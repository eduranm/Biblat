<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Revista extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}

	public function index($revistaSlug){
		$data = array();
		/*Obteniendo articulos de la revista*/
		$queryFields="SELECT 
					DISTINCT (sistema, 
					iddatabase) as \"sitemaIdDatabase\", 
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
		$queryFrom = "FROM \"mvSearch\" WHERE \"revistaSlug\"='{$revistaSlug}'";
		$query = "{$queryFields} 
				{$queryFrom} 
				ORDER BY anio DESC, volumen DESC, numero DESC, articulo";
		
		$queryCount = "SELECT count (DISTINCT (sistema, 
					iddatabase)) as total {$queryFrom}";
		
		/*Paginación y resultados*/
		$paginationURL = site_url("/revista/{$revistaSlug}");
		$perPage = 20;
		$articulosResultado = articulosResultado($query, $queryCount, $paginationURL, $perPage);
		/*Resultados de la página*/
		$data['main']['links'] = $articulosResultado['links'];
		$data['main']['search']['total'] = $articulosResultado['totalRows'];
		$data['main']['resultados'] = $articulosResultado['articulos'];
		$data['main']['revista'] = current($articulosResultado['articulos']);
		$data['main']['revista'] = $data['main']['revista']['revista'];
		/*Vistas*/
		$data['header']['content'] =  $this->load->view('buscar/header', $data['header'], TRUE);
		$data['header']['title'] = _sprintf('Biblat - Revista: %s', $data['main']['revista']);
		$breadcrumb = sprintf('%s > %s (%%d documentos)', anchor('revista', _('Revistas'), _('title="Revistas"')), $data['main']['revista']);
		$data['main']['breadcrumb'] = sprintf($breadcrumb, $articulosResultado['totalRows']);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('revista/index', $data['main']);
		$this->load->view('footer');
	}

	public function articulo($revista='', $articulo='', $mail=''){
		$uriVar = $this->uri->ruri_to_assoc();
		if($mail == 'true'):
			$uriVar['revista'] = $revista;
			$uriVar['articulo'] = $articulo;
			$uriVar['mail'] = $mail;
		endif;

		/*Consultas*/
		$this->load->database();
		$query = "SELECT 
				s.sistema, 
				s.iddatabase, 
				s.articulo, 
				s.\"articuloSlug\",
				s.revista, 
				s.\"revistaSlug\", 
				s.issn, 
				s.anio, 
				s.volumen, 
				s.numero, 
				s.periodo, 
				s.paginacion, 
				s.pais, 
				s.idioma, 
				s.\"tipoDocumento\", 
				s.\"enfoqueDocumento\", 
				s.\"autoresSecJSON\", 
				s.\"autoresSecInstitucionJSON\", 
				s.\"autoresJSON\", 
				s.\"institucionesSecJSON\", 
				s.\"institucionesJSON\", 
				s.\"idDisciplinasJSON\", 
				s.\"disciplinasJSON\", 
				s.\"palabrasClaveJSON\",
				s.url
			FROM \"mvSearch\" s
			WHERE \"revistaSlug\"='{$uriVar['revista']}' AND \"articuloSlug\"='{$uriVar['articulo']}'";
		$query = $this->db->query($query);
		$articulo = $query->row_array();
		$query->free_result();
		$this->db->close();
		/*Ordenando los datos del articulo*/
		/*Generando arreglo de autores*/
		if($articulo['autoresSecJSON'] != NULL && $articulo['autoresJSON'] != NULL):
			$articulo['autores'] = array_combine(json_decode($articulo['autoresSecJSON']), json_decode($articulo['autoresJSON']));
		endif;
		/*Generando arreglo institucion de autores*/
		if($articulo['autoresSecJSON'] != NULL && $articulo['autoresSecInstitucionJSON'] != NULL):
			$articulo['autoresInstitucionSec'] = array_combine(json_decode($articulo['autoresSecJSON']), json_decode($articulo['autoresSecInstitucionJSON']));
		endif;
		unset($articulo['autoresSecJSON'], $articulo['autoresJSON'], $articulo['autoresSecInstitucionJSON']);
		/*Generando arreglo de instituciones*/
		if($articulo['institucionesSecJSON'] != NULL && $articulo['institucionesJSON'] != NULL):
			$articulo['instituciones'] = array_combine(json_decode($articulo['institucionesSecJSON']), json_decode($articulo['institucionesJSON']));
		endif;
		unset($articulo['institucionesSecJSON'], $articulo['institucionesJSON']);
		/*Generando disciplinas*/
		if($articulo['idDisciplinasJSON'] != NULL && $articulo['disciplinasJSON'] != NULL):
			$articulo['disciplinas'] = array_combine(json_decode($articulo['idDisciplinasJSON']), json_decode($articulo['disciplinasJSON']));
		endif;
		unset($articulo['idDisciplinasJSON'], $articulo['disciplinasJSON']);
		/*Generando palabras clave*/
		if($articulo['palabrasClaveJSON'] != NULL):
			$articulo['palabrasClave'] = json_decode($articulo['palabrasClaveJSON']);
		endif;
		unset($articulo['palabrasClaveJSON']);
		/*Limpiando caracteres html*/
		$articulo = htmlspecialchars_deep($articulo);
		/*Creando lista de autores en html*/
		$articulo['autoresHTML'] = "";
		if(isset($articulo['autores'])):
			$totalAutores = count($articulo['autores']);
			$indexAutor = 1;
			foreach ($articulo['autores'] as $key => $autor):
				$articulo['autoresHTML'] .= "{$autor}";
				if ( isset($articulo['instituciones'][$articulo['autoresInstitucionSec'][$key]]) ):
					$articulo['autoresHTML'] .= "<sup>{$articulo['autoresInstitucionSec'][$key]}</sup>";
				endif;
				if($indexAutor < $totalAutores):
					$articulo['autoresHTML'] .= "<br/>";
				endif;
				$indexAutor++;
			endforeach;
		endif;
		/*Creando lista de instituciones html*/
		$articulo['institucionesHTML'] = "";
		if(isset($articulo['instituciones'])):
			$totalInstituciones = count($articulo['instituciones']);
			$indexInstitucion = 1;
			foreach ($articulo['instituciones'] as $key => $institucion):
				$articulo['institucionesHTML'] .= "<sup>{$key}</sup>{$institucion}";
				if($indexInstitucion < $totalInstituciones):
					$articulo['institucionesHTML'] .= "<br/>";
				endif;
				$indexInstitucion++;
			endforeach;
		endif;

		/*Creando disciplinas HTML*/
		$articulo['disciplinasHTML'] = "";
		if(isset($articulo['disciplinas'])):
			$totalDisciplinas = count($articulo['disciplinas']);
			$indexDisciplina = 1;
			foreach ($articulo['disciplinas'] as $key => $disciplina):
				$articulo['disciplinasHTML'] .= "{$disciplina}";
				if($indexDisciplina < $totalDisciplinas):
					$articulo['disciplinasHTML'] .= ",<br/>";
				endif;
				$indexDisciplina++;
			endforeach;
		endif;

		/*Creando palabras clave HTML*/
		$articulo['palabrasClaveHTML'] = "";
		if(isset($articulo['palabrasClave'])):
			$totalPalabrasClave = count($articulo['palabrasClave']);
			$indexPalabraClave = 1;
			foreach ($articulo['palabrasClave'] as $key => $palabraClave):
				$articulo['palabrasClaveHTML'] .= "{$palabraClave}";
				if($indexPalabraClave < $totalPalabrasClave):
					$articulo['palabrasClaveHTML'] .= ",<br/>";
				endif;
				$indexPalabraClave++;
			endforeach;
		endif;

		if (isset($articulo['paginacion'])):
			$articulo['paginacionFirst'] = preg_replace("/[-\s]+/", "", preg_replace('/(^\s*\d+\s*?-|^\s*\d+?\s*$).*/m', '\1', $articulo['paginacion']));
			$articulo['paginacionLast'] = preg_replace("/[-\s]+/", "", preg_replace('/.*(-\s*\d+\s*?$|^\s*\d+?\s*$).*/m', '\1', $articulo['paginacion']));
		endif;

		$database[0] = "CLASE";
		$database[1] = "PERIODICA";

		$articulo['database'] = $database[$articulo['iddatabase']];

		$articulo = remove_empty($articulo);

		$data['main']['articulo'] = $articulo;
		$data['header']['articulo'] = $data['main']['articulo'];
		$data['header']['title'] = _sprintf('Biblat - Revista: %s - Artículo: %s', $articulo['revista'], $articulo['articulo']);
		$data['main']['title'] = $data['header']['title'];
		$data['main']['mail'] = FALSE;
		/*Vistas*/
		if(isset($_POST['ajax'])):
			$this->output->enable_profiler(FALSE);
			$this->load->view('revista/articulo', $data['main']);
			return;
		endif;
		if($uriVar['mail'] == "true"):
			$this->output->enable_profiler(FALSE);
			$data['main']['mail'] = TRUE;
			return $this->load->view('revista/articulo', $data['main'], TRUE);
		endif;
		$data['header']['content'] =  $this->load->view('revista/articulo_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$data['main']['content'] = $this->load->view('revista/articulo', $data['header'], TRUE);
		$this->load->view('revista/articulo_content', $data['main']);
		$this->load->view('footer');
	}

	public function solicitudDocumento(){
		$this->output->enable_profiler(false);
		$config['mailtype'] = 'html';
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('solicitud@biblat.unam.mx', 'Solicitud Biblat');
		//$this->email->to('sinfo@dgb.unam.mx');
		$this->email->to('achwazer@gmail.com');
		//$this->email->cc('anoguez@dgb.unam.mx');
		$this->email->subject('Solicitud de documento Biblat');
		$data = $_POST;
		$data['fichaDocumento'] = $this->articulo($data['revista'], $data['articulo'], 'true');
		$body = $this->load->view('revista/mail_solicitud', $data, TRUE);
		$this->email->message($body);

		$this->email->send();
		$this->email->clear();
		$this->email->from('anoguez@dgb.unam.mx', 'Mtra. Araceli Noguez O.');
		$this->email->to($_POST['email']);
		$this->email->subject('Solicitud de documento Biblat');
		$body = $this->load->view('revista/mail_solicitud_usuario', $data, TRUE);
		$this->email->message($body);

		$this->email->send();
		//echo json_encode($_POST);
	}
}