CREATE TABLE "Calle"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_id_calle PRIMARY KEY (id)
);

CREATE TABLE "Criticidad"
(
  id serial NOT NULL,
  nombre character varying(50),
  descripcion character varying,
  CONSTRAINT pk_id_criticidad PRIMARY KEY (id)
);


CREATE TABLE "Bache"
(
  id serial NOT NULL,
  titulo varchar(50) NOT NULL, 
  latitud double precision,
  longitud double precision,
  "idCriticidad" serial,
  "idCalle" serial,
  "alturaCalle" integer,
  CONSTRAINT pk_id_bache PRIMARY KEY (id),
  CONSTRAINT fg_id_calle FOREIGN KEY ("idCalle")
      REFERENCES "Calle" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_criticidad FOREIGN KEY ("idCriticidad")
      REFERENCES "Criticidad" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE "TipoEstado"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_tipo_estado PRIMARY KEY (id)
);


CREATE TABLE "Estado"
(
  id serial NOT NULL,
  "idTipoEstado" serial NOT NULL,
  "idBache" serial NOT NULL,
  "idUsuario" serial NOT NULL,
  fecha date,
  CONSTRAINT pk_id_estado PRIMARY KEY (id),
  CONSTRAINT fg_id_bache FOREIGN KEY ("idBache")
      REFERENCES "Bache" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_tipo_estado FOREIGN KEY ("idTipoEstado")
      REFERENCES "TipoEstado" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);



CREATE TABLE "Grupo"
(
  id serial NOT NULL,
  nombre character varying(50),
  CONSTRAINT pk_id_grupo PRIMARY KEY (id)
);

CREATE TABLE "Usuario"
(
  id serial NOT NULL,
  nombre character varying,
  constrasenia character varying,
  CONSTRAINT pk_id_usuario PRIMARY KEY (id)
);

CREATE TABLE "GrupoUsuario"
(
  id serial NOT NULL,
  "idGrupo" serial NOT NULL,
  "idUsuario" serial NOT NULL,
  CONSTRAINT "pk_id_grupoUsr" PRIMARY KEY (id),
  CONSTRAINT fg_id_grupo FOREIGN KEY ("idGrupo")
      REFERENCES "Grupo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_usuario FOREIGN KEY ("idUsuario")
      REFERENCES "Usuario" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE "Multimedia"
(
  id serial NOT NULL,
  "idBache" serial NOT NULL,
  nombre character varying,
  tipo character varying,
  ruta character varying,
  CONSTRAINT pk_id_multimedia PRIMARY KEY (id),
  CONSTRAINT fg_id_bache FOREIGN KEY ("idBache")
      REFERENCES "Bache" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE "Observacion"
(
  id serial NOT NULL,
  "idBache" serial NOT NULL,
  "nombreObservador" character varying,
  "emailObservador" character varying,
  CONSTRAINT pk_id_observacion PRIMARY KEY (id),
  CONSTRAINT fg_id_bache FOREIGN KEY ("idBache")
      REFERENCES "Bache" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE "Permiso"
(
  id serial NOT NULL,
  nombre character varying(50),
  CONSTRAINT pk_id_permiso PRIMARY KEY (id)
);

CREATE TABLE "PermisoGrupo"
(
  id serial NOT NULL,
  "idPermiso" serial NOT NULL,
  "idGrupo" serial NOT NULL,
  CONSTRAINT "pk_id_permisoGrp" PRIMARY KEY (id),
  CONSTRAINT fg_id_grupo FOREIGN KEY ("idGrupo")
      REFERENCES "Grupo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_permiso FOREIGN KEY ("idPermiso")
      REFERENCES "Permiso" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);


CREATE TABLE "Usuario"
(
  id serial NOT NULL,
  nombre character varying,
  constrasenia character varying,
  CONSTRAINT pk_id_usuario PRIMARY KEY (id)
);
INSERT INTO "Criticidad" (nombre, descripcion) VALUES ('alta','asdsadsadasdsadsadsadasda'),('media','asdsadsadasdsadsadsadasda'), ('baja','asdsadsadasdsadsadsadasda');