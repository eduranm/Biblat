<div class="contenido">
	<div class="flagContainer">
		<p class="flag">
			<em>
				<?php echo $breadcrumb;?>
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
						<?php echo $key;?>.- <i><?php echo $resultado['articuloLink'];?></i> <?php echo $resultado['downloadLink'];?> <?php echo $resultado['mendeleyLink'];?><br/>
<?php 		if ($resultado['autoresHTML'] != ""): echo $resultado['autoresHTML'];?><br/>
<?php 		endif;
			if ($resultado['institucionesHTML'] != ""):  echo $resultado['institucionesHTML'];?><br/>
<?php 		endif;
			if ($resultado['detalleRevista'] != ""): echo $resultado['detalleRevista'];?><br/>
<?php 		endif;
			//if ($resultado['addRef'] != ""): echo $resultado['addRef'];?><br/>
<?php 		endif;?>	
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
