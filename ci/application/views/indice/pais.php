<div id="content">
	<div id="encabezado">
		<div id="migas">
			<p><a href="<?=site_url('/');?>"><?php _e('Inicio');?></a> / <?php _e('Índice');?> / <?php _e('País');?> / <?=$current['pais'];?></p>
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
			<h1><?php _printf('Revistas por país: "%s" (%d documentos)', $current['pais'], $current['total']);?></h1>
		</div><!--end titulo_int-->
		<br class="cf">
	</div><!--end encabezado-->
	<div id="content_txt">
		<div>
			<table border=0 cellpadding='0' cellspacing='0' class="resultados centrado">
				<caption title="<?php _e('Revistas indizadas en CLASE y PERIÓDICA según orden alfabético y número de documentos de cada revista');?>"></caption>
				<colgroup>
					<col id='noCol' />
					<col id='indbibCol' />
					<col id='totalCol' />
				</colgroup>
				<thead>
					<tr>
						<th scope='col'><?php _e('No.');?></th>
						<th scope='col'><?php _e('Revista');?></th>
						<th scope='col'><?php _e('Documentos');?></th>
					</tr>
				</thead>
				<tbody>
	<?php foreach ($registros as $key => $registro):?>
					<tr class="registro">
						<td><?=($key + 1);?></td>
						<td><?=$registro['revista'];?></td>
						<td class="totalRight"><a class="enlace" href="<?=site_url("revista/{$registro['revistaSlug']}");?>" title="<?=$registro['revista'];?>"><?=number_format($registro['articulos']);?></a></td>
					</tr>
	<?php endforeach;?>
					<tr><td class='acumuladas' colspan=2><?php _e('Total:');?></td><td class='acumuladas'><?=number_format($registrosTotalArticulos);?></td></tr>
				</tbody>
			</table>
		</div>
	</div><!--end content_txt-->
</div><!--end content-->