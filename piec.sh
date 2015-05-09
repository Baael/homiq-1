#!/bin/sh

cd `dirname $0`

plik="piec/`date +%F-%H-%M`.jpg"

wget -O $plik -o /dev/null http://10.10.20.99/piec.jpg
