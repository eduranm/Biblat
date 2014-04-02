<div class="contenido">
	<div class="flagContainer">
		<p class="flag">
			<em>
				<?php _e('Criterios de selección');?>
			</em>
		</p>
	</div>
	<div class="textoJ">
		<?php _printf('Para la visualización de los contenidos de una revista en el portal %s, así como para la generación de sus indicadores bibliométricos, toda publicación debe estar indizada en CLASE o PERIÓDICA. Para la generación de indicadores bibliométricos sólo se consideran revistas de investigación y técnico-profesionales, no así las de difusión científica o cultural; además, es requisito contar con, al menos, cinco años de indización consecutivos.','<span class="biblat">Biblat</span>');?><br></br>
		<p class="textoTitulo centrado"><?php _printf('Criterios de selección de revistas para las bases de datos %s y %s','<a href="http://clase.unam.mx" target="_blank">CLASE</a>','<a href="http://periodica.unam.mx" target="_blank">PERIÓDICA</a>');?></p>
		<?php _printf('%s y %s indizan revistas académicas de investigación, técnico-profesionales y de difusión científica o cultural, editadas en países de América Latina y el Caribe. También se incluyen revistas editadas por organismos internacionales de alcance panamericano. Las revistas pueden ser especializadas o multidisciplinarias, en formato impreso o electrónico.','<a href="http://clase.unam.mx" target="_blank">CLASE</a>','<a href="http://periodica.unam.mx" target="_blank">PERIÓDICA</a>');?><br></br>
		<?php _printf('Las revistas especializadas en ciencias sociales y humanidades se indizan en %s, mientras que las de ciencia y tecnología se incluyen en %s. Las multidisciplinarias pueden incluirse en alguna de las dos bases de datos, conforme a la opinión del Comité de Selección. Todas las revistas son evaluadas por el Comité, de acuerdo con los siguientes criterios.','<a href="http://clase.unam.mx" target="_blank">CLASE</a>','<a href="http://periodica.unam.mx" target="_blank">PERIÓDICA</a>');?><br></br>
		<b><?php _e('Criterios de normalización editorial');?></b><br></br>
		<?php _e('Las revistas deberán observar normas técnicas, nacionales o internacionales, que apoyan la transferencia de información y facilitan su registro, ya que proporcionan información única, suficiente y confiable relativa al historial de cada revista. Dentro de este grupo se valora que las revistas proporcionen los datos del editor o responsable de la revista; los datos del organismo responsable de su edición; el registro ISSN; la mención de periodicidad; el membrete bibliográfico en la portada, en páginas de presentación y en los documentos mismos, entre otros criterios.');?><br></br>
		<b><?php _e('Criterios de gestión y visibilidad');?></b><br></br>
		<?php _e('Este grupo de criterios permite conocer cómo es administrada la revista, qué tan estable ha sido y cuánto se difunde. Se valora que la revista mencione su objetivo, cobertura temática y público al que va dirigida; que cumpla con su periodicidad; que cuente con un consejo o comité editorial y que sus integrantes provengan de instituciones diversas; que se haga mención del tipo de arbitraje aplicado a los documentos; que se proporcionen las fechas de recepción y aceptación de los documentos y que incluyan instrucciones a los autores, entre otros. En cuanto a su visibilidad, se toma en cuenta que la revista esté cubierta por otras bases de datos o servicios de información y que indique sus mecanismos de distribución, incluyendo versiones electrónicas disponibles en Internet u otros formatos.');?><br></br>
		<b><?php _e('Criterios de contenidos con fines de indización');?></b><br></br>
		<?php _e('Se trata de criterios que el analista de información utiliza para describir bibliográficamente los contenidos. Aquí se consideran criterios que tienen que ver con la inclusión de resúmenes, palabras clave o descriptores; referencias o citas bibliográficas, así como la adscripción de los autores, elementos que se requieren para efectos de indización en las bases de datos. Asimismo, se cuantifica la proporción de documentos indizables: artículos originales, artículos de revisión, ensayos, informes técnicos, comunicaciones cortas, reseñas de libro, revisiones bibliográficas, entrevistas y estadísticas, entre otros.');?><br></br>
		<?php _e('Dichos criterios están condensados en la plantilla de evaluación que se expone a continuación. Para ser aprobada, la revista candidata debe sumar al menos ');?><b><?php _e('25 puntos.');?></b><?php _printf(' El proceso de evaluación es realizado por el Comité de Selección de %s y %s.','<a href="http://clase.unam.mx" target="_blank">CLASE</a>','<a href="http://periodica.unam.mx" target="_blank">PERIÓDICA</a>');?><br></br><br></br>
		<p class="textoTitulo centrado"><b><?php _printf('Plantilla de evaluación del Comité de Selección de Revistas para %s y %s','<a href="http://clase.unam.mx" target="_blank">CLASE</a>','<a href="http://periodica.unam.mx" target="_blank">PERIÓDICA</a>');?></b></p>	
		<?php _e('Para ser aprobada la revista deberá obtener 25 puntos como mínimo.');?><br></br>

		<table class="resultados centrado" border=1 cellpadding='3' cellspacing='2' summary='<?php _e('Criterios mínimos / OBLIGATORIOS');?>'>
			<colgroup>
				<col id='noCol' />
				<col id='criterioCol' />
				<col id='puntosCol' />
			</colgroup>
			<thead>
				<tr>
					<th scope='col'><?php _e('No.');?></th>
					<th scope='col'><?php _e('Criterios mínimos / OBLIGATORIOS');?></th>
					<th scope='col'><?php _e('Puntos');?></th>
				</tr>
			</thead>
			<tbody>
				<tr class="registro">
					<td>1</td>
					<td><b><?php _e('Mención de un editor o responsable de la revista.');?></b><?php _e(' Se valora positivamente la mención de un editor, director o responsable de la revista.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>2</td>
					<td><b><?php _e('Datos del organismo responsable y lugar de edición.');?></b><?php _e(' Se valora positivamente si la revista proporciona información suficiente para la identificación y localización del organismo editor o institución responsable, así como los datos del lugar de edición. Los datos pueden ser: nombre completo de la institución editora, dirección postal, ciudad o lugar de edición, teléfonos, correo electrónico o sitio web.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>3</td>
					<td><b><?php _e('Existencia de tabla de contenidos o índice.');?></b><?php _e(' Se valora positivamente si la revista proporciona la tabla de contenido o sumario en la que consten, entre otros, los nombres de los autores, título del trabajo y páginas.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>4</td>
					<td><b><?php _e('Identificación de los autores personales o institucionales en los documentos.');?></b><?php _e(' Los trabajos deben estar firmados por los autores con nombre y apellidos o declaración de autor institucional.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>5</td>
					<td><b><?php _e('Referencias bibliográficas en los documentos.');?></b><?php _e(' Los documentos publicados deben proporcionar una lista de referencias bibliográficas, obras citadas o notas bibliográficas al pie de página. La presencia de estas referencias será valorada solamente en artículos, ensayos o reseñas y no en cartas al editor, editoriales, entrevistas, reportajes u otro tipo de documentos que no suelen citar referencias bibliográficas.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>6</td>
					<td><b><?php _e('Membrete bibliográfico en cubiertas o páginas de presentación.');?></b><?php _e(' Estas deberán incluir al menos el título completo de la revista, así como ISSN, volumen, número, fecha y membrete bibliográfico.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>7</td>
					<td><b><?php _e('60% de contenido indizable.');?></b><?php _e(' Al menos el 60% de los documentos publicados en un fascículo, deben ser: artículos originales, ensayos, reseñas de libro, revisiones bibliográficas, notas de más de una cuartilla, informes técnicos o cartas al editor.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>8</td>
					<td><b><?php _e('ISSN');?></b><?php _e(' Se considerará positivamente la existencia de código ISSN');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>9</td>
					<td><b><?php _e('Mención del objetivo de la revista.');?></b><?php _e(' En el fascículo se debe hacer mención de los objetivos que la publicación persigue. Puede valorarse también si hace explícita su especialización temática y/o la audiencia a la que va dirigida.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>10</td>
					<td><b><?php _e('Mención de periodicidad.');?></b><?php _e(' Para su valoración la revista debe declarar su periodicidad sin ambigüedad o bien el número de ejemplares que ofrece al año. Este criterio califica solamente la mención de periodicidad, no su cumplimiento.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>11</td>
					<td><b><?php _e('Periodicidad semestral o más frecuente.');?></b><?php _e(' Califica positivamente si la periodicidad de la revista es semestral o más frecuente, ya que se aprecia que cumpla con su misión de difundir sus contenidos en el menor tiempo posible.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>12</td>
					<td><b><?php _e('Cumplimiento de periodicidad.');?></b><?php _e(' Se entiende que una revista cumple su periodicidad si a lo largo del año publica el número de fascículos que se corresponden con la periodicidad expresada por la revista (por ejemplo, tres fascículos al año, en el caso de las revistas cuatrimestrales). Por lo tanto, para poder calificar este criterio es indispensable que la revista explicite el número de ejemplares que ofrece al año.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>13</td>
					<td><b><?php _e('Existencia de un consejo, comité o cuerpo editorial.');?></b><?php _e(' Deberá constar en la revista la existencia de un cuerpo editorial que apoye al editor en diversas responsabilidades inherentes a la gestión de la revista o bien a la evaluación de las contribuciones, y deberán proporcionarse los nombres de cada uno de los que forman parte de esas instancias.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>14</td>
					<td><b><?php _e('Servicios de indización que cubren la revista.');?></b><?php _e(' Califica positivamente si la revista está incluida en algún servicio de índices y resúmenes, directorios, catálogos, hemerotecas virtuales y listas del núcleo básico de revistas nacionales, entre otros servicios de información. Este campo califica positivamente solamente si el servicio de información es mencionado por la propia revista.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>15</td>
					<td><b><?php _e('Clasificación de los tipos de documentos publicados (Tabla de contenido)');?></b><?php _e(' La revista debe proporcionar una clasificación de los tipos de documentos que publica, ya sea en la tabla de contenidos, al inicio de cada sección o documento, o bien en las instrucciones a los autores.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>16</td>
					<td><b><?php _e('Instrucciones a los autores.');?></b><?php _e(' Califica positivamente si aparecen las instrucciones a los autores sobre el envío de originales.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>17</td>
					<td><b><?php _e('Membrete bibliográfico al inicio del documento.');?></b><?php _e(' Califica positivamente si el membrete bibliográfico aparece al inicio de cada artículo e identifica a la fuente. Para darlo por cumplido el membrete debe contener por lo menos: título completo o abreviado y la numeración de la revista (volumen, número, parte, mes o sus equivalentes) ');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>18</td>
					<td><b><?php _e('Membrete bibliográfico en cada página del documento.');?></b><?php _e(' Califica positivamente si el membrete que identifica la fuente aparece en páginas pares o impares del artículo, no necesariamente en ambas.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>19</td>
					<td><b><?php _e('Fechas de recepción y/o aceptación del documento.');?></b><?php _e(' Califica positivamente sólo si indica ambas fechas. Esta información puede ser localizada al inicio o al final de cada artículo y es sólo exigible para artículos originales.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>20</td>
					<td><b><?php _e('Resumen del documento.');?></b><?php _e(' Califica positivamente si se incluyen resúmenes en el idioma original del trabajo.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>21</td>
					<td><b><?php _e('Resumen del documento en dos idiomas.');?></b><?php _e(' Califica positivamente si se incluyen resúmenes en el idioma original del trabajo y en un segundo idioma.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>22</td>
					<td><b><?php _e('Afiliación de los autores.');?></b><?php _e(' Deberá proporcionarse el nombre de la institución de trabajo del autor o autores de cada artículo.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>23</td>
					<td><b><?php _e('Palabras clave.');?></b><?php _e(' Deben proporcionarse palabras clave, en cualquier idioma, que describan el contenido del documento. Al igual que con los resúmenes, las palabras clave se valoran solamente en artículos.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>24</td>
					<td><b><?php _e('Palabras clave en dos idiomas.');?></b><?php _e(' Las palabras clave deben proporcionarse en dos idiomas y al igual que en el criterio referido al idioma de los resúmenes, en este caso tampoco se considera obligatorio que estén presentes en otro tipo de documentos diferentes a los artículos.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>25</td>
					<td><b><?php _e('Mención del sistema de arbitraje por pares.');?></b><?php _e(' En la revista deberá constar que el procedimiento empleado para la selección de los artículos a publicar es el arbitraje por pares.');?></td>
					<td><?php _e('(1 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>26</td>
					<td><b><?php _e('Sistema de arbitraje doble ciego.');?></b><?php _e(' En la revista deberá constar que el procedimiento empleado para la selección de los artículos a publicar es el arbitraje por pares especificando que sea mediante el sistema “doble ciego”.');?></td>
					<td><?php _e('(3 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>27</td>
					<td><b><?php _e('Mención de originalidad de los documentos.');?></b><?php _e(' Califica positivamente si en la presentación de la revista o en las instrucciones a los autores se menciona explícitamente esta exigencia para los trabajos sometidos a publicación.');?></td>
					<td><?php _e('(2 pt)');?></td>
				</tr>
				<tr class="registro">
					<td>28</td>
					<td><b><?php _e('Apertura institucional del consejo, comité o cuerpo editorial.');?></b><?php _e(' Para calificar positivamente, los cuerpos editoriales deberán contar con evaluadores externos a la entidad editora, por lo que deberá constar su afiliación institucional. Al menos el 50% de los miembros del consejo editorial deberán pertenecer a instituciones diferentes a la editora, de lo contrario no calificará positivamente.');?></td>
					<td><?php _e('(2 pt)');?></td>
				</tr>
			</tbody>
		</table><br></br>
		<?php _e('Para ');?><b><?php _printf('solicitar la inclusión de su revista en %s y %s','<a href="http://clase.unam.mx" target="_blank">CLASE</a>','<a href="http://periodica.unam.mx" target="_blank">PERIÓDICA</a></b>');?></b><?php _printf(', se requiere enviar los tres últimos fascículos publicados por la revista, en archivos PDF sin candados de impresión, al buzón %s (con copia a %s), o bien, la dirección electrónica (URL) de la revista, acompañado de un mensaje dirigido a Antonio Sánchez Pereyra, Presidente del Comité de Selección de %s y %s, en el que se explicite la intención de que la revista sea evaluada para su indización en dichas bases de datos','<a href="mailto:biblat@dgb.unam.mx">biblat@dgb.unam.mx</a>','<a href="mailto:claseyperiodicaunam@gmail.com">claseyperiodicaunam@gmail.com</a>','<a href="http://clase.unam.mx" target="_blank">CLASE</a>','<a href="http://periodica.unam.mx" target="_blank">PERIÓDICA</a></b>');?><br></br>
		<?php _e('Por otra parte, solicitamos, en caso de así convenir al editor de la revista, proporcionarnos la autorización para albergar los archivos PDF de la revista en la colección ');?><b><?php _e('Hemeroteca Virtual Latinoamericana');?></b><?php _printf(' y ofrecer acceso al texto completo de los artículos a los usuarios de %s y %s, sin mediar por ello costo alguno para ustedes como editores ni para el usuario. Por nuestra parte y habida cuenta de las cuatro décadas de trabajo que respaldan nuestro compromiso y responsabilidad con la difusión del conocimiento científico y humanístico, asumimos lo siguiente:','<a href="http://clase.unam.mx" target="_blank">CLASE</a>','<a href="http://periodica.unam.mx" target="_blank">PERIÓDICA</a>');?><br></br>
		<ol type=a>
			<li><?php _e('Ser un proyecto estrictamente académico impulsado por la Dirección General de Bibliotecas de la UNAM, y en consecuencia ser una organización de carácter científico.');?></li>
			<li><?php _e('Ser una hemeroteca científica en línea, de libre acceso a los contenidos completos de los artículos de su acervo.');?></li>
			<li><?php _e('Difundir de manera transparente y gratuita los trabajos y materiales que forman parte de la publicación para su consulta por parte de la comunidad científica a través de las siguientes páginas web: ');?><a href="http://clase.unam.mx" target="_blank">CLASE</a>, <a href="http://periodica.unam.mx" target="_blank">PERIÓDICA</a> y <a href="<?=base_url();?>">Biblat</a></li>
			<li><?php _e('No adjudicarse derechos de comercialización de los contenidos y materiales de la publicación, ni de sus logos, marcas y nombres registrados, por lo que tampoco está obligado a pagar regalías por la publicación de los mismos.');?></li>
			<li><?php _e('Respetar los derechos morales del autor, y en consecuencia mantener la integridad de la información salvaguardándola de mutilaciones, o modificaciones diferentes a las necesarias para la publicación electrónica de la obra, que generen inexactitudes o que vulneren la imagen de la revista, o del autor.');?></li>
			<li><?php _printf('Respetar la decisión de la revista de brindar sus contenidos a cualquier otra hemeroteca, sitio web, sistema de indización que considere conveniente, con lo que se entiende que %s y %s no reclama ningún tipo de exclusividad.','<a href="http://clase.unam.mx" target="_blank">CLASE</a>','<a href="http://periodica.unam.mx" target="_blank">PERIÓDICA</a>');?></li>
		</ol><br></br>
		<?php _e('En cuanto a la autorización solicitada al editor para el depósito de los archivos electrónicos en la colección Hemeroteca Virtual Latinoamericana así como para el acceso libre al texto completo de los artículos, solicitamos el envío del siguiente formato:');?><br></br>
	</div>
</div>