<?php
class BPSelectCtrl extends SelectCtrl{

    public function BPSelectCtrl(){

    global $xoopsDB,$log;
    $this->xoopsDB=$xoopsDB;
    $this->log=$log;
    }


public function getSelectBPartner($id,$showNull='N',$onchangefunction="",$ctrlname="bpartner_id",$wherestr="",$showLastBalance='N',
		$ctrlid="bpartner_id",$width="") {
	global $tablebpartner,$defaultorganization_id;
	 $sql="SELECT bpartner_id,bpartner_name,currentbalance
		from $tablebpartner where (bpartner_id=$id
		OR bpartner_id>0) and isactive=1 AND organization_id=$defaultorganization_id
		$wherestr
		order by seqno,bpartner_name ;";
	$this->log->showLog(4,"getSelectBPartner With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid' $width onmouseover='tooltip(this)'>";
	if ($showNull=='Y')
		$selectctl=$selectctl . "<OPTION value='0' SELECTED='SELECTED' >Null </OPTION>";

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$bpartner_id=$row['bpartner_id'];

		$bpartner_name=$row['bpartner_name'];
		$lastbalance=number_format($row['currentbalance'],2);

		if($showLastBalance=='N' || $lastbalance==0)
			$lastbalance="";
		if($id==$bpartner_id)
			$selected="SELECTED='SELECTED'";
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$bpartner_id' $selected>$bpartner_name $lastbalance</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
  	//$selectctl .= getZommCtrl($ctrlname,'../../system/bpartner.php');

	return $selectctl;
  }


public function getSelectTerms($id,$showNull='N'){
global $defaultorganization_id,$tableterms;

	$this->log->showLog(3,"Retrieve available system groups from database, with preselect id: $id");
	$sql="SELECT terms_id,terms_name FROM $tableterms where (isactive=1 or terms_id=$id) 
		AND terms_id>0 and organization_id=$defaultorganization_id
		ORDER by seqno,terms_name	";
	$this->log->showLog(3,"Retrieve available system groups with sql:$sql");
	
	$this->log->showLog(4,"SQL: $sql");

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$terms_id=$row['terms_id'];
		$terms_name=$row['terms_name'];
	
		if($id==$terms_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$terms_id' $selected>$terms_name</OPTION>";

	}

	return $selectctl;
	

  }


public function getSelectBPartnerGroup($id,$showNull='N') {
	global $tablebpartnergroup,$defaultorganization_id;
	 $sql="SELECT bpartnergroup_id,bpartnergroup_name from $tablebpartnergroup where (bpartnergroup_id='$id'
		OR bpartnergroup_id>0) and isactive=1 AND organization_id=$defaultorganization_id
		order by seqno,bpartnergroup_name ;";
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
	global $tablebpartnergroup,$defaultorganization_id;
        
	$sql="SELECT industry_id,industry_name from sim_industry where (isactive=1 or industry_id=$id) and industry_id>0 AND organization_id=$defaultorganization_id order by industry_name asc;";
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
}
?>
