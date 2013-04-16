	<div id="header">
		<div class="bannerLeft"></div>
		<div class="bannerRight"></div>
		<div class="banner"></div>
	</div>
	<div class="menuContainer">
		<div class="menu">
			<ul>
				<li><?php _e('¿Qué es Biblat?');?></li>
				<li>
					<?php _e('Bibliometría');?>
					<ul>
						<li><?php _e('Descripción');?></li>
						<li><?php _e('Metodología');?></li>
						<li><?php _e('Frecuencias');?></li>
						<li><?php _e('Indicadores');?></li>
					</ul>
				</li>
				<li><?php _e('Postular una revista');?></li>
				<li><?php _e('Políticas de copyright');?></li>
				<li><?php _e('Documentos');?></li>
			</ul>
		</div>
		<div class="menu menuRight">
			<ul>
				<li>
					<img src="<?php echo base_url();?>img/sitemap.png" height="16px" alt="Sitemap"/>
				</li>
				<li>
					<img src="<?php echo base_url();?>img/help.png" height="16px" alt="Sitemap"/>
				</li>
				<li>
					<img src="<?php echo base_url();?>img/mail.png" height="16px" alt="Sitemap"/>
				</li>
				<li>
					<img src="<?php echo base_url();?>img/spanish.png" height="16px" alt="Español"/>
					<ul>
						<li><a class="setlang" href="<?php echo site_url('setlang/en');?>" title="English"><img src="<?php echo base_url();?>img/english.png" height="16px" alt="English"/></a></li>
						<li><a class="setlang" href="<?php echo site_url('setlang/pt');?>" title="English"><img src="<?php echo base_url();?>img/portuguese.png" height="16px" alt="Português"/></a></li>
						<li><a class="setlang" href="<?php echo site_url('setlang/fr');?>" title="English"><img src="<?php echo base_url();?>img/french.png" height="16px" alt="Français"/></a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="searchContainer">
		<form action="<?php echo site_url('buscar');?>" class="searchform" method="post">
			<button class="icon-search" type="submit"><span class="visuallyhidden">buscar</span></button>
			<input type="hidden" name="disciplina" value=""/>
			<label>
				<span class="visuallyhidden">Buscar en Biblat</span>
<?php if (isset($search['slug'])) :?>
				<input type="text" placeholder="Buscar en Biblat" value="<?php echo $search['slug'];?>" name="slug">
<?php else:?>
				<input type="text" placeholder="Buscar en Biblat" value="" name="slug">
<?php endif;?>
			</label>
		</form>
	</div>
