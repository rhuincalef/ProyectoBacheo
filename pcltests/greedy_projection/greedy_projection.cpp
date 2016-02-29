#include <pcl/point_types.h>
#include <pcl/io/pcd_io.h>
#include <pcl/kdtree/kdtree_flann.h>
#include <pcl/features/normal_3d.h>
#include <pcl/surface/gp3.h>
#include <pcl/io/vtk_io.h>

#include <pcl/ros/conversions.h>
#include <pcl/common/common.h>
#include <pcl/surface/grid_projection.h>

#include <math.h>

float calculateVolumeTrianglenMesh(pcl::Vertices &v, pcl::PointCloud<pcl::PointXYZ>::Ptr cloud)
{
  // (1/6)(a x b . c) or a cross b dotted with c
  float volume;
  float v012 = cloud->points[v.vertices[0]].x * cloud->points[v.vertices[1]].y * cloud->points[v.vertices[2]].z;
  float v120 = cloud->points[v.vertices[1]].x * cloud->points[v.vertices[2]].y * cloud->points[v.vertices[0]].z;
  float v201 = cloud->points[v.vertices[2]].x * cloud->points[v.vertices[0]].y * cloud->points[v.vertices[1]].z;
  float v021 = cloud->points[v.vertices[0]].x * cloud->points[v.vertices[2]].y * cloud->points[v.vertices[1]].z;
  float v102 = cloud->points[v.vertices[1]].x * cloud->points[v.vertices[0]].y * cloud->points[v.vertices[2]].z;
  float v210 = cloud->points[v.vertices[2]].x * cloud->points[v.vertices[1]].y * cloud->points[v.vertices[0]].z;
  // [x1y2z3 + x2y3+z1 + x3y1z2 - x1y3z2 - x2y1z3 - x3y2z1]
  volume = (1.0f/6.0f) * (v012 + v120 + v201 - v021 - v102 - v210);
  return fabs(volume);
}

float calculateAreaTrianglenMesh(pcl::Vertices &v, pcl::PointCloud<pcl::PointXYZ>::Ptr cloud)
{
  float area;
  // N[0]->N[1] and N[0]->N[2] 
  float x1 = cloud->points[v.vertices[1]].x - cloud->points[v.vertices[0]].x;
  float y1 = cloud->points[v.vertices[1]].y - cloud->points[v.vertices[0]].y;
  float z1 = cloud->points[v.vertices[1]].z - cloud->points[v.vertices[0]].z;
  float x2 = cloud->points[v.vertices[2]].x - cloud->points[v.vertices[0]].x;
  float y2 = cloud->points[v.vertices[2]].y - cloud->points[v.vertices[0]].y;
  float z2 = cloud->points[v.vertices[2]].z - cloud->points[v.vertices[0]].z;
  // e3 = e1 x e2 (cross product)
  float x3 = y1 *z2 - z1*y2;
  float y3 = z1 *x2 - x1*z2;
  float z3 = x1 *y2 - y1*x2;
  area = (1.0f/2.0f) * sqrt(x3*x3 + y3*y3 + z3*z3);
  return area;
}

int
main (int argc, char** argv)
{
  // Load input file into a PointCloud<T> with an appropriate type
  pcl::PointCloud<pcl::PointXYZ>::Ptr cloud (new pcl::PointCloud<pcl::PointXYZ>);
  pcl::PCLPointCloud2 cloud_blob;
  pcl::io::loadPCDFile (argv[1], cloud_blob);
  pcl::fromPCLPointCloud2 (cloud_blob, *cloud);
  //* the data should be available in cloud

  // Normal estimation*
  pcl::NormalEstimation<pcl::PointXYZ, pcl::Normal> n;
  pcl::PointCloud<pcl::Normal>::Ptr normals (new pcl::PointCloud<pcl::Normal>);
  pcl::search::KdTree<pcl::PointXYZ>::Ptr tree (new pcl::search::KdTree<pcl::PointXYZ>);
  tree->setInputCloud (cloud);
  n.setInputCloud (cloud);
  n.setSearchMethod (tree);
  n.setKSearch (20);
  n.compute (*normals);
  //* normals should not contain the point normals + surface curvatures

  // Concatenate the XYZ and normal fields*
  pcl::PointCloud<pcl::PointNormal>::Ptr cloud_with_normals (new pcl::PointCloud<pcl::PointNormal>);
  pcl::concatenateFields (*cloud, *normals, *cloud_with_normals);
  //* cloud_with_normals = cloud + normals

  // Create search tree*
  pcl::search::KdTree<pcl::PointNormal>::Ptr tree2 (new pcl::search::KdTree<pcl::PointNormal>);
  tree2->setInputCloud (cloud_with_normals);

  // Initialize objects
  pcl::GreedyProjectionTriangulation<pcl::PointNormal> gp3;
  pcl::PolygonMesh triangles;

  // Set the maximum distance between connected points (maximum edge length)
  gp3.setSearchRadius (0.025);

  // Set typical values for the parameters
  gp3.setMu (2.5);
  gp3.setMaximumNearestNeighbors (100);
  gp3.setMaximumSurfaceAngle(M_PI/4); // 45 degrees
  gp3.setMinimumAngle(M_PI/18); // 10 degrees
  gp3.setMaximumAngle(2*M_PI/3); // 120 degrees
  gp3.setNormalConsistency(false);

  // Get result
  gp3.setInputCloud (cloud_with_normals);
  gp3.setSearchMethod (tree2);
  gp3.reconstruct (triangles);

  // Initialize objects
        pcl::GridProjection<pcl::PointNormal> gbpolygon;
        pcl::PolygonMesh triangles1;
        // Create search tree*
        pcl::search::KdTree<pcl::PointNormal>::Ptr tree3 (new pcl::search::KdTree<pcl::PointNormal>);
        tree3->setInputCloud (cloud_with_normals); 

        // Set parameters
        gbpolygon.setResolution(0.005);
        gbpolygon.setPaddingSize(3);
        gbpolygon.setNearestNeighborNum(100);
        gbpolygon.setMaxBinarySearchLevel(10);
       
        // Get result
        gbpolygon.setInputCloud(cloud_with_normals);
        gbpolygon.setSearchMethod(tree3);
        gbpolygon.reconstruct(triangles1);
        pcl::io::saveVTKFile("mesh_manifold.vtk", triangles1);

  // Additional vertex information
  std::vector<int> parts = gp3.getPartIDs();
  std::vector<int> states = gp3.getPointStates();

  pcl::io::saveVTKFile("mesh.vtk", triangles);

  pcl::PointCloud<pcl::PointXYZ>::Ptr triangle_cloud (new pcl::PointCloud<pcl::PointXYZ>);
  pcl::fromPCLPointCloud2(triangles1.cloud, *triangle_cloud);
  float volume = 0;
  for (size_t i = 0; i < triangles1.polygons.size(); ++i)
  {
    volume += calculateVolumeTrianglenMesh(triangles1.polygons[i], triangle_cloud);
  }

  std::cout << "Volume " <<  volume << std::endl;

  float area = .0f;
  float prom_area = .0f;
  for (size_t i = 0; i < triangles1.polygons.size(); ++i)
  {
    area += calculateAreaTrianglenMesh(triangles1.polygons[i], triangle_cloud);
  }
  prom_area = area / triangles1.polygons.size();
  
  std::cout << "Area " <<  area << std::endl;
  std::cout << "prom_area " <<  prom_area << std::endl;

  // Finish
  return (0);
}
