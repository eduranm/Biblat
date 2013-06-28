<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicadores extends CI_Controller {

	public $indicadores = array();
	public $disciplinas = array();

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
								'productividad-exogena' => _('Productividad exógena') 
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
			$this->session->set_userdata('query{'.md5($query).'}', $disciplinas);
		endif;
		$this->disciplinas = $this->session->userdata('query{'.md5($query).'}');
		$data['disciplinas'] = $this->disciplinas;
		$this->db->close();

		$this->load->vars($data);

		set_translation_language(get_cookie('lang'));
		$this->output->enable_profiler($this->config->item('enable_profiler'));
	}

	public function index($indicador="")
	{
		$data = array();
		$data['main']['indicador'] = $indicador;

		/*Vistas*/
		$js = $this->load->view('indicadores_index_js', $data['header'], TRUE);
		$data['header']['js'] = $this->minify->js->min($js);
		//$data['header']['js'] = $js;
		$data['header']['content'] =  $this->load->view('indicadores_header', $data['header'], TRUE);
		unset($data['header']['js']);
		$data['header']['title'] = _sprintf('Biblat - Indicador: %s', $this->indicadores[$data['main']['indicador']]);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('indicadores_index', $data['main']);
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
		$indicadorCampoTabla['indice-coautoria']="coautoria AS valor FROM \"mvIndiceCoautoriaPrice";
		$indicadorCampoTabla['tasa-documentos-coautorados']="\"tasaCoautoria\" AS valor FROM \"mvTasaCoautoria";
		$indicadorCampoTabla['grado-colaboracion']="subramayan AS valor FROM \"mvSubramayan";
		$indicadorCampoTabla['modelo-elitismo']="price AS valor FROM \"mvIndiceCoautoriaPrice";
		$indicadorCampoTabla['indice-colaboracion']="lawani AS valor FROM \"mvLawani";
		$indicadorCampoTabla['indice-densidad-documentos']="zakutina AS valor FROM \"mvZakutina";
		$indicadorCampoTabla['indice-concentracion']="";
		$indicadorCampoTabla['modelo-bradford-revista']="";
		$indicadorCampoTabla['modelo-bradford-institucion']="";
		$indicadorCampoTabla['productividad-exogena']="";

		if (isset($_POST['revista'])):
			$query = "SELECT revista AS title, anio, {$indicadorCampoTabla[$_POST['indicador']]}Revista\" WHERE \"revistaSlug\" IN (";
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
			$query = "SELECT \"paisAutor\" AS title, anio, {$indicadorCampoTabla[$_POST['indicador']]}Pais\" WHERE \"paisAutorSlug\" IN (";
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
		/*Generando filas*/
		foreach ($periodos as $periodo):
			$c = array();
			$c[] = array(
					'v' => $periodo
				);
			foreach ($indicadores as $kindicador => $vindicador):
				$c[] = array(
					'v' => $vindicador[$periodo]
				);
				$c[] = array(
					'v' => _sprintf('<div class="centrado"><b>%s</b></div><div class="centrado">Año %d: %s</div>', $kindicador, $periodo, $vindicador[$periodo])
				);
			endforeach;
			$data['data']['rows'][]['c'] = $c;
		endforeach;

		/*Opciones de la gráfica*/
		$data['options'] = array(
						'animation' => array(
								'duration' => 1000
							), 
						'height' => '500',
						'hAxis' => array(
								'title' => _('Periodo')
							), 
						'legend' => array(
								'position' => 'right'
							),
						'pointSize' => 3,
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => $this->indicadores[$_POST['indicador']],
								'minValue' => 0
							),
						'width' => '925',
						'chartArea' => array(
							'left' => 100,
							'top' => 50,
							'width' => 675,
							'height' => "80%"
							)
						);
		/*Datos para la tabla*/
		$data['tableOptions'] = array(
				'allowHtml' => true,
				'showRowNumber' => true
			);
		$data['history'] = array(
								'title' => _sprintf('Biblat - Indicador: %s', $this->indicadores[$_POST['indicador']]),
								'url' => site_url("indicadores/{$_POST['indicador']}")
							);
		echo json_encode($data, true);
	}

	public function getChartDataBradford(){
		$this->output->enable_profiler(false);
		$sufix['modelo-bradford-revista']="Revista";
		$sufix['modelo-bradford-institucion']="Institucion";
		$hAxisTitleGroup['modelo-bradford-revista']=_('Títulos de revista');
		$hAxisTitleGroup['modelo-bradford-institucion']=_('País de afilicación del autor');
		$titleGroup['modelo-bradford-revista']=_('Fecuencia de artículos por título de revista');
		$titleGroup['modelo-bradford-institucion']=_('Fecuencia de artículos por institución de afilicación del autor');
		$idDisciplina=$this->disciplinas[$_POST['disciplina']]['id_disciplina'];
		$query = "SELECT articulos, frecuencia, \"articulosXfrecuenciaAcumulado\", \"logFrecuenciaAcumulado\" FROM \"vBradford{$sufix[$_POST['indicador']]}\" WHERE id_disciplina={$idDisciplina}";
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
		$result['chart']['bradford']['cols'][] = array('id' => '','label' => _('Bradford'),'type' => 'number');
		/*Generando filas*/
		foreach ($query->result_array() as $row):
			$articulosXfrecuenciaAcumulado = (int)$row['articulosXfrecuenciaAcumulado'];
			$articuloXfrecuencia = $row['articulos'] * $row['frecuencia'];
			/*Segmentando grupos*/
			if ($articulosXfrecuenciaAcumulado < $promedio):
				$grupos['1']['limite'] = $articulosXfrecuenciaAcumulado;
			elseif ($articulosXfrecuenciaAcumulado > $promedio && ($articulosXfrecuenciaAcumulado - $promedio) < ($articuloXfrecuencia / 2)):
				$grupos['1']['limite'] = $articulosXfrecuenciaAcumulado;
			elseif ($articulosXfrecuenciaAcumulado < ($promedio * 2)):
				$grupos['2']['limite'] = $articulosXfrecuenciaAcumulado;
			elseif ($articulosXfrecuenciaAcumulado > ($promedio * 2) && ($articulosXfrecuenciaAcumulado - ($promedio * 2)) < ($articuloXfrecuencia / 2)):
				$grupos['2']['limite'] = $articulosXfrecuenciaAcumulado;
			endif;
			/*Agregado columnas a la fila*/
			$c = array();
			$c[] = array(
					'v' => round($row['logFrecuenciaAcumulado'], 4)
				);
			$c[] = array(
					'v' => $articulosXfrecuenciaAcumulado
				);
			/*$c[] = array(
				'v' => _sprintf('<div class="centrado"><b>%s</b></div><div class="centrado">Año %d: %s</div>', $kindicador, $periodo, $vindicador[$periodo])
			);*/
			$result['chart']['bradford']['rows'][]['c'] = $c;
		endforeach;
		/*Opciones de la gráfica de bradford*/
		$result['options']['bradford'] = array(
						'animation' => array(
								'duration' => 1000
							), 
						'curveType' => 'function', 
						'height' => '500',
						'hAxis' => array(
								'title' => _('log(fx)')
							), 
						'legend' => array(
								'position' => 'right'
							),
						'pointSize' => 1, 
						'title' => $this->indicadores[$_POST['indicador']],
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => _('Artículos'),
								'minValue' => 0
							),
						'width' => '925',
						'chartArea' => array(
							'left' => 120,
							'top' => 50,
							'width' => 675,
							'height' => "80%"
							)
						);
		/*Creando lista de revistas con su tatal de articulos agrupoados según los límites calculados anteriormente*/
		$column = strtolower($sufix[$_POST['indicador']]);
		$query = "SELECT {$column}, articulos FROM \"mvArticulosDisciplina{$sufix[$_POST['indicador']]}\" WHERE id_disciplina={$idDisciplina}";
		$query = $this->db->query($query);
		$acumuladoArticulos = 0;
		$revistaInstitucion = array();
		foreach ($query->result_array() as $row) :
			$acumulado += $row['articulos'];
			if ($acumulado <= $grupos['1']['limite']):
				$revistaInstitucion['1'][$row[$column]] = $row['articulos'];
			elseif ($acumulado <= $grupos['2']['limite']):
				$revistaInstitucion['2'][$row[$column]] = $row['articulos'];
			else:
				$revistaInstitucion['3'][$row[$column]] = $row['articulos'];
			endif;
		endforeach;
		/*Ordenando grupos alfabeticamnete*/
		ksort($revistaInstitucion['1']);
		ksort($revistaInstitucion['2']);
		ksort($revistaInstitucion['3']);
		/*Datos para la gráfica del grupo1*/
		$result['chart']['group1']['cols'][] = array('id' => '','label' => _('Títulos de revista'),'type' => 'string');
		$c = array();
		$c[] = array('v' => '');
		/*Agregado filas y columnas*/
		foreach ($revistaInstitucion['1'] as $label => $articulos):
			$result['chart']['group1']['cols'][] = array('id' => '','label' => $label,'type' => 'number');
			$c[] = array(
					'v' => (int)$articulos
				);
		endforeach;
		$result['chart']['group1']['rows'][]['c'] = $c;
		/*Datos para la gráfica del grupo2*/
		$result['chart']['group2']['cols'][] = array('id' => '','label' => _('Títulos de revista'),'type' => 'string');
		$c = array();
		$c[] = array('v' => '');
		/*Agregado filas y columnas*/
		foreach ($revistaInstitucion['2'] as $revista => $articulos):
			$result['chart']['group2']['cols'][] = array('id' => '','label' => $revista,'type' => 'number');
			$c[] = array(
					'v' => (int)$articulos
				);
		endforeach;
		$result['chart']['group2']['rows'][]['c'] = $c;
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
								'title' => $hAxisTitleGroup[$_POST['indicador']],
							), 
						'legend' => array(
								'position' => 'right'
							),
						'pointSize' => 1, 
						'title' => $titleGroup[$_POST['indicador']],
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => _('Artículos'),
								'minValue' => 0
							),
						'width' => '925',
						'chartArea' => array(
							'left' => 120,
							'top' => 50,
							'width' => 675,
							'height' => "80%"
							)
						);

		$result['last'] = $last;
		$result['grupos'] = $grupos;
		$result['revistaInstitucion'] = $revistaInstitucion;
		echo json_encode($result, true);
	}

	public function getChartDataPratt($limit=20){
		$this->output->enable_profiler(false);
		$idDisciplina=$this->disciplinas[$_POST['disciplina']]['id_disciplina'];
		$query = "SELECT revista, \"revistaSlug\", pratt FROM \"mvPratt\" WHERE id_disciplina={$idDisciplina}";
		$query = $this->db->query($query);
		$offset = 0;
		$grupo = 0;
		$c = array();
		$result['chart'] = array();
		$totalRows = $query->num_rows();
		foreach ($query->result_array() as $row):
			if(!isset($result['chart'][$grupo])):
				$result['chart'][$grupo]['cols'][] = array('id' => '','label' => _('Títulos de revista'),'type' => 'string');
				$c = array();
				$c[] = array('v' => '');
			endif;

			$result['chart'][$grupo]['cols'][] = array('id' => '','label' => $row['revista'],'type' => 'number');
			$c[] = array(
					'v' => round($row['pratt'], 4)
				);
			$offset++;
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
								'title' => _('Títulos de revista')
							), 
						'legend' => array(
								'position' => 'right'
							),
						'pointSize' => 1, 
						'tooltip' => array(
								'isHtml' => true
							),
						'vAxis' => array(
								'title' => $this->indicadores[$_POST['indicador']],
								'minValue' => 0
							),
						'width' => '925',
						'chartArea' => array(
							'left' => 120,
							'top' => 50,
							'width' => 675,
							'height' => "80%"
							)
						);
		echo json_encode($result, true);

	}

	public function getTableData(){

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
		$query = "SELECT \"paisAutor\", \"paisAutorSlug\" FROM \"mvPeriodosPais{$indicadorTabla[$_POST['indicador']]}\" WHERE id_disciplina='{$this->disciplinas[$_POST['disciplina']]['id_disciplina']}'";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row ):
			$revista = array(
					'val' => $row['paisAutorSlug'],
					'text' => htmlspecialchars($row['paisAutor'])
				);
			$data['paises'][] = $revista;
		endforeach;
		$this->db->close();

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
			$query = "SELECT min(anio) AS \"anioBase\", max(anio) AS \"anioFinal\" FROM \"{$indicadorTabla[$_POST['indicador']]}Pais\" WHERE \"paisAutorSlug\" IN (";
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
		echo json_encode($data, true);
	}

}
/* End of file indicadores.php */
/* Location: ./application/controllers/indicadores.php */