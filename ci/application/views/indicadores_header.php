	<link rel="stylesheet" href="<?php echo base_url();?>js/select2/select2.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.slider.min.css" />
	<script src="<?php echo base_url();?>js/select2/select2.js"></script>
	<script src="<?php echo base_url();?>js/jquery.slider.min.js"></script>
	<script src="<?php echo base_url();?>js/jquery.serializeJSON.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"], 'language': 'en'});
		var chart = null;
		var charType = null;
		var indicadorPopState=false;
		var disciplinaPopState=false;
		var revistaPopState=false;
		var paisPopState=false;
		var periodoPopState=false;
		var rangoPeriodo="0-0";
		var paisRevista="";
		var asyncAjax=false;
		var soloDisciplina = ['indice-concentracion', 'modelo-bradford-revista', 'modelo-bradford-institucion', 'productividad-exogena'];
		jQuery(document).ready(function(){
			jQuery("#indicador").select2({
				allowClear: true
			});

			jQuery("#indicador").on("change", function(e){
				value = jQuery(this).val();
				jQuery("#paisRevista, #periodos, #chart").hide("slow");
				jQuery("#disciplina").select2("val", "");
				if (value == "") {
					jQuery("#disciplina, #revista, #pais").select2("enable", false);
					jQuery("#revista, #pais").empty().append('<option></option>');
					jQuery("#revista, #pais").select2("destroy");
				}else if(jQuery.inArray(value, soloDisciplina) > -1){
					jQuery("#revista, #pais").select2("enable", false);
					jQuery("#revista, #pais").empty().append('<option></option>');
					jQuery("#revista, #pais").select2("destroy");
					jQuery("#disciplina").select2("enable", true);
				}else{
					jQuery("#revista, #pais").select2({allowClear: true, closeOnSelect: true});
					jQuery("#disciplina").select2("enable", true);
				}

				if(typeof history.pushState === "function" && !indicadorPopState){
					console.log(jQuery("#generarIndicador").serializeJSON());
					console.log('<?php echo site_url('indicadores')."/"?>' + value);
					history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?php echo site_url('indicadores')."/"?>' + value);
				}
				indicadorPopState=false;
				console.log(e);
			});

			jQuery(window).bind('popstate',  function(event) {
				console.log('pop:');
				updateData(event.originalEvent.state)
				
			});

			jQuery("#disciplina").select2({
				allowClear: true
			});

			jQuery("#disciplina").on("change", function(e){
				value = jQuery(this).val();
				indicadorValue = jQuery("#indicador").val();
				if (value == "") {
					jQuery("#paisRevista, #periodos, #chart").hide("slow");
					jQuery("#revista, #pais").empty().append('<option></option>');
					jQuery("#revista, #pais").select2("destroy");
					jQuery("#revista, #pais").select2({allowClear: true, closeOnSelect: true});
					jQuery("#revista, #pais").select2("enable", false);
				} else if (jQuery.inArray(indicadorValue, soloDisciplina) > -1) {
					
				} else {
					jQuery("#paisRevista").show("slow");
					jQuery.ajax({
						url: '<?php echo site_url("indicadores/getRevistasPaises");?>',
						type: 'POST',
						dataType: 'json',
						data: jQuery("#generarIndicador").serialize(),
						async: asyncAjax,
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
				if(typeof history.pushState === "function" && !disciplinaPopState){
					history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?php echo site_url('indicadores')."/"?>' + indicadorValue + '/disciplina/' + value);
				}
				disciplinaPopState=false;
				console.log(e);
			});

			jQuery("#revista").select2({
				allowClear: true,
				closeOnSelect: true
			});

			jQuery("#revista").on("change", function(e){
				value = jQuery(this).val();
				indicadorValue = jQuery("#indicador").val();
				disciplinaValue = jQuery("#disciplina").val();
				jQuery("#sliderPeriodo").prop("disabled", true);
				if (value != "" && value != null) {
					jQuery("#pais").select2("enable", false);
					setPeridos();
				}else{
					jQuery("#periodos, #chart").hide("slow");
					jQuery("#pais").select2("enable", true);
				}

				if(typeof history.pushState === "function" && !revistaPopState){
					paisRevista="";
					if(value != "" && value != null){
						paisRevista='/revista/' + value.join('/');
					}
					history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?php echo site_url('indicadores')."/"?>' + indicadorValue + '/disciplina/' + disciplinaValue + paisRevista);
				}
				revistaPopState=false;
				console.log(e);
			});

			jQuery("#pais").select2({
				allowClear: true,
				closeOnSelect: true
			});

			jQuery("#pais").on("change", function(e){
				value = jQuery(this).val();
				indicadorValue = jQuery("#indicador").val();
				disciplinaValue = jQuery("#disciplina").val();
				jQuery("#sliderPeriodo").prop("disabled", true);
				if (value != "" && value != null) {
					jQuery("#revista").select2("enable", false);
					setPeridos();
				}else{
					jQuery("#periodos, #chart").hide("slow");
					jQuery("#revista").select2("enable", true);
				}
				if(typeof history.pushState === "function" && !paisPopState){
					paisRevista="";
					if(value != "" && value != null){
						paisRevista='/pais/' + value.join('/');
					}
					history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?php echo site_url('indicadores')."/"?>' + indicadorValue + '/disciplina/' + disciplinaValue + paisRevista);
				}
				paisPopState=false;
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
				  	//history.pushState(jQuery("#generarIndicador").serializeJSON(), data.history.title, data.history.url);
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

			urlData = {
<?php if (preg_match('%indicadores/(.+?)(/.*|$)%', uri_string())):?>
				indicador:"<?php echo preg_replace('%indicadores/(.+?)(/.*|$)%', '\1', uri_string());?>",
<?php endif;?>
<?php if (preg_match('%.*?/disciplina/(.+?)(/.*|$)%', uri_string())):?>
				disciplina:"<?php echo preg_replace('%.*?/disciplina/(.+?)(/.*|$)%', '\1', uri_string());?>",
<?php endif;?>
<?php if (preg_match('%.*?/revista/(.+?)($|/[0-9]{4}-[0-9]{4})%', uri_string())):?>
				revista:"<?php echo preg_replace('%.*?/revista/(.+?)($|/[0-9]{4}-[0-9]{4})%', '\1', uri_string());?>".split('/'),
<?php endif;?>
<?php if (preg_match('%.*?/pais/(.+?)($|/[0-9]{4}-[0-9]{4})%', uri_string())):?>
				pais:"<?php echo preg_replace('%.*?/pais/(.+?)($|/[0-9]{4}-[0-9]{4})%', '\1', uri_string());?>".split('/'),
<?php endif;?>
<?php if (preg_match('%.*?/([0-9]{4})-([0-9]{4})%', uri_string())):?>
				periodo:"<?php echo preg_replace('%.*?/([0-9]{4})-([0-9]{4})%', '\1;\2', uri_string());?>"
<?php endif;?>
			}
<?php if (preg_match('%.*?/revista/(.+?)($|/[0-9]{4}-[0-9]{4})%', uri_string())):?>
				paisRevista="/revista/<?php echo preg_replace('%.*?/revista/(.+?)($|/[0-9]{4}-[0-9]{4})%', '\1', uri_string());?>";
<?php endif;?>
<?php if (preg_match('%.*?/pais/(.+?)($|/[0-9]{4}-[0-9]{4})%', uri_string())):?>
				paisRevista="/pais/<?php echo preg_replace('%.*?/pais/(.+?)($|/[0-9]{4}-[0-9]{4})%', '\1', uri_string());?>";
<?php endif;?>
			updateData(urlData);
			asyncAjax=true;
		});

		setPeridos = function(){
			jQuery("#periodos").slideDown("slow");
			jQuery.ajax({
				url: '<?php echo site_url("indicadores/getPeriodos");?>',
				type: 'POST',
				dataType: 'json',
				data: jQuery("#generarIndicador").serialize(),
				async: asyncAjax,
				success: function(data) {
					console.log(data);
					console.log(jQuery.parseJSON(data.scale));
					console.log(jQuery.parseJSON(data.heterogeneity));
					if(data.result){
						jQuery("#sliderPeriodo").prop('disabled', false);
						jQuery("#generate").prop('disabled', false);
						rangoPeriodo=data.anioBase + ";" + data.anioFinal;
						jQuery("#sliderPeriodo").val(rangoPeriodo);
						jQuery("#sliderPeriodo").data('pre', jQuery("#sliderPeriodo").val());
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
							callback: function(value){
								if(jQuery("#sliderPeriodo").data('pre') != jQuery("#sliderPeriodo").val()){
									jQuery("#sliderPeriodo").data('pre', jQuery("#sliderPeriodo").val());
									rango=jQuery("#sliderPeriodo").val().replace(';', '-');
									if(typeof history.pushState === "function" && !periodoPopState){
										history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?php echo site_url('indicadores')."/"?>' + indicadorValue + '/disciplina/' + disciplinaValue + paisRevista + '/' + rango);
									}
									periodoPopState=false;
									jQuery("#revista, #pais").select2("close");
									jQuery("#generarIndicador").submit();
								}
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
		};

		updateData = function(data){
			console.log(data);
			actualForm = jQuery("#generarIndicador").serializeJSON();
			if(data.indicador != actualForm.indicador){
				indicadorPopState=true;
				jQuery("#indicador").val(data.indicador).trigger("change");
			}
			if(data.disciplina != actualForm.disciplina){
				disciplinaPopState=true;
				jQuery("#disciplina").val(data.disciplina).trigger("change");
			}

			if(!actualForm.revista){
				actualForm.revista = ["revista"];
			}

			if(data.revista === "" || typeof data.revista === "undefined" && typeof data.pais === "undefined"){
				jQuery("#periodos, #chart").hide("slow");
				jQuery("#revista").select2("val", null);
				jQuery('#revista option').first().prop('selected', false);
				jQuery("#revista").select2("destroy");
				jQuery("#revista").select2({allowClear: true, closeOnSelect: true});
				jQuery("#pais").select2("enable", true);
			}
			
			if(data.revista !== "" &&  typeof data.revista !== "undefined" && data.revista.join('/') != actualForm.revista.join('/')){
				revistaPopState=true;
				jQuery("#revista").val(data.revista).trigger("change");
			}

			if(!actualForm.pais){
				actualForm.pais = ["pais"];
			}

			if(data.pais === "" || typeof data.pais === "undefined" && typeof data.revista === "undefined"){
				jQuery("#periodos, #chart").hide("slow");
				jQuery("#pais").select2("val", null);
				jQuery('#pais option').first().prop('selected', false);
				jQuery("#pais").select2("destroy");
				jQuery("#pais").select2({allowClear: true, closeOnSelect: true});
				jQuery("#revista").select2("enable", true);
			}
			if(data.pais !== "" &&  typeof data.pais !== "undefined" && data.pais.join('/') != actualForm.pais.join('/')){
				paisPopState=true;
				jQuery("#pais").val(data.pais).trigger("change");
			}
			console.log("rangoPeriodo: " + rangoPeriodo);
			if(typeof data.periodo === "undefined"){
				data.periodo = rangoPeriodo;
			}
			if(data.periodo != actualForm.periodo){
				jQuery("#sliderPeriodo").slider("value", data.periodo.substring(0, 4), data.periodo.substring(5));
				jQuery("#generarIndicador").submit();
			}
		};
	</script>