<div class="contenido">
	<select name="indicador" id="indicador" style="width:450px" tabindex="-1">
		<option></option>
<?php foreach ($indicadores as $key => $value): ?>
		<option value="<?php echo $key;?>" <?php if($key == $indicador) echo "selected";?>><?php echo $value;?></option>
<?php endforeach;?>
	</select>
	<div id="revistas">
		<select name="disciplina" id="disciplina" style="width:450px" tabindex="-1">
			<option></option>
<?php foreach ($disciplinas as $disciplina):?>
			<option value="<?php echo $disciplina['id_disciplina'];?>"><?php echo $disciplina['disciplina'];?></option>
<?php endforeach;?>
		</select>
		<select name="revista" id="revista" style="width:450px" tabindex="-1" disabled>
			<option></option>
		</select>
	</div>
</div>