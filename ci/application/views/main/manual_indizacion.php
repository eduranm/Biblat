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
        <td><?php _e('Nombres geográficos');?></td>
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
        <td><?php _e('Nombres geográficos');?></td>
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
        <td><?php _e('Tipo de documento');?></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man35"><?php _e('Tipo de documento: Enfoque');?></a></td>
        <td>590b</td>
        <td>X</td>
        <td></td>
        <td><?php _e('Enfoque');?></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man36"><?php _e('Disciplinas');?></a></td>
        <td>650a</td>
        <td>X</td>
        <td>X</td>
        <td><?php _e('Disciplinas');?></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man37"><?php _e('Palabra clave');?></a></td>
        <td>653a</td>
        <td>X</td>
        <td>X</td>
        <td><?php _e('Subdisciplinas / Nombres geográficos');?></td>
      </tr>
      <tr>
        <td><a class="manual" href="#man38"><?php _e('Keyword');?></a></td>
        <td>654a</td>
        <td>X</td>
        <td>X</td>
        <td><?php _e('Subdisciplinas / Nombres geográficos');?></td>
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
        <td><?php _e('Tesauros y Glosarios disponibles en línea');?></td>
      </tr>
    </table>

    <div style="display:none">

      <div id="man1" align="justify">
        <p align="right"><strong><?php _e('País de la revista');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: País de la revista');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 008e');?></p>
        <p align="right"><?php _e('Tipo de campo: obligatorio, alfabético');?></p>
        <p><?php _e('El país en este campo corresponde al lugar en donde se edita la revista. También es anotado por la persona responsable de la circulación del material y en el caso de títulos editados por organismos internacionales, con sede en países de fuera de América Latina y el Caribe, se asienta: Internacional. En el sistema en línea, el analista seleccionará de la tabla correspondiente, el nombre completo del país indicado en la hoja de Reporte de precodificación.');?></p>
      </div>

      <div id="man2" align="justify">
        <p align="right"><strong><?php _e('ISSN');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: ISSN');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 022a');?></p>
        <p align="right"><?php _e('Tipo de campo: opcional, alfanumérico');?></p>
        <p><?php _e('El ISSN es el número internacional normalizado de publicaciones seriadas. En el sistema en línea, en el campo 022a se debe ingresar la misma clave de la revista que se utilizó en el campo anterior (222a), para que el número de ISSN recuperado corresponda al título de la revista. Al igual que en el campo anterior, el sistema extraerá de la lista de encabezamientos, el ISSN de la revista de acuerdo con dicha clave. Si la revista no cuenta con ISSN el analista deberá borrar la clave y dejar el campo en blanco. Se recomienda especial cuidado en el ingreso de la clave, y su verificación con el número recuperado.');?></p>
      </div>

      <div id="man3" align="justify">
        <p align="right"><strong><?php _e('DOI del documento');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: DOI');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 024a');?></p>
        <p align="right"><?php _e('Tipo de campo: opcional, alfanumérico');?></p>
        <p><?php _e('El DOI es el código identificador de materiales digitales, con fines de normalización, el cual permite su localización en Internet aun cuando la dirección URL hubiera cambiado.');?></p>
        <p><?php _e('A partir de enero de 2012, será incluido en los registros de Clase y Periódica, en el campo 024a, siempre que el documento analizado lo proporcione. Este código DOI será tomado de las revistas en línea, como se indica en los ejemplos siguientes, copiando únicamente la parte resaltada que aparece en negrillas, cerciorándose de que se haya “copiado y pegado” adecuadamente.');?></p>
        <p align="center">http://dx.doi.org/10.1590/S1414-753X2009000100002</p>
        <p align="center">doi: 10.4067/S0718-22442009000200001</p>
        <p><?php _e('En el documento, la información regularmente aparece al inicio, en la parte superior del texto y en algunos casos se repite junto al resumen o al final. También puede ser que se muestre sólo en la versión HTML y no en PDF.');?></p>
        <p><?php _e('Dado que se trata de un código único de identificación para el documento que lo ostenta, se recomienda especial cuidado al asentarlo.');?></p>
      </div>
      
      <div id="man4" align="justify">
        <p align="right"><strong><?php _e('Número de sistema');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: No. de Sistema');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 035a');?></p>
        <p align="right"><?php _e('Tipo de campo: obligatorio, numérico');?></p>
        <p><?php _e('Este número es único y generado automáticamente por el sistema al momento de guardar el registro en el servidor.');?></p>
      </div>
      
      <div id="man5" align="justify">
        <p align="right"><strong><?php _e('Fecha de ingreso');?></strong></p>
        <p align="right"><?php _e('(Este campo no se despliega en la página web)');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 036a');?></p>
        <p align="right"><?php _e('Tipo de campo: obligatorio, numérico');?></p>
        <p><?php _e('La fecha en que se ingresa el registro a la base de datos se indica con cuatro dígitos (aa/mm), los dos primeros para el año y los dos siguientes para el mes.');?></p>
        <p align="center">036a 1008 (<?php _e('agosto de 2010)');?></p>
      </div>
      
      <div id="man6" align="justify">
        <p align="right"><strong><?php _e('Enlace');?></strong></p>
        <p align="right"><?php _e('(Este campo no se despliega en la página web)');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 039a');?></p>
        <p align="right"><?php _e('Tipo de campo: opcional, alfabético');?></p>
        <p><?php _e('El campo Enlace, etiqueta 039a, debe contener la abreviatura ENL. (en letras mayúsculas y con punto final) cuando incluimos una dirección electrónica en el campo 856u. Esta abreviatura indicará al sistema que el registro contiene una dirección URL para enlazar al texto completo del documento indizado y permitirá utilizar, en la página web de Clase o Periódica, la opción para realizar búsquedas sólo en artículos con acceso al texto completo.');?></p>
        <p><?php _e('Esta abreviatura aparece, desde el principio, en la plantilla de registro. Si el documento no tiene una dirección electrónica para acceder al texto completo y, por lo tanto, no se asienta en el campo correspondiente (856u), el campo de Enlace también deberá quedar en blanco, para lo cual será necesario borrar dicha abreviatura.');?></p>
      </div>

      <div id="man7" align="justify">
        <p align="right"><strong><?php _e('Idioma');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: idioma');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 041a');?></p>
        <p align="right"><?php _e('Tipo de campo: obligatorio, alfabético');?></p>
        <p><?php _e('El idioma en que está escrito el documento será codificado de acuerdo con la lista de idiomas del Anexo 1 (página 69), consultable también en la tabla disponible en línea. En algunas revistas los documentos aparecen en dos idiomas, por lo que se podrán codificar ambos, separados por una coma, en el siguiente orden de preferencia:');?></p>
        <ol align="center" type="1">
          <li><?php _e('Español');?></li>
          <li><?php _e('Portugués');?></li>
          <li><?php _e('Inglés');?></li>
          <li><?php _e('Francés');?></li>
          <li><?php _e('Otro');?></li>
        </ol>
      </div>

      <div id="man8" align="justify">
        <p align="right"><strong><?php _e('Autor personal: Nombre');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: autor');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 100a, z, 6');?></p>
        <p align="right"><?php _e('Subcampo: 100a');?></p>
        <p align="right"><?php _e('Tipo de campo: opcional, repetible, alfanumérico');?></p>
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

      <div id="man9" align="justify">
        <p align="right"><strong><?php _e('Autor personal: Referencia');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: autor');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 100a, z, 6');?></p>
        <p align="right"><?php _e('Subcampo: 100z');?></p>
        <p align="right"><?php _e('Tipo de subcampo: opcional, numérico, repetible');?></p>
        <p><?php _e('La referencia es el número con el cual se relaciona al autor con su institución de adscripción. Este número se indicará en el subcampo 100z tal como se indica en el ejemplo.');?></p>
        <div align="center"><img src="<?=base_url('img/autor_ref.jpg');?>"/></div>
        <p><?php _e('En caso de que el documento indizado no indique a qué institución está adscrito un autor, ni su dirección de correo electrónico, los subcampos 100z y 1006 deberán quedar en blanco, por lo cual habrá que eliminar los caracteres precargados () y @.');?></p>
      </div>

      <div id="man10" align="justify">
        <p align="right"><strong><?php _e('Autor personal: Correo electrónico');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: autor');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 100a, z, 6');?></p>
        <p align="right"><?php _e('Subcampo: 1006');?></p>
        <p align="right"><?php _e('Tipo de subcampo: opcional, alfanumérico, repetible');?></p>
        <p><?php _e('A partir de esta versión del manual se incluirá solamente la dirección de correo electrónico del primer autor o la del autor que la revista indique (5). Este dato, se asentará en el subcampo 1006 del autor correspondiente, aun cuando no tenga institución de adscripción. En caso de que aparezcan varias direcciones para un mismo autor, se incluirá sólo una de ellas, de preferencia la del servidor institucional.');?></p>
        <div align="center"><img src="<?=base_url('img/autorcorreo.jpg');?>"/></div>
      </div>
      
      <div id="man11" align="justify">
        <p align="right"><strong><?php _e('Autor corporativo: Institución');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: autor corporativo');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 110a, b, c');?></p>
        <p align="right"><?php _e('Subcampo: 110a');?></p>
        <p align="right"><?php _e('Tipo de campo: opcional, repetible, alfanumérico');?></p>
        <p><strong><?php _e('Regla General');?></strong></p>
        <p><?php _e('Algunos documentos son firmados por instituciones y no por personas. En estos casos, los autores institucionales o corporativos se codificarán en este campo como sigue: el nombre en el subcampo a, si el documento proporciona una dependencia se incluirá en el subcampo b, y el país en el subcampo c.');?></p>
        <p><?php _e('Los datos mínimos que se requieren para asentar un autor corporativo son: nombre de la institución y país. Siempre que exista un Autor corporativo, el campo Autor personal  (100a-6) quedará vacío.');?></p>
        <div align="center"><img src="<?=base_url('img/autorcorporativo.jpg');?>"/></div>
        <p><?php _e('Los nombres de las instituciones se codificarán siguiendo las reglas pertinentes del campo INSTITUCIÓN DE ADSCRIPCIÓN (página 23).');?></p>
        <p><strong><?php _e('Documentos Anónimos');?></strong></p>
        <p><?php _e('No deberán incluirse documentos anónimos. Todos los documentos a ingresar deben contar con autores personales o institucionales.');?></p>
        <p><?php _e('Hay documentos que no están firmados, pero es posible que hayan sido generados por la institución que edita la revista o por la propia revista; en tales casos el documento se puede atribuir a alguno de ellos como autor corporativo.');?></p>
      </div>
      
      <div id="man12" align="justify">
        <p align="right"><strong><?php _e('Autor corporativo: Dependencia');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: autor corporativo');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 110a, b, c');?></p>
        <p align="right"><?php _e('Subcampo: 110b');?></p>
        <p align="right"><?php _e('Tipo de campo: opcional, repetible, alfabético');?></p>
        <p><strong><?php _e('Regla General');?></strong></p>
        <p><?php _e('Algunos documentos son firmados por instituciones y no por personas. En estos casos, los autores institucionales o corporativos se codificarán en este campo como sigue: el nombre en el subcampo a, si el documento proporciona una dependencia se incluirá en el subcampo b, y el país en el subcampo c.');?></p>
        <p><?php _e('Los datos mínimos que se requieren para asentar un autor corporativo son: nombre de la institución y país. Siempre que exista un Autor corporativo, el campo Autor personal  (100a-6) quedará vacío.');?></p>
        <div align="center"><img src="<?=base_url('img/autorcorporativo.jpg');?>"/></div>
        <p><?php _e('Los nombres de las instituciones se codificarán siguiendo las reglas pertinentes del campo INSTITUCIÓN DE ADSCRIPCIÓN (página 23).');?></p>
        <p><strong><?php _e('Documentos Anónimos');?></strong></p>
        <p><?php _e('No deberán incluirse documentos anónimos. Todos los documentos a ingresar deben contar con autores personales o institucionales.');?></p>
        <p><?php _e('Hay documentos que no están firmados, pero es posible que hayan sido generados por la institución que edita la revista o por la propia revista; en tales casos el documento se puede atribuir a alguno de ellos como autor corporativo.');?></p>
      </div>

      <div id="man13" align="justify">
        <p align="right"><strong><?php _e('Autor corporativo: País');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: autor corporativo');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 110a, b, c');?></p>
        <p align="right"><?php _e('Subcampo: 110c');?></p>
        <p align="right"><?php _e('Tipo de campo: opcional, alfabético');?></p>
        <p><strong><?php _e('Regla General');?></strong></p>
        <p><?php _e('Algunos documentos son firmados por instituciones y no por personas. En estos casos, los autores institucionales o corporativos se codificarán en este campo como sigue: el nombre en el subcampo a, si el documento proporciona una dependencia se incluirá en el subcampo b, y el país en el subcampo c.');?></p>
        <p><?php _e('Los datos mínimos que se requieren para asentar un autor corporativo son: nombre de la institución y país. Siempre que exista un Autor corporativo, el campo Autor personal  (100a-6) quedará vacío.');?></p>
        <div align="center"><img src="<?=base_url('img/autorcorporativo.jpg');?>"/></div>
        <p><?php _e('Los nombres de las instituciones se codificarán siguiendo las reglas pertinentes del campo INSTITUCIÓN DE ADSCRIPCIÓN (página 23).');?></p>
        <p><strong><?php _e('Documentos Anónimos');?></strong></p>
        <p><?php _e('No deberán incluirse documentos anónimos. Todos los documentos a ingresar deben contar con autores personales o institucionales.');?></p>
        <p><?php _e('Hay documentos que no están firmados, pero es posible que hayan sido generados por la institución que edita la revista o por la propia revista; en tales casos el documento se puede atribuir a alguno de ellos como autor corporativo.');?></p>
      </div>

      <div id="man14" align="justify">
        <p align="right"><strong><?php _e('Adscripción del autor: Referencia');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: institución');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 120z, u, v, w, x');?></p>
        <p align="right"><?php _e('Subcampo: 120z');?></p>
        <p align="right"><?php _e('Tipo de subcampo: opcional, repetible, numérico');?></p>
        <p><?php _e('En este campo, la referencia es el número con el cual se relaciona la institución con su autor. Este número se indicará en el subcampo 120z.');?></p>
        <p><?php _e('La enumeración del subcampo 120z (adscripción del autor) deberá corresponder con el subcampo 100z (del campo de autor) para indicar la pertenencia a cada institución.');?></p>
        <div align="center"><img src="<?=base_url('img/institucion.jpg');?>"/></div>
        <p><?php _e('En caso de que un autor no cuente con institución de adscripción, este subcampo quedará vacío, por lo que el analista deberá borrar del registro los signos precargados ( ).');?></p>
      </div>
      
      <div id="man15" align="justify">
        <p align="right"><strong><?php _e('Adscripción del autor: Institución');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: institución');?></p>
        <p align="right"><?php _e('Etiquetas del campo: 120z,u,v,w,x');?></p>
        <p align="right"><?php _e('Subcampo: 120u');?></p>
        <p align="right"><?php _e('Tipo de campo: opcional, repetible, alfanumérico');?></p>
        <p align="right"><i><?php _e('Véanse páginas 23-28 del Manual');?></i></p>
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

      <div id="man16" align="justify">
        <p align="right"><strong><?php _e('Adscripción del autor: Dependencia');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: institución');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 120z, u, v, w, x');?></p>
        <p align="right"><?php _e('Subcampo: 120v');?></p>
        <p align="right"><?php _e('Tipo de subcampo: opcional, alfabético');?></p>
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
  
      <div id="man17" align="justify">
        <p align="right"><strong><?php _e('Adscripción del autor: Ciudad-estado');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: institución');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 120z, u, v, w, x');?></p>
        <p align="right"><?php _e('Subcampo: 120w');?></p>
        <p align="right"><?php _e('Tipo de campo: obligatorio* , alfabético');?></p>
        <p><?php _e('Los nombres de las ciudades y divisiones político-administrativas deberán escribirse en español.');?></p>
        <p><?php _e('Podrá omitirse la división político-administrativa cuando ésta no se encuentre en la lista de encabezamientos de ciudad-estado consultable en línea, o no se logre obtener el dato en otras fuentes de información confiables. Deberá omitirse cuando la ciudad y la división política tengan el mismo nombre.');?></p>
        <p><?php _e('Cuando existan dudas sobre la traducción al español de un nombre, deberá consultar:');?></p>
        <p><?php _printf('Gómez da Silva, Guido. %s, México: Academia Mexicana y Fondo de Cultura Económica, 1997.','<i>“Diccionario Geográfico Universal”</i>');?></p>
        <p><?php _e('Si la duda persiste, los nombres podrán ser escritos tal como aparezcan en el documento original, pero el analista deberá anotar dicho nombre en una lista y entregarla a la Jefatura del Departamento para fines de normalización.');?></p>
        <p>* <?php _e('Es obligatorio cuando se asiente una institución.');?></p>
      </div>

      <div id="man18" align="justify">
        <p align="right"><strong><?php _e('Adscripción del autor: País');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: institución');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 120z, u, v, w, x');?></p>
        <p align="right"><?php _e('Subcampo: 120x');?></p>
        <p align="right"><?php _e('Tipo de campo: obligatorio* , alfabético');?></p>
        <p><?php _e('El nombre del país se asentará en idioma español, conservando las preposiciones, conjunciones, artículos y demás signos ortográficos que formen parte de él.');?></p>
        <p><?php _e('Los nombres de países deben ser consultados en el anexo 6 de este Manual (página  85), el cual contiene una lista normalizada de nombres geográficos para su uso en las bases de datos Clase y Periódica.');?></p>
        <p>* <?php _e('Es obligatorio cuando se asiente una institución.');?></p>
      </div>

      <div id="man19" align="justify">
        <p align="right"><strong><?php _e('Título de la revista');?></strong></p>
        <p align="right"><?php _e('Nombre del campo en la página web: revista');?></p>
        <p align="right"><?php _e('Etiqueta del campo: 222a');?></p>
        <p align="right"><?php _e('Los títulos son asentados de acuerdo con las normas establecidas por el International Standard Serial Number (ISSN). Si una revista no cuenta con dicho número, entonces se optará por asentarlo tal como aparezca en SERIUNAM considerando que este catálogo se basa en varias fuentes autorizadas como LC (Library of Congress) y OCLC (Online Computer Library Center). Cuando una revista no aparezca en SERIUNAM, entonces el título deberá ser tomado de la cubierta y/o portada de la revista.');?></p>
        <p><?php _e('El título de la revista que se va a indizar, es anotado en la hoja de Reporte de precodificación por la persona responsable de la circulación del material a los analistas y se acompaña de una clave interna numérica, que lo relaciona con su ISSN.');?></p>
        <p><?php _e('En el sistema en línea, en el campo 222 el analista ingresará la clave numérica, para con ella recuperar el título completo de la revista, como se indica en la parte correspondiente al ingreso de datos en el sistema Aleph (página 49).');?></p>
        <p><?php _e('El sistema extraerá de la lista de encabezamientos, el título de la revista normalizado, de acuerdo con dicha clave.');?></p>
        <p><?php _e('Se recomienda especial cuidado en el ingreso de la clave y su verificación con el título recuperado.');?></p>
        <p align="center"><?php _e('222a 23089');?></p>
      </div>
    </div><!--End Colorbox div-->
  </div><!--end content_txt-->
</div><!--end content-->