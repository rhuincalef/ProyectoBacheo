using namespace std;

// EJEMPLO PARA CONFIGURACION DE CMAKELISTS CON VARIOS SOURCES -->
// https://www.cs.swarthmore.edu/~adanner/tips/cmake.php

// Se incluyen los demas modulos del pipeLine
#include "../lib/Global.h"
#include "../lib/FiltroNube.h"
#include "../lib/Segmentador.h"
#include "../lib/GeneradorClusters.h"
#include "../lib/ConstructorConvexHull.h"
#include "../lib/main.h"


// Configuracion de PCL con .cpp independientes -->
// http://pointclouds.org/documentation/tutorials/using_pcl_pcl_config.php
int main (int argc,char* argv[]) {
  if (argc < 2){
   std::cout << "Error se necesita un archivo de nubes de puntos pcd" << '\n';
    return 1;
  } 
  // - Eliminar algún tipo de ruido (aplicar filtro), yo utilice statistical_outlier_fiter de PCL -->OK
  pcl::PointCloud<pcl::PointXYZ>::Ptr nubeFiltrada (new pcl::PointCloud<pcl::PointXYZ>);
  nubeFiltrada=FiltroNube::removerPuntosSobrantes(argv[1]);

  // - planar segmentation. Eliminamos la calle para aislar los tipos de falla.
  pcl::PointCloud<pcl::PointXYZ>::Ptr indicesDeNube(new pcl::PointCloud<pcl::PointXYZ>);
  indicesDeNube=Segmentador::obtenerIndices(nubeFiltrada);


  // - Clusterizar. Aislamos cada tipo de falla encontrada. Para ello utilice varios algoritmos pero el más utilizado fue euclidean_segmentation.
  GeneradorClusters::obtenerClusters(nubeFiltrada);

  // - Desde ahora se puede tratar cada falla individualmente. 
  // Con cada falla identificada obtenía sus dimensiones y utilizando triangulaciones y convexhull
  // para reconstruir el cluster facilitaba la obtención de volumen.
  pcl::ConvexHull<pcl::PointXYZ> hull=ConstructorConvexHull::configurarHull(nubeFiltrada);
  pcl::PointCloud<pcl::PointXYZ>::Ptr convexHull;
  ConstructorConvexHull::imprimirPropiedadesFalla(nubeFiltrada,hull);
  ConstructorConvexHull::graficarConvexHull(convexHull);

  return 0;
}

	


