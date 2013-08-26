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
UPDATE articulo SET e_222='Bioquimia' WHERE e_222='Bioquimía';
UPDATE articulo SET e_222='Anales del Instituto de Biología. UNAM. Serie zoología' WHERE e_222='Anales del Instituto de Biología. UNAM. Serie Zoología';
UPDATE articulo SET e_222='Civitas. Revista de ciencias sociais' WHERE e_222='Civitas. Revista de ciencias sociais,';
UPDATE articulo SET e_222='Cognitio. Revista de filosofia' WHERE e_222='Cognitio. Revista de Filosofia';
UPDATE articulo SET e_222='Conjuntura economica (Rio de Janeiro)' WHERE e_222='Conjuntura económica (Rio de Janeiro)';
UPDATE articulo SET e_222='Enseñanza e investigación en psicología' WHERE e_222='Enseñanza e investigación en Psicología';
UPDATE articulo SET e_222='Estudios - Instituto Tecnológico Autónomo de México' WHERE e_222='Estudios - Instituto Tecnológico Autónomo de México,';
UPDATE articulo SET e_222='Estudos de psicologia (Natal)' WHERE e_222='Estudos de Psicologia (Natal)';
UPDATE articulo SET e_222='GénEros' WHERE e_222='Géneros';
UPDATE articulo SET e_222='Journal of Eastern Caribbean studies' WHERE e_222='Journal of eastern caribbean studies';
UPDATE articulo SET e_222='Novos estudos - CEBRAP' WHERE e_222='Novos Estudos - CEBRAP';
UPDATE articulo SET e_222='Psicologia: reflexao e critica' WHERE e_222 in ('Psicologia: Reflexao e critica', 'Psicologia: Reflexão e Crítica');
UPDATE articulo SET e_222='Revista brasileira de educacao' WHERE e_222='Revista Brasileira de Educação';
UPDATE articulo SET e_222='Revista brasileira de reumatologia' WHERE e_222='Revista Brasileira de Reumatologia';
UPDATE articulo SET e_222='Revista de economía política' WHERE e_222='Revista de economia politica';
UPDATE articulo SET e_222='Revista de extensión cultural - Universidad Nacional de Colombia' WHERE e_222='Revista de Extensión Cultural - Universidad Nacional de Colombia';
UPDATE articulo SET e_222='Revista de la Facultad de Farmacia de la Universidad de los Andes' WHERE e_222='Revista de la Facultad de Farmacia de la Universidad de Los Andes';
UPDATE articulo SET e_222='Revista médica del Instituto Mexicano del Seguro Social' WHERE e_222='Revista médica del Instituto Mexicano del Seguro Social,';
UPDATE articulo SET e_222='Revista mexicana de orientación educativa' WHERE e_222='Revista Mexicana de Orientación Educativa';
UPDATE articulo SET e_222='Sao Paulo em perspectiva' WHERE e_222='São Paulo em Perspectiva';
UPDATE articulo SET e_222='Sociedade e estado' WHERE e_222='Sociedade e Estado';
UPDATE articulo SET e_222='Symposium - Universidade Catolica de Pernambuco' WHERE e_222='Symposium - Universidade Católica de Pernambuco';
UPDATE articulo SET e_222='Utopía y praxis latinoamericana' WHERE e_222='Utopía y Praxis Latinoamericana';

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
UPDATE institucion SET e_100u=NULL WHERE e_100u='';
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
