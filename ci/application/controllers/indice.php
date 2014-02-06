<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Indice extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}
	public function index(){

	}

	public function alfabetico($letra){
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Indice alfabético "%s"', strtoupper($letra));
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
		$data['alfabetico']['letra'] = $letra;
		/*Vistas*/
		$data['header']['content'] =  $this->load->view('indice/alfabetico_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('indice/alfabetico', $data['alfabetico']);
		$this->load->view('footer');
	}

	public function disciplina($disciplina){
		$data = array();
		/*Consultas*/
		$this->load->database();
		/*Obteniendo lista de disciplinas*/
		$query = "SELECT * FROM \"mvDisciplina\"";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row):
			$data['disciplina']['disciplinas'][$row['slug']] = $row;
		endforeach;
		$query->free_result();
		$data['disciplina']['current'] = $data['disciplina']['disciplinas'][$disciplina];
		/*Obteniendo registros*/
		$query = "SELECT revista, \"revistaSlug\", count(revista) AS articulos FROM \"mvSearch\" WHERE id_disciplina = '{$data['disciplina']['current']['id_disciplina']}' GROUP BY revista, \"revistaSlug\" ORDER BY articulos DESC";
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
		$data['header']['title'] = _sprintf('Biblat - Indice por disciplina "%s"', $data['disciplina']['current']['disciplina']);
		$data['header']['content'] =  $this->load->view('indice/disciplina_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('indice/disciplina', $data['disciplina']);
		$this->load->view('footer');
	}

	public function pais($pais){
		$data = array();
		/*Consultas*/
		$this->load->database();
		/*Obteniendo lista de paises*/
		$query = "SELECT * FROM \"mvPais\"";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row):
			$data['pais']['paises'][$row['paisSlug']] = $row;
		endforeach;
		$query->free_result();
		$data['pais']['current'] = $data['pais']['paises'][$pais];
		/*Obteniendo registros*/
		$query = "SELECT revista, \"revistaSlug\", count(revista) AS articulos FROM \"mvSearch\" WHERE \"paisSlug\"='{$pais}' GROUP BY revista, \"revistaSlug\" ORDER BY articulos DESC";
		$query = $this->db->query($query);
		$data['pais']['registrosTotalArticulos'] = 0;
		foreach ($query->result_array() as $row):
			if($row['revista'] == ""):
				$row['revista'] = "[Título no definido]";
			endif;
			$data['pais']['registros'][] = $row;
			$data['pais']['registrosTotalArticulos'] += $row['articulos'];
		endforeach;
		$this->db->close();
		/*Vistas*/
		$data['header']['title'] = _sprintf('Biblat - Indice por país: "%s"', $data['pais']['paises'][$pais]['pais']);
		$data['header']['content'] =  $this->load->view('indiceDisciplinaHeader', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('indice/pais', $data['pais']);
		$this->load->view('footer');
	}
}