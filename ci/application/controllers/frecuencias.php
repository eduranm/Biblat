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
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaAutorDocumentos\"";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaAutorDocumentos\"";
		$args['cols'][] = array(
				'editable' => false,
				'title' => _('Autor'),
				'width' => 200
			);
		$args['cols'][] = array(
				'editable' => false,
				'hidden' => true,
				'title' => _('AutorSlug'),
				'width' => 200
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
			);
		$args['sortBy'] = array('autor', 'autorSlug', 'documentos');
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por autor');
		$data['header']['gridTitle'] = _sprintf('Frecuencia de documentos por autor');
		$data['main']['breadcrumb'] = sprintf('%s > %s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), _('Autor'));
		return $this->_renderFrecuency($args, $data);
	}

	public function autorDocumentos($slug){
		$args['slug'] = $slug;
		$args['query'] = "SELECT {$this->queryFields} FROM autor a INNER JOIN \"mvSearch\" s ON a.iddatabase=s.iddatabase AND a.sistema=s.sistema WHERE a.slug='{$slug}'";
		$args['queryCount'] = "SELECT count(DISTINCT (a.iddatabase, a.sistema)) AS total FROM autor a INNER JOIN \"mvSearch\" s ON a.iddatabase=s.iddatabase AND a.sistema=s.sistema WHERE a.slug='{$slug}'";
		$args['paginationURL'] = site_url("frecuencias/autor/{$slug}");
		/*Datos del autor*/
		$this->load->database();
		$queryAutor = "SELECT e_100a AS autor FROM autor WHERE slug='{$slug}' LIMIT 1";
		$queryAutor = $this->db->query($queryAutor);
		$this->db->close();
		$queryAutor = $queryAutor->row_array();
		$args['breadcrumb'] = sprintf('%s > %s > %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/autor', _('Autor'), _('title="Autor"')), $queryAutor['autor']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $queryAutor['autor']);
		return $this->_renderDocuments($args);
	}

	public function institucion(){
		$args = $this->uri->ruri_to_assoc();
		$args['defaultOrder'] = "documentos";
		$args['orderDir'] = "DESC";
		$args['sortBy'] = array('institucion', 'institucionSlug', 'paises', 'revistas', 'autores', 'documentos');
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionDARP\" {$where}";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaInstitucionDARP\"";
		$args['querySlug'] = $query = "SELECT institucion AS unslug FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['slug']}' LIMIT 1";
		$args['where'] = "WHERE \"institucionSlug\"='{$args['slug']}'";
		$args['breadcrumbSlug'] = sprintf('%s > %s > %%s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')));
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
				'title' => _('Países'),
				'width' => 100,
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Revistas'),
				'width' => 100,
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Autores'),
				'width' => 100,
			);
		$args['cols'][] = array(
				'align' => 'center',
				'editable' => false,
				'title' => _('Documentos'),
				'width' => 100,
			);
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución');
		$data['header']['gridTitle'] = _sprintf('Frecuencia de países, revistas, autores y documentos por institución');
		$data['main']['breadcrumb'] = sprintf('%s > %s', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), _('Institución'));
		$section = array('', '', '/pais', '/revista', '/autor', '/documento');
		$data['header']['section'] = json_encode($section, true);
		return $this->_renderFrecuency($args, $data);
	}

	public function institucionDocumentos($slug){
		$args['slug'] = $slug;
		$args['query'] = "SELECT DISTINCT ON (sistema, iddatabase) * FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$slug}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"mvInstucionDocumentos\" WHERE \"institucionSlug\"='{$slug}'";
		$args['paginationURL'] = site_url("frecuencias/institucion/{$slug}/documento");
		/*Datos de la institucion*/
		$this->load->database();
		$queryInstitucion = "SELECT e_100u AS institucion FROM institucion WHERE slug='{$slug}' LIMIT 1";
		$queryInstitucion = $this->db->query($queryInstitucion);
		$this->db->close();
		$queryInstitucion = $queryInstitucion->row_array();
		$args['breadcrumb'] = sprintf('%s > %s > %s (%%d documentos)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $queryInstitucion['institucion']);
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
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$this->load->database();
		$query = "SELECT institucion FROM \"mvFrecuenciaInstitucionPais\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", países de publicación', $institucion);
		$data['header']['gridTitle'] = _sprintf('Frecuencia de documentos por país de publicación en la institución:<br/> %s', $institucion);
		$data['main']['breadcrumb'] = sprintf('%s > %s > %s (País)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		return $this->_renderFrecuency($args, $data);
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
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionRevista\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaInstitucionRevista\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$this->load->database();
		$query = "SELECT institucion FROM \"mvFrecuenciaInstitucionRevista\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", revistas de publicación', $institucion);
		$data['header']['gridTitle'] = _sprintf('Frecuencia de documentos por revista de publicación en la institución: <br/>%s', $institucion);
		$data['main']['breadcrumb'] = sprintf('%s > %s > %s (Revista)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		return $this->_renderFrecuency($args, $data);
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
			);
		$args['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaInstitucionAutor\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$args['query'] = "SELECT * FROM \"mvFrecuenciaInstitucionAutor\" WHERE \"institucionSlug\"='{$args['institucionSlug']}'";
		$this->load->database();
		$query = "SELECT institucion FROM \"mvFrecuenciaInstitucionAutor\" WHERE \"institucionSlug\"='{$args['institucionSlug']}' LIMIT 1";
		$query = $this->db->query($query);
		$query = $query->row_array();
		$institucion = $query['institucion'];
		$this->db->close();
		$data = array();
		$data['header']['title'] = _sprintf('Biblat - Frecuencias por institución "%s", autor', $institucion);
		$data['header']['gridTitle'] = _sprintf('Frecuencia de documentos por autor en la institución: <br/>%s', $institucion);
		$data['main']['breadcrumb'] = sprintf('%s > %s > %s (Autor)', anchor('frecuencias', _('Frecuencias'), _('title="Frecuencias"')), anchor('frecuencias/institucion', _('Institución'), _('title="Institución"')), $institucion);
		return $this->_renderFrecuency($args, $data);
	}

	private function _renderFrecuency($args, $data){
		if ($args['export'] == "excel"):
			$xls['cols'] = array( _('Autor'), _('Documentos') );
			$xls['query'] = "SELECT autor, documentos FROM \"mvFrecuenciaAutorDocumentos\" ORDER BY documentos DESC, autor";
			$xls['queryTotal'] = "SELECT count(*) AS total FROM \"mvFrecuenciaAutorDocumentos\"";
			$xls['fileName'] = "Frecuencia-Institucion.xls";
			$xls['sheetTitle'] = "Frecuencia-> Institución";
			return $this->_excel($xls);
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
			$query = "{$args['query']} {$where} ORDER BY {$order} {$orderDir} LIMIT {$args['resultados']} OFFSET {$offset}";
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
		$data['header']['sortIndx'] = array_search($args['defaultOrder'], $args['sortBy']);
		$data['header']['args'] = pqgrid_args($args);
		$data['header']['content'] =  $this->load->view('frecuencias_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_common', $data['main']);
		$this->load->view('footer');
	}

	private function _renderDocuments($args){
		/*Obtniendo los registros con paginación*/
		$articulosResultado = articulosResultado($args['query'], $args['queryCount'], $args['paginationURL'], $resultados=20);
		/*Vistas*/
		$data = array();
		$data['main']['links'] = $articulosResultado['links'];
		$data['main']['resultados']=$articulosResultado['articulos'];
		$data['header']['title'] = sprintf($args['title'], $articulosResultado['totalRows']);
		$data['header']['slugHighLight']=slugHighLight($args['slug']);
		$data['header']['content'] =  $this->load->view('buscar_header', $data['header'], TRUE);
		$data['main']['breadcrumb'] = sprintf($args['breadcrumb'], $articulosResultado['totalRows']);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('frecuencias_documentos', $data['main']);
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
			$rowNumber = 1;
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$xls['fileName'].'"'); 
			header('Cache-Control: max-age=0');
			echo "\"Autor\", \"Documentos\"\n";
			foreach ($query->result_array() as $row):
				/*$dataRow = array();
				foreach ($row as $key => $value):
					$dataRow[] = $value;
				endforeach;
				$data[] = $dataRow;*/
				/*$this->excel->getActiveSheet()->setCellValue("A{$rowNumber}", $row['autor']);
				$this->excel->getActiveSheet()->setCellValue("B{$rowNumber}", $row['documentos']);
				$rowNumber++;*/
				echo "\"{$row['autor']}\", \"{$row['documentos']}\"\n";
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

}

/* End of file frecuencias.php */
/* Location: ./application/controllers/frecuencias.php */