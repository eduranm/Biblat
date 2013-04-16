<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Indice extends CI_Controller{
	public function __construct(){
		parent::__construct();
		set_translation_language(get_cookie('lang'));
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}
	public function index(){

	}

	public function alfabetico($letra){
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Indice alfabético "%s"', $letra);
		/*Consultas*/
		$this->load->database();
		$query = "SELECT revista, \"revistaSlug\", count(revista) AS articulos FROM \"mvSearch\" WHERE SUBSTRING(LOWER(revista), 1, 1)='{$letra}' GROUP BY revista, \"revistaSlug\" ORDER BY revista;";
		$query = $this->db->query($query);
		$data['alfabetico']['registrosTotalArticulos'] = 0;
		foreach ($query->result_array() as $row):
			if($row['revista'] == ""):
				$row['revista'] = "[Título no definido]";
			endif;
			$data['alfabetico']['registros'][] = $row;
			$data['alfabetico']['registrosTotalArticulos'] += $row['articulos'];
		endforeach;
		$query->free_result();
		$this->db->close();
		/*Vistas*/
		$data['header']['content'] =  $this->load->view('indiceAlfabeticoHeader', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('indice_alfabetico', $data['alfabetico']);
		$this->load->view('footer');
	}

	public function disciplina($disciplina){
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Indice por disciplina "%s"', $disciplina);
		/*Consultas*/
		$this->load->database();
		/*Obteniendo registro de disciplina a partir del slug*/
		$query = "SELECT * FROM disciplinas WHERE slug='$disciplina' LIMIT 1";
		$query = $this->db->query($query);
		$data['disciplina']['registroDisciplina'] = $query->row_array();
		$query->free_result();
		/*Obteniendo registros*/
		$query = "SELECT revista, \"revistaSlug\", count(revista) AS articulos FROM \"mvSearch\" WHERE id_disciplina = '{$data['disciplina']['registroDisciplina']['id_disciplina']}' GROUP BY revista, \"revistaSlug\"	 ORDER BY articulos DESC";
		$query = $this->db->query($query);
		$data['disciplina']['registrosTotalArticulos'] = 0;
		foreach ($query->result_array() as $row):
			if($row['revista'] == ""):
				$row['revista'] = "[Título no definido]";
			endif;
			$data['disciplina']['registros'][] = $row;
			$data['disciplina']['registrosTotalArticulos'] += $row['articulos'];
		endforeach;
		$this->db->close();
		/*Vistas*/
		$data['header']['content'] =  $this->load->view('indiceDisciplinaHeader', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('indice_disciplina', $data['disciplina']);
		$this->load->view('footer');
	}
}