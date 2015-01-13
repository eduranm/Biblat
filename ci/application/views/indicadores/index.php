<div class="row">	
	<form name="generarIndicador" id="generarIndicador" method="POST">
		<div class="col-md-6 form-group">
			<select name="indicador" id="indicador" class="form-control" data-placeholder="<?php _e('Seleccione indicador');?>">
			<option></option>
<?php foreach ($indicadores as $key => $value): ?>
				<option value="<?=$key;?>" <?php if($key == $indicador) echo "selected";?>><?=$value;?></option>
<?php endforeach;?>
			</select>
		</div>
		<div class="col-md-6 form-group">
			<select name="disciplina" id="disciplina" class="form-control" data-placeholder="<?php _e('Seleccione una disciplina');?>" <?php if($indicador == "") echo "disabled";?>>
			<option></option>
<?php foreach ($disciplinas as $kdisciplina => $disciplina):?>
				<option value="<?=$kdisciplina;?>"><?=$disciplina['disciplina'];?></option>
<?php endforeach;?>
			</select>
		</div>
		<div class="clearfix"></div>
		<div id="paisRevistaDiv" class="hidden">
			<div class="col-md-6 form-group">
				<select name="revista[]" id="revista" class="form-control" disabled multiple data-placeholder="<?php _e('Seleccione una o varias revistas');?>">
					<option></option>
				</select>
			</div>
			<div class="col-md-6 form-group">
				<select name="paisRevista[]" id="paisRevista" class="form-control" disabled multiple data-placeholder="<?php _e('Seleccione uno o varios países de la revista');?>">
					<option></option>
				</select>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-6 form-group">
				<select name="paisAutor[]" id="paisAutor" class="form-control" disabled multiple data-placeholder="<?php _e('Seleccione uno o varios países de la afiliación del autor');?>">
					<option></option>
				</select>
			</div>
		</div>
		<div class="clearfix"></div>
		<div id="periodos" class="col-md-12 form-group hidden">
			<input id="sliderPeriodo" type="slider" name="periodo" value="0;0" disabled/>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-12" id="tab-chars">
			<div id="tabs" style="display:none;">
				<ul>
					<li><a href="#charts"><i class="fa fa-line-chart"></i> {_('Gráfica')}</a></a></li>
					<li><a href="#grid"><i class="fa fa-table"></i> {_('Tabla')}</a></li>
					<li><a href="#info"><i class="fa fa-cogs"></i> {_('Metodología')}</a></li>
				</ul>
				<div id="charts">
					<div id="chartContainer">
						<div id="chartTitle"></div>
						<div id="chart" class="chart_data"></div>
						<div class="chartCopyright">
							<?php _e('Fuente:');?> <a href="<?=base_url();?>">biblat.unam.mx</a>
						</div>
					</div>
					<div id="bradfodContainer" style="display:none;">
						<div id="carousel-bradford" class="carousel slide" data-ride="carousel">
						  <!-- Indicators -->
						  <ol class="carousel-indicators">
						    <li data-target="#carousel-bradford" data-slide-to="0" class="active"></li>
						    <li data-target="#carousel-bradford" data-slide-to="1"></li>
						    <li data-target="#carousel-bradford" data-slide-to="2"></li>
						  </ol>

						  <!-- Wrapper for slides -->
						  <div class="carousel-inner" role="listbox">
						    <div class="item active">
						    	<div id="bradfordTitle"></div>
								<div id="chartBradford" class="chart_data"></div> 
						    </div>
						    <div class="item">
						     	<div id="group1Title"></div>
								<div id="chartGroup1" class="chart_data"></div>
						    </div>
						    <div class="item">
						    	<div id="group2Title"></div>
								<div id="chartGroup2" class="chart_data"></div>
						    </div>
						  </div>

						  <!-- Controls -->
						  <a class="left carousel-control" href="#carousel-bradford" role="button" data-slide="prev">
						    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"><i class="fa fa-chevron-circle-left"></i></span>
						    <span class="sr-only">Previous</span>
						  </a>
						  <a class="right carousel-control" href="#carousel-bradford" role="button" data-slide="next">
						    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"><i class="fa fa-chevron-circle-right"></i></span>
						    <span class="sr-only">Next</span>
						  </a>
						</div>
						<div class="chartCopyright">
							<?php _e('Fuente:');?> <a href="<?=base_url();?>">biblat.unam.mx</a>
						</div>
					</div>
					<div id="prattContainer" style="display:none;">
						<div id="carousel-pratt" class="carousel slide" data-ride="carousel">
						  <!-- Indicators -->
						  <ol class="carousel-indicators">
						  </ol>

						  <!-- Wrapper for slides -->
						  <div class="carousel-inner" role="listbox">
						  </div>

						  <!-- Controls -->
						  <a class="left carousel-control" href="#carousel-pratt" role="button" data-slide="prev">
						    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"><i class="fa fa-chevron-circle-left"></i></span>
						    <span class="sr-only">Previous</span>
						  </a>
						  <a class="right carousel-control" href="#carousel-pratt" role="button" data-slide="next">
						    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"><i class="fa fa-chevron-circle-right"></i></span>
						    <span class="sr-only">Next</span>
						  </a>
						</div>
						<div class="chartCopyright">
							<?php _e('Fuente:');?> <a href="<?=base_url();?>">biblat.unam.mx</a>
						</div>
					</div>
				</div>
				<div id="grid"><div id="gridContainer"></div></div>
				<div id="info">
					<div id="info-indice-coautoria" class="infoBox">
						<h4 class="text-center"><?php _e('Índice de Coautoría');?></h4>
						<p class="text-left">
							<?php _e('Este indicador muestra el número promedio de autores por artículo.');?>
						</p>
						<p class="text-left ident1"><?php _e('La formulación matemática es:');?></p>
						<div class="text-left ident2 formula">
							<span><i>Ic</i> = </span>
							<div class="fraction">
								<span class="fup"><i>Caf</i></span>
								<span class="bar">/</span>
								<span class="fdn"><i>Cd</i></span>
							</div>
						</div>
						<p class="text-left ident1">
							<?php _e('Donde:');?><br/>
							<i>Caf</i> = <?php _e('Cantidad de autores firmantes');?><br/>
							<i>Cd</i> = <?php _e('Cantidad de documentos');?>
						</p>
					</div>

					<div id="info-tasa-documentos-coautorados" class="infoBox">
						<h4 class="text-center"><?php _e('Tasa de Documentos Coautorados');?></h4>
						<p class="text-left">
							<?php _e('El valor numérico indica la proporción de artículos con autoría múltiple.');?>
						</p>
						<p class="text-left ident1"><?php _e('La formulación matemática es:');?></p>
						<div class="text-left ident2 formula">
								<i>Tdc</i> = 
								<div class="fraction">
									<span class="fup"><i>Cta</i></span>
									<span class="bar">/</span>
									<span class="fdn"><i>Ctd</i></span>
								</div>
						</div>
						<p class="text-left ident1">
							<?php _e('Donde:');?><br/>
							<i>Cta</i> = <?php _e('Cantidad total de documentos con autoría multiple');?><br/>
							<i>Ctd</i> = <?php _e('Cantidad total de documentos');?>
						</p>
						<p class="text-left">
							<?php _e('Se interpreta que valores cercanos a 1 muestran mayor cantidad de documentos en coautoría.');?>
						</p>
					</div>

					<div id="info-grado-colaboracion" class="infoBox">
						<h4 class="text-center"><?php _e('Grado de Colaboración (Índice de Subramanyan)');?></h4>
						<p class="text-left">
							<?php _e('El valor numérico indica la proporción de artículos con autoría múltiple.');?>
						</p>
						<p class="text-left ident1"><?php _e('La formulación matemática es:');?></p>
						<div class="text-left formula ident2">
								<i>GC</i> = 
								<div class="fraction">
									<span class="fup"><i>N<sub>m</sub></i></span>
									<span class="bar">/</span>
									<span class="fdn"><i>N<sub>m</sub> + N<sub>s</sub></i></span>
								</div>
						</div>
						<p class="text-left ident2">
							<?php _e('Donde:');?><br/>
							<i>N<sub>m</sub></i> = <?php _e('Total de documentos con autoría múltiple.');?><br/>
							<i>N<sub>s</sub></i> = <?php _e('Total de documentos escritos por un solo autor.');?>
						</p>
						<p class="text-left">
							<?php _e('Se interpreta que valores cercanos a 0 muestran un fuerte componente de autoría simple, mientras que los cercanos a 1 denotan una fuerte proporción de autoría múltiple.');?>
						</p>
					</div>

					<div id="info-modelo-elitismo" class="infoBox">
						<h4 class="text-center"><?php _e('Modelo de Elitismo (Price)');?></h4>
						<p class="text-left">
							<?php _e('Identifica la cantidad de autores que integran la elite de los más productivos por revista o país de publicación de la revista.');?><br/>
							<?php _e('El valor numérico representa la cantidad de los autores que integran dicha elite.');?>
						</p>
						<p class="text-left ident1"><?php _e('La formulación matemática es:');?></p>
						<div class="text-left ident2 formula">
								<i>E</i> = 
								<span class="radical">&radic;</span><span class="radicand"><i>N</i></span>
						</div>
						<p class="text-left ident1">
							<?php _e('Donde:');?><br/>
							<i>E</i> = <?php _printf('Elite de autores que publican el 50%% de los trabajos.');?><br/>
							<i>N</i> = <?php _e('Población total de autores.');?>
						</p>					
					</div>

					<div id="info-indice-colaboracion" class="infoBox">
						<h4 class="text-center"><?php _e('Índice de Colaboración (Índice de Lawani)');?></h4>
						<p class="text-left">
							<?php _e('Proporciona el peso promedio del número de autores por artículo.');?><br/>
							<?php _e('El valor numérico representa el promedio de autores por artículo.');?><br/>
							<?php _e('Además de  visualizar la frecuencia del número de autores por artículo.');?>
						</p>
						<p class="text-left ident1"><?php _e('La formulación matemática es:');?></p>
						<div class="text-left ident2 formula">
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
						<p class="text-left ident1">
							<?php _e('Donde:');?><br/>
							<i>N</i> = <?php _e('Total de documentos.');?><br/>
							<i>j<sub>i</sub></i> = <?php _e('Número de firmas (autores) por documentos.');?><br/>
							<i>n<sub>i</sub></i> =  <?php _e('Cantidad de documentos con autoría múltiple.');?>
						</p>				
					</div>

					<div id="info-indice-densidad-documentos" class="infoBox">
						<h4 class="text-center"><?php _e('Índice de Densidad de Documentos Zakutina y Priyenikova');?></h4>
						<p class="text-left">
							<?php _e('Índice que identifica los títulos con mayor densidad de información.');?><br/>
							<?php _e('El valor numérico proporciona la cantidad de artículos por revista.');?>
						</p>
						<p class="text-left ident1"><?php _e('La formulación matemática es:');?></p>
						<div class="text-left ident2 formula">
								<i>p</i> = 
								<div class="fraction">
									<span class="fup"><i>Rn</i></span>
									<span class="bar">/</span>
									<span class="fdn"><i>N</i></span>
								</div>
						</div>
						<p class="text-left ident1">
							<?php _e('Donde');?>:<br/>
							<i>Rn</i> = &sum; <?php _e('Artículos');?>.<br/>
							<i>N</i> = &sum; <?php _e('Títulos de revistas');?>.
						</p>
					</div>

					<div id="info-indice-concentracion" class="infoBox">
						<h4 class="text-center"><?php _e('Índice de concentración (Índice de Pratt)');?></h4>
						<p class="text-justify">
							<?php _e('Indica el grado de concentración temática de las revistas.');?><br/>
							<?php _e('El valor numérico representa el nivel de concentración temática basándose en sus descriptores.');?><br/>
							<?php _e('Se muestra la frecuencia de descriptores.');?>
						</p>
						<p class="text-left ident1"><?php _e('La formulación matemática es:');?></p>
						<div class="text-left ident2 formula">
								<i>C</i> = 
								<div class="fraction">
									<span class="fup">{literal}2{[(<i>n</i>+1)/2]-<i>q</i>}{/literal}</span>
									<span class="bar">/</span>
									<span class="fdn"><i>n</i>-1</span>
								</div>
						</div>
						<p class="text-left ident1">
							<?php _e('Donde:');?><br/>
							<i>C</i> = <?php _e('Índice de concentración de Pratt.');?><br/>
							<i>n</i> = <?php _e('Número de categorías.');?><br/>
							<i>q</i> = <?php _e('&sum; del producto del rango por la frecuencia de una categoría dada, dividido por la cantidad de ítems en todas las categorías.');?>
						</p>
						<p class="text-justify">
							<?php _e('Se interpreta que valores cercanos a 1 muestran mayor grado de especialización.');?>
						</p>				
					</div>

					<div id="info-modelo-bradford-revista" class="infoBox">
						<h4 class="text-center"><b><?php _e('Modelo matemático de Bradford');?></b><br/><?php _e('Distribución de artículos por revista');?></h4>
						<p class="text-left">
							<?php _e('Modelo matemático que identifica el núcleo de revistas con mayor cantidad de información por temática.');?><br/>
							<?php _e('Se identifican tres zonas según la cantidad de artículos por revista en la  disciplina:');?><br/>
							<?php _e('La zona Núcleo, la 2° y 3°, los títulos y la cantidad artículos que han publicado.');?><br/>
							<?php _e('Se muestra la frecuencia de artículos por revista de la disciplina.');?> 
						</p>
						<p class="text-left ident1"><?php _e('La formulación matemática es:');?></p>
						<div class="text-left ident2 formula">
								<i>p</i>:<i>p</i><sub>1</sub>:<i>p</i><sub>2</sub>:1:<i>n</i><sub>1</sub>:<i>n</i><sub>2</sub>
						</div>
						<p class="text-left ident1">
							<?php _e('Donde:');?><br/>
							<i>p</i> = <?php _e('Cantidad de títulos por zona.');?><br/>
							<i>n</i> = <?php _e('Multiplicador o factor de proporcionalidad de títulos por zona.');?>
						</p>
					</div>

					<div id="info-modelo-bradford-institucion" class="infoBox">
						<h4 class="text-center"><b><?php _e('Modelo matemático de Bradford');?></b><br/><?php _e('Distribución de artículos por instituciones.');?></h4>
						<p class="text-left">
							<?php _e('Modelo matemático que identifica el núcleo de instituciones con mayor cantidad de información por temática.');?><br/>
							<?php _e('Se identifican tres zonas según la cantidad de artículos por institución en la  disciplina:');?><br/>
							<?php _e('La zona Núcleo, la 2° y 3°, las instituciones y la cantidad artículos que han publicado.');?><br/>
							<?php _e('Se muestra la frecuencia de artículos por institución en disciplina.');?>
						</p>
						<p class="text-left ident1"><?php _e('La formulación matemática es:');?></p>
						<div class="text-left ident2 formula">
								<i>p</i>:<i>p</i><sub>1</sub>:<i>p</i><sub>2</sub>:1:<i>n</i><sub>1</sub>:<i>n</i><sub>2</sub>
						</div>
						<p class="text-left ident1">
							<?php _e('Donde:');?><br/>
							<i>p</i> = <?php _e('Cantidad de instituciones por zona.');?><br/>
							<i>n</i> = <?php _e('Multiplicador o factor de proporcionalidad de instituciones por zona.');?>
						</p>
					</div>

					<div id="info-productividad-exogena" class="infoBox">
						<h4 class="text-center"><?php _e('Tasa de autoría exógena');?></h4>
						<p class="text-justify">
							<?php _e('Indicador que mide el grado de internacionalización de las revistas, considerando la proporción de autores cuya institución de afiliación es de una nacionalidad distinta a la de la revista. Proporciona la tasa de productividad exógena por revista y la frecuencia de nacionalidad de sus autores.');?><br/>
							<?php _e('El valor numérico indica la proporción de autores extranjeros que han publicado en la revista.');?><br/>
						</p>
						<p class="text-left ident1"><?php _e('La formulación matemática es:');?></p>
						<div class="formula ident2">
								<i>TAE</i> =
								<div class="fraction">
									<span class="fup">&sum;ae</span>
									<span class="bar">/</span>
									<span class="fdn">&sum;d</span>
								</div>
						</div>
						<p class="text-left ident1"><?php _e('Donde:');?></p>
						<p class="text-left ident2">
							TAE = <?php _e('Tasa de autoría exógena');?><br/>
							ae	= <?php _e('Autores extranjeros');?><br/>
							d	= <?php _e('Total de documentos');?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div id="floatTableContainer"><div id="floatTable"></div><div id="toolbar_div"></div></div>

