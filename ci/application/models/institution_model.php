<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Institution_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all($limit, $offset){
		$this->db->select('*');
		$this->db->from('mvInstitucion');
		$this->db->order_by('e_100u');
		if($limit):
			$this->db->limit($limit, $offset);
		endif;
		
		$query = $this->db->get();
		
		return $query;
	}

	public function find($slug, $country, $limit, $offset){
		$slug = preg_replace("/%+/", "%", $slug);
		$this->db->select('e_100u, e_100w, e_100x, registros');
		$this->db->from('mvInstitucion');
		$this->db->where('slug ~~', $slug);
		$this->db->order_by('registros DESC, e_100u');
		if($country && $country != "-"):
			$this->db->where('slugPais', $country);
		endif;
		if($limit):
			$this->db->limit($limit, $offset);
		endif;

		$query = $this->db->get();
		
		return $query;
	}

	public function countrys(){
		$this->db->select('slugPais');
		$this->db->select_max('e_100x');
		$this->db->from('mvInstitucion');
		$this->db->order_by('slugPais');
		$this->db->group_by('slugPais');
		$this->db->where('e_100x IS NOT NULL');
		$query = $this->db->get();
		
		return $query;
	}

}

/* End of file institution_model.php */
/* Location: ./application/models/institution_model.php */