/*Otimizar consultas con LIKE*/
CREATE EXTENSION pg_trgm;

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

/*Indices para optimizar las consultas*/
CREATE INDEX "articuloTextoCompleto_idx" ON articulo(e_856u);	
CREATE INDEX "articuloAlfabetico_idx" ON articulo(substring(LOWER(e_222), 1, 1));
CREATE INDEX "articuloHevila_idx" ON articulo USING gin(e_856u gin_trgm_ops);

/*Normalizando paises*/

UPDATE articulo SET e_008='México' WHERE e_008='Mexico' OR e_008='Mèxico';