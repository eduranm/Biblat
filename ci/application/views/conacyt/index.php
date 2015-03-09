<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5 class="panel-title">
				<a data-parent="#accordion" href="{site_url('conacyt/reporte/conacyt-todas-las-areas')}">
					<span class="fa fa-file-pdf-o"></span> {_('Reporte bibliométrico completo')}
				</a>
			</h5>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5 class="panel-title">
				<a data-parent="#accordion" href="{site_url('conacyt/reporte/reporte-posicionamiento-cuartiles-jcr-scimago')}">
					<span class="fa fa-file-pdf-o"></span> {_('Reporte de posicionamiento por cuartiles')}
				</a>
			</h5>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseArea">
					<span class="fa fa-plus-square-o"></span> {_('Reporte bibliométrico por área del conocimiento')}
				</a>
			</h5>
		</div>
		<div id="collapseArea" class="panel-collapse collapse">
{foreach $areas area}
		<div class="panel">
			<ul class="list-group">
				<li class="list-group-item">
					<a data-toggle="collapse" data-parent="#collapseArea" href="#{$area.journals.0.areaConacytSlug}">
						<span class="fa fa-plus-square-o"></span> {$area.journals.0.areaConacytName}
					</a>
					<a href="{base_url('conacyt/area/$area.journals.0.areaConacytSlug')}"><span class="fa fa-file-pdf-o"></span></a>
				</li>
			</ul>
			<div id="{$area.journals.0.areaConacytSlug}" class="panel-collapse collapse list-group">
				<div class="list-group">
{foreach $area.journals journal}
					<a href="{site_url('conacyt/revista/$journal.slug')}" class="list-group-item"><span class="fa fa-file-pdf-o"></span> {$journal.name}</a>
{/foreach}
				</div>	
			</div>
		</div>
{/foreach}
	</div>
</div>
