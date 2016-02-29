#include <pcl/io/pcd_io.h>
#include <iostream>
#include <pcl/ModelCoefficients.h>
#include <pcl/point_types.h>
#include <pcl/sample_consensus/method_types.h>
#include <pcl/sample_consensus/model_types.h>
#include <pcl/segmentation/sac_segmentation.h>
#include <pcl/filters/extract_indices.h>
#include <pcl/filters/project_inliers.h>
#include <pcl/visualization/cloud_viewer.h>
#include <pcl/io/png_io.h>

/*
	Get the plane model, if present remove.
	Return a .pcd file 

	USO: ./planar_segmentation archivo.pcd
*/

int 
main (int argc, char** argv)
{
	pcl::PointCloud<pcl::PointXYZRGB>::Ptr cloud (new pcl::PointCloud<pcl::PointXYZRGB>);
	pcl::PointCloud<pcl::PointXYZRGB>::Ptr planePoints (new pcl::PointCloud<pcl::PointXYZRGB>);
	pcl::PointCloud<pcl::PointXYZRGB>::Ptr cloudNoPlane (new pcl::PointCloud<pcl::PointXYZRGB>);

	// Read a PCD file from disk.
	if (pcl::io::loadPCDFile<pcl::PointXYZRGB>(argv[1], *cloud) != 0)
	{
		return -1;
	}
	
	pcl::ModelCoefficients::Ptr coefficients(new pcl::ModelCoefficients);
	// Plane model segmantation
	pcl::SACSegmentation<pcl::PointXYZRGB> segmentation;
	segmentation.setOptimizeCoefficients(true);
	// segmentation.setInputCloud(cloud);
	segmentation.setModelType(pcl::SACMODEL_PLANE);
	// segmentation.setModelType(pcl::SACMODEL_PERPENDICULAR_PLANE);
	// best plane should be perpendicular to z-axis 
	// segmentation.setAxis(Eigen::Vector3f(0, 0, 1));
	segmentation.setMaxIterations(1000);
	segmentation.setEpsAngle(.1);
	segmentation.setMethodType(pcl::SAC_RANSAC);
	segmentation.setDistanceThreshold(0.02);

	pcl::PointIndices::Ptr inliers(new pcl::PointIndices);

	int i=0, nr_points = (int) cloud->points.size ();
	while (cloud->points.size () > 0.3 * nr_points)
	{
	  // Segment the largest planar component from the remaining cloud
	  segmentation.setInputCloud (cloud);
	  segmentation.segment (*inliers, *coefficients);
	  if (inliers->indices.size () == 0)
	  {
	    std::cout << "Could not estimate a planar model for the given dataset." << std::endl;
	    break;
	  }

	  // Extract the planar inliers from the input cloud
	  pcl::ExtractIndices<pcl::PointXYZRGB> extract;
	  extract.setInputCloud (cloud);
	  extract.setIndices (inliers);
	  extract.setNegative (false);

	  // Get the points associated with the planar surface
	  extract.filter (*planePoints);
	  std::cout << "PointCloud representing the planar component: " << planePoints->points.size () << " data points." << std::endl;

	  // Remove the planar inliers, extract the rest
	  extract.setNegative (true);
	  extract.filter (*cloudNoPlane);
	  *cloud = *cloudNoPlane;
	}

	// Write it back to disk under a different name.
	// Another possibility would be "savePCDFileBinary()".
	if (cloudNoPlane->points.size() > 0)
	{
		pcl::io::savePCDFileBinary("cloudNoPlane.pcd", *cloudNoPlane);
	}
	// pcl::io::savePCDFileBinary("planePoints.pcd", *planePoints);


}