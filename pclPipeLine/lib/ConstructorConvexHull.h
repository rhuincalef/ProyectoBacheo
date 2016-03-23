#ifndef GLOBAL_INCLUDES
#define GLOBAL_INCLUDES
	// Header global con todas las cabeceras necesarias para la definicion de las funciones
	#include "Global.h"
#endif

#ifndef CONVEX_HULL
#define CONVEX_HULL
class ConstructorConvexHull{ 
     public:
          static pcl::ConvexHull<pcl::PointXYZ> configurarHull(pcl::PointCloud<pcl::PointXYZ>::Ptr cloud,
                                                  float tamanioHoja1=0.01f,float tamanioHoja2=0.01f,float tamanioHoja3=0.01f,
                                                  int dimension=3, bool computarVolumenArea=true);
          static pcl::PointCloud<pcl::PointXYZ>::Ptr obtenerConvexHull(pcl::ConvexHull<pcl::PointXYZ> hull);
          static void imprimirPropiedadesFalla(pcl::PointCloud<pcl::PointXYZ>::Ptr cloud,pcl::ConvexHull<pcl::PointXYZ> hull); 
          static void graficarConvexHull(pcl::PointCloud<pcl::PointXYZ>::Ptr convexHull);

}; 
#endif