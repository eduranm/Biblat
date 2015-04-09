{if $links != ""}
    <div class="text-center">
      {$links}
    </div>
{/if}
      <table id="resultados" class="table table-striped table-hover">
      <tbody>
{foreach $resultados key resultado}
        <tr>
          <td>{$key}.-</td>
          <td>
            <i>{$resultado.articuloLink}</i><br/>
{if $resultado.autoresHTML}
           {$resultado.autoresHTML}<br/>
{/if}
{if $resultado.institucionesHTML}
           {$resultado.institucionesHTML}<br/>
{/if}
{if $resultado.detalleRevista}
           {$resultado.detalleRevista}<br/>
{/if}
{if !$resultado.addRef}
           {$resultado.addRef}<br/>
{/if}
          </td>
          <td class="nowrap text-right">
            {if $resultado.downloadLink}{$resultado.downloadLink}{/if} {$resultado.mendeleyLink}
          </td>
                </tr>
{/foreach}
      </tbody>
      </table>
{if $links != ""}
    <div class="text-center">
      {$links}
    </div>
{/if}