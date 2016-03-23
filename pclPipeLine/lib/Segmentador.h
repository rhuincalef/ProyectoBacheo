#ifndef GLOBAL_INCLUDES
#define GLOBAL_INCLUDES
	// Header global con todas las cabeceras necesarias para la definicion de las funciones
	#include "Global.h"
#endif

#ifndef SEGMENTADOR_NUBE
#define SEGMENTADOR_NUBE
class Segmentador{ 
     public:
     	// Se deben declarar en .h los parametros por defecto para los metodos estaticos y no en .cpp,
     	// al igual que la definicion de 'static'.
		static pcl::PointCloud<pcl::PointXYZ>::Ptr obtenerIndices(pcl::PointCloud<pcl::PointXYZ>::Ptr cloud,
		bool optimizarCoeficientes=true, pcl::SacModel tipoModelo=pcl::SACMODEL_PLANE, int cantIteracionesMax=1000,
		double epsAngle=0.1, int tipoMetodo=pcl::SAC_RANSAC,double limiteDistancia=0.02);
}; 
#endif