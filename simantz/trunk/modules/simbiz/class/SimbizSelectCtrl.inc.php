<?php
class SimbizSelectCtrl extends SelectCtrl{

    public function SimbizSelectCtrl(){

    global $xoopsDB,$log;
    $this->xoopsDB=$xoopsDB;
    $this->log=$log;
    }

  public function getSelectAccounts($id,$showNull='N',$onchangefunction="",$ctrlname="accounts_id",$wherestr='',$readonly='N',$isparent="N",$showlastbalance='N',
		$ctrlid='accounts_id',$width="") {
			        global $tableaccounts,$tableaccountclass,$tableaccountgroup,$tableaccounts,$defaultorganization_id;
	if($isparent == "N")
	$wherestr .= " and a.placeholder = 0 ";

	$orderby = " order by a.accountcode_full ";
        if($readonly=="Y")
	$sql=	"SELECT a.accounts_id,a.accounts_code,a.accounts_name,a.accountcode_full,a.lastbalance
		from $tableaccounts a
		inner join $tableaccountgroup g on a.accountgroup_id=g.accountgroup_id
		inner join $tableaccountclass c on c.accountclass_id=g.accountclass_id
		where a.accounts_id=$id and a.organization_id=$defaultorganization_id
		and c.classtype <> '8M'
		$wherestr  $orderby;";
        else
	 $sql=	"SELECT a.accounts_id,a.accounts_code,a.accounts_name,a.accountcode_full,a.lastbalance
		from $tableaccounts a
		inner join $tableaccountgroup g on a.accountgroup_id=g.accountgroup_id
		inner join $tableaccountclass c on c.accountclass_id=g.accountclass_id
		where (a.accounts_id=$id
		OR a.accounts_id>0) and a.organization_id=$defaultorganization_id
		and c.classtype <> '8M'
		$wherestr
		$orderby ;";



	$this->log->showLog(4,"getSelectAccounts With SQL: $sql");
	$query=$this->xoopsDB->query($sql);


	if(!$query){
	return "<input type='hidden' name='$ctrlname' value='0' $onchangefunction>";
	}else{

	$selectctl="<SELECT name='$ctrlname' $onchangefunction  id='$ctrlid' $width  onmouseover='tooltip(this)'>";
	if ($showNull=='Y'){
		if($id<1)
		$selectnull = "SELECTED='SELECTED'";
		else
		$selectnull = "";
	$selectctl=$selectctl . "<OPTION value='0' $selectnull>Null </OPTION>";
	}



	$selected='';
	while($row=$this->xoopsDB->fetchArray($query)){
		$accounts_id=$row['accounts_id'];
		$accounts_code=$row['accounts_code'];
		$accounts_name=$row['accounts_name'];
		$accountcode_full=$row['accountcode_full'];
		$lastbalance=$row['lastbalance'];

		if($lastbalance>0)
			$lastbalance="(Dr $lastbalance)";
		elseif($lastbalance<0)
			$lastbalance="(Cr $lastbalance)";
		else
			$lastbalance="";

		if($id==$accounts_id)
			$selected="SELECTED='SELECTED'";
		else
			$selected="";

		if($showlastbalance=='N')
			$lastbalance="";
		$selectctl=$selectctl  . "<OPTION value='$accounts_id' $selected>$accountcode_full-$accounts_name $lastbalance</OPTION>";

	}

	


        }

$selectctl=$selectctl . "</SELECT>";


	return $selectctl;
  }


public function getSelectAccountsAjax($id,$showNull='N',$onchangefunction="",$ctrlname="accounts_id",$wherestr='',$readonly='N',$isparent="N",$showlastbalance='N',
		$ctrlid='accounts_id',$width="",$showsearch="N",$line=0) {
                global $tableaccounts,$defaultorganization_id;
                
	if($isparent == "N")
	$wherestr .= " and placeholder = 0 ";

	//$orderby = " order by defaultlevel,accounts_code,accounts_name ";
	$orderby = " order by accountcode_full ";

	if($readonly=='Y')
	$sql=	"SELECT accounts_id,accounts_code,accounts_name,accountcode_full,lastbalance from $tableaccounts
		where accounts_id=$id and organization_id=$defaultorganization_id $wherestr
		$orderby ;";
	else
	$sql=	"SELECT accounts_id,accounts_code,accounts_name,accountcode_full,lastbalance from $tableaccounts where (accounts_id=$id
		OR accounts_id>0) and organization_id=$defaultorganization_id $wherestr
		$orderby ;";



	$this->log->showLog(4,"getSelectAccounts With SQL: $sql");
	$query=$this->xoopsDB->query($sql);

	if(!$query){
	return "<input type='hidden' name='$ctrlname' value='0' $onchangefunction>";
	}else{

	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid' $width  onmouseover='tooltip(this)'>";
	if ($showNull=='Y'){
		if($id<1)
		$selectnull = "SELECTED='SELECTED'";
		else
		$selectnull = "";
	$selectctl=$selectctl . "<OPTION value='0' $selectnull>Null </OPTION>";
	}


	$selected='';
	while($row=$this->xoopsDB->fetchArray($query)){
		$accounts_id=$row['accounts_id'];
		$accounts_code=$row['accounts_code'];
		$accounts_name=$row['accounts_name'];
		$accountcode_full=$row['accountcode_full'];
		$lastbalance=$row['lastbalance'];

		if($lastbalance>0)
			$lastbalance="(Dr $lastbalance)";
		elseif($lastbalance<0)
			$lastbalance="(Cr $lastbalance)";
		else
			$lastbalance="";

		if($id==$accounts_id)
			$selected="SELECTED='SELECTED'";
		else
			$selected="";

		if($showlastbalance=='N')
			$lastbalance="";
		$selectctl=$selectctl  . "<OPTION value='$accounts_id' $selected>$accountcode_full-$accounts_name $lastbalance</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	}


	if($showsearch=="Y"){//ajax list
	$idinput = $ctrlname."InputLayer".$ctrlid;
	$idlayer = $ctrlname."FormLayer".$ctrlid;

	if($onchangefunction == "")
	$onchangefunction = "0";
	else
	$onchangefunction = "1";

//	$selectctl=$selectctl . "<input type='button' value='...' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
//        $selectctl = $selectctl.$this->getZommCtrl('accounts_id',$ctrlid,'accounts.php');
//	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput' style='display:none' autocomplete=off  onkeyup=getListDB('getlistdbaccount',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line')>";
//	$selectctl=$selectctl . "<div id='$idlayer'></div>";
	}//ajax list

	if($readonly=='Y')
	return "<input type='hidden' name='$ctrlname' value='$id'><input name='accounts_desc' value='$accountcode_full-$accounts_name' readonly='readonly'  id='$ctrlid' $onchangefunction>";


	return $selectctl;
  }

   public function getSelectPeriod($id,$showNull='N',$onchangefunction="",$ctrlname="period_id",$ctrlid="period_id",$wherestr='') {
   global $tableperiod;
	//and isactive=1
	 $sql="SELECT period_id,period_name from $tableperiod where (period_id=$id
		OR period_id>0) $wherestr
		order by seqno,period_name asc;";
	$this->log->showLog(4,"getSelectPeriod With SQL: $sql");
$selectctl="<select name='$ctrlname' id='$ctrlid' $onchangefunction>";
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
        $selectctl.="</select>";
	return $selectctl;
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
	//$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid' $width onmouseover='tooltip(this)'>";
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

	//$selectctl=$selectctl . "</SELECT>";
  	//$selectctl .= getZommCtrl($ctrlname,'../../system/bpartner.php');

	return $selectctl;
  }



}
?>
