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
{foreach $template.meta name content}
        <meta name="{$name}" content="{$content}" />
{/foreach}
        <link rel="icon" href="{base_url('assets/img/favicon.ico')}" type="image/x-icon"/>
        <link rel="stylesheet" href="{base_url('assets/css/bootstrap.min.css')}" type="text/css" />
        <link rel="stylesheet" href="{base_url('css/jquery-ui.min.css')}" type="text/css" />
        <link rel="stylesheet" href="{base_url('assets/css/font-awesome.min.css')}" type="text/css" />
        <link rel="stylesheet" href="{base_url('js/pnotify/jquery.pnotify.default.css')}" type="text/css" />
        <link rel="stylesheet" href="{base_url('js/select2/select2.css')}" />
        <link rel="stylesheet" href="{base_url('assets/css/biblat.css')}" type="text/css" />
{if $canonical}
        <link rel="canonical" href="{$canonical}" />
{/if}
{foreach $template.css file}
        <link rel="stylesheet" href="{$file}" type="text/css" />
{/foreach}
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
      <body>
        <header>
            <div class="container">
                <div class="row">
                    <div id="biblat-logo" class="col-md-4 hidden-xs hidden-sm">
                        <a href="{site_url('/')}" title="{_('Bibliografía Latinoamericana')}">
                            <span class="bl-single"></span><br/>
                            <span class="bl-large"></span><br/>
                            <span class="bl-sub"></span><br/>
                        </a>
                    </div>
                    <div id="menu" class="col-md-8">
                        <div class="row">
                            <div id="dgb-unam" class="col-md-12 text-right hidden-xs hidden-sm">
                                <a href="http://dgb.unam.mx" title="{_('Dirección General de Bibliotecas')}" target="_blank"><span class="bl-dgb fa-5x"></a></span> 
                                <a href="http://www.unam.mx" title="{_('Universidad Nacional Autónoma de México')}" target="_blank"><span class="bl-unam fa-5x"></a></span>
                            </div>
                            <div class="col-md-12 navbar-main">
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
                                            <div class="visible-xs-block">
                                                {$template.partials.submenu}
                                            </div>
                                        </div><!-- /.navbar-collapse -->
                                    </div><!-- /.container -->
                                </nav>
                            </div><!--col-md-12-->
                            <div class="col-md-12 hidden-xs hidden-sm">
                                <form action="<?=site_url('buscar');?>" id="searchform" method="post" role="search" autocomplete="off">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-search dropdown-toggle" data-toggle="dropdown">
                                                        <span id="search-type" class="fa fa-cloud fa-fw"> </span><span class="caret"></span>
                                                    </button>
                                                    <ul id="search-opts" class="dropdown-menu" role="menu">
                                                    <li rel="todos"><a href="#"><span id="todos" class="fa fa-cloud fa-fw"></span> {_('Buscar en todos los campos')}</a></li>
                                                    <li rel="palabra-clave"><a href="#"><span id="palabra-clave" class="fa fa-key fa-fw"></span> {_('Buscar por palabra clave')}</a></li>
                                                    <li rel="autor"><a href="#"><span id="autor" class="fa fa-user fa-fw"></span> {_('Buscar por autor')}</a></li>
                                                    <li rel="revista"><a href="#"><span id="revista" class="fa fa-book fa-fw"></span> {_('Buscar por revista')}</a></li>
                                                    <li rel="institucion"><a href="#"><span id="institucion" class="fa fa-building fa-fw"></span> {_('Buscar por institución')}</a></li>
                                                    <li rel="articulo"><a href="#"><span id="articulo" class="fa fa-file-text-o fa-fw"></span> {_('Buscar por artículo')}</a></li>
                                                    <li rel="avanzada"><a href="#"><span id="avanzada" class="fa fa-search-plus fa-fw"></span> {_('Búsqueda avanzada')}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <textarea class="form-control" id="slug" name="slug" placeholder="{_('Buscar en Biblat')}"></textarea>
                                            <div id="advsearch" class="form-control"></div>
                                            <div class="input-group-addon">
                                                <button type="submit" class="btn btn-search"><span class="fa fa-search"></span></button>
                                            </div>
                                        </div><!--input-group-->
                                        <input type="hidden" name="disciplina" value=""/>
                                        <input type="hidden" name="filtro" id="filtro" value="todos"/>
                                    </div><!--form-group-->
                                </form>
                            </div><!--col-md-12 search-->
                        </div><!--row-->
                    </div><!--menu--> 
                </div><!--row--> 
            </div><!--container--> 
        </header>
        <div class="container">
            <div id="heading" class="row">
                <div class="col-sm-9">
                    <ol class="breadcrumb">
                        <li><a href="#">{_('Inicio')}</a></li>
                        <li>{_('Sobre Biblat')}</li>
                    </ol>
                    <div id="title">
                        <hr/>
                        <h4>{_('¿Qué es Biblat?')}</h4>
                        <hr/>
                    </div>
                </div>
                <div class="col-sm-3 hidden-xs">
                    <nav class="navbar navbar-default navbar-right" role="navigation">
                        <div class="container-fluid">
{$template.partials.submenu}
                        </div>
                    </nav>
                </div>
            </div><!--heading-->
        </div><!--container-fluid-->
        <div id="main" class="container">
            {$template.body}
            <div class="clearfix"></div>
        </div><!--container-fluid-->
        <footer class="container">
            <div id="sitemap" class="row hidden-xs">
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
            <div class="row">
                <div id="copyright" class="text-center">
                    {_sprintf('® Derechos reservados. 2009 - %d. Dirección General de Bibliotecas, Universidad Nacional Autónoma de México (UNAM). Esta página y sus contenidos pueden ser utilizados y reproducidos con fines no lucrativos, siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica. De otra forma, requiere permiso previo por escrito de la institución.', date('Y'))} <a href="{site_url('creditos')}">{_('CRÉDITOS')}</a>
                </div>
            </div>
        </div><!--sitemap-->
        </footer>
        <script src="{base_url('assets/js/jquery.js')}"></script>
        <script src="{base_url('assets/js/bootstrap.min.js')}"></script>
        <script src="{base_url('js/jquery-ui.min.js')}"></script>
        <script src="{base_url('js/jquery.autosize.min.js')}"></script>
        <script src="{base_url('js/jquery.validate.min.js')}"></script>
        <script src="{base_url('js/pnotify/jquery.pnotify.min.js')}"></script>
        <script src="{base_url('js/select2/select2.js')}"></script>
        <script src="{base_url('js/advancedsearch/js/evol.advancedSearch.min.js')}"></script>
{foreach $template.js file}
        <script src="{$file}"></script>
{/foreach}
        <script>
            {$template.partials.biblat_js}
        </script>
    </body>
</html>