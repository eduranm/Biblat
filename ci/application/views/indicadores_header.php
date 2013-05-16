	<link rel="stylesheet" href="<?php echo base_url();?>js/select2/select2.css" />
	<script src="<?php echo base_url();?>js/select2/select2.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"], 'language': 'es'});
		var chart = null;
		jQuery(document).ready(function(){
			jQuery("#indicador").select2({
				placeholder: "<?php _e('Seleccione indicador');?>",
				allowClear: true
			});

			jQuery("#indicador").on("change", function(e){
				if (e.val == "") {
					jQuery("#disciplina").select2("val", "");
					jQuery("#disciplina").select2("disable");
					jQuery("#disciplina").select2("destroy");
					jQuery("#disciplina").hide();
					jQuery("#revista").select2("val", "");
					jQuery("#revista").select2("disable");
					jQuery("#revista").select2("destroy");
					jQuery("#revista").hide();
				}else{
					jQuery("#disciplina").select2({
						placeholder: "<?php _e('Seleccione una disciplina');?>",
						allowClear: true
					});
					jQuery("#disciplina").select2("enable");
					jQuery("#revista").select2({
						placeholder: "<?php _e('Seleccione una revista');?>",
						allowClear: true
					});
				}
				console.log(e);
			});

			jQuery("#disciplina").select2({
				placeholder: "<?php _e('Seleccione una disciplina');?>",
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

			jQuery("#revista").select2({
				placeholder: "<?php _e('Seleccione una revista');?>",
				allowClear: true
			});

			jQuery("#revista").on("change", function(e){
				jQuery.ajax({
					url: '<?php echo site_url("indicadores/getPeriodos");?>/' + jQuery("#indicador").val() + '/' + e.val,
					type: 'POST',
					dataType: 'json',
					data: {ajax: 'true'},
					success: function(data) {
						console.log(data);
						if(data.result){
							jQuery("#periodo").select2("disable");
							jQuery("#periodo").empty();
							jQuery.each(data.periodos, function(key, val) {
								jQuery("#periodo").append('<option value="' + val.anio +'">' + val.anio + '</option>');
							});
							jQuery("#periodo").select2("enable");
							jQuery("#periodo").select2("open");
							jQuery("#generate").prop('disabled', false);
						}else{
							jQuery("#periodo").select2("disable");
							jQuery("#generate").prop('disabled', true);
							console.log(data.error);
						}
					}
				});
				console.log(e);
			});
			
			jQuery("#periodo").select2();

			jQuery("#generarIndicador").on("submit", function(e){
				jQuery.ajax({
				  url: '<?php echo site_url("indicadores/indiceCoautoriaChart");?>',
				  type: 'POST',
				  dataType: 'json',
				  data: jQuery(this).serialize(),
				  success: function(data) {
				  	console.log(data);
					var dataStart = new google.visualization.DataTable(data.start);
					var dataEnd = new google.visualization.DataTable(data.end);

					var options = {
						animation: {
							duration: 1500
						},
						hAxis: {
							title: '<?php _e('Periodo')?>'
						},
						legend: {
							position: 'right'
						},
						pointSize: 3,
						vAxis: {
							title: '<?php _e('Indice de coautoría')?>',
							minValue: 0,
							baseline: 0
						}
					};
					if(chart == null || chart.At != 'line'){
						chart = new google.visualization.LineChart(document.getElementById('chart'));
						console.log(chart.At);
						chart.draw(dataStart, options);
					}
					console.log(chart.At);
					chart.draw(dataEnd, options);
				  }
				});
				return false;
			});
		});
	</script>