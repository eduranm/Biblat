google.load('visualization', '1.1', {packages:['corechart', 'table', 'bar', 'line'], 'language': 'en'});
var realIndicator = null;
var val = {indicador: null, coleccion: null, area: null, revista: null, paisAutor: null, paisRevista: null, edad: null, tipodoc: null}
var chart = {normal: null, bradford:null, group1:null, group2:null, bargrp:null, data:null};
chart.data = {normal: null, bradford:null, group1:null, group2:null, bargrp:null, bargrpJ:null};
var tables = {normal: null, bradford:null, group1:null, group2:null, group3:null, bargrp:null};
var brfLim = null;
var popState = {indicador:false, coleccion:false, revista:false, paisRevista:false, paisAutor:false, periodo:false, area:false, edad: false, tipodoc: false};
var rangoPeriodo="0-0";
var urls = {coleccion:'', area:'', revista:'', paisAutor:'', paisRevista:'', edad:'', tipodoc:''}
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
	$('#indicador, #coleccion, #area, #revista, #paisRevista, #paisAutor, #edad, #tipodoc').select2({
		allowClear: true,
		closeOnSelect: true
	});

	$("#indicador").on("change", function(e){
		console.log('indicador change');
		$.each(val, function(k,v){val[k]=null;});
		$.each(urls, function(k,v){urls[k]='';});
		val.indicador = $(this).val();
		realIndicator = val.indicador;
		$('#coleccion, #area, #revista, #paisRevista, #paisAutor, #edad, #tipodoc').select2('val', '').select2('enable', false).parent().hide();
		$('#revista, #paisRevista, #paisAutor').empty().append('<option></option>').select2('destroy');
		$("#periodos, #tabs, #chartContainer, #bradfodContainer, #group-container").hide('slow');
		$('#sliderPeriodo').prop('disabled', true);
		switch (val.indicador){
			case 'distribucion-articulos-coleccion':
				updateInfo();
				$('#coleccion').select2('enable', true).parent().show();
				if(urlData == null || typeof urlData.coleccion === "undefined")
					setPeriodos();
				break;
			case 'distribucion-revista-coleccion':
			case 'indicadores-generales-revista':
				updateInfo();
				$('#coleccion').select2('enable', true).parent().show();
				break;
			case 'citacion-articulos-edad':
				updateInfo();
				$("#edad").select2('enable', true).parent().show();
				break;
			case 'citacion-articulos-tipo':
				updateInfo();
				$('#tipodoc').select2('enable', true).parent().show();
				break;
			case 'citaction-articulos-area-revista':
				updateInfo();
				$('#area').select2('enable', true).parent().show();
				break;
			default:
				break;
		}

		if(typeof history.pushState === "function" && !popState.indicador){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + val.indicador);
		}
		popState.indicador=false;
		console.log(e);
	});

	$('#coleccion').on("change", function(e){
		console.log('coleccion change');
		val.coleccion = $(this).val();
		console.log(val.coleccion);
		urls.coleccion = "";
		if(val.coleccion != "" && val.coleccion != null){
			urls.coleccion='/coleccion/' + val.coleccion.join('/');
		}
		if(typeof history.pushState === "function" && !popState.coleccion){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + val.indicador + urls.coleccion);
		}
		$("#chartContainer, #bradfodContainer, #group-container").hide();
		switch (realIndicator){
			case 'distribucion-articulos-coleccion':
			case 'distribucion-articulos-coleccion-area':
			case 'distribucion-articulos-coleccion-revista':
			case 'distribucion-articulos-coleccion-afiliacion':
				realIndicator = val.indicador;
				$('#tabs, #group-container').show();
				if(val.coleccion != "" && val.coleccion != null){
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					$.ajax({
						url: '<?=site_url("scielo/indicadores/getOptionData");?>',
						type: 'POST',
						dataType: 'json',
						data: getSerializedForm(),
						async: false,
						success: function(data) {
							console.log(data);
							$('#revista, #paisAutor').empty()
							.append('<option></option>')
							.select2('destroy');
							$('#revista, #paisAutor').parent().hide();
							if(typeof data.revistas !== "undefined"){
								$.each(data.revistas, function(key, revista) {
									optgroup = $('<optgroup label="SciELO '+key+'"></optgroup>');
									$.each(revista, function(k, v){
										optgroup.append('<option value="' + k +'">' + v + '</option>');
									});
									$('#revista').append(optgroup);
								});
								if(val.revista != null && val.revista != '')
									$('#revista').val(val.revista);
								$('#revista').show().select2({allowClear: true, closeOnSelect: true})
								.select2('enable', true).parent().show();
							}
							if(typeof data.paises !== "undefined"){
								$.each(data.paises, function(k, v) {
									$('#paisAutor').append('<option value="' + k +'">' + v + '</option>');
								});
								if(val.paisAutor != null && val.paisAutor != '')
									$('#paisAutor').val(val.paisAutor);
								$('#paisAutor').show().select2({allowClear: true, closeOnSelect: true})
								.select2('enable', true).parent().show();
							}
						}
					});
				}
				if((urlData == null || (typeof urlData.area === "undefined" && typeof urlData.revista === "undefined" && typeof urlData.paisAutor === "undefined")) && (val.area === "" || val.area == null) && (val.revista === "" || val.revista == null) && (val.paisAutor === "" || val.paisAutor == null)){
					setPeriodos();
				}
				if (val.coleccion === "" || val.coleccion == null) {
					$('#area, #revista, #paisRevista, #paisAutor').parent().hide();
					$('#revista, #paisRevista, #paisAutor')
					.empty()
					.append('<option></option>')
					.select2('destroy')
					.select2({allowClear: true, closeOnSelect: true});
					$("#area, #revista, #paisRevista, #paisAutor").select2('enable', false);
				}
				if(val.area !== "" && val.area != null){
					$('#area').trigger('change');
				}
				if(val.revista !== "" && val.revista != null){
					$('#revista').trigger('change');
				}
				if(val.paisAutor !== "" && val.paisAutor != null){
					$('#paisAutor').trigger('change');
				}
				break;
			case 'distribucion-articulos-coleccion-area-revista':
				val.revista = $('#revista').val() == null ? null : $.unique($('#revista').val());
				$('#area').trigger('change');
				break;
			case 'distribucion-revista-coleccion':
				$('#tabs, #periodos, #chartContainer, #bradfodContainer, #group-container').hide();
				if(val.coleccion != "" && val.coleccion != null){
					setPeriodos();
				}
				break;
			case 'indicadores-generales-revista':
				if(val.coleccion != "" && val.coleccion != null){
					$('#revista').parent().show();
					$('#revista').select2('enable', true);
					$.ajax({
						url: '<?=site_url("scielo/indicadores/getOptionData");?>',
						type: 'POST',
						dataType: 'json',
						data: getSerializedForm(),
						async: false,
						success: function(data) {
							console.log(data);
							$('#revista').empty()
							.append('<option></option>')
							.select2('destroy')
							.parent().hide();
							if(typeof data.revistas !== "undefined"){
								$.each(data.revistas, function(key, revista) {
									optgroup = $('<optgroup label="SciELO '+key+'"></optgroup>');
									$.each(revista, function(k, v){
										optgroup.append('<option value="' + k +'">' + v + '</option>');
									});
									$('#revista').append(optgroup);
								});
								if(val.revista != null && val.revista != '')
									$('#revista').val(val.revista);
								$('#revista').select2({allowClear: true, closeOnSelect: true})
								.select2('enable', true)
								.parent().show();
							}
						}
					});
					if(val.revista !== "" && val.revista != null){
						$('#revista').trigger('change');
					}
				}else{
					$('#tabs, #group-container, #periodos').hide();
					$('#revista').select2('val', '?')
					.select2('enable', false)
					.parent().hide();
					val.revista = null;
				}
				break;
			default:
				$('#tabs, #periodos, #chartContainer, #bradfodContainer, #group-container').hide();
				break;
		}
		popState.coleccion=false;
		console.log(e);
	});

	$('#area').on('change', function(e){
		console.log('area change');
		val.area = $(this).val();
		urls.area="";
		if(val.area != "" && val.area != null){
			urls.area='/area/' + val.area.join('/');
		}
		if(typeof history.pushState === "function" && !popState.area){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + val.indicador + urls.coleccion + urls.edad + urls.tipodoc + urls.area + urls.revista);
		}
		$("#chartContainer, #bradfodContainer, #group-container").hide();
		switch (realIndicator){
			case 'distribucion-articulos-coleccion':
			case 'distribucion-articulos-coleccion-area':
			case 'distribucion-articulos-coleccion-area-revista':
				$('#tabs, #chartContainer').show();
				if(val.area != "" && val.area != null){
					$('#paisAutor').select2('enable', false).parent().hide();
					if (val.revista == null || val.revista == '')
						realIndicator = 'distribucion-articulos-coleccion-area';
					$.ajax({
						url: '<?=site_url("scielo/indicadores/getOptionData");?>',
						type: 'POST',
						dataType: 'json',
						data: getSerializedForm(),
						async: false,
						success: function(data) {
							console.log(data);
							$('#revista').empty()
							.append('<option></option>')
							.select2('destroy').parent().hide();
							if(typeof data.revistas !== "undefined"){
								$.each(data.revistas, function(key, area) {
									optgroup = $('<optgroup label="SciELO '+key+'"></optgroup>');
									$.each(area, function(key2, revista){
										optgroup2 = $('<optgroup label="'+key2+'"></optgroup>');
										$.each(revista, function(k, v){
											optgroup2.append('<option value="' + k +'">' + v + '</option>');
										});
										optgroup.append(optgroup2);
									});
									$('#revista').append(optgroup);
								});
								if(val.revista != null && val.revista != '')
									$('#revista').val(val.revista);
								val.revista = $('#revista').val() == null ? null : $.unique($('#revista').val());
								$('#revista').show().select2({allowClear: true, closeOnSelect: true}).select2('enable', true)
								.parent().show();
							}
						}
					});
					if (val.revista == null || val.revista == '')
						realIndicator = 'distribucion-articulos-coleccion-area';
					updateInfo();
					if(urlData == null || typeof urlData.revista === "undefined")
						setPeriodos();
				}else{
					realIndicator = val.indicador
					$('#revista, #paisAutor').select2('val', '?').select2('enable', true)
					.parent().show();
					val.revista = null;
					if(!popState.coleccion)
						$('#coleccion').trigger('change');
				}
				break;
			case 'citacion-articulos-edad':
			case 'citacion-articulos-edad-area':
				$('#tabs, #chartContainer').show();
				if(val.area != "" && val.area != null){
					$('#revista, #paisAutor').select2('enable', false)
					.parent().hide();
					realIndicator = 'citacion-articulos-edad-area';
					updateInfo();
					setPeriodos();
				}else{
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					if(!popState.edad)
						$('#edad').trigger('change');
				}
				break;
			case 'citacion-articulos-tipo':
			case 'citacion-articulos-tipo-area':
				$('#tabs, #chartContainer').show();
				if(val.area != "" && val.area != null){
					$('#revista, #paisAutor').select2('enable', false)
					.parent().hide();
					realIndicator = 'citacion-articulos-tipo-area';
					updateInfo();
					setPeriodos();
				}else{
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					if(!popState.tipodoc)
						$('#tipodoc').trigger('change');
				}
				break;
			case 'citaction-articulos-area-revista':
				$('#tabs, #chartContainer').show();
				if(val.area != "" && val.area != null){
					$('#paisAutor').select2('enable', false).parent().hide();
					$.ajax({
						url: '<?=site_url("scielo/indicadores/getOptionData");?>',
						type: 'POST',
						dataType: 'json',
						data: getSerializedForm(),
						async: false,
						success: function(data) {
							console.log(data);
							$('#revista').empty()
							.append('<option></option>')
							.select2('destroy').parent().hide();
							if(typeof data.revistas !== "undefined"){
								$.each(data.revistas, function(key, revista) {
									$('#revista').append('<option value="' + key +'">' + revista + '</option>');
								});
								if(val.revista != null && val.revista != '')
									$('#revista').val(val.revista);
								val.revista = $('#revista').val();
								$('#revista').show().select2({allowClear: true, closeOnSelect: true}).select2('enable', true)
								.parent().show();
							}
						}
					});
				}else{
					$('#revista').select2('val', '?').select2('enable', false)
					.parent().hide();
					val.revista = null;
				}
				break;
			default:
				break;
		}
		popState.area=false;
		console.log(e);
	});

	$('#revista').on("change", function(e){
		console.log('revista change');
		val.revista = $(this).val() == null ? null : $.unique($(this).val());
		urls.revista="";
		if(val.revista != null){
			urls.revista='/revista/' + val.revista.join('/');
		}
		if(typeof history.pushState === "function" && !popState.revista){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + val.indicador + urls.coleccion + urls.edad + urls.tipodoc + urls.area + urls.revista);
		}
		$("#chartContainer, #bradfodContainer, #group-container").hide();
		switch (realIndicator){
			case 'distribucion-articulos-coleccion':
			case 'distribucion-articulos-coleccion-revista':
				$('#tabs, #chartContainer').show();
				if(val.revista != "" && val.revista != null){
					realIndicator = 'distribucion-articulos-coleccion-revista';
					$('#area, #paisAutor').select2('enable', false)
					.parent().hide();
					updateInfo();
					setPeriodos();
				}else{
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					if(!popState.coleccion)
						$('#coleccion').trigger('change');
				}
				break;
			case 'distribucion-articulos-coleccion-area':
			case 'distribucion-articulos-coleccion-area-revista':
				$('#tabs, #chartContainer').show();
				if(val.revista != "" && val.revista != null){
					$('#paisAutor').select2('enable', false)
					.parent().hide();
					realIndicator = 'distribucion-articulos-coleccion-area-revista';
					updateInfo();
					setPeriodos();
				}else if(!popState.coleccion){
					realIndicator = 'distribucion-articulos-coleccion-area';
					$('#area').trigger('change');
				}
				break;
			case 'indicadores-generales-revista':
				$('#tabs, #group-container').show();
				if(val.revista != "" && val.revista != null){
					setPeriodos();
				}else{
					$('#tabs, #group-container, #periodos').hide();
				}
				break;
			case 'citacion-articulos-edad':
			case 'citacion-articulos-edad-revista':
				$('#tabs, #chartContainer').show();
				if(val.revista != "" && val.revista != null){
					$('#area, #paisAutor').select2('enable', false)
					.parent().hide();
					realIndicator = 'citacion-articulos-edad-revista';
					updateInfo();
					setPeriodos();
				}else{
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					if(!popState.edad)
						$('#edad').trigger('change')
				};
				break;
			case 'citacion-articulos-tipo':
			case 'citacion-articulos-tipo-revista':
				$('#tabs, #chartContainer').show();
				if(val.revista != "" && val.revista != null){
					$('#area, #paisAutor').select2('enable', false)
					.parent().hide();
					realIndicator = 'citacion-articulos-tipo-revista';
					updateInfo();
					setPeriodos();
				}else{
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					if(!popState.tipodoc)
						$('#tipodoc').trigger('change');
				}
				break;
			default:
				break;
		}
		popState.revista=false;
		console.log(e);
	});

	$('#paisAutor').on("change", function(e){
		console.log('paisAutor change');
		val.paisAutor = $(this).val();
		urls.paisAutor="";
		if(val.paisAutor != "" && val.paisAutor != null){
			urls.paisAutor='/pais-autor/' + val.paisAutor.join('/');
		}
		if(typeof history.pushState === "function" && !popState.paisAutor){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + val.indicador + urls.coleccion + urls.edad + urls.tipodoc + urls.paisAutor);
		}
		$("#chartContainer, #bradfodContainer, #group-container").hide();
		switch (val.indicador){
			case 'distribucion-articulos-coleccion':
			case 'distribucion-articulos-coleccion-afiliacion':
				$('#tabs, #chartContainer').show();
				if(val.paisAutor != "" && val.paisAutor != null){
					realIndicator = 'distribucion-articulos-coleccion-afiliacion';
					$('#revista, #area').select2('enable', false)
					.parent().hide();
					updateInfo();
					setPeriodos();
				}else{
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					if(!popState.coleccion)
						$('#coleccion').trigger('change');
				}
				break;
			case 'citacion-articulos-edad':
			case 'citacion-articulos-edad-afiliacion':
				$('#tabs, #chartContainer').show();
				if(val.paisAutor != "" && val.paisAutor != null){
					$('#area, #revista').select2('enable', false)
					.parent().hide();
					realIndicator = 'citacion-articulos-edad-afiliacion';
					updateInfo();
					setPeriodos();
				}else{
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					if(!popState.edad)
						$('#edad').trigger('change');
				}
				break;
			case 'citacion-articulos-tipo':
			case 'citacion-articulos-tipo-afiliacion':
				$('#tabs, #chartContainer').show();
				if(val.paisAutor != "" && val.paisAutor != null){
					$('#area, #revista').select2('enable', false)
					.parent().hide();
					realIndicator = 'citacion-articulos-tipo-afiliacion';
					updateInfo();
					setPeriodos();
				}else{
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					if(!popState.tipodoc)
						$('#tipodoc').trigger('change');
				}
				break;
			default:
				break;
		}
		popState.paisAutor=false;
		console.log(e);
	});

	$('#paisRevista').on("change", function(e){
		value = $(this).val();
		indicadorValue = $("#indicador").val();
		coleccionValue = $('#coleccion').val();
		$('#sliderPeriodo').prop("disabled", true);
		if (value != "" && value != null) {
			$('#revista').select2('enable', false);
			$('#paisAutor').select2('enable', false);
			setPeriodos();
		}else{
			$("#periodos, #tabs, #chartContainer").hide('slow');
			$('#revista').select2('enable', true);
			$('#paisAutor').select2('enable', true);
		}
		if(typeof history.pushState === "function" && !popState.paisRevista){
			urls.paisRevista="";
			if(value != "" && value != null){
				urls.paisRevista='/pais-revista/' + value.join('/');
			}
			console.log('pushState');
			console.log(urls.paisRevista);
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + indicadorValue + '/coleccion/' + coleccionValue + urls.paisRevista);
		}
		popState.paisRevista=false;
		console.log(e);
	});

	$('#edad').on('change', function(e){
		console.log('edad change');
		val.edad = $(this).val();
		urls.edad="";
		if(val.edad != "" && val.edad != null){
			urls.edad='/edad/' + val.edad.join('/');
		}
		if(typeof history.pushState === "function" && !popState.edad){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + val.indicador + urls.edad);
		}
		$("#tabs, #periodos, #chartContainer, #bradfodContainer, #group-container").hide();
		$('#area, #revista, #paisRevista, #paisAutor').select2('enable', false);
		switch(realIndicator){
			case 'citacion-articulos-edad':
			case 'citacion-articulos-edad-area':
			case 'citacion-articulos-edad-revista':
			case 'citacion-articulos-edad-afiliacion':
				realIndicator = val.indicador;
				if(val.edad != "" && val.edad != null){
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					$.ajax({
						url: '<?=site_url("scielo/indicadores/getOptionData");?>',
						type: 'POST',
						dataType: 'json',
						data: getSerializedForm(),
						async: false,
						success: function(data) {
							console.log(data);
							$('#revista, #paisAutor').empty()
							.append('<option></option>')
							.select2('destroy');
							$('#revista, #paisAutor').parent().hide();
							if(typeof data.revistas !== "undefined"){
								$.each(data.revistas, function(k, v) {
									$('#revista').append('<option value="' + k +'">' + v + '</option>');
								});
								if(val.revista != null && val.revista != '')
									$('#revista').val(val.revista);
								$('#revista').show().select2({allowClear: true, closeOnSelect: true})
								.select2('enable', true).parent().show();
							}
							if(typeof data.paises !== "undefined"){
								$.each(data.paises, function(k, v) {
									$('#paisAutor').append('<option value="' + k +'">' + v + '</option>');
								});
								if(val.paisAutor != null && val.paisAutor != '')
									$('#paisAutor').val(val.paisAutor);
								$('#paisAutor').show().select2({allowClear: true, closeOnSelect: true})
								.select2('enable', true).parent().show();
							}
						}
					});
					if((urlData == null || (typeof urlData.area === "undefined" && typeof urlData.revista === "undefined" && typeof urlData.paisAutor === "undefined")) && (val.area === "" || val.area == null) && (val.revista === "" || val.revista == null) && (val.paisAutor === "" || val.paisAutor == null)){
						$('#tabs, #chartContainer').show();
						setPeriodos();
					}
					if(val.area !== "" && val.area != null){
						$('#area').trigger('change');
					}
					if(val.revista !== "" && val.revista != null){
						$('#revista').trigger('change');
					}
					if(val.paisAutor !== "" && val.paisAutor != null){
						$('#paisAutor').trigger('change');
					}
				}else{
					$('#area, #revista, #paisAutor').select2('val', '?').select2('enable', false)
					.parent().hide();
					val.area = null;
					val.revista = null;
					val.paisAutor = null;
				}
				break;
			default:
				break;
		}
		popState.edad=false;
		console.log(e);
	});

	$('#tipodoc').on('change', function(e){
		console.log('tipodoc change');
		val.tipodoc = $(this).val();
		urls.tipodoc="";
		if(val.tipodoc != "" && val.tipodoc != null){
			urls.tipodoc='/tipo-documento/' + val.tipodoc.join('/');
		}
		if(typeof history.pushState === "function" && !popState.tipodoc){
			history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + val.indicador + urls.tipodoc);
		}
		$('#tabs, #periodos, #chartContainer, #bradfodContainer, #group-container').hide();
		$('#area, #revista, #paisRevista, #paisAutor').select2('enable', false);
		switch(realIndicator){
			case 'citacion-articulos-tipo':
			case 'citacion-articulos-tipo-area':
			case 'citacion-articulos-tipo-revista':
			case 'citacion-articulos-tipo-afiliacion':
				realIndicator = val.indicador;
				if(val.tipodoc != "" && val.tipodoc != null){
					$('#area, #revista, #paisAutor').select2('enable', true)
					.parent().show();
					$.ajax({
						url: '<?=site_url("scielo/indicadores/getOptionData");?>',
						type: 'POST',
						dataType: 'json',
						data: getSerializedForm(),
						async: false,
						success: function(data) {
							console.log(data);
							$('#revista, #paisAutor').empty()
							.append('<option></option>')
							.select2('destroy');
							$('#revista, #paisAutor').parent().hide();
							if(typeof data.revistas !== "undefined"){
								$.each(data.revistas, function(k, v) {
									$('#revista').append('<option value="' + k +'">' + v + '</option>');
								});
								if(val.revista != null && val.revista != '')
									$('#revista').val(val.revista);
								$('#revista').show().select2({allowClear: true, closeOnSelect: true})
								.select2('enable', true).parent().show();
							}
							if(typeof data.paises !== "undefined"){
								$.each(data.paises, function(k, v) {
									$('#paisAutor').append('<option value="' + k +'">' + v + '</option>');
								});
								if(val.paisAutor != null && val.paisAutor != '')
									$('#paisAutor').val(val.paisAutor);
								$('#paisAutor').show().select2({allowClear: true, closeOnSelect: true})
								.select2('enable', true).parent().show();
							}
						}
					});
					if((urlData == null || (typeof urlData.area === "undefined" && typeof urlData.revista === "undefined" && typeof urlData.paisAutor === "undefined")) && (val.area === "" || val.area == null) && (val.revista === "" || val.revista == null) && (val.paisAutor === "" || val.paisAutor == null)){
						$('#tabs, #chartContainer').show();
						setPeriodos();
					}
					if(val.area !== "" && val.area != null){
						$('#area').trigger('change');
					}
					if(val.revista !== "" && val.revista != null){
						$('#revista').trigger('change');
					}
					if(val.paisAutor !== "" && val.paisAutor != null){
						$('#paisAutor').trigger('change');
					}
				}else{
					$('#area, #revista, #paisAutor').select2('val', '?').select2('enable', false)
					.parent().hide();
					val.area = null;
					val.revista = null;
					val.paisAutor = null;
				}
				break;
			default:
				break;
		}
		popState.tipodoc=false;
		console.log(e);	
	});

	$('#sliderPeriodo').jslider();

	$('#tabs').tabs({ 
		show: { effect: "fade", duration: 800 },
		activate: function(){
			if($('#tabs').tabs("option", "active") != 1){
				if($("#indicador").val() == "modelo-bradford-revista" || $("#indicador").val() == "modelo-bradford-institucion"){
					$("#gridContainer").accordion("option", "active", false);
				}
			}
			$('html, body').animate({
				scrollTop: $('#tabs').parent().parent().offset().top
			}, 700);
		}
	});

	$("#gridContainer").accordion({
		heightStyle: "content",
		collapsible: true,
		active: false,
		activate: function( event, ui ) {
			$('html, body').animate({
				scrollTop: $('#tabs').offset().top
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
		  	$('#tabs').tabs("option", "active", 0);
		  	$('#tabs a[href="#grid"]').show();
			$('.download-chart').hide();
			$('#carousel-chargrp').off('slide.bs.carousel');
			switch(realIndicator){
				case "distribucion-articulos-coleccion":
					$("#tabs, #group-container").slideDown('slow');
					$("#bargrpSlide").empty();
					chart.bargrp = new Array();
					chart.data.bargrp = new Array();
					chart.data.bargrpJ = data.journal;
					$("#carousel-chargrp .carousel-indicators, #carousel-chargrp .carousel-inner").empty();
					jQuery.each(data.chart, function(key, grupo) {
						if(key == 0){
							$("#carousel-chargrp .carousel-indicators").append('<li data-target="#carousel-chargrp" data-slide-to="' + key + '" class="active"></li>');
						}else{
							$("#carousel-chargrp .carousel-indicators").append('<li id="chartLi' + key + '" data-target="#carousel-chargrp" data-slide-to="' + key + '"></li>');
						}
						$("#carousel-chargrp .carousel-inner").append('<div id="chartParent' + key + '" class="item active">' + data.chartTitle + ' <div id="chartPratt' + key +'" class="chart_data"></div></div>');
						chart.data.bargrp[key] = new google.visualization.DataTable(grupo);
						chart.bargrp[key] = new google.charts.Bar(document.getElementById('chartPratt' + key));
						chart.bargrp[key].draw(chart.data.bargrp[key], google.charts.Bar.convertOptions(data.options));
						if(key > 0){
							google.visualization.events.addListener(chart.bargrp[key], 'ready', function(){
								$('#chartParent' + key).removeClass("active");
							});
						}
					});
					$("#carousel-chargrp").carousel(0);
					var tableData = new google.visualization.DataTable(data.table);
					$("#gridContainer").empty();
					$("#gridContainer").append(data.tableTitle);
					$("#gridContainer").append('<div id="table0"></div>');
					tables.bargrp = new google.visualization.Table(document.getElementById('table0'));
					tables.bargrp.draw(tableData, data.tableOptions);
					changeTableClass();
					google.visualization.events.addListener(tables.bargrp , 'sort', changeTableClass);
					$('#tabs a[href="#grid"]').show();
					break;
				case "indicadores-generales-revista":
					$("#tabs, #group-container").slideDown('slow');
					$("#bargrpSlide").empty();
					chart.bargrp = new Array();
					chart.data.bargrp = new Array();
					chart.data.bargrpJ = data.journal;
					$("#carousel-chargrp .carousel-indicators, #carousel-chargrp .carousel-inner").empty();
					nav = 0;
					jQuery.each(data.chart, function(key, grupo) {
						console.log(key);
						if(key == 'fasciculos'){
							$("#carousel-chargrp .carousel-indicators").append('<li data-target="#carousel-chargrp" data-slide-to="' + nav + '" class="active"></li>');
						}else{
							$("#carousel-chargrp .carousel-indicators").append('<li id="chartLi' + key + '" data-target="#carousel-chargrp" data-slide-to="' + nav + '"></li>');
						}
						chart.data.bargrp[key] = new google.visualization.DataTable(grupo);
						switch(key){
							case 'citas':
								$("#carousel-chargrp .carousel-inner").append('<div id="chartParent' + key + '" class="item active"><div class="text-center nowrap"><h4>' + data.title[key] + '</h4>' + data.update + '</div><div id="chartPratt' + key +'" class="chart_data"></div></div>');
								chart.bargrp[key] = new google.charts.Bar(document.getElementById('chartPratt' + key));
								chart.bargrp[key].draw(chart.data.bargrp[key], google.charts.Bar.convertOptions(data.options.bar));
								break;
							default:
								$("#carousel-chargrp .carousel-inner").append('<div id="chartParent' + key + '" class="item"><div class="text-center nowrap"><h4>' + data.title[key] + '</h4>' + data.update + '</div><div id="chartPratt' + key +'" class="chart_data"></div></div>');
								chart.bargrp[key] = new google.visualization.LineChart(document.getElementById('chartPratt' + key));
								chart.bargrp[key].draw(chart.data.bargrp[key], $.extend({}, data.options.line, data.vTitle[key]));
								break;
						}
						if(key == 'citas'){
							console.log("addListener: "+key);
							google.visualization.events.addListener(chart.bargrp[key], 'ready', function(){
								console.log("ready: "+key);
								$('#chartParent' + key).removeClass("active");
							});
						}
						nav++;
					});
					$("#carousel-chargrp").carousel(0);
					$('#tabs a[href="#grid"]').hide();
					$('.download-chart').show();
					$('#carousel-chargrp').on('slide.bs.carousel', function (e) {
						var current_chart = e.relatedTarget.id.replace('chartParent', '')
						$('.download-chart').show();
						if(current_chart === 'citas')
							$('.download-chart').hide();
					});
					break;
				default:
					$("#tabs, #chartContainer").show('slow');
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
					$('.download-chart').show();
					break;
			}
			console.log(chart);
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
<?php 	if (preg_match('%.*?/edad/(.+?)(/.*|$)%', uri_string())):?>
		edad:"<?=preg_replace('%.*?/edad/(.+?)(/area.*|/revista.*|/pais.*|/[0-9]{4}-[0-9]{4}|$)%', '\1', uri_string());?>".split('/'),
<?php 	endif;?>
<?php 	if (preg_match('%.*?/tipo-documento/(.+?)(/.*|$)%', uri_string())):?>
		tipodoc:"<?=preg_replace('%.*?/tipo-documento/(.+?)(/area.*|/revista/.*|/pais.*|/[0-9]{4}-[0-9]{4}|$)%', '\1', uri_string());?>".split('/'),
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
	$('#periodos').removeClass("hidden").slideDown('slow');
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
				$('#sliderPeriodo').jslider().destroy();
				$('#sliderPeriodo').prop('disabled', false);
				$("#generate").prop('disabled', false);
				rangoPeriodo=data.anioBase + ";" + data.anioFinal;
				console.log(data)
				$('#sliderPeriodo').val(rangoPeriodo);
				$('#sliderPeriodo').data('pre', $('#sliderPeriodo').val());
				$('#sliderPeriodo').jslider({
					from: data.anioBase, 
					to: data.anioFinal, 
					heterogeneity: jQuery.parseJSON(data.heterogeneity), 
					scale: jQuery.parseJSON(data.scale),
					format: { format: '####', locale: 'us' }, 
					limits: false, 
					step: 1, 
					callback: function(value){
						console.log(value);
						if($('#sliderPeriodo').data('pre') != value){
							$('#sliderPeriodo').data('pre', value);
							$('#sliderPeriodo').val(value);
							rango=value.replace(';', '-');
							if(typeof history.pushState === "function"){
								history.pushState($("#generarIndicador").serializeJSON(), null, '<?=site_url('scielo/indicadores')."/"?>' + val.indicador + urls.coleccion + urls.area + urls.revista + urls.edad + '/' + rango);
							}
							$("#revista, #paisRevista").select2("close");
							$("#generarIndicador").submit();
						}
					}
				});
				$('#sliderPeriodo').jslider("value", data.anioBase, data.anioFinal);
				if(!popState.periodo){
					$("#generarIndicador").submit();
				}
				popState.periodo=false;
			}else{
				$('#sliderPeriodo').prop('disabled', true);
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
		$('#coleccion').val(urlData.coleccion).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}

	if(typeof urlData.edad !== "undefined"){
		popState.edad=true;
		$('#edad').val(urlData.edad).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}

	if(typeof urlData.tipodoc !== "undefined"){
		popState.tipodoc=true;
		$('#tipodoc').val(urlData.tipodoc).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}

	if(typeof urlData.area !== "undefined"){
		popState.area=true;
		$("#area").val(urlData.area).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}

	if(typeof urlData.revista !== "undefined"){
		popState.revista=true;
		$('#revista').val(urlData.revista).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}

	if(typeof urlData.paisAutor !== "undefined"){
		popState.paisAutor=true;
		$('#paisAutor').val(urlData.paisAutor).trigger("change");
		actualForm = $("#generarIndicador").serializeJSON();
	}

	if(typeof urlData.periodo !== "undefined"){
		$('#sliderPeriodo').prop("disabled", false);
		$('#sliderPeriodo').jslider("value", urlData.periodo.substring(0, 4), urlData.periodo.substring(5));
		$('#sliderPeriodo').val(urlData.periodo);
		$("#generarIndicador").submit();
	}
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
			$('#tabs').tabs("option", "active", 1);
			$("#gridContainer").accordion("option", "active", 3);
		}
	}else if  (selection[0] != null && selection[0].column != null){
		if(selection[0].column == 2){
			$("#carousel-bradford").carousel(1);
		}else if (selection[0].column == 3){
			$("#carousel-bradford").carousel(2);
		}else{
			$('#tabs').tabs("option", "active", 1);
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
	var selection = chart.bargrp[key].getSelection();
	if (selection[0] != null && selection[0].column != null){
		disciplina=$('#coleccion').val();
		revista=chart.data.bargrpJ[key][(selection[0].column+1)/2 -1];
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

$('.download-chart').on('click', function(e){
	e.preventDefault();
	var imgData = '';
	var fName = '';
	switch(realIndicator){
		case 'distribucion-articulos-coleccion':
			return false;
			break;
		case 'indicadores-generales-revista':
			var current_chart = $('#carousel-chargrp').find('.item.active').attr('id').replace('chartParent', '');
			imgData = chart.bargrp[current_chart].getImageURI();
			fName = realIndicator+'-'+current_chart+'.png';
			break;
		default:
			imgData = chart.normal.getImageURI();
			fName = realIndicator+'.png';
			break;
	}
	tmp=$('<a></a>').attr('href', imgData).attr('download', fName);
	$('body').append(tmp);
	tmp.get(0).click();
	tmp.remove()
});
