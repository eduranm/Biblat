<div id="content">
	<div id="encabezado">                
      	<div id="share">
			<div id="share1">
				<span class="space"><a href="https://www.facebook.com/pages/BIBLAT/188958071154818" target="_blank"><i class="fa fa-facebook"></i>&#Xf09a</a></span>
				<span class="space"><a href="https://twitter.com/Biblat" target="_blank"><i class="fa fa-twitter"></i>&#Xf099;</i></a></span>
				<span class="space"><a href="#" target="_blank">?</a></span>
				<span class="space"><a href="mailto:scielo@dgb.unam.mx"><i class="fa fa-envelope-o"></i></a></span>
				<div><a class="share" href="#">Español</a></div>
			</div>
                  
			<div id="share2"> 
				<a href="#"><img src="<?=base_url('/img/bt_share_int.jpg');?>" width="23" height="40" alt="share"></a>
				<a href="#">A<sup>+</sup></a>
				<a href="#">A<sup>-</sup></a>
				<a href="javascript:window.print();"><i class="fa fa-print"></i></a>
			</div>
		</div><!--end share-->

      	<div class="titulo_int">
        	<h1><?php _e('Indicadores bibliométricos');?></h1>
      	</div><!--end titulo_int-->
        
        <br class="cf">
    </div><!--end encabezado-->
      
    <div id="content_txt">
	<form name="generarIndicador" id="generarIndicador" method="POST">
		<div class="colums">
			<div class="leftColumn">
				<select name="indicador" id="indicador" style="width:90%" data-placeholder="<?php _e('Seleccione indicador');?>">
				<option></option>
<?php foreach ($indicadores as $key => $value): ?>
					<option value="<?=$key;?>" <?php if($key == $indicador) echo "selected";?>><?=$value;?></option>
<?php endforeach;?>
				</select>
			</div>
			<div class="rightColumn">
				<select name="disciplina" id="disciplina" style="width:90%" data-placeholder="<?php _e('Seleccione una disciplina');?>" <?php if($indicador == "") echo "disabled";?>>
				<option></option>
<?php foreach ($disciplinas as $kdisciplina => $disciplina):?>
					<option value="<?=$kdisciplina;?>"><?=$disciplina['disciplina'];?></option>
<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="colums" id="paisRevistaDiv" style="display:none;">
			<div class="orColumn" id="orPaisRevistaColumn"><?php _e('ó');?></div>
			<div class="leftColumn">
				<select name="revista[]" id="revista" style="width:90%" disabled multiple data-placeholder="<?php _e('Seleccione una o varias revistas');?>">
					<option></option>
				</select>
			</div>
			<div class="rightColumn">
				<select name="paisRevista[]" id="paisRevista" style="width:90%" disabled multiple data-placeholder="<?php _e('Seleccione uno o varios países de la revista');?>">
					<option></option>
				</select>
			</div>
			<div class="rightColumn">
				<select name="paisAutor[]" id="paisAutor" style="width:90%" disabled multiple data-placeholder="<?php _e('Seleccione uno o varios países de la afiliación del autor');?>">
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
					<div class="chartCopyright">
						<?php _e('Fuente:');?> <a href="<?=base_url();?>">biblat.unam.mx</a>
					</div>
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
					<div class="chartCopyright">
						<?php _e('Fuente:');?> <a href="<?=base_url();?>">biblat.unam.mx</a>
					</div>
				</div>
				<div id="prattContainer" style="display:none;">
					<ul id="prattSlide"></ul>
					<div class="chartCopyright">
						<?php _e('Fuente:');?> <a href="<?=base_url();?>">biblat.unam.mx</a>
					</div>
				</div>
			</div>
			<div id="grid"><div id="gridContainer"></div></div>
			<div id="info">
				<div id="info-indice-coautoria" class="infoBox">
					<p class="textoTitulo centrado"><?php _e('Índice de Coautoría');?></p>
					<p class="textoL">
						<?php _e('Este indicador muestra el número promedio de autores por artículo.');?>
					</p>
					<p class="textoL ident1"><?php _e('La formulación matemática es:');?></p>
					<div class="textoL ident2 formula">
						<span><i>Ic</i> = </span>
						<div class="fraction">
							<span class="fup"><i>Caf</i></span>
							<span class="bar">/</span>
							<span class="fdn"><i>Cd</i></span>
						</div>
					</div>
					<p class="textoL ident1">
						<?php _e('Donde:');?><br/>
						<i>Caf</i> = <?php _e('Cantidad de autores firmantes');?><br/>
						<i>Cd</i> = <?php _e('Cantidad de documentos');?>
					</p>
				</div>

				<div id="info-tasa-documentos-coautorados" class="infoBox">
					<p class="textoTitulo centrado"><?php _e('Tasa de Documentos Coautorados');?></p>
					<p class="textoL">
						<?php _e('El valor numérico indica la proporción de artículos con autoría múltiple.');?>
					</p>
					<p class="textoL ident1"><?php _e('La formulación matemática es:');?></p>
					<div class="textoL ident2 formula">
							<i>Tdc</i> = 
							<div class="fraction">
								<span class="fup"><i>Cta</i></span>
								<span class="bar">/</span>
								<span class="fdn"><i>Ctd</i></span>
							</div>
					</div>
					<p class="textoL ident1">
						<?php _e('Donde:');?><br/>
						<i>Cta</i> = <?php _e('Cantidad total de documentos con autoría multiple');?><br/>
						<i>Ctd</i> = <?php _e('Cantidad total de documentos');?>
					</p>
					<p class="textoL">
						<?php _e('Se interpreta que valores cercanos a 1 muestran mayor cantidad de documentos en coautoría.');?>
					</p>
				</div>

				<div id="info-grado-colaboracion" class="infoBox">
					<p class="textoTitulo centrado"><?php _e('Grado de Colaboración (Índice de Subramanyan)');?></p>
					<p class="textoL">
						<?php _e('El valor numérico indica la proporción de artículos con autoría múltiple.');?>
					</p>
					<p class="textoL ident1"><?php _e('La formulación matemática es:');?></p>
					<div class="textoL formula ident2">
							<i>GC</i> = 
							<div class="fraction">
								<span class="fup"><i>N<sub>m</sub></i></span>
								<span class="bar">/</span>
								<span class="fdn"><i>N<sub>m</sub> + N<sub>s</sub></i></span>
							</div>
					</div>
					<p class="textoL ident2">
						<?php _e('Donde:');?><br/>
						<i>N<sub>m</sub></i> = <?php _e('Total de documentos con autoría múltiple.');?><br/>
						<i>N<sub>s</sub></i> = <?php _e('Total de documentos escritos por un solo autor.');?>
					</p>
					<p class="textoL">
						<?php _e('Se interpreta que valores cercanos a 0 muestran un fuerte componente de autoría simple, mientras que los cercanos a 1 denotan una fuerte proporción de autoría múltiple.');?>
					</p>
				</div>

				<div id="info-modelo-elitismo" class="infoBox">
					<p class="textoTitulo centrado"><?php _e('Modelo de Elitismo (Price)');?></p>
					<p class="textoL">
						<?php _e('Identifica la cantidad de autores que integran la elite de los más productivos por revista o país de publicación de la revista.');?><br/>
						<?php _e('El valor numérico representa la cantidad de los autores que integran dicha elite.');?>
					</p>
					<p class="textoL ident1"><?php _e('La formulación matemática es:');?></p>
					<div class="textoL ident2 formula">
							<i>E</i> = 
							<span class="radical">&radic;</span><span class="radicand"><i>N</i></span>
					</div>
					<p class="textoL ident1">
						<?php _e('Donde:');?><br/>
						<i>E</i> = <?php _printf('Elite de autores que publican el 50%% de los trabajos.');?><br/>
						<i>N</i> = <?php _e('Población total de autores.');?>
					</p>					
				</div>

				<div id="info-indice-colaboracion" class="infoBox">
					<p class="textoTitulo centrado"><?php _e('Índice de Colaboración (Índice de Lawani)');?></p>
					<p class="textoL">
						<?php _e('Proporciona el peso promedio del número de autores por artículo.');?><br/>
						<?php _e('El valor numérico representa el promedio de autores por artículo.');?><br/>
						<?php _e('Además de  visualizar la frecuencia del número de autores por artículo.');?>
					</p>
					<p class="textoL ident1"><?php _e('La formulación matemática es:');?></p>
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
						<?php _e('Donde:');?><br/>
						<i>N</i> = <?php _e('Total de documentos.');?><br/>
						<i>j<sub>i</sub></i> = <?php _e('Número de firmas (autores) por documentos.');?><br/>
						<i>n<sub>i</sub></i> =  <?php _e('Cantidad de documentos con autoría múltiple.');?>
					</p>				
				</div>

				<div id="info-indice-densidad-documentos" class="infoBox">
					<p class="textoTitulo centrado"><?php _e('Índice de Densidad de Documentos Zakutina y Priyenikova');?></p>
					<p class="textoL">
						<?php _e('Índice que identifica los títulos con mayor densidad de información.');?><br/>
						<?php _e('El valor numérico proporciona la cantidad de artículos por revista.');?>
					</p>
					<p class="textoL ident1"><?php _e('La formulación matemática es:');?></p>
					<div class="textoL ident2 formula">
							<i>p</i> = 
							<div class="fraction">
								<span class="fup"><i>Rn</i></span>
								<span class="bar">/</span>
								<span class="fdn"><i>N</i></span>
							</div>
					</div>
					<p class="textoL ident1">
						<?php _e('Donde');?>:<br/>
						<i>Rn</i> = &sum; <?php _e('Artículos');?>.<br/>
						<i>N</i> = &sum; <?php _e('Títulos de revistas');?>.
					</p>
				</div>

				<div id="info-indice-concentracion" class="infoBox">
					<p class="textoTitulo centrado"><?php _e('Índice de concentración (Índice de Pratt)');?></p>
					<p class="textoJ">
						<?php _e('Indica el grado de concentración temática de las revistas.');?><br/>
						<?php _e('El valor numérico representa el nivel de concentración temática basándose en sus descriptores.');?><br/>
						<?php _e('Se muestra la frecuencia de descriptores.');?>
					</p>
					<p class="textoL ident1"><?php _e('La formulación matemática es:');?></p>
					<div class="textoL ident2 formula">
							<i>C</i> = 
							<div class="fraction">
								<span class="fup">2{[(<i>n</i>+1)/2]-<i>q</i>}</span>
								<span class="bar">/</span>
								<span class="fdn"><i>n</i>-1</span>
							</div>
					</div>
					<p class="textoL ident1">
						<?php _e('Donde:');?><br/>
						<i>C</i> = <?php _e('Índice de concentración de Pratt.');?><br/>
						<i>n</i> = <?php _e('Número de categorías.');?><br/>
						<i>q</i> = <?php _e('&sum; del producto del rango por la frecuencia de una categoría dada, dividido por la cantidad de ítems en todas las categorías.');?>
					</p>
					<p class="textoJ">
						<?php _e('Se interpreta que valores cercanos a 1 muestran mayor grado de especialización.');?>
					</p>				
				</div>

				<div id="info-modelo-bradford-revista" class="infoBox">
					<p class="textoTitulo centrado"><b><?php _e('Modelo matemático de Bradford');?></b><br/><?php _e('Distribución de artículos por revista');?></p>
					<p class="textoL">
						<?php _e('Modelo matemático que identifica el núcleo de revistas con mayor cantidad de información por temática.');?><br/>
						<?php _e('Se identifican tres zonas según la cantidad de artículos por revista en la  disciplina:');?><br/>
						<?php _e('La zona Núcleo, la 2° y 3°, los títulos y la cantidad artículos que han publicado.');?><br/>
						<?php _e('Se muestra la frecuencia de artículos por revista de la disciplina.');?> 
					</p>
					<p class="textoL ident1"><?php _e('La formulación matemática es:');?></p>
					<div class="textoL ident2 formula">
							<i>p</i>:<i>p</i><sub>1</sub>:<i>p</i><sub>2</sub>:1:<i>n</i><sub>1</sub>:<i>n</i><sub>2</sub>
					</div>
					<p class="textoL ident1">
						<?php _e('Donde:');?><br/>
						<i>p</i> = <?php _e('Cantidad de títulos por zona.');?><br/>
						<i>n</i> = <?php _e('Multiplicador o factor de proporcionalidad de títulos por zona.');?>
					</p>
				</div>

				<div id="info-modelo-bradford-institucion" class="infoBox">
					<p class="textoTitulo centrado"><b><?php _e('Modelo matemático de Bradford');?></b><br/><?php _e('Distribución de artículos por instituciones.');?></p>
					<p class="textoL">
						<?php _e('Modelo matemático que identifica el núcleo de instituciones con mayor cantidad de información por temática.');?><br/>
						<?php _e('Se identifican tres zonas según la cantidad de artículos por institución en la  disciplina:');?><br/>
						<?php _e('La zona Núcleo, la 2° y 3°, las instituciones y la cantidad artículos que han publicado.');?><br/>
						<?php _e('Se muestra la frecuencia de artículos por institución en disciplina.');?>
					</p>
					<p class="textoL ident1"><?php _e('La formulación matemática es:');?></p>
					<div class="textoL ident2 formula">
							<i>p</i>:<i>p</i><sub>1</sub>:<i>p</i><sub>2</sub>:1:<i>n</i><sub>1</sub>:<i>n</i><sub>2</sub>
					</div>
					<p class="textoL ident1">
						<?php _e('Donde:');?><br/>
						<i>p</i> = <?php _e('Cantidad de instituciones por zona.');?><br/>
						<i>n</i> = <?php _e('Multiplicador o factor de proporcionalidad de instituciones por zona.');?>
					</p>
				</div>

				<div id="info-productividad-exogena" class="infoBox">
					<p class="textoTitulo centrado"><?php _e('Tasa de autoría exógena');?></p>
					<p class="textoJ">
						<?php _e('Indicador que mide el grado de internacionalización de las revistas, considerando la proporción de autores cuya institución de afiliación es de una nacionalidad distinta a la de la revista. Proporciona la tasa de productividad exógena por revista y la frecuencia de nacionalidad de sus autores.');?><br/>
						<?php _e('El valor numérico indica la proporción de autores extranjeros que han publicado en la revista.');?><br/>
					</p>
					<p class="textoL ident1"><?php _e('La formulación matemática es:');?></p>
					<div class="formula ident2">
							<i>TAE</i> =
							<div class="fraction">
								<span class="fup">&sum;ae</span>
								<span class="bar">/</span>
								<span class="fdn">&sum;d</span>
							</div>
					</div>
					<p class="textoL ident1"><?php _e('Donde:');?></p>
					<p class="textoL ident2">
						TAE = <?php _e('Tasa de autoría exógena');?><br/>
						ae	= <?php _e('Autores extranjeros');?><br/>
						d	= <?php _e('Total de documentos');?>
					</p>
				</div>
			</div>
		</div>
	</form>
	<div id="floatTableContainer"><div id="floatTable"></div><div id="toolbar_div"></div></div>
    </div><!--end content_txt-->
            
  </div><!--end content-->