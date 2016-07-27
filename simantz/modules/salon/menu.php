<?php
	include_once ('../../mainfile.php');
	$url=XOOPS_URL;
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tablewindowsgroup=$tableprefix . "simsalon_tblwindowsgroup";
	$tablewindows=$tableprefix . "simsalon_tblwindows";
	$tablegroups_users_link=$tableprefix . "groups_users_link";
	$uid = $xoopsUser->getVar('uid');


	if($uid!=""){

	$sqlmaster =	"SELECT * from $tablewindowsgroup a, $tablegroups_users_link b, $tablewindows c
			WHERE b.uid = $uid
			AND a.groupid = b.groupid
			AND a.windows_id = c.windows_id
			AND a.isaccess = 1
			AND c.windows_type = 'M' 
			GROUP BY c.windows_id order by CAST(c.windows_no AS SIGNED) asc ";
	
	$query=$xoopsDB->query($sqlmaster);
	$window_name = "";
	while($row=$xoopsDB->fetchArray($query)){
	$file = $row['windows_filename'];
	$name = $row['windows_name'];
	
	$window_master .=  "menus[1].addItem(url+'/$file', '', 22, 'left', \"$name\", 0);";
	}


	$sqltransaction ="SELECT * from $tablewindowsgroup a, $tablegroups_users_link b, $tablewindows c
			WHERE b.uid = $uid
			AND a.groupid = b.groupid
			AND a.windows_id = c.windows_id
			AND a.isaccess = 1
			AND c.windows_type = 'T' 
			GROUP BY c.windows_id order by CAST(c.windows_no AS SIGNED) asc ";
	
	$query=$xoopsDB->query($sqltransaction);
	$window_name = "";
	while($row=$xoopsDB->fetchArray($query)){
	$file = $row['windows_filename'];
	$name = $row['windows_name'];
	
	$window_transaction .=  "menus[2].addItem(url+'/$file', '', 22, 'left', \"$name\", 0);";
	}

	$sqlreport ="SELECT * from $tablewindowsgroup a, $tablegroups_users_link b, $tablewindows c
			WHERE b.uid = $uid
			AND a.groupid = b.groupid
			AND a.windows_id = c.windows_id
			AND a.isaccess = 1
			AND c.windows_type = 'R' 
			GROUP BY c.windows_id order by CAST(c.windows_no AS SIGNED) asc ";
	
	$query=$xoopsDB->query($sqlreport);
	$window_name = "";
	while($row=$xoopsDB->fetchArray($query)){
	$file = $row['windows_filename'];
	$name = $row['windows_name'];
	
	$window_report .=  "menus[3].addItem(url+'/$file', '', 22, 'left', \"$name\", 0);";
	}

	}

echo <<< EOF
<script type='text/javascript'>
function init()
{
	url='$url/modules/salon/';
	//Main Menu items:
	menus[0] = new menu(22, "horizontal", 0, 0, -2, -2, "#CACAFF", "#0000A0", "Times", 9, 
		"bold", "bold", "black", "white", 1, "gray", 2, "rollover:images/tri-down1.gif:images/tri-down2.gif", false, true, true, true, 12, true, 4, 4, "black");
	menus[0].addItem(url, "", 100, "center", "Home", 0);
	menus[0].addItem("#", "", 120, "center", "Master Data", 1);
	menus[0].addItem("#", "", 100, "center", "Transaction", 2);
	menus[0].addItem("#", "", 110, "center", "Reports", 3);
	menus[0].addItem("#", "", 110, "center", "Supports", 4);

//Sub Menu for 2nd Main Menu Item ("Master"):
	menus[1] = new menu(300, "vertical", 0, 0, -5, -5, "#CACAFF", "#0000A0", "Times", 9, "bold", 
		"bold", "black", "white", 1, "gray", 2, 62, false, true, false, true, 6, true, 4, 4, "black");

	$window_master
	/*
	menus[1].addItem(url+'/stafftype.php', "", 22, "left", "Employee Type", 0);
	menus[1].addItem(url+'/employee.php', "", 22, "left", "Employee", 0);
	menus[1].addItem(url+'/customertype.php', "", 22, "left", "Customer Type", 0);
	menus[1].addItem(url+'/customer.php', "", 22, "left", "Customer", 0);
	menus[1].addItem(url+'/terms.php', "", 22, "left", "Terms", 0);
	menus[1].addItem(url+'/uom.php', "", 22, "left", "Unit Of Measurement", 0);
	menus[1].addItem(url+'/category.php', "", 22, "left", "Product Category", 0);
	menus[1].addItem(url+'/product.php', "", 22, "left", "Product List", 0);
	menus[1].addItem(url+'/expensescategory.php', "", 22, "left", "Expenses Category", 0);
	menus[1].addItem(url+'/expenseslist.php', "", 22, "left", "Expenses List", 0);
	menus[1].addItem(url+'/promotion.php', "", 22, "left", "Promotion Package", 0);
	menus[1].addItem(url+'/commission.php', "", 22, "left", "Commission", 0);
	menus[1].addItem(url+'/vendor.php', "", 22, "left", "Vendor", 0);
	menus[1].addItem(url+'/leave.php', "", 22, "left", "Leave", 0);
	*/
	
	

//Sub Menu for 3rd Main Menu Item ("Transaction"):
	menus[2] = new menu(300, "vertical", 0, 0, -5, -5, "#CACAFF", "#0000A0", "Times", 9, "bold", 
		"bold", "black", "white", 1, "gray", 2, 62, false, true, false, true, 6, true, 4, 4, "black");
	/*
	menus[2].addItem(url+'/payment.php', "", 22, "left", "Sales (Payment)", 0);
	menus[2].addItem(url+'/payroll.php', "", 22, "left", "Payroll", 0);
	menus[2].addItem(url+'/expenses.php', "", 22, "left", "Expenses", 0);
	menus[2].addItem(url+'/vinvoice.php', "", 22, "left", "Vendor Invoice", 0);
	menus[2].addItem(url+'/internal.php', "", 22, "left", "Internal Use", 0);
	menus[2].addItem(url+'/adjustment.php', "", 22, "left", "Adjustment", 0);
//	menus[2].addItem(url+'/cservice.php', "", 22, "left", "Customer Service", 0);
	*/
	
	$window_transaction


//Sub Menu for 4th Main Menu Item ("Reports"):
	menus[3] = new menu(350, "vertical", 0, 0, -5, -5, "#CACAFF", "#0000A0", "Times", 9, "bold", 
		"bold", "black", "white", 1, "gray", 2, 62, false, true, false, true, 6, true, 4, 4, "black");
	/*
	menus[3].addItem(url+'/profitnloss.php', "", 22, "left", "Profit & Loss Statement", 0);
	menus[3].addItem(url+'/liststockrpt.php', "", 22, "left", "On Hand Stock Report", 0);
	menus[3].addItem(url+'/salary.php', "", 22, "left", "Performance Summary Report", 0);
	*/
	$window_report
//	menus[3].addItem(url+'/promotionexprpt.php', "", 22, "left", "Promotion Expiration Report", 0);
//	menus[3].addItem(url+'/salesturnoverrpt.php', "", 22, "left", "Sales Turnover", 0);
	
//	menus[3].addItem(url+'/viewdayincome.php', "", 22, "left", "Payment Receiving Report (By Student / User)", 0);
//	menus[3].addItem(url+'/viewproductincome.php', "", 22, "left", "Fees Collection Report(By Product)", 0);
//	menus[3].addItem(url+'/viewcategoryincome.php', "", 22, "left", "Payment Receiving Report (By Category)", 0);
//	menus[3].addItem(url+'/pickup.php', "", 22, "left", "Pick Up List", 0);
//	menus[3].addItem(url+'/performancerpt_center.php', "", 22, "left", "Center Performance Report", 0);
//	menus[3].addItem(url+'/performancerpt_tutor.php', "", 22, "left", "Tutor Performance Report", 0);

//Sub Menu for 4th Main Menu Item ("Supports"):
	menus[4] = new menu(300, "vertical", 0, 0, -5, -5, "#CACAFF", "#0000A0", "Times", 9, "bold", 
		"bold", "black", "white", 1, "gray", 2, 62, false, true, false, true, 6, true, 4, 4, "black");
//	menus[4].addItem(url+'/clone.php', "", 22, "left", "Clone Transaction", 0);
	menus[4].addItem('aboutus.php', "", 22, "left", "About Us", 0);
	menus[4].addItem('license.txt', "", 22, "left", "License under GNU/GPL V3", 0);
	menus[4].addItem('changelog.php', "", 22, "left", "Change Log", 0);


	try {
	autofocus();
	}catch (error) {
	}
	
//	hideMenu();
	
} //OUTER CLOSING BRACKET. EVERYTHING ADDED MUST BE ABOVE THIS LINE.

function IsNumeric(sText)
{
   var ValidChars = "0123456789.-";
   var IsNumber=true;
   var Char;

   if(sText==""){
	return false;
   }else{
		
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


	function parseelement(thisone){

	var prefix=""
	var wd
	
	if (thisone.value.charAt(0)=="$")
		return
		
	wd="w"
	var tempnum=thisone.value
	for (i=0;i<tempnum.length;i++){
	
			if (tempnum.charAt(i)=="."){
			wd="d"
			break
			}
	}
	//alert(wd);
	if (wd=="w")
		thisone.value=prefix+tempnum+".00"
	else{
		if (tempnum.charAt(tempnum.length-2)=="."){
		thisone.value=prefix+tempnum+"0"
		}else{
		tempnum=Math.round(tempnum*100)/100
		thisone.value=prefix+tempnum
		}
		
		
		/*
		tempnum=Math.round(tempnum*100)/100
		thisone.value=prefix+tempnum
		*/
	}
	
	}

	function currencyFormat(NumVal){

	var prefix=""
	var wd
	var retval = "0.00";
	
		
	wd="w"
	var tempnum=NumVal;
	for (i=0;i<tempnum.length;i++){
	
			if (NumVal.charAt(i)=="."){
			wd="d"
			break
			}
	}
	//alert(wd);
	if (wd=="w")
		retval=prefix+tempnum+".00"
	else{
		if (tempnum.charAt(tempnum.length-2)=="."){
		retval=prefix+tempnum+"0"
		}else{
		tempnum=Math.round(tempnum*100)/100
		thisone.value=prefix+tempnum
		}
	}
	
	
	return retval;
	}

	function PopupCenter(pageURL, title,w,h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	} 
	
	function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

	function firstPage(){
	}


	function do_over(pObj,bgcolor,type){


	pObj.style.backgroundColor = bgcolor;
	if(type == 'Y')
	pObj.style.color = 'green';
	
	}
	
	function do_out(pObj,bgcolor,type){

	pObj.style.backgroundColor = bgcolor;
	if(type == 'Y')
	pObj.style.color = 'black';

	}
	
	/*
	function do_down(pObj,bgcolor){
		pObj.style.backgroundColor = bgcolor;
		pObj.style.cursor = '';
		pObj.style.color = 'blue';
	}*/
	


</script>
EOF;
?>

