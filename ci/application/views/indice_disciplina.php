<div class="contenido">
	<div class="flagContainer">
		<p class="flag">
			<em>
				<?php _printf('Revistas del área de "%s" (%d documentos)', $current['disciplina'], $current['total']);?>
			</em>
		</p>
	</div>
	<div>
		<table border=0 cellpadding='0' cellspacing='0' class="resultados centrado">
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
					<td class="totalRight"><a class="enlace" href="<?php echo site_url("/revista/{$registro['revistaSlug']}");?>" title="<?php echo $registro['revista'];?>"><?php echo number_format($registro['articulos']);?></a></td>
				</tr>
<?php endforeach;?>
				<tr><td class='acumuladas' colspan=2><?php _e('Total:');?></td><td class='acumuladas'><?php echo number_format($registrosTotalArticulos);?></td></tr>
			</tbody>
		</table>
	</div>
</div>
