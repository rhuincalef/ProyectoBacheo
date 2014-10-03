CREATE TABLE ci_sessions (
  session_id varchar(40) DEFAULT '0' NOT NULL,
  ip_address varchar(16) DEFAULT '0' NOT NULL,
  user_agent varchar(120) NOT NULL,
  last_activity int DEFAULT 0 NOT NULL,
  user_data text NOT NULL,
  PRIMARY KEY (session_id)
);

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


CREATE TABLE "groups" (
    "id" SERIAL NOT NULL,
    "name" varchar(20) NOT NULL,
    "description" varchar(100) NOT NULL,
  PRIMARY KEY("id"),
  CONSTRAINT "check_id" CHECK(id >= 0)
);


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

CREATE TABLE "login_attempts" (
    "id" SERIAL NOT NULL,
    "ip_address" varchar(15),
    "login" varchar(100) NOT NULL,
    "time" int,
  PRIMARY KEY("id"),
  CONSTRAINT "check_id" CHECK(id >= 0)
);

DROP TABLE IF EXISTS "CriticidadModelo";
CREATE TABLE "CriticidadModelo"
(
  id serial NOT NULL,
  "nombreInformal" character varying(50),
  "nombreFormal" character varying(50),
  descripcion character varying,
  CONSTRAINT pk_id_criticidad PRIMARY KEY (id)
);

DROP TABLE IF EXISTS "Calle";
CREATE TABLE "Calle"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_id_calle PRIMARY KEY (id)
);

DROP TABLE IF EXISTS "Direccion";
CREATE TABLE "Direccion"
(
  id serial NOT NULL,
  "idCallePrincipal" integer NOT NULL,
  "altura" integer NOT NULL,
  "idCalleSecundariaA" integer,
  "idCalleSecundariaB" integer,

--  CONSTRAINT pk_id_direccion PRIMARY KEY ("idCallePrincipal","altura"),
  CONSTRAINT pk_id_direccion PRIMARY KEY (id),
  CONSTRAINT fg_id_calle_secundaria_a FOREIGN KEY ("idCalleSecundariaA")
      REFERENCES "Calle" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_calle_secundaria_b FOREIGN KEY ("idCalleSecundariaB")
      REFERENCES "Calle" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);



DROP TABLE IF EXISTS "TipoRotura";
CREATE TABLE "TipoRotura"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_tipo_rotura PRIMARY KEY (id)
);


DROP TABLE IF EXISTS "TipoMaterial";
CREATE TABLE "TipoMaterial"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_id_tipo_material PRIMARY KEY (id)
);


DROP TABLE IF EXISTS "Material";
CREATE TABLE "Material"
(
  id serial NOT NULL,
  "idTipoMaterial" integer,
  "idTipoRotura" integer,
  "numeroBaldosa" integer,
  CONSTRAINT pk_id_material PRIMARY KEY (id),
  CONSTRAINT "fk_id_tipo_material" FOREIGN KEY ("idTipoMaterial")
  REFERENCES "TipoMaterial" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT "fk_id_tipo_rotura" FOREIGN KEY ("idTipoRotura")
  REFERENCES "TipoRotura" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

DROP TABLE IF EXISTS "Bache";
CREATE TABLE "Bache"
(
  id serial NOT NULL,
  latitud double precision,
  longitud double precision,
  "idCriticidad" integer,
  "idDireccion" integer,
  "idMaterial" integer,
  ancho double precision,
  largo double precision,
  profundidad double precision,
  "tipoObstruccion" TipoObstruccion,
  CONSTRAINT pk_id_bache PRIMARY KEY (id),
  CONSTRAINT fg_direccion FOREIGN KEY ("idDireccion")
      REFERENCES "Direccion" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_criticidad FOREIGN KEY ("idCriticidad")
      REFERENCES "CriticidadModelo" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fg_id_material FOREIGN KEY ("idMaterial")
      REFERENCES "Material" (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);


DROP TABLE IF EXISTS "TipoEstado";
CREATE TABLE "TipoEstado"
(
  id serial NOT NULL,
  nombre character varying,
  CONSTRAINT pk_id_tipo_estado PRIMARY KEY (id)
);


DROP TABLE IF EXISTS "Estado";
CREATE TABLE "Estado"
(
  id serial NOT NULL,
  "idBache" integer,
  fecha timestamp,
  "idUsuario" integer,
  "idTipoEstado" integer,
  monto double precision,
  "fechaFinReparacion" timestamp,
  CONSTRAINT pk_id_estado PRIMARY KEY (id),
  CONSTRAINT fk_id_bache FOREIGN KEY ("idBache")
  REFERENCES "Bache" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_id_tipo_estado FOREIGN KEY ("idTipoEstado")
  REFERENCES "TipoEstado" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION ,
  CONSTRAINT fk_id_usuario FOREIGN KEY ("idUsuario")
  REFERENCES users (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION

);

DROP TABLE IF EXISTS "Observacion";
CREATE TABLE "Observacion"
(
  "idBache" integer,
  fecha timestamp,
  comentario character varying NOT NULL, 
  "nombreObservador" character varying NOT NULL,
  "emailObservador"  character varying NOT NULL,
  CONSTRAINT pk_id_observacion PRIMARY KEY ("idBache",fecha),
  CONSTRAINT fk_id_bache FOREIGN KEY ("idBache")
  REFERENCES "Bache" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

DROP TABLE IF EXISTS "Multimedia";
CREATE TABLE "Multimedia"
(
  "idBache" integer,
  "nombre" character varying NOT NULL,
  "tipo" character varying NOT NULL,
  CONSTRAINT pk_id_multimedia PRIMARY KEY ("idBache","nombre"),
  CONSTRAINT fk_id_bache FOREIGN KEY ("idBache")
  REFERENCES "Bache" (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);
