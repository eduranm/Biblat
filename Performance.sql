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
        'áàâãäåāăąÁÂÃÄÅĀĂĄèééêëēĕėęěĒĔĖĘĚìíîïìĩīĭÌÍÎÏÌĨĪĬóôõöōŏőÒÓÔÕÖŌŎŐùúûüũūŭůÙÚÛÜŨŪŬŮçÇÿ&,.ñÑŠšşŞŽžÝÞßøýþ"',
        'aaaaaaaaaaaaaaaaaeeeeeeeeeeeeeeeiiiiiiiiiiiiiiiiooooooooooooooouuuuuuuuuuuuuuuuccy---nnsssszzybsoyb'), E'[^\\w -]', '', 'g');
	
    result := regexp_replace(result, '-+', '-', 'g');
    result := regexp_replace(result, '-$', '', 'g');
    result := regexp_replace(result, '^-', '', 'g');
    RETURN NULLIF(result, '');
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
    RETURN NULLIF(result, '');
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
UPDATE articulo SET e_222=NULL WHERE e_222='';
UPDATE articulo SET id_disciplina=NULL WHERE id_disciplina<1;
UPDATE articulo SET e_222='Psicologia: reflexao e critica' WHERE e_222 in ('Psicologia: Reflexao e critica', 'Psicologia: Reflexão e Crítica');
UPDATE articulo SET e_222='Revista de economía política' WHERE e_222='Revista de economia politica';
UPDATE articulo SET e_222='Revista de la Facultad de Farmacia de la Universidad de los Andes' WHERE e_222='Revista de la Facultad de Farmacia de la Universidad de Los Andes';
UPDATE articulo SET e_222='Sociedade e estado' WHERE e_222='Sociedade e Estado';
UPDATE articulo SET e_222='Utopía y praxis latinoamericana' WHERE e_222='Utopía y Praxis Latinoamericana';

UPDATE articulo SET e_008='Colombia' WHERE e_222='Academia. Revista latinoamericana de administración';
UPDATE articulo SET e_008='Argentina' WHERE e_222='Andes (Salta)';
UPDATE articulo SET e_008='Venezuela' WHERE e_222='Antropológica (Caracas)';
UPDATE articulo SET e_008='Bolivia' WHERE e_222='Anuario de estudios bolivarianos';
UPDATE articulo SET e_008='Brasil' WHERE e_222='BAR. Brazilian administration review';
UPDATE articulo SET e_008='Colombia' WHERE e_222='Boletín de ciencias de la tierra';
UPDATE articulo SET e_008='Brasil' WHERE e_222='Cadernos da FUCAMP';
UPDATE articulo SET e_008='México' WHERE e_222='Ciencia UANL';
UPDATE articulo SET e_008='Argentina' WHERE e_222='Cuadernos del CISH. Sociohistórica';
UPDATE articulo SET e_008='México' WHERE e_222='Cuadernos universitarios (La Paz, B.C.S.)';
UPDATE articulo SET e_008='Venezuela' WHERE e_222='Entre lenguas';
UPDATE articulo SET e_008='Venezuela' WHERE e_222='Episteme NS';
UPDATE articulo SET e_008='Brasil' WHERE e_222='Estudos economicos - Instituto de Pesquisas Economicas';
UPDATE articulo SET e_008='Colombia' WHERE e_222='Fronteras de la historia';
UPDATE articulo SET e_008='México' WHERE e_222='Gaceta médica de México';
UPDATE articulo SET e_008='Costa Rica' WHERE e_222='Humanitas. Revista de investigación';
UPDATE articulo SET e_008='Venezuela' WHERE e_222='Interciencia';
UPDATE articulo SET e_008='Brasil' WHERE e_222='Jornal de psicanalise';
UPDATE articulo SET e_008='Barbados' WHERE e_222='Journal of Eastern Caribbean studies';
UPDATE articulo SET e_008='Colombia' WHERE e_222='Lecturas de economía';
UPDATE articulo SET e_008='Brasil' WHERE e_222='Natureza & conservacao';
UPDATE articulo SET e_008='México' WHERE e_222='Nuestra América. Serie';
UPDATE articulo SET e_008='Venezuela' WHERE e_222='Nueva sociedad';
UPDATE articulo SET e_008='Colombia' WHERE e_222='Palobra (Cartagena)';
UPDATE articulo SET e_008='Brasil' WHERE e_222='Papeis avulsos de zoologia';
UPDATE articulo SET e_008='Venezuela' WHERE e_222='Revista de ciencias sociales - Universidad del Zulia';
UPDATE articulo SET e_008='Colombia' WHERE e_222='Revista de ingeniería. Universidad de los Andes';
UPDATE articulo SET e_008='Venezuela' WHERE e_222='Revista del CLAD Reforma y democracia';
UPDATE articulo SET e_008='Argentina' WHERE e_222='Revista de nefrología, diálisis y transplante';
UPDATE articulo SET e_008='Colombia' WHERE e_222='Revista educación en ingeniería';
UPDATE articulo SET e_008='Colombia' WHERE e_222='Revista latinoamericana de ciencias sociales, niñez y juventud';
UPDATE articulo SET e_008='Venezuela' WHERE e_222='Revista latinoamericana de hipertensión';
UPDATE articulo SET e_008='Brasil' WHERE e_222='Transinformacao';

UPDATE articulo SET e_008='México' WHERE e_222='Revista geográfica (México, D.F.)';
UPDATE articulo SET e_008='Internacional' WHERE e_222='Revista interamericana de psicología';

/*Normalizando paises*/

UPDATE articulo SET e_008='México' WHERE e_008='Mexico' OR e_008='Mèxico';
ALTER TABLE articulo ADD COLUMN "revistaSlug" varchar;
ALTER TABLE articulo ADD COLUMN "e_698" varchar;
UPDATE articulo SET "revistaSlug"=slug(e_222);
UPDATE articulo a SET id_disciplina=d.id_disciplina 
  FROM disciplinas d WHERE slug(a.e_698)=d.slug;
/*Indices para optimizar las consultas*/
CREATE INDEX "articuloTextoCompleto_idx" ON articulo(e_856u);	
CREATE INDEX "articuloAlfabetico_idx" ON articulo(substring(LOWER(e_222), 1, 1));
CREATE INDEX "articuloHevila_idx" ON articulo USING gin(e_856u gin_trgm_ops);

REINDEX TABLE articulo;

VACUUM (VERBOSE, FULL) articulo;

/*autor*/
UPDATE autor SET e_1006=NULL WHERE e_1006='';
UPDATE autor SET e_100a=NULL WHERE e_100a='';
ALTER TABLE	autor ADD COLUMN slug varchar;
UPDATE autor SET slug=slug(e_100a);

CREATE INDEX "autorSlug_idx" ON autor(slug);
CREATE INDEX "autorSlugE100a_idx" ON autor(slug, e_100a);
CREATE INDEX "idx_autorDSAI" ON autor(iddatabase, sistema, sec_autor, sec_institucion);

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
UPDATE institucion SET e_100u=regexp_replace(e_100u, '(.+?)(,$|$)', '\1');
UPDATE institucion SET e_100x=regexp_replace(e_100x, '(.+?)(,$|\.$|$)', '\1');

ALTER TABLE institucion ADD COLUMN slug varchar;
UPDATE institucion SET slug=slug(e_100u);

ALTER TABLE institucion ADD COLUMN "paisInstitucionSlug" varchar;
UPDATE institucion SET "paisInstitucionSlug"=slug(e_100x);

CREATE INDEX "idx_institucionDSAI" ON institucion(iddatabase, sistema, sec_autor, sec_institucion);
CREATE INDEX ON institucion(iddatabase, sistema);
CREATE INDEX ON institucion(slug); 

VACUUM (VERBOSE, FULL) institucion;

--Revidisciplinas
ALTER TABLE rev_disciplinas ADD COLUMN "revistaSlug" varchar;
UPDATE rev_disciplinas SET "revistaSlug"=slug(revista);

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

--Lista blanca de revistas con 5 años consutivos y al menos 5 articulos
SELECT * FROM 
(SELECT "revistaSlug", anios_continuos(array_agg(anio)) AS anios_continuos
FROM 
(SELECT 
"revistaSlug", 
anio, 
count(*) AS articulos 
FROM "vArticulos" GROUP BY "revistaSlug", anio HAVING count(*) > 4) tb1 
GROUP BY "revistaSlug") tb2 WHERE anios_continuos > 4