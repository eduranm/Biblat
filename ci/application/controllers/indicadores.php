<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicadores extends CI_Controller {

	public $indicadores = array();
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
		$this->load->driver('minify');
		/*Variables globles*/
		$data = array();
		/*Lista de indicadores*/
		$data['indicadores'] = array(
								'indice-coautoria' => _('Índice de coautoría'),
								'tasa-documentos-coautorados' => _('Tasa de documentos coautorados'),
								'grado-colaboracion' => _('Grado de colaboración (Índice Subramayan)'),
								'modelo-elitismo' => _('Modelo de elitismo (Price)'),
								'indice-colaboracion' => _('Índice de colaboración (Índice de Lawani)'),
								'indice-densidad-documentos' => _('Índice de densidad de documentos Zakutina y Priyenikova'),
								'indice-concentracion' => _('Índice de concentración (Índice Pratt)'),
								'modelo-bradford-revista' => _('Modelo de Bradford por revista'),
								'modelo-bradford-institucion' => _('Modelo de Bradford por institución (Afiliación del autor)'),
								'productividad-exogena' => _('Tasa de autoría exógena') 
							);
		$this->indicadores = $data['indicadores'];
		/*Disciplinas*/
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

		$this->load->vars($data);

		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}

	public function index($indicador="")
	{
		$data = array();
		$data['main']['indicador'] = $indicador;

		/*Vistas*/
		$js = $this->load->view('indicadores/index_js', $data['header'], TRUE);
		$data['header']['js'] = $this->minify->js->min($js);
		//$data['header']['js'] = $js;
		$data['header']['content'] =  $this->load->view('indicadores/header', $data['header'], TRUE);
		unset($data['header']['js']);
		$data['header']['title'] = _sprintf('Biblat - Indicador: %s', $this->indicadores[$data['main']['indicador']]);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('indicadores/index', $data['main']);
		$this->load->view('footer');
	}

	public function getChartData(){
		$this->output->enable_profiler(false);
		$data['data']['cols'][] = array('id' => 'year','label' => _('Año'),'type' => 'string');
		$this->load->database();
		/*Convirtiendo el periodo en dos fechas*/
		$_POST['periodo'] = explode(";", $_POST['periodo']);
		/*Generamos el arreglo de periodos*/
		$periodos = $this->getPeriodos($_POST);
		
		/*Consulta para cada indicador*/
		$indicador['indice-coautoria'] = array(
			'campoTabla' => "coautoria AS valor FROM \"mvIndiceCoautoriaPrice",
			'title' => array(
					'revista' => '<div class="centrado"><b>'._('Índice de Coautoría').'</b><br/>'._('Media de autores por artículo en la revista').'</div>',
					'pais' => '<div class="centrado"><b>'._('Índice de Coautoría').'</b><br/>'._('Media de autores por articulo en las revistas del país').'</div>',
				),
			'vTitle' => _('Índice de Coautoría'),
			'hTitle' => _('Año'),
			'tooltip' => array(
					'revista' => _('Promedio de autores por artículo en el año %s: %s'),
					'pais' => _('Promedio de autores por artículo en las revistas del país en el año %s: %s')
				)
			);
		$indicador['tasa-documentos-coautorados'] = array(
			'campoTabla' => "\"tasaCoautoria\" AS valor FROM \"mvTasaCoautoria",
			'title' => array(
					'revista' => '<div class="centrado"><b>'._('Tasa de Documentos Coautorados').'</b><br/>'._('Media de documentos con autoría múltiple por revista').'</div>',
					'pais' => '<div class="centrado"><b>'._('Tasa de Documentos Coautorados').'</b><br/>'._('Media de documentos con autoría múltiple en las revistas del país').'</div>',
				),
			'vTitle' => _('Tasa de documentos'),
			'hTitle' => _('Año'),
			'tooltip' => array(
					'revista' => _('Promedio de artículos en coautoría en el año %s: %s'),
					'pais' => _('Promedio de artículos en coautoría en las revistas del país en el año %s: %s')
				)
			);
		$indicador['grado-colaboracion'] = array(
			'campoTabla' => "subramayan AS valor FROM \"mvSubramayan",
			'title' => array(
					'revista' => '<div class="centrado"><b>'._('Grado de Colaboración (Índice de Subramayan)').'</b><br/>'._('Proporción de artículos con autoría múltiple').'</div>',
					'pais' => '<div class="centrado"><b>'._('Grado de Colaboración (Índice de Subramayan)').'</b><br/>'._('Proporción de artículos con autoría múltiple en las revistas del país').'</div>',
				),
			'vTitle' => _('Grado de Colaboración'),
			'hTitle' => _('Año'),
			'tooltip' => array(
					'revista' => _('Promedio de artículos con autoría múltiple en el año %s: %s'),
					'pais' => _('Promedio de artículos con autoría múltiple en las revistas del país en el año %s: %s')
				)
			);
		$indicador['modelo-elitismo'] = array(
			'campoTabla' => "price AS valor FROM \"mvIndiceCoautoriaPrice",
			'title' => array(
					'revista' => '<div class="centrado"><b>'._('Modelo de Elitismo (Price)').'</b><br/>'._('Grupo de autores más productivos por revista').'</div>',
					'pais' => '<div class="centrado"><b>Modelo de Elitismo (Price)</b><br/>Grupo de autores más productivos por revista</div>',
				),
			'vTitle' => _('Cantidad de autores'),
			'hTitle' => _('Año'),
			'tooltip' => array(
					'revista' => _('Cantidad de autores que conforman la elite en el año %s: %s'),
					'pais' => _('Cantidad de autores que conforman la elite en el año %s: %s')
				)
			);
		$indicador['indice-colaboracion'] = array(
			'campoTabla' => "lawani AS valor FROM \"mvLawani",
			'title' => array(
					'revista' => '<div class="centrado"><b>'._('Índice de Colaboración (Índice de Lawani)').'</b><br/>'._('Peso promedio de autores por artículo.').'</div>',
					'pais' => '<div class="centrado"><b>'._('Índice de Colaboración (Índice de Lawani)').'</b><br/>'._('Peso promedio del número de autores por artículo en las revistas del país').'</div>',
				),
			'vTitle' => _('Índice de Colaboración'),
			'hTitle' => _('Año'),
			'tooltip' => array(
					'revista' => _('Promedio de coautores por artículo en el año %s: %s'),
					'pais' => _('Promedio de coautores por articulo en las revistas del país en el año %s: %s')
				)
			);
		$indicador['indice-densidad-documentos'] = array(
			'campoTabla' => "zakutina AS valor FROM \"mvZakutina",
			'title' => array(
					'revista' => '<div class="centrado"><b>'._('Índice de Densidad de Documentos Zakutina y Priyenikova').'</b><br/>'._('Títulos con mayor cantidad de artículos').'</div>'
				),
			'vTitle' => _('Índice de densidad'),
			'hTitle' => _('Año'),
			'tooltip' => array(
					'revista' => _('Cantidad de documentos por revista en el año %s: %s'),
				)
			);
		$indicadorCampoTabla['productividad-exogena']="";

		$selection = 'revista'; 
		if (isset($_POST['revista'])):
			$data['dataTable']['cols'][] = array('id' => '', 'label' => _('Revista/Año'), 'type' => 'string');
			$query = "SELECT revista AS title, anio, {$indicador[$_POST['indicador']]['campoTabla']}Revista\" WHERE \"revistaSlug\" IN (";
			$revistaOffset=1;
			$revistaTotal= count($_POST['revista']);
			foreach ($_POST['revista'] as $revista):
				$query .= "'{$revista}'";
				if($revistaOffset < $revistaTotal):
					$query .=",";
				endif;
				$revistaOffset++;
			endforeach;
			$query .=") AND anio BETWEEN '{$_POST['periodo'][0]}' AND '{$_POST['periodo'][1]}'";
		elseif (isset($_POST['pais'])):
			$data['dataTable']['cols'][] = array('id' => '', 'label' => _('País/Año'), 'type' => 'string');
			$selection = 'pais';
			$query = "SELECT \"paisRevista\" AS title, anio, {$indicador[$_POST['indicador']]['campoTabla']}Pais\" WHERE \"paisRevistaSlug\" IN (";
			$paisOffset=1;
			$paisTotal= count($_POST['pais']);
			foreach ($_POST['pais'] as $pais):
				$query .= "'{$pais}'";
				if($paisOffset < $paisTotal):
					$query .=",";
				endif;
				$paisOffset++;
			endforeach;
			$query .=") AND anio BETWEEN '{$_POST['periodo'][0]}' AND '{$_POST['periodo'][1]}' AND id_disciplina='{$this->disciplinas[$_POST['disciplina']]['id_disciplina']}'";
		endif;


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
			$data['dataTable']['cols'][] = array('id' => '','label' => $periodo, 'type' => 'string');
			$c = array();
			$c[] = array(
					'v' => $periodo
				);
			foreach ($indicadores as $kindicador => $vindicador):
				$c[] = array(
					'v' => $vindicador[$periodo]
				);
				$c[] = array(
					'v' => _sprintf("<div class=\"centrado\"><b>%s</b></div><div class=\"centrado\">{$indicador[$_POST['indicador']]['tooltip'][$selection]}</div>", $kindicador, $periodo, $vindicador[$periodo])
				);
				/*dataTable rows*/
				if( ! $setDataTableRows ):
					$cc = array();
					$cc[] = array(
						'v' => $kindicador
					);
					foreach ($periodos as $periodoDT):
						$cc[] = array(
							'v' => $vindicador[$periodoDT] != null ? number_format($vindicador[$periodoDT], 2, '.', '') : null
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
							)
						);
		/*Opciones para la tabla*/
		$data['tableOptions'] = array(
				'allowHtml' => true,
				'showRowNumber' => false
			);
		/*Titulo de la gráfica*/
		$data['chartTitle'] = $indicador[$_POST['indicador']]['title'][$selection];
		$data['tableTitle'] = "<div class=\"textoTitulo centrado\">{$this->indicadores[$_POST['indicador']]}</div>";
		header('Content-Type: application/json');
		echo json_encode($data, true);
	}

	public function getChartDataBradford(){
		$this->output->enable_profiler(false);
		$indicador['modelo-bradford-revista'] = array(
				'sufix' => "Revista",
				'title' => '<div class="centrado"><b>'._('Modelo matemático de Bradford').'</b><br/>'._('Distribución de artículos por revista').'</div>',
				'tableTitle' => '<h3>'._('Modelo matemático de Bradford').'</h3>',
				'hAxisTitle' => _('Logaritmo de la cantidad acumulada de títulos de revista'),
				'hAxisTitleGroup' => _('Títulos de revista'),
				'titleGroup' => '<div class="centrado"><b>'._('Modelo matemático de Bradford').'</b><br/>'._('Zona %s de revistas más productivas').'</div>',
				'tableTitleGroup' => '<h3>'._('Zona %s de revistas más productivas').'</h3>'
			);
		$indicador['modelo-bradford-institucion'] = array(
				'sufix' => "Institucion",
				'title' => '<div class="centrado"><b>'._('Modelo matemático de Bradford').'</b><br/>'._('Distribución de artículos por instituciones.').'</div>',
				'tableTitle' => '<h3>'._('Modelo matemático de Bradford por institución (afiliación del autor)').'</h3>',
				'hAxisTitle' => _('Logaritmo de la cantidad acumulada de instituciones'),
				'hAxisTitleGroup' => _('Institución'),
				'titleGroup' => '<div class="centrado"><b>'._('Modelo matemático de Bradford por institución (afiliación del autor)').'</b><br/>'._('Zona %s de instituciones más productivas por disciplina').'</div>',
				'tableTitleGroup' => '<h3>'._('Zona %s de instituciones más productivas por disciplina').'</h3>'
			);
		$idDisciplina=$this->disciplinas[$_POST['disciplina']]['id_disciplina'];
		$query = "SELECT articulos, frecuencia, \"articulosXfrecuenciaAcumulado\", \"logFrecuenciaAcumulado\" FROM \"vBradford{$indicador[$_POST['indicador']]['sufix']}\" WHERE id_disciplina={$idDisciplina}";
		$query = $this->db->query($query);
		/*Ultimo valor del arreglo*/
		$last = current(array_slice($query->result_array(), -1));
		$promedio = $last['articulosXfrecuenciaAcumulado']/3;
		$grupos = array();
		/*Variables para las gráficas*/
		$result = array();
		$result['chart']['bradford'] = array();
		/*Columnas*/
		$result['chart']['bradford']['cols'][] = array('id' => '','label' => _('log(fx)'),'type' => 'number');
		$result['chart']['bradford']['cols'][] = array('id' => '','label' => 'tooltip', 'type' => 'string', 'p' => array('role' => 'tooltip', 'html' => true));
		$result['chart']['bradford']['cols'][] = array('id' => '','label' => _('Zona núcleo'),'type' => 'number');
		$result['chart']['bradford']['cols'][] = array('id' => '','label' => _('Zona 2'),'type' => 'number');
		$result['chart']['bradford']['cols'][] = array('id' => '','label' => _('Zona 3'),'type' => 'number');
		/*Columnas de la tabla de bradford*/
		$result['table']['bradford']['cols'][] = array('id' => '','label' => _('Logaritmo de la cantidad acumulada de títulos de revista'),'type' => 'number');
		$result['table']['bradford']['cols'][] = array('id' => '','label' => _('Cantidad acumulada de artículos'),'type' => 'number');
		/*Generando filas*/
		$firstGroup = array(
				'2' => false,
				'3' => false
			);
		$rowNumber=0;
		/*Segmentando grupos*/
		foreach ($query->result_array() as $row):
			$articulosXfrecuenciaAcumulado = (int)$row['articulosXfrecuenciaAcumulado'];
			$articuloXfrecuencia = $row['articulos'] * $row['frecuencia'];
			if ($articulosXfrecuenciaAcumulado < $promedio):
				$grupos['1']['lim']['y'] = $articulosXfrecuenciaAcumulado;
				$grupos['1']['titulos']++;
				$grupos['1']['articulos'] = $articulosXfrecuenciaAcumulado;
			elseif ($articulosXfrecuenciaAcumulado > $promedio && ($articulosXfrecuenciaAcumulado - $promedio) < ($articuloXfrecuencia / 2)):
				$grupos['1']['lim']['y'] = $articulosXfrecuenciaAcumulado;
				$grupos['1']['titulos']++;
				$grupos['1']['articulos'] = $articulosXfrecuenciaAcumulado;
			elseif ($articulosXfrecuenciaAcumulado < ($promedio * 2)):
				$grupos['2']['lim']['y'] = $articulosXfrecuenciaAcumulado;
				$grupos['2']['titulos']++;
				$grupos['2']['articulos'] = $articulosXfrecuenciaAcumulado - $grupos['1']['lim']['y'];
			elseif ($articulosXfrecuenciaAcumulado > ($promedio * 2) && ($articulosXfrecuenciaAcumulado - ($promedio * 2)) < ($articuloXfrecuencia / 2)):
				$grupos['2']['lim']['y'] = $articulosXfrecuenciaAcumulado;
				$grupos['2']['titulos']++;
				$grupos['2']['articulos'] = $articulosXfrecuenciaAcumulado - $grupos['1']['lim']['y'];
			else:
				$grupos['3']['lim']['y'] = $articulosXfrecuenciaAcumulado;
				$grupos['3']['titulos']++;
				$grupos['3']['articulos'] = $articulosXfrecuenciaAcumulado - $grupos['2']['lim']['y'];
			endif;
		endforeach;
		/*Agregado columnas a la fila*/
		foreach ($query->result_array() as $row):
			$articulosXfrecuenciaAcumulado = (int)$row['articulosXfrecuenciaAcumulado'];
			$c = array();
			$c[] = array('v' => round($row['logFrecuenciaAcumulado'], 4));
			$ct = array();
			$ct[] = array('v' => number_format($row['logFrecuenciaAcumulado'], 4, '.', ''));
			$ct[] = array('v' => $articulosXfrecuenciaAcumulado);
			if($articulosXfrecuenciaAcumulado <= $grupos['1']['lim']['y']):
				$c[] = array('v' => '<div class="chartTootip"><span style="color:#3366cc;">&#9632; </span>'._('Zona núcleo').'<br/>'._sprintf('Artículos: %s', $grupos['1']['articulos']).'<br/>'._sprintf('Títulos de revista: %s', $grupos['1']['titulos']).' </div>');
				$c[] = array('v' => $articulosXfrecuenciaAcumulado);
				$c[] = array('v' => null);
				$c[] = array('v' => null);
				$grupos['1']['lim']['x'] = $c[0]['v'];
			elseif ($articulosXfrecuenciaAcumulado <= $grupos['2']['lim']['y']):
				if(!$firstGroup['2']):
					$cc = array();
					$cc[] = array('v' => round($row['logFrecuenciaAcumulado'], 4));
					$cc[] = array('v' => '<div class="chartTootip"><span style="color:#3366cc;">&#9632; </span>'._('Zona núcleo').'<br/>'._sprintf('Artículos: %s', $grupos['1']['articulos']).'<br/>'._sprintf('Títulos de revista: %s', $grupos['1']['titulos']).' </div>');
					$cc[] = array('v' => $articulosXfrecuenciaAcumulado);
					$cc[] = array('v' => null);
					$cc[] = array('v' => null);
					$result['chart']['bradford']['rows'][]['c'] = $cc;
					$firstGroup['2'] = true;
					$rowNumber++;
				endif;
				$c[] = array('v' => '<div class="chartTootip"><span style="color:#3366cc;">&#9632; </span>'._('Zona 2').'<br/>'._sprintf('Artículos: %s', $grupos['2']['articulos']).'<br/>'._sprintf('Títulos de revista: %s', $grupos['2']['titulos']).' </div>');
				$c[] = array('v' => null);
				$c[] = array('v' => $articulosXfrecuenciaAcumulado);
				$c[] = array('v' => null);
				$grupos['2']['lim']['x'] = $c[0]['v'];
			else:
				if(!$firstGroup['3']):
					$cc = array();
					$cc[] = array('v' => round($row['logFrecuenciaAcumulado'], 4));
					$cc[] = array('v' => '<div class="chartTootip"><span style="color:#3366cc;">&#9632; </span>'._('Zona 2').'<br/>'._sprintf('Artículos: %s', $grupos['2']['articulos']).'<br/>'._sprintf('Títulos de revista: %s', $grupos['2']['titulos']).' </div>');
					$cc[] = array('v' => null);
					$cc[] = array('v' => $articulosXfrecuenciaAcumulado);
					$cc[] = array('v' => null);
					$result['chart']['bradford']['rows'][]['c'] = $cc;
					$firstGroup['3'] = true;
					$rowNumber++;
				endif;
				$c[] = array('v' => '<div class="chartTootip"><span style="color:#3366cc;">&#9632; </span>'._('Zona 3').'<br/>'._sprintf('Artículos: %s', $grupos['3']['articulos']).'<br/>'._sprintf('Títulos de revista: %s', $grupos['3']['titulos']).' </div>');
				$c[] = array('v' => null);
				$c[] = array('v' => null);
				$c[] = array('v' => $articulosXfrecuenciaAcumulado);
				$grupos['3']['lim']['x'] = $c[0]['v'];
			endif;
			$result['chart']['bradford']['rows'][]['c'] = $c;
			$result['table']['bradford']['rows'][]['c'] = $ct;
			$rowNumber++;
		endforeach;
		/*Opciones de la gráfica de bradford*/
		$result['options']['bradford'] = array(
						'animation' => array(
								'duration' => 1000
							), 
						'curveType' => 'function',
						'focusTarget' => 'category',
						'height' => '500',
						'hAxis' => array(
								'title' => $indicador[$_POST['indicador']]['hAxisTitle'],
							), 
						'legend' => array(
								'position' => 'right'
							),
						'pointSize' => 0, 
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => _('Cantidad acumulada de artículos'),
								'minValue' => 0
							),
						'width' => '925',
						'chartArea' => array(
							'left' => 120,
							'top' => 50,
							'width' => 675,
							'height' => "80%"
							),
						'seriesType' => 'area',
						'series' => array(
								0 => array(
									'color' => '#3366cc'
									),
								1 => array(
									'color' => '#dc3912'
									),
								2 => array(
									'color' => '#ff9900'
									)
							),
						'tooltip' => array(
								'isHtml' => true
							)
						);
		/*Creando lista de revistas con su total de articulos agrupados según los límites calculados anteriormente*/
		$column = strtolower($indicador[$_POST['indicador']]['sufix']);
		$query = "SELECT {$column}, \"{$column}Slug\" AS slug, articulos FROM \"mvArticulosDisciplina{$indicador[$_POST['indicador']]['sufix']}\" WHERE id_disciplina={$idDisciplina} ORDER BY articulos DESC";
		$query = $this->db->query($query);
		$revistaInstitucion = array();
		foreach ($query->result_array() as $row) :
			$acumulado += $row['articulos'];
			$rowData['articulos'] = $row['articulos'];
			$rowData['slug'] = $row['slug'];
			if ($acumulado <= $grupos['1']['lim']['y']):
				$revistaInstitucion['1'][$row[$column]] = $rowData;
			elseif ($acumulado <= $grupos['2']['lim']['y']):
				$revistaInstitucion['2'][$row[$column]] = $rowData;
			else:
				$revistaInstitucion['3'][$row[$column]] = $rowData;
			endif;
		endforeach;
		/*Ordenando grupos alfabeticamnete*/
		//ksort($revistaInstitucion['1']);
		//ksort($revistaInstitucion['2']);
		//ksort($revistaInstitucion['3']);
		/*Datos para la gráfica del grupo1*/
		$result['chart']['group1']['cols'][] = array('id' => '','label' => _('Títulos de revista'),'type' => 'string');
		$c = array();
		$c[] = array('v' => '');
		/*Columnas de la tabla del grupo1*/
		$result['table']['group1']['cols'][] = array('id' => '','label' => _('Título de revista'),'type' => 'number');
		$result['table']['group1']['cols'][] = array('id' => '','label' => _('Cantidad de artículos'),'type' => 'number');
		/*Agregado filas y columnas*/
		foreach ($revistaInstitucion['1'] as $label => $value):
			$result['chart']['group1']['cols'][] = array('id' => $value['slug'],'label' => $label,'type' => 'number');
			$result['chart']['group1']['cols'][] = array('id' => '','label' => 'tooltip', 'type' => 'string', 'p' => array('role' => 'tooltip', 'html' => true));
			$c[] = array(
					'v' => (int)$value['articulos']
				);
			$c[] = array(
					'v' =>  sprintf('<div class="chartTootip"><b>%s</b><br/>', $label)._sprintf('Cantidad de artículos: %s', $value['articulos']).'</div>'
				);
			/*Agregando filas a la tabla*/
			$ct = array();
			$ct[] = array('v' => $label);
			$ct[] = array('v' => (int)$value['articulos']);
			$result['table']['group1']['rows'][]['c'] = $ct;
		endforeach;
		$result['chart']['group1']['rows'][]['c'] = $c;
		/*Datos para la gráfica del grupo2*/
		$result['chart']['group2']['cols'][] = array('id' => '','label' => _('Títulos de revista'),'type' => 'string');
		$c = array();
		$c[] = array('v' => '');
		/*Columnas de la tabla del grupo2*/
		$result['table']['group2']['cols'][] = array('id' => '','label' => _('Título de revista'),'type' => 'number');
		$result['table']['group2']['cols'][] = array('id' => '','label' => _('Cantidad de artículos'),'type' => 'number');
		/*Agregado filas y columnas*/
		foreach ($revistaInstitucion['2'] as $label => $value):
			$result['chart']['group2']['cols'][] = array('id' => $value['slug'],'label' => $label,'type' => 'number');
			$result['chart']['group2']['cols'][] = array('id' => '','label' => 'tooltip', 'type' => 'string', 'p' => array('role' => 'tooltip', 'html' => true));
			$c[] = array(
					'v' => (int)$value['articulos']
				);
			$c[] = array(
					'v' => sprintf('<div class="chartTootip"><b>%s</b><br/>', $label)._sprintf('Cantidad de artículos: %s', $value['articulos']).'</div>'
				);
			/*Agregando filas a la tabla*/
			$ct = array();
			$ct[] = array('v' => $label);
			$ct[] = array('v' => (int)$value['articulos']);
			$result['table']['group2']['rows'][]['c'] = $ct;
		endforeach;
		$result['chart']['group2']['rows'][]['c'] = $c;
		/*Columnas de la tabla del grupo3*/
		$result['table']['group3']['cols'][] = array('id' => '','label' => _('Título de revista'),'type' => 'number');
		$result['table']['group3']['cols'][] = array('id' => '','label' => _('Cantidad de artículos'),'type' => 'number');
		/*Agregado filas y columnas*/
		foreach ($revistaInstitucion['3'] as $revista => $articulos):
			/*Agregando filas a la tabla*/
			$ct = array();
			$ct[] = array('v' => $revista);
			$ct[] = array('v' => (int)$articulos);
			$result['table']['group3']['rows'][]['c'] = $ct;
		endforeach;
		/*Opciones de la gráfica de los grupos*/
		$result['options']['groups'] = array(
						'animation' => array(
								'duration' => 1000
							),
						'bar' => array(
								'groupWidth' => '85%'
							),
						'height' => '500',
						'hAxis' => array(
								'title' => $indicador[$_POST['indicador']]['hAxisTitleGroup'],
							), 
						'legend' => array(
								'position' => 'right'
							),
						'pointSize' => 1, 
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => _('Cantidad de artículos'),
								'minValue' => 0
							),
						'width' => '925',
						'chartArea' => array(
							'left' => 120,
							'top' => 50,
							'width' => 675,
							'height' => "80%"
							),
						'tooltip' => array(
								'isHtml' => true
							)
						);

		$result['last'] = $last;
		$result['grupos'] = $grupos;
		$result['revistaInstitucion'] = $revistaInstitucion;
		$result['title']['bradford'] = $indicador[$_POST['indicador']]['title'];
		$result['title']['group1'] = _sprintf($indicador[$_POST['indicador']]['titleGroup'], "núcleo");
		$result['title']['group2'] = _sprintf($indicador[$_POST['indicador']]['titleGroup'], "2");
		$result['table']['title']['bradford'] = $indicador[$_POST['indicador']]['tableTitle'];
		$result['table']['title']['group1'] = _sprintf($indicador[$_POST['indicador']]['tableTitleGroup'], "núcleo");
		$result['table']['title']['group2'] = _sprintf($indicador[$_POST['indicador']]['tableTitleGroup'], "2");
		$result['table']['title']['group3'] = _sprintf($indicador[$_POST['indicador']]['tableTitleGroup'], "3");
		/*Opciones para la tabla*/
		$result['tableOptions'] = array(
				'allowHtml' => true,
				'showRowNumber' => false
			);
		$result['tblGrpOpt'] = array(
				'allowHtml' => true,
				'showRowNumber' => true
			);
		header('Content-Type: application/json');
		echo json_encode($result, true);
	}

	public function getChartDataPrattExogena($limit=10){
		//$limit *= 2;
		$this->output->enable_profiler(false);
		$idDisciplina=$this->disciplinas[$_POST['disciplina']]['id_disciplina'];
		$indicador['indice-concentracion'] = array(
				'sql' => "SELECT revista, \"revistaSlug\", pratt AS indicador FROM \"mvPratt\" WHERE id_disciplina={$idDisciplina} ORDER BY indicador DESC",
				'title' => _('Índice de concentración temática'), 
				'chartTitle' => '<div id="chartTitle"><div class="centrado"><b>'._('Índice de concentración (Índice de Pratt)').'</b><br/>'._('Distribución decreciente de las revistas considerando su grado de concentración temática').'</div></div>',
				'tooltip' => "<div class=\"centrado\"><b>%s</b></div><div class=\"centrado\">Nivel de especialización de la revista: %s</div>"
			);
		$indicador['productividad-exogena'] = array(
				'sql' => "SELECT revista, \"revistaSlug\", exogena AS indicador FROM \"mvProductividadExogena\" WHERE id_disciplina={$idDisciplina} ORDER BY indicador DESC",
				'title' => _('Proporción de autoría exógena'), 
				'chartTitle' => '<div id="chartTitle" class="centrado"><b>'._('Tasa de autoría exógena').'</b><br/>'._('Distribución decreciente de las revistas considerando la proporción de autoría exógena').'</div>',
				'tooltip' => "<div class=\"centrado\"><b>%s</b></div><div class=\"centrado\">Proporción de autores extranjeros: %s</div>"
			);
		$query = $indicador[$_POST['indicador']]['sql'];
		$query = $this->db->query($query);
		$offset = 0;
		$grupo = 0;
		$c = array();
		$result['chart'] = array();
		$result['journal'] = array();
		$totalRows = $query->num_rows();
		$first = current(array_slice($query->result_array(), 0));
		$vAxisMax = round($first['indicador'], 1) + 1/10;
		$result['table']['cols'][] = array('id' => '','label' => _('Título de revista'),'type' => 'string');
		$result['table']['cols'][] = array('id' => '','label' => $indicador[$_POST['indicador']]['title'],'type' => 'number');
		foreach ($query->result_array() as $row):
			if(!isset($result['chart'][$grupo])):
				$result['chart'][$grupo]['cols'][] = array('id' => '','label' => _('Título de revista'),'type' => 'string');
				$c = array();
				$c[] = array('v' => '');
				$result['journal'][$grupo]=array();
			endif;
			$result['journal'][$grupo][] = $row['revistaSlug'];
			$result['chart'][$grupo]['cols'][] = array('id' => '','label' => $row['revista'],'type' => 'number');
			$result['chart'][$grupo]['cols'][] = array('id' => '','label' => $row['revista'].'-tooltip', 'type' => 'string', 'p' => array('role' => 'tooltip', 'html' => true));
			$c[] = array(
					'v' => round($row['indicador'], 4)
				);
			$c[] = array(
					'v' => _sprintf($indicador[$_POST['indicador']]['tooltip'], $row['revista'], round($row['indicador'], 4))
				);
			$offset++;
			/*Filas de la tabla*/
			$cc = array();
			$cc[] = array('v' => $row['revista']);
			$cc[] = array('v' => number_format($row['indicador'], 4, '.', ''));
			$result['table']['rows'][]['c'] = $cc;
			if($offset == $limit || $offset == $totalRows):
				$result['chart'][$grupo]['rows'][]['c'] = $c;
				$offset = 0;
				$totalRows -= $limit;
				$grupo++;
			endif;
		endforeach;
		/*Opciones de la gráfica*/
		$result['options'] = array(
						'animation' => array(
								'duration' => 1000
							),
						'bar' => array(
								'groupWidth' => '85%'
							),
						'height' => '500',
						'hAxis' => array(
								'title' => _('Título de revista')
							), 
						'legend' => array(
								'position' => 'right'
							),
						'pointSize' => 1, 
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => $indicador[$_POST['indicador']]['title'],
								'viewWindow' => array('max' => $vAxisMax),
								'minValue' => 0
							),
						'width' => '925',
						'chartArea' => array(
							'left' => 120,
							'top' => 50,
							'width' => 580,
							'height' => "80%"
							)
						);
		/*Opciones para la tabla*/
		$data['tableOptions'] = array(
				'allowHtml' => true,
				'showRowNumber' => false
			);
		$result['chartTitle'] = $indicador[$_POST['indicador']]['chartTitle'];
		$result['tableTitle'] = "<div class=\"textoTitulo centrado\">{$this->indicadores[$_POST['indicador']]}</div>";
		header('Content-Type: application/json');	
		echo json_encode($result, true);

	}

	public function getFrecuencias($revista){
		$this->output->enable_profiler(false);
		$idDisciplina=$this->disciplinas[$_POST['disciplina']]['id_disciplina'];
		switch ($_POST['indicador']):
			case 'indice-concentracion':
				$query = "SELECT \"descriptoresJSON\", \"frecuenciaDescriptorJSON\" FROM \"mvPratt\" WHERE id_disciplina={$idDisciplina} AND \"revistaSlug\"='{$revista}'";
				$query = $this->db->query($query);
				$row = $query->row_array();
				$descriptores = json_decode($row['descriptoresJSON']);
				$frecuencias = json_decode($row['frecuenciaDescriptorJSON']);
				$result = array();
				$result['table']['cols'][] = array('id' => '','label' => _('Descriptor'),'type' => 'string');
				$result['table']['cols'][] = array('id' => '','label' => _('Frecuencia'),'type' => 'number');
				foreach ($descriptores as $key => $value):
					$c = array();
					$c[] = array('v' => $value);
					$c[] = array('v' => $frecuencias[$key]);
					$result['table']['rows'][]['c'] = $c;
				endforeach;
				break;
			
			case 'productividad-exogena':
				$query = "SELECT \"paisAutor\", \"autores\" FROM \"mvAutoresRevistaPais\" WHERE \"revistaSlug\"='{$revista}' ORDER BY autores DESC, \"paisAutor\"";
				$query = $this->db->query($query);
				$row = $query->row_array();
				$result = array();
				$result['table']['cols'][] = array('id' => '','label' => _('País'),'type' => 'string');
				$result['table']['cols'][] = array('id' => '','label' => _('Frecuencia'),'type' => 'number');
				foreach ($query->result_array() as $row ):
					$c = array();
					$c[] = array('v' => $row['paisAutor']);
					$c[] = array('v' => $row['autores']);
					$result['table']['rows'][]['c'] = $c;
				endforeach;
				break;
		endswitch;
		/*Opciones para la tabla*/
		$data['tableOptions'] = array(
				'allowHtml' => true,
				'showRowNumber' => false
			);
		header('Content-Type: application/json');
		echo json_encode($result, true);
	}
	
	public function getRevistasPaises(){
		$this->output->enable_profiler(false);
		$data = array();

		/*Revistas en disciplina*/
		$indicadorTabla['indice-coautoria']="CoautoriaPriceZakutina";
		$indicadorTabla['tasa-documentos-coautorados']="TasaLawani";
		$indicadorTabla['grado-colaboracion']="Subramayan";
		$indicadorTabla['modelo-elitismo']="CoautoriaPriceZakutina";
		$indicadorTabla['indice-colaboracion']="TasaLawani";
		$indicadorTabla['indice-densidad-documentos']="CoautoriaPriceZakutina";
		$indicadorTabla['indice-concentracion']="";
		$indicadorTabla['modelo-bradford-revista']="";
		$indicadorTabla['modelo-bradford-institucion']="";
		$indicadorTabla['productividad-exogena']="";

		$this->load->database();
		$query = "SELECT revista, \"revistaSlug\" FROM \"mvPeriodosRevista{$indicadorTabla[$_POST['indicador']]}\" WHERE id_disciplina='{$this->disciplinas[$_POST['disciplina']]['id_disciplina']}'";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$revista = array(
					'val' => $row['revistaSlug'],
					'text' => htmlspecialchars($row['revista'])
				);
			$data['revistas'][] = $revista;
		endforeach;
		$query = "SELECT \"paisRevista\", \"paisRevistaSlug\" FROM \"mvPeriodosPais{$indicadorTabla[$_POST['indicador']]}\" WHERE id_disciplina='{$this->disciplinas[$_POST['disciplina']]['id_disciplina']}'";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$revista = array(
					'val' => $row['paisRevistaSlug'],
					'text' => htmlspecialchars($row['paisRevista'])
				);
			$data['paises'][] = $revista;
		endforeach;
		$this->db->close();
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
		$this->load->database();
		$query = "";
		/*Periodos por revista*/
		/*Consulta para cada indicador*/
		$indicadorTabla['indice-coautoria']="mvIndiceCoautoriaPrice";
		$indicadorTabla['tasa-documentos-coautorados']="mvTasaCoautoria";
		$indicadorTabla['grado-colaboracion']="mvSubramayan";
		$indicadorTabla['modelo-elitismo']="mvIndiceCoautoriaPrice";
		$indicadorTabla['indice-colaboracion']="mvLawani";
		$indicadorTabla['indice-densidad-documentos']="mvZakutina";
		$indicadorTabla['indice-concentracion']="";
		$indicadorTabla['modelo-bradford-revista']="";
		$indicadorTabla['modelo-bradford-institucion']="";
		$indicadorTabla['productividad-exogena']="";


		if (isset($_POST['revista'])):
			$query = "SELECT min(anio) AS \"anioBase\", max(anio) AS \"anioFinal\" FROM \"{$indicadorTabla[$_POST['indicador']]}Revista\" WHERE \"revistaSlug\" IN (";
			$revistaOffset=1;
			$revistaTotal= count($_POST['revista']);
			foreach ($_POST['revista'] as $revista):
				$query .= "'{$revista}'";
				if($revistaOffset < $revistaTotal):
					$query .=",";
				endif;
				$revistaOffset++;
			endforeach;
			$query .= ")";
		elseif (isset($_POST['pais'])):
			$query = "SELECT min(anio) AS \"anioBase\", max(anio) AS \"anioFinal\" FROM \"{$indicadorTabla[$_POST['indicador']]}Pais\" WHERE \"paisRevistaSlug\" IN (";
			$paisOffset=1;
			$paisTotal= count($_POST['pais']);
			foreach ($_POST['pais'] as $pais):
				$query .= "'{$pais}'";
				if($paisOffset < $paisTotal):
					$query .=",";
				endif;
				$paisOffset++;
			endforeach;
			$query .= ") AND id_disciplina='{$this->disciplinas[$_POST['disciplina']]['id_disciplina']}'";
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

	public function getAutoresPrice($revistaPais, $anio){
		$this->output->enable_profiler(false);
		$idDisciplina=$this->disciplinas[$_POST['disciplina']]['id_disciplina'];
		if(isset($_POST['revista'])):
			$query = "SELECT autor, documentos FROM \"mvAutorRevista\" WHERE \"revistaSlug\"='{$revistaPais}' AND anio='{$anio}' ORDER BY documentos DESC";
		else:
			$query = "SELECT autor, documentos FROM \"mvAutorPais\" WHERE \"paisRevistaSlug\"='{$revistaPais}' AND anio='{$anio}' ORDER BY documentos DESC";
		endif;
		$query = $this->db->query($query);
		$result = array();
		$result['table']['cols'][] = array('id' => '','label' => _('Autor'),'type' => 'string');
		$result['table']['cols'][] = array('id' => '','label' => _('Documentos'),'type' => 'number');
		foreach ($query->result_array() as $row):
			$c = array();
			$c[] = array('v' => $row['autor']);
			$c[] = array('v' => $row['documentos']);
			$result['table']['rows'][]['c'] = $c;
		endforeach;
		/*Opciones para la tabla*/
		$data['tableOptions'] = array(
				'allowHtml' => true,
				'showRowNumber' => false
			);
		header('Content-Type: application/json');
		echo json_encode($result, true);
	}

	public function bradfordDocumentos($slug, $ajax=false){
		$args['slug'] = $slug;
		$args['query'] = "SELECT {$this->queryFields} FROM \"vDocumentosBradfordFull\" WHERE \"revistaSlug\"='{$slug}'";
		$args['queryCount'] = "SELECT count(DISTINCT (iddatabase, sistema)) AS total FROM \"vDocumentosBradfordFull\" WHERE \"revistaSlug\"='{$slug}'";
		$args['paginationURL'] = site_url("indicadores/bradfordDocumentos/{$slug}");
		if(isset($_POST['ajax']) || $ajax):
			$args['paginationURL'] = site_url("indicadores/bradfordDocumentos/{$slug}/ajax");
			$args['ajax'] = true;
		endif;
		/*Datos de la revista*/
		$this->load->database();
		$queryRevista = "SELECT revista FROM \"mvSearch\" WHERE \"revistaSlug\"='{$slug}' LIMIT 1";
		$queryRevista = $this->db->query($queryRevista);
		$this->db->close();
		$queryRevista = $queryRevista->row_array();
		$args['breadcrumb'] = sprintf('%s<i class="separador"></i> %s<i class="separador"></i> %s (%%d documentos)', anchor('indicadores', _('Indicadores'), _('title="Indicadores"')), anchor('indicadores/modelo-bradford-revista', _('Modelo de Bradford por revista'), _('title="Modelo de Bradford por revista"')), $queryRevista['revista']);
		$args['title'] = _sprintf('Biblat - %s (%%d documentos)', $queryRevista['revista']);
		return $this->_renderDocuments($args);
	}

	private function _renderDocuments($args){
		/*Obtniendo los registros con paginación*/
		$query = "{$args['query']} ORDER BY anio DESC, volumen DESC, numero DESC, articulo";
		$articulosResultado = articulosResultado($query, $args['queryCount'], $args['paginationURL'], $resultados=20);
		/*Vistas*/
		$data = array();
		$data['main']['links'] = $articulosResultado['links'];
		$data['main']['resultados']=$articulosResultado['articulos'];
		$data['header']['title'] = sprintf($args['title'], $articulosResultado['totalRows']);
		$data['header']['slugHighLight']=slugHighLight($args['slug']);
		$data['header']['content'] =  $this->load->view('buscar/header', $data['header'], TRUE);
		$data['main']['breadcrumb'] = sprintf($args['breadcrumb'], $articulosResultado['totalRows']);
		if(isset($args['ajax'])):
			$data['header']['content'] .=  $this->load->view('header_ajax', $data['header'], TRUE);
			$this->load->view('header', $data['header']);
		else:
			$this->load->view('header', $data['header']);
			$this->load->view('menu', $data['header']);
		endif;
		$this->load->view('frecuencias/documentos', $data['main']);
		if(! isset($args['ajax'])):
			$this->load->view('footer');
		endif;
	}

}
/* End of file indicadores.php */
/* Location: ./application/controllers/indicadores.php */