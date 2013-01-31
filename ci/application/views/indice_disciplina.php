<br class=navegacion><a href="<?php echo base_url();?>" target='_parent'><?php _e('Inicio');?></a>  Revistas por disciplina
<center>
	<p class=titulo><?php _printf('Revistas del área de "%s"', $registroDisciplina['disciplina']);?> </p>

	<div id=tablaresultados>
		<table border=0 cellpadding='0' cellspacing='0'>
			<caption title="<?php _e('Revistas indizadas en CLASE y PERIÓDICA según orden alfabético y número de documentos de cada revista');?>"></caption>
			<colgroup>
			<col id='noCol' />
			<col id='indbibCol' />
			<col id='totalCol' />
		</colgroup>
		<thead>
			<tr>
				<th scope='col'><?php _e('No.');?></th>
				<th scope='col'><?php _e('Revista');?></th>
				<th scope='col'><?php _e('Documentos');?></th>
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