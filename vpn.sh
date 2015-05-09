#!/bin/sh
if [ ! "`/sbin/ifconfig |grep 192.168.168.16`" ]
then
	ns=`/sbin/route -n | /bin/awk '{if ($1=="0.0.0.0") print $2}'`
	echo "nameserver $ns" > /etc/resolv.conf
fi

