#!/bin/sh

cd `dirname $0`
txt=`/usr/bin/php -r "echo date('H:i');"`

link="http://api.gsmservice.pl/send.php?login=pudel&pass=spierdalaj&recipient=48601704847&text=temperatura+$1+%28$txt%29&type=1&sender=Promienko"

wget -o /dev/null -O /dev/null "$link" &

php sql.php global_timestamp.sql 
