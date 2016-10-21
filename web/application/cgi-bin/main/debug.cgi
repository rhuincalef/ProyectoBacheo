#!/bin/sh
QUERY_STRING='idFalla=8'
export QUERY_STRING
gdb build/conversorCgi.cgi
