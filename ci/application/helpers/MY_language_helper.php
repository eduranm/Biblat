<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('supported_langs') ):
	function supported_langs(){
		$CI =& get_instance();
		return $CI->lang->supported_langs();
	}
endif;

if ( ! function_exists('lang_i18n_code') ):
	function lang_i18n_code(){
		$CI =& get_instance();
		$lang = $CI->lang->lang_array();
		return $lang['i18n'];
	}
endif;

if ( ! function_exists('lang_iso_code') ):
	function lang_iso_code(){
		$CI =& get_instance();
		$lang = $CI->lang->lang_array();
		return $lang['iso'];
	}
endif;

if ( ! function_exists('get_browser_lang') ):
	function get_browser_lang(){
		$CI =& get_instance();
		$langs = $CI->lang->supported_langs();
		$browserLang = 'en';
		if ( isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) && strlen($_SERVER["HTTP_ACCEPT_LANGUAGE"]) > 1):
			$http_accept = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
			# Split possible languages into array
			$x = explode(",",$http_accept);
			foreach ($x as $val):
			#check for q-value and create associative array. No q-value means 1 by rule
				if(preg_match("/(.*);q=([0-1]{0,1}\.\d{0,4})/i",$val,$matches)):
					$lang[$matches[1]] = (float)$matches[2];
				else:
					$lang[$val] = 1.0;
				endif;
			endforeach;

			#return default language (highest q-value)
			$qval = 0.0;
			foreach ($lang as $key => $value):
				if ($value > $qval):
					$qval = (float)$value;
					$browserLang = $key;
				endif;
			endforeach;
			$browserLang = substr($browserLang, 0, 2);
		endif;
		if (! isset($langs[$browserLang])):
			$browserLang = 'en';
		endif;

		return $browserLang;
	}
endif;

if ( ! function_exists('browser_lang_array') ):
	function browser_lang_array(){
		$CI =& get_instance();
		$langs = $CI->lang->supported_langs();
		return $langs[get_browser_lang()];
	}
endif;

if ( ! function_exists('lang_notification') ):
	function lang_notification(){
		$show = FALSE;
		if (get_browser_lang() != lang_iso_code()):
			$show = TRUE;
		endif;
		return $show;
	}
endif;

if ( ! function_exists('default_lang') ):
	function default_lang(){
		$CI =& get_instance();
		return $CI->lang->lang();
	}
endif;

/* End of file MY_language_helper.php */
/* Location: ./application/helpers/MY_language_helper */