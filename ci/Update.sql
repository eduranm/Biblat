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


COPY artidisciplina 
FROM '/home/herz/Sites/biblat/clase/artitema.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

COPY artidisciplina 
FROM '/home/herz/Sites/biblat/periodica/artitema.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/"[01]";"[0-9]+?";"[0-9]+?";("[^0-9]"|NULL)/d' clase/autor.txt > autor.txt
COPY autor(iddatabase,sistema,sec_autor,sec_institucion,st_institucion,etiqueta,e_100a,e_1006) 
FROM '/home/herz/Sites/biblat/clase/autor.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/"[01]";"[0-9]+?";"[0-9]+?";("[^0-9]"|NULL)/d' periodica/autor.txt > autor.txt
COPY autor(iddatabase,sistema,sec_autor,sec_institucion,st_institucion,etiqueta,e_100a,e_1006) 
FROM '/home/herz/Sites/biblat/periodica/autor.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/"[01]";"[0-9]+?";"[0-9]+?";("[^0-9]"|NULL)/d' clase/institucion.txt > institucion.txt
COPY institucion(iddatabase,sistema,sec_autor,sec_institucion,e_100u,e_100v,e_100w,e_100x,etiqueta) 
FROM '/home/herz/Sites/biblat/clase/institucion.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/"[01]";"[0-9]+?";"[0-9]+?";("[^0-9]"|NULL)/d' periodica/institucion.txt > institucion.txt
COPY institucion(iddatabase,sistema,sec_autor,sec_institucion,e_100u,e_100v,e_100w,e_100x,etiqueta) 
FROM '/home/herz/Sites/biblat/periodica/institucion.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');


COPY palabraclave 
FROM '/home/herz/Sites/biblat/clase/palabraclave.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/;NULL$/d' periodica/palabraclave.txt > palabraclave.txt
COPY palabraclave 
FROM '/home/herz/Sites/biblat/periodica/palabraclave.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');

--sed -E -e '/;NULL$/d' periodica/keyword.txt > keyword.txt
COPY keyword 
FROM '/home/herz/Sites/biblat/periodica/keyword.txt'
(FORMAT 'csv', DELIMITER ';', NULL 'NULL', QUOTE '"', ESCAPE E'\\', ENCODING 'UTF8');


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
	FROM '/home/herz/Sites/biblat/periodicaJSON.txt' (FORMAT 'csv', DELIMITER ',', NULL 'NULL', QUOTE '''', ESCAPE E'\\', ENCODING 'UTF8')