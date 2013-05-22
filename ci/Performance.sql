/*Extensiones*/
CREATE extension pg_trgm ;
/*Slug functions*/
CREATE OR REPLACE FUNCTION slug(texto character varying)
  RETURNS character varying AS
$BODY$
DECLARE
    result varchar;
BEGIN
    result := regexp_replace(translate(replace(lower(texto), ' ', '-'),
        'áàâãäåāăąÁÂÃÄÅĀĂĄèééêëēĕėęěĒĔĖĘĚìíîïìĩīĭÌÍÎÏÌĨĪĬóôõöōŏőÒÓÔÕÖŌŎŐùúûüũūŭůÙÚÛÜŨŪŬŮçÇÿ&,.ñÑŠšŽžÝÞßøýþ',
        'aaaaaaaaaaaaaaaaaeeeeeeeeeeeeeeeiiiiiiiiiiiiiiiiooooooooooooooouuuuuuuuuuuuuuuuccy---nnsszzybsoyb'), E'[^\\w -]', '', 'g');
	
    result := regexp_replace(result, '-+', '-', 'g');
    result := regexp_replace(result, '-$', '', 'g');
    RETURN result;
END;
$BODY$
  LANGUAGE plpgsql IMMUTABLE
  COST 100;

CREATE OR REPLACE FUNCTION slug_space(texto character varying)
  RETURNS character varying AS
$BODY$
DECLARE
    result varchar;
BEGIN
    result := slug(texto);
    result := regexp_replace(result, '-', ' ', 'g');
    RETURN result;
END;
$BODY$
  LANGUAGE plpgsql IMMUTABLE
  COST 100;
/*Otimizar consultas con LIKE*/
CREATE EXTENSION pg_trgm;

/*Funciones para contar los años continuos*/
CREATE OR REPLACE FUNCTION array_sort (ANYARRAY)
RETURNS ANYARRAY LANGUAGE SQL
AS $$
SELECT ARRAY(SELECT unnest($1) ORDER BY 1)
$$


CREATE OR REPLACE FUNCTION anios_continuos(in_array text[])
  RETURNS integer AS
$$
DECLARE
i integer;
t text;
continuos integer;
maxcontinuo integer;
BEGIN
  continuos=1;
  maxcontinuo=1;
  in_array = array_sort(in_array);
  FOR i IN SELECT generate_subscripts( in_array, 1 ) LOOP
    IF in_array[ i + 1] IS NOT NULL
    THEN  
      IF in_array[ i + 1]::integer = in_array[i]::integer + 1
      THEN
        continuos=continuos + 1;
      ELSE
        continuos=1;
      END IF;
      maxcontinuo= GREATEST(maxcontinuo, continuos);
    END IF;
  END loop;
  RETURN maxcontinuo;
END;
$$
  LANGUAGE plpgsql;

/*Actualización de datos*/
/*articulo*/
UPDATE articulo SET e_008=NULL WHERE e_008='';
UPDATE articulo SET e_022=NULL WHERE e_022='';
UPDATE articulo SET e_041=NULL WHERE e_041='';
UPDATE articulo SET e_300a=NULL WHERE e_300a='';
UPDATE articulo SET e_300b=NULL WHERE e_300b='';
UPDATE articulo SET e_300c=NULL WHERE e_300c='';
UPDATE articulo SET e_300e=NULL WHERE e_300e='';
UPDATE articulo SET e_504=NULL WHERE e_504='';
UPDATE articulo SET e_546=NULL WHERE e_546='';
UPDATE articulo SET e_856u=NULL WHERE e_856u='';
UPDATE articulo SET id_disciplina=NULL WHERE id_disciplina<1;
/*Normalizando paises*/

UPDATE articulo SET e_008='México' WHERE e_008='Mexico' OR e_008='Mèxico';
/*Indices para optimizar las consultas*/
CREATE INDEX "articuloTextoCompleto_idx" ON articulo(e_856u);	
CREATE INDEX "articuloAlfabetico_idx" ON articulo(substring(LOWER(e_222), 1, 1));
CREATE INDEX "articuloHevila_idx" ON articulo USING gin(e_856u gin_trgm_ops);

REINDEX TABLE articulo;

VACUUM (VERBOSE, FULL) articulo;

/*autor*/
UPDATE autor SET e_1006=NULL WHERE e_1006='';
ALTER TABLE	autor ADD COLUMN slug varchar;
UPDATE autor SET slug=slug(e_100a);

CREATE INDEX "autorSlug_idx" ON autor(slug);
CREATE INDEX "autorSlugE100a_idx" ON autor(slug, e_100a);

VACUUM (VERBOSE, FULL) autor;

/*disciplinas*/
ALTER TABLE disciplinas ADD COLUMN slug varchar;
UPDATE disciplinas SET slug=slug(disciplina);

VACUUM (VERBOSE, FULL) disciplinas;

/*Instituciones*/

UPDATE institucion SET e_100x=NULL WHERE e_100x='';
UPDATE institucion SET e_100x='México' WHERE e_100x='Mëxico';
UPDATE institucion SET e_100x='Japón' WHERE e_100x='Japòn';

VACUUM (VERBOSE, FULL) institucion;


/**/

SELECT sum(totalautores) AS totalautores
FROM
  (SELECT distinct(autores),
          count(*) AS articulos,
          count(*)*autores AS totalautores
   FROM $tabla i
   INNER JOIN articulo t ON (i.iddatabase=t.iddatabase
                             AND i.sistema=t.sistema)
   WHERE t.e_222 LIKE '$revista'
     AND i.e_260b >'$ini'
     AND i.e_260b <'$fin'
     AND i.e_100x IS NOT NULL
   GROUP BY autores) AS total
