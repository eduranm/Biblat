<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class Conacyt extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function indicadores_get(){
		$data = array();
		$issn = $this->get('issn') ? $this->get('issn') : NULL;
		$this->load->database();
		$scieloDB = $this->load->database('scielo', TRUE);
		$query = "SELECT * FROM \"vJournalConacyt\"";
		if(isset($issn))
			$query = "{$query} WHERE issn='{$issn}' LIMIT 1";
		$query = $scieloDB->query($query);
		$scieloDB->close();
		foreach ($query->result_array() as $journal):
			$data[$journal['issn']]['indicators'] = array();
			$data[$journal['issn']]['name'] = $journal['name'];
			$report['2014'] = strtoupper($journal['neumonic'])."_Reporte_bibliometrico_DIC2014.pdf";
			if(file_exists("archivos/conacyt/reportes/revista/{$row['report']['2014']}")):
				$data[$journal['issn']]['indicators'][] = array(
						'title' => 'Reporte bibliométrico CONACYT',
						'url' => site_url("conacyt/revista/{$journal['slug']}"),
						'img' => NULL
					);
			endif;
		endforeach;

		$query = "SELECT * FROM \"vIndicadoresRevistaGeneralConacyt\"";
		if(isset($issn))
			$query = "{$query} WHERE \"revistaISSN\"='{$issn}' LIMIT 1";
		$query = $this->db->query($query);
		$this->db->close();
		foreach ($query->result_array() as $journal):
			$data[$journal['revistaISSN']]['name'] = $journal['revista'];
			if($journal['pratt']):
				$data[$journal['revistaISSN']]['indicators'][] = array(
						'title' => 'Índice de concentración Pratt (Biblat)',
						'url' => site_url("indicadores/indice-concentracion/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
						'img' => site_url("indicadores/indice-concentracion/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}/preview.png")
					);
			endif;
			if($journal['exogena']):
				$data[$journal['revistaISSN']]['indicators'][] = array(
						'title' => 'Tasa de autoría exógena (Biblat)',
						'url' => site_url("indicadores/productividad-exogena/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
						'img' => site_url("indicadores/productividad-exogena/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}/preview.png")
					);
			endif;
			if($journal['generalesrevista']):
				$data[$journal['revistaISSN']]['indicators'][] = array(
						'title' => 'Indicadores generales por revista (SciELO)',
						'url' => site_url("scielo/indicadores/indicadores-generales-revista/coleccion/{$journal['networkSlug']}/revista/acta-botanica-mexicana{$journal['revistaSlug']}"),
						'img' => site_url("scielo/indicadores/indicadores-generales-revista/coleccion/{$journal['networkSlug']}/revista/acta-botanica-mexicana{$journal['revistaSlug']}/preview.png")
					);
			endif;
			if($journal['redalycId']):
				$data[$journal['revistaISSN']]['indicators'][] = array(
						'title' => 'Indicadores de publicación (Redalyc)',
						'url' => "http://www.redalyc.org/revista.oa?id={$journal['redalycId']}&tipo=produccion&perfil=publicacion",
						'img' => NULL
					);
				$data[$journal['revistaISSN']]['indicators'][] = array(
						'title' => 'Indicadores de coautoría (Redalyc)',
						'url' => "http://www.redalyc.org/revista.oa?id={$journal['redalycId']}&tipo=produccion&perfil=coautoria",
						'img' => NULL
					);
			endif;
		endforeach;
		
		$this->response($data, 200);
	}

	public function datosFuente_get(){
		$issn = $this->get('issn') ? $this->get('issn') : NULL;
		$data = array();
		$this->load->database();
		$query = "SELECT * FROM \"vIndicadoresRevistasConacyt\"";
		if(isset($issn))
			$query = "{$query} WHERE issn='{$issn}'";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row):
			$id = $row['areaConacytSlug'];
			$revistaSlug = $row['slug'];
			if ( ! isset($data[$id][$revistaSlug])):
				$journal = array(
						'areaConacytName' => $row['areaConacytName'],
						'name' => $row['name'],
						'slug' => $row['slug'],
						'issn' => $row['issn']
					);
				$data[$id][$row['slug']] = $journal;
			endif;
			unset($row['networkId'], $row['areaConacytId'], $row['networkName'], $row['networkSlug'], $row['areaConacytSlug'], $row['neumonic'], $row['areaConacytName'], $row['name'], $row['slug'], $row['issn']);
			$data[$id][$revistaSlug]['datos'][] = $row;
		endforeach;
		if(isset($issn))
			$data = current(current($data));
		$this->response($data, 200);
	}
}