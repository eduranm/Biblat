<div class="row">	
	<form name="generarIndicador" id="generarIndicador" method="POST" autocomplete="off">
		<div class="col-md-6 form-group">
			<select name="indicador" id="indicador" class="form-control" data-placeholder="{_('Seleccione indicador')}">
			<option></option>
{foreach $indicadores group options}
				<optgroup label="{$group}">
{foreach $options key value}
					<option value="{$key}" {if $key == $indicador}selected="selected"{/if}>{$value}</option>
{/foreach}
				</optgroup>
{/foreach}
			</select>
		</div>
		<div class="col-md-6 form-group" style="display:none;">
			<select name="coleccion[]" id="coleccion" class="form-control" multiple="" data-placeholder="{_('Seleccione una o varias colecciones')}">
{foreach $colecciones coleccion}
				<option value="{$coleccion.slug}">SciELO {$coleccion.name}</option>
{/foreach}
			</select>
		</div>
		<div class="col-md-6 form-group" style="display:none;">
			<select name="edad[]" id="edad" class="form-control" multiple="" data-placeholder="{_('Seleccione el rango de edad del documento')}">
{foreach $ageRanges v}
				<option value="{$v.rango}">{$v.rango} {_('años')}</option>
{/foreach}
			</select>
		</div>
		<div class="col-md-6 form-group" style="display:none;">
			<select name="tipodoc[]" id="tipodoc" class="form-control" multiple="" data-placeholder="{_('Seleccione el tipo de documento citado')}">
{foreach $docTypes docType}
				<option value="{$docType.slug}">{$docType.name}</option>
{/foreach}
			</select>
		</div>
		<div class="col-md-6 form-group" style="display:none;">
			<select name="area[]" id="area" class="form-control" multiple="" data-placeholder="{_('Seleccione una o varias areas')}">
{foreach $areas area}
				<option value="{$area.slug}">{$area.name}</option>
{/foreach}
			</select>
		</div>
		<div class="col-md-6 form-group" style="display:none;">
			<select name="revista[]" id="revista" class="form-control" disabled multiple data-placeholder="{_('Seleccione una o varias revistas')}">
				<option></option>
			</select>
		</div>
		<div class="col-md-6 form-group" style="display:none;">
			<select name="paisRevista[]" id="paisRevista" class="form-control" disabled multiple data-placeholder="{_('Seleccione uno o varios países de la revista')}">
				<option></option>
			</select>
		</div>
		<div class="col-md-6 form-group" style="display:none;">
			<select name="paisAutor[]" id="paisAutor" class="form-control" disabled multiple data-placeholder="{_('Seleccione uno o varios países de la afiliación del autor')}">
				<option></option>
			</select>
		</div>
		<div class="clearfix"></div>
		<div id="periodos" class="col-md-12 form-group hidden">
			<input id="sliderPeriodo" type="slider" name="periodo" value="0;0" disabled/>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-12" id="tab-chars">
			<div id="tabs" style="display:none;">
				<ul>
					<li><a href="#charts"><i class="fa fa-line-chart"></i> {_('Gráfica')}</a><a href="" title="{_('Descargar gráfica')}" class="download-chart"><i class="fa fa-download"></i></a></li>
					<li><a href="#grid"><i class="fa fa-table"></i> {_('Tabla')}</a><a href="" title="{_('Descargar tabla')}" class="download-table"><i class="fa fa-download"></i></a></li>
					<li><a href="#info"><i class="fa fa-cogs"></i> {_('Metodología')}</a></li>
				</ul>
				<div id="charts">
					<div id="chartContainer">
						<div id="chartTitle"></div>
						<div id="chart" class="chart_data"></div>
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
					</div>
					<div id="group-container" style="display:none;">
						<div id="carousel-chargrp" class="carousel slide" data-ride="carousel">
						  <!-- Indicators -->
						  <ol class="carousel-indicators">
						  </ol>

						  <!-- Wrapper for slides -->
						  <div class="carousel-inner" role="listbox">
						  </div>

						  <!-- Controls -->
						  <a class="left carousel-control" href="#carousel-chargrp" role="button" data-slide="prev">
						    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"><i class="fa fa-chevron-circle-left"></i></span>
						    <span class="sr-only">Previous</span>
						  </a>
						  <a class="right carousel-control" href="#carousel-chargrp" role="button" data-slide="next">
						    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"><i class="fa fa-chevron-circle-right"></i></span>
						    <span class="sr-only">Next</span>
						  </a>
						</div>
						<div id="chart1"></div>
					</div>
				</div>
				<div id="info">
					<div id="info-distribucion-articulos-coleccion" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por colección')}</h4>
						<p class="text-left">
							{_('Muestra la cantidad total de artículos que han sido ingresados por colección SciELO, distribuidos por año de publicación.')}
						</p>
						<p class="text-left">
							{_('En color obscuro aparecen los artículos y en color claro otros documentos que corresponden a conferencias, reseñas, editoriales, obituarios y otro tipo de documentos.')}
						</p>
						<p class="text-left">
							{_('Esta información se modifica de manera regular dado que las colecciones se actualizan constantemente, ingresando con ello documentos más recientes, nuevas revistas y, dependiendo de las políticas de cada colección, se ingresan también colecciones retrospectivas.')}
						</p>
					</div>
					<div id="info-distribucion-articulos-coleccion-area" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por colección y área')}</h4>
						<p class="text-left">
							{_('Muestra la cantidad total de artículos que han sido ingresados por área temática filtrada por colección, distribuidos por año de publicación.')}
						</p>
						<p class="text-left">
							{_('Esta información se modifica de manera regular dado que las colecciones se actualizan constantemente, ingresando con ello documentos más recientes, nuevas revistas y, dependiendo de las políticas de cada colección, se ingresan también colecciones retrospectivas.')}
						</p>
					</div>
					<div id="info-distribucion-articulos-coleccion-revista" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por colección y revista')}</h4>
						<p class="text-left">
							{_('Muestra la cantidad total de artículos que han sido ingresados por revista filtrada por colección, distribuidos por año de publicación.')}
						</p>
						<p class="text-left">
							{_('Esta información se modifica de manera regular dado que las colecciones se actualizan constantemente, ingresando con ello documentos más recientes, nuevas revistas y, dependiendo de las políticas de cada colección, se ingresan también colecciones retrospectivas.')}
						</p>
					</div>
					<div id="info-distribucion-articulos-coleccion-afiliacion" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por colección y país de afiliación')}</h4>
						<p class="text-left">
							{_('Muestra la cantidad total de artículos que han sido ingresados por país de afiliación del autor filtrado por colección SciELO, distribuidos por año de publicación.')}
						</p>
						<p class="text-left">
							{_('Esta información se modifica de manera regular dado que las colecciones se actualizan constantemente, ingresando con ello documentos más recientes, nuevas revistas y, dependiendo de las políticas de cada colección, se ingresan también colecciones retrospectivas.')}
						</p>
					</div>
					<div id="info-distribucion-revista-coleccion" class="infoBox">
						<h4 class="text-center">{_('Distribución de revistas por colección')}</h4>
						<p class="text-left">
							{_('Muestra el número acumulativo de revistas incluidas en cada colección por año')}
						</p>
						<p class="text-left">
							{_('Las colecciones se actualizan constantemente por lo que ingresan fascículos más recientes, además de que se incluyen nuevas revistas y, de acuerdo con las políticas de cada colección, se ingresan también colecciones retrospectivas, por lo que en reportes subsecuentes se basarán en colecciones acrecentadas y las estadísticas serán actualizadas.')}
						</p>
					</div>
					<div id="info-indicadores-generales-revista" class="infoBox">
						<div id="revista-fasciculos">
							<h4 class="text-center">{_('Número de fascículos por revista')}</h4>
							<p class="text-left">
								{_('Muestra el número de fascículos o números publicados por una revista por año.')}
							</p>
						</div>
						<div id="revista-articulos">
							<h4 class="text-center">{_('Número de artículos por revista')}</h4>
							<p class="text-left">
								{_('Muestra los artículos publicados por revista al año. En el año más reciente, la revista no ha cerrado aún el año de publicación por lo que no se muestra aún el número definitivo de artículos publicados.')}
							</p>
							<p class="text-left">
								{_('Esta información refleja la productividad de las revistas y está directamente relacionada con su frecuencia de publicación.')}
							</p>
						</div>
						<div id="revista-referencias">
							<h4 class="text-center">{_('Número de referencias por revista')}</h4>
							<p class="text-left">
								{_('Muestra la cantidad total de referencias incluidas en los documentos publicados en la revista, distribuidas por año de publicación.')}
							</p>
							<p class="text-left">
								{_('Dicho de otra forma, son las citas que conceden los documentos publicados en una revista a los trabajos en los cuales se sustentó la investigación; éstos pueden ser artículos de revista, libros, capítulos de libro, conferencias (proceedings), manuales, reportes técnicos, etc.')}
							</p>
						</div>
						<div id="revista-citas">
							<h4 class="text-center">{_('Número de citas recibidas por revista')}</h4>
							<p class="text-left">
								{_('Muestra el total de citas recibidas por revista al año, sea cual fuere el año de publicación del documento citado; por ejemplo: en 2008 se contabilizan todas las citas recibidas por los artículos publicados por la revista en ese año y años anteriores.')}
							</p>
							<p class="text-left">
								{_('La información de las citas recibidas también es susceptible de actualizarse conforme se actualizan las colecciones SciELO. La inclusión de una nueva revista, particularmente de la misma área temática, frecuentemente adiciona citas a las revistas que ya están incluidas en la colección.')}
							</p>
							<p class="text-left">
								{_('*Se considera autocita a las referencias que se hacen a documentos publicados por la misma revista. ')}
							</p>
						</div>
						<div id="revista-factorImpacto">
							<h4 class="text-center">{_('Factor de impacto por revista')}</h4>
							<p class="text-left">
								{_('Este indicador pretende identificar a las revistas más relevantes o de mayor influencia en un área de estudio específica calculando la frecuencia con la que se cita un "artículo promedio" de una revista en un año en particular. Su cálculo toma en cuenta las citas recibidas en una ventana de tiempo de 2 años.')}
							</p>
							<p class="text-left">
								{_('El factor de impacto se calcula dividiendo el número de citas recibidas en un determinado año por los artículos publicados en los dos años anteriores, entre el número total de artículos publicados en los dos años anteriores.')}
							</p>
							<p class="text-left">
								{_('Ejemplo')}:
							</p>
							<div class="text-center">
								<div class="fraction">
									<span class="fup"><i>{_('Factor de impacto de la revista X')}</i></span>
									<span class="fdnb"><i>{_('en el año 2011')}</i></span>
								</div> = 
								<div class="fraction">
									<span class="fup"><i>{_('Citas recibidas en 2011 de art. publ. en 2010+2009')}</i></span>
									<span class="bar">/</span>
									<span class="fdn"><i>{_('Número de artículos publicados en 2010+2009')}</i></span>
								</div> = 
								<div class="fraction">
									<span class="fup"><i>{_('117 citas recibidas en 2011 de art. publ. en 2010+2009')}</i></span>
									<span class="bar">/</span>
									<span class="fdn"><i>{_('212 artículos publicados en 2010+2009')}</i></span>
								</div> = <b>0.5519</b>
							</div>
						</div>
						<div id="revista-indiceInmediatez">
							<h4 class="text-center">{_('Índice de inmediatez por revista')}</h4>
							<p class="text-left">
								{_('El Índice de inmediatez indica la rapidez con la que los artículos de una revista son citados. Su cálculo toma en cuenta solamente las citas que recibe la revista durante el mismo año de su publicación. ')}
							</p>
							<p class="text-left">
								{_('Se calcula dividiendo las citas recibidas por artículos publicados en un año en particular, entre el número de artículos publicados en ese mismo año.')}
							</p>
							<p class="text-left">
								{_('Ejemplo')}:
							</p>
							<div class="text-center">
								<div class="fraction">
									<span class="fup"><i>{_('Índice de inmediatez de la revista X')}</i></span>
									<span class="fdnb"><i>{_('en el año 2014')}</i></span>
								</div> = 
								<div class="fraction">
									<span class="fup"><i>{_('Citas recibidas por artículos publicados 2014')}</i></span>
									<span class="bar">/</span>
									<span class="fdn"><i>{_('Número de artículos publicados en 2014')}</i></span>
								</div> = 
								<div class="fraction">
									<span class="fup"><i>{_('16 citas recibidas por artículos publicados 2014')}</i></span>
									<span class="bar">/</span>
									<span class="fdn"><i>{_('70 artículos publicados en 2014')}</i></span>
								</div> = <b>0.2286</b>
							</div>
						</div>
						<div id="revista-vidaMedia">
							<h4 class="text-center">{_('Vida media de las citas')}</h4>
							<p class="text-left">
								{_('Este indicador muestra la edad del 50%% de los artículos citados de la revista en un año determinado.')}
							</p>
							<p class="text-left">
								{_('Ejemplo')}:
							</p>
							<p class="text-left">
								{_sprintf('La revista X obtuvo en 2011 un valor de Vida Media de 7 años. Significa que el 50%% de las citas que recibió en 2011 son para documentos publicados en los últimos 7 años, es decir del periodo 2005-2011. El otro 50%% de las citas son de documentos publicados en años anteriores a 2005.')}
							</p>
							<p class="text-left">
								{_sprintf('Un valor de Vida Media >10 años significa que el 50%% de las citas recibidas por la revista rebasan los 10 años desde su publicación.')}
							</p>
						</div>
					</div>
					<div id="info-citacion-articulos-edad" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por edad del documento citado')}</h4>
						<p class="text-left">
							{_('Muestra el número de documentos publicados y su distribución en el tiempo en donde se citan documentos dentro de los siguientes rangos de edad: 0-4 años; 5-9 años; 10-14 años; 15-19 años; 20-24 años; 25-29 años; 30-34 años y más de 35 años.')}
						</p>
						<p class="text-left">
							{_('**Edad se refiere al tiempo que tiene de haberse publicado el documento citado. 0 años significa que son documentos citados en el mismo año de su publicación.')}
						</p>
						<p class="text-left">
							{_('La búsqueda puede circunscribirse por área temática SciELO, revista o país de la afiliación (institución) del autor citante.')}
						</p>
					</div>
					<div id="info-citacion-articulos-edad-area" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por edad del documento citado y área citante')}</h4>
						<p class="text-left">
							{_('Muestra el número de documentos publicados filtrados por área temática y su distribución en el tiempo en donde se citan documentos dentro de los siguientes rangos de edad: 0-4 años; 5-9 años; 10-14 años; 15-19 años; 20-24 años; 25-29 años; 30-34 años y más de 35 años.')}
						</p>
						<p class="text-left">
							{_('**Edad se refiere al tiempo que tiene de haberse publicado el documento citado. 0 años significa que son documentos citados en el mismo año de su publicación.')}
						</p>
					</div>
					<div id="info-citacion-articulos-edad-revista" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por edad del documento citado y revista citante')}</h4>
						<p class="text-left">
							{_('Muestra el número de documentos publicados filtrados por revista y su distribución en el tiempo en donde se citan documentos dentro de los siguientes rangos de edad: 0-4 años; 5-9 años; 10-14 años; 15-19 años; 20-24 años; 25-29 años; 30-34 años y más de 35 años.')}
						</p>
						<p class="text-left">
							{_('**Edad se refiere al tiempo que tiene de haberse publicado el documento citado. 0 años significa que son documentos citados en el mismo año de su publicación.')}
						</p>
					</div>
					<div id="info-citacion-articulos-edad-afiliacion" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por edad del documento citado y país de afiliación citante')}</h4>
						<p class="text-left">
							{_('Muestra el número de documentos publicados filtrados por país de afiliación del autor y su distribución en el tiempo en donde se citan documentos dentro de los siguientes rangos de edad: 0-4 años; 5-9 años; 10-14 años; 15-19 años; 20-24 años; 25-29 años; 30-34 años y más de 35 años.')}
						</p>
						<p class="text-left">
							{_('**Edad se refiere al tiempo que tiene de haberse publicado el documento citado. 0 años significa que son documentos citados en el mismo año de su publicación.')}
						</p>
					</div>
					<div id="info-citacion-articulos-tipo" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por tipo del documento citado')}</h4>
						<p class="text-left">
							{_('Muestra el número de documentos publicados y su distribución en el tiempo en los que se citan los siguientes tipos de documento: artículos de Revistas, Libros, Tesis, Anales y Otros')}
						</p>
						<p class="text-left">
							{_('La búsqueda puede circunscribirse por área temática SciELO, revista o país de la afiliación (institución) del autor citante.')}
						</p>
					</div>
					<div id="info-citacion-articulos-tipo-area" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por tipo del documento citado y área citante')}</h4>
						<p class="text-left">
							{_('Muestra el número de documentos publicados filtrados por área temática y su distribución en el tiempo en los que se citan los siguientes tipos de documento: artículos de Revistas, Libros, Tesis, Anales y Otros')}
						</p>
					</div>
					<div id="info-citacion-articulos-tipo-revista" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por tipo del documento citado y revista citante')}</h4>
						<p class="text-left">
							{_('Muestra el número de documentos publicados filtrados por revista y su distribución en el tiempo en los que se citan los siguientes tipos de documento: artículos de Revistas, Libros, Tesis, Anales y Otros')}
						</p>
					</div>
					<div id="info-citacion-articulos-tipo-afiliacion" class="infoBox">
						<h4 class="text-center">{_('Distribución de artículos por tipo del documento citado y país de afiliación citante')}</h4>
						<p class="text-left">
							{_('Muestra el número de documentos publicados filtrados por país de afiliación del autor y su distribución en el tiempo en los que se citan los siguientes tipos de documento: artículos de Revistas, Libros, Tesis, Anales y Otros')}
						</p>
					</div>
				</div>
				<div id="grid"><div id="gridContainer"></div></div>
			</div>
		</div>
	</form>
</div>
<div id="floatTableContainer"><div id="floatTable"></div><div id="toolbar_div"></div></div>

