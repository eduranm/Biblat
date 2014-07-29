	<link rel="stylesheet" href="<?php echo base_url();?>css/articulo.css" />
<?php if(ENVIRONMENT === "production"):?>
	<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=herz"></script>
<?php endif;?>
<?php if (isset($articulo)):?>
	<meta name="citation_title" content="<?php echo $articulo['articulo'];?>"/>
	<meta name="citation_journal_title" content="<?php echo $articulo['revista'];?>"/>
	<meta name="citation_issn" content="<?php echo $articulo['issn'];?>"/>
<?php 	if ( isset($articulo['numero']) ):?>
	<meta name="citation_issue" content="<?php echo $articulo['numero'];?>"/>
	<meta name="prism.number" content="<?php echo $articulo['numero'];?>"/>
<?php 	endif;?>
<?php 	if ( isset($articulo['volumen']) ):?>
	<meta name="citation_volume" content="<?php echo $articulo['volumen'];?>"/>
	<meta name="eprints.volume" content="<?php echo $articulo['volumen'];?>"/>
<?php 	endif;?>
<?php 	if ( isset($articulo['paginacion']) ):?>
	<meta name="citation_firstpage" content="<?php echo $articulo['paginacionFirst'];?>"/>
	<meta name="citation_lastpage" content="<?php echo $articulo['paginacionLast'];?>"/>
	<meta name="eprints.pagerange" content="<?php echo $articulo['paginacion'];?>">
	<meta name="prism.startingPage" content="<?php echo $articulo['paginacionFirst'];?>"/>
	<meta name="prism.endingPage" content="<?php echo $articulo['paginacionLast'];?>"/>
<?php 	endif;?>
<?php 	if ( isset($articulo['anio']) ):?>
	<meta name="citation_date" content="<?php echo $articulo['anio'];?>"/>
	<meta name="eprints.date" content="<?php echo $articulo['anio'];?>"/>
	<meta name="prism.publicationDate" content="<?php echo $articulo['anio'];?>"/>
	<meta name="dc.date" content="<?php echo $articulo['anio'];?>"/>
<?php 	endif;?>
	<meta name="eprints.title" content="<?php echo $articulo['articulo'];?>"/>
<?php 	if (isset($articulo['autores'])):
			$autoresTotal = count($articulo['autores']);
			$autorIndex = 1;
			$citation_authors = "";
			foreach ($articulo['autores'] as $autor):
				$citation_authors .= "{$autor}";
				if($autorIndex < $autoresTotal):
					$citation_authors .= "; ";
				endif;
				$autorIndex++;
?>
	<meta name="eprints.creators_name" content="<?php echo $autor;?>"/>
	<meta name="dc.creator" content="<?php echo $autor;?>"/>
<?php 		endforeach;?>
	<meta name="citation_authors" content="<?php echo $citation_authors;?>"/>
<?php	endif;?>
	<meta name="eprints.type" content="article"/>
	<meta name="eprints.ispublished" content="pub"/>
	<meta name="eprints.date_type" content="published"/>
	<meta name="eprints.publication" content="<?php echo $articulo['revista'];?>"/>
	<meta name="prism.publicationName" content="<?php echo $articulo['revista'];?>"/>
	<meta name="prism.issn" content="<?php echo $articulo['issn'];?>"/>
	<meta name="dc.title" content="<?php echo $articulo['articulo'];?>"/>
<?php endif;?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#formSolicitudDocumento').validate();
		});
	</script>
