<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}
	public function index(){
		$data = array();
		$data['header']['title'] = _("Biblat");
		$data['header']['description'] = _('Biblat ofrece: referencias bibliográficas de documentos publicados en revistas científicas y académicas latinoamericanas indizadas en CLASE y PERIÓDICA, acceso al texto completo de revistas en acceso abierto, indicadores bibliométricos e información sobre los políticas de acceso de las revistas.');
		/*Consultas*/
		$this->load->database();
		/*Max disciplina*/
		$query = "SELECT total FROM \"mvDisciplina\" WHERE id_disciplina <> '23' ORDER BY total DESC LIMIT 1";
		$query = $this->db->query($query);
		$data['index']['maxDisciplina'] = $query->row_array();
		$data['index']['maxDisciplina'] = $data['index']['maxDisciplina']['total'];
		$query->free_result();
		/*Disciplinas*/
		$query = "SELECT * FROM \"mvDisciplina\" WHERE id_disciplina <> '23'";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row):
			$row['size'] = round(($row['total']/ $data['index']['maxDisciplina']) * 20);
			$data['index']['disciplinas'][] = $row;
		endforeach;
		$query->free_result();
		/*Obtención de totales*/
		$query = "SELECT count(*) AS documentos FROM \"mvSearch\"";
		$query = $this->db->query($query);
		$data['index']['totales'] = $query->row_array();
		$query->free_result();
		$query = "SELECT count(DISTINCT revista) AS revistas FROM \"mvRevistaDisciplina\"";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		$query = "SELECT count(*) AS enlaces FROM \"mvSearch\" WHERE url IS NOT NULL";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		$query = "SELECT count(*) AS hevila FROM \"mvSearch\" WHERE url ~~ '%hevila%'";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		/*Obteniendo lista de paises*/
		if(! $this->session->userdata('paises')){
			$query = "SELECT * FROM \"mvPais\" WHERE \"paisSlug\" <> 'internacional'";
			$query = $this->db->query($query);
			$paises = $query->result_array();
			$query->free_result();
			$this->db->close();
			$this->session->set_userdata('paises', json_encode($paises));
		}
		$data['index']['paises'] = json_decode($this->session->userdata('paises'), TRUE);
		/*Vistas*/
		$data['header']['disciplinas'] = $data['index']['disciplinas'];
		$data['header']['content'] =  $this->load->view('main/header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('main/index', $data['index']);
		$this->load->view('footer');
	}

	public function creditos(){
		$data = array();
		$data['header']['title'] = _("Biblat - Créditos");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/creditos');
		$this->load->view('footer');
	}

	public function bibliografia(){
		$data = array();
		$data['header']['title'] = _("Biblat - Bibliografía");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/bibliografia');
		$this->load->view('footer');
	}

	public function sobreBiblat(){
		$data = array();
		$data['header']['title'] = _("Biblat - Sobre Biblat");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/info_biblat');
		$this->load->view('footer');
		$this->load->helper('url');
	}

	public function clasePeriodica(){
		$data = array();
		$data['header']['title'] = _("Biblat - CLASE y PERIÓDICA");
		$this->load->database();
		$query = "SELECT * FROM \"vDisciplinasBase\" ORDER BY iddatabase, disciplina";
		$query = $this->db->query($query);
		$data[ 'disciplina' ] = array();
		foreach ($query->result_array() as $row):
				$disciplina = array();
				$disciplina['disciplina'] = $row['disciplina'];
				$disciplina['slug'] = $row['slug'];
   				$data[ 'disciplina' ][ $row[ 'iddatabase' ] ][] = $disciplina;	
		endforeach;
		$this->db->close();
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/info_clase_periodica', $data);
		$this->load->view('footer');
	}

	public function scielo(){
		$data = array();
		$data['header']['title'] = _("Biblat - Sobre SciELO");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/info_scielo');
		$this->load->view('footer');
	}

	public function materialesDifusion(){
		$data = array();
		$data['header']['title'] = _("Biblat - Materiales de difusión");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/materiales_difusion');
		$this->load->view('footer');
	}

	public function descripcionBiblat(){
		$data = array();
		$data['header']['title'] = _("Biblat - Descripción");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/descripcion_biblat');
		$this->load->view('footer');
	}

	public function metodologiaBiblat(){
		$data = array();
		$data['header']['title'] = _("Biblat - Metodología");
		$data['header']['content'] = $this->load->view('header_metodologia', $data['header'],TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/metodologia_biblat');
		$this->load->view('footer');
	}

	public function indicadoresScielo(){
		$data = array();
		$data['header']['title'] = _("Biblat - Indicadores por revista");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/indicadores_scielo');
		$this->load->view('footer');
	}

	public function indicadoresRevista(){
		$data = array();
		$data['header']['title'] = _("Biblat - Indicadores por revista");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/indicadores_por_revista');
		$this->load->view('footer');
	}

	public function criteriosSeleccion(){
		$data = array();
		$data['header']['title'] = _("Biblat - Criterios de selección");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/criterios_seleccion');
		$this->load->view('footer');
	}

	public function sitemap(){
		$data = array();
		$data['header']['title'] = _("Biblat - Mapa del sitio");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/sitemap');
		$this->load->view('footer');
	}

	public function contacto(){
		$this->load->library('recaptcha');
		$data['main']['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('main/contacto',$data['main']);
		$this->load->view('footer');
	}

	public function contactoSubmit(){
		$this->load->library('recaptcha');
		$this->recaptcha->recaptcha_check_answer();
		var_dump($this->recaptcha->getIsValid());
	}

	public function lang_notification(){
		$browserLang = browser_lang_array();
		$data['message'] = _sprintf('Deacuerdo al idioma de su navegador le sugerimos cambiar el idioma de la página a %s', $browserLang['title']);
		$data['button'] = '<button class="translate">'._('Traducir').'</button>';
		echo json_encode($data, TRUE); exit(0);
	}
}
