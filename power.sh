#!/bin/sh

cd `dirname $0`
txt=`/usr/bin/php -r "echo date('H:i');"`
if [ $1 ]
then
	txt=`/usr/bin/php -r "echo round($1,2);"`
fi

echo "From: alarm@promienko.pl
To: piotr@gammanet.pl,anna.kapluk@gmail.com
Subject: prąd

Dom bierze $txt kWh, tak ma być ?" | /usr/sbin/ssmtp  piotr@gammanet.pl
