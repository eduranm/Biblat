	<link rel="stylesheet" href="<?php echo base_url();?>js/select2/select2.css" />
	<script src="<?php echo base_url();?>js/select2/select2.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"], 'language': 'es'});
		var chart = null;
		jQuery(document).ready(function(){
			jQuery("#indicador").select2({
				allowClear: true
			});

			jQuery("#indicador").on("change", function(e){
				if (e.val == "") {
					jQuery("#disciplina").select2("val", "");
					jQuery("#disciplina, #revista, #pais").select2("enable", false);
					jQuery("#disciplina, #revista, #pais").select2("destroy");
					jQuery("#revista, #pais").empty().append('<option></option>');
					jQuery("#disciplina, #revista, #pais").hide();
				}else{
					jQuery("#disciplina, #revista, #pais").select2({
						allowClear: true
					});
					jQuery("#disciplina").select2("enable", true);
				}
				console.log(e);
			});

			jQuery("#disciplina").select2({
				allowClear: true
			});

			jQuery("#disciplina").on("change", function(e){
				if (e.val == "") {
					jQuery("#revista, #pais").empty().append('<option></option>');
					jQuery("#revista, #pais").select2("destroy");
					jQuery("#revista, #pais").select2({allowClear: true});
					jQuery("#revista, #pais").select2("enable", false);
				} else {
					jQuery.ajax({
						url: '<?php echo site_url("indicadores/getRevistasPaises");?>',
						type: 'POST',
						dataType: 'json',
						data: jQuery("#generarIndicador").serialize(),
						success: function(data) {
							jQuery("#revista, #pais").empty().append('<option></option>');
							jQuery("#revista, #pais").select2("destroy");
							jQuery("#revista, #pais").select2({allowClear: true});
							jQuery("#revista, #pais").select2("enable", false);
							jQuery.each(data.revistas, function(key, val) {
								jQuery("#revista").append('<option value="' + val.val +'">' + val.text + '</option>');
							});

							jQuery.each(data.paises, function(key, val) {
								jQuery("#pais").append('<option value="' + val.val +'">' + val.text + '</option>');
							});
							jQuery("#revista, #pais").select2("enable", true);
							console.log(data);
						}
					});
				}
				console.log(e);
			});

			jQuery("#revista").select2({
				allowClear: true
			});

			jQuery("#revista").on("change", function(e){
				jQuery("#periodo").select2("enable", false);
				jQuery("#periodo").empty();
				if (e.val != "") {
					jQuery("#pais").select2("enable", false);
					jQuery.ajax({
						url: '<?php echo site_url("indicadores/getPeriodos");?>',
						type: 'POST',
						dataType: 'json',
						data: jQuery("#generarIndicador").serialize(),
						success: function(data) {
							console.log(data);
							if(data.result){
								jQuery.each(data.periodos, function(key, val) {
									jQuery("#periodo").append('<option value="' + val +'">' + val + '</option>');
								});
								jQuery("#periodo").select2("enable", true)
								jQuery("#periodo").val(data.base).trigger("change");
								jQuery("#generate").prop('disabled', false);
							}else{
								jQuery("#periodo").select2("enable", false);
								jQuery("#generate").prop('disabled', true);
								console.log(data.error);
							}
						}
					});
				}else{
					jQuery("#pais").select2("enable", true);
				}
				console.log(e);
			});

			jQuery("#pais").select2({
				allowClear: true
			});

			jQuery("#pais").on("change", function(e){
				if (e.val != "") {
					jQuery("#revista").select2("enable", false);
					jQuery.ajax({
						url: '<?php echo site_url("indicadores/getPeriodos");?>',
						type: 'POST',
						dataType: 'json',
						data: jQuery("#generarIndicador").serialize(),
						success: function(data) {
							console.log(data);
							if(data.result){
								jQuery.each(data.periodos, function(key, val) {
									jQuery("#periodo").append('<option value="' + val +'">' + val + '</option>');
								});
								jQuery("#periodo").select2("enable", true)
								jQuery("#periodo").val(data.base).trigger("change");
								jQuery("#generate").prop('disabled', false);
							}else{
								jQuery("#periodo").select2("enable", false);
								jQuery("#generate").prop('disabled', true);
								console.log(data.error);
							}
						}
					});
				}else{
					jQuery("#revista").select2("enable", true);
				}
				console.log(e);
			});
			
			jQuery("#periodo").select2();

			jQuery("#generarIndicador").on("submit", function(e){
				jQuery.ajax({
				  url: '<?php echo site_url("indicadores/getChartData");?>',
				  type: 'POST',
				  dataType: 'json',
				  data: jQuery(this).serialize(),
				  success: function(data) {
				  	console.log(data);
					var chartData = new google.visualization.DataTable(data.data);

					if(chart == null || chart.At != 'line'){
						chart = new google.visualization.LineChart(document.getElementById('chart'));
						console.log(chart.At);
					}
					console.log(chart.At);
					chart.draw(chartData, data.options);
				  }
				});
				return false;
			});
		});
	</script>