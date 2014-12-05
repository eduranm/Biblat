CREATE TABLE matviews
(
  mv_name name NOT NULL,
  v_name name NOT NULL,
  last_refresh timestamp with time zone,
  CONSTRAINT matviews_pkey PRIMARY KEY (mv_name )
);

CREATE OR REPLACE FUNCTION create_matview(NAME, NAME)
 RETURNS VOID
 SECURITY DEFINER
 LANGUAGE plpgsql AS '
 DECLARE
     matview ALIAS FOR $1;
     view_name ALIAS FOR $2;
     entry matviews%ROWTYPE;
 BEGIN
     SELECT * INTO entry FROM matviews WHERE mv_name = matview;
 
     IF FOUND THEN
         RAISE EXCEPTION ''Materialized view ''''%'''' already exists.'',
           matview;
     END IF;
 
     EXECUTE ''REVOKE ALL ON '' || view_name || '' FROM PUBLIC''; 
 
     EXECUTE ''GRANT SELECT ON '' || view_name || '' TO PUBLIC'';
 
     EXECUTE ''CREATE TABLE '' || matview || '' AS SELECT * FROM '' || view_name;
 
     EXECUTE ''REVOKE ALL ON '' || matview || '' FROM PUBLIC'';
 
     EXECUTE ''GRANT SELECT ON '' || matview || '' TO PUBLIC'';
 
     INSERT INTO matviews (mv_name, v_name, last_refresh)
       VALUES (matview, view_name, CURRENT_TIMESTAMP); 
     
     RETURN;
 END';

 CREATE OR REPLACE FUNCTION drop_matview(NAME) RETURNS VOID
 SECURITY DEFINER
 LANGUAGE plpgsql AS '
 DECLARE
     matview ALIAS FOR $1;
     entry matviews%ROWTYPE;
 BEGIN
 
     SELECT * INTO entry FROM matviews WHERE mv_name = matview;
 
     IF NOT FOUND THEN
         RAISE EXCEPTION ''Materialized view % does not exist.'', matview;
     END IF;
 
     EXECUTE ''DROP TABLE '' || matview;
     DELETE FROM matviews WHERE mv_name=matview;
 
     RETURN;
 END';

CREATE OR REPLACE FUNCTION indexes_matview(name)
  RETURNS void AS
$BODY$
DECLARE 
  matview ALIAS FOR $1;
  index_matview RECORD;
  indexes_matview text[];
  i integer;
BEGIN
  SELECT array_agg(indexdef) INTO indexes_matview FROM pg_indexes WHERE tablename='mvIndiceCoautoriaPricePais';
  RAISE NOTICE 'indexes_matview: %', indexes_matview;
  FOR i IN SELECT generate_subscripts( indexes_matview, 1 ) LOOP
    RAISE NOTICE 'Index definition: %', indexes_matview[i];
    EXECUTE indexes_matview[i];
  END LOOP;
  RAISE NOTICE 'mat_view: %', matview;
  FOR index_matview IN SELECT indexdef FROM pg_indexes WHERE tablename=replace(matview, '"', '') LOOP
    RAISE NOTICE 'Index definition: %', index_matview.indexdef;
  END LOOP;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE;

CREATE OR REPLACE FUNCTION refresh_matview(name)
  RETURNS void AS $$
 DECLARE 
     matview ALIAS FOR $1;
     entry matviews%ROWTYPE;
     indexes_matview RECORD;
     i integer;
 BEGIN
    SELECT * INTO entry FROM matviews WHERE mv_name = matview;

    IF NOT FOUND THEN
         RAISE EXCEPTION 'Materialized view % does not exist.', matview;
    END IF;

    SELECT array_agg(indexdef) AS definition, array_agg(indexname) AS name INTO indexes_matview FROM pg_indexes WHERE tablename=replace(matview, '"', '');

    FOR i IN SELECT generate_subscripts( indexes_matview.name, 1 ) LOOP
      RAISE NOTICE 'DROP INDEX: %', indexes_matview.name[i];
      EXECUTE 'DROP INDEX "'||indexes_matview.name[i]||'"';
    END LOOP;
    
    
    EXECUTE 'DELETE FROM ' || matview;
    EXECUTE 'INSERT INTO ' || matview
        || ' SELECT * FROM ' || entry.v_name;

    FOR i IN SELECT generate_subscripts( indexes_matview.definition, 1 ) LOOP
      RAISE NOTICE 'INDEX definition: %', indexes_matview.definition[i];
      EXECUTE indexes_matview.definition[i];
    END LOOP;
    
    UPDATE matviews
        SET last_refresh=CURRENT_TIMESTAMP
        WHERE mv_name=matview;

    RETURN;
END
$$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION refresh_matviews()
  RETURNS void AS $$
DECLARE 
  matview RECORD;
  sql text;
BEGIN
  FOR matview IN SELECT matviewname FROM pg_matviews LOOP
    sql :='REFRESH MATERIALIZED VIEW "'||matview.matviewname||'"';
    RAISE NOTICE 'EXECUTE: %', sql;
    EXECUTE sql;
  END LOOP;
RETURN;
END
$$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION truncate_matviews()
  RETURNS void AS $$
DECLARE 
  matview RECORD;
  sql text;
BEGIN
  FOR matview IN SELECT matviewname FROM pg_matviews LOOP
    sql :='REFRESH MATERIALIZED VIEW "'||matview.matviewname||'" WITH NO DATA';
    RAISE NOTICE 'EXECUTE: %', sql;
    EXECUTE sql;
  END LOOP;
RETURN;
END
$$
LANGUAGE plpgsql;

--Vista para revista y su disciplina correspondiente
--DROP MATERIALIZED VIEW "mvRevistaDisciplina";
CREATE MATERIALIZED VIEW "mvRevistaDisciplina" AS 
SELECT
  base, "revistaSlug", (array_agg(revista))[1] AS revista, (array_agg("disciplinaRevista"))[1] AS "disciplinaRevista", sum(documentos)
--base, "revistaSlug", array_agg(revista), array_agg("disciplinaRevista"), array_agg(documentos)
FROM
  (SELECT 
    substr(sistema, 1, 5) AS base, 
    slug(revista) AS "revistaSlug",
    revista,
    "disciplinaRevista", 
    count(*) AS documentos
  FROM article
  GROUP BY substr(sistema, 1, 5), slug(revista), revista, "disciplinaRevista"
  ORDER BY base, "revistaSlug", documentos DESC) t
WHERE "revistaSlug" IS NOT NULL
GROUP BY base, "revistaSlug"
HAVING count(*) > 1;

--Vista para busquedas
--DROP MATERIALIZED VIEW "mvSearch";
CREATE MATERIALIZED VIEW "mvSearch" AS 
SELECT 
    t.sistema, 
    slug(t.revista) AS "revistaSlug", 
    slug(t.articulo) AS "articuloSlug",
    slug(t."paisRevista") AS "paisRevistaSlug",  
    regexp_replace(t."descripcionBibliografica"->>'a', '.*?([0-9]+)', '\1')::varchar AS volumen, 
    regexp_replace(t."descripcionBibliografica"->>'b', '.*?([0-9]+)', '\1')::varchar AS numero, 
    t."descripcionBibliografica"->>'c' AS periodo, 
    regexp_replace(t."descripcionBibliografica"->>'e', '^.*?([0-9]+.*)', '\1')::varchar AS paginacion, 
    t.documento->>'a' AS "tipoDocumento",
    t.documento->>'b' AS "enfoqueDocumento",
    d.slug AS "disciplinaSlug",
    d.id_disciplina,
    array_to_json(a."autoresSecArray")::text AS "autoresSecJSON",
    array_to_json(a."autoresSecInstitucionArray")::text AS "autoresSecInstitucionJSON",
    array_to_json(a."autoresArray")::text AS "autoresJSON",
    a."autoresSlug",
    array_to_json(i."institucionesSecArray")::text AS "institucionesSecJSON",
    array_to_json(i."institucionesArray")::text AS "institucionesJSON",
    i."institucionesSlug",
    concat(json_slug(t."palabraClave"), json_slug(t.keyword)) AS "palabrasClaveSlug",
    concat(
        json_slug(t."palabraClave"),
        json_slug(t.keyword),
        slug_space(t.articulo) || ' | ',
        slug_space(t.revista) || ' | ',
        slug_space(t."paisRevista") || ' | ',
        i."institucionesSlug",
        a."autoresSlug"
      ) AS "generalSlug"
FROM article t
    LEFT JOIN (SELECT 
            sistema, 
            array_agg(id ORDER BY id) AS "autoresSecArray",
            array_agg("institucionId" ORDER BY id) AS "autoresSecInstitucionArray",
            array_agg(nombre ORDER BY id) AS "autoresArray",
            string_agg(slug_space(nombre), ' | ' ORDER BY id) || ' | ' AS "autoresSlug"
        FROM author
        GROUP BY sistema) a --Autores
    ON (t.sistema=a.sistema) 
    LEFT JOIN (SELECT 
            sistema, 
            array_agg(id ORDER BY id) AS "institucionesSecArray",
            array_agg(concat(institucion, ', '||dependencia, ', '||ciudad, '. '||pais) ORDER BY id) AS "institucionesArray",
            string_agg(slug_space(institucion), ' | ' ORDER BY id) || ' | ' AS "institucionesSlug"
        FROM institution 
        GROUP BY sistema) i --Instituciones
    ON (t.sistema=i.sistema)
    INNER JOIN disciplinas d 
    ON slug(t."disciplinaRevista")=d.slug;

CREATE INDEX ON "mvSearch"(sistema);
CREATE INDEX ON "mvSearch"(id_disciplina);
CREATE INDEX ON "mvSearch"(volumen);
CREATE INDEX ON "mvSearch"(numero);
CREATE INDEX ON "mvSearch"("articuloSlug");
CREATE INDEX ON "mvSearch"("revistaSlug");
CREATE INDEX ON "mvSearch"("disciplinaSlug");
CREATE INDEX ON "mvSearch"("paisRevistaSlug");
CREATE INDEX ON "mvSearch" USING gin("generalSlug" gin_trgm_ops);
CREATE INDEX ON "mvSearch" USING gin("autoresSlug" gin_trgm_ops);
CREATE INDEX ON "mvSearch" USING gin("articuloSlug" gin_trgm_ops);
CREATE INDEX ON "mvSearch" USING gin("revistaSlug" gin_trgm_ops);
CREATE INDEX ON "mvSearch" USING gin("paisRevistaSlug" gin_trgm_ops);
CREATE INDEX ON "mvSearch" USING gin("institucionesSlug" gin_trgm_ops);
CREATE INDEX ON "mvSearch" USING gin("palabrasClaveSlug" gin_trgm_ops);


CREATE INDEX "searchIdDatabase_idx" ON "mvSearch"(iddatabase);
CREATE INDEX "searchTextoCompleto_idx" ON "mvSearch"(url);


CREATE INDEX "searchAlfabetico_idx" ON "mvSearch"(substring(LOWER(revista), 1, 1));
--CREATE INDEX "searchGeneralSlug_idx" ON "mvSearch" USING gin(("generalSlug"::tsvector));









--Vista con el contenido de la ficha del documento
--DROP VIEW "vSearchFull";
CREATE VIEW "vSearchFull" AS
SELECT 
    a.*,
    s."revistaSlug",
    s."articuloSlug",
    s."paisRevistaSlug",
    s.volumen,
    s.numero,
    s.periodo,
    s.paginacion,
    s."tipoDocumento",
    s."enfoqueDocumento",
    s."disciplinaSlug",
    s.id_disciplina,
    s."autoresSecJSON",
    s."autoresSecInstitucionJSON",
    s."autoresJSON",
    s."autoresSlug",
    s."institucionesSecJSON",
    s."institucionesJSON",
    s."institucionesSlug",
    s."palabrasClaveSlug",
    s."generalSlug"
FROM article a
INNER JOIN "mvSearch" s
  ON a.sistema=s.sistema;

--Vista para lista de paises
--DROP MATERIALIZED VIEW "mvPais";
CREATE MATERIALIZED VIEW "mvPais" AS 
SELECT
  "paisRevistaSlug",
  "paisRevista",
  count(*) AS total
  FROM  "vSearchFull"
  GROUP BY "paisRevistaSlug", "paisRevista"
  ORDER BY "paisRevistaSlug";

--Vista para disciplinas
--DROP MATERIALIZED VIEW "mvDisciplina";
CREATE MATERIALIZED VIEW "mvDisciplina" AS
SELECT DISTINCT 
  a.id_disciplina, 
  d.disciplina, 
  d.slug, 
  count(*) AS total
FROM "vSearchFull" a 
INNER JOIN disciplinas d ON a.id_disciplina=d.id_disciplina
GROUP BY a.id_disciplina, d.disciplina, d.slug 
ORDER BY d.disciplina;

--Vista para las revistas por disciplina
--DROP MATERIALIZED VIEW "mvDisciplinaRevistas";
CREATE MATERIALIZED VIEW "mvDisciplinaRevistas" AS
SELECT
  "revistaSlug",
  (array_agg(revista))[1] AS revista,
  id_disciplina, 
  sum(documentos) AS documentos 
FROM
  (SELECT 
    "revistaSlug",
    revista,
    id_disciplina, 
    count(*) AS documentos 
  FROM "vSearchFull" 
  GROUP BY id_disciplina, "revistaSlug", revista 
  ORDER BY id_disciplina, "revistaSlug", revista, documentos DESC) t
GROUP BY id_disciplina, "revistaSlug";


--Vista para mostrar solo los documentos que sean artículos y mostrando el año en una cadena de 4 digitos
--DROP VIEW "vArticulos";
CREATE OR REPLACE VIEW "vArticulos" AS
WITH articulos AS
  (SELECT 
    sistema,
    id_disciplina,
    revista,
    "revistaSlug",
    volumen,
    numero,
    substr("anioRevista", 1, 4) AS anio,
    "paisRevista",
    "paisRevistaSlug"
  FROM "vSearchFull" WHERE 
    "tipoDocumento" ~~ 'Artículo%' 
    AND substr("anioRevista", 1, 4) ~ '[0-9]{4}' 
    AND "revistaSlug"::varchar != ALL((SELECT array_agg("revistaSlug")::varchar[] FROM "revistasBacklist")::varchar[]))

SELECT 
  a.* 
FROM 
  articulos a
INNER JOIN 
  (SELECT "revistaSlug", anios_continuos(array_agg(anio)) AS anios_continuos
  FROM 
    (SELECT 
      "revistaSlug", 
      anio, 
      count(*) AS articulos 
    FROM articulos GROUP BY "revistaSlug", anio HAVING count(*) > 4) title --Titulos de revista con más de 4 articulos al año 
  GROUP BY "revistaSlug" HAVING  anios_continuos(array_agg(anio)) > 4) tc --Titlos de revista con más de 4 periodos consecutivos;
  ON a."revistaSlug"=tc."revistaSlug";

--Autor indicador
--DROP VIEW "vAutorIndicador";
CREATE OR REPLACE VIEW "vAutorIndicador" AS
SELECT a.*
FROM author a
LEFT JOIN institution i 
ON a.sistema=i.sistema
AND a."institucionId"=i.id
WHERE i.pais IS NOT NULL;

--Autores por documento
--DROP VIEW "vAutoresDocumento";
CREATE OR REPLACE VIEW "vAutoresDocumento" AS
SELECT * FROM
(SELECT a.sistema,
       count(*) AS autores,
       max(i.pais) AS pais

FROM author a
LEFT JOIN institution i 
  ON a.sistema=i.sistema
  AND a."institucionId"=i.id
GROUP BY a.sistema) AS ad WHERE ad.pais IS NOT NULL;

--Autores por documento y pais de aficialción
--DROP VIEW "vAutoresDocumentoPais";
CREATE OR REPLACE VIEW "vAutoresDocumentoPais" AS
SELECT dp.sistema,
       dp.pais,
       sum(ad.autores) AS autores
FROM
  (SELECT a.sistema,
          i.pais
   FROM author a
   INNER JOIN institution i 
     ON a.sistema=i.sistema
     AND a."institucionId"=i.id
   WHERE i.pais IS NOT NULL
   GROUP BY a.sistema, i.pais) AS dp --dp => documento y pais de afiliacion
INNER JOIN
  (SELECT a.sistema,
          count(*) AS autores
   FROM author a
   LEFT JOIN institution i 
     ON a.sistema=i.sistema
     AND a."institucionId"=i.id
   GROUP BY a.sistema) AS ad -- ad => autores por documento
ON dp.sistema=ad.sistema
GROUP BY dp.sistema, dp.pais;

--Autores en revista
--DROP MATERIALIZED VIEW "mvAutorRevista";
CREATE MATERIALIZED VIEW "mvAutorRevista" AS
SELECT 
  ar."revistaSlug",
  ar.anio,
  ai.nombre AS autor,
  count(*) AS documentos
FROM "vAutorIndicador" ai
INNER JOIN "vArticulos" ar 
  ON ai.sistema=ar.sistema
GROUP BY "revistaSlug", anio, autor
ORDER BY "revistaSlug", anio, autor;

CREATE MATERIALIZED VIEW "mvAutorPais" AS
SELECT 
  ar."paisRevistaSlug",
  ar.anio,
  ai.nombre AS autor,
  count(*) AS documentos
FROM "vAutorIndicador" ai
INNER JOIN "vArticulos" ar 
  ON ai.sistema=ar.sistema
GROUP BY "paisRevistaSlug", anio, autor
ORDER BY "paisRevistaSlug", anio, autor;

--Indice de coautoria por revista
CREATE MATERIALIZED VIEW "mvIndiceCoautoriaPriceRevista" AS
SELECT max(ar.revista) AS revista,
       ar."revistaSlug",
       ar.anio,
       count(*) AS documentos,
       sum(au.autores) AS autores,
       sum(au.autores) / count(*) AS coautoria,
       sqrt(sum(au.autores)) AS price
FROM "vAutoresDocumento" au
INNER JOIN "vArticulos" ar 
  ON au.sistema=ar.sistema
GROUP BY "revistaSlug", anio
ORDER BY "revistaSlug", anio;

CREATE INDEX ON "mvIndiceCoautoriaPriceRevista"("revistaSlug");
CREATE INDEX ON "mvIndiceCoautoriaPriceRevista"(anio);

--Indice de coautoria por país de la revista
CREATE MATERIALIZED VIEW "mvIndiceCoautoriaPricePaisRevista" AS
SELECT ar.id_disciplina, max(ar."paisRevista") AS "paisRevista", ar."paisRevistaSlug", ar.anio, 
    count(*) AS documentos, sum(au.autores) AS autores, 
    sum(au.autores) / count(*) AS coautoria, 
    sqrt(sum(au.autores)) AS price
   FROM "vAutoresDocumento" au
   JOIN "vArticulos" ar 
    ON au.sistema=ar.sistema
  GROUP BY ar.id_disciplina, ar."paisRevistaSlug", ar.anio
  ORDER BY ar.id_disciplina, ar."paisRevistaSlug", ar.anio;

CREATE INDEX ON "mvIndiceCoautoriaPricePaisRevista"("paisRevistaSlug");
CREATE INDEX ON "mvIndiceCoautoriaPricePaisRevista"(anio);
CREATE INDEX ON "mvIndiceCoautoriaPricePaisRevista"(id_disciplina);

 
--Indice de coautoria por país del autor
CREATE MATERIALIZED VIEW "mvIndiceCoautoriaPricePaisAutor" AS
SELECT 
  au.pais AS "paisAutor", 
  slug(au.pais) AS "paisAutorSlug", 
  id_disciplina, 
  ar.anio, 
  count(*) AS documentos, 
  sum(au.autores) AS autores, 
  sum(au.autores) / count(*) AS coautoria,
  sqrt(sum(au.autores)) AS price
FROM "vAutoresDocumentoPais" au
INNER JOIN  "vArticulos" ar 
  ON au.sistema=ar.sistema
GROUP BY "paisAutor", id_disciplina, anio
ORDER BY "paisAutor", id_disciplina, anio;

CREATE INDEX ON "mvIndiceCoautoriaPricePaisAutor"("paisAutorSlug");
CREATE INDEX ON "mvIndiceCoautoriaPricePaisAutor"(anio);
CREATE INDEX ON "mvIndiceCoautoriaPricePaisAutor"(id_disciplina);

--Vista para revistas con años continuos mayores a 4
CREATE MATERIALIZED VIEW "mvPeriodosRevistaCoautoriaPriceZakutina" AS
SELECT dr.revista,
       dr."revistaSlug",
       dr.id_disciplina,
       dr.documentos,
       ac.anios_continuos
FROM
  (SELECT "revistaSlug",
          anios_continuos(array_agg(anio))
   FROM "mvIndiceCoautoriaPriceRevista"
   GROUP BY "revistaSlug") AS ac --Años continuos por revista
INNER JOIN "mvDisciplinaRevistas" dr ON ac."revistaSlug"=dr."revistaSlug"
WHERE anios_continuos > 4;

--Vista para paises con años continuos mayores a 4
CREATE MATERIALIZED VIEW "mvPeriodosPaisRevistaCoautoriaPriceZakutina" AS
SELECT *
FROM
  (SELECT id_disciplina,
    max("paisRevista") AS "paisRevista",
          "paisRevistaSlug",
          anios_continuos(array_agg(anio))
   FROM "mvIndiceCoautoriaPricePaisRevista"
   GROUP BY id_disciplina,
      "paisRevistaSlug"
   ORDER BY id_disciplina,
     "paisRevistaSlug") AS ac --Años continuos por revista
WHERE anios_continuos > 4;

--Vista para autores con años continuos mayores a 4
CREATE MATERIALIZED VIEW "mvPeriodosPaisAutorCoautoriaPriceZakutina" AS
SELECT * 
FROM
  (SELECT "paisAutor",
    "paisAutorSlug",
    id_disciplina,
    anios_continuos(array_agg(anio))
  FROM "mvIndiceCoautoriaPricePaisAutor"
  GROUP BY "paisAutorSlug",
    "paisAutor",
    id_disciplina
  ORDER BY "paisAutorSlug",
    id_disciplina) AS ac --Años continuos por revista
WHERE anios_continuos > 4;

--Vista para tasa de coutoria por revista
CREATE MATERIALIZED VIEW "mvTasaCoautoriaRevista" AS
SELECT td.revista,
       td."revistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       tda.documentos AS "documentosMultiple",
       (tda.documentos::numeric/td.documentos::numeric) AS "tasaCoautoria"
FROM "mvIndiceCoautoriaPriceRevista" td --Total de documentos
INNER JOIN
  (SELECT ar."revistaSlug",
          ar.anio,
          count(*) AS documentos
   FROM "vArticulos" ar
   INNER JOIN "vAutoresDocumento" au 
    ON ar.sistema=au.sistema AND au.autores>1
   GROUP BY "revistaSlug", anio) AS tda --Total de documentos con mas de un autor
ON td."revistaSlug"=tda."revistaSlug" AND td.anio=tda.anio;

CREATE INDEX ON "mvTasaCoautoriaRevista"("revistaSlug");
CREATE INDEX ON "mvTasaCoautoriaRevista"(anio);

--Vista para tasa de coutoria por pais de la revista
CREATE MATERIALIZED VIEW "mvTasaCoautoriaPaisRevista" AS
SELECT td.id_disciplina,
       td."paisRevista",
       td."paisRevistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       tda.documentos AS "documentosMultiple",
       (tda.documentos::numeric/td.documentos::numeric) AS "tasaCoautoria"
FROM "mvIndiceCoautoriaPricePaisRevista" td --Total de documentos
INNER JOIN
  (SELECT ar.id_disciplina,
    ar."paisRevistaSlug",
          ar.anio,
          count(*) AS documentos
   FROM "vArticulos" ar
   INNER JOIN "vAutoresDocumento" au 
   ON ar.sistema=au.sistema AND au.autores>1
   GROUP BY ar.id_disciplina, "paisRevistaSlug", anio) AS tda --Total de documentos con mas de un autor
ON td.id_disciplina=tda.id_disciplina AND td."paisRevistaSlug"=tda."paisRevistaSlug" AND td.anio=tda.anio;

CREATE INDEX ON "mvTasaCoautoriaPaisRevista"("paisRevistaSlug");
CREATE INDEX ON "mvTasaCoautoriaPaisRevista"(anio);
CREATE INDEX ON "mvTasaCoautoriaPaisRevista"(id_disciplina);

--Vista para tasa de coutoria por pais del autor
CREATE MATERIALIZED VIEW "mvTasaCoautoriaPaisAutor" AS
SELECT 
  td."paisAutor",
  td."paisAutorSlug",
  td.id_disciplina,
  td.anio,
  td.documentos AS "totalDocumentos",
  tda.documentos AS "documentosMultiple",
  (tda.documentos::numeric/td.documentos::numeric) AS "tasaCoautoria"
FROM "mvIndiceCoautoriaPricePaisAutor" td --Total de documentos
INNER JOIN
  (SELECT 
    slug(au.pais) AS "paisAutorSlug", 
    id_disciplina,
    anio,
    count(*) AS documentos
  FROM "vArticulos" ar
  INNER JOIN "vAutoresDocumentoPais" au
    ON ar.sistema=au.sistema AND au.autores>1
  GROUP BY "paisAutorSlug", id_disciplina, anio) AS tda --Documentos con más de un autor
ON td."paisAutorSlug"=tda."paisAutorSlug" AND td.id_disciplina=tda.id_disciplina AND td.anio=tda.anio;

CREATE INDEX ON "mvTasaCoautoriaPaisAutor"("paisAutorSlug");
CREATE INDEX ON "mvTasaCoautoriaPaisAutor"(anio);
CREATE INDEX ON "mvTasaCoautoriaPaisAutor"(id_disciplina);

-- Vista para periodos en reivistas para los indicadores Tasa de coautoría e Indice Lawani
CREATE MATERIALIZED VIEW "mvPeriodosRevistaTasaLawani" AS
SELECT dr.revista,
       dr."revistaSlug",
       dr.id_disciplina,
       dr.documentos,
       ac.anios_continuos
FROM
  (SELECT "revistaSlug",
          anios_continuos(array_agg(anio))
   FROM "mvTasaCoautoriaRevista"
   GROUP BY "revistaSlug") AS ac --Años continuos por revista
INNER JOIN "mvDisciplinaRevistas" dr ON ac."revistaSlug"=dr."revistaSlug"
WHERE anios_continuos > 4;

-- Vista para periodos en paises para los indicadores Tasa de coautoría e Indice Lawani
CREATE MATERIALIZED VIEW "mvPeriodosPaisRevistaTasaLawani" AS
SELECT *
FROM
  (SELECT "paisRevista",
          "paisRevistaSlug",
          id_disciplina,
          anios_continuos(array_agg(anio))
   FROM "mvTasaCoautoriaPaisRevista"
   GROUP BY "paisRevistaSlug",
            "paisRevista",
            id_disciplina
   ORDER BY "paisRevistaSlug",
            id_disciplina) AS ac --Años continuos por revista
WHERE anios_continuos > 4;

-- Vista para periodos de autores para los indicadores Tasa de coautoría e Indice Lawani
CREATE MATERIALIZED VIEW "mvPeriodosPaisAutorTasaLawani" AS
SELECT *
FROM
  (SELECT "paisAutor",
    "paisAutorSlug",
    id_disciplina,
    anios_continuos(array_agg(anio))
  FROM "mvTasaCoautoriaPaisAutor"
  GROUP BY "paisAutorSlug",
    "paisAutor",
    id_disciplina
  ORDER BY "paisAutorSlug",
    id_disciplina) AS ac --Años continuos por revista
  WHERE anios_continuos > 4;

--Vista lawani por revista
CREATE MATERIALIZED VIEW "mvLawaniRevista" AS
SELECT td.revista,
       td."revistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       sad."autoresXdocumentos",
       sad."autoresXdocumentos"::numeric/td.documentos::numeric AS lawani
FROM "mvIndiceCoautoriaPriceRevista" td --Total de documentos
INNER JOIN
  (SELECT "revistaSlug",
          anio,
          sum("autoresXdocumentos") AS "autoresXdocumentos"
   FROM
     (SELECT a."revistaSlug",
             a.anio,
             ad.autores * count(*) AS "autoresXdocumentos"
      FROM "vAutoresDocumento" ad --autores por documento
INNER JOIN "vArticulos" a 
    ON ad.sistema=a.sistema
      AND ad.autores>1
      GROUP BY a."revistaSlug",
               a.anio,
               ad.autores) adr -- autoresXdocumento por revista al año
GROUP BY "revistaSlug",
         anio) sad -- suma de autoresXdocumento por revista al año
ON td."revistaSlug"=sad."revistaSlug"
AND td.anio=sad.anio;

--Vista lawani por país de la revista
CREATE MATERIALIZED VIEW "mvLawaniPaisRevista" AS
SELECT td.id_disciplina,
       td."paisRevista",
       td."paisRevistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       sad."autoresXdocumentos",
       sad."autoresXdocumentos"::numeric/td.documentos::numeric AS lawani
FROM "mvIndiceCoautoriaPricePaisRevista" td --Total de documentos
INNER JOIN
  (SELECT id_disciplina, 
   "paisRevistaSlug",
          anio,
          sum("autoresXdocumentos") AS "autoresXdocumentos"
   FROM
     (SELECT a.id_disciplina,
       a."paisRevistaSlug",
             a.anio,
             ad.autores * count(*) AS "autoresXdocumentos"
      FROM "vAutoresDocumento" ad --autores por documento
INNER JOIN "vArticulos" a 
    ON ad.sistema=a.sistema
      AND ad.autores>1
      GROUP BY a.id_disciplina,
         a."paisRevistaSlug",
               a.anio,
               ad.autores) adr -- autoresXdocumento por pais al año
GROUP BY id_disciplina,
   "paisRevistaSlug",
         anio) sad -- suma de autoresXdocumento por pais al año
ON td.id_disciplina=sad.id_disciplina AND td."paisRevistaSlug"=sad."paisRevistaSlug"
AND td.anio=sad.anio;

--Vista lawani por país del autor
CREATE MATERIALIZED VIEW "mvLawaniPaisAutor" AS
SELECT
  td."paisAutor",
  td."paisAutorSlug",
  td.id_disciplina,
  td.anio,
  sadp."autoresXdocumentos"::numeric/td.documentos::numeric AS lawani 
FROM "mvIndiceCoautoriaPricePaisAutor" td --Total de documentos
INNER JOIN
  (SELECT 
    "paisAutorSlug",
    id_disciplina,
    anio,
    sum("autoresXdocumentos") AS "autoresXdocumentos"
  FROM
    (SELECT 
      slug(adp.pais) AS "paisAutorSlug",
      id_disciplina,
      anio,
      --autores, count(*) AS documentos,
      autores * count(*) AS "autoresXdocumentos"
    FROM "vAutoresDocumentoPais" adp
    INNER JOIN "vArticulos" a
      ON adp.sistema=a.sistema AND adp.autores>1
    GROUP BY "paisAutorSlug", a.id_disciplina, a.anio, adp.autores) AS adp --Autores por documentos en pais, disciplina y año
  GROUP BY "paisAutorSlug", id_disciplina, anio) AS sadp --Suma de autores por documentos en pais, disciplina y año
  ON td."paisAutorSlug"=sadp."paisAutorSlug" AND td.id_disciplina=sadp.id_disciplina AND td.anio=sadp.anio;

-- Vista para inide subramayan por revista
CREATE MATERIALIZED VIEW "mvSubramayanRevista" AS
SELECT
  am.revista,
  am."revistaSlug",
  am.anio,
  am.documentos AS "documentosMultiple",
  au.documentos AS "documentosUnAutor",
  am.documentos::numeric/(au.documentos+am.documentos)::numeric AS subramayan
FROM
(SELECT max(ar.revista) AS revista,
    ar."revistaSlug",
          ar.anio,
          count(*) AS documentos
   FROM "vArticulos" ar
   INNER JOIN "vAutoresDocumento" au 
    ON ar.sistema=au.sistema AND au.autores>1
   GROUP BY "revistaSlug", anio) am -- Autores multiples
INNER JOIN
(SELECT   ar."revistaSlug",
          ar.anio,
          count(*) AS documentos
   FROM "vArticulos" ar
   INNER JOIN "vAutoresDocumento" au 
   ON ar.sistema=au.sistema AND au.autores=1
   GROUP BY "revistaSlug", anio) au --Autores unicos
ON am."revistaSlug"=au."revistaSlug" AND am.anio=au.anio;

--Vista para indice subramayan por país de la revista
CREATE MATERIALIZED VIEW "mvSubramayanPaisRevista" AS
SELECT
  am.id_disciplina, 
  am."paisRevista",
  am."paisRevistaSlug",
  am.anio,
  am.documentos AS "documentosMultiple",
  au.documentos AS "documentosUnAutor",
  am.documentos::numeric/(au.documentos+am.documentos)::numeric AS subramayan
FROM
(SELECT   ar.id_disciplina,
    max(ar."paisRevista") AS "paisRevista",
    ar."paisRevistaSlug",
          ar.anio,
          count(*) AS documentos
   FROM "vArticulos" ar
   INNER JOIN "vAutoresDocumento" au 
    ON ar.sistema=au.sistema AND au.autores>1
   GROUP BY id_disciplina, "paisRevistaSlug", anio) am -- Autores multiples
INNER JOIN
(SELECT   ar.id_disciplina, 
    ar."paisRevistaSlug",
          ar.anio,
          count(*) AS documentos
   FROM "vArticulos" ar
   INNER JOIN "vAutoresDocumento" au 
    ON ar.sistema=au.sistema AND au.autores=1
   GROUP BY id_disciplina, "paisRevistaSlug", anio) au --Autores unicos
ON am.id_disciplina=au.id_disciplina AND am."paisRevistaSlug"=au."paisRevistaSlug" AND am.anio=au.anio;

-- Vista para periodos en reivistas para en indicador subramayab
CREATE MATERIALIZED VIEW "mvPeriodosRevistaSubramayan" AS
SELECT dr.revista,
       dr."revistaSlug",
       dr.id_disciplina,
       dr.documentos,
       ac.anios_continuos
FROM
  (SELECT "revistaSlug",
          anios_continuos(array_agg(anio))
   FROM "mvSubramayanRevista"
   GROUP BY "revistaSlug") AS ac --Años continuos por revista
INNER JOIN "mvDisciplinaRevistas" dr ON ac."revistaSlug"=dr."revistaSlug"
WHERE anios_continuos > 4;

--Vista para periodos en paises para el indicador subramayan
CREATE MATERIALIZED VIEW "mvPeriodosPaisRevistaSubramayan" AS
SELECT *
FROM
  (SELECT "paisRevista",
          "paisRevistaSlug",
          id_disciplina,
          anios_continuos(array_agg(anio))
   FROM "mvSubramayanPaisRevista"
   GROUP BY "paisRevistaSlug",
            "paisRevista",
            id_disciplina
   ORDER BY "paisRevistaSlug",
            id_disciplina) AS ac --Años continuos por revista
WHERE anios_continuos > 4;

-- Vista para inidice zakutina por revista

CREATE MATERIALIZED VIEW "mvZakutinaRevista" AS
SELECT td.revista,
       td."revistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       t.titulos,
       (td.documentos::numeric/t.titulos::numeric) AS zakutina
FROM "mvIndiceCoautoriaPriceRevista" td --Total de documentos
INNER JOIN
(SELECT "revistaSlug", anio, count(*) AS titulos FROM (SELECT "revistaSlug", anio, volumen, numero FROM 
"vAutoresDocumento" ad 
INNER JOIN
"vArticulos" a
  ON ad.sistema=a.sistema
GROUP BY "revistaSlug", anio, volumen, numero) ravn -- Revista, año, volumen, numero

GROUP BY "revistaSlug", anio) t --Titulos por revista al año
ON td."revistaSlug"=t."revistaSlug" AND td.anio=t.anio;

--Vista para indice zakutina por país de la revista
CREATE MATERIALIZED VIEW "mvZakutinaPaisRevista" AS
SELECT td.id_disciplina,
       td."paisRevista",
       td."paisRevistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       t.titulos,
       (td.documentos::numeric/t.titulos::numeric) AS zakutina
FROM "mvIndiceCoautoriaPricePaisRevista" td --Total de documentos
INNER JOIN
  (SELECT id_disciplina,
    "paisRevistaSlug",
          anio,
          count(*) AS titulos
   FROM
     (SELECT id_disciplina,
       "paisRevistaSlug",
             anio,
             volumen,
             numero
      FROM "vAutoresDocumento" ad
      INNER JOIN "vArticulos" a ON ad.sistema=a.sistema
      GROUP BY id_disciplina,
         "paisRevistaSlug",
               anio,
               volumen,
               numero) ravn -- Pais, año, volumen, numero
GROUP BY id_disciplina, "paisRevistaSlug",
         anio) t --Titulos por pais al año
ON td.id_disciplina=t.id_disciplina AND td."paisRevistaSlug"=t."paisRevistaSlug"
AND td.anio=t.anio;

--Vista para indice Pratt
CREATE MATERIALIZED VIEW "mvPratt" AS
SELECT 
  id_disciplina,
  max(revista) AS revista,
  "revistaSlug",
  array_to_json(array_agg(descriptor)) AS "descriptoresJSON",
  array_to_json(array_agg(frecuencia)) AS "frecuenciaDescriptorJSON",
  --(count(*)::numeric + 0.5::numeric) AS "n+1/2",
  --(sum(frecuencia*rango)::numeric/sum(frecuencia))::numeric AS "q",
  --((count(*)::numeric + 0.5::numeric) - (sum(frecuencia*rango)::numeric/sum(frecuencia))::numeric) AS "(n+1/2)-q",
  2 * (((count(*)::numeric + 1) / 2) - (sum(frecuencia*rango)::numeric/sum(frecuencia))::numeric) / (count(*)-1)::numeric AS "pratt"
FROM
  (SELECT 
    ad.id_disciplina,
    ad.revista,
    ad."revistaSlug",
    ad.articulos,
    fd.descriptor,
    fd.frecuencia,
    row_number() OVER (PARTITION BY ad.id_disciplina, ad."revistaSlug" ORDER BY frecuencia DESC, descriptor) AS rango
  FROM
    (SELECT 
      max(revista) AS revista, 
      "revistaSlug", 
      id_disciplina, 
      count(*) AS articulos
    FROM "vAutoresDocumento" ad
    INNER JOIN  "vArticulos" a
      ON ad.sistema=a.sistema
    GROUP BY "revistaSlug", id_disciplina HAVING count(*) > 25) ad --Articulos por disciplina
  INNER JOIN
    (SELECT 
      "revistaSlug", 
      id_disciplina,
      p.descpalabraclave AS descriptor, 
      count(*) AS frecuencia
    FROM "vAutoresDocumento" ad
    INNER JOIN "vArticulos" a
      ON ad.sistema=a.sistema
    INNER JOIN (SELECT *, row_number() OVER(PARTITION BY sistema) AS id FROM 
            (SELECT 
              sistema, 
              ('['||json_array_elements("palabraClave")||']')::json->>0 AS descpalabraclave 
            FROM article
            ORDER BY sistema) t) p
    ON ad.sistema=p.sistema
    WHERE p.id < 3
    GROUP BY "revistaSlug", id_disciplina, p.descpalabraclave) fd --Frecuencia del descriptor
  ON ad."revistaSlug"=fd."revistaSlug" AND ad.id_disciplina=fd.id_disciplina) fdr
GROUP BY id_disciplina, "revistaSlug";

--Bradford

CREATE MATERIALIZED VIEW "mvDocumentosBradford" AS
SELECT 
  a.sistema
FROM "vAutoresDocumento" ad
INNER JOIN "vArticulos" a
  ON ad.sistema=a.sistema
GROUP BY a."revistaSlug", a.sistema;

CREATE OR REPLACE VIEW "vDocumentosBradfordFull" AS
SELECT   
  s.sistema,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  "paisRevista", 
  "anioRevista", 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url,
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON" 
FROM "mvDocumentosBradford" db 
INNER JOIN "vSearchFull" s 
  ON db.sistema=s.sistema;

CREATE MATERIALIZED VIEW "mvArticulosDisciplinaRevista" AS
SELECT * FROM
(SELECT 
    a.id_disciplina, 
    a."revistaSlug", 
    max(a.revista) AS revista, 
    count(*) AS articulos
 FROM "vAutoresDocumento" ad
  INNER JOIN "vArticulos" a
    ON ad.sistema=a.sistema
  GROUP BY a.id_disciplina, a."revistaSlug") adr ORDER BY id_disciplina, articulos DESC;

CREATE OR REPLACE VIEW "vBradfordRevista" AS
SELECT 
  * ,
  log("frecuenciaAcumulado") AS "logFrecuenciaAcumulado"
FROM
(SELECT 
  id_disciplina, 
  articulos, 
  --sum(articulos) OVER (PARTITION BY id_disciplina ORDER BY articulos DESC) AS "articulosAcumulado",
  count(*) AS frecuencia,
  sum(count(*)) OVER (PARTITION BY id_disciplina ORDER BY articulos DESC) AS "frecuenciaAcumulado",
  --articulos * count(*) AS "articulosXfrecuencia",
  sum(articulos * count(*)) OVER (PARTITION BY id_disciplina ORDER BY articulos DESC) AS "articulosXfrecuenciaAcumulado"
FROM "mvArticulosDisciplinaRevista"
GROUP BY id_disciplina, articulos) adrc; --Articulos por disciplina, revista, acumulados

--Bradford institucion
CREATE MATERIALIZED VIEW "mvArticulosDisciplinaInstitucion" AS
SELECT * FROM
(SELECT 
      id_disciplina,
      max(institucion) AS institucion,
      "institucionSlug",
      count(*) AS articulos
    FROM
      (SELECT 
        i.sistema, 
        a.id_disciplina,
        max(i.institucion) AS institucion,
        i.slug AS "institucionSlug"
      FROM  "vArticulos" a
      INNER JOIN institution i
        ON a.sistema=i.sistema
      WHERE i.pais IS NOT NULL AND i.institucion IS NOT NULL
      GROUP BY i.sistema, a.id_disciplina, "institucionSlug") ai --Articulo institucion
    GROUP BY id_disciplina, "institucionSlug") adi ORDER BY id_disciplina, articulos DESC;

CREATE OR REPLACE VIEW "vBradfordInstitucion" AS
SELECT 
  * ,
  log("frecuenciaAcumulado") AS "logFrecuenciaAcumulado"
FROM
  (SELECT 
    id_disciplina, 
    articulos, 
    --sum(articulos) OVER (PARTITION BY id_disciplina ORDER BY articulos DESC) AS "articulosAcumulado",
    count(*) AS frecuencia,
    sum(count(*)) OVER (PARTITION BY id_disciplina ORDER BY articulos DESC) AS "frecuenciaAcumulado",
    --articulos * count(*) AS "articulosXfrecuencia",
    sum(articulos * count(*)) OVER (PARTITION BY id_disciplina ORDER BY articulos DESC) AS "articulosXfrecuenciaAcumulado"
  FROM "mvArticulosDisciplinaInstitucion"
  GROUP BY id_disciplina, articulos) adic; --Articulos por disciplina, revista, acumulados

--Autores por revista, pais
CREATE MATERIALIZED VIEW "mvAutoresRevistaPais" AS
SELECT 
  max(ar.revista) AS revista,
  ar."revistaSlug",
  max("paisAutor") AS "paisAutor",
  adp."paisAutorSlug",
  sum(autores) AS autores
FROM
(SELECT 
  a.sistema, max(i.pais) AS "paisAutor", 
  i."paisInstitucionSlug" AS "paisAutorSlug", 
  count(*) AS autores
FROM author a
     INNER JOIN institution i ON a.sistema=i.sistema AND a."institucionId"=i.id
WHERE i.pais IS NOT NULL
GROUP BY a.sistema, i."paisInstitucionSlug") adp --Autores por documento y país
INNER JOIN "vArticulos" ar ON adp.sistema=ar.sistema
GROUP BY ar."revistaSlug", adp."paisAutorSlug";

--Productividad exogena
CREATE MATERIALIZED VIEW "mvProductividadExogena" AS
SELECT 
  dr.id_disciplina,
  max(dr.revista) AS revista,
  dr."revistaSlug",
  documentos,
  sum(autores) AS autores,
  sum(autores)/documentos AS exogena
FROM 
  (SELECT ar.id_disciplina,
    max(ar.revista) AS revista,
         ar."revistaSlug",
         count(*) AS documentos,
         max("paisRevistaSlug") AS "paisRevistaSlug"
  FROM "vAutoresDocumento" au
  INNER JOIN "vArticulos" ar ON au.sistema=ar.sistema
  GROUP BY ar.id_disciplina, "revistaSlug" HAVING count(*) > 25
  ORDER BY "revistaSlug") dr --Documentos por revista
INNER JOIN 
  "mvAutoresRevistaPais" arp ON dr."revistaSlug"=arp."revistaSlug" AND dr."paisRevistaSlug"!=arp."paisAutorSlug"
GROUP BY dr.id_disciplina, dr."revistaSlug", documentos
ORDER BY dr.id_disciplina, dr."revistaSlug";

--Frecuencias--
--Documentos por autor
--DROP MATERIALIZED VIEW "mvFrecuenciaAutorDocumentos";
CREATE MATERIALIZED VIEW "mvFrecuenciaAutorDocumentos" AS
SELECT 
  a.autor,
  a."autorSlug",
  a.documentos,
  COALESCE(ac.coautorias, 0) AS coautorias
FROM
  (SELECT 
       max(nombre) AS autor, 
       slug AS "autorSlug", 
       count(DISTINCT sistema) AS documentos 
     FROM author GROUP BY slug) a
LEFT JOIN (
  SELECT 
      aa.slug AS "autorSlug", 
      count(DISTINCT a.slug) AS coautorias 
  FROM
    (SELECT sistema, slug FROM author  GROUP BY sistema, slug) aa
    INNER JOIN author a ON aa.sistema=a.sistema AND aa.slug<>a.slug
    GROUP BY aa.slug) ac
ON a."autorSlug" = ac."autorSlug"
ORDER BY documentos DESC, "autorSlug";

CREATE INDEX ON "mvFrecuenciaAutorDocumentos"(autor);
CREATE INDEX ON "mvFrecuenciaAutorDocumentos"(documentos);

--Autor documentos
CREATE OR REPLACE VIEW "vAutorDocumentos" AS
SELECT   
  s.sistema,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  "paisRevista", 
  "anioRevista", 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url,
  a.slug AS "autorSlug",
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON" 
FROM author a 
INNER JOIN "vSearchFull" s ON 
a.sistema=s.sistema;

--Revistas donde publica la institucion
CREATE OR REPLACE VIEW "vInstitucionRevistas" AS
SELECT 
  max(i.institucion) AS institucion,
  i.slug AS "institucionSlug",
  max(revista) AS revista,
  "revistaSlug"
FROM institution i
INNER JOIN "vSearchFull" s 
  ON i.sistema=s.sistema
GROUP BY "institucionSlug", "revistaSlug";

--Frecuencia de coutores del autor
--DROP MATERIALIZED VIEW "mvFrecuenciaAutorCoautoria";
CREATE MATERIALIZED VIEW "mvFrecuenciaAutorCoautoria" AS
SELECT 
      aa.slug AS "autorSlug", 
      a.slug AS "autorCoSlug",
      max(a.nombre) AS "autorCoautoria",
      count(DISTINCT a.sistema) AS documentos 
  FROM
    (SELECT sistema, slug FROM author  GROUP BY sistema, slug) aa
    INNER JOIN author a ON aa.sistema=a.sistema AND aa.slug<>a.slug
    GROUP BY aa.slug, a.slug;

CREATE INDEX ON "mvFrecuenciaAutorCoautoria"("autorSlug");
CREATE INDEX ON "mvFrecuenciaAutorCoautoria"("autorCoSlug");


--Documentos de couatorias por autor
--DROP MATERIALIZED VIEW "mvAutorCoautoriaSI";
CREATE MATERIALIZED VIEW "mvAutorCoautoriaSI" AS
SELECT 
      a.sistema,
      aa.slug AS "autorSlug", 
      a.slug AS "autorCoSlug"
  FROM
    (SELECT sistema, slug FROM autHor  GROUP BY sistema, slug) aa
    INNER JOIN author a ON aa.sistema=a.sistema AND aa.slug<>a.slug
    GROUP BY a.sistema, aa.slug, a.slug;

CREATE INDEX ON "mvAutorCoautoriaSI"(sistema);
CREATE INDEX ON "mvAutorCoautoriaSI"("autorSlug");
CREATE INDEX ON "mvAutorCoautoriaSI"("autorCoSlug");

--DROP VIEW "vAutorCoautoriaDocumentos";
CREATE VIEW "vAutorCoautoriaDocumentos" AS
SELECT   
  s.sistema,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  "paisRevista", 
  "anioRevista", 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url,
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON",
  ac."autorSlug",
  ac."autorCoSlug"
FROM "mvAutorCoautoriaSI" ac --Autor couatorias
INNER JOIN "vSearchFull" s ON ac.sistema=s.sistema;

--Autores de la institucion
--DROP VIEW "vInstitucionAutor";
CREATE OR REPLACE VIEW "vInstitucionAutor" AS
SELECT 
  max(i.institucion) AS institucion,
  i.slug AS "institucionSlug",
  max(a.nombre) AS autor,
  a.slug AS "autorSlug"
FROM institution i
INNER JOIN author a 
  ON a.sistema=a.sistema AND i.id=a."institucionId"
GROUP BY "institucionSlug", "autorSlug";

--Autores, documentos, revistas y paises por institucion
--DROP MATERIALIZED VIEW "mvFrecuenciaInstitucionDARP";
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionDARP" AS
SELECT  
  irpd."institucionSlug", 
  irpd.institucion,
  irpd.revistas,
  irpd.paises,
  irpd.disciplinas,
  irpd.documentos,
  ia.autores,
  COALESCE(ic.coautorias, 0) AS coautorias
FROM
  (SELECT
    "institucionSlug",
    (array_agg(institucion))[1] AS institucion,
    sum(revistas) AS revistas,
    sum(paises) AS paises,
    sum(disciplinas) AS disciplinas,
    sum(documentos) AS documentos
   FROM
      (SELECT 
        i.slug AS "institucionSlug",
        institucion,  
        count(DISTINCT s."revistaSlug") AS revistas,
        count(DISTINCT s."paisRevistaSlug") AS paises,
        count(DISTINCT s.id_disciplina) AS disciplinas,
        count(DISTINCT i.sistema) AS documentos
       FROM institution i
       INNER JOIN "vSearchFull" s ON i.sistema=s.sistema
       GROUP BY i.slug, institucion
       ORDER BY i.slug, institucion, documentos DESC) t
  GROUP BY "institucionSlug") irpd --Institucion revistas, documentos, paises
INNER JOIN 
  (SELECT
    i.slug AS "institucionSlug",
    count(DISTINCT a.slug) AS autores
  FROM institution i
  LEFT JOIN author a ON
    i.sistema=a.sistema AND
    i.id=a."institucionId"
  GROUP BY i.slug) ia --Institucion autores
ON irpd."institucionSlug"=ia."institucionSlug"
LEFT JOIN
  (SELECT 
      ia.slug AS "institucionSlug", 
      count(DISTINCT i.slug) AS coautorias 
  FROM
    (SELECT sistema, slug FROM institution  GROUP BY sistema, slug) ia
    INNER JOIN institution i ON ia.sistema=i.sistema AND ia.slug<>i.slug
    GROUP BY ia.slug) ic --Insticuones coautoria
ON irpd."institucionSlug"=ic."institucionSlug";

CREATE INDEX ON "mvFrecuenciaInstitucionDARP"(institucion);
CREATE INDEX ON "mvFrecuenciaInstitucionDARP"(documentos);

--Documentos por institucion -> país de publicación
--DROP MATERIALIZED VIEW "mvFrecuenciaInstitucionPais";
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionPais" AS
SELECT
  "institucionSlug",
  "paisRevistaSlug",
  (array_agg("paisRevista"))[1] AS "paisRevista",
  sum(documentos) AS documentos
FROM
  (SELECT 
    --max(i.e_100u) AS institucion,
    i.slug AS "institucionSlug",
    "paisRevistaSlug",
    "paisRevista",
    count(DISTINCT s.sistema) AS documentos
  FROM institution i
  INNER JOIN "vSearchFull" s 
    ON i.sistema=s.sistema
  GROUP BY "institucionSlug", "paisRevistaSlug", "paisRevista"
  ORDER BY "institucionSlug", "paisRevistaSlug", "paisRevista", documentos DESC) t
GROUP BY "institucionSlug", "paisRevistaSlug";


--Documentos por institucion -> revista
--DROP MATERIALIZED VIEW "mvFrecuenciaInstitucionRevista";
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionRevista" AS
SELECT
  "institucionSlug",
  "revistaSlug",
  (array_agg(revista))[1] AS revista,
  sum(documentos) AS documentos
FROM
  (SELECT 
    --max(i.e_100u) AS institucion,
    i.slug AS "institucionSlug",
    "revistaSlug",
    revista,
    count(DISTINCT s.sistema) AS documentos
  FROM institution i
  INNER JOIN "vSearchFull" s 
    ON i.sistema=s.sistema
  GROUP BY "institucionSlug", "revistaSlug", revista
  ORDER BY "institucionSlug", "revistaSlug", revista, documentos DESC) t
GROUP BY "institucionSlug", "revistaSlug";


--Documentos por institucion -> autor
--DROP MATERIALIZED VIEW "mvFrecuenciaInstitucionAutor";
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionAutor" AS
SELECT
    max(i.institucion) AS institucion,
    i.slug AS "institucionSlug",
    max(a.nombre) AS autor,
    a.slug AS "autorSlug",
    count(DISTINCT i.sistema) AS documentos
  FROM institution i
  INNER JOIN author a ON
    i.sistema=a.sistema AND
    i.id=a."institucionId"
  GROUP BY i.slug, a.slug;

--Documentos por institucion -> disciplina
--DROP MATERIALIZED VIEW "mvFrecuenciaInstitucionDisciplina";
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionDisciplina" AS
SELECT 
  max(i.institucion) AS institucion,
  i.slug AS "institucionSlug",
  max(a."disciplinaRevista") AS disciplina,
  a."disciplinaSlug",
  count(DISTINCT a.sistema) AS documentos
FROM institution i
INNER JOIN "vSearchFull" a 
  ON i.sistema=a.sistema
GROUP BY "institucionSlug", a."disciplinaSlug";

--Número de documentos por institucion -> coautoria
--DROP MATERIALIZED VIEW "mvFrecuenciaInstitucionCoautoria";
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionCoautoria" AS
SELECT 
      ia.slug AS "institucionSlug", 
      i.slug AS "institucionCoSlug",
      max(i.institucion) AS "institucionCoautoria",
      count(DISTINCT i.sistema) AS documentos 
  FROM
    (SELECT sistema, slug FROM institution GROUP BY sistema, slug) ia
    INNER JOIN institution i ON ia.sistema=i.sistema AND ia.slug<>i.slug
    GROUP BY ia.slug, i.slug ORDER BY "institucionSlug", documentos DESC;



--Institucion documentos

--DROP CREATE MATERIALIZED VIEW "mvInstitucionSI";
CREATE MATERIALIZED VIEW "mvInstitucionSI" AS
SELECT
  sistema,
  slug AS "institucionSlug"
FROM institution
GROUP BY sistema, slug;

CREATE INDEX ON "mvInstitucionSI"(sistema);
CREATE INDEX ON "mvInstitucionSI"("institucionSlug");

--DROP VIEW "vInstitucionDocumentos";
CREATE VIEW "vInstitucionDocumentos" AS
SELECT 
  s.sistema,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  "paisRevista", 
  "paisRevistaSlug",
  "anioRevista", 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url, 
  "disciplinaSlug",
  i."institucionSlug",
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON" 
FROM "mvInstitucionSI" i 
INNER JOIN "vSearchFull" s ON i.sistema=s.sistema;

--Institucion->autor documentos--
--DROP MATERIALIZED VIEW "mvInstitucionAutorSI";
CREATE MATERIALIZED VIEW "mvInstitucionAutorSI" AS
SELECT
  i.sistema,
  i.slug AS "institucionSlug",
  a.slug AS "autorSlug"
FROM institution i
  INNER JOIN author a ON
    i.sistema=a.sistema AND
    i.id=a."institucionId";

CREATE INDEX ON "mvInstitucionAutorSI"(sistema);
CREATE INDEX ON "mvInstitucionAutorSI"("institucionSlug");
CREATE INDEX ON "mvInstitucionAutorSI"("autorSlug");

CREATE VIEW "vInstitucionAutorDocumentos" AS
SELECT
  s.sistema,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  "paisRevista", 
  "anioRevista", 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url, 
  ia."institucionSlug",
  ia."autorSlug",
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON"
  FROM "mvInstitucionAutorSI" ia
  INNER JOIN "vSearchFull" s ON ia.sistema=s.sistema;

--Documentos en coautoria con la isntitucion
--DROP MATERIALIZED VIEW "mvInstitucionCoautoriaSI";
CREATE MATERIALIZED VIEW "mvInstitucionCoautoriaSI" AS
SELECT 
      i.sistema,
      ia.slug AS "institucionSlug", 
      i.slug AS "institucionCoSlug"
FROM
    (SELECT sistema, slug FROM institution  GROUP BY sistema, slug) ia
    INNER JOIN institution i ON ia.sistema=i.sistema AND ia.slug<>i.slug
    GROUP BY i.sistema, ia.slug, i.slug;

CREATE INDEX ON "mvInstitucionCoautoriaSI"(sistema);
CREATE INDEX ON "mvInstitucionCoautoriaSI"("institucionSlug");
CREATE INDEX ON "mvInstitucionCoautoriaSI"("institucionCoSlug");

CREATE VIEW "vInstitucionCoautoriaDocumentos" AS
SELECT
  s.sistema,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  "paisRevista", 
  "anioRevista", 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url, 
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON",
  ic."institucionSlug", 
  ic."institucionCoSlug"
  FROM "mvInstitucionCoautoriaSI" ic
  INNER JOIN "vSearchFull" s ON ic.sistema=s.sistema;

--Frecuencia Pais de afiliacion del autor, total de documentos, autores, instituciones
--DROP MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacion";
CREATE MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacion" AS
SELECT
  pa.*,
  COALESCE(pc.coautorias, 0) AS coautorias
FROM (SELECT 
    max(pais) AS "paisInstitucion", 
    "paisInstitucionSlug", 
    count(DISTINCT i.slug) AS instituciones,
    count(DISTINCT a.slug) AS autores,
    count(DISTINCT i.sistema) AS documentos,
    count(DISTINCT t.id_disciplina) AS disciplinas
  FROM institution i
  INNER JOIN "vSearchFull" t 
    ON i.sistema=t.sistema
  LEFT JOIN author a 
    ON i.sistema=a.sistema 
    AND i.id=a."institucionId"
  WHERE i.slug IS NOT NULL AND i.pais IS NOT NULL GROUP BY "paisInstitucionSlug") pa
  LEFT JOIN (SELECT
    pa."paisInstitucionSlug",
    count(DISTINCT i."paisInstitucionSlug") AS coautorias
  FROM (SELECT 
      sistema, 
      "paisInstitucionSlug" 
    FROM institution  
    GROUP BY sistema, "paisInstitucionSlug") pa
  INNER JOIN institution i 
    ON pa.sistema=i.sistema AND pa."paisInstitucionSlug"<>i."paisInstitucionSlug"
  WHERE i.slug IS NOT NULL AND i.pais IS NOT NULL GROUP BY pa."paisInstitucionSlug")pc
ON pa."paisInstitucionSlug"=pc."paisInstitucionSlug";

--Frecuencia de documentos por: País de afiliacion -> intitucion
--DROP MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionInstitucion";
CREATE MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionInstitucion" AS
SELECT 
  max(pais) AS "paisInstitucion", 
  "paisInstitucionSlug", 
  max(institucion) AS institucion,
  i.slug AS "institucionSlug",
  count(DISTINCT i.sistema) AS documentos
FROM institution i
WHERE i.slug IS NOT NULL GROUP BY "paisInstitucionSlug", i.slug;

--Frecuencia de documentos por: País de afiliacion -> autor
--DROP MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionAutor";
CREATE MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionAutor" AS
SELECT 
  max(pais) AS "paisInstitucion", 
  "paisInstitucionSlug", 
  max(nombre) AS autor,
  a.slug AS "autorSlug",
  count(DISTINCT i.sistema) AS documentos
FROM institution i
INNER JOIN author a ON
  i.sistema=a.sistema AND
  i.id=a."institucionId"
WHERE i.slug IS NOT NULL GROUP BY "paisInstitucionSlug", a.slug;

--Frecuencia de documentos por: País de afiliacion -> disciplina
--DROP MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionDisciplina";
CREATE MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionDisciplina" AS
SELECT 
    i."paisInstitucionSlug", 
    s."disciplinaSlug",
    max(s."disciplinaRevista") AS disciplina,
    count(DISTINCT s.sistema) AS documentos
  FROM institution i
  INNER JOIN "vSearchFull" s ON i.sistema=s.sistema
WHERE i.slug IS NOT NULL
GROUP BY i."paisInstitucionSlug", s."disciplinaSlug";

--Frecuencia de documentos por: País de afiliacion -> coautoria
--DROP MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionCoautoria";
CREATE MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionCoautoria" AS
SELECT
    pa."paisInstitucionSlug",
    i."paisInstitucionSlug" AS "paisInstitucionCoSlug",
    max(i.pais) AS "paisInstitucionCoautoria",
    count(DISTINCT i.sistema) AS documentos
  FROM (SELECT 
      sistema, 
      "paisInstitucionSlug" 
    FROM institution  
    WHERE slug IS NOT NULL
    GROUP BY sistema, "paisInstitucionSlug") pa
  INNER JOIN institution i 
    ON pa.sistema=i.sistema AND pa."paisInstitucionSlug"<>i."paisInstitucionSlug"
  WHERE i.slug IS NOT NULL AND i.pais IS NOT NULL 
GROUP BY pa."paisInstitucionSlug", i."paisInstitucionSlug";

--Pais de afiliacion documentos
--DROP MATERIALIZED VIEW "mvPaisAfiliacionSI";
CREATE MATERIALIZED VIEW "mvPaisAfiliacionSI" AS
SELECT
  i.sistema,
  i."paisInstitucionSlug"
FROM institution i
GROUP BY i.sistema, "paisInstitucionSlug";

CREATE INDEX ON "mvPaisAfiliacionSI"(sistema);
CREATE INDEX ON "mvPaisAfiliacionSI"("paisInstitucionSlug");

--DROP VIEW "vPaisAfiliacionDocumentos";
CREATE VIEW "vPaisAfiliacionDocumentos" AS
SELECT 
  s.sistema,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  "paisRevista", 
  "anioRevista", 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url, 
  "disciplinaSlug",
  pi."paisInstitucionSlug",
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON" 
FROM "mvPaisAfiliacionSI" pi
INNER JOIN "vSearchFull" s ON pi.sistema=s.sistema;

--Pais de afiliacion/institucion documentos
--DROP MATERIALIZED VIEW "mvPaisAfiliacionInstitucionSI";
CREATE MATERIALIZED VIEW "mvPaisAfiliacionInstitucionSI" AS
SELECT
  i.sistema,
  i."paisInstitucionSlug",
  i.slug AS "institucionSlug"
FROM institution i
GROUP BY i.sistema, "paisInstitucionSlug", "institucionSlug";

CREATE INDEX ON "mvPaisAfiliacionInstitucionSI"(sistema);
CREATE INDEX ON "mvPaisAfiliacionInstitucionSI"("paisInstitucionSlug");
CREATE INDEX ON "mvPaisAfiliacionInstitucionSI"("institucionSlug");

--DROP VIEW "vPaisAfiliacionInstitucionDocumentos";
CREATE VIEW "vPaisAfiliacionInstitucionDocumentos" AS
SELECT 
  s.sistema,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  "paisRevista", 
  "anioRevista", 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url, 
  "disciplinaSlug",
  pi."paisInstitucionSlug",
  pi."institucionSlug",
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON" 
FROM "mvPaisAfiliacionInstitucionSI" pi
INNER JOIN "vSearchFull" s ON pi.sistema=s.sistema;

--Pais de afiliacion/autor documentos
--DROP MATERIALIZED VIEW "mvPaisAfiliacionAutorSI";
CREATE MATERIALIZED VIEW "mvPaisAfiliacionAutorSI" AS
SELECT
  i.sistema,
  i."paisInstitucionSlug",
  a.slug AS "autorSlug"
FROM institution i
LEFT JOIN author a ON
  i.sistema=a.sistema AND
  i.id=a."institucionId" AND
  a.slug IS NOT NULL
WHERE i.slug IS NOT NULL
GROUP BY i.sistema, "paisInstitucionSlug", "autorSlug";

CREATE INDEX ON "mvPaisAfiliacionAutorSI"(sistema);
CREATE INDEX ON "mvPaisAfiliacionAutorSI"("paisInstitucionSlug");
CREATE INDEX ON "mvPaisAfiliacionAutorSI"("autorSlug");

--DROP VIEW "vPaisAfiliacionAutorDocumentos";
CREATE VIEW "vPaisAfiliacionAutorDocumentos" AS
SELECT 
  s.sistema,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  "paisRevista", 
  "anioRevista", 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url, 
  "disciplinaSlug",
  pi."paisInstitucionSlug",
  pi."autorSlug",
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON" 
FROM "mvPaisAfiliacionAutorSI" pi
INNER JOIN "vSearchFull" s ON pi.sistema=s.sistema;

--Documentos en coautoria por país de afiliación
--DROP MATERIALIZED VIEW "mvPaisAfiliacionCoautoriaSI";
CREATE MATERIALIZED VIEW "mvPaisAfiliacionCoautoriaSI" AS
SELECT
    i.sistema,
    pa."paisInstitucionSlug",
    i."paisInstitucionSlug" AS "paisInstitucionCoSlug"
  FROM (SELECT 
      sistema, 
      "paisInstitucionSlug" 
    FROM institution  
    WHERE slug IS NOT NULL
    GROUP BY sistema, "paisInstitucionSlug") pa
  INNER JOIN institution i 
    ON pa.sistema=i.sistema AND pa."paisInstitucionSlug"<>i."paisInstitucionSlug"
  WHERE i.slug IS NOT NULL AND i.institucion IS NOT NULL 
GROUP BY i.sistema, pa."paisInstitucionSlug", i."paisInstitucionSlug";

CREATE INDEX ON "mvPaisAfiliacionCoautoriaSI"(sistema);
CREATE INDEX ON "mvPaisAfiliacionCoautoriaSI"("paisInstitucionSlug");
CREATE INDEX ON "mvPaisAfiliacionCoautoriaSI"("paisInstitucionCoSlug");

CREATE VIEW "vPaisAfiliacionCoautoriaDocumentos" AS
SELECT 
  s.sistema,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  "paisRevista", 
  "anioRevista", 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url, 
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON",
  pc."paisInstitucionSlug",
  pc."paisInstitucionCoSlug"
FROM "mvPaisAfiliacionCoautoriaSI" pc
INNER JOIN "vSearchFull" s 
  ON pc.sistema=s.sistema;

--Frecuencia de documentos, autores por revista
--DROP MATERIALIZED VIEW "mvFrecuenciaRevista";
CREATE MATERIALIZED VIEW "mvFrecuenciaRevista" AS
SELECT
  "revistaSlug",
  (array_agg(revista))[1] AS revista,
  sum(autores) AS autores,
  sum(anios) AS anios,
  sum(instituciones) AS instituciones,
  sum(documentos) AS documentos
FROM
  (SELECT 
    "revistaSlug",
    revista,
    count(DISTINCT a.slug) AS autores,
    count(DISTINCT s."anioRevista") AS anios,
    count(DISTINCT i.slug) AS instituciones,
    count(DISTINCT s.sistema) AS documentos
  FROM "vSearchFull" s 
  LEFT JOIN author a ON s.sistema=a.sistema
  LEFT JOIN institution i ON s.sistema=i.sistema AND i.slug IS NOT NULL
  WHERE "revistaSlug" IS NOT NULL 
  GROUP BY "revistaSlug", revista
  ORDER BY "revistaSlug", revista, documentos DESC) t
GROUP BY "revistaSlug";

--Frecuencia de documentos, autores por revista
--DROP MATERIALIZED VIEW "mvFrecuenciaRevistaAutor";
CREATE MATERIALIZED VIEW "mvFrecuenciaRevistaAutor" AS
SELECT
  "revistaSlug",
  "autorSlug",
  (array_agg(nombre))[1] AS autor,
  sum(documentos) AS documentos
FROM
  (SELECT 
    s."revistaSlug",
    a.nombre,
    a.slug AS "autorSlug",
    count(DISTINCT s.sistema) AS documentos
  FROM "vSearchFull" s 
  INNER JOIN author a ON s.sistema=a.sistema AND a.slug IS NOT NULL
  WHERE "revistaSlug" IS NOT NULL 
  GROUP BY "revistaSlug", "autorSlug", nombre
  ORDER BY "revistaSlug", "autorSlug", nombre, documentos DESC) t
GROUP BY "revistaSlug", "autorSlug";

--Frecuencia de documentos por revista -> años
--DROP MATERIALIZED VIEW "mvFrecuenciaRevistaAnio";
CREATE MATERIALIZED VIEW "mvFrecuenciaRevistaAnio" AS
SELECT 
  "revistaSlug",
  substr("anioRevista", 1, 4) AS anio,
  count(DISTINCT s.sistema) AS documentos
FROM "vSearchFull" s 
WHERE "revistaSlug" IS NOT NULL
GROUP BY "revistaSlug", anio;

--Frecuencia de documentos por revista -> años
--DROP MATERIALIZED VIEW "mvFrecuenciaRevistaInstitucion";
CREATE MATERIALIZED VIEW "mvFrecuenciaRevistaInstitucion" AS
SELECT
  "revistaSlug",
  "institucionSlug",
  (array_agg(institucion))[1] AS institucion,
  sum(documentos) AS documentos
FROM
  (SELECT 
    s."revistaSlug",
    i.slug AS "institucionSlug",
    institucion,
    count(DISTINCT s.sistema) AS documentos
  FROM "vSearchFull" s 
  LEFT JOIN institution i ON s.sistema=i.sistema
  WHERE "revistaSlug" IS NOT NULL AND i.slug IS NOT NULL 
  GROUP BY "revistaSlug", i.slug, institucion
  ORDER BY "revistaSlug", i.slug, institucion, documentos DESC) t
GROUP BY "revistaSlug", "institucionSlug";


SELECT slug, array_to_json(array_agg(institucion)) AS instituciones, array_to_json(array_agg(documentos)) AS documentos
FROM
  (SELECT 
  slug, 
  e_100u AS institucion, 
  count(*) AS documentos 
  FROM institucion 
  GROUP BY slug, e_100u
  ORDER BY slug, documentos DESC) tb
GROUP BY slug HAVING count(*) > 1

--DROP MATERIALIZED VIEW  "mvDisciplinasBase";
CREATE MATERIALIZED VIEW  "mvDisciplinasBase" AS 
 SELECT 
  substr(sistema, 1, 5) AS base,
    "disciplinaSlug",
    "disciplinaRevista"
   FROM "vSearchFull"
  GROUP BY substr(sistema, 1, 5), "disciplinaSlug", "disciplinaRevista"
  ORDER BY substr(sistema, 1, 5), "disciplinaSlug";

--Vista materializada de frecuencia por disciplina
--DROP  MATERIALIZED VIEW "mvFrecuenciaDisciplina";
CREATE MATERIALIZED VIEW "mvFrecuenciaDisciplina" AS
SELECT
  s.id_disciplina,
  s."disciplinaSlug",
  max(s."disciplinaRevista") AS "disciplinaRevista",
  count(DISTINCT s."paisRevista") AS paises,
  count(DISTINCT s.revista) AS revistas,
  count(DISTINCT s.sistema) AS documentos,
  count(DISTINCT i.slug) AS instituciones,
  count(DISTINCT i."paisInstitucionSlug") AS "paisesInstitucion"
FROM "vSearchFull" s
LEFT JOIN institution i ON s.sistema=i.sistema
GROUP BY s.id_disciplina, s."disciplinaSlug";

--Vista materializada de frecuencia disciplina/institución
--DROP MATERIALIZED VIEW "mvFrecuenciaDisciplinaInstitucion";
CREATE MATERIALIZED VIEW "mvFrecuenciaDisciplinaInstitucion" AS
SELECT
  "disciplinaSlug",
  "institucionSlug",
  (array_agg(institucion))[1] AS institucion,
  sum(documentos) AS documentos
FROM
  (SELECT 
    s."disciplinaSlug",
    i.slug AS "institucionSlug",
    institucion,
    count(DISTINCT i.sistema) AS documentos
    FROM institution i
  INNER JOIN "vSearchFull" s 
    ON i.sistema=s.sistema
  WHERE i.slug IS NOT NULL
  GROUP BY s."disciplinaSlug", i.slug, institucion
  ORDER BY s."disciplinaSlug", i.slug, institucion, documentos DESC) t
GROUP BY "disciplinaSlug", "institucionSlug";

--Vista materializada de frecuencia disciplina/país
--DROP MATERIALIZED VIEW "mvFrecuenciaDisciplinaPais";
CREATE MATERIALIZED VIEW "mvFrecuenciaDisciplinaPais" AS
SELECT
  "disciplinaSlug",
  "paisRevistaSlug",
  (array_agg("paisRevista"))[1] AS "paisRevista",
  sum(documentos) AS documentos
FROM
  (SELECT 
    "disciplinaSlug",
    "paisRevistaSlug",
    "paisRevista",
    count(DISTINCT sistema) AS documentos
  FROM "vSearchFull"
  GROUP BY "disciplinaSlug", "paisRevistaSlug", "paisRevista"
  ORDER BY "disciplinaSlug", "paisRevistaSlug", "paisRevista", documentos DESC) t
GROUP BY "disciplinaSlug", "paisRevistaSlug";

--Vista materializada de frecuencia disciplina/revista
--DROP MATERIALIZED VIEW "mvFrecuenciaDisciplinaRevista";
CREATE MATERIALIZED VIEW "mvFrecuenciaDisciplinaRevista" AS 
SELECT
  "disciplinaSlug",
  "revistaSlug",
  (array_agg(revista))[1] AS revista,
  sum(documentos) AS documentos
FROM
  (SELECT 
    "disciplinaSlug",
    "revistaSlug",
    revista,
    count(DISTINCT sistema) AS documentos
  FROM "vSearchFull"
  GROUP BY "disciplinaSlug", "revistaSlug", revista
  ORDER BY "disciplinaSlug", "revistaSlug", revista, documentos DESC) t
GROUP BY "disciplinaSlug", "revistaSlug";

--Vista para totales
--DROP MATERIALIZED VIEW "mvTotales";
CREATE MATERIALIZED VIEW "mvTotales" AS 
SELECT 
  count(*) AS documentos,
  count(DISTINCT "revistaSlug") AS revistas,
  count(DISTINCT url::text) AS enlaces,
  count(DISTINCT (CASE WHEN url::text ~~ '%hevila%' THEN url::text ELSE NULL END)) AS hevila
FROM "vSearchFull";

--DROP MATERIALIZED VIEW "mvInstitucion";
CREATE MATERIALIZED VIEW "mvInstitucion" AS 
SELECT
  slug,
  (array_agg(institucion))[1] AS institucion,
  "paisInstitucionSlug",
  (array_agg(pais))[1] AS pais,
  ciudad,
  sum(registros) AS registros
FROM
  (SELECT 
    slug_space(i.institucion) AS slug,
    i.institucion,
    i."paisInstitucionSlug",
    i.pais,
    i.ciudad,
    count(*) AS registros
   FROM institution i
  WHERE i.institucion IS NOT NULL
  GROUP BY i.institucion, i.ciudad, i.pais, "paisInstitucionSlug"
  ORDER BY slug, "paisInstitucionSlug", i.ciudad, registros DESC) t
GROUP BY slug, "paisInstitucionSlug", ciudad;
CREATE INDEX ON "mvInstitucion" USING gin(slug gin_trgm_ops);
  
--Drops
--SELECT drop_matview('"mvIndiceCoautoriaPricePais"');
--SELECT drop_matview('"mvTasaCoautoriaPais"');
--SELECT drop_matview('"mvPeriodosPaisTasaLawani"');
--SELECT drop_matview('"mvLawaniPais"');
--SELECT drop_matview('"mvSubramayanPais"');
--SELECT drop_matview('"mvPeriodosPaisSubramayan"');
--SELECT drop_matview('"mvZakutinaPais"');
--SELECT drop_matview('"mvPeriodosPaisCoautoriaPriceZakutina"');

--DROP VIEW "vIndiceCoautoriaPricePais" CASCADE;
--DROP VIEW "vSubramayanPais" CASCADE;
