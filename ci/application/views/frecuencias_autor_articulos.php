<div class="contenido">
	<div class="flagContainer">
		<p class="flag">
			<em>
				<a href="<?php echo site_url('frecuencias')?>"><?php _e('Frecuencias');?></a> > <a href="<?php echo site_url('frecuencias/autor')?>"><?php _e('Autor');?></a> > <?php _printf('%s (%s documentos)', $autor, $total)?>
			</em>
		</p>
	</div>
<?php if ($links != ""):?>
	<div class="pagination">
		<?php _printf('Páginas: %s', $links);?>
	</div>
<?php 	endif;?>
	<div class="centrado">
		<table class="resultados centrado" cellspacing="5" cellpadding="5" border="0">
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
	<div class="pagination"><?php _printf('Páginas: %s', $links);?></div><br/>
<?php 	endif;?>
	</div>
</div>