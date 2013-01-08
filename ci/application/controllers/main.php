<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$language = $this->config->item('language');
		if($this->session->userdata('language')):
			$language = $this->session->userdata('language');
		endif;
		$this->lang->load('main', $language);
		$this->output->enable_profiler(TRUE);
	}
	public function index(){
		$this->session->set_userdata('language', 'spanish');
		$this->load->view('main_header');
		$this->load->view('main_index');
		$this->load->view('main_footer');
	}
}