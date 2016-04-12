// #include <pcl/io/pcd_io.h>
// #include <iostream>
// #include <pcl/surface/convex_hull.h>
// #include <pcl/surface/concave_hull.h>
// #include <pcl/filters/filter.h>
// #include <pcl/visualization/cloud_viewer.h>
// #include <pcl/filters/voxel_grid.h>

// #include <pcl/common/distances.h>

// #include <math.h>

// Se incluye el .h de la defincion de la clase
#include "../../../lib/ConstructorConvexHull.h"

// Link al procesamiento del Convex Hull -->
// http://robotica.unileon.es/mediawiki/index.php/PCL/OpenNI_tutorial_3:_Cloud_processing_%28advanced%29#Retrieving_the_hull

// Definicion de las funciones miembro 

// Retorna un hull configurado a partir de una nube de puntos de entrada
pcl::ConvexHull<pcl::PointXYZ> ConstructorConvexHull::configurarHull(pcl::PointCloud<pcl::PointXYZ>::Ptr cloud,
									float tamanioHoja1,float tamanioHoja2,float tamanioHoja3,
									int dimension, bool computarVolumenArea){
	
	
	pcl::PointCloud<pcl::PointXYZ>::Ptr filteredCloud (new pcl::PointCloud<pcl::PointXYZ>);

	// The mapping tells you to what points of the old cloud the new ones correspond,
	// but we will not use it.
	std::vector<int> mapping;
	pcl::removeNaNFromPointCloud(*cloud, *cloud, mapping);
	
	// Filter object.
	pcl::VoxelGrid<pcl::PointXYZ> filter;
	filter.setInputCloud(cloud);
	// We set the size of every voxel to be 1x1x1cm
	// (only one point per every cubic centimeter will survive).
	filter.setLeafSize(tamanioHoja1,tamanioHoja2,tamanioHoja3);
	filter.filter(*filteredCloud);

	pcl::ConvexHull<pcl::PointXYZ> hull;
	// pcl::ConcaveHull<pcl::PointXYZ> hull;
	hull.setInputCloud(cloud);
	// hull.setAlpha(.1);
	hull.setDimension(dimension);
	hull.setComputeAreaVolume(computarVolumenArea);
	
	return hull;
}

// A partir de un hull obtiene una nube de puntos(cluster obtenido desde euclidean_segmentation.cpp) uniendo los puntos mas exteriores.
 pcl::PointCloud<pcl::PointXYZ>::Ptr ConstructorConvexHull::obtenerConvexHull(pcl::ConvexHull<pcl::PointXYZ> hull){
	pcl::PointCloud<pcl::PointXYZ>::Ptr convexHull (new pcl::PointCloud<pcl::PointXYZ>);
	hull.reconstruct(*convexHull);
	return convexHull;
}



// Muestra el area, volumen, valores maximos y minimos de los ejes x,y,z en la salida estandar.
 void ConstructorConvexHull::imprimirPropiedadesFalla(pcl::PointCloud<pcl::PointXYZ>::Ptr cloud,pcl::ConvexHull<pcl::PointXYZ> hull){
	std::cout << "Area " << hull.getTotalArea() << " Volume " << hull.getTotalVolume() << std::endl;
	int min_indice_x, max_indice_x, min_indice_y, max_indice_y, min_indice_z, max_indice_z;
	pcl::PointXYZ max, min;
	pcl::getMinMax3D(*cloud, min, max);
	std::cout << "Min_x " << min.x << " y Max_x " << max.x << std::endl;
	std::cout << "Min_y " << min.y << " y Max_y " << max.y << std::endl;
	std::cout << "Min_z " << min.z << " y Max_z " << max.z << std::endl;

	for (int i = 0; i < cloud->points.size(); ++i)
	{
		if (cloud->points[i].x == min.x)
		{
				min_indice_x = i;
		}
		if (cloud->points[i].x  == max.x)
		{
				max_indice_x = i;
		}
		if (cloud->points[i].y == min.y)
		{
				min_indice_y = i;
		}
		if (cloud->points[i].y == max.y)
		{
				max_indice_y = i;
		}
		if (cloud->points[i].z == min.z)
		{
				min_indice_z = i;
		}
		if (cloud->points[i].z == max.z)
		{
				max_indice_z = i;
		}
	}
	std::cout << "Puntos" << std::endl;
	std::cout << "x1: " << cloud->points[min_indice_x] << " x2: " << cloud->points[max_indice_x] << std::endl;
	std::cout << "y1: " << cloud->points[min_indice_y] << " y2: " << cloud->points[max_indice_y] << std::endl;
	std::cout << "z1: " << cloud->points[min_indice_z] << " z2: " << cloud->points[max_indice_z] << std::endl;

	float width;
	// pcl::euclideanDistance (cloud->points[min_indice_x], cloud->points[max_indice_x]);
	// pcl::squaredEuclideanDistance (cloud->points[min_indice_x], cloud->points[max_indice_x]);
	width =  fabs(fabs(max.x) - fabs(min.x));
	std::cout << "Ancho: " << width << std::endl;
	float height;
	height = fabs(fabs(max.y) - fabs(min.y));
	std::cout << "Altura: " << height << std::endl;
	float depth;
	depth = fabs(fabs(max.z) - fabs(min.z));
	std::cout << "Profundidad: " << depth << std::endl;
	// Eigen::Vector4f max4f, min4f;
	// pcl::getMinMax3D(*cloud, min4f, max4f);

}

// Muestra en una ventana el grafico de la nube con convex hull.
 void ConstructorConvexHull::graficarConvexHull(pcl::PointCloud<pcl::PointXYZ>::Ptr convexHull){
	// Visualize everything.
	pcl::visualization::CloudViewer viewer("ConvexHull");
	viewer.showCloud(convexHull);
	while (!viewer.wasStopped())
	{
		// Do nothing but wait.
	}
}

// int 
// main (int argc, char** argv){
// 	pcl::PointCloud<pcl::PointXYZ>::Ptr cloud (new pcl::PointCloud<pcl::PointXYZ>);
// 	// Read a PCD file from disk.
// 	if (pcl::io::loadPCDFile<pcl::PointXYZ>(argv[1], *cloud) != 0)
// 	{
// 		return -1;
// 	}
// 	pcl::ConvexHull<pcl::PointXYZ> hull=ConstructorConvexHull::configurarHull(cloud);
// 	pcl::PointCloud<pcl::PointXYZ>::Ptr convexHull;
// 	ConstructorConvexHull::imprimirPropiedadesFalla(cloud,hull);
// 	ConstructorConvexHull::graficarConvexHull(convexHull);
	// return 0;
// }