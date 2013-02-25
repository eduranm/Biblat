<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('slug')):
	function slug($name,$utf=false){

		$sname = trim($name); //remover espacios vacios

		$sname = strtolower(preg_replace('/\s+/','-',$sname)); // pasamos todo a minusculas y cambiamos todos los espacios por -

		if($utf){ // si el texto no viene en formato utf8 se le manda a codificar como tal.
			$sname = utf8_decode($sname);
		}
		// Lista de caracteres latinos y sus correspondientes para slug
		$table = array(
			'á'=>'a', 'à'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ā'=>'a', 'ă'=>'a', 'ą'=>'a', 'Á'=>'a', 'Â'=>'a', 'Ã'=>'a', 'Ä'=>'a', 'Å'=>'a', 'Ā'=>'a', 'Ă'=>'a', 'Ą'=>'a', 'è'=>'e', 'é'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ē'=>'e', 'ĕ'=>'e', 'ė'=>'e', 'ę'=>'e', 'ě'=>'e', 'Ē'=>'e', 'Ĕ'=>'e', 'Ė'=>'e', 'Ę'=>'e', 'Ě'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ì'=>'i', 'ĩ'=>'i', 'ī'=>'i', 'ĭ'=>'i', 'Ì'=>'i', 'Í'=>'i', 'Î'=>'i', 'Ï'=>'i', 'Ì'=>'i', 'Ĩ'=>'i', 'Ī'=>'i', 'Ĭ'=>'i', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ō'=>'o', 'ŏ'=>'o', 'ő'=>'o', 'Ò'=>'o', 'Ó'=>'o', 'Ô'=>'o', 'Õ'=>'o', 'Ö'=>'o', 'Ō'=>'o', 'Ŏ'=>'o', 'Ő'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ũ'=>'u', 'ū'=>'u', 'ŭ'=>'u', 'ů'=>'u', 'Ù'=>'u', 'Ú'=>'u', 'Û'=>'u', 'Ü'=>'u', 'Ũ'=>'u', 'Ū'=>'u', 'Ŭ'=>'u', 'Ů'=>'u', 'ç'=>'c', 'Ç'=>'c', 'ÿ'=>'y', '&'=>'-', ','=>'-', '.'=>'-', 'ñ'=>'n', 'Ñ'=>'n', 'Š'=>'s', 'š'=>'s', 'Ž'=>'z', 'ž'=>'z', 'Ý'=>'y', 'Þ'=>'b', 'ß'=>'s', 'ø'=>'o', 'ý'=>'y', 'þ'=>'b'
		);

		$sname = strtr($sname, $table); // remplazamos los acentos, etc, por su correspondientes
		$sname = preg_replace("/[^A-Za-z0-9-]+/", "", $sname); // eliminamos cualquier caracter que no sea de la a-z o 0 al 9 o -

		return $sname;
	}
endif;

if ( ! function_exists('slugClean')):
	function slugClean($string){
		$rstring = trim($string);
		$rstring = preg_replace('/-/',' ',$rstring);
		return $rstring;
	}
endif;