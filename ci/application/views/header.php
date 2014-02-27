<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if(isset($description)):?>
	<meta name="description" content="<?=$description;?>" /> 
<?php endif;?>
	<title><?=$title;?></title>
	<link rel="icon" href="<?=base_url('img/favicon.ico');?>" type="image/x-icon"/>
	<link rel="stylesheet" href="<?=base_url('css/estiloBiblat.css');?>" type="text/css" />
	<link rel="stylesheet" href="<?=base_url('css/font-awesome.min.css');?>" type="text/css" />
	<link rel="stylesheet" href="<?=base_url('css/jquery-ui.min.css');?>" type="text/css" />
	<link rel="stylesheet" href="<?=base_url('js/pnotify/jquery.pnotify.default.css');?>" type="text/css" />
	<link rel="stylesheet" href="<?=base_url('css/default.css');?>" type="text/css" />
	<script type="text/javascript" src="<?=base_url('js/jquery.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('js/jquery.validate.min.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('js/jquery.autosize.min.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('js/jquery-ui.min.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('js/jquery.blockUI.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('js/pnotify/jquery.pnotify.min.js');?>"></script>
	<script type="text/javascript">
		var addthis_config = addthis_config||{};
		addthis_config.data_track_addressbar = false;
		addthis_config.data_track_clickback = false;
		addthis_config.ui_language = "<?=lang_iso_code();?>";
	</script>
	<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=herz"></script>
	<script type="text/javascript" language="javascript">
		loading = {
			start: function(){
				jQuery.blockUI({ 
					message: '<h2 style="white-space:nowrap;"><img src="<?=base_url('img/loading.gif');?>" /><br /><?php _e('Espere un momento...');?></h2>',
					css: { 
						color: '#000', 
						backgroundColor:'#FBFCEF', 
						opacity: 0.6, 
						border: '2px solid #114D66',
						cursor: 'wait'
					},
					baseZ: 9000,
					onBlock: function(){
						loading.status=true;
					},
					onUnblock: function(){
						loading.status=false;
					}
				});
			},
			end: function(){
				jQuery.unblockUI();
			},
			status: false
		}; 
		jQuery.pnotify.defaults.history = false;
		jQuery.pnotify.defaults.styling = "jqueryui";
		jQuery(document).bind("contextmenu",function(e){
			return false;
		});
		jQuery(document).ready(function()
		{
<?php  
	if ( lang_notification() ):
		$broserLang = get_browser_lang();
?>
			jQuery.ajax({
				url: '<?=base_url("{$broserLang}/main/lang_notification");?>',
				dataType: 'json',
				success: function(data) {
					jQuery.pnotify({
						title: data.message + '  ' + data.button,
						icon: true,
						addclass: "stack-bar-top",
						type: 'info',
						sticker: false,
						animation: 'slide',
						cornerclass: "",
						width: "100%"
					});
				}
			});
			jQuery(document).on('click', '.translate', function(e) {
				location = '<?=site_url($this->lang->switch_uri($broserLang));?>';
			});
<?php endif;?>
			jQuery("#options").click(function(e) {
				jQuery(".optionsMenu").toggle();
				return false;
			});
			jQuery(".optionsMenu li").click(function(e) {
				var button = jQuery(this).attr('rel');
				jQuery('#options').attr('class', 'icon-'+button);
				jQuery('#filtro').val(button);
				jQuery(".optionsMenu").toggle();
				console.log(button);
			});
			jQuery('.searchform #slug').keypress(function(e) {
				if(e.which == 13) {
					jQuery('.searchform').submit();
					return false;
				}
			});
			jQuery('.searchform').submit(function(e) {
				var data = jQuery(this).serializeArray();
				data.push({name: "ajax", value: true});
				jQuery.ajax({
					url: '<?=site_url('buscar');?>',
					type: 'POST',
					data: jQuery.param(data),
					success: function(data) {
						window.location = data;
						return false;
					}
				});
				return false;
			});
			jQuery('textarea').autosize();
			jQuery('body').click(function(e) {
				jQuery(".optionsMenu").hide();
			});
			jQuery('body').on('click', '#solicitudDocumento', function(e) {
				jQuery('.solicitudDocumento, #sd-disable, #sd-enable').toggle();
			});
			jQuery('body').on('click', '#showmap', function(e) {
				jQuery('#mapa-anexo').toggle();
			});
			jQuery('body').on('submit', '#formSolicitudDocumento', function(e) {
				if(!loading.status){
					loading.start();
				}
				console.log(jQuery(this).attr("action"));
				jQuery.ajax({
					url: jQuery(this).attr("action"),
					type: 'POST',
					data: jQuery(this).serialize(),
					success: function(data) {
						console.log(data)
						loading.end();
						jQuery('input:text').each(function(){
							jQuery(this).val('');
						});
						jQuery('.solicitudDocumento, #sd-disable, #sd-enable').toggle();
						jQuery.pnotify({
							title: '<?php _e('La solicitud ha sido enviada');?>',
							icon: true,
							type: 'success',
							sticker: false
						});
						return false;
					}
				});
				return false;
			});
		});
	</script>
<?php if(ENVIRONMENT === "production"):?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-33940112-1']);
		_gaq.push(['_trackPageview']);

		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
<?php endif;?>
<?php 
if(isset($content)):
	echo $content;
endif;
?>
</head>
<body>
	<div class="wrapper">