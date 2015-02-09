<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicadores extends CI_Controller {

	public $indicadores = array();
	public $indicadoresSite = array();
	public $areas = array();
	public $colecciones = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->indicadoresSite = array(
			_('Publicación') => array(
					'distribucion-articulos-coleccion' => _('Distribución de artículos por colección'),
					'distribucion-revista-coleccion' => _('Distribución de revistas por colección'),
					'distribucion-articulos-afiliacion' => _('Distribución de artículos por país de afiliación'),
					'distribucion-articulos-revista-afiliacion' => _('Distribución de artículos por revista y país de afiliación'),
					'distribucion-articulos-publicacion-afiliacion' => _('Distribución de artículos por país de publicación y país de afiliación'),
					'distribucion-articulos-area-afiliacion' => _('Distribución de artículos por área y país de afiliación'),
					'distribucion-coautor-revista-afiliacion' => _('Distribución de artículos por revista y número de co-autores'),
					'distribucion-coautor-area-afiliacion' => _('Distribución de artículos por área y número de co-autores'),
				),
			_('Colección') => array(
					'generales' => _('Indicadores generales por revista')
				),
			_('Citación') => array(
					'distribucion-articulos-edad' => _('Distribución de artículos por edad del documento citado'),
					'distribucion-articulos-tipo' => _('Distribución de artículos por tipo del documento citado'),
					'distribucion-articulos-revista-edad' => _('Distribución de artículos por revista y edad del documento citado'),
					'distribucion-articulos-revista-tipo' => _('Distribución de artículos por revista y tipo del documento citado'),
					'distribucion-articulos-area-edad' => _('Distribución de artículos por área y edad del documento citado'),
					'distribucion-articulos-area-tipo' => _('Distribución de artículos por área y tipo del documento citado'),
					'distribucion-articulos-area-revista' => _('Distribución de artículos por área y revista ciatda'),
					'distribucion-articulos-afiliacion-edad' => _('Distribución de artículos por páis de afiliación y edad del documento citado'),
					'distribucion-articulos-afiliacion-tipo' => _('Distribución de artículos por páis de afiliación y tipo del documento citado'),
					'distribucion-articulos-afiliacion-revista' => _('Distribución de artículos por páis de afiliación y revista ciatda'),
				)
		);
		$this->indicadores = array(
			'distribucion-articulos-coleccion' => _('Distribución de artículos por colección'),
			'distribucion-articulos-coleccion-area' => _('Distribución de artículos por colección y área'),
			'distribucion-articulos-coleccion-area-revista' => _('Distribución de artículos por colección, área y revista'),
			'distribucion-articulos-coleccion-revista' => _('Distribución de artículos por colección y revista'),
			'distribucion-articulos-coleccion-afiliacion' => _('Distribución de artículos por colección y país de afiliación'),
			'distribucion-revista-coleccion' => _('Distribución de revistas por colección'),
			'distribucion-articulos-afiliacion' => _('Distribución de artículos por país de afiliación'),
			'distribucion-articulos-revista-afiliacion' => _('Distribución de artículos por revista y país de afiliación'),
			'distribucion-articulos-publicacion-afiliacion' => _('Distribución de artículos por país de publicación y país de afiliación'),
			'distribucion-articulos-area-afiliacion' => _('Distribución de artículos por área y país de afiliación'),
			'distribucion-coautor-revista-afiliacion' => _('Distribución de artículos por revista y número de co-autores'),
			'distribucion-coautor-area-afiliacion' => _('Distribución de artículos por área y número de co-autores'),
			'generales' => _('Indicadores generales ()'),
			'distribucion-articulos-edad' => _('Distribución de artículos por edad del documento citado'),
			'distribucion-articulos-tipo' => _('Distribución de artículos por tipo del documento citado'),
			'distribucion-articulos-revista-edad' => _('Distribución de artículos por revista y edad del documento citado'),
			'distribucion-articulos-revista-tipo' => _('Distribución de artículos por revista y tipo del documento citado'),
			'distribucion-articulos-area-edad' => _('Distribución de artículos por área y edad del documento citado'),
			'distribucion-articulos-area-tipo' => _('Distribución de artículos por área y tipo del documento citado'),
			'distribucion-articulos-area-revista' => _('Distribución de artículos por área y revista ciatda'),
			'distribucion-articulos-afiliacion-edad' => _('Distribución de artículos por páis de afiliación y edad del documento citado'),
			'distribucion-articulos-afiliacion-tipo' => _('Distribución de artículos por páis de afiliación y tipo del documento citado'),
			'distribucion-articulos-afiliacion-revista' => _('Distribución de artículos por páis de afiliación y revista ciatda'),
		);
		/*Colecciones*/
		$this->load->database('scielo');
		$query = "SELECT id, name, slug FROM \"network\"";
		$queryResult = $this->db->query($query);
		foreach ($queryResult->result_array() as $row):
			$this->colecciones['slug'][$row['slug']] = $row;
			$this->colecciones['id'][$row['id']] = $row;
		endforeach;
		$query = "SELECT id, name, slug FROM \"area\"";
		$queryResult = $this->db->query($query);
		foreach ($queryResult->result_array() as $row):
			$this->areas['slug'][$row['slug']] = $row;
			$this->areas['id'][$row['id']] = $row;
		endforeach;

		$this->db->close();

		$this->output->enable_profiler($this->config->item('enable_profiler'));
		$this->template->set_partial('biblat_js', 'javascript/biblat', array(), TRUE);
		$this->template->set_partial('submenu', 'layouts/submenu');
		$this->template->set_partial('search', 'layouts/search');
		$this->template->set_breadcrumb(_('Inicio'), site_url('/'));
		$this->template->set_breadcrumb(_('SciELO'));
		$this->template->set('class_method', $this->router->fetch_class().$this->router->fetch_method());
		$this->template->set('indicadores', $this->indicadoresSite);
		$this->template->set('colecciones', $this->colecciones['slug']);
		$this->template->set('areas', $this->areas['slug']);
	}

	public function index($indicador="")
	{
		$data = array();
		$data['indicador'] = $indicador;
		/*Vistas*/
		$data['page_title'] = $this->indicadores[$indicador] == '' ? _('Indicadores bibliométricos') : $this->indicadores[$indicador];
		$this->template->set_partial('view_js', 'scielo/indicadores/index_js', $data, FALSE);
		$this->template->title($data['header']['title']);
		$this->template->css('css/jquery.slider.min.css');
		$this->template->css('css/colorbox.css');
		$this->template->js('js/jquery.slider.min.js');
		$this->template->js('js/jquery.serializeJSON.min.js');
		$this->template->js('js/colorbox.js');
		$this->template->js('//www.google.com/jsapi');
		$this->template->set_meta('description', $this->indicadores[$indicador]);
		$this->template->set_breadcrumb(_('Indicadores bibliométricos'));
		$this->template->build('scielo/indicadores/index', $data);
	}

	public function getChartData(){
		$this->output->enable_profiler(false);
		switch ($_POST['indicador']):
			case 'distribucion-articulos-coleccion':
				$this->getChartCollection();
				break;
			case 'distribucion-articulos-coleccion-area':
			case 'distribucion-articulos-coleccion-area-revista':
			case 'distribucion-articulos-coleccion-revista':
			case 'distribucion-articulos-coleccion-afiliacion':
				$this->getChartCollectionSub();
				break;
			default:

				break;
		endswitch;
	}

	public function getOptionData(){
		$this->output->enable_profiler(false);
		switch ($_POST['indicador']):
			case 'distribucion-articulos-coleccion':
				$this->getRevistaAfiliacionCollection();
				break;
			case 'distribucion-articulos-coleccion-area':
			case 'distribucion-articulos-coleccion-area-revista':
				$this->getRevistaCollectionArea();
				break;
			default:
				break;
		endswitch;
	}

	public function getChartCollection()
	{
		$this->load->database();
		/*Convirtiendo el periodo en dos fechas*/
		$_POST['periodo'] = explode(";", $_POST['periodo']);
		/*Generamos el arreglo de periodos*/
		$periodos = $this->getPeriodos($_POST);
		/*Consulta para el indicador*/
		$indicador['distribucion-articulos-coleccion'] = array(
			'sql' => 'SELECT "networkId", anio, articulo, "otroDocumento" FROM "networkDistribution"',
			'title' => '<div class="text-center nowrap"><h4>'._('Distribución de artículos por colección').'</h4></div>',
			'vTitle' => _('Documentos'),
			'hTitle' => _('Año'),
			'tooltip' => _('%s en la colección %s en el año %s: %s')
			);
		$query = $indicador[$_POST['indicador']]['sql'];
		$query .= " WHERE anio BETWEEN '{$_POST['periodo'][0]}' AND '{$_POST['periodo'][1]}'";
		$colecciones = array_keys($this->colecciones['slug']);
		if (isset($_POST['coleccion']) && count($_POST['coleccion']) > 0):
			$colecciones = $_POST['coleccion'];
		endif;
		$limit = 4;
		$queryOrder = ' ORDER BY anio, "networkId"';
		$result['chart'] = array();
		$result['journal'] = array();
		$groups = array_chunk($colecciones, $limit, TRUE);
		$vAxisMax = 0;
		$result['table']['cols'][] = array('id' => 'year','label' => _('Año'),'type' => 'string');
		$result['table']['cols'][] = array('id' => '','label' => $indicador[$_POST['indicador']]['title'],'type' => 'number');
		$anioActual = 0;
		$grupo = 0;
		foreach ($groups as $key => $group):
			$queryColeccion = " AND \"networkId\" IN (";
			$coleccionOffset=1;
			$coleccionTotal= count($group);
			$offset = 0;
			$c = array();
			$result['chart'][$key]['cols'][] = array('id' => 'year','label' => _('Año'),'type' => 'string');
			foreach ($group as $coleccion):
				$result['chart'][$key]['cols'][] = array('id' => '','label' => _sprintf('%s artículos', $this->colecciones['slug'][$coleccion]['name']),'type' => 'number');
				$result['chart'][$key]['cols'][] = array('id' => '','label' => _sprintf('%s artículos', $this->colecciones['slug'][$coleccion]['name']).'-tooltip','type' => 'string', 'role' => 'tooltip');
				$result['chart'][$key]['cols'][] = array('id' => '','label' => _sprintf('%s otros documentos', $this->colecciones['slug'][$coleccion]['name']),'type' => 'number');
				$queryColeccion .= "'{$this->colecciones['slug'][$coleccion]['id']}'";
				if($coleccionOffset < $coleccionTotal):
					$queryColeccion .=",";
				endif;
				$coleccionOffset++;
			endforeach;
			$queryColeccion .= ")";
			$queryRS = $this->db->query($query.$queryColeccion.$queryOrder);
			$totalRows = $queryRS->num_rows();
			foreach ($queryRS->result_array() as $row):
				if($anioActual != $row['anio'] || !isset($result['chart'][$grupo])):
					if(count($c) > 0):
						$result['chart'][$grupo]['rows'][]['c'] = $c;
					endif;
					$c = array();
					$c[] = array('v' => $row['anio']);
					$anioActual = $row['anio'];
				endif;
				$vAxisMax = ($row['articulo'] + $row['otroDocumento']) < $vAxisMax ? $vAxisMax : ($row['articulo'] + $row['otroDocumento']); 
				$c[] = array(
					'v' => $row['articulo']
				);
				$c[] = array(
						'v' => _sprintf($indicador[$_POST['indicador']]['tooltip'], "Artículos", $this->colecciones['id'][$row['networkId']]['name'], $row['anio'], $row['articulo'])
					);
				$c[] = array(
						'v' => $row['otroDocumento']
					);
				$offset++;
				if($offset == $totalRows):
					$result['chart'][$grupo]['rows'][]['c'] = $c;
				endif;
			endforeach;
			$grupo++;
		endforeach;
		/*Opciones de la gráfica*/
		$result['options'] = array(
						'animation' => array(
								'duration' => 1000
							),
						'bars' => 'vertical',
						// 'bar' => array(
						// 		'groupWidth' => '85%'
						// 	),
						'height' => '550',
						'hAxis' => array(
								'title' => _('Año')
							), 
						'isStacked' => TRUE,
						'legend' => array(
								'position' => 'right'
							),
						'pointSize' => 1, 
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => $indicador[$_POST['indicador']]['vTitle'],
								'viewWindow' => array('max' => $vAxisMax),
								'minValue' => 0
							),
						'series' => array(
							1 =>  array('visibleInLegend' => FALSE)
							),
						'width' => '95%',
						'chartArea' => array(
							'left' => 100,
							'top' => 40,
							'width' => 550,
							'height' => "80%"
							),
						'backgroundColor' => array(
							'fill' => 'transparent'
							)
						);
		for ($i=1; $i < $limit; $i++):
			$result['options']['vAxes'][$i] = array(
				'title' => '',
				'textStyle' => array(
					'fontSize' => 0
					)
				);
			$result['options']['axes']['y'][$i] = array(
				'side' => 'right'
				);
			$result['options']['series'][$i*2] = array('targetAxisIndex' => $i);
			$result['options']['series'][($i*2)+1] = array('targetAxisIndex' => $i, 'visibleInLegend' => FALSE);
		endfor;
		/*Opciones para la tabla*/
		$result['tableOptions'] = array(
				'allowHtml' => true,
				'showRowNumber' => false,
				'cssClassNames' => array(
					'headerRow' => 'bold',
					'tableRow'	=> ' ',
					'oddTableRow' => ' ',
					'selectedTableRow' => ' ',
					'hoverTableRow' => ' ',
					'headerCell' => ' ',
					'tableCell' => ' ',
					'rowNumberCell' => ' '
					)
			);
		$result['chartTitle'] = "<div class=\"text-center nowrap\"><h4>{$indicador[$_POST['indicador']]['chartTitle']}</h4></div>";
		$result['tableTitle'] = "<h4 class=\"text-center\">{$this->indicadores[$_POST['indicador']]}</h4>";
		header('Content-Type: application/json');	
		echo json_encode($result, true);
	}
	public function getChartCollectionSub()
	{
		$this->output->enable_profiler(false);
		$data['data']['cols'][] = array('id' => 'year','label' => _('Año'),'type' => 'string');
		$this->load->database();
		/*Convirtiendo el periodo en dos fechas*/
		$_POST['periodo'] = explode(";", $_POST['periodo']);
		/*Generamos el arreglo de periodos*/
		$periodos = $this->getPeriodos($_POST);
		
		/*Consulta para cada indicador*/
		$indicador['distribucion-articulos-coleccion-area'] = array(
			'sql' => "SELECT \"areaNetwork\" AS title, anio, articulos as valor FROM \"vNetworkAreaDistribution\"",
			'vTitle' => _('Artículos por área'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['distribucion-articulos-coleccion-area-revista'] = array(
			'sql' => "SELECT journal AS title, anio, articulos as valor FROM \"networkAreaJournalDistribution\"",
			'vTitle' => _('Artículos por área'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['distribucion-articulos-coleccion-revista'] = array(
			'sql' => "SELECT journal AS title, anio, articulos as valor FROM \"networkJournalDistribution\"",
			'vTitle' => _('Artículos por revista'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['distribucion-articulos-coleccion-afiliacion'] = array(
			'sql' => "SELECT \"affiliationNetwork\" AS title, anio, articulos as valor FROM \"vNetworkAffiliationDistribution\"",
			'vTitle' => _('Artículos por país de afiliación'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos en el año <b>%s</b>: <b>%s</b>')
			);
		$query = $indicador[$_POST['indicador']]['sql'];
		$query .= " WHERE \"networkId\" IN (";
		$coleccionOffset=1;
		$coleccionTotal= count($_POST['coleccion']);
		foreach ($_POST['coleccion'] as $coleccion):
			$query .= "'{$this->colecciones['slug'][$coleccion]['id']}'";
			if($coleccionOffset < $coleccionTotal):
				$query .=",";
			endif;
			$coleccionOffset++;
		endforeach;
		$query .= ")";
		
		if (isset($_POST['area'])):
			$data['dataTable']['cols'][] = array('id' => '', 'label' => _('Área/Año'), 'type' => 'string');
			$query .= " AND \"areaId\" IN (";
			$offset=1;
			$total= count($_POST['area']);
			foreach ($_POST['area'] as $area):
				$query .= "'{$this->areas['slug'][$area]['id']}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;

		if (isset($_POST['revista'])):
			$data['dataTable']['cols'][] = array('id' => '', 'label' => _('Revista/Año'), 'type' => 'string');
			$query .= " AND \"revistaSlug\" IN (";
			$offset=1;
			$total= count($_POST['revista']);
			foreach ($_POST['revista'] as $revista):
				$query .= "'{$revista}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;

		if (isset($_POST['paisAutor'])):
			$data['dataTable']['cols'][] = array('id' => '', 'label' => _('Afiliación/Año'), 'type' => 'string');
			$query .= " AND \"paisSlug\" IN (";
			$offset=1;
			$total= count($_POST['paisAutor']);
			foreach ($_POST['paisAutor'] as $paisAutor):
				$query .= "'{$paisAutor}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;

		$query .= " AND anio BETWEEN '{$_POST['periodo'][0]}' AND '{$_POST['periodo'][1]}'";
		$query = $this->db->query($query);
		$indicadores = array();
		foreach ($query->result_array() as $row ):
			$indicadores[$row['title']][$row['anio']] = round($row['valor'], 2);
		endforeach;
		/*Generando columnas*/
		foreach ($indicadores as $kindicador => $vindicador):
			$data['data']['cols'][] = array('id' => slug($kindicador),'label' => $kindicador, 'type' => 'number');
			$data['data']['cols'][] = array('id' => slug($kindicador)."-tooltip",'label' => $kindicador, 'type' => 'string', 'p' => array('role' => 'tooltip', 'html' => true));
		endforeach;
		/*Generando filas para gráfica y columnas para la tabla*/
		$setDataTableRows = false;
		foreach ($periodos as $periodo):
			$data['dataTable']['cols'][] = array('id' => '','label' => $periodo, 'type' => 'number');
			$c = array();
			$c[] = array(
					'v' => $periodo
				);
			foreach ($indicadores as $kindicador => $vindicador):
				$c[] = array(
					'v' => $vindicador[$periodo]
				);
				$c[] = array(
					'v' => _sprintf("<div class=\"text-center nowrap\"><b>%s</b></div><div class=\"text-center nowrap\">{$indicador[$_POST['indicador']]['tooltip']}</div>", $kindicador, $periodo, $vindicador[$periodo])
				);
				/*dataTable rows*/
				if( ! $setDataTableRows ):
					$cc = array();
					$cc[] = array(
						'v' => $kindicador
					);
					foreach ($periodos as $periodoDT):
						$cc[] = array(
							'v' => $vindicador[$periodoDT] != null ? number_format($vindicador[$periodoDT], 0, '.', ',') : null
						);
					endforeach;
					$data['dataTable']['rows'][]['c'] = $cc;
				endif;
			endforeach;
			$setDataTableRows = true;
			$data['data']['rows'][]['c'] = $c;
		endforeach;

		/*Opciones de la gráfica*/
		$data['options'] = array(
						'animation' => array(
								'duration' => 1000
							), 
						'height' => '500',
						'hAxis' => array(
								'title' => $indicador[$_POST['indicador']]['hTitle']
							), 
						'legend' => array(
								'position' => 'right'
							),
						'pointSize' => 3,
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => $indicador[$_POST['indicador']]['vTitle'],
								'minValue' => 0
							),
						'width' => '925',
						'chartArea' => array(
							'left' => 100,
							'top' => 40,
							'width' => 675,
							'height' => "80%"
							),
						'backgroundColor' => array(
							'fill' => 'transparent'
							)
						);
		/*Opciones para la tabla*/
		$data['tableOptions'] = array(
				'allowHtml' => true,
				'showRowNumber' => false,
				'cssClassNames' => array(
					'headerRow' => 'bold',
					'tableRow'	=> ' ',
					'oddTableRow' => ' ',
					'selectedTableRow' => ' ',
					'hoverTableRow' => ' ',
					'headerCell' => ' ',
					'tableCell' => ' ',
					'rowNumberCell' => ' '
					)
			);
		/*Titulo de la gráfica*/
		$data['chartTitle'] = "<div class=\"text-center nowrap\"><h4>{$this->indicadores[$_POST['indicador']]}</h4></div>";
		$data['tableTitle'] = "<h4 class=\"text-center\">{$this->indicadores[$_POST['indicador']]}</h4>";
		header('Content-Type: application/json');
		echo json_encode($data, true);
	}

	public function getPeriodos($request=null){
		$this->output->enable_profiler(false);
		if($request != null):
			$data['periodos'] = range($request['periodo'][0], $request['periodo'][1]);
			return $data['periodos'];
		endif;

		$data = array();
		$this->load->database('scielo');
		$query = "";
		/*Periodos por revista*/
		/*Consulta para cada indicador*/
		$indicadorTabla['distribucion-articulos-coleccion']="networkDistribution";
		$indicadorTabla['distribucion-articulos-coleccion-area']="networkAreaDistribution";
		$indicadorTabla['distribucion-articulos-coleccion-area-revista']="networkAreaJournalDistribution";
		$indicadorTabla['distribucion-articulos-coleccion-revista']="networkJournalDistribution";
		$indicadorTabla['distribucion-articulos-coleccion-afiliacion']="networkAffiliationDistribution";
		$query = "SELECT min(anio) AS \"anioBase\", max(anio) AS \"anioFinal\" FROM \"{$indicadorTabla[$_POST['indicador']]}\"";
		if (isset($_POST['coleccion']) && count($_POST['coleccion']) > 0):
			$query .= " WHERE \"networkId\" IN (";
			$coleccionOffset=1;
			$coleccionTotal= count($_POST['coleccion']);
			foreach ($_POST['coleccion'] as $coleccion):
				$query .= "'{$this->colecciones['slug'][$coleccion]['id']}'";
				if($coleccionOffset < $coleccionTotal):
					$query .=",";
				endif;
				$coleccionOffset++;
			endforeach;
			$query .= ")";
		endif;

		if (isset($_POST['area'])):
			$query .= " AND \"areaId\" IN (";
			$offset=1;
			$total= count($_POST['area']);
			foreach ($_POST['area'] as $area):
				$query .= "'{$this->areas['slug'][$area]['id']}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif; 

		if (isset($_POST['revista'])):
			$query .= " AND \"revistaSlug\" IN (";
			$offset=1;
			$total= count($_POST['revista']);
			foreach ($_POST['revista'] as $revista):
				$query .= "'{$revista}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;

		if (isset($_POST['paisAutor'])):
			$query .= " AND \"paisSlug\" IN (";
			$offset=1;
			$total= count($_POST['paisAutor']);
			foreach ($_POST['paisAutor'] as $paisAutor):
				$query .= "'{$paisAutor}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;

		$query = $this->db->query($query);
		$rango = $query->row_array();
		$this->db->close();
		$anioBase = $rango['anioBase'];
		$anioFinal = $rango['anioFinal'];

		$data['result'] = true;
		$data['anioBase'] = (int)$anioBase;
		$data['anioFinal'] = (int)$anioFinal;

		/*Generando escala*/
		$scale = array();
		$scaleOffset = $data['anioBase'];
		while ( $scaleOffset < $data['anioFinal']):	
			$scale[] = $scaleOffset;
			if($scaleOffset % 5 > 0):
				$scaleOffset += (5 - $scaleOffset % 5);
			else:
				$scaleOffset += 5;
				if($scaleOffset <= $data['anioFinal']):
					$scale[] = "|";
				endif;
			endif;
		endwhile;
		$scale[] = $data['anioFinal'];
		$data['scale'] = json_encode($scale, true);
		$heterogeneity = array();
		$scales = count($scale) - 1;
		foreach ($scale as $key => $value):
			if($value != $data['anioFinal'] && $value != $data['anioBase'] && $value != "|" && is_numeric($value)):
				$indice = $key;
				$porcentaje = number_format((($indice/$scales) * 100), 1, '.', '');
				$heterogeneity[] = "{$porcentaje}/{$value}";
			endif;
		endforeach;
		$data['heterogeneity'] = json_encode($heterogeneity, true);
		header('Content-Type: application/json');
		echo json_encode($data, true);
	}

	public function getRevistaAfiliacionCollection(){
		$this->load->database();
		$coleccionOffset=1;
		$coleccionTotal= count($_POST['coleccion']);
		$coleccionIN = "";
		foreach ($_POST['coleccion'] as $coleccion):
			$coleccionIN .= "'{$this->colecciones['slug'][$coleccion]['id']}'";
			if($coleccionOffset < $coleccionTotal):
				$coleccionIN .=",";
			endif;
			$coleccionOffset++;
		endforeach;
		$query = "SELECT \"networkId\", name, slug FROM \"vNetworkJournals\" WHERE \"networkId\" IN(${coleccionIN})";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$data['revistas'][$this->colecciones['id'][$row['networkId']]['name']][$row['slug']] = htmlspecialchars($row['name']);
		endforeach;

		$query = "SELECT name, slug FROM \"vNetworksAffiliations\" WHERE \"networkId\" IN(${coleccionIN})";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$data['paises'][$row['slug']] = htmlspecialchars($row['name']);
		endforeach;

		$this->db->close();
		header('Content-Type: application/json');
		echo json_encode($data, true);
	}

	public function getRevistaCollectionArea(){
		$this->load->database();
		$offset=1;
		$total= count($_POST['coleccion']);
		$coleccionIN = "";
		foreach ($_POST['coleccion'] as $coleccion):
			$coleccionIN .= "'{$this->colecciones['slug'][$coleccion]['id']}'";
			if($offset < $total):
				$coleccionIN .=",";
			endif;
			$offset++;
		endforeach;
		$offset=1;
		$total= count($_POST['area']);
		$areaIN = "";
		foreach ($_POST['area'] as $area):
			$areaIN .= "'{$this->areas['slug'][$area]['id']}'";
			if($offset < $total):
				$areaIN .=",";
			endif;
			$offset++;
		endforeach;
		$query = "SELECT \"networkId\", \"areaId\", name, slug FROM \"vNetworkAreaJournals\" WHERE \"networkId\" IN({$coleccionIN}) AND \"areaId\" IN({$areaIN})";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$networkName = $this->colecciones['id'][$row['networkId']]['name'];
			$areaName = $this->areas['id'][$row['areaId']]['name'];
			$data['revistas'][$networkName][$areaName][$row['slug']] = htmlspecialchars($row['name']);
		endforeach;

		$this->db->close();
		header('Content-Type: application/json');
		echo json_encode($data, true);
	}

}

/* End of file indicadores.php */
/* Location: ./application/controllers/indicadores.php */