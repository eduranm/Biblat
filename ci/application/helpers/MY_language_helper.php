<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 function lang_i18n_code(){
  $CI =& get_instance();
  $lang = $CI->lang->lang_array();
  return $lang['i18n'];
 }

 function lang_iso_code(){
  $CI =& get_instance();
  $lang = $CI->lang->lang_array();
  return $lang['iso'];
 }

/* End of file MY_language_helper.php */
/* Location: ./application/helpers/MY_language_helper */