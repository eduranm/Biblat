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
    slug(t.e_245) as "e245Slug",
    t.e_222, 
    slug(t.e_222) as "e_222Slug", 
    t.e_008, 
    t.e_260b, 
    t.e_300a, 
    t.e_300b, 
    t.e_300c, 
    t.e_300e, 
    t.e_856u, 
    t.id_disciplina,
    a.e_100a, 
    slug(a.e_100a) as "e_100aSlug", 
    i.e_100u,
    slug(i.e_100u) as "e_100uSlug", 
    p.descpalabraclave,
    slug(p.descpalabraclave) as "descPalabraClaveSlug"
FROM articulo t 
LEFT JOIN autor a ON (a.iddatabase=t.iddatabase AND a.sistema=t.sistema AND a.sec_autor='1')
LEFT JOIN institucion i ON (a.iddatabase=i.iddatabase AND a.sistema=i.sistema AND a.sec_autor=i.sec_autor) 
LEFT JOIN artidisciplina d ON (t.iddatabase=d.iddatabase AND t.sistema=d.sistema) 
LEFT JOIN palabraclave p on (t.iddatabase=p.iddatabase AND t.sistema=p.sistema)
GROUP BY t.iddatabase, t.sistema, a.e_100a, i.e_100u, p.descpalabraclave, "descPalabraClaveSlug";

SELECT create_matview('"mvSearch"', '"vSearch"');

CREATE INDEX "idDisciplina_idx" ON "mvSearch"(id_disciplina);
CREATE INDEX "e_856u_idx" ON "mvSearch"(e_856u);
CREATE INDEX "palabraClave_idx" ON "mvSearch"("descPalabraClaveSlug");
CREATE INDEX "articulo_idx" ON "mvSearch"("e245Slug");
CREATE INDEX "autor_idx" ON "mvSearch"("e_100aSlug");
CREATE INDEX "institucion_idx" ON "mvSearch"("e_100uSlug");
CREATE INDEX "revista_idx" ON "mvSearch"("e_222Slug");
