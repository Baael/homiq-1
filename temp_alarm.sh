#!/bin/sh

echo "$1: `date`" >>/tmp/alarm-temperatury

cd `dirname $0`

txt=`/usr/bin/php -r "echo date('H:i');"`

if [ "$1" = "1" ]
then

	link="http://api.gsmservice.pl/send.php?login=pudel&pass=spierdalaj&recipient=48601704847&text=PIEC+SIE+NIE+ROZPALIL+$txt&type=1&sender=Promienko"
	wget -o /dev/null -O /dev/null "$link" &

	link="http://api.gsmservice.pl/send.php?login=pudel&pass=spierdalaj&recipient=48695773100&text=PIEC+SIE+NIE+ROZPALIL+$txt&type=1&sender=Promienko"
	wget -o /dev/null -O /dev/null "$link" &
fi

