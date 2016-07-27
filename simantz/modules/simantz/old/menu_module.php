<?php


	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	include_once ('../../mainfile.php');
	include_once 'class/Permission.php';
//	include_once '../system/class/Log.php';
//	include_once '../themes/default/style.css';
        include_once "../simantz/class/datepicker/class.datepicker.php";

        $url=XOOPS_URL."/modules/simantz";
	$module_id=$xoopsModule->getVar('mid');
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$userid=$xoopsUser->getVar('uid');
        $user=$xoopsUser->getVar('uname');

	$log = new Log();
	$o = new Permission($xoopsDB,$tableprefix,$log,$module_id);

	$menulist = $o->generateMenu($userid,$module_id);
        $menulist = str_replace( array("\r\n", "\n","\r"), "", $menulist );
        
	include_once '../simantz/class/SelectCtrl.inc.php';
	$ctrl=new SelectCtrl();

	$orgwhereaccess=$permission->orgWhereStr($userid);
	$orgctrl=$ctrl->selectionOrg($userid,$defaultorganization_id,$showNull='N');
	$curr_date = getDateSession($curr_date);
        
        $sql="SELECT employee_name FROM sim_simedu_employee WHERE uid=$userid";
        $query=$xoopsDB->query($sql);
        if($row=$xoopsDB->fetchArray($query)) $user=$row['employee_name'];

	echo "
	<div id='pagetitle'>Dear $user, you are now in the $menuname</div><br>";
        
echo <<< EOF
<script src="../simantz/include/sframe.js" type="text/javascript"></script>

<link rel="stylesheet" href="../simantz/include/stylemenu.css" type="text/css" />
<script type="text/javascript" src="../../modules/system/class/gui/oxygen/js/menu.js"></script>


<script type='text/javascript'>
    try {
    document.getElementById('xo-globalnav').innerHTML = "$menulist";
    var menu=new menu.dd("menu");
    menu.init("menu","menuhover");
    }catch (error) {
    }


        
        
function init()
{

        /*
	url="$url/modules/hea";
	//Main Menu items:
	menus[0] = new menu(20, "horizontal", 0, 86, -2, -2, "#eef15c", "#df6e01", "Arial,Helvetica", 8,
		"bold", "bold", "black", "white", 0, "gray", 1, "rollover:images/tri-down1.gif:images/tri-down2.gif", false, true, true, false, 0, true, 3, 3, "gray");
	menus[0].addItem(url, "", 100, "center", "Home", 0);
	menus[0].addItem("#", "", 120, "center", "Master Data", 1);
	menus[0].addItem("#", "", 100, "center", "Transaction", 2);
	menus[0].addItem("#", "", 110, "center", "Reports", 3);
	//menus[0].addItem("#", "", 110, "center", "Supports", 4);

//Sub Menu for 2nd Main Menu Item ("Master"):
	menus[1] = new menu(300, "vertical", 0, 0, -5, -5, "#eef15c", "#df6e01", "Arial,Helvetica", 8, "bold",
		"bold", "black", "white", 1, "gray", 1, 62, false, true, false, true, 6, true, 4, 4, "black");
	$o->mastermenu

//Sub Menu for 3rd Main Menu Item ("Transaction"):
	menus[2] = new menu(300, "vertical", 0, 0, -5, -5, "#eef15c", "#df6e01", "Arial,Helvetica", 8, "bold",
		"bold", "black", "white", 1, "gray", 1, 62, false, true, false, true, 6, true, 4, 4, "black");
	$o->transactionmenu


//Sub Menu for 4th Main Menu Item ("Reports"):
	menus[3] = new menu(350, "vertical", 0, 0, -5, -5, "#eef15c", "#df6e01", "Arial,Helvetica", 8, "bold",
		"bold", "black", "white", 1, "gray", 1, 62, false, true, false, true, 6, true, 4, 4, "black");
	$o->reportmenu

//Sub Menu for 4th Main Menu Item ("Reports"):
	menus[4] = new menu(300, "vertical", 0, 0, -5, -5, "#eef15c", "#df6e01", "Arial,Helvetica", 8, "bold",
		"bold", "black", "white", 1, "gray", 1, 62, false, true, false, true, 6, true, 4, 4, "black");
	menus[4].addItem('aboutus.php', "", 22, "left", "About Us", 0);
	menus[4].addItem('license.txt', "", 22, "left", "License under GNU/GPL V3", 0);
	menus[4].addItem('changelog.php', "", 22, "left", "Change Log", 0);

	//showHideMenu();
	try {
	autofocus();
	}catch (error) {
	}
        */
} //OUTER CLOSING BRACKET. EVERYTHING ADDED MUST BE ABOVE THIS LINE.

var previousindexid=-1;
/*
var selectionfieldid;
var ;
var needreset=0;
setInterval("resetSelection()", 6000);

function resetSelection(){
//		alert(needreset+','+previousindexid+','+selectionfieldid);

	if(needreset==1){
		alert(needreset+','+previousindexid+','+selectionfieldid);
		document.getElementById(previousselectionfieldid).selectedIndex =previousindexid;
		data=	document.getElementById(previousselectionfieldid).selectedIndex;
		alert('reset data from: '+data+" to: "+previousindexid+' with controlfield:'+selectionfieldid);
		needreset=0;
		}
		
}
*/

  function changefield(e,ctrl,nextctrl,previousctrl){
  var keycode;
  if (window.event) keycode = window.event.keyCode;
  else if (e) keycode = e.which;
  //alert (keycode);
  switch(keycode){
 	case 38:
		document.frmProduction.getElementByName(nextctrl).setfocus();
	break;
	case 40:
		document.frmProduction.getElementByName(previousctrl).setfocus();

		
	break;
	default:
	break;
 } 
}

  function changearrayfield(e,ctrl,nextid,lastid,alternatectrl){
  var keycode;
  if (window.event) keycode = window.event.keyCode;
  else if (e) keycode = e.which;
  //alert (keycode);
	//alert(ctrl+nextid+lastid);

  switch(keycode){
 	case 119:
	//	document.getElementsByName(ctrl)[nextid].focus();
		newctrl=document.getElementById(ctrl+lastid);
		alternatectrl=document.getElementById(alternatectrl+lastid);
	//	alert(newctrl.value);

		if(newctrl.style.display=='')
		newctrl.focus();
		else
		alternatectrl.focus();

	break;
	case 120:

		newctrl=document.getElementById(ctrl+nextid);
		alternatectrl=document.getElementById(alternatectrl+nextid);
	//	alert(newctrl.value);

		try {

		if(newctrl.style.display=='')
		newctrl.focus();
		else
		alternatectrl.focus();

		}catch (error) {
		}

		
	break;
	default:
	break;
 } 
}

  function changearrayfieldEnter(e,ctrl,nextid,lastid,alternatectrl,fld){
  var keycode;
  if (window.event) keycode = window.event.keyCode;
  else if (e) keycode = e.which;
  //alert (keycode);
	//alert(ctrl+nextid+lastid);

  switch(keycode){
 	case 119:
	//	document.getElementsByName(ctrl)[nextid].focus();
		newctrl=document.getElementById(ctrl+lastid);
		alternatectrl=document.getElementById(alternatectrl+lastid);
	//	alert(newctrl.value);

		if(newctrl.style.display=='')
		newctrl.focus();
		else
		alternatectrl.focus();

	break;
	case 120:

		newctrl=document.getElementById(ctrl+nextid);
		alternatectrl=document.getElementById(alternatectrl+nextid);
	//	alert(newctrl.value);

		try {

		if(newctrl.style.display=='')
		newctrl.focus();
		else
		alternatectrl.focus();

		}catch (error) {
		}

		
	break;
	case 13:
		tabOnEnter (fld)
		//return keycode;
	break;
	default:
	break;
 } 
}

function tabOnEnter(fld){
	formfld = fld.form;
	
	var i = 0;
	while(i< fld.form.elements.length){
	var ctlname = fld.form.elements[i]; 
	//alert(fld.form.elements[i+1].style.display);
	if(ctlname == fld){
	//alert(fld.form.elements[i+1].style);
		try {
		while(fld.form.elements[i+1].type == "hidden" || fld.form.elements[i+1].type == "button" 
			|| fld.form.elements[i+1].style.display == "none"){
		i++;
		}
	
		fld.form.elements[i+1].focus();
		break;
		}catch (error) {
		break;
		}
		
	}

	i++;
	}
}



function IsNumeric(sText)
{
   var ValidChars = "0123456789.-";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }


function isDate(dateStr) {

	var datePat = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;
	var matchArray = dateStr.match(datePat); // is the format ok?

	if (matchArray == null) {
		alert("Please enter date as YYYY-MM-DD.");
		return false;
		}

	month = matchArray[4]; // p@rse date into variables
	day = matchArray[7];
	year = matchArray[1];

	if (month < 1 || month > 12) { // check month range
		alert("Month must be between 1 and 12.");
		return false;
	}

	if (day < 1 || day > 31) {
		alert("Day must be between 1 and 31.");
		return false;
	}

	if ((month==4 || month==6 || month==9 || month==11) && day==31) {
		alert("Month "+month+" doesn`t have 31 days!")
		return false;
	}

	if (month == 2) { // check for february 29th
		var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
		if (day > 29 || (day==29 && !isleap)) {
			alert("February " + year + " doesn`t have " + day + " days!");
			return false;
		}
	}
	return true; // date is valid
}


	function getRequest(arr_fld,arr_val){
	
		var http = GetXmlHttpObject();
		if (http==null)
		{
		alert ("Browser does not support HTTP Request")
		return
		}

		var url = "post.php";
		var params = "";
		var fld_php = "array(";
		var val_php = "array(";
		var length_arr = arr_fld.length;

		for (x=0; x<length_arr; x++){
		if(x>0)
		params = params + "&";
		params = params + arr_fld[x]+"="+arr_val[x]
		
		//string arr_fld
		fld_php = fld_php + "'" + arr_fld[x] + "'" ;
		
		if(x!=length_arr-1)		
		fld_php = fld_php + ",";
		else
		fld_php = fld_php + ")";

		//string arr_val
		val_php = val_php + "'" + arr_val[x] + "'" ;
		
		if(x!=length_arr-1)		
		val_php = val_php + ",";
		else
		val_php = val_php + ")";

		}
		
		params = params + "&str_fld=" + fld_php;
		params = params + "&str_val=" + val_php;
		//alert(params);

		http.open("POST", url, true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.setRequestHeader("Content-length", params.length);
		http.setRequestHeader("Connection", "close");
	
		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200) {
			document.getElementById('simit').innerHTML = http.responseText;
			document.frmValidate.submit();	
			}
		}
		http.send(params);
		
//		document.frmValidate.submit();
	
	}

	function GetXmlHttpObject(){
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
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		}
		return xmlHttp;
	}

	function firstPage(){
	}

function setSessionDate(value){

location.href='index.php?setSessionDate=Y&defaultDateSession='+value;
}



</script>



EOF;
?>


