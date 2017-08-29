-- INSERT - TABLE "TipoMaterialModelo"
INSERT INTO public."TipoMaterialModelo"(
            id, nombre)
    VALUES (1, 'pavimento rígido');

INSERT INTO public."TipoMaterialModelo"(
            id, nombre)
    VALUES (2, 'pavimento flexible');

INSERT INTO public."TipoMaterialModelo"(
            id, nombre)
    VALUES (3, 'pavimento articulado');

-- INSERT - TABLE "TipoEstadoModelo"
INSERT INTO public."TipoEstadoModelo"(
            id, nombre)
    VALUES (1, 'informado');

INSERT INTO public."TipoEstadoModelo"(
            id, nombre)
    VALUES (2, 'confirmado');

INSERT INTO public."TipoEstadoModelo"(
            id, nombre)
    VALUES (3, 'reparando');

INSERT INTO public."TipoEstadoModelo"(
            id, nombre)
    VALUES (4, 'reparado');


-- INSERT - TABLE "MultimediaModelo"
INSERT INTO public."MultimediaModelo"(
            id, "nombreArchivo", extension)
    VALUES (default, '/home/manjaro-guille/mis_proyectos/ProyectoBacheo/web/_/img/Multimedias/TipoFalla/1/deficiencia de sellado.jpeg', 'jpeg');

INSERT INTO public."MultimediaModelo"(
            id, "nombreArchivo", extension)
    VALUES (default, '/home/manjaro-guille/mis_proyectos/ProyectoBacheo/web/_/img/Multimedias/TipoFalla/2/grietas.png', 'png');

INSERT INTO public."MultimediaModelo"(
            id, "nombreArchivo", extension)
    VALUES (default, '/home/manjaro-guille/mis_proyectos/ProyectoBacheo/web/_/img/Multimedias/TipoFalla/3/baches.png', 'png');

INSERT INTO public."MultimediaModelo"(
            id, "nombreArchivo", extension)
    VALUES (default, '/home/manjaro-guille/mis_proyectos/ProyectoBacheo/web/_/img/Multimedias/TipoFalla/4/ahuellamiento.png', 'png');

--
-- Tener en cuenta que las imágenes deben existir en carpeta asignada en el proyecto para la subida de archivos multimediales.
-- Example:
--   $config['upload_path'] = './_/img/Multimedias';
--
-- INSERT - TABLE "TipoFallaModelo"
INSERT INTO public."TipoFallaModelo"(
            id, nombre, influencia, "idMultimedia")
    VALUES (1, 'deficiencia de sellado', 48, 1);

INSERT INTO public."TipoFallaModelo"(
            id, nombre, influencia, "idMultimedia")
    VALUES (2, 'baches', 50, 2);

INSERT INTO public."TipoFallaModelo"(
            id, nombre, influencia, "idMultimedia")
    VALUES (3, 'grietas', 20, 3);

INSERT INTO public."TipoFallaModelo"(
            id, nombre, influencia, "idMultimedia")
    VALUES (4, 'ahuellamiento y depresiones', 50, 4);

-- INSERT - TABLE "TipoMaterialTipoFallaModelo"
INSERT INTO public."TipoMaterialTipoFallaModelo"(
            "idTipoMaterial", "idTipoFalla")
    VALUES (1, 1);

INSERT INTO public."TipoMaterialTipoFallaModelo"(
            "idTipoMaterial", "idTipoFalla")
    VALUES (1, 2);

INSERT INTO public."TipoMaterialTipoFallaModelo"(
            "idTipoMaterial", "idTipoFalla")
    VALUES (1, 3);

INSERT INTO public."TipoMaterialTipoFallaModelo"(
            "idTipoMaterial", "idTipoFalla")
    VALUES (2, 4);

-- INSERT - TABLE "CriticidadModelo"
-- Criticidades para deficiencias de sellado
INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (1, 'bajo', 'longitud con deficiencias de sellado < 5% de la longitud de la junta', 1);

INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (2, 'medio', '5% longitud con deficiencias de sellado 25% de la longitud de la junta', 1.15);

INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (3, 'alto', 'longitud con deficiencias de sellado > 25% de la longitud de la junta', 1.3);
-- Fin Criticidades para deficiencias de sellado

-- Criticidades para baches
INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (4, 'bajo', 'Se determina por cantidad de baches y dimensiones', 1);

INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (5, 'medio', 'Se determina por cantidad de baches y dimensiones', 1.15);

INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (6, 'alto', 'Se determina por cantidad de baches y dimensiones', 1.3);
-- Fin Criticidades para baches

-- Criticidades para grietas
INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (7, 'bajo', 'ancho < 3 mm, sin saltaduras y escalonamiento imperceptible', 1);

INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (8, 'medio', '3 ≤ancho grieta≤ 10 mm ó c/ resaltos de ancho < 50 mm ó escalonamiento < 15 mm', 1.15);

INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (9, 'alto', 'ancho 10 mm ó resaltos de ancho 50 mm ó escalonamiento 15 mm', 1.3);
-- Fin Criticidades para grietas

-- Criticidades para ahuellamiento y depresiones
INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (10, 'bajo', 'profundidad máxima del ahuellamiento es inferior a los 20 mm', 1);

INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (11, 'medio', 'profundidad máxima es mayor a 20 mm pero inferior a 40 mm', 1.15);

INSERT INTO public."CriticidadModelo"(
            id, nombre, descripcion, ponderacion)
    VALUES (12, 'alto', 'profundidad máxima superior a 40 mm', 1.3);
-- Fin Criticidades para ahuellamiento y depresiones

-- INSERT - TABLE "TipoFallaCriticidadModelo"
INSERT INTO public."TipoFallaCriticidadModelo"(
            "idTipoFalla", "idCriticidad")
    VALUES (1, 1);
INSERT INTO public."TipoFallaCriticidadModelo"(
        "idTipoFalla", "idCriticidad")
    VALUES (1, 2);

INSERT INTO public."TipoFallaCriticidadModelo"(
        "idTipoFalla", "idCriticidad")
    VALUES (1, 3);

INSERT INTO public."TipoFallaCriticidadModelo"(
            "idTipoFalla", "idCriticidad")
    VALUES (2, 4);
INSERT INTO public."TipoFallaCriticidadModelo"(
        "idTipoFalla", "idCriticidad")
    VALUES (2, 5);

INSERT INTO public."TipoFallaCriticidadModelo"(
        "idTipoFalla", "idCriticidad")
    VALUES (2, 6);

INSERT INTO public."TipoFallaCriticidadModelo"(
            "idTipoFalla", "idCriticidad")
    VALUES (3, 7);
INSERT INTO public."TipoFallaCriticidadModelo"(
        "idTipoFalla", "idCriticidad")
    VALUES (3, 8);

INSERT INTO public."TipoFallaCriticidadModelo"(
        "idTipoFalla", "idCriticidad")
    VALUES (3, 9);

INSERT INTO public."TipoFallaCriticidadModelo"(
        "idTipoFalla", "idCriticidad")
    VALUES (4, 10);

INSERT INTO public."TipoFallaCriticidadModelo"(
        "idTipoFalla", "idCriticidad")
    VALUES (4, 11);

INSERT INTO public."TipoFallaCriticidadModelo"(
        "idTipoFalla", "idCriticidad")
    VALUES (4, 12);

-- INSERT - TABLE "TipoReparacionModelo"
INSERT INTO public."TipoReparacionModelo"(
            id, nombre, descripcion, costo)
    VALUES (1, 'Sellado de juntas y grietas', 'Sellado de juntas y grietas', 100);

INSERT INTO public."TipoReparacionModelo"(
            id, nombre, descripcion, costo)
    VALUES (2, 'reparación especial', 'Dependiendo del deterioro', 100);

INSERT INTO public."TipoReparacionModelo"(
            id, nombre, descripcion, costo)
    VALUES (3, 'Sellado de juntas y grietas', 'Sellado de juntas y grietas', 100);

INSERT INTO public."TipoReparacionModelo"(
            id, nombre, descripcion, costo)
    VALUES (4, 'Reparación en todo el espesor', 'Reparación en todo el espesor', 100);

INSERT INTO public."TipoReparacionModelo"(
            id, nombre, descripcion, costo)
    VALUES (5, 'Reparación para puesta en servicio acelerada', 'Reparación para puesta en servicio acelerada', 100);

INSERT INTO public."TipoReparacionModelo"(
            id, nombre, descripcion, costo)
    VALUES (6, 'Perfilado del pavimento', 'Severidad baja perfilado del pavimento', 100);

INSERT INTO public."TipoReparacionModelo"(
            id, nombre, descripcion, costo)
    VALUES (7, 'Relleno de la rodadera', 'Severidad media relleno de la rodadera', 100);

INSERT INTO public."TipoReparacionModelo"(
            id, nombre, descripcion, costo)
    VALUES (8, 'Reparación local de la estructura del pavimento', 'Severidad alta reparación local de la estructura del pavimento', 100);

-- INSERT - TABLE "TipoFallaTipoReparacionModelo"
INSERT INTO public."TipoFallaTipoReparacionModelo"(
            "idTipoFalla", "idTipoReparacion")
    VALUES (1, 1);

INSERT INTO public."TipoFallaTipoReparacionModelo"(
            "idTipoFalla", "idTipoReparacion")
    VALUES (2, 2);

INSERT INTO public."TipoFallaTipoReparacionModelo"(
            "idTipoFalla", "idTipoReparacion")
    VALUES (3, 3);

INSERT INTO public."TipoFallaTipoReparacionModelo"(
            "idTipoFalla", "idTipoReparacion")
    VALUES (3, 4);

INSERT INTO public."TipoFallaTipoReparacionModelo"(
            "idTipoFalla", "idTipoReparacion")
    VALUES (3, 5);

INSERT INTO public."TipoFallaTipoReparacionModelo"(
            "idTipoFalla", "idTipoReparacion")
    VALUES (4, 6);

INSERT INTO public."TipoFallaTipoReparacionModelo"(
            "idTipoFalla", "idTipoReparacion")
    VALUES (4, 7);

INSERT INTO public."TipoFallaTipoReparacionModelo"(
            "idTipoFalla", "idTipoReparacion")
    VALUES (4, 8);

-- INSERT - TABLE "TipoAtributoModelo"
INSERT INTO public."TipoAtributoModelo"(
            id, "idTipoFalla", nombre, "unidadMedida")
    VALUES (1, 1, 'longitud', 'metros');

INSERT INTO public."TipoAtributoModelo"(
            id, "idTipoFalla", nombre, "unidadMedida")
    VALUES (2, 2, 'ancho', 'centímetros');

INSERT INTO public."TipoAtributoModelo"(
            id, "idTipoFalla", nombre, "unidadMedida")
    VALUES (3, 2, 'profundidad', 'centímetros');

INSERT INTO public."TipoAtributoModelo"(
            id, "idTipoFalla", nombre, "unidadMedida")
    VALUES (4, 3, 'ancho', 'milímetros');

INSERT INTO public."TipoAtributoModelo"(
            id, "idTipoFalla", nombre, "unidadMedida")
    VALUES (5, 4, 'profundidad', 'centímetros');

INSERT INTO public."TipoAtributoModelo"(
            id, "idTipoFalla", nombre, "unidadMedida")
    VALUES (6, 4, 'longitud', 'centímetros');
