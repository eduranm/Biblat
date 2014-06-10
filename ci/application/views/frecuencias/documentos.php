<div id="content">
	<div id="encabezado">
    	<div id="migas"> 
        	<p><a href="<?=base_url('');?>"><?php _e('Inicio');?></a> / <?php _e('Bibliometría');?> / <?php _e('Frecuencias');?></p>
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
	          <a href="javascript:window.print();"><img src="<?=base_url('/img/bt_print_int.jpg');?>" width="44" height="40" alt="imprimir pagina"></a>
        	</div>
      	</div><!--end share-->  

      	<div class="titulo_int">
        	<h1><?php echo $breadcrumb;?></h1>
      	</div><!--end titulo_int-->
        
        <br class="cf">
    </div><!--end encabezado-->
      
    <div id="content_txt">
		<?php if ($links != ""):?>
			<div class="pagination">
				<?php _printf('Páginas: %s', $links);?>
			</div>
		<?php 	endif;?>
			<div>
				<table cellspacing="5" cellpadding="5" border="0">
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
			</div>

   	</div><!--end content_txt-->           

  	<br class="cf">
</div><!--end content-->