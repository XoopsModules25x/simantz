<?php
	include_once ('../../mainfile.php');
	include_once (XOOPS_ROOT_PATH.'/header.php');
	include_once '../simantz/class/Permission.php';
	include_once '../system/class/Organization.php';
//	include_once 'class/Accounts.php';
//	include_once 'accounts.php';
	include_once '../system/class/Log.php';



	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	include "setting.php";
	$log = new Log();


	$rowperpage=50;
	$backuppath=XOOPS_ROOT_PATH."/../backup";

	$module_id=$xoopsModule->getVar('mid');

	$break=explode('/',$_SERVER['SCRIPT_NAME']);
	$usefilename=$break[count($break)-1];
//	$userid=$xoopsUser->getVar('uid');

	$url=XOOPS_URL;
	
	global $xoopsUser;
	
	if(!$xoopsUser)
		redirect_header($url,2,"<b style='color:red'>Session expired, please relogin.</b>");
	else
	$userid=$xoopsUser->getVar('uid');
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tableuser= $tableprefix . "users";
	$tablecountry=$tableprefix."country";
	$tableclosing=$tableprefix."simbiz_closing";
	$tableaccountclass=$tableprefix."simbiz_accountclass";
	$tableaccountgroup=$tableprefix."simbiz_accountgroup";
	$tableaccounts=$tableprefix."simbiz_accounts";
	$tablebatch=$tableprefix."simbiz_batch";
	$tabledebitcreditnote=$tableprefix."simbiz_debitcreditnote";
	$tabledebitcreditnoteline=$tableprefix."simbiz_debitcreditnoteline";
	$tableinvoice=$tableprefix."simbiz_invoice";
	$tableinvoiceline=$tableprefix."simbiz_invoiceline";
	$tablebpartner=$tableprefix."bpartner";
	$tablebpartnergroup=$tableprefix."bpartnergroup";
	$tableconversion=$tableprefix."conversionrate";
	$tablecurrency=$tableprefix."currency";
	$tableorganization=$tableprefix."organization";
	$tableperiod=$tableprefix."period";
	$tablefinancialyear=$tableprefix."simbiz_financialyear";
	$tablefinancialyearline=$tableprefix."simbiz_financialyearline";
	$tabletax=$tableprefix."simbiz_tax";
	$tablegroups=$tableprefix."groups";
	$tableterms=$tableprefix."terms";
	$tabletransaction=$tableprefix."simbiz_transaction";
	$tabletranssummary=$tableprefix."simbiz_transsummary";

	$tablewindow=$tableprefix."simbiz_window";
	$tablepermission=$tableprefix."simbiz_permission";
	$tablegroups_users_link=$tableprefix."groups_users_link";
	$tablegrouppermission=$tableprefix."group_permission";
	$tablemodules=$tableprefix."modules";
	$tableconversionrate=$tableprefix."conversionrate";
	$tableusers=$tableprefix."users";
	$tablereceipt=$tableprefix."simbiz_receipt";
	$tablereceiptline=$tableprefix."simbiz_receiptline";
	$tablepaymentvoucher=$tableprefix."simbiz_paymentvoucher";
	$tablepaymentvoucherline=$tableprefix."simbiz_paymentvoucherline";

	$tablebankreconcilation=$tableprefix."simbiz_bankreconcilation";
	$defaultorganization_id=0;
	
	
	session_start(); 
	$log=new Log();
	$o = new Organization();
//	$a = new Accounts();


	if( $_GET['switchorg']=='Y')
	$_SESSION['defaultorganization_id']=$_GET['defaultorganization_id'];

	$defaultorganization_id=$_SESSION['defaultorganization_id'];
	//$orgid=$_POST['organization_id'];
	
	if( $_GET['setSessionDate']=='Y')
	$_SESSION['defaultDateSession'] = $_GET['defaultDateSession'];

	$defaultDateSession=$_SESSION['defaultDateSession'];


	if($defaultorganization_id=='' ){
		$defaultorganization_id=$o->getDefaultOrganization($userid);
		$_SESSION['defaultorganization_id']=$defaultorganization_id; 

	}
	
	$permission = new Permission();
	$log->showLog(4,"Currenct org session id=".$_SESSION['defaultorganization_id']);
	$result=$permission->checkPermission($userid,$module_id,$usefilename);
	$menuname=$result[0];
	if($menuname == "")
		 redirect_header("index.php",$pausetime,
			"<b style='color:red'>You don't have permission to access this page, back to home.</b> ");

        $isreadonlywindows=$result[1];
        $windowsetting=$result[2];

	$o->fetchOrganization($defaultorganization_id);
	$defcurrencycode=$o->currency_code;
	$defaultcurrency_id=$o->currency_id;
	$defaultorganization_name=$o->organization_name;		
	include_once "setting.php";

	


//	if($a->checkAccounts($defaultorganization_id))
//    $a->insertDefaultAcc($defaultorganization_id,$userid);


	function getNewCode($xoopsDB,$fldname,$table,$where="") {
		global $defaultorganization_id,$xoopsDB,$log;
		$wherestr = " WHERE CAST($fldname AS SIGNED) > 0 and organization_id = $defaultorganization_id ";
		$wherestr .= $where;
	
		$sql =	"SELECT CAST($fldname AS SIGNED) as new_no, $fldname as ori_data 
			from $table $wherestr order by CAST($fldname AS SIGNED) DESC limit 1 ";
		$log->showLog(4,"getNewCode with SQL: $sql");
		$query=$xoopsDB->query($sql);
	
		if($row=$xoopsDB->fetchArray($query)){
			
			$new_no=$row['new_no']+1;
	
			$length_new = strlen($new_no);
			$length_ori = strlen($row['ori_data']);

			if($length_new < $length_ori){
			$add0 = "";
			while($i < ($length_ori - $length_new)){
			$i++;
			$add0 .= "0";
			}
			return $add0.$new_no;
			}else
			return $new_no;

			
		}
		else
		return 1;
	
  	}

	
	function getMonth($date,$type){//get 1st & end month

	$month = substr($date,4,2);
	$year = substr($date,0,4);
	$first_of_month = mktime(0, 0, 0, (int)$month, 1, $year);
	$days_in_month = date('t', $first_of_month);
	$last_of_month = mktime(0, 0, 0, (int)$month, $days_in_month, $year);
	
	if($type==0)
	$date_val = date("Y",$first_of_month).date("m",$first_of_month).date("d",$first_of_month);
	else
	$date_val = date("Y",$last_of_month).date("m",$last_of_month).date("d",$last_of_month);
	
	
	$date_val = strtotime($date_val.' UTC');
	
	return gmdate('Y-m-d',$date_val);
	
	}
	
	function getPeriodDate($period_id){
	global $xoopsDB,$tableperiod;
	$retval = "";
	
	$sql = "select * from $tableperiod where period_id = $period_id";
	
	$query=$xoopsDB->query($sql);
	
	if($row=$xoopsDB->fetchArray($query)){
	$retval = $row['period_name'];
	}
	
	return $retval;
	
	}

	
	
function convertNumber($num)
{
   list($num, $dec) = explode(".", $num);

   $output = "";

   if($num{0} == "-")
   {
      $output = "negative ";
      $num = ltrim($num, "-");
   }
   else if($num{0} == "+")
   {
      $output = "positive ";
      $num = ltrim($num, "+");
   }
   
   if($num{0} == "0")
   {
      $output .= "zero";
   }
   else
   {
      $num = str_pad($num, 36, "0", STR_PAD_LEFT);
      $group = rtrim(chunk_split($num, 3, " "), " ");
      $groups = explode(" ", $group);

      $groups2 = array();
      foreach($groups as $g) $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});

      for($z = 0; $z < count($groups2); $z++)
      {
         if($groups2[$z] != "")
         {
            $output .= $groups2[$z].convertGroup(11 - $z).($z < 11 && !array_search('', array_slice($groups2, $z + 1, -1))
             && $groups2[11] != '' && $groups[11]{0} == '0' ? " " : " ");
//             && $groups2[11] != '' && $groups[11]{0} == '0' ? " and " : ", ");
         }
      }

      $output = rtrim($output, ", ");
   }

   if($dec > 0)
   {
      
	
    $output .= " and cents ".convertTwoDigit($dec{0},$dec{1});
   }

   return strtoupper($output . " only");
}

function convertGroup($index)
{
   switch($index)
   {
      case 11: return " decillion";
      case 10: return " nonillion";
      case 9: return " octillion";
      case 8: return " septillion";
      case 7: return " sextillion";
      case 6: return " quintrillion";
      case 5: return " quadrillion";
      case 4: return " trillion";
      case 3: return " billion";
      case 2: return " million";
      case 1: return " thousand";
      case 0: return "";
   }
}

function convertThreeDigit($dig1, $dig2, $dig3)
{
   $output = "";

   if($dig1 == "0" && $dig2 == "0" && $dig3 == "0") return "";

   if($dig1 != "0")
   {
      $output .= convertDigit($dig1)." hundred";
      if($dig2 != "0" || $dig3 != "0") $output .= " ";
   }

   if($dig2 != "0") $output .= convertTwoDigit($dig2, $dig3);
   else if($dig3 != "0") $output .= convertDigit($dig3);

   return $output;
}

function convertTwoDigit($dig1, $dig2)
{
   if($dig2 == "0")
   {
      switch($dig1)
      {
         case "1": return "ten";
         case "2": return "twenty";
         case "3": return "thirty";
         case "4": return "forty";
         case "5": return "fifty";
         case "6": return "sixty";
         case "7": return "seventy";
         case "8": return "eighty";
         case "9": return "ninety";
      }
   }
   else if($dig1 == "1")
   {
      switch($dig2)
      {
         case "1": return "eleven";
         case "2": return "twelve";
         case "3": return "thirteen";
         case "4": return "fourteen";
         case "5": return "fifteen";
         case "6": return "sixteen";
         case "7": return "seventeen";
         case "8": return "eighteen";
         case "9": return "nineteen";
      }
   }
   else
   {
      $temp = convertDigit($dig2);
      switch($dig1)
      {
         case "2": return "twenty-$temp";
         case "3": return "thirty-$temp";
         case "4": return "forty-$temp";
         case "5": return "fifty-$temp";
         case "6": return "sixty-$temp";
         case "7": return "seventy-$temp";
         case "8": return "eighty-$temp";
         case "9": return "ninety-$temp";
      }
   }
}
      
function convertDigit($digit)
{
   switch($digit)
   {
      case "0": return "zero";
      case "1": return "one";
      case "2": return "two";
      case "3": return "three";
      case "4": return "four";
      case "5": return "five";
      case "6": return "six";
      case "7": return "seven";
      case "8": return "eight";
      case "9": return "nine";
   }
}

function getDateSession(){
global $defaultDateSession;
$curr_date = $timestamp= date("Y-m-d", time()) ;

if($defaultDateSession != "")
$curr_date = $defaultDateSession;


return $curr_date;
}

  function getCentSalesPoint($value){

	$retval = $value;
	$pointstr = strpos($value,".");

	$number1 = substr($retval,0,strpos($value,".")+2);

	if($pointstr>0){
	$lastpointer = substr($retval,strpos($value,".")+2,strpos($value,".")+3);
	//echo $lastpointer = substr($retval,strpos($value,".")+2,strpos($value,"."));

	if($lastpointer > 5)
	$number1 = $number1 + 0.1;
	
	if($lastpointer != 5)
	$retval = $number1;
	}

	return $retval;
  }

function right($value, $count){

    $value = substr($value, (strlen($value) - $count), strlen($value));

    return $value;

}


function left($string, $count){

    return substr($string, 0, $count);

}

 function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function getLastDayByMonth($period_name){
    $year=left($period_name,4);
    $month=right($period_name,2);
    if($month<12)
     $newday=$year."-".($month+1)."-"."01";
     else
     $newday=($year+1)."-01-01";
     return date("Y-m-d",strtotime("-1 second",
                                strtotime($newday)
                        )
                            );
 
}

function getMinMaxBatchDate($type=0){
    global $xoopsDB,$tablebatch;
    $retval = "";

    if($type == 0)
    $sql = "select min(batchdate) as select_date from $tablebatch where batch_id > 0 limit 1";
    else
    $sql = "select max(batchdate) as select_date from $tablebatch where batch_id > 0  limit 1";

    $query=$xoopsDB->query($sql);

    while ($row=$xoopsDB->fetchArray($query)){
    $retval = $row['select_date'];
    }
    return $retval;
}

function changeNegativeNumberFormat($number,$decimal=2){
    if($number<0)
    return "(".number_format(abs($number),$decimal).")";
    else
    return number_format($number,$decimal);
    
}

 function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>
