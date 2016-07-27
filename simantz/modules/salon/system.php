<?php
	include_once ('../../mainfile.php');
	include_once (XOOPS_ROOT_PATH.'/header.php');
	$url=XOOPS_URL;	
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tablecustomer=$tableprefix . "simsalon_customer";
	$tableuser= $tableprefix . "users";
	$rowperpage=50;
	$pausetime=0;
	$tokenlife=86400;
	$thstyle="style='text-align: center;' " ;
	$tdstyle[0]="class='even' style='text-align:center;' ";
	$tdstyle[1]="class='odd' style='text-align:center;'";
	$cur_symbol = "RM";
	$inactiveperiod = 180; //days
	$limitauto = 20; //sales history
	$odd_color = "#e8f9e9";
	$even_color = "#d4f9cf";
	$head_color = "#b2d9ac";
	$limitrecord = 12; //customertab
	
	$uid = $xoopsUser->getVar('uid');
	
	$allow = allowWindows($xoopsDB,$tableprefix,$uid,"access");

	if($allow == false)
	redirect_header("index.php",3,"Permission Denied. Please Contact Your Administrator.");

	function getNewCode($xoopsDB,$fldname,$table,$where="") {
	
		$wherestr = " WHERE CAST($fldname AS SIGNED) > 0 ";
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

			/*
			if(strlen($row['new_no']) != strlen($row['ori_data']))
			return str_replace($row['new_no'], '', $row['ori_data'])."".$new_no;
			else
			return $new_no;
			*/
			
		}
		else
		return 1;
	
  	}


	function getMonth($date,$type){
	
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

	function allowWindows($xoopsDB,$tableprefix,$uid,$action=""){
	
	$tablewindowsgroup = $tableprefix."simsalon_tblwindowsgroup";
	$tablewindows= $tableprefix."simsalon_tblwindows";
	$tablegroups_users_link = $tableprefix."groups_users_link";
	
	$arrStr = explode("/", $_SERVER['SCRIPT_NAME'] );
	$arrStr = array_reverse($arrStr );

	$filename = $arrStr[0];
	
	if($action=="edit")
	$type = "allowedit";
	elseif($action=="new")
	$type = "allowadd";
	else
	$type = "isaccess";
	
	$sql=	"SELECT $type from $tablewindowsgroup a, $tablegroups_users_link b, $tablewindows c 
		WHERE b.uid = $uid
		AND c.windows_filename = '$filename' 
		AND a.groupid = b.groupid
		AND a.windows_id = c.windows_id";
	$val = false;
	$query=$xoopsDB->query($sql);
	$i=0;
	while ($row=$xoopsDB->fetchArray($query)){
	$i++;
	if($row[$type]==1)
	$val = true ;
	

	}
	

	if($i==0)
	$val=true;

	return $val;

	}

	function getOrganizationInfo($xoopsDB,$tableprefix){
	$tableorganization = $tableprefix."simsalon_organization";
	$tableaddress = $tableprefix."simsalon_address";
	$tablearea = $tableprefix."simsalon_area";
	$org = "";	

	$sql = "select * from $tableorganization a, $tableaddress b, $tablearea c  
		where a.address_id = b.address_id 
		and b.area_id = c.area_id 
		limit 1";
	
	$query=$xoopsDB->query($sql);

	if ($row=$xoopsDB->fetchArray($query)){
	//$org .= $row['address_name']."\n";
	if($row['street1'] != "")
	$org .= $row['no']." ".$row['street1'].",\n";
	if($row['street2'] != "")
	$org .= $row['street2'].",\n";
	if($row['city'] != "")
	$org .= $row['postcode'].", ".$row['city'].",\n";
	if($row['state'] != "")
	$org .= $row['state'].", ".$row['country'].",\n";
	if($row['tel_1'] != "")
	$org .= "Tel : ".$row['tel_1']." ".$row['tel_2'];
	}
	return $org;
	}

	?>
