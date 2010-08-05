<?php

	include_once ('../../mainfile.php');
	include_once (XOOPS_ROOT_PATH.'/header.php');
	include_once '../simantz/class/Permission.php';
	include_once '../simantz/class/Organization.inc.php';
//	include_once 'class/Accounts.php';
//	include_once 'accounts.php';

	include_once '../simantz/class/Log.inc.php';

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        include_once '../simantz/setting.php';
	include "setting.php";

	$log = new Log();


	$rowperpage=50;
	$backuppath=XOOPS_ROOT_PATH."/../backup";

	$module_id=$xoopsModule->getVar('mid');

	$break=explode('/',$_SERVER['SCRIPT_NAME']);
	$usefilename=$break[count($break)-1];
	

	$url=XOOPS_URL;
	
	global $xoopsUser;
	
	if(!$xoopsUser){
        $url = XOOPS_URL ."/modules/approval/login.php";
echo <<< EOF
       <script type="text/javascript">
       self.location = "$url";
       </script>
EOF;
        }else
	$userid=$xoopsUser->getVar('uid');
        $uid=$xoopsUser->getVar('uid');
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tableuser= $tableprefix . "users";
	$tablecountry=$tableprefix."country";
	$tableclosing=$tableprefix."simbiz_closing";
	$tableaccounts=$tableprefix."simbiz_accounts";
	$tablebatch=$tableprefix."simbiz_batch";
	$tablebpartner=$tableprefix."bpartner";
	$tablebpartnergroup=$tableprefix."bpartnergroup";
	$tableconversion=$tableprefix."conversionrate";
	$tablecurrency=$tableprefix."currency";
	$tableorganization=$tableprefix."organization";
	$tableperiod=$tableprefix."period";

	$tabletax=$tableprefix."simbiz_tax";

	$tablestafftype=$tableprefix."staff_stafftype";
	$tableemployee=$tableprefix."staff_employee";

	$tablegroups=$tableprefix."groups";
	$tableterms=$tableprefix."terms";
	$tabletransaction=$tableprefix."simbiz_transaction";
	$tabletranssummary=$tableprefix."simbiz_transsummary";
    $tablewindow=$tableprefix."window";
	$tableheapermission=$tableprefix."simedu_heapermission";
    $tablehespermission=$tableprefix."simedu_hespermission";
    $tablehrpermission=$tableprefix."simedu_hrpermission";
    $tablehostelpermission=$tableprefix."simedu_hostelpermission";
    $tablefinancepermission=$tableprefix."simedu_financepermission";
	$tablegroups_users_link=$tableprefix."groups_users_link";
	$tablegrouppermission=$tableprefix."group_permission";
	$tablemodules=$tableprefix."modules";
	$tableconversionrate=$tableprefix."conversionrate";
	$tableusers=$tableprefix."users";
	$tableraces= $tableprefix . "races";
    $tablereligion= $tableprefix . "religion";
    $tablerelationship= $tableprefix . "simedu_relationship";

    $tablesession=$tableprefix."simedu_session";
    $tablesemester=$tableprefix."simedu_semester";
    $tablesubjecttype=$tableprefix."simedu_subjecttype";
    $tablecoursetype=$tableprefix."simedu_coursetype";
    $tablecourse=$tableprefix."simedu_course";
    $tableyear=$tableprefix."year";
    $tableloantype=$tableprefix."simedu_loantype";
    $tablesubject=$tableprefix."simedu_subject";
    $tablesubjectspm=$tableprefix."simedu_subjectspm";
    $tablecocurriculum=$tableprefix."simedu_cocurriculum";
    $tablestudent=$tableprefix."simedu_student";
    $tablestudentspm=$tableprefix."simedu_studentspm";
    $tablestudentfather=$tableprefix."simedu_studentfather";
    $tablestudentmother=$tableprefix."simedu_studentmother";
    $tablestudenthier=$tableprefix."simedu_studenthier";
    $tabledepartmentcourse=$tableprefix."simedu_departmentcourse";
    $tableclockin=$tableprefix."simedu_clockin";
    $tableclockduty=$tableprefix."simedu_clockduty";
    $tableclockmaster=$tableprefix."simedu_clockmaster";
    $tableemployee=$tableprefix."simedu_employee";
    $tableemployeegroup=$tableprefix."simedu_employeegroup";
    $tabledepartment=$tableprefix."simedu_department";
    $tableacademiccalendar=$tableprefix."simedu_academiccalendar";
    $tablejobposition=$tableprefix."simedu_jobposition";
    $tablestudentinvoice=$tableprefix."simedu_studentinvoice";
    $tablestudentinvoiceline=$tableprefix."simedu_studentinvoiceline";

    $tableallowanceline=$tableprefix."simedu_allowanceline";
    $tabledisciplineline=$tableprefix."simedu_disciplineline";
    $tableactivityline=$tableprefix."simedu_activityline";
    $tableattachmentline=$tableprefix."simedu_attachmentline";
    $tableportfolioline=$tableprefix."simedu_portfolioline";
    $tableappraisalline=$tableprefix."simedu_appraisalline";
    $tableovertime=$tableprefix."simedu_overtime";
    $tableovertimeline=$tableprefix."simedu_overtimeline";
    $tableleave=$tableprefix."simedu_leave";
    $tableleaveline=$tableprefix."simedu_leaveline";
    $tabletimeoff=$tableprefix."simedu_timeoff";
    
	$tablefinancialyear=$tableprefix."simbiz_financialyear";
	$tablefinancialyearline=$tableprefix."simbiz_financialyearline";
            $tableclosesession=$tableprefix."simedu_closesession";
	
    $tablestudentfeedback=$tableprefix."simedu_studentfeedback";
        $tablefeedback=$tableprefix."simedu_feedback";
	$defaultorganization_id=0;
	
	
	session_start(); 
//	$log=new Log();
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

        $havewriteperm=$result[1];
        $windowsetting=$result[2];

	$o->fetchOrganization($defaultorganization_id);
	$defcurrencycode=$o->currency_code;
	$defaultcurrency_id=$o->currency_id;			

	//include_once "setting.php";

//	if($a->checkAccounts($defaultorganization_id))
//    $a->insertDefaultAcc($defaultorganization_id,$userid);


	function getNewCode($xoopsDB,$fldname,$table,$where="") {
		global $defaultorganization_id,$xoopsDB;
		$wherestr = " WHERE CAST($fldname AS SIGNED) > 0 and organization_id = $defaultorganization_id ";
		$wherestr .= $where;
	
		$sql =	"SELECT CAST($fldname AS SIGNED) as new_no, $fldname as ori_data 
			from $table $wherestr order by CAST($fldname AS SIGNED) DESC limit 1 ";
	
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

   return $output . " only";
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

  function getDecimalPoint($length){

	$retval = $length;

	$number1 = substr($length,0,strpos($length,"."));

	//$decimal = $length - $number1;
	$decimal = "0".substr($length,strpos($length,"."),strlen($length));

	if($decimal == 0)
	$retval = $number1;

	return $retval;
  }

  function getDividerPoint($value){

	$retval = $value;
	$divider_text = "";

	$number1 = substr($value,0,strpos($value,"."));

	//$decimal = $value - $number1;
	$decimal = "0".substr($value,strpos($value,"."),strlen($value));

	$i=0;
	$up_no = 0;
	while($i < 8){
	$i++;
	
	$pointer_d = $i/8;

	if($pointer_d == $decimal){
	$up_no = $i;
	$divider_text = "$i/8";
	$i = 9;
	}

	}

	if(is_int($up_no)){
		 if($up_no == "4"){
			$divider_text = "1/2";
			}
	}

	if($divider_text == "8/8")
	$divider_text="";
	
	if($divider_text != "")
	$retval = $number1."  $divider_text";

	return $retval;
  }

  function getTonnagePoint($tonnage){

	$retval = $tonnage;

	$number1 = substr($tonnage,0,strpos($tonnage,"."));

	//echo $decimal = $tonnage - (int)$number1;
	$decimal = "0".substr($tonnage,strpos($tonnage,"."),strlen($tonnage));

	$decimal_3p = substr(str_replace("0.","",$decimal),0,3);
	$lastchar_3p = substr($decimal_3p,2,3);

	if(!is_int($lastchar_3p/2))
	$lastchar_3p = $lastchar_3p - 1;

	$final_3p = substr($decimal,0,4)."$lastchar_3p";

	$retval = $number1 + $final_3p;

	return $retval;
  }

  function getCurrencyPoint($value){

	$retval = $value;

	$number1 = substr($retval,0,strpos($value,".")+2);

	if($decimal == 0)
	$retval = $number1;

	

	return $retval;
  }

  function getCentPoint($value){

	$retval = $value;

	$number1 = substr($retval,0,strpos($value,".")+2);
	$lastpointer = substr($retval,strpos($value,".")+2,strpos($value,".")+3);

	if($lastpointer >= 4)
	$number1 = $number1 + 0.1;
	
	$retval = $number1;
	

	return $retval;
  }

function getDateSession(){
global $defaultDateSession;
$curr_date = $timestamp= date("Y-m-d", time()) ;

if($defaultDateSession != "")
$curr_date = $defaultDateSession;


return $curr_date;
}

  function getTonnageSales($value){

	$retval = $value;

 	$number1 = substr($retval,0,strpos($value,".")+5);
	$lastpointer = substr($retval,strpos($value,".")+5,strpos($value,".")+3);

	if($lastpointer >= 5)
	$number1 = $number1 + 0.0001;
	
	$retval = $number1;
	

	return $retval;
  }

//echo dateDiff("2009-09-02", "2009-08-30");
function dateDiff($endDate, $beginDate)
{

    //YYYY-MM-DD
    $y1 = substr($endDate,0,4);
    $m1 = (int)substr($endDate,5,2);
    $d1 = (int)substr($endDate,8,2);

    $y2 = substr($beginDate,0,4);
    $m2 = (int)substr($beginDate,5,2);
    $d2 = (int)substr($beginDate,8,2);

    $start_date=gregoriantojd($m2, $d2, $y2);
    $end_date=gregoriantojd($m1, $d1, $y1);

    //echo "$end_date $start_date";
    return $end_date - $start_date + 1;
}

function getYearSession(){
        global $ctrl,$defaultorganization_id,$tableclosesession,$xoopsDB;

        $sql = "select year_id,session_id from $tableclosesession
                    where isactive = 0 and organization_id = $defaultorganization_id ";


        $query=$xoopsDB->query($sql);

         $year_id = 0;
         $session_id = 0;
         if($row=$xoopsDB->fetchArray($query)){
         $year_id = $row['year_id'];
         $session_id = $row['session_id'];
         }

         return array('year_id'=>$year_id,'session_id'=>$session_id);
    }

            function getDepartmentID($uid){
        global $xoopsDB,$tableemployee;

        $retval = 0;

        $sqlemp = "select department_id
        from $tableemployee em
        where em.uid = $uid ";

        $rsemp=$xoopsDB->query($sqlemp);

        if($rowemp=$xoopsDB->fetchArray($rsemp)){
        $retval = $rowemp['department_id'];
        }

        return $retval;
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
