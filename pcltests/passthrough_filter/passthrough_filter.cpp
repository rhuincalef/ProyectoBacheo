#include <pcl/io/pcd_io.h>
#include <pcl/filters/passthrough.h>
 
#include <pcl/visualization/cloud_viewer.h>

int
main(int argc, char** argv)
{
	// Objects for storing the point clouds.
	pcl::PointCloud<pcl::PointXYZRGB>::Ptr cloud(new pcl::PointCloud<pcl::PointXYZRGB>);
	pcl::PointCloud<pcl::PointXYZRGB>::Ptr filteredCloud(new pcl::PointCloud<pcl::PointXYZRGB>);
 
	// Read a PCD file from disk.
	if (pcl::io::loadPCDFile<pcl::PointXYZRGB>(argv[1], *cloud) != 0)
	{
		return -1;
	}
 
	// Filter object.
	pcl::PassThrough<pcl::PointXYZRGB> filter;
	filter.setInputCloud(cloud);
	// Filter out all points with Z values not in the [0-2] range.
	filter.setFilterFieldName("z");
	filter.setFilterLimits(0.0, 1.5);
 
	filter.filter(*filteredCloud);

	// Write it back to disk under a different name.
	// Another possibility would be "savePCDFileBinary()".
	pcl::io::savePCDFileBinary("filteredCloud.pcd", *filteredCloud);
}