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
		$data['start']['cols'][] = array('id' => 'year','label' => _('Año'),'type' => 'string');
		$this->load->database();
		/*Armamos arreglo de periodos y extraemos el nombre de la revista*/
		$query = "SELECT anio, revista FROM \"mvIndiceCoautoriaRevista\" WHERE \"revistaSlug\"='{$_POST['revista']}' AND anio>='{$_POST['periodo']}' ORDER BY anio DESC LIMIT 1";
		$query = $this->db->query($query);
		$anioRevista = $query->row_array();
		$data['start']['cols'][] = array('id' => 'coautoria','label' => $anioRevista['revista'],'type' => 'number');
		/*Consulta de los indices de coautoria a partir del año inicial del periodo*/
		$query = "SELECT anio, coautoria FROM \"mvIndiceCoautoriaRevista\" WHERE \"revistaSlug\"='{$_POST['revista']}' AND anio>='{$_POST['periodo']}'";
		$query = $this->db->query($query);

		$indicadores = array();
		foreach ($query->result_array() as $row ):
			$indicadores[$row['anio']] = round($row['coautoria'], 2);
		endforeach;

		for($anio = $_POST['periodo']; $anio <= $anioRevista['anio']; $anio++):
			$start = array();
			$start[] = array(
					'v' => $anio
				);
			$start[] = array(
					'v' => 0
				);
			$data['start']['rows'][]['c'] = $start;

			$end = array();
			$end[] = array(
					'v' => $anio
				);
			$end[] = array(
					'v' => $indicadores[$anio]
				);
			$data['end']['rows'][]['c'] = $end;
		endfor;

		$data['end']['cols'] = $data['start']['cols'];
		echo json_encode($data, true);
	}

	public function getRevistas($idDisciplina){
		$this->output->enable_profiler(false);
		$data = array();
		/*Revistas en disciplina*/
		$this->load->database();
		$query = "SELECT revista, \"revistaSlug\" FROM \"mvDisciplinaRevistas\" WHERE id_disciplina='{$idDisciplina}'";
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

	public function getPeriodos($indicador, $revista){
		$this->output->enable_profiler(false);
		$data = array();
		$this->load->database();
		$query = "";
		/*Periodos por revista*/
		switch ($indicador):
			case 'indice-coautoria':
					$query = "SELECT anio FROM \"mvIndiceCoautoriaRevista\" WHERE \"revistaSlug\"='{$revista}'";
				break;
			
			default:
				break;
		endswitch;
		$query = $this->db->query($query);
		$data['periodos'] = $query->result_array();
		$this->db->close();

		$periodo=0;
		$continuos=1;
		while ( $periodo < count($data['periodos']) && $continuos < 5):
			if(($data['periodos'][$periodo + 1]['anio']) == ($data['periodos'][$periodo]['anio'] + 1)):
				$continuos++;
			else:
				$continuos=1;
			endif;
			$periodo++;
		endwhile;

		if($continuos < 5):
			$data['result'] = false;
			$data['error'] = _('No hay información suficiente para generar el indicador');
		else:
			$data['result'] = true;
		endif;
		
		print_r(json_encode($data, true));
	}

}
/* End of file indicadores.php */
/* Location: ./application/controllers/indicadores.php */