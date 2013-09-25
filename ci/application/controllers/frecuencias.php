<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frecuencias extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		set_translation_language(get_cookie('lang'));
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}

	public function index()
	{
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias');
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_index', $data['main']);
		$this->load->view('footer');
	}

	public function autor(){
		$args = $this->uri->uri_to_assoc();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por autor');
		$order = "documentos";
		$orderDir = "DESC";
		if (isset($_POST['ajax'])):
			$this->load->database();
			/*Obtniendo el total de registros*/
			$query = "SELECT count(*) AS total FROM \"mvFrecuenciaAutorDocumentos\"";
			$query = $this->db->query($query);
			$query = $query->row_array();
			$data['main']['total'] = $query['total'];
			/*Filas de la tabla*/
			$sort = explode("-", $args['ordenar']);
			$order = $sort[0];
			$orderDir = strtoupper($sort[1]);
			$offset = $args['resultados'] * ($args['pagina']-1);
			$query = "SELECT * FROM \"mvFrecuenciaAutorDocumentos\" ORDER BY {$order} {$orderDir} LIMIT {$args['resultados']} OFFSET {$offset}";
			$query = $this->db->query($query);
			$this->db->close();
			$result = array();
			$result['totalRecords']=$data['main']['total'];
			$result['curPage']=$_POST['page'];
			$result['data']=array();
			$rowNumber=1;
			foreach ($query->result_array() as $row):
				$rowResult = array();
				//$rowResult[]=$rowNumber + $offset;
				$rowResult[]=$row['autor'];
				$rowResult[]=$row['autorSlug'];
				$rowResult[]=$row['documentos'];
				$result['data'][]=$rowResult;
				$rowNumber++;
			endforeach;
			$this->output->enable_profiler(false);
			header('Content-Type: application/json');
			echo json_encode($result, true);
			return 0;
		endif;
		/*Columnas de la tabla*/
		/*$colModel[] = array(
				'title' => '#',
				'width' => 50
			);*/
		$colModel[] = array(
				'editable' => false,
				'title' => _('Autor'),
				'width' => 200
			);
		$colModel[] = array(
				'editable' => false,
				'hidden' => true,
				'title' => _('AutorSlug'),
				'width' => 200
			);
		$colModel[] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
			);
		$sortBy = array('autor', 'autorSlug', 'documentos');
		$data['header']['colModel'] = json_encode($colModel, true);
		$data['header']['sortBy'] = json_encode($sortBy, true);
		$data['header']['sortIndx'] = array_search($order, $sortBy);
		$data['header']['args'] = pqgrid_args($args);
		$data['header']['content'] =  $this->load->view('frecuencias_autor_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_autor', $data['main']);
		$this->load->view('footer');
	}

	public function autorArticulos($slug){
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - autor articulos');
		/*Obtniendo los registros con paginación*/
		$query = "SELECT * FROM autor a INNER JOIN \"mvSearch\" s ON a.iddatabase=s.iddatabase AND a.sistema=s.sistema WHERE a.slug='{$slug}'";
		$queryCount = "SELECT count(*) AS total FROM autor a INNER JOIN \"mvSearch\" s ON a.iddatabase=s.iddatabase AND a.sistema=s.sistema WHERE a.slug='{$slug}'";
		$perPage = 20;
		$paginationURL = site_url("frecuencias/autor/{$slug}");
		$articulosResultado = articulosResultado($query, $queryCount, $paginationURL, $perPage);
		/*Datos del autor*/
		$this->load->database();
		$queryAutor = "SELECT e_100a AS autor FROM autor WHERE slug='{$slug}' LIMIT 1";
		$queryAutor = $this->db->query($queryAutor);
		$this->db->close();
		$queryAutor = $queryAutor->row_array();
		$data['main']['autor'] = $queryAutor['autor'];
		/*Vistas*/
		$data['main']['links'] = $articulosResultado['links'];
		$data['main']['total'] = $articulosResultado['totalRows'];
		$data['main']['resultados']=$articulosResultado['articulos'];
		$data['header']['title'] = _sprintf('Biblat - %s (%s documentos)', $data['main']['autor'], $data['main']['total']);
		$data['header']['slugHighLight']=slugHighLight($slug);
		$data['header']['content'] =  $this->load->view('buscar_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_autor_articulos', $data['main']);
		$this->load->view('footer');
	}

	public function institucion(){
		$args = $this->uri->uri_to_assoc();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institucion');
		$order = "documentos";
		$orderDir = "DESC";
		if (isset($_POST['ajax'])):
			$this->load->database();
			/*Obtniendo el total de registros*/
			$query = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionDARP\"";
			$query = $this->db->query($query);
			$query = $query->row_array();
			$data['main']['total'] = $query['total'];
			/*Filas de la tabla*/
			$sort = explode("-", $args['ordenar']);
			$order = $sort[0];
			$orderDir = strtoupper($sort[1]);
			$offset = $args['resultados'] * ($args['pagina']-1);
			$query = "SELECT * FROM \"mvFrecuenciaInstitucionDARP\" ORDER BY {$order} {$orderDir} LIMIT {$args['resultados']} OFFSET {$offset}";
			$query = $this->db->query($query);
			$this->db->close();
			$result = array();
			$result['totalRecords']=$data['main']['total'];
			$result['curPage']=$_POST['page'];
			$result['data']=array();
			$rowNumber=1;
			foreach ($query->result_array() as $row):
				$rowResult = array();
				//$rowResult[]=$rowNumber + $offset;
				$rowResult[]=$row['institucion'];
				$rowResult[]=$row['institucionSlug'];
				$rowResult[]=$row['paises'];
				$rowResult[]=$row['revistas'];
				$rowResult[]=$row['autores'];
				$rowResult[]=$row['documentos'];
				$result['data'][]=$rowResult;
				$rowNumber++;
			endforeach;
			$this->output->enable_profiler(false);
			header('Content-Type: application/json');
			echo json_encode($result, true);
			return 0;
		endif;
		/*Columnas de la tabla*/
		/*$colModel[] = array(
				'title' => '#',
				'width' => 50
			);*/
		$colModel[] = array(
				'editable' => false,
				'title' => _('Institución'),
				'width' => 200
			);
		$colModel[] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'institucionSlug',
				'width' => 200
			);
		$colModel[] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Países'),
				'width' => 100,
			);
		$colModel[] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Revistas'),
				'width' => 100,
			);
		$colModel[] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Autores'),
				'width' => 100,
			);
		$colModel[] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
			);
		$sortBy = array('institucion', 'institucionSlug', 'paises', 'revistas', 'autores', 'documentos');
		$data['header']['colModel'] = json_encode($colModel, true);
		$data['header']['sortBy'] = json_encode($sortBy, true);
		$data['header']['sortIndx'] = array_search($order, $sortBy);
		$data['header']['args'] = pqgrid_args($args);
		$data['header']['content'] =  $this->load->view('frecuencias_autor_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_autor', $data['main']);
		$this->load->view('footer');
	}

}

/* End of file frecuencias.php */
/* Location: ./application/controllers/frecuencias.php */