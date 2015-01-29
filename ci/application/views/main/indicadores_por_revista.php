<div class="text-center">
	<nav>
	  <ul class="pagination hidden-xs hidden-sm">
{foreach range('A', 'Z') i}	  
		<li {if $i == $letra}class="active" {/if}><a href="{$il=lower($i) site_url('bibliometria/indicadores-por-revista/$il')}">{$i}</a></li>
{/foreach}
	  </ul>
	  {$alpha_links}
	</nav>
</div>
<div class="panel-group" id="accordion">
{foreach $revistas revista}
	<div class="panel panel-default">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#{$revista.revistaSlug}">
	        	<span class="glyphicon fa fa-book"></span> {$revista.revista}
	        </a>
	      </h4>
	    </div>
	    <div id="{$revista.revistaSlug}" class="panel-collapse collapse">
	    	<ul class="list-group">
{if $revista.coautoriapricezakutina}
				<li class="list-group-item"><a href="{site_url('indicadores/indice-coautoria/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}"><span class="glyphicon fa fa-line-chart"></span>{_('Índice de coautoría')}</a></li>
				<li class="list-group-item"><a href="{site_url('indicadores/modelo-elitismo/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}"><span class="glyphicon fa fa-line-chart"></span>{_('Modelo de elitismo (Price)')}</a></li>
				<li class="list-group-item"><a href="{site_url('indicadores/indice-densidad-documentos/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}"><span class="glyphicon fa fa-line-chart"></span>{_('Índice de densidad de documentos Zakutina y Priyenikova')}</a></li>
{/if}
{if $revista.subramayan}
				<li class="list-group-item"><a href="{site_url('indicadores/grado-colaboracion/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}"><span class="glyphicon fa fa-line-chart"></span>{_('Grado de colaboración (Índice Subramanyan)')}</a></li>
{/if}
{if $revista.tasalawani}
				<li class="list-group-item"><a href="{site_url('indicadores/tasa-documentos-coautorados/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}"><span class="glyphicon fa fa-line-chart"></span>{_('Tasa de documentos coautorados')}</a></li>
				<li class="list-group-item"><a href="{site_url('indicadores/indice-colaboracion/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}"><span class="glyphicon fa fa-line-chart"></span>{_('Índice de colaboración (Índice de Lawani)')}</a></li>
{/if}
			</ul>
		</div>
	</div>
{/foreach}
</div>
<br/>
