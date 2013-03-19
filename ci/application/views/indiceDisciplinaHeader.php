	<link rel="stylesheet" href="<?php echo base_url();?>css/estiloBiblatresultados.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/colorbox.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/colorboxIndices.css" />
	<script type="text/javascript" src="<?php echo base_url();?>js/colorbox.js"></script>
	<script type="text/javascript">
		jQuery.noConflict();
		jQuery(document).ready(function() {
			jQuery(".registro").colorbox({
				rel:"registro", 
				transition:"fade", 
				iframe:true, 
				width:"50%", 
				height:"90%", 
				current:"registro {current} de {total}",
				href: function(){
					var url = jQuery(this).find("a.enlace").attr('href');
					return url;
				},
				title: function(){
					var url = jQuery(this).find("a.enlace").attr('title');
					return url;
				}
			});
		});
	</script>