  <div id="content">
    <div id="encabezado">
      <div id="migas"> 
        <p><a href="<?=base_url('');?>"><?php _e('Inicio');?></a> / <?php _e('Búsqueda');?></p>
      </div><!--end migas-->
                 
      <div id="share">
        <div id="share1"> 
          <a href="#" target="_blank"><img src="<?=base_url('/img/bt_face_int.jpg');?>" width="22" height="37" alt="facebook"></a>
          <a href="#" target="_blank"><img src="<?=base_url('/img/bt_twit_int.jpg');?>" width="22" height="37" alt="twitter"></a>
          <a href="#" target="_blank"><img src="<?=base_url('/img/bt_ayuda_int.jpg');?>" width="22" height="37" alt="ayuda"></a>
          <a href="mailto:scielo@dgb.unam.mx" target="_blank"><img src="<?=base_url('/img/bt_contact_int.jpg');?>" width="25" height="37" alt="contacto"></a>
          <div>
            <a class="share" href="#">Español</a>
          </div>            
        </div>

        <div id="share2"> 
          <a href="#"><img src="<?=base_url('/img/bt_share_int.jpg');?>" width="23" height="40" alt="share"></a>
          <a href="#"><img src="<?=base_url('/img/bt_aument_int.jpg');?>" width="39" height="40" alt="Aumentar tipografía"></a>
          <a href="#"><img src="<?=base_url('/img/bt_dismin_int.jpg');?>" width="39" height="40" alt="Disminuir tipografía"></a>
          <a href="#"><img src="<?=base_url('/img/bt_print_int.jpg');?>" width="44" height="40" alt="imprimir pagina"></a>
        </div>
      </div><!--end share-->  

<?php if(isset($resultados)):?>
      <div class="titulo_int">
        <h1><?=$title;?></h1>
      </div><!--end titulo_int-->
        
        <br class="cf">
    </div><!--end encabezado-->
      
    <div id="content_txt">
<?php 	if ($search['disciplina'] != ""):?>
	<div class="flagContainer">
		<p class="flag">
			<em>
				<?php _printf('<i>(%s documentos publicados en el área de <b>%s</b>)</i>', $search['total'], $search['disciplina']);?>
				
			</em>
		</p>
	</div>
<?php 	else:?>

	<div class="cien">
		<div class="titulo_int">
            <h1><?php _printf('<i>%s documentos publicados</i>', $search['total']);?>
<?php if(!$textoCompleto && $search['totalCompleto'] > 0): echo ", ".anchor("{$paginationURL}/texto-completo", _sprintf('<b>mostrar "%s" resultados en texto completo</b>', $search['totalCompleto']), 'title="'._sprintf('mostrar %s resultados en texto completo', $search['totalCompleto']).'"'); endif;?>
<?php if($textoCompleto):?>	
				en texto completo
				<?php endif;?></h1>
          </div><!--end titulo_int-->
          <br class="cf">
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
						<?=$key;?>.- <i><?=$resultado['articuloLink'];?></i> <?=$resultado['downloadLink'];?> <?=$resultado['mendeleyLink'];?><br/>
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
    </div><!--end content_txt-->
            
  </div><!--end content-->
  <br class="cf">
</div><!--end content_int-->
