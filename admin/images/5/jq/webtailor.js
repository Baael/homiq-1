/// <reference path="jquery-1.2.4-intellisense.js" />
var listaFotek = new Array ();
var temp = new Array();
var listaFotekAlt = new Array ();
var listaFotekClass = new Array ();
var tbSize = new Array ();
var szerokosc=0;				
var wysokosc=0;	
var licznik = 0;
var maks = new Array(); 
var nr = 1; 	
var img = new Image(); 
var interv;
function pokaz()
{
	licznik++;
	if(licznik == listaFotek .length )
	{
		licznik = 0;
	}
	$('.cmsJQGNaviLinks').removeClass('cmsJQChosen'); 
	$('.cmsJQGNaviLinks').eq(licznik).addClass('cmsJQChosen');
	setSize(licznik, img);
	var szerokosc = tbSize[0];
	var wysokosc = tbSize[1];
	var szerokoscPictStyl = tbSize[2];
	var wysokoscPictStyl = tbSize[3];
	var pozXzdjecia = tbSize[4];
	var pozYzdjecia = tbSize[5];
	var pozXdivStyl = tbSize[6];
	var pozYdivStyl = tbSize[7];
	var pozXdiv = tbSize[8];
	var pozYdiv = tbSize[9];
	pozYdivStylNavi = (parseInt (pozYdiv-wysokosc))+'px'; 
	pozXdivStylNavi = (parseInt (pozXdiv-szerokosc))+'px'; 
	$('.cmsJQPict img').attr('src',listaFotek[licznik]).animate({'width':szerokosc, 'height':wysokosc}); 
	$('.cmsJQPict').animate({ 'top':pozYdiv, 'left':pozXdiv ,'width':szerokoscPictStyl,'height':wysokoscPictStyl});
	$('.cmsJQPict img').animate ({ 'left':0,'top' :0 });
	if(listaFotekAlt[licznik]!='')
		$('#cmsJQText').css('width',szerokoscPictStyl);
	else
		$('#cmsJQText').css('width',0); 
	$('#cmsJQText').text(listaFotekAlt[licznik]);
	
}
		
//pobranie obrazow z rel=jquery
function pobierzObrazyRel(wybranaKlasa) 
{ 
 $('a[@rel*=jquery]').each (function (i) 
 {
 	var link = $(this); 
	//alert($(this).html());
	listaFotek[i]=$(this).attr('href');
	listaFotekClass[i]=$(link).attr('class');
		//alert(listaFotek[i]);
		if ($(link).children('img').attr('alt')!=undefined)
			listaFotekAlt[i]=$(link).children('img').attr('alt');
		else
			listaFotekAlt[i]= '';
	;}); 
	return listaFotek; 

}

//dostosowywanie rozmiarow i polozenia
function setSize(licznik,img) 
{
	img.src = listaFotek[licznik]; 
	tbSize[0] = img.width; 
	tbSize[1] = img.height; 
	var szerokoscPict = tbSize[0] +30; 
	var wysokoscPict = tbSize[1] +30; 
	tbSize[2] = szerokoscPict +'px';
	tbSize[3] = wysokoscPict +'px';
	tbSize[4] = (parseInt(((szerokoscPict)/2)))+'px'; 
	tbSize[5] = (parseInt(((wysokoscPict)/2)))+'px'; 
	tbSize[8] = (document.body.offsetWidth-szerokoscPict)/2; 
	tbSize[6] = (parseInt (tbSize[8] )) +'px'; 
	tbSize[9] = (document.body.offsetHeight-wysokoscPict)/2; 
	tbSize[7] = (parseInt (tbSize[9] )) +'px'; 
	return tbSize;
}

function maxXY(listaFotek) 
{ 
	maks[0]=0;
	maks[1]=0; 
	for (i=0; i<=listaFotek.length-1;i++) 
	{   
		obraz = new Image(); 
		obraz.src = listaFotek [i]; 
		//alert(listaFotekClass[i]);
	} 
}

$(document).ready (function(){
	var szerokoscEkranu = document.body.scrollWidth +'px'; 
	var wysokoscEkranu = document.body.clientHeight+'px';
	//alert(navigator.appName);
	if (navigator.appName == "Microsoft Internet Explorer")
	wysokoscEkranu = document.body.clientHeight+'px';
	else
	wysokoscEkranu =  document.body.offsetHeight+'px';
	pobierzObrazyRel();
	maxXY(listaFotek); 
	
	//funkcja prawo/lewo
	function naviClick(licznik) 
	{ 
		clearInterval (interv); 
		$('.cmsJQGNaviLinks').removeClass('cmsJQChosen'); 
		$('.cmsJQGNaviLinks').eq(licznik).addClass('cmsJQChosen');
		setSize(licznik, img); 
		var szerokosc = tbSize[0]; 
		var wysokosc = tbSize[1];  
		var szerokoscPictStyl = tbSize[2];  
		var wysokoscPictStyl = tbSize[3]; 
		var pozXzdjecia = tbSize[4]; 
		var pozYzdjecia = tbSize[5]; 
		var pozXdivStyl = tbSize[6]; 
		var pozYdivStyl = tbSize[7] ; 
		var pozXdiv = tbSize[8]; 
		var pozYdiv = tbSize[9]; 
		pozYdivStylNavi = (parseInt (pozYdiv-wysokosc))+'px'; 
		pozXdivStylNavi = (parseInt (pozXdiv-szerokosc))+'px'; 
		$('.cmsJQPict img').attr('src',listaFotek[licznik]).animate({'width':szerokosc, 'height':wysokosc}); 
		$('.cmsJQPict').animate({ 'top':pozYdiv, 'left':pozXdiv ,'width':szerokoscPictStyl,'height':wysokoscPictStyl});
		$('.cmsJQPict img').animate ({ 'left':0,'top' :0 });
		if(listaFotekAlt[licznik]!='')
			$('#cmsJQText').css('width',szerokoscPictStyl);
		else
			$('#cmsJQText').css('width',0);
		$('#cmsJQText').text(listaFotekAlt[licznik]);
		//alert(listaFotekAlt[licznik]);
		return licznik ; 
	}
			
//wyswietlanie diva ze zdjeciem i zwiazane z tym eventy ;)
$('a[@rel*=jquery]').click (function(){
	var jqFotoIndex = $('a[@rel*=jquery]').index(this); 
	licznik = jqFotoIndex; 
	setSize(licznik, img); 
	//alert($(this).attr('class'));
	var wybranaKlasa = $(this).attr('class');
	pobierzObrazyRel(wybranaKlasa);
	//alert(tbSize); ";
	var szerokosc = tbSize[0]; 
	var wysokosc = tbSize[1];  
	var szerokoscPictStyl = tbSize[2];  
	var wysokoscPictStyl = tbSize[3];  
	var pozXzdjecia = tbSize[4];   
	var pozYzdjecia = tbSize[5];   
	var pozXdivStyl = tbSize[6];  
	var pozYdivStyl = tbSize[7] ; 
	var pozXdiv = tbSize[8]; 
	var pozYdiv = tbSize[9];  
	var tloGalerii = '<div class="cmsJQG">';
	tloGalerii += '<div class="cmsJQNavi" style="position: absolute; width:'+szerokoscEkranu+'">';
	tloGalerii += '<div class="cmsJQGTools">';
	tloGalerii += '<a href="#" id="cmsJQToolsLeft"><</a><a href="#" id="cmsJQToolsRight">></a><a href="#" id="cmsJQToolsPlay">play</a><a href="#" id="cmsJQGClose">X</a>';  
	tloGalerii += '</div>'; 
	tloGalerii += '<div class="cmsJQGLinks">';
	for(i=0;i<listaFotek.length;i++)
	{ 
		{var link = '<a href="'+listaFotek[i]+'" class="cmsJQGNaviLinks">'+nr+'</a>'; 
		nr++; 
		tloGalerii += link; 
		}
	} 
	nr=1; 
	tloGalerii += '</div>'; 
	tloGalerii += '</div>'; 
	tloGalerii += '<div class="cmsJQPict" style="width:'+szerokoscPictStyl+';height:'+wysokoscPictStyl+';top:'+pozYdivStyl+';left:'+pozXdivStyl+';">';
	tloGalerii += '<div id="cmsJQText" style="position:absolute;top:'+wysokoscPictStyl+';"></div>';
//	tloGalerii += '</div>';
	tloGalerii += '</div>';
	tloGalerii += '<div class="cmsJQBack" style ="width:'+szerokoscEkranu+'; height:'+wysokoscEkranu+';"></div>'; 
	tloGalerii += '</div>'; 
			
	//dodanie diva ze zdjeciem do html
	$('body').append(tloGalerii); 
	$('.cmsJQPict').append('<img src =" '+$(this).attr('href')+'" style="left:pozXzdjecia;top:pozYzdjecia"/>');
	//$('#cmsJQText').append('');  //
	$('.cmsJQPict img').css ('left',0).css ('top',0); 
	$('.cmsJQPict').fadeIn ('slow');  
	$('.cmsJQGNaviLinks').eq(licznik).addClass('cmsJQChosen'); 
	if(listaFotekAlt[licznik]!='')
		$('#cmsJQText').css('width',szerokoscPictStyl);
	else
		$('#cmsJQText').css('width',0);
	$('#cmsJQText').text(listaFotekAlt[licznik]);
	//nawigacja lewy przycisk
	$('.cmsJQNavi #cmsJQToolsLeft').click(function(){ if(licznik==0){licznik=listaFotek.length-1;}else{licznik--;}; 
	naviClick(licznik); 
}); 
	//nawigacja prawy przycisk
	$('.cmsJQNavi #cmsJQToolsRight').click(function(){ if(licznik==listaFotek.length-1){licznik=0;}else{licznik++;}; 
	naviClick(licznik); 
}); 
$('.cmsJQGNaviLinks').click(function(){  
	clearInterval (interv); 
	var Index = $('.cmsJQGNaviLinks').index(this); 
	$('.cmsJQGNaviLinks').removeClass('cmsJQChosen'); 
	$(this).addClass('cmsJQChosen');
	licznik = Index; 
	
	setSize(licznik, img); 
	var szerokosc = tbSize[0]; 
	var wysokosc = tbSize[1];  
	var szerokoscPictStyl = tbSize[2];  
	var wysokoscPictStyl = tbSize[3];  
	var pozXzdjecia = tbSize[4];   
	var pozYzdjecia = tbSize[5];   
	var pozXdivStyl = tbSize[6];  
	var pozYdivStyl = tbSize[7] ; 
	var pozXdiv = tbSize[8]; 
	var pozYdiv = tbSize[9]; 
	$('.cmsJQPict img').attr('src',listaFotek[licznik]).animate({'width':szerokosc, 'height':wysokosc}); 
	$('.cmsJQPict').animate({ 'top':pozYdiv, 'left':pozXdiv ,'width':szerokoscPictStyl,'height':wysokoscPictStyl});
	$('.cmsJQPict img').animate ({ 'left':0,'top' :0 }); 
	if(listaFotekAlt[licznik]!='')
		$('#cmsJQText').css('width',szerokoscPictStyl);
	else
		$('#cmsJQText').css('width',0);
	$('#cmsJQText').text(listaFotekAlt[licznik]);
	licznik = Index; 
	return false; 
}); 
$('#cmsJQToolsPlay').click(function(){ }).toggle(function(){interv = setInterval(pokaz,3000);$('#cmsJQToolsPlay').text('stop');}, function(){clearInterval (interv);$('#cmsJQToolsPlay').text('play');}); 
$('#cmsJQGClose').click(function(){ $('.cmsJQBack').remove(); $('.cmsJQPict').remove();$('.cmsJQNavi').remove(); clearInterval (interv);}); 
$('.cmsJQPict img').click(function(){ $('.cmsJQBack').remove(); $('.cmsJQPict').remove();$('.cmsJQNavi').remove(); clearInterval (interv);});  
			
//koniec sekcji div i wydarzenia z nim zwiazane
return false;});
}); 