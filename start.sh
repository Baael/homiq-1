#!/bin/sh

cd  `dirname $0`

echo -n "starting homiq ... "

if [ "`id -u`" = "0" ]
then
	/usr/bin/rdate -s ntp.task.gda.pl
else
	sudo /usr/bin/rdate -s ntp.task.gda.pl
fi
 
if [ -f postgres ]
then
	mkdir /var/run/postgresql 2>/dev/null
	chown postgres /var/run/postgresql
	su - postgres '/home/homiq/postgres.sh'  >/dev/null
	sleep 3
fi

if [ -f ifconf ]
then
	sh ifconf	
fi


if [ "`id -u`" = "0" ]
then
	su www-data ./homiq_start.sh
else
	sudo su www-data ./homiq_start.sh
fi
echo "ok"

