
while [ "1" = "1" ]
do
	temp=`echo "select g_t from global;" |psql -t -q homiq-promienko 2>/dev/null|head -n 1 `


	if [ "$temp" ]
	then
		break
	fi
	sleep 1
	echo dupa
done


/home/homiq/start.sh >/dev/null 2>/dev/null
