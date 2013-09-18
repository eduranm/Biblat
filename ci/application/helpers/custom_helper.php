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

if ( ! function_exists('slugClean')):
	function slugClean($string){
		$rstring = trim($string);
		$rstring = preg_replace('/[-+&]/',' ', $rstring);
		$rstring = preg_replace("/\s+/", ' ', $rstring);
		return $rstring;
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
		$sname = preg_replace("/[^A-Za-z0-9-+&\"]+/", "", $sname); // eliminamos cualquier caracter que no sea de la a-z o 0 al 9 o -
		$sname = preg_replace("/-+/", "-", $sname);/*Eliminamos guiones dobles*/
		$sname = preg_replace("/\++/", "+", $sname);/*Eliminamos signos + dobles*/
		$sname = preg_replace("/\&+/", "&", $sname);/*Eliminamos signos & dobles*/
		$sname = preg_replace("/(-\+-|\+-|-\+)/", "+", $sname);
		$sname = preg_replace("/(-\&-|\&-|-\&)/", "&", $sname);

		return $sname;
	}
endif;

if ( ! function_exists('slugSearchClean') ):
	function slugSearchClean($string){
		$rstring = trim($string);
		$rstring = urldecode($rstring);
		$rstring = preg_replace("/&+/", " & ", $rstring);
		$rstring = preg_replace("/\++/", " + ", $rstring);
		$rstring = preg_replace("/-+/", " ", $rstring);

		return $rstring;
	}
endif;

if ( ! function_exists('slugQuerySearch') ):
	function slugQuerySearch($string, $whereField="generalSlug"){
		$rstring['where'] = "";
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
				$totalIndexW = count($words);
				$currentIndexW = 1;
				foreach ($words as $word):
					$rstring['where'] .="{$word}";
					if($currentIndexW < $totalIndexW):
						$rstring['where'] .= "_";
					endif;
					$currentIndexW++;
				endforeach;
				$rstring['where'] .= "%'";
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
				$totalIndex = count($astring);
				$currentIndex = 1;
				$rstring['where'] .= "\"{$whereField}\" ~~ '%";
				foreach ($astring as $word):
					$rstring['where'] .= "{$word}";
					if($currentIndex < $totalIndex):
						$rstring['where'] .= "_";
					endif;
					$currentIndex++;
				endforeach;
				$rstring['where'] .= "%'";
			else:
				$rstring['where'] .= "\"{$whereField}\" ~~ '%{$astring[0]}%'";
			endif;
		endif;
		$rstring = str_replace("%22", " ", $rstring);
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
		$sname = preg_replace("/-+/", "[\\\\\\s.,+&]+", $sname);
		$sname = str_replace("%22", "\\\\b", $sname);
		return $sname;
	}
endif;

if ( ! function_exists('articulosResultado') ):
	function articulosResultado($query, $queryCount, $paginationURL, $perPage){
		/**/
		$resultado = array();
		/*Load libraries*/
		$ci=& get_instance();
		$ci->load->database();
		$ci->load->library('session');
		$ci->load->library('pagination');

		if ( ! $ci->session->userdata('query{'.md5($queryCount).'}')):
			$queryTotalRows = $ci->db->query($queryCount);
			$queryTotalRows = $queryTotalRows->row_array();
			$ci->session->set_userdata('query{'.md5($queryCount).'}', $queryTotalRows['total']);
		endif;

		$totalRows=(int)$ci->session->userdata('query{'.md5($queryCount).'}');

		$config['base_url'] = $paginationURL;
		$config['uri_segment'] = $ci->uri->total_segments();
		$config['total_rows'] = $totalRows;
		$config['per_page'] = $perPage;
		$config['use_page_numbers'] = true;
		$config['first_link'] = "<img src=\"".base_url()."img/first.png\" border=\"0\"/>";
		$config['last_link'] = "<img src=\"".base_url()."img/last.png\" border=\"0\"/>";
		$config['next_link'] = "<img src=\"".base_url()."img/next.png\" border=\"0\"/>";
		$config['prev_link'] = "<img src=\"".base_url()."img/prev.png\" border=\"0\"/>";
		$config['cur_tag_open'] = '<span class="currentPage">';
		$config['cur_tag_close'] = '</span>';
		$config['num_tag_open'] = '<span class="page">';
		$config['num_tag_close'] = '</span>';
		$config['prev_tag_open'] = '<span>';
		$config['prev_tag_close'] = '</span>';
		$config['next_tag_open'] = '<span>';
		$config['next_tag_close'] = '</span>';
		$config['first_tag_open'] = '<span>';
		$config['first_tag_close'] = '</span>';
		$config['last_tag_open'] = '<span>';
		$config['last_tag_close'] = '</span>';
		$config['full_tag_open'] = '<div class="navbar">';
		$config['full_tag_close'] = '</div>';
		$ci->pagination->initialize($config);
		
		$resultado['links'] = $ci->pagination->create_links();
		$resultado['totalRows'] = $totalRows;

		$offset = (($ci->pagination->cur_page - 1) * $config['per_page']);
		if ($offset < 0 ):
			$offset = 0;
		endif;
		$query = "{$query} LIMIT {$config['per_page']} OFFSET {$offset}";
		$query = $ci->db->query($query);
		foreach ($query->result_array() as $row):
			/*Generando arreglo de autores*/
			if($row['autoresSecJSON'] != NULL && $row['autoresJSON'] != NULL):
				$row['autores'] = array_combine(json_decode($row['autoresSecJSON']), json_decode($row['autoresJSON']));
			endif;
			/*Generando arreglo institucion de autores*/
			if($row['autoresSecJSON'] != NULL && $row['autoresSecInstitucionJSON'] != NULL):
				$row['autoresInstitucionSec'] = array_combine(json_decode($row['autoresSecJSON']), json_decode($row['autoresSecInstitucionJSON']));
			endif;
			unset($row['autoresSecJSON'], $row['autoresJSON'], $row['autoresSecInstitucionJSON']);
			/*Generando arreglo de instituciones*/
			if($row['institucionesSecJSON'] != NULL && $row['institucionesJSON'] != NULL):
				$row['instituciones'] = array_combine(json_decode($row['institucionesSecJSON']), json_decode($row['institucionesJSON']));
			endif;
			unset($row['institucionesSecJSON'], $row['institucionesJSON']);
			/*Limpiando caracteres html*/
			$row = htmlspecialchars_deep($row);
			/*Creando valores para el checkbox*/
			$row['checkBoxValue'] = "{$row['iddatabase']}|{$row['sistema']}";
			$row['checkBoxId'] = "cbox_{$row['checkBoxValue']}";
			/*Creando link en caso de que exista texto completo*/
			$row['articuloLink'] = $row['articulo'];
			if( $row['url'] != NULL):
				$row['articuloLink'] = "<a href=\"{$row['url']}\" target=\"_blank\">{$row['articuloLink']}</a>";
			endif;
			/*Creando lista de autores en html*/
			$row['autoresHTML'] = "";
			if(isset($row['autores'])):
				$totalAutores = count($row['autores']);
				$indexAutor = 1;
				foreach ($row['autores'] as $key => $autor):
					$row['autoresHTML'] .= "{$autor}";
					if ( isset($row['instituciones'][$row['autoresInstitucionSec'][$key]]) ):
						$row['autoresHTML'] .= "<sup>{$row['autoresInstitucionSec'][$key]}</sup>";
					endif;
					if($indexAutor < $totalAutores):
						$row['autoresHTML'] .= "., ";
					endif;
					$indexAutor++;
				endforeach;
			endif;
			/*Creando lista de instituciones html*/
			$row['institucionesHTML'] = "";
			if(isset($row['instituciones'])):
				$totalInstituciones = count($row['instituciones']);
				$indexInstitucion = 1;
				foreach ($row['instituciones'] as $key => $institucion):
					$row['institucionesHTML'] .= "<sup>{$key}</sup>{$institucion}";
					if($indexInstitucion < $totalInstituciones):
						$row['institucionesHTML'] .= "., ";
					endif;
					$indexInstitucion++;
				endforeach;
			endif;
			/*Creando el detalle de la revista*/
			$row['detalleRevista'] = "[{$row['revista']}, {$row['pais']}, {$row['anio']} {$row['volumen']} {$row['numero']} {$row['periodo']}, {$row['paginacion']}]";

			$resultado['articulos'][++$offset] = $row;
		endforeach;
		$query->free_result();
		$ci->db->close();
		//print_r($resultado);
		//die();
		return $resultado;
	}
endif;

if ( ! function_exists('getAbstract') ):
	function getAbstract($sistema, $idDatabase){

	}
endif;

if ( ! function_exists('remove_empty') ):
	function remove_empty($array) {
	  return array_filter($array, '_remove_empty_internal');
	}
endif;

if ( ! function_exists('_remove_empty_internal') ):
	function _remove_empty_internal($value) {
	  return !empty($value) || $value === 0;
	}
endif;

if ( ! function_exists('ucname') ):
	function ucname($string) {
		$string =ucwords(strtolower($string));

		foreach (array('-', '\'') as $delimiter) :
			if (strpos($string, $delimiter)!==false):
			$string =implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
			endif;
		endforeach;
		return $string;
	}
endif;

if ( ! function_exists('htmlspecialchars_deep') ):
	function htmlspecialchars_deep($mixed, $quote_style = ENT_QUOTES, $charset = 'UTF-8'){
		if (is_array($mixed)):
			foreach($mixed as $key => $value):
				$mixed[$key] = htmlspecialchars_deep($value, $quote_style, $charset);
			endforeach;
		elseif (is_string($mixed)):
			$mixed = htmlspecialchars(htmlspecialchars_decode($mixed, $quote_style), $quote_style, $charset);
		endif;
		return $mixed;
	} 
endif;