

function createCheckBox(s,tdid,adr)
{
	_adr=parseInt(adr);

	sel=document.getElementById(s);
	html='';
	for (i=1; i<sel.options.length; i++)
	{
		v=sel.options[i].value;
		t=sel.options[i].text;

		_v=v.split('.');
		a=parseInt(_v[0]);

		pow=parseInt(Math.pow(2,a));
		
		and=_adr & pow;
		ch = (and > 0 ) ? 'checked' : '';
		

		html+='<input '+ch+' type="checkbox" name="actions[a_input_adr]['+a.toString()+']" value="'+pow.toString()+'" /> '+t+'<br />';
		//alert(t+':'+v);
	}
	document.getElementById(tdid).innerHTML=html;

}

function przepiszDoHidden(obj)
{
	
	id='_'+obj.id;
	obj2=document.getElementById(id);

	if (obj2!=null) 
	{
		o=obj.value.split('.');
		obj2.value=o[0];
	}
	
}

function selectWeOnChange(s,nr)
{
	if (document.getElementById('we_master')==null) return;
	if (s!=null) przepiszDoHidden(s);
	if (typeof(selectyZalezne)!='undefined') if (typeof(we)!='undefined') selectyZalezne(we,'we_master:we_module:we_input','wybierz:wybierz:wybierz',nr);
} 

function selectWyOnChange(s,nr)
{
	if (document.getElementById('wy_master')==null) return;
	if (s!=null) przepiszDoHidden(s);
	if (typeof(selectyZalezne)!='undefined') if (typeof(wy)!='undefined') selectyZalezne(wy,'wy_master:wy_module:wy_output','wybierz:wybierz:wybierz',nr);
   
} 

function ustawWartoscSel(s,v)
{
	sel=document.getElementById(s);
	sel.value=v;
	return;


	for (i=0;i<sel.options.length ;i++ )
	{
		alert(sel.options[i].value+' ? '+v);
	}

}

