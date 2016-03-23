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
SET (DIR_PCL_LIBS /usr/lib)

# Se agregan los modulos como librerias
add_library(filtroNube "segmentacion/filtrado/FiltroNube.cpp" )
add_library(segmentador "segmentacion/planar_segmentation/Segmentador.cpp")
add_library(generadorClusters "segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp")
add_library(constructorConvexHull "reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp")

SET( LIBRERIAS_A_LINKEAR filtroNube segmentador generadorClusters constructorConvexHull)


#Se definen las librerias para filtroNube
#SE LINKEAN DEPENDENCIAS de filtroNube.cpp

#target_link_libraries(filtroNube 
#	"${DIR_PCL_LIBS}/libpcl_common.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_io.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_filters.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_segmentation.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_recognition.so.1.7"
#)

#Se definen las librerias para segmentador
#SE LINKEAN DEPENDENCIAS de segmentador.cpp
#target_link_libraries(segmentador 
#	"${DIR_PCL_LIBS}/libpcl_common.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_io.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_filters.so.1.7"
##	"${DIR_PCL_LIBS}/libpcl_search.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_segmentation.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_recognition.so.1.7"
#)


#Se definen las librerias para generadorClusters
#SE LINKEAN DEPENDENCIAS de generadorClusters.cpp
#target_link_libraries(generadorClusters 
#	"${DIR_PCL_LIBS}/libpcl_common.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_search.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_io.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_segmentation.so.1.7"
#	"${DIR_PCL_LIBS}/libpcl_recognition.so.1.7"
#)


#Se definen las librerias para convexHull
#SE LINKEAN DEPENDENCIAS de CONSTRUCTORCONVEXHULL.cpp
#
file(GLOB libreriasCCH "${DIR_PCL_LIBS}/libpcl_visualization.so.1.7" "${DIR_PCL_LIBS}/libpcl_search.so.1.7" "${DIR_PCL_LIBS}/libpcl_surface.so.1.7" "${DIR_PCL_LIBS}/libpcl_segmentation.so.1.7" "${DIR_PCL_LIBS}/libpcl_recognition.so.1.7" "${DIR_PCL_LIBS}/libpcl_filters.so.1.7" )

target_link_libraries(constructorConvexHull ${libreriasCCH})

#Se agrega el ejecutable
add_executable(main main.cpp)

target_link_libraries(main ${PCL_COMMON_LIBRARIES} ${PCL_IO_LIBRARIES} ${PCL_LIBRARIES} ${global} ${LIBRERIAS_A_LINKEAR})



#foreach(lib ${LIBRERIAS_A_LINKEAR})
	#Se deben agregar las referencias que tienen las librerias anteriores a PCL con target_link_libraries()
#	target_link_libraries(${lib} ${PCL_LIBRARIES})
#endforeach()

