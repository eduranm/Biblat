	<link rel="stylesheet" href="<?php echo base_url();?>js/select2/select2.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.slider.min.css" />
	<script src="<?php echo base_url();?>js/select2/select2.js"></script>
	<script src="<?php echo base_url();?>js/jquery.slider.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"], 'language': 'en'});
		var chart = null;
		var charType = null;
		var soloDisciplina = ['indice-concentracion', 'modelo-bradford-revista', 'modelo-bradford-institucion', 'productividad-exogena'];
		jQuery(document).ready(function(){
			jQuery("#indicador").select2({
				allowClear: true
			});

			jQuery("#indicador").on("change", function(e){
				jQuery("#paisRevista, #periodos, #chart").hide("slow");
				jQuery("#disciplina").select2("val", "");
				if (e.val == "") {
					jQuery("#disciplina, #revista, #pais").select2("enable", false);
					jQuery("#revista, #pais").empty().append('<option></option>');
					jQuery("#revista, #pais").select2("destroy");
				}else if(jQuery.inArray(e.val, soloDisciplina) > -1){
					jQuery("#revista, #pais").select2("enable", false);
					jQuery("#revista, #pais").empty().append('<option></option>');
					jQuery("#revista, #pais").select2("destroy");
					jQuery("#disciplina").select2("enable", true);
				}else{
					jQuery("#revista, #pais").select2({allowClear: true, closeOnSelect: true});
					jQuery("#disciplina").select2("enable", true);
				}

				if(typeof history.pushState === "function"){
					console.log(jQuery("#generarIndicador").serializeArray());
					history.pushState(jQuery("#generarIndicador").serializeArray(), null, '<?php site_url('indicadores')?>' + e.val);
				}
				console.log(e);
			});

			jQuery(window).bind('popstate',  function(event) {
				console.log('pop: ' + event.state);
			});

			jQuery("#disciplina").select2({
				allowClear: true
			});

			jQuery("#disciplina").on("change", function(e){
				if (e.val == "") {
					jQuery("#paisRevista, #periodos, #chart").hide("slow");
					jQuery("#revista, #pais").empty().append('<option></option>');
					jQuery("#revista, #pais").select2("destroy");
					jQuery("#revista, #pais").select2({allowClear: true, closeOnSelect: true});
					jQuery("#revista, #pais").select2("enable", false);
				} else if (jQuery.inArray(jQuery("#indicador").val(), soloDisciplina) > -1) {
					
				} else {
					jQuery("#paisRevista").show("slow");
					jQuery.ajax({
						url: '<?php echo site_url("indicadores/getRevistasPaises");?>',
						type: 'POST',
						dataType: 'json',
						data: jQuery("#generarIndicador").serialize(),
						success: function(data) {
							console.log(data);
							jQuery("#revista, #pais").empty().append('<option></option>');
							jQuery("#revista, #pais").select2("destroy");
							jQuery("#revista, #pais").select2({allowClear: true, closeOnSelect: true});
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
				allowClear: true,
				closeOnSelect: true
			});

			jQuery("#revista").on("change", function(e){
				jQuery("#sliderPeriodo").prop("disabled", true);
				if (e.val != "") {
					jQuery("#pais").select2("enable", false);
					setPeridos();
				}else{
					jQuery("#periodos, #chart").hide("slow");
					jQuery("#pais").select2("enable", true);
				}
				console.log(e);
			});

			jQuery("#pais").select2({
				allowClear: true,
				closeOnSelect: true
			});

			jQuery("#pais").on("change", function(e){
				jQuery("#sliderPeriodo").prop("disabled", true);
				if (e.val != "") {
					jQuery("#revista").select2("enable", false);
					setPeridos();
				}else{
					jQuery("#periodos, #chart").hide("slow");
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
				  	jQuery("#chart").show("slow");
				  	console.log(data);
				  	history.pushState(null, data.history.title, data.history.url);
					var chartData = new google.visualization.DataTable(data.data);

					if(chart == null || charType != 'line'){
						charType = 'line';
						chart = new google.visualization.LineChart(document.getElementById('chart'));
					}
					console.log(chart);
					chart.draw(chartData, data.options);
					
				  }
				});
				return false;
			});
		});

		setPeridos = function(){
			jQuery("#periodos").show("slow");
			jQuery.ajax({
				url: '<?php echo site_url("indicadores/getPeriodos");?>',
				type: 'POST',
				dataType: 'json',
				data: jQuery("#generarIndicador").serialize(),
				success: function(data) {
					console.log(data);
					console.log(jQuery.parseJSON(data.scale));
					console.log(jQuery.parseJSON(data.heterogeneity));
					if(data.result){
						jQuery("#sliderPeriodo").prop('disabled', false);
						jQuery("#generate").prop('disabled', false);
						jQuery("#sliderPeriodo").val(data.anioBase + ";" + data.anioFinal);
						jQuery("#sliderPeriodo").slider().destroy();
						jQuery("#sliderPeriodo").slider({
							from: data.anioBase, 
							to: data.anioFinal, 
							heterogeneity: jQuery.parseJSON(data.heterogeneity), 
							scale: jQuery.parseJSON(data.scale),
							format: { format: '####', locale: 'us' }, 
							limits: false, 
							step: 1, 
							dimension: '', 
							//skin: "round_plastic",
							callback: function(value){
								console.log(jQuery("#sliderPeriodo").slider("prc"));
								jQuery("#revista, #pais").select2("close");
								jQuery("#generarIndicador").submit();
							}
						});
						jQuery("#generarIndicador").submit();
					}else{
						jQuery("#sliderPeriodo").prop('disabled', true);
						jQuery("#generate").prop('disabled', true);
						console.log(data.error);
					}
				}
			});
		}
	</script>