<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class indice extends CI_Controller{
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

	}
}