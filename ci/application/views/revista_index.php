<div class="centrado resultadosRevista">
<?php if(isset($resultados)):?>
	<div class="titulo centrado"><?php _printf('%s<br/>(%d artículos)', $revista, $search['total']);?></div><br/>
	<?php if ($links != ""):?>
	<div class="centrado links"><?php _printf('Página: %s', $links);?></div><br/>
	<?php endif;?>
	<div class="centrado" id="tablaresultados">
		<table class="resultados" cellspacing="5" cellpadding="5" border="0" width="100%">
			<?php foreach ($resultados as $key => $resultado):?>
				<tr>
					<td>
						<?php echo $key;?>.- <i><?php echo $resultado['articuloLink'];?></i> <?php echo $resultado['downloadLink'];?> <?php echo $resultado['mendeleyLink'];?><br/>
							<?php if ($resultado['autoresHTML'] != ""): echo $resultado['autoresHTML'];?><br/>
							<?php endif;
							if ($resultado['institucionesHTML'] != ""):  echo $resultado['institucionesHTML'];?><br/>
							<?php endif;
							if ($resultado['detalleRevista'] != ""): echo $resultado['detalleRevista'];?><br/>
							<?php endif;?>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
	</div><br/>
	<?php if ($links != ""):?>
	<div class="centrado links"><?php _printf('Página: %s', $links);?></div><br/>
	<?php endif;?>
<?php else:?>
	<p class="titulo centrado"><?php _printf('No se encontraron resultados para la búsqueda por %s: "%s"', strtolower($search['indice']), $search['slug']);?></p>
<?php endif;?>
</div>