#!/bin/sh


### BEGIN INIT INFO
# Provides:             homiq
# Required-Start:       $postgresql
# Required-Stop:        $time
# Should-Start:         $syslog
# Should-Stop:          $postgresql
# Default-Start:        2 3 4 5
# Default-Stop:         0 1 6
# Short-Description:    Inteligent Home
### END INIT INFO


cd /home/homiq 

if [ "$1" = "stop" ]
then
	su pi /home/homiq/stop.sh
	exit
fi

if [ "$1" = "restart" ]
then
	su pi /home/homiq/restart.sh
	exit
fi

su pi /home/homiq/start.sh
