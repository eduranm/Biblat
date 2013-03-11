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

 CREATE OR REPLACE FUNCTION refresh_matview(name) RETURNS VOID
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

    EXECUTE ''DELETE FROM '' || matview;
    EXECUTE ''INSERT INTO '' || matview
        || '' SELECT * FROM '' || entry.v_name;

    UPDATE matviews
        SET last_refresh=CURRENT_TIMESTAMP
        WHERE mv_name=matview;

    RETURN;
END';

/*Vista para busquedas*/
CREATE OR REPLACE VIEW "vSearch" AS SELECT 
    t.sistema, 
    t.iddatabase, 
    t.e_245 AS articulo,
    slug(t.e_245) AS "articuloSlug",
    t.e_222 AS revista, 
    slug(t.e_222) AS "revistaSlug", 
    t.e_008 AS pais, 
    slug(t.e_008) AS "paisSlug", 
    t.e_260b AS anio, 
    t.e_300a AS volumen, 
    t.e_300b AS numero, 
    t.e_300c AS periodo, 
    t.e_300e AS paginacion, 
    t.e_856u AS url, 
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
CREATE INDEX "searchIdDisciplina_idx" ON "mvSearch"(id_disciplina);
CREATE INDEX "searchTextoCompleto_idx" ON "mvSearch"(url);
CREATE INDEX "searchArticuloSlug_idx" ON "mvSearch"("articuloSlug");
CREATE INDEX "searchRevistaSlug_idx" ON "mvSearch"("revistaSlug");
CREATE INDEX "searchGeneralSlug_idx" ON "mvSearch" USING gin(("generalSlug"::tsvector));

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
CREATE INDEX "searchSingleFields_idx" ON "mvSearchFields" USING gin(("singleFields"::tsvector));
