<div class="contenido">
<?php if(isset($resultados)):?>
	<div class="flagContainer">
		<p class="flag">
			<em>
				<?php echo $title;?>
			</em>
		</p>
	</div>
<?php 	if ($search['disciplina'] != ""):?>
	<div class="flagContainer">
		<p class="flag">
			<em>
				<?php _printf('<i>(%s documentos publicados en el área de <b>%s</b>)</i>', $search['total'], $search['disciplina']);?>
				
			</em>
		</p>
	</div>
<?php 	else:?>
	<div class="flagContainer">
		<p class="flag">
			<em>
				<?php _printf('<i>%s documentos publicados</i>', $search['total']);?>
<?php if(!$textoCompleto && $search['totalCompleto']) > 0): echo ", ".anchor("{$paginationURL}/texto-completo", _sprintf('<b>mostrar "%s" resultados en texto completo</b>', $search['totalCompleto']), 'title="'._sprintf('mostrar %s resultados en texto completo', $search['totalCompleto']).'"'); else:?>
				en texto completo
				<?php endif;?>
			</em>
		</p>
	</div>
<?php 	endif;
		if ($links != ""):?>
	<div class="pagination">
		<?php _printf('Páginas: %s', $links);?>
	</div>
<?php 	endif;?>
	<div class="centrado">
		<table class="resultados centrado" cellspacing="5" cellpadding="5" border="0">
<?php 	foreach ($resultados as $key => $resultado):?>
				<tr>
					<td>
						<?php echo $key;?>.- <i><?php echo $resultado['articuloLink'];?></i> <?php echo $resultado['downloadLink'];?> <?php echo $resultado['mendeleyLink'];?><br/>
<?php 		if ($resultado['autoresHTML'] != ""): echo $resultado['autoresHTML'];?><br/>
<?php 		endif;
			if ($resultado['institucionesHTML'] != ""):  echo $resultado['institucionesHTML'];?><br/>
<?php 		endif;
			if ($resultado['detalleRevista'] != ""): echo $resultado['detalleRevista'];?><br/>
<?php 		endif;?>	
					</td>
				</tr>
<?php 	endforeach;?>
		</table>
	</div><br/>
<?php 	if ($links != ""):?>
	<div class="pagination"><?php _printf('Páginas: %s', $links);?></div><br/>
<?php 	endif;?>
<?php else:?>
	<p class="titulo centrado"><?php _printf('No se encontraron resultados para la búsqueda por: "%s"', $search['slug']);?></p>
<?php endif;?>
</div>
