<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$language = $this->config->item('language');
		if($this->session->userdata('language')):
			$language = $this->session->userdata('language');
		endif;
		$this->lang->load('main', $language);
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}
	public function index(){
		echo site_url('main');
		$data = array();
		$data['header']['title'] = "Biblat";
		/*Sessiones*/
		$sessiondata["registros"]="";
		$sessiondata["bd"]="";
		$sessiondata["iddisciplina"]="";
		$this->session->set_userdata($sessiondata);
		/*Consultas*/
		$this->load->database();
		/*Disciplinas*/
		$query = "SELECT * FROM disciplinas WHERE id_disciplina <> '23' ORDER BY disciplina";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row):
			$data['index']['disciplinas'][] = $row;
		endforeach;
		$query->free_result();
		/*Ontención de totales*/
		$query = "SELECT count(*) AS documentos FROM articulo";
		$query = $this->db->query($query);
		$data['index']['totales'] = $query->row_array();
		$query->free_result();
		$query = "SELECT count(*) AS revistas FROM rev_disciplinas";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		$query = "SELECT count(*) AS enlaces FROM articulo WHERE e_856u <> ''";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		$query = "SELECT count(*) AS hevila FROM articulo WHERE e_856u LIKE '%hevila%'";
		$query = $this->db->query($query);
		$data['index']['totales'] = array_merge($data['index']['totales'], $query->row_array());
		$query->free_result();
		$this->db->close();
		/*Vistas*/
		$this->load->view('main_header', $data['header']);
		$this->load->view('main_index', $data['index']);
		$this->load->view('main_footer');
	}
}