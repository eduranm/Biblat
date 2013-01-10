<br class=navegacion><a href="<?php echo base_url();?>" target='_parent'>Inicio</a>  Revistas por disciplina
<center>
	<p class=titulo>Revistas del área de "<?php echo $registroDisciplina['disciplina'];?>" </p>

	<div id=tablaresultados>
		<table border=0 cellpadding='0' cellspacing='0' summary='Revistas en orden alfab&eacute;tico'>
			<caption title="Revistas indizadas en CLASE y PERIÓDICA según orden alfab&eacute;tico y número de documentos de cada revista"></caption>
			<colgroup>
			<col id='noCol' />
			<col id='indbibCol' />
			<col id='totalCol' />
		</colgroup>
		<thead>
			<tr>
				<th scope='col'>No.</th>
				<th scope='col'>Revista</th>
				<th scope='col'>Documentos</th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($registros as $key => $registro):?>
		<tr class="registro">
			<td><?php echo ($key + 1);?></td>
			<td><?php echo $registro['revista'];?></td>
			<td class="totalRight"><a class="enlace" href="detalle_bib.php?tipobus=indices&index=revista&revista=<?php echo str_replace(" ", "+", $registro['revista']);?>&articulos=<?php echo $registro['articulos'];?>" title="<?php echo $registro['revista'];?>"><?php echo number_format($registro['articulos']);?></a></td>
		</tr>
<?php endforeach;?>
		<tr><td class='acumuladas' colspan=2>Total:</td><td class='acumuladas'><?php echo number_format($registrosTotalArticulos);?></td></tr>
	</tbody>
</table>
</div>
</center>