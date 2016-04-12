// Link de la documentacion de PCL -->
// http://robotica.unileon.es/mediawiki/index.php/PCL/OpenNI_tutorial_3:_Cloud_processing_%28advanced%29#Segmentation

// NOTA IMPORTANTE: PARA COMPILAR EL FUENTE CON SOPORTE PARA LA LIBRERIA Utilizar el comando:
// g++ pruebaTupla.cpp -std=gnu++11

// #include <pcl/io/pcd_io.h>
// #include <iostream>
// #include <pcl/filters/voxel_grid.h>
// #include <pcl/features/normal_3d.h>
// #include <pcl/kdtree/kdtree.h>
// #include <pcl/ModelCoefficients.h>
// #include <pcl/point_types.h>
// #include <pcl/sample_consensus/method_types.h>
// #include <pcl/sample_consensus/model_types.h>
// #include <pcl/segmentation/sac_segmentation.h>
// #include <pcl/filters/extract_indices.h>
// #include <pcl/filters/project_inliers.h>
// #include <pcl/visualization/cloud_viewer.h>
// #include <pcl/segmentation/extract_clusters.h>

#include "../../../lib/GeneradorClusters.h"

// Graba un archivo .pcd por cada cluster en el disco(cada cluster se almacena como una nube a parte)
void GeneradorClusters::obtenerNubeClusterizada(pcl::EuclideanClusterExtraction<pcl::PointXYZ> clustering,
										pcl::PointCloud<pcl::PointXYZ>::Ptr cloud,
										char* pathClusters){
	std::vector<pcl::PointIndices> clusters;
	clustering.extract(clusters);
	// For every cluster...
	// ...add all its points to a new cloud...
	pcl::PointCloud<pcl::PointXYZ>::Ptr cluster(new pcl::PointCloud<pcl::PointXYZ>);
	int currentClusterNum = 1;
	for (std::vector<pcl::PointIndices>::const_iterator i = clusters.begin(); i != clusters.end(); ++i)
	{
		// ...add all its points to a new cloud...
		// pcl::PointCloud<pcl::PointXYZRGBA>::Ptr cluster(new pcl::PointCloud<pcl::PointXYZRGBA>);
		for (std::vector<int>::const_iterator point = i->indices.begin(); point != i->indices.end(); point++)
			cluster->points.push_back(cloud->points[*point]);
		cluster->width = cluster->points.size();
		cluster->height = 1;
		cluster->is_dense = true;
		// ...and save it to disk.
		if (cluster->points.size() <= 0)
			break;
		std::cout << "Cluster " << currentClusterNum << " has " << cluster->points.size() << " points." << std::endl;
		std::string fileName = boost::to_string(pathClusters) + boost::to_string("/") + "cluster" + boost::to_string(currentClusterNum) + ".pcd";
		pcl::io::savePCDFileASCII(fileName, *cluster);
		currentClusterNum++;
	}
	std::cout << "Todos los clusters han sido escritos en disco correctamente" << '\n';
}

// Configura los parametros necesarios e invoca a al metodo que obtiene los clusters a partir de la nube
void GeneradorClusters::obtenerClusters(pcl::PointCloud<pcl::PointXYZ>::Ptr cloud, char* pathClusters){
// The mapping tells you to what points of the old cloud the new ones correspond,
	// but we will not use it.
	// std::vector<int> mapping;
	// pcl::removeNaNFromPointCloud(*cloud, *cloud, mapping);

	// kd-tree object for searches.
	pcl::search::KdTree<pcl::PointXYZ>::Ptr kdtree(new pcl::search::KdTree<pcl::PointXYZ>);
	kdtree->setInputCloud(cloud);
	
	// Euclidean clustering object.
	pcl::EuclideanClusterExtraction<pcl::PointXYZ> clustering;
	// Set cluster tolerance to 2cm (small values may cause objects to be divided
	// in several clusters, whereas big values may join objects in a same cluster).
	clustering.setClusterTolerance(0.02);
	// Set the minimum and maximum number of points that a cluster can have.
	clustering.setMinClusterSize(100);
	// clustering.setMinClusterSize(cloud->points.size() / 1000);
	clustering.setMaxClusterSize(25000);
	// clustering.setMaxClusterSize(cloud->points.size());
	clustering.setSearchMethod(kdtree);
	// clustering.setInputCloud(cloud);
	clustering.setInputCloud(cloud);
	
	obtenerNubeClusterizada(clustering,cloud,pathClusters);
}


// int 
// main (int argc, char** argv)
// {
// 	pcl::PointCloud<pcl::PointXYZ>::Ptr cloud (new pcl::PointCloud<pcl::PointXYZ>);

// 	// Read a PCD file from disk.
// 	if (pcl::io::loadPCDFile<pcl::PointXYZ>(argv[1], *cloud) != 0)
// 	{
// 		return -1;
// 	}
// 	pcl::PointCloud<pcl::PointXYZ>::Ptr cluster;
	
// 	GeneradorClusters::obtenerClusters(cloud);
	// return 0;
// }