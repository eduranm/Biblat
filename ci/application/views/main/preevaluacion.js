/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class_pre = {
    select:1,
    chart:null,
    puntos:0,
    puntos_obliga:0,
    puntos_nobliga:0,
    pag_inicio:0,
    pag_fin:0,
    criterio:[
        {
            texto:'1. Mención de un editor o responsable de la revista',
            descripcion:'Se valora positivamente la mención de un editor, director o responsable de la revista.',
            cumplo:false,
            celda:'D9',
            obligatorio:true
        },
        {
            texto:'2. Datos del organismo responsable y lugar de edición',
            descripcion:'Se valora positivamente si la revista proporciona información suficiente para la identificación y localización del organismo editor o institución responsable, así como los datos del lugar de edición. Los datos pueden ser: nombre completo de la institución editora, dirección postal, ciudad o lugar de edición, teléfonos, correo electrónico o sitio web.',
            cumplo:false,
            celda:'D10',
            obligatorio:true
        },
        {
            texto:'3. Existencia de tabla de contenidos o índice',
            descripcion:'Se valora positivamente si la revista proporciona la tabla de contenido o sumario en la que consten, entre otros, los nombres de los autores, título del trabajo y páginas.',
            cumplo:false,
            celda:'D11',
            obligatorio:true
        },
        {
            texto:'4. Identificación de los autores personales o institucionales en los documentos',
            descripcion:'Los trabajos deben estar firmados por los autores con nombre y apellidos o declaración de autor institucional.',
            cumplo:false,
            celda:'D12',
            obligatorio:true
        },
        {
            texto:'5. Referencias bibliográficas en los documentos',
            descripcion:'Los documentos publicados deben proporcionar una lista de referencias bibliográficas, obras citadas o notas bibliográficas al pie de página. La presencia de estas referencias será valorada solamente en artículos, ensayos o reseñas y no en cartas al editor, editoriales, entrevistas, reportajes u otro tipo de documentos que no suelen citar referencias bibliográficas.',
            cumplo:false,
            celda:'D13',
            obligatorio:true
        },
        {
            texto:'6. Membrete bibliográfico en cubiertas o páginas de presentación',
            descripcion:'Estas deberán incluir al menos el título completo de la revista, así como ISSN, volumen, número, fecha y membrete bibliográfico.',
            cumplo:false,
            celda:'D14',
            obligatorio:true
        },
        {
            texto:'7. 60% de contenido indizable',
            descripcion:'Al menos el 60% de los documentos publicados en un fascículo, deben ser: artículos originales, ensayos, reseñas de libro, revisiones bibliográficas, notas de más de una cuartilla, informes técnicos o cartas al editor.',
            cumplo:false,
            celda:'D15',
            obligatorio:true
        },
        {
            texto:'8. ISSN',
            descripcion:'Es obligatorio contar con código ISSN e ISSN para la versión electrónica en su caso.',
            cumplo:false,
            celda:'D16',
            obligatorio:true
        },
        {
            texto:'9. Mención del objetivo de la revista',
            descripcion:'En el fascículo se debe hacer mención de los objetivos que la publicación persigue. Puede valorarse también si hace explícita su especialización temática y/o la audiencia a la que va dirigida.',
            cumplo:false,
            celda:'D17',
            obligatorio:true
        },
        {
            texto:'10. Mención de periodicidad',
            descripcion:'Para su valoración la revista debe declarar su periodicidad sin ambigüedad o bien el número de ejemplares que ofrece al año. Este criterio califica solamente la mención de periodicidad, no su cumplimiento.',
            cumplo:false,
            celda:'D18',
            obligatorio:true
        },
        {
            texto:'11. Periodicidad semestral o más frecuente',
            descripcion:'Califica positivamente si la periodicidad de la revista es semestral o más frecuente, ya que se aprecia que cumpla con su misión de difundir sus contenidos en el menor tiempo posible.',
            cumplo:false,
            celda:'D19',
            obligatorio:true
        },
        {
            texto:'12. Cumplimiento de periodicidad',
            descripcion:'Se entiende que una revista cumple su periodicidad si a lo largo del año publica el número de fascículos que se corresponden con la periodicidad expresada por la revista (por ejemplo, tres fascículos al año, en el caso de las revistas cuatrimestrales). Por lo tanto, para poder calificar este criterio es indispensable que la revista explicite el número de ejemplares que ofrece al año (No aplica en periodicidad continua).',
            cumplo:false,
            celda:'D20',
            obligatorio:true
        },
        {
            texto:'13. Disponibilidad de contenidos retrospectivos',
            descripcion:'Aplica a revistas electrónicas y el requisito se refiere al acceso a números y documentos en texto completo publicados anteriormente, considerando un lapso de tiempo de 5 años al menos o desde que se inició la publicación de la revista.',
            cumplo:false,
            celda:'D21',
            obligatorio:true
        },
        {
            texto:'14. Existencia de un consejo, comité o cuerpo editorial',
            descripcion:'Deberá constar en la revista la existencia de un cuerpo editorial que apoye al editor en diversas responsabilidades inherentes a la gestión de la revista o bien a la evaluación de las contribuciones, y deberán proporcionarse los nombres de cada uno de los que forman parte de esas instancias.',
            cumplo:false,
            celda:'D22',
            obligatorio:true
        },
        {
            texto:'15. Servicios de indización que cubren la revista',
            descripcion:'Califica positivamente si la revista está incluida en algún servicio de índices y resúmenes, directorios, catálogos, hemerotecas virtuales y listas del núcleo básico de revistas nacionales, entre otros servicios de información. Este campo califica positivamente solamente si el servicio de información es mencionado por la propia revista.',
            cumplo:false,
            celda:'D23',
            obligatorio:true
        },
        {
            texto:'16. Clasificación de los tipos de documentos publicados (Tabla de contenido)',
            descripcion:'Ya sea por los tipos de documentos publicados (artículo original, revisiones, reseñas, por ej.) o por temáticas específicas.',
            cumplo:false,
            celda:'D24',
            obligatorio:true
        },
        {
            texto:'17. Instrucciones a los autores',
            descripcion:'Califica positivamente si aparecen las instrucciones a los autores sobre el envío de originales.',
            cumplo:false,
            celda:'D25',
            obligatorio:true
        },
        {
            texto:'18. Normas para referencias bibliográficas',
            descripcion:'En las instrucciones a los autores deben indicarse las normas de elaboración de las referencias bibliográficas basadas en alguna norma internacional ampliamente aceptada (APA, Harvard, ISO, Vancouver u alguna otra).',
            cumplo:false,
            celda:'D26',
            obligatorio:true
        },
        {
            texto:'19. Membrete bibliográfico al inicio del documento',
            descripcion:'Califica positivamente si éste aparece al inicio de cada artículo e identifica a la fuente. Para darlo por cumplido, cada documento ya sea en PDF y/o HTML, debe incluir un membrete que contenga por lo menos: título completo o abreviado, DOI y la numeración de la revista (año, volumen, número, parte, mes).',
            cumplo:false,
            celda:'D27',
            obligatorio:true
        },
        {
            texto:'20. Membrete bibliográfico en cada página del documento',
            descripcion:'Califica positivamente si el membrete que identifica al documento (PDF y/o HTML) aparece en páginas pares o impares del artículo, no necesariamente en ambas.',
            cumplo:false,
            celda:'D28',
            obligatorio:true
        },
        {
            texto:'21. Uso del identificador de recursos uniforme (URI)',
            descripcion:'Por ejemplo, Handle o el Digital Object Identifier (DOI) para cada uno de los documentos publicados. Este requisito aplica para las revistas electrónicas.',
            cumplo:false,
            celda:'D29',
            obligatorio:true
        },
        {
            texto:'22. Descarga individual de contenidos',
            descripcion:'Permite la descarga de los artículos de manera individual.',
            cumplo:false,
            celda:'D30',
            obligatorio:true
        },
        {
            texto:'23. Fechas de recepción y/o aceptación del documento',
            descripcion:'Califica positivamente sólo si indica ambas fechas. Esta información puede ser localizada al inicio o al final de cada artículo y es sólo exigible para artículos originales.',
            cumplo:false,
            celda:'D31',
            obligatorio:true
        },
        {
            texto:'24. Resumen del documento',
            descripcion:'Califica positivamente si se incluyen resúmenes en el idioma original del trabajo.',
            cumplo:false,
            celda:'D32',
            obligatorio:true
        },
        {
            texto:'25. Resumen del documento en dos idiomas',
            descripcion:'Califica positivamente si se incluyen resúmenes en el idioma original del trabajo y en un segundo idioma.',
            cumplo:false,
            celda:'D33',
            obligatorio:true
        },
        {
            texto:'26. Afiliación de los autores',
            descripcion:'Deberá proporcionarse el nombre de la institución de trabajo del autor o autores de cada artículo.',
            cumplo:false,
            celda:'D34',
            obligatorio:true
        },
        {
            texto:'27. Palabras clave',
            descripcion:'Deben proporcionarse palabras clave, en cualquier idioma, que describan el contenido del documento. Al igual que con los resúmenes, las palabras clave se valoran solamente en artículos.',
            cumplo:false,
            celda:'D35',
            obligatorio:true
        },
        {
            texto:'28. Palabras clave en dos idiomas',
            descripcion:'Las palabras clave deben proporcionarse en dos idiomas y al igual que en el criterio referido al idioma de los resúmenes, en este caso tampoco se considera obligatorio que estén presentes en otro tipo de documentos diferentes a los artículos.',
            cumplo:false,
            celda:'D36',
            obligatorio:true
        },
        {
            texto:'29. Mención del sistema de arbitraje por pares',
            descripcion:'En la revista deberá constar que el procedimiento empleado para la selección de los artículos a publicar es el arbitraje por pares.',
            cumplo:false,
            celda:'D37',
            obligatorio:true
        },
        {
            texto:'30. Sistema de arbitraje doble ciego',
            descripcion:'En la revista deberá constar que el procedimiento empleado para la selección de los artículos a publicar es el arbitraje por pares especificando que sea mediante el sistema "doble ciego".',
            cumplo:false,
            celda:'D38',
            obligatorio:true
        },
        {
            texto:'31. Mención de originalidad de los documentos',
            descripcion:'Califica positivamente si en la presentación de la revista o en las instrucciones a los autores se menciona explícitamente esta exigencia para los trabajos sometidos a publicación.',
            cumplo:false,
            celda:'D39',
            obligatorio:true
        },
        {
            texto:'32. Apertura institucional del consejo, comité o cuerpo editorial',
            descripcion:'Para calificar positivamente, los cuerpos editoriales deberán contar con evaluadores externos a la entidad editora, por lo que deberá constar su afiliación institucional. Al menos el 50% de los miembros del consejo editorial deberán pertenecer a instituciones diferentes a la editora, de lo contrario no calificará positivamente.',
            cumplo:false,
            celda:'D40',
            obligatorio:true
        },
        {
            texto:'33. Declaración de política de derecho de autor respecto al acceso de los documentos',
            descripcion:'En particular se recomienda utilizar licencias Creative Commons (https://creativecommons.org/licenses). La información del tipo de licencia adoptada por la revista debe constar obligatoriamente en los formatos PDF, XML y otros que utilice la revista para la publicación en línea.',
            cumplo:false,
            celda:'D41',
            obligatorio:true
        },
        {
            texto:'34. Adopción de códigos de ética',
            descripcion:'La revista debe informar su adhesión a normas y códigos de ética internacionales: Pueden ser los establecidos por el Committee on Publication Ethics (Code of Conduct and Best Practices Guidelines for Journals Editors, COPE https://publicationethics.org), por el Council of Science Editors (http://www.councilscienceeditors.org), Council for International Organizations of Medical Sciences (CIOMS, http://cioms.ch), el International Committee of Medical Journal Editors (ICJME, http://www.icmje.org), algún otro o bien, tener su propio código de ética.',
            cumplo:false,
            celda:'D45',
            obligatorio:false
        },
        {
            texto:'35. Fuentes de financiamiento',
            descripcion:'Indicar si la revista efectúa cobro por el procesamiento de artículos (APC).',
            cumplo:false,
            celda:'D46',
            obligatorio:false
        },
        {
            texto:'36. Formato de dictaminación visible',
            descripcion:'Es público y disponible el formulario de evaluación utilizado por los dictaminadores.',
            cumplo:false,
            celda:'D47',
            obligatorio:false
        },
        {
            texto:'37. Publicación al inicio del periodo programado',
            descripcion:'Para aprobar este punto se requiere que la publicación de los contenidos de la revista se realice al inicio del período según la frecuencia definida por la revista. Para tal efecto, se verifica la frecuencia definida por la revista y la fecha observada en el sitio web de la revista. La fecha en que se debe publicar es al comienzo del periodo declarado. Este punto es obviado si la revista ha adoptado el modelo de publicación continua.',
            cumplo:false,
            celda:'D48',
            obligatorio:false
        },
        {
            texto:'38. Tiempo de procesamiento de los manuscritos',
            descripcion:'El tiempo promedio de procesamiento de los manuscritos debe ser como máximo de hasta 6 (seis) meses, considerando el tiempo entre las fechas de recepción y de decisión final en cuanto a la publicación, y de hasta 12 (doce) meses, considerando el tiempo entre las fechas de recepción y publicación del manuscrito. Sin embargo, se recomienda un ciclo total medio de 6 (seis) meses.',
            cumplo:false,
            celda:'D49',
            obligatorio:false
        },
        {
            texto:'39. Recepción continua de manuscritos',
            descripcion:'La recepción de artículos para su dictaminación y probable publicación por la revista debe estar disponible de forma continua, es decir, no es válido que las revistas suspendan la recepción de manuscritos en ningún período por ninguna razón.',
            cumplo:false,
            celda:'D50',
            obligatorio:false
        },
        {
            texto:'40. Periodicidad y número de artículos publicados por año aceptables',
            descripcion:'La periodicidad y el número de artículos publicados al año son indicadores del flujo de producción editorial de la revista y de la producción científica del área temática correspondiente. Los valores de referencia requeridos dependen del área temática en la que la revista está clasificada.',                     
            cumplo:false,
            celda:'D51',
            obligatorio:false            
        },
        {
            texto:'41. Composición e internacionalidad de los editores y del cuerpo editorial (Editores asociados o Editores por sección)',
            descripcion:'Las revistas pueden adoptar diferentes estructuras y denominaciones de instancias de gestión editorial. Estas estructuras y las funciones que realizan deben estar documentadas formalmente y actualizadas periódicamente/anualmente.'
                    +'<br><br>Editores-jefes: Todas las revistas deben tener uno o más editores-jefes definidos, con afiliación nacional o extranjera...',
            cumplo:false,
            celda:'D53',
            obligatorio:false,
            ver:true
        },
        {
            texto:'42. Cuerpo de editores asociados o de sección',
            descripcion:'La gestión editorial debe contar preferentemente con uno o más grupos definidos de editores que colaboran activa y sistemáticamente con el editor jefe en la gestión del flujo de evaluación de manuscritos, con énfasis en la selección e interacción con los evaluadores y autores. En general, estos editores se agrupan bajo la denominación de editores asociados o editores de sección, son parte formal del equipo editorial y contribuyen sistemáticamente a la evaluación de manuscritos...',
            cumplo:false,
            celda:'D56',
            obligatorio:false,
            ver:true
        },
        {
            texto:'43. Internacionalidad de los dictaminadores/árbitros',
            descripcion:'Los expertos encargados de la dictaminación de los artículos deben ser investigadores nacionales y extranjeros reconocidos en el tema de los manuscritos que evalúan. Debe maximizarse la participación de árbitros afiliados a instituciones extranjeras.',
            cumplo:false,
            celda:'D59',
            obligatorio:false
        },
        {
            texto:'44. Identificación de la afiliación institucional e internacionalidad de los autores',
            descripcion:'Se requiere el registro exhaustivo de las afiliaciones de los autores para la identificación del origen institucional y geográfico de las investigaciones publicadas. Así, todos los tipos de documentos, sin excepción, deben tener autoría con especificación completa de las instancias institucionales y geográficas a las que están afiliados cada uno de los autores. Cada instancia institucional es identificada por nombres de hasta tres niveles jerárquicos o programáticos y por la ubicación geográfica (ciudad, estado y país) en que está localizada...',
            cumplo:false,
            celda:'D60',
            obligatorio:false,
            ver:true
        },
        {
            texto:'45. Normalización de los textos, citas y referencias bibliográficas',
            descripcion:'Las revistas deben especificar en las instrucciones a los autores las normas que siguen para la estructuración y presentación de los textos y para la presentación y formato de las citas y de las referencias bibliográficas.'
            +'<br>La estructuración de los textos es dependiente de las áreas temáticas y tipos de documentos. Las revistas deben de preferencia seguir las patrones y prácticas más comunes en las respectivas áreas temáticas. Algunas áreas temáticas cuentan con guías y directrices para la publicación de ciertos tipos de investigaciones, como es el caso de la Red Equator para las ciencias de la salud: http://www.equator-network.org...',
            cumplo:false,
            celda:'D72',
            obligatorio:false,
            ver:true
        },
        {
            texto:'46. Declaración de la contribución de autores y colaboradores',
            descripcion:'La autoría de un documento atribuye crédito e implica la responsabilidad del contenido publicado. Las revistas deben instruir a los autores a registrar al final de los artículos la contribución de cada uno de los autores y colaboradores, expresada en las instrucciones a los autores, con la utilización de dos criterios mínimos de autoría...',
            cumplo:false,
            celda:'D77',
            obligatorio:false,
            ver:true
            
        },
        {
            texto:'47. Adopción de lineamiento de Ciencia Abierta',
            descripcion:'La Ciencia Abierta preconiza la apertura de todos los componentes que fundamentan la comunicación de la investigación, como son los métodos, datos y programas de computadora. Esta apertura pretende contribuir a acelerar la publicación de las investigaciones, facilitar la evaluación de los manuscritos, la replicabilidad de las investigaciones y reutilización de los datos recolectados. En este sentido, se requiere la implantación de los siguientes avances...',
            cumplo:false,
            celda:'D85',
            obligatorio:false,
            ver:true
        },
        {
            texto:'48. Erratas y retractaciones',
            descripcion:'Los editores deben mencionar en las instrucciones a los autores, que permiten la publicación de erratas y por otra parte se responsabilizan de la retractación de artículos.',
            cumplo:false,
            celda:'D91',
            obligatorio:false
        }
        
        
    ],
    gaugeOptions : {
            chart: {
                type: 'solidgauge',
                backgroundColor: 'transparent'
            },

            title: null,

            pane: {
                center: ['50%', '50%'],
                size: '80%',
                startAngle: -90,
                endAngle: 90,
                background: {
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                    innerRadius: '60%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            exporting: {
                enabled: false
            },

            tooltip: {
                enabled: false
            },

            // the value axis
            yAxis: {
                stops: [
                    [0.1, '#DF5353'], // red
                    [0.85, '#DDDF0D'], // yellow            
                    [0.85, '#55BF3B'], // green            
                ],
                lineWidth: 0,
                tickWidth: 0,
                minorTickInterval: null,
                tickAmount: 2,
                title: {
                    y: -70
                },
                labels: {
                    y: 16
                }
            },

            plotOptions: {
                solidgauge: {
                    dataLabels: {
                        y: 5,
                        borderWidth: 0,
                        useHTML: true
                    }
                }
            }
        },
    
    ready:function(){
//        var href = '    <b><a target="_blank" style="float:right;font-size:14" href="criterios-de-seleccion#1">Ver criterio</a></b>';
        var href = '';
        $('#ev_texto').html(class_pre.criterio[class_pre.select-1].texto 
                + ((class_pre.criterio[class_pre.select-1].obligatorio)?' (Obligatorio)':''));
        $('#ev_descripcion').html(class_pre.criterio[class_pre.select-1].descripcion
                + ((class_pre.criterio[class_pre.select-1].ver)?href:'')
                );
        
        class_pre.paginacion(1,1);
        
        class_pre.control();
        
        class_pre.chart = Highcharts.chart('resultado', Highcharts.merge(class_pre.gaugeOptions, {
            yAxis: {
                min: 0,
                max: 48,
                title: {
                    text: ''
                }
            },

            credits: {
                enabled: false
            },

            series: [{
                name: 'Puntos',
                data: [0],
                dataLabels: {
                    format:
                        '<div style="text-align:center">' +
                        '<span style="font-size:25px">{y}</span><br/>' +
                        '<span style="font-size:12px;opacity:0.4">Puntos totales</span><br/><br/>' +                        
                        '<span id="obliga" style="font-size:9px;opacity:0.4;text-align:left">Obligatorios: 0/33</span><br/>' +                        
                        '<span id="nobliga" style="font-size:9px;opacity:0.4">No obligatorios: 0/15</span>' +                        
                        '</div>'
                },
                tooltip: {
                    valueSuffix: 'puntos'
                }
            }]

        }));        
        
    },
    control:function(){
        class_pre.anterior_click();
        class_pre.siguiente_click();
        class_pre.pag_click();
        
        $('#btn_cumplo').on('click',function(){
            var num = parseInt($('.pagination .active a').text())-1;
            var cumplo = !class_pre.criterio[num].cumplo;
            var point = class_pre.chart.series[0].points[0];
            
            class_pre.criterio[num].cumplo = cumplo;
            
            if(num<33)
                if(cumplo)
                    class_pre.puntos_obliga++;
                else
                    class_pre.puntos_obliga--;
            else
                if(cumplo)
                    class_pre.puntos_nobliga++;
                else
                    class_pre.puntos_nobliga--;               
            
            if(cumplo){
                class_pre.puntos++;
                $('#btn_cumplo').removeClass('btn-default');
                $('#btn_cumplo').addClass('btn-success');
            }else{
                class_pre.puntos--;
                $('#btn_cumplo').removeClass('btn-success');
                $('#btn_cumplo').addClass('btn-default');
            }
            
            point.update(class_pre.puntos);
            
            $('#obliga').text('Obligatorios: ' + class_pre.puntos_obliga + '/33');
            $('#nobliga').text('No obligatorios: ' + class_pre.puntos_nobliga + '/15');
            
            if(class_pre.puntos_obliga === 33 && class_pre.puntos_nobliga >= 7){
                $('#div_postular').show();
                $('#div_enviar').hide();
                $('path.highcharts-point').css('fill','rgb(82 223 82)');                
            }else{
                $('#div_postular').hide();
                $('#div_enviar').show();
                if(class_pre.puntos_obliga !== 33)
                    $('path.highcharts-point').css('fill','rgb(221,222,13)');
                else
                    $('path.highcharts-point').css('fill','');
            }
            
            if (cumplo)
                setTimeout(function(){
                    $('#sig').click();
                    $('#btn_cumplo')[0].blur();
                },100);
            else
                $('#btn_cumplo')[0].blur();
        });
        
        $('#btn_comenzar').on('click',function(){
            $('#row_comenzar').hide();
            $('#row_preevaluacion').show();            
        });
        
        $('#form_postular').on('submit',function(e){
            e.preventDefault();
            var form = {};
            form.nombre = $('#nombre').val();
            form.correo = $('#correo').val();
            form.nombre_revista = $('#nombre_revista').val();
            form.issn = $('#issn').val();
            form.pais = $('#pais').val();
            form.organizacion = $('#organizacion').val();
            form.periodicidad = $('#periodicidad').val();
            form.ciudad = $('#ciudad').val();
            form.autorizo = $('#autorizo')[0].checked;
            loading.start();
            
            $.post('<?=site_url("main/createPlantilla");?>', $.extend(form,{criterio:class_pre.criterio,completo:true}), function(result){
                loading.end();
                $('#btn_postular').prop('disabled',true);
                $('#btn_postular').text('Enviado!');
                $('#div_enviar').html('');
                $('#div_criterios').html('');
                $('.form').prop('disabled',true);
              });
        });
        
        $('#form_enviar').on('submit',function(e){
            e.preventDefault();
            var form = {};
            form.correo = $('#correo2').val();
            loading.start();
            
            $.post('<?=site_url("main/createPlantilla");?>', $.extend(form,{criterio:class_pre.criterio,completo:false}), function(result){
                loading.end();
                $('#btn_enviar').prop('disabled',true);
                $('#btn_enviar').text('Enviado!');
                $('#div_postular').html('');
                $('#div_criterios').html('');
                $('.form').prop('disabled',true);
              });
        });
    },
    siguiente_click:function(){
        $('#sig').on('click',function(){
            var active = $('.pagination .active a');
            class_pre.select = parseInt(active.text());
            class_pre.select++;
            var href = '    <b><a target="_blank" style="font-size:14" href="criterios-de-seleccion#'+class_pre.select+'">Ver criterio completo</a></b>';
            //var href = '';
            $('#ev_texto').html(class_pre.criterio[class_pre.select-1].texto
                    + ((class_pre.criterio[class_pre.select-1].obligatorio)?' (Obligatorio)':'')
                    );
            $('#ev_descripcion').html(class_pre.criterio[class_pre.select-1].descripcion
                    + ((class_pre.criterio[class_pre.select-1].ver)?href:'')
                    );
            if(class_pre.select > class_pre.pag_fin){
                class_pre.paginacion(class_pre.select,class_pre.select);
            }else{
                class_pre.paginacion(class_pre.pag_inicio,class_pre.select);
            }
            class_pre.anterior_click();
            class_pre.siguiente_click();
            class_pre.pag_click();
            class_pre.btn_cumplo();
        });
    },
    anterior_click:function(){
        $('#ant').on('click',function(){
            var active = $('.pagination .active a');
            class_pre.select = parseInt(active.text());
            class_pre.select--;
            var href = '    <b><a target="_blank" style="font-size:14" href="criterios-de-seleccion#'+class_pre.select+'">Ver criterio completo</a></b>';
            //var href = '';
            $('#ev_texto').html(class_pre.criterio[class_pre.select-1].texto
                    + ((class_pre.criterio[class_pre.select-1].obligatorio)?' (Obligatorio)':'')
                    );
            $('#ev_descripcion').html(class_pre.criterio[class_pre.select-1].descripcion
                    + ((class_pre.criterio[class_pre.select-1].ver)?href:'')
                    );
            if(class_pre.select < class_pre.pag_inicio){
                class_pre.paginacion(class_pre.select-9,class_pre.select);
            }else{
                class_pre.paginacion(class_pre.pag_inicio,class_pre.select);
            }
            class_pre.anterior_click();
            class_pre.siguiente_click();
            class_pre.pag_click();
            class_pre.btn_cumplo();
        });
    },
    pag_click:function(){
        $('.pag').on('click',function(e){
            class_pre.select = parseInt(this.text);
            var href = '    <b><a target="_blank" style="font-size:14" href="criterios-de-seleccion#'+class_pre.select+'">Ver criterio completo</a></b>';
            //var href = '';
            $('#ev_texto').html(class_pre.criterio[class_pre.select-1].texto
                    + ((class_pre.criterio[class_pre.select-1].obligatorio)?' (Obligatorio)':'')
                    );
            $('#ev_descripcion').html(class_pre.criterio[class_pre.select-1].descripcion
                    + ((class_pre.criterio[class_pre.select-1].ver)?href:'')
                    );
            class_pre.paginacion(class_pre.pag_inicio,class_pre.select);
            
            class_pre.anterior_click();
            class_pre.siguiente_click();
            class_pre.pag_click();
            class_pre.btn_cumplo();
        });
    },
    btn_cumplo:function(){
        if(class_pre.criterio[class_pre.select-1].cumplo){
                $('#btn_cumplo').removeClass('btn-default');
                $('#btn_cumplo').addClass('btn-success');
            }else{
                $('#btn_cumplo').removeClass('btn-success');
                $('#btn_cumplo').addClass('btn-default');
            }
    },
    paginacion:function(inicio, activa){
        class_pre.pag_inicio = inicio;
        $('#pag').html('');
        var len = 10;        
        var html = '';
        var style = ['', 'style="background-color:mediumseagreen; color:white;"']
        
        if(activa !== 1)
            html = '<li><a id="ant" href="javascript:void(0);" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>';
        
        class_pre.criterio.forEach(function(val,i){
            if(i>=(inicio-1) && i<(inicio+len-1)){
                class_pre.pag_fin = (i+1);
                if(i===(activa-1))
                    html+='<li id="pag'+(i+1)+'" class="active"><a class="pag" href="javascript:void(0);">'+(i+1)+'</a></li>';
                else
                   html+='<li id="pag'+(i+1)+'"><a class="pag" '+style[(val.cumplo)?1:0]+' href="javascript:void(0);">'+(i+1)+'</a></li>';
           }        
        });
        
        if(class_pre.criterio.length !== activa)
            html+='<li><a href="javascript:void(0);" aria-label="Siguiente" id="sig"><span aria-hidden="true">»</span></a></li>';
        
        $('#pag').html(html);
    }
};

$(class_pre.ready);
