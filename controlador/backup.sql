--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.13
-- Dumped by pg_dump version 9.3.1
-- Started on 2014-07-24 12:03:07

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 162 (class 3079 OID 11644)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 1861 (class 0 OID 0)
-- Dependencies: 162
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 161 (class 1259 OID 16399)
-- Name: productos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE productos (
    id integer NOT NULL,
    nombre character varying,
    precio integer,
    descripcion character varying,
    cantidad integer,
    ruta character varying
);


ALTER TABLE public.productos OWNER TO postgres;

--
-- TOC entry 1853 (class 0 OID 16399)
-- Dependencies: 161
-- Data for Name: productos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY productos (id, nombre, precio, descripcion, cantidad, ruta) FROM stdin;
1	Apple TV	300000	El Apple TV con HD de 1080p te brinda el mejor entretenimiento directamente en tu TV de pantalla ancha. Elige entre miles de videos en iTunes, muchos de ellos en asombroso HD de 1080p. Mira deportes en vivo en HD. Accede a contenido de Netflix, YouTube, Vimeo y mucho más1. Además, con AirPlay puedes reproducir videos, mostrar fotos y disfrutar de la música de tu iPhone, iPad o iPod touch en tu TV	8	vista/imagenes/Apple_TV.jpg
2	TV Led LG	1000000	Televisor lg con ultra hd ofrece 4 veces mayor definición que un tv full hd, disfruta de imágenes increíblemente reales y nítidas gracias a la ultra claridad de su pantalla ips. Sumérgete en cada detalle con una definición increíblemente precisa	10	"vista/imagenes/TV_Led_LG.jpg"
3	IPad Retina	840000	Pantalla Multi-Touch retroiluminada por LED con tecnología IPS / Resolución de 2.048 por 1.536 a 264 píxeles por pulgada Batería recargable integrada de polímeros de litio de 42.5 vatios/hor	20	"vista/imagenes/Ipad_Retina.jpg"
4	Ipad Air	1200000	El iPad Air cuenta con una hermosa pantalla de 7.9 pulgadas, cámaras iSight y FaceTime, conexión wireless ultrarrápida, y hasta 10 horas de duración de batería. Además, hay más de 300,000 apps en el App Store diseñadas para el iPad, que también funcionan con el iPad mini.\r\nDe modo que es un iPad en todo sentido, con la misma forma y un poco más pequeño.	15	"vista/imagenes/Ipad_Air.jpg"
5	PC Lenovo	750000	Procesador: Intel Celeron Bay Trail N2830, Memoria: 4GB, Disco duro: 500G 5400RPM, Sistema operativo: Windows 8.1, Tamaño de pantalla: 14 pulgadas	20	"vista/imagenes/PC_Lenovo.jpg"
6	Macbook Pro	1900000	Tamaño de pantalla: 13.3 pulgadas, Procesador: Procesador dual core / Intel Core i5 de 2.5 GHz (Turbo Boost de hasta 3.1GHz), Memoria RAM: 4 GB, Disco duro: 500 GB, Sistema Operativo: OS X Lion	6	"vista/imagenes/Macbook_Pro.jpg"
7	Control PlayStation	160000	Control Inalambrico con sensores que vibran con cada acción 	18	"vista/imagenes/Control_PlayStation.jpg"
8	Camara Canon	450000	Camara digital de 20mp, 10x de zoom	14	"vista/imagenes/Camara_Canon.jpg"
\.


--
-- TOC entry 1751 (class 2606 OID 16406)
-- Name: pk_pr_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY productos
    ADD CONSTRAINT pk_pr_id PRIMARY KEY (id);


--
-- TOC entry 1860 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2014-07-24 12:03:08

--
-- PostgreSQL database dump complete
--

