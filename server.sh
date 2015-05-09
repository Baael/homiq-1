#!/bin/sh

cd  `dirname $0`

sh stop.sh
sleep 1
php server.php
