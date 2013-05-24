<div class="contenido">
	<form name="generarIndicador" id="generarIndicador" method="POST">
		<div class="colums">
			<div class="leftColumn">
				<select name="indicador" id="indicador" style="width:90%" data-placeholder="<?php _e('Seleccione indicador');?>">
				<option></option>
<?php foreach ($indicadores as $key => $value): ?>
					<option value="<?php echo $key;?>" <?php if($key == $indicador) echo "selected";?>><?php echo $value;?></option>
<?php endforeach;?>
				</select>
			</div>
			<div class="rightColumn">
				<select name="disciplina" id="disciplina" style="width:90%" data-placeholder="<?php _e('Seleccione una disciplina');?>">
				<option></option>
<?php foreach ($disciplinas as $disciplina):?>
					<option value="<?php echo $disciplina['id_disciplina'];?>"><?php echo $disciplina['disciplina'];?></option>
<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="colums" id="paisRevista">
			<div class="leftColumn">
				<select name="revista[]" id="revista" style="width:90%" disabled multiple data-placeholder="<?php _e('Seleccione una revista');?>">
					<option></option>
				</select>
				ó
			</div>
			<div class="rightColumn">
				<select name="pais[]" id="pais" style="width:90%" disabled multiple data-placeholder="<?php _e('Seleccione un país');?>">
					<option></option>
				</select>
			</div>
		</div>
		<div id="periodos" class="sliderPeriodo">
			<input id="sliderPeriodo" type="slider" name="periodo" value="0;0" />
		</div>
		<div>
			<input type="Submit" id="generate" value="<?php _e('Generar indicador');?>"/>
		</div>
		<div id="chart" style="width: 95%; height: 500px;">

		</div>
	</form>
</div>