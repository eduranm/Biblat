<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicadores extends CI_Controller {

	public $indicadores = array();

	public function __construct()
	{
		parent::__construct();
		/*Variables globles*/
		$data = array();
		/*Lista de indicadores*/
		$data['indicadores'] = array(
								'indice-coautoria' => _('Índice de coautoría'),
								'tasa-documentos-coautorados' => _('Tasa de documentos coautorados'),
								'grado-colaboracion' => _('Grado de colaboración (Índice Subramayan)'),
								'modelo-elitismo' => _('Modelo de elitismo (Price)'),
								'indice-colaboracion' => _('Índice de colaboración (Índice de Lawani)'),
								'indice-densidad-documentos' => _('Índice de densidad de documentos Zakutina y Priyenikova'),
								'indice-concentracion' => _('Índice de concentración (Índice Pratt)'),
								'modelo-bradford-revista' => _('Modelo de Bradford por revista'),
								'modelo-bradford-institucion' => _('Modelo de Bradford por institución (Afiliación del autor)'),
								'productividad-exogena' => _('Productividad exógena') 
							);
		$this->indicadores = $data['indicadores'];
		/*Disciplinas*/
		$this->load->database();
		$query = "SELECT id_disciplina, disciplina FROM \"mvDisciplina\"";
		$query = $this->db->query($query);
		$data['disciplinas'] = $query->result_array();
		$this->db->close();

		$this->load->vars($data);

		set_translation_language(get_cookie('lang'));
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}

	public function index($indicador="")
	{
		$data = array();
		$data['main']['indicador'] = $indicador;

		/*Vistas*/
		$data['header']['content'] =  $this->load->view('indicadores_header', $data['header'], TRUE);
		$data['header']['title'] = _sprintf('Biblat - Indicador: %s', $this->indicadores[$data['main']['indicador']]);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('indicadores_indiceCoautoria', $data['main']);
		$this->load->view('footer');
	}

	public function getChartData(){
		$this->output->enable_profiler(false);

		$data['data']['cols'][] = array('id' => 'year','label' => _('Año'),'type' => 'string');
		$this->load->database();
		/*Generamos el arreglo de periodos*/
		$periodos = $this->getPeriodos($_POST);
		/*Consulta para cada indicador*/
		$indicadorQuery['indice-coautoria']['revista']="SELECT revista AS title, anio, coautoria AS valor FROM \"mvIndiceCoautoriaRevista\" WHERE \"revistaSlug\" IN (";
		$indicadorQuery['indice-coautoria']['pais']="SELECT \"paisAutor\" AS title, anio, coautoria AS valor FROM \"mvIndiceCoautoriaPais\" WHERE \"paisAutorSlug\" IN (";
		$indicadorQuery['tasa-documentos-coautorados']['revista']="SELECT revista AS title, anio, \"tasaCoautoria\" AS valor FROM \"mvTasaCoautoriaRevista\" WHERE \"revistaSlug\" IN (";
		$indicadorQuery['tasa-documentos-coautorados']['pais']="SELECT \"paisAutor\" AS title, anio, \"tasaCoautoria\" AS valor FROM \"mvTasaCoautoriaPais\" WHERE \"paisAutorSlug\" IN (";
		$indicadorQuery['grado-colaboracion']="";
		$indicadorQuery['modelo-elitismo']="";
		$indicadorQuery['indice-colaboracion']="";
		$indicadorQuery['indice-densidad-documentos']="";
		$indicadorQuery['indice-concentracion']="";
		$indicadorQuery['modelo-bradford-revista']="";
		$indicadorQuery['modelo-bradford-institucion']="";
		$indicadorQuery['productividad-exogena']="";
		if (isset($_POST['revista'])):
			$query = $indicadorQuery[$_POST['indicador']]['revista'];
			$revistaOffset=1;
			$revistaTotal= count($_POST['revista']);
			foreach ($_POST['revista'] as $revista):
				$query .= "'{$revista}'";
				if($revistaOffset < $revistaTotal):
					$query .=",";
				endif;
				$revistaOffset++;
			endforeach;
			$query .=") AND anio>='{$_POST['periodo']}'";
		else:
			$query = $indicadorQuery[$_POST['indicador']]['pais'];
			$paisOffset=1;
			$paisTotal= count($_POST['pais']);
			foreach ($_POST['pais'] as $pais):
				$query .= "'{$pais}'";
				if($paisOffset < $paisTotal):
					$query .=",";
				endif;
				$paisOffset++;
			endforeach;
			$query .=") AND anio>='{$_POST['periodo']}' AND id_disciplina='{$_POST['disciplina']}'";
		endif;

		$query = $this->db->query($query);
		$indicadores = array();
		foreach ($query->result_array() as $row ):
			$indicadores[$row['title']][$row['anio']] = round($row['valor'], 2);
		endforeach;
		/*Generando columnas*/
		foreach ($indicadores as $kindicador => $vindicador):
			$data['data']['cols'][] = array('id' => slug($kindicador),'label' => $kindicador, 'type' => 'number');
			$data['data']['cols'][] = array('id' => slug($kindicador)."-tooltip",'label' => $kindicador, 'type' => 'string', 'p' => array('role' => 'tooltip', 'html' => true));
		endforeach;
		foreach ($periodos as $periodo):
			$c = array();
			$c[] = array(
					'v' => $periodo
				);
			foreach ($indicadores as $kindicador => $vindicador):
				$c[] = array(
					'v' => $vindicador[$periodo]
				);
				$c[] = array(
					'v' => _sprintf('<div class="centrado"><b>%s</b></div><div class="centrado">Año %d: %s</div>', $kindicador, $periodo, $vindicador[$periodo])
				);
			endforeach;
			$data['data']['rows'][]['c'] = $c;
		endforeach;

		/*Opciones de la gráfica*/
		$data['options'] = array(
						'animation' => array(
								'duration' => 1000
							), 
						'hAxis' => array(
								'title' => _('Periodo')
							), 
						'legend' => array(
								'position' => 'right'
							),
						'pointSize' => 3,
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => $this->indicadores[$_POST['indicador']],
								'minValue' => 0
							)
						);
		echo json_encode($data, true);
	}

	public function getRevistasPaises(){
		$this->output->enable_profiler(false);
		$data = array();

		/*Revistas en disciplina*/
		$this->load->database();
		$query = "SELECT revista, \"revistaSlug\" FROM \"mvDisciplinaRevistasContinuos\" WHERE id_disciplina='{$_POST['disciplina']}'";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$revista = array(
					'val' => $row['revistaSlug'],
					'text' => htmlspecialchars($row['revista'])
				);
			$data['revistas'][] = $revista;
		endforeach;
		$query = "SELECT \"paisAutor\", \"paisAutorSlug\" FROM \"mvDisciplinaPaisesContinuos\" WHERE id_disciplina='{$_POST['disciplina']}'";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$revista = array(
					'val' => $row['paisAutorSlug'],
					'text' => htmlspecialchars($row['paisAutor'])
				);
			$data['paises'][] = $revista;
		endforeach;
		$this->db->close();

		echo json_encode($data, true);
	}

	public function getPeriodos($request=null){
		$this->output->enable_profiler(false);
		if($request != null):
			$_POST=$request;
		endif;
		
		$data = array();
		$this->load->database();
		$query = "";
		/*Periodos por revista*/
		switch ($_POST['indicador']):
			case 'indice-coautoria':
				if (isset($_POST['revista'])):
					$query = "SELECT min(anio) AS \"anioBase\", max(anio) AS \"anioFinal\" FROM \"mvIndiceCoautoriaRevista\" WHERE \"revistaSlug\" IN (";
					$revistaOffset=1;
					$revistaTotal= count($_POST['revista']);
					foreach ($_POST['revista'] as $revista):
						$query .= "'{$revista}'";
						if($revistaOffset < $revistaTotal):
							$query .=",";
						endif;
						$revistaOffset++;
					endforeach;
					$query .= ")";
				elseif (isset($_POST['pais'])):
					$query = "SELECT min(anio) AS \"anioBase\", max(anio) AS \"anioFinal\" FROM \"mvIndiceCoautoriaPais\" WHERE \"paisAutorSlug\" IN (";
					$paisOffset=1;
					$paisTotal= count($_POST['pais']);
					foreach ($_POST['pais'] as $pais):
						$query .= "'{$pais}'";
						if($paisOffset < $paisTotal):
							$query .=",";
						endif;
						$paisOffset++;
					endforeach;
					$query .= ")";
				endif;
				break;
			case 'tasa-documentos-coautorados':
				if (isset($_POST['revista'])):
					$query = "SELECT min(anio) AS \"anioBase\", max(anio) AS \"anioFinal\" FROM \"mvTasaCoautoriaRevista\" WHERE \"revistaSlug\" IN (";
					$revistaOffset=1;
					$revistaTotal= count($_POST['revista']);
					foreach ($_POST['revista'] as $revista):
						$query .= "'{$revista}'";
						if($revistaOffset < $revistaTotal):
							$query .=",";
						endif;
						$revistaOffset++;
					endforeach;
					$query .= ")";
				elseif (isset($_POST['pais'])):
					$query = "SELECT min(anio) AS \"anioBase\", max(anio) AS \"anioFinal\" FROM \"mvTasaCoautoriaPais\" WHERE \"paisAutorSlug\" IN (";
					$paisOffset=1;
					$paisTotal= count($_POST['pais']);
					foreach ($_POST['pais'] as $pais):
						$query .= "'{$pais}'";
						if($paisOffset < $paisTotal):
							$query .=",";
						endif;
						$paisOffset++;
					endforeach;
					$query .= ")";
				endif;
				break;
			default:
				break;
		endswitch;

		$query = $this->db->query($query);
		$rango = $query->row_array();
		$this->db->close();
		$anioBase = $rango['anioBase'];
		if(isset($_POST['periodo'])):
			$anioBase = $_POST['periodo'];
		endif;
		$anioFinal = $rango['anioFinal'];	

		$data['result'] = true;
		$data['periodos'] = range($anioBase, $anioFinal);
		$data['base'] = $anioBase;

		if($request != null):
			return $data['periodos'];
		else:
			echo json_encode($data, true);
		endif;
	}

}
/* End of file indicadores.php */
/* Location: ./application/controllers/indicadores.php */