<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class Cleanhtml {
	/**
	* Responsible for sending final output to browser
	*/
	function output()
	{
		$CI =& get_instance();
		$buffer = $CI->output->get_output();
		/*Remove debug console log in production*/
		if(ENVIRONMENT === "production"):
			$buffer = preg_replace('/console.log(.+?);/', "", $buffer);
		endif;
		
		$CI->output->set_output($buffer);
		$CI->output->_display();
	}
}
?>