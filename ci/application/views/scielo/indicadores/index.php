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
		<div class="col-md-6 form-group">
			<select name="coleccion[]" id="coleccion" class="form-control" multiple="" data-placeholder="{_('Seleccione una o varias colecciones')}" <?php if($indicador == "") echo "disabled";?>>
{foreach $colecciones coleccion}
				<option value="{$coleccion.slug}">{$coleccion.name}</option>
{/foreach}
			</select>
		</div>
		<div class="col-md-6 form-group">
			<select name="area[]" id="area" class="form-control" multiple="" data-placeholder="{_('Seleccione una o varias areas')}" <?php if($indicador == "") echo "disabled";?>>
{foreach $areas area}
				<option value="{$area.slug}">{$area.name}</option>
{/foreach}
			</select>
		</div>
		<div class="col-md-6 form-group">
			<select name="revista[]" id="revista" class="form-control" disabled multiple data-placeholder="{_('Seleccione una o varias revistas')}">
				<option></option>
			</select>
		</div>
		<div class="col-md-6 form-group">
			<select name="paisRevista[]" id="paisRevista" class="form-control" disabled multiple data-placeholder="{_('Seleccione uno o varios países de la revista')}">
				<option></option>
			</select>
		</div>
		<div class="col-md-6 form-group">
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
					<li><a href="#charts"><i class="fa fa-line-chart"></i> {_('Gráfica')}</a></a></li>
					<li><a href="#grid"><i class="fa fa-table"></i> {_('Tabla')}</a></li>
				</ul>
				<div id="charts">
					<div id="chartContainer">
						<div id="chartTitle"></div>
						<div id="chart" class="chart_data"></div>
						<div class="chartCopyright">
							{_('Fuente:')} <a href="<?=base_url();?>">biblat.unam.mx</a>
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
							{_('Fuente:')} <a href="<?=base_url();?>">biblat.unam.mx</a>
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
							{_('Fuente:')} <a href="<?=base_url();?>">biblat.unam.mx</a>
						</div>
						<div id="chart1"></div>
					</div>
				</div>
				<div id="grid"><div id="gridContainer"></div></div>
			</div>
		</div>
	</form>
</div>
<div id="floatTableContainer"><div id="floatTable"></div><div id="toolbar_div"></div></div>

