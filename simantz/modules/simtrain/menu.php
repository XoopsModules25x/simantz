<?php
	include_once ('../../mainfile.php');
	include_once 'class/Permission.php';
	include_once 'class/Log.php';


	$url=XOOPS_URL;
	$module_id=$xoopsModule->getVar('mid');
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$userid=$xoopsUser->getVar('uid');
	$log = new Log();
	$o = new Permission($xoopsDB,$tableprefix,$log,$module_id);
	$o->generateMenu($userid,$module_id);
	global $xoopsUser;


	//if(!$xoopsUser)
	//	redirect_header($url,2,"<b style='color:red'>Session expired, please relogin.</b>");
	//else
	$uname=$xoopsUser->getVar('uname');
	$sql="SELECT count(msg_id) as count FROM $tableprefix" . "priv_msgs where to_userid=$userid AND read_msg=0";
	$row=$xoopsDB->fetchArray($xoopsDB->query($sql));
	$count=$row['count'];
	//echo "<div>Welcome $uname</div>";

	include_once 'class/Organization.php';
	$org=new Organization($xoopsDB, $tableprefix,$log,$ad);
	$orgctrl=$o->selectionOrg($uid,$defaultorganization_id,$showNull='N','Y');

	echo "
	<div style='border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);'>
		<big><big><big>
		<span style='font-weight: bold;text-align:left'>$menuname </span> 
		<span style='text-align:right;'><strong>/ Organization $orgctrl</strong></span>
		</big></big></big></div><br>";
	//echo "<big><span style='font-weight: bold;text-align:left'>$menuname /</span> <strong>Default Organization:</strong></big> $orgctrl<br>";

/*
	menus[1].addItem(url+'/races.php', "", 22, "left", "Races", 0);
	menus[1].addItem(url+'/school.php', "", 22, "left", "School", 0);
	menus[1].addItem(url+'/standard.php', "", 22, "left", "Standard", 0);
	menus[1].addItem(url+'/employee.php', "", 22, "left", "Employee", 0);
	menus[1].addItem(url+'/student.php', "", 22, "left", "Student", 0);
	menus[1].addItem(url+'/category.php', "", 22, "left", "Category", 0);
	menus[1].addItem(url+'/product.php', "", 22, "left", "Products", 0);
	menus[1].addItem(url+'/area.php', "", 22, "left", "Area", 0);
	menus[1].addItem(url+'/transport.php', "", 22, "left", "Transport Charge", 0);
	menus[1].addItem(url+'/period.php', "", 22, "left", "Period", 0);

	menus[2].addItem(url+'/tuitionclass.php', "", 22, "left", "Add/Edit Tuition Class", 0);
	menus[2].addItem(url+'/regclass.php', "", 22, "left", "Tuition Class Registration", 0);
	menus[2].addItem(url+'/regattendance.php', "", 22, "left", "Register Attendance", 0);
	menus[2].addItem(url+'/inventorymovement.php', "", 22, "left", "In/Out Stock", 0);
	menus[2].addItem(url+'/regproduct.php', "", 22, "left", "Other Sales", 0);
	menus[2].addItem(url+'/payment.php', "", 22, "left", "Payment", 0);
	menus[2].addItem(url+'/listpayment.php', "", 22, "left", "Payment History", 0);
	menus[2].addItem(url+'/cashtransfer.php', "", 22, "left", "Cash Transfer", 0);
	menus[2].addItem(url+'/listcashtransfer.php', "", 22, "left", "Cash Transfer History", 0);

	menus[3].addItem(url+'/attendance.php', "", 22, "left", "Attendance Check List", 0);
	menus[3].addItem(url+'/liststock.php', "", 22, "left", "On Hand Stock Report", 0);
	menus[3].addItem(url+'/listtuitionclass.php', "", 22, "left", "Fees Report(By Class)", 0);
	menus[3].addItem(url+'/classothersales.php', "", 22, "left", "Registration & In/Out Sales Report", 0);
	menus[3].addItem(url+'/outstandingpayment.php', "", 22, "left", "Outstanding Payment Report", 0);
	menus[3].addItem(url+'/viewdayincome.php', "", 22, "left", "Payment Receiving Report (By Student / User)", 0);
	menus[3].addItem(url+'/viewproductincome.php', "", 22, "left", "Fees Collection Report(By Product)", 0);

	menus[3].addItem(url+'/viewcategoryincome.php', "", 22, "left", "Payment Receiving Report (By Category)", 0);
	menus[3].addItem(url+'/pickup.php', "", 22, "left", "Pick Up List", 0);
	menus[3].addItem(url+'/performancerpt_center.php', "", 22, "left", "Center Performance Report", 0);
	menus[3].addItem(url+'/performancerpt_tutor.php', "", 22, "left", "Tutor Performance Report", 0);
*/
echo <<< EOF

<script type='text/javascript'>
function init()
{
	url='$url/modules/simtrain/';
	//Main Menu items:
	menus[0] = new menu(22, "horizontal", 0, 0, -2, -2, "#CACAFF", "#0000A0", "Arial,Helvetica", 8, 
		"bold", "bold", "black", "white", 0, "gray", 1, "rollover:images/tri-down1.gif:images/tri-down2.gif", false, true, true, false, 0, true, 3, 3, "gray");
	menus[0].addItem(url, "", 100, "center", "Home", 0);
	menus[0].addItem("#", "", 120, "center", "Master Data", 1);
	menus[0].addItem("#", "", 100, "center", "Transaction", 2);
	menus[0].addItem("#", "", 110, "center", "Reports", 3);
	menus[0].addItem("#", "", 110, "center", "Supports", 4);
	menus[0].addItem("../../viewpmsg.php", "", 210, "center", "$uname Inbox($count)", 0);


//Sub Menu for 2nd Main Menu Item ("Master"):
	menus[1] = new menu(300, "vertical", 0, 0, -5, -5, "#CACAFF", "#0000A0", "Arial,Helvetica", 8, "bold", 
		"bold", "black", "white", 1, "gray", 1, 62, false, true, false, true, 6, true, 4, 4, "black");
	$o->mastermenu

//Sub Menu for 3rd Main Menu Item ("Transaction"):
	menus[2] = new menu(300, "vertical", 0, 0, -5, -5, "#CACAFF", "#0000A0", "Arial,Helvetica", 8, "bold", 
		"bold", "black", "white", 1, "gray", 1, 62, false, true, false, true, 6, true, 4, 4, "black");
	$o->transactionmenu


//Sub Menu for 4th Main Menu Item ("Reports"):
	menus[3] = new menu(350, "vertical", 0, 0, -5, -5, "#CACAFF", "#0000A0", "Arial,Helvetica", 8, "bold", 
		"bold", "black", "white", 1, "gray", 1, 62, false, true, false, true, 6, true, 4, 4, "black");
	$o->reportmenu

//Sub Menu for 4th Main Menu Item ("Reports"):
	menus[4] = new menu(300, "vertical", 0, 0, -5, -5, "#CACAFF", "#0000A0", "Arial,Helvetica", 8, "bold", 
		"bold", "black", "white", 1, "gray", 1, 62, false, true, false, true, 6, true, 4, 4, "black");
	menus[4].addItem('./admin/window.php', "", 22, "left", "Add Windows", 0);
	menus[4].addItem('aboutus.php', "", 22, "left", "About Us", 0);
	menus[4].addItem('license.txt', "", 22, "left", "License under GNU/GPL V3", 0);
	menus[4].addItem('changelog.php', "", 22, "left", "Change Log", 0);

	showHideMenu();
	try {
	autofocus();
	}catch (error) {
	}
	//autofocus();
} //OUTER CLOSING BRACKET. EVERYTHING ADDED MUST BE ABOVE THIS LINE.

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

</script>
EOF;
?>

