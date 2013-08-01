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
			<input id="sliderPeriodo" type="slider" name="periodo" value="0;0" disabled/>
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
			<div id="info">
				<div id="info-indice-coautoria" class="infoBox">
					<pre>

Este indicador muestra el número medio de autores por artículo.
El valor numérico indica el promedio de autores por documento.
	La formulación matemática es:
<div class="formula">
		<i>Ic</i> = <div class="fraction"><span class="fup"><i>Caf</i></span><span class="bar">/</span><span class="fdn"><i>Cd</i></span></div>
</div>					
	Donde:
	<i>Caf</i> = Cantidad de autores firmantes
	<i>Cd</i> = Cantidad de documentos
					</pre>
				</div>
				<div id="info-tasa-documentos-coautorados" class="infoBox">
					<pre>

Indicador que determina el promedio de artículos conautoría múltiple.
El valor numérico indica el promedio de artículos en coautoría.
	La formulación matemática es:
<div class="formula">
		<i>Tdc</i> = <div class="fraction"><span class="fup"><i>Cta</i></span><span class="bar">/</span><span class="fdn"><i>Ctd</i></span></div>
</div>					
	Donde:
	<i>Cta</i> = Cantidad total de documentos con autoría multiple
	<i>Ctd</i> = Cantidad total de documentos
					</pre>
				</div>
				<div id="info-grado-colaboracion" class="infoBox">
					<pre>

Indica el promedio de artículos con autoría múltiple.
El valor numérico indica el promedio de artículos con autoría múltiple.
	La formulación matemática es:
<div class="formula">
		<i>GC</i> = <div class="fraction"><span class="fup"><i>N<sub>m</sub></i></span><span class="bar">/</span><span class="fdn"><i>N<sub>m</sub> + N<sub>s</sub></i></span></div>
</div>					
	Donde:
	<i>N<sub>m</sub></i> = Total de documentos con autoría múltiple.
	<i>N<sub>s</sub></i> = =  Total de documentos escritos por un solo autor.
					</pre>
				</div>

				<div id="info-modelo-elitismo" class="infoBox">
					<pre>

Identifica la cantidad de autores que integran la elite de los más productivos.
El valor numérico representa la cantidad de los autores que integran dicha elite.
	La formulación matemática es:
<div class="formula">
		<i>E</i> = <span class="radical">&radic;</span><span class="radicand"><i>N</i></span>
</div>					
	Donde:
	<i>E</i> = Elite de autores que publican el 50% de los trabajos.
	<i>N</i> = Población total de autores.
					</pre>
				</div>

				<div id="info-indice-colaboracion" class="infoBox">
					<pre>

Proporciona el peso promedio del número de autores por artículo.
El valor numérico representa el promedio de coautores por artículo. Además de  visualizar la frecuencia del número de autores por artículo.
	La formulación matemática es:
<div class="formula">
		<i>IC</i> = <span class="intsuma"><span class="lim">N</span><span class="sum-frac">&sum;</span><span class="lim"><i>i</i>=1</span></span><div class="fraction"><span class="fup"><i>j<sub>i</sub> n<sub>j</sub></i></span><span class="bar">/</span><span class="fdn"><i>N</i></span></div>
</div>					
	Donde:
	<i>N</i> = Total de documentos.
	<i>j<sub>i</sub></i> = Número de firmas (autores) por documentos.
	<i>n<sub>i</sub></i> =  Cantidad de documentos con autoría múltiple.
					</pre>
				</div>

				<div id="info-indice-densidad-documentos" class="infoBox">
					<pre>

Índice que identifica los títulos con mayor cantidad de artículos.
El valor numérico proporciona la cantidad de artículos por revista o por año.
	La formulación matemática es:
<div class="formula">
		<i>p</i> = <div class="fraction"><span class="fup"><i>Rn</i></span><span class="bar">/</span><span class="fdn"><i>N</i></span></div>
</div>					
	Donde:
	<i>Rn</i> = &sum; Artículos.
	<i>N</i> = &sum; Títulos de revistas.
					</pre>
				</div>

				<div id="info-indice-concentracion" class="infoBox">
					<pre>

Indica el grado de especialización de las revistas.
El valor numérico representa el nivel de concentración temática basándose en sus descriptores. 
Se muestra la frecuencia de descriptores.
	La formulación matemática es:
<div class="formula">
		<i>C</i> = <div class="fraction"><span class="fup">2[(<i>n</i>+1/2)-<i>q</i>]</span><span class="bar">/</span><span class="fdn"><i>n</i>-1</span></div>
</div>					
	Donde:
	<i>C</i> = Índice de concentración de Pratt.
	<i>n</i> = Número de categorías.
	<i>q</i> = &sum; del producto del rango por la frecuencia de una categoría dada, 
              dividido por la cantidad de ítems en todas las categorías.
					</pre>
				</div>

				<div id="info-modelo-bradford-revista" class="infoBox">
					<pre>

Modelo matemático que identifica el núcleo de revistas más productivas por temática.
Se identifican tres zonas según su nivel de productividad para la disciplina: 
	La zona Núcleo, la 2° y 3°, los títulos y la cantidad artículos que han publicado. 
Se muestra la frecuencia de descriptores.
	La formulación matemática es:
<div class="formula">
		<i>p</i>:<i>p</i><sub>1</sub>:<i>p</i><sub>2</sub>:1:<i>n</i><sub>1</sub>:<i>n</i><sub>2</sub>
</div>					
	Donde:
	<i>p</i> = Cantidad de títulos por disciplinas del conocimiento y países.
	<i>n</i> = Multiplicador o factor de proporcionalidad detítulos entre las disciplinas.
					</pre>
				</div>

				<div id="info-modelo-bradford-institucion" class="infoBox">
					<pre>

Modelo matemático que proporciona el núcleo de instituciones más productivas.
Se identifican tres zonas según su nivel de productividad para la disciplina: 
	La zona Núcleo, la 2° y 3°, los títulos y la cantidad artículos que han publicado. 
Se muestra la frecuencia de descriptores.
	La formulación matemática es:
<div class="formula">
		<i>p</i>:<i>p</i><sub>1</sub>:<i>p</i><sub>2</sub>:1:<i>n</i><sub>1</sub>:<i>n</i><sub>2</sub>
</div>					
	Donde:
	<i>p</i> = Cantidad de títulos por disciplinas del conocimiento y países.
	<i>n</i> = Multiplicador o factor de proporcionalidad detítulos entre las disciplinas.
					</pre>
				</div>

				<div id="info-productividad-exogena" class="infoBox">
					<pre>

Indicador que mide el grado de internacionalización de las revistas.
El valor numérico indica la proporción de autores extranjeros que han publicado en la revista.
Se muestra la frecuencia de descriptores.
	La formulación matemática es:
<div class="formula">
		<i>PEx</i>:
</div>					
	Donde:
					</pre>
				</div>
			</div>
		</div>
	</form>
</div>