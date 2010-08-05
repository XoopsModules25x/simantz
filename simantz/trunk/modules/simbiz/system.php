<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

	//include_once '../simantz/class/Permission.php';
//	include_once '../simantz/class/Organization.inc.php';
//	include_once 'class/Accounts.php';
//	include_once 'accounts.php';

	//include_once '../simantz/class/Log.inc.php';

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	include "../simantz/system.php";
      include_once '../simantz/setting.php';
	include "setting.php";


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

	$tablereceipt=$tableprefix."simbiz_receipt";
	$tablereceiptline=$tableprefix."simbiz_receiptline";
	$tablepaymentvoucher=$tableprefix."simbiz_paymentvoucher";
	$tablepaymentvoucherline=$tableprefix."simbiz_paymentvoucherline";
	$tablebankreconcilation=$tableprefix."simbiz_bankreconcilation";
    $tableindustry=$tableprefix."industry";
    $tableaddress=$tableprefix."address";
    $tableregion=$tableprefix."region";

    	$tableraces= $tableprefix . "races";
    $tablereligion= $tableprefix . "religion";


//
//	function getMonth($date,$type){//get 1st & end month
//
//	$month = substr($date,4,2);
//	$year = substr($date,0,4);
//	$first_of_month = mktime(0, 0, 0, (int)$month, 1, $year);
//	$days_in_month = date('t', $first_of_month);
//	$last_of_month = mktime(0, 0, 0, (int)$month, $days_in_month, $year);
//
//	if($type==0)
//	$date_val = date("Y",$first_of_month).date("m",$first_of_month).date("d",$first_of_month);
//	else
//	$date_val = date("Y",$last_of_month).date("m",$last_of_month).date("d",$last_of_month);
//
//
//	$date_val = strtotime($date_val.' UTC');
//
//	return gmdate('Y-m-d',$date_val);
//
//	}

//	function getPeriodDate($period_id){
//	global $xoopsDB,$tableperiod;
//	$retval = "";
//
//	$sql = "select * from $tableperiod where period_id = $period_id";
//
//	$query=$xoopsDB->query($sql);
//
//	if($row=$xoopsDB->fetchArray($query)){
//	$retval = $row['period_name'];
//	}
//
//	return $retval;
//
//	}


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

    function getLatestPrimaryID($tablename,$primarykey,$checkorg=true) {
    global $xoopsDB,$defaultorganization_id;

    $wherestr = "";
    if($checkorg)
    $wherestr = " where organization_id = $defaultorganization_id ";

	$sql="SELECT MAX($primarykey) as fldname from $tablename $wherestr;";

	$query=$xoopsDB->query($sql);
	if($row=$xoopsDB->fetchArray($query)){

		return $row['fldname'];
	}
	else
	return -1;

  } // end

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

	
?>
