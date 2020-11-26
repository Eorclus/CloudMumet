-- DROP TABLE public.users;

CREATE TABLE public.users (
	id serial NOT NULL DEFAULT nextval('users_id_seq'::regclass),
	"name" varchar(250) NULL,
	"password" varchar(250) NULL,
	mobno int8 NULL,
	CONSTRAINT id PRIMARY KEY (id)
);
