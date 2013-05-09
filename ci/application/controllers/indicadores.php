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
		/*Vistas para cada indicador*/
		$indicadorVista = array(
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
		/*Periodos por revista*/
		$this->db->close();
		print_r(json_encode($data['revistas'], true));
	}

}
/* End of file indicadores.php */
/* Location: ./application/controllers/indicadores.php */