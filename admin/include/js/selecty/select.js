var Preferencje = new Array();
var CookieQueue = new Array();
var CookiePos = 0;
var CookieSent = 0;

function preferuje(token,val)
{
	tokens=token.split(':');
	for (i=0;i<tokens.length;i++)
	{
		token=tokens[i];
		squarebracket=token.indexOf('[');
		if (squarebracket>0)
		{
			token='pref['+token.substring(0,squarebracket)+']'+token.substring(squarebracket);
		}
		else
		{
			Preferencje[token]=val;
			token='pref['+token+']';
		}
		
		CookieQueue[CookiePos++]=token+'='+val+'; path=/';
	}

	
}



function cookieQueueRun2()
{
	while (CookiePos>CookieSent) document.cookie=CookieQueue[CookieSent++];
	setTimeout(cookieQueueRun2,100);
	
}

cookieQueueRun2();


function selectyZalezne(tablicaZmiennych2,idSelectowOddzieloneDwukropkiem,naglowkiOddzieloneDwukropkiem,numerSelectaWybranego,selectoryWplywajaceRozdzieloneDwukropkiem)
{
	var selects=new Array();
	var values=new Array();
	var head=new Array();
	var sValues=new Array();
	var influence=new Array();


	if (selectoryWplywajaceRozdzieloneDwukropkiem==null)
	{
		ids=idSelectowOddzieloneDwukropkiem.split(':');
		for (i=0;i<ids.length;i++) influence[i]=new Array();
		for (i=0;i<ids.length;i++) 
		{
			for (j=0;j<ids.length;j++)
			{
				influence[i][j]=(i==j)?false:true;
			}
		}
	}
	else
	{
		ids=selectoryWplywajaceRozdzieloneDwukropkiem.split(':');
		for (i=0;i<ids.length;i++) influence[i]=new Array();
		gwiazdka='';
		for (i=0;i<ids.length;i++) 
		{
			if (i>0) gwiazdka+=',';
			gwiazdka+=i;
			for (j=0;j<ids.length;j++)
			{
				influence[i][j]=false;
			}
		}

		for (i=0;i<ids.length;i++) 
		{
			if (ids[i]=='*') ids[i]=gwiazdka;
			inf=ids[i].split(',');
			
			for (j=0;j<inf.length;j++)
			{
				jj=parseInt(inf[j]);
				if (i!=jj) influence[i][jj]=true;
			}
		}


	}


	tablicaZmiennych=tablicaZmiennych2['s'];
	if (tablicaZmiennych.length==0)
	{
		xlen=0;
		for (i=0;i<tablicaZmiennych2['k'].length;i++)
		{
			plus=3;
			if (tablicaZmiennych2['k'][i].length<=256) plus=2;
			if (tablicaZmiennych2['k'][i].length<=16) plus=1;
			xlen+=plus;
		}

		if (xlen>0) for (i=0;i<tablicaZmiennych2['x'].length/xlen; i++)
		{
			tablicaZmiennych[i] = new Array();
			tablicaZmiennych[i]['k'] = new Array();
			tablicaZmiennych[i]['n'] = new Array();

			totalen=0;
			for (j=0;j<tablicaZmiennych2['k'].length;j++)
			{
				len=3;
				if (tablicaZmiennych2['k'][j].length<=256) len=2;
				if (tablicaZmiennych2['k'][j].length<=16) len=1;
				//len=tablicaZmiennych2['k'][j].length<=16 ? 1 : 2;
				x=tablicaZmiennych2['x'].substr(i*xlen+totalen,len);
				
				totalen+=len;
				dd=parseInt(x,16);

				tablicaZmiennych[i]['k'][j]=tablicaZmiennych2['k'][j][dd];
				tablicaZmiennych[i]['n'][j]=tablicaZmiennych2['n'][j][dd];
			}

		}

		tablicaZmiennych2['s']=tablicaZmiennych;
	}



	ids=idSelectowOddzieloneDwukropkiem.split(':');
	for (i=0;i<ids.length;i++)
	{
		if (document.getElementById(ids[i])==null ) continue;

		selects[i]=document.getElementById(ids[i]);

		values[i]=Preferencje[ids[i]];

		sValues[i]=selects[i].value;
		
	}

	heads=naglowkiOddzieloneDwukropkiem.split(':');

	for (i=0;i<heads.length;i++)
	{
		head[i]=heads[i];
	}
	

	for (s=0;s<selects.length;s++)
	{

		if (s==numerSelectaWybranego) continue;

		if (numerSelectaWybranego>=0 && !influence[s][numerSelectaWybranego] ) continue;


		options=new Array();
		opt_idx=0;
		selects[s].length=500;
		selectedIndex=0;

	

		if (head[s].length && selects[s].options!=null)
		{
			selects[s].options[opt_idx].value='';
			//dodaje do nazwy spacje zeby w sortowaniu bylo pierwsze, na koncu przywracam nazwe
			selects[s].options[opt_idx].text=' ';
			opt_idx++;
		}


		for (t=0;t<tablicaZmiennych.length;t++)
		{
			if (options[tablicaZmiennych[t]['k'][s]]) continue;

			mozebyc=1;
			for (i=0;i<selects.length;i++)
			{
				if (i==s) continue;
				if (sValues[i]==null) continue;
				if (sValues[i].length==0) continue;
				if (sValues[i] != tablicaZmiennych[t]['k'][i] )
				{	
					mozebyc=0;
					break;
				}
			}
			if (mozebyc==0) continue;

			if (tablicaZmiennych[t]['n'][s].length==0) continue;

			if (selects[s].options!=null)
			{
				selects[s].options[opt_idx].value=tablicaZmiennych[t]['k'][s];
				selects[s].options[opt_idx].text=tablicaZmiennych[t]['n'][s];
			}

			if (values[s]==tablicaZmiennych[t]['k'][s]) selectedIndex=opt_idx;

			opt_idx++;
			
			options[tablicaZmiennych[t]['k'][s]]=1;
		}

		selects[s].length=opt_idx;
		selects[s].selectedIndex=selectedIndex;


	}



	//tu sortuje wartosci w selecie tylko dla destynacji i wylotu i pomijam ten aktualnie wybrany



	for (s=0;s<selects.length;s++)
	{
		if (s==numerSelectaWybranego) continue;
		if (numerSelectaWybranego>=0 && !influence[s][numerSelectaWybranego] ) continue;



		switch (s)
		{
		case 0:
		case 1:
			if (selects[s].options!=null) sortSelect(selects[s], true);
		}
		
		selects[s].value=sValues[s];
		if (sValues[s]=='') selects[s].selectedIndex=0;

		
	}

	//a tu przywracam pierwszy tekst w selekcie

	for (s=0;s<selects.length;s++)
	{
		if (head[s].length && selects[s].options!=null )
		{
			selects[s].options[0].value='';
			selects[s].options[0].text=head[s];
			//opt_idx++;
		}

		
		if (selects[s].options!=null)
		{
			prefix='';
			for (i=1;i<selects[s].options.length ;i++ )
			{
				if (prefix.length && selects[s].options[i].text.substr(0,prefix.length)==prefix)
				{
					selects[s].options[i].text=' -'+selects[s].options[i].text.substr(prefix.length);
				}
				else
				{
					prefix=selects[s].options[i].text;
				}
			}

			
		}	
	}

	for (s=0;s<selects.length;s++)
	{
		if (numerSelectaWybranego<0) continue;
		if (numerSelectaWybranego>=0 && !influence[s][numerSelectaWybranego] ) continue;

		if (selects[s].selectedIndex > 0 ) continue;
	
		if (typeof(Preferencje[selects[s].name])!='undefined') if (Preferencje[selects[s].name].length>0) 
		{
			selects[s].value=Preferencje[selects[s].name];
			if (selects[s].value.length==0) selects[s].selectedIndex=0;
		}
		

		
	}
	


}
<!-- funckje zalatwione przez Robsona -->

// sort function - ascending (case-insensitive)
function sortFuncAsc(record1, record2) {
	var value1 = record1.optText.toLowerCase();
	var value2 = record2.optText.toLowerCase();
	if (value1 > value2) return(1);
	if (value1 < value2) return(-1);
	return(0);
}

// sort function - descending (case-insensitive)
function sortFuncDesc(record1, record2) {
	var value1 = record1.optText.toLowerCase();
	var value2 = record2.optText.toLowerCase();
	if (value1 > value2) return(-1);
	if (value1 < value2) return(1);
	return(0);
}

function sortSelect(selectToSort, ascendingOrder) 
{
	//alert(selectToSort.name+': '+selectToSort.options.length);

	if (arguments.length == 1) ascendingOrder = true;    // default to ascending sort

	// copy options into an array
	var myOptions = [];
	for (var loop=0; loop<selectToSort.options.length; loop++) {
		myOptions[loop] = { optText:selectToSort.options[loop].text, optValue:selectToSort.options[loop].value };
	}

	// sort array
	if (ascendingOrder) {
		myOptions.sort(sortFuncAsc);
	} else {
		myOptions.sort(sortFuncDesc);
	}

	// copy sorted options from array back to select box
	selectToSort.options.length = 0;
	for (var loop=0; loop<myOptions.length; loop++) 
	{
		var optObj = document.createElement('option');
		optObj.text = myOptions[loop].optText;
		optObj.value = myOptions[loop].optValue;
		selectToSort.options.add(optObj);
	}
}



