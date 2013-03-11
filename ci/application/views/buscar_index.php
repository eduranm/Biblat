<div class="centrado">
<?php if(isset($resultados)):?>
	<p class="titulo centrado"><?php _printf('Resultados de la búsqueda por %s', strtolower($search['indice']));?></p><br/>
	<p class="centrado"><?php _printf('<b>%s</b>: %s (%s documentos publicados en el área de <i><b>%s</b></i>)', $search['indice'], $search['slug'], $search['total'], $search['disciplina']);?></p><br/>
	<div class="centrado"><?php _printf('Página: %s', $links);?></div><br/>
	<div class="centrado" id="tablaresultados">
		<table cellspacing="5" cellpadding="5" border="0">
			<?php foreach ($resultados as $key => $resultado):?>
				<tr>
					<td>
						<input type="checkbox" name="registros[]" id="<?php echo $resultado['checkBoxId']?>" value="<?php echo $resultado['checkBoxValue']?>">   <?php echo $key;?>.- <i><?php echo $resultado['articuloLink'];?></i><br/>
							<?php echo $resultado['autoresHTML'];?><br/>
							<?php echo $resultado['institucionesHTML'];?><br/>
							<?php echo $resultado['detalleRevista'];?><br/>
							<a target="_blank" title="<?php echo $resultado['titulo'];?>" class="registro cboxElement" href="">Ver registro completo </a>
							<a target="_blank" href="http://www.mendeley.com/import/?url=" title="Agregue este articulo a su biblioteca Mendeley"><img src="http://www.mendeley.com/graphics/mendeley.png"></a>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
	</div><br/>
	<div class="centrado"><?php _printf('Página: %s', $links);?></div><br/>
<?php else:?>
	<p class="titulo centrado"><?php _printf('No se encontraron resultados para la búsqueda por %s: "%s"', strtolower($search['indice']), $search['slug']);?></p>
<?php endif;?>
</div>
