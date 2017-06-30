TRUNCATE TABLE article CASCADE;
COPY article
	FROM '/Users/herz/Sites/biblat/database/articuloCLAPER.txt' (FORMAT 'csv', DELIMITER ',', NULL 'NULL', QUOTE '''', ESCAPE E'\\', ENCODING 'UTF8');

--egrep -v "'.+?','[0-9]+?',.+?$" institucionCLAPER.txt > institucionCLAPER_error.txt && gsed -i.bak -E -e "/'.+?','[0-9]+?',.+?$/\!d" institucionCLAPER.txt && rm institucionCLAPER.txt.bak
TRUNCATE TABLE institution;
COPY institution (sistema, id, institucion, dependencia, ciudad, pais)
	FROM '/Users/herz/Sites/biblat/database/institucionCLAPER.txt' (FORMAT 'csv', DELIMITER ',', NULL 'NULL', QUOTE '''', ESCAPE E'\\', ENCODING 'UTF8');
UPDATE institution SET slug=slug(institucion);
UPDATE institution SET "paisInstitucionSlug"=slug(pais);

--egrep -v ".+?,('[0-9]+?'|NULL)$" autorCLAPER.txt > autorCLAPER_error.txt && gsed -i.bak -E -e "/.+?,('[0-9]+?'|NULL)$/\!d" autorCLAPER.txt && rm autorCLAPER.txt.bak
TRUNCATE TABLE author;
COPY author (sistema, id, nombre, email, "institucionId")
	FROM '/Users/herz/Sites/biblat/database/autorCLAPER.txt' (FORMAT 'csv', DELIMITER ',', NULL 'NULL', QUOTE '''', ESCAPE E'\\', ENCODING 'UTF8');
UPDATE author SET slug=slug(nombre);

TRUNCATE TABLE catalogador;
COPY catalogador
	FROM '/Users/herz/Sites/biblat/database/catalogadorCLAPER.txt' (FORMAT 'csv', DELIMITER ',', NULL 'NULL', QUOTE '''', ESCAPE E'\\', ENCODING 'UTF8');


--TODO ejecutar solo al importar registros de SciELO, temponral!
--SELECT * FROM article WHERE substr("descripcionBibliografica"::text, 1, 1)='[';
--SELECT * FROM article WHERE substr("documento"::text, 1, 1)='[';
--SELECT * FROM article WHERE substr("descripcionBibliografica"::text, 1, 1)='[' OR substr("documento"::text, 1, 1)='[';

