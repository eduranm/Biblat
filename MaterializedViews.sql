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
CREATE MATERIALIZED VIEW "mvRevistaDisciplina" AS 
SELECT 
  iddatabase, 
  e_222 AS revista, 
  slug(e_222) AS "revistaSlug", 
  id_disciplina, 
  e_698 AS disciplina, 
  count(*) AS documentos 
FROM articulo GROUP BY iddatabase, e_222, id_disciplina, e_698;
--Vista para busquedas
--DROP MATERIALIZED VIEW "mvSearch";
CREATE MATERIALIZED VIEW "mvSearch" AS SELECT 
    t.sistema, 
    t.iddatabase, 
    t.e_245 AS articulo,
    slug(t.e_245) AS "articuloSlug",
    t.e_222 AS revista, 
    t."revistaSlug", 
    t.e_008 AS pais, 
    slug(t.e_008) AS "paisSlug", 
    t.e_022 AS issn, 
    t.e_041 AS idioma, 
    t.e_260b AS anio, 
    regexp_replace(t.e_300a, '.*?([0-9]+)', '\1')::varchar AS volumen, 
    regexp_replace(t.e_300b, '.*?([0-9]+)', '\1')::varchar AS numero, 
    initcap(t.e_300c)::varchar AS periodo, 
    regexp_replace(t.e_300e, '^.*?([0-9]+.*)', '\1')::varchar AS paginacion, 
    t.e_856u AS url, 
    t.e_590a AS "tipoDocumento",
    t.e_590b AS "enfoqueDocumento",
    t.id_disciplina,
    d.disciplina,
    d.slug AS "disciplinaSlug",
    array_to_json(a."autoresSecArray")::text AS "autoresSecJSON",
    array_to_json(a."autoresSecInstitucionArray")::text AS "autoresSecInstitucionJSON",
    array_to_json(a."autoresArray")::text AS "autoresJSON",
    a."autoresSlug",
    array_to_json(i."institucionesSecArray")::text AS "institucionesSecJSON",
    array_to_json(i."institucionesArray")::text AS "institucionesJSON",
    i."institucionesSlug",
    array_to_json(ad."idDisciplinasArray")::text AS "idDisciplinasJSON",
    array_to_json(ad."disciplinasArray")::text AS "disciplinasJSON",
    array_to_json(p."palabrasClaveArray")::text AS "palabrasClaveJSON",
    array_to_json(k."keywordArray")::text AS "keywordJSON",
    concat(p."palabrasClaveSlug", k."keywordSlug") AS "palabrasClaveSlug",
    concat(
        p."palabrasClaveSlug",
        k."keywordSlug",
        slug_space(t.e_245) || ' | ',
        slug_space(t.e_222) || ' | ',
        slug_space(t.e_008) || ' | ',
        i."institucionesSlug",
        a."autoresSlug"
      ) AS "generalSlug"
FROM articulo t
    LEFT JOIN (SELECT 
            at.iddatabase, 
            at.sistema, 
            array_agg(at.sec_institucion ORDER BY at.sec_autor) AS "autoresSecInstitucionArray",
            array_agg(at.sec_autor ORDER BY at.sec_autor) AS "autoresSecArray",
            array_agg(at.e_100a ORDER BY at.sec_autor) AS "autoresArray",
            string_agg(slug_space(at.e_100a), ' | ' ORDER BY at.sec_autor) || ' | ' AS "autoresSlug"
        FROM autor at
        GROUP BY at.iddatabase, at.sistema) a --Autores
    ON (t.iddatabase=a.iddatabase AND t.sistema=a.sistema) 
    LEFT JOIN (SELECT 
            it.iddatabase, 
            it.sistema, 
            array_agg(it.sec_institucion ORDER BY it.sec_institucion) AS "institucionesSecArray",
            array_agg(concat(it.e_100u, ', '||it.e_100v, ', '||e_100w, '. '||e_100x) ORDER BY it.sec_institucion) AS "institucionesArray",
            string_agg(slug_space(it.e_100u), ' | ' ORDER BY it.sec_institucion) || ' | ' AS "institucionesSlug"
        FROM institucion it
        GROUP BY it.iddatabase, it.sistema) i --Instituciones
    ON (t.iddatabase=i.iddatabase AND t.sistema=i.sistema)
    LEFT JOIN (SELECT 
            dt.iddatabase, 
            dt.sistema,
            array_agg(dt.iddisciplina ORDER BY dt.iddisciplina) AS "idDisciplinasArray",
            array_agg(dt.disciplina ORDER BY dt.iddisciplina) AS "disciplinasArray"
        FROM artidisciplina dt
        GROUP BY dt.iddatabase, dt.sistema) ad 
    ON (t.iddatabase=ad.iddatabase AND t.sistema=ad.sistema) 
    LEFT JOIN (SELECT 
        pt.iddatabase, 
        pt.sistema, 
        array_agg(pt.descpalabraclave ORDER BY pt.sec_palcve) AS "palabrasClaveArray", 
        string_agg(slug_space(pt.descpalabraclave), ' | ' ORDER BY pt.descpalabraclave) || ' | ' AS "palabrasClaveSlug"
        FROM palabraclave pt
        GROUP BY pt.iddatabase, pt.sistema) p 
    ON (t.iddatabase=p.iddatabase AND t.sistema=p.sistema)
    LEFT JOIN (SELECT
        kw.iddatabase, 
        kw.sistema, 
        array_agg(kw.desckeyword ORDER BY kw.sec_keyword) AS "keywordArray", 
        string_agg(slug_space(kw.desckeyword), ' | ' ORDER BY kw.desckeyword) || ' | ' AS "keywordSlug"
        FROM keyword kw
        GROUP BY kw.iddatabase, kw.sistema) k
    ON (t.iddatabase=k.iddatabase AND t.sistema=k.sistema)
    INNER JOIN disciplinas d 
    ON t.id_disciplina=d.id_disciplina;

CREATE INDEX "searchSistema_idx" ON "mvSearch"(sistema);
CREATE INDEX "searchIdDatabase_idx" ON "mvSearch"(iddatabase);
CREATE INDEX "searchSistemaIdDatabase_idx" ON "mvSearch"(sistema, iddatabase);
CREATE INDEX "searchIdDisciplina_idx" ON "mvSearch"(id_disciplina);
CREATE INDEX "searchTextoCompleto_idx" ON "mvSearch"(url);
CREATE INDEX "searchArticuloSlug_idx" ON "mvSearch"("articuloSlug");
CREATE INDEX "searchRevistaSlug_idx" ON "mvSearch"("revistaSlug");
CREATE INDEX "searchAlfabetico_idx" ON "mvSearch"(substring(LOWER(revista), 1, 1));
CREATE INDEX "searchHevila_idx" ON "mvSearch" USING gin(url gin_trgm_ops);
--CREATE INDEX "searchGeneralSlug_idx" ON "mvSearch" USING gin(("generalSlug"::tsvector));
CREATE INDEX "searchGeneralSlug_idx" ON "mvSearch" USING gin("generalSlug" gin_trgm_ops);
CREATE INDEX "searchAutoresSlug_idx" ON "mvSearch" USING gin("autoresSlug" gin_trgm_ops);
CREATE INDEX "searchArticuloSlugGin_idx" ON "mvSearch" USING gin("articuloSlug" gin_trgm_ops);
CREATE INDEX "searchRevistaSlugGin_idx" ON "mvSearch" USING gin("revistaSlug" gin_trgm_ops);
CREATE INDEX "searchPaisSlugGin_idx" ON "mvSearch" USING gin("paisSlug" gin_trgm_ops);
CREATE INDEX "searchPaisSlug_idx" ON "mvSearch"("paisSlug");
CREATE INDEX "searchInstitucionesSlug_idx" ON "mvSearch" USING gin("institucionesSlug" gin_trgm_ops);
CREATE INDEX "searchpalabrasClaveSlug_idx" ON "mvSearch" USING gin("palabrasClaveSlug" gin_trgm_ops);

--Vista con el contenido de la ficha del documento
CREATE OR REPLACE VIEW "fichaDocumento" AS
  SELECT 
    s.*,
    a."520" AS "resumenJSON" 
FROM "mvSearch" s
INNER JOIN 
  aleph_tags a
  ON a."035"=CASE iddatabase WHEN 0 THEN 'CLA01' ELSE 'PER01' END||sistema;

--Vista para lista de paises
CREATE MATERIALIZED VIEW "mvPais" AS 
SELECT
  "paisSlug",
  pais,
  count(*) AS total
  FROM  "mvSearch"
  GROUP BY "paisSlug", pais
  ORDER BY "paisSlug";

--Vista para disciplinas
CREATE MATERIALIZED VIEW "mvDisciplina" AS
SELECT DISTINCT 
  a.id_disciplina, 
  d.disciplina, 
  d.slug, 
  count(*) AS total
FROM articulo a INNER JOIN disciplinas d ON a.id_disciplina=d.id_disciplina
GROUP BY a.id_disciplina, d.disciplina, d.slug 
ORDER BY d.disciplina;

--Vista para las revistas por disciplina
CREATE MATERIALIZED VIEW "mvDisciplinaRevistas" AS
SELECT 
  e_222 AS revista,
  slug(e_222) AS "revistaSlug",
  id_disciplina, 
  count(*) AS documentos 
FROM articulo 
GROUP BY id_disciplina, e_222 
ORDER BY id_disciplina;


--Vista para mostrar solo los documentos que sean artículos y mostrando el año en una cadena de 4 digitos
CREATE OR REPLACE VIEW "vArticulos" AS
WITH articulos AS
  (SELECT 
    iddatabase,
    sistema,
    id_disciplina,
    e_222 AS revista,
    slug(e_222) AS "revistaSlug",
    e_300a,
    e_300b,
    substr(e_260b, 1, 4) AS anio,
    e_008 AS "paisRevista",
    slug(e_008) AS "paisRevistaSlug"
  FROM articulo WHERE 
    e_590a ~~ 'Artículo%' 
    AND substr(e_260b, 1, 4) ~ '[0-9]{4}' 
    AND slug(e_222)::varchar != ALL((SELECT array_agg("revistaSlug")::varchar[] FROM "revistasBacklist")::varchar[]))

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
CREATE OR REPLACE VIEW "vAutorIndicador" AS
SELECT a.*
FROM autor a
LEFT JOIN institucion i ON a.iddatabase=i.iddatabase
AND a.sistema=i.sistema
AND a.sec_autor=i.sec_autor
AND a.sec_institucion=i.sec_institucion
WHERE i.e_100x IS NOT NULL;

--Autores por documento
CREATE OR REPLACE VIEW "vAutoresDocumento" AS
SELECT * FROM
(SELECT a.iddatabase,
       a.sistema,
       count(*) AS autores,
       max(i.e_100x) AS e_100x

FROM autor a
LEFT JOIN institucion i ON a.iddatabase=i.iddatabase
AND a.sistema=i.sistema
AND a.sec_autor=i.sec_autor
AND a.sec_institucion=i.sec_institucion
GROUP BY a.iddatabase, a.sistema) AS ad WHERE ad.e_100x IS NOT NULL;

--Autores por documento y pais de aficialción
CREATE OR REPLACE VIEW "vAutoresDocumentoPais" AS
SELECT dp.iddatabase,
       dp.sistema,
       dp.e_100x,
       sum(ad.autores) AS autores
FROM
  (SELECT a.iddatabase,
          a.sistema,
          e_100x
   FROM autor a
   INNER JOIN institucion i ON a.iddatabase=i.iddatabase
   AND a.sistema=i.sistema
   AND a.sec_autor=i.sec_autor
   AND a.sec_institucion=i.sec_institucion
   WHERE e_100x IS NOT NULL
   GROUP BY a.iddatabase, a.sistema, e_100x) AS dp --dp => documento y pais de afiliacion
INNER JOIN
  (SELECT a.iddatabase,
          a.sistema,
          count(*) AS autores
   FROM autor a
   LEFT JOIN institucion i ON a.iddatabase=i.iddatabase
   AND a.sistema=i.sistema
   AND a.sec_autor=i.sec_autor
   AND a.sec_institucion=i.sec_institucion
   GROUP BY a.iddatabase, a.sistema) AS ad -- ad => autores por documento
ON dp.iddatabase=ad.iddatabase
AND dp.sistema=ad.sistema
GROUP BY dp.iddatabase, dp.sistema, dp.e_100x;

--Autores en revista
CREATE MATERIALIZED VIEW "mvAutorRevista" AS
SELECT 
  ar."revistaSlug",
  ar.anio,
  ai.e_100a AS autor,
  count(*) AS documentos
FROM "vAutorIndicador" ai
INNER JOIN "vArticulos" ar ON ai.iddatabase=ar.iddatabase AND ai.sistema=ar.sistema
GROUP BY "revistaSlug", anio, autor
ORDER BY "revistaSlug", anio, autor;

CREATE MATERIALIZED VIEW "mvAutorPais" AS
SELECT 
  ar."paisRevistaSlug",
  ar.anio,
  ai.e_100a AS autor,
  count(*) AS documentos
FROM "vAutorIndicador" ai
INNER JOIN "vArticulos" ar ON ai.iddatabase=ar.iddatabase AND ai.sistema=ar.sistema
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
INNER JOIN "vArticulos" ar ON au.iddatabase=ar.iddatabase AND au.sistema=ar.sistema
GROUP BY "revistaSlug", anio
ORDER BY "revistaSlug", anio;

CREATE INDEX "indiceCoautoriaPriceRevista_resvistaSlug" ON "mvIndiceCoautoriaPriceRevista"("revistaSlug");
CREATE INDEX "indiceCoautoriaPriceRevista_anio" ON "mvIndiceCoautoriaPriceRevista"(anio);

--Indice de coautoria por país de la revista
CREATE MATERIALIZED VIEW "mvIndiceCoautoriaPricePaisRevista" AS
SELECT ar.id_disciplina, max(ar."paisRevista") AS "paisRevista", ar."paisRevistaSlug", ar.anio, 
    count(*) AS documentos, sum(au.autores) AS autores, 
    sum(au.autores) / count(*)::numeric AS coautoria, 
    sqrt(sum(au.autores)) AS price
   FROM "vAutoresDocumento" au
   JOIN "vArticulos" ar ON au.iddatabase = ar.iddatabase AND au.sistema::text = ar.sistema::text
  GROUP BY ar.id_disciplina, ar."paisRevistaSlug", ar.anio
  ORDER BY ar.id_disciplina, ar."paisRevistaSlug", ar.anio;

CREATE INDEX "indiceCoautoriaPricePaisRevista_paisRevistaSlug" ON "mvIndiceCoautoriaPricePaisRevista"("paisRevistaSlug");
CREATE INDEX "indiceCoautoriaPricePaisRevista_anio" ON "mvIndiceCoautoriaPricePaisRevista"(anio);
CREATE INDEX "indiceCoautoriaPricePaisRevista_idDisciplina" ON "mvIndiceCoautoriaPricePaisRevista"(id_disciplina);

 
--Indice de coautoria por país del autor
CREATE MATERIALIZED VIEW "mvIndiceCoautoriaPricePaisAutor" AS
SELECT 
  au.e_100x AS "paisAutor", 
  slug(au.e_100x) AS "paisAutorSlug", 
  id_disciplina, 
  ar.anio, 
  count(*) AS documentos, 
  sum(au.autores) AS autores, 
  sum(au.autores) / count(*) AS coautoria,
  sqrt(sum(au.autores)) AS price
FROM "vAutoresDocumentoPais" au
INNER JOIN  "vArticulos" ar 
  ON au.iddatabase=ar.iddatabase AND au.sistema=ar.sistema
  GROUP BY "paisAutor", id_disciplina, anio
  ORDER BY "paisAutor", id_disciplina, anio;

CREATE INDEX "indiceCoautoriaPricePaisAutor_paisAutorSlug" ON "mvIndiceCoautoriaPricePaisAutor"("paisAutorSlug");
CREATE INDEX "indiceCoautoriaPricePaisAutor_anio" ON "mvIndiceCoautoriaPricePaisAutor"(anio);
CREATE INDEX "indiceCoautoriaPricePaisAutor_idDisciplina" ON "mvIndiceCoautoriaPricePaisAutor"(id_disciplina);

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
   INNER JOIN "vAutoresDocumento" au ON ar.iddatabase=au.iddatabase AND ar.sistema=au.sistema AND au.autores>1
   GROUP BY "revistaSlug", anio) AS tda --Total de documentos con mas de un autor
ON td."revistaSlug"=tda."revistaSlug" AND td.anio=tda.anio;

CREATE INDEX "tasaCoautoriaRevista_resvistaSlug" ON "mvTasaCoautoriaRevista"("revistaSlug");
CREATE INDEX "tasaCoautoriaRevista_anio" ON "mvTasaCoautoriaRevista"(anio);

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
   INNER JOIN "vAutoresDocumento" au ON ar.iddatabase=au.iddatabase AND ar.sistema=au.sistema AND au.autores>1
   GROUP BY ar.id_disciplina, "paisRevistaSlug", anio) AS tda --Total de documentos con mas de un autor
ON td.id_disciplina=tda.id_disciplina AND td."paisRevistaSlug"=tda."paisRevistaSlug" AND td.anio=tda.anio;

CREATE INDEX "tasaCoautoriaPaisRevista_resvistaSlug" ON "mvTasaCoautoriaPaisRevista"("paisRevistaSlug");
CREATE INDEX "tasaCoautoriaPaisRevista_anio" ON "mvTasaCoautoriaPaisRevista"(anio);
CREATE INDEX "tasaCoautoriaPaisRevista_idDisciplina" ON "mvTasaCoautoriaPaisRevista"(id_disciplina);

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
    slug(au.e_100x) AS "paisAutorSlug", 
    id_disciplina,
    anio,
    count(*) AS documentos
  FROM "vArticulos" ar
  INNER JOIN "vAutoresDocumentoPais" au
  ON ar.iddatabase=au.iddatabase AND ar.sistema=au.sistema AND au.autores>1
  GROUP BY "paisAutorSlug", id_disciplina, anio) AS tda --Documentos con más de un autor
ON td."paisAutorSlug"=tda."paisAutorSlug" AND td.id_disciplina=tda.id_disciplina AND td.anio=tda.anio;

CREATE INDEX "tasaCoautoriaPaisAutor_resvistaSlug" ON "mvTasaCoautoriaPaisAutor"("paisAutorSlug");
CREATE INDEX "tasaCoautoriaPaisAutor_anio" ON "mvTasaCoautoriaPaisAutor"(anio);
CREATE INDEX "tasaCoautoriaPaisAutor_idDisciplina" ON "mvTasaCoautoriaPaisAutor"(id_disciplina);

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
INNER JOIN "vArticulos" a ON ad.iddatabase=a.iddatabase
      AND ad.sistema=a.sistema
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
INNER JOIN "vArticulos" a ON ad.iddatabase=a.iddatabase
      AND ad.sistema=a.sistema
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
      slug(adp.e_100x) AS "paisAutorSlug",
      id_disciplina,
      anio,
      --autores, count(*) AS documentos,
      autores * count(*) AS "autoresXdocumentos"
    FROM "vAutoresDocumentoPais" adp
    INNER JOIN "vArticulos" a
    ON adp.iddatabase=a.iddatabase AND adp.sistema=a.sistema AND adp.autores>1
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
   INNER JOIN "vAutoresDocumento" au ON ar.iddatabase=au.iddatabase AND ar.sistema=au.sistema AND au.autores>1
   GROUP BY "revistaSlug", anio) am -- Autores multiples
INNER JOIN
(SELECT   ar."revistaSlug",
          ar.anio,
          count(*) AS documentos
   FROM "vArticulos" ar
   INNER JOIN "vAutoresDocumento" au ON ar.iddatabase=au.iddatabase AND ar.sistema=au.sistema AND au.autores=1
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
   INNER JOIN "vAutoresDocumento" au ON ar.iddatabase=au.iddatabase AND ar.sistema=au.sistema AND au.autores>1
   GROUP BY id_disciplina, "paisRevistaSlug", anio) am -- Autores multiples
INNER JOIN
(SELECT   ar.id_disciplina, 
    ar."paisRevistaSlug",
          ar.anio,
          count(*) AS documentos
   FROM "vArticulos" ar
   INNER JOIN "vAutoresDocumento" au ON ar.iddatabase=au.iddatabase AND ar.sistema=au.sistema AND au.autores=1
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
(SELECT "revistaSlug", anio, count(*) AS titulos FROM (SELECT "revistaSlug", anio, e_300a, e_300b FROM 
"vAutoresDocumento" ad 
INNER JOIN
"vArticulos" a
ON ad.iddatabase=a.iddatabase AND ad.sistema=a.sistema
GROUP BY "revistaSlug", anio, e_300a, e_300b) ravn -- Revista, año, volumen, numero

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
             e_300a,
             e_300b
      FROM "vAutoresDocumento" ad
      INNER JOIN "vArticulos" a ON ad.iddatabase=a.iddatabase
      AND ad.sistema=a.sistema
      GROUP BY id_disciplina,
         "paisRevistaSlug",
               anio,
               e_300a,
               e_300b) ravn -- Pais, año, volumen, numero
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
FROM
"vAutoresDocumento" ad
INNER JOIN 
"vArticulos" a
ON ad.iddatabase=a.iddatabase AND ad.sistema=a.sistema
GROUP BY "revistaSlug", id_disciplina HAVING count(*) > 25) ad --Articulos por disciplina
INNER JOIN
(SELECT 
  "revistaSlug", 
  id_disciplina,
  p.descpalabraclave AS descriptor, 
  count(*) AS frecuencia
FROM
"vAutoresDocumento" ad
INNER JOIN 
"vArticulos" a
ON ad.iddatabase=a.iddatabase AND ad.sistema=a.sistema
INNER JOIN palabraclave p
ON ad.iddatabase=p.iddatabase AND ad.sistema=p.sistema
WHERE p.sec_palcve < 3
GROUP BY "revistaSlug", id_disciplina, p.descpalabraclave) fd --Frecuencia del descriptor
ON ad."revistaSlug"=fd."revistaSlug" AND ad.id_disciplina=fd.id_disciplina) fdr
GROUP BY id_disciplina, "revistaSlug";

--Bradford

CREATE MATERIALIZED VIEW "mvDocumentosBradford" AS
SELECT 
  a.iddatabase,
  a.sistema
FROM "vAutoresDocumento" ad
INNER JOIN "vArticulos" a
  ON ad.iddatabase=a.iddatabase AND ad.sistema=a.sistema
GROUP BY a."revistaSlug", a.iddatabase, a.sistema;

CREATE OR REPLACE VIEW "vDocumentosBradfordFull" AS
SELECT   
  s.sistema,
  s.iddatabase,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  pais, 
  anio, 
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
INNER JOIN "mvSearch" s ON 
db.iddatabase=s.iddatabase AND db.sistema=s.sistema;

CREATE MATERIALIZED VIEW "mvArticulosDisciplinaRevista" AS
SELECT * FROM
(SELECT 
    a.id_disciplina, 
    a."revistaSlug", 
    max(a.revista) AS revista, 
    count(*) AS articulos
 FROM "vAutoresDocumento" ad
  INNER JOIN "vArticulos" a
    ON ad.iddatabase=a.iddatabase AND ad.sistema=a.sistema
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
        i.iddatabase, 
        i.sistema, 
        a.id_disciplina,
        max(i.e_100u) AS institucion,
        slug(i.e_100u) AS "institucionSlug"
      FROM  "vArticulos" a
      INNER JOIN institucion i
        ON a.iddatabase=i.iddatabase AND a.sistema=i.sistema
      WHERE i.e_100x IS NOT NULL AND i.e_100u IS NOT NULL
      GROUP BY i.iddatabase, i.sistema, a.id_disciplina, "institucionSlug") ai --Articulo institucion
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
  a.iddatabase, 
  a.sistema, max(i.e_100x) AS "paisAutor", 
  slug(i.e_100x) AS "paisAutorSlug", 
  count(*) AS autores
FROM autor a
     INNER JOIN institucion i ON a.iddatabase = i.iddatabase AND a.sistema=i.sistema AND a.sec_autor = i.sec_autor AND a.sec_institucion = i.sec_institucion
WHERE i.e_100x IS NOT NULL
GROUP BY a.iddatabase, a.sistema, slug(i.e_100x)) adp --Autores por documento y país
INNER JOIN "vArticulos" ar ON adp.iddatabase=ar.iddatabase AND adp.sistema=ar.sistema
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
  INNER JOIN "vArticulos" ar ON au.iddatabase=ar.iddatabase AND au.sistema=ar.sistema
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
       max(e_100a) AS autor, 
       slug AS "autorSlug", 
       count(DISTINCT (iddatabase, sistema)) AS documentos 
     FROM autor GROUP BY slug) a
LEFT JOIN (
  SELECT 
      aa.slug AS "autorSlug", 
      count(DISTINCT a.slug) AS coautorias 
  FROM
    (SELECT iddatabase, sistema, slug FROM autor  GROUP BY iddatabase, sistema, slug) aa
    INNER JOIN autor a ON aa.iddatabase=a.iddatabase AND aa.sistema=a.sistema AND aa.slug<>a.slug
    GROUP BY aa.slug) ac
ON a."autorSlug" = ac."autorSlug"
ORDER BY documentos DESC, "autorSlug";

CREATE INDEX "frecuencuaAutorDocumentos_autor" ON "mvFrecuenciaAutorDocumentos"(autor);
CREATE INDEX "frecuencuaAutorDocumentos_documentos" ON "mvFrecuenciaAutorDocumentos"(documentos);

--Autor documentos
CREATE OR REPLACE VIEW "vAutorDocumentos" AS
SELECT   
  s.sistema,
  s.iddatabase,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  pais, 
  anio, 
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
FROM autor a 
INNER JOIN "mvSearch" s ON 
a.iddatabase=s.iddatabase AND a.sistema=s.sistema;

--Revistas donde publica la institucion
CREATE OR REPLACE VIEW "vInstitucionRevistas" AS
SELECT 
  max(i.e_100u) AS insticuion,
  i.slug AS "institucionSlug",
  max(revista) AS revista,
  "revistaSlug"
FROM institucion i
INNER JOIN "mvSearch" s 
  ON i.iddatabase=s.iddatabase AND i.sistema=s.sistema
GROUP BY "institucionSlug", "revistaSlug";

--Frecuencia de coutores del autor
--DROP MATERIALIZED VIEW "mvFrecuenciaAutorCoautoria";
CREATE MATERIALIZED VIEW "mvFrecuenciaAutorCoautoria" AS
SELECT 
      aa.slug AS "autorSlug", 
      a.slug AS "autorCoSlug",
      max(a.e_100a) AS "autorCoautoria",
      count(DISTINCT (a.iddatabase, a.sistema)) AS documentos 
  FROM
    (SELECT iddatabase, sistema, slug FROM autor  GROUP BY iddatabase, sistema, slug) aa
    INNER JOIN autor a ON aa.iddatabase=a.iddatabase AND aa.sistema=a.sistema AND aa.slug<>a.slug
    GROUP BY aa.slug, a.slug;

CREATE INDEX ON "mvFrecuenciaAutorCoautoria"("autorSlug");
CREATE INDEX ON "mvFrecuenciaAutorCoautoria"("autorCoSlug");


--Documentos de couatorias por autor
CREATE MATERIALIZED VIEW "mvAutorCoautoriaSI" AS
SELECT 
      a.iddatabase, 
      a.sistema,
      aa.slug AS "autorSlug", 
      a.slug AS "autorCoSlug"
  FROM
    (SELECT iddatabase, sistema, slug FROM autor  GROUP BY iddatabase, sistema, slug) aa
    INNER JOIN autor a ON aa.iddatabase=a.iddatabase AND aa.sistema=a.sistema AND aa.slug<>a.slug
    GROUP BY a.iddatabase, a.sistema, aa.slug, a.slug;

CREATE INDEX "autorCoautoriaSI_idx" ON "mvAutorCoautoriaSI"(iddatabase, sistema);
CREATE INDEX "autorCoautoriaSIAutor_idx" ON "mvAutorCoautoriaSI"("autorSlug");
CREATE INDEX "autorCoautoriaSICoautor_idx" ON "mvAutorCoautoriaSI"("autorCoSlug");

CREATE VIEW "vAutorCoautoriaDocumentos" AS
SELECT   
  s.sistema,
  s.iddatabase,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  pais, 
  anio, 
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
INNER JOIN "mvSearch" s ON ac.iddatabase=s.iddatabase AND ac.sistema=s.sistema;

--Autores de la institucion
CREATE OR REPLACE VIEW "vInstitucionAutor" AS
SELECT 
  max(i.e_100u) AS insticuion,
  i.slug AS "institucionSlug",
  max(e_100a) AS autor,
  a.slug AS "autorSlug"
FROM institucion i
INNER JOIN "autor" a 
  ON i.iddatabase=a.iddatabase AND a.sistema=a.sistema AND i.sec_autor=a.sec_autor AND i.sec_institucion=a.sec_institucion
GROUP BY "institucionSlug", "autorSlug";

--Autores, documentos, revistas y paises por institucion
--DROP MATERIALIZED VIEW "mvFrecuenciaInstitucionDARP";
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionDARP" AS
SELECT 
  irpd.institucion, 
  irpd."institucionSlug", 
  irpd.revistas,
  irpd.paises,
  irpd.disciplinas,
  irpd.documentos,
  ia.autores,
  COALESCE(ic.coautorias, 0) AS coautorias
FROM
  (SELECT 
    max(e_100u) AS institucion, 
    i.slug AS "institucionSlug", 
    count(DISTINCT s."revistaSlug") AS revistas,
    count(DISTINCT s."paisSlug") AS paises,
    count(DISTINCT s.id_disciplina) AS disciplinas,
    count(DISTINCT (s.iddatabase, s.sistema)) AS documentos
     FROM institucion i
     JOIN "mvSearch" s ON i.iddatabase = s.iddatabase AND i.sistema=s.sistema
    GROUP BY i.slug) irpd --Institucion revistas, documentos, paises
INNER JOIN 
  (SELECT
    i.slug AS "institucionSlug",
    count(DISTINCT a.slug) AS autores
  FROM institucion i
  LEFT JOIN autor a ON
    i.iddatabase=a.iddatabase AND
    i.sistema=a.sistema AND
    i.sec_autor=a.sec_autor
  GROUP BY i.slug) ia --Institucion autores
ON irpd."institucionSlug"=ia."institucionSlug"
LEFT JOIN
  (SELECT 
      ia.slug AS "institucionSlug", 
      count(DISTINCT i.slug) AS coautorias 
  FROM
    (SELECT iddatabase, sistema, slug FROM institucion  GROUP BY iddatabase, sistema, slug) ia
    INNER JOIN institucion i ON ia.iddatabase=i.iddatabase AND ia.sistema=i.sistema AND ia.slug<>i.slug
    GROUP BY ia.slug) ic --Insticuones coautoria
ON irpd."institucionSlug"=ic."institucionSlug";

CREATE INDEX "idx_fInstitucionDARPInstitucion" ON "mvFrecuenciaInstitucionDARP"(institucion);
CREATE INDEX "idx_fInstitucionDARPDocumentos" ON "mvFrecuenciaInstitucionDARP"(documentos);

--Documentos por institucion -> país de publicación
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionPais" AS
SELECT 
  --max(i.e_100u) AS institucion,
  i.slug AS "institucionSlug",
  max(pais) AS pais,
  "paisSlug",
  count(DISTINCT (s.iddatabase, s.sistema)) AS documentos
FROM institucion i
INNER JOIN "mvSearch" s 
  ON i.iddatabase=s.iddatabase AND i.sistema=s.sistema
GROUP BY "institucionSlug", "paisSlug";


--Documentos por institucion -> revista
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionRevista" AS
SELECT 
  --max(i.e_100u) AS institucion,
  i.slug AS "institucionSlug",
  max(revista) AS revista,
  "revistaSlug",
  count(DISTINCT (s.iddatabase, s.sistema)) AS documentos
FROM institucion i
INNER JOIN "mvSearch" s 
  ON i.iddatabase=s.iddatabase AND i.sistema=s.sistema
GROUP BY "institucionSlug", "revistaSlug";


--Documentos por institucion -> autor
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionAutor" AS
SELECT
    max(i.e_100u) AS institucion,
    i.slug AS "institucionSlug",
    max(a.e_100a) AS autor,
    a.slug AS "autorSlug",
    count(DISTINCT (i.iddatabase, i.sistema)) AS documentos
  FROM institucion i
  INNER JOIN autor a ON
    i.iddatabase=a.iddatabase AND
    i.sistema=a.sistema AND
    i.sec_autor=a.sec_autor
  GROUP BY i.slug, a.slug;

--Documentos por institucion -> disciplina
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionDisciplina" AS
SELECT 
  max(i.e_100u) AS institucion,
  i.slug AS "institucionSlug",
  max(d.disciplina) AS disciplina,
  d.slug AS "disciplinaSlug",
  count(DISTINCT (a.iddatabase, a.sistema)) AS documentos
FROM institucion i
INNER JOIN articulo a 
  ON i.iddatabase=a.iddatabase AND i.sistema=a.sistema
INNER JOIN disciplinas d ON a.id_disciplina=d.id_disciplina
GROUP BY "institucionSlug", d.slug;

--Número de documentos por institucion -> coautoria
CREATE MATERIALIZED VIEW "mvFrecuenciaInstitucionCoautoria" AS
SELECT 
      ia.slug AS "institucionSlug", 
      i.slug AS "institucionCoSlug",
      max(i.e_100u) AS "institucionCoautoria",
      count(DISTINCT (i.iddatabase, i.sistema)) AS documentos 
  FROM
    (SELECT iddatabase, sistema, slug FROM institucion  GROUP BY iddatabase, sistema, slug) ia
    INNER JOIN institucion i ON ia.iddatabase=i.iddatabase AND ia.sistema=i.sistema AND ia.slug<>i.slug
    GROUP BY ia.slug, i.slug ORDER BY "institucionSlug", documentos DESC

--Institucion documentos
--DROP MATERIALIZED VIEW "mvInstucionDocumentos";
CREATE MATERIALIZED VIEW "mvInstucionDocumentos" AS
SELECT 
  s.sistema,
  s.iddatabase,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  pais, 
  "paisSlug",
  anio, 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url, 
  "disciplinaSlug",
  i.slug AS "institucionSlug",
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON" 
FROM institucion i 
INNER JOIN "mvSearch" s ON i.iddatabase=s.iddatabase AND i.sistema=s.sistema;

CREATE INDEX "idx_institucionDocumentos" ON "mvInstucionDocumentos"(iddatabase, sistema);
CREATE INDEX "idx_institucionDocumentosinstitucionSlug" ON "mvInstucionDocumentos"("institucionSlug");

--Institucion->autor documentos--
CREATE MATERIALIZED VIEW "mvInstucionAutorDocumentos" AS
SELECT
  s.sistema,
  s.iddatabase,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  pais, 
  anio, 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url, 
  i.slug AS "institucionSlug",
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON",
  a.slug AS "autorSlug"
  FROM institucion i
  INNER JOIN autor a ON
    i.iddatabase=a.iddatabase AND
    i.sistema=a.sistema AND
    i.sec_autor=a.sec_autor
  INNER JOIN "mvSearch" s ON i.iddatabase=s.iddatabase AND i.sistema=s.sistema;

--Documentos en coautoria con la isntitucion
CREATE MATERIALIZED VIEW "mvInstitucionCoautoriaSI" AS
SELECT 
      i.iddatabase, 
      i.sistema,
      ia.slug AS "institucionSlug", 
      i.slug AS "institucionCoSlug"
FROM
    (SELECT iddatabase, sistema, slug FROM institucion  GROUP BY iddatabase, sistema, slug) ia
    INNER JOIN institucion i ON ia.iddatabase=i.iddatabase AND ia.sistema=i.sistema AND ia.slug<>i.slug
    GROUP BY i.iddatabase, i.sistema, ia.slug, i.slug;

CREATE INDEX "institucionCoautoriaSI_idx" ON "mvInstitucionCoautoriaSI"(iddatabase, sistema);
CREATE INDEX "institucionCoautoriaSIInstitucion_idx" ON "mvInstitucionCoautoriaSI"("institucionSlug");
CREATE INDEX "institucionCoautoriaSIInstitucionCo_idx" ON "mvInstitucionCoautoriaSI"("institucionCoSlug");

CREATE VIEW "vInstucionCoautoriaDocumentos" AS
SELECT
  s.sistema,
  s.iddatabase,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  pais, 
  anio, 
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
  INNER JOIN "mvSearch" s ON ic.iddatabase=s.iddatabase AND ic.sistema=s.sistema;

--Frecuencia Pais de afiliacion del autor, total de documentos, autores, instituciones
--DROP MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacion";
CREATE MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacion" AS
SELECT
  pa.*,
  COALESCE(pc.coautorias, 0) AS coautorias
FROM (SELECT 
    max(e_100x) AS "paisInstitucion", 
    "paisInstitucionSlug", 
    count(DISTINCT i.slug) AS instituciones,
    count(DISTINCT a.slug) AS autores,
    count(DISTINCT (i.iddatabase, i.sistema)) AS documentos,
    count(DISTINCT t.id_disciplina) AS disciplinas
  FROM institucion i
  INNER JOIN articulo t 
    ON i.iddatabase=t.iddatabase AND
    i.sistema=t.sistema
  LEFT JOIN autor a ON
    i.iddatabase=a.iddatabase AND
    i.sistema=a.sistema AND
    i.sec_autor=a.sec_autor
  WHERE i.slug IS NOT NULL AND i.e_100x IS NOT NULL GROUP BY "paisInstitucionSlug") pa
  LEFT JOIN (SELECT
    pa."paisInstitucionSlug",
    count(DISTINCT i."paisInstitucionSlug") AS coautorias
  FROM (SELECT 
      iddatabase, 
      sistema, 
      "paisInstitucionSlug" 
    FROM institucion  
    GROUP BY iddatabase, sistema, "paisInstitucionSlug") pa
  INNER JOIN institucion i 
    ON pa.iddatabase=i.iddatabase AND pa.sistema=i.sistema AND pa."paisInstitucionSlug"<>i."paisInstitucionSlug"
  WHERE i.slug IS NOT NULL AND i.e_100x IS NOT NULL GROUP BY pa."paisInstitucionSlug")pc
ON pa."paisInstitucionSlug"=pc."paisInstitucionSlug";

--Frecuencia de documentos por: País de afiliacion -> intitucion
CREATE MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionInstitucion" AS
SELECT 
  max(e_100x) AS "paisInstitucion", 
  "paisInstitucionSlug", 
  max(e_100u) AS institucion,
  i.slug AS "institucionSlug",
  count(DISTINCT (i.iddatabase, i.sistema)) AS documentos
FROM institucion i
WHERE i.slug IS NOT NULL GROUP BY "paisInstitucionSlug", i.slug;

--Frecuencia de documentos por: País de afiliacion -> autor
CREATE MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionAutor" AS
SELECT 
  max(e_100x) AS "paisInstitucion", 
  "paisInstitucionSlug", 
  max(e_100a) AS autor,
  a.slug AS "autorSlug",
  count(DISTINCT (i.iddatabase, i.sistema)) AS documentos
FROM institucion i
INNER JOIN autor a ON
  i.iddatabase=a.iddatabase AND
  i.sistema=a.sistema AND
  i.sec_autor=a.sec_autor
WHERE i.slug IS NOT NULL GROUP BY "paisInstitucionSlug", a.slug;

--Frecuencia de documentos por: País de afiliacion -> disciplina
--DROP MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionDisciplina";
CREATE MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionDisciplina" AS
SELECT 
    i."paisInstitucionSlug", 
    s."disciplinaSlug",
    max(s.disciplina) AS disciplina,
    count(DISTINCT (s.iddatabase, s.sistema)) AS documentos
  FROM institucion i
  INNER JOIN "mvSearch" s ON i.iddatabase=s.iddatabase AND i.sistema=s.sistema
WHERE i.slug IS NOT NULL
GROUP BY i."paisInstitucionSlug", s."disciplinaSlug";
--Frecuencia de documentos por: País de afiliacion -> coautoria
--DROP MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionCoautoria";
CREATE MATERIALIZED VIEW "mvFrecuenciaPaisAfiliacionCoautoria" AS
SELECT
    pa."paisInstitucionSlug",
    i."paisInstitucionSlug" AS "paisInstitucionCoSlug",
    max(i.e_100x) AS "paisInstitucionCoautoria",
    count(DISTINCT (i.iddatabase, i.sistema)) AS documentos
  FROM (SELECT 
      iddatabase, 
      sistema, 
      "paisInstitucionSlug" 
    FROM institucion  
    WHERE slug IS NOT NULL
    GROUP BY iddatabase, sistema, "paisInstitucionSlug") pa
  INNER JOIN institucion i 
    ON pa.iddatabase=i.iddatabase AND pa.sistema=i.sistema AND pa."paisInstitucionSlug"<>i."paisInstitucionSlug"
  WHERE i.slug IS NOT NULL AND i.e_100x IS NOT NULL 
GROUP BY pa."paisInstitucionSlug", i."paisInstitucionSlug";

--Pais de afiliacion documentos
--DROP MATERIALIZED VIEW "mvPaisAfiliacionDocumentos";
CREATE MATERIALIZED VIEW "mvPaisAfiliacionDocumentos" AS
SELECT 
  s.sistema,
  s.iddatabase,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  pais, 
  anio, 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url, 
  "disciplinaSlug",
  i."paisInstitucionSlug",
  i.slug AS "institucionSlug",
  a.slug AS "autorSlug",
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON" 
FROM institucion i
INNER JOIN "mvSearch" s ON i.iddatabase=s.iddatabase AND i.sistema=s.sistema
LEFT JOIN autor a ON
  i.iddatabase=a.iddatabase AND
  i.sistema=a.sistema AND
  i.sec_autor=a.sec_autor AND
  a.slug IS NOT NULL
WHERE i.slug IS NOT NULL;

CREATE INDEX ON "mvPaisAfiliacionDocumentos"("paisInstitucionSlug");
CREATE INDEX ON "mvPaisAfiliacionDocumentos"(iddatabase, sistema);

--Documentos en coautoria por país de afiliación
CREATE MATERIALIZED VIEW "mvPaisAfiliacionSI" AS
SELECT
    i.iddatabase, 
    i.sistema,
    pa."paisInstitucionSlug",
    i."paisInstitucionSlug" AS "paisInstitucionCoSlug"
  FROM (SELECT 
      iddatabase, 
      sistema, 
      "paisInstitucionSlug" 
    FROM institucion  
    WHERE slug IS NOT NULL
    GROUP BY iddatabase, sistema, "paisInstitucionSlug") pa
  INNER JOIN institucion i 
    ON pa.iddatabase=i.iddatabase AND pa.sistema=i.sistema AND pa."paisInstitucionSlug"<>i."paisInstitucionSlug"
  WHERE i.slug IS NOT NULL AND i.e_100x IS NOT NULL 
GROUP BY i.iddatabase, i.sistema, pa."paisInstitucionSlug", i."paisInstitucionSlug";

CREATE INDEX ON "mvPaisAfiliacionSI"(iddatabase, sistema);
CREATE INDEX ON "mvPaisAfiliacionSI"("paisInstitucionSlug");
CREATE INDEX ON "mvPaisAfiliacionSI"("paisInstitucionCoSlug");

CREATE VIEW "vPaisAfiliacionDocumentosCoautoria" AS
SELECT 
  s.sistema,
  s.iddatabase,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  pais, 
  anio, 
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
FROM "mvPaisAfiliacionSI" pc
INNER JOIN "mvSearch" s 
  ON pc.iddatabase=s.iddatabase AND pc.sistema=s.sistema;

--Frecuencia de documentos, autores por revista
--DROP MATERIALIZED VIEW "mvFrecuenciaRevista";
CREATE MATERIALIZED VIEW "mvFrecuenciaRevista" AS
SELECT 
  max(revista) AS revista,
  "revistaSlug",
  count(DISTINCT a.slug) AS autores,
  count(DISTINCT s.anio) AS anios,
  count(DISTINCT i.slug) AS instituciones,
  count(DISTINCT(s.sistema, s.iddatabase)) AS documentos
FROM "mvSearch" s 
LEFT JOIN autor a ON s.sistema=a.sistema AND s.iddatabase=a.iddatabase
LEFT JOIN institucion i ON s.sistema=i.sistema AND s.iddatabase=i.iddatabase AND i.slug IS NOT NULL
WHERE "revistaSlug" IS NOT NULL GROUP BY "revistaSlug";

--Frecuencia de documentos, autores por revista
CREATE MATERIALIZED VIEW "mvFrecuenciaRevistaAutor" AS
SELECT 
  "revistaSlug",
  max(a.e_100a) AS autor,
  a.slug AS "autorSlug",
  count(DISTINCT(s.sistema, s.iddatabase)) AS documentos
FROM "mvSearch" s INNER JOIN autor a ON s.sistema=a.sistema AND s.iddatabase=a.iddatabase AND a.slug IS NOT NULL
WHERE "revistaSlug" IS NOT NULL GROUP BY "revistaSlug", "autorSlug";

--Frecuencia de documentos por revista -> años
CREATE MATERIALIZED VIEW "mvFrecuenciaRevistaAnio" AS
SELECT 
  "revistaSlug",
  anio,
  count(DISTINCT(s.sistema, s.iddatabase)) AS documentos
FROM "mvSearch" s 
WHERE "revistaSlug" IS NOT NULL
GROUP BY "revistaSlug", anio;

--Frecuencia de documentos por revista -> años
CREATE MATERIALIZED VIEW "mvFrecuenciaRevistaInstitucion" AS
SELECT 
  "revistaSlug",
  i.slug AS "institucionSlug",
  max(i.e_100u) AS institucion,
  count(DISTINCT(s.sistema, s.iddatabase)) AS documentos
FROM "mvSearch" s 
LEFT JOIN institucion i ON s.sistema=i.sistema AND s.iddatabase=i.iddatabase
WHERE "revistaSlug" IS NOT NULL AND i.slug IS NOT NULL 
GROUP BY "revistaSlug", i.slug;

--Revista documentos
--DROP MATERIALIZED VIEW "mvRevistaDocumentos";
CREATE MATERIALIZED VIEW "mvRevistaDocumentos" AS
SELECT 
  s.sistema,
  s.iddatabase,
  articulo, 
  "articuloSlug", 
  revista, 
  "revistaSlug", 
  pais, 
  anio, 
  volumen, 
  numero, 
  periodo, 
  paginacion, 
  url,
  a.slug AS "autorSlug",
  i.slug AS "institucionSlug",
  "autoresSecJSON",
  "autoresSecInstitucionJSON",
  "autoresJSON",
  "institucionesSecJSON",
  "institucionesJSON" 
FROM "mvSearch" s
LEFT JOIN autor a ON 
  s.sistema=a.sistema AND
  s.iddatabase=a.iddatabase AND
  a.slug IS NOT NULL
LEFT JOIN institucion i ON s.sistema=i.sistema AND s.iddatabase=i.iddatabase
WHERE s.revista IS NOT NULL;

CREATE INDEX "idx_revistaDocumentos" ON "mvRevistaDocumentos"("revistaSlug");




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

CREATE OR REPLACE VIEW "vDisciplinasBase" AS 
 SELECT articulo.iddatabase,
    disciplinas.disciplina,
    disciplinas.slug
   FROM disciplinas
   JOIN articulo ON disciplinas.id_disciplina = articulo.id_disciplina AND disciplinas.id_disciplina <> 23::numeric
  GROUP BY disciplinas.slug, disciplinas.disciplina, articulo.iddatabase
  ORDER BY articulo.iddatabase, disciplinas.slug;
  
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
