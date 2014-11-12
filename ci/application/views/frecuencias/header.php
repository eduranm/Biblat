{literal}
		jQuery(document).ready(function(){
			var colM = <?=$colModel?>;
			var dataModel = {
				location: "remote",
				sorting: "remote",
				paging: "remote",
				dataType: "JSON",
				method: "POST",
				curPage: <?=$args['pagina'];?>,
				rPP: <?=$args['resultados'];?>,
				sortIndx: <?=$sortIndx;?>,
				sortDir: '<?php if($sortDir==="DESC"){echo "up";} else{echo "down";}?>',
				rPPOptions: [10, 20, 30, 40, 50, 100],
				getUrl: function () {
					var sortDir = (this.sortDir == "down") ? "asc" : "desc";
					var sort = <?=$sortBy?>;
					return { 
							url: "<?=current_url(1);?>/ordenar/" + sort[this.sortIndx] + "-" + sortDir + "/resultados/" + this.rPP + "/pagina/" + this.curPage, 
							data: "ajax=true"};
				},
				getData: function (dataJSON) {            
					return { curPage: dataJSON.curPage, totalRecords: dataJSON.totalRecords, data: dataJSON.data };               
				}
			}			
			
			grid = jQuery("div#gridTable").pqGrid({ width: 900, height: 400,
				dataModel: dataModel,
				colModel: colM,
				title: '<?=$gridTitle;?>',
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
		case 'institucion':
		case 'paisAfiliacion':
		case 'revista':
		case 'disciplina':
		case 'autor':?>
			jQuery("div#gridTable").on( "pqgridcellclick", function( event, ui ) {
				section = <?=$section?>;
				slug=ui.dataModel.data[ui.rowIndxPage][1];
				console.log("section:" + section);
				console.log("slug:" + slug);
				window.location.href = "<?=site_url($this->uri->segment(2).'/'.$this->uri->segment(3))?>" + "/" + slug + section[ui.colIndx];
			});
<?php 	break;
	case 'autorCoautoria':
	case 'institucionPais':
	case 'institucionRevista':
	case 'institucionAutor':
	case 'institucionDisciplina':
	case 'institucionCoautoria':
	case 'paisAfiliacionInstitucion':
	case 'paisAfiliacionAutor':
	case 'paisAfiliacionDisciplina':
	case 'paisAfiliacionCoautoria':
	case 'revistaAutor':
	case 'revistaInstitucion':
	case 'revistaAnio':
	case 'disciplinaPais':
	case 'disciplinaRevista':
	case 'disciplinaInstitucion':?>
			jQuery("div#gridTable").on( "pqgridrowclick", function( event, ui ) {
				slug=ui.dataModel.data[ui.rowIndxPage][1];
				if (/\d{4}/i.test(slug)) {
					slug = slug + "/1"
				}
				window.location.href = "<?=current_url()?>" + "/" + slug;
			});	
<?php 	break;
		endswitch;?>
			jQuery.contextMenu({
				selector: 'div#gridTable', 
				callback: function(key, options) {
					window.location.href = "<?=current_url(1);?>/export/excel"
				},
				items: {
					"excel": {name: "<?php _e('Exportar a excel');?>", icon: "excel"},
				}
			});
		});
{/literal}