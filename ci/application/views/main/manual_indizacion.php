<div id="content">
  <div id="encabezado">
    <div id="migas">
      <p><a href="<?=site_url('/');?>">Inicio</a> / <?php _e('Sobre Biblat');?> / <?php _e('Manual de indización');?></p>
    </div><!--End migas-->
    <div id="share">
      <div id="share1">
        <span class="space"><a href="https://www.facebook.com/pages/BIBLAT/188958071154818" target="_blank">&#Xf09a;</a></span>
        <span class="space"><a href="https://twitter.com/Biblat" target="_blank">&#Xf099;</i></i></a></span>
        <span class="space"><a href="#" target="_blank">?</a></span>
        <span class="space"><a href="mailto:scielo@dgb.unam.mx"><i class="fa fa-envelope-o"></i></a></span>
        <div><a class="share" href="#">Español</a></div>
      </div>
      <div id="share2">
        <a href="#">A<sup>+</sup></a>
        <a href="#">A<sup>-</sup></a>
        <a href="javascript:window.print();"><i class="fa fa-print"></i></a>
      </div>
    </div><!--end share-->
    <div class="titulo_int">
      <h1><?php _e('Manual de indización');?></h1>
    </div><!--end titulo_int-->
    <br class="cf">
  </div><!--end encabezado-->
  <div id="content_txt">
    <table class="tablaGeneral" border=1 cellpadding='3' cellspacing='2'>
      <tr class="encabezado">
        <td width="300"><?php _e('Nombre del campo');?></td>
        <td width="6"><?php _e('Etiquetas');?></td>
        <td width="55"><?php _e('Campos obligatorios');?></td>
        <td width="55"><?php _e('Campos repetibles');?></td>
        <td width="250"><?php _e('Anexos');?></td>
      </tr>
      <tr>
        <td ><a href="#" onclick="MM_openBrWindow('paisrevista.html','','scrollbars=yes,width=650,height=330')"><?php _e('País de la revista');?></a></td>
        <td>008e</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td ><a href="#" onclick="MM_openBrWindow('issn.html','','scrollbars=yes,width=650,height=420')"><?php _e('ISSN');?></a></td>
        <td>022a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('doi.html','','scrollbars=yes,width=750,height=500')"><?php _e('DOI');?></a></td>
        <td>024a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td ><a href="#" onclick="MM_openBrWindow('numsistema.html','','scrollbars=yes,width=650,height=300')"><?php _e('Número de sistema (1)');?></a></td>
        <td>035a</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('fechaingreso.html','','scrollbars=yes,width=650,height=320')"><?php _e('Fecha de ingreso');?></a></td>
        <td>036a</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('enlace.html','','scrollbars=yes,width=650,height=410')"><?php _e('Enlace');?></a></td>
        <td>039a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('idioma.html','','scrollbars=yes,width=650,height=390')"><?php _e('Idioma');?></a></td>
        <td>041a</td>
        <td>X</td>
        <td></td>
        <td><a href="anexos/anexo1-idiomas.pdf" target="_blank"><?php _e('Idioma');?></a></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('autorpersnombre.html','','scrollbars=yes,width=850,height=800')"><?php _e('Autor personal:  Nombre');?></a></td>
        <td>100a</td>
        <td></td>
        <td>X</td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('autorpersreferencia.html','','scrollbars=yes,width=650,height=450')"><?php _e('Autor personal:  Referencia');?></a></td>
        <td>100z</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('autorperscorreo.html','','scrollbars=yes,width=650,height=440')"><?php _e('Autor personal:  Correo electrónico');?></a></td>
        <td>100<span class="datospeke">6</span></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('autorcorinstitucion.html','','scrollbars=yes,width=650,height=600')"><?php _e('Autor corporativo: Institución');?></a></td>
        <td>110a</td>
        <td></td>
        <td>X</td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('autorcordependencia.html','','scrollbars=yes,width=650,height=500')"><?php _e('Autor corporativo: Dependencia');?></a></td>
        <td>110b</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('autorcorpais.html','','scrollbars=yes,width=650,height=500')"><?php _e('Autor corporativo: País');?></a></td>
        <td>110c</td>
        <td></td>
        <td></td>
        <td><a href="anexos/anexo6-codigosgeograficos.pdf" target="_blank"><?php _e('Nombres geográficos');?></a></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('adscreferencia.html','','scrollbars=yes,width=850,height=600')"><?php _e('Adscripción del autor: Referencia');?></a></td>
        <td>120z</td>
        <td></td>
        <td>X</td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('adscinstitucion.html','','scrollbars=yes,width=850,height=500')"><?php _e('Adscripción del autor: Institución');?></a></td>
        <td>120u</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('adscdependencia.html','','scrollbars=yes,width=650,height=500')"><?php _e('Adscripción del autor: Dependencia');?></a></td>
        <td>120v</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('adscciudad.html','','scrollbars=yes,width=650,height=500')"><?php _e('Adscripción del autor: Ciudad y estado');?></a></td>
        <td>120w</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('adscautor.html','','scrollbars=yes,width=650,height=360')"><?php _e('Adscripción del autor: País');?></a></td>
        <td>120x</td>
        <td></td>
        <td></td>
        <td><a href="anexos/anexo6-codigosgeograficos.pdf" target="_blank"><?php _e('Nombres geográficos');?></a></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('revista.html','','scrollbars=yes,width=650,height=500')"><?php _e('Revista');?></a></td>
        <td>222a</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('titulodocumento.html','','scrollbars=yes,width=650,height=500')"><?php _e('Título del documento');?></a></td>
        <td>245a</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('anorevista.html','','scrollbars=yes,width=650,height=350')"><?php _e('Año de la revista');?></a></td>
        <td>260c</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('descvolumen.html','','scrollbars=yes,width=650,height=500')"><?php _e('Descripción bibliográfica (2): Volumen');?></a></td>
        <td>300a</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('descnumero.html','','scrollbars=yes,width=650,height=500')"><?php _e('Descripción bibliográfica: Número');?></a></td>
        <td>300b</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('descmes.html','','scrollbars=yes,width=650,height=500')"><?php _e('Descripción bibliográfica: Mes');?></a></td>
        <td>300c</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('descparte.html','','scrollbars=yes,width=650,height=500')"><?php _e('Descripción bibliográfica: Parte');?></a></td>
        <td>300d</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('descpaginacion.html','','scrollbars=yes,width=650,height=500')"><?php _e('Descripción bibliográfica: Paginación');?></a></td>
        <td>300e</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('referencias.html','','scrollbars=yes,width=650,height=500')"><?php _e('Referencias');?></a></td>
        <td>504a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('resumen.html','','scrollbars=yes,width=650,height=500')"><?php _e('Resumen');?></a></td>
        <td>520</td>
        <td></td>
        <td>X</td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('resumenespanol.html','','scrollbars=yes,width=650,height=500')"><?php _e('Resumen: Español');?></a></td>
        <td>520a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('resumenportugues.html','','scrollbars=yes,width=650,height=500')"><?php _e('Resumen: Portugués');?></a></td>
        <td>520p</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('resumeningles.html','','scrollbars=yes,width=650,height=500')"><?php _e('Resumen: Inglés');?></a></td>
        <td>520i</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('resumenotro.html','','scrollbars=yes,width=650,height=500')"><?php _e('Resumen: Otro resumen');?></a></td>
        <td>520o</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('idiomaresumen.html','','scrollbars=yes,width=650,height=500')"><?php _e('Idioma del resumen');?></a></td>
        <td>546a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('tipodocumento.html','','scrollbars=yes,width=650,height=500')"><?php _e('Tipo de documento');?></a></td>
        <td>590a</td>
        <td>X</td>
        <td></td>
        <td><a href="anexos/anexo2-tiposdedocumento.pdf" target="_blank"><?php _e('Tipo de documento');?></a></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('tipoenfoque.html','','scrollbars=yes,width=650,height=500')"><?php _e('Tipo de documento: Enfoque');?></a></td>
        <td>590b</td>
        <td>X</td>
        <td></td>
        <td><a href="anexos/anexo3-enfoque.pdf" target="_blank"><?php _e('Enfoque');?></a></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('tema.html','','scrollbars=yes,width=650,height=500')"><?php _e('Disciplinas');?></a></td>
        <td>650a</td>
        <td>X</td>
        <td>X</td>
        <td><a href="anexos/anexo4-disciplinas.pdf" target="_blank"><?php _e('Disciplinas');?></a></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('palabraclave.html','','scrollbars=yes,width=700,height=650')"><?php _e('Palabra clave');?></a></td>
        <td>653a</td>
        <td>X</td>
        <td>X</td>
        <td><a href="anexos/anexo5-subdisciplinas.pdf" target="_blank"><?php _e('Subdisciplinas');?></a> / <a href="anexos/anexo6-codigosgeograficos.pdf" target="_blank"><?php _e('Nombres geográficos');?></a></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('keyword.html','','scrollbars=yes,width=650,height=380')"><?php _e('Keyword');?></a></td>
        <td>654a</td>
        <td>X</td>
        <td>X</td>
        <td><a href="anexos/anexo5-subdisciplinas.pdf" target="_blank"><?php _e('Subdisciplinas');?></a> / <a href="anexos/anexo6-codigosgeograficos.pdf" target="_blank"><?php _e('Nombres geográficos');?></a></td>
      </tr>
      <tr>
        <td><a href="#" onclick="MM_openBrWindow('textocompleto.html','','scrollbars=yes,width=650,height=500')"><?php _e('Texto completo');?></a></td>
        <td>856u</td>
        <td></td>
        <td>X</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><a href="anexos/anexo7-tesaurosyglosarios.pdf" target="_blank"><?php _e('Tesauros y Glosarios disponibles en línea');?></a></td>
      </tr>
    </table>
  </div><!--end content_txt-->
</div><!--end content-->