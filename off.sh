cd `dirname $0`
txt=`/usr/bin/php dodatek.php`
link="http://api.gsmservice.pl/send.php?login=pudel&pass=spierdalaj&recipient=48601704847&text=pa+$txt&type=1&sender=Promienko"

#wget -o /dev/null -O /dev/null "$link" &
