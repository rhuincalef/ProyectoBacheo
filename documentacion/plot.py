import numpy as np
from mpl_toolkits.mplot3d import Axes3D
import matplotlib.pyplot as plt
import random
import cPickle
import sys

def main(args=sys.argv):

	p = open(args[1], 'r')
	o = cPickle.load(p)

	def fun(x, y):
	  return -(o["depth"][x][y])

	fig = plt.figure()
	ax = fig.add_subplot(111, projection='3d')
	x = y = np.arange(0, 480, 1)
	X, Y = np.meshgrid(x, y)
	zs = np.array([fun(x,y) for x,y in zip(np.ravel(X), np.ravel(Y))])
	Z = zs.reshape(X.shape)

	ax.plot_surface(X, Y, Z)

	ax.set_xlabel('X Label')
	ax.set_ylabel('Y Label')
	ax.set_zlabel('Z Label')

	plt.show()

if __name__ == '__main__':
	main()