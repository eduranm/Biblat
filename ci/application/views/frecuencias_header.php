	<link rel="stylesheet" href="<?php echo site_url("css/jquery-ui.min.css");?>" />
	<link rel="stylesheet" href="<?php echo site_url("js/pqgrid/pqgrid.dev.css");?>" />
	<link rel="stylesheet" href="<?php echo site_url("js/pqgrid/themes/Office/pqgrid.css");?>" />
	<link rel="stylesheet" href="<?php echo site_url("css/jquery.contextMenu.css");?>" />
	<link rel="stylesheet" href="<?php echo site_url("js/prettify/prettify.sunburst.css");?>" />
	<script type="text/javascript" src="<?php echo site_url("js/jquery-ui.min.js")?>"></script>
	<script type="text/javascript" src="<?php echo site_url("js/pqgrid/pqgrid.dev.js")?>"></script>
	<script type="text/javascript" src="<?php echo site_url("js/pqgrid/localize/pq-localize-es.js")?>"></script>
	<script type="text/javascript" src="<?php echo site_url("js/jquery-ui.min.js")?>"></script>
	<script type="text/javascript" src="<?php echo site_url("js/jquery.contextMenu.js")?>"></script>
	<script type="text/javascript" src="<?php echo site_url("js/prettify/prettify.js")?>"></script>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			var colM = <?php echo $colModel?>;
			var dataModel = {
				location: "remote",
				sorting: "remote",
				paging: "remote",
				dataType: "JSON",
				method: "POST",
				curPage: <?php echo $args['pagina'];?>,
				rPP: <?php echo $args['resultados'];?>,
				sortIndx: <?php echo $sortIndx;?>,
				sortDir: "up",
				rPPOptions: [10, 20, 30, 40, 50, 100],
				getUrl: function () {
					var sortDir = (this.sortDir == "down") ? "asc" : "desc";
					var sort = <?php echo $sortBy?>;
					return { 
							url: "<?php echo current_url(1);?>/ordenar/" + sort[this.sortIndx] + "-" + sortDir + "/resultados/" + this.rPP + "/pagina/" + this.curPage, 
							data: "ajax=true"};
				},
				getData: function (dataJSON) {            
					return { curPage: dataJSON.curPage, totalRecords: dataJSON.totalRecords, data: dataJSON.data };               
				}
			}			
			
			grid = jQuery("div#gridTable").pqGrid({ width: 900, height: 400,
				dataModel: dataModel,
				colModel: colM,
				title: '<?php echo $gridTitle;?>',
				resizable: false,           
				columnBorders: true,
				freezeCols: 2,
				flexHeight:true,
				flexWidth: true,
				selectionModel: { type: 'cell'}, 
				hoverMode:'cell'
			});
			grid.pqGrid("option", $.paramquery.pqGrid.regional['es']);
			grid.find(".pq-pager").pqPager("option", $.paramquery.pqPager.regional['es']);
<?php switch($this->uri->rsegment(2)):
		case 'autor':
?>
			jQuery("div#gridTable").on( "pqgridrowclick", function( event, ui ) {
				autorSlug=ui.dataModel.data[ui.rowIndxPage][1];
				window.location.href = "<?php echo site_url('frecuencias/autor')?>" + "/" + autorSlug;
			});
<?php 	break;
		case 'institucion':
		case 'paisAfiliacion':?>
			jQuery("div#gridTable").on( "pqgridcellclick", function( event, ui ) {
				section = <?php echo $section?>;
				slug=ui.dataModel.data[ui.rowIndxPage][1];
				window.location.href = "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" + "/" + slug + section[ui.colIndx];
			});
<?php 	break;
	case 'institucionPais':
	case 'institucionRevista':
	case 'institucionAutor':
	case 'paisAfiliacionInstitucion':
	case 'paisAfiliacionAutor':?>	
			jQuery("div#gridTable").on( "pqgridrowclick", function( event, ui ) {
				slug=ui.dataModel.data[ui.rowIndxPage][1];
				window.location.href = "<?php echo current_url()?>" + "/" + slug;
			});	
<?php 	break;
		endswitch;?>
			jQuery.contextMenu({
				selector: 'div#gridTable', 
				callback: function(key, options) {
					window.location.href = "<?php echo current_url(1);?>/export/excel"
				},
				items: {
					"excel": {name: "<?php _e('Exportar a excel');?>", icon: "excel"},
				}
			});
		});
	</script>