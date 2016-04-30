cmake_minimum_required(VERSION 2.8 FATAL_ERROR)

project(clusterizador)

find_package(PCL 1.2 REQUIRED)

include_directories(${PCL_INCLUDE_DIRS})
link_directories(${PCL_LIBRARY_DIRS})
add_definitions(${PCL_DEFINITIONS})


#Se compila la libreria con como clusterizador
add_library(clusterizador "GeneradorClusters.cpp")

#Se define la libreria como shared y se la importa para vincularla al ejecutable

add_library( libPclSegmentacion SHARED IMPORTED "/usr/lib/pcl_segmentation")
add_library( libPclApps SHARED IMPORTED "/usr/lib/pcl_apps")
add_library( libPclSACSegmentacion SHARED IMPORTED "/usr/lib/pcl_recognition")
add_library( libPclFilters SHARED IMPORTED "/usr/lib/pcl_filters")

target_link_libraries(clusterizador ${PCL_LIBRARIES} libPclSegmentacion libPclApps libPclSACSegmentacion libPclFilters)
