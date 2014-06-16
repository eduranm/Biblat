    <div id="mainSlider">
        <div class="anythingSlider anythingSlider-scielo activeSlider" style="height: 300px; width: 900px;">
            <div class="anythingWindow" style="width: 900px; height: 300px;">
                <ul type="none">

                </ul>
            </div>
        </div>
    </div>
    <div id="mainSearchContainer">
        <form action="<?=site_url('buscar');?>" class="searchform" method="post">
            <button id="options" class="icon-<?=(empty($filtro)? 'todos':$filtro);?>"></button>
            <ul class="optionsMenu">
                <li rel="todos"><i class="fa fa-cloud"></i><?php _e('Buscar en todos los campos');?></li>
                <li rel="palabra-clave"><i class="fa fa fa-key"></i><?php _e('Buscar por palabra clave');?></li>
                <li rel="autor"><i class="fa fa-user"></i><?php _e('Buscar por autor');?></li>
                <li rel="revista"><i class="fa fa-book"></i><?php _e('Buscar por revista');?></li>
                <li rel="institucion"><i class="fa fa fa-building-o"></i><?php _e('Buscar por institución');?></li>
                <li rel="articulo"><i class="fa fa-file-text-o"></i><?php _e('Buscar por artículo');?></li>
                <li rel="avanzada"><i class="fa fa-search-plus"></i><?php _e('Búsqueda avanzada');?></li>
            </ul>
            <button class="icon-search" type="submit"><span class="visuallyhidden">buscar</span></button>
            <input type="hidden" name="disciplina" value=""/>
            <input type="hidden" name="filtro" id="filtro" value="todos"/>
            <div id="advsearch"></div>
            <label>
                <span class="visuallyhidden"><?php _e('Buscar en Biblat');?></span>
    <?php if (isset($search['slug'])) :?>
                <textarea autocomplete="off" placeholder="<?php _e('Buscar en Biblat');?>" name="slug" id="slug"><?=$search['slug'];?></textarea>
    <?php else:?>
                <textarea autocomplete="off" placeholder="<?php _e('Buscar en Biblat');?>" value="" name="slug" id="slug"></textarea>
    <?php endif;?>
            </label>
        </form>
    </div><!--end main search container-->

	<div id="content_izq">
        <div id="titulo_index">
            <p><?php _e('REVISTAS POR DISCIPLINA');?></p>
        </div>
        <div class="tagCloud"></div><br>
        <div id="titulo_index">
        	<p><?php _e('REVISTA POR ORDEN ALFABÉTICO');?></p>
        </div>
        <div id="alfabetico">
			<p>
<?php foreach (range('A', 'Z') as $i):?>
				<a class="abc" href="<?=site_url("indice/alfabetico/".strtolower($i));?>"><?=$i;?></a>
<?php endforeach;?>
			</p>
        </div>

        <div id="titulo_index">
            <p><?php _e('FRECUENCIAS (CLASE y PERIÓDICA)');?></p>
        </div>
        
        <div id="frecuencia">
            <div id="news-left" class="demo">
                <div role="tablist" class="new left ui-accordion ui-widget ui-helper-reset" id="accordion">
                    <div class="body" style="float: none; position: estatic;">
                        <h3 tabindex="0" aria-expanded="true" aria-selected="false" aria-controls="ui-accordion-accordion-panel-0" id="ui-accordion-accordion-header-0" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><?php _e('Por autor');?></h3>
                        <div aria-hidden="true" role="tabpanel" aria-labelledby="ui-accordion-accordion-header-0" id="ui-accordion-accordion-panel-0" style="display: none; height: 91px;" class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                            <a href="<?=site_url("frecuencias/autor");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por autor');?></a>
                        </div>
                    </div>

                    <div class="body" style="float: none; position: estatic;">
                        <h3 tabindex="-1" aria-expanded="false" aria-selected="false" aria-controls="ui-accordion-accordion-panel-1" id="ui-accordion-accordion-header-1" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><?php _e('Por institución de afiliación del autor');?></h3>
                        <div aria-hidden="true" role="tabpanel" aria-labelledby="ui-accordion-accordion-header-1" id="ui-accordion-accordion-panel-1" style="display: none; height: 91px;" class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                            <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución');?></a><br>
                            <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución según el país de la revista');?></a><br>
                            <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución según la revista de publicación');?></a><br>
                            <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por autor según su institución de afiliación');?></a><br>
                            <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina según la institución');?></a>
                        </div>
                    </div>

                    <div class="body" style="float: none; position: estatic;">
                        <h3 tabindex="-1" aria-expanded="false" aria-selected="false" aria-controls="ui-accordion-accordion-panel-2" id="ui-accordion-accordion-header-2" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><?php _e('Por país de institución de afiliación del autor');?></h3>
                        <div aria-hidden="true" role="tabpanel" aria-labelledby="ui-accordion-accordion-header-2" id="ui-accordion-accordion-panel-2" style="display: none; height: 91px;" class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                            <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por país de la institución de afiliación del autor');?></a><br>
                            <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos por institución de afiliación por país');?></a><br>
                            <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos por autor según país de institución de afiliación');?></a><br>                    
                            <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos por disciplina según país de la institución del autor');?></a>
                        </div>
                    </div>

                    <div class="body" style="float: none; position: estatic;">
                        <h3 tabindex="-1" aria-expanded="false" aria-selected="false" aria-controls="ui-accordion-accordion-panel-3" id="ui-accordion-accordion-header-3" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><?php _e('Por disciplina');?></h3>                      
                        <div aria-hidden="true" role="tabpanel" aria-labelledby="ui-accordion-accordion-header-3" id="ui-accordion-accordion-panel-3" style="display: none; height: 91px;" class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                            <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina');?></a><br>
                            <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina y revista');?></a><br>
                            <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina e institución de afiliación del autor');?></a><br>
                            <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina y país de la revista');?></a><br>
                            <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina y país de la institución de afiliación del autor');?></a>
                        </div> 
                    </div>

                    <div class="body" style="float: none; position: estatic;">
                        <h3 tabindex="-1" aria-expanded="false" aria-selected="false" aria-controls="ui-accordion-accordion-panel-4" id="ui-accordion-accordion-header-4" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><?php _e('Por revista');?></h3>
                        <div aria-hidden="true" role="tabpanel" aria-labelledby="ui-accordion-accordion-header-4" id="ui-accordion-accordion-panel-4" style="display: none; height: 91px;" class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                            <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por revista');?></a><br>
                            <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por autor y revista');?></a><br>
                            <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución de afiliación del autor en las revistas');?></a><br>
                            <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de artículos publicados por año');?></a>
                        </div>
                    </div>
                </div>     
           </div>
        </div><br>

        <div id="titulo_index">
            <p><?php _e('INDICADORES SCIELO');?></p>
        </div>

        <div id="s7" style="position: relative; overflow: hidden; width: 550px; height: 354px;">
            <div style="position: absolute; top: 0px; left: 550px; display: none; z-index: 2; opacity: 1; width: 520px; height: 324px;">
                <strong>1</strong><br><br>
                <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Indicadores bibliométricos anuales de las revistas de la red SciELO');?><br></a> 
                <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Número de revistas incluidas en las colecciones de la red SciELO');?><br></a>
                <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Número de artículos publicados por revistas SciELO');?><br></a>
                <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Número y tipo de documento publicados en las revistas de las colecciones SciELO');?><br></a>
                <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Número de artículos incluidos en las colecciones SciELO por área del conocimiento');?><br></a>
                <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Número de artículos incluidos por área del conocimiento en las colecciones SciELO');?><br></a>
                <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Número de artículos incluidos en la red SciELO según país de la afiliación del autor');?><br></a>
                <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Número de artículos publicados por revistas SciELO según el país de la afiliación del autor');?><br></a>
                <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Número de artículos publicados por revistas SciELO según el país de publicación de la revista y país de la afiliación del autor');?><br></a>
                <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Número de artículos publicados por revistas SciELO según área del conocimiento y país de la afiliación del autor');?><br></a>
            </div>

            <div style="position: absolute; top: 0px; left: 0px; display: block; z-index: 3; opacity: 1; width: 520px; height: 324px;">
                <strong>2</strong><br><br>
                <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Número de citas recibidas por revista SciELO según área del conocimiento de la revista citante');?><br></a>
                <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Número de citas recibidas por revista SciELO según país de la afiliación del autor citante');?><br></a>
                <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Número de artículos citados según la edad de citación en artículos incluidos en todas las colecciones SciELO');?><br></a>
                <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Número de artículos citados según la edad de citación por título de revista');?><br></a>
                <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Número de artículos citados según la edad de citación por área del conocimiento de las revistas citantes');?><br></a>
                <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Número de artículos citados según la edad de citación por país de la afiliación del autor citante');?><br></a>
                <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Tipo de documento citado por los artículos incluidos en todas las colecciones SciELO');?><br></a>
                <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Tipo de documento citado por revista citante');?><br></a>
                <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Tipo de documento citado por área del conocimiento de la revista citante');?><br></a>
                <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Tipo de documento citado por país de la afiliación del autor citante');?><br></a>
            </div>
        </div>
        <div class="nav">
            <a id="prev2" href="javascript:;"><img src="<?=base_url('/img/bt_menos.jpg');?>" alt="atrás" border="0" height="17" width="18"></a> <a id="next2" href="javascript:;"><img src="<?=base_url('/img/bt_mas.jpg');?>" alt="mas" align="right" border="0" height="17" width="18"></a>
        </div>
	</div><!--end content_izq-->

	<div id="content_der">
		<div id="titulo_index">
            <p><?php _e('UN POCO DE NOSOTROS');?></p>
        </div>
        <div id="info_index">
            <p><?php _printf('%s es un portal especializado en revistas científicas y académicas publicadas en América Latina y el Caribe, que ofrece los siguientes servicios:','<span class="biblat"><acronym title="'._sprintf('Bibliografía Latinoamericana').'">Biblat</acronym></span>');?></p>
            <ul>
                <li><?php _printf('Referencias bibliográficas y texto completo de los artículos y documentos publicados en más de 3,000 revistas indizadas en %s y %s.','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>');?></li>
            </ul>
            <ul>
                <li><?php _printf('Visualización gráfica de indicadores extraídos de %s , %s, %s y de otras bases de datos.','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>','<a href="http://www.scielo.org" target="_blank"><acronym title="Scientific Electronic Library Online">SciELO</acronym></a>');?></li>
            </ul>
            <ul>
                <li><?php _printf('Información sobre las %s de las revistas indizadas en %s , %s.','<a href="javascript:;">Políticas de acceso abierto</a>','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>');?></li>
            </ul> 

            <p></p>
            <p align="right"><a class="leer_mas" href="<?=site_url('sobre-biblat');?>"><?php _e('Leer más');?><img src="<?=base_url('img/bt_mas.jpg');?>" alt="<?php _e('leer más');?>" height="17" width="18"> </a></p>
        </div>

        <div id="titulo_index">
            <p><?php _e('REVISTAS POR PAÍS');?></p>
        </div>
        <div id="sliderPais">
        </div>

        <div id="titulo_index">
            <p><?php _e('INDICADORES BIBLIOMÉTRICOS');?></p>
        </div>
        <div id="bibliometrico"><br>
            <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Índice de coautoría');?></a><br>
            <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Tasa de documentos coautorados');?></a><br>
            <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Grado de colaboración (Índice de Subramanyan)');?></a><br>
            <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Índice de colaboración (Índice de Lawani)');?></a><br>
            <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Modelo de Elitismo (Price)');?></a><br>
            <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Índice de densidad de documentos de Zakutina y Priyenikova');?></a><br>
            <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Índice de concentración temática (Pratt)');?></a><br>
            <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Modelo de Bradford por revista');?></a><br>
            <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Modelo de Bradford (Productividad institucional)');?></a><br>
            <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Productividad exógena por título de revista');?></a><br>
            <a href="javascript:;" class="indiA"><span class="amarillo">•</span> <?php _e('Regionalización de la producción institucional');?></a><br>
            <a href="javascript:;" class="indiB"><span class="amarillo">•</span> <?php _e('Coautoría según país de la institución de afiliación del autor');?></a><br><br>
        </div>
            
        <div id="titulo_index">
            <p><?php _e('OTROS INDICADORES');?></p>
        </div>
        <img src="<?=base_url('/img/indicadores.jpg');?>" usemap="#Map" height="299" width="416">
            <map name="Map">
                <area shape="rect" coords="12,3,137,305" href="javascript:;">
                <area shape="rect" coords="143,3,273,296" href="javascript:;">
                <area shape="rect" coords="282,2,407,298" href="javascript:;">
            </map>
        <br class="cf">
	</div><!--end content_der-->
