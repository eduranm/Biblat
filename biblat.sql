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