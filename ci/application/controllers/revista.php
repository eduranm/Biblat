<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Revista extends CI_Controller{
	public function index($revista){
		$data = array();
		/*Obteniendo articulos de la revista*/
		$queryFields="SELECT 
					DISTINCT (sistema, 
					iddatabase) as \"sitemaIdDatabase\", 
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
		$queryFrom = "FROM \"mvSearch\" where \"revistaSlug\"='{$revista}'";
		$query = "{$queryFields} 
				{$queryFrom} 
				ORDER BY anio DESC, articulo";
		
		$queryCount = "SELECT count (DISTINCT (sistema, 
					iddatabase)) as total {$queryFrom}";
		
		/*Paginación y resultados*/
		$paginationURL = site_url("/revista/{$revista}");
		$perPage = 20;
		$articulosResultado = articulosResultado($query, $queryCount, $paginationURL, $perPage);
		/*Resultados de la página*/
		$data['main']['links'] = $articulosResultado['links'];
		$data['main']['search']['total'] = $articulosResultado['totalRows'];
		$data['main']['resultados'] = $articulosResultado['articulos'];
		$data['main']['revista'] = current($articulosResultado['articulos']);
		$data['main']['revista'] = $data['main']['revista']['revista'];
		/*Vistas*/
		$data['header']['content'] =  $this->load->view('revista_header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('revista_index', $data['main']);
		$this->load->view('footer');
	}
}