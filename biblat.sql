--Biblat database tables
CREATE DATABASE biblat;

\connect biblat;

CREATE TABLE "logSolicitudDocumento" (
    database numeric(1,0),
    sistema character varying(9),
    nombre character varying,
    email character varying,
    instituto character varying,
    telefono character varying(20),
    ip character varying(15),
    pais character varying,
    ciudad character varying,
    datetime timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone,
    session_id character varying(40)
);

CREATE TABLE "advancedSearchHash"
(
  hash character varying(32) NOT NULL,
  search character varying,
  query character varying,
  CONSTRAINT "advacedSearchHash_pkey" PRIMARY KEY (hash)
);

CREATE OR REPLACE FUNCTION "advancedSearchHashInsert"(character varying(32), character varying, character varying)
    RETURNS text
        AS $$
            DECLARE
                vhash ALIAS FOR $1;
                vsearch ALIAS FOR $2;
                vquery ALIAS FOR $3;
                retval text;
            BEGIN
                UPDATE "advancedSearchHash" SET search=vsearch, query=vquery
                    WHERE hash=vhash;
                IF (FOUND) THEN
                    retval := 'registro actualizado';
                ELSE
                    INSERT INTO "advancedSearchHash" (hash, search, query)
                        VALUES (vhash, vsearch, vquery);
                    retval := 'registro insertado';
                END IF;
                RETURN retval;
            END;
        $$
LANGUAGE 'plpgsql';