
var ajax_may_document_write = true;

var ajax_idle_started = false ;


function ajax_action(action,id,callback)
{

	href_a=location.href.split('?');
	action_path=href_a[0]+'?ajax_action=1&'+action;


	$.get(action_path,
						function(state)
						{
							if (state.length>0)
							{
								if (callback=='roleta')
								{
									ajax_roleta(id,state);
								}
								else
								{
									ajax_onoff(id,callback,state);
								}
							}
						}
	);

}

function ajax_onoff(id,type,state)
{
	uimages=ajax_uimages;

	divId='o_'+id;

	if (type=='M') divId='macro_'+id;

	div=document.getElementById(divId);


	if (div==null)
	{
		html='<div id="'+divId+'">';
		if (!ajax_idle_started) ajax_idle();
	}
	else
	{
		html='';
	}

	if (type=='M')
	{
		src=uimages+'/run.gif';
		if (state=='a') src=uimages+'/runa.gif';
		_onclick='ajax_action(\'action=macro&m_id='+id+'\',\''+id+'\',\'macro\')';

	}
	else
	{
		src=uimages+'/'+type+'-'+state+'.gif';
		_onclick='ajax_action(\'action=O&o_id='+id+'\',\''+id+'\',\''+type+'\')';
	}

	html+='<img style="cursor: pointer" onclick="'+_onclick+'" src="'+src+'" />';

	if (div==null)
	{
		html+='</div>';
		if (ajax_may_document_write) document.write(html);
	}
	else
	{
		div.innerHTML=html;
	}

}

function ajax_roleta(id,state)
{
	uimages=ajax_uimages;

	divId='r_'+id;
	div=document.getElementById(divId);

	if (div==null)
	{
		html='<div id="'+divId+'">';
		if (!ajax_idle_started) ajax_idle();
	}
	else
	{
		divId=div;
		html='';
	}

	if (state=='d') 
	{
		src=uimages+'/down-1.gif';
		_onclick='';
		style='';
	}
	else
	{
		src=uimages+'/down-0.gif'
		_onclick='ajax_action(\'action=d&m_id='+id+'\',\''+id+'\',\'roleta\')';
		style='cursor: pointer';
	}

	html+='<img style="'+style+'" onclick="'+_onclick+'" src="'+src+'" />';

	if (state=='D' || state=='U') 
	{
		src=uimages+'/stop-1.gif';
		_onclick='';
		style='';
	}
	else
	{
		src=uimages+'/stop-0.gif';
		_onclick='ajax_action(\'action=s&m_id='+id+'\',\''+id+'\',\'roleta\')';
		style='cursor: pointer';
	}

	html+='<img style="'+style+'" onclick="'+_onclick+'" src="'+src+'" />';


	if (state=='u') 
	{
		src=uimages+'/up-1.gif';
		_onclick='';
		style='';
	}
	else
	{
		src=uimages+'/up-0.gif';
		_onclick='ajax_action(\'action=u&m_id='+id+'\',\''+id+'\',\'roleta\')';
		style='cursor: pointer';
	}


	html+='<img style="'+style+'" onclick="'+_onclick+'" src="'+src+'" />';


	if (div==null)
	{
		html+='</div>';
		if (ajax_may_document_write) document.write(html);
	}
	else
	{
		div.innerHTML=html;
	}

}

d = new Date();
var ajax_time_difference = ajax_now - Math.round(d.getTime()/1000) ;
var ajax_last_check = Math.round(d.getTime()/1000) + ajax_time_difference + 1;


function ajax_idle()
{
	ajax_idle_started = true;
	href_a=location.href.split('?');
	action_path=href_a[0]+'?ajax_action=1&action=idle&t='+ajax_last_check;

	d = new Date();
	ajax_last_check = Math.round(d.getTime()/1000) + ajax_time_difference;


	$.get(action_path,
						function(resp)
						{
							if (resp.length>0)
							{
								ajax_may_document_write = false;

								wynik=resp.split(',');
								for(i=0;i<wynik.length;i++)
								{
									linia=wynik[i].split(':');
									
									if (linia[0]=='o') ajax_onoff(linia[1],linia[2],linia[3]);
									if (linia[0]=='R') ajax_roleta(linia[1],linia[2]);
									if (linia[0]=='M') ajax_onoff(linia[1],'M',linia[2]);
								}
							}
						}
	);
							setTimeout(ajax_idle,1500);	

}



//document.write('<pre id="idle_debug">TU DEBUG Z BIEDRONKI</pre>');


