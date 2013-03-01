<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Buscar extends CI_Controller{

	public function __construct(){
		parent::__construct();
		set_translation_language(get_cookie('lang'));
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}
	
	public function index($disciplina="", $indice="", $slug="", $textoCompleto=""){
		/*Si se hizo una consulta con POST redirigimos a una url correcta*/
		if(isset($_POST['disciplina']) && isset($_POST['indice']) && isset($_POST['slug'])):
			if(isset($_POST['textoCompleto'])):
				$textoCompleto="texto-completo";
			endif;
			redirect(site_url("buscar/{$_POST['disciplina']}/{$_POST['indice']}/".slug($_POST['slug'])."/{$textoCompleto}"), 'refresh');
		endif;
		/*Si no exite ningun dato redirigimos al index*/
		if($disciplina == "" || $indice == "" || $slug == ""):
			 redirect(base_url(), 'refresh');
		endif;
		/*Variables para vistas*/
		$data = array();
		/*Arrego con descripcion y sql para cada indice*/
		$indiceArray['tema'] = array('sql' => '"palabrasClaveSlug"', 'descripcion' => _('Tema'));
		$indiceArray['articulo'] = array('sql' => '"articuloSlug"', 'descripcion' => _('Artículo'));
		$indiceArray['autor'] = array('sql' => '"autoresSlug"', 'descripcion' => _('Autor'));
		$indiceArray['institucion'] = array('sql' => '"institucionesSlug"', 'descripcion' => _('Institución'));
		$indiceArray['revista'] = array('sql' => '"revistaSlug"', 'descripcion' => _('Revista'));

		/*Header title*/
		$data['header']['title'] = _sprintf('Biblat - Búsqueda por %s: "%s"', strtolower($indiceArray[$indice]['descripcion']), slugClean($slug));
		/*Consultas*/
		$this->load->database();
		/*Obteniendo id de la disciplina*/
		$query = "SELECT * from disciplinas WHERE slug='{$disciplina}'";
		$query = $this->db->query($query);
		$disciplina = $query->row_array();
		$query->free_result();
		/*Creando la consulta para los resultados*/
		$whereTextoCompleto = "";
		if ($textoCompleto == "texto-completo"):
			$whereTextoCompleto = "AND e_856u <> ''";
		endif;


		$query="SELECT 
					DISTINCT sistema, 
					iddatabase, 
					e_245 AS titulo, 
					e_222 AS revista, 
					e_008 AS pais, 
					e_260b AS anio, 
					e_300a AS volumen, 
					e_300b AS numero, 
					e_300c AS periodo, 
					e_300e AS paginacion, 
					e_856u AS url, 
					\"autoresSec\",
					\"autoresSecInstitucion\",
					\"autoresJSON\",
					\"institucionesSec\",
					\"institucionesJSON\"
				FROM \"mvSearch\"  
				WHERE id_disciplina='{$disciplina['id_disciplina']}' $whereTextoCompleto AND {$indiceArray[$indice]['sql']} LIKE '%$slug%'
				ORDER BY e_260b DESC";
		
		$queryCount = "SELECT count (*) as total FROM (${query}) as rows";
		if ( ! $this->session->userdata('query{'.md5($queryCount).'}')):
			$queryTotalRows = $this->db->query($queryCount);
			$queryTotalRows = $queryTotalRows->row_array();
			$this->session->set_userdata('query{'.md5($queryCount).'}', $queryTotalRows['total']);
		endif;

		$totalRows=(int)$this->session->userdata('query{'.md5($queryCount).'}');

		/*Creando paginacion*/
		$this->load->library('pagination');
		if ($textoCompleto == "texto-completo"):
			$config['base_url'] = site_url("buscar/{$disciplina['slug']}/{$indice}/{$slug}/{$textoCompleto}");
			$config['uri_segment'] = 6;
		else:
			$config['base_url'] = site_url("buscar/{$disciplina['slug']}/{$indice}/{$slug}");
			$config['uri_segment'] = 5;
		endif;
		$config['total_rows'] = $totalRows;
		$config['per_page'] = 20;
		$config['use_page_numbers'] = true;
		$config['first_link'] = _('Primera');
		$config['last_link'] = _('Última');
		$this->pagination->initialize($config);
		
		$data['main']['links'] = $this->pagination->create_links();

		/*Datos de la busqueda*/
		$data['main']['search']['indice'] = $indiceArray[$indice]['descripcion'];
		$data['main']['search']['slug'] = slugClean($slug);
		$data['main']['search']['disciplina'] = $disciplina['disciplina'];
		$data['main']['search']['total'] = $totalRows;
		/*Resultados de la página*/
		$offset = (($this->pagination->cur_page - 1) * $config['per_page']);
		if ($offset < 0 ):
			$offset = 0;
		endif;
		$query = "{$query} LIMIT {$config['per_page']} OFFSET {$offset}";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row):
			/*Generando arreglo de autores*/
			if($row['autoresSec'] != NULL && $row['autoresJSON'] != NULL):
				$row['autores'] = array_combine(json_decode($row['autoresSec']), json_decode($row['autoresJSON']));
			endif;
			/*Generando arreglo institucion de autores*/
			if($row['autoresSec'] != NULL && $row['autoresSecInstitucion'] != NULL):
				$row['autoresInstitucionSec'] = array_combine(json_decode($row['autoresSec']), json_decode($row['autoresSecInstitucion']));
			endif;
			unset($row['autoresSec'], $row['autoresJSON'], $row['autoresSecInstitucion']);
			/*Generando arreglo de instituciones*/
			if($row['institucionesSec'] != NULL && $row['institucionesJSON'] != NULL):
				$row['instituciones'] = array_combine(json_decode($row['institucionesSec']), json_decode($row['institucionesJSON']));
			endif;
			unset($row['institucionesSec'], $row['institucionesJSON']);
			/*Creando valores para el checkbox*/
			$row['checkBoxValue'] = "{$row['iddatabase']}|{$row['sistema']}";
			$row['checkBoxId'] = "cbox_{$row['checkBoxValue']}";
			/*Creando link en caso de que exista texto completo*/
			$row['articuloLink'] = $row['titulo'];
			if( $row['url'] != NULL):
				$row['articuloLink'] = "<a href=\"{$row['url']}\" target=\"_blank\">{$row['articuloLink']}</a>";
			endif;
			/*Creando lista de autores en html*/
			$row['autoresHTML'] = "";
			if(isset($row['autores'])):
				$totalAutores = count($row['autores']);
				$indexAutor = 1;
				foreach ($row['autores'] as $key => $autor):
					$row['autoresHTML'] .= "{$autor}<sup>{$row['autoresInstitucionSec'][$key]}</sup>";
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

			$data['main']['resultados'][++$offset] = $row;
		endforeach;
		$query->free_result();
		/*Vistas*/
		$data['header']['content'] =  $this->load->view('buscar_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('buscar_index', $data['main']);
		$this->load->view('footer');
	}
}