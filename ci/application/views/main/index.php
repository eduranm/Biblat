<div id="mainSlider">
    <ul id="bxsliderMain">
        <li id="slide-totales">
            <a href="javascript:;">
                <img src="<?=base_url('img/slides/banners_01.jpg');?>"/>
                <div class="vertical-text" id="total-hevila"><?php echo _sprintf('%s textos completos en HEVILA', number_format($totales['hevila'], 0, '.', ','));?></div>
                <div class="vertical-text" id="total-enlaces"><?php echo _sprintf('%s textos completos', number_format($totales['enlaces'], 0, '.', ','));?></div>
                <div class="vertical-text" id="total-documentos"><?php echo _sprintf('%s documentos', number_format($totales['documentos'], 0, '.', ','));?></div>
                <div class="vertical-text" id="total-revistas"><?php echo _sprintf('%s revistas', number_format($totales['revistas'], 0, '.', ','));?></div>
            </a>
        </li>
        <li><a href="javascript:;"><img src="<?=base_url('img/slides/banners_02.jpg');?>"/></a></li>
        <li><a href="<?php echo site_url('indicadores');?>"><img src="<?=base_url('img/slides/banners_03.jpg');?>"/></a></li>
        <li><a href="<?php echo site_url('frecuencias');?>"><img src="<?=base_url('img/slides/banners_04.jpg');?>"/></a></li>
    </ul>
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
            <div id="accordion">
                <h3><?php _e('Por autor');?></h3>
                <div>
                    <a href="<?=site_url("frecuencias/autor");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por autor');?></a>
                </div>
                <h3><?php _e('Por institución de afiliación del autor');?></h3>
                <div>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución');?></a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución según el país de la revista');?></a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución según la revista de publicación');?></a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por autor según su institución de afiliación');?></a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina según la institución');?></a>
                </div>
                
                <h3><?php _e('Por país de institución de afiliación del autor');?></h3>
                <div>
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por país de la institución de afiliación del autor');?></a><br>
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos por institución de afiliación por país');?></a><br>
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos por autor según país de institución de afiliación');?></a><br>                    
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos por disciplina según país de la institución del autor');?></a>
                </div>

                <h3><?php _e('Por disciplina');?></h3>                      
                <div>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina');?></a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina y revista');?></a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina e institución de afiliación del autor');?></a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina y país de la revista');?></a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina y país de la institución de afiliación del autor');?></a>
                </div> 

                <h3><?php _e('Por revista');?></h3>
                <div>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por revista');?></a><br>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por autor y revista');?></a><br>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución de afiliación del autor en las revistas');?></a><br>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de artículos publicados por año');?></a>
                </div>
            </div>     
        </div>
    </div><br>

    <div id="titulo_index">
        <p><?php _e('INDICADORES SCIELO');?></p>
    </div>

    <ul id="bxsliderIndicadores">
        <div>
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

        <div>
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
    </ul>
</div><!--end content_izq-->

<div id="content_der">
	<div id="titulo_index">
        <p><?php _e('UN POCO DE NOSOTROS');?></p>
    </div>
    <div id="info_index">
        <p><?php _printf('%s es un portal especializado en revistas científicas y académicas publicadas en América Latina y el Caribe, que ofrece los siguientes servicios:','<span class="biblat"><acronym title="'._sprintf('Bibliografía Latinoamericana').'">Biblat</acronym></span>');?></p>
        <ul>
            <li><?php _printf('Referencias bibliográficas y texto completo de los artículos y documentos publicados en más de 3,000 revistas indizadas en %s y %s.','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>');?></li><br/>
            <li><?php _printf('Visualización gráfica de indicadores extraídos de %s, %s, %s y de otras bases de datos.','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>','<a href="http://www.scielo.org" target="_blank"><acronym title="Scientific Electronic Library Online">SciELO</acronym></a>');?></li><br/>
            <li><?php _printf('Información sobre las %s de las revistas indizadas en %s , %s.','<a href="javascript:;">Políticas de acceso abierto</a>','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>');?></li>
        </ul> 

        <p></p>
        <p align="right"><a class="leer_mas" href="<?=site_url('sobre-biblat');?>"><?php _e('Leer más');?><img src="<?=base_url('img/bt_mas.jpg');?>" alt="<?php _e('leer más');?>" height="17" width="18"> </a></p>
    </div>

    <div id="titulo_index">
        <p><?php _e('REVISTAS POR PAÍS');?></p>
    </div>
    <div id="sliderPais">
        <ul id="bxsliderPais">
            <li><a href="<?=site_url("indice/pais/internacional");?>"><img src="<?=base_url('img/america.jpg');?>" title="<?php _e('Internacional');?>"></a></li>
<?php foreach ($paises as $pais):?>
            <li><a href="<?=site_url("indice/pais/{$pais['paisSlug']}");?>"><img src="<?=base_url("img/{$pais['paisSlug']}.jpg");?>" title="<?=$pais['pais'];?>"></a></li>
<?php endforeach;?>
        </ul>
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