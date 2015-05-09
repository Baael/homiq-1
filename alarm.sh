
cd `dirname $0`
txt=`/usr/bin/php -r "echo date('H:i');"`
if [ $1 ]
then
	txt=$1
fi
link="http://api.gsmservice.pl/send.php?login=pudel&pass=spierdalaj&recipient=48601704847&text=ALARM+$txt&type=1&sender=Promienko"

wget -o /dev/null -O /dev/null "$link" &

echo "From: alarm@promienko.pl
To: piotr@gammanet.pl
Subject: alarm

$txt" | /usr/sbin/ssmtp  piotr@gammanet.pl
