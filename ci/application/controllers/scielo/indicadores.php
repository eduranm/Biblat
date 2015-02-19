<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicadores extends CI_Controller {

	public $indicadores = array();
	public $indicadoresSite = array();
	public $areas = array();
	public $colecciones = array();
	public $ageRanges = array();
	public $docTypes = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->indicadoresSite = array(
			_('Publicación') => array(
					'distribucion-articulos-coleccion' => _('Distribución de artículos por colección'),
					'distribucion-revista-coleccion' => _('Distribución de revistas por colección'),
					// 'distribucion-articulos-afiliacion' => _('Distribución de artículos por país de afiliación'),
					// 'distribucion-articulos-revista-afiliacion' => _('Distribución de artículos por revista y país de afiliación'),
					// 'distribucion-articulos-publicacion-afiliacion' => _('Distribución de artículos por país de publicación y país de afiliación'),
					// 'distribucion-articulos-area-afiliacion' => _('Distribución de artículos por área y país de afiliación'),
					// 'distribucion-coautor-revista-afiliacion' => _('Distribución de artículos por revista y número de co-autores'),
					// 'distribucion-coautor-area-afiliacion' => _('Distribución de artículos por área y número de co-autores'),
				),
			_('Colección') => array(
					'indicadores-generales-revista' => _('Indicadores generales por revista')
				),
			_('Citación') => array(
					'citacion-articulos-edad' => _('Distribución de artículos por edad del documento citado'),
					'citacion-articulos-tipo' => _('Distribución de artículos por tipo del documento citado'),
					'citaction-articulos-area-revista' => _('Distribución de artículos por área y revista citada'),
					// 'citacion-articulos-afiliacion-revista' => _('Distribución de artículos por páis de afiliación y revista ciatada'),
				)
		);
		$this->indicadores = array(
			'distribucion-articulos-afiliacion' => array(
				'title' => _('Distribución de artículos por país de afiliación'),
				'update' => '08/12/2014'
				),
			'citacion-articulos-afiliacion-revista' => array(
				'title' => _('Distribución de artículos por páis de afiliación y revista citada'),
				'update' => '08/12/2014'
				),
			'distribucion-articulos-area-afiliacion' => array(
				'title' => _('Distribución de artículos por área y país de afiliación'),
				'update' => '08/12/2014'
				),
			'citaction-articulos-area-revista' => array(
				'title' => _('Distribución de artículos por área y revista citada'),
				'update' => '08/12/2014'
				),
			'distribucion-articulos-coleccion' => array(
				'title' => _('Distribución de artículos por colección'),
				'update' => '08/12/2014'
				),
			'distribucion-articulos-coleccion-afiliacion' => array(
				'title' => _('Distribución de artículos por colección y país de afiliación'),
				'update' => '08/12/2014'
				),
			'distribucion-articulos-coleccion-area' => array(
				'title' => _('Distribución de artículos por colección y área'),
				'update' => '18/06/2013'
				),
			'distribucion-articulos-coleccion-area-revista' => array(
				'title' => _('Distribución de artículos por colección, área y revista'),
				'update' => '08/12/2014'
				),
			'distribucion-articulos-coleccion-revista' => array(
				'title' => _('Distribución de artículos por colección y revista'),
				'update' => '08/12/2014'
				),
			'citacion-articulos-edad' => array(
				'title' => _('Distribución de artículos por edad del documento citado'),
				'update' => '08/12/2014'
				),
			'citacion-articulos-edad-afiliacion' => array(
				'title' => _('Distribución de artículos según edad del documento y país de afiliación citante'),
				'update' => '08/12/2014'
				),
			'citacion-articulos-edad-area' => array(
				'title' => _('Distribución de artículos según edad del documento y área citante'),
				'update' => '08/12/2014'
				),
			'citacion-articulos-edad-revista' => array(
				'title' => _('Distribución de artículos según edad del documento y revista citante'),
				'update' => '08/12/2014'
				),
			'distribucion-articulos-publicacion-afiliacion' => array(
				'title' => _('Distribución de artículos por país de publicación y país de afiliación'),
				'update' => '08/12/2014'
				),
			'distribucion-articulos-revista-afiliacion' => array(
				'title' => _('Distribución de artículos por revista y país de afiliación'),
				'update' => '08/12/2014'
				),
			'citacion-articulos-tipo' => array(
				'title' => _('Distribución de artículos por tipo del documento citado'),
				'update' => '08/12/2014'
				),
			'citacion-articulos-tipo-afiliacion' => array(
				'title' => _('Distribución de artículos según tipo de documento y país de afiliación citante'),
				'update' => '08/12/2014'
				),
			'citacion-articulos-tipo-area' => array(
				'title' => _('Distribución de artículos según tipo de documento y área citante'),
				'update' => '08/12/2014'
				),
			'citacion-articulos-tipo-revista' => array(
				'title' => _('Distribución de artículos según tipo de documento y revista citante'),
				'update' => '08/12/2014'
				),
			'distribucion-coautor-area-afiliacion' => array(
				'title' => _('Distribución de artículos por área y número de co-autores'),
				'update' => '08/12/2014'
				),
			'distribucion-coautor-revista-afiliacion' => array(
				'title' => _('Distribución de artículos por revista y número de co-autores'),
				'update' => '08/12/2014'
				),
			'distribucion-revista-coleccion' => array(
				'title' => _('Distribución de revistas por colección'),
				'update' => '08/12/2014'
				),
			'indicadores-generales-revista' => array(
				'title' => _('Indicadores generales por revista'),
				'update' => '08/12/2014'
				),
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
		$query = "SELECT rango FROM \"vAgeRange\"";
		$queryResult = $this->db->query($query);
		$this->ageRanges = $queryResult->result_array();
		$query = "SELECT id, name, slug FROM \"docType\" ORDER BY slug";
		$queryResult = $this->db->query($query);
		foreach ($queryResult->result_array() as $row):
			$this->docTypes['slug'][$row['slug']] = $row;
			$this->docTypes['id'][$row['id']] = $row;
		endforeach;
		
		$this->db->close();

		$this->output->enable_profiler($this->config->item('enable_profiler'));
		$this->template->set_partial('biblat_js', 'javascript/biblat', array(), TRUE, FALSE);
		$this->template->set_partial('submenu', 'layouts/submenu');
		$this->template->set_partial('search', 'layouts/search');
		$this->template->set_breadcrumb(_('Inicio'), site_url('/'));
		$this->template->set_breadcrumb(_('SciELO'));
		$this->template->set('class_method', $this->router->fetch_class().$this->router->fetch_method());
		$this->template->set('indicadores', $this->indicadoresSite);
		$this->template->set('colecciones', $this->colecciones['slug']);
		$this->template->set('areas', $this->areas['slug']);
		$this->template->set('ageRanges', $this->ageRanges);
		$this->template->set('docTypes', $this->docTypes['slug']);
	}

	public function index($indicador="")
	{
		$data = array();
		$data['indicador'] = $indicador;
		/*Vistas*/
		$data['page_title'] = $this->indicadores[$indicador]['title'] == '' ? _('Indicadores bibliométricos') : $this->indicadores[$indicador]['title'];
		$this->template->set_partial('view_js', 'scielo/indicadores/index_js', $data, TRUE, FALSE);
		$this->template->title($data['header']['title']);
		$this->template->css('css/jquery.slider.min.css');
		$this->template->css('css/colorbox.css');
		$this->template->js('js/jquery.slider.min.js');
		$this->template->js('js/jquery.serializeJSON.min.js');
		$this->template->js('js/colorbox.js');
		$this->template->js('//www.google.com/jsapi');
		$this->template->set_meta('description', $this->indicadores[$indicador]['title']);
		$this->template->set_breadcrumb(_('Indicadores bibliométricos'));
		$this->template->build('scielo/indicadores/index', $data);
	}

	public function getPeriodos($request=null){
		$this->output->enable_profiler(false);
		if($request != null):
			$data['periodos'] = range($request['periodo'][0], $request['periodo'][1]);
			return $data['periodos'];
		endif;

		$data = array();
		$query = NULL;
		
		switch ($_POST['indicador']) :
			case 'distribucion-articulos-coleccion':
			case 'distribucion-articulos-coleccion-area':
			case 'distribucion-articulos-coleccion-area-revista':
			case 'distribucion-articulos-coleccion-revista':
			case 'distribucion-articulos-coleccion-afiliacion':
			case 'distribucion-revista-coleccion':
			case 'citacion-articulos-edad':
			case 'citacion-articulos-edad-area':
			case 'citacion-articulos-edad-revista':
			case 'citacion-articulos-edad-afiliacion':
			case 'citacion-articulos-tipo':
			case 'citacion-articulos-tipo-area':
			case 'citacion-articulos-tipo-revista':
			case 'citacion-articulos-tipo-afiliacion':
				$query = $this->getPeriodosCollectionEdadTipoDoc();
				break;
			case 'indicadores-generales-revista':
				$query = $this->getPeriodosGeneral();
				break;
			default:
				break;
		endswitch;

		/*Realizando consulta*/
		$this->load->database('scielo');
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
		$offset = $data['anioBase'];
		while ( $offset < $data['anioFinal']):	
			$scale[] = $offset;
			if($offset % 5 > 0):
				$offset += (5 - $offset % 5);
			else:
				$offset += 5;
				if($offset <= $data['anioFinal']):
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
			case 'distribucion-revista-coleccion':
			case 'citacion-articulos-edad':
			case 'citacion-articulos-edad-area':
			case 'citacion-articulos-edad-revista':
			case 'citacion-articulos-edad-afiliacion':
			case 'citacion-articulos-tipo':
			case 'citacion-articulos-tipo-area':
			case 'citacion-articulos-tipo-revista':
			case 'citacion-articulos-tipo-afiliacion':
				$this->getChartCollectionSub();
				break;
			case 'indicadores-generales-revista':
				$this->getChartGeneral();
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
			case 'indicadores-generales-revista':
				$this->getRevistasGeneral();
				break;
			case 'citacion-articulos-edad':
				$this->getRevistaAfiliacionEdad();
				break;
			case 'citacion-articulos-tipo':
				$this->getRevistaAfiliacionTipoDoc();
				break;
			case 'citaction-articulos-area-revista':
				$this->getRevistaArea();
				break;
			default:
				break;
		endswitch;
	}

	/*Gráficas*/
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
		$result['table']['cols'][] = array('id' => 'year','label' => _('Colección'),'type' => 'string');
		$result['table']['cols'][] = array('id' => 'year','label' => _('Tipo'),'type' => 'string');
		$anioActual = 0;
		$grupo = 0;
		foreach ($periodos as $periodo):
			$result['table']['cols'][] = array('id' => '','label' => $periodo, 'type' => 'number');
		endforeach;
		foreach ($groups as $key => $group):
			$queryColeccion = " AND \"networkId\" IN (";
			$coleccionOffset=1;
			$coleccionTotal= count($group);
			$offset = 0;
			$c = array();
			$result['chart'][$key]['cols'][] = array('id' => 'year','label' => _('Año'),'type' => 'string');
			foreach ($group as $coleccion):
				$result['chart'][$key]['cols'][] = array('id' => '','label' => _sprintf('SciELO %s artículos', $this->colecciones['slug'][$coleccion]['name']),'type' => 'number');
				$result['chart'][$key]['cols'][] = array('id' => '','label' => _sprintf('SciELO %s artículos', $this->colecciones['slug'][$coleccion]['name']).'-tooltip','type' => 'string', 'role' => 'tooltip');
				$result['chart'][$key]['cols'][] = array('id' => '','label' => _sprintf('SciELO %s otros documentos', $this->colecciones['slug'][$coleccion]['name']),'type' => 'number');
				$queryColeccion .= "'{$this->colecciones['slug'][$coleccion]['id']}'";
				if($coleccionOffset < $coleccionTotal):
					$queryColeccion .=",";
				endif;
				$coleccionOffset++;
			endforeach;
			$queryColeccion .= ")";
			$queryRS = $this->db->query($query.$queryColeccion.$queryOrder);
			$totalRows = $queryRS->num_rows();
			$tableRows = array();
			foreach ($queryRS->result_array() as $row):
				if($anioActual != $row['anio'] || !isset($result['chart'][$grupo])):
					if(count($c) > 0):
						$result['chart'][$grupo]['rows'][]['c'] = $c;
					endif;
					$c = array();
					$c[] = array('v' => $row['anio']);
					$anioActual = $row['anio'];
				endif;
				if(!isset($tableRows[$row['networkId']])):
					$tableRows[$row['networkId']] = array();
					$tableRows[$row['networkId']]['ca'][] = array('v' => _sprintf('SciELO %s', $this->colecciones['id'][$row['networkId']]['name']));
					$tableRows[$row['networkId']]['ca'][] = array('v' => _('Artículos originales'));
					$tableRows[$row['networkId']]['cb'][] = array('v' => '');
					$tableRows[$row['networkId']]['cb'][] = array('v' => _('Otro tipo de documetos'));
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
				$tableRows[$row['networkId']]['ca'][] = array('v' => (int)$row['articulo']);
				$tableRows[$row['networkId']]['cb'][] = array('v' => (int)$row['otroDocumento']);
				$offset++;
				if($offset == $totalRows):
					$result['chart'][$grupo]['rows'][]['c'] = $c;
				endif;
			endforeach;
			$grupo++;
		endforeach;
		foreach ($tableRows as $row):
			$result['table']['rows'][]['c'] = $row['ca'];
			$result['table']['rows'][]['c'] = $row['cb'];
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
								'position' => 'right',
								'maxLines' => 2
							),
						'title'=> _sprintf('Fuente: %s', 'biblat.unam.mx'),
						'titlePosition' => 'in',
						'titleTextStyle' => array(
							'bold' => FALSE,
							'italic' => TRUE
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
							'fill' => '#FAFAFA'
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
		$result['chartTitle'] = "<div class=\"text-center nowrap\"><h4>{$this->indicadores[$_POST['indicador']]['title']}</h4><h5><a href=\"http://www.scielo.org\" target=\"_blank\" class=\"scielo-update\"><span class=\"bl-scielo fa-2x\"></span> {$this->indicadores[$_POST['indicador']]['update']}</a></i></h5></div>";
		$result['tableTitle'] = "<h4 class=\"text-center\">{$this->indicadores[$_POST['indicador']]['title']}</h4>";
		header('Content-Type: application/json');	
		echo json_encode($result, true);
	}

	public function getChartCollectionSub()
	{
		$data = array();
		$labels = array();
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
		$indicador['distribucion-revista-coleccion'] = array(
			'sql' => "SELECT 'SciELO '||\"networkName\" AS title, anio, revistas as valor FROM \"vNetworkDistributionJ\"",
			'vTitle' => _('Revistas por coleccion'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de revistas en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['citacion-articulos-edad'] = array(
			'sql' => "SELECT \"rango\"||' "._('Años')."' AS title, anio, articulos as valor FROM \"ageDocCitation\"",
			'vTitle' => _('Número de artículos'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos citados en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['citacion-articulos-edad-area'] = array(
			'sql' => "SELECT \"areaName\"||' ('||rango||' "._('Años').")' AS title, anio, articulos as valor FROM \"vAgeDocAreaCitation\"",
			'vTitle' => _('Número de artículos'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos citados en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['citacion-articulos-edad-revista'] = array(
			'sql' => "SELECT revista||' ('||rango||' "._('Años').")' AS title, anio, articulos as valor FROM \"ageDocJournalCitation\"",
			'vTitle' => _('Número de artículos'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos citados en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['citacion-articulos-edad-afiliacion'] = array(
			'sql' => "SELECT pais||' ('||rango||' "._('Años').")' AS title, anio, articulos as valor FROM \"ageDocAffiliationCitation\"",
			'vTitle' => _('Número de artículos'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos citados en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['citacion-articulos-tipo'] = array(
			'sql' => "SELECT \"docTypeName\" AS title, anio, articulos as valor FROM \"vDocTypeDistribution\"",
			'vTitle' => _('Artículos citados por tipo de documento'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos citados en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['citacion-articulos-tipo-area'] = array(
			'sql' => "SELECT \"areaName\"||' ('||\"docTypeName\"||')' AS title, anio, articulos as valor FROM \"vDocTypeAreaCitation\"",
			'vTitle' => _('Número de artículos'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos citados en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['citacion-articulos-tipo-revista'] = array(
			'sql' => "SELECT revista||' ('||\"docTypeName\"||')' AS title, anio, articulos as valor FROM \"vDocTypeJournalCitation\"",
			'vTitle' => _('Número de artículos'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos citados en el año <b>%s</b>: <b>%s</b>')
			);
		$indicador['citacion-articulos-tipo-afiliacion'] = array(
			'sql' => "SELECT pais||' ('||\"docTypeName\"||')' AS title, anio, articulos as valor FROM \"vDocTypeAffiliationCitation\"",
			'vTitle' => _('Número de artículos'),
			'hTitle' => _('Año'),
			'tooltip' => _('Número de artículos citados en el año <b>%s</b>: <b>%s</b>')
			);

		$query = $indicador[$_POST['indicador']]['sql'];
		$query .= " WHERE anio BETWEEN '{$_POST['periodo'][0]}' AND '{$_POST['periodo'][1]}'";

		if (isset($_POST['coleccion'])):
			$labels[] = _('Colección');
			$query .= " AND \"networkId\" IN (";
			$offset=1;
			$total= count($_POST['coleccion']);
			foreach ($_POST['coleccion'] as $coleccion):
				$query .= "'{$this->colecciones['slug'][$coleccion]['id']}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;

		if (isset($_POST['edad'])):
			$labels[] = _('Edad');
			$query .= " AND \"rango\" IN (";
			$offset=1;
			$total= count($_POST['edad']);
			foreach ($_POST['edad'] as $edad):
				$query .= "'{$edad}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;

		if (isset($_POST['tipodoc'])):
			$labels[] = _('Tipo de documento');
			$query .= " AND \"docTypeId\" IN (";
			$offset=1;
			$total= count($_POST['tipodoc']);
			foreach ($_POST['tipodoc'] as $tipodoc):
				$query .= "'{$this->docTypes['slug'][$tipodoc]['id']}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;
		
		if (isset($_POST['area'])):
			$labels[] = _('Area');
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
			$labels[] = _('Revista');
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
			$labels[] = _('Afiliación');
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

		$data['dataTable']['cols'][] = array('id' => '', 'label' => implode(', ', $labels).'/'._('Año'), 'type' => 'string');
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
							'v' => $vindicador[$periodoDT] != null ? $vindicador[$periodoDT] : null
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
								'position' => 'right',
								'maxLines' => 2
							),
						'title'=> _sprintf('Fuente: %s', 'biblat.unam.mx'),
						'titlePosition' => 'in',
						'titleTextStyle' => array(
							'bold' => FALSE,
							'italic' => TRUE
							),
						'pointSize' => 3,
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => $indicador[$_POST['indicador']]['vTitle'],
								'minValue' => 0
							),
						'width' => '1000',
						'chartArea' => array(
							'left' => 10,
							'top' => 40,
							'width' => "70%",
							'height' => "80%"
							),
						'backgroundColor' => array(
							'fill' => '#FAFAFA'
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
		$data['chartTitle'] = "<div class=\"text-center nowrap\"><h4>{$this->indicadores[$_POST['indicador']]['title']}</h4><h5><a href=\"http://www.scielo.org\" target=\"_blank\" class=\"scielo-update\"><span class=\"bl-scielo fa-2x\"></span> {$this->indicadores[$_POST['indicador']]['update']}</a></i></h5></div>";
		$data['tableTitle'] = "<h4 class=\"text-center\">{$this->indicadores[$_POST['indicador']]['title']}</h4>";
		header('Content-Type: application/json');
		echo json_encode($data, true);
	}

	public function getChartGeneral(){
		$data = array();
		$charts = array(
			'fasciculos' => array('title' => 'Número de fasciculos por revista', 'vTitle' => 'Fasciculos por revista', 'tooltip' => _('Número de fasciculos en el año <b>%s</b>: <b>%s</b>')),
			'articulos' => array('title' => 'Número de artículos por revista', 'vTitle' => 'Artículos por revista', 'tooltip' => _('Número de artículos en el año <b>%s</b>: <b>%s</b>')), 
			'referencias' => array('title' => 'Número de referencias por revista', 'vTitle' => 'Referencias por revista', 'tooltip' => _('Número de referencias en el año <b>%s</b>: <b>%s</b>')), 
			'citas' => array('title' => 'Número de citas/autocitas por revista', 'vTitle' => 'Citas por revista', 'tooltip' => _('Número de citas/autocitas en el año <b>%s</b>: <b>%s</b>')), 
			'factorImpacto' => array('title' => 'Factor de impacto por revista', 'vTitle' => 'Factor de impacto', 'tooltip' => _('Factor de impacto en el año <b>%s</b>: <b>%s</b>')),
			'indiceInmediates' => array('title' => 'Indice de inmediates por revista', 'vTitle' => 'Indice de inmediates', 'tooltip' => _('Indice de inmediates en el año <b>%s</b>: <b>%s</b>')),
			'vidaMedia' => array('title' => 'Vida media por revista', 'vTitle' => 'Vida media', 'tooltip' => _('Vida media en el año <b>%s</b>: <b>%s</b>'))
		);
		$data['update'] = "<h5><a href=\"http://www.scielo.org\" target=\"_blank\" class=\"scielo-update\"><span class=\"bl-scielo fa-2x\"></span> {$this->indicadores[$_POST['indicador']]['update']}</a></i></h5>";
		foreach ($charts as $key => $chart):
			$data['title'][$key] = $charts[$key]['title'];
			$data['vTitle'][$key] = array('vAxis' => array('title' => $charts[$key]['vTitle'], 'minValue' => 0));
			$data['chart'][$key]['cols'][] = array('id' => 'year','label' => _('Año'),'type' => 'string');
		endforeach;

		/*Convirtiendo el periodo en dos fechas*/
		$_POST['periodo'] = explode(";", $_POST['periodo']);
		/*Generamos el arreglo de periodos*/
		$periodos = $this->getPeriodos($_POST);

		$query = "SELECT * FROM \"indicadoresGeneralesRevista\" WHERE anio BETWEEN '{$_POST['periodo'][0]}' AND '{$_POST['periodo'][1]}'";
		if (isset($_POST['coleccion']) && count($_POST['coleccion']) > 0):
			$query .= " AND \"networkId\" IN (";
			$offset=1;
			$total= count($_POST['coleccion']);
			foreach ($_POST['coleccion'] as $coleccion):
				$query .= "'{$this->colecciones['slug'][$coleccion]['id']}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;
		if (isset($_POST['revista']) && count($_POST['revista']) > 0):
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
		$this->load->database();
		$query = $this->db->query($query);
		$this->db->close();

		$indicadores = array();
		foreach ($query->result_array() as $row ):
			$indicadores[$row['journal']][$row['anio']] = $row;
		endforeach;

		/*Generando columnas*/
		foreach ($indicadores as $kindicador => $vindicador):
			foreach ($charts as $key => $chart):
				switch ($key):
					case 'citas':
						$data['chart'][$key]['cols'][] = array('id' => slug($kindicador)."-autocitacion",'label' => $kindicador._(' (autocitas)'), 'type' => 'number');
						$data['chart'][$key]['cols'][] = array('id' => slug($kindicador)."-tooltip",'label' => $kindicador, 'type' => 'string', 'p' => array('role' => 'tooltip', 'html' => true));
					default:
						$data['chart'][$key]['cols'][] = array('id' => slug($kindicador),'label' => $kindicador, 'type' => 'number');
						$data['chart'][$key]['cols'][] = array('id' => slug($kindicador)."-tooltip",'label' => $kindicador, 'type' => 'string', 'p' => array('role' => 'tooltip', 'html' => true));
				endswitch;
			endforeach;
		endforeach;

		/*Generando filas para gráficas y columnas para la tabla*/
		$setDataTableRows = false;
		foreach ($periodos as $periodo):
			foreach ($charts as $key => $chart):
				$c = array();
				$c[] = array(
						'v' => $periodo
					);
				foreach ($indicadores as $kindicador => $vindicador):
					$value = $vindicador[$periodo][$key];
					$tooltipv = $value;
					switch ($key):
						case 'citas':
							// print_r($vindicador[$periodo]);die();
							$porcentajeAutocita = $vindicador[$periodo]['porcentajeAutoCita'] != NULL ? $vindicador[$periodo]['porcentajeAutoCita'] : 0;
							$citas = round($value * (1 - ($porcentajeAutocita / 100)));
							$autocitas = round($value * ($porcentajeAutocita / 100));
							$c[] = array(
								'v' => $autocitas
							);
							$c[] = array(
								'v' => _sprintf("<div class=\"text-center nowrap\"><b>%s</b></div><div class=\"text-center nowrap\">{$charts[$key]['tooltip']}</div>", $kindicador, $periodo, $autocitas)
							);
							$c[] = array(
								'v' => $citas
							);
							$c[] = array(
								'v' => _sprintf("<div class=\"text-center nowrap\"><b>%s</b></div><div class=\"text-center nowrap\">{$charts[$key]['tooltip']}</div>", $kindicador, $periodo, $citas)
							);
							break;
						case 'vidaMedia':
							$value = $value == '>10,0' ? 10.1 : $value;
							$tooltipv = $value == 10.1 ? '>10.0' : $value;
						default:
							$c[] = array(
								'v' => $value
							);
							$c[] = array(
								'v' => _sprintf("<div class=\"text-center nowrap\"><b>%s</b></div><div class=\"text-center nowrap\">{$charts[$key]['tooltip']}</div>", $kindicador, $periodo, $tooltipv)
							);
					endswitch;
				endforeach;
				$data['chart'][$key]['rows'][]['c'] = $c;
			endforeach;
		endforeach;
		/*Opciones de la gráfica*/
		$data['options']['bar'] = array(
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
						'title'=> _sprintf('Fuente: %s', 'biblat.unam.mx'),
						'titlePosition' => 'in',
						'titleTextStyle' => array(
							'bold' => FALSE,
							'italic' => TRUE
							),
						'vAxis' => array(
								'title' => _('Número de citas recibidas'),
								'minValue' => 0
							),
						'series' => array(),
						'width' => '1000px',
						'chartArea' => array(
							'left' => 100,
							'top' => 40,
							'width' => "70%",
							'height' => "80%"
							),
						'backgroundColor' => array(
							'fill' => '#FAFAFA'
							)
						);
		for ($i=1; $i < $query->num_rows(); $i++):
			$data['options']['bar']['vAxes'][$i] = array(
				'title' => '',
				'textStyle' => array(
					'fontSize' => 0
					)
				);
			$data['options']['bar']['axes']['y'][$i] = array(
				'side' => 'right'
				);
			$data['options']['bar']['series'][$i*2] = array('targetAxisIndex' => $i);
			$data['options']['bar']['series'][($i*2)+1] = array('targetAxisIndex' => $i);
		endfor;
		$data['options']['line'] = array(
						'animation' => array(
								'duration' => 1000
							), 
						'height' => '500',
						'hAxis' => array(
								'title' => _('Año')
							), 
						'legend' => array(
								'position' => 'right',
								'maxLines' => 2
							),
						'title'=> _sprintf('Fuente: %s', 'biblat.unam.mx'),
						'titlePosition' => 'in',
						'titleTextStyle' => array(
							'bold' => FALSE,
							'italic' => TRUE
							),
						'pointSize' => 3,
						'tooltip' => array(
								'isHtml' => true
							),
						'width' => '1000',
						'chartArea' => array(
							'left' => 10,
							'top' => 40,
							'width' => "70%",
							'height' => "80%"
							),
						'backgroundColor' => array(
							'fill' => '#FAFAFA'
							)
						);
		header('Content-Type: application/json');
		echo json_encode($data, true);
	}

	/*Periodos*/

	public function getPeriodosCollectionEdadTipoDoc(){
		$query = "";
		/*Consulta para cada indicador*/
		$indicadorTabla['distribucion-articulos-coleccion']="networkDistribution";
		$indicadorTabla['distribucion-articulos-coleccion-area']="networkAreaDistribution";
		$indicadorTabla['distribucion-articulos-coleccion-area-revista']="networkAreaJournalDistribution";
		$indicadorTabla['distribucion-articulos-coleccion-revista']="networkJournalDistribution";
		$indicadorTabla['distribucion-articulos-coleccion-afiliacion']="networkAffiliationDistribution";
		$indicadorTabla['distribucion-revista-coleccion']="networkDistribution";
		$indicadorTabla['citacion-articulos-edad']="ageDocCitation";
		$indicadorTabla['citacion-articulos-edad-area']="ageDocAreaCitation";
		$indicadorTabla['citacion-articulos-edad-revista']="ageDocJournalCitation";
		$indicadorTabla['citacion-articulos-edad-afiliacion']="ageDocAffiliationCitation";
		$indicadorTabla['citacion-articulos-tipo']="docTypeCitation";
		$indicadorTabla['citacion-articulos-tipo-area']="docTypeAreaCitation";
		$indicadorTabla['citacion-articulos-tipo-revista']="docTypeJournalCitation";
		$indicadorTabla['citacion-articulos-tipo-afiliacion']="docTypeAffiliationCitation";
		$query = "SELECT min(anio) AS \"anioBase\", max(anio) AS \"anioFinal\" FROM \"{$indicadorTabla[$_POST['indicador']]}\"";
		if (isset($_POST['coleccion']) && count($_POST['coleccion']) > 0):
			$query .= " WHERE \"networkId\" IN (";
			$offset=1;
			$total= count($_POST['coleccion']);
			foreach ($_POST['coleccion'] as $coleccion):
				$query .= "'{$this->colecciones['slug'][$coleccion]['id']}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;

		if (isset($_POST['edad']) && count($_POST['edad']) > 0):
			$query .= " WHERE \"rango\" IN (";
			$offset=1;
			$total= count($_POST['edad']);
			foreach ($_POST['edad'] as $edad):
				$query .= "'{$edad}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;

		if (isset($_POST['tipodoc']) && count($_POST['tipodoc']) > 0):
			$query .= " WHERE \"docTypeId\" IN (";
			$offset=1;
			$total= count($_POST['tipodoc']);
			foreach ($_POST['tipodoc'] as $tipodoc):
				$query .= "'{$this->docTypes['slug'][$tipodoc]['id']}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
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

		return $query;
	}

	public function getPeriodosGeneral(){
		$query = "";
		$query = "SELECT min(anio) AS \"anioBase\", max(anio) AS \"anioFinal\" FROM \"indicadoresGeneralesRevista\"";
		if (isset($_POST['coleccion']) && count($_POST['coleccion']) > 0):
			$query .= " WHERE \"networkId\" IN (";
			$offset=1;
			$total= count($_POST['coleccion']);
			foreach ($_POST['coleccion'] as $coleccion):
				$query .= "'{$this->colecciones['slug'][$coleccion]['id']}'";
				if($offset < $total):
					$query .=",";
				endif;
				$offset++;
			endforeach;
			$query .= ")";
		endif;
		if (isset($_POST['revista']) && count($_POST['revista']) > 0):
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
		return $query;
	}

	/*Opciones*/
	public function getRevistaAfiliacionCollection(){
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

	public function getRevistaAfiliacionEdad(){
		$this->load->database();
		$offset=1;
		$total= count($_POST['edad']);
		$edadIN = "";
		foreach ($_POST['edad'] as $edad):
			$edadIN .= "'{$edad}'";
			if($offset < $total):
				$edadIN .=",";
			endif;
			$offset++;
		endforeach;
		$query = "SELECT revista, \"revistaSlug\" FROM \"ageDocJournalCitation\" WHERE \"rango\" IN(${edadIN}) ORDER BY \"revistaSlug\"";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$data['revistas'][$row['revistaSlug']] = htmlspecialchars($row['revista']);
		endforeach;

		$query = "SELECT pais, \"paisSlug\" FROM \"ageDocAffiliationCitation\" WHERE \"rango\" IN(${edadIN}) ORDER BY \"paisSlug\"";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$data['paises'][$row['paisSlug']] = htmlspecialchars($row['pais']);
		endforeach;

		$this->db->close();
		header('Content-Type: application/json');
		echo json_encode($data, true);
	}

	public function getRevistaAfiliacionTipoDoc(){
		$this->load->database();
		$offset=1;
		$total= count($_POST['tipodoc']);
		$tipodocIN = "";
		foreach ($_POST['tipodoc'] as $tipodoc):
			$tipodocIN .= "'{$this->docTypes['slug'][$tipodoc]['id']}'";
			if($offset < $total):
				$tipodocIN .=",";
			endif;
			$offset++;
		endforeach;
		$query = "SELECT revista, \"revistaSlug\" FROM \"docTypeJournalCitation\" WHERE \"docTypeId\" IN(${tipodocIN}) ORDER BY \"revistaSlug\"";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$data['revistas'][$row['revistaSlug']] = htmlspecialchars($row['revista']);
		endforeach;

		$query = "SELECT pais, \"paisSlug\" FROM \"docTypeAffiliationCitation\" WHERE \"docTypeId\" IN(${tipodocIN}) ORDER BY \"paisSlug\"";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$data['paises'][$row['paisSlug']] = htmlspecialchars($row['pais']);
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

	public function getRevistasGeneral(){
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
		$query = "SELECT \"networkId\", journal, \"revistaSlug\" FROM \"indicadoresGeneralesRevista\" WHERE \"networkId\" IN({$coleccionIN}) ORDER BY \"revistaSlug\"";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$networkName = $this->colecciones['id'][$row['networkId']]['name'];
			$data['revistas'][$networkName][$row['revistaSlug']] = htmlspecialchars($row['journal']);
		endforeach;

		$this->db->close();
		header('Content-Type: application/json');
		echo json_encode($data, true);
	}

}

/* End of file indicadores.php */
/* Location: ./application/controllers/indicadores.php */