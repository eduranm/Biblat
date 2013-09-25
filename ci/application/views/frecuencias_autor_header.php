	<link rel="stylesheet" href="<?php echo site_url("css/jquery-ui.min.css");?>" />
	<link rel="stylesheet" href="<?php echo site_url("js/pqgrid/pqgrid.dev.css");?>" />
	<link rel="stylesheet" href="<?php echo site_url("js/pqgrid/themes/Office/pqgrid.css");?>" />
	<script type="text/javascript" src="<?php echo site_url("js/jquery-ui.min.js")?>"></script>
	<script type="text/javascript" src="<?php echo site_url("js/pqgrid/pqgrid.dev.js")?>"></script>
	<script type="text/javascript" src="<?php echo site_url("js/pqgrid/localize/pq-localize-es.js")?>"></script>
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
				title: "Frecuencia de documentos por autor",
				resizable: false,           
				columnBorders: true,
				freezeCols: 2,
				flexHeight:true,
				flexWidth: true,
			});
			grid.pqGrid("option", $.paramquery.pqGrid.regional['es']);
			grid.find(".pq-pager").pqPager("option", $.paramquery.pqPager.regional['es']);

			jQuery("div#gridTable").on( "pqgridrowclick", function( event, ui ) {
				autorSlug=ui.dataModel.data[ui.rowIndxPage][1];
				window.location.href = "<?php echo site_url('frecuencias/autor')?>" + "/" + autorSlug;
			});
		});
	</script>