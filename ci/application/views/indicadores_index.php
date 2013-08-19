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
			<div class="orColumn" id="orPaisRevistaColumn"><?php _e('ó');?></div>
			<div class="leftColumn">
				<select name="revista[]" id="revista" style="width:90%" disabled multiple data-placeholder="<?php _e('Seleccione una o varias revistas');?>">
					<option></option>
				</select>
			</div>
			<div class="rightColumn">
				<select name="pais[]" id="pais" style="width:90%" disabled multiple data-placeholder="<?php _e('Seleccione uno o varios países de la revista');?>">
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
				<div id="chartContainer">
					<div id="chartTitle"></div>
					<div id="chart" style="width: 1000px; height: 500px;"></div>
				</div>
				<div id="bradfodContainer" style="display:none;">
					<ul id="bradfordSlide">
						<li>
							<div id="bradfordTitle"></div>
							<div id="chartBradford"></div> 
						</li>
						<li>
							<div id="group1Title"></div>
							<div id="chartGroup1"></div>
						</li>
						<li>
							<div id="group2Title"></div>
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
					<p class="textoL">
						Este indicador muestra el número medio de autores por artículo.<br/>
						El valor numérico indica el promedio de autores por documento.
					</p>
					<p class="textoL ident1">La formulación matemática es:</p>
					<div class="textoL ident2 formula">
						<span><i>Ic</i> = </span>
						<div class="fraction">
							<span class="fup"><i>Caf</i></span>
							<span class="bar">/</span>
							<span class="fdn"><i>Cd</i></span>
						</div>
					</div>
					<p class="textoL ident1">
						Donde:<br/>
						<i>Caf</i> = Cantidad de autores firmantes<br/>
						<i>Cd</i> = Cantidad de documentos
					</p>
				</div>

				<div id="info-tasa-documentos-coautorados" class="infoBox">
					<p class="textoL">
						Indicador que determina el promedio de artículos conautoría múltiple.<br/>
						El valor numérico indica el promedio de artículos en coautoría.
					</p>
					<p class="textoL ident1">La formulación matemática es:</p>
					<div class="textoL ident2 formula">
							<i>Tdc</i> = 
							<div class="fraction">
								<span class="fup"><i>Cta</i></span>
								<span class="bar">/</span>
								<span class="fdn"><i>Ctd</i></span>
							</div>
					</div>
					<p class="textoL ident1">
						Donde:<br/>
						<i>Cta</i> = Cantidad total de documentos con autoría multiple<br/>
						<i>Ctd</i> = Cantidad total de documentos
					</p>
				</div>

				<div id="info-grado-colaboracion" class="infoBox">
					<p class="textoL">
						Indica el promedio de artículos con autoría múltiple.<br/>
						El valor numérico indica el promedio de artículos con autoría múltiple.
					</p>
					<p class="textoL ident1">La formulación matemática es:</p>
					<div class="textoL formula ident2">
							<i>GC</i> = 
							<div class="fraction">
								<span class="fup"><i>N<sub>m</sub></i></span>
								<span class="bar">/</span>
								<span class="fdn"><i>N<sub>m</sub> + N<sub>s</sub></i></span>
							</div>
					</div>
					<p class="textoL ident2">
						Donde:<br/>
						<i>N<sub>m</sub></i> = Total de documentos con autoría múltiple.<br/>
						<i>N<sub>s</sub></i> = =  Total de documentos escritos por un solo autor.
					</p>
				</div>

				<div id="info-modelo-elitismo" class="infoBox">
					<p class="textoL">
						Identifica la cantidad de autores que integran la elite de los más productivos.<br/>
						El valor numérico representa la cantidad de los autores que integran dicha elite.
					</p>
					<p class="textoL ident1">La formulación matemática es:</p>
					<div class="textoL ident2 formula">
							<i>E</i> = 
							<span class="radical">&radic;</span><span class="radicand"><i>N</i></span>
					</div>
					<p class="textoL ident1">
						Donde:<br/>
						<i>E</i> = Elite de autores que publican el 50% de los trabajos.<br/>
						<i>N</i> = Población total de autores.
					</p>					
				</div>

				<div id="info-indice-colaboracion" class="infoBox">
					<p class="textoL">
						Proporciona el peso promedio del número de autores por artículo.<br/>
						El valor numérico representa el promedio de coautores por artículo.<br/>
						Además de  visualizar la frecuencia del número de autores por artículo.
					</p>
					<p class="textoL ident1">La formulación matemática es:</p>
					<div class="textoL ident2 formula">
							<i>IC</i> = 
							<span class="intsuma">
								<span class="lim">N</span>
								<span class="sum-frac">&sum;</span>
								<span class="lim"><i>i</i>=1</span>
							</span>
							<div class="fraction">
								<span class="fup"><i>j<sub>i</sub> n<sub>j</sub></i></span>
								<span class="bar">/</span>
								<span class="fdn"><i>N</i></span>
							</div>
					</div>
					<p class="textoL ident1">
						Donde:<br/>
						<i>N</i> = Total de documentos.<br/>
						<i>j<sub>i</sub></i> = Número de firmas (autores) por documentos.<br/>
						<i>n<sub>i</sub></i> =  Cantidad de documentos con autoría múltiple.
					</p>				
				</div>

				<div id="info-indice-densidad-documentos" class="infoBox">
					<p class="textoL">
						Índice que identifica los títulos con mayor cantidad de artículos.<br/>
						El valor numérico proporciona la cantidad de artículos por revista o por año.
					</p>
					<p class="textoL ident1">La formulación matemática es:</p>
					<div class="textoL ident2 formula">
							<i>p</i> = 
							<div class="fraction">
								<span class="fup"><i>Rn</i></span>
								<span class="bar">/</span>
								<span class="fdn"><i>N</i></span>
							</div>
					</div>
					<p class="textoL ident1">
						Donde:<br/>
						<i>Rn</i> = &sum; Artículos.<br/>
						<i>N</i> = &sum; Títulos de revistas.
					</p>
				</div>

				<div id="info-indice-concentracion" class="infoBox">
					<p class="textoL">
						Indica el grado de especialización de las revistas.<br/>El valor numérico representa el nivel de concentración temática basándose en sus descriptores.<br/>
						Se muestra la frecuencia de descriptores.
					</p>
					<p class="textoL ident1">La formulación matemática es:</p>
					<div class="textoL ident2 formula">
							<i>C</i> = 
							<div class="fraction">
								<span class="fup">2{[(<i>n</i>+1)/2]-<i>q</i>}</span>
								<span class="bar">/</span>
								<span class="fdn"><i>n</i>-1</span>
							</div>
					</div>
					<p class="textoL ident1">
						Donde:<br/>
						<i>C</i> = Índice de concentración de Pratt.<br/>
						<i>n</i> = Número de categorías.<br/>
						<i>q</i> = &sum; del producto del rango por la frecuencia de una categoría dada, <br/>dividido por la cantidad de ítems en todas las categorías.
					</p>				
				</div>

				<div id="info-modelo-bradford-revista" class="infoBox">
					<p class="textoL">
						Modelo matemático que identifica el núcleo de revistas más productivas por temática.<br/>
						Se identifican tres zonas según su nivel de productividad para la disciplina:<br/>
						La zona Núcleo, la 2° y 3°, los títulos y la cantidad artículos que han publicado.<br/>
						Se muestra la frecuencia de descriptores.
					</p>
					<p class="textoL ident1">La formulación matemática es:</p>
					<div class="textoL ident2 formula">
							<i>p</i>:<i>p</i><sub>1</sub>:<i>p</i><sub>2</sub>:1:<i>n</i><sub>1</sub>:<i>n</i><sub>2</sub>
					</div>
					<p class="textoL ident1">
						Donde:<br/>
						<i>p</i> = Cantidad de títulos por disciplinas del conocimiento y países.<br/>
						<i>n</i> = Multiplicador o factor de proporcionalidad de títulos entre las disciplinas.
					</p>
				</div>

				<div id="info-modelo-bradford-institucion" class="infoBox">
					<p class="textoL">
						Modelo matemático que proporciona el núcleo de instituciones más productivas.<br/>
						Se identifican tres zonas según su nivel de productividad para la disciplina:<br/>
						La zona Núcleo, la 2° y 3°, los títulos y la cantidad artículos que han publicado.<br/>
						Se muestra la frecuencia de descriptores.
					</p>
					<p class="textoL ident1">La formulación matemática es:</p>
					<div class="textoL ident2 formula">
							<i>p</i>:<i>p</i><sub>1</sub>:<i>p</i><sub>2</sub>:1:<i>n</i><sub>1</sub>:<i>n</i><sub>2</sub>
					</div>
					<p class="textoL ident1">
						Donde:<br/>
						<i>p</i> = Cantidad de títulos por disciplinas del conocimiento y países.<br/>
						<i>n</i> = Multiplicador o factor de proporcionalidad detítulos entre las disciplinas.
					</p>
				</div>

				<div id="info-productividad-exogena" class="infoBox">
					<p class="textoL">
						Indicador que mide el grado de internacionalización de las revistas.<br/>
						El valor numérico indica la proporción de autores extranjeros que han publicado en la revista.<br/>
						Se muestra la frecuencia de descriptores.
					</p>
					<p class="textoL ident1">La formulación matemática es:</p>
					<div class="formula">
							<i>PEx</i>:
					</div>
					<p class="textoL ident1">Donde:</p>
				</div>
			</div>
		</div>
	</form>
	<div id="floatTableContainer"><div id="floatTable"></div><div id="toolbar_div"></div></div>
</div>