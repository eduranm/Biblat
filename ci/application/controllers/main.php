<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->output->enable_profiler($this->config->item('enable_profiler'));
		$this->template->set_partial('biblat_js', 'javascript/biblat', array(), TRUE);
		$this->template->set_partial('submenu', 'layouts/submenu');
		$this->template->set_breadcrumb(_('Inicio'), site_url('/'));
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
		if(! $this->session->userdata('paises')){
			$query = "SELECT * FROM \"mvPais\" WHERE \"paisSlug\" <> 'internacional'";
			$query = $this->db->query($query);
			$paises = $query->result_array();
			$query->free_result();
			$this->db->close();
			$this->session->set_userdata('paises', json_encode($paises));
		}
		$data['index']['paises'] = json_decode($this->session->userdata('paises'), TRUE);
		/*Vistas*/
		$data['header']['disciplinas'] = $data['index']['disciplinas'];
		$data['header']['content'] =  $this->load->view('main/header', $data['header'], TRUE);
		$this->load->view('header', $data['header']);
		$this->load->view('menu', $data['header']);
		$this->load->view('main/index', $data['index']);
		$this->load->view('footer');
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
		$query = "SELECT * FROM \"mvDisciplinasBase\" ORDER BY iddatabase, disciplina";
		$query = $this->db->query($query);
		$data[ 'disciplina' ] = array();
		foreach ($query->result_array() as $row):
				$disciplina = array();
				$disciplina['disciplina'] = $row['disciplina'];
				$disciplina['slug'] = $row['slug'];
   				$data[ 'disciplina' ][ $row[ 'iddatabase' ] ][] = $disciplina;	
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
		$this->template->set_partial('view_js', 'header_metodologia', array(), TRUE);
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
		$this->template->set_partial('view_js', 'header_metodologia', array(), TRUE);
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

	public function indicadoresRevista(){
		$data = array();
		$data['header']['title'] = _("Biblat - Indicadores por revista");
		$this->load->view('header', $data['header']);
		$this->load->view('menu');
		$this->load->view('main/indicadores_por_revista');
		$this->load->view('footer');
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
		$data['button'] = '<button class="translate">'._('Traducir').'</button>';
		echo json_encode($data, TRUE); exit(0);
	}
}
