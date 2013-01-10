	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.tagcanvas.js"></script>
	<script type="text/javascript" language="javascript">
		jQuery(document).ready(function()
		{
			if(! jQuery('#tagCloud').tagcanvas({
				textColour : '#000000',
				outlineThickness : 1,
				maxSpeed : 0.03,
				depth : 1.50,
				shape : 'sphere',
				dragControl : true,
				textHeight: 22,
				initial: [0.1,-0.1]
				})) {
				// TagCanvas failed to load
				jQuery('#tagCloudContainer').hide();
			}
		}); 
	</script>
