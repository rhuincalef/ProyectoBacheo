# Ejemplo de configuracion Cmakelists
# https://www.cs.swarthmore.edu/~adanner/tips/cmake.php
# Variables CMake -->
# https://cmake.org/Wiki/CMake_Useful_Variables


cmake_minimum_required(VERSION 2.6 FATAL_ERROR)
project(Procesador_pcds)
find_package(PCL 1.3 REQUIRED COMPONENTS common io)
include_directories(${PCL_INCLUDE_DIRS})
link_directories(${PCL_LIBRARY_DIRS})
add_definitions(${PCL_DEFINITIONS})

# Se incluye el directorio para las los archivos con includes.
include_directories("../lib")
include_directories("/usr/include/pcl-1.7")

#Se agregan los subdirectorios para el resto de los archivos.
add_subdirectory("segmentacion/filtrado")
add_subdirectory("segmentacion/planar_segmentation")
add_subdirectory("segmentacion/clusterizado(euclidean_segmentation)")
add_subdirectory("reconstruccionConvexHull/convex_hull_reconstruction")

#message("VALOR DE CPATH: $ENV{CPATH}")


#Se define una variable para todas las librerias y se la agrega para linkeo.
#NOTA: Los archivos de cabecera en C++ se definen en variables que luego se agregan en el paso de linkeo
#directamente.
file(GLOB global "../lib/*.h")

#Se incluyen las librerias de pcl instaladas en el sistema -->
#/usr/include/pcl-1.7
#Se agrega el directorio para buscar la libreria de pcl
# La var. a modificar es CMAKE_CXX_FLAGS (opciones gcc -I)
SET (CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} -I/usr/include/pcl-1.7")
SET (CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} -I/usr/include/eigen3")
SET (CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} -I/usr/include/vtk-5.8 ")

#Se define una variable con el dir. de instalacion de la libreria de pcl
SET (FILTRO_NUBE "segmentacion/filtrado/FiltroNube.cpp")
SET (SEGMENTADOR "segmentacion/planar_segmentation/Segmentador.cpp")
SET (GENERADOR_CLUSTERS "segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp")
SET (CONSTRUCTOR_CONVEX_HULL "reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp")

add_library(filtradoLib  STATIC IMPORTED libfiltradoNube.a)
add_library(segmentadorA  STATIC IMPORTED libsegmentador.a)
add_library(cluster  STATIC IMPORTED libclusterizador.a)
add_library(convexHullConstructor  STATIC IMPORTED libconvexHull.a)


#TRABAJANDO CON LIBRERIAS EXTERNAS A CMAKE:
#1-Para trabajar con Cmake se creo el dir cmake/Modules/ y se copio el sig. archivo:
#/usr/share/pcl-1.7/PCLConfig.cmake
# Como "FindPCL.cmake" en ese directorio.
#2-Luego se agregaron las siguientes lineas -->
set(CMAKE_MODULE_PATH ${CMAKE_MODULE_PATH} "${CMAKE_SOURCE_DIR}/cmake/Modules/")
find_package(PCL REQUIRED)
include_directories(${PCL_INCLUDE_DIRS})
set(LIBS_PCL ${LibPCL_LIBRARIES})

#Se genera el ejecutable con el codigo de cada uno de los modulos .cpp
add_executable(main main.cpp ${FILTRO_NUBE} ${SEGMENTADOR} ${GENERADOR_CLUSTERS} ${CONSTRUCTOR_CONVEX_HULL} )


# target_link_libraries(my_fabulous_target PCL_XXX_LIBRARIES)
target_link_libraries(main ${PCL_COMMON_LIBRARIES} ${PCL_IO_LIBRARIES} ${PCL_LIBRARIES} ${LIBS_PCL} ${filtradoLib} ${segmentadorA} ${cluster} ${convexHullConstructor})

