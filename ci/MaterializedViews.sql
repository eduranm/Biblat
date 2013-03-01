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
    t.e_245,
    slug(t.e_245) as "articuloSlug",
    t.e_222, 
    slug(t.e_222) as "revistaSlug", 
    t.e_008, 
    t.e_260b, 
    t.e_300a, 
    t.e_300b, 
    t.e_300c, 
    t.e_300e, 
    t.e_856u, 
    t.id_disciplina,
    a."autoresSec",
    a."autoresSecInstitucion",
    a."autoresJSON",
    a."autoresSlug",
    i."institucionesSec",
    i."institucionesJSON",
    i."institucionesSlug",
    d."idDisciplinasJSON",
    d."disciplinasJSON",
    p."palabrasClaveJSON",
    p."palabrasClaveSlug"
FROM articulo t
    LEFT JOIN (SELECT 
            at.iddatabase, 
            at.sistema, 
            array_to_json(array_agg(at.sec_institucion ORDER BY at.sec_autor))::text AS "autoresSecInstitucion",
            array_to_json(array_agg(at.sec_autor ORDER BY at.sec_autor))::text AS "autoresSec",
            array_to_json(array_agg(at.e_100a ORDER BY at.sec_autor))::text AS "autoresJSON",
            string_agg(slug(at.e_100a), '|' ORDER BY at.sec_autor) AS "autoresSlug"
        FROM autor at
        GROUP BY at.iddatabase, at.sistema) a 
    ON (t.iddatabase=a.iddatabase AND t.sistema=a.sistema) 
    LEFT JOIN (SELECT 
            it.iddatabase, 
            it.sistema, 
            array_to_json(array_agg(it.sec_institucion ORDER BY it.sec_institucion))::text AS "institucionesSec",
            array_to_json(array_agg(it.e_100u ORDER BY it.sec_institucion))::text AS "institucionesJSON",
            string_agg(slug(it.e_100u), '|' ORDER BY it.sec_institucion) AS "institucionesSlug"
        FROM institucion it
        GROUP BY it.iddatabase, it.sistema) i 
    ON (t.iddatabase=i.iddatabase AND t.sistema=i.sistema)
    LEFT JOIN (SELECT 
            dt.iddatabase, 
            dt.sistema,
            array_to_json(array_agg(dt.iddisciplina ORDER BY dt.iddisciplina))::text AS "idDisciplinasJSON",
            array_to_json(array_agg(dt.disciplina ORDER BY dt.iddisciplina))::text AS "disciplinasJSON"
        FROM artidisciplina dt
        GROUP BY dt.iddatabase, dt.sistema) d 
    ON (t.iddatabase=d.iddatabase AND t.sistema=d.sistema) 
    LEFT JOIN (SELECT 
        pt.iddatabase, 
        pt.sistema, 
        array_to_json(array_agg(pt.descpalabraclave ORDER BY pt.descpalabraclave))::text AS "palabrasClaveJSON", 
        string_agg(slug(pt.descpalabraclave), '|' ORDER BY pt.descpalabraclave) AS "palabrasClaveSlug"
        FROM palabraclave pt
        GROUP BY pt.iddatabase, pt.sistema) p 
    ON (t.iddatabase=p.iddatabase AND t.sistema=p.sistema);

SELECT create_matview('"mvSearch"', '"vSearch"');

CREATE INDEX "searchIdDisciplina_idx" ON "mvSearch"(id_disciplina);
CREATE INDEX "searchTextoCompleto_idx" ON "mvSearch"(e_856u);
CREATE INDEX "searchPalabrasClaveSlug_idx" ON "mvSearch"("palabrasClaveSlug");
CREATE INDEX "searchArticuloSlug_idx" ON "mvSearch"("articuloSlug");
CREATE INDEX "searchAutoresSlug_idx" ON "mvSearch"("autoresSlug");
CREATE INDEX "searchInstitucionesSlug_idx" ON "mvSearch"("institucionesSlug");
CREATE INDEX "searchRevistaSlug_idx" ON "mvSearch"("revistaSlug");
