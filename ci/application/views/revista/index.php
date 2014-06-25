<div id="content">
	<div id="encabezado">    
        <div id="migas">
            <p><a href="<?=site_url('/');?>"><?php _e('Inicio');?></a> / <?php echo $breadcrumb;?></p>
        </div><!--End migas-->           
        <div id="share">
            <div id="share1">
                <span class="space"><a href="https://www.facebook.com/pages/BIBLAT/188958071154818" target="_blank">&#Xf09a;</a></span>
                <span class="space"><a href="https://twitter.com/Biblat" target="_blank">&#Xf099;</i></i></a></span>
                <span class="space"><a href="#" target="_blank">?</a></span>
                <span class="space"><a href="mailto:scielo@dgb.unam.mx"><i class="fa fa-envelope-o"></i></a></span>
                <div><a class="share" href="#">Español</a></div>
            </div>
                <div id="share2">
                    <a href="#">A<sup>+</sup></a>
                    <a href="#">A<sup>-</sup></a>
                    <a href="javascript:window.print();"><i class="fa fa-print"></i></a>
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
    	</div>
	</div><!--end content_txt-->
</div><!--end content-->