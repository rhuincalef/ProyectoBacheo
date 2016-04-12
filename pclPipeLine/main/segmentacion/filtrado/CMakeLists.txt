cmake_minimum_required(VERSION 2.8 FATAL_ERROR)

project(filtradoNube)

find_package(PCL 1.2 REQUIRED)

include_directories(${PCL_INCLUDE_DIRS})
link_directories(${PCL_LIBRARY_DIRS})
add_definitions(${PCL_DEFINITIONS})


SET (DIR_INCLUDE_FILTRADO "/usr/lib")
#Se compila la libreria con filtrado nube
add_library(filtradoNube "FiltroNube.cpp")

#Se define la libreria como shared y se la importa para vincularla al ejecutable
add_library(libEstadisticas SHARED IMPORTED "/usr/lib/pcl_filters")

target_link_libraries (filtradoNube ${PCL_LIBRARIES} libEstadisticas )
