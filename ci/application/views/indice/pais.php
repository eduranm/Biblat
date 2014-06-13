
<div id="content">
	<div id="encabezado">
		<div id="share">
			<div id="share1"> 
				<a href="#" target="_blank"><img src="<?=base_url('/img/bt_face_int.jpg');?>" width="22" height="37" alt="facebook"></a>
				<a href="#" target="_blank"><img src="<?=base_url('/img/bt_twit_int.jpg');?>" width="22" height="37" alt="twitter"></a>
				<a href="#" target="_blank"><img src="<?=base_url('/img/bt_ayuda_int.jpg');?>" width="22" height="37" alt="ayuda"></a>
				<a href="mailto:scielo@dgb.unam.mx" target="_blank"><img src="<?=base_url('/img/bt_contact_int.jpg');?>" width="25" height="37" alt="contacto"></a>
				<div><a class="share" href="#">Español</a></div>      
			</div>
                 
			<div id="share2">
				<a href="#"><img src="<?=base_url('/img/bt_share_int.jpg');?>" width="23" height="40" alt="share"></a>
				<a href="#"><img src="<?=base_url('/img/bt_aument_int.jpg');?>" width="39" height="40" alt="Aumentar tipografía"></a>
				<a href="#"><img src="<?=base_url('/img/bt_dismin_int.jpg');?>" width="39" height="40" alt="Disminuir tipografía"></a>
				<a href="javascript:window.print();"><img src="<?=base_url('/img/bt_print_int.jpg');?>" width="44" height="40" alt="imprimir pagina"></a>
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
