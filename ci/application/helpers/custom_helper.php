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
		$sname = preg_replace("/-+/", "-", $sname);/*Eliminamos guiones dobles*/

		return $sname;
	}
endif;

if ( ! function_exists('slugSearch')):
	function slugSearch($name,$utf=false){

		$sname = trim($name); //remover espacios vacios

		$sname = strtolower(preg_replace('/\s+/','-',$sname)); // pasamos todo a minusculas y cambiamos todos los espacios por -

		if($utf){ // si el texto no viene en formato utf8 se le manda a codificar como tal.
			$sname = utf8_decode($sname);
		}
		// Lista de caracteres latinos y sus correspondientes para slug
		$table = array(
			'á'=>'a', 'à'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ā'=>'a', 'ă'=>'a', 'ą'=>'a', 'Á'=>'a', 'Â'=>'a', 'Ã'=>'a', 'Ä'=>'a', 'Å'=>'a', 'Ā'=>'a', 'Ă'=>'a', 'Ą'=>'a', 'è'=>'e', 'é'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ē'=>'e', 'ĕ'=>'e', 'ė'=>'e', 'ę'=>'e', 'ě'=>'e', 'Ē'=>'e', 'Ĕ'=>'e', 'Ė'=>'e', 'Ę'=>'e', 'Ě'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ì'=>'i', 'ĩ'=>'i', 'ī'=>'i', 'ĭ'=>'i', 'Ì'=>'i', 'Í'=>'i', 'Î'=>'i', 'Ï'=>'i', 'Ì'=>'i', 'Ĩ'=>'i', 'Ī'=>'i', 'Ĭ'=>'i', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ō'=>'o', 'ŏ'=>'o', 'ő'=>'o', 'Ò'=>'o', 'Ó'=>'o', 'Ô'=>'o', 'Õ'=>'o', 'Ö'=>'o', 'Ō'=>'o', 'Ŏ'=>'o', 'Ő'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ũ'=>'u', 'ū'=>'u', 'ŭ'=>'u', 'ů'=>'u', 'Ù'=>'u', 'Ú'=>'u', 'Û'=>'u', 'Ü'=>'u', 'Ũ'=>'u', 'Ū'=>'u', 'Ŭ'=>'u', 'Ů'=>'u', 'ç'=>'c', 'Ç'=>'c', 'ÿ'=>'y', ','=>'-', '.'=>'-', 'ñ'=>'n', 'Ñ'=>'n', 'Š'=>'s', 'š'=>'s', 'Ž'=>'z', 'ž'=>'z', 'Ý'=>'y', 'Þ'=>'b', 'ß'=>'s', 'ø'=>'o', 'ý'=>'y', 'þ'=>'b'
		);

		$sname = strtr($sname, $table); // remplazamos los acentos, etc, por su correspondientes
		$sname = preg_replace("/[^A-Za-z0-9-+&]+/", "", $sname); // eliminamos cualquier caracter que no sea de la a-z o 0 al 9 o -
		$sname = preg_replace("/-+/", "-", $sname);/*Eliminamos guiones dobles*/
		$sname = preg_replace("/\++/", "+", $sname);/*Eliminamos signos + dobles*/
		$sname = preg_replace("/\&+/", "&", $sname);/*Eliminamos signos & dobles*/
		$sname = preg_replace("/(-\+-|\+-|-\+)/", "+", $sname);
		$sname = preg_replace("/(-\&-|\&-|-\&)/", "&", $sname);

		return $sname;
	}
endif;

if ( ! function_exists('slugClean')):
	function slugClean($string){
		$rstring = trim($string);
		$rstring = preg_replace('/[-+&]/',' ', $rstring);
		$rstring = preg_replace("/\s+/", ' ', $rstring);
		return $rstring;
	}
endif;

if ( ! function_exists('slugQuerySearch') ):
	function slugQuerySearch($string){
		$rstring['join'] = "";
		$rstring['where'] = "";
		$whereField = "generalSlug";
		$operador = NULL;
		if ( strrpos($string, "+") > 0):
			$operador['char'] = "+";
			$operador['query'] = " OR ";
		endif;
		if ( strrpos($string, "&") > 0):
			$operador['char'] = "&";
			$operador['query'] = " AND ";
		endif;
		if ( strrpos($string, "+") > 0 && strrpos($string, "&") > 0 && strrpos($string, "&") > strrpos($string, "+")):
			$operador['char'] = "+";
			$operador['query'] = " OR ";
		endif;
		if( $operador != NULL):
			$astring = explode($operador['char'], $string);
			foreach ($astring as $key => $value):
				$astring[$key] = slugClean($value);
				$astring[$key] = trim($astring[$key]);
				$astring[$key] =explode(" ", $astring[$key]);
			endforeach;

			$totalIndex = count($astring);
			$currentIndex = 1;
			foreach ($astring as $words):
				$rstring['where'] .= "\"{$whereField}\" ~~ '%";
				foreach ($words as $word):
					$rstring['where'] .="{$word}%";
				endforeach;
				$rstring['where'] .= "'";
				if($currentIndex < $totalIndex):
					$rstring['where'] .= $operador['query'];
				endif;
				$currentIndex++;
			endforeach;
		else:
			$astring = slugClean($string);
			$astring = trim($astring);
			$astring = explode(" ", $astring);
			if( count($astring) > 1 ):
				$rstring['join'] = "INNER JOIN \"mvSearchFields\" sf ON s.sistema=sf.sistema AND s.iddatabase=sf.iddatabase";
				$whereField = "singleFields";
				$totalIndex = count($astring);
				$currentIndex = 1;
				$rstring['where'] .= "\"{$whereField}\" ~~ '%";
				foreach ($astring as $word):
					$rstring['where'] .= "{$word}";
					if($currentIndex < $totalIndex):
						$rstring['where'] .= "%";
					endif;
					$currentIndex++;
				endforeach;
				$rstring['where'] .= "%'";
			else:
				$rstring['where'] .= "\"{$whereField}\" ~~ '%{$astring[0]}%'";
			endif;
		endif;
		return $rstring;
	}
endif;

if ( ! function_exists('slugHighLight') ):
	function slugHighLight($string){
		$sname = sprintf("\"%s\"", trim($string));
		$sname = preg_replace("/[&+]/", "\", \"", $sname);
		$sname = preg_replace("/a/", "[aáàâãäåāăą]", $sname);
		$sname = preg_replace("/e/", "[eéèêėēĕěę]", $sname);
		$sname = preg_replace("/i/", "[iìíîïìĩīĭ]", $sname);
		$sname = preg_replace("/o/", "[oóôõöōŏőø]", $sname);
		$sname = preg_replace("/u/", "[uùùûüũūŭů]", $sname);
		$sname = preg_replace("/c/", "[çc]", $sname);
		$sname = preg_replace("/y/", "[ýÿy]", $sname);
		$sname = preg_replace("/n/", "[ñn]", $sname);
		$sname = preg_replace("/s/", "[šs]", $sname);
		$sname = preg_replace("/z/", "[žz]", $sname);
		$sname = preg_replace("/b/", "[þÞßb]", $sname);
		$sname = preg_replace("/-+/", "\\\\\\s+", $sname);

		return $sname;
	}
endif;