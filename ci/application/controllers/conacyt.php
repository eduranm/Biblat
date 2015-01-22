<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conacyt extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler($this->config->item('enable_profiler'));
		$this->template->set_partial('biblat_js', 'javascript/biblat', array(), TRUE);
		$this->template->set_partial('submenu', 'layouts/submenu');
		$this->template->set_partial('search', 'layouts/search');
		$this->template->set_breadcrumb(_('Inicio'), site_url('/'));
		$this->template->set('class_method', $this->router->fetch_class().$this->router->fetch_method());
	}

	public function index()
	{
		$data = array();
		$data['page_title'] = _('Reporte bibliométrico CONACYT');
		$scieloDB = $this->load->database('scielo', TRUE);
		$query = "SELECT * FROM \"vJournalConacyt\" WHERE \"networkId\"=5";
		$query = $scieloDB->query($query);
		$scieloDB->close();
		$data['areas'] = array();
		foreach ($query->result_array() as $row):
			$row['report']['2014'] = strtoupper($row['neumonic'])."_Reporte_bibliometrico_DIC2014.pdf";
			if(file_exists("archivos/conacyt/reportes/revista/{$row['report']['2014']}")):
				$data['areas'][$row['areaConacytId']]['report']['2014']=strtoupper(slug($row['areaConacytName'])).".pdf";
				$data['areas'][$row['areaConacytId']]['journals'][] = $row;
			endif;
		endforeach;
		//print_r($query->result_array());
		$this->template->title(_('Biblat - Reporte bibliométrico CONACYT'));
		$this->template->set_meta('description', _('Reporte bibliométrico CONACYT'));
		$this->template->build('conacyt/index', $data);
	}

	public function get_report($neumonic=NULL){
		$this->output->enable_profiler(FALSE);
		$data = array(
				'result' => FALSE
			);
		$report = strtoupper($neumonic)."_Reporte_bibliometrico_DIC2014.pdf";
		if(file_exists("archivos/conacyt/reportes/revista/{$report}")):
			$data = array(
					'result' => TRUE,
					'url' => base_url("archivos/conacyt/reportes/revista/${report}")
				);
		endif;
		$this->load->view('conacyt/get_report', $data);
	}

}

/* End of file scielo.php */
/* Location: ./application/controllers/scielo.php */