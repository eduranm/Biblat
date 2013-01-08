<?php

if ( ! function_exists('langf')){
	function langf(){
		$args = func_get_args();
		$args[0] = lang($args[0]);
		return call_user_func_array('sprintf', $args);
	}
}