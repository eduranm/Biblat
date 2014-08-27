<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class Scielo extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index_get(){
		$article=array();
		$article['google']=array(
				'citation_journal_title' => 'Atmósfera',
				'citation_journal_title_abbrev' => 'Atmósfera',
				'citation_publisher' => 'Centro de Ciencias de la Atmósfera, UNAM',
				'citation_title' => 'Modeling methane emissions and methane inventories for cattle production systems in Mexico',
				'citation_date' => '04/2014',
				'citation_volume' => '27',
				'citation_issue' => '2',
				'citation_issn' => '0187-6236',
				'citation_doi' => '0.10.1038/nphys1170',
				'citation_abstract_html_url' => 'http://www.scielo.org.mx/scielo.php?script=sci_abstract&amp;pid=S0187-62362014000200006&amp;lng=es&amp;nrm=iso&amp;tlng=en',
				'citation_fulltext_html_url' => 'http://www.scielo.org.mx/scielo.php?script=sci_arttext&amp;pid=S0187-62362014000200006&amp;lng=es&amp;nrm=iso&amp;tlng=en',
				'citation_pdf_url' => 'http://www.scielo.org.mx/scielo.php?script=sci_pdf&amp;pid=S0187-62362014000200006&amp;lng=es&amp;nrm=iso&amp;tlng=en',
				'citation_language' => 'es',
				'citation_keywords' => array(
						array('lang'=>'en', 'keyword'=>'Methane'),
						array('lang'=>'en', 'keyword'=>'ruminant'),
						array('lang'=>'en', 'keyword'=>'greenhouse gases'),
					),
				'citation_authors' => array(
						array(
							'fname' => 'Octavio Alonso',
							'surname' => 'Castellán-Ortega',
							'aff' => 'Universidad Autónoma del Estado de México, Toluca, México',
							'email' => 'a@a.com'
						),
						array(
							'fname' => 'Juan Carlos',
							'surname' => 'Ku-Vera',
							'aff' => 'Universidad Autónoma de Yucatán, Mérida, México',
							'email' => 'b@b.com'
						),
						array(
							'fname' => 'Julieta G.',
							'surname' => 'Estrada-Flores',
							'aff' => 'Universidad Autónoma de Yucatán, Mérida, México',
							'email' => 'b@b.com'
						)
					),
				'citation_firstpage' => '185',
				'citation_lastpage' => '191',
				'citation_id' => '#',
				'citation_section' => 'Artículos',
				'abstract' => array(
						'lang'=>'en',
						'content' => 'Anaerobic fermentation of structural carbohydrates in the rumen of bovines produces waste products such as volatile fatty acids, fermentation heat, carbon dioxide and methane gas. Methane is a greenhouse gas having several times the global warming potential of CO2. The purpose of the present paper is to provide a realistic estimate of the national inventory of methane produced by the enteric fermentation of cattle, based on a simulation model and to provide estimates of CH4 produced by cattle fed typical diets from the tropical and temperate climates of Mexico. Predicted total emission of methane produced by the 23.3 million heads of cattle in Mexico is approximately 2.02 Tg/yr. It was concluded that the modeling approach was suitable in producing a better estimate of the national methane inventory for cattle. It is flexible enough to incorporate more cattle groups or classification schemes, productivity levels and a variety feed ingredients for cattle. The model could also be used to evaluate different mitigation strategies and serve as a tool to design mitigation policies.'
					),
				'files' => array(
						array(
							'type' => 'application/pdf',
							'name' => '43-209-1-PB.pdf',
							'imgs' => null,
							'url' => 'http://donde.esta.alojado/43-209-1-PB.pdf'
						),
						array(
							'type' => 'text/html',
							'name' => '43-210-1-PB.html',
							'imgs' => array(
										array(
											'name' => '343-2400-1-PB.jpg',
											'original' => '010solares01.jpg',
											'url' => 'http://donde.esta.alojado/343-2400-1-PB.jpg'
										),
										array(
											'name' => '344-2407-1-PB.jpg',
											'original' => '010espejo02.jpg',
											'url' => 'http://donde.esta.alojado/344-2407-1-PB.jpg'
										),
									),
							'url' => 'http://donde.esta.alojado/43-210-1-PB.html'
						)
					) 
			);

		$article['dc']=array(
				'dcterms:citation' => array(
						'journalTitle' => 'Atmósfera',
						'journalAbbreviatedTitle' => 'Atmósfera',
						'journalVolume' => '27',
						'journalIssueNumber' => '2',
						'journalIssueDate' => '04/2014',
						'pagination' => '185-191'
					),
				'dc:source' => array(
						'issn' => '0187-6236',
						'uri' => 'http://www.scielo.org.mx/scielo.php?script=sci_arttext&amp;pid=S0187-62362014000200006&amp;lng=es&amp;nrm=iso&amp;tlng=en'
					),
				'dc:publisher' => 'Centro de Ciencias de la Atmósfera, UNAM',
				'dc:title' => 'Modeling methane emissions and methane inventories for cattle production systems in Mexico',
				'dc:date' => '04/2014',
				'citation_language' => 'es',
				'dc:subjects' => array(
						array('lang'=>'en', 'keyword'=>'Methane'),
						array('lang'=>'en', 'keyword'=>'ruminant'),
						array('lang'=>'en', 'keyword'=>'greenhouse gases'),
					),
				'dc:creators' => array(
						array(
							'fname' => 'Octavio Alonso',
							'surname' => 'Castellán-Ortega',
							'aff' => 'Universidad Autónoma del Estado de México, Toluca, México',
							'email' => 'a@a.com'
						),
						array(
							'fname' => 'Juan Carlos',
							'surname' => 'Ku-Vera',
							'aff' => 'Universidad Autónoma de Yucatán, Mérida, México',
							'email' => 'b@b.com'
						),
						array(
							'fname' => 'Julieta G.',
							'surname' => 'Estrada-Flores',
							'aff' => 'Universidad Autónoma de Yucatán, Mérida, México',
							'email' => 'b@b.com'
						)
					),
				'dc:identifier' => '#',
				'dc:description' => array(
						'lang'=>'en',
						'content' => 'Anaerobic fermentation of structural carbohydrates in the rumen of bovines produces waste products such as volatile fatty acids, fermentation heat, carbon dioxide and methane gas. Methane is a greenhouse gas having several times the global warming potential of CO2. The purpose of the present paper is to provide a realistic estimate of the national inventory of methane produced by the enteric fermentation of cattle, based on a simulation model and to provide estimates of CH4 produced by cattle fed typical diets from the tropical and temperate climates of Mexico. Predicted total emission of methane produced by the 23.3 million heads of cattle in Mexico is approximately 2.02 Tg/yr. It was concluded that the modeling approach was suitable in producing a better estimate of the national methane inventory for cattle. It is flexible enough to incorporate more cattle groups or classification schemes, productivity levels and a variety feed ingredients for cattle. The model could also be used to evaluate different mitigation strategies and serve as a tool to design mitigation policies.'
					),
				'section_id' => '1',
				'section' => 'Artículos',
				'files' => array(
						array(
							'type' => 'application/pdf',
							'name' => '43-209-1-PB.pdf',
							'imgs' => null,
							'url' => 'http://donde.esta.alojado/43-209-1-PB.pdf'
						),
						array(
							'type' => 'text/html',
							'name' => '43-210-1-PB.html',
							'imgs' => array(
										array(
											'name' => '343-2400-1-PB.jpg',
											'original' => '010solares01.jpg',
											'url' => 'http://donde.esta.alojado/343-2400-1-PB.jpg'
										),
										array(
											'name' => '344-2407-1-PB.jpg',
											'original' => '010espejo02.jpg',
											'url' => 'http://donde.esta.alojado/344-2407-1-PB.jpg'
										),
									),
							'url' => 'http://donde.esta.alojado/43-210-1-PB.html'
						)
					) 
			);
		$this->response($article[$this->get('type')]);
	}

}

/* End of file institution.php */
/* Location: ./application/controllers/api/institution.php */