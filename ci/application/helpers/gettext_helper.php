<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*gettext helper function to lang*/
if (! function_exists('_e')):
	function _e($str){
		echo _($str);
	}
endif;

if (! function_exists('_sprintf')):
	function _sprintf(){
		$args = func_get_args();
		$args[0] = _($args[0]);
		return call_user_func_array('sprintf', $args);
	}
endif;

if (! function_exists('_printf')):
	function _printf(){
		$args = func_get_args();
		$args[0] = _($args[0]);
		return call_user_func_array('printf', $args);
	}
endif;