#!/bin/sh


cd `dirname $0`
php sunriseset.php >/dev/null 2>/dev/null
php clean.php
pg_dump homiq-promienko > homiq-promienko.sql
rm -f homiq-promienko.sql.gz
gzip homiq-promienko.sql
vacuumdb -f -d homiq-promienko >/dev/null
#svn -q -m "baza danych" ci homiq-promienko.sql.gz
git commit -m "baza danych" homiq-promienko.sql.gz
git push

if [ "`id -u`" = "0" ]
then
	/usr/bin/rdate -s ntp.task.gda.pl
else
	sudo /usr/bin/rdate -s ntp.task.gda.pl
fi
 

