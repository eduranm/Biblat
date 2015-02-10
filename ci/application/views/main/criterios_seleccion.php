		<p>{$biblat=_('Bibliografía Latinoamericana') _sprintf('Para la visualización de los contenidos de una revista en el portal %s, así como para la generación de sus indicadores bibliométricos, toda publicación debe estar indizada en CLASE o PERIÓDICA. Para la generación de indicadores bibliométricos sólo se consideran revistas de investigación y técnico-profesionales, no así las de difusión científica o cultural; además, es requisito contar con, al menos, cinco años de indización consecutivos.','<span class="biblat"><acronym title="$biblat">Biblat</acronym></span>')}</p>

		<p>{$clase=_('Citas Latinoamericanas en Ciencias Sociales y Humanidades') $periodica=_('Índice de Revistas Latinoamericanas en Ciencias') _sprintf('%s y %s indizan revistas académicas de investigación, técnico-profesionales y de difusión científica o cultural, editadas en países de América Latina y el Caribe. También se incluyen revistas editadas por organismos internacionales de alcance panamericano. Las revistas pueden ser especializadas o multidisciplinarias, en formato impreso o electrónico.','<a href="http://clase.unam.mx" target="_blank"><acronym title="$clase">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="$periodica">PERIÓDICA</acronym></a>')}</p>

		<p>{_sprintf('Las revistas especializadas en ciencias sociales y humanidades se indizan en %s, mientras que las de ciencia y tecnología se incluyen en %s. Las multidisciplinarias pueden incluirse en alguna de las dos bases de datos, conforme a la opinión del Comité de Selección. Todas las revistas son evaluadas por el Comité, de acuerdo con los siguientes criterios.','<a href="http://clase.unam.mx" target="_blank"><acronym title="$clase">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="$periodica">PERIÓDICA</acronym></a>')}</p></br>

		<p><b>{_('Criterios de normalización editorial')}</b></p>

		<p>{_('Las revistas deberán observar normas técnicas, nacionales o internacionales, que apoyan la transferencia de información y facilitan su registro, ya que proporcionan información única, suficiente y confiable relativa al historial de cada revista. Dentro de este grupo se valora que las revistas proporcionen los datos del editor o responsable de la revista; los datos del organismo responsable de su edición; el registro ISSN; la mención de periodicidad; el membrete bibliográfico en la portada, en páginas de presentación y en los documentos mismos, entre otros criterios.')}</p></br>

		<p><b>{_('Criterios de gestión y visibilidad')}</b></p>

		<p>{_('Este grupo de criterios permite conocer cómo es administrada la revista, qué tan estable ha sido y cuánto se difunde. Se valora que la revista mencione su objetivo, cobertura temática y público al que va dirigida; que cumpla con su periodicidad; que cuente con un consejo o comité editorial y que sus integrantes provengan de instituciones diversas; que se haga mención del tipo de arbitraje aplicado a los documentos; que se proporcionen las fechas de recepción y aceptación de los documentos y que incluyan instrucciones a los autores, entre otros. En cuanto a su visibilidad, se toma en cuenta que la revista esté cubierta por otras bases de datos o servicios de información y que indique sus mecanismos de distribución, incluyendo versiones electrónicas disponibles en Internet u otros formatos.')}</p></br>

		<p><b>{_('Criterios de contenidos con fines de indización')}</b></p>

		<p>{_('Se trata de criterios que el analista de información utiliza para describir bibliográficamente los contenidos. Aquí se consideran criterios que tienen que ver con la inclusión de resúmenes, palabras clave o descriptores; referencias o citas bibliográficas, así como la adscripción de los autores, elementos que se requieren para efectos de indización en las bases de datos. Asimismo, se cuantifica la proporción de documentos indizables: artículos originales, artículos de revisión, ensayos, informes técnicos, comunicaciones cortas, reseñas de libro, revisiones bibliográficas, entrevistas y estadísticas, entre otros.')}</p>

		<p>{_('Dichos criterios están condensados en la plantilla de evaluación que se expone a continuación. Para ser aprobada, la revista candidata debe sumar al menos')}<b> {_('25 puntos.')}</b> {_sprintf('El proceso de evaluación es realizado por el Comité de Selección de %s y %s.','<a href="http://clase.unam.mx" target="_blank"><acronym title="$clase">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="$periodica">PERIÓDICA</acronym></a>')}</p></br>

		<div class="page_title">
            <hr/>
            <h4>{_('Plantilla de evaluación del Comité de Selección de Revistas para CLASE y PERIÓDICA')}</h4>
            <hr/>
        </div>
		
		{_('Para ser aprobada la revista deberá obtener 25 puntos como mínimo.')}

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr class="encabezado">
					<td>{_('No.')}</td>
					<td>{_('Criterios mínimos / OBLIGATORIOS')}</td>
					<td>{_('Puntos')}</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td><b>{_('Mención de un editor o responsable de la revista.')}</b> {_('Se valora positivamente la mención de un editor, director o responsable de la revista.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>2</td>
					<td><b>{_('Datos del organismo responsable y lugar de edición.')}</b> {_('Se valora positivamente si la revista proporciona información suficiente para la identificación y localización del organismo editor o institución responsable, así como los datos del lugar de edición. Los datos pueden ser: nombre completo de la institución editora, dirección postal, ciudad o lugar de edición, teléfonos, correo electrónico o sitio web.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>3</td>
					<td><b>{_('Existencia de tabla de contenidos o índice.')}</b> {_('Se valora positivamente si la revista proporciona la tabla de contenido o sumario en la que consten, entre otros, los nombres de los autores, título del trabajo y páginas.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>4</td>
					<td><b>{_('Identificación de los autores personales o institucionales en los documentos.')}</b> {_('Los trabajos deben estar firmados por los autores con nombre y apellidos o declaración de autor institucional.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>5</td>
					<td><b>{_('Referencias bibliográficas en los documentos.')}</b> {_('Los documentos publicados deben proporcionar una lista de referencias bibliográficas, obras citadas o notas bibliográficas al pie de página. La presencia de estas referencias será valorada solamente en artículos, ensayos o reseñas y no en cartas al editor, editoriales, entrevistas, reportajes u otro tipo de documentos que no suelen citar referencias bibliográficas.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>6</td>
					<td><b>{_('Membrete bibliográfico en cubiertas o páginas de presentación.')}</b> {_('Estas deberán incluir al menos el título completo de la revista, así como ISSN, volumen, número, fecha y membrete bibliográfico.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>7</td>
					<td><b>{_('60% de contenido indizable.')}</b> {_('Al menos el 60% de los documentos publicados en un fascículo, deben ser: artículos originales, ensayos, reseñas de libro, revisiones bibliográficas, notas de más de una cuartilla, informes técnicos o cartas al editor.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>8</td>
					<td><b>{_('ISSN')}</b> {_('Se considerará positivamente la existencia de código ISSN')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>9</td>
					<td><b>{_('Mención del objetivo de la revista.')}</b> {_('En el fascículo se debe hacer mención de los objetivos que la publicación persigue. Puede valorarse también si hace explícita su especialización temática y/o la audiencia a la que va dirigida.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>10</td>
					<td><b>{_('Mención de periodicidad.')}</b> {_('Para su valoración la revista debe declarar su periodicidad sin ambigüedad o bien el número de ejemplares que ofrece al año. Este criterio califica solamente la mención de periodicidad, no su cumplimiento.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>11</td>
					<td><b>{_('Periodicidad semestral o más frecuente.')}</b> {_('Califica positivamente si la periodicidad de la revista es semestral o más frecuente, ya que se aprecia que cumpla con su misión de difundir sus contenidos en el menor tiempo posible.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>12</td>
					<td><b>{_('Cumplimiento de periodicidad.')}</b> {_('Se entiende que una revista cumple su periodicidad si a lo largo del año publica el número de fascículos que se corresponden con la periodicidad expresada por la revista (por ejemplo, tres fascículos al año, en el caso de las revistas cuatrimestrales). Por lo tanto, para poder calificar este criterio es indispensable que la revista explicite el número de ejemplares que ofrece al año.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>13</td>
					<td><b>{_('Existencia de un consejo, comité o cuerpo editorial.')}</b> {_('Deberá constar en la revista la existencia de un cuerpo editorial que apoye al editor en diversas responsabilidades inherentes a la gestión de la revista o bien a la evaluación de las contribuciones, y deberán proporcionarse los nombres de cada uno de los que forman parte de esas instancias.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>14</td>
					<td><b>{_('Servicios de indización que cubren la revista.')}</b> {_('Califica positivamente si la revista está incluida en algún servicio de índices y resúmenes, directorios, catálogos, hemerotecas virtuales y listas del núcleo básico de revistas nacionales, entre otros servicios de información. Este campo califica positivamente solamente si el servicio de información es mencionado por la propia revista.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>15</td>
					<td><b>{_('Clasificación de los tipos de documentos publicados (Tabla de contenido)')}</b> {_('La revista debe proporcionar una clasificación de los tipos de documentos que publica, ya sea en la tabla de contenidos, al inicio de cada sección o documento, o bien en las instrucciones a los autores.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>16</td>
					<td><b>{_('Instrucciones a los autores.')}</b> {_('Califica positivamente si aparecen las instrucciones a los autores sobre el envío de originales.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>17</td>
					<td><b>{_('Membrete bibliográfico al inicio del documento.')}</b> {_('Califica positivamente si el membrete bibliográfico aparece al inicio de cada artículo e identifica a la fuente. Para darlo por cumplido el membrete debe contener por lo menos: título completo o abreviado y la numeración de la revista (volumen, número, parte, mes o sus equivalentes)')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>18</td>
					<td><b>{_('Membrete bibliográfico en cada página del documento.')}</b> {_('Califica positivamente si el membrete que identifica la fuente aparece en páginas pares o impares del artículo, no necesariamente en ambas.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>19</td>
					<td><b>{_('Fechas de recepción y/o aceptación del documento.')}</b> {_('Califica positivamente sólo si indica ambas fechas. Esta información puede ser localizada al inicio o al final de cada artículo y es sólo exigible para artículos originales.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>20</td>
					<td><b>{_('Resumen del documento.')}</b> {_('Califica positivamente si se incluyen resúmenes en el idioma original del trabajo.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>21</td>
					<td><b>{_('Resumen del documento en dos idiomas.')}</b> {_('Califica positivamente si se incluyen resúmenes en el idioma original del trabajo y en un segundo idioma.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>22</td>
					<td><b>{_('Afiliación de los autores.')}</b> {_('Deberá proporcionarse el nombre de la institución de trabajo del autor o autores de cada artículo.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>23</td>
					<td><b>{_('Palabras clave.')}</b> {_('Deben proporcionarse palabras clave, en cualquier idioma, que describan el contenido del documento. Al igual que con los resúmenes, las palabras clave se valoran solamente en artículos.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>24</td>
					<td><b>{_('Palabras clave en dos idiomas.')}</b> {_('Las palabras clave deben proporcionarse en dos idiomas y al igual que en el criterio referido al idioma de los resúmenes, en este caso tampoco se considera obligatorio que estén presentes en otro tipo de documentos diferentes a los artículos.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>25</td>
					<td><b>{_('Mención del sistema de arbitraje por pares.')}</b> {_('En la revista deberá constar que el procedimiento empleado para la selección de los artículos a publicar es el arbitraje por pares.')}</td>
					<td>(1 pt)</td>
				</tr>
				<tr>
					<td>26</td>
					<td><b>{_('Sistema de arbitraje doble ciego.')}</b> {_('En la revista deberá constar que el procedimiento empleado para la selección de los artículos a publicar es el arbitraje por pares especificando que sea mediante el sistema “doble ciego”.')}</td>
					<td>(3 pt)</td>
				</tr>
				<tr>
					<td>27</td>
					<td><b>{_('Mención de originalidad de los documentos.')}</b> {_('Califica positivamente si en la presentación de la revista o en las instrucciones a los autores se menciona explícitamente esta exigencia para los trabajos sometidos a publicación.')}</td>
					<td>(2 pt)</td>
				</tr>
				<tr>
					<td>28</td>
					<td><b>{_('Apertura institucional del consejo, comité o cuerpo editorial.')}</b> {_('Para calificar positivamente, los cuerpos editoriales deberán contar con evaluadores externos a la entidad editora, por lo que deberá constar su afiliación institucional. Al menos el 50% de los miembros del consejo editorial deberán pertenecer a instituciones diferentes a la editora, de lo contrario no calificará positivamente.')}</td>
					<td>(2 pt)</td>
				</tr>
			</tbody>
		</table><br>

		<p>{_('Para')}<b> {_sprintf('solicitar la inclusión de su revista en %s y %s','<a href="http://clase.unam.mx" target="_blank"><acronym title="$clase">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="$periodica">PERIÓDICA</acronym></a></b>')}</b>, {_sprintf('se requiere enviar los tres últimos fascículos publicados por la revista, en archivos PDF sin candados de impresión, al buzón %s (con copia a %s), o bien, la dirección electrónica (URL) de la revista, acompañado de un mensaje dirigido a Antonio Sánchez Pereyra, Presidente del Comité de Selección de %s y %s, en el que se explicite la intención de que la revista sea evaluada para su indización en dichas bases de datos','<a href="mailto:biblat@dgb.unam.mx">biblat@dgb.unam.mx</a>','<a href="mailto:claseyperiodicaunam@gmail.com">claseyperiodicaunam@gmail.com</a>','<a href="http://clase.unam.mx" target="_blank"><acronym title="$clase">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="$periodica">PERIÓDICA</acronym></a></b>')}</p>

		<p>{_('Por otra parte, solicitamos, en caso de así convenir al editor de la revista, proporcionarnos la autorización para albergar los archivos PDF de la revista en la colección')}<b> {_('Hemeroteca Virtual Latinoamericana')}</b> {_sprintf('y ofrecer acceso al texto completo de los artículos a los usuarios de %s y %s, sin mediar por ello costo alguno para ustedes como editores ni para el usuario. Por nuestra parte y habida cuenta de las cuatro décadas de trabajo que respaldan nuestro compromiso y responsabilidad con la difusión del conocimiento científico y humanístico, asumimos lo siguiente:','<a href="http://clase.unam.mx" target="_blank"><acronym title="$clase">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="$periodica">PERIÓDICA</acronym></a>')}</p>

		<ol type=a>
			<li>{$unam=_('Universidad Nacional Autónoma de México') _sprintf('Ser un proyecto estrictamente académico impulsado por la Dirección General de Bibliotecas de la %s, y en consecuencia ser una organización de carácter científico.','<a href="http://www.unam.mx" target="_blank"><acronym title="$unam">UNAM</acronym></a>')}</li>

			<li>{_('Ser una hemeroteca científica en línea, de libre acceso a los contenidos completos de los artículos de su acervo.')}</li>

			<li>{_('Difundir de manera transparente y gratuita los trabajos y materiales que forman parte de la publicación para su consulta por parte de la comunidad científica a través de las siguientes páginas web:')} <a href="http://clase.unam.mx" target="_blank"><acronym title="{$clase}">CLASE</acronym></a>, <a href="http://periodica.unam.mx" target="_blank"><acronym title="{$periodica}">PERIÓDICA</acronym></a> y <a href="{base_url()}"><acronym title="{$biblat}">Biblat</acronym></a></li>

			<li>{_('No adjudicarse derechos de comercialización de los contenidos y materiales de la publicación, ni de sus logos, marcas y nombres registrados, por lo que tampoco está obligado a pagar regalías por la publicación de los mismos.')}</li>

			<li>{_('Respetar los derechos morales del autor, y en consecuencia mantener la integridad de la información salvaguardándola de mutilaciones, o modificaciones diferentes a las necesarias para la publicación electrónica de la obra, que generen inexactitudes o que vulneren la imagen de la revista, o del autor.')}</li>
			
			<li>{_sprintf('Respetar la decisión de la revista de brindar sus contenidos a cualquier otra hemeroteca, sitio web, sistema de indización que considere conveniente, con lo que se entiende que %s y %s no reclama ningún tipo de exclusividad.','<a href="http://clase.unam.mx" target="_blank"><acronym title="$clase">CLASE</acronym></a>','<a href="http://periodica.unam.mx" target="_blank"><acronym title="$periodica">PERIÓDICA</acronym></a>')}</li>
		</ol><br>

		<p>{_('En cuanto a la autorización solicitada al editor para el depósito de los archivos electrónicos en la colección Hemeroteca Virtual Latinoamericana así como para el acceso libre al texto completo de los artículos, solicitamos el envío del siguiente formato:')}</p>