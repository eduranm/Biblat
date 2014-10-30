{literal}
	$(document).ready(function() {
		$(".add-ref").click(function(){
			console.log($(this).attr("id"));
			/*formBuscador = $("#buscador").serialize();
			$.ajax({
				type: "POST",
				async: false,
				url: "<?=base_url('saveCheck.php')?>",
				data: formBuscador
			}).done(function( msg ) {
				//alert( "Data Saved: " + msg );
			});*/
			return false;
		});
		$(".registro").colorbox({
			rel:'registro', 
			transition:"fade", 
			data: {ajax:true}, 
			height:"90%", 
			current:"<?php _printf('Artículo %s de %s', '{current}', '{total}');?>"
		});
		$(document).bind('cbox_complete', function(){
<?php if(ENVIRONMENT === "production"):?>
			addthis.toolbox('.addthis_toolbox');
<?php endif;?>
			$('#formSolicitudDocumento').validate();
		});
		$("#resultados").highlight([<?=$slugHighLight;?>], { element: 'mark'});
	});
{/literal}
