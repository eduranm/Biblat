<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "main";
$route['404_override'] = '';

$route['setlang/(.*)'] = 'setlang/index/$1';

$route['buscar/(autor|articulo|institucion|revista|tema)/(.*)/(texto-completo)(.*)'] = 'buscar/index/$1/null/$2/$3$4';
$route['buscar/(.*)/(.*)/(texto-completo)(.*)'] = 'buscar/index/null/$1/$2/$3$4';
$route['buscar/(.*)/(texto-completo)(.*)'] = 'buscar/index/null/null/$1/$2$3';
$route['buscar/(autor|articulo|institucion|revista|tema)/(.*)/([0-9]+)'] = 'buscar/index/$1/null/$2/$3';
$route['buscar/(.*)/(.*)/([0-9]+)'] = 'buscar/index/null/$1/$2/$3';
$route['buscar/(.*)/([0-9]+)'] = 'buscar/index/null/null/$1/$2';
$route['buscar/(autor|articulo|institucion|revista|tema)/(.*)'] = 'buscar/index/$1/null/$2';
$route['buscar/(.*)/(.*)'] = 'buscar/index/null/$1/$2';
$route['buscar/(.*)'] = 'buscar/index/null/null/$1';

$route['revista/(.+)/articulo/(.+)'] = "revista/articulo/revista/$1/articulo/$2";
$route['revista/(.*)'] = "revista/index/$1";

$route['indicadores/(indice-coautoria|tasa-documentos-coautorados|grado-colaboracion|modelo-elitismo|indice-colaboracion|indice-densidad-documentos|indice-concentracion|modelo-bradford-revista|modelo-bradford-institucion|productividad-exogena)(.*)'] = "indicadores/index/$1";

$route['frecuencias/institucion/([^/]+)'] = "frecuencias/institucion/slug/$1";
$route['frecuencias/institucion/([^/]+)/(ordenar/.*)'] = "frecuencias/institucion/slug/$1/$2";
$route['frecuencias/autor/([^/]+)'] = "frecuencias/autorDocumentos/$1";
$route['frecuencias/autor/([^/]+)/([0-9]+)'] = "frecuencias/autorDocumentos/$1/$2";

$route['frecuencias/institucion/([^/]+)/documento'] = "frecuencias/institucionDocumentos/$1";
$route['frecuencias/institucion/([^/]+)/documento/([0-9]+)'] = "frecuencias/institucionDocumentos/$1/$2";
$route['frecuencias/institucion/(.+?)/\bpais\b/([^/]+)$'] = "frecuencias/institucionPaisDocumentos/$1/$2";
$route['frecuencias/institucion/(.+?)/\bpais\b/([^/]+)/[0-9^/]$'] = "frecuencias/institucionPaisDocumentos/$1/$2/$3";
$route['frecuencias/institucion/(.+?)/\bpais\b(.*)'] = "frecuencias/institucionPais/institucionSlug/$1$2";
$route['frecuencias/institucion/(.+?)/\brevista\b/([^/]+)$'] = "frecuencias/institucionRevistaDocumentos/$1/$2";
$route['frecuencias/institucion/(.+?)/\brevista\b/([^/]+)/[0-9^/]$'] = "frecuencias/institucionRevistaDocumentos/$1/$2/$3";
$route['frecuencias/institucion/(.+?)/\brevista\b(.*)'] = "frecuencias/institucionRevista/institucionSlug/$1$2";
$route['frecuencias/institucion/(.+?)/\bautor\b/([^/]+)$'] = "frecuencias/institucionAutorDocumentos/$1/$2";
$route['frecuencias/institucion/(.+?)/\bautor\b/([^/]+)/[0-9^/]$'] = "frecuencias/institucionAutorDocumentos/$1/$2/$3";
$route['frecuencias/institucion/(.+?)/\bautor\b(.*)'] = "frecuencias/institucionAutor/institucionSlug/$1$2";
/* End of file routes.php */
/* Location: ./application/config/routes.php */
