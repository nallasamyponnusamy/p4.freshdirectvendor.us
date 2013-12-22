<!--
//var loaddisplaystatustext = "&nbsp;&nbsp;&nbsp;&nbsp;<img src='/scripts/ajaxtabs/images/loading.gif' /> Processing..."
var loaddisplaystatustext = "<div id='loading'>Processing...</div>"

// dynamically loads javascript and css files from AJAX calls
// ==========================================================
function loadjscssfile(filename, filetype){
    if (filetype=="js"){ //if filename is a external JavaScript file
    var fileref=document.createElement('script')
    fileref.setAttribute("type","text/javascript")
    fileref.setAttribute("src", filename)
    }
else if (filetype=="css"){ //if filename is an external CSS file
    var fileref=document.createElement("link")
    fileref.setAttribute("rel", "stylesheet")
    fileref.setAttribute("type", "text/css")
    fileref.setAttribute("href", filename)
    }
if (typeof fileref!="undefined")
  document.getElementsByTagName("head")[0].appendChild(fileref)
}

var filesadded=""; //list of files already added

function checkloadjscssfile(filename, filetype)
{
	if (filesadded.indexOf("["+filename+"]")==-1)
	{
        loadjscssfile(filename, filetype)
        filesadded+="["+filename+"]" //List of files added in the form "[filename1],[filename2],etc"
        } //else
//alert("file already added!")
}
// ==========================================================

// checks if a browser is AJAX combatible
// ======================================
function GetXmlHttpObject()
{
    var xmlHttp=null;
    try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
catch (e)
 {
     //Internet Explorer
     try
     {
     xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
     }
catch (e)
  {
      xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
}
return xmlHttp;
}
// ======================================

// greys out screen while executing server code
function onRequestStart(sender, arguments)   
{
    grayOut(true, "");
    }

function onResponseEnd(sender, arguments)  
{
    grayOut(false, "");
    }

function grayOut(vis, options)   
{
    var optionsoptions = options || {};
var zindex = options.zindex || 50;
var opacity = options.opacity || 70;
var opaque = (opacity / 100);
var bgcolor = options.bgcolor || '#000000';
var dark=document.getElementById('darkenScreenObject');

	if (!dark)   
	{  
		// The dark layer doesn't exist, it's never been created.  So we'll
// create it here and apply some basic styles.
//var tbody = document.getElementsByTagName("body")[0];
		var tbody = document.getElementById('mainContent');
		var tnode = document.createElement('div'); 
		tnode.style.position='absolute';  
		tnode.style.top='0px';  
		tnode.style.left='0px'; 
		tnode.style.overflow='hidden';  
		tnode.style.display='none'; 
		tnode.innerHTML = loaddisplaystatustext;
		tnode.id='darkenScreenObject';  
		tbody.appendChild(tnode);  
		dark=document.getElementById('darkenScreenObject');
	}
 
	if (vis)  
	{
		var pageWidth='100%';   
		var pageHeight='100%';   
		dark.style.opacity=opaque;   
		dark.style.MozOpacity=opaque; 
		dark.style.filter='alpha(opacity='+opacity+')';   
		dark.style.zIndex=zindex;  
		dark.style.backgroundColor=bgcolor;   
		dark.style.width= pageWidth;
		dark.style.height= pageHeight;   
		dark.style.display='block';
	} else  
	{
		dark.style.display='none';   
	}
}

function rld()
{
	document.location.reload()
}
//-->