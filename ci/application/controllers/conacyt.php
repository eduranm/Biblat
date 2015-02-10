<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conacyt extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler($this->config->item('enable_profiler'));
		$this->template->set_partial('biblat_js', 'javascript/biblat', array(), TRUE, FALSE);
		$this->template->set_partial('submenu', 'layouts/submenu');
		$this->template->set_partial('search', 'layouts/search');
		$this->template->set_breadcrumb(_('Inicio'), site_url('/'));
		$this->template->set_breadcrumb(_('Reportes'));
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
				$data['areas'][$row['areaConacytId']]['report']['2014']=strtoupper($row['areaConacytSlug']).".pdf";
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
			$scieloDB = $this->load->database('scielo', TRUE);
			$query = "SELECT slug FROM journal WHERE neumonic='${neumonic}'";
			$query = $scieloDB->query($query);
			$query = $query->row_array();
			$scieloDB->close();
			$report = $query['slug'];
			$data = array(
					'result' => TRUE,
					'url' => base_url("conacyt/revista/${report}")
				);
		endif;
		$this->load->view('conacyt/get_report', $data);
	}

	public function pdf_viewer(){
		$data = array();
		$uri_args = $this->uri->ruri_to_assoc(3);
		foreach ($uri_args as $key => $value):
			switch ($key):
				case 'revista':
					$scieloDB = $this->load->database('scielo', TRUE);
					$query = "SELECT neumonic, name FROM journal WHERE slug='${value}'";
					$query = $scieloDB->query($query);
					$query = $query->row_array();
					$scieloDB->close();
					$report = strtoupper($query['neumonic'])."_Reporte_bibliometrico_DIC2014.pdf";
					$data['url'] = base_url("archivos/conacyt/reportes/revista/${report}");
					$data['name'] = " - ${query['name']}";
					break;
				case 'area':
					$scieloDB = $this->load->database('scielo', TRUE);
					$query = "SELECT name, slug FROM \"areaConacyt\" WHERE slug='${value}'";
					$query = $scieloDB->query($query);
					$query = $query->row_array();
					$report = strtoupper($query['slug']);
					$data['url'] = base_url("archivos/conacyt/reportes/area/${report}.pdf");
					$data['name'] = " - ${query['name']}";
					break;
				case 'reporte':
					$report = strtoupper($value);
					$data['url'] = base_url("archivos/conacyt/reportes/${report}.pdf");
					$data['name'] = "";
					break;
			endswitch;
		endforeach;

		$this->template->set_partial('view_js', 'javascript/pdf_viewer', $data, TRUE, FALSE);
		$this->template->title(_('Biblat - Reporte bibliométrico CONACYT').$data['name']);
		$this->template->set_meta('description', _('Reporte bibliométrico CONACYT'));
		$this->template->set_meta('google', _('notranslate'));
		$this->template->set_metadata('resource', base_url('assets/js/pdfjs/locale/locale.properties'), 'application/l10n');
		$this->template->css('assets/css/pdfjs/viewer.css');
		$this->template->js('assets/js/pdfjs/compatibility.js');
		$this->template->js('assets/js/pdfjs/l10n.js');
		$this->template->js('assets/js/pdfjs/pdf.js');
		$this->template->set_breadcrumb(_('CONACYT'), site_url('conacyt'));
		$this->template->build('layouts/pdf_viewer', $data);
	}

}

/* End of file scielo.php */
/* Location: ./application/controllers/scielo.php */