-- Table: "Calle"

-- DROP TABLE "Calle";

CREATE TABLE "Calle"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_id_calle PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "Calle"
  OWNER TO adminpepe;


-- Table: "Criticidad"

-- DROP TABLE "Criticidad";

CREATE TABLE "Criticidad"
(
  id serial NOT NULL,
  nombre character varying(50),
  descripcion character varying,
  CONSTRAINT pk_id_criticidad PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "Criticidad"
  OWNER TO adminpepe;


-- Table: "Estado"

-- DROP TABLE "Estado";

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
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "Estado"
  OWNER TO adminpepe;




-- Table: "Bache"

-- DROP TABLE "Bache";

CREATE TABLE "Bache"
(
  id serial NOT NULL,
  latitud bigserial,
  longitud bigserial,
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
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "Bache"
  OWNER TO adminpepe;

-- Table: "Grupo"

-- DROP TABLE "Grupo";

CREATE TABLE "Grupo"
(
  id serial NOT NULL,
  nombre character varying(50),
  CONSTRAINT pk_id_grupo PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "Grupo"
  OWNER TO adminpepe;

-- Table: "GrupoUsuario"

-- Table: "Usuario"

-- DROP TABLE "Usuario";

CREATE TABLE "Usuario"
(
  id serial NOT NULL,
  nombre character varying,
  constrasenia character varying,
  CONSTRAINT pk_id_usuario PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "Usuario"
  OWNER TO adminpepe;


-- DROP TABLE "GrupoUsuario";
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
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "GrupoUsuario"
  OWNER TO adminpepe;

-- Table: "Multimedia"

-- DROP TABLE "Multimedia";

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
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "Multimedia"
  OWNER TO adminpepe;

-- Table: "Observacion"

-- DROP TABLE "Observacion";

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
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "Observacion"
  OWNER TO adminpepe;

-- Table: "Permiso"

-- DROP TABLE "Permiso";

CREATE TABLE "Permiso"
(
  id serial NOT NULL,
  nombre character varying(50),
  CONSTRAINT pk_id_permiso PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "Permiso"
  OWNER TO adminpepe;

-- Table: "PermisoGrupo"

-- DROP TABLE "PermisoGrupo";

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
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "PermisoGrupo"
  OWNER TO adminpepe;


-- Table: "TipoEstado"

-- DROP TABLE "TipoEstado";

CREATE TABLE "TipoEstado"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_tipo_estado PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "TipoEstado"
  OWNER TO adminpepe;


-- Table: "Usuario"

-- DROP TABLE "Usuario";

CREATE TABLE "Usuario"
(
  id serial NOT NULL,
  nombre character varying,
  constrasenia character varying,
  CONSTRAINT pk_id_usuario PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "Usuario"
  OWNER TO adminpepe;

