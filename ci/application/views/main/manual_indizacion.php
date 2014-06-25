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
        <td ><a class="manual" href="#man1"><?php _e('País de la revista');?></a></td>
        <td>008e</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td ><a class="manual" href="#man2"><?php _e('ISSN');?></a></td>
        <td>022a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man3"><?php _e('DOI');?></a></td>
        <td>024a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td ><a class="manual" href="#man4"><?php _e('Número de sistema (1)');?></a></td>
        <td>035a</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man5"><?php _e('Fecha de ingreso');?></a></td>
        <td>036a</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man6"><?php _e('Enlace');?></a></td>
        <td>039a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man7"><?php _e('Idioma');?></a></td>
        <td>041a</td>
        <td>X</td>
        <td></td>
        <td><a href="<?=base_url('files/manual_idiomas.pdf');?>" target="_blank"><?php _e('Idioma');?></a></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man8"><?php _e('Autor personal:  Nombre');?></a></td>
        <td>100a</td>
        <td></td>
        <td>X</td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man9"><?php _e('Autor personal:  Referencia');?></a></td>
        <td>100z</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man10"><?php _e('Autor personal:  Correo electrónico');?></a></td>
        <td>100<span class="datospeke">6</span></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man11"><?php _e('Autor corporativo: Institución');?></a></td>
        <td>110a</td>
        <td></td>
        <td>X</td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man12"><?php _e('Autor corporativo: Dependencia');?></a></td>
        <td>110b</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man13"><?php _e('Autor corporativo: País');?></a></td>
        <td>110c</td>
        <td></td>
        <td></td>
        <td><a href="<?=base_url('files/anexo6-codigosgeograficos.pdf');?>"><?php _e('Nombres geográficos');?></a></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man14"><?php _e('Adscripción del autor: Referencia');?></a></td>
        <td>120z</td>
        <td></td>
        <td>X</td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man15"><?php _e('Adscripción del autor: Institución');?></a></td>
        <td>120u</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man16"><?php _e('Adscripción del autor: Dependencia');?></a></td>
        <td>120v</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man17"><?php _e('Adscripción del autor: Ciudad y estado');?></a></td>
        <td>120w</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man18"><?php _e('Adscripción del autor: País');?></a></td>
        <td>120x</td>
        <td></td>
        <td></td>
        <td><a href="<?=base_url('files/anexo6-codigosgeograficos.pdf');?>" target="_blank"><?php _e('Nombres geográficos');?></a></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man19"><?php _e('Revista');?></a></td>
        <td>222a</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man20"><?php _e('Título del documento');?></a></td>
        <td>245a</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man21"><?php _e('Año de la revista');?></a></td>
        <td>260c</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man22"><?php _e('Descripción bibliográfica (2): Volumen');?></a></td>
        <td>300a</td>
        <td>X</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man23"><?php _e('Descripción bibliográfica: Número');?></a></td>
        <td>300b</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man24"><?php _e('Descripción bibliográfica: Mes');?></a></td>
        <td>300c</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man25"><?php _e('Descripción bibliográfica: Parte');?></a></td>
        <td>300d</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man26"><?php _e('Descripción bibliográfica: Paginación');?></a></td>
        <td>300e</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man27"><?php _e('Referencias');?></a></td>
        <td>504a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man28"><?php _e('Resumen');?></a></td>
        <td>520</td>
        <td></td>
        <td>X</td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man29"><?php _e('Resumen: Español');?></a></td>
        <td>520a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man30"><?php _e('Resumen: Portugués');?></a></td>
        <td>520p</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man31"><?php _e('Resumen: Inglés');?></a></td>
        <td>520i</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man32"><?php _e('Resumen: Otro resumen');?></a></td>
        <td>520o</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man33"><?php _e('Idioma del resumen');?></a></td>
        <td>546a</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man34"><?php _e('Tipo de documento');?></a></td>
        <td>590a</td>
        <td>X</td>
        <td></td>
        <td><a href="<?=base_url('files/anexo2-tiposdedocumento.pdf');?>" target="_blank"><?php _e('Tipo de documento');?></a></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man35"><?php _e('Tipo de documento: Enfoque');?></a></td>
        <td>590b</td>
        <td>X</td>
        <td></td>
        <td><a href="<?=base_url('files/anexo3-enfoque.pdf');?>" target="_blank"><?php _e('Enfoque');?></a></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man36"><?php _e('Disciplinas');?></a></td>
        <td>650a</td>
        <td>X</td>
        <td>X</td>
        <td><a href="<?=base_url('files/anexo4-disciplinas.pdf');?>" target="_blank"><?php _e('Disciplinas');?></a></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man37"><?php _e('Palabra clave');?></a></td>
        <td>653a</td>
        <td>X</td>
        <td>X</td>
        <td><a href="<?=base_url('files/anexo5-subdisciplinas.pdf');?>" target="_blank"><?php _e('Subdisciplinas');?></a> / <a href="<?=base_url('files/anexo6-codigosgeograficos.pdf');?>" target="_blank"><?php _e('Nombres geográficos');?></a></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man38"><?php _e('Keyword');?></a></td>
        <td>654a</td>
        <td>X</td>
        <td>X</td>
        <td><a href="<?=base_url('files/anexo5-subdisciplinas.pdf');?>" target="_blank"><?php _e('Subdisciplinas');?></a> / <a href="<?=base_url('files/anexo6-codigosgeograficos.pdf');?>" target="_blank"><?php _e('Nombres geográficos');?></a></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man39"><?php _e('Texto completo');?></a></td>
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
        <td><a href="<?=base_url('files/anexo7-tesaurosyglosarios.pdf');?>" target="_blank"><?php _e('Tesauros y Glosarios disponibles en línea');?></a></td>
      </tr>
    </table>

    <div id="manual" style="display:none">
      <div id="man1">
        <p class="tituloMan"><?php _e('País de la revista');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: País de la revista');?></p>
          <p><?php _e('Etiqueta del campo: 008e');?></p>
          <p><?php _e('Tipo de campo: obligatorio, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _printf('El país en este campo corresponde al lugar en donde se edita la revista. También es anotado por la persona responsable de la circulación del material y en el caso de títulos editados por organismos internacionales, con sede en países de fuera de América Latina y el Caribe, se asienta: Internacional. En el sistema en línea, el analista seleccionará de la tabla correspondiente, el nombre completo del país indicado en la hoja de %s.','<i>Reporte de precodificación</i>');?></p>
        </div>
      </div>

      <div id="man2">
        <p class="tituloMan"><?php _e('ISSN');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: ISSN');?></p>
          <p><?php _e('Etiqueta del campo: 022a');?></p>
          <p><?php _e('Tipo de campo: opcional, alfanumérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('El ISSN es el número internacional normalizado de publicaciones seriadas. En el sistema en línea, en el campo 022a se debe ingresar la misma clave de la revista que se utilizó en el campo anterior (222a), para que el número de ISSN recuperado corresponda al título de la revista. Al igual que en el campo anterior, el sistema extraerá de la lista de encabezamientos, el ISSN de la revista de acuerdo con dicha clave. Si la revista no cuenta con ISSN el analista deberá borrar la clave y dejar el campo en blanco. Se recomienda especial cuidado en el ingreso de la clave, y su verificación con el número recuperado.');?></p>
        </div>
      </div>

      <div id="man3">
        <p class="tituloMan"><?php _e('DOI del documento');?></p><br/>
        <div class="descripcionMan">
          <p><i><?php _e('Nombre del campo en la página web: DOI');?></i></p>
          <p><i><?php _e('Etiqueta del campo: 024a');?></i></p>
          <p><i><?php _e('Tipo de campo: opcional, alfanumérico');?></i></p><br/>
        </div>
        <div class="textoMan">
          <p><?php _printf('El %s es el código identificador de materiales digitales, con fines de normalización, el cual permite su localización en Internet aun cuando la dirección URL hubiera cambiado.','<i>DOI</i>');?></p>
          <p><?php _printf('A partir de enero de 2012, será incluido en los registros de %s y , en el campo 024a, siempre que el documento analizado lo proporcione. Este código %s será tomado de las revistas en línea, como se indica en los ejemplos siguientes, copiando únicamente la parte resaltada que aparece en negrillas, cerciorándose de que se haya “copiado y pegado” adecuadamente.','<i>Clase</i>','<i>Periódica</i>','<i>DOI</i>');?></p>
          <p align="center">http://<i>dx.doi.org/10.1590/S1414-753X2009000100002</i></p>
          <p align="center">doi: <i>10.4067/S0718-22442009000200001</i></p>
          <p><?php _e('En el documento, la información regularmente aparece al inicio, en la parte superior del texto y en algunos casos se repite junto al resumen o al final. También puede ser que se muestre sólo en la versión HTML y no en PDF.');?></p>
          <p><?php _e('Dado que se trata de un código único de identificación para el documento que lo ostenta, se recomienda especial cuidado al asentarlo.');?></p>
        </div>
      </div>
      
      <div id="man4">
        <p class="tituloMan"><?php _e('Número de sistema');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: No. de Sistema');?></p>
          <p><?php _e('Etiqueta del campo: 035a');?></p>
          <p><?php _e('Tipo de campo: obligatorio, numérico');?></p>
        </div><br/>
        <p class="textoMan"><?php _e('Este número es único y generado automáticamente por el sistema al momento de guardar el registro en el servidor.');?></p>
      </div>
      
      <div id="man5">
        <p class="tituloMan"><?php _e('Fecha de ingreso');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('(Este campo no se despliega en la página web)');?></p>
          <p><?php _e('Etiqueta del campo: 036a');?></p>
          <p><?php _e('Tipo de campo: obligatorio, numérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('La fecha en que se ingresa el registro a la base de datos se indica con cuatro dígitos (aa/mm), los dos primeros para el año y los dos siguientes para el mes.');?></p>
          <p align="center">036a 1008 (<?php _e('agosto de 2010)');?></p>
        </div>
      </div>
      
      <div id="man6">
        <p class="tituloMan"><?php _e('Enlace');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('(Este campo no se despliega en la página web)');?></p>
          <p><?php _e('Etiqueta del campo: 039a');?></p>
          <p><?php _e('Tipo de campo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _printf('El campo Enlace, etiqueta 039a, debe contener la abreviatura ENL. (en letras mayúsculas y con punto final) cuando incluimos una dirección electrónica en el campo 856u. Esta abreviatura indicará al sistema que el registro contiene una dirección URL para enlazar al texto completo del documento indizado y permitirá utilizar, en la página web de %s o %s, la opción para realizar búsquedas sólo en artículos con acceso al texto completo.','<i>Clase</i>','<i>Periódica</i>');?></p>
          <p><?php _printf('Esta abreviatura aparece, desde el principio, en la plantilla de registro. Si el documento no tiene una dirección electrónica para acceder al texto completo y, por lo tanto, no se asienta en el campo correspondiente (856u), el campo de %s también deberá quedar en blanco, para lo cual será necesario borrar dicha abreviatura.','<i>Enlace</i>');?></p>
        </div>
      </div>

      <div id="man7">
        <p class="tituloMan"><?php _e('Idioma');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: idioma');?></p>
          <p><?php _e('Etiqueta del campo: 041a');?></p>
          <p><?php _e('Tipo de campo: obligatorio, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('El idioma en que está escrito el documento será codificado de acuerdo con la lista de idiomas del Anexo 1 (página 69), consultable también en la tabla disponible en línea. En algunas revistas los documentos aparecen en dos idiomas, por lo que se podrán codificar ambos, separados por una coma, en el siguiente orden de preferencia:');?></p>
          <ol align="center" type="1">
            <li><?php _e('Español');?></li>
            <li><?php _e('Portugués');?></li>
            <li><?php _e('Inglés');?></li>
            <li><?php _e('Francés');?></li>
            <li><?php _e('Otro');?></li>
          </ol>
        </div>
      </div>

      <div id="man8">
        <p class="tituloMan"><?php _e('Autor personal: Nombre');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: autor');?></p>
          <p><?php _e('Etiqueta del campo: 100a, z, 6');?></p>
          <p><?php _e('Subcampo: 100a');?></p>
          <p><?php _e('Tipo de campo: opcional, repetible, alfanumérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('Se incluyen todos los autores personales de un documento, respetando el orden en que aparezcan asentados (4). La entrada se hará por el apellido paterno; una coma y un espacio en blanco deberán separar los apellidos de los nombres o iniciales de los nombres. Las iniciales deberán ir en mayúsculas con punto y sin separación. Los apellidos abreviados no deberán incluirse. El asentamiento de los autores personales observa las normas establecidas por la Biblioteca del Congreso de los Estados Unidos:');?><a href="http://authorities.loc.gov/webvoy.htm" target="_blank">http://authorities.loc.gov/webvoy.htm</a></p>
          <p><?php _e('(4) Hasta junio de 2009 se indizaban un máximo de ocho autores por documento.');?></p>
          <table width="471" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            <tr>
              <td width="153"><div align="center">Carlos A. Duarte </div></td>
              <td width="118" class="centrado"><i>Codificar</i></td>
              <td width="178"><div align="center">Duarte,  Carlos A.</div></td>
            </tr>
            <tr>
              <td><div align="center">J.M.  García Pesquera</div></td>
              <td class="centrado"><i>Codificar</i></td>
              <td><div align="center">García  Pesquera, J.M.</div></td>
            </tr>
            <tr>
              <td><div align="center">Ramón Limantour L.</div></td>
              <td class="centrado"><i>Codificar</i></td>
              <td><div align="center">Limantour, Ramón</td>
            </tr>
          </table>
          <p><strong><?php _e('Nombres castellanos');?></strong></p>
          <p><?php _e('El apellido paterno será el de entrada y deberá separarse del materno por un espacio. Muchas revistas utilizan guiones para separar el apellido paterno del materno; en estos casos el guión deberá ser ignorado. Se recomienda al analista buscar y respetar la forma normalizada en la lista de encabezamientos de autor.');?></p>
          <p><?php _e('Los guiones serán respetados solamente en el caso de apellidos compuestos.');?></p>
          <table width="566" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            <tr>
              <td width="223"><div align="center">Raúl  Hernández Sánchez-Barba</div></td>
              <td width="91" class="centrado"><i>Codificar</i></td>
              <td width="238"><div align="center">Hernández  Sánchez-Barba, Raúl</div></td>
            </tr>
          </table>
          <p><?php _e('En los apellidos de entrada que tengan preposiciones o artículos, éstos serán pospuestos al final y en letras minúsculas:');?></p>
          <table width="606" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            <tr>
              <td width="202"><div align="center">Aníbal de  la Vega Lewison</div></td>
              <td width="132" class="centrado"><i>Codificar</i></td>
              <td width="258"><div align="center">Vega Lewison, Aníbal de la</div></td>
            </tr>
            <tr>
              <td><div align="center">Jacqueline  Las Heras Trueba</div></td>
              <td class="centrado"><i>Codificar</i></td>
              <td><div align="center">Heras  Trueba, Jacqueline las</div></td>
            </tr>
            <tr>
              <td><div align="center">Rudi van Dantzig</div></td>
              <td class="centrado"><i>Codificar</i></td>
              <td><div align="center">Dantzig, Rudi van</div></td>
            </tr>
          </table>
          <p><?php _e('Serán incluidos también los artículos, preposiciones, conjunciones, apóstrofos y  partículas que formen parte o vayan unidos a un apellido o nombre de pila.');?></p>
          <table width="606" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            <tr>
              <td width="202"><div align="center">María del  Carmen Castañeda</div></td>
              <td width="132" class="centrado"><i>Codificar</i></td>
              <td width="258"><div align="center">Castañeda,  María del Carmen</div></td>
            </tr>
            <tr>
              <td><div align="center">Clementina  Díaz y de Ovando</div></td>
              <td class="centrado"><i>Codificar</i></td>
              <td><div align="center">Díaz y de  Ovando, Clementina</div></td>
            </tr>
            <tr>
              <td><div align="center">Josefina  Laiglesia</div></td>
              <td class="centrado"><i>Codificar</i></td>
              <td><div align="center">Laiglesia,  Josefina</div></td>
            </tr>
            <tr>
              <td><div align="center">John  McCarthy</div></td>
              <td class="centrado"><i>Codificar</i></td>
              <td><div align="center">McCarthy,  John</div></td>
            </tr>
            <tr>
              <td><div align="center">Alvaro de Oliveira D’Antona</div></td>
              <td class="centrado"><i>Codificar</i></td>
              <td><div align="center">D’Antona, Alvaro de Oliveira</div></td>
            </tr>
          </table>
          <p><strong><?php _e('Nombres portugueses');?></strong></p>
          <p><?php _e('El último apellido se anotará en primer término. Las preposiciones y artículos que formen parte del último apellido serán codificadas al final:');?></p>
          <table width="566" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            <tr>
              <td width="223"><div align="center">Regina  Coeli Fernandes da Silva</div></td>
              <td width="91" class="centrado"><i>Codificar</i></td>
              <td width="238"><div align="center">Silva,  Regina Coeli Fernandes da</div></td>
            </tr>
          </table>
          <p><?php _e('Las relaciones de parentesco deberán anexarse al último apellido mediante un guión.');?></p>
          <table width="566" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            <tr>
              <td width="223"><div align="center">Tadeus  Keller Filho</div></td>
              <td width="91" class="centrado"><i>Codificar</i></td>
              <td width="238"><div align="center">Keller-Filho,  Tadeus</div></td>
            </tr>
          </table>
          <p><strong><?php _e('Nombres orientales');?></strong></p>
          <p><?php _e('Los nombres orientales se escribirán tal cual aparezcan en los documentos, salvo en los casos en que el documento indique cuál es el apellido.');?></p>
          <table width="566" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            <tr>
              <td width="223"><div align="center">Chen  Peixun</div></td>
              <td width="91" class="centrado"><i>Codificar</i></td>
              <td width="238"><div align="center">Chen  Peixun</div></td>
            </tr>
            <tr>
              <td><div align="center">U San Tha  Aung</div></td>
              <td class="centrado"><i>Codificar</i></td>
              <td><div align="center">U San Tha  Aung</div></td>
            </tr>
          </table>
          <p><?php _e('En algunos documentos se indica cuál es el apellido de entrada, especialmente con los nombres japoneses. En estos casos el apellido se presenta en mayúsculas.');?></p>
          <table width="566" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            <tr>
              <td width="223"><div align="center">Akihisa MOTOKI </div></td>
              <td width="91" class="centrado"><i>Codificar</i></td>
              <td width="238"><div align="center">Motoki, Akihisa</div></td>
            </tr>
          </table>
          <p><?php _e('De acuerdo con el apartado de este manual referente a signos ortográficos (página 14), los diacríticos y tildes utilizados en cualquier otro idioma diferente al español se obviarán, para evitar dispersión.');?></p>
        </div>
      </div>

      <div id="man9">
        <p class="tituloMan"><?php _e('Autor personal: Referencia');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: autor');?></p>
          <p><?php _e('Etiqueta del campo: 100a, z, 6');?></p>
          <p><?php _e('Subcampo: 100z');?></p>
          <p><?php _e('Tipo de subcampo: opcional, numérico, repetible');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('La referencia es el número con el cual se relaciona al autor con su institución de adscripción. Este número se indicará en el subcampo 100z tal como se indica en el ejemplo.');?></p>
          <div align="center"><img src="<?=base_url('img/autor_ref.jpg');?>"/></div>
          <p><?php _e('En caso de que el documento indizado no indique a qué institución está adscrito un autor, ni su dirección de correo electrónico, los subcampos 100z y 1006 deberán quedar en blanco, por lo cual habrá que eliminar los caracteres precargados () y @.');?></p>
        </div>
      </div>

      <div id="man10">
        <p class="tituloMan"><?php _e('Autor personal: Correo electrónico');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: autor');?></p>
          <p><?php _e('Etiqueta del campo: 100a, z, 6');?></p>
          <p><?php _e('Subcampo: 1006');?></p>
          <p><?php _e('Tipo de subcampo: opcional, alfanumérico, repetible');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('A partir de esta versión del manual se incluirá solamente la dirección de correo electrónico del primer autor o la del autor que la revista indique (5). Este dato, se asentará en el subcampo 1006 del autor correspondiente, aun cuando no tenga institución de adscripción. En caso de que aparezcan varias direcciones para un mismo autor, se incluirá sólo una de ellas, de preferencia la del servidor institucional.');?></p>
          <div align="center"><img src="<?=base_url('img/autorcorreo.jpg');?>"/></div>
        </div>
      </div>
      
      <div id="man11">
        <p class="tituloMan"><?php _e('Autor corporativo: Institución');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: autor corporativo');?></p>
          <p><?php _e('Etiqueta del campo: 110a, b, c');?></p>
          <p><?php _e('Subcampo: 110a');?></p>
          <p><?php _e('Tipo de campo: opcional, repetible, alfanumérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Regla General');?></strong></p>
          <p><?php _e('Algunos documentos son firmados por instituciones y no por personas. En estos casos, los autores institucionales o corporativos se codificarán en este campo como sigue: el nombre en el subcampo a, si el documento proporciona una dependencia se incluirá en el subcampo b, y el país en el subcampo c.');?></p>
          <p><?php _e('Los datos mínimos que se requieren para asentar un autor corporativo son: nombre de la institución y país. Siempre que exista un Autor corporativo, el campo Autor personal  (100a-6) quedará vacío.');?></p>
          <div align="center"><img src="<?=base_url('img/autorcorporativo.jpg');?>"/></div>
          <p><?php _e('Los nombres de las instituciones se codificarán siguiendo las reglas pertinentes del campo INSTITUCIÓN DE ADSCRIPCIÓN (página 23).');?></p>
          <p><strong><?php _e('Documentos Anónimos');?></strong></p>
          <p><?php _e('No deberán incluirse documentos anónimos. Todos los documentos a ingresar deben contar con autores personales o institucionales.');?></p>
          <p><?php _e('Hay documentos que no están firmados, pero es posible que hayan sido generados por la institución que edita la revista o por la propia revista; en tales casos el documento se puede atribuir a alguno de ellos como autor corporativo.');?></p>
        </div>
      </div>
      
      <div id="man12">
        <p class="tituloMan"><?php _e('Autor corporativo: Dependencia');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: autor corporativo');?></p>
          <p><?php _e('Etiqueta del campo: 110a, b, c');?></p>
          <p><?php _e('Subcampo: 110b');?></p>
          <p><?php _e('Tipo de campo: opcional, repetible, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Regla General');?></strong></p>
          <p><?php _e('Algunos documentos son firmados por instituciones y no por personas. En estos casos, los autores institucionales o corporativos se codificarán en este campo como sigue: el nombre en el subcampo a, si el documento proporciona una dependencia se incluirá en el subcampo b, y el país en el subcampo c.');?></p>
          <p><?php _e('Los datos mínimos que se requieren para asentar un autor corporativo son: nombre de la institución y país. Siempre que exista un Autor corporativo, el campo Autor personal  (100a-6) quedará vacío.');?></p>
          <div align="center"><img src="<?=base_url('img/autorcorporativo.jpg');?>"/></div>
          <p><?php _e('Los nombres de las instituciones se codificarán siguiendo las reglas pertinentes del campo INSTITUCIÓN DE ADSCRIPCIÓN (página 23).');?></p>
          <p><strong><?php _e('Documentos Anónimos');?></strong></p>
          <p><?php _e('No deberán incluirse documentos anónimos. Todos los documentos a ingresar deben contar con autores personales o institucionales.');?></p>
          <p><?php _e('Hay documentos que no están firmados, pero es posible que hayan sido generados por la institución que edita la revista o por la propia revista; en tales casos el documento se puede atribuir a alguno de ellos como autor corporativo.');?></p>
        </div>
      </div>

      <div id="man13">
        <p class="tituloMan"><?php _e('Autor corporativo: País');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: autor corporativo');?></p>
          <p><?php _e('Etiqueta del campo: 110a, b, c');?></p>
          <p><?php _e('Subcampo: 110c');?></p>
          <p><?php _e('Tipo de campo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Regla General');?></strong></p>
          <p><?php _e('Algunos documentos son firmados por instituciones y no por personas. En estos casos, los autores institucionales o corporativos se codificarán en este campo como sigue: el nombre en el subcampo a, si el documento proporciona una dependencia se incluirá en el subcampo b, y el país en el subcampo c.');?></p>
          <p><?php _e('Los datos mínimos que se requieren para asentar un autor corporativo son: nombre de la institución y país. Siempre que exista un Autor corporativo, el campo Autor personal  (100a-6) quedará vacío.');?></p>
          <div align="center"><img src="<?=base_url('img/autorcorporativo.jpg');?>"/></div>
          <p><?php _e('Los nombres de las instituciones se codificarán siguiendo las reglas pertinentes del campo INSTITUCIÓN DE ADSCRIPCIÓN (página 23).');?></p>
          <p><strong><?php _e('Documentos Anónimos');?></strong></p>
          <p><?php _e('No deberán incluirse documentos anónimos. Todos los documentos a ingresar deben contar con autores personales o institucionales.');?></p>
          <p><?php _e('Hay documentos que no están firmados, pero es posible que hayan sido generados por la institución que edita la revista o por la propia revista; en tales casos el documento se puede atribuir a alguno de ellos como autor corporativo.');?></p>
        </div>
      </div>

      <div id="man14">
        <p class="tituloMan"><?php _e('Adscripción del autor: Referencia');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: institución');?></p>
          <p><?php _e('Etiqueta del campo: 120z, u, v, w, x');?></p>
          <p><?php _e('Subcampo: 120z');?></p>
          <p><?php _e('Tipo de subcampo: opcional, repetible, numérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('En este campo, la referencia es el número con el cual se relaciona la institución con su autor. Este número se indicará en el subcampo 120z.');?></p>
          <p><?php _e('La enumeración del subcampo 120z (adscripción del autor) deberá corresponder con el subcampo 100z (del campo de autor) para indicar la pertenencia a cada institución.');?></p>
          <div align="center"><img src="<?=base_url('img/institucion.jpg');?>"/></div>
          <p><?php _e('En caso de que un autor no cuente con institución de adscripción, este subcampo quedará vacío, por lo que el analista deberá borrar del registro los signos precargados ( ).');?></p>
        </div>
      </div>
      
      <div id="man15">
        <p class="tituloMan"><?php _e('Adscripción del autor: Institución');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: institución');?></p>
          <p><?php _e('Etiquetas del campo: 120z,u,v,w,x');?></p>
          <p><?php _e('Subcampo: 120u');?></p>
          <p><?php _e('Tipo de campo: opcional, repetible, alfanumérico');?></p>
          <p><i><?php _e('Véanse páginas 23-28 del Manual');?></i></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('La institución de adscripción o afiliación, representa el lugar de trabajo de autores y coautores. En este sentido, la información de adscripción se deberá asentar relacionada con el autor perteneciente a ella, según lo indique el propio documento.');?></p>
          <p><?php _e('El registro de autores y sus respectivas instituciones de afiliación se realiza en dos bloques:');?></p>
          <p><?php _e('Bloque número 1: información del autor, su correo electrónico y un número identificador relacionado con el número asignado a la institución a la cual pertenece.');?></p>
          <div align="center"><img src="<?=base_url('img/adscrejemplo1.jpg');?>"/></div>
          <p><?php _e('Bloque número 2: información de la institución y datos relacionados:');?></p>
          <div align="center"><img src="<?=base_url('img/adscrejemplo2.jpg');?>"/></div>
          <p><?php _e('La codificación de la adscripción del autor observará la siguiente puntuación:');?></p>
          <div align="center"><img src="<?=base_url('img/adscrejemplo5.jpg');?>"/></div>
          <p><?php _e('La asignación de los números de referencia que se asentarán en los subcampos 100z y 120z para la correlación entre autor e institución se realizará de acuerdo con los siguientes criterios:');?></p>
          <ol type="1">
            <li><?php _e('Se incluirán todos los autores y sus instituciones de adscripción.');?></li>
            <li><?php _e('El orden en que se registrarán los autores y sus respectivas instituciones deberá ser el mismo que aparezca en el documento analizado.');?></li>
            <li><?php _e('Una institución es repetible si la dependencia es diferente. También será repetible si la ciudad y estado son diferentes.');?></li>
            <li><?php _e('La enumeración del subcampo 120z se realizará con números consecutivos de  acuerdo con el número de instituciones diferentes, considerando el criterio descrito en el punto anterior.');?></li>
            <li><?php _e('La enumeración del subcampo 120z (adscripción del autor) deberá corresponder con el subcampo 100z (del campo de autor) para indicar la pertenencia a cada institución.');?></li>
          </ol>
          <div align="center"><img src="<?=base_url('img/ref_autor_pers.jpg');?>"/></div>
          <p><?php _e('En caso de que un autor no cuente con institución de adscripción, este subcampo quedará vacío, por lo que el analista deberá borrar del registro los signos precargados ( ).');?></p>
          <p><?php _e('Para que una institución de adscripción pueda ser indizada, debemos conocer por lo menos tres datos: el nombre de la institución, la ciudad y el país en que se localiza.');?></p>
          <p><?php _e('La adscripción institucional de un autor puede ser registrada hasta dos niveles diferentes, a saber:');?></p>
          <ul>
            <li><?php _e('Institución (120u): representa el nivel jerárquico más alto. Como ejemplo podemos citar: una universidad, un ministerio o secretaría de estado, una empresa o un organismo internacional.');?></li>
            <li><?php _e('Dependencia (120v): representa un nivel subordinado, por ejemplo, una facultad dentro de una universidad, una dirección general dentro de una secretaría de estado o la división inmediata inferior de una empresa u organismo internacional. A menudo, las adscripciones no proporcionan todos los niveles en que está organizada una institución por lo que el analista puede ingresar los dos primeros que aparezcan, por ejemplo:');?></li>
          </ul>
          <p align="center"><?php _e('120u Universidad de Granada,');?></p>
          <p align="center"><?php _e('120v Laboratorio de Antropología,');?></p>
          <p><?php _e('Hasta 1997 existía un tercer subcampo en el que podía codificarse un tercer nivel jerárquico correspondiente a las unidades subordinadas de una Dependencia.');?></p>
          <p><?php _e('La información se complementa con:');?></p>
          <ul>
            <li><?php _e('Nombre de la ciudad');?></li>
            <li><?php _e('Nombre de la división político-administrativa en que se ubica la ciudad');?></li>
            <li><?php _e('Nombre del país');?></li>
          </ul>
          <p><?php _e('Podrá omitirse la división político-administrativa cuando ésta no se encuentre en la lista de encabezamientos de ciudad-estado consultable en línea, o no se logre obtener el dato en otras fuentes de información confiables. Deberá omitirse cuando la ciudad y la división política tengan el mismo nombre.');?></p>
          <div align="center"><img src="<?=base_url('img/adscrejemplo3.jpg');?>"/></div>
          <p><?php _e('Cuando una sigla o abreviatura forme parte oficial del nombre, ésta se respetará.');?></p>
          <div align="center"><img src="<?=base_url('img/adscrejemplo4.jpg');?>"/></div>
          <p><?php _e('Se recomienda a todos los analistas que siempre consulten, y tomen los datos, de la lista de encabezamientos disponible en línea, especialmente en el caso de nombres muy largos y que son asentados en las revistas siempre de forma variable. Sólo de esta manera se logrará la consistencia y calidad de esta información.');?></p>
          <p><strong><?php _e('Reglas de identificación:');?></strong></p>
          <ol type="1">
            <li><?php _e('La información de las instituciones de adscripción y sus dependencias, se identificará en los propios documentos. Esta información puede ser encontrada tanto al principio como al final del documento, así como en las “Listas de colaboradores” que aparecen entre las primeras o entre las últimas páginas de un fascículo.');?></li>
            <li><?php _e('Se ingresará una sola institución de adscripción por autor. Frecuentemente un mismo autor aparece relacionado con más de una adscripción, por lo que se deberá codificar considerando lo siguiente:');?>
              <ul type="none">
                <li><?php _e('2.1 La institución en que se generó el trabajo publicado');?></li>
                <li><?php _e('2.2 La que aparezca en primer término');?></li>
              </ul>
            </li>
            <li><?php _e('Se indizarán las instituciones de todos los autores que aparezcan en el documento (una por autor), no importa el país en el cual se ubiquen. Sin embargo, para incluirlas deberán ser diferentes, a nivel de institución y/o dependencia.');?></li>
            <li><?php _e('Cuando se trate de la reproducción parcial o total de una tesis y se indique tanto la institución donde se obtuvo el grado como la institución de adscripción, esta última es la que se deberá ingresar.');?></li>
            <li><?php _e('Las instituciones en que profesores o investigadores eméritos o visitantes, becarios y alumnos realizan sus escritos, deben ser consideradas instituciones de adscripción y por lo tanto, se ingresarán.');?></li>
            <li><?php _e('No se considerarán instituciones de adscripción a las instituciones que patrocinaron la investigación que dio lugar al documento o las instituciones en donde el autor obtuvo sus grados académicos, ya que este tipo de información con frecuencia acompaña a los datos del autor a manera de un breve resumen curricular. Tampoco se ingresarán direcciones personales o cargos como asesores o consultores independientes.');?></li>
            <li><?php _e('No se registra la institución, cuando el autor es un Jefe de Estado y firma como tal.');?></li>
          </ol>
          <p><strong><?php _e('Reglas de indización:');?></strong></p>
          <ol type="1">
            <li><?php _e('Se aplicarán las reglas generales referidas al uso de mayúsculas, minúsculas y signos ortográficos descritos al inicio del presente Manual.');?></li>
            <li><?php _e('Los nombres de todas las instituciones y sus dependencias se registrarán completos, no se utilizarán siglas y abreviaturas, a excepción de los casos en que éstas formen parte oficial del nombre. Cuando se desconozca el nombre desarrollado de una institución, deberá consultarse la lista de encabezamientos correspondiente, o tratar de localizarla en fuentes de información confiables.');?>
              <table width="566" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                <tr>
                  <td width="353"><div align="center">Universidade  Estadual Paulista “Julio de Mesquita Filho”</div>         </td>
                  <td width="72" class="centrado"><i>no:</i></td>
                  <td width="127"><div align="center">UNESP</div></td>
                </tr>
                <tr>
                  <td>Universidad EAFIT</td>
                  <td class="centrado"><i>no:</i></td>
                  <td><div align="center">EAFIT</div></td>
                </tr>
                <tr>
                  <td>Facultad  de Filosofía y Letras</td>
                  <td class="centrado"><i>no:</i></td>
                  <td><div align="center">FFyL</div></td>
                </tr>
              </table>
            </li>
            <li><?php _e('Los nombres de las instituciones y sus dependencias respetarán las siguientes normas respecto del idioma:');?>
              <ul type="none">
                <li><?php _e('3.1 Los nombres de instituciones localizadas en un país de habla castellana, serán indizados en español.');?>
                  <table width="310" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                    <tr>
                      <td width="304"><div align="center">
                        <p align="center">Policlínico Docente de  Camagüey</p>
                      </div></td>
                    </tr>
                  </table>
                </li>
                <li><?php _e('3.2 Los nombres de instituciones localizadas en países de habla portuguesa, serán indizados en portugués, sin diacríticos.');?>
                  <table width="310" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                    <tr>
                      <td width="304"><div align="center">
                        <p align="center">Universidade  de Sao Paulo</p>
                      </div></td>
                    </tr>
                    <tr>
                      <td><div align="center">Secretaria  Nacional de Producao Agropecuaria</div></td>
                    </tr>
                  </table>
                </li>
                <li><?php _e('3.3 Los nombres de instituciones localizadas en países de habla francesa, serán indizados en francés y los de habla italiana en italiano, sin los diacríticos de dichos idiomas.');?>
                  <table width="310" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                    <tr>
                      <td width="304"><div align="center">
                        <p align="center">Universite Claude Bernard Lyon 1</p>
                      </div></td>
                    </tr>
                    <tr>
                      <td><div align="center">Universita degli Studi di Milano</div></td>
                    </tr>
                  </table>
                </li>
                <li><?php _e('3.4 Los nombres de instituciones localizadas en países de habla inglesa o cualquier otro idioma diferente a los cuatro arriba mencionados, serán indizados en inglés.');?>
                  <table width="310" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                    <tr>
                      <td width="304"><div align="center">
                        <p align="center">Byurakan  Astrophysical Observatory</p>
                      </div></td>
                    </tr>
                    <tr>
                      <td><div align="center">Indian Institute of Tropical Meteorology</div></td>
                    </tr>
                    <tr>
                      <td><div align="center">Technical University of Budapest </div></td>
                    </tr>
                    <tr>
                      <td><div align="center">United Nations </div></td>
                    </tr>
                  </table>
                </li>
              </ul>
              <p><?php _e('Con frecuencia los nombres de las instituciones aludidas en el punto 3.4 aparecen en los documentos traducidos al español o al portugués y en ocasiones en su idioma original (húngaro, checo, alemán, etc.). En todos estos casos, si hay duda sobre la forma normalizada de asentar un nombre en inglés se recomienda consultar el sitio web oficial de la institución u organismo, ya que las traducciones oficiales al inglés suelen aparecer en dichos sitios. Si persiste la duda, el nombre podrá ser ingresado tal como aparezca, pero el analista deberá anotar en una lista el nombre no normalizado de la institución que ingresó y entregarla a la Jefatura del Departamento para posterior normalización.');?></p>
            </li>
            <li><?php _e('Los nombres de las ciudades y divisiones político-administrativas deberán escribirse en español, excepto aquellas que no tienen una traducción oficial o que la costumbre recomienda no traducir. Tal es el caso de los nombres de ciudades y estados de Brasil:');?>
              <table width="310" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                <tr>
                  <td width="304"><div align="center">
                    <p align="center">Rio Grande do Sul </p>
                  </div></td>
                </tr>
                <tr>
                  <td height="21"><div align="center">Rio de Janeiro </div></td>
                </tr>
              </table>
              <p><?php _e('En éste y otros casos similares, deberán tomarse en cuenta las indicaciones para diacríticos (página 14).');?></p>
              <p><?php _e('Cuando existan dudas sobre la traducción al español de un nombre geográfico puede consultar la Wikipedia (es.wikipedia.org) en la cual se ha hecho un trabajo de normalización importante en materia de nombres geográficos en diferentes idiomas. Como complemento, puede consultar el Diccionario Geográfico Universal de Guido Gómez da Silva, editado en 1997 y cuya ficha completa aparece en la bibliografía de este manual (página 106).');?></p>
              <p><?php _e('Si la duda persiste, los nombres podrán ser escritos tal como aparezcan en el documento original, pero el analista deberá anotar dicho nombre en una lista y entregarla a la Jefatura del Departamento para fines de normalización.');?></p>
            </li>
            <li><?php _e('El nombre del país se asentará en idioma español, conservando las preposiciones, conjunciones, artículos y demás signos ortográficos que formen parte de él.');?>
              <p><?php _e('Los nombres de países deben ser consultados en el anexo 6 de este Manual (página 85), el cual contiene una lista normalizada de nombres geográficos para su uso en las bases de datos Clase y Periódica.');?></p>
            </li>
          </ol>
        </div>
      </div>

      <div id="man16">
        <p class="tituloMan"><?php _e('Adscripción del autor: Dependencia');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: institución');?></p>
          <p><?php _e('Etiqueta del campo: 120z, u, v, w, x');?></p>
          <p><?php _e('Subcampo: 120v');?></p>
          <p><?php _e('Tipo de subcampo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('La adscripción institucional de un autor puede ser registrada hasta dos niveles diferentes, a saber:');?></p>
          <ul>
            <li><?php _e('Institución (120u): representa el nivel jerárquico más alto. Como ejemplo podemos citar: una universidad, un ministerio o secretaría de estado, una empresa o un organismo internacional');?></li>
            <li><?php _e('Dependencia (120v): representa un nivel subordinado, por ejemplo, una facultad dentro de una universidad, una dirección general dentro de una secretaría de estado o la división inmediata inferior de una empresa u organismo internacional. A menudo, las adscripciones no proporcionan todos los niveles en que está organizada una institución por lo que el analista puede ingresar los dos primeros que aparezcan, por ejemplo:');?>
              120u Universidad de Granada,<br>
              120v Laboratorio de Antropología,
            </li>
          </ul>
          <p><?php _e('Hasta 1997 existía un tercer subcampo en el que podía codificarse un tercer nivel jerárquico correspondiente a las unidades subordinadas de una Dependencia.');?></p>
          <p><?php _e('A partir de octubre de 1998 se asientan los nombres completos de las instituciones y sus dependencias, respetando artículos, conjunciones y preposiciones, y evitando al máximo el uso de abreviaturas o siglas.');?></p>
          <p><?php _e('Se recomienda a todos los analistas que siempre consulten, y tomen los datos, de la lista de encabezamientos disponible en línea, especialmente en el caso de nombres muy largos y que son asentados en las revistas siempre de forma variable. Sólo de esta manera se logrará la consistencia y calidad de esta información');?></p>
          <p><strong><?php _e('Reglas de identificación:');?></strong></p>
          <ol>
            <li><?php _e('La información de las instituciones de adscripción y sus dependencias, se identificará en los propios documentos.  Esta información puede ser encontrada tanto al principio como al final del documento, o en las “Listas de colaboradores” que aparecen entre las primeras o entre las últimas páginas de un fascículo.');?></li>
          </ol>
          <p><strong><?php _e('Reglas de indización:');?></strong></p>
          <ol>
            <li><?php _e('Se aplicarán las reglas generales referidas al uso de mayúsculas, minúsculas y signos ortográficos descritos al inicio del presente Manual.');?></li>
            <li><?php _e('Los nombres de todas las instituciones y sus dependencias se registrarán completos, no se utilizarán siglas y abreviaturas, a excepción de los casos en que éstas formen parte oficial del nombre. Cuando se desconozca el nombre desarrollado de una institución, deberá consultarse la lista de encabezamientos  correspondiente, o tratar de localizarla en fuentes de información confiables.');?>
              <table width="606" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                <tr>
                  <td width="384"><div align="center" class="textolibre">Universidade  Estadual Paulista “Julio de Mesquita Filho”</div></td>
                  <td width="86" class="textolibre"><i>no:</i></td>
                  <td width="122"><div align="center" class="textolibre">UNESP</div></td>
                </tr>
                <tr>
                  <td><div align="center" class="textolibre">Universidad  EAFIT</div></td>
                  <td class="textolibre"><i>no:</i></td>
                  <td><div align="center" class="textolibre">EAFIT</div></td>
                </tr>
                <tr>
                  <td><div align="center" class="textolibre">Facultad  de Filosofía y Letras</div></td>
                  <td class="textolibre"><i>no:</i></td>
                  <td><div align="center" class="textolibre">FFyL</div></td>
                </tr>
              </table>
            </li>
          </ol>
        </div>
      </div>
  
      <div id="man17">
        <p class="tituloMan"><?php _e('Adscripción del autor: Ciudad-estado');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: institución');?></p>
          <p><?php _e('Etiqueta del campo: 120z, u, v, w, x');?></p>
          <p><?php _e('Subcampo: 120w');?></p>
          <p><?php _e('Tipo de campo: obligatorio* , alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('Los nombres de las ciudades y divisiones político-administrativas deberán escribirse en español.');?></p>
          <p><?php _e('Podrá omitirse la división político-administrativa cuando ésta no se encuentre en la lista de encabezamientos de ciudad-estado consultable en línea, o no se logre obtener el dato en otras fuentes de información confiables. Deberá omitirse cuando la ciudad y la división política tengan el mismo nombre.');?></p>
          <p><?php _e('Cuando existan dudas sobre la traducción al español de un nombre, deberá consultar:');?></p>
          <p><?php _printf('Gómez da Silva, Guido. %s, México: Academia Mexicana y Fondo de Cultura Económica, 1997.','<i>“Diccionario Geográfico Universal”</i>');?></p>
          <p><?php _e('Si la duda persiste, los nombres podrán ser escritos tal como aparezcan en el documento original, pero el analista deberá anotar dicho nombre en una lista y entregarla a la Jefatura del Departamento para fines de normalización.');?></p>
          <p>* <?php _e('Es obligatorio cuando se asiente una institución.');?></p>
        </div>
      </div>

      <div id="man18">
        <p class="tituloMan"><?php _e('Adscripción del autor: País');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: institución');?></p>
          <p><?php _e('Etiqueta del campo: 120z, u, v, w, x');?></p>
          <p><?php _e('Subcampo: 120x');?></p>
          <p><?php _e('Tipo de campo: obligatorio* , alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('El nombre del país se asentará en idioma español, conservando las preposiciones, conjunciones, artículos y demás signos ortográficos que formen parte de él.');?></p>
          <p><?php _e('Los nombres de países deben ser consultados en el anexo 6 de este Manual (página  85), el cual contiene una lista normalizada de nombres geográficos para su uso en las bases de datos Clase y Periódica.');?></p>
          <p>* <?php _e('Es obligatorio cuando se asiente una institución.');?></p>
        </div>
      </div>

      <div id="man19">
        <p class="tituloMan"><?php _e('Título de la revista');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: revista');?></p>
          <p><?php _e('Etiqueta del campo: 222a');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('Los títulos son asentados de acuerdo con las normas establecidas por el International Standard Serial Number (ISSN). Si una revista no cuenta con dicho número, entonces se optará por asentarlo tal como aparezca en SERIUNAM considerando que este catálogo se basa en varias fuentes autorizadas como LC (Library of Congress) y OCLC (Online Computer Library Center). Cuando una revista no aparezca en SERIUNAM, entonces el título deberá ser tomado de la cubierta y/o portada de la revista.');?></p>
          <p><?php _e('El título de la revista que se va a indizar, es anotado en la hoja de Reporte de precodificación por la persona responsable de la circulación del material a los analistas y se acompaña de una clave interna numérica, que lo relaciona con su ISSN.');?></p>
          <p><?php _e('En el sistema en línea, en el campo 222 el analista ingresará la clave numérica, para con ella recuperar el título completo de la revista, como se indica en la parte correspondiente al ingreso de datos en el sistema Aleph (página 49).');?></p>
          <p><?php _e('El sistema extraerá de la lista de encabezamientos, el título de la revista normalizado, de acuerdo con dicha clave.');?></p>
          <p><?php _e('Se recomienda especial cuidado en el ingreso de la clave y su verificación con el título recuperado.');?></p>
          <p align="center"><?php _e('222a 23089');?></p>
        </div>
      </div>

      <div id="man20">
        <p class="tituloMan"><?php _e('Título del documento');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: título');?></p>
          <p><?php _e('Etiqueta del subcampo: 245a');?></p>
          <p><?php _e('Tipo de campo: obligatorio, alfanumérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Regla General');?></strong></p>
          <p><?php _e('El título del documento se transcribirá tal como aparezca en el original.');?></p>
          <p><?php _e('Copiar los títulos de la Tabla de contenido o de alguna otra parte de la revista es muy riesgoso, ya que pueden diferir sustancialmente de los que forman parte de cada artículo.');?></p>
          <p><?php _e('En algunos servicios de información, por razones de presentación, los títulos de la Tabla de contenido suelen aparecer en idioma distinto al del artículo original. Por lo tanto, es indispensable verificarlos contra el documento para cerciorarse de su pertinencia.');?></p>
          <p><?php _e('Se respetará la instrucción sobre signos ortográficos descrita en el apartado de instrucciones generales. Las excepciones son:');?></p>
          <ol type="1">
            <li><?php _e('Cuando dicho título (completo) se encuentre entrecomillado, en cuyo caso, dichas comillas ser&aacute;n ignoradas.');?></li>
            <li><?php _e('Cuando aparezca sólo con mayúsculas, entonces se transcribirá con las mayúsculas y minúsculas que correspondan.');?></li>
            <li><?php _e('Cuando los datos del título sean "copiados y pegados" de una versión electrónica, estos podrán conservar los diacríticos, pero se deberá respetar la regla de mayúsculas y minúsculas.');?></li>
          </ol>
          <p><?php _e('Algunas letras griegas y símbolos se pueden ingresar utilizando los códigos ASCII, o activar el teclado para ver la tabla disponible en el Módulo de Catalogación, desde la plantilla que se esté trabajando.');?></p>
          <p><?php _e('No se debe anotar punto final.');?></p>
          <blockquote>
            <p>Linearización estocástica de alinealidades del tipo F(x) sin y;  F(x) cos y</p>
            <p>As equacoes multiquadricas normalizadas para interpolacao de dados geologicos</p>
            <p>Mineralization process in “Porphyry Copper” deposits and the Molybdenite-Chalcopyrite occurrences in Rio de Janeiro-RJ</p>
          </blockquote>
          <p><strong><?php _e('Enriquecimiento de títulos');?></strong></p>
          <p><?php _e('Cuando el título original sea poco claro o no revele el contenido del mismo podrá ser ampliado. El enriquecimiento de información se codificará entre paréntesis angulares. Los textos adicionados deberán ser breves');?></p>
          <table width="606" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
             <tr>
              <td width="271" class="textolibre"><div align="center"><i>Título original</i> </div></td>
              <td width="325" class="textolibre"><div align="center"><i>Título enriquecido</i> </div></td>
            </tr>
            <tr>
              <td class="textolibre"><div align="center"></div></td>
              <td class="textolibre"><div align="center"></div></td>
            </tr>
            <tr>
              <td class="textolibre"><div align="center">Editorial</div></td>
              <td class="textolibre"><div align="center">Editorial  &lt;mujeres y partidos políticos&gt</div></td>
            </tr>
            <tr>
              <td class="textolibre"><div align="center">Informe  anual 1998</div></td>
              <td class="textolibre"><div align="center">Informe  anual 1998 &lt;Bancomer&gt;</div></td>
            </tr>
            <tr>
              <td class="textolibre"><div align="center">Ley 1238</div></td>
              <td class="textolibre"><div align="center">Ley 1238  &lt;Código de tránsito&gt;</div></td>
            </tr>
          </table>
          <p><?php _e('Título de reseña de libro');?></p>
          <p><?php _e('A partir de esta versión del Manual, para el asentamiento de títulos de reseña de libro se usará una adecuación de la norma ISO (International Standard Organization). El orden de la información será el siguiente:');?></p>
          <p><?php _e('Apellido del autor usando letras mayúsculas y minúsculas, coma, nombre(s) del autor o sus iniciales, punto, título del libro, punto, lugar de edición, dos puntos, editorial, coma, año de publicación, coma, número de páginas seguido de un espacio y una sola p (minúscula) con punto.');?></p>
          <blockquote>
            <p>Fix-Zamudio, Héctor. Introducción a la justicia administrativa del ordenamiento mexicano. México: Editora de El Colegio Nacional, 1981, 103 p</p>
            <p></p>
          </blockquote>
          <p><?php _e('Si hay más de un autor, éstos se separarán por punto y coma. Si existe algún dato adicional como la denotación de compiladores, organizadores y editores, número de edición, número ISBN o paginación en números romanos, entre otros, éstos se asentarán como aparezcan.');?></p>
          <blockquote>
            <p>Fernández, Stella Maris. Técnicas del trabajo intelectual. 2a. ed., Buenos Aires: Universidad de Buenos Aires, Facultad de Filosofía y Letras, 1996, XIX-284 p.</p>
            <p>Dorman, Peter (ed.). Sacred Space and Sacred Function in Ancient Thebes. Occasional Proceedings of the Theban Workshop. Studies in Ancient Oriental Civilization, 61. Chicago: The Oriental Institute Press, 2007, 213 p.</p>
          </blockquote>
          <p><?php _e('Cuando la reseña comprenda más de un libro, cada referencia se separará por un punto y seguido, de la siguiente forma:');?></p>
          <blockquote>
            <p>Gardner, R.; Scoging, H. (orgs.).  Mega-geomorphology. Oxford: Oxford University Press, 1983, 240 p. Litvin, V.N. The morphostructure of the Atlantic Ocean floor. Dordrecht: Reidel, 1984, 172 p.  Smith, D.E.; Dawson, A.G. (comps.).  Shorelines and isostasy. London: Academic Press, 1983, 385 p.</p>
          </blockquote>
          <p><?php _e('Si la reseña de libro tiene un título, éste se incluirá al principio, antes de la reseña normalizada. Sin embargo, si el título de la reseña es el mismo que el título del libro, entonces se codificará solamente la referencia bibliográfica iniciando con el apellido del autor o con el nombre de la institución, según sea el caso.');?></p>
          <p><?php _e('Para algunas letras griegas y símbolos se pueden utilizar los códigos ASCII, o activar el teclado para ver la tabla disponible en el módulo de catalogación, desde la plantilla que se esté trabajando. Si existiera cualquier inconveniente y el sistema no reconociera estos códigos, entonces se transcribirá como sigue:');?></p>
          <div align="center"><img src="<?=base_url('img/letrasgriegas.jpg');?>"/></div><br/>
          <p><strong><?php _e('Latitudes y longitudes');?></strong></p>
          <p><?php _e('En los títulos, estas expresiones se codificarán de la siguiente forma respetando el idioma del documento:');?></p>
          <p align="center"><?php _e('24 grados 16’08”S');?></p>
          <p align="center"><?php _e('110 grados 30’09”W');?></p><br/>
          <p><strong><?php _e('Subíndices y superíndices');?></strong></p>
          <p><?php _e('Los subíndices se transcribirán a renglón seguido.');?></p>
          <div align="center"><img src="<?=base_url('img/subindices.jpg');?>"/></div><br/>
          <p><?php _e('Si se trata de superíndices, incluyendo exponentes, se escribirá entre paréntesis el prefijo Sup y los números o letras correspondientes.');?></p>
          <div align="center"><img src="<?=base_url('img/superindices.jpg');?>"/></div><br/>
          <p><strong><?php _e('Abreviaturas y siglas');?></strong></p>
          <p><?php _e('Cuando éstas aparezcan en el título del documento se codificarán sin puntos y todo en mayúsculas.');?></p>
          <table width="606" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            <tr>
              <td width="202"><div align="center">U.N.A.M.</div></td>
              <td width="132" class="centrado"><i>Codificar</i></td>
              <td width="258"><div align="center">UNAM</div></td>
            </tr>
            <tr>
              <td><div align="center">D.F.</div></td>
              <td class="centrado"><i>Codificar</i></td>
              <td><div align="center">DF</div></td>
            </tr>
          </table>
          <p><strong><?php _e('Números ordinales');?></strong></p>
          <p><?php _e('Cuando el teclado de la computadora no cuente con el símbolo para números ordinales, entonces se asentarán como sigue:');?></p>
          <div align="center"><img src="<?=base_url('img/ordinales.jpg');?>"/></div><br/>

        </div>
      </div>
        
      <div id="man21">
        <p class="tituloMan"><?php _e('Año de la revista');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: año');?></p>
          <p><?php _e('Etiqueta del campo: 260c');?></p>
          <p><?php _e('Tipo de campo: obligatorio, alfanumérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('El año del fascículo que será analizado, también se codifica previamente al análisis y se indica utilizando cuatro dígitos. Cuando un fascículo corresponda a dos años, se ingresan ambos sin abreviar.');?></p>
          <table width="350" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            <tr>
              <td width="171"><div align="center">260c    2004</div></td>
              <td width="200" class="centrado">260c    2009-2010</td>
            </tr>
          </table>
        </div>
      </div>
      
      <div id="man22">
        <p class="tituloMan"><?php _e('Descripción bibliográfica: Volumen');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: descripción');?></p>
          <p><?php _e('Etiqueta del campo: 300a, b, c, d, e');?></p>
          <p><?php _e('Subcampo: 300a');?></p>
          <p><?php _e('Tipo de campo: opcional, alfanumérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Volumen, número, mes, parte y paginación');?></strong></p>
          <p><?php _printf('La descripción bibliográfica o colación, consta de los siguientes elementos relativos al fascículo de una revista: %s.','<i>volumen, número, mes, parte y paginación</i>');?></p>
          <p><?php _e('Estos datos serán codificados de acuerdo con la información contenida en el fascículo y cada elemento se ingresará en el subcampo correspondiente, sin punto final, ni espacios entre las letras que anteceden a cada uno de ellos.');?></p>
          <p><?php _e('El volumen será ingresado en el subcampo a y deberá antecederle la letra V; el número en el subcampo b antecedido de la letra N; los meses en el subcampo c abreviados, en letras minúsculas y sin punto; la parte (suplementos, números especiales, estaciones del año, etc.) en el subcampo d sin abreviar, también en minúsculas y sin punto. Finalmente, la paginación siempre en el subcampo e antecedida de la letra P.');?></p>
          <div align="center"><img src="<?=base_url('img/descrbibliogr.jpg');?>"/></div><br/>
          <p><strong><?php _e('Paginación');?></strong></p>
          <p><?php _e('La página inicial y la final de cada documento se asentarán separadas con un guión, sin espacios. Es posible utilizar tanto números como letras, con apego a los signos empleados en la revista.');?></p>
          <p align="center">P234-235</p>
          <p><?php _e('Cuando un documento no tenga paginación continua, sino que ésta se interrumpa y reinicie más adelante en la revista, sólo se indicará la primera página seguida del signo +.');?></p>
          <p align="center">P49+</p>
          <p><?php _e('Cuando el documento conste de una sola página se anota el número sin mayor denotación.');?></p>
          <p align="center">P40</p>
          <p><?php _e('Cuando la paginación use números romanos se codificarán tal como aparezcan en el documento.');?></p>
          <p align="center">PI-XII</p>
          <p align="center">Pi-iii</p>
          <p><?php _e('La numeración puede incluir tanto números arábigos como romanos. En estos casos se indicará la paginación, separando ambos elementos por una coma y un espacio en blanco');?></p>
          <p align="center">Pi-vi, 1-62</p>
          <p><?php _e('Cuando el analista considere indispensable ingresar suplementos o secciones que aparecen sin paginación alguna, o intercaladas en un fascículo, se indicará la página inmediata anterior a la que se encuentra dicho suplemento o sección; se recomienda incluir además, en el campo del Título del documento alguna nota aclaratoria al respecto.');?></p>
          <p align="center">Caricatura. &#60;suplemento sin paginación incluido entre las páginas 86 y 87&#62;</p>
          <p><strong><?php _e('Paginación en revistas electrónicas');?></strong></p>
          <p><?php _e('A partir de 2001 se incluyen en las bases de datos, revistas publicadas en formato electrónico, ya sean versiones electrónicas de revistas impresas o bien, que se publican exclusivamente en formato electrónico. En estos casos, en la etiqueta 300 se codificarán los datos relacionados a volumen, número, mes y paginación, tal como aparezcan, siguiendo las instrucciones para las versiones impresas. En este formato, los documentos no siempre están paginados, por lo tanto, el subcampo de paginación puede o no contener información.');?></p>
          <div align="center"><img src="<?=base_url('img/pagrevelect.jpg');?>"/></div><br/>
        </div>
      </div>

      <div id="man23">
        <p class="tituloMan"><?php _e('Descripción bibliográfica: Número');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: descripción');?></p>
          <p><?php _e('Etiqueta del campo: 300a, b, c, d, e');?></p>
          <p><?php _e('Subcampo: 300b');?></p>
          <p><?php _e('Tipo de campo: opcional, numérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Volumen, número, mes, parte y paginación');?></strong></p>
          <p><?php _printf('La descripción bibliográfica o colación, consta de los siguientes elementos relativos al fascículo de una revista: %s.','<i>volumen, número, mes, parte y paginación</i>');?></p>
          <p><?php _e('Estos datos serán codificados de acuerdo con la información contenida en el fascículo y cada elemento se ingresará en el subcampo correspondiente, sin punto final, ni espacios entre las letras que anteceden a cada uno de ellos.');?></p>
          <p><?php _e('El volumen será ingresado en el subcampo a y deberá antecederle la letra V; el número en el subcampo b antecedido de la letra N; los meses en el subcampo c abreviados, en letras minúsculas y sin punto; la parte (suplementos, números especiales, estaciones del año, etc.) en el subcampo d sin abreviar, también en minúsculas y sin punto. Finalmente, la paginación siempre en el subcampo e antecedida de la letra P.');?></p>
          <div align="center"><img src="<?=base_url('img/descrbibliogr.jpg');?>"/></div><br/>
          <p><strong><?php _e('Paginación');?></strong></p>
          <p><?php _e('La página inicial y la final de cada documento se asentarán separadas con un guión, sin espacios. Es posible utilizar tanto números como letras, con apego a los signos empleados en la revista.');?></p>
          <p align="center">P234-235</p>
          <p><?php _e('Cuando un documento no tenga paginación continua, sino que ésta se interrumpa y reinicie más adelante en la revista, sólo se indicará la primera página seguida del signo +.');?></p>
          <p align="center">P49+</p>
          <p><?php _e('Cuando el documento conste de una sola página se anota el número sin mayor denotación.');?></p>
          <p align="center">P40</p>
          <p><?php _e('Cuando la paginación use números romanos se codificarán tal como aparezcan en el documento.');?></p>
          <p align="center">PI-XII</p>
          <p align="center">Pi-iii</p>
          <p><?php _e('La numeración puede incluir tanto números arábigos como romanos. En estos casos se indicará la paginación, separando ambos elementos por una coma y un espacio en blanco');?></p>
          <p align="center">Pi-vi, 1-62</p>
          <p><?php _e('Cuando el analista considere indispensable ingresar suplementos o secciones que aparecen sin paginación alguna, o intercaladas en un fascículo, se indicará la página inmediata anterior a la que se encuentra dicho suplemento o sección; se recomienda incluir además, en el campo del Título del documento alguna nota aclaratoria al respecto.');?></p>
          <p align="center">Caricatura. &#60;suplemento sin paginación incluido entre las páginas 86 y 87&#62;</p>
          <p><strong><?php _e('Paginación en revistas electrónicas');?></strong></p>
          <p><?php _e('A partir de 2001 se incluyen en las bases de datos, revistas publicadas en formato electrónico, ya sean versiones electrónicas de revistas impresas o bien, que se publican exclusivamente en formato electrónico. En estos casos, en la etiqueta 300 se codificarán los datos relacionados a volumen, número, mes y paginación, tal como aparezcan, siguiendo las instrucciones para las versiones impresas. En este formato, los documentos no siempre están paginados, por lo tanto, el subcampo de paginación puede o no contener información.');?></p>
          <div align="center"><img src="<?=base_url('img/pagrevelect.jpg');?>"/></div><br/>
        </div>
      </div>
      
      <div id="man24">
        <p class="tituloMan"><?php _e('Descripción bibliográfica: Mes');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: descripción');?></p>
          <p><?php _e('Etiqueta del campo: 300a, b, c, d, e');?></p>
          <p><?php _e('Subcampo: 300c');?></p>
          <p><?php _e('Tipo de campo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Volumen, número, mes, parte y paginación');?></strong></p>
          <p><?php _printf('La descripción bibliográfica o colación, consta de los siguientes elementos relativos al fascículo de una revista: %s.','<i>volumen, número, mes, parte y paginación</i>');?></p>
          <p><?php _e('Estos datos serán codificados de acuerdo con la información contenida en el fascículo y cada elemento se ingresará en el subcampo correspondiente, sin punto final, ni espacios entre las letras que anteceden a cada uno de ellos.');?></p>
          <p><?php _e('El volumen será ingresado en el subcampo a y deberá antecederle la letra V; el número en el subcampo b antecedido de la letra N; los meses en el subcampo c abreviados, en letras minúsculas y sin punto; la parte (suplementos, números especiales, estaciones del año, etc.) en el subcampo d sin abreviar, también en minúsculas y sin punto. Finalmente, la paginación siempre en el subcampo e antecedida de la letra P.');?></p>
          <div align="center"><img src="<?=base_url('img/descrbibliogr.jpg');?>"/></div><br/>
          <p><strong><?php _e('Paginación');?></strong></p>
          <p><?php _e('La página inicial y la final de cada documento se asentarán separadas con un guión, sin espacios. Es posible utilizar tanto números como letras, con apego a los signos empleados en la revista.');?></p>
          <p align="center">P234-235</p>
          <p><?php _e('Cuando un documento no tenga paginación continua, sino que ésta se interrumpa y reinicie más adelante en la revista, sólo se indicará la primera página seguida del signo +.');?></p>
          <p align="center">P49+</p>
          <p><?php _e('Cuando el documento conste de una sola página se anota el número sin mayor denotación.');?></p>
          <p align="center">P40</p>
          <p><?php _e('Cuando la paginación use números romanos se codificarán tal como aparezcan en el documento.');?></p>
          <p align="center">PI-XII</p>
          <p align="center">Pi-iii</p>
          <p><?php _e('La numeración puede incluir tanto números arábigos como romanos. En estos casos se indicará la paginación, separando ambos elementos por una coma y un espacio en blanco');?></p>
          <p align="center">Pi-vi, 1-62</p>
          <p><?php _e('Cuando el analista considere indispensable ingresar suplementos o secciones que aparecen sin paginación alguna, o intercaladas en un fascículo, se indicará la página inmediata anterior a la que se encuentra dicho suplemento o sección; se recomienda incluir además, en el campo del Título del documento alguna nota aclaratoria al respecto.');?></p>
          <p align="center">Caricatura. &#60;suplemento sin paginación incluido entre las páginas 86 y 87&#62;</p>
          <p><strong><?php _e('Paginación en revistas electrónicas');?></strong></p>
          <p><?php _e('A partir de 2001 se incluyen en las bases de datos, revistas publicadas en formato electrónico, ya sean versiones electrónicas de revistas impresas o bien, que se publican exclusivamente en formato electrónico. En estos casos, en la etiqueta 300 se codificarán los datos relacionados a volumen, número, mes y paginación, tal como aparezcan, siguiendo las instrucciones para las versiones impresas. En este formato, los documentos no siempre están paginados, por lo tanto, el subcampo de paginación puede o no contener información.');?></p>
          <div align="center"><img src="<?=base_url('img/pagrevelect.jpg');?>"/></div><br/>
        </div>
      </div>
      
      <div id="man25">
        <p class="tituloMan"><?php _e('Descripción bibliográfica: Parte');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: descripción');?></p>
          <p><?php _e('Etiqueta del campo: 300a, b, c, d, e');?></p>
          <p><?php _e('Subcampo: 300d');?></p>
          <p><?php _e('Tipo de campo: opcional, alfanumérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Volumen, número, mes, parte y paginación');?></strong></p>
          <p><?php _printf('La descripción bibliográfica o colación, consta de los siguientes elementos relativos al fascículo de una revista: %s.','<i>volumen, número, mes, parte y paginación</i>');?></p>
          <p><?php _e('Estos datos serán codificados de acuerdo con la información contenida en el fascículo y cada elemento se ingresará en el subcampo correspondiente, sin punto final, ni espacios entre las letras que anteceden a cada uno de ellos.');?></p>
          <p><?php _e('El volumen será ingresado en el subcampo a y deberá antecederle la letra V; el número en el subcampo b antecedido de la letra N; los meses en el subcampo c abreviados, en letras minúsculas y sin punto; la parte (suplementos, números especiales, estaciones del año, etc.) en el subcampo d sin abreviar, también en minúsculas y sin punto. Finalmente, la paginación siempre en el subcampo e antecedida de la letra P.');?></p>
          <div align="center"><img src="<?=base_url('img/descrbibliogr.jpg');?>"/></div><br/>
          <p><strong><?php _e('Paginación');?></strong></p>
          <p><?php _e('La página inicial y la final de cada documento se asentarán separadas con un guión, sin espacios. Es posible utilizar tanto números como letras, con apego a los signos empleados en la revista.');?></p>
          <p align="center">P234-235</p>
          <p><?php _e('Cuando un documento no tenga paginación continua, sino que ésta se interrumpa y reinicie más adelante en la revista, sólo se indicará la primera página seguida del signo +.');?></p>
          <p align="center">P49+</p>
          <p><?php _e('Cuando el documento conste de una sola página se anota el número sin mayor denotación.');?></p>
          <p align="center">P40</p>
          <p><?php _e('Cuando la paginación use números romanos se codificarán tal como aparezcan en el documento.');?></p>
          <p align="center">PI-XII</p>
          <p align="center">Pi-iii</p>
          <p><?php _e('La numeración puede incluir tanto números arábigos como romanos. En estos casos se indicará la paginación, separando ambos elementos por una coma y un espacio en blanco');?></p>
          <p align="center">Pi-vi, 1-62</p>
          <p><?php _e('Cuando el analista considere indispensable ingresar suplementos o secciones que aparecen sin paginación alguna, o intercaladas en un fascículo, se indicará la página inmediata anterior a la que se encuentra dicho suplemento o sección; se recomienda incluir además, en el campo del Título del documento alguna nota aclaratoria al respecto.');?></p>
          <p align="center">Caricatura. &#60;suplemento sin paginación incluido entre las páginas 86 y 87&#62;</p>
          <p><strong><?php _e('Paginación en revistas electrónicas');?></strong></p>
          <p><?php _e('A partir de 2001 se incluyen en las bases de datos, revistas publicadas en formato electrónico, ya sean versiones electrónicas de revistas impresas o bien, que se publican exclusivamente en formato electrónico. En estos casos, en la etiqueta 300 se codificarán los datos relacionados a volumen, número, mes y paginación, tal como aparezcan, siguiendo las instrucciones para las versiones impresas. En este formato, los documentos no siempre están paginados, por lo tanto, el subcampo de paginación puede o no contener información.');?></p>
          <div align="center"><img src="<?=base_url('img/pagrevelect.jpg');?>"/></div><br/>
        </div>
      </div>

      <div id="man26">
        <p class="tituloMan"><?php _e('Descripción bibliográfica: Paginación');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: descripción');?></p>
          <p><?php _e('Etiqueta del campo: 300a, b, c, d, e');?></p>
          <p><?php _e('Subcampo: 300e');?></p>
          <p><?php _e('Tipo de campo: opcional, alfanumérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Volumen, número, mes, parte y paginación');?></strong></p>
          <p><?php _printf('La descripción bibliográfica o colación, consta de los siguientes elementos relativos al fascículo de una revista: %s.','<i>volumen, número, mes, parte y paginación</i>');?></p>
          <p><?php _e('Estos datos serán codificados de acuerdo con la información contenida en el fascículo y cada elemento se ingresará en el subcampo correspondiente, sin punto final, ni espacios entre las letras que anteceden a cada uno de ellos.');?></p>
          <p><?php _e('El volumen será ingresado en el subcampo a y deberá antecederle la letra V; el número en el subcampo b antecedido de la letra N; los meses en el subcampo c abreviados, en letras minúsculas y sin punto; la parte (suplementos, números especiales, estaciones del año, etc.) en el subcampo d sin abreviar, también en minúsculas y sin punto. Finalmente, la paginación siempre en el subcampo e antecedida de la letra P.');?></p>
          <div align="center"><img src="<?=base_url('img/descrbibliogr.jpg');?>"/></div><br/>
          <p><strong><?php _e('Paginación');?></strong></p>
          <p><?php _e('La página inicial y la final de cada documento se asentarán separadas con un guión, sin espacios. Es posible utilizar tanto números como letras, con apego a los signos empleados en la revista.');?></p>
          <p align="center">P234-235</p>
          <p><?php _e('Cuando un documento no tenga paginación continua, sino que ésta se interrumpa y reinicie más adelante en la revista, sólo se indicará la primera página seguida del signo +.');?></p>
          <p align="center">P49+</p>
          <p><?php _e('Cuando el documento conste de una sola página se anota el número sin mayor denotación.');?></p>
          <p align="center">P40</p>
          <p><?php _e('Cuando la paginación use números romanos se codificarán tal como aparezcan en el documento.');?></p>
          <p align="center">PI-XII</p>
          <p align="center">Pi-iii</p>
          <p><?php _e('La numeración puede incluir tanto números arábigos como romanos. En estos casos se indicará la paginación, separando ambos elementos por una coma y un espacio en blanco');?></p>
          <p align="center">Pi-vi, 1-62</p>
          <p><?php _e('Cuando el analista considere indispensable ingresar suplementos o secciones que aparecen sin paginación alguna, o intercaladas en un fascículo, se indicará la página inmediata anterior a la que se encuentra dicho suplemento o sección; se recomienda incluir además, en el campo del Título del documento alguna nota aclaratoria al respecto.');?></p>
          <p align="center">Caricatura. &#60;suplemento sin paginación incluido entre las páginas 86 y 87&#62;</p>
          <p><strong><?php _e('Paginación en revistas electrónicas');?></strong></p>
          <p><?php _e('A partir de 2001 se incluyen en las bases de datos, revistas publicadas en formato electrónico, ya sean versiones electrónicas de revistas impresas o bien, que se publican exclusivamente en formato electrónico. En estos casos, en la etiqueta 300 se codificarán los datos relacionados a volumen, número, mes y paginación, tal como aparezcan, siguiendo las instrucciones para las versiones impresas. En este formato, los documentos no siempre están paginados, por lo tanto, el subcampo de paginación puede o no contener información.');?></p>
          <div align="center"><img src="<?=base_url('img/pagrevelect.jpg');?>"/></div><br/>
        </div>
      </div>
      
      <div id="man27">
        <p class="tituloMan"><?php _e('Referencias');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('(Este campo no se despliega en la página web)');?></p>
          <p><?php _e('Etiqueta del campo: 504a');?></p>
          <p><?php _e('Tipo de campo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('A partir de septiembre de 2002, las referencias bibliográficas o notas contenidas en los documentos no son contabilizadas, pero se anota en este campo la abreviatura: Refs., la cual aparecerá, precargada, en la plantilla de catalogación.');?></p>
          <p><?php _e('Esta leyenda indicará al usuario que el documento sí contiene referencias, citas o notas bibliográficas.');?></p>
          <p><?php _e('Para ser consideradas como referencias, cada una deberá tener los datos mínimos para su recuperación como son: autor, título, fuente, año y paginación. En el caso de las fuentes electrónicas deberá tener además la dirección URL completa y la fecha de consulta.');?></p>
          <p><?php _e('Las referencias pueden encontrarse tanto al final del documento, como al pie de página e intercaladas en el texto o en diversas notas.');?></p>
          <p><?php _e('En el caso de reseñas de libros, no se deberá considerar la referencia del libro reseñado.');?></p>
          <p><?php _e('Nota: Si el documento no incluye referencias bibliográficas, el analista deberá borrar la abreviatura y dejar el campo en blanco.');?></p>
        </div>
      </div>

      <div id="man28">
        <p class="tituloMan"><?php _e('Resumen');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: resumen, resumo, abstract');?></p>
          <p><?php _e('Etiqueta del campo: 520a, 520p, 520i');?></p>
          <p><?php _e('Tipo de campo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Regla General');?></strong></p>
          <p><?php _e('A partir de noviembre de 2007, se incluyen tres campos para resúmenes, cuando la revista proporciona uno o varios resúmenes del documento que se está indizando.');?></p>
          <blockquote>
            <blockquote>
              <blockquote>
                <blockquote>
                  <p>520a    Resumen en idioma español<br />
                  520p    Resumen en idioma portugués<br />
                  520i     Resumen en idioma inglés</p>
                </blockquote>
              </blockquote>
            </blockquote>
          </blockquote>
          <p><?php _e('Los resúmenes serán incluidos en el caso de revistas electrónicas de las cuales sea factible “copiar y pegar”, con objeto de mantener la integridad del texto. El analista deberá revisar que se haya copiado adecuadamente.');?></p>
          <p><?php _e('Se incorporarán hasta un máximo de tres resúmenes conforme a los tres idiomas considerados: español (520a), portugués (520p) e inglés (520i). Esto contempla cualquiera de las combinaciones posibles: inclusión de uno, dos o tres resúmenes, en  los tres idiomas mencionados.');?></p>
          <p><?php _e('Cada resumen terminará con un punto final a menos que, debido a la longitud del campo, el resumen se haya copiado incompleto.');?></p>
          <p><?php _e('Cuando, además de los tres idiomas arriba mencionados, aparezca un cuarto resumen en otro idioma, este último ya no se incluirá.');?></p>
          <div align="center"><img src="<?=base_url('img/resumen.jpg');?>"/></div><br/>
          <p><strong><?php _e('Otro resumen');?></strong></p>
          <p><?php _e('En caso de que el documento y el resumen principal se encuentren en un idioma diferente a los que considera este apartado, dicho resumen se podrá asentar en la etiqueta 520o destinada a Otro resumen para no dejarlo fuera; de cualquier forma el número máximo de resúmenes que se puede incluir en un registro es de tres. Consultar la lista de Campos disponibles para Clase o Periódica y agregar otro campo para esta opción, cuando se requiera.');?></p>
          <p><?php _e('Al igual que en el campo de Idioma del resumen, sólo se incluirán los que formen parte del cuerpo del artículo.');?></p>
        </div>
      </div>

      <div id="man29">
        <p class="tituloMan"><?php _e('Resumen: Español');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: RESUMEN');?></p>
          <p><?php _e('Etiqueta del campo: 520a');?></p>
          <p><?php _e('Tipo de campo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Regla General');?></strong></p>
          <p><?php _e('A partir de noviembre de 2007, se incluyen tres campos para resúmenes, cuando la revista proporciona uno o varios resúmenes del documento que se está indizando.');?></p>
          <blockquote>
            <blockquote>
              <blockquote>
                <blockquote>
                  <p>520a    Resumen en idioma español<br />
                  520p    Resumen en idioma portugués<br />
                  520i     Resumen en idioma inglés</p>
                </blockquote>
              </blockquote>
            </blockquote>
          </blockquote>
          <p><?php _e('Los resúmenes serán incluidos en el caso de revistas electrónicas de las cuales sea factible “copiar y pegar”, con objeto de mantener la integridad del texto. El analista deberá revisar que se haya copiado adecuadamente.');?></p>
          <p><?php _e('Se incorporarán hasta un máximo de tres resúmenes conforme a los tres idiomas considerados: español (520a), portugués (520p) e inglés (520i). Esto contempla cualquiera de las combinaciones posibles: inclusión de uno, dos o tres resúmenes, en  los tres idiomas mencionados.');?></p>
          <p><?php _e('Cada resumen terminará con un punto final a menos que, debido a la longitud del campo, el resumen se haya copiado incompleto.');?></p>
          <p><?php _e('Cuando, además de los tres idiomas arriba mencionados, aparezca un cuarto resumen en otro idioma, este último ya no se incluirá.');?></p>
          <div align="center"><img src="<?=base_url('img/resumen.jpg');?>"/></div><br/>
          <p><strong><?php _e('Otro resumen');?></strong></p>
          <p><?php _e('En caso de que el documento y el resumen principal se encuentren en un idioma diferente a los que considera este apartado, dicho resumen se podrá asentar en la etiqueta 520o destinada a Otro resumen para no dejarlo fuera; de cualquier forma el número máximo de resúmenes que se puede incluir en un registro es de tres. Consultar la lista de Campos disponibles para Clase o Periódica y agregar otro campo para esta opción, cuando se requiera.');?></p>
          <p><?php _e('Al igual que en el campo de Idioma del resumen, sólo se incluirán los que formen parte del cuerpo del artículo.');?></p>
        </div>
      </div>

      <div id="man30">
        <p class="tituloMan"><?php _e('Resumen: Portugués');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: RESUMO');?></p>
          <p><?php _e('Etiqueta del campo: 520p');?></p>
          <p><?php _e('Tipo de campo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Regla General');?></strong></p>
          <p><?php _e('A partir de noviembre de 2007, se incluyen tres campos para resúmenes, cuando la revista proporciona uno o varios resúmenes del documento que se está indizando.');?></p>
          <blockquote>
            <blockquote>
              <blockquote>
                <blockquote>
                  <p>520a    Resumen en idioma español<br />
                  520p    Resumen en idioma portugués<br />
                  520i     Resumen en idioma inglés</p>
                </blockquote>
              </blockquote>
            </blockquote>
          </blockquote>
          <p><?php _e('Los resúmenes serán incluidos en el caso de revistas electrónicas de las cuales sea factible “copiar y pegar”, con objeto de mantener la integridad del texto. El analista deberá revisar que se haya copiado adecuadamente.');?></p>
          <p><?php _e('Se incorporarán hasta un máximo de tres resúmenes conforme a los tres idiomas considerados: español (520a), portugués (520p) e inglés (520i). Esto contempla cualquiera de las combinaciones posibles: inclusión de uno, dos o tres resúmenes, en  los tres idiomas mencionados.');?></p>
          <p><?php _e('Cada resumen terminará con un punto final a menos que, debido a la longitud del campo, el resumen se haya copiado incompleto.');?></p>
          <p><?php _e('Cuando, además de los tres idiomas arriba mencionados, aparezca un cuarto resumen en otro idioma, este último ya no se incluirá.');?></p>
          <div align="center"><img src="<?=base_url('img/resumen.jpg');?>"/></div><br/>
          <p><strong><?php _e('Otro resumen');?></strong></p>
          <p><?php _e('En caso de que el documento y el resumen principal se encuentren en un idioma diferente a los que considera este apartado, dicho resumen se podrá asentar en la etiqueta 520o destinada a Otro resumen para no dejarlo fuera; de cualquier forma el número máximo de resúmenes que se puede incluir en un registro es de tres. Consultar la lista de Campos disponibles para Clase o Periódica y agregar otro campo para esta opción, cuando se requiera.');?></p>
          <p><?php _e('Al igual que en el campo de Idioma del resumen, sólo se incluirán los que formen parte del cuerpo del artículo.');?></p>
        </div>
      </div>
      
      <div id="man31">
        <p class="tituloMan"><?php _e('Resumen: Inglés');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: ABSTRACT');?></p>
          <p><?php _e('Etiqueta del campo: 520i');?></p>
          <p><?php _e('Tipo de campo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Regla General');?></strong></p>
          <p><?php _e('A partir de noviembre de 2007, se incluyen tres campos para resúmenes, cuando la revista proporciona uno o varios resúmenes del documento que se está indizando.');?></p>
          <blockquote>
            <blockquote>
              <blockquote>
                <blockquote>
                  <p>520a    Resumen en idioma español<br />
                  520p    Resumen en idioma portugués<br />
                  520i     Resumen en idioma inglés</p>
                </blockquote>
              </blockquote>
            </blockquote>
          </blockquote>
          <p><?php _e('Los resúmenes serán incluidos en el caso de revistas electrónicas de las cuales sea factible “copiar y pegar”, con objeto de mantener la integridad del texto. El analista deberá revisar que se haya copiado adecuadamente.');?></p>
          <p><?php _e('Se incorporarán hasta un máximo de tres resúmenes conforme a los tres idiomas considerados: español (520a), portugués (520p) e inglés (520i). Esto contempla cualquiera de las combinaciones posibles: inclusión de uno, dos o tres resúmenes, en  los tres idiomas mencionados.');?></p>
          <p><?php _e('Cada resumen terminará con un punto final a menos que, debido a la longitud del campo, el resumen se haya copiado incompleto.');?></p>
          <p><?php _e('Cuando, además de los tres idiomas arriba mencionados, aparezca un cuarto resumen en otro idioma, este último ya no se incluirá.');?></p>
          <div align="center"><img src="<?=base_url('img/resumen.jpg');?>"/></div><br/>
          <p><strong><?php _e('Otro resumen');?></strong></p>
          <p><?php _e('En caso de que el documento y el resumen principal se encuentren en un idioma diferente a los que considera este apartado, dicho resumen se podrá asentar en la etiqueta 520o destinada a Otro resumen para no dejarlo fuera; de cualquier forma el número máximo de resúmenes que se puede incluir en un registro es de tres. Consultar la lista de Campos disponibles para Clase o Periódica y agregar otro campo para esta opción, cuando se requiera.');?></p>
          <p><?php _e('Al igual que en el campo de Idioma del resumen, sólo se incluirán los que formen parte del cuerpo del artículo.');?></p>
        </div>
      </div>

      <div id="man32">
        <p class="tituloMan"><?php _e('Resumen: Otro');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: OTRO');?></p>
          <p><?php _e('Etiqueta del campo: 520o');?></p>
          <p><?php _e('Tipo de campo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Regla General');?></strong></p>
          <p><?php _e('A partir de noviembre de 2007, se incluyen tres campos para resúmenes, cuando la revista proporciona uno o varios resúmenes del documento que se está indizando.');?></p>
          <blockquote>
            <blockquote>
              <blockquote>
                <blockquote>
                  <p>520a    Resumen en idioma español<br />
                  520p    Resumen en idioma portugués<br />
                  520i     Resumen en idioma inglés</p>
                </blockquote>
              </blockquote>
            </blockquote>
          </blockquote>
          <p><?php _e('Los resúmenes serán incluidos en el caso de revistas electrónicas de las cuales sea factible “copiar y pegar”, con objeto de mantener la integridad del texto. El analista deberá revisar que se haya copiado adecuadamente.');?></p>
          <p><?php _e('Se incorporarán hasta un máximo de tres resúmenes conforme a los tres idiomas considerados: español (520a), portugués (520p) e inglés (520i). Esto contempla cualquiera de las combinaciones posibles: inclusión de uno, dos o tres resúmenes, en  los tres idiomas mencionados.');?></p>
          <p><?php _e('Cada resumen terminará con un punto final a menos que, debido a la longitud del campo, el resumen se haya copiado incompleto.');?></p>
          <p><?php _e('Cuando, además de los tres idiomas arriba mencionados, aparezca un cuarto resumen en otro idioma, este último ya no se incluirá.');?></p>
          <div align="center"><img src="<?=base_url('img/resumen.jpg');?>"/></div><br/>
          <p><strong><?php _e('Otro resumen');?></strong></p>
          <p><?php _e('En caso de que el documento y el resumen principal se encuentren en un idioma diferente a los que considera este apartado, dicho resumen se podrá asentar en la etiqueta 520o destinada a Otro resumen para no dejarlo fuera; de cualquier forma el número máximo de resúmenes que se puede incluir en un registro es de tres. Consultar la lista de Campos disponibles para Clase o Periódica y agregar otro campo para esta opción, cuando se requiera.');?></p>
          <p><?php _e('Al igual que en el campo de Idioma del resumen, sólo se incluirán los que formen parte del cuerpo del artículo.');?></p>
        </div>
      </div>

      <div id="man33">
        <p class="tituloMan"><?php _e('Idioma del resumen');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: idioma del resumen');?></p>
          <p><?php _e('Etiqueta del campo: 546a');?></p>
          <p><?php _e('Tipo de campo: opcional, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('El o los idiomas de los resúmenes se codificarán también de acuerdo con la lista de idiomas del anexo 1 (página 69), disponible también en la tabla en línea. Se podrán codificar hasta cuatro idiomas de resúmenes por cada documento, separándolos con comas y conservando la jerarquía arriba mencionada. Algunas de las combinaciones que se presentan con más frecuencia son:');?></p>
          <p>
            <?php _e('Español');?><br/>
            <?php _e('Español, portugués');?><br/>
            <?php _e('Portugués, inglés');?><br/>
            <?php _e('Español, portugués, inglés');?><br/>
            <?php _e('Español, portugués, inglés, francés');?><br/>
          </p>
          <p><?php _e('Se indizarán únicamente los idiomas que aparezcan en el cuerpo del artículo. Si los resúmenes aparecen separados del artículo, al principio o al final del fascículo, no deberán ser considerados, dado que no son recuperables al consultar un artículo en línea o mediante copias impresas o digitalizadas del artículo.');?></p>
        </div>
      </div>

      <div id="man34">
        <p class="tituloMan"><?php _e('Tipo de documento y enfoque');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: tipo de documento, enfoque');?></p>
          <p><?php _e('Etiqueta del campo: 590a, b');?></p>
          <p><?php _e('Tipo de campo: obligatorio, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('El Tipo de documento y el Enfoque serán codificados, en ese orden, en un mismo campo denominado tipo de documento. Hasta 1997, estos datos se asentaban por separado.');?></p>
          <p><?php _e('Basándose en la extensión, forma o género de cada documento, le será asignado un Tipo de Documento. La lista puede ser consultada en el anexo 2 (página 70) o en la Tabla disponible en línea.');?></p>
          <p><?php _e('Para indicar el enfoque o manejo que el autor hace del asunto que desarrolla, se elegirán uno o dos Enfoques, de acuerdo con la lista del anexo 3 (página 72) o seleccionándolos de la Tabla disponible en línea.');?></p>
          <p><?php _e('Al momento de ingresar los datos en este campo, primero se codificará el Tipo de documento con un punto al final. A continuación el o los Enfoques, hasta un máximo de dos, separados por una coma y sin punto final.');?></p>
          <div align="center"><img src="<?=base_url('img/tipodocumento.jpg');?>"/></div><br/>
        </div>
      </div>

      <div id="man35">
        <p class="tituloMan"><?php _e('Tipo de documento y enfoque');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: tipo de documento, enfoque');?></p>
          <p><?php _e('Etiqueta del campo: 590a, b');?></p>
          <p><?php _e('Tipo de campo: obligatorio, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('El Tipo de documento y el Enfoque serán codificados, en ese orden, en un mismo campo denominado tipo de documento. Hasta 1997, estos datos se asentaban por separado.');?></p>
          <p><?php _e('Basándose en la extensión, forma o género de cada documento, le será asignado un Tipo de Documento. La lista puede ser consultada en el anexo 2 (página 70) o en la Tabla disponible en línea.');?></p>
          <p><?php _e('Para indicar el enfoque o manejo que el autor hace del asunto que desarrolla, se elegirán uno o dos Enfoques, de acuerdo con la lista del anexo 3 (página 72) o seleccionándolos de la Tabla disponible en línea.');?></p>
          <p><?php _e('Al momento de ingresar los datos en este campo, primero se codificará el Tipo de documento con un punto al final. A continuación el o los Enfoques, hasta un máximo de dos, separados por una coma y sin punto final.');?></p>
          <div align="center"><img src="<?=base_url('img/tipodocumento.jpg');?>"/></div><br/>
        </div>
      </div>

      <div id="man36">
        <p class="tituloMan"><?php _e('Disciplinas');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: disciplina');?></p>
          <p><?php _e('Etiqueta del campo: 650a');?></p>
          <p><?php _e('Tipo de campo: obligatorio, repetible, alfabético');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('Las disciplinas representan áreas del conocimiento que permiten clasificar a cada documento de acuerdo con su especialidad.');?></p>
          <p><?php _e('A cada documento se le puede asignar de una a tres disciplinas en orden descendente de importancia. Dada la cobertura multidisciplinaria de las bases de datos Clase y Periódica,   se pueden asignar diferentes disciplinas, de acuerdo con el contenido del documento.');?></p>
          <div align="center"><img src="<?=base_url('img/disciplinas.jpg');?>"/></div><br/>
          <p><?php _e('La lista completa de disciplinas aparece en el anexo 4 (página 73) o bien, en el sistema en línea consultando la lista de encabezamientos en este campo.');?></p>
          <p><?php _e('Los nombres de las disciplinas utilizados se derivan de una clasificación propia elaborada en el Departamento de Bibliografía Latinoamericana, basada en la clasificación de la ciencia de la UNESCO  -modificada por CONACYT- pero adecuada a los contenidos de las publicaciones periódicas latinoamericanas.');?></p>
          <p><?php _e('A partir de junio de 2010, este campo se dedica a la asignación de Disciplinas. Hasta antes de esta fecha, se utilizó para asentar Subdisciplinas, las cuales fueron incorporadas al campo de Palabras clave (653a). Por lo tanto, el vocabulario controlado utilizado hasta entonces como Subdisciplinas (o Temas), se asienta ahora como palabras clave.');?></p>
        </div>
      </div>

      <div id="man37">
        <p class="tituloMan"><?php _e('Palabras clave y keywords');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: palabra clave y keyword');?></p>
          <p><?php _e('Etiquetas de los campos: 653a, 654a');?></p>
          <p><?php _e('Tipo de campos: obligatorios, repetibles, alfanuméricos');?></p>
        </div><br/>
        <div class="textoMan">
          <table border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="372" valign="top" class="textolibre"><ul type="square">
                <li><a class="manual" href="#key1">Regla general</a></li>    
              </ul></td>
              <td width="372" valign="top" class="textolibre"><ul type="square">
                <li><a class="manual" href="#key2">Nombres de países, divisiones políticas y ciudades</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a class="manual" href="#key3">Lenguaje de indización</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('nombresregiones.html','','scrollbars=yes,width=750,height=420')">Regiones políticas, económicas, históricas o naturales</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('tipoterminos.html','','scrollbars=yes,width=750,height=650')">Tipos de términos</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('nomaccgeograf.html','','scrollbars=yes,width=650,height=450')">Nombres de accidentes geográficos</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('numpalasignar.html','','scrollbars=yes,width=750,height=650')">Número de palabras clave a asignar</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('nombresinstituciones.html','','scrollbars=yes,width=750,height=550')">Nombres de instituciones</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('articprepconj.html','','scrollbars=yes,width=750,height=550')">Artículos, preposiciones y conjunciones</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('gruposetnicos.html','','scrollbars=yes,width=750,height=500')">Grupos étnicos</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('sinonimos.html','','scrollbars=yes,width=750,height=350')">Sinónimos</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('titulosobras.html','','scrollbars=yes,width=750,height=420')">Títulos de obras</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('singularplural.html','','scrollbars=yes,width=750,height=550')">Uso de singular y plural</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('titulosrevistas.html','','scrollbars=yes,width=750,height=550')">Títulos de revistas</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                 <li><a href="#" onclick="MM_openBrWindow('letrasgriegas.html','','scrollbars=yes,width=750,height=450')">Letras griegas</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
            <li><a href="#" onclick="MM_openBrWindow('nomenclatura.html','','scrollbars=yes,width=750,height=550')">Nomenclatura química</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
               <li><a href="#" onclick="MM_openBrWindow('nombrespersonas.html','','scrollbars=yes,width=750,height=550')">Nombres de personas</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('suelos.html','','scrollbars=yes,width=750,height=450')">Suelos</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('seudonimos.html','','scrollbars=yes,width=750,height=500')">Seudónimos</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('variedades.html','','scrollbars=yes,width=750,height=400')">Variedades</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('nombresrealeza.html','','scrollbars=yes,width=750,height=550')">Nombres de realeza y religiosos</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('cruzas.html','','scrollbars=yes,width=750,height=630')">Cruzas</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('siglas.html','','scrollbars=yes,width=750,height=550')">Siglas</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('clima.html','','scrollbars=yes,width=750,height=550')">Clima</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('palabrasoconceptos.html','','scrollbars=yes,width=750,height=450')">Palabras o conceptos ligados al nombre de una persona o lugar</a></li>
                </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('latitudes.html','','scrollbars=yes,width=750,height=350')">Latitudes y longitudes</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('fechas.html','','scrollbars=yes,width=750,height=480')">Fechas</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('taxonomia.html','','scrollbars=yes,width=750,height=650')">Taxonomía</a></li>
              </ul></td>
            </tr>
            <tr>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('nombresgeograf.html','','scrollbars=yes,width=750,height=600')">Nombres geográficos</a></li>
              </ul></td>
              <td valign="top" class="textolibre"><ul type="square">
                <li><a href="#" onclick="MM_openBrWindow('nombrescomunes.html','','scrollbars=yes,width=750,height=550')">Nombres comunes</a></li>
              </ul></td>
            </tr>
          </table>
        </div>
      </div>

      <div id="man38">
        <p class="tituloMan"><?php _e('Palabras clave y keywords');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: palabra clave y keyword');?></p>
          <p><?php _e('Etiquetas de los campos: 653a, 654a');?></p>
          <p><?php _e('Tipo de campos: obligatorios, repetibles, alfanuméricos');?></p>
          <p><?php _e('');?></p>
        </div><br/>
        <div class="textoMan">
          <p><strong><?php _e('Keyword');?></strong></p>
          <p><?php _e('Las keywords (654a) sólo se incluyen en Periódica. Son expresiones en inglés formadas por uno o más términos extraidos del documento que se analiza y que denotan o reflejan el contenido intelectual del documento en forma específica.');?></p>
          <p><?php _e('Para su selección y asignación favor de consultar y aplicar los criterios contenidos en el apartado Palabra clave y keywords.');?></p>
        </div>
      </div>

      <div id="man39">
        <p class="tituloMan"><?php _e('Texto completo');?></p><br/>
        <div class="descripcionMan">
          <p><?php _e('Nombre del campo en la página web: texto completo');?></p>
          <p><?php _e('Etiqueta del campo: 856u');?></p>
          <p><?php _e('Tipo de campo: opcional, alfanumérico');?></p>
        </div><br/>
        <div class="textoMan">
          <p><?php _e('A partir de 2004 se empezaron a agregar direcciones electrónicas para enlazar al texto completo, a registros ya existentes en las bases de datos Clase y Periódica. A partir de 2005 los enlaces se ingresan en el momento de crear un registro.');?></p>
          <p><?php _e('Se incluyen enlaces al texto completo de artículos de revistas electrónicas que se encuentran en sitios que se consideran formales y confiables, los cuales ofrecen acceso libre a los textos sin necesidad de registro previo o clave de acceso.');?></p>
          <p><?php _e('También se incluyen enlaces al texto completo de documentos alojados en el acervo de Hevila (página 64). Este acervo forma parte de la Hemeroteca Latinoamericana y, por lo tanto, su acceso ofrece todas las ventajas.');?></p>
          <p><?php _e('La dirección electrónica debe asentarse en el campo 856u cerciorándose de que en el campo 039a (Enlace) quede asentada la abreviatura ENL. (incluyendo el punto), la cual aparece precargada en la plantilla de catalogación.');?></p>
          <p><?php _e('En los casos en que no exista una dirección electrónica por artículo, sino que ésta sólo lleva a la tabla de contenido, se incluirá dicha dirección siempre y cuando, ya en la página, la tabla de contenido permita el acceso al texto completo de cada artículo.');?></p>
          <p><?php _e('También se considera como enlace aceptable, la dirección de las revistas que ofrezcan el  acceso al contenido de todo el fascículo en un mismo archivo y no un archivo separado para cada artículo. En estos casos el criterio principal es tener el acceso al texto completo de los artículos.');?></p>
          <p><?php _e('Después de incluir cualquier dirección electrónica para enlace al texto completo, se deberá verificar en la página web de Clase o Periódica el funcionamiento y pertinencia de cada enlace. Esta verificación se puede realizar desde la plantilla del registro trabajado, después de guardarse en el servidor, o directamente en el sitio web de Clase o Periódica.');?></p>
        </div>
      </div>
    </div><!--End Colorbox div-->
  </div><!--end content_txt-->
</div><!--end content-->