<div id="content">
  <div id="encabezado">
    <div id="migas">
      <p><a href="<?=site_url('/');?>">Inicio</a> / <?php _e('Sobre Biblat');?> / <?php _e('CLASE y PERIÓDICA');?></p>
    </div><!--End migas-->
    <div id="share">
      <div id="share1">
        <span class="space"><a href="https://www.facebook.com/pages/BIBLAT/188958071154818" target="_blank">&#Xf09a;</a></span>
        <span class="space"><a href="https://twitter.com/Biblat" target="_blank">&#Xf099;</i></i></a></span>
        <span class="space"><a href="#" target="_blank">?</a></span>
        <span class="space"><a href="mailto:scielo@dgb.unam.mx"><i class="fa fa-envelope-o"></i></a></span>
        <div><a class="share" href="#">Español</a></div>
      </div>
      <div id="share2">
        <a href="#">A<sup>+</sup></a>
        <a href="#">A<sup>-</sup></a>
        <a href="javascript:window.print();"><i class="fa fa-print"></i></a>
      </div>
    </div><!--end share-->

    <div class="titulo_int">
      <h1><?php _e('CLASE y PERIÓDICA');?></h1>
    </div><!--end titulo_int-->
        
    <br class="cf">
  </div><!--end encabezado-->
      
  <div id="content_txt">
    <p><?php _printf('La principal fuente de información de %s son las bases de datos %s (Citas Latinoamericanas en Ciencias Sociales y Humanidades) y %s (Índice de Revistas Latinoamericanas en Ciencias), las cuales difunden registros de documentos contenidos en publicaciones periódicas y seriadas editadas en países y territorios de América Latina y el Caribe, así como aquellas de organismos internacionales ubicados dentro de la región que tienen una participación mayoritaria de países latinoamericanos.','<span class="biblat"><acronym title="'._sprintf('Bibliografía Latinoamericana').'">Biblat</acronym></span>','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>');?></p>

    <p><?php _printf('%s y %s se encuentran disponibles para consulta en línea en las siguientes direcciones:','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>');?></p>

    <div align="center">
      <a href="http://clase.unam.mx" target="_blank">http://clase.unam.mx</a><br></br>
      <a href="http://periodica.unam.mx" target="_blank">http://periodica.unam.mx</a><br></br>
    </div>

    <p><?php _printf('O bien, en el sitio web de la Dirección General de Bibliotecas (%s), seleccionar Catálogos y bajo el enunciado Revistas Latinoamericanas encontrará los enlaces correspondientes.','<a href="http://dgb.unam.mx" target="_blank">http://dgb.unam.mx</a>');?></p><br>
			

    <div class="cien">
      <div class="titulo_int">
        <h1><?php _e('Características');?></h1>
      </div><!--end titulo_int-->
      <br class="cf">
    </div>

    <p><a href="http://clase.unam.mx" target="_blank"><img style="float: left; padding-right: 10px;" src="<?=base_url('img/clase.gif');?>" width="83" height="55" /></a><?php _printf('%s es una base de datos bibliográfica creada en 1975 en la Universidad Nacional Autónoma de México (%s). Contiene registros bibliográficos de artículos, ensayos, reseñas de libro, revisiones bibliográficas, notas breves, editoriales, biografías, entrevistas, estadísticas y otros documentos publicados en más de 1,700 revistas publicadas en América Latina y el Caribe, especializadas en ciencias sociales y humanidades.','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://unam.mx/" target="_blank"><acronym title="'._sprintf('Universidad Nacional Autónoma de México').'">UNAM</acronym></a>');?></p>

    <p><?php _printf('Las revistas incluidas en %s cumplen con criterios de selección y son analizadas por un equipo multidisciplinario que cubre los siguientes temas:','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>');?></p>

    <ol>
<?php foreach ($disciplina[0] as $item):?>
		  <li><a href="<?php echo site_url('indice/disciplina/'.$item['slug']);?>"><?php echo $item['disciplina'];?></a></li>
<?php endforeach;?>
		</ol><br>

    <p><a href="http://periodica.unam.mx" target="_blank"><img style="float: left; padding-right: 10px;" src="<?=base_url('img/periodica.gif');?>" width="123" height="55" /></a><?php _printf('%s es una base de datos bibliográfica creada en 1978 en la Universidad Nacional Autónoma de México (%s). Contiene registros bibliográficos de artículos originales, informes técnicos, estudios de caso, estadísticas y otros documentos publicados en cerca de 1,500 revistas de América Latina y el Caribe, especializadas en ciencia y tecnología.','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>','<a href="http://www.unam.mx" target="_blank"><acronym title='._sprintf('Universidad Nacional Autónoma de México').'">UNAM</acronym></a>');?></p>

    <p><?php _printf('Las revistas incluidas en %s cumplen con criterios de selección y son analizadas por un equipo multidisciplinario que cubre los siguientes temas:','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>');?></p>

		<ol>
<?php foreach ($disciplina[1] as $item):?>
      <li><a href="<?php echo site_url('indice/disciplina/'.$item['slug']);?>"><?php echo $item['disciplina'];?></a></li>
<?php endforeach;?>
	  </ol><br>

		<p><?php _printf('Metodología de indización de %s y %s:','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>');?></a></p>

		<p><?php _printf('Para conocer la metodología que se utiliza para el análisis documental, normalización y asentamiento de la información en %s y %s, consulte el %s.','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>','<a href="http://bibliotecas.unam.mx/eventos/manual/index.html#" target="_blank">Manual de Indización</a>');?><a href="<?=base_url('files/manual_indizacion.pdf');?>" target="_blank"><img style="  padding-left: 5px;" src="<?=base_url('img/pdf.png');?>" width="16" height="16" /></a></p><br>
	

    <div class="cien">
      <div class="titulo_int">
        <h1><?php _e('Opciones de búsqueda en Biblat');?></h1>
      </div><!--end titulo_int-->
      <br class="cf">
    </div>

    <p><span class="biblat"><acronym title="<?php _e('Bibliografía Latinoamericana');?>">Biblat</acronym></span> <?php _printf('proporciona un acceso integrado de la información contenida en %s y %s, lo cual permite realizar búsquedas de información simultáneas tanto en el área de ciencias sociales y humanidades (%s) o en ciencias exactas y naturales (%s), o bien, realizar búsquedas restringidas por disciplina del conocimiento.','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>','<a href="http://clase.unam.mx" target="_blank"><acronym title="'._sprintf('Citas Latinoamericanas en Ciencias Sociales y Humanidades').'">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="'._sprintf('Índice de Revistas Latinoamericanas en Ciencias').'">PERIÓDICA</acronym></a>');?></p>
    <p><?php _e('Las opciones de búsqueda son:');?></p>

    <p><b><?php _e('Búsqueda básica:');?></b> <?php _e('utilizando un término de búsqueda dentro de alguno de los siguientes campos:');?><b> <?php _e('palabra clave');?></b> <?php _e('(término que describe más específicamente el contenido de cada documento, incluyendo nombres geográficos, de organizaciones, de personas y fechas relevantes mencionadas en el documento; sólo términos en español) de los documentos indizados (sólo búsquedas en español),');?><b> <?php _e('autor');?></b> <?php _e('(apellidos y nombres o iniciales de los autores del documento),');?><b> <?php _e('revista');?></b> <?php _e('(título de la revista),');?><b> <?php _e('título del documento');?></b> <?php _e('(título del artículo o documento) o nombre de la');?><b> <?php _e('institución');?></b> <?php _e('(institución de afiliación del autor); o bien, en todos estos campos.');?></p>

    p><b><?php _e('Búsqueda avanzada:');?></b> <?php _e('para realizar búsquedas combinando distintos campos y utilizando los operadores boléanos AND y OR.');?></p>

    <p><?php _printf('Algunos registros bibliográficos están enlazados a artículos en texto completo. %s ofrece dos tipos de acceso al texto completo: mediante enlaces hipertextuales a los sitios web de las revistas (recursos externos) y a través de la colección del acervo digital de la Hemeroteca Virtual Latinoamericana de la Dirección General de Bibliotecas (%s) %s. Todas las revistas se encuentran en la Hemeroteca Latinoamericana, a través de la cual se ofrece el servicio de obtención de documentos.','<span class="biblat"><acronym title="'._sprintf('Bibliografía Latinoamericana').'">Biblat</acronym></span>','<a href="http://dgb.unam.mx" target="_blank"><acronym title="'._sprintf('Dirección General de Bibliotecas').'">DGB</acronym></a>','<a href="http://www.unam.mx"><acronym title="'._sprintf('Universidad Nacional Autónoma de México').'">UNAM</acronym></a>');?></p>
  </div><!--end content_txt-->
</div><!--end content-->