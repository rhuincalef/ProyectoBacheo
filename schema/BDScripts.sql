/*
Todos los Drop en el orden que van para que no estorben

DROP TABLE IF EXISTS "MultimediaModelo";
DROP TABLE IF EXISTS "ObservacionModelo";
DROP TABLE IF EXISTS "TipoAtributoModelo";
DROP TABLE IF EXISTS "FallaTipoAtributoModelo";
DROP TABLE IF EXISTS "ConformaNivelServicioModelo";
DROP TABLE IF EXISTS "FallaEstadoModelo";
DROP TABLE IF EXISTS "EstadoModelo";
DROP TABLE IF EXISTS "FallaModelo";
DROP TABLE IF EXISTS "DireccionModelo";
DROP TABLE IF EXISTS "CalleModelo";
DROP TABLE IF EXISTS "TipoFallaCriticidadModelo";
DROP TABLE IF EXISTS "TipoFallaTipoReparacionModelo";
DROP TABLE IF EXISTS "TipoMaterialTipoFallaModelo";
DROP TABLE IF EXISTS "TipoFallaModelo";
DROP TABLE IF EXISTS "CriticidadModelo";
DROP TABLE IF EXISTS "TipoMaterialModelo";
DROP TABLE IF EXISTS "TipoReparacionModelo";
DROP TABLE IF EXISTS "TipoEstadoModelo";
DROP TABLE IF EXISTS "FallaMultimediaModelo";
DROP TABLE IF EXISTS "NivelServicioModelo";
DROP TABLE IF EXISTS "ci_sessions";
DROP TABLE IF EXISTS "users";
DROP TABLE IF EXISTS "groups";
DROP TABLE IF EXISTS "users_groups";
DROP TABLE IF EXISTS "login_attempts";
*/



DROP TABLE IF EXISTS "ci_sessions";
CREATE TABLE ci_sessions (
  session_id varchar(40) DEFAULT '0' NOT NULL,
  ip_address varchar(16) DEFAULT '0' NOT NULL,
  user_agent varchar(120) NOT NULL,
  last_activity int DEFAULT 0 NOT NULL,
  user_data text NOT NULL,
  PRIMARY KEY (session_id)
);

DROP TABLE IF EXISTS "users";
CREATE TABLE "users" (
    "id" SERIAL NOT NULL,
    "ip_address" varchar(15),
    "username" varchar(100) NOT NULL,
    "password" varchar(255) NOT NULL,
    "salt" varchar(255),
    "email" varchar(100) NOT NULL,
    "activation_code" varchar(40),
    "forgotten_password_code" varchar(40),
    "forgotten_password_time" int,
    "remember_code" varchar(40),
    "created_on" int NOT NULL,
    "last_login" int,
    "active" int,
    "first_name" varchar(50),
    "last_name" varchar(50),
    "company" varchar(100),
    "phone" varchar(20),
  PRIMARY KEY("id"),
  CONSTRAINT "check_id" CHECK(id >= 0),
  CONSTRAINT "check_active" CHECK(active >= 0)
);

DROP TABLE IF EXISTS "groups";
CREATE TABLE "groups" (
    "id" SERIAL NOT NULL,
    "name" varchar(20) NOT NULL,
    "description" varchar(100) NOT NULL,
  PRIMARY KEY("id"),
  CONSTRAINT "check_id" CHECK(id >= 0)
);

DROP TABLE IF EXISTS "users_groups";
CREATE TABLE "users_groups" (
    "id" SERIAL NOT NULL,
    "user_id" integer NOT NULL,
    "group_id" integer NOT NULL,
  PRIMARY KEY("id"),
  CONSTRAINT "uc_users_groups" UNIQUE (user_id, group_id),
  CONSTRAINT "users_groups_check_id" CHECK(id >= 0),
  CONSTRAINT "users_groups_check_user_id" CHECK(user_id >= 0),
  CONSTRAINT "users_groups_check_group_id" CHECK(group_id >= 0)
);


INSERT INTO groups (id, name, description) VALUES
    (1,'admin','Administrator'),
    (2,'members','General User');

INSERT INTO users (ip_address, username, password, salt, email, activation_code, forgotten_password_code, created_on, last_login, active, first_name, last_name, company, phone) VALUES
    ('127.0.0.1','administrator','$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36','','admin@admin.com','',NULL,'1268889823','1268889823','1','Admin','istrator','ADMIN','0');

INSERT INTO users_groups (user_id, group_id) VALUES
    (1,1),
    (1,2);

DROP TABLE IF EXISTS "login_attempts";
CREATE TABLE "login_attempts" (
    "id" SERIAL NOT NULL,
    "ip_address" varchar(15),
    "login" varchar(100) NOT NULL,
    "time" int,
  PRIMARY KEY("id"),
  CONSTRAINT "check_id" CHECK(id >= 0)
);

-- ACA EMPIEZA


DROP TABLE IF EXISTS "CriticidadModelo";
CREATE TABLE "CriticidadModelo"
(
  id serial NOT NULL,
  nombre character varying(50),
  descripcion character varying,
  ponderacion double precision,
  CONSTRAINT pk_id_criticidad PRIMARY KEY (id)
);

DROP TABLE IF EXISTS "CalleModelo";
CREATE TABLE "CalleModelo"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_id_calle PRIMARY KEY (id)
);

DROP TABLE IF EXISTS "DireccionModelo";
CREATE TABLE "DireccionModelo"
(
  id serial NOT NULL,
  "idCallePrincipal" integer NOT NULL,
  altura integer NOT NULL,
  "idCalleSecundariaA" integer,
  "idCalleSecundariaB" integer,
  rangoestimado1 integer,
  rangoestimado2 integer,

--  CONSTRAINT pk_id_direccion PRIMARY KEY ("idCallePrincipal","altura"),
  CONSTRAINT pk_id_direccion PRIMARY KEY (id),
  CONSTRAINT fg_id_calle_secundaria_a FOREIGN KEY ("idCalleSecundariaA")
      REFERENCES "CalleModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_calle_secundaria_b FOREIGN KEY ("idCalleSecundariaB")
      REFERENCES "CalleModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);




-- DROP TABLE IF EXISTS "TipoRoturaModelo";
-- CREATE TABLE "TipoRoturaModelo"
-- (
--   id serial NOT NULL,
--   nombre character varying,
--   CONSTRAINT pk_tipo_rotura PRIMARY KEY (id)
-- );


DROP TABLE IF EXISTS "MultimediaModelo";
CREATE TABLE "MultimediaModelo"
(
--  "idFalla" integer NOT NULL,
  id serial NOT NULL,
  "nombreArchivo" character varying NOT NULL,
  extension character varying NOT NULL,
  CONSTRAINT pk_id_multimedia PRIMARY KEY (id)
/*  CONSTRAINT pk_id_multimedia PRIMARY KEY ("idFalla","nombreArchivo"),
  CONSTRAINT fk_id_falla FOREIGN KEY ("idFalla")
  REFERENCES "FallaModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION*/
);

DROP TABLE IF EXISTS "TipoFallaModelo";
CREATE TABLE "TipoFallaModelo"
(
  id serial NOT NULL,
  nombre character varying,
  influencia int NOT NULL,
  "idMultimedia" integer NOT NULL,
  CONSTRAINT pk_tipo_falla PRIMARY KEY (id),
  CONSTRAINT fk_id_multimedia FOREIGN KEY ("idMultimedia")
      REFERENCES "MultimediaModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

DROP TABLE IF EXISTS "TipoFallaCriticidadModelo";
CREATE TABLE "TipoFallaCriticidadModelo"
(
  "idTipoFalla" integer NOT NULL,
  "idCriticidad" integer NOT NULL,
  CONSTRAINT pk_id_tipo_falla_criticidad PRIMARY KEY ("idTipoFalla","idCriticidad"),
  CONSTRAINT fk_id_tipo_falla FOREIGN KEY ("idTipoFalla")
  REFERENCES "TipoFallaModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_id_criticidad FOREIGN KEY ("idCriticidad")
  REFERENCES "CriticidadModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);


DROP TABLE IF EXISTS "TipoMaterialModelo";
CREATE TABLE "TipoMaterialModelo"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_id_tipo_material PRIMARY KEY (id),
  CONSTRAINT uc_nombre UNIQUE (nombre)
);

DROP TABLE IF EXISTS "TipoReparacionModelo";
CREATE TABLE "TipoReparacionModelo"
(
  id serial NOT NULL,
  nombre character varying,
  descripcion character varying,
  costo double precision,
  CONSTRAINT pk_id_tipo_reparacion PRIMARY KEY (id)
);


DROP TABLE IF EXISTS "TipoFallaTipoReparacionModelo";
CREATE TABLE "TipoFallaTipoReparacionModelo"
(
  "idTipoFalla" integer NOT NULL,
  "idTipoReparacion" integer NOT NULL,
  CONSTRAINT pk_id_tipo_falla_tipo_reparacion PRIMARY KEY ("idTipoFalla","idTipoReparacion"),
  CONSTRAINT fk_id_tipo_falla FOREIGN KEY ("idTipoFalla")
  REFERENCES "TipoFallaModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_id_tipo_reparacion FOREIGN KEY ("idTipoReparacion")
  REFERENCES "TipoReparacionModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

-- DROP TABLE IF EXISTS "MaterialModelo";
-- CREATE TABLE "MaterialModelo"
-- (
--   id serial NOT NULL,
--   "idTipoMaterial" integer,
--   "idTipoRotura" integer,
--   "numeroBaldosa" integer,
--   CONSTRAINT pk_id_material PRIMARY KEY (id),
--   CONSTRAINT "fk_id_tipo_material" FOREIGN KEY ("idTipoMaterial")
--   REFERENCES "TipoMaterialModelo" (id) MATCH SIMPLE
--   ON UPDATE NO ACTION ON DELETE NO ACTION,
--   CONSTRAINT "fk_id_tipo_rotura" FOREIGN KEY ("idTipoRotura")
--   REFERENCES "TipoRoturaModelo" (id) MATCH SIMPLE
--   ON UPDATE NO ACTION ON DELETE NO ACTION
-- );

-- CREATE TYPE "TipoObstruccion" AS ENUM ('parcial', 'total');


DROP TABLE IF EXISTS "FallaModelo";
CREATE TABLE "FallaModelo"
(
  id serial NOT NULL,
  latitud double precision,
  longitud double precision,
  "idCriticidad" integer,
  "idDireccion" integer,
  "idTipoMaterial" integer,
  "idTipoFalla" integer,
  "idTipoReparacion" integer,
  "areaAfectada" integer,
  CONSTRAINT pk_id_Falla PRIMARY KEY (id),
  CONSTRAINT fg_direccion FOREIGN KEY ("idDireccion")
      REFERENCES "DireccionModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_criticidad FOREIGN KEY ("idCriticidad")
      REFERENCES "CriticidadModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_tipo_material FOREIGN KEY ("idTipoMaterial")
      REFERENCES "TipoMaterialModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_tipo_falla FOREIGN KEY ("idTipoFalla")
      REFERENCES "TipoFallaModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_tipo_reparacion FOREIGN KEY ("idTipoReparacion")
      REFERENCES "TipoReparacionModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);


DROP TABLE IF EXISTS "TipoEstadoModelo";
CREATE TABLE "TipoEstadoModelo"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_id_tipo_estado PRIMARY KEY (id)
);


DROP TABLE IF EXISTS "EstadoModelo";
CREATE TABLE "EstadoModelo"
(
  id serial NOT NULL,
  "idFalla" integer,
  "idUsuario" integer,
  "idTipoEstado" integer,
  "montoEstimado" double precision,
  "montoReal" double precision,
  "fechaFinReparacionReal" timestamp,
  "fechaFinReparacionEstimada" timestamp,
  CONSTRAINT pk_id_estado PRIMARY KEY (id),
  CONSTRAINT fk_id_falla FOREIGN KEY ("idFalla")
  REFERENCES "FallaModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_id_tipo_estado FOREIGN KEY ("idTipoEstado")
  REFERENCES "TipoEstadoModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION ,
  CONSTRAINT fk_id_usuario FOREIGN KEY ("idUsuario")
  REFERENCES users (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION

);


DROP TABLE IF EXISTS "FallaEstadoModelo";
CREATE TABLE "FallaEstadoModelo"
(
  "idFalla" integer NOT NULL,
  "idEstado" integer NOT NULL,
  fecha timestamp NOT NULL,
  CONSTRAINT pk_id_falla_estado PRIMARY KEY ("idFalla","idEstado",fecha),
  
  CONSTRAINT fk_id_falla FOREIGN KEY ("idFalla")
  REFERENCES "FallaModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_id_estado FOREIGN KEY ("idEstado")
  REFERENCES "EstadoModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);




DROP TABLE IF EXISTS "ObservacionModelo";
CREATE TABLE "ObservacionModelo"
(
  "idFalla" integer NOT NULL,
  fecha timestamp NOT NULL,
  comentario character varying NOT NULL, 
  "nombreObservador" character varying NOT NULL,
  "emailObservador"  character varying NOT NULL,
  CONSTRAINT pk_id_observacion PRIMARY KEY ("idFalla",fecha),
  CONSTRAINT fk_id_falla FOREIGN KEY ("idFalla")
  REFERENCES "FallaModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

-- Table: "FallaMultimediaModelo"

DROP TABLE IF EXISTS "FallaMultimediaModelo";

CREATE TABLE "FallaMultimediaModelo"
(
  "idFalla" integer NOT NULL,
  "idMultimedia" integer NOT NULL,
  CONSTRAINT fk_id_falla FOREIGN KEY ("idFalla")
      REFERENCES "FallaModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_id_multimedia FOREIGN KEY ("idMultimedia")
      REFERENCES "MultimediaModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

DROP TABLE IF EXISTS "TipoAtributoModelo";
CREATE TABLE "TipoAtributoModelo"
(
  id serial NOT NULL,
--  "idFalla" integer NOT NULL,
  "idTipoFalla" integer NOT NULL,
  "nombre" character varying NOT NULL,
  "unidadMedida" character varying NOT NULL,
  CONSTRAINT pk_id_tipo_atributo PRIMARY KEY ("id"),
  CONSTRAINT fk_id_tipo_falla FOREIGN KEY ("idTipoFalla")
  REFERENCES "TipoFallaModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

DROP TABLE IF EXISTS "FallaTipoAtributoModelo";
CREATE TABLE "FallaTipoAtributoModelo"
(
  "idFalla" integer NOT NULL,
  "idTipoAtributo" integer NOT NULL,
  valor character varying NOT NULL,
  CONSTRAINT pk_id_falla_tipo_atributo PRIMARY KEY ("idFalla","idTipoAtributo"),
  CONSTRAINT fk_id_falla FOREIGN KEY ("idFalla")
  REFERENCES "FallaModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_id_tipo_atributo FOREIGN KEY ("idTipoAtributo")
  REFERENCES "TipoAtributoModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

DROP TABLE IF EXISTS "TipoMaterialTipoFallaModelo";
CREATE TABLE "TipoMaterialTipoFallaModelo"
(
  "idTipoMaterial" integer NOT NULL,
  "idTipoFalla" integer NOT NULL,
  CONSTRAINT pk_id_tipo_material_tipo_falla PRIMARY KEY ("idTipoMaterial","idTipoFalla"),
  CONSTRAINT fk_id_tipo_falla FOREIGN KEY ("idTipoFalla")
  REFERENCES "TipoFallaModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_tipo_material FOREIGN KEY ("idTipoMaterial")
  REFERENCES "TipoMaterialModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

DROP TABLE IF EXISTS "NivelServicioModelo";
CREATE TABLE "NivelServicioModelo"
(
  id serial NOT NULL,
  "estadoCalle" character varying NOT NULL,
  "tipoMantenimiento" character varying NOT NULL,
  valor integer NOT NULL,
  CONSTRAINT pk_id_nivel_servicio PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "ConformaNivelServicioModelo";
CREATE TABLE "ConformaNivelServicioModelo"
(
  "idFalla" integer NOT NULL,
  "idCalle" integer NOT NULL,
  "idNivelServicio" integer NOT NULL,
  CONSTRAINT pk_id_conforma_nivel_servicio PRIMARY KEY ("idFalla","idCalle","idNivelServicio"),
  CONSTRAINT fk_id_falla FOREIGN KEY ("idFalla")
  REFERENCES "FallaModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_id_calle FOREIGN KEY ("idCalle")
  REFERENCES "CalleModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_id_nivel_servicio FOREIGN KEY ("idNivelServicio")
  REFERENCES "NivelServicioModelo" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);


