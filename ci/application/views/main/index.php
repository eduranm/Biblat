<div id="carousel-biblat" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-biblat" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-biblat" data-slide-to="1"></li>
    <li data-target="#carousel-biblat" data-slide-to="2"></li>
    <li data-target="#carousel-biblat" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <svg class="img-responsive center-block" version="1.1" id="banners_01" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 235.2 69.6" enable-background="new 0 0 235.2 69.6" xml:space="preserve" width="980" height="290">
        <image overflow="visible" width="980" height="290" xlink:href="{base_url('img/slides/banners_01.jpg')}"  transform="matrix(0.24 0 0 0.24 0 0)"></image>
        <text transform="matrix(4.489659e-11 -1 1 4.489659e-11 138.3335 63.3335)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="3.7">{_sprintf('%s textos completos en HEVILA', number_format($totales['hevila'], 0, '.', ','))}</text>
        <text transform="matrix(4.489659e-11 -1 1 4.489659e-11 148.8335 63.3335)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="3.6">{_sprintf('%s textos completos', number_format($totales['enlaces'], 0, '.', ','))}</text>
        <text transform="matrix(4.489659e-11 -1 1 4.489659e-11 159.557 63.3335)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="3.6">{_sprintf('%s documentos', number_format($totales['documentos'], 0, '.', ','))}</text>
        <text transform="matrix(4.489659e-11 -1 1 4.489659e-11 170.3335 63.3335)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="3.6">{_sprintf('%s revistas', number_format($totales['revistas'], 0, '.', ','))}</text>
    </svg>
    </div>
    <div class="item">
      <img class="img-responsive center-block" src="{base_url('img/slides/banners_02.jpg')}"/>
    </div>
    <div class="item">
      <a href="{site_url('indicadores')}"><img class="img-responsive center-block" src="{base_url('img/slides/banners_03.jpg')}"/></a>
    </div>
    <div class="item">
      <a href="{site_url('frecuencias')}"><img class="img-responsive center-block" src="{base_url('img/slides/banners_04.jpg')}"/></a>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-biblat" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-biblat" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div><!-- carousel-biblat -->

<div class="row" id="main-search">
    <div class="col-md-8 col-md-offset-2">{$template.partials.search}</div>
</div>
<div class="row" id="main-sections">
    <div class="col-md-6">
        <h3>{_('UN POCO DE NOSOTROS')}</h3>
        <p>{$biblat=_sprintf('Bibliografía Latinoamericana') _sprintf('%s es un portal especializado en revistas científicas y académicas publicadas en América Latina y el Caribe, que ofrece los siguientes servicios:','<span class="biblat"><acronym title="$biblat">Biblat</acronym></span>')}</p>
        <ul>
            <li>{$clase=_sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades') $periodica=_sprintf('Índice de Revistas Latinoamericanas en Ciencias') _sprintf('Referencias bibliográficas y texto completo de los artículos y documentos publicados en más de 3,000 revistas indizadas en %s y %s.','<a href="http://clase.unam.mx" target="_blank"><acronym title="$clase">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="$periodica">PERIÓDICA</acronym></a>')}</li><br/>
            <li>{_sprintf('Visualización gráfica de indicadores extraídos de %s, %s, %s y de otras bases de datos.','<a href="http://clase.unam.mx" target="_blank"><acronym title="$clase">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="$periodica">PERIÓDICA</acronym></a>','<a href="http://www.scielo.org" target="_blank"><acronym title="Scientific Electronic Library Online">SciELO</acronym></a>')}</li><br/>
            <li>{_sprintf('Información sobre las %s de las revistas indizadas en %s , %s.','<a href="javascript:;">Políticas de acceso abierto</a>','<a href="http://clase.unam.mx" target="_blank"><acronym title="$clase">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="$periodica">PERIÓDICA</acronym></a>')}</li>
        </ul> 

        <p></p>
        <p class="text-right"><a class="leer_mas" href="{site_url('sobre-biblat')}">{_('Leer más')} <i class="fa fa-angle-double-right"></i></a></p>
    </div><!-- Un poco de nosotros -->
    <div class="col-md-6">
        <h3>{_('REVISTAS POR DISCIPLINA')}</h3>
        <div class="tagCloud"></div>
    </div><!-- Revistas por disciplina -->
    <div class="clearfix hidden-sm"></div>
    <div class="col-md-6">
        <h3>{_('REVISTA POR ORDEN ALFABÉTICO')}</h3>
        <div id="alfabetico">
            <p></p>
            <p class="text-center">
{foreach range('A', 'Z') i}
                <a class="abc" href="{$il=lower($i) site_url('indice/alfabetico/$il')}">{$i}</a>
{/foreach}
            </p>
            <p></p>
        </div>
    </div><!-- Revistas por ordern alfabético -->
    <div class="col-md-6">
        <h3>{_('REVISTAS POR PAÍS')}</h3>

        <div id="carousel-pais" class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active">
                <a href="{site_url("indice/pais/internacional")}"><img class="img-responsive center-block" src="{base_url('img/america.jpg')}" title="{_('Internacional')}"></a>
                <div class="carousel-caption">{_('Internacional')}</div>
            </div>
{foreach $paises pais}
                <div class="item">
                    <a href="{site_url("indice/pais/$pais.paisRevistaSlug")}"><img class="img-responsive center-block" src="{base_url("img/$pais.paisRevistaSlug")}.jpg" title="{$pais.paisRevista}"></a>
                    <div class="carousel-caption">{$pais.paisRevista}</div>
                </div>
{/foreach}
          </div>

          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-pais" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-pais" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
    </div><!-- Revistas por país -->
    <div class="clearfix hidden-sm"></div>
    <div class="col-md-6">
        <h3>{_('FRECUENCIAS (CLASE y PERIÓDICA)')}</h3>
        {$template.partials.frecuencias_accordion} 
    </div><!-- Frecuencias CLAPER -->
    <div class="col-md-6">
        <h3>{_('INDICADORES BIBLIOMÉTRICOS')}</h3>
        <ul class="orange-list list-striped">
            <li><a href="{site_url('indicadores/indice-coautoria')}">{_('Índice de coautoría')}</a></li>
            <li><a href="{site_url('indicadores/tasa-documentos-coautorados')}">{_('Tasa de documentos coautorados')}</a></li>
            <li><a href="{site_url('indicadores/grado-colaboracion')}">{_('Grado de colaboración (Índice de Subramanyan)')}</a></li>
            <li><a href="{site_url('indicadores/indice-colaboracion')}">{_('Índice de colaboración (Índice de Lawani)')}</a></li>
            <li><a href="{site_url('indicadores/modelo-elitismo')}">{_('Modelo de Elitismo (Price)')}</a></li>
            <li><a href="{site_url('indicadores/indice-densidad-documentos')}">{_('Índice de densidad de documentos de Zakutina y Priyenikova')}</a></li>
            <li><a href="{site_url('indicadores/indice-concentracion')}">{_('Índice de concentración temática (Pratt)')}</a></li>
            <li><a href="{site_url('indicadores/modelo-bradford-revista')}">{_('Modelo de Bradford por revista')}</a></li>
            <li><a href="{site_url('indicadores/modelo-bradford-institucion')}">{_('Modelo de Bradford (Productividad institucional)')}</a></li>
            <li><a href="{site_url('indicadores/productividad-exogena')}">{_('Productividad exógena por título de revista')}</a></li>
            <li><a href="javascript:;">{_('Regionalización de la producción institucional')}</a></li>
            <li><a href="javascript:;">{_('Coautoría según país de la institución de afiliación del autor')}</a></li>
        </ul>
    </div><!-- Indicadores bibliometricos -->
    <div class="clearfix"></div>
    <div class="col-md-6">
        <h3>{_('INDICADORES SCIELO')}</h3>
        <div id="carousel-scielo" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#carousel-scielo" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-scielo" data-slide-to="1"></li>
          </ol>
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active">
                <ul class="orange-list list-striped">
                    <li><a href="javascript:;">{_('Indicadores bibliométricos anuales de las revistas de la red SciELO')}</a> </li>
                    <li><a href="javascript:;">{_('Número de revistas incluidas en las colecciones de la red SciELO')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos publicados por revistas SciELO')}</a></li>
                    <li><a href="javascript:;">{_('Número y tipo de documento publicados en las revistas de las colecciones SciELO')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos incluidos en las colecciones SciELO por área del conocimiento')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos incluidos por área del conocimiento en las colecciones SciELO')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos incluidos en la red SciELO según país de la afiliación del autor')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos publicados por revistas SciELO según el país de la afiliación del autor')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos publicados por revistas SciELO según el país de publicación de la revista y país de la afiliación del autor')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos publicados por revistas SciELO según área del conocimiento y país de la afiliación del autor')}</a></li>
                </ul>
            </div>
            <div class="item">
                <ul class="orange-list list-striped">
                    <li><a href="javascript:;">{_('Número de citas recibidas por revista SciELO según área del conocimiento de la revista citante')}</a></li>
                    <li><a href="javascript:;">{_('Número de citas recibidas por revista SciELO según país de la afiliación del autor citante')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos citados según la edad de citación en artículos incluidos en todas las colecciones SciELO')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos citados según la edad de citación por título de revista')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos citados según la edad de citación por área del conocimiento de las revistas citantes')}</a></li>
                    <li><a href="javascript:;">{_('Número de artículos citados según la edad de citación por país de la afiliación del autor citante')}</a></li>
                    <li><a href="javascript:;">{_('Tipo de documento citado por los artículos incluidos en todas las colecciones SciELO')}</a></li>
                    <li><a href="javascript:;">{_('Tipo de documento citado por revista citante')}</a></li>
                    <li><a href="javascript:;">{_('Tipo de documento citado por área del conocimiento de la revista citante')}</a></li>
                    <li><a href="javascript:;">{_('Tipo de documento citado por país de la afiliación del autor citante')}</a> </li>
                </ul>
            </div>
          </div>
        </div><!-- carousel-scielo -->
    </div><!-- Indicadore SciELO -->
    <div class="col-md-6">
        <h3>{_('OTROS INDICADORES')}</h3>
        <img class="img-responsive center-block" src="{base_url('/img/indicadores.jpg')}" usemap="#Map" height="299" width="416">
            <map name="Map">
                <area shape="rect" coords="12,3,137,305" href="{site_url('bibliometria/indicadores-por-revista')}">
                <area shape="rect" coords="143,3,273,296" href="{site_url('conacyt')}">
                <area shape="rect" coords="282,2,407,298" href="javascript:;">
            </map>
    </div><!-- Otros indicadores -->
    <p></p>
</div>
