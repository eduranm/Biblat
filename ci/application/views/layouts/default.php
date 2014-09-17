<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{$template.title}</title>
        <meta name="resource-type" content="document" />
        <meta name="robots" content="all, index, follow"/>
        <meta name="googlebot" content="all, index, follow" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
{foreach $meta name content}
        <meta name="{$name}" content="{$content}" />
{/foreach}
        <link rel="icon" href="{base_url('assets/themes/default/img/favicon.ico')}" type="image/x-icon"/>
        <link rel="stylesheet" href="{base_url('assets/themes/default/css/bootstrap.min.css')}" type="text/css" />
        <link rel="stylesheet" href="{base_url('assets/themes/default/css/font-awesome.min.css')}" type="text/css" />
        <link rel="stylesheet" href="{base_url('assets/themes/default/css/biblat.css')}" type="text/css" />
{if $canonical}
        <link rel="canonical" href="{$canonical}" />
{/if}
{foreach $css file}
        <link rel="stylesheet" href="{$file}" type="text/css" />
{/foreach}
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
    </head>
    <body>
        <header class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-10 col-lg-offset-1">
                    <div class="row">
                    	<div id="biblat-logo" class="col-md-4 hidden-xs hidden-sm">
                            <span class="bl-single"></span><br/>
                            <span class="bl-large"></span><br/>
                            <span class="bl-sub"></span><br/>
                        </div>
                        <div id="menu" class="col-md-8">
                            <div class="row">
                            	<div id="dgb-unam" class="col-sm-3 col-sm-offset-9 col-md-4 col-md-offset-8 hidden-xs hidden-sm text-right">
                                    <span class="bl-dgb fa-5x"></span> <span class="bl-unam fa-5x"></span>
                                </div>
                                <div class="col-md-12">
                                    <nav class="navbar navbar-default" role="navigation">
                                        <div class="container-fluid">
                                            <div class="navbar-header hidden-md hidden-lg">
                                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1">
                                                    <span class="sr-only">Toggle navigation</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                                <a class="navbar-brand" href="{base_url()}" title="{_('Bibliografía Latinoamericana')}"><span class="bl-single"></span></a>
                                            </div>
                                            <div class="collapse navbar-collapse navbar-right" id="bs-navbar-collapse-1">
                                                <ul class="nav navbar-nav">
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{_('Sobre Biblat')}<span class="caret"></span></a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{site_url('sobre-biblat')}">{_('¿Qué es Biblat?')}</a></li>
                                                            <li><a href="{site_url('clase-y-periodica')}">{_('Clase y Periódica')}</a></li>
                                                            <li><a href="{site_url('manual-de-indizacion')}">{_('Manual de indización')}</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="{site_url('scielo')}">{_('SciELO')}</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#">{_('Tutoriales')}</a></li>
                                                            <li><a href="{site_url('materiales-de-difusion')}">{_('Materiales de difusión')}</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{_('Bibliometría')}<span class="caret"></span></a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{site_url('bibliometria/descripcion-biblat')}">{_('Descripción')}</a></li>
                                                            <li><a href="{site_url('bibliometria/metodologia-biblat')}">{_('Metodología')}</a></li>
                                                            <li><a href="{site_url('frecuencias')}">{_('Frecuencias')}</a></li>
                                                            <li><a href="{site_url('indicadores')}">{_('Indicadores')}</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#">{_('Indicadores SciELO')}</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#">{_('Indicadores por revista')}</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{_('Postular una revista')}<span class="caret"></span></a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{site_url('postular-revista/criterios-de-seleccion')}">{_('Criterios de selección de revistas')}</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#">{_('Políticas de acceso')}</a></li>
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{_('Documentos')}<span class="caret"></span></a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{site_url('documentos/bibliografia')}">{_('Bibliografía')}</a></li>
                                                            <li><a href="#">{_('Presentaciones PPT')}</a></li>
                                                            <li><a href="#">{_('Archivos multimedia')}</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                                <ul class="nav navbar-nav visible-xs-block">
                                                    <li><a href="#"><span class="fa fa-facebook-square"></span>  Facebook</a></li>
                                                    <li><a href="#"><span class="fa fa-twitter"></span> Twitter</a></li>
                                                    <li><a href="#"><span class="fa fa-question-circle"></span> {_('Ayuda')}</a></li>
                                                    <li><a href="#"><span class="fa fa-envelope-o"></span> {_('Contacto')}</a></li>
                                                    <li><a href="#"><span class="fa fa-print"></span> {_('Imprimir')}</a></li>
                                                    <li class="dropdown">
                                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-language"></span> {_('Idioma')}<span class="caret"></span></a>
                                                      <ul class="dropdown-menu" role="menu">
                                                        {foreach supported_langs() langKey curlang}
                                                        <li><a href="{site_url($lang->switch_uri($langKey))}">{$curlang.title}</a></li>
                                                        {/foreach}
                                                      </ul>
                                                    </li>
                                                </ul>
                                            </div><!-- /.navbar-collapse -->
                                        </div><!-- /.container -->
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div><!--row-->
                </div><!--cols-->
            </div><!--row-->
        </header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-10 col-lg-offset-1">
                    <div id="heading" class="row">
                        <div class="col-sm-9">
                            <ol class="breadcrumb">
                                <li><a href="#">{_('Inicio')}</a></li>
                                <li><a href="#">{_('Sobre Biblat')}</a></li>
                            </ol>
                            <div id="title">
                                <hr/>
                                <h4 id="title">{_('¿Qué es Biblat?')}</h4>
                                <hr/>
                            </div>
                        </div>
                        <div class="col-xs-offset-0 col-sm-2 col-sm-offset-1 col-md-3 col-md-offset-0 hidden-xs">
                            <nav class="navbar navbar-default navbar-right" role="navigation">
                                <div class="collapse navbar-collapse">
                                    <ul class="nav navbar-nav">
                                        <li><a href="#"><span class="fa fa-facebook-square"></span><span class="visible-xs-inline"> Facebook</span></a></li>
                                        <li><a href="#"><span class="fa fa-twitter"></span><span class="visible-xs-inline"> Twitter</span></a></li>
                                        <li><a href="#"><span class="fa fa-question-circle"></span><span class="visible-xs-inline"> {_('Ayuda')}</span></a></li>
                                        <li><a href="#"><span class="fa fa-envelope-o"></span><span class="visible-xs-inline"> {_('Contacto')}</span></a></li>
                                        <li><a href="#"><span class="fa fa-print"></span><span class="visible-xs-inline"> {_('Imprimir')}</span></a></li>
                                        <li class="dropdown">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-language"></span><span class="visible-xs-inline"> {_('Idioma')}</span><span class="caret"></span></a>
                                          <ul class="dropdown-menu" role="menu">
                                            {foreach supported_langs() langKey curlang}
                                            <li><a href="{site_url($lang->switch_uri($langKey))}">{$curlang.title}</a></li>
                                            {/foreach}
                                          </ul>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div><!--heading-->
                </div>
            </div>
        </div><!--container-fluid-->
        <div class="container-fluid">
            <div class="row">
                <div id="main" class="col-md-12 col-lg-10 col-lg-offset-1">
                    {$template.body}
                    <div class="clearfix"></div>
                </div><!--main-->
            </div><!--row-->
        </div><!--container-fluid-->
        <footer class="container-fluid">
            <div class="row">
                <div id="sitemap" class="col-md-12 col-lg-10 col-lg-offset-1 hidden-xs">
                    <div class="row">
                        <div class="col-xs-9 col-xs-offset-3 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1">
                            <ul class="list-unstyled">
                              <li><a href="{site_url('sobre-biblat')}">{_('¿Qué es Biblat?')}</a></li>
                              <li><a href="{site_url('clase-y-periodica')}">{_('Clase y Periódica')}</a></li>
                              <li><a href="{site_url('manual-de-indizacion')}">{_('Manual de indización')}</a></li>
                              <li><a href="{site_url('scielo')}">{_('SciELO')}</a></li>
                              <li><a href="#">{_('Tutoriales')}</a></li>
                              <li><a href="{site_url('materiales-de-difusion')}">{_('Materiales de difusión')}</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-9 col-xs-offset-3 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1">
                            <ul class="list-unstyled">
                              <li><a href="{site_url('bibliometria/descripcion-biblat')}">{_('Descripción')}</a></li>
                              <li><a href="{site_url('bibliometria/metodologia-biblat')}">{_('Metodología')}</a></li>
                              <li><a href="{site_url('frecuencias')}">{_('Frecuencias')}</a></li>
                              <li><a href="{site_url('indicadores')}">{_('Indicadores')}</a></li>
                              <li><a href="#">{_('Indicadores SciELO')}</a></li>
                              <li><a href="#">{_('Indicadores por revista')}</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-9 col-xs-offset-3 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1">
                            <ul class="list-unstyled">
                              <li><a href="{site_url('postular-revista/criterios-de-seleccion')}">{_('Criterios de selección de revistas')}</a></li>
                              <li><a href="#">{_('Políticas de acceso')}</a></li>
                              <li><a href="{site_url('documentos/bibliografia')}">{_('Bibliografía')}</a></li>
                              <li><a href="#">{_('Presentaciones PPT')}</a></li>
                              <li><a href="#">{_('Archivos multimedia')}</a></li>
                            </ul>
                        </div>
                    </div><!--row-->
                </div><!--sitemap-->
                <div id="copyright" class="col-md-12 col-lg-10 col-lg-offset-1 text-center">
                    {_sprintf('® Derechos reservados. 2009 - %d. Dirección General de Bibliotecas, Universidad Nacional Autónoma de México (UNAM). Esta página y sus contenidos pueden ser utilizados y reproducidos con fines no lucrativos, siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica. De otra forma, requiere permiso previo por escrito de la institución.', date('Y'))} <a href="{site_url('creditos')}">{_('CRÉDITOS')}</a>
                </div>
            </div><!--row-->
        </footer>
        <script src="{base_url('assets/themes/default/js/jquery.js')}"></script>
        <script src="{base_url('assets/themes/default/js/bootstrap.min.js')}"></script>
        {foreach $js file}
        <script src="{$file}"></script>
        {/foreach}
    </body>
</html>