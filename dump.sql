--
-- PostgreSQL database dump
--

\restrict lf42euC4U90cZ4Vob6z1tGZgRxodjujEYK34B7sskwACBRQyOFJ3aUvEqMkaxbU

-- Dumped from database version 18.4
-- Dumped by pg_dump version 18.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: livros; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.livros (
    id integer NOT NULL,
    titulo character varying(100) NOT NULL,
    autor character varying(100) NOT NULL,
    genero character varying(100) NOT NULL,
    ano_publicacao integer NOT NULL,
    status_livro character varying(20) DEFAULT 'Disponível'::character varying,
    CONSTRAINT livros_status_livro_check CHECK (((status_livro)::text = ANY ((ARRAY['Disponível'::character varying, 'Emprestado'::character varying])::text[])))
);


ALTER TABLE public.livros OWNER TO postgres;

--
-- Name: livros_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.livros_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.livros_id_seq OWNER TO postgres;

--
-- Name: livros_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.livros_id_seq OWNED BY public.livros.id;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    senha character varying(255) NOT NULL
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO postgres;

--
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- Name: livros id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.livros ALTER COLUMN id SET DEFAULT nextval('public.livros_id_seq'::regclass);


--
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- Data for Name: livros; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.livros (id, titulo, autor, genero, ano_publicacao, status_livro) FROM stdin;
\.


--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios (id, nome, email, senha) FROM stdin;
1	Pedro Lanaro	pedro.lanaro@gmail.com	$2y$12$okTdfp9EWunmZr./URTYxeb8aj7cIWemhPMnkXE2DzZi28BFLwWpK
2	Laura	laura@gmail.com	$2y$12$XA685Vdwwus/7yfP4mTFrexV.d6lb/zoJms4swPBm29jecMNNl9HS
\.


--
-- Name: livros_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.livros_id_seq', 1, true);


--
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 2, true);


--
-- Name: livros livros_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.livros
    ADD CONSTRAINT livros_pkey PRIMARY KEY (id);


--
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

\unrestrict lf42euC4U90cZ4Vob6z1tGZgRxodjujEYK34B7sskwACBRQyOFJ3aUvEqMkaxbU

