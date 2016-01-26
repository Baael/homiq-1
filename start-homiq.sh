#!/bin/sh

cd  `dirname $0`

while [ "1" = "1" ]
do
	temp=`echo "select g_t from global;" |psql -t -q homiq-promienko 2>/dev/null|head -n 1 `


	if [ "$temp" ]
	then
		break
	fi
	sleep 1
	echo "[`date`] No database" >> homiq.log
done

while [ "1" = "1" ]
do
	/home/homiq/start.sh >/dev/null 2>/dev/null
	sleep 2
	fail=`tail -n 3 homiq.log | grep "not connectable"`
	if [ ! "$fail" ]
	then
		break
	fi
done
