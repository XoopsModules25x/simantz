<?php


class Permission {
  public $groupid;
  public $window_id;
  public $permission_id;
  public $module_id=0;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $lineallow;
  public $linewindow_id;
  public $transactionmenu;
  public $mastermenu;
  public $reportmenu;
  private $xoopsDB;
  private $tableprefix;
  private $tableusers;
  private $tablemodules;
  private $tableorganization;
  private $tablegroups;
  private $tablegroups_users_link;
  private $tablepermission;
  private $tablewindow;
  private $log;

public function Permission (){
	global $xoopsDB,$log,$module_id,$tablepermission,$tablegroups,$tablegroups_users_link,$tablewindow,$tablegrouppermission,
		$tableorganization,$tableusers,$tablemodules;
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablemodules=$tablemodules;
	$this->tableusers=$tableusers;
	$this->tableorganization=$tableorganization;
	$this->tablegroups=$tablegroups;
	$this->tablegroups_users_link=$tablegroups_users_link;
	$this->tablegrouppermission=$tablegrouppermission;
	$this->tablewindow=$tablewindow;
	$this->module_id=$module_id;
	$this->tablepermission=$tablepermission;
	$this->log=$log;

   }

  public function showControlHeader($groupid){


	$this->log->showLog(4,"Accessing showcontrolheader with groupid: $groupid");
	
	$sql="SELECT g.groupid, g.name from $this->tablegroups g inner join 
		$this->tablegrouppermission gp on gp.gperm_groupid=g.groupid
		WHERE gperm_name = 'module_read' and gp.gperm_itemid=$this->module_id order by g.name";
	$selectgroup="<SELECT name='groupid' onchange='action.click();'>";
	$i=0;
	$query=$this->xoopsDB->query($sql);
	$select_it="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$linegroupid=$row['groupid'];
		$groupname=$row['name'];
		if($linegroupid==$groupid)
			$select_it="SELECTED='SELECTED'";
		else
			$select_it="";
	
		$selectgroup=$selectgroup."<option $select_it value='$linegroupid'>$groupname</option>";

	}

	$selectgroup=$selectgroup."</SELECT>";
	$this->log->showLog(4,"With SQL: $sql");

	echo <<<EOF
	<A href='index.php'>Back To This Module Administration Menu</A>
	 <TABLE>
		<TBODY>
		<TR><TH colspan='3' style='text-align: center'>Search Groups </TH></TR>
		<TR><FORM method='POST' action='permission.php'>
			<TD class="head">Group</TD>
			<TD class="odd">$selectgroup <A href='../../system/admin.php?fct=groups'>Add/Edit Groups</A></TD>
			<TD class="even"><INPUT type='submit' name="action" value="search"></TD>
			</FORM>
		</TR>
		</TBODY>
	 </TABLE>
<br>


EOF;
  }

  public function showPermissionTable($groupid){
	$this->log->showLog(4,"Accessing showcontrolheader with groupid: $groupid");
	
/*	$sql="SELECT * FROM (SELECT w.filename, w.window_name, w.window_id,(CASE p.groupid WHEN $groupid THEN $groupid 
		WHEN NULL THEN NULL ELSE 9999 END) as groupid, functiontype
		FROM $this->tablewindow w 
		LEFT JOIN $this->tablepermission p on p.window_id=w.window_id order by w.functiontype, w.window_name)
		as t";*/
	$sql="SELECT w.window_id,w.window_name,w.filename,w.functiontype,gp.groupid FROM $this->tablewindow w
	LEFT JOIN (SELECT groupid,window_id FROM 
	$this->tablepermission p WHERE p.groupid=$groupid) gp on gp.window_id=w.window_id order by w.functiontype,w.seqno";
	$this->log->showLog(4,"With SQL: $sql");

//show table header
echo <<< EOF
	 <TABLE>
		<TBODY>
		<TR><TH colspan='5' style='text-align: center'>Add/Edit Group Permission</TH></TR>
		<TR><FORM method='POST' action='permission.php' name='frmUpdatePermission'>
			<Th>No</Th>
			<Th>Function Name</Th>
			<Th>File Name</Th>
			<Th>Function Type</Th>
			<Th>Allow Access <A href='#' onclick='selectall();'><br>[SELECT ALL]</A>&nbsp;<A href='#' 
				onclick='removeall();'>[REMOVE ALL]</A><br>
				<INPUT TYPE='submit' value='save' name='submit'></Th>
				<input type='hidden' name='groupid' value=$groupid></TR>
EOF;
	$i=0;



	$checked="";
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$filename=$row['filename'];
		$window_name=$row['window_name'];
		$window_id=$row['window_id'];
		$functiontype=$row['functiontype'];
		if($functiontype=='M')
			$functiontype="Master";
		elseif($functiontype=='T')
			$functiontype="Transaction";
		else
			$functiontype="Report";

		$groupid=$row['groupid'];
	if($groupid>0)
	$checked="checked";
	else
	$checked="";
	if($rowtype=='odd')
		$rowtype='even';
	else
		$rowtype='odd';
	$j=$i+1;
	echo <<< EOF
	
		<TR>	<TD class="$rowtype">$j</TD>
			<TD class="head">$window_name</TD>
			<TD class="$rowtype">$filename</TD>
			<TD class="$rowtype">$functiontype</TD>
			<TD class="$rowtype"><INPUT type='checkbox' name="lineallow[$i]" $checked>
					<input type='hidden' name='linewindow_id[$i]' value='$window_id'></TD>
			
		</TR>

EOF;
$i++;
	}
	echo "<TR><TD>
		<INPUT TYPE='hidden' value='save' name='action'>
		<INPUT TYPE='submit' value='save' name='submit'>
		<INPUT TYPE='hidden' value='$i' name='linecount'>
		</form></TD></TR></TBODY> </TABLE>";


  }

  public function updatePermission(){
	$timestamp= date("y/m/d H:i:s", time()) ;
 
	$this->log->showLog(4,"Accessing updatePermission with groupid=$this->groupid");
	$sqldel="DELETE FROM $this->tablepermission where groupid=$this->groupid";
	$this->log->showLog(4,"With SQL1: $sqldel");
	$result=$this->xoopsDB->query($sqldel);
	if($result)
	{
		$i=0;
		foreach($this->linewindow_id as $winid){
		//if allow access, add record into table
		if($this->lineallow[$i]=='on'){
			$sqlinsert="INSERT INTO $this->tablepermission (window_id,groupid,
				updated,updatedby,created,createdby) VALUES ($winid,$this->groupid,
				'$timestamp',$this->updatedby,'$timestamp',$this->createdby)";
			$this->log->showLog(4,"With SQL2: $sqlinsert");
			$this->xoopsDB->query($sqlinsert);
		}
		$i++;
		}
	return true;
	}
	else{
	return false;
	}
  }


  public function generateMenu($uid,$module_id){

	$this->log->showLog(3, "accessing generateMenu(uid=$uid,module=$module_id) for get permission.");
	$sql="select distinct(w.window_id) as window_id,
		w.window_name, w.functiontype,w.seqno,w.filename
		from sim_groups g 
		inner join $this->tablegroups_users_link gul on g.groupid=gul.groupid 
		inner join $this->tableusers u on gul.uid=u.uid 
		inner join $this->tablegrouppermission gp on gp.gperm_groupid=g.groupid 
		inner join $this->tablemodules m on gp.gperm_itemid=m.mid
		inner join $this->tablepermission gsp on gsp.groupid=g.groupid
		inner join $this->tablewindow w on gsp.window_id=w.window_id
		where m.mid=$module_id and gp.gperm_name='module_read' and u.uid=$uid and w.isactive='Y'
		order by  w.functiontype,w.seqno";
	$this->log->showLog(4, "With SQL: $sql");
	$this->transactionmenu="";
	$this->mastermenu="";
	$this->reportmenu="";

	$query=$this->xoopsDB->query($sql);
	$i=0;

	while($row=$this->xoopsDB->fetchArray($query)){
		$window_id=$row['window_id'];
		$window_name=$row['window_name'];
		$functiontype =$row['functiontype'];
		$seqno=$row['seqno'];
		$filename=$row['filename'];
		
		switch($functiontype){
		case "M":
			$this->mastermenu=$this->mastermenu . "\n" .
				"menus[1].addItem(url+'/$filename', '', 22, 'left', '$window_name', 0);";
		break;
		case "V":
			$this->reportmenu=$this->reportmenu . "\n" .
				"menus[3].addItem(url+'/$filename', '', 22, 'left', '$window_name', 0);";

		break;
		default:
			$this->transactionmenu=$this->transactionmenu . "\n" .
				"menus[2].addItem(url+'/$filename', '', 22, 'left', '$window_name', 0);";

		break;
		}

	}
	//echo  $this->mastermenu.$this->reportmenu.$this->transactionmenu;
	
  }

  public function checkPermission($uid,$module_id,$usefilename){

	$this->log->showLog(3, "checkPermission(uid=$uid,module_id=$module_id,usefilename=$usefilename)");
	$sql="select distinct(w.window_id) as window_id,
		w.window_name, w.functiontype,w.seqno,w.filename
		from sim_groups g 
		inner join $this->tablegroups_users_link gul on g.groupid=gul.groupid 
		inner join $this->tableusers u on gul.uid=u.uid 
		inner join $this->tablegrouppermission gp on gp.gperm_groupid=g.groupid 
		inner join $this->tablemodules m on gp.gperm_itemid=m.mid
		inner join $this->tablepermission gsp on gsp.groupid=g.groupid
		inner join $this->tablewindow w on gsp.window_id=w.window_id
		where m.mid=$module_id and w.filename='$usefilename' and gp.gperm_name='module_read' and u.uid=$uid
		order by  w.functiontype,w.seqno";
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);

	if($usefilename=='index.php')
		return "SimBiz Accounting System";
	elseif ($row=$this->xoopsDB->fetchArray($query))
		return $row['window_name'];
	else
 		return "";
	
 }




 public function orgWhereStr($uid){
	$this->log->showLog(3,"Generate sqlstring for user to see available organization data for uid : $uid");
	$sql="SELECT organization_id from $this->tableorganization o
		INNER JOIN $this->tablegroups_users_link ug on o.groupid=ug.groupid 
		where ug.uid=$uid and o.isactive=1";

	
	$this->log->showLog(3,"Wtih SQL: $sql");
	$wherestr="organization_id in(";
			
	$query=$this->xoopsDB->query($sql);
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
		
		$organization_id=$row['organization_id'];
		if ($i==0)
			$wherestr=$wherestr . $organization_id;
		else
			$wherestr=$wherestr  . ",$organization_id";
		$i++;
	}

	$wherestr=$wherestr . ")";
	$this->log->showLog(4,"Return orgWhereStr='$wherestr'");
	return $wherestr;
 }
 public function selectAvailableSysUser($id,$includenull='Y'){
	$this->log->showLog(3,"Retrieve available system users from database, with id: $id");
	$tableusers=$this->tableprefix."users";
	$sql="SELECT uid,uname from $tableusers ";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='uid' >";

	if($includenull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$uid=$row['uid'];
		$uname=$row['uname'];
	
		if($id==$uid)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$uid' $selected>$uname</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
   }
}

?>