<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frecuencias extends CI_Controller {

	public $disciplinas = array();
	public $queryFields="DISTINCT (sistema, 
					iddatabase) AS \"sitemaIdDatabase\",
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
		$this->output->enable_profiler($this->config->item('enable_profiler'));
		$this->load->database();
		$query = "SELECT id_disciplina, disciplina, slug FROM \"mvDisciplina\"";
		if ( ! $this->session->userdata('query{'.md5($query).'}')):
			$queryResult = $this->db->query($query);
			$disciplina = array();
			foreach ($queryResult->result_array() as $row):
				$disciplina['disciplina'] = $row['disciplina'];
				$disciplina['id_disciplina'] = $row['id_disciplina'];
				$disciplinas[$row['slug']] = $disciplina;
			endforeach;
			$this->session->set_userdata('query{'.md5($query).'}', json_encode($disciplinas));
		endif;
		$this->disciplinas = json_decode($this->session->userdata('query{'.md5($query).'}'), true);
		$data['disciplinas'] = $this->disciplinas;
		$this->db->close();
	}

	public function index()
	{
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias');
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias/index', $data['main']);
		$this->load->view('footer');
	}

	public function autor(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaAutorDocumentos\"";
		$args['sortBy'] = array('autor', 'autorSlug', 'coautorias','documentos');
		$args['query'] = "SELECT * FROM \"mvFrecuenciaAutorDocumentos\"";
		$args['querySlug'] = "SELECT e_100a AS unslug FROM autor WHERE slug='{$args['slug']}' LIMIT 1";
		$args['where'] = "WHERE \"autorSlug\"='{$args['slug']}'";
		$args['breadcrumbSlug'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %%s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/autor', _('Autor'), _('title="Autor"')));
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Autor'),
				'width' => 200
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'AutorSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Coautorías'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por autor');
		$data['header']['gridTitle'] = _sprintf('Frecuencia de documentos por autor');
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), _('Autor'));
		/*XML vars*/
		$args['xls']['cols'] = array( _('Autor'), _('Coautorías'), _('Documentos') );
		$args['xls']['query'] = "SELECT autor, coautorias, documentos FROM \"mvFrecuenciaAutorDocumentos\" ORDER BY documentos DESC, autor";
		$args['xls']['fileName'] = "Frecuencia-Autor.csv";
		$section = array('', '', '/coautoria', '/documento');
		$data['header']['section'] = json_encode($section, true);
		return $this->_renderFrecuency($args, $data);
	}

	public function autorDocumentos($slug){
		$args['slug'] = $slug;
		$args['query'] = "SELECT {$this->queryFields} FROM \"vAutorDocumentos\" WHERE \"autorSlug\"='{$slug}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"vAutorDocumentos\" WHERE \"autorSlug\"='{$slug}'";
		$args['paginationURL'] = site_url("frecuencias/autor/{$slug}");
		/*Datos del autor*/
		$this->load->database();
		$queryAutor = "SELECT e_100a AS autor FROM autor WHERE slug='{$slug}' LIMIT 1";
		$queryAutor = $this->db->query($queryAutor);
		$this->db->close();
		$queryAutor = $queryAutor->row_array();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/autor', _('Autor'), _('title="Autor"')), $queryAutor['autor']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $queryAutor['autor']);
		return $this->_renderDocuments($args);
	}

	public function autorCoautoria(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('autorCoautoria', 'autorCoSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Autor'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'autorCoSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaAutorCoautoria\" WHERE \"autorSlug\"='{$args['autorSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaAutorCoautoria\" WHERE \"autorSlug\"='{$args['autorSlug']}'";
		$this->load->database();
		$query = "SELECT e_100a AS autor FROM autor WHERE slug='{$args['autorSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$autor = $query['autor'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por autor "%s", coautores', $autor);
		$data['header']['gridTitle'] = _sprintf('Número de documentos por coautor del autor:<br/> %s', $autor);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Coautoría', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/autor', _('Autor'), _('title="Autor"')), $autor);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Autor'), _('Documentos'));
		$args['xls']['query'] = "SELECT autorCoautoria, documentos FROM \"mvFrecuenciaAutorCoautoria\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' ORDER BY documentos DESC, pais";
		$args['xls']['fileName'] = "Frecuencia-{$autor}-Coautorias.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function autorCoautoriaDocumentos($autor, $coautor){
		$args['slug'] = $coautor;
		$args['query'] = "SELECT {$this->queryFields} FROM \"vAutorCoautoriaDocumentos\" WHERE \"autorSlug\"='{$autor}' AND \"autorCoSlug\"='$coautor'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"vAutorCoautoriaDocumentos\" WHERE \"autorSlug\"='{$autor}' AND \"autorCoSlug\"='{$coautor}'";
		$args['paginationURL'] = site_url("frecuencias/autor/{$autor}/coautoria/{$coautor}");
		/*Datos del autor*/
		$this->load->database();
		$query = "SELECT e_100a AS autor FROM autor WHERE slug='{$autor}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$autor = array(
				'slug' => $autor,
				'autor' => $query['autor']
			);
		/*Datos del coautor*/
		$query = "SELECT e_100a AS coautor FROM autor WHERE slug='{$coautor}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$coautor = array(
				'slug' => $coautor,
				'coautor' => $query['coautor']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/autor', _('Autor'), _('title="Autor"')), anchor("frecuencias/autor/{$autor['slug']}/coautoria", _sprintf('%s/Coautoría', $autor['autor']), _("title= \"{$autor['autor']}/Coautoría\"")), $coautor['coautor']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $autor['autor']);
		return $this->_renderDocuments($args);
	}

	public function institucion(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('institucion', 'institucionSlug', 'paises', 'revistas', 'autores', 'disciplinas', 'coautorias','documentos');
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionDARP\" {$where}";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaInstitucionDARP\"";
		$args['querySlug'] = "SELECT e_100u AS unslug FROM institucion WHERE slug='{$args['slug']}' LIMIT 1";
		$args['where'] = "WHERE \"institucionSlug\"='{$args['slug']}'";
		$args['breadcrumbSlug'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %%s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')));
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Institución'),
				'width' => 200
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'institucionSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('País-Revista'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Revistas'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Autores'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Disciplinas'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Instituciones coautoras'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Institución'), _('Países'), _('Revistas'), _('Autores'), _('Disciplinas'), _('Coautoría institucional'), _('Documentos'));
		$args['xls']['query'] = "SELECT institucion, paises, revistas, autores, disciplinas, coautorias,documentos FROM \"mvFrecuenciaInstitucionDARP\" ORDER BY documentos DESC, institucion";
		$args['xls']['fileName'] = "Frecuencia-Institucion.csv";
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución');
		$data['header']['gridTitle'] = _sprintf('Número de documentos por país de publicación de la revista, título de la revista, autor y disciplina, por institución de afiliación del autor');
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), _('Institución'));
		$section = array('', '', '/pais', '/revista', '/autor', '/disciplina', '/coautoria','/documento');
		$data['header']['section'] = json_encode($section, true);
		return $this->_renderFrecuency($args, $data);
	}

	public function institucionDocumentos($slug){
		$args['slug'] = $slug;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$slug}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$slug}'";
		$args['paginationURL'] = site_url("frecuencias/institucion/{$slug}/documento");
		/*Datos de la institucion*/
		$this->load->database();
		$queryInstitucion = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$slug}' LIMIT 1";
		$queryInstitucion = $this->db->query($queryInstitucion);
		$this->db->close();
		$queryInstitucion = $queryInstitucion->row_array();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $queryInstitucion['institucion']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $queryInstitucion['institucion']);
		return $this->_renderDocuments($args);
	}

	public function institucionPais(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('pais', 'paisSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('País'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'paisSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", países de publicación', $institucion);
		$data['header']['gridTitle'] = _sprintf('Número de documentos por país de publicación de la revista de la institución:<br/> %s', $institucion);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/País', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		/*XML vars*/
		$args['xls']['cols'] = array( _('País'), _('Documentos'));
		$args['xls']['query'] = "SELECT pais, documentos FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' ORDER BY documentos DESC, pais";
		$args['xls']['fileName'] = "Frecuencia-{$institucion}-Paises.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function institucionPaisDocumentos($institucion, $pais){
		$args['slug'] = $pais;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$institucion}' AND \"paisSlug\"='$pais'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$institucion}' AND \"paisSlug\"='{$pais}'";
		$args['paginationURL'] = site_url("frecuencias/institucion/{$institucion}/pais/{$pais}");
		/*Datos de la institucion*/
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$institucion}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = array(
				'slug' => $institucion,
				'institucion' => $query['institucion']
			);
		/*Datos del país*/
		$query = "SELECT pais FROM \"mvSearch\" WHERE \"paisSlug\"='{$pais}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$pais = array(
				'slug' => $pais,
				'pais' => $query['pais']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), anchor("frecuencias/institucion/{$institucion['slug']}/pais", _sprintf('%s/País', $institucion['institucion']), _("title= \"{$institucion['institucion']}/País\"")), $pais['pais']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $institucion['institucion']);
		return $this->_renderDocuments($args);
	}

	public function institucionRevista(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('revista', 'revistaSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Revista'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'revistaSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionRevista\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaInstitucionRevista\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", revistas de publicación', $institucion);
		$data['header']['gridTitle'] = _sprintf('Número de documentos publicados por revista de la institución: <br/>%s', $institucion);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Revista', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Revista'), _('Documentos'));
		$args['xls']['query'] = "SELECT revista, documentos FROM \"mvFrecuenciaInstitucionRevista\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' ORDER BY documentos DESC, revista";
		$args['xls']['fileName'] = "Frecuencia-{$institucion}-Revistas.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function institucionRevistaDocumentos($institucion, $revista){
		$args['slug'] = $revista;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$institucion}' AND \"revistaSlug\"='$revista'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$institucion}' AND \"revistaSlug\"='{$revista}'";
		$args['paginationURL'] = site_url("frecuencias/institucion/{$institucion}/revista/{$revista}");
		/*Datos de la institucion*/
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$institucion}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = array(
				'slug' => $institucion,
				'institucion' => $query['institucion']
			);
		/*Datos del país*/
		$query = "SELECT revista FROM \"mvSearch\" WHERE \"revistaSlug\"='{$revista}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$revista = array(
				'slug' => $revista,
				'revista' => $query['revista']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), anchor("frecuencias/institucion/{$institucion['slug']}/revista", _sprintf('%s/Revista', $institucion['institucion']), _("title= \"{$institucion['institucion']}/Revista\"")), $revista['revista']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $institucion['institucion']);
		return $this->_renderDocuments($args);
	}

	public function institucionAutor(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('autor', 'autorSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Autor'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'autorSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionAutor\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaInstitucionAutor\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", autor', $institucion);
		$data['header']['gridTitle'] = _sprintf('Número de documentos publicados por autor adscritos a la institución: <br/>%s', $institucion);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Autor', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Autor'), _('Documentos'));
		$args['xls']['query'] = "SELECT autor, documentos FROM \"mvFrecuenciaInstitucionAutor\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' ORDER BY documentos DESC, autor";
		$args['xls']['fileName'] = "Frecuencia-{$institucion}-Autores.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function institucionAutorDocumentos($institucion, $autor){
		$args['slug'] = $autor;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvInstucionAutorDocumentos\" WHERE \"institucionSlug\"='{$institucion}' AND \"autorSlug\"='$autor'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvInstucionAutorDocumentos\" WHERE \"institucionSlug\"='{$institucion}' AND \"autorSlug\"='{$autor}'";
		$args['paginationURL'] = site_url("frecuencias/institucion/{$institucion}/autor/{$autor}");
		/*Datos de la institucion*/
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$institucion}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = array(
				'slug' => $institucion,
				'institucion' => $query['institucion']
			);
		/*Datos del país*/
		$query = "SELECT e_100a AS autor FROM autor WHERE slug='{$autor}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$autor = array(
				'slug' => $autor,
				'autor' => $query['autor']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), anchor("frecuencias/institucion/{$institucion['slug']}/autor", _sprintf('%s/Autor', $institucion['institucion']), _("title= \"{$institucion['institucion']}/Autor\"")), $autor['autor']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $institucion['institucion']);
		return $this->_renderDocuments($args);
	}

	public function institucionDisciplina(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('disciplina', 'disciplinaSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Disciplina'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'disciplinaSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionDisciplina\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaInstitucionDisciplina\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", disciplina', $institucion);
		$data['header']['gridTitle'] = _sprintf('Número de documentos publicados por disciplina en la institución: <br/>%s', $institucion);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Disciplina', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Disciplina'), _('Documentos'));
		$args['xls']['query'] = "SELECT disciplina, documentos FROM \"mvFrecuenciaInstitucionDisciplina\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' ORDER BY documentos DESC, autor";
		$args['xls']['fileName'] = "Frecuencia-{$institucion}-Disciplinas.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function institucionDisciplinaDocumentos($institucion, $disciplina){
		$args['slug'] = $disciplina;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$institucion}' AND \"disciplinaSlug\"='$disciplina'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$institucion}' AND \"disciplinaSlug\"='{$disciplina}'";
		$args['paginationURL'] = site_url("frecuencias/institucion/{$institucion}/disciplina/{$disciplina}");
		/*Datos de la institucion*/
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$institucion}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = array(
				'slug' => $institucion,
				'institucion' => $query['institucion']
			);
		/*Datos de la disciplina*/
		$query = "SELECT disciplina FROM disciplinas WHERE slug='{$disciplina}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$disciplina = array(
				'slug' => $disciplina,
				'disciplina' => $query['disciplina']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), anchor("frecuencias/institucion/{$institucion['slug']}/disciplina", _sprintf('%s/Disciplina', $institucion['institucion']), _("title= \"{$institucion['institucion']}/Disciplina\"")), $disciplina['disciplina']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $institucion['institucion']);
		return $this->_renderDocuments($args);
	}

	public function institucionCoautoria(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('institucionCoautoria', 'institucionCoSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Institución'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'institucionSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionCoautoria\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaInstitucionCoautoria\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", disciplina', $institucion);
		$data['header']['gridTitle'] = _sprintf('Número de documentos en coautoría en la institución: <br/>%s', $institucion);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Coautoría', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Institución'), _('Documentos'));
		$args['xls']['query'] = "SELECT \"institucionCoautoria\", documentos FROM \"mvFrecuenciaInstitucionCoautoria\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' ORDER BY documentos DESC, autor";
		$args['xls']['fileName'] = "Frecuencia-{$institucion}-Coautoria.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function institucionCoautoriaDocumentos($institucion, $coautoria){
		$args['slug'] = $coautoria;
		$args['query'] = "SELECT {$this->queryFields} FROM \"vInstucionCoautoriaDocumentos\" WHERE \"institucionSlug\"='{$institucion}' AND \"institucionCoSlug\"='$coautoria'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"vInstucionCoautoriaDocumentos\" WHERE \"institucionSlug\"='{$institucion}' AND \"institucionCoSlug\"='{$coautoria}'";
		$args['paginationURL'] = site_url("frecuencias/institucion/{$institucion}/coautoria/{$coautoria}");
		/*Datos de la institucion*/
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$institucion}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = array(
				'slug' => $institucion,
				'institucion' => $query['institucion']
			);
		/*Datos de la institucion coautoria*/
		$query = "SELECT e_100u AS coautoria FROM institucion WHERE slug='{$coautoria}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$coautoria = array(
				'slug' => $coautoria,
				'coautoria' => $query['coautoria']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), anchor("frecuencias/institucion/{$institucion['slug']}/coautoria", _sprintf('%s/Coautoría', $institucion['institucion']), _("title= \"{$institucion['institucion']}/Coautoría\"")), $coautoria['coautoria']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $institucion['institucion']);
		return $this->_renderDocuments($args);
	}

	public function paisAfiliacion(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('paisInstitucion', 'paisInstitucionSlug', 'instituciones', 'autores', 'disciplinas', 'coautorias','documentos');
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaPaisAfiliacion\" {$where}";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaPaisAfiliacion\"";
		$args['querySlug'] = $query = "SELECT e_100x AS unslug FROM institucion WHERE \"paisInstitucionSlug\"='{$args['slug']}' LIMIT 1";
		$args['where'] = "WHERE \"paisInstitucionSlug\"='{$args['slug']}'";
		$args['breadcrumbSlug'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %%s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/pais-afiliacion', _('País de afiliación'), _('title="País de afiliación del autor"')));
		/*XML vars*/
		$args['xls']['cols'] = array( _('País de afiliación'), _('Instituciones'), _('Autores'), _('Disciplinas'), _('Paises coautores'), _('Documentos') );
		$args['xls']['query'] = "SELECT \"paisInstitucion\", instituciones, autores, documentos FROM \"mvFrecuenciaPaisAfiliacion\" ORDER BY documentos DESC, \"paisInstitucion\"";
		$args['xls']['fileName'] = "Frecuencia-PaisAfiliacion.csv";
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('País de afiliación'),
				'width' => 200
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'institucionSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Instituciones'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Autores'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Disciplinas'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Paises coautores'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución');
		$data['header']['gridTitle'] = _sprintf('Número de documentos por institución, autor y disciplina por país de la institución del autor');
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s', anchor('frecuencias', _('Frecuencias'), _('title="País de afiliación del autor"')), _('País de afiliación'));
		$section = array('', '', '/institucion', '/autor', '/disciplina', '/coautoria', '/documento');
		$data['header']['section'] = json_encode($section, true);
		return $this->_renderFrecuency($args, $data);
	}

	public function paisAfiliacionDocumentos($slug){
		$args['slug'] = $slug;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvPaisAfiliacionDocumentos\" WHERE \"paisInstitucionSlug\"='{$slug}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvPaisAfiliacionDocumentos\" WHERE \"paisInstitucionSlug\"='{$slug}'";
		$args['paginationURL'] = site_url("frecuencias/pais-afiliacion/{$slug}/documento");
		/*Datos del país de afiliacion*/
		$this->load->database();
		$query = "SELECT e_100x AS \"paisInstitucion\" FROM institucion WHERE \"paisInstitucionSlug\"='{$slug}' LIMIT 1";
		$query = $this->db->query($query);
		$this->db->close();
		$query = $query->row_array();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/pais-afiliacion', _('País de afiliación'), _('title="País de afiliación del autor"')), $query['paisInstitucion']);
		$args['title'] = _sprintf('Biblat - País de afiliación: %s (%%d documentos)', $query['paisInstitucion']);
		return $this->_renderDocuments($args);
	}

	public function paisAfiliacionInstitucion(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('institucion', 'institucionSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Institución'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'institucionSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaPaisAfiliacionInstitucion\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaPaisAfiliacionInstitucion\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}'";
		$this->load->database();
		$query = "SELECT \"paisInstitucion\" FROM \"mvFrecuenciaPaisAfiliacionInstitucion\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por país de afiliación "%s", instituciones', $query['paisInstitucion']);
		$data['header']['gridTitle'] = _sprintf('Número de documentos por institución de afiliación del autor del país:<br/> %s', $query['paisInstitucion']);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Institución', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/pais-afiliacion', _('País de afiliación'), _('title="País de afiliación del autor"')), $query['paisInstitucion']);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Institución'), _('Documentos'));
		$args['xls']['query'] = "SELECT institucion, documentos FROM \"mvFrecuenciaPaisAfiliacionInstitucion\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}' ORDER BY documentos DESC, institucion";
		$args['xls']['fileName'] = "Frecuencia-{$query['paisInstitucion']}-Instituciones.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function paisAfiliacionInstitucionDocumentos($pais, $institucion){
		$args['slug'] = $institucion;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvPaisAfiliacionDocumentos\" WHERE \"paisInstitucionSlug\"='{$pais}' AND \"institucionSlug\"='{$institucion}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvPaisAfiliacionDocumentos\" WHERE \"paisInstitucionSlug\"='{$pais}' AND \"institucionSlug\"='{$institucion}'";
		$args['paginationURL'] = site_url("frecuencias/pais-afiliacion/{$pais}/institucion/{$institucion}");
		/*Datos de la institucion*/
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$institucion}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = array(
				'slug' => $institucion,
				'institucion' => $query['institucion']
			);
		/*Datos del país*/
		$query = "SELECT e_100x AS pais FROM institucion WHERE \"paisInstitucionSlug\"='{$pais}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$pais = array(
				'slug' => $pais,
				'pais' => $query['pais']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/pais-afiliacion', _('País de afiliación'), _('title="País de afiliación del autor"')), anchor("frecuencias/pais-afiliacion/{$pais['slug']}/institucion", _sprintf('%s/Institución', $pais['pais']), _("title= \"{$institucion['institucion']}/Institución\"")), $institucion['institucion']);
		$args['title'] = _sprintf('Biblat - País de afiliación: %s/%s (%%d documentos)', $pais['pais'], $institucion['institucion']);
		return $this->_renderDocuments($args);
	}

	public function paisAfiliacionAutor(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('autor', 'autorSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Autor'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'autorSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaPaisAfiliacionAutor\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaPaisAfiliacionAutor\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}'";
		$this->load->database();
		$query = "SELECT \"paisInstitucion\" FROM \"mvFrecuenciaPaisAfiliacionAutor\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias país de afiliación "%s", autores', $query['paisInstitucion']);
		$data['header']['gridTitle'] = _sprintf('Número de documentos por autor del país de institución de afiliación:<br/> %s', $query['paisInstitucion']);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Autor', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/pais-afiliacion', _('País de afiliación'), _('title="País de afiliación del autor"')), $query['paisInstitucion']);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Autor'), _('Documentos') );
		$args['xls']['query'] = "SELECT autor, documentos FROM \"mvFrecuenciaPaisAfiliacionAutor\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}' ORDER BY documentos DESC, autor";
		$args['xls']['fileName'] = "Frecuencia-{$query['paisInstitucion']}-Autores.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function paisAfiliacionAutorDocumentos($pais, $autor){
		$args['slug'] = $autor;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvPaisAfiliacionDocumentos\" WHERE \"paisInstitucionSlug\"='{$pais}' AND \"autorSlug\"='{$autor}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvPaisAfiliacionDocumentos\" WHERE \"paisInstitucionSlug\"='{$pais}' AND \"autorSlug\"='{$autor}'";
		$args['paginationURL'] = site_url("frecuencias/pais-afiliacion/{$pais}/autor/{$autor}");
		/*Datos del autor*/
		$this->load->database();
		$query = "SELECT e_100a AS autor FROM autor WHERE slug='{$autor}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$autor = array(
				'slug' => $autor,
				'autor' => $query['autor']
			);
		/*Datos del país*/
		$query = "SELECT e_100x AS pais FROM institucion WHERE \"paisInstitucionSlug\"='{$pais}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$pais = array(
				'slug' => $pais,
				'pais' => $query['pais']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/pais-afiliacion', _('País de afiliación'), _('title="País de afiliación del autor"')), anchor("frecuencias/pais-afiliacion/{$pais['slug']}/autor", _sprintf('%s/Autor', $pais['pais']), _("title= \"{$autor['autor']}/Institución\"")), $autor['autor']);
		$args['title'] = _sprintf('Biblat - País de afiliación: %s/%s (%%d documentos)', $pais['pais'], $autor['autor']);
		return $this->_renderDocuments($args);
	}

	public function paisAfiliacionDisciplina(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('disciplina', 'disciplinaSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Disciplina'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'disciplinaSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaPaisAfiliacionDisciplina\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaPaisAfiliacionDisciplina\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}'";
		$this->load->database();
		$query = "SELECT e_100x AS \"paisInstitucion\" FROM institucion WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias país de afiliación "%s", autores', $query['paisInstitucion']);
		$data['header']['gridTitle'] = _sprintf('Número de documentos por autor del país de institución de afiliación:<br/> %s', $query['paisInstitucion']);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Autor', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/pais-afiliacion', _('País de afiliación'), _('title="País de afiliación del autor"')), $query['paisInstitucion']);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Autor'), _('Documentos') );
		$args['xls']['query'] = "SELECT disciplina, documentos FROM \"mvFrecuenciaPaisAfiliacionDisciplina\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}' ORDER BY documentos DESC, autor";
		$args['xls']['fileName'] = "Frecuencia-{$query['paisInstitucion']}-Disciplinas.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function paisAfiliacionDisciplinaDocumentos($pais, $disciplina){
		$args['slug'] = $disciplina;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvPaisAfiliacionDocumentos\" WHERE \"paisInstitucionSlug\"='{$pais}' AND \"disciplinaSlug\"='{$disciplina}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvPaisAfiliacionDocumentos\" WHERE \"paisInstitucionSlug\"='{$pais}' AND \"disciplinaSlug\"='{$disciplina}'";
		$args['paginationURL'] = site_url("frecuencias/pais-afiliacion/{$pais}/disciplina/{$disciplina}");
		/*Datos de la disciplina*/
		$this->load->database();
		$query = "SELECT disciplina FROM disciplinas WHERE slug='{$disciplina}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$disciplina = array(
				'slug' => $disciplina,
				'disciplina' => $query['disciplina']
			);
		/*Datos del país*/
		$query = "SELECT e_100x AS pais FROM institucion WHERE \"paisInstitucionSlug\"='{$pais}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$pais = array(
				'slug' => $pais,
				'pais' => $query['pais']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/pais-afiliacion', _('País de afiliación'), _('title="País de afiliación del autor"')), anchor("frecuencias/pais-afiliacion/{$pais['slug']}/disciplina", _sprintf('%s/Disciplina', $pais['pais']), _("title= \"{$disciplina['disciplina']}/Disciplina\"")), $disciplina['disciplina']);
		$args['title'] = _sprintf('Biblat - País de afiliación: %s/%s (%%d documentos)', $pais['pais'], $disciplina['disciplina']);
		return $this->_renderDocuments($args);
	}

	public function paisAfiliacionCoautoria(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('paisInstitucionCoautoria', 'paisInstitucionCoSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('País coautor'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'paisInstitucionCoSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaPaisAfiliacionCoautoria\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaPaisAfiliacionCoautoria\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}'";
		$this->load->database();
		$query = "SELECT e_100x AS \"paisInstitucion\" FROM institucion WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias país de afiliación "%s", paises', $query['paisInstitucion']);
		$data['header']['gridTitle'] = _sprintf('Número de documentos en coautoría por país de institución de afiliación:<br/> %s', $query['paisInstitucion']);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Coautoría', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/pais-afiliacion', _('País de afiliación'), _('title="País de afiliación del autor"')), $query['paisInstitucion']);
		/*XML vars*/
		$args['xls']['cols'] = array( _('País coautor'), _('Documentos') );
		$args['xls']['query'] = "SELECT \"paisInstitucionCoautoria\", documentos FROM \"mvFrecuenciaPaisAfiliacionCoautoria\" WHERE \"paisInstitucionSlug\"='{$args['paisInstitucionSlug']}' ORDER BY documentos DESC, autor";
		$args['xls']['fileName'] = "Frecuencia-{$query['paisInstitucion']}-Coautoria.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function paisAfiliacionCoautoriaDocumentos($pais, $coautoria){
		$args['slug'] = $coautoria;
		$args['query'] = "SELECT {$this->queryFields} FROM \"vPaisAfiliacionDocumentosCoautoria\" WHERE \"paisInstitucionSlug\"='{$pais}' AND \"paisInstitucionCoSlug\"='{$coautoria}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"vPaisAfiliacionDocumentosCoautoria\" WHERE \"paisInstitucionSlug\"='{$pais}' AND \"paisInstitucionCoSlug\"='{$coautoria}'";
		$args['paginationURL'] = site_url("frecuencias/pais-afiliacion/{$pais}/coautoria/{$coautoria}");
		/*Datos del país coautor*/
		$this->load->database();
		$query = "SELECT e_100x AS coautoria FROM institucion WHERE \"paisInstitucionSlug\"='{$coautoria}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$coautoria = array(
				'slug' => $coautoria,
				'coautoria' => $query['coautoria']
			);
		/*Datos del país*/
		$query = "SELECT e_100x AS pais FROM institucion WHERE \"paisInstitucionSlug\"='{$pais}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$pais = array(
				'slug' => $pais,
				'pais' => $query['pais']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/pais-afiliacion', _('País de afiliación'), _('title="País de afiliación del autor"')), anchor("frecuencias/pais-afiliacion/{$pais['slug']}/coautoria", _sprintf('%s/Coautoría', $pais['pais']), _("title= \"{$coautoria['coautoria']}/Coautoría\"")), $coautoria['coautoria']);
		$args['title'] = _sprintf('Biblat - País de afiliación: %s/%s (%%d documentos)', $pais['pais'], $coautoria['coautoria']);
		return $this->_renderDocuments($args);
	}

	public function disciplina(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('disciplina', 'slug', 'instituciones', 'paises', 'revistas', 'documentos');
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaDisciplina\" {$where}";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaDisciplina\"";
		$args['querySlug'] = $query = "SELECT disciplina AS unslug FROM disciplinas WHERE slug='{$args['slug']}' LIMIT 1";
		$args['where'] = "WHERE slug='{$args['slug']}'";
		$args['breadcrumbSlug'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %%s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/disciplina', _('Disciplina'), _('title="Disciplina"')));
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Disciplina'),
				'width' => 200
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'disciplinaSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Institución'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('País-Revista'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Revistas'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Disciplina'), _('Institución'), _('Países'), _('Revistas'), _('Documentos'));
		$args['xls']['query'] = "SELECT disciplina, paises, revistas, instituciones, documentos FROM \"mvFrecuenciaDisciplina\" ORDER BY documentos DESC, disciplina";
		$args['xls']['fileName'] = "Frecuencia-Disciplina.csv";
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por disciplina');
		$data['header']['gridTitle'] = _sprintf('Número de documentos por institución de afiliación del autor, país de la revista y título de la revista, por disciplina');
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), _('Disciplina'));
		$section = array('', '', '/institucion', '/pais', '/revista', '/documento');
		$data['header']['section'] = json_encode($section, true);
		return $this->_renderFrecuency($args, $data);
	}

	public function disciplinaDocumentos($slug){
		$args['slug'] = $slug;
		$args['query'] = "SELECT {$this->queryFields} FROM \"vDisciplinaDocumentos\" WHERE \"disciplinaSlug\"='{$slug}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"vDisciplinaDocumentos\" WHERE \"disciplinaSlug\"='{$slug}'";
		$args['paginationURL'] = site_url("frecuencias/disciplina/{$slug}/documento");
		/*Datos de la disciplina*/
		$this->load->database();
		$queryDisciplina = "SELECT disciplina  FROM disciplinas WHERE slug='{$slug}' LIMIT 1";
		$queryDisciplina = $this->db->query($queryDisciplina);
		$this->db->close();
		$queryDisciplina = $queryDisciplina->row_array();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/disciplina', _('Disciplina'), _('title="Disciplina"')), $queryDisciplina['disciplina']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $queryDisciplina['disciplina']);
		return $this->_renderDocuments($args);
	}

	public function disciplinaInstitucion(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('institucion', 'institucionSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Institución'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'institucionSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaDisciplinaInstitucion\" WHERE \"disciplinaSlug\"='{$args['disciplinaSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaDisciplinaInstitucion\" WHERE \"disciplinaSlug\"='{$args['disciplinaSlug']}'";
		$this->load->database();
		$query = "SELECT disciplina FROM disciplinas WHERE slug='{$args['disciplinaSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$disciplina = $query['disciplina'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por disciplina "%s", institución de afiliación del autor', $disciplina);
		$data['header']['gridTitle'] = _sprintf('Número de documentos por institución de afiliación del autor de la disciplina:<br/> %s', $disciplina);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Institución', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/disciplina', _('Disciplina'), _('title="Disciplina"')), $disciplina);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Institución'), _('Documentos'));
		$args['xls']['query'] = "SELECT institucion, documentos FROM \"mvFrecuenciaDisciplinaInstitucion\" WHERE \"disciplinaSlug\"='{$args['disciplinaSlug']}' ORDER BY documentos DESC, institucion";
		$args['xls']['fileName'] = "Frecuencia-{$disciplina}-Instituciones.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function disciplinaInstitucionDocumentos($disciplina, $institucion){
		$args['slug'] = $institucion;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvInstucionDocumentos\" WHERE \"disciplinaSlug\"='{$disciplina}' AND \"institucionSlug\"='$institucion'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvInstucionDocumentos\" WHERE \"disciplinaSlug\"='{$disciplina}' AND \"institucionSlug\"='{$institucion}'";
		$args['paginationURL'] = site_url("frecuencias/disciplina/{$disciplina}/institucion/{$institucion}");
		/*Datos de la disciplina*/
		$this->load->database();
		$query = "SELECT disciplina FROM disciplinas WHERE slug='{$disciplina}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$disciplina = array(
				'slug' => $disciplina,
				'disciplina' => $query['disciplina']
			);
		/*Datos de la institución*/
		$query = "SELECT \"institucionSlug\" FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"LIKE'{$institucion}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = array(
				'slug' => $institucion,
				'institucion' => $query['institucion']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/disciplina', _('Disciplina'), _('title="Disciplina"')), anchor("frecuencias/disciplina/{$disciplina['slug']}/institucion", _sprintf('%s/País', $disciplina['disciplina']), _("title= \"{$disciplina['disciplina']}/Institución\"")), $institucion['institucion']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $disciplina['disciplina']);
		return $this->_renderDocuments($args);
	}

	public function disciplinaPais(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('pais', 'paisSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('País-Revista'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'paisSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaDisciplinaPais\" WHERE \"disciplinaSlug\"='{$args['disciplinaSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaDisciplinaPais\" WHERE \"disciplinaSlug\"='{$args['disciplinaSlug']}'";
		$this->load->database();
		$query = "SELECT disciplina FROM disciplinas WHERE slug='{$args['disciplinaSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$disciplina = $query['disciplina'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por disciplina "%s", países de publicación de la revista', $disciplina);
		$data['header']['gridTitle'] = _sprintf('Número de documentos por país de la revista de la disciplina:<br/> %s', $disciplina);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/País', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/disciplina', _('Disciplina'), _('title="Disciplina"')), $disciplina);
		/*XML vars*/
		$args['xls']['cols'] = array( _('País'), _('Documentos'));
		$args['xls']['query'] = "SELECT pais, documentos FROM \"mvFrecuenciaDisciplinaPais\" WHERE \"disciplinaSlug\"='{$args['disciplinaSlug']}' ORDER BY documentos DESC, pais";
		$args['xls']['fileName'] = "Frecuencia-{$disciplina}-Paises.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function disciplinaPaisDocumentos($disciplina, $pais){
		$args['slug'] = $pais;
		$args['query'] = "SELECT {$this->queryFields} FROM \"vDisciplinaDocumentos\" WHERE \"disciplinaSlug\"='{$disciplina}' AND \"paisSlug\"='$pais'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"vDisciplinaDocumentos\" WHERE \"disciplinaSlug\"='{$disciplina}' AND \"paisSlug\"='{$pais}'";
		$args['paginationURL'] = site_url("frecuencias/disciplina/{$disciplina}/pais/{$pais}");
		/*Datos de la disciplina*/
		$this->load->database();
		$query = "SELECT disciplina FROM disciplinas WHERE slug='{$disciplina}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$disciplina = array(
				'slug' => $disciplina,
				'disciplina' => $query['disciplina']
			);
		/*Datos del país*/
		$query = "SELECT pais FROM \"mvSearch\" WHERE \"paisSlug\"='{$pais}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$pais = array(
				'slug' => $pais,
				'pais' => $query['pais']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/disciplina', _('Disciplina'), _('title="Disciplina"')), anchor("frecuencias/disciplina/{$disciplina['slug']}/pais", _sprintf('%s/País', $disciplina['disciplina']), _("title= \"{$disciplina['disciplina']}/País\"")), $pais['pais']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $disciplina['disciplina']);
		return $this->_renderDocuments($args);
	}

	public function disciplinaRevista(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('revista', 'revistaSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Revista'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'revistaSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaDisciplinaRevista\" WHERE \"disciplinaSlug\"='{$args['disciplinaSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaDisciplinaRevista\" WHERE \"disciplinaSlug\"='{$args['disciplinaSlug']}'";
		$this->load->database();
		$query = "SELECT disciplina FROM disciplinas WHERE slug='{$args['disciplinaSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$disciplina = $query['disciplina'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por disciplina "%s", revistas de publicación', $disciplina);
		$data['header']['gridTitle'] = _sprintf('Número de documentos publicados por revista de la disciplina: <br/>%s', $disciplina);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Revista', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/disciplina', _('Disciplina'), _('title="Disciplina"')), $disciplina);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Revista'), _('Documentos'));
		$args['xls']['query'] = "SELECT revista, documentos FROM \"mvFrecuenciaDisciplinaRevista\" WHERE \"disciplinaSlug\"='{$args['disciplinaSlug']}' ORDER BY documentos DESC, revista";
		$args['xls']['fileName'] = "Frecuencia-{$disciplina}-Revistas.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function disciplinaRevistaDocumentos($disciplina, $revista){
		$args['slug'] = $revista;
		$args['query'] = "SELECT {$this->queryFields} FROM \"vDisciplinaDocumentos\" WHERE \"disciplinaSlug\"='{$disciplina}' AND \"revistaSlug\"='$revista'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"vDisciplinaDocumentos\" WHERE \"disciplinaSlug\"='{$disciplina}' AND \"revistaSlug\"='{$revista}'";
		$args['paginationURL'] = site_url("frecuencias/disciplina/{$disciplina}/revista/{$revista}");
		/*Datos de la disciplina*/
		$this->load->database();
		$query = "SELECT disciplina FROM disciplinas WHERE slug='{$disciplina}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$disciplina = array(
				'slug' => $disciplina,
				'disciplina' => $query['disciplina']
			);
		/*Datos de la revista*/
		$query = "SELECT revista FROM \"mvSearch\" WHERE \"revistaSlug\"='{$revista}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$revista = array(
				'slug' => $revista,
				'revista' => $query['revista']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/disciplina', _('Disciplina'), _('title="Disciplina"')), anchor("frecuencias/disciplina/{$disciplina['slug']}/revista", _sprintf('%s/Revista', $disciplina['disciplina']), _("title= \"{$disciplina['disciplina']}/Revista\"")), $revista['revista']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $disciplina['disciplina']);
		return $this->_renderDocuments($args);
	}
	
	private function _renderFrecuency($args, $data){
		if ($args['export'] == "excel"):
			$args['xls']['queryTotal'] = $args['queryTotal'];
			return $this->_excel($args['xls']);
		endif;
		$where = "";
		if(isset($args['slug'])):
			$this->load->database();
			$query = $this->db->query($args['querySlug']);
			$query = $query->row_array();
			$this->db->close();
			$where = $args['where'];
			$data['main']['breadcrumb'] = sprintf($args['breadcrumbSlug'], $query['unslug']);
		endif;
		if (isset($_POST['ajax'])):
			$this->load->database();
			/*Obtniendo el total de registros*/
			$query = $this->db->query($args['queryTotal']);
			$query = $query->row_array();
			$data['main']['total'] = $query['total'];
			/*Filas de la tabla*/
			$sort = explode("-", $args['ordenar']);
			$order = $sort[0];
			$orderDir = strtoupper($sort[1]);
			$offset = $args['resultados'] * ($args['pagina']-1);
			$query = "{$args['query']} {$where} ORDER BY \"{$order}\" {$orderDir} LIMIT {$args['resultados']} OFFSET {$offset}";
			$query = $this->db->query($query);
			$result = array();
			$result['totalRecords']=$data['main']['total'];
			$result['curPage']=$_POST['page'];
			$result['data']=array();
			$rowNumber=1;
			foreach ($query->result_array() as $row):
				$rowResult = array();
				foreach ($args['sortBy'] as $col):
					$rowResult[]=$row[$col];
				endforeach;
				$result['data'][]=$rowResult;
				$rowNumber++;
			endforeach;
			$query->free_result();
			$this->db->close();
			$this->output->enable_profiler(false);
			header('Content-Type: application/json');
			echo json_encode($result, true);
			return 0;
		endif;
		/*Vistas*/
		$data['header']['colModel'] = json_encode($args['cols'], true);
		$data['header']['sortBy'] = json_encode($args['sortBy'], true);
		$data['header']['sortDir'] = $args['orderDir'];
		$data['header']['sortIndx'] = array_search($args['defaultOrder'], $args['sortBy']);
		$data['header']['args'] = pqgrid_args($args);
		$data['header']['content'] =  $this->load->view('frecuencias/header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias/common', $data['main']);
		$this->load->view('footer');
	}

	public function revista(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('revista', 'revistaSlug', 'autores', 'instituciones', 'anios','documentos');
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaRevista\" {$where}";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaRevista\"";
		$args['querySlug'] = "SELECT revista AS unslug FROM \"mvFrecuenciaRevista\" WHERE \"revistaSlug\"='{$args['slug']}' LIMIT 1";
		$args['where'] = "WHERE \"revistaSlug\"='{$args['slug']}'";
		$args['breadcrumbSlug'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %%s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/revista', _('Revista'), _('title="Institución"')));
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Revista'),
				'width' => 200
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'revistaSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Autores'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Instituciones'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Años'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por revista');
		$data['header']['gridTitle'] = _sprintf('Número de documentos publicados por revista y autor');
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), _('Revista'));
		$section = array('', '', '/autor', '/institucion', '/anio', '/documento');
		$data['header']['section'] = json_encode($section, true);
		/*XML vars*/
		$args['xls']['cols'] = array( _('Revista'), _('Autores'), _('Instituciones'), _('Años'), _('Documentos') );
		$args['xls']['query'] = "SELECT revista, autores, instituciones, anios, documentos FROM \"mvFrecuenciaRevista\" ORDER BY documentos DESC, revista";
		$args['xls']['fileName'] = "Frecuencia-Revista.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function revistaDocumentos($slug){
		$args['slug'] = $slug;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvRevistaDocumentos\" WHERE \"revistaSlug\"='{$slug}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvRevistaDocumentos\" WHERE \"revistaSlug\"='{$slug}'";
		$args['paginationURL'] = site_url("frecuencias/revista/{$slug}/documento");
		/*Datos del país de afiliacion*/
		$this->load->database();
		$query = "SELECT revista FROM \"mvSearch\" WHERE \"revistaSlug\"='{$slug}' LIMIT 1";
		$query = $this->db->query($query);
		$this->db->close();
		$query = $query->row_array();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/revista', _('Revista'), _('title="Revista"')), $query['revista']);
		$args['title'] = _sprintf('Biblat - Revista: %s (%%d documentos)', $query['revista']);
		return $this->_renderDocuments($args);
	}

	public function revistaAutor(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('autor', 'autorSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Autor'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'autorSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaRevistaAutor\" WHERE \"revistaSlug\"='{$args['revistaSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaRevistaAutor\" WHERE \"revistaSlug\"='{$args['revistaSlug']}'";
		$this->load->database();
		$query = "SELECT revista FROM \"mvSearch\" WHERE \"revistaSlug\"='{$args['revistaSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por revista: %s, autores', $query['revista']);
		$data['header']['gridTitle'] = _sprintf('Número de documentos publicados por autor en la revista:<br/> %s', $query['revista']);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Autor', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/revista', _('Revista'), _('title="Revista"')), $query['revista']);
		/*XML vars*/
		$args['xls']['cols'] = array( ('Autor'), _('Documentos') );
		$args['xls']['query'] = "SELECT autor, documentos FROM \"mvFrecuenciaRevistaAutor\" WHERE \"revistaSlug\"='{$args['revistaSlug']}' ORDER BY documentos DESC, autor";
		$args['xls']['fileName'] = "Frecuencia-{$query['revista']}-Autores.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function revistaAutorDocumentos($revista, $autor){
		$args['slug'] = $autor;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvRevistaDocumentos\" WHERE \"revistaSlug\"='{$revista}' AND \"autorSlug\"='$autor'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvRevistaDocumentos\" WHERE \"revistaSlug\"='{$revista}' AND \"autorSlug\"='{$autor}'";
		$args['paginationURL'] = site_url("frecuencias/revista/{$revista}/autor/{$autor}");
		/*Datos de la revista*/
		$this->load->database();
		$query = "SELECT revista FROM \"mvSearch\" WHERE \"revistaSlug\"='{$revista}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$revista = array(
				'slug' => $revista,
				'revista' => $query['revista']
			);
		/*Datos del autor*/
		$query = "SELECT e_100a AS autor FROM autor WHERE slug='{$autor}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$autor = array(
				'slug' => $autor,
				'autor' => $query['autor']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/revista', _('Revista'), _('title="Revista"')), anchor("frecuencias/revista/{$revista['slug']}/autor", _sprintf('%s/Autor', $revista['revista']), _("title= \"{$revista['revista']}/Autor\"")), $autor['autor']);
		$args['title'] = _sprintf('Biblat - Revista: %s/%s (%%d documentos)', $revista['revista'], $autor['autor']);
		return $this->_renderDocuments($args);
	}	

	public function revistaAnio(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "anio";
		$args['orderDir'] = "ASC";
		$args['sortBy'] = array('anio', 'anio', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Año'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'anio',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaRevistaAnio\" WHERE \"revistaSlug\"='{$args['revistaSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaRevistaAnio\" WHERE \"revistaSlug\"='{$args['revistaSlug']}'";
		$this->load->database();
		$query = "SELECT revista FROM \"mvSearch\" WHERE \"revistaSlug\"='{$args['revistaSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por revista: %s, autores', $query['revista']);
		$data['header']['gridTitle'] = _sprintf('Número de documentos publicados por autor en la revista:<br/> %s', $query['revista']);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Autor', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/revista', _('Revista'), _('title="Revista"')), $query['revista']);
		/*XML vars*/
		$args['xls']['cols'] = array( ('Autor'), _('Documentos') );
		$args['xls']['query'] = "SELECT autor, documentos FROM \"mvFrecuenciaRevistaAutor\" WHERE \"revistaSlug\"='{$args['revistaSlug']}' ORDER BY documentos DESC, autor";
		$args['xls']['fileName'] = "Frecuencia-{$query['revista']}-Años.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function revistaAnioDocumentos($revista, $anio){
		$args['slug'] = $anio;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvRevistaDocumentos\" WHERE \"revistaSlug\"='{$revista}' AND anio='$anio'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvRevistaDocumentos\" WHERE \"revistaSlug\"='{$revista}' AND anio='{$anio}'";
		$args['paginationURL'] = site_url("frecuencias/revista/{$revista}/anio/{$anio}");
		$args['firstPageNumber'] = TRUE;
		/*Datos de la revista*/
		$this->load->database();
		$query = "SELECT revista FROM \"mvSearch\" WHERE \"revistaSlug\"='{$revista}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$revista = array(
				'slug' => $revista,
				'revista' => $query['revista']
			);
		/*Datos del año*/
		$anio = array(
				'slug' => $anio,
				'anio' => $anio
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/revista', _('Revista'), _('title="Revista"')), anchor("frecuencias/revista/{$revista['slug']}/anio", _sprintf('%s/Año', $revista['revista']), _("title= \"{$revista['revista']}/Año\"")), $anio['anio']);
		$args['title'] = _sprintf('Biblat - Revista: %s/%s (%%d documentos)', $revista['revista'], $anio['anio']);
		return $this->_renderDocuments($args);
	}

	public function revistaInstitucion(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('institucion', 'institucionSlug', 'documentos');
		/*Columnas de la tabla*/
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Institución'),
				'width' => 320
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => 'institucionSlug',
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
				'className' => 'pq-link'
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaRevistaInstitucion\" WHERE \"revistaSlug\"='{$args['revistaSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaRevistaInstitucion\" WHERE \"revistaSlug\"='{$args['revistaSlug']}'";
		$this->load->database();
		$query = "SELECT revista FROM \"mvSearch\" WHERE \"revistaSlug\"='{$args['revistaSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por revista: %s, autores', $query['revista']);
		$data['header']['gridTitle'] = _sprintf('Número de documentos publicados por autor en la revista:<br/> %s', $query['revista']);
		$data['main']['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s/Autor', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/revista', _('Revista'), _('title="Revista"')), $query['revista']);
		/*XML vars*/
		$args['xls']['cols'] = array( ('Autor'), _('Documentos') );
		$args['xls']['query'] = "SELECT autor, documentos FROM \"mvFrecuenciaRevistaAutor\" WHERE \"revistaSlug\"='{$args['revistaSlug']}' ORDER BY documentos DESC, autor";
		$args['xls']['fileName'] = "Frecuencia-{$query['revista']}-Instituciones.csv";
		return $this->_renderFrecuency($args, $data);
	}

	public function revistaInstitucionDocumentos($revista, $institucion){
		$args['slug'] = $institucion;
		$args['query'] = "SELECT {$this->queryFields} FROM \"mvRevistaDocumentos\" WHERE \"revistaSlug\"='{$revista}' AND \"institucionSlug\"='$institucion'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvRevistaDocumentos\" WHERE \"revistaSlug\"='{$revista}' AND \"institucionSlug\"='{$institucion}'";
		$args['paginationURL'] = site_url("frecuencias/revista/{$revista}/institucion/{$institucion}");
		/*Datos de la revista*/
		$this->load->database();
		$query = "SELECT revista FROM \"mvSearch\" WHERE \"revistaSlug\"='{$revista}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$revista = array(
				'slug' => $revista,
				'revista' => $query['revista']
			);
		/*Datos de la institucion*/
		$this->load->database();
		$query = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$institucion}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = array(
				'slug' => $institucion,
				'institucion' => $query['institucion']
			);
		$this->db->close();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/revista', _('Revista'), _('title="Revista"')), anchor("frecuencias/revista/{$revista['slug']}/institucion", _sprintf('%s/Institución', $revista['revista']), _("title= \"{$revista['revista']}/Institución\"")), $institucion['institucion']);
		$args['title'] = _sprintf('Biblat - Revista: %s/%s (%%d documentos)', $revista['revista'], $institucion['institucion']);
		return $this->_renderDocuments($args);
	}

	private function _renderDocuments($args){
		/*Obtniendo los registros con paginación*/
		$query = "{$args['query']} ORDER BY anio DESC, volumen DESC, numero DESC, articulo";
		if($args['firstPageNumber']):
			$articulosResultado = articulosResultado($query, $args['queryCount'], $args['paginationURL'], $resultados=20, FALSE, TRUE);
		else:
			$articulosResultado = articulosResultado($query, $args['queryCount'], $args['paginationURL'], $resultados=20);
		endif;
		/*Vistas*/
		$data = array();
		$data['main']['links'] = $articulosResultado['links'];
		$data['main']['resultados']=$articulosResultado['articulos'];
		$data['header']['title'] = sprintf($args['title'], $articulosResultado['totalRows']);
		$data['header']['slugHighLight']=slugHighLight($args['slug']);
		$data['header']['content'] =  $this->load->view('buscar/header', $data['header'], TRUE);
		$data['main']['breadcrumb'] = sprintf($args['breadcrumb'], $articulosResultado['totalRows']);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias/documentos', $data['main']);
		$this->load->view('footer');
	}
	private function _excel($xls){
		@set_time_limit(3000);
		//phpinfo(); die();
		$this->load->library('excel');
		$this->load->database();
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize' => '128MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		/*Sheets*/
		$query = $this->db->query($xls['queryTotal']);
		$query = $query->row_array();
		//$sheetLimit = 65535;
		$sheetLimit = 1048576;
		$sheets = ceil($query['total'] / $sheetLimit);
		for ($i=0; $i < $sheets; $i++) :
			$this->excel->setActiveSheetIndex($i);
			$data = array();
			$data[] = $xls['cols'];
			$offset = $i * $sheetLimit;
			$query = $this->db->query("{$xls['query']} LIMIT {$sheetLimit} OFFSET {$offset}");
			header('Content-Type: application/vnd.ms-excel; charset=utf-8');
			header('Content-Disposition: attachment;filename="'.$xls['fileName'].'"'); 
			header('Cache-Control: max-age=0');
			$colsTotal=1;
			foreach ($xls['cols'] as $col):
				if(preg_match("/\s/", $col)):
					echo "\"{$col}\"";
				else:
					echo $col;
				endif;
				if($colsTotal < count($xls['cols'])):
					echo ", ";
				else:
					echo ", \n";
				endif;
				$colsTotal++;
			endforeach;
			foreach ($query->result_array() as $row):
				$colsTotal=1;
				foreach ($row as $col):
					if(preg_match("/\s/", $col)):
						echo "\"{$col}\"";
					else:
						echo $col;
					endif;
					if($colsTotal < count($xls['cols'])):
						echo ", ";
					else:
						echo ", \n";
					endif;
					$colsTotal++;
				endforeach;	
			endforeach;
			$query->free_result();
			exit();
			/*$this->excel->getActiveSheet()->fromArray(
				$data,	// The data to set
				NULL,		// Array values with this value will not be set
				'A1'		// Top left coordinate of the worksheet range where
							// 	we want to set these values (default is A1)
			);
			unset($data);*/
			if($i < ($sheets - 1)):
				$this->excel->createSheet();
			endif;
		endfor;
		/*Ontenido datos*/
		
		//$this->excel->getActiveSheet()->setTitle($xls['sheetTitle']);

		$this->db->close();

		//print_r($data); die();
		
		 
		//header('Content-Type: application/vnd.ms-excel'); //mime type
		//header('Content-Disposition: attachment;filename="'.$xls['fileName'].'"'); //tell browser what's the file name
		//header('Cache-Control: max-age=0'); //no cache
		             
		$objWriter = new PHPExcel_Writer_Excel2007($this->excel); 
		 $objWriter->setOffice2003Compatibility(true);
		//$objWriter->save('php://output');
		$objWriter->save("/tmp/{$xls['fileTitle']}");
		/*if(file_exists("/tmp/{$xls['fileTitle']}")):
			//header('Content-Type: application/vnd.ms-excel');
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$xls['fileName'].'x"'); 
			header('Cache-Control: max-age=0');
			readfile("/tmp/{$xls['fileTitle']}");
			exit();
		endif;*/
	}

	public function test(){
		$this->load->database();
		$query="SELECT s.* FROM 
 (SELECT DISTINCT ON(sistema, iddatabase) sistema, iddatabase FROM \"mvPaisAfiliacionDocumentos\" WHERE \"paisInstitucionSlug\"='republica-dominicana') t
 INNER JOIN \"mvSearch\" s on t.sistema=s.sistema AND t.iddatabase=s.iddatabase";
 		$query = $this->db->query($query);

 		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment;filename="republica-dominicana.csv"'); 
		header('Cache-Control: max-age=0');
		echo '"articulo", "revista", "pais", "issn", "idioma", "anio", "volumen", "numero", "periodo", "paginacion", "url", "tipoDocumento", "enfoqueDocumento", "autores", "instituciones", "disciplinas", "palabrasClave"';
		echo "\n";
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
			$autores="";
			$autorOffset=1;
			foreach($row['autores'] as $key => $value):
				$autores .= "{$value} ({$row['autoresInstitucionSec'][$key]})";
				if($autorOffset < count($row['autores'])):
					$autores .= "; ";
 				endif;
				$autorOffset++;
			endforeach;
			$instituciones="";
			$institucionOffset=1;
			foreach($row['instituciones'] as $key => $value):
				$instituciones .= "({$key}) {$value}";
				if($institucionOffset < count($row['instituciones'])):
					$instituciones .= "; ";
 				endif;
				$institucionOffset++;
			endforeach;
			$row['disciplinas'] = json_decode($row['disciplinasJSON']);
			$disciplinas="";
			$disciplinaOffset=1;
			foreach ($row['disciplinas'] as $disciplina):
				$disciplinas .= "{$disciplina}";
				if($disciplinaOffset < count($row['disciplinas'])):
					$disciplinas .= "; ";
 				endif;
				$disciplinaOffset++;
			endforeach;
			$row['palabrasClave'] = json_decode($row['palabrasClaveJSON']);
			$palabrasClave="";
			$palabraClaveOffset=1;
			foreach ($row['palabrasClave'] as $palabraClave):
				$palabrasClave .= "{$palabraClave}";
				if($palabraClaveOffset < count($row['palabrasClave'])):
					$palabrasClave .= "; ";
 				endif;
				$palabraClaveOffset++;
			endforeach;
			$result = "\"{$row['articulo']}\", \"{$row['revista']}\", \"{$row['pais']}\", \"{$row['issn']}\", \"{$row['idioma']}\", \"{$row['anio']}\", \"{$row['volumen']}\", \"{$row['numero']}\", \"{$row['periodo']}\", \"{$row['paginacion']}\", \"{$row['url']}\", \"{$row['tipoDocumento']}\", \"{$row['enfoqueDocumento']}\", \"{$autores}\", \"{$instituciones}\", \"{$disciplinas}\", \"{$palabrasClave}\"\n";
 			echo $result; 
 		endforeach;
	}

}

/* End of file frecuencias.php */
/* Location: ./application/controllers/frecuencias.php */