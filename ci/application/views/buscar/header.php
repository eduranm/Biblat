	<link rel="stylesheet" href="<?=base_url('css/estiloBiblatresultados.css');?>"/>
	<link rel="stylesheet" href="<?=base_url('css/colorbox.css');?>"/>
	<link rel="stylesheet" href="<?=base_url('css/colorboxIndices.css');?>"/>
	<script type="text/javascript" src="<?=base_url('js/colorbox.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('js/jquery.highlight.js');?>"></script>
	<script type="text/javascript">
		jQuery.noConflict();
		jQuery(document).ready(function() {
			jQuery(".add-ref").click(function(){
				console.log(jQuery(this).attr("id"));
				/*formBuscador = jQuery("#buscador").serialize();
				jQuery.ajax({
					type: "POST",
					async: false,
					url: "<?=base_url('saveCheck.php')?>",
					data: formBuscador
				}).done(function( msg ) {
					//alert( "Data Saved: " + msg );
				});*/
				return false;
			});
			jQuery(".registro").colorbox({
				rel:'registro', 
				transition:"fade", 
				data: {ajax:true}, 
				height:"90%", 
				current:"<?php _printf('Artículo %s de %s', '{current}', '{total}');?>"
			});
			jQuery(document).bind('cbox_complete', function(){
				addthis.toolbox('.addthis_toolbox');
				jQuery('#formSolicitudDocumento').validate();
			});
			jQuery(".resultados").highlight([<?=$slugHighLight;?>]);
		});
	</script>
