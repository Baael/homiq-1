#!/bin/sh

cd  `dirname $0`

sh stop.sh
sleep 1
mv homiq.log log/homiq.log.`date +'%Y-%m-%d'`
gzip log/homiq.log.`date +'%Y-%m-%d'`
sh start.sh

