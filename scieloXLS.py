#!/usr/bin/python
# -*- coding: utf-8 -*-
import re
import xlrd
import argparse
import sys
reload(sys)
sys.setdefaultencoding("utf-8")

book = None
sheet = None
nrows = None
ncols = None
discartRow = re.compile(r'(.*Total.*|.*SciELO.*|.*Scielo.*)')

networkId = {
	'Brasil': 1,
	'Chile': 2,
	'Colombia': 3,
	u'Col\xf4mbia': 3,
	'Espanha': 4,
	u'México': 5,
	'Argentina': 6,
	'Cuba': 7,
	'Venezuela': 8,
	u'África do Sul': 9,
	u'Africa do Sul': 9,
	'Portugal': 10,
	u'Perú': 11,
	'Peru': 11,
	'Costa Rica': 12,
	u'Saúde Pública': 13,
	'Social Sciences': 14
}

areaId = {
	u'Ciências Agrárias': 1,
	u'Ciências Agrícolas': 1,
	u'Ciências Biológicas': 2,
	u'Ciências da Saúde': 3,
	u'Ciências Exatas e da Terra': 4,
	u'Ciências Sociais Aplicadas': 5,
	u'Ciências Humanas': 6,
	'Engenharias': 7,
	'Engenharia': 7,
	u'Lingüística, Letras e Artes': 8,
	u'Linguistica, Letras e Artes': 8
}

areaConacytId = {
	u'Físico, Matemáticas y Ciencias de la Tierra': 1,
	u'Biología y Química': 2,
	u'Medicina y Ciencias de la Salud': 3,
	u'Humanidades y Ciencias de la Conducta': 4,
	u'Ciencias Sociales': 5,
	u'Biotecnología y Ciencias Agropecuarias': 6,
	u'Ingenierías': 7,
	u'Multidisciplinarias': 8
}

affiliationCountry = {
	u'Afeganistão': u'Afganistán',
	u'Albania': u'Albania',
	u'Alemanha': u'Alemania',
	u'Angola': u'Angola',
	u'Antilhas Holandesas': u'Antillas Holandesas',
	u'Arábia Saudita': u'Arabia Saudita',
	u'Algeria': u'Argelia',
	u'Argentina': u'Argentina',
	u'Armênia': u'Armenia',
	u'Australia': u'Australia',
	u'Austria': u'Austria',
	u'Bahamas': u'Bahamas',
	u'Bahrein': u'Bahrein',
	u'Bangladesh': u'Bangladesh',
	u'Barbados': u'Barbados',
	u'Belize': u'Belice',
	u'Benim': u'Benim',
	u'Belarus': u'Bielorrusia',
	u'Bolívia': u'Bolivia',
	u'Bosnia-Herzegovina': u'Bosnia y Herzegovina',
	u'Botsuana': u'Botswana',
	u'Brasil': u'Brasil',
	u'Búlgaria': u'Bulgaria',
	u'Burquina Fasso': u'Burkina Faso',
	u'Bélgica': u'Bélgica',
	u'Cabo Verde': u'Cabo Verde',
	u'Camboja': u'Camboya',
	u'Camarões': u'Camerún',
	u'Canadá': u'Canadá',
	u'Chade': u'Chad',
	u'Chile': u'Chile',
	u'China': u'China',
	u'Chipre': u'Chipre',
	u'Colômbia': u'Colombia',
	u'Congo': u'Congo',
	u'Coreia do Sul': u'Corea del Sur',
	u'Costa Rica': u'Costa Rica',
	u'Costa do Marfim': u'Costa de Marfil',
	u'Croácia': u'Croacia',
	u'Cuba': u'Cuba',
	u'Dinamarca': u'Dinamarca',
	u'Dominica': u'Dominica',
	u'Equador': u'Ecuador',
	u'Egito': u'Egipto',
	u'El Salvador': u'El Salvador',
	u'Emirados Árabes Unidos': u'Emiratos Árabes Unidos',
	u'Eritréia': u'Eritrea',
	u'Eslovênia': u'Eslovenia',
	u'Espanha': u'España',
	u'Estados Unidos da América': u'Estados Unidos de América',
	u'Estônia': u'Estonia',
	u'Etiópia': u'Etiopía',
	u'Fiji': u'Fiji',
	u'Filipinas': u'Filipinas',
	u'Finlândia': u'Finlandia',
	u'França': u'Francia',
	u'Gabão': u'Gabón',
	u'Gâmbia': u'Gambia',
	u'Georgia': u'Georgia',
	u'Gana': u'Ghana',
	u'Grécia': u'Grecia',
	u'Groenlândia': u'Groenlandia',
	u'Guatemala': u'Guatemala',
	u'Guiana': u'Guayana',
	u'Guiana Francesa': u'Guayana Francesa',
	u'Guine': u'Guinea',
	u'Guine-Bissau': u'Guinea-Bisáu',
	u'Haiti': u'Haití',
	u'Honduras': u'Honduras',
	u'Hong Kong': u'Hong Kong',
	u'Hungria': u'Hungría',
	u'Índia': u'India',
	u'Indonésia': u'Indonesia',
	u'Iraque': u'Irak',
	u'Irlanda': u'Irlanda',
	u'Irã, República Islâmica do': u'Irán',
	u'Islândia': u'Islandia',
	u'Falkland, Ilhas': u'Islas Malvinas',
	u'Maurício, Ilhas': u'Islas Mauricio',
	u'Salomão, Ilhas': u'Islas Salomón',
	u'Israel': u'Israel',
	u'Itália': u'Italia',
	u'Jamaica': u'Jamaica',
	u'Japão': u'Japón',
	u'Jordânia': u'Jordania',
	u'Qatar': u'Katar',
	u'Cazaquistão': u'Kazajistán',
	u'Quênia': u'Kenia',
	u'Quirguizistão': u'Kirguistán',
	u'Kuwait': u'Kuwait',
	u'Lessoto': u'Lessoto',
	u'Letônia': u'Letonia',
	u'Libéria': u'Liberia',
	u'Líbia': u'Libia',
	u'Lituânia': u'Lituania',
	u'Luxemburgo': u'Luxemburgo',
	u'Líbano': u'Líbano',
	u'Macau': u'Macao',
	u'Madagascar': u'Madagascar',
	u'Malásia': u'Malasia',
	u'Malawi': u'Malawi',
	u'Malta': u'Malta',
	u'Mali': u'Malí',
	u'Marrocos': u'Marruecos',
	u'Mongólia': u'Mongolia',
	u'Moçambique': u'Mozambique',
	u'Myanmar': u'Myanmar',
	u'México': u'México',
	u'Namíbia': u'Namibia',
	u'Nepal': u'Nepal',
	u'Nicarágua': u'Nicaragua',
	u'Nigéria': u'Nigeria',
	u'Noruega': u'Noruega',
	u'Nova Caledônia': u'Nueva Caledonia',
	u'Nova Zelândia': u'Nueva Zelanda',
	u'Niger': u'Níger',
	u'Omã': u'Omán',
	u'Paquistão': u'Pakistán',
	u'Panamá': u'Panamá',
	u'Papua-Nova Guiné': u'Papúa Nueva Guinea',
	u'Paraguai': u'Paraguay',
	u'Países Baixos': u'Países Bajos',
	u'Perú': u'Perú',
	u'Polônia': u'Polonia',
	u'Portugal': u'Portugal',
	u'Porto Rico': u'Puerto Rico',
	u'Reino Unido': u'Reino Unido',
	u'Centro-Africana, República': u'República Centroafricana',
	u'Tcheca, República': u'República Checa',
	u'Dominicana, República': u'República Dominicana',
	u'Eslovaca, República': u'República Eslovaca',
	u'Romênia': u'Romênia',
	u'Ruanda': u'Ruanda',
	u'Federacao Russa': u'Rusia',
	u'Saint Kitts Nevis Anguilla': u'Saint Kitts Nevis Anguilla',
	u'San Marino': u'San Marino',
	u'Senegal': u'Senegal',
	u'Seychelles': u'Seychelles',
	u'Serra Leoa': u'Sierra Leona',
	u'não informado': u'Sin información',
	u'Singapura': u'Singapur',
	u'Síria': u'Siria',
	u'Somália': u'Somalia',
	u'Sri Lanka': u'Sri Lanka',
	u'África do Sul': u'Sudáfrica',
	u'Sudão': u'Sudán',
	u'Suécia': u'Suecia',
	u'Suiça': u'Suiza',
	u'Suriname': u'Suriname',
	u'Swazilandia': u'Swazilandia',
	u'Suazilândia': u'Suazilandia',
	u'Tailândia': u'Tailandia',
	u'Taiwan': u'Taiwán',
	u'Tanzânia': u'Tanzania',
	u'Togo': u'Togo',
	u'Tonga': u'Tonga',
	u'Trinidad e Tobago': u'Trinidad y Tobago',
	u'Turquia': u'Turquía',
	u'Tunísia': u'Túnez',
	u'Ucrânia': u'Ucrania',
	u'Uganda': u'Uganda',
	u'Uruguai': u'Uruguay',
	u'Usbequistão': u'Uzbekistán',
	u'Venezuela': u'Venezuela',
	u'Vietnã': u'Vietnam',
	u'Iemen': u'Yemen',
	u'Iugoslavia': u'Yugoslavia',
	u'Zâmbia': u'Zambia',
	u'Zimbabue': u'Zimbabue'
}

neumonics = {
	u'Acta botánica mexicana': 'abm',
	u'Acta de investigación psicológica': 'aip',
	u'Acta ortopédica mexicana': 'aom',
	u'Acta poética': 'ap',
	u'Acta zoológica mexicana': 'azm',
	u'Agricultura técnica en México': 'agrit',
	u'Agricultura, sociedad y desarrollo': 'asd',
	u'Agrociencia': 'agro',
	u'Alteridades': 'alte',
	u'América Latina en la historia económica': 'alhe',
	u'Anales del Instituto de Investigaciones Estéticas': 'aiie',
	u'Andamios': 'anda',
	u'Anuario Mexicano de Derecho Internacional': 'amdi',
	u'Anuario mexicano de derecho internacional': 'amdi',
	u'Archivos de cardiología de México': 'acm',
	u'Archivos de neurociencias (México, D.F.)': 'aneuro',
	u'Argumentos (México, D.F.)': 'argu',
	u'Atmósfera': 'atm',
	u'Biocyt biología, ciencia y tecnología': 'biocyt',
	u'Boletín de la Sociedad Botánica de México': 'bsbm',
	u'Boletín de la Sociedad Geológica Mexicana': 'bsgm',
	u'Boletín mexicano de derecho comparado': 'bmdc',
	u'Boletín médico del Hospital Infantil de México': 'bmim',
	u'Botanical Sciences': 'bs',
	u'Ciencia forestal en México': 'cfm',
	u'Ciencia Forestal en México/ahora Revista mexicana de ciencias forestales': 'cfm',
	u'Ciencias Marinas': 'ciemar',
	u'Ciencias marinas': 'ciemar',
	u'Cirujano general': 'cg',
	u'Computación y Sistemas': 'cys',
	u'Comunicación y Sociedad': 'comso',
	u'Comunicación y sociedad': 'comso',
	u'Concreto y cemento. Investigación y desarrollo': 'ccid',
	u'CONfines de relaciones internacionales y ciencia política': 'confines',
	u'Contaduría y administración': 'cya',
	u'Convergencia': 'conver',
	u'Crítica (México, D.F.)': 'rhfi',
	u'Cuestiones constitucionales': 'cconst',
	u'Cuicuilco': 'cuicui',
	u'Cultura y representaciones sociales': 'crs',
	u'Culturales': 'cultural',
	u'Desacatos': 'desacatos',
	u'Diánoia': 'dianoia',
	u'Economía mexicana. Nueva época': 'emne',
	u'Economía sociedad y territorio': 'est',
	u'Economía UNAM': 'eunam',
	u'Economía, sociedad y territorio': 'est',
	u'Economía: teoría y práctica': 'etp',
	u'Economíaunam': 'eunam',
	u'EconoQuantum': 'ecoqu',
	u'Ecosistema y recursos agropecuarios': 'era',
	u'Ecosistemas y recursos agropecuarios': 'era',
	u'Educación matemática': 'ed',
	u'Educación química': 'eq',
	u'En-claves del pensamiento': 'enclav',
	u'Enfermería universitaria': 'eu',
	u'Escritos. Universidad Autónoma de Puebla': 'escritos',
	u'Espiral (Guadalajara)': 'espiral',
	u'Espiral': 'espiral',
	u'Estudios de cultura maya': 'ecm',
	u'Estudios de cultura náhuatl': 'ecn',
	u'Estudios de historia moderna y contemporánea de México': 'ehmcm',
	u'Estudios de historia novohispana': 'ehn',
	u'Estudios fronterizos': 'estfro',
	u'Estudios políticos (México)': 'ep',
	u'Estudios sociales (Hermosillo, Son.)': 'estsoc',
	u'Frontera norte': 'fn',
	u'Gaceta médica de México': 'gmm',
	u'Geofísica internacional': 'geoint',
	u'Gestión y política pública': 'gpp',
	u'Hidrobiológica': 'hbio',
	u'Historia y grafía': 'hg',
	u'Huitzil': 'huitzil',
	u'Ingeniería mecánica, tecnología y desarrollo (Impresa)': 'imtd',
	u'Ingeniería mecánica, tecnología y desarrollo': 'imtd',
	u'Ingeniería, investigación y tecnología': 'iit',
	u'Intervención (México D.F.)': 'inter',
	u'Investigaciones geográficas': 'igeo',
	u'Investigación bibliotecológica': 'ib',
	u'Investigación económica': 'ineco',
	u'Investigación en educación médica': 'iem',
	u'Isonomía': 'is',
	u'Journal of applied research and technology': 'jart',
	u'Journal of behavior health and social issues': 'jbhsi',
	u'Journal of behavior, health & social issues (México)': 'jbhsi',
	u'Journal of the Mexican Chemical Society': 'jmcs',
	u'La Ventana. Revista de estudios de género': 'laven',
	u'La ventana. Revista de estudios de género': 'laven',
	u'Latinoamérica. Revista de estudios Latinoamericanos': 'latinoam',
	u'LiminaR (Impresa)': 'liminar',
	u'LiminaR': 'liminar',
	u'Literatura mexicana': 'lm',
	u'Madera y bosques': 'mb',
	u'Mexican Law Review': 'mlr',
	u'Migraciones internacionales': 'migra',
	u'Migración y desarrollo': 'myd',
	u'Neumología y cirugía de toráx': 'nct',
	u'Neumología y cirugía de tórax': 'nct',
	u'Norteamérica': 'namerica',
	u'Nova scienta': 'ns',
	u'Nova tellus': 'novatell',
	u'Nueva antropología': 'na',
	u'Papeles de Población': 'pp',
	u'Papeles de población': 'pp',
	u'Península': 'peni',
	u'Perfiles educativos': 'peredu',
	u'Perfiles latinoamericanos': 'perlat',
	u'Perinatología y reproducción humana': 'prh',
	u'Polibits': 'poli',
	u'Polibotánica': 'polib',
	u'Polis (Impresa)': 'polis',
	u'Polis': 'polis',
	u'Política y cultura': 'polcul',
	u'Política y gobierno': 'pyg',
	u'Problemas del desarrollo': 'prode',
	u'Región y sociedad': 'regsoc',
	u'Relaciones (Zamora)': 'rz',
	u'Revista Chapingo. Serie ciencias forestales y del ambiente': 'rcscfa',
	u'Revista Chapingo. Serie horticultura': 'rcsh',
	u'Revista Chapingo. Serie: Horticultura': 'rcsh',
	u'Revista CONAMED': 'rconamed',
	u'Revista de educación bioquímica': 'reb',
	u'Revista de ingeniería sísmica': 'ris',
	u'Revista de investigación clínica': 'ric',
	u'Revista de investigación educativa de la escuela de graduados en educación': 'rieege',
	u'Revista de la educación superior': 'resu',
	u'Revista de la Facultad de Medicina (México)': 'facmed',
	u'Revista de la Falcultad de Medicina': 'facmed',
	u'Revista del Instituto Nacional de Enfermedades Respiratorias': 'iner',
	u'Revista Electrónica de Investigación Educativa': 'redie',
	u'Revista electrónica de investigación educativa': 'redie',
	u'Revista fitotecnia mexicana': 'rfm',
	u'Revista fitotecnica mexicana': 'rfm',
	u'Revista Iberoamericana de educación superior': 'ries',
	u'Revista iberoamericana de educación superior': 'ries',
	u'Revista internacional de contaminación ambiental': 'rica',
	u'Revista IUS': 'rius',
	u'Revista latinoamerica de química': 'rlq',
	u'Revista latinoamericana de investigación en matemática educativa': 'relime',
	u'Revista latinoamericana de química': 'rlq',
	u'Revista mexicana de análisis de la conducta': 'rmac',
	u'Revista mexicana de astronomía y ^astrofísica': 'rmaa',
	u'Revista mexicana de astronomía y astrofísica': 'rmaa',
	u'Revista mexicana de biodiversidad': 'rmbiodiv',
	u'Revista mexicana de cardiología': 'rmc',
	u'Revista mexicana de ciencias agrícolas': 'remexca',
	u'Revista mexicana de ciencias farmaceúticas': 'rmcf',
	u'Revista mexicana de ciencias forestales': 'remcf',
	u'Revista mexicana de ciencias geológicas': 'rmcg',
	u'Revista mexicana de ciencias pecuarias': 'rmcp',
	u'Revista mexicana de ciencias políticas y sociales': 'rmcps',
	u'Revista Mexicana de fitopatología': 'rmfi',
	u'Revista mexicana de fitopatología': 'rmfi',
	u'Revista mexicana de física E': 'rmfe',
	u'Revista mexicana de física': 'rmf',
	u'Revista mexicana de ingeniería biomédica': 'rmib',
	u'Revista mexicana de ingeniería química': 'rmiq',
	u'Revista mexicana de investigación educativa': 'rmie',
	u'Revista mexicana de micología': 'rmm',
	u'Revista mexicana de sociología': 'rms',
	u'Revista mexicana de transtornos alimentarios': 'rmta',
	u'Revista mexicana de trastornos alimentarios': 'rmta',
	u'Revista odontológica mexicana': 'rom',
	u'Salud mental': 'sm',
	u'Salud Pública de México': 'spm',
	u'Secuencia (Impresa)': 'secu',
	u'Secuencia': 'secu',
	u'Signos filosóficos': 'signosf',
	u'Signos históricos': 'sh',
	u'Sinéctica': 'sine',
	u'Sociológica (México)': 'soc',
	u'Superficies y vacío': 'sv',
	u'Tecnología y ciencias del agua': 'tca',
	u'Terra latinoamericana': 'tl',
	u'Therya': 'therya',
	u'TIP. Revista especializada en ciencias químico-biológicas': 'tip',
	u'Trashumante. Revista americana de historia social': 'trashu',
	u'Tropical and subtropical agroecosystems': 'tsa',
	u'Tzintzun': 'tzintzun',
	u'Tzintzun. Revista de estudios históricos': 'treh',
	u'Tópicos (México)': 'trf',
	u'Tópicos de Seminario': 'tods',
	u'Tópicos del seminario': 'tods',
	u'Tópicos. Revista de filosofía': 'trf',
	u'Universidad y ciencia': 'uc',
	u'Valenciana': 'valencia',
	u'Veterinaria México OA': 'vetmexoa',
	u'Veterinaria México': 'vetmex',
}

areaConacyt = {
	u'Agricultura, sociedad y desarrollo': u'Ciencias Sociales',
	u'Agrociencia': u'Biotecnología y Ciencias Agropecuarias',
	u'Alteridades': u'Humanidades y Ciencias de la Conducta',
	u'Andamios': u'Ciencias Sociales',
	u'Anuario mexicano de derecho internacional': u'Ciencias Sociales',
	u'Argumentos (México, D.F.)': u'Ciencias Sociales',
	u'Atmósfera': u'Físico, Matemáticas y Ciencias de la Tierra',
	u'Boletín de la Sociedad Geológica Mexicana': u'Físico, Matemáticas y Ciencias de la Tierra',
	u'Boletín mexicano de derecho comparado': u'Ciencias Sociales',
	u'Botanical Sciences': u'Biología y Química',
	u'Ciencias marinas': u'Físico, Matemáticas y Ciencias de la Tierra',
	u'Comunicación y sociedad': u'Ciencias Sociales',
	u'Contaduría y administración': u'Ciencias Sociales',
	u'Convergencia': u'Ciencias Sociales',
	u'Cuestiones constitucionales': u'Ciencias Sociales',
	u'Cuicuilco': u'Humanidades y Ciencias de la Conducta',
	u'Culturales': u'Ciencias Sociales',
	u'Desacatos': u'Humanidades y Ciencias de la Conducta',
	u'Diánoia': u'Humanidades y Ciencias de la Conducta',
	u'EconoQuantum': u'Ciencias Sociales',
	u'Economía, sociedad y territorio': u'Ciencias Sociales',
	u'Economía: teoría y práctica': u'Ciencias Sociales',
	u'Ecosistemas y recursos agropecuarios': u'Multidisciplinarias',
	u'Estudios de cultura maya': u'Humanidades y Ciencias de la Conducta',
	u'Estudios fronterizos': u'Ciencias Sociales',
	u'Estudios sociales (Hermosillo, Son.)': u'Ciencias Sociales',
	u'Frontera norte': u'Ciencias Sociales',
	u'Geofísica internacional': u'Físico, Matemáticas y Ciencias de la Tierra',
	u'Gestión y política pública': u'Ciencias Sociales',
	u'Hidrobiológica': u'Biología y Química',
	u'Ingeniería mecánica, tecnología y desarrollo': u'Ingenierías',
	u'Ingeniería, investigación y tecnología': u'Ingenierías',
	u'Investigaciones geográficas': u'Físico, Matemáticas y Ciencias de la Tierra',
	u'Investigación bibliotecológica': u'Ciencias Sociales',
	u'Isonomía': u'Ciencias Sociales',
	u'Journal of applied research and technology': u'Ingenierías',
	u'Journal of the Mexican Chemical Society': u'Biología y Química',
	u'Latinoamérica. Revista de estudios Latinoamericanos': u'Multidisciplinarias',
	u'LiminaR': u'Ciencias Sociales',
	u'Madera y bosques': u'Biotecnología y Ciencias Agropecuarias',
	u'Migraciones internacionales': u'Ciencias Sociales',
	u'Migración y desarrollo': u'Ciencias Sociales',
	u'Norteamérica': u'Ciencias Sociales',
	u'Nueva antropología': u'Ciencias Sociales',
	u'Papeles de población': u'Ciencias Sociales',
	u'Perfiles educativos': u'Humanidades y Ciencias de la Conducta',
	u'Perfiles latinoamericanos': u'Ciencias Sociales',
	u'Polibits': u'Ingenierías',
	u'Polibotánica': u'Biología y Química',
	u'Polis': u'Ciencias Sociales',
	u'Política y cultura': u'Humanidades y Ciencias de la Conducta',
	u'Política y gobierno': u'Ciencias Sociales',
	u'Problemas del desarrollo': u'Ciencias Sociales',
	u'Región y sociedad': u'Ciencias Sociales',
	u'Relaciones (Zamora)': u'Humanidades y Ciencias de la Conducta',
	u'Revista Chapingo. Serie ciencias forestales y del ambiente': u'Biotecnología y Ciencias Agropecuarias',
	u'Revista Chapingo. Serie horticultura': u'Biotecnología y Ciencias Agropecuarias',
	u'Revista electrónica de investigación educativa': u'Humanidades y Ciencias de la Conducta',
	u'Revista fitotecnia mexicana': u'Biotecnología y Ciencias Agropecuarias',
	u'Revista internacional de contaminación ambiental': u'Biología y Química',
	u'Revista latinoamericana de investigación en matemática educativa': u'Humanidades y Ciencias de la Conducta',
	u'Revista latinoamericana de química': u'Biología y Química',
	u'Revista mexicana de astronomía y astrofísica': u'Físico, Matemáticas y Ciencias de la Tierra',
	u'Revista mexicana de biodiversidad': u'Biología y Química',
	u'Revista mexicana de ciencias agrícolas': u'Biotecnología y Ciencias Agropecuarias',
	u'Revista mexicana de ciencias geológicas': u'Físico, Matemáticas y Ciencias de la Tierra',
	u'Revista mexicana de ciencias pecuarias': u'Biotecnología y Ciencias Agropecuarias',
	u'Revista mexicana de ciencias políticas y sociales': u'Ciencias Sociales',
	u'Revista mexicana de fitopatología': u'Biología y Química',
	u'Revista mexicana de física': u'Físico, Matemáticas y Ciencias de la Tierra',
	u'Revista mexicana de ingeniería química': u'Ingenierías',
	u'Revista mexicana de investigación educativa': u'Humanidades y Ciencias de la Conducta',
	u'Revista mexicana de micología': u'Biología y Química',
	u'Revista mexicana de sociología': u'Ciencias Sociales',
	u'Salud Pública de México': u'Medicina y Ciencias de la Salud',
	u'Secuencia': u'Humanidades y Ciencias de la Conducta',
	u'Signos filosóficos': u'Humanidades y Ciencias de la Conducta',
	u'Sinéctica': u'Humanidades y Ciencias de la Conducta',
	u'Sociológica (México)': u'Ciencias Sociales',
	u'Superficies y vacío': u'Físico, Matemáticas y Ciencias de la Tierra',
	u'Tzintzun': u'Humanidades y Ciencias de la Conducta',
	u'Tópicos del seminario': u'Humanidades y Ciencias de la Conducta',
	u'Valenciana': u'Humanidades y Ciencias de la Conducta',
	u'Veterinaria México': u'Biotecnología y Ciencias Agropecuarias'
}

docTypeDct = {
	u'periódico': 1,
	'livro': 2,
	'outro': 3,
	'anais': 4,
	'tese': 5
}


def open_file(path):
	global book, sheet, nrows, ncols
	book = xlrd.open_workbook(path)
	sheet = book.sheet_by_index(0)
	nrows = sheet.nrows
	ncols = sheet.ncols

def parse_number(value, pfloat = False):
	if value == '>10,0':
		return '\'{0}\''.format(value)
	if re.match(r'(^$|nan|-|inf)', '{0}'.format(value)) != None:
		return 'NULL'
	if pfloat:
		return float(value)
	return int(value)

def parse_null(value):
	if value == '':
		return 'NULL'
	return '\'{0}\''.format(value)

def parse_a01a(path):
	open_file(path)
	row_index = 7
	network=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		network = row_values[1].strip()
		if discartRow.match(network) == None and network in networkId:
			row_index += 1
			row_values_other = sheet.row_values(row_index)
			for (value, value2) in zip(row_values[3:-1], row_values_other[3:-1]):
				print "INSERT INTO \"networkDistribution\" VALUES ({0}, {1}, {2}, {3});".format(networkId[network], year, parse_number(value), parse_number(value2))
				year += 1
		row_index += 1

def parse_a01b(path):
	open_file(path)
	row_index = 7
	network=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		network = row_values[1].strip()
		if discartRow.match(network) == None and network in networkId:
			for value in row_values[2:]:
				print "UPDATE \"networkDistribution\" SET revistas={2} WHERE \"networkId\"={0} AND anio={1};".format(networkId[network], year, parse_number(value))
				year += 1
		row_index += 1

def parse_a01c(path):
	open_file(path)
	row_index = 7
	network=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		area=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				network = row_values[1].strip()
			if row_values[2] != '':
				area = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"networkArea\" VALUES ({0}, {1}, {2}, {3});".format(networkId[network], areaId[area], year, parse_number(value))
					year += 1
		row_index += 1

def parse_a01d(path):
	open_file(path)
	row_index = 7
	network=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		country=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				network = row_values[1].strip()
			if row_values[2] != '':
				country = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"networkAffiliation\" VALUES ({0}, '{1}', {2}, {3});".format(networkId[network], affiliationCountry[country], year, parse_number(value))
					year += 1
		row_index += 1

def parse_a02a(path):
	open_file(path)
	row_index = 7
	country=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		if discartRow.match(row_values[1]) == None:
			country = row_values[1].strip()
			for value in row_values[2:-1]:
				if isinstance(value, float):
					print "INSERT INTO \"affiliationDistribution\" VALUES('{0}', {1}, {2});".format(affiliationCountry[country], year, parse_number(value))
				year += 1
		row_index += 1

def parse_a02b(path):
	open_file(path)
	row_index = 7
	journal=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		country=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				journal = row_values[1].strip().replace('\'', '\\\'')
			if row_values[2] != '':
				country = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"journalAffiliation\" VALUES (E'{0}', '{1}', {2}, {3});".format(journal, affiliationCountry[country], year, parse_number(value))
					year += 1
		row_index += 1

def parse_a02c(path):
	open_file(path)
	row_index = 7
	publication=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		affiliation=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				publication = row_values[1].strip()
			if row_values[2] != '':
				affiliation = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"publicationAffiliation\" VALUES ('{0}', '{1}', {2}, {3});".format(affiliationCountry[publication], affiliationCountry[affiliation], year, parse_number(value))
					year += 1
		row_index += 1

def parse_a02d(path):
	open_file(path)
	row_index = 7
	area=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		country=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				area = row_values[1].strip()
			if row_values[2] != '':
				country = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"publicationAffiliation\" VALUES ({0}, '{1}', {2}, {3});".format(areaId[area], affiliationCountry[country], year, parse_number(value))
					year += 1
		row_index += 1

def parse_a03b(path):
	open_file(path)
	row_index = 7
	area=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		coautors=0
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				area = row_values[1].strip()
			if row_values[2] != '':
				coautors = int(row_values[2])
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"areaCoautor\" VALUES ({0}, {1}, {2}, {3});".format(areaId[area], coautors, year, parse_number(value))
					year += 1
		row_index += 1

def parse_b01a(path):
	open_file(path)
	row_index = 7
	network=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		journal=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				network = row_values[1].strip()
			if row_values[2] != '':
				journal = row_values[2].strip().replace('\'', '\\\'')
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"networkJournal\" VALUES ({0}, E'{1}', {2}, {3});".format(networkId[network], journal, year, parse_number(value))
					year += 1
		row_index += 1

def parse_b01b(path):
	open_file(path)
	row_index = 7
	network=''
	area=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		journal=''
		areaConacytIdL='NULL'
		neumonic='NULL'
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				network = row_values[1].strip()
			if row_values[2] != '':
				area = row_values[2].strip()
			if row_values[3] != '':
				journal = row_values[3].strip()
				if journal in neumonics:
					neumonic = '\'{0}\''.format(neumonics[journal])
				if journal in areaConacyt:
					areaConacytIdL = areaConacytId[areaConacyt[journal]]
				journal = journal.replace('\'', '\\\'')
				for value in row_values[4:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"networkAreasJournal\" VALUES ({0}, {1}, {2}, E'{3}', {4}, {5}, {6});".format(networkId[network], areaId[area], areaConacytIdL, journal, neumonic, year, parse_number(value))
					year += 1
		row_index += 1

def parse_b01c(path):
	open_file(path)
	row_index = 7
	indicator = {}
	while row_index < nrows:
		row_values = sheet.row_values(row_index)[1::]
		indicator = {
			'year': int(row_values[0]),
			'journal': row_values[1].strip().replace('\'', '\\\''),
			'networkId': 0,
			'fasciculos': parse_number(row_values[4]),
			'articulos': parse_number(row_values[5]),
			'referencias': parse_number(row_values[6]),
			'citas': parse_number(row_values[7]),
			'autocitacion': parse_number(row_values[8], True),
			'factorImpacto': parse_number(row_values[9], True),
			'inmediates': parse_number(row_values[10], True),
			'vidaMedia': parse_number(row_values[11], True),
		}
		query = "INSERT INTO \"indicadoresRevistaAnual\" VALUES(%(networkId)d, E'%(journal)s', %(year)d, %(fasciculos)s, %(articulos)s, %(referencias)s, %(citas)s, %(autocitacion)s, %(factorImpacto)s, %(inmediates)s, %(vidaMedia)s);"
		if row_values[2] in networkId:
			indicator['networkId'] = networkId[row_values[2]]
			print query % indicator
		if row_values[3] in networkId:
			indicator['networkId'] = networkId[row_values[3]]
			print query % indicator
		row_index += 1

def parse_c01a(path):
	open_file(path)
	row_index = 7
	rango=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		if discartRow.match(row_values[1]) == None:
			rango = row_values[1].strip()
			for value in row_values[2:-1]:
				if isinstance(value, float):
					print "INSERT INTO \"ageCitationDoc\" VALUES('{0}', {1}, {2});".format(rango, year, parse_number(value))
				year += 1
		row_index += 1

def parse_c01b(path):
	open_file(path)
	row_index = 7
	docType=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		if discartRow.match(row_values[1]) == None:
			docType = row_values[1].strip()
			for value in row_values[2:-1]:
				if isinstance(value, float):
					print "INSERT INTO \"typeCitationDoc\" VALUES({0}, {1}, {2});".format(docTypeDct[docType], year, parse_number(value))
				year += 1
		row_index += 1

def parse_c02a(path):
	open_file(path)
	row_index = 7
	journal=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		rango=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				journal = row_values[1].strip().replace('\'', '\\\'')
			if row_values[2] != '':
				rango = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"journalAgeCitationDoc\" VALUES (E'{0}', '{1}', {2}, {3});".format(journal, rango, year, parse_number(value))
					year += 1
		row_index += 1

def parse_c02b(path):
	open_file(path)
	row_index = 7
	journal=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		docType=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				journal = row_values[1].strip().replace('\'', '\\\'')
			if row_values[2] != '':
				docType = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"journalTypeCitationDoc\" VALUES (E'{0}', {1}, {2}, {3});".format(journal, docTypeDct[docType], year, parse_number(value))
					year += 1
		row_index += 1

def parse_c03a(path):
	open_file(path)
	row_index = 8
	area=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		rango=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				area = row_values[1].strip()
			if row_values[2] != '':
				rango = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"areaAgeCitationDoc\" VALUES ({0}, '{1}', {2}, {3});".format(areaId[area], rango, year, parse_number(value))
					year += 1
		row_index += 1

def parse_c03b(path):
	open_file(path)
	row_index = 7
	area=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		docType=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				area = row_values[1].strip()
			if row_values[2] != '':
				docType = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"areaTypeCitationDoc\" VALUES ({0}, {1}, {2}, {3});".format(areaId[area], docTypeDct[docType], year, parse_number(value))
					year += 1
		row_index += 1

def parse_c03c(path):
	open_file(path)
	row_index = 7
	area=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		journal=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				area = row_values[1].strip()
			if row_values[2] != '':
				journal = row_values[2].strip().replace('\'', '\\\'')
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"areaCiatationJournal\" VALUES ({0}, E'{1}', {2}, {3});".format(areaId[area], journal, year, parse_number(value))
					year += 1
		row_index += 1

def parse_c04a(path):
	open_file(path)
	row_index = 7
	country=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		rango=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				country = row_values[1].strip()
			if row_values[2] != '':
				rango = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"affiliationAgeCitationDoc\" VALUES ('{0}', '{1}', {2}, {3});".format(affiliationCountry[country], rango, year, parse_number(value))
					year += 1
		row_index += 1

def parse_c04b(path):
	open_file(path)
	row_index = 7
	country=''
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		docType=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				country = row_values[1].strip()
			if row_values[2] != '':
				docType = row_values[2].strip()
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "INSERT INTO \"affiliationTypeCiationDoc\" VALUES ('{0}', {1}, {2}, {3});".format(affiliationCountry[country], docTypeDct[docType], year, parse_number(value))
					year += 1
		row_index += 1

def parse_c04c(path):
	open_file(path)
	row_index = 7
	country=''
	print "INSERT INTO \"afiliationCitationJournal\""
	while row_index < nrows:
		row_values = sheet.row_values(row_index)
		year=2000
		journal=''
		if discartRow.match(row_values[1]) == None:
			if row_values[1] != '':
				country = row_values[1].strip()
			if row_values[2] != '':
				journal = row_values[2].strip().replace('\'', '\\\'')
				for value in row_values[3:-1]:
					if isinstance(value, float):
						print "\tVALUES ('{0}', E'{1}', {2}, {3}),".format(affiliationCountry[country], journal, year, parse_number(value))
					year += 1
		row_index += 1
basePath = ""

# path = basePath + "/Publicacion/Números da Rede SciELO por/A01a_pt Ano de publicação.xls"
# path = basePath + "/Publicacion/Números da Rede SciELO por/A01b_pt Periódico.xls"
# path = basePath + "/Publicacion/Números da Rede SciELO por/A01c_pt Assunto.xls"
# path = basePath + "/Publicacion/Números da Rede SciELO por/A01d_pt País de afiliação do autor.xls"

# path = basePath + "/Publicacion/País de Afiliação do Autor por/A02a_pt Ano de publicação.xls"
# path = basePath + "/Publicacion/País de Afiliação do Autor por/A02b_pt Periódico.xls"
# path = basePath + "/Publicacion/País de Afiliação do Autor por/A02c_pt País de publicação da revista.xls"
# path = basePath + "/Publicacion/País de Afiliação do Autor por/A02d_pt Assunto.xls"

# path = basePath + "/Publicacion/Número de Co-autores por/A03a_pt Periódico.xls"
# path = basePath + "/Publicacion/Número de Co-autores por/A03b_pt Assunto.xls"

# path = basePath + "/Coleccion/Periódico por/B01a_pt Ano de publicação.xls"
# path = basePath + "/Coleccion/Periódico por/B01b_pt Assunto.xls"
# path = basePath + "/Coleccion/Periódico por/B01c_pt Indicadores gerais.xls"

# path = basePath + "/Citacion/Ano de Citação por/C01a_pt Idade do documento citado.xls"
# path = basePath + "/Citacion/Ano de Citação por/C01b_pt Tipo de documento citado.xls"

# path = basePath + "/Citacion/Periódico Citante por/C02a_pt Idade do documento citado.xls"
# path = basePath + "/Citacion/Periódico Citante por/C02b_pt Tipo de documento citado.xls"

# path = basePath + "/Citacion/Assunto do Periódico Citante por/C03a_pt Idade do documento citado.xls"
# path = basePath + "/Citacion/Assunto do Periódico Citante por/C03b_pt Tipo de documento citado.xls"
# path = basePath + "/Citacion/Assunto do Periódico Citante por/C03c_pt Periódico SciELO citado.xls"

# path = basePath + "/Citacion/País de Afiliação do Autor Citante por/C04a_pt Idade do documento citado.xls"
# path = basePath + "/Citacion/País de Afiliação do Autor Citante por/C04b_pt Tipo de documento citado.xls"
path = basePath + "/Citacion/País de Afiliação do Autor Citante por/C04c_pt Periódico SciELO citado.xls"

parse_c04c(path)


