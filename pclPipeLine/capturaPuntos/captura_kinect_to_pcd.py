#import the necessary modules
import freenect
import cv2
import numpy as np
 
from calibkinect import depth2xyzuv
import pcl
import sys,getopt
import re

#function to get RGB image from kinect
def get_video():
    array,_ = freenect.sync_get_video()
    array = cv2.cvtColor(array,cv2.COLOR_RGB2BGR)
    return array

#function to get depth image from kinect
def get_depth():
    array,_ = freenect.sync_get_depth()
    # array = array.astype(np.uint8)
    return array
 
depth = None
frame = None
grayscale_frame = None

def showHelp():
    print 'Ayuda: '
    print 'Presione ESC para salir.'
    print 'Presione h para ver ayuda.'
    print 'Presione SPACEBAR para capturar los datos del kinect.'


def esNombreArchivoValido(nomb):
    inicio=None
    inicio=re.compile('[a-zA-Z0-9]+.pcd$')
    return inicio.search(nomb) is not None
        

def main(argv):
    #Obtencion de parametros de entrada 
    try:
        opts, args = getopt.getopt(argv,"f",["archivoDeCaptura="])
    except getopt.GetoptError:
        print 'python captura_kinect_to_pcd.py -f <archivo-salida>'
        sys.exit(1)

    archivoSalida=''
    (opt,_)=opts[0]
    if opt!='-f' or not esNombreArchivoValido(args[0]):
        print "Error se debe proporcionar la opcion -f <nombre-archivo-captura>.pcd"
        print ""
        sys.exit(1)

    archivoSalida=args[0]
    #Acceso al Kinect para captura
    while 1:
        #get a frame from RGB camera
        frame = get_video()
        #get a frame from depth sensor
        depth = get_depth()
        
        #converting to gray scale image from kinect
        grayscale_frame = cv2.cvtColor(frame,cv2.COLOR_RGB2GRAY)
        
        #display RGB image
        cv2.imshow('RGB image',frame)

        #display depth image
        depth_image = depth.astype(np.uint8)
        cv2.imshow('Depth image',depth_image)
 
        cv2.imshow('COLOR_RGB2GRAY', grayscale_frame)
        # quit program when 'esc' key is pressed
        k = cv2.waitKey(5) & 0xFF
        if k == 27:
            break
        elif k == 32:
            print 'Captura:'
            xyz, uv = depth2xyzuv(depth)
            data = xyz.astype(np.float32)
            print data

            cv2.imwrite('video.png', frame)
            
            p = pcl.PointCloud(data)
            pcl.save(p, archivoSalida)
        elif k == 104:
            showHelp()

    cv2.destroyAllWindows()


if __name__ == "__main__":
    main(sys.argv[1:])