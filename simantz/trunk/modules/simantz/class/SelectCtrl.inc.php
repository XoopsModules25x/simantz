<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class SelectCtrl{
    public $log;
    public $xoopsDB;

    public function SelectCtrl(){
    global $xoopsDB,$log,$module_id;

  	$this->xoopsDB=$xoopsDB;
	$this->defaultorganization_id=$defaultorganization_id;
	$this->log=$log;
        }

public function getSelectModule($id,$showNull='Y',$controlname="mid",$controlid="mid",$onchangefunction=""){

	$sql="SELECT mid,name from sim_modules where weight>0 order by weight ";

	//$selectctl="<SELECT name=\"$controlname\" id=\"$controlid\" $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$mid=$row['mid'];
		$name=$row['name'];

		if($id==$mid)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value=\"$mid\" $selected>$name</OPTION>";

	}

	//$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
}

public function selectionOrg($uid,$id,$showNull='N',$onchangefunction="",$ishide='N'){
        global $tablegroups_users_link,$tableorganization ;
        //location.href='index.php?switchorg=Y&defaultorganization_id='+this.value
	$this->log->showLog(3,"Retrieve available organization (select organization_id: $id) to employee_id : $uid, ishide=$ishide");
        $sql="SELECT distinct(organization_id) as organization_id,organization_code from $tableorganization o
		INNER JOIN  $tablegroups_users_link ug on o.groupid=ug.groupid where o.organization_id>0 and isactive=1 and ug.uid=$uid";

	$this->log->showLog(3,"Wtih SQL: $sql");
	$selectctl="<SELECT id='organization_id' name='organization_id' onchange=\"$onchangefunction\">";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
		$organization_id=$row['organization_id'];
		$organization_code=$row['organization_code'];

		if($id==$organization_id){
			$selected='SELECTED="SELECTED"';

			$selectedcode=$organization_code;
			if($ishide=="Y")
				return "<input readonly='readonly' name='organization_code' value='$selectedcode'>
					<input  type='hidden' name='organization_id' value='$id'>";
		}
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$organization_id' $selected>$organization_code</OPTION>";
		$i++;
	}


	if($ishide=="Y")
	return "<input readonly='readonly' name='organization_code' value='$selectedcode/$id'>";

	$selectctl=$selectctl . "</SELECT><input type='hidden' name='organization_code' value='$selectedcode'>";
	$errmsg="";
	if($i==0)
		$errmsg="<b style='color:red'><small><small><small>
			Warning! No organization found! Please follow step by step to create new organization.</small></small></small></b>";
	return $selectctl . $errmsg;
  }

  
  public function getSelectionOrg($uid,$id,$showNull='N' , $onchangefunction="",$ishide='N'){
        global $tablegroups_users_link,$tableorganization ;
        //location.href='index.php?switchorg=Y&defaultorganization_id='+this.value
        $class_name = "class ='selectfield1' ";

	$this->log->showLog(3,"Retrieve available organization (select organization_id: $id) to employee_id : $uid, ishide=$ishide");
	$sql="SELECT distinct(organization_id) as organization_id,organization_code from $tableorganization o
		INNER JOIN  $tablegroups_users_link ug on o.groupid=ug.groupid where o.organization_id>0 and isactive=1";

	$this->log->showLog(3,"Wtih SQL: $sql");
	$selectctl="";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
		$organization_id=$row['organization_id'];
		$organization_code=$row['organization_code'];

		if($id==$organization_id){
			$selected='SELECTED="SELECTED"';

			$selectedcode=$organization_code;
			if($ishide=="Y")
				return "<input readonly='readonly' name='organization_code' value='$selectedcode'>
					<input  type='hidden' name='organization_id' value='$id'>";
		}
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$organization_id' $selected>$organization_code</OPTION>";
		$i++;
	}


	if($ishide=="Y")
	return "<input readonly='readonly' name='organization_code' value='$selectedcode/$id'>";

	$selectctl=$selectctl . "<input type='hidden' name='organization_code' value='$selectedcode'>";
	$errmsg="";
	if($i==0)
		$errmsg="<b style='color:red'><small><small><small>
			Warning! No organization found! Please follow step by step to create new organization.</small></small></small></b>";
	return $selectctl . $errmsg;


  }


public function selectionOrganization($uid,$id,$showNull='N',$onchangefunction="location.href='index.php?switchorg=Y&defaultorganization_id='+this.value",$ishide='N'){
        global $tablegroups_users_link,$tableorganization ;
	$this->log->showLog(3,"Retrieve available organization (select organization_id: $id) to employee_id : $uid, ishide=$ishide");
	$sql="SELECT distinct(organization_id) as organization_id,organization_code from $tableorganization o
		INNER JOIN  $tablegroups_users_link ug on o.groupid=ug.groupid where o.organization_id>0 and isactive=1";

	$this->log->showLog(3,"Wtih SQL: $sql");
	//$selectctl="<SELECT name='organization_id' onchange=\"$onchangefunction\">";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
		$organization_id=$row['organization_id'];
		$organization_code=$row['organization_code'];

		if($id==$organization_id){
			$selected='SELECTED="SELECTED"';

			$selectedcode=$organization_code;
			if($ishide=="Y")
				return "<input readonly='readonly' name='organization_code' value='$selectedcode'>
					<input  type='hidden' name='organization_id' value='$id'>";
		}
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$organization_id' $selected>$organization_code</OPTION>";
		$i++;
	}


	if($ishide=="Y")
	return "<input readonly='readonly' name='organization_code' value='$selectedcode/$id'>";

	//$selectctl=$selectctl . "<input type='hidden' name='organization_code' value='$selectedcode'>";
	$errmsg="";
	if($i==0)
		$errmsg="<b style='color:red'><small><small><small>
			Warning! No organization found! Please follow step by step to create new organization.</small></small></small></b>";
	return $selectctl . $errmsg;


  }

public function getAllSystemGroup($gid){
       global $tablegroups;
	$this->log->showLog(3,"Retrieve available system groups from database, with preselect id: $id");
	$sql="SELECT groupid,name FROM $tablegroups";
	$this->log->showLog(3,"Retrieve available system groups with sql:$sql");

	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='groupid' >";



	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$groupid=$row['groupid'];
		$name=$row['name'];

		if($gid==$groupid)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$groupid' $selected>$name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;



  } //getAllSystemGroup

public function getUserGroup($gid,$showNull='Y'){
       global $tablegroups;
	$this->log->showLog(3,"Retrieve available system groups from database, with preselect id: $id");
	$sql="SELECT groupid,name FROM $tablegroups WHERE groupid>1";
	$this->log->showLog(3,"Retrieve available system groups with sql:$sql");
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$selected="";
        	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	while($row=$this->xoopsDB->fetchArray($query)){
		$groupid=$row['groupid'];
		$name=$row['name'];
		if($gid==$groupid)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$groupid' $selected>$name</OPTION>";
	}

	return $selectctl;



  } //getAllSystemGroup

public function getSelectCountry($id,$showNull='Y') {
    global $tablecountry;
	 $sql=sprintf("SELECT country_id,country_name from $tablecountry where (isactive=1 or country_id= %d) and country_id>0
		order by seqno,country_name",$id);
	$this->log->showLog(4,"getSelectCountry With SQL: $sql");

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$country_id=$row['country_id'];
		$country_name=$row['country_name'];

		if($id==$country_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value="."'$country_id' $selected>$country_name</OPTION>";

	}
// echo "<textarea>$selectctl</textarea>";
	return $selectctl;
  } // end

public function getSelectCurrency($id,$showNull='Y',$ctrlname='currency_id',$wherestr="",$onchangefunction="") {

  global $tablecurrency;
	$sql="SELECT currency_id,currency_code from $tablecurrency where (isactive=1 or currency_id='$id') and currency_id>0
		$wherestr order by seqno,currency_name ;";
$this->log->showLog(4,"getSelectCurrency With SQL: $sql");
	//$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$currency_id=$row['currency_id'];
		$currency_code=$row['currency_code'];

		if($id==$currency_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$currency_id' $selected>$currency_code</OPTION>";

	}

	//$selectctl=$selectctl . "</SELECT>";
 //       echo "<textarea>$selectctl</textarea>";
	return $selectctl;
  } // end

public function getSelectRaces($id,$showNull='N',$wherestr='') {

	$sql=sprintf("SELECT races_id,races_name from sim_races where (races_id= %d OR races_id > 0) and isactive = 1 $wherestr
		order by seqno asc, races_name ASC",$id);

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$races_id=$row['races_id'];
		$races_name=$row['races_name'];
		if($id==$races_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$races_id' $selected>$races_name</OPTION>";
	}

	return $selectctl;
  }
  
public function getSelectDialect($id,$showNull='N',$wherestr='') {

	$sql=sprintf("SELECT dialect_id,dialect_name from sim_dialect where (dialect_id= '%d' OR isactive = 1) and dialect_id > 0 $wherestr
		order by seqno asc, dialect_name ASC",$id);

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$dialect_id=$row['dialect_id'];
		$dialect_name=$row['dialect_name'];
		if($id==$dialect_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$dialect_id' $selected>$dialect_name</OPTION>";
	}

	return $selectctl;
  }

public function getSelectReligion($id,$showNull='N',$wherestr='') {

	$sql=sprintf("SELECT religion_id,religion_name from sim_religion where (religion_id= '%d' OR religion_id>0) and isactive='1' $wherestr
		order by seqno asc, religion_name ASC",$id);

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$religion_id=$row['religion_id'];
		$religion_name=$row['religion_name'];
		if($id==$religion_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$religion_id' $selected>$religion_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectEmployeeStatus($id,$showNull='N',$wherestr='') {

	$sql=sprintf("SELECT * from sim_hr_employeestatus where (employeestatus_id= %d OR employeestatus_id>0) and isactive='1' $wherestr
		order by employeestatus_name asc",$id);

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
	$this->log->showLog(4,"getSelectEmployeeStatus With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$employeestatus_id=$row['employeestatus_id'];
		$employeestatus_name=$row['employeestatus_name'];
		if($id==$employeestatus_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$employeestatus_id' $selected>$employeestatus_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectRelationship($id,$showNull='N') {

	$sql="SELECT relationship_id,relationship_name from sim_hr_relationship where (relationship_id='$id'
		OR relationship_id>0) and isactive='1' $wherestr
		order by relationship_name desc ;";

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";

	while($row=$this->xoopsDB->fetchArray($query)){
		 $relationship_id=$row['relationship_id'];
		$relationship_name=$row['relationship_name'];
		if($id==$relationship_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$relationship_id' $selected>$relationship_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectMaritalStatus($id,$showNull='N') {

	$sql="SELECT maritalstatus_id,maritalstatus_name from sim_hr_maritalstatus where (maritalstatus_id='$id'
		OR maritalstatus_id>0) and isactive='1' $wherestr
		order by maritalstatus_name asc ;";

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";

	while($row=$this->xoopsDB->fetchArray($query)){
		 $maritalstatus_id=$row['maritalstatus_id'];
		$maritalstatus_name=$row['maritalstatus_name'];
		if($id==$maritalstatus_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$maritalstatus_id' $selected>$maritalstatus_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectLeavetype($id,$showNull='N',$wherestr) {

	$sql="SELECT leavetype_id,leavetype_name from sim_hr_leavetype where (leavetype_id='$id'
		OR leavetype_id>0) and isactive='1' $wherestr
		order by seqno asc, leavetype_name asc ;";

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">All</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";

	while($row=$this->xoopsDB->fetchArray($query)){
		 $leavetype_id=$row['leavetype_id'];
		$leavetype_name=$row['leavetype_name'];
		if($id==$leavetype_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$leavetype_id' $selected>$leavetype_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectPeriod($id,$showNull='N',$wherestr='') {

	//and isactive=1
        $sql="SELECT period_id,period_name from sim_period where (
		period_id>0) $wherestr
		order by seqno,period_name desc;";
	$this->log->showLog(4,"getSelectPeriod With SQL: $sql");

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$period_id=$row['period_id'];
		$period_name=$row['period_name'];
		if($id==$period_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$period_id' $selected>$period_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectEmployeeletter($id,$showNull='N',$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT studentletter_id,studentletter_name from sim_simedu_studentletter where (studentletter_id=$id
		OR studentletter_id>0) and isactive=1 $wherestr
		order by studentletter_name ;";
	$this->log->showLog(4,"getSelectEmployeeletter With SQL: $sql");

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$studentletter_id=$row['studentletter_id'];
		$studentletter_name=$row['studentletter_name'];
		if($id==$studentletter_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$studentletter_id' $selected>$studentletter_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectBPartnerGroup($id,$showNull='N') {

	$sql="SELECT bpartnergroup_id,bpartnergroup_name from sim_bpartnergroup where (bpartnergroup_id=$id
		OR bpartnergroup_id>0) and isactive=1 
		order by seqno,bpartnergroup_name asc;";
	$this->log->showLog(4,"getSelectBPartnerGroup With SQL: $sql");

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$bpartnergroup_id=$row['bpartnergroup_id'];

		$bpartnergroup_name=$row['bpartnergroup_name'];
		if($id==$bpartnergroup_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$bpartnergroup_id' $selected>$bpartnergroup_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectIndustry($id,$showNull='N') {

	$sql="SELECT industry_id,industry_name from sim_industry where isactive=1 and industry_id>0 order by industry_name asc;";
	$this->log->showLog(3,"Generate Industry list with with SQL($id,$showNull): $sql");
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$industry_id=$row['industry_id'];
		$industry_name=$row['industry_name'];

		if($id==$industry_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$industry_id' $selected>$industry_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectDepartment($id,$showNull='N',$wherestr='') {

	$sql=sprintf("SELECT department_id,department_name from sim_hr_department where (department_id= %d OR department_id>0) and isactive='1' $wherestr
		order by seqno asc, department_name ASC",$id);

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$department_id=$row['department_id'];
		$department_name=$row['department_name'];
		if($id==$department_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$department_id' $selected>$department_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectWorkflowStatus($id,$showNull='N') {

	$sql=sprintf("SELECT workflowstatus_id,workflowstatus_name from sim_workflowstatus where (workflowstatus_id= %d OR workflowstatus_id>0) and isactive='1' $wherestr
		order by workflowstatus_name ASC",$id);

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$workflowstatus_id=$row['workflowstatus_id'];
		$workflowstatus_name=$row['workflowstatus_name'];
		if($id==$workflowstatus_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$workflowstatus_id' $selected>$workflowstatus_name</OPTION>";

	}

	return $selectctl;
  }

   public function getSelectYear($id,$showNull='N',$wherestr='') {

	$sql=sprintf("SELECT year_name from sim_year where (year_name= %d OR year_name>0) and isactive='1' $wherestr
		order by year_name asc",$id);

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$year_name=$row['year_name'];
		if($id==$year_name)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$year_name' $selected>$year_name</OPTION>";

	}

	return $selectctl;
  }

public function getSelectTracking($id,$showNull='N',$wherestr="") {

	$sql=sprintf("SELECT * FROM sim_simbiz_track where track_id > 0 AND isactive = 1 $wherestr
		order by seqno ASC,track_name ASC",$id);

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$track_id=$row['track_id'];
		$track_name=$row['track_name'];
		if($id==$track_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$track_id' $selected>$track_name</OPTION>";

	}

	return $selectctl;
  }


 public function getSelectUsers($id,$showNull='N',$onchangefunction="",$ctrlname="uid",$wherestr='') {
	global $defaultorganization_id,$tableusers;


	 $sql="SELECT uid, uname from $tableusers where (uid=$id
		OR uid>0) and uid>0 $wherestr
		order by uname ;";
	$this->log->showLog(4,"getSelectUsername With SQL: $sql");
	//$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

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

	//$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }


  public function getSelectRegion($id,$showNull='N') {

	$sql="SELECT region_id,region_name from $this->tableregion where (isactive=1 or region_id=$id)
            and region_id>0 order by region_name and organization_id=$this->defaultorganization_id";
	$this->log->showLog(3,"Generate Region list with id=:$id and shownull=$showNull SQL: $sql");
	//$selectctl="<SELECT name='region_id' >";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$region_id=$row['region_id'];
		$region_name=$row['region_name'];

		if($id==$region_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$region_id' $selected>$region_name</OPTION>";

	}

	//$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end
}
