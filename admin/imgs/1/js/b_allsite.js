// slideshow
var slideshow_item = 0;
var slideshow_time = 0;
var slideshow_endtime = 6000;
var slideshow_last = 0;
var slideshow_slides = new Array();
var slideshow_przerzuc = 0;
var slideshow_n = 0;

function slideshow_check()
{
  if (slideshow_time>slideshow_endtime && slideshow_slides[slideshow_n][2]==true)
  {
    lasts=slideshow_last;
    slideshow_przerzuc=false;
    slideshow_last=slideshow_n;
    $("#slideshow_slide"+slideshow_n).fadeIn("slow", function () {
      $(this).css({'z-index':7});
      $("#slideshow .items a").removeClass("active");
      $("#slideshow .items a").eq(slideshow_n).addClass("active");
      $("#slideshow .click a").attr("href",slideshow_slides[slideshow_n][0]);
      if (slideshow_slides[slideshow_n][3].length>0) slideshow_endtime=parseInt(slideshow_slides[slideshow_n][3])*1000;
      else slideshow_endtime=6000;
      slideshow_n+=1;
      if (slideshow_n==slideshow_slides.length) slideshow_n=0;
      $("#slideshow_slide"+slideshow_n).css({'z-index':8, 'display':'none'});
      if (slideshow_slides[slideshow_n][2]==false) 
      {
        $("#slideshow_slide"+slideshow_n).attr("src",slideshow_slides[slideshow_n][1]);
      }
      $("#slideshow_slide"+lasts).hide();      
    });
    slideshow_time=0;
  }
  else
    slideshow_time+=100;
}

function slideshow_slideloaded (ipd)
{
  slideshow_slides[ipd][2]=true;
}

function slideshow_change(cn)
{
  if (cn==-1)
  {
    if (slideshow_n>=2) slideshow_n-=2;
    else if (slideshow_n==1) slideshow_n=slideshow_slides.length-1;
    else slideshow_n=slideshow_slides.length-2;
    slideshow_slideload(slideshow_n);
  }
  else
  {
    slideshow_przerzuc=true;
    slideshow_time=slideshow_endtime;
  }  
}

function slideshow_slideload(cn)
{
  cn=parseInt(cn);
  if (cn!=slideshow_last)
  {
    if (slideshow_slides[cn][2]==false)
    {
      $("#slideshow_slide"+cn).attr("src",slideshow_slides[cn][1]);
    }
    slideshow_przerzuc=true;
    slideshow_time=slideshow_endtime;
    slideshow_n=cn;  
  }
  else
  {
    slideshow_time=0;
  }
}

function slideshow_begin()
{
  $("#slideshow .items").append($("<a href=\"#\" rel=\"0\">1</a>").click(function () { slideshow_slideload(0); }).addClass("active") );
  for (i=1;i<slideshow_slides.length;i++)
  {     
    var img = new Image();
    $(img).attr("id","slideshow_slide"+i);
    $(img).attr("title",i);
    if (i==0)
      $(img).css({'display':'block'});
    else
      $(img).css({'display':'none'});
    $(img).load( function () { 
      slideshow_slideloaded($(this).attr("title"));
    });
    $("#slideshow .slide_col").eq(0).append(img);
    $("#slideshow .items").append($("<a href=\"#\" rel=\""+i+"\">"+(i+1)+"</a>").click(function () { slideshow_slideload($(this).attr("rel")); }) );
  }
  
  slideshow_last=slideshow_slides.length-1;
  $("#slideshow .navi").show();
  slideshow_slides[0][2]=true;
  slideshow_timer_id = window.setInterval("slideshow_check()",100);
  slideshow_slideload(0);
}

function hotelfoto_loaded()
{
  var fotarr=$("#hotel_foto .hotel_fotos img");
  for (i=0;i<fotarr.length-1;i++) fotarr.eq(i).hide().remove();
  $("#hotel_foto .hotel_fotos img").eq(0).show();
  $("#hotel_foto .hotel_fotos div").hide();
}

function hotelfoto_change(link)
{
  $("#hotel_foto .hotel_fotos div").show();
  var img = new Image();
  $(img).load( function () { 
    hotelfoto_loaded();
  });
  $(img).attr("src",link);
  $(img).css({'display':'none'});
  $("#hotel_foto .hotel_fotos").eq(0).append(img);
}


function fotoview_change(link,title)
{
  $("#hotel_foto .hotel_fotos div").show();
  var img = new Image();
  $(img).load( function () { 
    hotelfoto_loaded();
  });
  $(img).attr("src",link);
  $(img).css({'display':'none'});
  $("#hotel_foto .hotel_fotos").eq(0).append(img);
  $("#hotel_foto .hotel_fotoview_desc").html(title);
}


function hotelmapa_show()
{
  if ($("#hotel_mapa").css('display')=='none')
  {
    $("#hotel_mapa").slideDown("normal", function (){
      $("#mapa_googla").show();
      load_google_map();
    });  
  }
  else
  {
    $("#mapa_googla").hide();
    $("#hotel_mapa").slideUp();
  }
}

function form_submit(_id)
{
	obj=document.getElementById(_id);
	if (obj!=null) obj.submit();	
}

function hotel_podstrona(ajdi,lp)
{
  $("#podstrony .podstrona").hide();
  $("#atrakcje_regionu_div").hide();
  $("#"+ajdi).show();
  $("#podstrony_zakladki .zakladka").removeClass("active").addClass("noactive");
  $("#podstrony_zakladki .zakladka").eq(lp).addClass("active").removeClass("noactive");
  if (lp==0)
  {
    $("#hotel_foto .hotel_fotos").show();
    $("#hotel_foto .hotel_fotosy_one").show();
    $("#hotel_foto .hotel_fotosy_more").hide();
  }
  else if (lp==1)
  {
    $("#hotel_foto .hotel_fotos").show();
    $("#hotel_foto .hotel_fotosy_one").hide();
    $("#hotel_foto .hotel_fotosy_more").show();
  }
  else if (lp==2)
  {
    $("#hotel_foto .hotel_fotos").show();
    $("#hotel_foto .hotel_fotosy_one").hide();
    $("#hotel_foto .hotel_fotosy_more").hide();
    $("#atrakcje_regionu_div").show();
  }
  else if (lp==3)
  {
    $("#hotel_foto .hotel_fotos").hide();
    $("#hotel_foto .hotel_fotosy_one").hide();
    $("#hotel_foto .hotel_fotosy_more").hide();
  }
}

function fanslajd(zak)
{
  speed=1000;
  
  zakladka=1;
  if (parseInt($("#fanslajd .fanslajd_2").css('left'))<460) zakladka=2;
  if (parseInt($("#fanslajd .fanslajd_3").css('left'))<500) zakladka=3;
  
  if (zak==1) 
  {
    $("#fanslajd .fanslajd_4").animate({ left: "505px" }, speed );
    $("#fanslajd .fanslajd_3").animate({ left: "470px" }, speed, function () { $("#fanslajd_mapka").show(); } );
  }
  
  if (zak==2) 
  {
    $("#fanslajd .fanslajd_3").animate({ left: "35px" }, speed );
    $("#fanslajd .fanslajd_4").animate({ left: "505px" }, speed );
  }
  
  if (zak==3) 
  {
    $("#fanslajd .fanslajd_3").animate({ left: "35px" }, speed );
    $("#fanslajd .fanslajd_4").animate({ left: "70px" }, speed );
  }
}

function zwijany(ajdi,uimg)
{
  if ($('#'+ajdi+' .info').css('display')=='block')
  {
    $('#'+ajdi+' .info').slideUp();
    $('#'+ajdi+' .arr').attr('src',uimg+'zwijany_off.gif');
  }
  else
  {
    $('#'+ajdi+' .info').slideDown();
    $('#'+ajdi+' .arr').attr('src',uimg+'zwijany_on.gif');
  }
}

function czat_online()
{
  var Win = window.open('http://chat.livechatinc.net/licence/180200/open_chat.cgi?groups=0'+'&s=1&lang=pl&params='+escape('strona=ScanHoliday'),'czatonline','width=604,height=247,resizable=no,scrollbars=no,status=1');
}

function katalog_popup(link)
{
  var Win = window.open(link,'katalogonline','width=984,height=787,resizable=no,scrollbars=no,status=1');
}