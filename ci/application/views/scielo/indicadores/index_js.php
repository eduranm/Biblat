{literal}
google.load("visualization", "1.1", {packages:['corechart', 'table', 'bar', 'line'], 'language': 'en'});
var indicador = null;
var realIndicator = null;
var coleccion = null;
var area = null;
var chart = {normal: null, bradford:null, group1:null, group2:null, pratt:null, data:null};
chart.data = {normal: null, bradford:null, group1:null, group2:null, pratt:null, prattJ:null};
var tables = {normal: null, bradford:null, group1:null, group2:null, group3:null, pratt:null};
var brfLim = null;
var popState = {indicador:false, coleccion:false, revista:false, paisRevista:false, paisAutor:false, periodo:false, area:false};
var rangoPeriodo="0-0";
var dataPeriodo="0-0";
var coleccionURL="";
var areaURL="";
var revistaURL="";
var paisAutorURL="";
var paisRevistaURL="";
var asyncAjax=false;
var urlData = null;
$(document).ready(function(){
	$(window).bind('popstate',  function(event) {
		console.log('pop:');
		updateData(event.originalEvent.state)	
	});

	$('.carousel').carousel({
	  interval: false
	})
	$("#indicador, #coleccion, #area, #revista, #paisRevista, #paisAutor").select2({
		allowClear: true,
		closeOnSelect: true
	});

	$("#indicador").on("change", function(e){
		console.log('indicador change');
		indicador = $(this).val();
		$('#coleccion, #area, #revista, #paisRevista, #paisAutor').parent().hide();
		$("#periodos, #tabs, #chartContainer, #bradfodContainer, #prattContainer").hide("slow");
		$("#coleccion").select2("val", "");
		$("#sliderPeriodo").prop('disabled', true);
		switch (indicador){
			case 'distribucion-articulos-coleccion':
				realIndicator = indicador;
				updateInfo();
				$("#coleccion").select2("enable", true).parent().show();
				if(urlData == null || typeof urlData.coleccion === "undefined")
					setPeriodos();
				break;
			default:
				$("#coleccion, #area, #revista, #paisRevista, #paisAutor").select2("enable", false);
				$("#revista, #paisRevista, #paisAutor").empty().append('<option></option>').select2("destroy");
				break;
		}

		if(typeof history.pushState === "function" && !popState.indicador){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + indicador);
		}
		popState.indicador=false;
		console.log(e);
	});

	$("#coleccion").on("change", function(e){
		console.log('coleccion change');
		coleccion = $(this).val();
		console.log(coleccion);
		coleccionURL = "";
		if(coleccion != "" && coleccion != null){
			coleccionURL='/coleccion/' + coleccion.join('/');
		}
		if(typeof history.pushState === "function" && !popState.coleccion){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + indicador + coleccionURL);
		}
		$("#chartContainer, #bradfodContainer, #prattContainer").hide();
		switch (indicador){
			case 'distribucion-articulos-coleccion':
				realIndicator = indicador;
				$('#tabs, #prattContainer').show();
				if(coleccion != "" && coleccion != null){
					$('#area, #revista, #paisAutor').parent().show();
					$("#area, #revista, #paisAutor").select2("enable", true);
					$.ajax({
						url: '<?=site_url("scielo/indicadores/getOptionData");?>',
						type: 'POST',
						dataType: 'json',
						data: getSerializedForm(),
						async: false,
						success: function(data) {
							console.log(data);
							$("#revista, #paisAutor").empty()
							.append('<option></option>')
							.select2("destroy")
							$("#revista, #paisAutor").parent().hide();
							if(typeof data.revistas !== "undefined"){
								$.each(data.revistas, function(key, revista) {
									optgroup = $('<optgroup label="'+key+'"></optgroup>');
									$.each(revista, function(k, v){
										optgroup.append('<option value="' + k +'">' + v + '</option>');
									});
									$("#revista").append(optgroup);
								});
								if(revista != null && revista != '')
									$("#revista").val(revista);
								$("#revista").show().select2({allowClear: true, closeOnSelect: true}).select2("enable", false);
								$("#revista").select2("enable", true).parent().show();
							}
							if(typeof data.paises !== "undefined"){
								$.each(data.paises, function(k, v) {
									$("#paisAutor").append('<option value="' + k +'">' + v + '</option>');
								});
								if(paisAutor != null && paisAutor != '')
									$("#paisAutor").val(paisAutor);
								$("#paisAutor").show().select2({allowClear: true, closeOnSelect: true}).select2("enable", false);
								$("#paisAutor").select2("enable", true).parent().show();
							}
						}
					});
				}
				if((urlData == null || (typeof urlData.area === "undefined" && typeof urlData.revista === "undefined" && typeof urlData.paisAutor === "undefined")) && (area === "" || area == null) && (revista === "" || revista == null) && (paisAutor === "" || paisAutor == null)){
					setPeriodos();
				}
				if (coleccion === "" || coleccion == null) {
					$('#area, #revista, #paisRevista, #paisAutor').parent().hide();
					$("#revista, #paisRevista, #paisAutor")
					.empty()
					.append('<option></option>')
					.select2("destroy")
					.select2({allowClear: true, closeOnSelect: true});
					$("#area, #revista, #paisRevista, #paisAutor").select2("enable", false);
				}
				if(area !== "" && area != null){
					$('#area').trigger('change');
				}
				if(revista !== "" && revista != null){
					$('#revista').trigger('change');
				}
				if(paisAutor !== "" && paisAutor != null){
					$('#paisAutor').trigger('change');
				}
			default:
				break;
		}
		popState.coleccion=false;
		console.log(e);
	});

	$('#area').on('change', function(e){
		console.log('area change');
		area = $(this).val();
		areaURL="";
		if(area != "" && area != null){
			areaURL='/area/' + area.join('/');
		}
		if(typeof history.pushState === "function" && !popState.area){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + indicador + coleccionURL + areaURL);
		}
		$("#chartContainer, #bradfodContainer, #prattContainer").hide();
		switch (realIndicator){
			case 'distribucion-articulos-coleccion':
			case 'distribucion-articulos-coleccion-area':
				$('#tabs, #chartContainer').show();
				if(area != "" && area != null){
					$('#paisAutor').select2("enable", false).parent().hide();
					realIndicator = 'distribucion-articulos-coleccion-area';
					$.ajax({
						url: '<?=site_url("scielo/indicadores/getOptionData");?>',
						type: 'POST',
						dataType: 'json',
						data: getSerializedForm(),
						async: false,
						success: function(data) {
							console.log(data);
							$("#revista").empty()
							.append('<option></option>')
							.select2("destroy").parent().hide();
							if(typeof data.revistas !== "undefined"){
								$.each(data.revistas, function(key, area) {
									optgroup = $('<optgroup label="'+key+'"></optgroup>');
									$.each(area, function(key2, revista){
										optgroup2 = $('<optgroup label="'+key2+'"></optgroup>');
										$.each(revista, function(k, v){
											optgroup2.append('<option value="' + k +'">' + v + '</option>');
										});
										optgroup.append(optgroup2);
									});
									$("#revista").append(optgroup);
								});
								if(revista != null && revista != '')
									$("#revista").val(revista);
								$("#revista").show().select2({allowClear: true, closeOnSelect: true}).select2("enable", true)
								.parent().show();
							}
						}
					});
					updateInfo();
					if(urlData == null || typeof urlData.revista === "undefined")
						setPeriodos();
					break;
				}else if(!popState.coleccion){
					$('#area, #revista, #paisAutor').parent().show();
					$("#area, #revista, #paisAutor").select2("enable", true);
					$('#coleccion').trigger('change');
				}
			default:
				break;
		}
		popState.area=false;
		console.log(e);
	});

	$("#revista").on("change", function(e){
		console.log('revista change');
		revista = $(this).val();
		revistaURL="";
		if(revista != "" && revista != null){
			revistaURL='/revista/' + revista.join('/');
		}
		if(typeof history.pushState === "function" && !popState.revista){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + indicador + coleccionURL + areaURL + revistaURL);
		}
		$("#chartContainer, #bradfodContainer, #prattContainer").hide();
		switch (realIndicator){
			case 'distribucion-articulos-coleccion':
			case 'distribucion-articulos-coleccion-revista':
				$('#tabs, #chartContainer').show();
				if(revista != "" && revista != null){
					$('#area, #paisAutor').parent().hide();
					$("#area, #paisAutor").select2("enable", false);
					realIndicator = 'distribucion-articulos-coleccion-revista';
					updateInfo();
					setPeriodos();
				}else if(!popState.coleccion){
					$('#area, #revista, #paisAutor').parent().show();
					$("#area, #revista, #paisAutor").select2("enable", true);
					$('#coleccion').trigger('change');
				}
				break;
			case 'distribucion-articulos-coleccion-area':
			case 'distribucion-articulos-coleccion-area-revista':
				$('#tabs, #chartContainer').show();
				if(revista != "" && revista != null){
					$('#paisAutor').select2("enable", false)
					.parent().hide();
					realIndicator = 'distribucion-articulos-coleccion-area-revista';
					updateInfo();
					setPeriodos();
				}else if(!popState.coleccion){
					realIndicator = 'distribucion-articulos-coleccion-area';
					$('#area').trigger('change');
				}
				break;
			default:
				break;
		}
		popState.revista=false;
		console.log(e);
	});

	$("#paisAutor").on("change", function(e){
		console.log('paisAutor change');
		paisAutor = $(this).val();
		paisAutorURL="";
		if(paisAutor != "" && paisAutor != null){
			paisAutorURL='/pais-autor/' + paisAutor.join('/');
		}
		if(typeof history.pushState === "function" && !popState.paisAutor){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + indicador + coleccionURL + paisAutorURL);
		}
		$("#chartContainer, #bradfodContainer, #prattContainer").hide();
		switch (indicador){
			case 'distribucion-articulos-coleccion':
				$('#tabs, #chartContainer').show();
				if(paisAutor != "" && paisAutor != null){
					$('#revista, #area').parent().hide();
					$("#revista, #area").select2("enable", false);
					realIndicator = 'distribucion-articulos-coleccion-afiliacion';
					updateInfo();
					setPeriodos();
				}else if(!popState.coleccion){
					$('#area, #revista, #paisAutor').parent().show();
					$("#area, #revista, #paisAutor").select2("enable", true);
					$('#coleccion').trigger('change');
				}
			default:
				break;
		}
		popState.paisAutor=false;
		console.log(e);
	});

	$("#paisRevista").on("change", function(e){
		value = $(this).val();
		indicadorValue = $("#indicador").val();
		coleccionValue = $("#coleccion").val();
		$("#sliderPeriodo").prop("disabled", true);
		if (value != "" && value != null) {
			$("#revista").select2("enable", false);
			$("#paisAutor").select2("enable", false);
			setPeriodos();
		}else{
			$("#periodos, #tabs, #chartContainer").hide("slow");
			$("#revista").select2("enable", true);
			$("#paisAutor").select2("enable", true);
		}
		if(typeof history.pushState === "function" && !popState.paisRevista){
			paisRevistaURL="";
			if(value != "" && value != null){
				paisRevistaURL='/pais-revista/' + value.join('/');
			}
			console.log('pushState');
			console.log(paisRevistaURL);
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + indicadorValue + '/coleccion/' + coleccionValue + paisRevistaURL);
		}
		popState.paisRevista=false;
		console.log(e);
	});

	$("#sliderPeriodo").jslider();

	$("#tabs").tabs({ 
		show: { effect: "fade", duration: 800 },
		activate: function(){
			if($("#tabs").tabs("option", "active") != 1){
				if($("#indicador").val() == "modelo-bradford-revista" || $("#indicador").val() == "modelo-bradford-institucion"){
					$("#gridContainer").accordion("option", "active", false);
				}
			}
			$('html, body').animate({
				scrollTop: $("#tabs").offset().top
			}, 700);
		}
	});

	$("#gridContainer").accordion({
		heightStyle: "content",
		collapsible: true,
		active: false,
		activate: function( event, ui ) {
			$('html, body').animate({
				scrollTop: $("#tabs").offset().top
			}, 700);
		}
	});

	$("#generarIndicador").on("submit", function(e){
		console.log(e);
		loading.start();
		urlRequest = '<?=site_url("scielo/indicadores/getChartData");?>';
		jQuery.ajax({
		  url: urlRequest,
		  type: 'POST',
		  dataType: 'json',
		  data: getSerializedForm(),
		  success: function(data) {
		  	console.log(data);
		  	$("#tabs").tabs("option", "active", 0);
			switch(realIndicator){
				case "distribucion-articulos-coleccion":
					$("#tabs, #prattContainer").slideDown("slow");
					$("#prattSlide").empty();
					chart.pratt = new Array();
					chart.data.pratt = new Array();
					chart.data.prattJ = data.journal;
					$("#carousel-pratt .carousel-indicators, #carousel-pratt .carousel-inner").empty();
					jQuery.each(data.chart, function(key, grupo) {
						if(key == 0){
							$("#carousel-pratt .carousel-indicators").append('<li data-target="#carousel-pratt" data-slide-to="' + key + '" class="active"></li>');
						}else{
							$("#carousel-pratt .carousel-indicators").append('<li id="chartLi' + key + '" data-target="#carousel-pratt" data-slide-to="' + key + '"></li>');
						}
						$("#carousel-pratt .carousel-inner").append('<div id="chartParent' + key + '" class="item active">' + data.chartTitle + ' <div id="chartPratt' + key +'" class="chart_data"></div></div>');
						chart.data.pratt[key] = new google.visualization.DataTable(grupo);
						chart.pratt[key] = new google.charts.Bar(document.getElementById('chartPratt' + key));
						chart.pratt[key].draw(chart.data.pratt[key], google.charts.Bar.convertOptions(data.options));
						if(key > 0){
							google.visualization.events.addListener(chart.pratt[key], 'ready', function(){
								$('#chartParent' + key).removeClass("active");
							});
						}
					});
					$("#carousel-pratt").carousel(0);
					var tableData = new google.visualization.DataTable(data.table);
					$("#gridContainer").empty();
					$("#gridContainer").append(data.tableTitle);
					$("#gridContainer").append('<div id="table0"></div>');
					tables.pratt = new google.visualization.Table(document.getElementById('table0'));
					tables.pratt.draw(tableData, data.tableOptions);
					changeTableClass();
					google.visualization.events.addListener(tables.pratt , 'sort', changeTableClass);
					console.log(chart);	
					break;
				case "modelo-bradford-revista":
				case "modelo-bradford-institucion":
					//$("#gridContainer").accordion("destroy");
					$("#tabs, #bradfodContainer").slideDown("slow");
					brfLim = data.grupos;
					chart.data.bradford = new google.visualization.DataTable(data.chart.bradford);
					if(chart.bradford == null){
						chart.bradford = new google.visualization.ComboChart(document.getElementById('chartBradford'));
					}
					chart.bradford.draw(chart.data.bradford, data.options.bradford);
					google.visualization.events.addListener(chart.bradford, 'select', chooseZone);

					$("#bradfordTitle").html(data.title.bradford);

					chart.data.group1 = new google.visualization.DataTable(data.chart.group1);
					if(chart.group1 == null){
						chart.group1 = new google.visualization.ColumnChart(document.getElementById('chartGroup1'));
					}
					chart.group1.draw(chart.data.group1, data.options.groups);
					google.visualization.events.addListener(chart.group1, 'select', function(){bradfordArticles('group1')});
					$("#group1Title").html(data.title.group1);

					chart.data.group2 = new google.visualization.DataTable(data.chart.group2);
					if(chart.group2 == null){
						chart.group2 = new google.visualization.ColumnChart(document.getElementById('chartGroup2'));
					}
					chart.group2.draw(chart.data.group2, data.options.groups);
					google.visualization.events.addListener(chart.group2, 'select', function(){bradfordArticles('group2')});
					$("#group2Title").html(data.title.group2);
					var tableData = new google.visualization.DataTable(data.table.bradford);
					$("#gridContainer").empty();
					$("#gridContainer").append(data.table.title.bradford);
					$("#gridContainer").append('<div id="table0"></div>');
					tables.bradford = new google.visualization.Table(document.getElementById('table0'));
					tables.bradford.draw(tableData, data.tableOptions);
					google.visualization.events.addListener(tables.bradford , 'sort', changeTableClass);


					var tableData = new google.visualization.DataTable(data.table.group1);
					$("#gridContainer").append(data.table.title.group1);
					$("#gridContainer").append('<div class="groupTable" id="table1"></div>');
					tables.group1 = new google.visualization.Table(document.getElementById('table1'));
					tables.group1.draw(tableData, data.tblGrpOpt);
					google.visualization.events.addListener(tables.group1 , 'sort', changeTableClass);

					var tableData = new google.visualization.DataTable(data.table.group2);
					$("#gridContainer").append(data.table.title.group2);
					$("#gridContainer").append('<div class="groupTable" id="table2"></div>');
					tables.group2 = new google.visualization.Table(document.getElementById('table2'));
					tables.group2.draw(tableData, data.tblGrpOpt);
					google.visualization.events.addListener(tables.group2 , 'sort', changeTableClass);

					var tableData = new google.visualization.DataTable(data.table.group3);
					$("#gridContainer").append(data.table.title.group3);
					$("#gridContainer").append('<div class="groupTable" id="table3"></div>');
					tables.group3 = new google.visualization.Table(document.getElementById('table3'));
					tables.group3.draw(tableData, data.tblGrpOpt);
					changeTableClass();
					google.visualization.events.addListener(tables.group3 , 'sort', changeTableClass);

					$("#gridContainer").accordion( "refresh" );
					break;
				case "indice-concentracion":
				case "productividad-exogena":
					$("#tabs, #prattContainer").slideDown("slow");
					$("#prattSlide").empty();
					chart.pratt = new Array();
					chart.data.pratt = new Array();
					chart.data.prattJ = data.journal; 
					jQuery.each(data.chart, function(key, grupo) {
						active='';
						if(key == 0){
							active='active';
						}
						$("#carousel-pratt .carousel-indicators").append('<li data-target="#carousel-pratt" data-slide-to="' + key + '" class="' + active + '"></li>');
						$("#carousel-pratt .carousel-inner").append('<div class="item ' + active + '">' + data.chartTitle + ' <div id="chartPratt' + key +'" class="chart_data"></div></div>');
						chart.data.pratt[key] = new google.visualization.DataTable(grupo);
						chart.pratt[key] = new google.visualization.ColumnChart(document.getElementById('chartPratt' + key));
						chart.pratt[key].draw(chart.data.pratt[key], data.options);
						google.visualization.events.addListener(chart.pratt[key], 'select', function(){getFrecuencias(key)});
					});

					var tableData = new google.visualization.DataTable(data.table);
					$("#gridContainer").empty();
					$("#gridContainer").append(data.tableTitle);
					$("#gridContainer").append('<div id="table0"></div>');
					tables.pratt = new google.visualization.Table(document.getElementById('table0'));
					tables.pratt.draw(tableData, data.tableOptions);
					changeTableClass();
					google.visualization.events.addListener(tables.pratt , 'sort', changeTableClass);
					console.log(chart);	
					break;
				default:
					$("#tabs, #chartContainer").show("slow");
					chart.data.normal = new google.visualization.DataTable(data.data);
					if(chart.normal == null){
						chart.normal = new google.visualization.LineChart(document.getElementById('chart'));
						google.visualization.events.addListener(chart.normal, 'select', choosePoint);
					}
					chart.normal.draw(chart.data.normal, data.options);
					$("#chartTitle").html(data.chartTitle);

					var tableData = new google.visualization.DataTable(data.dataTable);
					$("#gridContainer").empty();
					$("#gridContainer").append(data.tableTitle);
					$("#gridContainer").append('<div id="table0"></div>');
					tables.normal = new google.visualization.Table(document.getElementById('table0'));
					tables.normal.draw(tableData, data.tableOptions);
					changeTableClass();
					google.visualization.events.addListener(tables.normal , 'sort', changeTableClass);
					

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
<?php 	if (preg_match('%.*?/coleccion/(.+?)(/.*|$)%', uri_string())):?>
		coleccion:"<?=preg_replace('%.*?/coleccion/(.+?)(/area.*|/revista.*|/pais.*|/[0-9]{4}-[0-9]{4}|$)%', '\1', uri_string());?>".split('/'),
<?php 	endif;?>
<?php 	if (preg_match('%.*?/area/(.+?)(/.*|$)%', uri_string())):?>
		area:"<?=preg_replace('%.*?/area/(.+?)(/revista.*|/pais.*|/[0-9]{4}-[0-9]{4}|$)%', '\1', uri_string());?>".split('/'),
<?php 	endif;?>
<?php 	if (preg_match('%.*?/revista/(.+?)(/.*|$)%', uri_string())):?>
		revista:"<?=preg_replace('%.*?/revista/(.+?)(/area.*|/pais.*|/[0-9]{4}-[0-9]{4}|$)%', '\1', uri_string());?>".split('/'),
<?php 	endif;?>
<?php 	if (preg_match('%.*?/pais-revista/(.+?)(/.*|$)%', uri_string())):?>
		paisRevista:"<?=preg_replace('%.*?/pais-revista/(.+?)(/.*|$)%', '\1', uri_string());?>".split('/'),
<?php 	endif;?>
<?php 	if (preg_match('%.*?/pais-autor/(.+?)(/.*|$)%', uri_string())):?>
		paisAutor:"<?=preg_replace('%.*?/pais-autor/(.+?)(/area.*|/revista.*|/[0-9]{4}-[0-9]{4}|$)%', '\1', uri_string());?>".split('/'),
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
		updateData();
	}
<?php endif;?>
	if(typeof history.replaceState === "function"){
		history.replaceState($("#generarIndicador").serializeJSON(), null);
	}
});
getSerializedForm = function () {
	dataPost = $('#generarIndicador').serializeArray();
	for (index = 0; index < dataPost.length; ++index) {
		if (dataPost[index].name == "indicador") {
			dataPost[index].value = realIndicator;
			break;
		}
	}
	return $.param(dataPost);
}

setPeriodos = function(){
	loading.start();
	$("#periodos").removeClass("hidden").slideDown("slow");
	jQuery.ajax({
		url: '<?=site_url("scielo/indicadores/getPeriodos");?>',
		type: 'POST',
		dataType: 'json',
		data: getSerializedForm(),
		async: false,
		success: function(data) {
			console.log(data);
			console.log(jQuery.parseJSON(data.scale));
			console.log(jQuery.parseJSON(data.heterogeneity));
			if(data.result){
				$("#sliderPeriodo").jslider().destroy();
				$("#sliderPeriodo").prop('disabled', false);
				$("#generate").prop('disabled', false);
				rangoPeriodo=data.anioBase + ";" + data.anioFinal;
				console.log(data)
				$("#sliderPeriodo").val(rangoPeriodo);
				$("#sliderPeriodo").data('pre', $("#sliderPeriodo").val());
				$("#sliderPeriodo").jslider({
					from: data.anioBase, 
					to: data.anioFinal, 
					heterogeneity: jQuery.parseJSON(data.heterogeneity), 
					scale: jQuery.parseJSON(data.scale),
					format: { format: '####', locale: 'us' }, 
					limits: false, 
					step: 1, 
					callback: function(value){
						console.log(value);
						if($("#sliderPeriodo").data('pre') != value){
							$("#sliderPeriodo").data('pre', value);
							$("#sliderPeriodo").val(value);
							rango=value.replace(';', '-');
							if(typeof history.pushState === "function"){
								history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + indicador + coleccionURL + areaURL + revistaURL + paisAutor + '/' + rango);
							}
							$("#revista, #paisRevista").select2("close");
							$("#generarIndicador").submit();
						}
					}
				});
				$("#sliderPeriodo").jslider("value", data.anioBase, data.anioFinal);
				if(!popState.periodo){
					$("#generarIndicador").submit();
				}
				popState.periodo=false;
			}else{
				$("#sliderPeriodo").prop('disabled', true);
				$("#generate").prop('disabled', true);
				console.log(data.error);
			}
			loading.end();
		}
	});
};

updateInfo = function(){
	$("#info").children(".infoBox").hide();
	$("#info-" + realIndicator).show();
}

updateData = function(){
	console.log("urlData");
	console.log(urlData);
	asyncAjax=false;
	actualForm = $("#generarIndicador").serializeJSON();
	if(typeof urlData.periodo !== "undefined"){
		popState.periodo = true;
	}
	// if(typeof urlData.indicador !== "undefined"){
	// 	updateInfo(urlData.indicador);
	// }
	if(typeof urlData.indicador !== "undefined"){
		popState.indicador=true;
		$("#indicador").val(urlData.indicador).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}
	if(typeof urlData.coleccion !== "undefined"){
		popState.coleccion=true;
		popState.area=true;
		popState.revista=true;
		popState.paisAutor=true;
		$("#coleccion").val(urlData.coleccion).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}

	if(typeof urlData.area !== "undefined"){
		popState.area=true;
		$("#area").val(urlData.area).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}

	if(typeof urlData.revista !== "undefined"){
		popState.revista=true;
		$("#revista").val(urlData.revista).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}

	if(typeof urlData.paisAutor !== "undefined"){
		popState.paisAutor=true;
		$("#paisAutor").val(urlData.paisAutor).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}

	// if(typeof urlData.periodo !== "undefined"){
	// 	$("#sliderPeriodo").prop("disabled", false);
	// 	$("#sliderPeriodo").jslider("value", urlData.periodo.substring(0, 4), urlData.periodo.substring(5));
	// 	$("#sliderPeriodo").val(urlData.periodo);
	// 	$("#generarIndicador").submit();
	// }
	$.each(popState, function(k,v){popState[k]=false;});
	asyncAjax=true;
	urlData=null;
};

chooseZone = function () {
	var selection = chart.bradford.getSelection();
	console.log(selection);
	if (selection[0] != null && selection[0].row != null){
		var value = chart.data.bradford.getFormattedValue(selection[0].row, 0);
		if (value <= brfLim[1].lim.x){
			$("#carousel-bradford").carousel(1);
		}
		else if (value > brfLim[1].lim.x && value <= brfLim[2].lim.x) {
			$("#carousel-bradford").carousel(2);
		}else{
			$("#tabs").tabs("option", "active", 1);
			$("#gridContainer").accordion("option", "active", 3);
		}
	}else if  (selection[0] != null && selection[0].column != null){
		if(selection[0].column == 2){
			$("#carousel-bradford").carousel(1);
		}else if (selection[0].column == 3){
			$("#carousel-bradford").carousel(2);
		}else{
			$("#tabs").tabs("option", "active", 1);
			$("#gridContainer").accordion("option", "active", 3);
		}
	}
}

choosePoint = function () {
	var selection = chart.normal.getSelection()[0];
	indicadorValue = $("#indicador").val();
	if (selection && indicadorValue == "modelo-elitismo"){
		var revistaPais = chart.data.normal.getColumnId(selection.column);
		var anio = chart.data.normal.getFormattedValue(selection.row, 0);
		console.log(anio);
		jQuery.ajax({
			url: '<?=site_url("scielo/indicadores/getAutoresPrice");?>/'+ revistaPais + '/' + anio,
			type: 'POST',
			dataType: 'json',
			data: getSerializedForm(),
			success: function(data){
				console.log(data);
				var tableData = new google.visualization.DataTable(data.table);
				var table = new google.visualization.Table(document.getElementById('floatTable'));
				table.draw(tableData, data.tableOptions);
				changeTableClass();
				google.visualization.events.addListener(table , 'sort', changeTableClass);
				jQuery.colorbox({inline: true, href: $('#floatTable'), height:"90%",});
			}
		});
	}
}

bradfordArticles = function (group) {
	var selection = chart[group].getSelection()[0];
	indicadorValue = $("#indicador").val();
	if (selection && indicadorValue == "modelo-bradford-revista"){
		var revista = chart.data[group].getColumnId(selection.column);
		var disciplina=$('#coleccion').val();
		location.href = "<?=site_url("scielo/indicadores/modelo-bradford-revista/disciplina");?>/"+ disciplina + "/revista/"+ revista + "/documentos"
	}
}

getFrecuencias = function (key) {
	var selection = chart.pratt[key].getSelection();
	if (selection[0] != null && selection[0].column != null){
		disciplina=$('#coleccion').val();
		revista=chart.data.prattJ[key][(selection[0].column+1)/2 -1];
		jQuery.ajax({
			url: '<?=site_url("scielo/indicadores/getFrecuencias");?>/'+ revista,
			type: 'POST',
			dataType: 'json',
			data: getSerializedForm(),
			success: function(data){
				console.log(data);
				var tableData = new google.visualization.DataTable(data.table);
				var table = new google.visualization.Table(document.getElementById('floatTable'));
				table.draw(tableData, data.tableOptions);
				changeTableClass();
				google.visualization.events.addListener(table , 'sort', changeTableClass);
				jQuery.colorbox({inline: true, href: $('#floatTable'), height:"90%",});
			}
		});
		
		console.log(revista);
	}
}
changeTableClass = function (argument) {
	$('.google-visualization-table-table')
	.removeClass('google-visualization-table-table')
	.addClass('table table-bordered table-condensed table-striped')
	.parent().addClass('table-responsive')
	.parent().attr('style', 'position: relative;').removeClass('google-visualization-table content');
}
{/literal}