#ifndef GLOBAL_INCLUDES
#define GLOBAL_INCLUDES
	// Header global con todas las cabeceras necesarias para la definicion de las funciones
	#include "Global.h"
#endif

#ifndef GENERADOR_CLUSTERS
#define GENERADOR_CLUSTERS
class GeneradorClusters{ 
     public:
     	// Se deben declarar en .h los parametros por defecto para los metodos estaticos y no en .cpp,
     	// al igual que la definicion de 'static'.
		static void obtenerNubeClusterizada(pcl::EuclideanClusterExtraction<pcl::PointXYZ> clustering,
										pcl::PointCloud<pcl::PointXYZ>::Ptr cloud,
										char* pathClusters);
		static void obtenerClusters(pcl::PointCloud<pcl::PointXYZ>::Ptr cloud, char* pathClusters="../clustersPcd");
}; 
#endif