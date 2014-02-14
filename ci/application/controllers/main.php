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
		$query = "SELECT count(*) AS revistas FROM rev_disciplinas";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		$query = "SELECT count(*) AS enlaces FROM \"mvSearch\" WHERE url IS NOT NULL";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		$query = "SELECT count(*) AS hevila FROM \"mvSearch\" WHERE url ~ '%hevila%'";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		/*Obteniendo lista de paises*/
		$query = "SELECT * FROM \"mvPais\" WHERE \"paisSlug\" <> 'internacional'";
		$query = $this->db->query($query);
		$data['index']['paises'] = $query->result_array();
		$query->free_result();
		$this->db->close();
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
