<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Buscar extends CI_Controller{

	public function __construct(){
		parent::__construct();
		set_translation_language(get_cookie('lang'));
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}
	
	public function index($disciplina="", $slug="", $textoCompleto=""){
		/*Si se hizo una consulta con POST redirigimos a una url correcta*/
		if(isset($_POST['disciplina']) && isset($_POST['slug'])):
			if(isset($_POST['textoCompleto'])):
				$textoCompleto="texto-completo";
			endif;
			$returnURL = site_url(preg_replace('%[/]+%', '/', "buscar/{$_POST['disciplina']}/".slugSearch($_POST['slug'])."/{$textoCompleto}"));
			redirect($returnURL, 'refresh');
		endif;
		/*Si no exite ningun dato redirigimos al index*/
		if($disciplina == "" || $slug == ""):
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
		/*Creando la consulta para los resultados*/
		$whereTextoCompleto = "";
		if ($textoCompleto == "texto-completo"):
			$whereTextoCompleto = "AND url <> ''";
		endif;

		$whereDisciplina = "";
		if ($disciplina != "null"):
			/*Obteniendo id de la disciplina*/
			$query = "SELECT * from disciplinas WHERE slug='{$disciplina}'";
			$query = $this->db->query($query);
			$disciplina = $query->row_array();
			$query->free_result();
			$whereDisciplina = "AND id_disciplina={$disciplina['id_disciplina']}";
		endif;

		$slugQuerySearch = slugQuerySearch($slug);
		$queryFields="SELECT 
					DISTINCT (s.sistema, 
					s.iddatabase) as \"sitemaIdDatabase\", 
					articulo, 
					revista, 
					pais, 
					anio, 
					volumen, 
					numero, 
					periodo, 
					paginacion, 
					url, 
					\"autoresSecJSON\",
					\"autoresSecInstitucionJSON\",
					\"autoresJSON\",
					\"institucionesSecJSON\",
					\"institucionesJSON\"";
		$queryFrom="FROM \"mvSearch\" s 
				{$slugQuerySearch[join]} 
				WHERE  {$slugQuerySearch[where]} {$whereTextoCompleto} {$whereDisciplina}";
		$query = "{$queryFields} 
				{$queryFrom} 
				ORDER BY anio DESC, articulo";
		
		$queryCount = "SELECT count (DISTINCT (s.sistema, 
					s.iddatabase)) as total {$queryFrom}";
		if ( ! $this->session->userdata('query{'.md5($queryCount).'}')):
			$queryTotalRows = $this->db->query($queryCount);
			$queryTotalRows = $queryTotalRows->row_array();
			$this->session->set_userdata('query{'.md5($queryCount).'}', $queryTotalRows['total']);
		endif;

		$totalRows=(int)$this->session->userdata('query{'.md5($queryCount).'}');

		/*Creando paginacion*/
		if($disciplina == "null"):
			$disciplina = array();
			$disciplina['slug'] = "";
			$disciplina['disciplina'] = "";
		endif;
		$this->load->library('pagination');
		if ($textoCompleto == "texto-completo"):
			$config['base_url'] = site_url(preg_replace('%[/]+%', '/',"buscar/{$disciplina['slug']}/{$slug}/{$textoCompleto}"));
		else:
			$config['base_url'] = site_url(preg_replace('%[/]+%', '/',"buscar/{$disciplina['slug']}/{$slug}"));
		endif;
		$config['uri_segment'] = $this->uri->total_segments();
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

			$data['main']['resultados'][++$offset] = $row;
		endforeach;
		$data['header']['slugHighLight']=slugHighLight($slug);
		$query->free_result();
		$this->db->close();
		/*Vistas*/
		$data['header']['content'] =  $this->load->view('buscar_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('buscar_index', $data['main']);
		$this->load->view('footer');
	}
}