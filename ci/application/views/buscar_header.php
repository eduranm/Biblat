	<link rel="stylesheet" href="<?php echo base_url();?>css/estiloBiblatresultados.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/colorbox.css" />
	<script type="text/javascript" src="<?php echo base_url();?>js/colorbox.js"></script>
	<script type="text/javascript">
		jQuery.noConflict();
		jQuery(document).ready(function() {
			jQuery(".saveCheck").click(function(){
				formBuscador = jQuery("#buscador").serialize();
				jQuery.ajax({
					type: "POST",
					async: false,
					url: "<?php echo base_url()?>/saveCheck.php",
					data: formBuscador
				}).done(function( msg ) {
					//alert( "Data Saved: " + msg );
				});
			});
			jQuery(".registro").colorbox({rel:'registro', transition:"fade", iframe:true, width:"50%", height:"90%", current:"registro {current} de {total}" });
			jQuery(document).bind('cbox_complete', function(){
				//jQuery.colorbox.resize();
			});
		});
	</script>
