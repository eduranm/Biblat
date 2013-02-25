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
		$indiceArray['tema'] = array('sql' => 'p.descpalabraclave', 'descripcion' => _('Tema'));
		$indiceArray['articulo'] = array('sql' => 't.e_245', 'descripcion' => _('Artículo'));
		$indiceArray['autor'] = array('sql' => 'a.e_100a', 'descripcion' => _('Autor'));
		$indiceArray['institucion'] = array('sql' => 'i.e_100u', 'descripcion' => _('Institución'));
		$indiceArray['revista'] = array('sql' => 't.e_222', 'descripcion' => _('Revista'));

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
			$whereTextoCompleto = "AND t.e_856u <> ''";
		endif;


		if ($indice=="revista" or $indice=="autor" or $indice=="institucion"):
			$query="SELECT 
						t.sistema, 
						t.iddatabase, 
						t.e_245, 
						t.e_222, 
						t.e_008, 
						t.e_260b, 
						t.e_300a, 
						t.e_300b, 
						t.e_300c, 
						t.e_300e, 
						t.e_856u, 
						a.e_100a,
						i.e_100u 
					FROM articulo t 
					LEFT JOIN autor a ON (a.iddatabase=t.iddatabase AND a.sistema=t.sistema AND a.sec_autor='1') 
					LEFT JOIN institucion i ON (i.iddatabase=a.iddatabase AND i.sistema=a.sistema AND i.sec_institucion=a.sec_institucion) 
					LEFT JOIN artidisciplina d ON (d.iddatabase=t.iddatabase AND d.sistema=t.sistema) 
					WHERE t.id_disciplina='{$disciplina['id_disciplina']}' $whereTextoCompleto  AND slug({$indiceArray[$indice]['sql']}) LIKE '%$slug%'
					GROUP BY t.iddatabase, t.sistema, a.e_100a, i.e_100u 
					ORDER BY t.e_260b DESC";
		else:
			$query="SELECT 
						t.sistema, 
						t.iddatabase, 
						t.e_245, 
						t.e_222, 
						t.e_008, 
						t.e_260b, 
						t.e_300a, 
						t.e_300b, 
						t.e_300c, 
						t.e_300e, 
						t.e_856u, 
						a.e_100a, 
						i.e_100u 
					FROM articulo t 
					LEFT JOIN autor a ON (a.iddatabase=t.iddatabase AND a.sistema=t.sistema AND a.sec_autor='1')
					LEFT JOIN institucion i ON (a.iddatabase=i.iddatabase AND a.sistema=i.sistema AND a.sec_autor=i.sec_autor) 
					LEFT JOIN artidisciplina d ON (t.iddatabase=d.iddatabase AND t.sistema=d.sistema) 
					LEFT JOIN palabraclave p on (t.iddatabase=p.iddatabase AND t.sistema=p.sistema)  
					WHERE t.id_disciplina='{$disciplina['id_disciplina']}' $whereTextoCompleto AND slug({$indiceArray[$indice]['sql']}) LIKE '%$slug%'
					GROUP BY t.iddatabase, t.sistema, a.e_100a, i.e_100u
					ORDER BY t.e_260b DESC";
		endif;
		
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
		$query = "{$query} LIMIT {$config['per_page']} OFFSET ". (($this->pagination->cur_page - 1) * $config['per_page']);
		$query = $this->db->query($query);
		print_r($query->result_array());
		/*Vistas*/
		$this->load->view('buscar_index', $data['main']);
	}
}