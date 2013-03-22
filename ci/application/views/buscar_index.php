<div class="centrado">
<?php if(isset($resultados)):?>
	<p class="titulo centrado"><?php _printf('Resultados de la búsqueda por: %s', $search['slug']);?></p><br/>
<?php 	if ($search['disciplina'] != ""):?>
	<p class="centrado"><?php _printf('<i>(%s documentos publicados en el área de <i><b>%s</b></i>)', $search['total'], $search['disciplina']);?></p><br/>
<?php 	else:?>
	<p class="centrado"><?php _printf('<i>(%s documentos publicados</i>)', $search['total']);?></p><br/>
<?php 	endif;
		if ($links != ""):?>
	<div class="centrado"><?php _printf('Página: %s', $links);?></div><br/>
<?php 	endif;?>
	<div class="centrado" id="tablaresultados">
		<table class="resultados" cellspacing="5" cellpadding="5" border="0" width="100%">
<?php 	foreach ($resultados as $key => $resultado):?>
				<tr>
					<td>
						<input type="checkbox" name="registros[]" id="<?php echo $resultado['checkBoxId']?>" value="<?php echo $resultado['checkBoxValue']?>">   <?php echo $key;?>.- <i><?php echo $resultado['articuloLink'];?></i><br/>
<?php 		if ($resultado['autoresHTML'] != ""): echo $resultado['autoresHTML'];?><br/>
<?php 		endif;
			if ($resultado['institucionesHTML'] != ""):  echo $resultado['institucionesHTML'];?><br/>
<?php 		endif;
			if ($resultado['detalleRevista'] != ""): echo $resultado['detalleRevista'];?><br/>
<?php 		endif;?>
							<a target="_blank" title="<?php echo $resultado['articulo'];?>" class="registro cboxElement" href="<?php echo site_url("revista/{$resultado['revistaSlug']}/articulo/{$resultado['articuloSlug']}");?>"><?php _e('Ver registro completo');?> </a>
							<a target="_blank" href="http://www.mendeley.com/import/?url=<?php echo urlencode(site_url("revista/{$resultado['revistaSlug']}/articulo/{$resultado['articuloSlug']}"));?>" title="<?php _e('Agregue este articulo a su biblioteca Mendeley');?>"><img src="http://www.mendeley.com/graphics/mendeley.png"></a>
					</td>
				</tr>
<?php 	endforeach;?>
		</table>
	</div><br/>
<?php 	if ($links != ""):?>
	<div class="centrado"><?php _printf('Página: %s', $links);?></div><br/>
<?php 	endif;?>
<?php else:?>
	<p class="titulo centrado"><?php _printf('No se encontraron resultados para la búsqueda por: "%s"', $search['slug']);?></p>
<?php endif;?>
</div>
