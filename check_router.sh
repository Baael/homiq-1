#!/bin/sh

export PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/opt/bin:/usr/x86_64-pc-linux-gnu/gcc-bin/4.3.2:/usr/kde/3.5/sbin:/usr/kde/3.5/bin:/usr/qt/3/bin

rm -f /tmp/wp
wget -O /tmp/wp -o /dev/null http://www.wp.pl
if [ ! -s /tmp/wp ]
then
	wget  -O /dev/null -o /dev/null --http-user=admin --http-password=html#OK  "http://10.10.20.254/cgi-bin/reset.cgi" &
	sleep 20
	php -r "mail('piotr@podstawski.com','promienko-restart','reset');"
fi
