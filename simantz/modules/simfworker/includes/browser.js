//---- Set this variable only! ----
var buildDir = "includes/";
//---------------------------------

var ie4 = false, ie5_mac = false, ie55 = false;
var nn4 = false, dom = false, opera = false, safari = false;
var agent = navigator.userAgent.toLowerCase();

if (agent.indexOf("opera") != -1)
	opera = true;
else if (agent.indexOf("safari") != -1)
	safari = true;
else if (document.all)
{
	var version = parseFloat(agent.substr(agent.indexOf("msie")+5, 3));
	if (agent.indexOf("mac") != -1 && version >= 5)
		ie5_mac = true;
	else
	{
		if (version >= 5.5)
			ie55 = true;
		else if (version >= 4)
			ie4 = true;
	}
}
//else if (document.layers)
else if (navigator.appName == "Netscape" && parseInt(navigator.appVersion) >= 4 && 
	parseInt(navigator.appVersion) < 5)
	nn4 = true;
else if (document.getElementById)
	dom = true;

var blank = new Image();
blank.src = buildDir + "blank.gif";

if (ie4)
	document.write('<script type="text/javascript" src="' + buildDir + 'ie4-build.js"></script>');
else if (ie5_mac)
	document.write('<script type="text/javascript" src="' + buildDir + 'ie5m-build.js"></script>');
else if (ie55)
	document.write('<script type="text/javascript" src="' + buildDir + 'ie55-build.js"></script>');
else if (nn4)
	document.write('<script type="text/javascript" src="' + buildDir + 'ns4-build.js"></script>');
else if (dom)
	document.write('<script type="text/javascript" src="' + buildDir + 'dom-build.js"></script>');
else if (opera)
	document.write('<script type="text/javascript" src="' + buildDir + 'op7-build.js"></script>');
else if (safari)
	document.write('<script type="text/javascript" src="' + buildDir + 'saf-build.js"></script>');
else
{
	alert("Your browser doesn't support this script.");
	location.href = buildDir + "upgrade.html";
	document.write('<script type="text/javascript" src="' + buildDir + 'no-build.js"></script>');
}