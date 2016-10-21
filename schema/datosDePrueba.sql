

--1.Habilitar CGI con archivo /etc/apache2/apache2.conf:
--a)Ejecutar comando para habilitar el modulo CGI: $sudo a2enmod cgi
--b)Agregar la siguiente linea al archivo apache2.conf:
--
--Configuracion para habilitar CGI-BIN
--<Directory "/var/www/html/tkinect2016/webGLViewer/cgi-bin">
--    Options +ExecCGI
--    AddHandler cgi-script .cgi
--</Directory>

--c)Reiniciar apache: $ sudo service apache2 restart


--2. Habilitar reescritura de URL en apache2.conf con:
--a) Habilitar el modulo de reescritura de URL con: $a2enmod rewrite enable
--b) Editar apache2.conf y agregar:

-- <Directory />
-- 	Options FollowSymLinks
-- 	AllowOverride All
-- 	Require all denied
-- </Directory>

-- <Directory /var/www/>
-- 	Options Indexes FollowSymLinks
-- 	AllowOverride All
-- 	Require all granted
-- </Directory>

-- $ Reiniciar apache2: $ sudo service apache2 restart


-- 3. Configurar en el archivo apache2/sites-enabled/000-default.conf la ruta
-- de la carpeta multimedia raiz de los pcds dentro del FS del servidor con 
-- lo siguiente:
-- 
-- 	<Directory "/var/www/html/repoProyectoBacheo/web/application/dataMultimedia">
--     Allow from all
--     Require all granted
--  </Directory>
--  
--  Y recargar conf. de apache: $ sudo service apache2 reload


-- 4. Ejecutar el siguiente script para la prueba de la aplicacion -->
-- 
-- Scritp con datos de prueba obligatorios
INSERT INTO "MultimediaModelo"(id,nombreArchivo) 
	VALUES(1,'bache.png');

INSERT INTO "MultimediaModelo"(id,nombreArchivo) 
	VALUES(1,'grieta.png');

INSERT INTO "MultimediaModelo"(id,nombreArchivo) 
	VALUES(1,'ahuellamiento.png');


INSERT INTO "TipoFallaModelo"(id,nombre,influencia,"idMultimedia") 
	VALUES(1,'Bache',1,1);

INSERT INTO "TipoFallaModelo"(id,nombre,influencia,"idMultimedia") 
	VALUES(2,'Grieta',2,2);

INSERT INTO "TipoFallaModelo"(id,nombre,influencia,"idMultimedia") 
	VALUES(3,'Ahuellamiento',3,3);


 
INSERT INTO "TipoMaterialModelo"(id,nombre) 
	VALUES(1,'Semento');

 
INSERT INTO "TipoMaterialModelo"(id,nombre) 
	VALUES(2,'Asfalto');

 
INSERT INTO "TipoMaterialModelo"(id,nombre) 
	VALUES(3,'Concreto');




INSERT INTO "TipoMaterialTipoFallaModelo"("idTipoMaterial","idTipoFalla") 
	VALUES(1,1);


INSERT INTO "TipoMaterialTipoFallaModelo"("idTipoMaterial","idTipoFalla") 
	VALUES(2,2);

INSERT INTO "TipoMaterialTipoFallaModelo"("idTipoMaterial","idTipoFalla") 
	VALUES(3,3);


--Se cargan los estados del bache en tipoEstadoModelo (Informado|Confirmado| Reparando | Reparado)

INSERT INTO "TipoEstadoModelo"(id,nombre) 
	VALUES(1,"Informado");

INSERT INTO "TipoEstadoModelo"(id,nombre) 
	VALUES(2,"Confirmado");

INSERT INTO "TipoEstadoModelo"(id,nombre) 
	VALUES(3,"Reparando");

INSERT INTO "TipoEstadoModelo"(id,nombre) 
	VALUES(4,"Reparado");











	




