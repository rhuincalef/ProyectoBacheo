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
#
SET (FILTRO_NUBE "segmentacion/filtrado/FiltroNube.cpp")
SET (SEGMENTADOR "segmentacion/planar_segmentation/Segmentador.cpp")
SET (GENERADOR_CLUSTERS "segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp")
SET (CONSTRUCTOR_CONVEX_HULL "reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp")



#Se agrega la libreria de filtradoNube.a compilada con la referencia a  la libreria
# (ESTO FALLABA EN EL METODO -->pcl::StatisticalOutlierRemoval<pcl::PointXYZ>::applyFilter antes!!!)
add_library(filtradoLib  STATIC IMPORTED "segmentacion/filtrado/libfiltradoNube.a")
add_library(segmentadorA  STATIC IMPORTED "segmentacion/planar_segmentation/libsegmentador.a")


##################################### Se agregan modulos especificos de PCL no agregados por defecto#####################################
#Se define la libreria como shared y se la importa para vincularla al ejecutable
#add_library(libPclApps1 SHARED IMPORTED "/usr/lib/pcl_apps")
#add_library(libPclSearch SHARED IMPORTED "/usr/lib/pcl_search")
#add_library(libPclKeypoints SHARED IMPORTED "/usr/lib/pcl_keypoints")
#add_library(libPclRecognition  SHARED IMPORTED "/usr/lib/pcl_recognition")
#add_library(libPclSurface SHARED IMPORTED "/usr/lib/pcl_surface")
#add_library(libPclTracking SHARED IMPORTED "/usr/lib/pcl_tracking")



#########################################################################################################################################

#Se genera el ejecutable con el codigo de cada uno de los modulos .cpp
#
add_executable(main main.cpp ${FILTRO_NUBE} ${SEGMENTADOR} ${GENERADOR_CLUSTERS} ${CONSTRUCTOR_CONVEX_HULL} )

target_link_libraries(main ${PCL_COMMON_LIBRARIES} ${PCL_IO_LIBRARIES} ${PCL_LIBRARIES} ${filtradoLib} ${segmentadorA} )

#Se vincula la libreria compartida propia del proyecto
#target_link_libraries(main ${segmentadorA})



#Librerias de PCL necesarias.
#target_link_libraries(main ${libPclApps1})
#target_link_libraries(main ${libPclSearch})
#target_link_libraries(main ${libPclKeypoints})
#target_link_libraries(main ${libPclRecognition})
#target_link_libraries(main ${libPclSurface})
#target_link_libraries(main ${libPclTracking})



