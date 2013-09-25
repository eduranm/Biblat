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
  FOR matview IN SELECT mv_name FROM matviews LOOP
    sql :='SELECT refresh_matview('''||matview.mv_name||''')';
    RAISE NOTICE 'EXECUTE: %', sql;
    EXECUTE sql;
  END LOOP;
RETURN;
END
$$
LANGUAGE plpgsql;


--Vista para busquedas
CREATE OR REPLACE VIEW "vSearch" AS SELECT 
    t.sistema, 
    t.iddatabase, 
    t.e_245 AS articulo,
    slug(t.e_245) AS "articuloSlug",
    t.e_222 AS revista, 
    slug(t.e_222) AS "revistaSlug", 
    t.e_008 AS pais, 
    slug(t.e_008) AS "paisSlug", 
    t.e_022 AS issn, 
    t.e_041 AS idioma, 
    t.e_260b AS anio, 
    t.e_300a AS volumen, 
    t.e_300b AS numero, 
    t.e_300c AS periodo, 
    t.e_300e AS paginacion, 
    t.e_856u AS url, 
    t.e_590a AS "tipoDocumento",
    t.e_590b AS "enfoqueDocumento",
    t.id_disciplina,
    array_to_json(a."autoresSecArray")::text AS "autoresSecJSON",
    array_to_json(a."autoresSecInstitucionArray")::text AS "autoresSecInstitucionJSON",
    array_to_json(a."autoresArray")::text AS "autoresJSON",
    a."autoresSlug",
    array_to_json(i."institucionesSecArray")::text AS "institucionesSecJSON",
    array_to_json(i."institucionesArray")::text AS "institucionesJSON",
    i."institucionesSlug",
    array_to_json(d."idDisciplinasArray")::text AS "idDisciplinasJSON",
    array_to_json(d."disciplinasArray")::text AS "disciplinasJSON",
    array_to_json(p."palabrasClaveArray")::text AS "palabrasClaveJSON",
    p."palabrasClaveSlug",
    (COALESCE(p."palabrasClaveSlug", '') || 
        COALESCE(slug_space(t.e_245) || ' | ', '') || 
        COALESCE(slug_space(t.e_222) || ' | ', '') || 
        COALESCE(slug_space(t.e_008) || ' | ', '') || 
        COALESCE(i."institucionesSlug", '') || 
        COALESCE(a."autoresSlug", ''))  AS "generalSlug"
FROM articulo t
    LEFT JOIN (SELECT 
            at.iddatabase, 
            at.sistema, 
            array_agg(at.sec_institucion ORDER BY at.sec_autor) AS "autoresSecInstitucionArray",
            array_agg(at.sec_autor ORDER BY at.sec_autor) AS "autoresSecArray",
            array_agg(at.e_100a ORDER BY at.sec_autor) AS "autoresArray",
            string_agg(slug_space(at.e_100a), ' | ' ORDER BY at.sec_autor) || ' | ' AS "autoresSlug"
        FROM autor at
        GROUP BY at.iddatabase, at.sistema) a 
    ON (t.iddatabase=a.iddatabase AND t.sistema=a.sistema) 
    LEFT JOIN (SELECT 
            it.iddatabase, 
            it.sistema, 
            array_agg(it.sec_institucion ORDER BY it.sec_institucion) AS "institucionesSecArray",
            array_agg(it.e_100u ORDER BY it.sec_institucion) AS "institucionesArray",
            string_agg(slug_space(it.e_100u), ' | ' ORDER BY it.sec_institucion) || ' | ' AS "institucionesSlug"
        FROM institucion it
        GROUP BY it.iddatabase, it.sistema) i 
    ON (t.iddatabase=i.iddatabase AND t.sistema=i.sistema)
    LEFT JOIN (SELECT 
            dt.iddatabase, 
            dt.sistema,
            array_agg(dt.iddisciplina ORDER BY dt.iddisciplina) AS "idDisciplinasArray",
            array_agg(dt.disciplina ORDER BY dt.iddisciplina) AS "disciplinasArray"
        FROM artidisciplina dt
        GROUP BY dt.iddatabase, dt.sistema) d 
    ON (t.iddatabase=d.iddatabase AND t.sistema=d.sistema) 
    LEFT JOIN (SELECT 
        pt.iddatabase, 
        pt.sistema, 
        array_agg(pt.descpalabraclave ORDER BY pt.descpalabraclave) AS "palabrasClaveArray", 
        string_agg(slug_space(pt.descpalabraclave), ' | ' ORDER BY pt.descpalabraclave) || ' | ' AS "palabrasClaveSlug"
        FROM palabraclave pt
        GROUP BY pt.iddatabase, pt.sistema) p 
    ON (t.iddatabase=p.iddatabase AND t.sistema=p.sistema);


SELECT create_matview('"mvSearch"', '"vSearch"');

CREATE INDEX "searchSistema_idx" ON "mvSearch"(sistema);
CREATE INDEX "searchIdDatabase_idx" ON "mvSearch"(iddatabase);
CREATE INDEX "searchSistemaIdDatabase_idx" ON "mvSearch"(sistema, iddatabase);
CREATE INDEX "searchIdDisciplina_idx" ON "mvSearch"(id_disciplina);
CREATE INDEX "searchTextoCompleto_idx" ON "mvSearch"(url);
CREATE INDEX "searchArticuloSlug_idx" ON "mvSearch"("articuloSlug");
CREATE INDEX "searchRevistaSlug_idx" ON "mvSearch"("revistaSlug");
CREATE INDEX "searchAlfabetico_idx" ON "mvSearch"(substring(LOWER(revista), 1, 1));
CREATE INDEX "searchHevila_idx" ON "mvSearch" USING gin(url gin_trgm_ops);
#CREATE INDEX "searchGeneralSlug_idx" ON "mvSearch" USING gin(("generalSlug"::tsvector));
CREATE INDEX "searchGeneralSlug_idx" ON "mvSearch" USING gin("generalSlug" gin_trgm_ops);
CREATE INDEX "searchAutoresSlug_idx" ON "mvSearch" USING gin("autoresSlug" gin_trgm_ops);
CREATE INDEX "searchArticuloSlugGin_idx" ON "mvSearch" USING gin("articuloSlug" gin_trgm_ops);
CREATE INDEX "searchRevistaSlugGin_idx" ON "mvSearch" USING gin("revistaSlug" gin_trgm_ops);
CREATE INDEX "searchPaisSlug_idx" ON "mvSearch" USING gin("paisSlug" gin_trgm_ops);
CREATE INDEX "searchInstitucionesSlug_idx" ON "mvSearch" USING gin("institucionesSlug" gin_trgm_ops);

CREATE OR REPLACE VIEW "vSearchFields" AS SELECT 
    t.sistema, 
    t.iddatabase, 
    unnest(
        array_cat(    
          array_cat(
              array_append(
                array_append(
                    array_append(p."palabrasClaveArray", slug_space(t.e_245)),
                    slug_space(t.e_222)
                ),
                slug_space(t.e_008)
              ),
              i."institucionesArray"
          ),
          a."autoresArray"
        )
    ) AS "singleFields"
FROM articulo t
    LEFT JOIN (SELECT 
            at.iddatabase, 
            at.sistema, 
            array_agg(slug_space(at.e_100a) ORDER BY at.sec_autor) AS "autoresArray"
        FROM autor at
        GROUP BY at.iddatabase, at.sistema) a 
    ON (t.iddatabase=a.iddatabase AND t.sistema=a.sistema) 
    LEFT JOIN (SELECT 
            it.iddatabase, 
            it.sistema, 
            array_agg(slug_space(it.e_100u) ORDER BY it.sec_institucion) AS "institucionesArray"
        FROM institucion it
        GROUP BY it.iddatabase, it.sistema) i 
    ON (t.iddatabase=i.iddatabase AND t.sistema=i.sistema)
    LEFT JOIN (SELECT 
        pt.iddatabase, 
        pt.sistema, 
        array_agg(slug_space(pt.descpalabraclave) ORDER BY pt.descpalabraclave) AS "palabrasClaveArray"
        FROM palabraclave pt
        GROUP BY pt.iddatabase, pt.sistema) p 
    ON (t.iddatabase=p.iddatabase AND t.sistema=p.sistema);

SELECT create_matview('"mvSearchFields"', '"vSearchFields"');

CREATE INDEX "searchFieldSistema_idx" ON "mvSearchFields"(sistema);
CREATE INDEX "searchFieldIdDatabase_idx" ON "mvSearchFields"(iddatabase);
CREATE INDEX "searchFieldSistemaIdDatabase_idx" ON "mvSearchFields"(sistema, iddatabase);
#CREATE INDEX "searchSingleFields_idx" ON "mvSearchFields" USING gin(("singleFields"::tsvector));
CREATE INDEX "searchSingleFields_idx" ON "mvSearchFields" USING gin("singleFields" gin_trgm_ops);

--Vista para lista de paises
CREATE OR REPLACE VIEW "vPais" AS 
SELECT
  "paisSlug",
  pais,
  count(*) as total
  FROM  "vSearch"
  GROUP BY "paisSlug", pais
  ORDER BY "paisSlug";

SELECT create_matview('"mvPais"', '"vPais"');

--Vista para disciplinas
CREATE OR REPLACE VIEW "vDisciplina" AS
SELECT DISTINCT 
  a.id_disciplina, 
  d.disciplina, 
  d.slug, 
  count(*) as total
FROM articulo a INNER JOIN disciplinas d ON a.id_disciplina=d.id_disciplina
GROUP BY a.id_disciplina, d.disciplina, d.slug 
ORDER BY d.disciplina;

SELECT create_matview('"mvDisciplina"', '"vDisciplina"');

--Vista para las revistas por disciplina
CREATE OR REPLACE VIEW "vDisciplinaRevistas" AS
SELECT 
  e_222 as revista, 
  id_disciplina, 
  count(*) as documentos 
FROM articulo 
GROUP BY id_disciplina, e_222 
ORDER BY id_disciplina;

SELECT create_matview('"mvDisciplinaRevistas"', '"vDisciplinaRevistas"');


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


--Indice de coautoria por revista
CREATE OR REPLACE VIEW "vIndiceCoautoriaPriceRevista" AS
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

SELECT create_matview('"mvIndiceCoautoriaPriceRevista"', '"vIndiceCoautoriaPriceRevista"');
CREATE INDEX "indiceCoautoriaPriceRevista_resvistaSlug" ON "mvIndiceCoautoriaPriceRevista"("revistaSlug");
CREATE INDEX "indiceCoautoriaPriceRevista_anio" ON "mvIndiceCoautoriaPriceRevista"(anio);

--Indice de coautoria por país
CREATE OR REPLACE VIEW "vIndiceCoautoriaPricePais" AS
SELECT ar.id_disciplina, max(ar."paisRevista") AS "paisRevista", ar."paisRevistaSlug", ar.anio, 
    count(*) AS documentos, sum(au.autores) AS autores, 
    sum(au.autores) / count(*)::numeric AS coautoria, 
    sqrt(sum(au.autores)) AS price
   FROM "vAutoresDocumento" au
   JOIN "vArticulos" ar ON au.iddatabase = ar.iddatabase AND au.sistema::text = ar.sistema::text
  GROUP BY ar.id_disciplina, ar."paisRevistaSlug", ar.anio
  ORDER BY ar.id_disciplina, ar."paisRevistaSlug", ar.anio;

SELECT create_matview('"mvIndiceCoautoriaPricePais"', '"vIndiceCoautoriaPricePais"');
CREATE INDEX "indiceCoautoriaPricePais_paisRevistaSlug" ON "mvIndiceCoautoriaPricePais"("paisRevistaSlug");
CREATE INDEX "indiceCoautoriaPricePais_anio" ON "mvIndiceCoautoriaPricePais"(anio);
CREATE INDEX "indiceCoautoriaPricePais_idDisciplina" ON "mvIndiceCoautoriaPricePais"(id_disciplina);

--Vista para revistans con años continuos mayores a 4
CREATE OR REPLACE VIEW "vPeriodosRevistaCoautoriaPriceZakutina" AS
SELECT dr.revista,
       dr."revistaSlug",
       dr.id_disciplina,
       dr.documentos,
       ac.anios_continuos
FROM
  (SELECT "revistaSlug",
          anios_continuos(array_agg(anio))
   FROM "vIndiceCoautoriaPriceRevista"
   GROUP BY "revistaSlug") AS ac --Años continuos por revista
INNER JOIN "vDisciplinaRevistas" dr ON ac."revistaSlug"=dr."revistaSlug"
WHERE anios_continuos > 4;

SELECT create_matview('"mvPeriodosRevistaCoautoriaPriceZakutina"', '"vPeriodosRevistaCoautoriaPriceZakutina"');

--Vista para paises con años continuos mayores a 4
CREATE OR REPLACE VIEW "vPeriodosPaisCoautoriaPriceZakutina" AS
SELECT *
FROM
  (SELECT id_disciplina,
    max("paisRevista") AS "paisRevista",
          "paisRevistaSlug",
          anios_continuos(array_agg(anio))
   FROM "vIndiceCoautoriaPricePais"
   GROUP BY id_disciplina,
      "paisRevistaSlug"
   ORDER BY id_disciplina,
     "paisRevistaSlug") AS ac --Años continuos por revista
WHERE anios_continuos > 4;


SELECT create_matview('"mvPeriodosPaisCoautoriaPriceZakutina"', '"vPeriodosPaisCoautoriaPriceZakutina"');

--Vista para tasa de coutoria por revista
CREATE OR REPLACE VIEW "vTasaCoautoriaRevista" AS
SELECT td.revista,
       td."revistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       tda.documentos AS "documentosMultiple",
       (tda.documentos::numeric/td.documentos::numeric) AS "tasaCoautoria"
FROM "vIndiceCoautoriaPriceRevista" td --Total de documentos
INNER JOIN
  (SELECT ar."revistaSlug",
          ar.anio,
          count(*) AS documentos
   FROM "vArticulos" ar
   INNER JOIN "vAutoresDocumento" au ON ar.iddatabase=au.iddatabase AND ar.sistema=au.sistema AND au.autores>1
   GROUP BY "revistaSlug", anio) AS tda --Total de documentos con mas de un autor
ON td."revistaSlug"=tda."revistaSlug" AND td.anio=tda.anio;


SELECT create_matview('"mvTasaCoautoriaRevista"', '"vTasaCoautoriaRevista"');
CREATE INDEX "tasaCoautoriaRevista_resvistaSlug" ON "mvTasaCoautoriaRevista"("revistaSlug");
CREATE INDEX "tasaCoautoriaRevista_anio" ON "mvTasaCoautoriaRevista"(anio);

--Vista para tasa de coutoria por pais
CREATE OR REPLACE VIEW "vTasaCoautoriaPais" AS
SELECT td.id_disciplina,
       td."paisRevista",
       td."paisRevistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       tda.documentos AS "documentosMultiple",
       (tda.documentos::numeric/td.documentos::numeric) AS "tasaCoautoria"
FROM "vIndiceCoautoriaPricePais" td --Total de documentos
INNER JOIN
  (SELECT ar.id_disciplina,
    ar."paisRevistaSlug",
          ar.anio,
          count(*) AS documentos
   FROM "vArticulos" ar
   INNER JOIN "vAutoresDocumento" au ON ar.iddatabase=au.iddatabase AND ar.sistema=au.sistema AND au.autores>1
   GROUP BY ar.id_disciplina, "paisRevistaSlug", anio) AS tda --Total de documentos con mas de un autor
ON td.id_disciplina=tda.id_disciplina AND td."paisRevistaSlug"=tda."paisRevistaSlug" AND td.anio=tda.anio;

SELECT create_matview('"mvTasaCoautoriaPais"', '"vTasaCoautoriaPais"');
CREATE INDEX "tasaCoautoriaPais_resvistaSlug" ON "mvTasaCoautoriaPais"("paisRevistaSlug");
CREATE INDEX "tasaCoautoriaPais_anio" ON "mvTasaCoautoriaPais"(anio);
CREATE INDEX "tasaCoautoriaPais_idDisciplina" ON "mvTasaCoautoriaPais"(id_disciplina);

-- Vista para periodos en reivistas para los indicadores Tasa de coautoría e Indice Lawani
CREATE OR REPLACE VIEW "vPeriodosRevistaTasaLawani" AS
SELECT dr.revista,
       dr."revistaSlug",
       dr.id_disciplina,
       dr.documentos,
       ac.anios_continuos
FROM
  (SELECT "revistaSlug",
          anios_continuos(array_agg(anio))
   FROM "vTasaCoautoriaRevista"
   GROUP BY "revistaSlug") AS ac --Años continuos por revista
INNER JOIN "vDisciplinaRevistas" dr ON ac."revistaSlug"=dr."revistaSlug"
WHERE anios_continuos > 4;

SELECT create_matview('"mvPeriodosRevistaTasaLawani"', '"vPeriodosRevistaTasaLawani"');

-- Vista para periodos en paises para los indicadores Tasa de coautoría e Indice Lawani
CREATE OR REPLACE VIEW "vPeriodosPaisTasaLawani" AS
SELECT *
FROM
  (SELECT "paisRevista",
          "paisRevistaSlug",
          id_disciplina,
          anios_continuos(array_agg(anio))
   FROM "vTasaCoautoriaPais"
   GROUP BY "paisRevistaSlug",
            "paisRevista",
            id_disciplina
   ORDER BY "paisRevistaSlug",
            id_disciplina) AS ac --Años continuos por revista
WHERE anios_continuos > 4;


SELECT create_matview('"mvPeriodosPaisTasaLawani"', '"vPeriodosPaisTasaLawani"');

--Vista lawani por revista
CREATE OR REPLACE VIEW "vLawaniRevista" AS
SELECT td.revista,
       td."revistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       sad."autoresXdocumentos",
       sad."autoresXdocumentos"::numeric/td.documentos::numeric AS lawani
FROM "vIndiceCoautoriaPriceRevista" td --Total de documentos
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

SELECT create_matview('"mvLawaniRevista"', '"vLawaniRevista"');

--Vista lawani por país
CREATE OR REPLACE VIEW "vLawaniPais" AS
SELECT td.id_disciplina,
       td."paisRevista",
       td."paisRevistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       sad."autoresXdocumentos",
       sad."autoresXdocumentos"::numeric/td.documentos::numeric AS lawani
FROM "vIndiceCoautoriaPricePais" td --Total de documentos
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

SELECT create_matview('"mvLawaniPais"', '"vLawaniPais"');

-- Vista para inide subramayan por revista
CREATE OR REPLACE VIEW "vSubramayanRevista" AS
SELECT
  am.revista,
  am."revistaSlug",
  am.anio,
  am.documentos AS "documentosMultiple",
  au.documentos AS "documentosUnAutor",
  am.documentos::numeric/(au.documentos+am.documentos)::numeric AS subramayan
FROM
(SELECT max(ar.revista) as revista,
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

SELECT create_matview('"mvSubramayanRevista"', '"vSubramayanRevista"');

--Vista para indice subramayan por país
CREATE OR REPLACE VIEW "vSubramayanPais" AS
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
    max(ar."paisRevista") as "paisRevista",
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

SELECT create_matview('"mvSubramayanPais"', '"vSubramayanPais"');

-- Vista para periodos en reivistas para en indicador subramayab
CREATE OR REPLACE VIEW "vPeriodosRevistaSubramayan" AS
SELECT dr.revista,
       dr."revistaSlug",
       dr.id_disciplina,
       dr.documentos,
       ac.anios_continuos
FROM
  (SELECT "revistaSlug",
          anios_continuos(array_agg(anio))
   FROM "vSubramayanRevista"
   GROUP BY "revistaSlug") AS ac --Años continuos por revista
INNER JOIN "vDisciplinaRevistas" dr ON ac."revistaSlug"=dr."revistaSlug"
WHERE anios_continuos > 4;

SELECT create_matview('"mvPeriodosRevistaSubramayan"', '"vPeriodosRevistaSubramayan"');

--Vista para periodos en paises para el indicador subramayan
CREATE OR REPLACE VIEW "vPeriodosPaisSubramayan" AS
SELECT *
FROM
  (SELECT "paisAutor",
          "paisAutorSlug",
          id_disciplina,
          anios_continuos(array_agg(anio))
   FROM "vSubramayanPais"
   GROUP BY "paisAutorSlug",
            "paisAutor",
            id_disciplina
   ORDER BY "paisAutorSlug",
            id_disciplina) AS ac --Años continuos por revista
WHERE anios_continuos > 4;


SELECT create_matview('"mvPeriodosPaisSubramayan"', '"vPeriodosPaisSubramayan"');

-- Vista para inidice zakutina por revista

CREATE OR REPLACE VIEW "vZakutinaRevista" AS
SELECT td.revista,
       td."revistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       t.titulos,
       (td.documentos::numeric/t.titulos::numeric) AS zakutina
FROM "vIndiceCoautoriaPriceRevista" td --Total de documentos
INNER JOIN
(SELECT "revistaSlug", anio, count(*) AS titulos FROM (SELECT "revistaSlug", anio, e_300a, e_300b FROM 
"vAutoresDocumento" ad 
INNER JOIN
"vArticulos" a
ON ad.iddatabase=a.iddatabase AND ad.sistema=a.sistema
GROUP BY "revistaSlug", anio, e_300a, e_300b) ravn -- Revista, año, volumen, numero

GROUP BY "revistaSlug", anio) t --Titulos por revista al año
ON td."revistaSlug"=t."revistaSlug" AND td.anio=t.anio;

SELECT create_matview('"mvZakutinaRevista"', '"vZakutinaRevista"');

--Vista para indice zakutina por país
CREATE OR REPLACE VIEW "vZakutinaPais" AS
SELECT td.id_disciplina,
       td."paisRevista",
       td."paisRevistaSlug",
       td.anio,
       td.documentos AS "totalDocumentos",
       t.titulos,
       (td.documentos::numeric/t.titulos::numeric) AS zakutina
FROM "vIndiceCoautoriaPricePais" td --Total de documentos
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

SELECT create_matview('"mvZakutinaPais"', '"vZakutinaPais"');

--Vista para indice Pratt
CREATE OR REPLACE VIEW "vPratt" AS
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
  p.descpalabraclave as descriptor, 
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

SELECT create_matview('"mvPratt"', '"vPratt"');

--Bradford
CREATE OR REPLACE VIEW "vArticulosDisciplinaRevista" AS
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

SELECT create_matview('"mvArticulosDisciplinaRevista"', '"vArticulosDisciplinaRevista"');

CREATE OR REPLACE VIEW "vBradfordRevista" AS
SELECT 
  * ,
  log("frecuenciaAcumulado") as "logFrecuenciaAcumulado"
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
CREATE OR REPLACE VIEW "vArticulosDisciplinaInstitucion" AS
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
        slug(i.e_100u) as "institucionSlug"
      FROM  "vArticulos" a
      INNER JOIN institucion i
        ON a.iddatabase=i.iddatabase AND a.sistema=i.sistema
      WHERE i.e_100x IS NOT NULL AND i.e_100u IS NOT NULL
      GROUP BY i.iddatabase, i.sistema, a.id_disciplina, "institucionSlug") ai --Articulo institucion
    GROUP BY id_disciplina, "institucionSlug") adi ORDER BY id_disciplina, articulos DESC;

SELECT create_matview('"mvArticulosDisciplinaInstitucion"', '"vArticulosDisciplinaInstitucion"');


CREATE OR REPLACE VIEW "vBradfordInstitucion" AS
SELECT 
  * ,
  log("frecuenciaAcumulado") as "logFrecuenciaAcumulado"
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
  GROUP BY id_disciplina, articulos) adic --Articulos por disciplina, revista, acumulados

--Autores por revista, pais
CREATE OR REPLACE VIEW "vAutoresRevistaPais" AS
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

SELECT create_matview('"mvAutoresRevistaPais"', '"vAutoresRevistaPais"');

--Productividad exogena
CREATE OR REPLACE VIEW "vProductividadExogena" AS
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
  "vAutoresRevistaPais" arp ON dr."revistaSlug"=arp."revistaSlug" AND dr."paisRevistaSlug"!=arp."paisAutorSlug"
GROUP BY dr.id_disciplina, dr."revistaSlug", documentos
ORDER BY dr.id_disciplina, dr."revistaSlug";

SELECT create_matview('"mvProductividadExogena"', '"vProductividadExogena"');

--Frecuencias--
--Documentos por autor
CREATE OR REPLACE VIEW "vFrecuenciaAutorDocumentos" AS
SELECT 
  max(e_100a) AS autor, 
  slug as "autorSlug", 
  count(*) AS documentos 
FROM autor GROUP BY slug ORDER BY documentos DESC, "autorSlug";

SELECT create_matview('"mvFrecuenciaAutorDocumentos"', '"vFrecuenciaAutorDocumentos"');

CREATE INDEX "frecuencuaAutorDocumentos_autor" ON "mvFrecuenciaAutorDocumentos"(autor);
CREATE INDEX "frecuencuaAutorDocumentos_documentos" ON "mvFrecuenciaAutorDocumentos"(documentos);

--Paises donde publica la institucion
CREATE OR REPLACE VIEW "vInstitucionPais" AS
SELECT 
  max(i.e_100u) AS insticuion,
  i.slug AS "institucionSlug",
  max(pais) AS pais,
  "paisSlug"
FROM institucion i
INNER JOIN "mvSearch" s 
  ON i.iddatabase=s.iddatabase AND i.sistema=s.sistema
GROUP BY "institucionSlug", "paisSlug";

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
CREATE OR REPLACE VIEW "vFrecuenciaInstitucionDARP" AS
SELECT 
  irpd.institucion, 
  irpd."institucionSlug", 
  irpd.revistas,
  irpd.paises,
  irpd.documentos,
  ia.autores
FROM
  (SELECT 
    max(e_100u) AS institucion, 
    i.slug AS "institucionSlug", 
    count(DISTINCT s."revistaSlug") AS revistas,
    count(DISTINCT s."paisSlug") AS paises,
    count(*) AS documentos
     FROM institucion i
     JOIN "mvSearch" s ON i.iddatabase = s.iddatabase AND i.sistema=s.sistema
    GROUP BY i.slug) irpd --Institucion revistas, documentos, paises
INNER JOIN 
  (SELECT
    i.slug AS "institucionSlug",
    count(DISTINCT a.slug) as autores
  FROM institucion i
  LEFT JOIN autor a ON
    i.iddatabase=a.iddatabase AND
    i.sistema=a.sistema AND
    i.sec_autor=a.sec_autor
  GROUP BY i.slug) ia --Institucion autores
ON irpd."institucionSlug"=ia."institucionSlug";

SELECT create_matview('"mvFrecuenciaInstitucionDARP"', '"vFrecuenciaInstitucionDARP"');

CREATE INDEX "idx_fInstitucionDARPInstitucion" ON "mvFrecuenciaInstitucionDARP"(institucion);
CREATE INDEX "idx_fInstitucionDARPDocumentos" ON "mvFrecuenciaInstitucionDARP"(documentos);