
google.load("visualization", "1", {packages:["corechart", "table"], 'language': 'en'});
var chart = {normal: null, bradford:null, group1:null, group2:null, pratt:null, data:null};
chart.data = {normal: null, bradford:null, group1:null, group2:null, pratt:null, prattJ:null};
var tables = {normal: null, bradford:null, group1:null, group2:null, group3:null, pratt:null};
var brfLim = null;
var popState = {indicador:false, disciplina:false, revista:false, paisRevista:false, paisAutor:false, periodo:false};
var rangoPeriodo="0-0";
var dataPeriodo="0-0";
var paisRevistaURL="";
var asyncAjax=false;
var soloDisciplina = ['indice-concentracion', 'modelo-bradford-revista', 'modelo-bradford-institucion', 'productividad-exogena'];
var soloPaisAutor = ['indice-coautoria', 'tasa-documentos-coautorados', 'indice-colaboracion'];
jQuery(document).ready(function(){
	jQuery("#indicador").select2({
		allowClear: true
	});

	jQuery("#indicador").on("change", function(e){
		value = jQuery(this).val();
		jQuery("#paisRevistaDiv, #periodos, #tabs, #chartContainer, #bradfodContainer, #prattContainer").hide("slow");
		jQuery("#disciplina").select2("val", "");
		jQuery("#sliderPeriodo").prop('disabled', true);
		if (value == "") {
			jQuery("#disciplina, #revista, #paisRevista, #paisAutor").select2("enable", false);
			jQuery("#revista, #paisRevista, #paisAutor").empty().append('<option></option>');
			jQuery("#revista, #paisRevista, #paisAutor").select2("destroy");
		}else if(jQuery.inArray(value, soloDisciplina) > -1){
			jQuery("#revista, #paisRevista, #paisAutor").select2("enable", false);
			jQuery("#revista, #paisRevista, #paisAutor").empty().append('<option></option>');
			jQuery("#revista, #paisRevista, #paisAutor").select2("destroy");
			jQuery("#disciplina").select2("enable", true);
			updateInfo(value);
		}else{
			jQuery("#revista, #paisRevista, #paisAutor").select2({allowClear: true, closeOnSelect: true});
			jQuery("#disciplina").select2("enable", true);
			updateInfo(value);
		}

		if(typeof history.pushState === "function" && !popState.indicador){
			history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?=site_url('indicadores')."/"?>' + value);
		}
		popState.indicador=false;
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
		jQuery("#sliderPeriodo").prop('disabled', true);
		if (value == "") {
			jQuery("#paisRevistaDiv, #periodos, #tabs, #chartContainer, #bradfodContainer, #prattContainer").hide("slow");
			jQuery("#revista, #paisRevista, #paisAutor").empty().append('<option></option>');
			jQuery("#revista, #paisRevista, #paisAutor").select2("destroy");
			jQuery("#revista, #paisRevista, #paisAutor").select2({allowClear: true, closeOnSelect: true});
			jQuery("#revista, #paisRevista, #paisAutor").select2("enable", false);
		} else if (jQuery.inArray(indicadorValue, soloDisciplina) > -1) {
			jQuery("#generarIndicador").submit();
		} else {
			if(!loading.status){
				loading.start();
			}
			jQuery("#orPaisRevistaColumn").show();
			jQuery("#paisRevistaDiv").show("slow");
			jQuery("#periodos, #tabs, #chartContainer, #bradfodContainer, #prattContainer").hide("slow");
			jQuery.ajax({
				url: '<?=site_url("indicadores/getRevistasPaises");?>',
				type: 'POST',
				dataType: 'json',
				data: jQuery("#generarIndicador").serialize(),
				async: asyncAjax,
				success: function(data) {
					console.log(data);
					controlsTotal = 0;
					jQuery("#revista, #paisRevista, #paisAutor").empty().append('<option></option>');
					jQuery("#revista").select2("destroy");
					jQuery("#paisRevista").select2("destroy");
					jQuery("#paisAutor").select2("destroy");
					jQuery("#revista, #paisRevista, #paisAutor").hide();
					if(typeof data.revistas !== "undefined"){
						jQuery("#revista").select2({allowClear: true, closeOnSelect: true});
						jQuery("#revista").select2("enable", false);
						jQuery.each(data.revistas, function(key, val) {
							jQuery("#revista").append('<option value="' + val.val +'">' + val.text + '</option>');
						});
						controlsTotal++;
						jQuery("#revista").select2("enable", true);
					}
					if(typeof data.paisesRevistas !== "undefined" && indicadorValue != "indice-densidad-documentos"){
						jQuery("#paisRevista").select2({allowClear: true, closeOnSelect: true});
						jQuery("#paisRevista").select2("enable", false);
						jQuery.each(data.paisesRevistas, function(key, val) {
							jQuery("#paisRevista").append('<option value="' + val.val +'">' + val.text + '</option>');
						});
						controlsTotal++;
						jQuery("#paisRevista").select2("enable", true);
					}
					if(typeof data.paisesAutores !== "undefined" && jQuery.inArray(indicadorValue, soloPaisAutor) > -1){
						jQuery("#paisAutor").select2({allowClear: true, closeOnSelect: true});
						jQuery("#paisAutor").select2("enable", false);
						jQuery.each(data.paisesAutores, function(key, val) {
							jQuery("#paisAutor").append('<option value="' + val.val +'">' + val.text + '</option>');
						});
						controlsTotal++;
						jQuery("#paisAutor").select2("enable", true);
					}
					if(controlsTotal < 2){
						jQuery("#orPaisRevistaColumn").hide();
					}
					if(controlsTotal == 0){
						jQuery.pnotify({
							title: '<?php _e('No se encontraron datos para la disciplina seleccionada');?>',
							icon: true,
							type: 'error',
							addclass: 'errorNotification',
							sticker: false
						});
					}
					loading.end();
				}
			});
		}
		if(typeof history.pushState === "function" && !popState.disciplina){
			disciplina="";
			if(value != "" && value != null){
				disciplina='/disciplina/' + value;
			}
			history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?=site_url('indicadores')."/"?>' + indicadorValue + disciplina);
		}
		popState.disciplina=false;
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
			jQuery("#paisRevista").select2("enable", false);
			jQuery("#paisAutor").select2("enable", false);
			setPeridos();
		}else{
			jQuery("#periodos, #tabs, #chartContainer").hide("slow");
			jQuery("#paisRevista").select2("enable", true);
			jQuery("#paisAutor").select2("enable", true);
		}

		if(typeof history.pushState === "function" && !popState.revista){
			paisRevistaURL="";
			if(value != "" && value != null){
				paisRevistaURL='/revista/' + value.join('/');
			}
			history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?=site_url('indicadores')."/"?>' + indicadorValue + '/disciplina/' + disciplinaValue + paisRevistaURL);
		}
		popState.revista=false;
		console.log(e);
	});

	jQuery("#paisRevista").select2({
		allowClear: true,
		closeOnSelect: true
	});

	jQuery("#paisRevista").on("change", function(e){
		value = jQuery(this).val();
		indicadorValue = jQuery("#indicador").val();
		disciplinaValue = jQuery("#disciplina").val();
		jQuery("#sliderPeriodo").prop("disabled", true);
		if (value != "" && value != null) {
			jQuery("#revista").select2("enable", false);
			jQuery("#paisAutor").select2("enable", false);
			setPeridos();
		}else{
			jQuery("#periodos, #tabs, #chartContainer").hide("slow");
			jQuery("#revista").select2("enable", true);
			jQuery("#paisAutor").select2("enable", true);
		}
		if(typeof history.pushState === "function" && !popState.paisRevista){
			paisRevistaURL="";
			if(value != "" && value != null){
				paisRevistaURL='/pais-revista/' + value.join('/');
			}
			console.log('pushState');
			console.log(paisRevistaURL);
			history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?=site_url('indicadores')."/"?>' + indicadorValue + '/disciplina/' + disciplinaValue + paisRevistaURL);
		}
		popState.paisRevista=false;
		console.log(e);
	});
	
	jQuery("#paisAutor").select2({
		allowClear: true,
		closeOnSelect: true
	});

	jQuery("#paisAutor").on("change", function(e){
		value = jQuery(this).val();
		indicadorValue = jQuery("#indicador").val();
		disciplinaValue = jQuery("#disciplina").val();
		jQuery("#sliderPeriodo").prop("disabled", true);
		if (value != "" && value != null) {
			jQuery("#revista").select2("enable", false);
			jQuery("#paisRevista").select2("enable", false);
			setPeridos();
		}else{
			jQuery("#periodos, #tabs, #chartContainer").hide("slow");
			jQuery("#revista").select2("enable", true);
			jQuery("#paisRevista").select2("enable", true);
		}
		if(typeof history.pushState === "function" && !popState.paisAutor){
			paisRevistaURL="";
			if(value != "" && value != null){
				paisRevistaURL='/pais-autor/' + value.join('/');
			}
			history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?=site_url('indicadores')."/"?>' + indicadorValue + '/disciplina/' + disciplinaValue + paisRevistaURL);
		}
		popState.paisAutor=false;
		console.log(e);
	});

	jQuery("#sliderPeriodo").jslider();

	jQuery("#prattSlide").anythingSlider({
				theme: 'scielo',
				mode: 'fade',
				expand: true,
				easing: "linear",
				buildNavigation: true,
				buildStartStop: false,
				hashTags: false,
				animationTime: 1200,
				navigationFormatter : function(index, panel){
					return "<?php _e('Gráfica ')?>" + index;
				}
			});
	jQuery("#bradfordSlide").anythingSlider({
				theme: 'scielo',
				mode: 'fade',
				expand: true,
				easing: "linear",
				buildNavigation: true,
				buildStartStop: false,
				hashTags: false,
				animationTime: 1200,
				navigationFormatter : function(index, panel){
					return ['<?php _e("Modelo matemático de Bradford")?>', '<?php _e("Zona núcleo de revistas más productivas")?>', '<?php _e("Zona 2 de revistas más productivas")?>'][index - 1];
				}
			});
	jQuery("#tabs").tabs({ 
		show: { effect: "fade", duration: 800 },
		activate: function(){
			if(jQuery("#tabs").tabs("option", "active") != 1){
				if(jQuery("#indicador").val() == "modelo-bradford-revista" || jQuery("#indicador").val() == "modelo-bradford-institucion"){
					jQuery("#gridContainer").accordion("option", "active", false);
				}
			}
			jQuery('html, body').animate({
				scrollTop: jQuery("#tabs").offset().top
			}, 700);
		}
	});

	jQuery("#gridContainer").accordion({
		heightStyle: "content",
		collapsible: true,
		active: false,
		activate: function( event, ui ) {
			jQuery('html, body').animate({
				scrollTop: jQuery("#tabs").offset().top
			}, 700);
		}
	});
	
	jQuery("#generarIndicador").on("submit", function(e){
		console.log(e);
		if(!loading.status){
			loading.start();
		}
		indicadorValue = jQuery("#indicador").val();
		urlRequest = '<?=site_url("indicadores/getChartData");?>';
		switch(indicadorValue){
			case "modelo-bradford-revista":
			case "modelo-bradford-institucion":
				urlRequest = '<?=site_url("indicadores/getChartDataBradford");?>';
				break;
			case "indice-concentracion":
			case "productividad-exogena":
				urlRequest = '<?=site_url("indicadores/getChartDataPrattExogena");?>';
				break;
		}
		jQuery.ajax({
		  url: urlRequest,
		  type: 'POST',
		  dataType: 'json',
		  data: jQuery(this).serialize(),
		  success: function(data) {
		  	console.log(data);
		  	jQuery("#tabs").tabs("option", "active", 0);
			switch(indicadorValue){
				case "modelo-bradford-revista":
				case "modelo-bradford-institucion":
					//jQuery("#gridContainer").accordion("destroy");
					jQuery("#bradfordSlide").anythingSlider(1);
					jQuery("#tabs, #bradfodContainer").slideDown("slow");
					brfLim = data.grupos;
					chart.data.bradford = new google.visualization.DataTable(data.chart.bradford);
					if(chart.bradford == null){
						chart.bradford = new google.visualization.ComboChart(document.getElementById('chartBradford'));
					}
					chart.bradford.draw(chart.data.bradford, data.options.bradford);
					google.visualization.events.addListener(chart.bradford, 'select', chooseZone);

					jQuery("#bradfordTitle").html(data.title.bradford);

					chart.data.group1 = new google.visualization.DataTable(data.chart.group1);
					if(chart.group1 == null){
						chart.group1 = new google.visualization.ColumnChart(document.getElementById('chartGroup1'));
					}
					chart.group1.draw(chart.data.group1, data.options.groups);
					google.visualization.events.addListener(chart.group1, 'select', function(){bradfordArticles('group1')});
					jQuery("#group1Title").html(data.title.group1);

					chart.data.group2 = new google.visualization.DataTable(data.chart.group2);
					if(chart.group2 == null){
						chart.group2 = new google.visualization.ColumnChart(document.getElementById('chartGroup2'));
					}
					chart.group2.draw(chart.data.group2, data.options.groups);
					google.visualization.events.addListener(chart.group2, 'select', function(){bradfordArticles('group2')});
					jQuery("#group2Title").html(data.title.group2);
					var tableData = new google.visualization.DataTable(data.table.bradford);
					jQuery("#gridContainer").empty();
					jQuery("#gridContainer").append(data.table.title.bradford);
					jQuery("#gridContainer").append('<div class="dataTable" id="table0"></div>');
					tables.bradford = new google.visualization.Table(document.getElementById('table0'));
					tables.bradford.draw(tableData, data.tableOptions);

					var tableData = new google.visualization.DataTable(data.table.group1);
					jQuery("#gridContainer").append(data.table.title.group1);
					jQuery("#gridContainer").append('<div class="dataTable groupTable" id="table1"></div>');
					tables.group1 = new google.visualization.Table(document.getElementById('table1'));
					tables.group1.draw(tableData, data.tblGrpOpt);

					var tableData = new google.visualization.DataTable(data.table.group2);
					jQuery("#gridContainer").append(data.table.title.group2);
					jQuery("#gridContainer").append('<div class="dataTable groupTable" id="table2"></div>');
					tables.group2 = new google.visualization.Table(document.getElementById('table2'));
					tables.group2.draw(tableData, data.tblGrpOpt);

					var tableData = new google.visualization.DataTable(data.table.group3);
					jQuery("#gridContainer").append(data.table.title.group3);
					jQuery("#gridContainer").append('<div class="dataTable groupTable" id="table3"></div>');
					tables.group3 = new google.visualization.Table(document.getElementById('table3'));
					tables.group3.draw(tableData, data.tblGrpOpt);

					jQuery("#gridContainer").accordion( "refresh" );
					break;
				case "indice-concentracion":
				case "productividad-exogena":
					jQuery("#tabs, #prattContainer").slideDown("slow");
					jQuery("#prattSlide").empty();
					chart.pratt = new Array();
					chart.data.pratt = new Array();
					chart.data.prattJ = data.journal; 
					jQuery.each(data.chart, function(key, grupo) {
						jQuery("#prattSlide").append('<li>' + data.chartTitle + ' <div id="chartPratt' + key +'"></div></li>').anythingSlider();
						chart.data.pratt[key] = new google.visualization.DataTable(grupo);
						chart.pratt[key] = new google.visualization.ColumnChart(document.getElementById('chartPratt' + key));
						chart.pratt[key].draw(chart.data.pratt[key], data.options);
						google.visualization.events.addListener(chart.pratt[key], 'select', function(){getFrecuencias(key)});
					});

					var tableData = new google.visualization.DataTable(data.table);
					jQuery("#gridContainer").empty();
					jQuery("#gridContainer").append(data.tableTitle);
					jQuery("#gridContainer").append('<div class="dataTable" id="table0"></div>');
					tables.pratt = new google.visualization.Table(document.getElementById('table0'));
					tables.pratt.draw(tableData, data.tableOptions);
					console.log(chart);	
					break;
				default:
					jQuery("#tabs, #chartContainer").show("slow");
					chart.data.normal = new google.visualization.DataTable(data.data);
					if(chart.normal == null){
						chart.normal = new google.visualization.LineChart(document.getElementById('chart'));
					}
					chart.normal.draw(chart.data.normal, data.options);
					google.visualization.events.addListener(chart.normal, 'select', choosePoint);
					jQuery("#chartTitle").html(data.chartTitle);

					var tableData = new google.visualization.DataTable(data.dataTable);
					jQuery("#gridContainer").empty();
					jQuery("#gridContainer").append(data.tableTitle);
					jQuery("#gridContainer").append('<div class="dataTable" id="table0"></div>');
					tables.normal = new google.visualization.Table(document.getElementById('table0'));
					tables.normal.draw(tableData, data.tableOptions);
					

					break;
			}
			loading.end();
		  }
		});
		return false;
	});
<?php if (preg_match('%indicadores/(...+?)%', uri_string())):?>
	urlData = {
<?php 	if (preg_match('%indicadores/(.+?)(/.*|$)%', uri_string())):?>
		indicador:"<?=preg_replace('%.+?/indicadores/(.+?)(/.*|$)%', '\1', uri_string());?>",
<?php 	endif;?>
<?php 	if (preg_match('%.*?/disciplina/(.+?)(/.*|$)%', uri_string())):?>
		disciplina:"<?=preg_replace('%.*?/disciplina/(.+?)(/.*|$)%', '\1', uri_string());?>",
<?php 	endif;?>
<?php 	if (preg_match('%.*?/revista/(.+?)($|/[0-9]{4}-[0-9]{4})%', uri_string())):?>
		revista:"<?=preg_replace('%.*?/revista/(.+?)($|/[0-9]{4}-[0-9]{4})%', '\1', uri_string());?>".split('/'),
<?php 	endif;?>
<?php 	if (preg_match('%.*?/pais-revista/(.+?)($|/[0-9]{4}-[0-9]{4})%', uri_string())):?>
		paisRevista:"<?=preg_replace('%.*?/pais-revista/(.+?)($|/[0-9]{4}-[0-9]{4})%', '\1', uri_string());?>".split('/'),
<?php 	endif;?>
<?php 	if (preg_match('%.*?/pais-autor/(.+?)($|/[0-9]{4}-[0-9]{4})%', uri_string())):?>
		paisAutor:"<?=preg_replace('%.*?/pais-autor/(.+?)($|/[0-9]{4}-[0-9]{4})%', '\1', uri_string());?>".split('/'),
<?php 	endif;?>
<?php 	if (preg_match('%.*?/([0-9]{4})-([0-9]{4})%', uri_string())):?>
		periodo:"<?=preg_replace('%.*?/([0-9]{4})-([0-9]{4})%', '\1;\2', uri_string());?>"
<?php 	endif;?>
	}
<?php 	if (preg_match('%.*?/revista/(.+?)($|/[0-9]{4}-[0-9]{4})%', uri_string())):?>
	paisRevistaURL="/revista/<?=preg_replace('%.*?/revista/(.+?)($|/[0-9]{4}-[0-9]{4})%', '\1', uri_string());?>";
<?php 	endif;?>
<?php 	if (preg_match('%.*?/pais/(.+?)($|/[0-9]{4}-[0-9]{4})%', uri_string())):?>
	paisRevistaURL="/pais/<?=preg_replace('%.*?/pais/(.+?)($|/[0-9]{4}-[0-9]{4})%', '\1', uri_string());?>";
<?php 	endif;?>
	if(typeof urlData.indicador !== "undefined"){
		updateData(urlData);
	}
	delete urlData;
<?php endif;?>
	if(typeof history.replaceState === "function"){
		history.replaceState(jQuery("#generarIndicador").serializeJSON(), null);
	}
});

setPeridos = function(){
	if(!loading.status){
		loading.start();
	}
	jQuery("#periodos").slideDown("slow");
	jQuery.ajax({
		url: '<?=site_url("indicadores/getPeriodos");?>',
		type: 'POST',
		dataType: 'json',
		data: jQuery("#generarIndicador").serialize(),
		async: asyncAjax,
		success: function(data) {
			console.log(data);
			console.log(jQuery.parseJSON(data.scale));
			console.log(jQuery.parseJSON(data.heterogeneity));
			if(data.result){
				jQuery("#sliderPeriodo").jslider().destroy();
				jQuery("#sliderPeriodo").prop('disabled', false);
				jQuery("#generate").prop('disabled', false);
				rangoPeriodo=data.anioBase + ";" + data.anioFinal;
				jQuery("#sliderPeriodo").val(rangoPeriodo);
				jQuery("#sliderPeriodo").data('pre', jQuery("#sliderPeriodo").val());
				jQuery("#sliderPeriodo").jslider({
					from: data.anioBase, 
					to: data.anioFinal, 
					heterogeneity: jQuery.parseJSON(data.heterogeneity), 
					scale: jQuery.parseJSON(data.scale),
					format: { format: '####', locale: 'us' }, 
					limits: false, 
					step: 1, 
					callback: function(value){
						if(jQuery("#sliderPeriodo").data('pre') != value){
							jQuery("#sliderPeriodo").data('pre', value);
							rango=value.replace(';', '-');
							if(typeof history.pushState === "function"){
								history.pushState(jQuery("#generarIndicador").serializeJSON(), null, '<?=site_url('indicadores')."/"?>' + indicadorValue + '/disciplina/' + disciplinaValue + paisRevistaURL + '/' + rango);
							}
							jQuery("#revista, #paisRevista").select2("close");
							jQuery("#generarIndicador").submit();
						}
					}
				});
				if(!popState.periodo){
					jQuery("#generarIndicador").submit();
				}
				popState.periodo=false;
			}else{
				jQuery("#sliderPeriodo").prop('disabled', true);
				jQuery("#generate").prop('disabled', true);
				console.log(data.error);
			}
			//loading.end();
		}
	});
};

updateInfo = function(indicador){
	jQuery("#info").children(".infoBox").hide();
	jQuery("#info-" + indicador).show();
}

updateData = function(data){
	console.log(data);
	asyncAjax=false;
	actualForm = jQuery("#generarIndicador").serializeJSON();
	if(typeof data.periodo !== "undefined"){
		popState.periodo = true;
	}
	if(typeof data.indicador !== "undefined"){
		updateInfo(data.indicador);
	}
	if(typeof data.indicador !== "undefined"){
		popState.indicador=true;
		jQuery("#indicador").val(data.indicador).trigger("change");
		actualForm = jQuery("#generarIndicador").serializeJSON();
	}
	if(typeof data.disciplina !== "undefined"){
		popState.disciplina=true;
		jQuery("#disciplina").val(data.disciplina).trigger("change");
		actualForm = jQuery("#generarIndicador").serializeJSON();
	}

	if(!actualForm.revista){
		actualForm.revista = ["revista"];
	}
	if(data.revista === "" || typeof data.revista === "undefined" && typeof data.pais === "undefined"){
		jQuery("#periodos, #tabs, #chartContainer, #bradfodContainer, #prattContainer").hide("slow");
		jQuery("#revista").select2("val", null);
		jQuery('#revista option').first().prop('selected', false);
		jQuery("#revista").select2("destroy");
		jQuery("#revista").select2({allowClear: true, closeOnSelect: true});
		jQuery("#paisRevista").select2("enable", true);
	}
	
	if(data.revista !== "" && typeof data.revista !== "undefined" && data.revista.join('/') != actualForm.revista.join('/')){
		popState.revista=true;
		jQuery("#revista").val(data.revista).trigger("change");
		actualForm = jQuery("#generarIndicador").serializeJSON();
	}

	if(!actualForm.paisRevista){
		actualForm.paisRevista = ["pais"];
	}

	if(data.paisRevista !== "" &&  typeof data.paisRevista !== "undefined" && data.paisRevista.join('/') != actualForm.paisRevista.join('/')){
		popState.paisRevista=true;
		jQuery("#paisRevista").val(data.paisRevista).trigger("change");
		actualForm = jQuery("#generarIndicador").serializeJSON();
	}

	if(!actualForm.paisAutor){
		actualForm.paisAutor = ["pais"];
	}

	if(data.paisAutor !== "" &&  typeof data.paisAutor !== "undefined" && data.paisAutor.join('/') != actualForm.paisAutor.join('/')){
		popState.paisAutor=true;
		jQuery("#paisAutor").val(data.paisAutor).trigger("change");
		actualForm = jQuery("#generarIndicador").serializeJSON();
	}
	if(typeof data.periodo !== "undefined"){
		jQuery("#sliderPeriodo").prop("disabled", false);
		jQuery("#sliderPeriodo").jslider("value", data.periodo.substring(0, 4), data.periodo.substring(5));
		jQuery("#generarIndicador").submit();
	}
	asyncAjax=true;
};

chooseZone = function () {
	var selection = chart.bradford.getSelection();
	if (selection[0] != null && selection[0].row != null){
		var value = chart.data.bradford.getFormattedValue(selection[0].row, 0);
		if (value <= brfLim[1].lim.x){
			jQuery("#bradfordSlide").anythingSlider(2);
		}
		else if (value > brfLim[1].lim.x && value <= brfLim[2].lim.x) {
			jQuery("#bradfordSlide").anythingSlider(3);
		}else{
			jQuery("#tabs").tabs("option", "active", 1);
			jQuery("#gridContainer").accordion("option", "active", 3);
		}
	}
}

choosePoint = function () {
	var selection = chart.normal.getSelection()[0];
	indicadorValue = jQuery("#indicador").val();
	if (selection && indicadorValue == "modelo-elitismo"){
		var revistaPais = chart.data.normal.getColumnId(selection.column);
		var anio = chart.data.normal.getFormattedValue(selection.row, 0);
		console.log(anio);
		jQuery.ajax({
			url: '<?=site_url("indicadores/getAutoresPrice");?>/'+ revistaPais + '/' + anio,
			type: 'POST',
			dataType: 'json',
			data: jQuery("#generarIndicador").serialize(),
			success: function(data){
				console.log(data);
				var tableData = new google.visualization.DataTable(data.table);
				var table = new google.visualization.Table(document.getElementById('floatTable'));
				table.draw(tableData, data.tableOptions);
				jQuery.colorbox({inline: true, href: jQuery('#floatTable'), height:"90%",});
			}
		});
	}
}

bradfordArticles = function (group) {
	var selection = chart[group].getSelection()[0];
	indicadorValue = jQuery("#indicador").val();
	if (selection && indicadorValue == "modelo-bradford-revista"){
		var revista = chart.data[group].getColumnId(selection.column);
		jQuery.colorbox({href:"<?=site_url("indicadores/bradfordDocumentos");?>/" + revista + "/ajax", data: {ajax:true}, transition:"fade", height:"90%", width: "1000px", iframe: true});
	}
}

getFrecuencias = function (key) {
	var selection = chart.pratt[key].getSelection();
	if (selection[0] != null && selection[0].column != null){
		disciplina=jQuery('#disciplina').val();
		revista=chart.data.prattJ[key][(selection[0].column+1)/2 -1];
		jQuery.ajax({
			url: '<?=site_url("indicadores/getFrecuencias");?>/'+ revista,
			type: 'POST',
			dataType: 'json',
			data: jQuery("#generarIndicador").serialize(),
			success: function(data){
				console.log(data);
				var tableData = new google.visualization.DataTable(data.table);
				var table = new google.visualization.Table(document.getElementById('floatTable'));
				table.draw(tableData, data.tableOptions);
				jQuery.colorbox({inline: true, href: jQuery('#floatTable'), height:"90%",});
			}
		});
		
		console.log(revista);
	}
}
