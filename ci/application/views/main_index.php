<div class="contenido">
	<div class="flagContainer">
		<p class="flag">
			<em>
				<?php _e('Disponibles');?>
			</em>
		</p>
		<p class="flag flagRight">
			<em>
				<?php _e('Revistas por disciplina');?>
			</em>
		</p>
	</div>
	<div class="colums">
		<div class="leftColumn">
			<p class="texto">
				<span class="disponibles"><?php echo number_format($totales['revistas']); ?></span> <?php _e('revistas');?><br />
				<span class="disponibles"><?php echo number_format($totales['documentos']); ?></span> <?php _e('documentos');?><br />
				<span class="disponibles"><?php echo number_format($totales['enlaces']); ?></span> <?php _e('textos completos');?><br />
				<span class="disponibles"><?php echo number_format($totales['hevila']); ?></span> <?php _e('artículos en texto completo en repositorio HEVILA');?>
			</p>
		</div>
		<div class="rightColumn">
			<div class="tagCloud"></div>
		</div>
	</div>
	<div class="flagContainer">
		<p class="flag">
			<em>
				<?php _e('Revistas por orden alfabético');?>
			</em>
		</p>
		<p class="flag flagRight">
			<em>
				<?php _e('Revistas por país');?>
			</em>
		</p>
	</div>
	<div class="colums">
		<div class="leftColumn">
			<p class="texto">
<?php foreach (range('A', 'Z') as $i):?>
				<a href="<?php echo site_url("indice/alfabetico/".strtolower($i));?>"><?php echo $i;?></a>
<?php endforeach;?>
			</p>
		</div>
		<div class="rightColumn">
			<p class="texto">
				<ul class="paisesFlags">
					<li><a href="<?php echo site_url("indice/pais/".slug("Internacional"));?>"><img src="<?php echo base_url();?>img/flags/world.png" title="Organismos Internacionales" border="0"/></a></li>
<?php foreach ($paises as $pais):?>
					<li><a href="<?php echo site_url("indice/pais/{$pais['paisSlug']}");?>" title="<?php echo $pais['pais'];?>"><img src="<?php echo base_url("img/flags/{$pais['paisSlug']}.png");?>" title="<?php echo $pais['pais'];?>" border="0"/></a></li>
<?php endforeach;?>
				</ul>
			</p>
		</div>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="buscador" valign="top">
				<div id="bienvenida">
					<?php _e('<span class="titulo">Biblat</span> ofrece: referencias bibliográficas de documentos publicados en revistas científicas y académicas latinoamericanas indizadas en CLASE y Periódica, acceso al texto completo de revistas en acceso abierto, indicadores bibliométricos e información sobre los derechos de copyright de las revistas.');?> <br /><br />
				</div>
			</td>
			</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<td width="36%" valign="top">
				<div id="accesos"><span class="titulos"><span class="titulo"><?php _e('Estadísticas');?></span>:<br /><br />
					<!--      <a href="http://statcounter.com/p5215750/summary/" target="_blank"><img src="<?php echo base_url();?>img/grafica.gif" width="340" height="114" alt="accesos" /></a>--> 

					<a href="ind_topten.php"><img src="<?php echo base_url();?>img/estadisticas.jpg" width=350 heigth=350 border=0><br><?php _e('Ver Top Ten');?></a>


					<br /><br />
				</div>
			</td>
		</tr>
	</table>

	<div id="creditos">
		<a href="creditos.html"><?php _e('Créditos');?></a>
	</div>

</div>
