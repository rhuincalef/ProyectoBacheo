#include <pcl/io/pcd_io.h>
#include <iostream>
#include <pcl/surface/convex_hull.h>
#include <pcl/surface/concave_hull.h>
#include <pcl/filters/filter.h>
#include <pcl/visualization/cloud_viewer.h>
#include <pcl/filters/voxel_grid.h>

#include <pcl/common/distances.h>

#include <math.h>

/*
	Get the convex hull reconstruction from the input cloud.
	Show the area and volume from the convex hull reconstruction.
	Show the height, width and depth.

	Uso: ./convex_hull_reconstruction archivo.pcd
*/
int 
main (int argc, char** argv)
{
	pcl::PointCloud<pcl::PointXYZ>::Ptr cloud (new pcl::PointCloud<pcl::PointXYZ>);
	pcl::PointCloud<pcl::PointXYZ>::Ptr convexHull (new pcl::PointCloud<pcl::PointXYZ>);
	pcl::PointCloud<pcl::PointXYZ>::Ptr filteredCloud (new pcl::PointCloud<pcl::PointXYZ>);

	// Read a PCD file from disk.
	if (pcl::io::loadPCDFile<pcl::PointXYZ>(argv[1], *cloud) != 0)
	{
		return -1;
	}
	// The mapping tells you to what points of the old cloud the new ones correspond,
	// but we will not use it.
	std::vector<int> mapping;
	pcl::removeNaNFromPointCloud(*cloud, *cloud, mapping);
	
	// Filter object.
	pcl::VoxelGrid<pcl::PointXYZ> filter;
	filter.setInputCloud(cloud);
	// We set the size of every voxel to be 1x1x1cm
	// (only one point per every cubic centimeter will survive).
	filter.setLeafSize(0.01f, 0.01f, 0.01f);
	filter.filter(*filteredCloud);

	pcl::ConvexHull<pcl::PointXYZ> hull;
	// pcl::ConcaveHull<pcl::PointXYZ> hull;
	hull.setInputCloud(cloud);
	// hull.setAlpha(.1);
	hull.setDimension(3);
	hull.setComputeAreaVolume(true);
	hull.reconstruct(*convexHull);
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


	// Visualize everything.
	pcl::visualization::CloudViewer viewer("ConvexHull");
	viewer.showCloud(convexHull);
	while (!viewer.wasStopped())
	{
		// Do nothing but wait.
	}
}