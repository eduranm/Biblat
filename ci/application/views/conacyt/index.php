<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-parent="#accordion" href="#">
	        <span class="glyphicon fa fa-file-pdf-o"></span> Reporte bibliométrico completo
        </a>
      </h4>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseArea">
        	<span class="glyphicon fa fa-plus-square-o"></span> Reporte bibliométrico por área del conocimiento
        </a>
      </h4>
    </div>
    <div id="collapseArea" class="panel-collapse collapse">
{foreach $areas area}
		<div class="panel">
			<ul class="list-group">
				<li class="list-group-item">
					<a data-toggle="collapse" data-parent="#collapseArea" href="#{$area.journals.0.areaConacytSlug}">
						<span class="glyphicon fa fa-plus-square-o"></span> {$area.journals.0.areaConacytName}
					</a>
					<a href="{base_url('archivos/conacyt/reportes/area/$area.report.2014')}" target="_blank"><span class="glyphicon fa fa-file-pdf-o"></span></a>
				</li>
			</ul>
			<div id="{$area.journals.0.areaConacytSlug}" class="panel-collapse collapse list-group">
				<div class="list-group">
{foreach $area.journals journal}
					<a href="{base_url('archivos/conacyt/reportes/revista/$journal.report.2014')}" target="_blank" class="list-group-item"><span class="glyphicon fa fa-file-pdf-o"></span> {$journal.name}</a>
{/foreach}
				</div>	
			</div>
		</div>
{/foreach}
	</div>
</div>

<pre>{print_r($areas)}</pre>
