<div class="text-center">
	<nav>
	  <ul class="pagination hidden-xs hidden-sm">
{foreach range('A', 'Z') i}	  
		<li {if $i == $letra}class="active" {/if}><a href="{$il=lower($i) site_url('indice/alfabetico/$il')}">{$i}</a></li>
{/foreach}
	  </ul>
	  {$alpha_links}
	</nav>
</div>

    <table class="table table-striped table-hover">
      <caption title="{_('Revistas indizadas en CLASE y PERIÓDICA según orden alfabético y número de documentos de cada revista')}"></caption>
			<thead>
				<tr>
					<th>{_('No.')}</th>
					<th>{_('Revista')}</th>
					<th class="text-right">{_('Documentos')}</th>
				</tr>
			</thead>
			<tbody>
{foreach $registros key registro}
				<tr>
					<td>{$key + 1}</td>
					<td>{$registro.revista}</td>
					<td class="text-right"><a class="enlace" href="{site_url('revista/$registro.revistaSlug')}" title="{$registro.revista}">{number_format($registro.articulos)}</a></td>
				</tr>
{/foreach}
				<tr>
          <td class="text-right" colspan=2>{_('Total:')}</td>
          <td class="text-right">{number_format($registrosTotalArticulos)}</td>
        </tr>
			</tbody>
		</table>
