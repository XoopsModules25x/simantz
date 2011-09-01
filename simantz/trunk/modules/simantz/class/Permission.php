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
  private $window_no;
  public $findmodule_id;
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
	$this->module_id=$module_id;
	$this->log=$log;
}

  public function showControlHeader($groupid,$mid){
  global $xoopsUser;
         $uid=$xoopsUser->getVar('uid');
        if($uid>1)
           $wherestring=" WHERE g.groupid>1";
        else
           $wherestring="";
        
	$this->log->showLog(4,"Accessing showcontrolheader with groupid: $groupid");

        $sql="SELECT g.groupid, g.name from sim_groups g $wherestring
		 order by g.name";
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

        $sql="SELECT m.mid,m.name from sim_modules m WHERE m.weight >0
		 order by m.name";
	$selectmodule="<SELECT name='findmodule_id' onchange='action.click();'>";
	$i=0;
	$query=$this->xoopsDB->query($sql);
	$select_it="";

	while($row=$this->xoopsDB->fetchArray($query)){
		 $linemid=$row['mid'];
		 $mname=$row['name'];
		if($linemid==$mid)
			 $selectm="SELECTED='SELECTED'";
		else
			$selectm="";

		$selectmodule=$selectmodule."<option $selectm value='$linemid'>$mname</option>";

	}

	$selectmodule.="</SELECT>";
	$this->log->showLog(4,"With SQL: $sql");

	echo <<<EOF

	 <TABLE class="searchformblock">
		<TBODY>
		<TR><Td class="searchformheader" colspan='5' style='text-align: center'>Search Groups</Td></TR>
		<TR><FORM method='GET' action='permission.php'>
			<TD class="head">Group</TD>
			<TD class="odd">$selectgroup <A href='group.php'>Add/Edit Groups</A></TD>
			<TD class="head">Module</TD><TD class="odd">$selectmodule</TD>

                    <TD class="even"><INPUT type='submit' name="action" value="search"></TD>
			</FORM>
		</TR>
		</TBODY>
	 </TABLE>
<br>


EOF;
  }

  public function showPermissionTable($groupid,$mid){
	$this->log->showLog(4,"Accessing showcontrolheader with groupid: $groupid");



//show table header
echo <<< EOF
<FORM method='POST' action='permission.php' name='frmUpdatePermission'>
	 <TABLE class="searchformblock">
		<TBODY >
		<TR><Td class="searchformheader" colspan='10' style='text-align: center'>Add/Edit Group Permission
                        <INPUT TYPE='submit' value='save' name='submit'>
                        <INPUT TYPE='hidden' value='$this->groupid' name='groupid'>
                        </d></TR>
		<TR>
			<Td class="tdListRightHeader">No</Td>
			<Td class="tdListRightHeader">Function Name</Td>
			<Td class="tdListRightHeader">Module Name</Td>
			<Td class="tdListRightHeader">File Name</Td>
			<Td class="tdListRightHeader">Description</Td>
			<Td class="tdListRightHeader">Seq</Td>
                        <Td class="tdListRightHeader">R<br/><input name="readperm" type="checkbox"  onclick=selectall(this.checked)><br>
				</Td>
                        <Td class="tdListRightHeader">W<br/><input type="checkbox" name="writeperm" onclick=selectallwriteperm(this.checked)><br>
				</Td>
			<Td class="tdListRightHeader">Valid Until</Td>
			<Td class="tdListRightHeader">Setting</Td>

</TR>
EOF;
$this->window_no=0;
$this->showPermissionTableDetail($groupid,$mid,0,$level);
	echo "<TR><TD>
		<INPUT TYPE='hidden' value='save' name='action'>
		<INPUT TYPE='submit' value='save' name='submit'>
		<INPUT TYPE='hidden' value='$mid' name='findmodule_id'>
		<INPUT TYPE='hidden' value='$this->window_no' name='linecount'>
		</form></TD></TR></TBODY> </TABLE>";


  }


  public function showPermissionTableDetail($groupid,$mid,$window_id,$level){

   $sql="SELECT w.window_id,w.window_name,w.filename,w.parentwindows_id,w.seqno,w.windowsetting,
                w2.window_name as parentname,m.name as module_name,
                (SELECT permissionsetting FROM
                    sim_permission p WHERE p.groupid=$groupid and window_id=w.window_id) as permissionsetting,
                (SELECT validuntil FROM
                    sim_permission p WHERE p.groupid=$groupid and window_id=w.window_id) as validuntil,
                (SELECT iswriteperm FROM
                    sim_permission p WHERE p.groupid=$groupid and window_id=w.window_id) as iswriteperm,
                (SELECT groupid FROM
                    sim_permission p WHERE p.groupid=$groupid and window_id=w.window_id) as groupid
               FROM sim_window w
               LEFT JOIN sim_modules m on m.mid=w.mid
               LEFT JOIN sim_window w2 on w2.window_id=w.parentwindows_id
               WHERE w.window_id>0 and w.mid=$mid and w.parentwindows_id=$window_id
                    order by m.name, w2.window_name, w.seqno";

	$this->log->showLog(4,"With SQL: $sql");


        $i=0;



	$checked="";
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
                $this->window_no++;
		$filename=$row['filename'];
		$window_name=$row['window_name'];
                for($j=0;$j<$level;$j++)
                    $window_name= "&nbsp;&nbsp;&nbsp;&nbsp;$window_name";
		$window_id=$row['window_id'];
		$parentname=$row['parentname'];
		$description=str_replace("\n", "<br/>", $row['description']);
                $iswriteperm=$row['iswriteperm'];
                $seqno=$row['seqno'];
                $module_name=$row['module_name'];
		$newgroupid=$row['groupid'];
                $windowsetting=$row['windowsetting'];
                $permissionsetting=htmlspecialchars($row['permissionsetting']);
                $validuntil=$row['validuntil'];
	if($newgroupid>0)
	$checked="checked";
	else
	$checked="";

        if($iswriteperm>0)
	$writechecked="checked";
	else
	$writechecked="";


	if($rowtype=='odd')
		$rowtype='even';
	else
		$rowtype='odd';
	$i=$this->window_no-1;
	echo <<< EOF

		<TR>	<TD class="$rowtype">$this->window_no</TD>
			<TD class="$rowtype">$window_name</TD>
			<TD class="$rowtype">$module_name</TD>
			<TD class="$rowtype">$filename</TD>
			<TD class="$rowtype">$description</TD>
			<TD class="$rowtype">$seqno</TD>
			<TD class="$rowtype"><INPUT type='checkbox' name="lineallow[$i]" $checked></TD>
			<TD class="$rowtype"><INPUT type='checkbox' name="lineallowwrite[$i]" $writechecked>
					<input type='hidden' name='linewindow_id[$i]' value='$window_id'></TD>
			<TD class="$rowtype"><INPUT name="linevaliduntil[$i]" value="$validuntil" size="10"></TD>
			<TD class="$rowtype"><INPUT name="linepermissionsetting[$i]"  value="$permissionsetting" size="60" title="option:description"></TD>
		</TR>

EOF;

    $this->showPermissionTableDetail($groupid,$mid,$window_id,$level+1);
	}
  }

  public function updatePermission(){
	$timestamp= date("y/m/d H:i:s", time()) ;

	$this->log->showLog(4,"Accessing updatePermission with groupid=$this->groupid");
	 $sqldel="DELETE FROM sim_permission where groupid=$this->groupid and
                        window_id in (select w.window_id from sim_window w where mid=$this->findmodule_id)";
	$this->log->showLog(4,"With SQL1: $sqldel");
	$result=$this->xoopsDB->query($sqldel);
	if($result)
	{
		$i=0;
		foreach($this->linewindow_id as $winid){
		//if allow access, add record into table
		if($this->lineallow[$i]=='on'){
                    if($this->lineallowwrite[$i]=='on')
                        $allowwritevalue=1;
                     else
                     $allowwritevalue=0;
                     $permissionsetting=$this->linepermissionsetting[$i];
                     $validuntil=$this->linevaliduntil[$i];
			$sqlinsert="INSERT INTO sim_permission (window_id,groupid,updated,updatedby,
				created,createdby,permissionsetting,validuntil,iswriteperm) VALUES
                                ($winid,$this->groupid,'$timestamp',$this->updatedby,'$timestamp',
                            $this->createdby,'$permissionsetting','$validuntil',
                                $allowwritevalue)";

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


function showMenu($parentwindows_id,$level,$uid,$module_id){
            $currentdate=date("Y-m-d",time());

    $output = "";
  $sql="SELECT distinct(w.window_id),w.window_name, w.filename, m.name as modulename,m.dirname
                from sim_groups g
		inner join sim_groups_users_link gul on g.groupid=gul.groupid
		inner join sim_users u on gul.uid=u.uid
		inner join sim_group_permission gp on gp.gperm_groupid=g.groupid
		inner join sim_modules m on gp.gperm_itemid=m.mid
		inner join sim_permission gsp on gsp.groupid=g.groupid
		inner join sim_window w on gsp.window_id=w.window_id
		where m.mid=$module_id and gp.gperm_name='module_read'
                    and w.mid=$module_id
                    and w.parentwindows_id=$parentwindows_id and u.uid=$uid and
                    w.isactive=1 and w.window_id>0
                  and ( gsp.validuntil = '0000-00-00' OR gsp.validuntil >= '$currentdate') order by w.seqno";

  $level++;
 $query=$this->xoopsDB->query($sql);
    while($row=$this->xoopsDB->fetchArray($query)){
        $prefix="";
        for($i=0;$i<$level;$i++)
        $prefix.="&nbsp;";
        if($row['filename']!=""){
           $linkname=" href='".$row['filename']."'";
           $cssclass="";
        }
        else{
            $cssclass="class='parent'";
            $linkname="";
        }


        $output .= "<li><a $linkname $cssclass><span>".$row['window_name']."</span></a><ul>";


        $output .= $this->showMenu($row['window_id'],$level,$uid,$module_id);
        $output .= "</ul></li>";
    }

    return $output;
    //echo "";
}

  public function checkPermission($uid,$module_id,$usefilename){
        $currentdate=date("Y-m-d",time());
	$this->log->showLog(3, "checkPermission(uid=$uid,module_id=$module_id,usefilename=$usefilename)");
        $sql="select distinct(w.window_id) as window_id,w.helpurl,
		w.window_name, gsp.iswriteperm, gsp.permissionsetting ,w.seqno,w.filename,
            w.windowsetting,w.mid
		from sim_groups g
		inner join sim_groups_users_link gul on g.groupid=gul.groupid
		inner join sim_users u on gul.uid=u.uid
		inner join sim_group_permission gp on gp.gperm_groupid=g.groupid
		inner join sim_modules m on gp.gperm_itemid=m.mid
		inner join sim_permission gsp on gsp.groupid=g.groupid
		inner join sim_window w on gsp.window_id=w.window_id
		where w.mid=$module_id and w.filename='$usefilename' and w.isdeleted=0
                and gp.gperm_name='module_read' and u.uid=$uid
                and ( gsp.validuntil = '0000-00-00' OR gsp.validuntil >= '$currentdate') order by gsp.iswriteperm DESC,gsp.permissionsetting DESC";

	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);

	if($usefilename=='index.php')
		return array("Home",0,"","");
	elseif ($row=$this->xoopsDB->fetchArray($query))
		return array($row['window_name'],$row['iswriteperm'],$row['windowsetting'],$row['permissionsetting'],$row['helpurl']);
	else
 		return array("",0,0,"","");

 }




 public function orgWhereStr($uid){
	$this->log->showLog(3,"Generate sqlstring for user to see available organization data for uid : $uid");
	$sql="SELECT organization_id from sim_organization o
		INNER JOIN sim_groups_users_link ug on o.groupid=ug.groupid
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
	$tableusers="sim_users";
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
   
   
function showReportList($parentwindows_id,$level,$uid,$module_id){
            $currentdate=date("Y-m-d",time());

    $output = "";
  $sql="SELECT distinct(w.window_id),w.window_name, w.filename, m.name as modulename,m.dirname
                from sim_groups g
		inner join sim_groups_users_link gul on g.groupid=gul.groupid
		inner join sim_users u on gul.uid=u.uid
		inner join sim_group_permission gp on gp.gperm_groupid=g.groupid
		inner join sim_modules m on gp.gperm_itemid=m.mid
		inner join sim_permission gsp on gsp.groupid=g.groupid
		inner join sim_window w on gsp.window_id=w.window_id
		where m.mid=$module_id and gp.gperm_name='module_read'
                    and w.mid=$module_id
                    and w.parentwindows_id=$parentwindows_id and u.uid=$uid and
                    w.isactive=1 and w.window_id>0
                  and ( gsp.validuntil = '0000-00-00' OR gsp.validuntil >= '$currentdate') order by w.seqno";

  $level++;
 $query=$this->xoopsDB->query($sql);
    while($row=$this->xoopsDB->fetchArray($query)){
        $prefix="";
        $wid=$row['window_id'];
        $wname=$row['window_name'];
        $filename=$row['filename'];
        for($i=0;$i<$level;$i++)
        $prefix.="&nbsp;";
        if($row['filename']!=""){
           $linkname=" onclick='getParam($wid,\"$filename\",\"$wname\")'";
           $cssclass="";
        }
        else{
            $cssclass="class='parent'";
            $linkname="";
        }


        $output .= "<li id='li$wid' name='rr[]'><a $linkname $cssclass><span>".$row['window_name']."</span></a><ul>";


        $output .= $this->showReportList($row['window_id'],$level,$uid,$module_id);
        $output .= "</ul></li>";
    }

    return $output;
    //echo "";
}
}

