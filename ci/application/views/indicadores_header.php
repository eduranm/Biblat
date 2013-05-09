	<link rel="stylesheet" href="<?php echo base_url();?>js/select2/select2.css" />
	<script src="<?php echo base_url();?>js/select2/select2.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#indicador").select2({
				placeholder: "<?php _e('Seleccione indicador');?>",
				allowClear: true
			});
			jQuery("#disciplina").select2({
				placeholder: "<?php _e('Seleccione una disciplina');?>",
				allowClear: true
			});
			jQuery("#revista").select2({
				placeholder: "<?php _e('Seleccione una revista');?>",
				allowClear: true
			});
			jQuery("#disciplina").on("change", function(e){
				if (e.val == "") {
					jQuery("#revista").select2("val", "");
					jQuery("#revista").select2("disable");
				} else {
					jQuery.ajax({
						url: '<?php echo site_url("indicadores/getRevistas");?>/' + e.val,
						type: 'POST',
						dataType: 'json',
						data: {ajax: 'true'},
						success: function(data) {
							jQuery("#revista").select2("disable");
							jQuery("#revista").empty().append('<option></option>');
							jQuery("#revista").select2("val", "");
							jQuery.each(data, function(key, val) {
								jQuery("#revista").append('<option value="' + val.val +'">' + val.text + '</option>');
							});
							jQuery("#revista").select2("enable");
							jQuery("#revista").select2("open");
						}
					});
				}
				console.log(e);
			});
			jQuery(document).on("click", ".select2-result-label", function(event){
				alert(jQuery(this).text());
			});
		});
	</script>