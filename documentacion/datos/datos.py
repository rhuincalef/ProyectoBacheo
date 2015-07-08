#!/usr/bin/env python2

import sys
import freenect
import cPickle

def main(args=sys.argv):
	print(args[1])
	depth, timestamp = freenect.sync_get_depth()

	with open(args[1], 'w') as f:
		cPickle.dump({'depth': depth, 'timestamp': timestamp}, f)

if __name__ == '__main__':
	main()