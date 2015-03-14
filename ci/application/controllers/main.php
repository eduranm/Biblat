<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->output->enable_profiler($this->config->item('enable_profiler'));
		$this->template->set_partial('biblat_js', 'javascript/biblat', array(), TRUE, FALSE);
		$this->template->set_partial('submenu', 'layouts/submenu');
		$this->template->set_partial('search', 'layouts/search');
		$this->template->set_breadcrumb(_('Inicio'), site_url('/'));
		$this->template->set('class_method', $this->router->fetch_class().$this->router->fetch_method());
	}
	public function index(){
		$data = array();
		$data['header']['title'] = _("Biblat");
		$data['header']['description'] = _('Biblat ofrece: referencias bibliográficas de documentos publicados en revistas científicas y académicas latinoamericanas indizadas en CLASE y PERIÓDICA, acceso al texto completo de revistas en acceso abierto, indicadores bibliométricos e información sobre los políticas de acceso de las revistas.');
		/*Consultas*/
		$this->load->database();
		/*Max disciplina*/
		$query = "SELECT total FROM \"mvDisciplina\" WHERE id_disciplina <> '23' ORDER BY total DESC LIMIT 1";
		$query = $this->db->query($query);
		$data['index']['maxDisciplina'] = $query->row_array();
		$data['index']['maxDisciplina'] = $data['index']['maxDisciplina']['total'];
		$query->free_result();
		/*Disciplinas*/
		$query = "SELECT * FROM \"mvDisciplina\" WHERE id_disciplina <> '23'";
		$query = $this->db->query($query);
		foreach ($query->result_array() as $row):
			$row['size'] = round(($row['total']/ $data['index']['maxDisciplina']) * 20);
			$data['index']['disciplinas'][] = $row;
		endforeach;
		$query->free_result();
		/*Obtención de totales*/
		$query = "SELECT * FROM \"mvTotales\"";
		$query = $this->db->query($query);
		$data['index']['totales'] = $query->row_array();
		$query->free_result();
		/*Obteniendo lista de paises*/
		$query = "SELECT * FROM \"mvPais\" WHERE \"paisRevistaSlug\" <> 'internacional'";
		$query = $this->db->query($query);
		$paises = $query->result_array();
		$query->free_result();
		$this->db->close();
		$data['index']['paises'] = $paises;
		/*Banner con cantidades*/
		$data['index']['svg'] = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
				<svg class="img-responsive center-block" version="1.1" id="banners_01" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 235.2 69.6" enable-background="new 0 0 235.2 69.6" xml:space="preserve" width="980" height="290">
		            <image overflow="visible" width="980" height="290" xlink:href="'.base_url('img/slides/banners_01.jpg').'"  transform="matrix(0.24 0 0 0.24 0 0)"></image>
		            <text transform="matrix(4.489659e-11 -1 1 4.489659e-11 138.3335 63.3335)" fill="#FFFFFF" font-family="\'MyriadPro-Regular\'" font-size="3.7">'._sprintf('%s textos completos en HEVILA', number_format($data['index']['totales']['hevila'], 0, '.', ',')).'</text>
		            <text transform="matrix(4.489659e-11 -1 1 4.489659e-11 148.8335 63.3335)" fill="#FFFFFF" font-family="\'MyriadPro-Regular\'" font-size="3.6">'._sprintf('%s textos completos', number_format($data['index']['totales']['enlaces'], 0, '.', ',')).'</text>
		            <text transform="matrix(4.489659e-11 -1 1 4.489659e-11 159.557 63.3335)" fill="#FFFFFF" font-family="\'MyriadPro-Regular\'" font-size="3.6">'._sprintf('%s documentos', number_format($data['index']['totales']['documentos'], 0, '.', ',')).'</text>
		            <text transform="matrix(4.489659e-11 -1 1 4.489659e-11 170.3335 63.3335)" fill="#FFFFFF" font-family="\'MyriadPro-Regular\'" font-size="3.6">'._sprintf('%s revistas', number_format($data['index']['totales']['revistas'], 0, '.', ',')).'</text>
		        </svg>';
		/*Vistas*/
		$this->template->set_partial('view_js', 'main/header', array(), TRUE, FALSE);
		$this->template->set_partial('frecuencias_accordion', 'frecuencias/index', array(), TRUE);
		$this->template->title(_('Biblat - Bibliografía latinoamericana'));
		$this->template->js('js/d3.js');
		$this->template->js('js/d3.layout.cloud.js');
		$this->template->set_breadcrumb(_('Sobre Biblat'));
		$this->template->set_meta('description', _('Bibliografía latinoamericana'));
		$this->template->build('main/index', $data['index']);
	}

	public function creditos(){
		$data = array();
		$data['page_title'] = _('Créditos');
		$this->template->title(_('Biblat - Créditos'));
		$this->template->set_meta('description', _('Créditos'));
		$this->template->build('main/creditos', $data);
	}

	public function bibliografia(){
		$data = array();
		$data['page_title'] = _('Bibliografía');
		$this->template->title(_('Biblat - Bibliografía'));
		$this->template->set_breadcrumb(_('Documentos'));
		$this->template->set_meta('description', _('Bibliografía'));
		$this->template->build('main/bibliografia', $data);
	}

		public function presentaciones(){
		$data = array();
		$data['page_title'] = _('Presentaciones PPT');
		$this->template->title(_('Biblat - Presentaciones PPT'));
		$this->template->set_breadcrumb(_('Documentos'));
		$this->template->set_meta('description', _('Presentaciones PPT'));
		$this->template->build('main/presentaciones', $data);
	}

	public function multimedia(){
		$data = array();
		$data['page_title'] = _('Multimedia');
		$this->template->title(_('Biblat - Multimedia'));
		$this->template->set_breadcrumb(_('Documentos'));
		$this->template->set_meta('description', _('Multimedia'));
		$this->template->build('main/multimedia', $data);
	}

	public function sobreBiblat(){
		$data = array();
		$data['page_title'] = _('¿Qué es Biblat?');
		$this->template->title(_('Biblat - ¿Qué es Biblat?'));
		$this->template->set_breadcrumb(_('Sobre Biblat'));
		$this->template->set_meta('description', _('¿Qué es Biblat?'));
		$this->template->build('main/info_biblat', $data);
	}

	public function clasePeriodica(){
		$data = array();
		$this->load->database();
		$query = "SELECT * FROM \"mvDisciplinasBase\" ORDER BY base, \"disciplinaRevista\"";
		$query = $this->db->query($query);
		$data[ 'disciplina' ] = array();
		foreach ($query->result_array() as $row):
				$disciplina = array();
				$disciplina['disciplina'] = $row['disciplinaRevista'];
				$disciplina['slug'] = $row['slug'];
   				$data[ 'disciplina' ][ $row[ 'base' ] ][] = $disciplina;	
		endforeach;
		$data['page_title'] = _('CLASE y PERIÓDICA');
		$this->template->title(_('Biblat - CLASE y PERIÓDICA'));
		$this->template->set_breadcrumb(_('Sobre Biblat'));
		$this->template->set_meta('description', _('CLASE y PERIÓDICA'));
		$this->template->build('main/info_clase_periodica', $data);
	}

	public function scielo(){
		$data = array();
		$data['page_title'] = _('Sobre SciELO');
		$this->template->title(_('Biblat - Sobre SciELO'));
		$this->template->set_breadcrumb(_('Sobre Biblat'));
		$this->template->set_meta('description', _('Sobre SciELO'));
		$this->template->build('main/info_scielo', $data);
	}

	public function manualIndizacion(){
		$data = array();
		$data['page_title'] = _('Manual de indización');
		$this->template->set_partial('view_js', 'main/header_metodologia', array(), TRUE);
		$this->template->title(_('Biblat - Manual de indización'));
		$this->template->css('assets/css/colorbox.css');
		$this->template->js('assets/js/colorbox.js');
		$this->template->set_breadcrumb(_('Sobre Biblat'));
		$this->template->set_meta('description', _('Manual de indización'));
		$this->template->build('main/manual_indizacion', $data);
	}

	public function materialesDifusion(){
		$data = array();
		$data['page_title'] = _('Materiales de difusión');
		$this->template->title(_('Biblat - Materiales de difusión'));
		$this->template->set_breadcrumb(_('Sobre Biblat'));
		$this->template->set_meta('description', _('Materiales de difusión'));
		$this->template->build('main/materiales_difusion', $data);
	}

	public function descripcionBiblat(){
		$data = array();
		$data['page_title'] = _('Descripción');
		$this->template->title(_('Biblat - Descripción'));
		$this->template->set_breadcrumb(_('Bibliometría'));
		$this->template->set_meta('description', _('Descripción'));
		$this->template->build('main/descripcion_biblat', $data);
	}

	public function metodologiaBiblat(){
		$data = array();
		$data['page_title'] = _('Metodología');
		$this->template->set_partial('view_js', 'main/header_metodologia', array(), TRUE);
		$this->template->title(_('Biblat - Metodología'));
		$this->template->css('assets/css/colorbox.css');
		$this->template->js('assets/js/colorbox.js');
		$this->template->set_breadcrumb(_('Bibliometría'));
		$this->template->set_meta('description', _('Metodología'));
		$this->template->build('main/metodologia_biblat', $data);
	}

	public function indicadoresScielo(){
		$data = array();
		$data['header']['title'] = _("Biblat - Indicadores por revista");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/indicadores_scielo');
		$this->load->view('footer');
	}

	public function indicadoresRevista($alpha="a"){
		$this->load->library('pagination');
		$config['base_url'] = site_url('bibliometria/indicadores-por-revista');
		$config['uri_segment'] = 4;
		$config['first_link'] = "&laquo;";
		$config['last_link'] = "&raquo;";
		$config['next_link'] = "&rsaquo;";
		$config['prev_link'] = "&lsaquo;";
		$config['cur_tag_open'] = '<li class="active text-uppercase"><a href="javascript:;">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="text-uppercase">';
		$config['num_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['full_tag_open'] = '<ul class="pagination hidden-md hidden-lg">';
		$config['full_tag_close'] = '</ul>';
		$this->pagination->initialize($config);

		$this->load->database();
		$query = "SELECT * FROM \"vIndicadoresRevista\" WHERE substr(\"revistaSlug\", 1 , 1)='{$alpha}'";
		$query = $this->db->query($query);
		$this->db->close();

		$data = array();
		$data['revistas'] = $query->result_array();
		$data['alpha_links'] = $this->pagination->create_alpha_links();
		$data['alpha'] = strtoupper($alpha);
		$data['page_title'] = _('Indicadores por revista');
		$this->template->set_partial('view_js', 'main/indicadores_por_revista_js', array(), TRUE);
		$this->template->title(_('Biblat - Indicadores por revista'));
		$this->template->set_breadcrumb(_('Bibliometría'));
		$this->template->set_meta('description', _('Metodología'));
		$this->template->build('main/indicadores_por_revista', $data);
	}

	public function criteriosSeleccion(){
		$data = array();
		$data['page_title'] = _('Criterios de selección');
		$this->template->title(_('Biblat - Criterios de selección'));
		$this->template->set_breadcrumb(_('Postular una revista'));
		$this->template->set_meta('description', _('Criterios de selección'));
		$this->template->build('main/criterios_seleccion', $data);
	}

	public function sitemap(){
		$data = array();
		$data['header']['title'] = _("Biblat - Mapa del sitio");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/sitemap');
		$this->load->view('footer');
	}

	public function contacto(){
		$this->load->library('recaptcha');
		$data['main']['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('main/contacto',$data['main']);
		$this->load->view('footer');
	}

	public function contactoSubmit(){
		$this->load->library('recaptcha');
		$this->recaptcha->recaptcha_check_answer();
		var_dump($this->recaptcha->getIsValid());
	}

	public function lang_notification(){
		$browserLang = browser_lang_array();
		$data['message'] = _sprintf('Deacuerdo al idioma de su navegador le sugerimos cambiar el idioma de la página a %s', $browserLang['title']);
		$data['button'] = '<button class="btn btn-warning translate">'._('Traducir').'</button>';
		echo json_encode($data, TRUE); exit(0);
	}
}
