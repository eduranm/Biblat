<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setlang extends CI_Controller{

	public function index($lang){
		$langList['es'] = 'es_ES';
		$langList['en'] = 'en_US';
		$langList['pt'] = 'pt_BR';
		$langList['fr'] = 'fr_FR';
		$cookie = array(
			'name'   => 'lang',
			'value'  => $langList[$lang],
			'expire' => time()+86500,
			'domain' => $_SERVER['SERVER_NAME'],
			'path'   => '/',
			'prefix' => '',
			'secure' => FALSE
		);

		set_cookie($cookie);

		if(!isset($_POST['ajax'])):
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		endif;
	}
}