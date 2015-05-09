	function keyExists(sel,key)
	{
		var i,len,o_key, result;
		
		result=false;
		len=sel.length;
		for (i=0;i<len;i++)
		{
			o_key=sel.options[i].value;
			if (key==o_key)
			{ 
				result=true;
				break;
			}
		}
		return result;
	}

	function wResetSelect(obj,txt)
	{
		if (obj == null) return false;
		sel_len=obj.length;
		for (i=0;i<sel_len;i++)
		{
			obj[i]=null;
		}
		obj.length=0;
		last=obj.length;
		nowy= new Option(txt,'',0,1);
		obj[last] = nowy;
	}

	function wSetSelect(obj1,obj2,dane)
	{
		wResetSelect(obj2,'wybierz');
		if (obj1 == null || dane == null) return false;
		var klucz = obj1.value;
		if (klucz != '')
		{
			var dlugosc = dane[''+klucz+'']['k'].length;
			var ilosc_wierszy = obj2.length;
			if (obj2 != null)
			{
				obj2.length = dlugosc + ilosc_wierszy;
				for (i=0; i < dlugosc; i++)
				{
					obj2.options[i+ilosc_wierszy].value = dane[''+klucz+'']['n'][i];
					obj2.options[i+ilosc_wierszy].text = dane[''+klucz+'']['n'][i];
				}
			}
		}
		else if (obj2 == null)
		{
			wResetSelect(obj1,'wybierz');
			obj1.length=0;
			for (key in dane)
			{
				dlugosc = dane[''+key+'']['k'];
				for (i=0; i < dlugosc.length; i++)
				{
					_key = dane[''+key+'']['k'][i];
					_val = dane[''+key+'']['n'][i];
					if (!keyExists(obj1,_key))
					{
						last=obj1.length;
						nowy= new Option(_val,_key,0,0);
			    		obj1[last] = nowy;
					}
				}

			}
		}

	}


	function wSetSelect_split(obj1,obj2,dane)
	{
		wResetSelect(obj2,'wybierz');
		if (obj1 == null || dane == null) return false;
		var klucz = obj1.value;
		if (klucz != '')
		{
			var dlugosc = dane[''+klucz+'']['k'].length;
			var ilosc_wierszy = obj2.length;
			if (obj2 != null)
			{
				obj2.length = dlugosc + ilosc_wierszy;
				for (i=0; i < dlugosc; i++)
				{
					obj2.options[i+ilosc_wierszy].value = dane[''+klucz+'']['k'][i];
					obj2.options[i+ilosc_wierszy].text = dane[''+klucz+'']['n'][i];
				}
			}
		}
		else if (obj2 == null)
		{
			wResetSelect(obj1,'wybierz');
			obj1.length=0;
			for (key in dane)
			{
				dlugosc = dane[''+key+'']['k'];
				for (i=0; i < dlugosc.length; i++)
				{
					_key = dane[''+key+'']['k'][i];
					_val = dane[''+key+'']['n'][i];
					if (!keyExists(obj1,_key))
					{
						last=obj1.length;
						nowy= new Option(_val,_key,0,0);
			    		obj1[last] = nowy;
					}
				}

			}
		}

	}


	function findAndSelect(obj,val)
	{
		if (obj == null || val == null)
			return false;

		for (i=0; i < obj.length; i++)
		{
			if (obj.options[i].value == val)
			{
				obj.options[i].selected = true;
				return true;
			}
		}
		return false;
	}
