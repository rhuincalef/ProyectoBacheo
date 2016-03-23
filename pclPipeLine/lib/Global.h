// Includes de FiltroNube
#include <iostream>
#include <pcl/io/pcd_io.h>
#include <pcl/point_types.h>
#include <pcl/filters/statistical_outlier_removal.h>
// Includes de Segmentador
#include <pcl/ModelCoefficients.h>
#include <pcl/sample_consensus/method_types.h>
#include <pcl/sample_consensus/model_types.h>
#include <pcl/segmentation/sac_segmentation.h>
#include <pcl/filters/extract_indices.h>
#include <pcl/filters/project_inliers.h>
#include <pcl/visualization/cloud_viewer.h>
#include <pcl/io/png_io.h>
// Includes GeneradorClusters
#include <pcl/filters/voxel_grid.h>
#include <pcl/features/normal_3d.h>
#include <pcl/kdtree/kdtree.h>
#include <pcl/segmentation/extract_clusters.h>
//Includes ConstructorConvexHull
#include <pcl/surface/convex_hull.h>
#include <pcl/surface/concave_hull.h>
#include <pcl/filters/filter.h>
#include <pcl/common/distances.h>
#include <math.h>


// Includes de FiltroNube
// #include <iostream>
// #include <pcl/io/pcd_io.h>
// #include <pcl/point_types.h>
// #include <pcl/filters/statistical_outlier_removal.h>
// // Includes de Segmentador
// #include <pcl/ModelCoefficients.h>
// #include <pcl/sample_consensus/method_types.h>
// #include <pcl/sample_consensus/model_types.h>
// #include <pcl/segmentation/sac_segmentation.h>
// #include <pcl/filters/extract_indices.h>
// #include <pcl/filters/project_inliers.h>
// #include <pcl/visualization/cloud_viewer.h>
// #include <pcl/io/png_io.h>
// // Includes GeneradorClusters
// #include <pcl/filters/voxel_grid.h>
// #include <pcl/features/normal_3d.h>
// #include <pcl/kdtree/kdtree.h>
// #include <pcl/segmentation/extract_clusters.h>
// //Includes ConstructorConvexHull
// #include <pcl/surface/convex_hull.h>
// #include <pcl/surface/concave_hull.h>
// #include <pcl/filters/filter.h>
// #include <pcl/common/distances.h>
// #include <math.h>




