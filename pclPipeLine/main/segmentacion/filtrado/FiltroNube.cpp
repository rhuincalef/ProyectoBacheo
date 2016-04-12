//Link al removedor de puntos sobrantes en pcl -->
// http://pointclouds.org/documentation/tutorials/statistical_outlier.php
using namespace std;
// #include <iostream>
// #include <pcl/io/pcd_io.h>
// #include <pcl/point_types.h>
// #include <pcl/filters/statistical_outlier_removal.h>

#include "../../../lib/FiltroNube.h"


// Este metodo retorna una nube de puntos con los puntos sobrantes removidos
pcl::PointCloud<pcl::PointXYZ>::Ptr FiltroNube::removerPuntosSobrantes(char* rutaArchivoNubePtos,int meanK,double desviacionStd){
  	pcl::PointCloud<pcl::PointXYZ>::Ptr cloud (new pcl::PointCloud<pcl::PointXYZ>);
	pcl::PointCloud<pcl::PointXYZ>::Ptr cloud_filtered (new pcl::PointCloud<pcl::PointXYZ>);
	// Fill in the cloud data
	pcl::PCDReader reader;
	// Replace the path below with the path where you saved your file
	reader.read<pcl::PointXYZ> (rutaArchivoNubePtos, *cloud);

	// Create the filtering object
	pcl::StatisticalOutlierRemoval<pcl::PointXYZ> sor;
	sor.setInputCloud (cloud);
	sor.setMeanK (meanK);
	sor.setStddevMulThresh (desviacionStd);
	sor.filter (*cloud_filtered);
	return cloud_filtered;
}

// Programa de prueba para el filtrado de archivos .pcd
 int
 main (int argc, char** argv)
  {
//   printf("Probando filtrado de nube de puntos con entrada %s\n",argv[1]);
//   pcl::PointCloud<pcl::PointXYZ>::Ptr nubeResultado=FiltroNube::removerPuntosSobrantes(argv[1]);
//   printf("Despues de remover los puntos sobrantes de la nube\n");
//   pcl::PCDWriter writer;
//   writer.write<pcl::PointXYZ> ("table_scene_lms400_inliers.pcd", *nubeResultado, false);
	return (0);
 }

