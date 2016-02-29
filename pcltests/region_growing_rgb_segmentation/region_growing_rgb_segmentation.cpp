#include <pcl/io/pcd_io.h>
#include <iostream>
#include <pcl/filters/voxel_grid.h>
#include <pcl/features/normal_3d.h>
#include <pcl/kdtree/kdtree.h>
#include <pcl/ModelCoefficients.h>
#include <pcl/point_types.h>
#include <pcl/sample_consensus/method_types.h>
#include <pcl/sample_consensus/model_types.h>
#include <pcl/segmentation/sac_segmentation.h>
#include <pcl/filters/extract_indices.h>
#include <pcl/filters/project_inliers.h>
#include <pcl/visualization/cloud_viewer.h>
#include <pcl/segmentation/region_growing_rgb.h>
#include <pcl/filters/passthrough.h>

int 
main (int argc, char** argv)
{
	pcl::PointCloud<pcl::PointXYZRGB>::Ptr cloud (new pcl::PointCloud<pcl::PointXYZRGB>);

	// Read a PCD file from disk.
	if (pcl::io::loadPCDFile<pcl::PointXYZRGB>(argv[1], *cloud) != 0)
	{
		return -1;
	}
	// The mapping tells you to what points of the old cloud the new ones correspond,
	// but we will not use it.
	std::vector<int> mapping;
	pcl::removeNaNFromPointCloud(*cloud, *cloud, mapping);

	// kd-tree object for searches.
	pcl::search::KdTree<pcl::PointXYZRGB>::Ptr kdtree(new pcl::search::KdTree<pcl::PointXYZRGB>);
	// kdtree->setInputCloud(cloud);
	kdtree->setInputCloud(cloud);

	// Color-based region growing clustering object.
	pcl::RegionGrowingRGB<pcl::PointXYZRGB> clustering;
	// clustering.setInputCloud(cloud);
	clustering.setInputCloud(cloud);
	clustering.setSearchMethod(kdtree);
	// Here, the minimum cluster size affects also the postprocessing step:
	// clusters smaller than this will be merged with their neighbors.
	clustering.setMinClusterSize(600);
	clustering.setMaxClusterSize(100000);
	clustering.setNumberOfNeighbours(10);
	clustering.setSmoothnessThreshold(3.0 / 180.0 * M_PI);
	clustering.setCurvatureThreshold(1.0);
	// Set the distance threshold, to know which points will be considered neighbors.
	clustering.setDistanceThreshold(10);
	// Color threshold for comparing the RGB color of two points.
	clustering.setPointColorThreshold(6);
	// Region color threshold for the postprocessing step: clusters with colors
	// within the threshold will be merged in one.
	clustering.setRegionColorThreshold(5);
	
	std::vector <pcl::PointIndices> clusters;
	clustering.extract(clusters);
	
	// For every cluster...
	int currentClusterNum = 1;
	for (std::vector<pcl::PointIndices>::const_iterator i = clusters.begin(); i != clusters.end(); ++i)
	{
		// ...add all its points to a new cloud...
		pcl::PointCloud<pcl::PointXYZRGB>::Ptr cluster(new pcl::PointCloud<pcl::PointXYZRGB>);
		for (std::vector<int>::const_iterator point = i->indices.begin(); point != i->indices.end(); point++)
			cluster->points.push_back(cloud->points[*point]);
		cluster->width = cluster->points.size();
		cluster->height = 1;
		cluster->is_dense = true;
	
		// ...and save it to disk.
		if (cluster->points.size() <= 0)
			break;
		std::cout << "Cluster " << currentClusterNum << " has " << cluster->points.size() << " points." << std::endl;
		std::string fileName = "cluster" + boost::to_string(currentClusterNum) + ".pcd";
		pcl::io::savePCDFileASCII(fileName, *cluster);
	
		currentClusterNum++;
	}

}