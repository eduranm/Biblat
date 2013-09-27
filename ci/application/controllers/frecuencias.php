<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frecuencias extends CI_Controller {

	public $queryFields="DISTINCT ON (s.sistema, s.iddatabase)
					articulo, 
					\"articuloSlug\", 
					revista, 
					\"revistaSlug\", 
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
		$data['header']['gridTitle'] = _sprintf('Frecuencia de documentos por autor');
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
		$data['header']['content'] =  $this->load->view('frecuencias_header', $data['header'], TRUE);
		$data['main']['breadcrumb'] = sprintf('%s > %s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), _('Autor'));
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_common', $data['main']);
		$this->load->view('footer');
	}

	public function autorDocumentos($slug){
		$data = array();
		/*Obtniendo los registros con paginación*/
		$query = "SELECT {$this->queryFields} FROM autor a INNER JOIN \"mvSearch\" s ON a.iddatabase=s.iddatabase AND a.sistema=s.sistema WHERE a.slug='{$slug}'";
		$queryCount = "SELECT count(DISTINCT (a.iddatabase, a.sistema)) AS total FROM autor a INNER JOIN \"mvSearch\" s ON a.iddatabase=s.iddatabase AND a.sistema=s.sistema WHERE a.slug='{$slug}'";
		$perPage = 20;
		$paginationURL = site_url("frecuencias/autor/{$slug}");
		$articulosResultado = articulosResultado($query, $queryCount, $paginationURL, $perPage);
		/*Datos del autor*/
		$this->load->database();
		$queryAutor = "SELECT e_100a AS autor FROM autor WHERE slug='{$slug}' LIMIT 1";
		$queryAutor = $this->db->query($queryAutor);
		$this->db->close();
		$queryAutor = $queryAutor->row_array();
		/*Vistas*/
		$data['main']['links'] = $articulosResultado['links'];
		$data['main']['resultados']=$articulosResultado['articulos'];
		$data['header']['title'] = _sprintf('Biblat - %s (%d documentos)', $data['main']['autor'], $data['main']['total']);
		$data['header']['slugHighLight']=slugHighLight($slug);
		$data['header']['content'] =  $this->load->view('buscar_header', $data['header'], TRUE);
		$data['main']['breadcrumb'] = sprintf('%s > %s > %s (%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/autor', _('Autor'), _('title="Autor"')), $queryAutor['autor'], $articulosResultado['totalRows']);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_documentos', $data['main']);
		$this->load->view('footer');
	}

	public function institucion(){
		$args = $this->uri->ruri_to_assoc();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución');
		$data['header']['gridTitle'] = _sprintf('Frecuencia de países, revistas, autores y documentos por institución');
		$data['main']['breadcrumb'] = sprintf('%s > %s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), _('Institución'));
		$where = "";
		if(isset($args['slug'])):
			$this->load->database();
			$query = "SELECT institucion FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['slug']}' LIMIT 1";
			$query = $this->db->query($query);
			$query = $query->row_array();
			$institucion = $query['institucion'];
			$this->db->close();
			$where = "WHERE \"institucionSlug\"='{$args['slug']}'";
			$data['main']['breadcrumb'] = sprintf('%s > %s > %s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		endif;
		$order = "documentos";
		$orderDir = "DESC";
		if (isset($_POST['ajax'])):
			$this->load->database();
			/*Obtniendo el total de registros*/
			$query = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionDARP\" {$where}";
			$query = $this->db->query($query);
			$query = $query->row_array();
			$data['main']['total'] = $query['total'];
			/*Filas de la tabla*/
			$sort = explode("-", $args['ordenar']);
			$order = $sort[0];
			$orderDir = strtoupper($sort[1]);
			$offset = $args['resultados'] * ($args['pagina']-1);
			$query = "SELECT * FROM \"mvFrecuenciaInstitucionDARP\" {$where} ORDER BY {$order} {$orderDir} LIMIT {$args['resultados']} OFFSET {$offset}";
			$query = $this->db->query($query);
			$this->db->close();
			$result = array();
			$result['totalRecords']=$data['main']['total'];
			$result['curPage']=$_POST['page'];
			$result['data']=array();
			$rowNumber=1;
			foreach ($query->result_array() as $row):
				$rowResult = array();
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
		$section = array('', '', '/pais', '/revista', '/autor', '/documento');
		$data['header']['colModel'] = json_encode($colModel, true);
		$data['header']['sortBy'] = json_encode($sortBy, true);
		$data['header']['section'] = json_encode($section, true);
		$data['header']['sortIndx'] = array_search($order, $sortBy);
		$data['header']['args'] = pqgrid_args($args);
		$data['header']['content'] =  $this->load->view('frecuencias_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_common', $data['main']);
		$this->load->view('footer');
	}

	public function institucionDocumentos($slug){
		$data = array();
		/*Obtniendo los registros con paginación*/
		$query = "SELECT DISTINCT ON (sistema, iddatabase) * FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$slug}'";
		$queryCount = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$slug}'";
		$perPage = 20;
		$paginationURL = site_url("frecuencias/institucion/{$slug}/documento");
		$articulosResultado = articulosResultado($query, $queryCount, $paginationURL, $perPage);
		/*Datos del autor*/
		$this->load->database();
		$queryInstitucion = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$slug}' LIMIT 1";
		$queryInstitucion = $this->db->query($queryInstitucion);
		$this->db->close();
		$queryInstitucion = $queryInstitucion->row_array();
		/*Vistas*/
		$data['main']['links'] = $articulosResultado['links'];
		$data['main']['resultados']=$articulosResultado['articulos'];
		$data['header']['title'] = _sprintf('Biblat - %s (%s documentos)', $queryInstitucion['institucion'], $articulosResultado['totalRows']);
		$data['header']['slugHighLight']=slugHighLight($slug);
		$data['header']['content'] =  $this->load->view('buscar_header', $data['header'], TRUE);
		$data['main']['breadcrumb'] = sprintf('%s > %s > %s (%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $queryInstitucion['institucion'], $articulosResultado['totalRows']);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_documentos', $data['main']);
		$this->load->view('footer');
	}

	public function institucionPais(){
		$args = $this->uri->ruri_to_assoc();
		$data = array();
		$order = "documentos";
		$orderDir = "DESC";
		$this->load->database();
		$query = "SELECT institucion FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		if (isset($_POST['ajax'])):
			$this->load->database();
			/*Obtniendo el total de registros*/
			$query = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
			$query = $this->db->query($query);
			$query = $query->row_array();
			$data['main']['total'] = $query['total'];
			/*Filas de la tabla*/
			$sort = explode("-", $args['ordenar']);
			$order = $sort[0];
			$orderDir = strtoupper($sort[1]);
			$offset = $args['resultados'] * ($args['pagina']-1);
			$query = "SELECT * FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' ORDER BY {$order} {$orderDir} LIMIT {$args['resultados']} OFFSET {$offset}";
			$query = $this->db->query($query);
			$this->db->close();
			$result = array();
			$result['totalRecords']=$data['main']['total'];
			$result['curPage']=$_POST['page'];
			$result['data']=array();
			$rowNumber=1;
			foreach ($query->result_array() as $row):
				$rowResult = array();
				$rowResult[]=$row['pais'];
				$rowResult[]=$row['paisSlug'];
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
		$colModel[] = array(
				'editable' => false,
				'title' => _('País'),
				'width' => 320
			);
		$colModel[] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'paisSlug',
				'width' => 200
			);
		$colModel[] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
			);
		$sortBy = array('pais', 'paisSlug', 'documentos');
		/*Datos pra las vistas*/
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", países de publicación', $institucion);
		$data['header']['gridTitle'] = _sprintf('Frecuencia de documentos por país de publicación en la institución:<br/> %s', $institucion);
		$data['header']['colModel'] = json_encode($colModel, true);
		$data['header']['sortBy'] = json_encode($sortBy, true);
		$data['header']['sortIndx'] = array_search($order, $sortBy);
		$data['header']['args'] = pqgrid_args($args);
		$data['header']['content'] =  $this->load->view('frecuencias_header', $data['header'], TRUE);
		$data['main']['breadcrumb'] = sprintf('%s > %s > %s (País)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		/*Vistas*/
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_common', $data['main']);
		$this->load->view('footer');
	}

	public function institucionRevista(){
		$args = $this->uri->ruri_to_assoc();
		$data = array();
		$order = "documentos";
		$orderDir = "DESC";
		$this->load->database();
		$query = "SELECT institucion FROM \"mvFrecuenciaInstitucionRevista\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		if (isset($_POST['ajax'])):
			$this->load->database();
			/*Obtniendo el total de registros*/
			$query = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionRevista\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
			$query = $this->db->query($query);
			$query = $query->row_array();
			$data['main']['total'] = $query['total'];
			/*Filas de la tabla*/
			$sort = explode("-", $args['ordenar']);
			$order = $sort[0];
			$orderDir = strtoupper($sort[1]);
			$offset = $args['resultados'] * ($args['pagina']-1);
			$query = "SELECT * FROM \"mvFrecuenciaInstitucionRevista\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' ORDER BY {$order} {$orderDir} LIMIT {$args['resultados']} OFFSET {$offset}";
			$query = $this->db->query($query);
			$this->db->close();
			$result = array();
			$result['totalRecords']=$data['main']['total'];
			$result['curPage']=$_POST['page'];
			$result['data']=array();
			$rowNumber=1;
			foreach ($query->result_array() as $row):
				$rowResult = array();
				$rowResult[]=$row['revista'];
				$rowResult[]=$row['revistaSlug'];
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
		$colModel[] = array(
				'editable' => false,
				'title' => _('Revista'),
				'width' => 320
			);
		$colModel[] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'revistaSlug',
				'width' => 200
			);
		$colModel[] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
			);
		$sortBy = array('pais', 'paisSlug', 'documentos');
		/*Datos pra las vistas*/
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", revistas de publicación', $institucion);
		$data['header']['gridTitle'] = _sprintf('Frecuencia de documentos por revista de publicación en la institución: <br/>%s', $institucion);
		$data['header']['colModel'] = json_encode($colModel, true);
		$data['header']['sortBy'] = json_encode($sortBy, true);
		$data['header']['sortIndx'] = array_search($order, $sortBy);
		$data['header']['args'] = pqgrid_args($args);
		$data['header']['content'] =  $this->load->view('frecuencias_header', $data['header'], TRUE);
		$data['main']['breadcrumb'] = sprintf('%s > %s > %s (Revista)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		/*Vistas*/
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_common', $data['main']);
		$this->load->view('footer');
	}

	public function institucionAutor(){
		$args = $this->uri->ruri_to_assoc();
		$data = array();
		$order = "documentos";
		$orderDir = "DESC";
		$this->load->database();
		$query = "SELECT institucion FROM \"mvFrecuenciaInstitucionAutor\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		if (isset($_POST['ajax'])):
			$this->load->database();
			/*Obtniendo el total de registros*/
			$query = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionAutor\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
			$query = $this->db->query($query);
			$query = $query->row_array();
			$data['main']['total'] = $query['total'];
			/*Filas de la tabla*/
			$sort = explode("-", $args['ordenar']);
			$order = $sort[0];
			$orderDir = strtoupper($sort[1]);
			$offset = $args['resultados'] * ($args['pagina']-1);
			$query = "SELECT * FROM \"mvFrecuenciaInstitucionAutor\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' ORDER BY {$order} {$orderDir} LIMIT {$args['resultados']} OFFSET {$offset}";
			$query = $this->db->query($query);
			$this->db->close();
			$result = array();
			$result['totalRecords']=$data['main']['total'];
			$result['curPage']=$_POST['page'];
			$result['data']=array();
			$rowNumber=1;
			foreach ($query->result_array() as $row):
				$rowResult = array();
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
		$colModel[] = array(
				'editable' => false,
				'title' => _('Autor'),
				'width' => 320
			);
		$colModel[] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'autorSlug',
				'width' => 200
			);
		$colModel[] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
			);
		$sortBy = array('autor', 'autorSlug', 'documentos');
		/*Datos pra las vistas*/
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", autor', $institucion);
		$data['header']['gridTitle'] = _sprintf('Frecuencia de documentos por autor en la institución: <br/>%s', $institucion);
		$data['header']['colModel'] = json_encode($colModel, true);
		$data['header']['sortBy'] = json_encode($sortBy, true);
		$data['header']['sortIndx'] = array_search($order, $sortBy);
		$data['header']['args'] = pqgrid_args($args);
		$data['header']['content'] =  $this->load->view('frecuencias_header', $data['header'], TRUE);
		$data['main']['breadcrumb'] = sprintf('%s > %s > %s (Autor)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		/*Vistas*/
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_common', $data['main']);
		$this->load->view('footer');
	}

}

/* End of file frecuencias.php */
/* Location: ./application/controllers/frecuencias.php */