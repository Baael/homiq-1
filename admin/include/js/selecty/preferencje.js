Preferencje=new Array();
dc=document.cookie;
if (dc.length>0)
{
	dca=dc.split(';');
	for (dci=0;dci<dca.length;dci++)
	{		
		ciastko=dca[dci];
		while (ciastko.substr(0,1)==' ') ciastko=ciastko.substr(1);
		if (ciastko.substr(0,5)!='pref[') continue;
		ciastko=ciastko.substr(5);
		ci=ciastko.indexOf(']');
		key=ciastko.substr(0,ci);
		val=ciastko.substr(ci+2);
		Preferencje[key]=val;
	}
}