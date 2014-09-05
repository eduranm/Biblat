<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class Institutions extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('institution_model');
	}

	public function index_get()
	{
		$limit = $this->get('limit') ? $this->get('limit') : 0;
		$offset = $this->get('offset') ? $this->get('offset') : 0;

		$institutions = $this->institution_model->get_all($limit, $offset);

		$institutions = array(
				'rows' => $institutions->num_rows(),
				'data' => $institutions->result_array()
			);

		$this->response($institutions['data'], 200);
	}

	public function index_post(){
		$this->response($_POST, 200);
	}

	public function find_get(){
		$slug = "%".str_replace('-', '%', $this->get('slug'))."%";
		if(preg_match('/^%(([a-z]%)+?)$/', $slug, $match)):
			$slug = preg_replace("/%([a-z])/", "% $1", $match[1]);
		endif;
		$country = $this->get('country') ? $this->get('country') : FALSE;
		$limit = $this->get('limit') ? $this->get('limit') : 0;
		$offset = $this->get('offset') ? $this->get('offset') : 0;
		$institutions = $this->institution_model->find($slug, $country, $limit, $offset);

		$institutions = array(
				'rows' => $institutions->num_rows(),
				'data' => $institutions->result_array()
			);
		$this->response($institutions['data'], 200);
	}

	public function country_get(){
		$countrys = $this->institution_model->countrys();

		$countrys = array(
				'rows' => $countrys->num_rows(),
				'data' => $countrys->result_array()
			);

		$this->response($countrys['data'], 200);
	}
}

/* End of file institution.php */
/* Location: ./application/controllers/api/institution.php */