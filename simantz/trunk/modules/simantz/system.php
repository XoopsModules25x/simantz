<?php
	include_once ('../../mainfile.php');
        include_once (XOOPS_ROOT_PATH.'/header.php');

	include_once '../simantz/class/Permission.php';
	include_once '../simantz/class/Organization.inc.php';
//	include_once 'class/Accounts.php';
//	include_once 'accounts.php';
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

	include_once '../simantz/class/Log.inc.php';
        	include "../simantz/setting.php";

	$log = new Log();

	$rowperpage=50;
//	$pausetime=100;
//	$tokenlife=1000;
	//$backuppath=XOOPS_ROOT_PATH."/../backup";

	$module_id=$xoopsModule->getVar('mid');

	$break=explode('/',$_SERVER['SCRIPT_NAME']);
	$usefilename=$break[count($break)-1];
//	$userid=$xoopsUser->getVar('uid');

	$url=XOOPS_URL;
	
	global $xoopsUser;

	if(!$xoopsUser)
		redirect_header($url."/user.php",2,"<b style='color:red'>Session expired, please relogin.</b>");
	else{
	$userid=$xoopsUser->getVar('uid');
        $uname=$xoopsUser->getVar('uname');
    	$isadmin=$xoopsUser->isAdmin();
        $timestamp=date("Y-m-d H:i:s",time());
        }
    
	$tableprefix= XOOPS_DB_PREFIX . "_";
        $tableuser= $tableprefix . "users";
        $tableraces= $tableprefix . "races";
        $tableaddress=$tableprefix."address";
        $tablecontacts=$tableprefix."contacts";
        $tableaccounts=$tableprefix."simbiz_accounts";
        $tabletax=$tableprefix."simbiz_tax";
        $tablecountry=$tableprefix."country";
        $tablebpartner=$tableprefix."bpartner";
        $tablebpartnergroup=$tableprefix."bpartnergroup";
        $tablecurrency=$tableprefix."currency";
        $tableorganization=$tableprefix."organization";
        $tableperiod=$tableprefix."period";
        $tablegroups=$tableprefix."groups";
        $tableregion=$tableprefix."region";
        $tablereligion=$tableprefix."religion";
        $tablerelationship=$tableprefix."simedu_relationship";
        $tableterms=$tableprefix."terms";
        $tabletransaction=$tableprefix."simbiz_transaction";
        $tabletranssummary=$tableprefix."simbiz_transsummary";
        $tableconversionrate=$tableprefix."conversionrate";
        $tablebatch=$tableprefix."simbiz_batch";
        $tableinventorychangeline=$tableprefix."simiterp_inventorychangeline";
        $tableinventorychange=$tableprefix."simiterp_inventorychange";
        $tableproject=$tableprefix."simiterp_project";
        $tablewindow=$tableprefix."window";
        $tablepermission=$tableprefix."permission";
        $tablegroups_users_link=$tableprefix."groups_users_link";
        $tablegrouppermission=$tableprefix."group_permission";
        $tablemodules=$tableprefix."modules";

        $tablesystemlist=$tableprefix."simiterp_systemlist";
        $tablestatus=$tableprefix."simiterp_status";
        $tabletype=$tableprefix."simiterp_type";
        $tablestafftype=$tableprefix."simiterp_stafftype";
        $tableindustry=$tableprefix."industry";
        $tableusers=$tableprefix."users";
        $tablestock=$tableprefix."simiterp_currentstock";
        $tableproducttransaction=$tableprefix."simiterp_producttransaction";
        $defaultorganization_id=0;
        $tableuom=$tableprefix."simiterp_uom";
        $tableinventorymovement=$tableprefix."simiterp_productmovement";
        $tableinventorymovementline=$tableprefix."simiterp_productmovementline";
        $tableshipment=$tableprefix."simiterp_shipment";
        $tableshipmentline=$tableprefix."simiterp_shipmentline";
        $tableproduction=$tableprefix."simiterp_production";
        $tableproductionoutput=$tableprefix."simiterp_productionoutput";
        $tableproductionline=$tableprefix."simiterp_productionline";

        $tablepricelist=$tableprefix."simiterp_pricelist";
        $tablefollowuptype=$tableprefix."followuptype";
        $tablefollowup=$tableprefix."followup";

        $tablegroupuserslink=$tableprefix."groups_users_link";
        $tablegroups=$tableprefix."groups";

//	session_start();
	$log=new Log();
	$o = new Organization();
//	$a = new Accounts();


	if( $_GET['switchorg']=='Y')
	$_SESSION['defaultorganization_id']=$_GET['defaultorganization_id'];

	$defaultorganization_id=$_SESSION['defaultorganization_id'];
	//$orgid=$_POST['organization_id'];

	if($defaultorganization_id=='' ){
		$defaultorganization_id=$o->getDefaultOrganization($userid);
		$_SESSION['defaultorganization_id']=$defaultorganization_id; 

		if($defaultorganization_id=='' || $defaultorganization_id==0){
	$defaultorganization_id=1;	
		$_SESSION['defaultorganization_id']=$defaultorganization_id; 
		}
	}

	if( $_GET['setSessionDate']=='Y')
	$_SESSION['defaultDateSession'] = $_GET['defaultDateSession'];

	$defaultDateSession=$_SESSION['defaultDateSession'];

	
	$permission = new Permission();
	$log->showLog(4,"Currenct org session id=".$_SESSION['defaultorganization_id'] .",program org_id= $defaultorganization_id,uid=$userid");
	$arrperm=$permission->checkPermission($userid,$module_id,$usefilename);
        $menuname=$arrperm[0];
	$xoopsTpl->assign('xoops_pagetitle', $menuname);

        $havewriteperm=$arrperm[1];
        $windowsetting=$arrperm[2];
        $permissionsetting=$arrperm[3];
        $helpurl=$arrperm[4];

        if(strpos($permissionsetting,'$')>=0){

        $permissionsetting=explode(",", $permissionsetting);
        $totalpermissionsetting=count($permissionsetting);
        $i=0;
        while($i < $totalpermissionsetting){

           eval($permissionsetting[$i].";");
	if(strpos($permissionsetting[$i],'$'))
        eval($permissionsetting[$i].";");

        $i++;
        }
        
        }
//      echo $viewappraisal;
//      echo $viewpayroll;
 


	if($menuname == "" && $userid > 1)
		 redirect_header("index.php",$pausetime,
			"<b style='color:red'>You don't have permission to access this page, back to home.</b> ");
        
	$o->fetchOrganization($defaultorganization_id);
        $defcountrycode=$o->country_code;
	$defcurrencycode=$o->currency_code;
	$defaultcurrency_id=$o->currency_id;
        $defaultorganization_name=$o->organization_name;
        $defaulttelcode=$o->telcode;
		$log->showLog(3,"end system.php.");

//	if($a->checkAccounts($defaultorganization_id))
//    $a->insertDefaultAcc($defaultorganization_id,$userid);


	function getNewCode($xoopsDB,$fldname,$table,$where="") {
		global $defaultorganization_id;
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


function getDateSession(){
global $defaultDateSession;
$curr_date = $timestamp= date("Y-m-d", time()) ;

if($defaultDateSession != "")
$curr_date = $defaultDateSession;


return $curr_date;
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


function isGroup($group_name, $user_id){

    global $xoopsDB;
      $sql = "select u.name, g.name as g_name from sim_users u, sim_groups g, sim_groups_users_link ug
                    where u.uid=ug.uid and g.groupid=ug.groupid and u.uid=$user_id and g.name='$group_name'";
     $rs = $xoopsDB->query($sql);
     $allow = false;
     while ($row=$xoopsDB->fetchArray($rs)){
         //echo $row['g_name']." ".$group_name." ".$allow."|";

         if($row['g_name']==$group_name){
             $allow = true;
         }
     }
     return $allow;
 }

function right($value, $count){
    return substr($value, ($count*-1));
}

function left($string, $count){
    return substr($string, 0, $count);
}
?>
