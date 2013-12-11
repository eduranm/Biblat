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
		$query = "SELECT count(*) AS documentos FROM articulo";
		$query = $this->db->query($query);
		$data['index']['totales'] = $query->row_array();
		$query->free_result();
		$query = "SELECT count(*) AS revistas FROM rev_disciplinas";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		$query = "SELECT count(*) AS enlaces FROM articulo WHERE e_856u IS NOT NULL";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		$query = "SELECT count(*) AS hevila FROM articulo WHERE e_856u LIKE '%hevila%'";
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
		$data['header']['content'] =  $this->load->view('main_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('main_index', $data['index']);
		$this->load->view('footer');
	}

	public function creditos(){
		$data = array();
		$data['header']['title'] = _("Biblat - Créditos");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main_creditos');
		$this->load->view('footer');
	}

	public function sitemap(){
		$data = array();
		$data['header']['title'] = _("Biblat - Mapa del sitio");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main_sitemap');
		$this->load->view('footer');
	}

	public function contacto(){
		$this->load->library('recaptcha');
		$data['main']['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('main_contacto',$data['main']);
		$this->load->view('footer');
	}

	public function contactoSubmit(){
		$this->load->library('recaptcha');
		$this->recaptcha->recaptcha_check_answer();
		var_dump($this->recaptcha->getIsValid());
	}
}
