<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Indice extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->output->enable_profiler($this->config->item('enable_profiler'));
		$this->template->set_partial('biblat_js', 'javascript/biblat', array(), TRUE);
		$this->template->set_partial('submenu', 'layouts/submenu');
		$this->template->set_partial('search', 'layouts/search');
		$this->template->set_breadcrumb(_('Inicio'), site_url('/'));
		$this->template->set_breadcrumb(_('Índice'));
		$this->template->set('class_method', $this->router->fetch_class().$this->router->fetch_method());
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
		$data['alfabetico']['page_title'] = sprintf('Revistas por orden alfabético: %s', strtoupper($letra));
		$this->template->title($data['header']['title']);
		$this->template->set_meta('description', $data['main']['page_title']);
		$this->template->set_breadcrumb(_('Alfabético'));
		$this->template->build('indice/alfabetico', $data['alfabetico']);
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
		$data['disciplina']['page_title'] = sprintf('Revistas del área de "%s"', $data['disciplina']['current']['disciplina']);
		$this->template->title($data['header']['title']);
		$this->template->set_meta('description', $data['main']['page_title']);
		$this->template->set_breadcrumb(_('Disciplina'));
		$this->template->build('indice/disciplina', $data['disciplina']);
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
		$data['pais']['page_title'] = sprintf('Revistas por país: "%s"', $data['pais']['current']['pais']);
		$this->template->title($data['header']['title']);
		$this->template->set_meta('description', $data['main']['page_title']);
		$this->template->set_breadcrumb(_('País'));
		$this->template->build('indice/pais', $data['pais']);
	}
}