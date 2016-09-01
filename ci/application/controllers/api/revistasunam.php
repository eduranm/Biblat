<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class Revistasunam extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function indicadores_get(){
        $data = array();
        $issn = $this->get('issn') ? $this->get('issn') : NULL;
        $this->load->database();
        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $request = array(
                'collection' => 'mex',
                'journal' => $issn,
                'field' => 'issn',
            );
        $this->load->library('curl');
        $this->curl->get('http://analytics.scielo.org/ajx/publication/size', $request);
        // $this->curl->setHeader('Content-Type', 'application/json');
        $scielo = (object) array('total' => 0);
        if (!$this->curl->error)
            $scielo = $this->curl->response;
        if($scielo->total == 1):
            $endpoint = "w/accesses/list/journals";
            $params = array(
                "journal" => $issn,
                "collection" => "mex"
            );
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Accesos totales a los documentos de la revista',
                    'url' => $this->analytics_url($endpoint, $params),
                    'img' => NULL
                );
            $endpoint = "w/accesses/list/issues";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Fascículos más consultados',
                    'url' => $this->analytics_url($endpoint, $params),
                    'img' => NULL
                );
            $endpoint = "w/accesses/list/articles";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Artículos más consultados',
                    'url' => $this->analytics_url($endpoint, $params),
                    'img' => NULL
                );
            $endpoint = "w/publication/size";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'No. de fascículos, documentos y referencias concedidas ingresadas en SciELOMX',
                    'url' => $this->analytics_url($endpoint, $params),
                    'img' => NULL
                );
            $endpoint = "w/publication/article";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Licencias Creative Commons en documentos publicados',
                    'url' => $this->analytics_url($endpoint, $params),
                    'img' => NULL
                );
            $endpoint = "w/publication/article_by_publication_year";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Licencias CC en documentos por año de publicación',
                    'url' => $this->analytics_url($endpoint, $params)."#article_licenses_publication_year",
                    'img' => NULL
                );
            $endpoint = "w/publication/article";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Área temática de los documentos publicados',
                    'url' => $this->analytics_url($endpoint, $params)."#article_subject_areas",
                    'img' => NULL
                );
            $endpoint = "w/publication/article_by_publication_year";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Área temática de los documentos por año de publicación',
                    'url' => $this->analytics_url($endpoint, $params)."#article_subject_areas_publication_year",
                    'img' => NULL
                );
            $endpoint = "w/publication/article";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Publicación por tipo de documento',
                    'url' => $this->analytics_url($endpoint, $params)."#document_type",
                    'img' => NULL
                );
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Idioma de publicación de documentos',
                    'url' => $this->analytics_url($endpoint, $params)."#article_languages",
                    'img' => NULL
                );
            $endpoint = "w/publication/article_by_publication_year";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Idioma de los documentos por año de publicación',
                    'url' => $this->analytics_url($endpoint, $params)."#article_languages_publication_year",
                    'img' => NULL
                );
            $endpoint = "w/publication/article";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'No. de documentos publicados por año',
                    'url' => $this->analytics_url($endpoint, $params)."#article_year",
                    'img' => NULL
                );
            $endpoint = "w/publication/article";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'No. de referencias bibliográficas citadas en los documentos',
                    'url' => $this->analytics_url($endpoint, $params)."#article_references",
                    'img' => NULL
                );
            $endpoint = "w/bibliometrics/journal";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Gráficas de citas concedidas, recibidas y autocitas',
                    'url' => $this->analytics_url($endpoint, $params),
                    'img' => NULL
                );
            $endpoint = "bibliometrics/list/granted";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Citas concedidas por revista',
                    'url' => $this->analytics_url($endpoint, $params),
                    'img' => NULL
                );
            $endpoint = "bibliometrics/list/received";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Citas recibidas por revista',
                    'url' => $this->analytics_url($endpoint, $params),
                    'img' => NULL
                );
            $endpoint = "bibliometrics/list/citing_forms";
            $data[$issn]['indicators']['scielo'][] = array(
                    'title' => 'Variedad de formas en la que es citada la revista',
                    'url' => $this->analytics_url($endpoint, $params),
                    'img' => NULL
                );
        endif;

        $query = "SELECT * FROM \"vIndicadoresRevistaGeneral\"";
        if(isset($issn))
            $query = "{$query} WHERE \"revistaISSN\"='{$issn}'";
        $query = $this->db->query($query);
        $this->db->close();
        foreach ($query->result_array() as $journal):
            if(!isset($data[$journal['revistaISSN']]['name']))
                $data[$journal['revistaISSN']]['name'] = $journal['revista'];
            if($journal['pratt']):
                $data[$journal['revistaISSN']]['indicators']['biblat'][] = array(
                        'title' => 'Índice de concentración Pratt',
                        'url' => site_url("indicadores/indice-concentracion/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
                        'img' => site_url("indicadores/indice-concentracion/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}/preview.png")
                    );
            endif;
            if($journal['exogena']):
                $data[$journal['revistaISSN']]['indicators']['biblat'][] = array(
                        'title' => 'Tasa de autoría exógena',
                        'url' => site_url("indicadores/productividad-exogena/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
                        'img' => site_url("indicadores/productividad-exogena/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}/preview.png")
                    );
            endif;
            if($journal['coautoriapricezakutina']):
                $data[$journal['revistaISSN']]['indicators']['biblat'][] = array(
                        'title' => 'Índice de coautoría',
                        'url' => site_url("indicadores/indice-coautoria/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
                        'img' => site_url("indicadores/indice-coautoria/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}/preview.png")
                    );
                $data[$journal['revistaISSN']]['indicators']['biblat'][] = array(
                        'title' => 'Modelo de elitismo (Price)',
                        'url' => site_url("indicadores/modelo-elitismo/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
                        'img' => site_url("indicadores/modelo-elitismo/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}/preview.png")
                    );
                $data[$journal['revistaISSN']]['indicators']['biblat'][] = array(
                        'title' => 'Índice de densidad de documentos Zakutina y Priyenikova',
                        'url' => site_url("indicadores/indice-densidad-documentos/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
                        'img' => site_url("indicadores/indice-densidad-documentos/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}/preview.png")
                    );
            endif;
            if($journal['subramayan']):
                $data[$journal['revistaISSN']]['indicators']['biblat'][] = array(
                        'title' => 'Grado de colaboración (Índice Subramanyan)',
                        'url' => site_url("indicadores/grado-colaboracion/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
                        'img' => site_url("indicadores/grado-colaboracion/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}/preview.png")
                    );
            endif;
            if($journal['tasalawani']):
                $data[$journal['revistaISSN']]['indicators']['biblat'][] = array(
                        'title' => 'Tasa de documentos coautorados',
                        'url' => site_url("indicadores/tasa-documentos-coautorados/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
                        'img' => site_url("indicadores/tasa-documentos-coautorados/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}/preview.png")
                    );
                $data[$journal['revistaISSN']]['indicators']['biblat'][] = array(
                        'title' => 'Tasa de documentos coautorados',
                        'url' => site_url("indicadores/indice-colaboracion/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}"),
                        'img' => site_url("indicadores/indice-colaboracion/disciplina/{$journal['disciplinaSlug']}/revista/{$journal['revistaSlug']}/preview.png")
                    );
            endif;
        endforeach;
        
        $this->response($data, 200);
    }

    public function analytics_url($endpoint, $params){
        $analytics = "http://analytics.scielo.org";
        $params_url = "?";
        foreach ($params as $key => $value):
            $params_url .= sprintf("&%s=%s", $key, $value);
        endforeach;
        $params_url = str_replace("?&", "?", $params_url);
        return sprintf('%s/%s%s', $analytics, $endpoint, $params_url);
    }
}