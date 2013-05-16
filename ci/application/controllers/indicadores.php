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

	public function index()
	{
		
	}

	public function indiceCoautoria(){
		$data = array();
		$data['main']['indicador'] = "indice-coautoria";

		/*Vistas*/
		$data['header']['content'] =  $this->load->view('indicadores_header', $data['header'], TRUE);
		$data['header']['title'] = _sprintf('Biblat - Indicador: %s', $this->indicadores[$data['main']['indicador']]);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('indicadores_indiceCoautoria', $data['main']);
		$this->load->view('footer');
	}

	public function indiceCoautoriaChart(){
		$this->output->enable_profiler(false);
		array_shift($_POST['revista']);
		$data['cols'][] = array('id' => 'year','label' => _('Año'),'type' => 'string');
		$this->load->database();
		/*Generamos el arreglo de periodos*/
		$periodos = $this->getPeriodos($_POST);
		/*Consulta de los indices de coautoria a partir del año inicial del periodo*/
		$query = "SELECT revista, anio, coautoria FROM \"mvIndiceCoautoriaRevista\" WHERE \"revistaSlug\" IN (";
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

		$query = $this->db->query($query);
		$indicadores = array();
		foreach ($query->result_array() as $row ):
			$indicadores[$row['revista']][$row['anio']] = round($row['coautoria'], 2);
		endforeach;
		/*Generando columnas*/
		foreach ($indicadores as $kindicador => $vindicador):
			$data['cols'][] = array('id' => slug($kindicador),'label' => $kindicador, 'type' => 'number');
		endforeach;
		foreach ($periodos as $periodo):
			$c = array();
			$c[] = array(
					'v' => $periodo
				);
			foreach ($indicadores as $indicador):
				$c[] = array(
					'v' => $indicador[$periodo]
				);
			endforeach;
			$data['rows'][]['c'] = $c;
		endforeach;
		echo json_encode($data, true);
	}

	public function getRevistas($idDisciplina){
		$this->output->enable_profiler(false);
		$data = array();
		/*Revistas en disciplina*/
		$this->load->database();
		$query = "SELECT revista, \"revistaSlug\" FROM \"mvDisciplinaRevistasContinuos\" WHERE id_disciplina='{$idDisciplina}'";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$revista = array(
					'val' => $row['revistaSlug'],
					'text' => $row['revista']
				);
			$data['revistas'][] = $revista;
		endforeach;
		$this->db->close();

		print_r(json_encode($data['revistas'], true));
	}

	public function getPeriodos($request=null){
		$this->output->enable_profiler(false);
		if($request != null):
			$_POST=$request;
		else:
			array_shift($_POST['revista']);
		endif;

		$data = array();
		$this->load->database();
		$query = "";
		/*Periodos por revista*/
		switch ($_POST['indicador']):
			case 'indice-coautoria':
						$query = "SELECT max(anio) as anio FROM \"mvIndiceCoautoriaRevista\" WHERE \"revistaSlug\" IN (";
						$revistaOffset=1;
						$revistaTotal= count($_POST['revista']);
						foreach ($_POST['revista'] as $revista):
							$query .= "'{$revista}'";
							if($revistaOffset < $revistaTotal):
								$query .=",";
							endif;
							$revistaOffset++;
						endforeach;
						$query .= ") GROUP BY anio ORDER BY anio";
				break;
			
			default:
				break;
		endswitch;

		$query = $this->db->query($query);
		$rango = $query->result_array();
		$this->db->close();

		$periodo=0;
		$continuos=1;
		$anioBase=0;
		while ( $periodo < count($rango) && $continuos < 5):
			if(($rango[$periodo + 1]['anio']) == ($rango[$periodo]['anio'] + 1)):
				$continuos++;
			else:
				$continuos=1;
			endif;
			$periodo++;
			$anioBase=$rango[($periodo + 1) - $continuos];
		endwhile;
		if(isset($_POST['periodo'])):
			$anioBase['anio']=$_POST['periodo'];
		endif;
		$anioFinal = end($rango);	

		if($continuos < 5):
			$data['result'] = false;
			$data['error'] = _('No hay información suficiente para generar el indicador');
		else:
			$data['result'] = true;
			$data['periodos'] = range($anioBase['anio'], $anioFinal['anio']);
			$data['base'] = $anioBase['anio'];
		endif;
		if($request != null):
			return $data['periodos'];
		else:
			print_r(json_encode($data, true));
		endif;
	}

}
/* End of file indicadores.php */
/* Location: ./application/controllers/indicadores.php */