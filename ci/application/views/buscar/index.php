<?php if(isset($resultados)):?>
<?php	if ($search['disciplina'] != ""):?>
    <div class="page_title">
        <hr/>
        <h4><?php _printf('<i>(%s documentos publicados en el área de <b>%s</b>)</i>', $search['total'], $search['disciplina']);?></h4>
        <hr/>
<?php	else:?>
    <div class="page_title">
        <hr/>
        <h4><?php _printf('<i>%s documentos publicados</i>', $search['total']);?>
<?php if(!$textoCompleto && $search['totalCompleto'] > 0): echo ", ".anchor("{$paginationURL}/texto-completo", _sprintf('<b>mostrar "%s" resultados en texto completo</b>', $search['totalCompleto']), 'title="'._sprintf('mostrar %s resultados en texto completo', $search['totalCompleto']).'"'); endif;?>
<?php if($textoCompleto):?>	
				en texto completo
				<?php endif;?></h4>
      <hr/>
    </div>
<?php 	endif;?>
{$template.partials.view_article}
<?php else:?>
    <div class="page_title">
      <hr/>
      <h4><?php _printf('No se encontraron resultados para la búsqueda por: "%s"', $search['slug']);?></h4>
      <hr/>
    </div>
<?php endif;?>
