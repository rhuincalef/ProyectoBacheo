# CMAKE generated file: DO NOT EDIT!
# Generated by "Unix Makefiles" Generator, CMake Version 2.8

#=============================================================================
# Special targets provided by cmake.

# Disable implicit rules so canonical targets will work.
.SUFFIXES:

# Remove some rules from gmake that .SUFFIXES does not remove.
SUFFIXES =

.SUFFIXES: .hpux_make_needs_suffix_list

# Suppress display of executed commands.
$(VERBOSE).SILENT:

# A target that is always out of date.
cmake_force:
.PHONY : cmake_force

#=============================================================================
# Set environment variables for the build.

# The shell in which to execute make rules.
SHELL = /bin/sh

# The CMake executable.
CMAKE_COMMAND = /usr/bin/cmake

# The command to remove a file.
RM = /usr/bin/cmake -E remove -f

# Escaping for special characters.
EQUALS = =

# The program to use to edit the cache.
CMAKE_EDIT_COMMAND = /usr/bin/ccmake

# The top-level source directory on which CMake was run.
CMAKE_SOURCE_DIR = /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main

# The top-level build directory on which CMake was run.
CMAKE_BINARY_DIR = /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main

# Include any dependencies generated for this target.
include CMakeFiles/main.dir/depend.make

# Include the progress variables for this target.
include CMakeFiles/main.dir/progress.make

# Include the compile flags for this target's objects.
include CMakeFiles/main.dir/flags.make

CMakeFiles/main.dir/main.cpp.o: CMakeFiles/main.dir/flags.make
CMakeFiles/main.dir/main.cpp.o: main.cpp
	$(CMAKE_COMMAND) -E cmake_progress_report /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/CMakeFiles $(CMAKE_PROGRESS_1)
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Building CXX object CMakeFiles/main.dir/main.cpp.o"
	/usr/bin/c++   $(CXX_DEFINES) $(CXX_FLAGS) -o CMakeFiles/main.dir/main.cpp.o -c /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/main.cpp

CMakeFiles/main.dir/main.cpp.i: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Preprocessing CXX source to CMakeFiles/main.dir/main.cpp.i"
	/usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -E /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/main.cpp > CMakeFiles/main.dir/main.cpp.i

CMakeFiles/main.dir/main.cpp.s: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Compiling CXX source to assembly CMakeFiles/main.dir/main.cpp.s"
	/usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -S /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/main.cpp -o CMakeFiles/main.dir/main.cpp.s

CMakeFiles/main.dir/main.cpp.o.requires:
.PHONY : CMakeFiles/main.dir/main.cpp.o.requires

CMakeFiles/main.dir/main.cpp.o.provides: CMakeFiles/main.dir/main.cpp.o.requires
	$(MAKE) -f CMakeFiles/main.dir/build.make CMakeFiles/main.dir/main.cpp.o.provides.build
.PHONY : CMakeFiles/main.dir/main.cpp.o.provides

CMakeFiles/main.dir/main.cpp.o.provides.build: CMakeFiles/main.dir/main.cpp.o

CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o: CMakeFiles/main.dir/flags.make
CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o: segmentacion/filtrado/FiltroNube.cpp
	$(CMAKE_COMMAND) -E cmake_progress_report /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/CMakeFiles $(CMAKE_PROGRESS_2)
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Building CXX object CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o"
	/usr/bin/c++   $(CXX_DEFINES) $(CXX_FLAGS) -o CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o -c /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/segmentacion/filtrado/FiltroNube.cpp

CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.i: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Preprocessing CXX source to CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.i"
	/usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -E /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/segmentacion/filtrado/FiltroNube.cpp > CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.i

CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.s: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Compiling CXX source to assembly CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.s"
	/usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -S /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/segmentacion/filtrado/FiltroNube.cpp -o CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.s

CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o.requires:
.PHONY : CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o.requires

CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o.provides: CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o.requires
	$(MAKE) -f CMakeFiles/main.dir/build.make CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o.provides.build
.PHONY : CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o.provides

CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o.provides.build: CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o

CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o: CMakeFiles/main.dir/flags.make
CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o: segmentacion/planar_segmentation/Segmentador.cpp
	$(CMAKE_COMMAND) -E cmake_progress_report /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/CMakeFiles $(CMAKE_PROGRESS_3)
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Building CXX object CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o"
	/usr/bin/c++   $(CXX_DEFINES) $(CXX_FLAGS) -o CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o -c /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/segmentacion/planar_segmentation/Segmentador.cpp

CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.i: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Preprocessing CXX source to CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.i"
	/usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -E /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/segmentacion/planar_segmentation/Segmentador.cpp > CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.i

CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.s: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Compiling CXX source to assembly CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.s"
	/usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -S /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/segmentacion/planar_segmentation/Segmentador.cpp -o CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.s

CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o.requires:
.PHONY : CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o.requires

CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o.provides: CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o.requires
	$(MAKE) -f CMakeFiles/main.dir/build.make CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o.provides.build
.PHONY : CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o.provides

CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o.provides.build: CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o

CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o: CMakeFiles/main.dir/flags.make
CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o: segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp
	$(CMAKE_COMMAND) -E cmake_progress_report /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/CMakeFiles $(CMAKE_PROGRESS_4)
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Building CXX object CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o"
	/usr/bin/c++   $(CXX_DEFINES) $(CXX_FLAGS) -o "CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o" -c "/home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp"

CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.i: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Preprocessing CXX source to CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.i"
	/usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -E "/home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp" > "CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.i"

CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.s: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Compiling CXX source to assembly CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.s"
	/usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -S "/home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp" -o "CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.s"

CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o.requires:
.PHONY : CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o.requires

CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o.provides: CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o.requires
	$(MAKE) -f CMakeFiles/main.dir/build.make "CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o.provides.build"
.PHONY : CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o.provides

CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o.provides.build: CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o

CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o: CMakeFiles/main.dir/flags.make
CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o: reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp
	$(CMAKE_COMMAND) -E cmake_progress_report /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/CMakeFiles $(CMAKE_PROGRESS_5)
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Building CXX object CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o"
	/usr/bin/c++   $(CXX_DEFINES) $(CXX_FLAGS) -o CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o -c /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp

CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.i: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Preprocessing CXX source to CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.i"
	/usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -E /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp > CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.i

CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.s: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Compiling CXX source to assembly CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.s"
	/usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -S /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp -o CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.s

CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o.requires:
.PHONY : CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o.requires

CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o.provides: CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o.requires
	$(MAKE) -f CMakeFiles/main.dir/build.make CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o.provides.build
.PHONY : CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o.provides

CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o.provides.build: CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o

# Object files for target main
main_OBJECTS = \
"CMakeFiles/main.dir/main.cpp.o" \
"CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o" \
"CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o" \
"CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o" \
"CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o"

# External object files for target main
main_EXTERNAL_OBJECTS =

main: CMakeFiles/main.dir/main.cpp.o
main: CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o
main: CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o
main: CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o
main: CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o
main: CMakeFiles/main.dir/build.make
main: /usr/lib/i386-linux-gnu/libboost_system.so
main: /usr/lib/i386-linux-gnu/libboost_filesystem.so
main: /usr/lib/i386-linux-gnu/libboost_thread.so
main: /usr/lib/i386-linux-gnu/libboost_date_time.so
main: /usr/lib/i386-linux-gnu/libboost_iostreams.so
main: /usr/lib/i386-linux-gnu/libboost_serialization.so
main: /usr/lib/i386-linux-gnu/libboost_chrono.so
main: /usr/lib/i386-linux-gnu/libpthread.so
main: /usr/lib/libpcl_common.so
main: /usr/lib/libOpenNI.so
main: /usr/lib/libOpenNI2.so
main: /usr/lib/libvtkCommon.so.5.8.0
main: /usr/lib/libvtkFiltering.so.5.8.0
main: /usr/lib/libvtkImaging.so.5.8.0
main: /usr/lib/libvtkGraphics.so.5.8.0
main: /usr/lib/libvtkGenericFiltering.so.5.8.0
main: /usr/lib/libvtkIO.so.5.8.0
main: /usr/lib/libvtkRendering.so.5.8.0
main: /usr/lib/libvtkVolumeRendering.so.5.8.0
main: /usr/lib/libvtkHybrid.so.5.8.0
main: /usr/lib/libvtkWidgets.so.5.8.0
main: /usr/lib/libvtkParallel.so.5.8.0
main: /usr/lib/libvtkInfovis.so.5.8.0
main: /usr/lib/libvtkGeovis.so.5.8.0
main: /usr/lib/libvtkViews.so.5.8.0
main: /usr/lib/libvtkCharts.so.5.8.0
main: /usr/lib/libpcl_io.so
main: /usr/lib/i386-linux-gnu/libboost_system.so
main: /usr/lib/i386-linux-gnu/libboost_filesystem.so
main: /usr/lib/i386-linux-gnu/libboost_thread.so
main: /usr/lib/i386-linux-gnu/libboost_date_time.so
main: /usr/lib/i386-linux-gnu/libboost_iostreams.so
main: /usr/lib/i386-linux-gnu/libboost_serialization.so
main: /usr/lib/i386-linux-gnu/libboost_chrono.so
main: /usr/lib/i386-linux-gnu/libpthread.so
main: /usr/lib/libpcl_common.so
main: /usr/lib/libpcl_octree.so
main: /usr/lib/i386-linux-gnu/libboost_system.so
main: /usr/lib/i386-linux-gnu/libboost_filesystem.so
main: /usr/lib/i386-linux-gnu/libboost_thread.so
main: /usr/lib/i386-linux-gnu/libboost_date_time.so
main: /usr/lib/i386-linux-gnu/libboost_iostreams.so
main: /usr/lib/i386-linux-gnu/libboost_serialization.so
main: /usr/lib/i386-linux-gnu/libboost_chrono.so
main: /usr/lib/i386-linux-gnu/libpthread.so
main: /usr/lib/libpcl_common.so
main: /usr/lib/i386-linux-gnu/libboost_system.so
main: /usr/lib/i386-linux-gnu/libboost_filesystem.so
main: /usr/lib/i386-linux-gnu/libboost_thread.so
main: /usr/lib/i386-linux-gnu/libboost_date_time.so
main: /usr/lib/i386-linux-gnu/libboost_iostreams.so
main: /usr/lib/i386-linux-gnu/libboost_serialization.so
main: /usr/lib/i386-linux-gnu/libboost_chrono.so
main: /usr/lib/i386-linux-gnu/libpthread.so
main: /usr/lib/libpcl_common.so
main: /usr/lib/libpcl_octree.so
main: /usr/lib/libOpenNI.so
main: /usr/lib/libOpenNI2.so
main: /usr/lib/libvtkCommon.so.5.8.0
main: /usr/lib/libvtkFiltering.so.5.8.0
main: /usr/lib/libvtkImaging.so.5.8.0
main: /usr/lib/libvtkGraphics.so.5.8.0
main: /usr/lib/libvtkGenericFiltering.so.5.8.0
main: /usr/lib/libvtkIO.so.5.8.0
main: /usr/lib/libvtkRendering.so.5.8.0
main: /usr/lib/libvtkVolumeRendering.so.5.8.0
main: /usr/lib/libvtkHybrid.so.5.8.0
main: /usr/lib/libvtkWidgets.so.5.8.0
main: /usr/lib/libvtkParallel.so.5.8.0
main: /usr/lib/libvtkInfovis.so.5.8.0
main: /usr/lib/libvtkGeovis.so.5.8.0
main: /usr/lib/libvtkViews.so.5.8.0
main: /usr/lib/libvtkCharts.so.5.8.0
main: /usr/lib/libpcl_io.so
main: /usr/lib/i386-linux-gnu/libboost_system.so
main: /usr/lib/i386-linux-gnu/libboost_filesystem.so
main: /usr/lib/i386-linux-gnu/libboost_thread.so
main: /usr/lib/i386-linux-gnu/libboost_date_time.so
main: /usr/lib/i386-linux-gnu/libboost_iostreams.so
main: /usr/lib/i386-linux-gnu/libboost_serialization.so
main: /usr/lib/i386-linux-gnu/libboost_chrono.so
main: /usr/lib/i386-linux-gnu/libpthread.so
main: /usr/lib/libOpenNI.so
main: /usr/lib/libOpenNI2.so
main: /usr/lib/libvtkCommon.so.5.8.0
main: /usr/lib/libvtkFiltering.so.5.8.0
main: /usr/lib/libvtkImaging.so.5.8.0
main: /usr/lib/libvtkGraphics.so.5.8.0
main: /usr/lib/libvtkGenericFiltering.so.5.8.0
main: /usr/lib/libvtkIO.so.5.8.0
main: /usr/lib/libvtkRendering.so.5.8.0
main: /usr/lib/libvtkVolumeRendering.so.5.8.0
main: /usr/lib/libvtkHybrid.so.5.8.0
main: /usr/lib/libvtkWidgets.so.5.8.0
main: /usr/lib/libvtkParallel.so.5.8.0
main: /usr/lib/libvtkInfovis.so.5.8.0
main: /usr/lib/libvtkGeovis.so.5.8.0
main: /usr/lib/libvtkViews.so.5.8.0
main: /usr/lib/libvtkCharts.so.5.8.0
main: /usr/lib/libpcl_common.so
main: /usr/lib/libpcl_io.so
main: /usr/lib/libpcl_octree.so
main: /usr/lib/i386-linux-gnu/libboost_system.so
main: /usr/lib/i386-linux-gnu/libboost_filesystem.so
main: /usr/lib/i386-linux-gnu/libboost_thread.so
main: /usr/lib/i386-linux-gnu/libboost_date_time.so
main: /usr/lib/i386-linux-gnu/libboost_iostreams.so
main: /usr/lib/i386-linux-gnu/libboost_serialization.so
main: /usr/lib/i386-linux-gnu/libboost_chrono.so
main: /usr/lib/i386-linux-gnu/libpthread.so
main: /usr/lib/libpcl_common.so
main: /usr/lib/libOpenNI.so
main: /usr/lib/libOpenNI2.so
main: /usr/lib/libpcl_io.so
main: /usr/lib/libpcl_octree.so
main: /usr/lib/libvtkViews.so.5.8.0
main: /usr/lib/libvtkInfovis.so.5.8.0
main: /usr/lib/libvtkWidgets.so.5.8.0
main: /usr/lib/libvtkVolumeRendering.so.5.8.0
main: /usr/lib/libvtkHybrid.so.5.8.0
main: /usr/lib/libvtkParallel.so.5.8.0
main: /usr/lib/libvtkRendering.so.5.8.0
main: /usr/lib/libvtkImaging.so.5.8.0
main: /usr/lib/libvtkGraphics.so.5.8.0
main: /usr/lib/libvtkIO.so.5.8.0
main: /usr/lib/libvtkFiltering.so.5.8.0
main: /usr/lib/libvtkCommon.so.5.8.0
main: /usr/lib/libvtksys.so.5.8.0
main: CMakeFiles/main.dir/link.txt
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --red --bold "Linking CXX executable main"
	$(CMAKE_COMMAND) -E cmake_link_script CMakeFiles/main.dir/link.txt --verbose=$(VERBOSE)

# Rule to build all files generated by this target.
CMakeFiles/main.dir/build: main
.PHONY : CMakeFiles/main.dir/build

CMakeFiles/main.dir/requires: CMakeFiles/main.dir/main.cpp.o.requires
CMakeFiles/main.dir/requires: CMakeFiles/main.dir/segmentacion/filtrado/FiltroNube.cpp.o.requires
CMakeFiles/main.dir/requires: CMakeFiles/main.dir/segmentacion/planar_segmentation/Segmentador.cpp.o.requires
CMakeFiles/main.dir/requires: CMakeFiles/main.dir/segmentacion/clusterizado(euclidean_segmentation)/GeneradorClusters.cpp.o.requires
CMakeFiles/main.dir/requires: CMakeFiles/main.dir/reconstruccionConvexHull/convex_hull_reconstruction/ConstructorConvexHull.cpp.o.requires
.PHONY : CMakeFiles/main.dir/requires

CMakeFiles/main.dir/clean:
	$(CMAKE_COMMAND) -P CMakeFiles/main.dir/cmake_clean.cmake
.PHONY : CMakeFiles/main.dir/clean

CMakeFiles/main.dir/depend:
	cd /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main && $(CMAKE_COMMAND) -E cmake_depends "Unix Makefiles" /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main /home/rodrigo/aplicacionesWeb/ProyectoBacheo/pclPipeLine/main/CMakeFiles/main.dir/DependInfo.cmake --color=$(COLOR)
.PHONY : CMakeFiles/main.dir/depend

