--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.14
-- Dumped by pg_dump version 9.5.14

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: annotation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.annotation (
    id_annot integer NOT NULL,
    id_exp integer NOT NULL,
    id_cat integer NOT NULL,
    id_data integer NOT NULL,
    date date NOT NULL,
    expert_sample_confidence_level integer
);


ALTER TABLE public.annotation OWNER TO postgres;

--
-- Name: annotation_id_annot_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.annotation_id_annot_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.annotation_id_annot_seq OWNER TO postgres;

--
-- Name: annotation_id_annot_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.annotation_id_annot_seq OWNED BY public.annotation.id_annot;


--
-- Name: category; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.category (
    id_cat integer NOT NULL,
    label_cat character varying(50) NOT NULL,
    id_prj integer NOT NULL,
    num_line integer
);


ALTER TABLE public.category OWNER TO postgres;

--
-- Name: category_id_cat_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.category_id_cat_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.category_id_cat_seq OWNER TO postgres;

--
-- Name: category_id_cat_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.category_id_cat_seq OWNED BY public.category.id_cat;


--
-- Name: competence_level; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.competence_level (
    id_cptlvl integer NOT NULL,
    label_cptlvl character varying(50) NOT NULL
);


ALTER TABLE public.competence_level OWNER TO postgres;

--
-- Name: competence_level_id_cptlvl_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.competence_level_id_cptlvl_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.competence_level_id_cptlvl_seq OWNER TO postgres;

--
-- Name: competence_level_id_cptlvl_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.competence_level_id_cptlvl_seq OWNED BY public.competence_level.id_cptlvl;


--
-- Name: confidence_interval; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.confidence_interval (
    id_confidence_interval integer NOT NULL,
    label_confidence_interval character varying(20) NOT NULL
);


ALTER TABLE public.confidence_interval OWNER TO postgres;

--
-- Name: confidence_interval_id_confidence_interval_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.confidence_interval_id_confidence_interval_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.confidence_interval_id_confidence_interval_seq OWNER TO postgres;

--
-- Name: confidence_interval_id_confidence_interval_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.confidence_interval_id_confidence_interval_seq OWNED BY public.confidence_interval.id_confidence_interval;


--
-- Name: data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.data (
    id_data integer NOT NULL,
    pathname_data character varying(500) NOT NULL,
    priority_data numeric(5,2) DEFAULT 0,
    nbannotation_data integer,
    id_prj integer NOT NULL
);


ALTER TABLE public.data OWNER TO postgres;

--
-- Name: data_id_data_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.data_id_data_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.data_id_data_seq OWNER TO postgres;

--
-- Name: data_id_data_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.data_id_data_seq OWNED BY public.data.id_data;


--
-- Name: date; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.date (
    date date NOT NULL
);


ALTER TABLE public.date OWNER TO postgres;

--
-- Name: expert; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.expert (
    id_exp integer NOT NULL,
    name_exp character varying(50) NOT NULL,
    firstname_exp character varying(50) NOT NULL,
    bd_date_exp date NOT NULL,
    sex_exp character varying(50) NOT NULL,
    address_exp character varying(50) NOT NULL,
    pc_exp integer NOT NULL,
    mail_exp character varying(50) NOT NULL,
    tel_exp character varying(50) NOT NULL,
    city_exp character varying(50) NOT NULL,
    pwd_exp character varying(100) NOT NULL,
    type_exp character varying(20) NOT NULL,
    CONSTRAINT ck_expert_typeexp CHECK ((((type_exp)::text = 'expert'::text) OR ((type_exp)::text = 'admin'::text) OR ((type_exp)::text = 'superadmin'::text)))
);


ALTER TABLE public.expert OWNER TO postgres;

--
-- Name: expert_id_exp_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.expert_id_exp_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.expert_id_exp_seq OWNER TO postgres;

--
-- Name: expert_id_exp_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.expert_id_exp_seq OWNED BY public.expert.id_exp;


--
-- Name: interface; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.interface (
    id_int integer NOT NULL,
    label_int character varying(50) NOT NULL
);


ALTER TABLE public.interface OWNER TO postgres;

--
-- Name: interface_id_int_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.interface_id_int_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.interface_id_int_seq OWNER TO postgres;

--
-- Name: interface_id_int_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.interface_id_int_seq OWNED BY public.interface.id_int;


--
-- Name: pairwise; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pairwise (
    id_pair integer NOT NULL,
    id_exp integer NOT NULL,
    id_data1 integer NOT NULL,
    id_data2 integer NOT NULL,
    date date,
    id_cat integer
);


ALTER TABLE public.pairwise OWNER TO postgres;

--
-- Name: pairwise_id_pair_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pairwise_id_pair_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pairwise_id_pair_seq OWNER TO postgres;

--
-- Name: pairwise_id_pair_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pairwise_id_pair_seq OWNED BY public.pairwise.id_pair;


--
-- Name: participation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.participation (
    id_part integer NOT NULL,
    id_prj integer NOT NULL,
    id_cptlvl integer NOT NULL,
    id_exp integer NOT NULL,
    expert_project_confidence_level character varying(20)
);


ALTER TABLE public.participation OWNER TO postgres;

--
-- Name: participation_id_part_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.participation_id_part_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.participation_id_part_seq OWNER TO postgres;

--
-- Name: participation_id_part_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.participation_id_part_seq OWNED BY public.participation.id_part;


--
-- Name: project; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.project (
    id_prj integer NOT NULL,
    name_prj character varying(50) NOT NULL,
    desc_prj character varying(500),
    id_mode integer NOT NULL,
    id_int integer NOT NULL,
    id_exp integer NOT NULL,
    value_mode numeric,
    limit_prj numeric(4,0)
);


ALTER TABLE public.project OWNER TO postgres;

--
-- Name: project_id_prj_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.project_id_prj_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.project_id_prj_seq OWNER TO postgres;

--
-- Name: project_id_prj_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.project_id_prj_seq OWNED BY public.project.id_prj;


--
-- Name: session_mode; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.session_mode (
    id_mode integer NOT NULL,
    label_mode character varying(50) NOT NULL
);


ALTER TABLE public.session_mode OWNER TO postgres;

--
-- Name: session_mode_id_mode_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.session_mode_id_mode_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.session_mode_id_mode_seq OWNER TO postgres;

--
-- Name: session_mode_id_mode_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.session_mode_id_mode_seq OWNED BY public.session_mode.id_mode;


--
-- Name: tripletwise; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tripletwise (
    id_triplet integer NOT NULL,
    id_exp integer NOT NULL,
    id_data1 integer NOT NULL,
    id_data2 integer NOT NULL,
    id_data3 integer NOT NULL,
    date date,
    id_cat integer
);


ALTER TABLE public.tripletwise OWNER TO postgres;

--
-- Name: tripletwise_id_triplet_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tripletwise_id_triplet_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tripletwise_id_triplet_seq OWNER TO postgres;

--
-- Name: tripletwise_id_triplet_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tripletwise_id_triplet_seq OWNED BY public.tripletwise.id_triplet;


--
-- Name: id_annot; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.annotation ALTER COLUMN id_annot SET DEFAULT nextval('public.annotation_id_annot_seq'::regclass);


--
-- Name: id_cat; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category ALTER COLUMN id_cat SET DEFAULT nextval('public.category_id_cat_seq'::regclass);


--
-- Name: id_cptlvl; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.competence_level ALTER COLUMN id_cptlvl SET DEFAULT nextval('public.competence_level_id_cptlvl_seq'::regclass);


--
-- Name: id_confidence_interval; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.confidence_interval ALTER COLUMN id_confidence_interval SET DEFAULT nextval('public.confidence_interval_id_confidence_interval_seq'::regclass);


--
-- Name: id_data; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.data ALTER COLUMN id_data SET DEFAULT nextval('public.data_id_data_seq'::regclass);


--
-- Name: id_exp; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.expert ALTER COLUMN id_exp SET DEFAULT nextval('public.expert_id_exp_seq'::regclass);


--
-- Name: id_int; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.interface ALTER COLUMN id_int SET DEFAULT nextval('public.interface_id_int_seq'::regclass);


--
-- Name: id_pair; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pairwise ALTER COLUMN id_pair SET DEFAULT nextval('public.pairwise_id_pair_seq'::regclass);


--
-- Name: id_part; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.participation ALTER COLUMN id_part SET DEFAULT nextval('public.participation_id_part_seq'::regclass);


--
-- Name: id_prj; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.project ALTER COLUMN id_prj SET DEFAULT nextval('public.project_id_prj_seq'::regclass);


--
-- Name: id_mode; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_mode ALTER COLUMN id_mode SET DEFAULT nextval('public.session_mode_id_mode_seq'::regclass);


--
-- Name: id_triplet; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tripletwise ALTER COLUMN id_triplet SET DEFAULT nextval('public.tripletwise_id_triplet_seq'::regclass);


--
-- Data for Name: annotation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.annotation (id_annot, id_exp, id_cat, id_data, date, expert_sample_confidence_level) FROM stdin;
1	0	2	1	2019-03-20	2
2	0	2	2	2019-03-20	2
3	0	3	3	2019-03-20	2
4	0	3	4	2019-03-20	1
5	0	2	5	2019-03-20	1
6	0	4	9	2019-03-20	1
7	0	4	10	2019-03-20	1
8	0	4	11	2019-03-20	1
\.


--
-- Name: annotation_id_annot_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.annotation_id_annot_seq', 8, true);


--
-- Data for Name: category; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category (id_cat, label_cat, id_prj, num_line) FROM stdin;
1	Rock\r	1	\N
2	Paper\r	1	\N
3	Scissors	1	\N
4	Pink\r	2	\N
5	Blue\r	2	\N
6	Yellow\r	2	\N
7	Brown	2	\N
\.


--
-- Name: category_id_cat_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.category_id_cat_seq', 7, true);


--
-- Data for Name: competence_level; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.competence_level (id_cptlvl, label_cptlvl) FROM stdin;
1	Not an expert
2	Confident
3	Highly confident
4	Expert
\.


--
-- Name: competence_level_id_cptlvl_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.competence_level_id_cptlvl_seq', 1, false);


--
-- Data for Name: confidence_interval; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.confidence_interval (id_confidence_interval, label_confidence_interval) FROM stdin;
0	Doubt
1	Confident
2	Highly confident
\.


--
-- Name: confidence_interval_id_confidence_interval_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.confidence_interval_id_confidence_interval_seq', 1, false);


--
-- Data for Name: data; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.data (id_data, pathname_data, priority_data, nbannotation_data, id_prj) FROM stdin;
6	/source/storage/app/datas/projetdetest/Scissors/Scissors2.jpg	0.00	0	1
7	/source/storage/app/datas/projetdetest/Scissors/Scissors1.jpg	0.00	0	1
8	/source/storage/app/datas/projetdetest/Scissors/Scissors3.jpg	0.00	0	1
1	/source/storage/app/datas/projetdetest/Paper/Paper1.jpg	0.00	1	1
2	/source/storage/app/datas/projetdetest/Paper/Paper2.jpg	0.00	1	1
3	/source/storage/app/datas/projetdetest/Rock/Rock1.jpg	0.00	1	1
4	/source/storage/app/datas/projetdetest/Rock/Rock2.jpg	0.00	1	1
5	/source/storage/app/datas/projetdetest/Rock/Rock3.jpg	0.00	1	1
12	/source/storage/app/datas/projettestboutons/Stardust/Humans/Judgement.jpg	0.00	0	2
13	/source/storage/app/datas/projettestboutons/Stardust/Humans/Lovers.jpg	0.00	0	2
14	/source/storage/app/datas/projettestboutons/Stardust/Humans/DarkBlueMoon.jpg	0.00	0	2
15	/source/storage/app/datas/projettestboutons/Badguys/Morioh/KillerQueen.jpg	0.00	0	2
16	/source/storage/app/datas/projettestboutons/Joestars/Dio/TheWorld.jpg	0.00	0	2
17	/source/storage/app/datas/projettestboutons/Joestars/Jojo/StarPlatinum.jpg	0.00	0	2
18	/source/storage/app/datas/projettestboutons/Joestars/Jojo/CrazyDiamond.jpg	0.00	0	2
19	/source/storage/app/datas/projettestboutons/Joestars/Jojo/HermitPurple.jpg	0.00	0	2
20	/source/storage/app/datas/projettestboutons/Morioh/RedHotChiliPepper.jpg	0.00	0	2
21	/source/storage/app/datas/projettestboutons/Morioh/TheHand.jpg	0.00	0	2
9	/source/storage/app/datas/projettestboutons/Stardust/Vampires/Cream.jpg	0.00	1	2
10	/source/storage/app/datas/projettestboutons/Stardust/Vampires/Death13.jpg	0.00	1	2
11	/source/storage/app/datas/projettestboutons/Stardust/Humans/Justice.jpg	0.00	1	2
\.


--
-- Name: data_id_data_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.data_id_data_seq', 21, true);


--
-- Data for Name: date; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.date (date) FROM stdin;
2019-03-20
\.


--
-- Data for Name: expert; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.expert (id_exp, name_exp, firstname_exp, bd_date_exp, sex_exp, address_exp, pc_exp, mail_exp, tel_exp, city_exp, pwd_exp, type_exp) FROM stdin;
0	superamdin	superamdin	0212-06-15	h	7 rue de la ristocratie	74000	superamdin.admin@gmail.com	0102030405	Annecy	$2y$10$Sp9Lbk4fWgyOtF3PGv9TKeopzgC79NqKCX7a.DNUtC0OkjqJYa9.O	superadmin
\.


--
-- Name: expert_id_exp_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.expert_id_exp_seq', 1, false);


--
-- Data for Name: interface; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.interface (id_int, label_int) FROM stdin;
1	Classification
2	Pairwise similarity
3	Tripletwise similarity
\.


--
-- Name: interface_id_int_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.interface_id_int_seq', 1, false);


--
-- Data for Name: pairwise; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pairwise (id_pair, id_exp, id_data1, id_data2, date, id_cat) FROM stdin;
\.


--
-- Name: pairwise_id_pair_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pairwise_id_pair_seq', 1, false);


--
-- Data for Name: participation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.participation (id_part, id_prj, id_cptlvl, id_exp, expert_project_confidence_level) FROM stdin;
1	1	1	0	1
2	2	1	0	1
\.


--
-- Name: participation_id_part_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.participation_id_part_seq', 2, true);


--
-- Data for Name: project; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.project (id_prj, name_prj, desc_prj, id_mode, id_int, id_exp, value_mode, limit_prj) FROM stdin;
1	projetdetest	f	2	1	0	\N	3
2	projettestboutons	Projet dédié au test de Quit et Validate.	1	1	0	\N	1
\.


--
-- Name: project_id_prj_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.project_id_prj_seq', 2, true);


--
-- Data for Name: session_mode; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.session_mode (id_mode, label_mode) FROM stdin;
1	Timer
2	Number of annotations
\.


--
-- Name: session_mode_id_mode_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.session_mode_id_mode_seq', 1, false);


--
-- Data for Name: tripletwise; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tripletwise (id_triplet, id_exp, id_data1, id_data2, id_data3, date, id_cat) FROM stdin;
\.


--
-- Name: tripletwise_id_triplet_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tripletwise_id_triplet_seq', 1, false);


--
-- Name: annotation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.annotation
    ADD CONSTRAINT annotation_pkey PRIMARY KEY (id_annot);


--
-- Name: category_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category
    ADD CONSTRAINT category_pkey PRIMARY KEY (id_cat);


--
-- Name: competence_level_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.competence_level
    ADD CONSTRAINT competence_level_pkey PRIMARY KEY (id_cptlvl);


--
-- Name: confidence_interval_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.confidence_interval
    ADD CONSTRAINT confidence_interval_pkey PRIMARY KEY (id_confidence_interval);


--
-- Name: data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.data
    ADD CONSTRAINT data_pkey PRIMARY KEY (id_data);


--
-- Name: date_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.date
    ADD CONSTRAINT date_pkey PRIMARY KEY (date);


--
-- Name: expert_mail_exp_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.expert
    ADD CONSTRAINT expert_mail_exp_key UNIQUE (mail_exp);


--
-- Name: expert_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.expert
    ADD CONSTRAINT expert_pkey PRIMARY KEY (id_exp);


--
-- Name: interface_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.interface
    ADD CONSTRAINT interface_pkey PRIMARY KEY (id_int);


--
-- Name: pairwise_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pairwise
    ADD CONSTRAINT pairwise_pkey PRIMARY KEY (id_pair);


--
-- Name: participation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.participation
    ADD CONSTRAINT participation_pkey PRIMARY KEY (id_part);


--
-- Name: project_name_prj_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.project
    ADD CONSTRAINT project_name_prj_key UNIQUE (name_prj);


--
-- Name: project_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.project
    ADD CONSTRAINT project_pkey PRIMARY KEY (id_prj);


--
-- Name: session_mode_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_mode
    ADD CONSTRAINT session_mode_pkey PRIMARY KEY (id_mode);


--
-- Name: tripletwise_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tripletwise
    ADD CONSTRAINT tripletwise_pkey PRIMARY KEY (id_triplet);


--
-- Name: fk_categoryannotation; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.annotation
    ADD CONSTRAINT fk_categoryannotation FOREIGN KEY (id_cat) REFERENCES public.category(id_cat);


--
-- Name: fk_categorypairwise; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pairwise
    ADD CONSTRAINT fk_categorypairwise FOREIGN KEY (id_cat) REFERENCES public.category(id_cat);


--
-- Name: fk_competencelevelparticipation; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.participation
    ADD CONSTRAINT fk_competencelevelparticipation FOREIGN KEY (id_cptlvl) REFERENCES public.competence_level(id_cptlvl);


--
-- Name: fk_confidenceintervalannotation; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.annotation
    ADD CONSTRAINT fk_confidenceintervalannotation FOREIGN KEY (expert_sample_confidence_level) REFERENCES public.confidence_interval(id_confidence_interval);


--
-- Name: fk_data1pairwise; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pairwise
    ADD CONSTRAINT fk_data1pairwise FOREIGN KEY (id_data1) REFERENCES public.data(id_data);


--
-- Name: fk_data1triplet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tripletwise
    ADD CONSTRAINT fk_data1triplet FOREIGN KEY (id_data1) REFERENCES public.data(id_data);


--
-- Name: fk_data2pairwise; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pairwise
    ADD CONSTRAINT fk_data2pairwise FOREIGN KEY (id_data2) REFERENCES public.data(id_data);


--
-- Name: fk_data2triplet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tripletwise
    ADD CONSTRAINT fk_data2triplet FOREIGN KEY (id_data2) REFERENCES public.data(id_data);


--
-- Name: fk_data3triplet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tripletwise
    ADD CONSTRAINT fk_data3triplet FOREIGN KEY (id_data3) REFERENCES public.data(id_data);


--
-- Name: fk_dataannotation; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.annotation
    ADD CONSTRAINT fk_dataannotation FOREIGN KEY (id_data) REFERENCES public.data(id_data);


--
-- Name: fk_dateannotation; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.annotation
    ADD CONSTRAINT fk_dateannotation FOREIGN KEY (date) REFERENCES public.date(date);


--
-- Name: fk_datepairwise; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pairwise
    ADD CONSTRAINT fk_datepairwise FOREIGN KEY (date) REFERENCES public.date(date);


--
-- Name: fk_datetriplet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tripletwise
    ADD CONSTRAINT fk_datetriplet FOREIGN KEY (date) REFERENCES public.date(date);


--
-- Name: fk_expannotation; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.annotation
    ADD CONSTRAINT fk_expannotation FOREIGN KEY (id_exp) REFERENCES public.expert(id_exp);


--
-- Name: fk_expertpairwise; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pairwise
    ADD CONSTRAINT fk_expertpairwise FOREIGN KEY (id_exp) REFERENCES public.expert(id_exp);


--
-- Name: fk_expertparticipation; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.participation
    ADD CONSTRAINT fk_expertparticipation FOREIGN KEY (id_exp) REFERENCES public.expert(id_exp);


--
-- Name: fk_expertproject; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.project
    ADD CONSTRAINT fk_expertproject FOREIGN KEY (id_exp) REFERENCES public.expert(id_exp);


--
-- Name: fk_experttriplet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tripletwise
    ADD CONSTRAINT fk_experttriplet FOREIGN KEY (id_exp) REFERENCES public.expert(id_exp);


--
-- Name: fk_interfaceproject; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.project
    ADD CONSTRAINT fk_interfaceproject FOREIGN KEY (id_int) REFERENCES public.interface(id_int);


--
-- Name: fk_modeproject; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.project
    ADD CONSTRAINT fk_modeproject FOREIGN KEY (id_mode) REFERENCES public.session_mode(id_mode);


--
-- Name: fk_projectcategory; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category
    ADD CONSTRAINT fk_projectcategory FOREIGN KEY (id_prj) REFERENCES public.project(id_prj);


--
-- Name: fk_projectdata; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.data
    ADD CONSTRAINT fk_projectdata FOREIGN KEY (id_prj) REFERENCES public.project(id_prj);


--
-- Name: fk_projectparticipation; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.participation
    ADD CONSTRAINT fk_projectparticipation FOREIGN KEY (id_prj) REFERENCES public.project(id_prj);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

