#ifndef GLOBAL_INCLUDES
#define GLOBAL_INCLUDES
	// Header global con todas las cabeceras necesarias para la definicion de las funciones
	#include "Global.h"
#endif

#ifndef FILTO_NUBE
#define FILTO_NUBE
class FiltroNube{ 
     public:
     	// Se deben declarar en .h los parametros por defecto para los metodos estaticos y no en .cpp,
     	// al igual que la definicion de 'static'.
		static pcl::PointCloud<pcl::PointXYZ>::Ptr removerPuntosSobrantes(char* rutaArchivoNubePtos,
			int meanK=50,double desviacionStd=1.0);
}; 
#endif