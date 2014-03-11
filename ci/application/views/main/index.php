<div class="contenido main">
	<div class="flagContainer">
		<p class="flag flag">
			<em>
				<?php _e('Revistas por disciplina');?>
			</em>
		</p>
		<p class="flag flagRight">
			<em>
				<?php _e('Revistas por país');?>
			</em>
		</p>
	</div>
	<div class="columns">
		<div class="leftColumn">
			<div class="tagCloud"></div>
		</div>
		<div class="rightColumn">
			<ul class="paisesFlags">
				<li><a href="<?=site_url("indice/pais/".slug("Internacional"));?>"><span class="flagspr flagspr-world" title="<?=$pais['pais'];?>"></span></a></li>
<?php foreach ($paises as $pais):?>
				<li><a href="<?=site_url("indice/pais/{$pais['paisSlug']}");?>" title="<?=$pais['pais'];?>"><span class="flagspr flagspr-<?=$pais['paisSlug'];?>" title="<?=$pais['pais'];?>"></span></a></li>
<?php endforeach;?>
			</ul>
		</div>
		<p class="flag flagRight">
			<em>
				<?php _e('Revistas por orden alfabético');?>
			</em>
		</p>
		<div class="rightColumn">
			<p class="texto">
<?php foreach (range('A', 'Z') as $i):?>
				<a href="<?=site_url("indice/alfabetico/".strtolower($i));?>"><?=$i;?></a>
<?php endforeach;?>
			</p>
		</div>
		<p class="flag flagRight">
			<em>
				<?php _e('Disponibles');?>
			</em>
		</p>
		<div class="rightColumn">
			<p class="texto">
				<span class="disponibles"><?=number_format($totales['revistas']); ?></span> <?php _e('revistas');?><br />
				<span class="disponibles"><?=number_format($totales['documentos']); ?></span> <?php _e('documentos');?><br />
				<span class="disponibles"><?=number_format($totales['enlaces']); ?></span> <?php _e('textos completos');?><br />
				<span class="disponibles"><?=number_format($totales['hevila']); ?></span> <?php _e('documentos en texto completo en repositorio HEVILA');?>
			</p>
		</div>
	</div>
	<div id="creditos" class="cboth">
		<a href="<?=site_url('creditos');?>"><?php _e('Créditos');?></a>
	</div>
</div>
