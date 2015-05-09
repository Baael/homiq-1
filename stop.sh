
cd  `dirname $0`

echo -n "stoping homiq ... "


if [ -f homiq.pid ]
then
	if [ "`id -u`" = "0" ]
	then
		kill -TERM `cat homiq.pid`
	else
		sudo kill -TERM `cat homiq.pid`
	fi
fi

if [ -f postgres ]
then
	sleep 1

	if [ -f /var/lib/postgresql/current/data/postmaster.pid ]
	then
		kill -TERM `cat /var/lib/postgresql/current/data/postmaster.pid |head -n 1`
		rm -f /var/lib/postgresql/current/data/postmaster.pid
	fi
fi
echo "ok"


