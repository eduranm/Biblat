<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Buscar extends CI_Controller{

	public function __construct(){
		parent::__construct();
		set_translation_language(get_cookie('lang'));
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}
	
	public function index($disciplina="", $indice="", $slug="", $textoCompleto=""){
		/*Variables para vistas*/
		$data['main']="";
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

		/*Arrego con descripcion y sql para cada indice*/
		$indiceArray['tema'] = array('sql' => '"descPalabraClaveSlug"', 'descripcion' => _('Tema'));
		$indiceArray['articulo'] = array('sql' => '"e245Slug"', 'descripcion' => _('Artículo'));
		$indiceArray['autor'] = array('sql' => '"e_100aSlug"', 'descripcion' => _('Autor'));
		$indiceArray['institucion'] = array('sql' => '"e_100uSlug"', 'descripcion' => _('Institución'));
		$indiceArray['revista'] = array('sql' => '"e_222Slug"', 'descripcion' => _('Revista'));

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
					e_245, 
					e_222, 
					e_008, 
					e_260b, 
					e_300a, 
					e_300b, 
					e_300c, 
					e_300e, 
					e_856u, 
					e_100a, 
					e_100u 
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
		$this->pagination->initialize($config);
		$data['main']['links'] = $this->pagination->create_links();
		/*Resultados de la página*/
		$offset = (($this->pagination->cur_page - 1) * $config['per_page']);
		if ($offset < 0 ):
			$offset = 0;
		endif;
		$query = "{$query} LIMIT {$config['per_page']} OFFSET {$offset}";
		$query = $this->db->query($query);
		print_r($query->result_array());
		/*Vistas*/
		$this->load->view('buscar_index', $data['main']);
	}
}