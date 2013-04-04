<div class="articulo">
<?php if (isset($articulo)):?>
	<table>
		<caption class="titulo centrado"> 
			<?php echo $articulo['articulo'];?>
			<div class="addthis_toolbox addthis_default_style">
				<a class="addthis_button_mendeley" style="cursor:pointer"></a>
				<a class="addthis_button_facebook" style="cursor:pointer"></a>
				<a class="addthis_button_twitter" style="cursor:pointer"></a>
				<a class="addthis_button_email" style="cursor:pointer"></a>
				<a class="addthis_button_print" style="cursor:pointer"></a>
				<a class="addthis_button_compact"></a>
				<a class="addthis_counter addthis_bubble_style"></a>
			</div>
		</caption>
		<tbody>
<?php 	if ( isset($articulo['revista']) ):?>
				<tr>
					<td class="attributo"><?php _e('Revista:');?></td>
					<td><a href="<?php echo site_url("revista/{$articulo['revistaSlug']}")?>" title="<?php echo $articulo['revista']?>"><?php echo $articulo['revista']?></a></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['issn']) ):?>
				<tr>
					<td class="attributo"><?php _e('ISSN:');?></td>
					<td><?php echo $articulo['issn']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['autoresHTML']) ):?>
				<tr>
					<td class="attributo"><?php _e('Autores:');?></td>
					<td><?php echo $articulo['autoresHTML']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['institucionesHTML']) ):?>
				<tr>
					<td class="attributo"><?php _e('Instituciones:');?></td>
					<td><?php echo $articulo['institucionesHTML']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['anio']) ):?>
				<tr>
					<td class="attributo"><?php _e('Año:');?></td>
					<td><?php echo $articulo['anio']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['periodo']) ):?>
				<tr>
					<td class="attributo"><?php _e('Periodo:');?></td>
					<td><?php echo ucname($articulo['periodo'])?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['volumen']) ):?>
				<tr>
					<td class="attributo"><?php _e('Volumen:');?></td>
					<td><?php echo $articulo['volumen']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['numero']) ):?>
				<tr>
					<td class="attributo"><?php _e('Número:');?></td>
					<td><?php echo $articulo['numero']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['paginacion']) ):?>
				<tr>
					<td class="attributo"><?php _e('Paginación:');?></td>
					<td><?php echo $articulo['paginacion']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['pais']) ):?>
				<tr>
					<td class="attributo"><?php _e('País:');?></td>
					<td><?php echo $articulo['pais']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['idioma']) ):?>
				<tr>
					<td class="attributo"><?php _e('Idioma:');?></td>
					<td><?php echo $articulo['idioma']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['disciplinasHTML']) ):?>
				<tr>
					<td class="attributo"><?php _e('Disciplinas:');?></td>
					<td><?php echo $articulo['disciplinasHTML']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['palabrasClaveHTML']) ):?>
				<tr>
					<td class="attributo"><?php _e('Palabras clave:');?></td>
					<td><?php echo $articulo['palabrasClaveHTML']?></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['url']) ):?>
				<tr>
					<td class="attributo"><?php _e('Texto completo:');?></td>
					<td><a href="<?php echo $articulo['url']?>"><?php echo $articulo['url']?></a></td>
				</tr>
<?php 	endif;?>
		</tbody>
	</table>
<?php endif;?>
</div>