<div class="text-center">
	<nav>
	  <ul class="pagination hidden-xs hidden-sm">
<?php foreach (range('A', 'Z') as $i):?>
		<li <?if($i == $alpha):?>class="active" <?endif;?>><a href="<?=site_url("bibliometria/indicadores-por-revista/".strtolower($i));?>"><?=$i;?></a></li>
<?php endforeach;?>
	  </ul>
	  {$alpha_links}
	</nav>
</div>
<div id="i-journals">
{foreach $revistas revista}
	<h4>{$revista.revista}</h4>
	<div>
{if $revista.coautoriapricezakutina}
	<a href="{site_url('indicadores/indice-coautoria/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}">{_('Índice de coautoría')}</a><br/>
	<a href="{site_url('indicadores/modelo-elitismo/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}">{_('Modelo de elitismo (Price)')}</a><br/>
	<a href="{site_url('indicadores/indice-densidad-documentos/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}">{_('Índice de densidad de documentos Zakutina y Priyenikova')}</a><br/>
{/if}
{if $revista.subramayan}
	<a href="{site_url('indicadores/grado-colaboracion/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}">{_('Grado de colaboración (Índice Subramanyan)')}</a><br/>
{/if}
{if $revista.tasalawani}
	<a href="{site_url('indicadores/tasa-documentos-coautorados/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}">{_('Tasa de documentos coautorados')}</a><br/>
	<a href="{site_url('indicadores/indice-colaboracion/disciplina/$revista.disciplinaSlug/revista/$revista.revistaSlug')}">{_('Índice de colaboración (Índice de Lawani)')}</a><br/>
{/if}
	</div>
{/foreach}
</div>
<br/>
