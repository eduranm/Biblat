<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class Cleanhtml {
	/**
	* Responsible for sending final output to browser
	*/
	function output()
	{
		ini_set("pcre.recursion_limit", "16777");
		$CI =& get_instance();
		$buffer = $CI->output->get_output();
		/*Remove debug console log in production*/
		if(ENVIRONMENT === "production"):
			$buffer = preg_replace('/console.log\(.+?\);/', "", $buffer);
			$buffer = preg_replace('/<!--.+?-->/', "", $buffer);
			$re = '%(?>[^\S ]\s*|\s{2,})(?=[^<]*+(?:<(?!/?(?:textarea|pre|script)\b)[^<]*+)*+(?:<(?>textarea|pre|script)\b|\z))%Six';
			$new_buffer = preg_replace($re, " ", $buffer);
			if ($new_buffer === null)
				$new_buffer = $buffer;
			$CI->output->set_output($new_buffer);
		else:
			$CI->output->set_output($buffer);
		endif;
		$CI->output->_display();
	}
}
?>