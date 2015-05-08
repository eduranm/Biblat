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
		if($issn == NULL):
			$data['response'] = 'error';
			$data['message'] = 'ISSN is needed to request, example: '.site_url('api/indicadores/issn/0036-3634');
			$this->response($data, 500);
		else:
			$data['indicators'] = array();
			$this->load->database();
			$scieloDB = $this->load->database('scielo', TRUE);
			$query = "SELECT * FROM \"vJournalConacyt\" WHERE issn='{$issn}' LIMIT 1";
			$query = $scieloDB->query($query);
			$journal = $query->row_array();
			$scieloDB->close();
			$data['journal'] = $journal['name'];
			$report['2014'] = strtoupper($journal['neumonic'])."_Reporte_bibliometrico_DIC2014.pdf";
			if(file_exists("archivos/conacyt/reportes/revista/{$row['report']['2014']}")):
				$data['indicators'][] = array(
						'title' => 'Reporte bibliométrico CONACYT',
						'url' => site_url("conacyt/revista/{$journal['slug']}"),
						'img' => null
					);
			endif;

			$query = "SELECT * FROM \"vIndicadoresRevistaGeneral\" WHERE \"revistaISSN\"='{$issn}' LIMIT 1";
			$query = $this->db->query($query);
			$journal = $query->row_array();
			$this->db->close();
			$data['journal'] = $journal['revista'];
			if($journal['pratt']):
				$data['indicators'][] = array(
						'title' => 'Índice de concentración Pratt (Biblat)',
						'url' => site_url("indicadores/indice-concentracion/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
						'img' => null
					);
			endif;
			if($journal['exogena']):
				$data['indicators'][] = array(
						'title' => 'Tasa de autoría exógena (Biblat)',
						'url' => site_url("indicadores/productividad-exogena/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
						'img' => null
					);
			endif;
			if($journal['generalesrevista']):
				$data['indicators'][] = array(
						'title' => 'Indicadores generales por revista (SciELO)',
						'url' => site_url("scielo/indicadores/indicadores-generales-revista/coleccion/{$journal['networkSlug']}/revista/acta-botanica-mexicana{$journal['revistaSlug']}"),
						'img' => null
					);
			endif;
			$this->response($data, 200);
		endif;
	}
}