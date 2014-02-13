<div class="articulo">
<?php if (isset($articulo)):?>
	<table <?php if ($mail):?> border="1" style="border-collapse:collapse; width:650px;"<?php endif;?>>
<?php 	if (!$mail):?>
		<caption class="centrado"> 
			<?php echo $articulo['articulo'];?>
			<div class="addthis_toolbox addthis_default_style" addthis:url="<?php echo site_url("revista/{$articulo['revistaSlug']}/articulo/{$articulo['articuloSlug']}")?>" addthis:title="<?php echo $title;?>">
				<a class="addthis_button_mendeley" style="cursor:pointer"></a>
				<a class="addthis_button_facebook" style="cursor:pointer"></a>
				<a class="addthis_button_twitter" style="cursor:pointer"></a>
				<a class="addthis_button_email" style="cursor:pointer"></a>
				<a class="addthis_button_print" style="cursor:pointer"></a>
				<a class="addthis_button_compact"></a>
				<a class="addthis_counter addthis_bubble_style"></a>
			</div>
		</caption>
<?php 	endif;?>
		<tbody>
<?php 	if ($mail):?>
				<tr>
					<td class="attributo"><?php _e('Título del documento:');?></td>
					<td><a href="<?php echo site_url("revista/{$articulo['revistaSlug']}/articulo/{$articulo['articuloSlug']}")?>" title="<?php echo $articulo['revista']?>"><?php echo $articulo['articulo']?></a></td>
				</tr>
<?php 	endif;?>
<?php 	if ( isset($articulo['revista']) ):?>
				<tr>
					<td class="attributo"><?php _e('Revista:');?></td>
					<td><a href="<?php echo site_url("revista/{$articulo['revistaSlug']}")?>" title="<?php echo $articulo['revista']?>"><?php echo $articulo['revista']?></a></td>
				</tr>
<?php 	endif;?>
				<tr>
					<td class="attributo"><?php _e('Base de datos:');?></td>
					<td><?php echo $articulo['database']?></td>
				</tr>
				<tr>
					<td class="attributo"><?php _e('Número de sistema:');?></td>
					<td><?php echo $articulo['sistema']?></td>
				</tr>
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
					<td><a href="<?php echo $articulo['url']?>" target="_blank"><?php echo $articulo['url']?></a></td>
				</tr>
<?php 	elseif (!$mail && !isset($articulo['url'])):?>
				<tr id="solicitudDocumento">
					<td colspan="2"><b><?php _e('Solicitud del documento')?></b> <span id="sd-enable" class="fa">&#xf152</span> <span id="sd-disable" class="fa">&#xf150</span></td>
				</tr>
				<tr class="solicitudDocumento">
					<td colspan="2">
						<form id="formSolicitudDocumento" action="<?php echo site_url('revista/solicitud/documento');?>" method="POST" class="contacto">
							<fieldset>
								<b><?php _e('Nota:');?></b> <?php _e('El envío del documento tiene costo.');?><br/><br/>
								<label><?php _e('Nombre');?></label><br/>
								<input type="text" name="from" required data-msg-required="<?php _e('El nombre es requerido');?>"/><br/>
								<label><?php _e('Dirección de correo electrónico');?></label><br/>
								<input type="text" name="email" placeholder="me@domain.com" required data-msg-required="<?php _e('El correo electrónico es requerido');?>"/><br/>
								<label><?php _e('Instituto');?></label><br/>
								<input type="text" name="instituto"/><br/>
								<label><?php _e('Teléfono');?></label><br/>
								<input type="text" name="telefono"/><br/>
								<input type="hidden" name="database" value="<?php echo $articulo['database'];?>"/>
								<input type="hidden" name="sistema" value="<?php echo $articulo['sistema'];?>"/>
								<input type="hidden" name="revista" value="<?php echo $articulo['revistaSlug'];?>"/>
								<input type="hidden" name="articulo" value="<?php echo $articulo['articuloSlug'];?>"/>
								<input type="hidden" name="url" value="<?php echo current_url();?>"/>
								<div class="textoJ">
								<?php _e('Los documentos originales pueden ser consultados en el Departamento de Información y Servicios Documentales, ubicado en el Anexo de la Dirección General de Bibliotecas (DGB), circuito de la Investigación Científica a un costado del Auditorio Nabor Carrillo, zona de Institutos entre Física y Astronomía. Ciudad Universitaria UNAM.');?> <a id="showmap" href="javascript:;"><?php _e('Ver mapa');?></a><img id="mapa-anexo" style="display:none" src="<?php echo base_url('img/mapa-anexo.jpg');?>" border="0" width="600px"/><br/><?php _e('Mayores informes: Departamento de Información y Servicios Documentales, Tels. (5255) 5622-3960, 5622-3964, e-mail: sinfo@dgb.unam.mx, Horario: Lunes a viernes (8 a 16 hrs.)');?></div>
								<input class="fa" type="submit" value="Enviar   &#xf0e0;"/>
							</fieldset>
						</form>
					</td>
				</tr>
<?php 	endif;?>
		</tbody>
	</table>
<?php endif;?>
</div>