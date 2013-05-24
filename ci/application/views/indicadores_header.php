	<link rel="stylesheet" href="<?php echo base_url();?>js/select2/select2.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.slider.min.css" />
	<script src="<?php echo base_url();?>js/select2/select2.js"></script>
	<script src="<?php echo base_url();?>js/jquery.slider.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"], 'language': 'en'});
		var chart = null;
		var soloDisciplina = ['indice-concentracion', 'modelo-bradford-revista', 'modelo-bradford-institucion', 'productividad-exogena'];
		jQuery(document).ready(function(){
			jQuery("#indicador").select2({
				allowClear: true
			});

			jQuery("#indicador").on("change", function(e){
				jQuery("#disciplina").select2("val", "");
				if (e.val == "") {
					jQuery("#disciplina, #revista, #pais").select2("enable", false);
					jQuery("#revista, #pais").empty().append('<option></option>');
					jQuery("#disciplina, #paisRevista").hide();
				}else if(jQuery.inArray(e.val, soloDisciplina) > -1){
					jQuery("#revista, #pais").select2("enable", false);
					jQuery("#revista, #pais").empty().append('<option></option>');
					jQuery("#paisRevista").hide();
					jQuery("#disciplina").select2("enable", true);
				}else{
					jQuery("#paisRevista").show();
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
				} else if (jQuery.inArray(jQuery("#indicador").val(), soloDisciplina) > -1) {

				} else {
					jQuery.ajax({
						url: '<?php echo site_url("indicadores/getRevistasPaises");?>',
						type: 'POST',
						dataType: 'json',
						data: jQuery("#generarIndicador").serialize(),
						success: function(data) {
							console.log(data);
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
						}
					});
				}
				console.log(e);
			});

			jQuery("#revista").select2({
				allowClear: true
			});

			jQuery("#revista").on("change", function(e){
				jQuery("#sliderPeriodo").prop("disabled", true);
				if (e.val != "") {
					jQuery("#pais").select2("enable", false);
					setPeridos();
				}else{
					jQuery("#pais").select2("enable", true);
				}
				console.log(e);
			});

			jQuery("#pais").select2({
				allowClear: true
			});

			jQuery("#pais").on("change", function(e){
				jQuery("#sliderPeriodo").prop("disabled", true);
				if (e.val != "") {
					jQuery("#revista").select2("enable", false);
					setPeridos();
				}else{
					jQuery("#revista").select2("enable", true);
				}
				console.log(e);
			});
			
			jQuery("#sliderPeriodo").slider();

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

		setPeridos = function(){
			jQuery.ajax({
				url: '<?php echo site_url("indicadores/getPeriodos");?>',
				type: 'POST',
				dataType: 'json',
				data: jQuery("#generarIndicador").serialize(),
				success: function(data) {
					console.log(data);
					console.log(jQuery.parseJSON(data.scale));
					if(data.result){
						jQuery("#sliderPeriodo").prop('disabled', false);
						jQuery("#generate").prop('disabled', false);
						jQuery("#sliderPeriodo").val(data.anioBase + ";" + data.anioFinal);
						jQuery("#sliderPeriodo").slider().destroy();
						jQuery("#sliderPeriodo").slider({
							from: data.anioBase, 
							to: data.anioFinal, 
							//heterogeneity: ['50/2010'], 
							scale: jQuery.parseJSON(data.scale),
							format: { format: '####', locale: 'us' }, 
							limits: false, 
							step: 1, 
							dimension: '', 
							skin: "round_plastic" 
						});
					}else{
						jQuery("#sliderPeriodo").prop('disabled', true);
						jQuery("#generate").prop('disabled', true);
						console.log(data.error);
					}
				}
			});
		}
	</script>