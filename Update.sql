TRUNCATE TABLE articulo;
COPY articulo(
	iddatabase,
	sistema,
	e_008,
	e_022,
	e_035,
	e_036,
	e_041,
	e_222,
	e_245,
	e_260b,
	e_300a,
	e_300b,
	e_300c,
	e_300e,
	e_504,
	e_546,
	e_590a,
	e_590b,
	e_698,
	e_856u) FROM '/home/herz/Sites/biblat/clase/articulo.txt' (FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');


COPY articulo(
	iddatabase,
	sistema,
	e_008,
	e_022,
	e_035,
	e_036,
	e_041,
	e_222,
	e_245,
	e_260b,
	e_300a,
	e_300b,
	e_300c,
	e_300e,
	e_504,
	e_546,
	e_590a,
	e_590b,
	e_698,
	e_856u) FROM '/home/herz/Sites/biblat/periodica/articulo.txt' (FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8')

TRUNCATE TABLE artidisciplina;
COPY artidisciplina 
FROM '/home/herz/Sites/biblat/clase/artitema.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

COPY artidisciplina 
FROM '/home/herz/Sites/biblat/periodica/artitema.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/"[01]";"[0-9]+?";"[0-9]+?";("[^0-9]"|NULL)/d' clase/autor.txt > autor.txt && mv autor.txt clase/autor.txt
TRUNCATE TABLE autor;
COPY autor(iddatabase,sistema,sec_autor,sec_institucion,st_institucion,etiqueta,e_100a,e_1006) 
FROM '/home/herz/Sites/biblat/clase/autor.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/"[01]";"[0-9]+?";"[0-9]+?";("[^0-9]"|NULL)/d' periodica/autor.txt > autor.txt && mv autor.txt periodica/autor.txt
COPY autor(iddatabase,sistema,sec_autor,sec_institucion,st_institucion,etiqueta,e_100a,e_1006) 
FROM '/home/herz/Sites/biblat/periodica/autor.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/"[01]";"[0-9]+?";"[0-9]+?";("[^0-9]"|NULL)/d' clase/institucion.txt > institucion.txt && mv institucion.txt clase/institucion.txt
TRUNCATE TABLE institucion;
COPY institucion(iddatabase,sistema,sec_autor,sec_institucion,e_100u,e_100v,e_100w,e_100x,etiqueta) 
FROM '/home/herz/Sites/biblat/clase/institucion.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/"[01]";"[0-9]+?";"[0-9]+?";("[^0-9]"|NULL)/d' periodica/institucion.txt > institucion.txt && mv institucion.txt periodica/institucion.txt
COPY institucion(iddatabase,sistema,sec_autor,sec_institucion,e_100u,e_100v,e_100w,e_100x,etiqueta) 
FROM '/home/herz/Sites/biblat/periodica/institucion.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

TRUNCATE TABLE palabraclave;
COPY palabraclave 
FROM '/home/herz/Sites/biblat/clase/palabraclave.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/;NULL$/d' periodica/palabraclave.txt > palabraclave.txt && mv palabraclave.txt periodica/palabraclave.txt
COPY palabraclave 
FROM '/home/herz/Sites/biblat/periodica/palabraclave.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/;NULL$/d' periodica/keyword.txt > keyword.txt && mv keyword.txt periodica/keyword.txt
TRUNCATE TABLE keyword;
COPY keyword 
FROM '/home/herz/Sites/biblat/periodica/keyword.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--Actualizacion de datos
TRUNCATE TABLE aleph_tags;
	COPY aleph_tags(
		"008",
		"022",
		"024",
		"035",
		"036",
		"039",
		"041",
		"100",
		"110",
		"120",
		"222",
		"245",
		"260",
		"300",
		"504",
		"520",
		"546",
		"590",
		"650",
		"653",
		"654",
		"698",
		"856") 
	FROM '/home/herz/Sites/biblat/claperJSON.txt' (FORMAT 'csv', DELIMITER ',', NULL 'NULL', QUOTE '''', ESCAPE E'\\', ENCODING 'UTF8');


TRUNCATE TABLE article;
	COPY article
	FROM '/home/herz/Sites/biblat/articuloCLAPER.txt' (FORMAT 'csv', DELIMITER ',', NULL 'NULL', QUOTE '''', ESCAPE E'\\', ENCODING 'UTF8');

#egrep -v ".+?,('[0-9]+?'|NULL)$" autorCLAPER.txt > autorCLAPER_error.txt && sed -i.bak -E -e "/.+?,('[0-9]+?'|NULL)$/\!d" autorCLAPER.txt && rm autorCLAPER.txt.bak
TRUNCATE TABLE author;
	COPY author
	FROM '/home/herz/Sites/biblat/autorCLAPER.txt' (FORMAT 'csv', DELIMITER ',', NULL 'NULL', QUOTE '''', ESCAPE E'\\', ENCODING 'UTF8');
#egrep -v "'.+?','[0-9]+?',.+?$" institucionCLAPER.txt > institucionCLAPER_error.txt
TRUNCATE TABLE institution;
	COPY institution
	FROM '/home/herz/Sites/biblat/institucionCLAPER.txt' (FORMAT 'csv', DELIMITER ',', NULL 'NULL', QUOTE '''', ESCAPE E'\\', ENCODING 'UTF8');
