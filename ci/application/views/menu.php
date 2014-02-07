<?php
$langs['es'] = array(
						'url' => site_url($this->lang->switch_uri('es')),
						'title' => "Español",
						'img' => "spanish.png"
					);
$langs['en'] = array(
						'url' => site_url($this->lang->switch_uri('en')),
						'title' => "English",
						'img' => "english.png"
					);
$langs['pt'] = array(
						'url' => site_url($this->lang->switch_uri('pt')),
						'title' => "Português",
						'img' => "portuguese.png"
					);
$langs['fr'] = array(
						'url' => site_url($this->lang->switch_uri('fr')),
						'title' => "Français",
						'img' => "french.png"
					);
$langs['ca'] = array(
						'url' => site_url($this->lang->switch_uri('ca')),
						'title' => "Catalan",
						'img' => "catalan.png"
					);
$defaultLang = $this->lang->lang();
?>
	<div id="header">
		<div class="bannerLeft"></div>
		<div class="bannerRight"></div>
		<div class="banner">
			<div class="bannerLinks">
				<a class="biblatLink" href="<?=site_url('/');?>" title="Biblat"></a>
				<a class="unamLink" href="http://www.unam.mx" target="_blank" title="UNAM"></a>
				<a class="dgbLink" href="http://dgb.unam.mx" target="_blank" title="DGB"></a>
			</div>
		</div>
	</div>
	<div class="menuContainer">
		<div class="menu">
			<ul>
				<li>
					<a href="javascript:;" title="<?php _e('¿Qué es Biblat?');?>"><?php _e('¿Qué es Biblat?');?></a>
					<ul>
						<li><a href="javascript:;" title="<?php _e('Biblat');?>"><?php _e('Biblat');?></a></li>
						<li><a href="javascript:;" title="<?php _e('Clase y Periódica');?>"><?php _e('Clase y Periódica');?></a></li>
						<li><a href="javascript:;" title="<?php _e('Tutoriales');?>"><?php _e('Tutoriales');?></a></li>
						<li><a href="javascript:;" title="<?php _e('Materiales de difusión');?>"><?php _e('Materiales de difusión');?></a></li>
						<li><a href="javascript:;" title="<?php _e('Manual de indización');?>"><?php _e('Manual de indización');?></a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;" title="<?php _e('Bibliometría');?>"><?php _e('Bibliometría');?></a>
					<ul>
						<li><a href="javascript:;" title="<?php _e('Descripción');?>"><?php _e('Descripción');?></a></li>
						<li><a href="javascript:;" title="<?php _e('Metodología');?>"><?php _e('Metodología');?></a></li>
						<li>
							<a href="javascript:;" title="<?php _e('Frecuencias');?>"><?php _e('Frecuencias');?></a>
							<ul>
								<li><a href="<?=site_url('frecuencias/autor');?>" title="<?php _e('Autor');?>"><?php _e('Autor');?></a></li>
								<li><a href="<?=site_url('frecuencias/institucion');?>" title="<?php _e('Institución');?>"><?php _e('Institución');?></a></li>
								<li><a href="<?=site_url('frecuencias/pais-afiliacion');?>" title="<?php _e('País de afiliación del autor');?>"><?php _e('País de afiliación');?></a></li>
								<li><a href="<?=site_url('frecuencias/revista');?>" title="<?php _e('Revista');?>"><?php _e('Revista');?></a></li>
							</ul>
						</li>
						<li>
							<a href="<?=site_url('indicadores');?>" title="<?php _e('Indicadores');?>"><?php _e('Indicadores');?></a>
							<ul>
								<li><a href="<?=site_url('indicadores/indice-coautoria');?>" title="<?php _e('Índice de coautoría');?>"><?php _e('Índice de coautoría');?></a></li>
								<li><a href="<?=site_url('indicadores/tasa-documentos-coautorados');?>" title="<?php _e('Tasa de documentos coautorados');?>"><?php _e('Tasa de documentos coautorados');?></a></li>
								<li><a href="<?=site_url('indicadores/grado-colaboracion');?>" title="<?php _e('Grado de colaboración (Índice Subramayan)');?>"><?php _e('Grado de colaboración');?></a></li>
								<li><a href="<?=site_url('indicadores/modelo-elitismo');?>" title="<?php _e('Modelo de elitismo (Price)');?>"><?php _e('Modelo de elitismo');?></a></li>
								<li><a href="<?=site_url('indicadores/indice-colaboracion');?>" title="<?php _e('Índice de colaboración (Índice de Lawani)');?>"><?php _e('Índice de colaboración');?></a></li>
								<li><a href="<?=site_url('indicadores/indice-densidad-documentos');?>" title="<?php _e('Índice de densidad de documentos Zakutina y Priyenikova');?>"><?php _e('Índice de densidad de documentos');?></a></li>
								<li><a href="<?=site_url('indicadores/indice-concentracion');?>" title="<?php _e('Índice de concentración (Índice Pratt)');?>"><?php _e('Índice de concentración');?></a></li>
								<li><a href="<?=site_url('indicadores/modelo-bradford-revista');?>" title="<?php _e('Modelo de Bradford por revista');?>"><?php _e('Modelo de Bradford por revista');?></a></li>
								<li><a href="<?=site_url('indicadores/modelo-bradford-institucion');?>" title="<?php _e('Modelo de Bradford por institución (Afiliación del autor)');?>"><?php _e('Modelo de Bradford por institución');?></a></li>
								<li><a href="<?=site_url('indicadores/productividad-exogena');?>" title="<?php _e('Tasa de autoría exógena');?>"><?php _e('Tasa de autoría exógena');?></a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;" title="<?php _e('Postular una revista');?>"><?php _e('Postular una revista');?></a>
					<ul>
						<li><a href="javascript:;" title="<?php _e('Criterios de selección de revistas');?>"><?php _e('Criterios de selección de revistas');?></a></li>
						<li><a href="javascript:;" title="<?php _e('Contacto');?>"><?php _e('Contacto');?></a></li>
					</ul>
				</li>
				<li><a href="javascript:;" title="<?php _e('Políticas de acceso');?>"><?php _e('Políticas de acceso');?></a></li>
				<li>
					<a href="javascript:;" title="<?php _e('Documentos');?>"><?php _e('Documentos');?></a>
					<ul>
						<li><a href="<?=site_url('documentos/bibliografia');?>" title="<?php _e('Bibliografía');?>"><?php _e('Bibliografía');?></a></li>
						<li><a href="javascript:;" title="<?php _e('Presentaciones PPT');?>"><?php _e('Presentaciones PPT');?></a></li>
						<li><a href="javascript:;" title="<?php _e('Archivos multimedia');?>"><?php _e('Archivos multimedia');?></a></li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="menu menuRight">
			<ul>
				<li>
					<div class="addthis_toolbox addthis_default_style">
						<a class="addthis_button_facebook" style="cursor:pointer"></a>
						<a class="addthis_button_twitter" style="cursor:pointer"></a>
						<a class="addthis_button_compact"></a>
					</div>
				</li>
				<li>
					<a href="<?=site_url('sitemap');?>" title="<?php _e('Mapa del sitio');?>"><img border="0" src="<?=base_url();?>img/sitemap.png" height="16px" alt="<?php _e('Mapa del sitio');?>"/></a>
				</li>
				<li>
					<a href="javascript:;" title="<?php _e('Ayuda');?>"><img border="0"  src="<?=base_url();?>img/help.png" height="16px" alt="<?php _e('Ayuda');?>"/></a>
				</li>
				<li>
					<a href="javascript:;" title="<?php _e('Contacto');?>"><img border="0"  src="<?=base_url();?>img/mail.png" height="16px" alt="<?php _e('Contacto');?>"/></a>
				</li>
				<li>
					<img src="<?=base_url();?>img/<?=$langs[$defaultLang]['img'];?>" border="0"  height="16px" alt="<?=$langs[$defaultLang]['title'];?>"/>
					<ul>
<?php foreach ($langs as $langKey => $lang):
		if ($langKey != $defaultLang):?>
						<li><a class="setlang" href="<?=$lang['url'];?>" title="<?=$lang['title'];?>"><img border="0"  src="<?=base_url();?>img/<?=$lang['img'];?>" height="16px" alt="<?=$lang['title'];?>"/></a></li>
<?php 	endif;
	  endforeach;?>
	  				</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="searchContainer">
		<form action="<?=site_url('buscar');?>" class="searchform" method="post">
			<button id="options" class="icon-<?=(empty($filtro)? 'todos':$filtro);?>"></button>
			<ul class="optionsMenu">
				<li rel="todos"><i class="fa fa-cloud"></i><?php _e('Buscar en todos los campos');?></li>
				<li rel="palabra-clave"><i class="fa fa fa-key"></i><?php _e('Buscar por palabra clave');?></li>
				<li rel="autor"><i class="fa fa-user"></i><?php _e('Buscar por autor');?></li>
				<li rel="revista"><i class="fa fa-book"></i><?php _e('Buscar por revista');?></li>
				<li rel="institucion"><i class="fa fa fa-building-o"></i><?php _e('Buscar por institucion');?></li>
				<li rel="articulo"><i class="fa fa-file-text-o"></i><?php _e('Buscar por articulo');?></li>
				<li rel="avanzada"><i class="fa fa-search-plus"></i><?php _e('Búsqueda avanzada');?></li>
			</ul>
			<button class="icon-search" type="submit"><span class="visuallyhidden">buscar</span></button>
			<input type="hidden" name="disciplina" value=""/>
			<input type="hidden" name="filtro" id="filtro" value="todos"/>
			<label>
				<span class="visuallyhidden"><?php _e('Buscar en Biblat');?></span>
<?php if (isset($search['slug'])) :?>
				<textarea autocomplete="off" placeholder="<?php _e('Buscar en Biblat');?>" name="slug" id="slug"><?=$search['slug'];?></textarea>
<?php else:?>
				<textarea autocomplete="off" placeholder="<?php _e('Buscar en Biblat');?>" value="" name="slug" id="slug"></textarea>
<?php endif;?>
			</label>
		</form>
	</div>
