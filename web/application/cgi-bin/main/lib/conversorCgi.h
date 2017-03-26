#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <iostream>
#include <dirent.h>
#include <string.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <errno.h>
#include <signal.h>


#include "../../lib/shared.h"
#include "../../excepciones/lib/excepciones.h"


// TODO: Reemplazar esto por el directorio de multimedia cuando se integre todo
// a la aplicacion web.

// PATHS PARA MODIFICAR.
const char* PATH_MULTIMEDIA = "/var/www/html/repoProyectoBacheo/web/application/dataMultimedia";
const char* PATH_IMG_DEFAULT = "/var/www/html/repoProyectoBacheo/web/application/cgi-bin/default_img";
const char* PATH_SERVER_ROOT_PCD = "repoProyectoBacheo/web/application/dataMultimedia";

const char* PROTO = "http://";
const char* HOST= "localhost";


// Constantes para las imagenes por defecto.
const char* NOMBRE_IMG_DEFAULT = "img_default.png";

// Carpeta por defecto donde se agrupan los csv de datos.
char* PATH_CSV_POR_DEFECTO = "csv_temp";

// Extension por defecto de la nube de puntos
const char* EXTENSION_NUBE_PUNTOS = "pcd";

// Permisos de la mascara umask
const int PERMISOS_RWX = 000;
const int PERMISOS_DEFAULT = 022;


// Cantidad de parametros obligatorios en la query string.
int CANTIDAD_PARAM_QUERY_STRING = 1;
// Campo con el se invoca al script cgi y se envia el ID de la falla
const char* CAMPO_QUERY_STRING = "idFalla=%s";


// Resultados que retorna el script cgi
const int ERROR = 1;
const int EXITO = 0;

// Tamanio de buffers de lectura de archivos y otros
const int MAX_BUFFER = 100;

// Codigos de error para las excepciones.
const int COD_ERRORES_GENERALES = 400;
const int COD_ERROR_PCD_INEXISTENTE = 401;
const int COD_ERROR_IMAGEN_INEXISTENTE = 402;


// Prototipos de las funciones 
void copiar_archivo(FILE* fuente,FILE* destino);
bool estaCadenaLimpia(const char* data);
void imprimirErrorJson(char* msg,int codigo);
char* obtenerNombreArchivoPuntos(char* dir);
char* construirUrl(char* dir);
// const char* generar_csv_info(const char* nombreCarpetaNube);
char* generar_imagen(char* nombreCarpetaNube);
void crear_directorio(const char* url);
