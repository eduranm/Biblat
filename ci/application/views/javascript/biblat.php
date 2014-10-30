{literal}
<?php if(ENVIRONMENT === "production"):?>
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-33940112-1']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
<!-- Piwik -->
var _paq = _paq || [];
_paq.push(["trackPageView"]);
_paq.push(["enableLinkTracking"]);

(function() {
var u=(("https:" == document.location.protocol) ? "https" : "http") + "://132.248.67.111/piwik/";
_paq.push(["setTrackerUrl", u+"piwik.php"]);
_paq.push(["setSiteId", "2"]);
var d=document, g=d.createElement("script"), 
s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
g.defer=true; g.async=true; g.src=u+"piwik.js"; 
s.parentNode.insertBefore(g,s);
})();
<!-- End Piwik Code -->
<?php endif;?>
var addthis_config = addthis_config||{};
addthis_config.data_track_addressbar = false;
addthis_config.data_track_clickback = false;
addthis_config.ui_language = "<?=lang_iso_code();?>";
loading = {
	start: function(){
		$.blockUI({ 
			message: '<h2 style="white-space:nowrap;"><img src="<?=base_url('img/loading.gif');?>" /><br/><?php _e('Espere un momento...');?></h2>',
			css: { 
				color: '#000', 
				backgroundColor:'#FBFCEF', 
				opacity: 0.6, 
				border: '2px solid #114D66',
				cursor: 'wait'
			},
			baseZ: 1000000,
			onBlock: function(){
				loading.status=true;
			},
			onUnblock: function(){
				loading.status=false;
			}
		});
	},
	end: function(){
		$.unblockUI();
	},
	status: false
};

advsearch = {
	updateData: function(){
		$('#slug').val(JSON.stringify($('#advsearch').advancedSearch("val")));
	},
	getList: function(){
		var json;
		$.ajax({async: false,type: "POST",url: "<?php echo site_url('buscar/getList');?>",dataType: "json",data:{request:'clients'},
			success: function(data){ json = data; }
		});
		return json;
	}
};
$.pnotify.defaults.history = true;
$.pnotify.defaults.styling = "bootstrap";
$(document).bind("contextmenu",function(e){
	return false;
});
$(document).ready(function()
{
<?php  
if ( lang_notification() ):
$broserLang = get_browser_lang();
?>
$.ajax({
	url: '<?=base_url("{$broserLang}/main/lang_notification");?>',
	dataType: 'json',
	success: function(data) {
		$.pnotify({
			title: data.message + '  ' + data.button,
			addclass: "stack-bar-top",
			type: 'info',
			cornerclass: "",
			width: "100%",
			stack: {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0}
		});
	}
});
$(document).on('click', '.translate', function(e) {
	location = '<?=site_url($this->lang->switch_uri($broserLang));?>';
});
<?php endif;?>
lists = advsearch.getList();
$('#advsearch').advancedSearch({
	fields:[
		{ type:"text", id:"palabra-clave", label:"<?=_e('Palabra clave');?>", opDefault: 'lk', opHide: true},
		{ type:"text", id:"autor", label:"<?=_e('Autor');?>", opDefault: 'lk', opHide: true},
		{ type:"text", id:"revista", label:"<?=_e('Revista');?>", opDefault: 'lk', opHide: true},
		{ type:"text", id:"institucion", label:"<?=_e('Institución');?>", opDefault: 'lk', opHide: true},
		{ type:"text", id:"articulo", label:"<?=_e('Artículo');?>", opDefault: 'lk', opHide: true},
		{ type:"lov", id:"pais", label:"<?=_e('País de la revista');?>", list: lists.paises, listPlaceholder: "<?php _e('Seleccione país');?>"},
		{ type:"lov", id:"disciplina", label:"<?=_e('Disciplina');?>", list: lists.disciplinas, listPlaceholder: "<?php _e('Seleccione disciplina');?>"}
	],
	lang: {sEqual: '=', sLike: '&asymp;', sInList: "<?=_e('cualquiera de');?>"},
	enableSelect2: true,
	placeholder: "<?=_e('Seleccione filtro');?>"
}).on('submit.search change.search', function(evt){
	advsearch.updateData();
});
	$("#search-opts li").click(function(e) {
		var button = $(this).attr('rel');
		$('#search-type').attr('class', $('#'+button).attr('class'));
		$('#filtro').val(button);
		$('#slug').show();
		$('#advsearch').hide();
		console.log(button);
		if(button == "avanzada"){
			$('#slug').hide();
			$('#advsearch').show();
			$('.evo-bNew').trigger('click');
		}
		if($('#search-opts').data('last') == "avanzada"){
			$('#advsearch').advancedSearch("clear");
			$('#slug').val('');
			$('#slug').height(20);
		}
		$('#search-opts').data('last', button);
	});
<?php if($search['filtro'] == "avanzada"):?>
	$("#search-opts li[rel='avanzada']").trigger("click");
	$('#advsearch').advancedSearch('val', $.parseJSON('<?=$search['json']?>'));
	$('.evo-bDel').trigger("click");
<?php endif;?>

	$('#searchform #slug').keypress(function(e) {
		if(e.which == 13) {
			$('#searchform').submit();
			return false;
		}
	});
	$('#searchform').submit(function(e) {
		if($('#value').length > 0 && $('#value').val().length > 0 || $('#lov').length > 0){
			$('.evo-bAdd').trigger('click');
		}
		var data = $(this).serializeArray();
		data.push({name: "ajax", value: true});
		$.ajax({
			url: '<?=site_url('buscar');?>',
			async: false,
			type: 'POST',
			data: $.param(data),
			success: function(data) {
				window.location = data;
				return false;
			}
		});
		return false;
	});
	$('textarea').autosize();

	$('body').click(function(e) {
		$(".optionsMenu").hide();
	});
	$('body').on('click', '#solicitudDocumento', function(e) {
		$('.solicitudDocumento, #sd-disable, #sd-enable').toggle();
	});
	$('body').on('click', '#showmap', function(e) {
		$('#mapa-anexo').toggle();
	});
	$('body').on('submit', '#formSolicitudDocumento', function(e) {
		if(!loading.status){
			loading.start();
		}
		console.log($(this).attr("action"));
		$.ajax({
			url: $(this).attr("action"),
			type: 'POST',
			dataType: 'json',
			data: $(this).serialize(),
			success: function(data) {
				console.log(data)
				loading.end();
				$('input:text').each(function(){
					$(this).val('');
				});
				$('.solicitudDocumento, #sd-disable, #sd-enable').toggle();
				$.pnotify({
					title: data.title,
					icon: true,
					type: data.type,
					sticker: false
				});
				return false;
			}
		});
		return false;
	});
});
{/literal}