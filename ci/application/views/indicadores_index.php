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
				<select name="disciplina" id="disciplina" style="width:90%" data-placeholder="<?php _e('Seleccione una disciplina');?>" <?php if($indicador == "") echo "disabled";?>>
				<option></option>
<?php foreach ($disciplinas as $kdisciplina => $disciplina):?>
					<option value="<?php echo $kdisciplina;?>"><?php echo $disciplina['disciplina'];?></option>
<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="colums" id="paisRevista" style="display:none;">
			<div class="orColumn"><?php _e('ó');?></div>
			<div class="leftColumn">
				<select name="revista[]" id="revista" style="width:90%" disabled multiple data-placeholder="<?php _e('Seleccione una o varias revistas');?>">
					<option></option>
				</select>
			</div>
			<div class="rightColumn">
				<select name="pais[]" id="pais" style="width:90%" disabled multiple data-placeholder="<?php _e('Seleccione uno o varios países');?>">
					<option></option>
				</select>
			</div>
		</div>
		<div id="periodos" class="sliderPeriodo" style="display:none;">
			<input id="sliderPeriodo" type="slider" name="periodo" value="0;0" />
		</div>
		<div id="tabs" style="display:none;">
			 <ul>
				<li class="chartTab"><a href="#charts"></a></li>
				<li class="gridTab"><a href="#grid"></a></li>
				<li class="infoTab"><a href="#info"></a></li>
			</ul>
			<div id="charts">
				<div id="chart" style="width: 1000px; height: 500px; display:none;"></div>
				<div id="bradfodContainer" style="display:none;">
					<ul id="bradfordSlide">
						<li>
							<div id="chartBradford"></div>
						</li>
						<li>
							<div id="chartGroup1"></div>
						</li>
						<li>
							<div id="chartGroup2"></div>
						</li>
					</ul>
				</div>
				<div id="prattContainer" style="display:none;">
					<ul id="prattSlide"></ul>
				</div>
			</div>
			<div id="grid"><ul id="tableSlide"></ul></div>
			<div id="info">Info</div>
		</div>
	</form>
</div>