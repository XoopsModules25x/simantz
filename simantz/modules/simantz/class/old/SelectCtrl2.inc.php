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

	$sql="SELECT mid,name from sim_modules order by weight";

	$selectctl="<SELECT name=\"$controlname\" id=\"$controlid\">";
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

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
}

/*
public function selectionOrg($uid,$id,$showNull='N',$onchangefunction="location.href='index.php?switchorg=Y&defaultorganization_id='+this.value",$ishide='N'){

	$this->log->showLog(3,"Retrieve available organization (select organization_id: $id) to employee_id : $uid, ishide=$ishide");
	 $sql="SELECT distinct(organization_id) as organization_id,organization_code from sim_organization o
		INNER JOIN sim_groups_users_link ug on o.groupid=ug.groupid where o.organization_id>0";


	$this->log->showLog(3,"Wtih SQL: $sql");
	$selectctl="<SELECT name='organization_id' onchange=\"$onchangefunction\">";
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
 * 
 */
 
 public function getSelectBPartnerGroupAjaxN($recordid=0,$ctrlid="bpartnergroup_id",$onchangefunction="",$filterstring="",$mode="classic",$initialsearch=""){
 	$this->log->showLog(2,"Call getSelectBPartnerGroup($id,$ctrlid,$onchangefunction,$filterstring,$mode) from select control");
        global $nitobicombothemes;
        $selection="<ntb:Combo id=\"$ctrlid\" Mode=\"$mode\" theme=\"$nitobicombothemes\" initialsearch=\"$initialsearch\">
        <ntb:ComboTextBox DataFieldIndex=1 width=\"200px\"></ntb:ComboTextBox>
        <ntb:ComboList DatasourceUrl=\"selection.php?action=bpartnergroup\" PageSize=\"5\" width=\"480px\" >
        <ntb:ComboColumnDefinition HeaderLabel=\"ID\" DataFieldIndex=0  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Name\" DataFieldIndex=1  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Active\" DataFieldIndex=2  width=\"40px\"></ntb:ComboColumnDefinition>
        </ntb:ComboList>
        </ntb:Combo>";

    return $selection;
 }

 public function getSelectIndustryAjaxN($recordid=0,$ctrlid="industry_id",$onchangefunction="",$filterstring="",$mode="classic",$initialsearch=""){
 	$this->log->showLog(2,"Call getSelectIndustry($id,$ctrlid,$onchangefunction,$filterstring,$mode) from select control");
        global $nitobicombothemes;
        $selection="<ntb:Combo id=\"$ctrlid\" Mode=\"$mode\" theme=\"$nitobicombothemes\" initialsearch=\"$initialsearch\">
        <ntb:ComboTextBox DataFieldIndex=1 width=\"200px\"></ntb:ComboTextBox>
        <ntb:ComboList DatasourceUrl=\"selection.php?action=industry\" PageSize=\"5\" width=\"480px\" >
        <ntb:ComboColumnDefinition HeaderLabel=\"ID\" DataFieldIndex=0  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Name\" DataFieldIndex=1  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Active\" DataFieldIndex=2  width=\"40px\"></ntb:ComboColumnDefinition>
        </ntb:ComboList>
        </ntb:Combo>";

    return $selection;
 }

  public function getSelectEmployeeAjaxN($recordid=0,$ctrlid="employee_id",$onchangefunction="",$filterstring="",$mode="classic",$initialsearch=""){
 	$this->log->showLog(2,"Call getSelectEmployee($id,$ctrlid,$onchangefunction,$filterstring,$mode) from select control");
        global $nitobicombothemes;
        $selection="<ntb:Combo id=\"$ctrlid\" Mode=\"$mode\" theme=\"$nitobicombothemes\" initialsearch=\"$initialsearch\">
        <ntb:ComboTextBox DataFieldIndex=1 width=\"200px\"></ntb:ComboTextBox>
        <ntb:ComboList DatasourceUrl=\"selection.php?action=employee\" PageSize=\"5\" width=\"480px\" >
        <ntb:ComboColumnDefinition HeaderLabel=\"ID\" DataFieldIndex=0  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Name\" DataFieldIndex=1  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Active\" DataFieldIndex=2  width=\"40px\"></ntb:ComboColumnDefinition>
        </ntb:ComboList>
        </ntb:Combo>";
    return $selection;
 }

   public function getSelectTermsAjaxN($recordid=0,$ctrlid="terms_id",$onchangefunction="",$filterstring="",$mode="classic",$initialsearch=""){
 	$this->log->showLog(2,"Call getSelectTerms($id,$ctrlid,$onchangefunction,$filterstring,$mode) from select control");
        global $nitobicombothemes;
        $selection="<ntb:Combo id=\"$ctrlid\" Mode=\"$mode\" theme=\"$nitobicombothemes\" initialsearch=\"$initialsearch\">
        <ntb:ComboTextBox DataFieldIndex=1 width=\"200px\"></ntb:ComboTextBox>
        <ntb:ComboList DatasourceUrl=\"selection.php?action=terms\" PageSize=\"5\" width=\"480px\" >
        <ntb:ComboColumnDefinition HeaderLabel=\"ID\" DataFieldIndex=0  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Name\" DataFieldIndex=1  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Active\" DataFieldIndex=2  width=\"40px\"></ntb:ComboColumnDefinition>
        </ntb:ComboList>
        </ntb:Combo>";

    return $selection;
 }

    public function getSelectCurrencyAjaxN($recordid=0,$ctrlid="currency_id",$onchangefunction="",$filterstring="",$mode="classic",$initialsearch=""){
 	$this->log->showLog(2,"Call getSelectCurrency($id,$ctrlid,$onchangefunction,$filterstring,$mode) from select control");
        global $nitobicombothemes;
        $selection="<ntb:Combo id=\"$ctrlid\" Mode=\"$mode\" theme=\"$nitobicombothemes\" initialsearch=\"$initialsearch\">
        <ntb:ComboTextBox DataFieldIndex=1 width=\"200px\"></ntb:ComboTextBox>
        <ntb:ComboList DatasourceUrl=\"selection.php?action=currency\" PageSize=\"5\" width=\"480px\" >
        <ntb:ComboColumnDefinition HeaderLabel=\"ID\" DataFieldIndex=0  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Name\" DataFieldIndex=1  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Active\" DataFieldIndex=2  width=\"40px\"></ntb:ComboColumnDefinition>
        </ntb:ComboList>
        </ntb:Combo>";

    return $selection;
 }

 public function getSelectTaxAjaxN($recordid=0,$ctrlid="tax_id",$onchangefunction="",$filterstring="",$mode="classic",$initialsearch=""){
 	$this->log->showLog(2,"Call getSelectTax($id,$ctrlid,$onchangefunction,$filterstring,$mode) from select control");
        global $nitobicombothemes;
        $selection="<ntb:Combo id=\"$ctrlid\" Mode=\"$mode\" theme=\"$nitobicombothemes\" initialsearch=\"$initialsearch\">
        <ntb:ComboTextBox DataFieldIndex=1 width=\"200px\"></ntb:ComboTextBox>
        <ntb:ComboList DatasourceUrl=\"selection.php?action=currency\" PageSize=\"5\" width=\"480px\" >
        <ntb:ComboColumnDefinition HeaderLabel=\"ID\" DataFieldIndex=0  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Name\" DataFieldIndex=1  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Active\" DataFieldIndex=2  width=\"40px\"></ntb:ComboColumnDefinition>
        </ntb:ComboList>
        </ntb:Combo>";

    return $selection;
 }

  public function getSelectPriceListAjaxN($recordid=0,$ctrlid="tax_id",$onchangefunction="",$filterstring="",$mode="classic",$initialsearch=""){
 	
        $this->log->showLog(2,"Call getSelectPriceList($id,$ctrlid,$onchangefunction,$filterstring,$mode) from select control");
        global $nitobicombothemes;
        $selection="<ntb:Combo id=\"$ctrlid\" Mode=\"$mode\" theme=\"$nitobicombothemes\" initialsearch=\"$initialsearch\">
        <ntb:ComboTextBox DataFieldIndex=1 width=\"200px\"></ntb:ComboTextBox>
        <ntb:ComboList DatasourceUrl=\"selection.php?action=pricelist\" PageSize=\"5\" width=\"480px\" >
        <ntb:ComboColumnDefinition HeaderLabel=\"ID\" DataFieldIndex=0  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Name\" DataFieldIndex=1  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Active\" DataFieldIndex=2  width=\"40px\"></ntb:ComboColumnDefinition>
        </ntb:ComboList>
        </ntb:Combo>";

    return $selection;
 }

    public function getSelectAccountsAjaxN($recordid=0,$ctrlid="accounts_id",$onchangefunction="",$filterstring="",$mode="classic",$initialsearch=""){
        $this->log->showLog(2,"Call getSelectAccounts($id,$ctrlid,$onchangefunction,$filterstring,$mode) from select control");
        global $nitobicombothemes;
         $selection="<ntb:Combo id=\"$ctrlid\" Mode=\"$mode\" theme=\"$nitobicombothemes\" initialsearch=\"$initialsearch\">
        <ntb:ComboTextBox DataFieldIndex=1 width=\"200px\"></ntb:ComboTextBox>
        <ntb:ComboList DatasourceUrl=\"selection.php?action=accounts\" PageSize=\"5\" width=\"480px\" >
        <ntb:ComboColumnDefinition HeaderLabel=\"ID\" DataFieldIndex=0  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Name\" DataFieldIndex=1  width=\"40px\"></ntb:ComboColumnDefinition>
        <ntb:ComboColumnDefinition HeaderLabel=\"Active\" DataFieldIndex=2  width=\"40px\"></ntb:ComboColumnDefinition>
        </ntb:ComboList>
        </ntb:Combo>";
//    $selection="<select name=\"$ctrlid\"></select>";
    return $selection;
    }


 public function getTextField($fieldname,$fieldvalue="",$fieldid="",$option=""){
     $this->log->showLog(2,"Call getTextField($fieldname,$fieldvalue,$fieldid,$option)");
     if($fieldid!="")
     $fieldidctrl="id=\"$fieldid\"";
     
     
     $textfield="<input name=\"$fieldname\" $fieldidctrl value=\"$fieldvalue\" $functionstring $option>";
      return $textfield;
 }

 public function getCheckBox($fieldname,$checked,$fieldvalue,$fieldid,$option){
     $this->log->showLog(2,"Call getCheckBox($fieldname,$checked,$fieldvalue,$fieldid,$option)");
     if($fieldid!="")
     $fieldidctrl="id=\"$fieldid\"";

     if($checked==true || $checked==1 || $checked=="on")
     $checked="checked";
     
     $checkbox="<input type=\"checkbox\" $checked name=\"$fieldname\" $fieldidctrl value=\"$fieldvalue\" $option>";
     
     return $checkbox;
 }

 public function getTextArea($fieldname,$fieldvalue,$fieldid,$option){
     $this->log->showLog(2,"Call getCheckBox($fieldname,$checked,$fieldvalue,$fieldid,$option)");
     if($fieldid!="")
     $fieldidctrl="id=\"$fieldid\"";

     $textarea="<textarea name=\"$fieldname\" $fieldidctrl $option>$fieldvalue</textarea>";
     return $textarea;
 }


 public function getButton($fieldname, $fieldvalue, $fieldid,$type="button",$arroption=array(), $option=""){
     $this->log->showLog(2,"Call getButton($fieldname, $fieldvalue, $fieldid,$type,$arroption, $option)");
     if($fieldid!="")
     $fieldidctrl="id=\"$fieldid\"";

     if($classname!="")
     $classname="class=\"$classname\"";

     if($arroption){

     $selection="<SELECT  name=\"$fieldname"."_select\" id=\"$fieldname"."_select\">";
     foreach($arroption as $k=>$v)
        $selection.="<option value=\"$k\">$v</option>";
     $selection.="</select>";
     }
     $button="$selection<input type=\"$type\" name=\"$fieldname\" $fieldidctrl value=\"$fieldvalue\" $option> &nbsp;";
     return $button;
 }

 public function getHiddenField($fieldname, $fieldvalue, $fieldid,$option){
      $this->log->showLog(2,"Call getHiddenField($fieldname, $fieldvalue, $fieldid,$option)");
     if($fieldid!="")
     $fieldidctrl="id=\"$fieldid\"";
     return "<input type=\"hidden\" name=\"$fieldname\" $fieldidctrl value=\"$fieldvalue\">";

 }


 /*
  * paste from simedu select control class
  */


public function getSelectModules($id,$showNull='Y') {

	$sql="SELECT mid,name from $this->tablemodules where (isactive=1 or mid='$id') and mid>0 order by name";

	$selectctl="<SELECT name='mid' >";
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
		$selectctl=$selectctl  . "<OPTION value='$mid' $selected>$name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

public function getSelectWindow($id,$showNull='Y') {

	$sql="SELECT window_id,window_name from $this->tablewindow where (isactive='Y' or window_id='$id' ) and window_id>0 order by window_name";

	$selectctl="<SELECT name='window_id' >";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$window_id=$row['window_id'];
		$window_name=$row['window_name'];

		if($id==$window_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$window_id' $selected>$window_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

 public function getSelectCountry($id,$showNull='Y') {
	$sql=sprintf("SELECT country_id,country_name from sim_country where (isactive=1 or country_id= %d) and country_id>0
		order by defaultlevel,country_name",$id);
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

	return $selectctl;
  } // end

 public function getSelectCurrency($id,$showNull='Y',$ctrlname='currency_id',$wherestr="",$onchangefunction="") {

	$sql="SELECT currency_id,currency_code from $this->tablecurrency where (isactive=1 or currency_id=$id) and currency_id>0
		$wherestr order by defaultlevel,currency_name ;";
$this->log->showLog(4,"getSelectCurrency With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
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

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getAllSystemGroup($gid){
	$this->log->showLog(3,"Retrieve available system groups from database, with preselect id: $id");
	$sql="SELECT groupid,name FROM $this->tablegroups";
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

 public function getAccClass($id,$showNull,$onchangefunction=""){

	$this->log->showLog(3,"Retrieve available system groups from database, with preselect id: $id");
	$sql="SELECT accountclass_id,accountclass_name FROM $this->tableaccountclass where (isactive=1 or accountclass_id=$id)
		AND accountclass_id>0
		ORDER by defaultlevel,accountclass_name	";
	$this->log->showLog(3,"Retrieve available system groups with sql:$sql");

	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='accountclass_id' $onchangefunction>";



	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$accountclass_id=$row['accountclass_id'];
		$accountclass_name=$row['accountclass_name'];

		if($id==$accountclass_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$accountclass_id' $selected>$accountclass_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;


  }

public function getSelectTax($id,$showNull='N',$onchangefunction=""){

	$this->log->showLog(3,"Retrieve available system groups from database, with preselect id: $id");
	$sql="SELECT tax_id,tax_name FROM $this->tabletax where (isactive=1 or tax_id=$id)
		AND tax_id>0 and organization_id=$this->defaultorganization_id
		ORDER by defaultlevel,tax_name	";
	$this->log->showLog(3,"Retrieve available system groups with sql:$sql");

	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='tax_id' $onchangefunction>";

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$tax_id=$row['tax_id'];
		$tax_name=$row['tax_name'];

		if($id==$tax_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$tax_id' $selected>$tax_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;


  }

public function getSelectTerms($id,$showNull='N',$onchangefunction=""){

	$this->log->showLog(3,"Retrieve available system groups from database, with preselect id: $id");
	$sql="SELECT terms_id,terms_name FROM $this->tableterms where (isactive=1 or terms_id=$id)
		AND terms_id>0 and organization_id=$this->defaultorganization_id
		ORDER by defaultlevel,terms_name	";
	$this->log->showLog(3,"Retrieve available system groups with sql:$sql");

	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='terms_id' $onchangefunction>";

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

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;


  }

public function selectionOrg($uid,$id,$showNull='N',$onchangefunction="location.href='index.php?switchorg=Y&defaultorganization_id='+this.value",$ishide='N'){

	$this->log->showLog(3,"Retrieve available organization (select organization_id: $id) to employee_id : $uid, ishide=$ishide");
	$sql="SELECT distinct(organization_id) as organization_id,organization_code from $this->tableorganization o
		INNER JOIN $this->tablegroups_users_link ug on o.groupid=ug.groupid where o.organization_id>0 and isactive=1";

	$this->log->showLog(3,"Wtih SQL: $sql");
	$selectctl="<SELECT name='organization_id' onchange=\"$onchangefunction\">";
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


 public function getSelectAccountGroup($id,$showNull='N',$onchangefunction="") {
	$sql="SELECT accountgroup_id,initial,accountgroup_name from $this->tableaccountgroup where (isactive=1 or accountgroup_id=$id)
		and accountgroup_id>0 and organization_id=$this->defaultorganization_id order by initial, defaultlevel,accountgroup_name ;";
	$this->log->showLog(4,"getSelectAccountGroup With SQL: $sql");
	$selectctl="<SELECT name='accountgroup_id' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$accountgroup_id=$row['accountgroup_id'];
		$accountgroup_name=$row['accountgroup_name'];
		$inital =$row['initial'];
		if($id==$accountgroup_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$accountgroup_id' $selected>$inital-$accountgroup_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

public function getSelectAccounts($id,$showNull='N',$onchangefunction="",$ctrlname="accounts_id",$wherestr='',$readonly='N',$isparent="N",$showlastbalance='N',
		$ctrlid='accounts_id',$width="") {

	if($isparent == "N")
	$wherestr .= " and placeholder = 0 ";

	//$orderby = " order by defaultlevel,accounts_code,accounts_name ";
	$orderby = " order by accountcode_full ";

	if($readonly=='Y')
	$sql=	"SELECT accounts_id,accounts_code,accounts_name,accountcode_full,lastbalance from $this->tableaccounts
		where accounts_id=$id and organization_id=$this->defaultorganization_id $wherestr
		$orderby ;";
	else
	$sql=	"SELECT accounts_id,accounts_code,accounts_name,accountcode_full,lastbalance from $this->tableaccounts where (accounts_id=$id
		OR accounts_id>0) and organization_id=$this->defaultorganization_id $wherestr
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

	$selectctl=$selectctl . "</SELECT>";

	}


	if($readonly=='Y')
	return "<input type='hidden' name='$ctrlname' value='$id'><input name='accounts_desc' value='$accountcode_full-$accounts_name' readonly='readonly'  id='$ctrlid' $onchangefunction>";


	return $selectctl;
  }

 public function getSelectAccountsBackup($id,$showNull='N',$onchangefunction="",$ctrlname="accounts_id",$wherestr='',$readonly='N',$isparent="N",$showlastbalance='N',
		$ctrlid='accounts_id') {

	if($isparent == "N")
	$wherestr .= " and placeholder = 0 ";

	//$orderby = " order by defaultlevel,accounts_code,accounts_name ";
	$orderby = " order by accountcode_full ";

	if($readonly=='Y')
	$sql=	"SELECT accounts_id,accounts_code,accounts_name,accountcode_full,lastbalance from $this->tableaccounts
		where accounts_id=$id and organization_id=$this->defaultorganization_id $wherestr
		$orderby ;";
	else
	$sql=	"SELECT accounts_id,accounts_code,accounts_name,accountcode_full,lastbalance from $this->tableaccounts where (accounts_id=$id
		OR accounts_id>0) and organization_id=$this->defaultorganization_id $wherestr
		$orderby ;";



	$this->log->showLog(4,"getSelectAccounts With SQL: $sql");
	$query=$this->xoopsDB->query($sql);

	if(!$query){
	return "<input type='hidden' name='$ctrlname' value='0'>";
	}else{

	$selectctl="<SELECT name='$ctrlname' $onchangefunction  id='$ctrlid'>";
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


	if($readonly=='Y')
	return "<input type='hidden' name='$ctrlname' value='$id'><input name='accounts_desc' value='$accountcode_full-$accounts_name' readonly='readonly'  id='$ctrlid'>";


	return $selectctl;
  }

 public function getSelectPeriod($id,$showNull='N',$wherestr='') {

	//and isactive=1
	$sql="SELECT period_id,period_name from $this->tableperiod where (period_id=$id
		OR period_id>0) $wherestr
		order by defaultlevel,period_name asc;";
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

public function getSelectBPartnerGroup($id,$showNull='N',$onchangefunction="") {

	$sql="SELECT bpartnergroup_id,bpartnergroup_name from $this->tablebpartnergroup where (bpartnergroup_id=$id
		OR bpartnergroup_id>0) and isactive=1 AND organization_id=$this->defaultorganization_id
		order by defaultlevel,bpartnergroup_name ;";
	$this->log->showLog(4,"getSelectBPartnerGroup With SQL: $sql");
	$selectctl="<SELECT name='bpartnergroup_id' $onchangefunction>";
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

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  }

public function getSelectBPartner($id,$showNull='N',$wherestr="",$showLastBalance='N') {

	$sql="SELECT bpartner_id,bpartner_name,currentbalance
		from $this->tablebpartner where (bpartner_id=$id
		OR bpartner_id>0) and isactive=1 AND organization_id=$this->defaultorganization_id
		$wherestr
		order by defaultlevel,bpartner_name ;";
	$this->log->showLog(4,"getSelectBPartner With SQL: $sql");

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

	if($showsearch=="Y"){//ajax list
	$idinput = $ctrlname."InputLayer".$ctrlid;
	$idlayer = $ctrlname."FormLayer".$ctrlid;

	if($onchangefunction == "")
	$onchangefunction = "0";
	else
	$onchangefunction = "1";

	$selectctl=$selectctl . "<input type='button' value='>' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
       //$selectctl = $selectctl.$this->getZommCtrl('bpartner_id',$ctrlid,'bpartner.php');
	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput' style='display:none' autocomplete=off  onkeyup=getListDB('getlistdbbpartner',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line')>";
	$selectctl=$selectctl . "<div id='$idlayer'></div>";
	}//ajax list

  	//$selectctl .= getZommCtrl($ctrlname,'../../system/bpartner.php');

	return $selectctl;
  }



public function getSelectBPartnerExtra($id,$showNull='N',$onchangefunction="",$ctrlname="bpartner_id",$wherestr="",$showLastBalance='N',
		$ctrlid="bpartner_id",$width="",$showsearch="N",$line=0) {
global $defaultorganization_id,$tablebpartner;

	$sql="SELECT bpartner_id,bpartner_name,currentbalance
		from $tablebpartner where (bpartner_id=$id
		OR bpartner_id>0) and isactive=1 AND organization_id=$defaultorganization_id
		$wherestr
		order by defaultlevel,bpartner_name ;";

	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid' $width onmouseover ='tooltip(this)'>";
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

	if($showsearch=="Y"){//ajax list
	$idinput = $ctrlname."InputLayer".$ctrlid;
	$idlayer = $ctrlname."FormLayer".$ctrlid;

	if($onchangefunction == "")
	$onchangefunction = "0";
	else
	$onchangefunction = "1";

	$selectctl=$selectctl . "<input type='button' value='>' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
       //$selectctl = $selectctl.$this->getZommCtrl('bpartner_id',$ctrlid,'bpartner.php');
	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput' style='display:none' autocomplete=off  onkeyup=getListDB('getlistdbbpartner',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line')>";
	$selectctl=$selectctl . "<div id='$idlayer'></div>";
	}//ajax list

  	//$selectctl .= getZommCtrl($ctrlname,'../../system/bpartner.php');

	return $selectctl;
  }

/*public function getSelectBPartner_Currency($id,$showNull='N',$onchangefunction="",$ctrlname="bpartner_id",$wherestr="",
		$showLastBalance='N',$getXChangeInfo="N",$bpartnercontrol_id='bpartner_id',$conversioncontrol_id='multiplyrate',
		$currencycontrol_id='currency_id') {
	global $defaultcurrency_id,$defaultorganization_id;
	$sql="SELECT bp.bpartner_id,bp.bpartner_name,bp.currentbalance,cur.currency_code,
		case when (SELECT multiplyvalue FROM $this->tableconversionrate where currencyfrom_id=$defaultcurrency_id and organization_id=$defaultorganization_id
			and isactive=1 and currencyto_id=bp.currency_id) is null then 1 else (SELECT multiplyvalue FROM $this->tableconversionrate where currencyfrom_id=$defaultcurrency_id and organization_id=$defaultorganization_id
			and isactive=1 and currencyto_id=bp.currency_id) end as multiplyrate
		from $this->tablebpartner bp
		INNER JOIN $this->tablecurrency cur on cur.currency_id=bp.currency_id
		where (bp.bpartner_id=$id OR bp.bpartner_id>0) and
		bp.isactive=1 AND bp.organization_id=$defaultorganization_id
		$wherestr order by bp.defaultlevel,bp.bpartner_name ;";

	$this->log->showLog(4,"getSelectBPartner With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . "<OPTION value='0' SELECTED='SELECTED'>Null </OPTION>";

	$query=$this->xoopsDB->query($sql);
	$selected="";
	$curcode="";
	$multiplyrate=1;
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
		$bpartner_id=$row['bpartner_id'];

		$bpartner_name=$row['bpartner_name'];
		$lastbalance=number_format($row['currentbalance'],2);


		if($showLastBalance=='N')
			$lastbalance="";
		if($id==$bpartner_id){
			$selected="SELECTED='SELECTED'";
			$curcode=$row["currency_code"];
			$multiplyrate=$row["multiplyrate"];

		}
		else{
			$selected="";
			if($id==0 && $showNull=='N' && $i==0)
				{	$selected="SELECTED='SELECTED'";
					$curcode=$row["currency_code"];
					$multiplyrate=$row["multiplyrate"];
				}

		}
		$selectctl=$selectctl  . "<OPTION value='$bpartner_id' $selected>$bpartner_name $lastbalance</OPTION>";
		$i++;
	}

	$selectctl=$selectctl . "</SELECT>";

	//if($multiplyrate!=1 && $getXChangeInfo=='Y')
		$selectctl=$selectctl."<br>$curcode Exchange:<input name='conversionrate' value='$multiplyrate' size='8'>";
	return $selectctl;
  } */

public function getSelectFinancialYear($id,$showNull='N',$onchangefunction="",$ctrlname="financialyear_id",$wherestr="") {

	$sql="SELECT financialyear_id,financialyear_name from $this->tablefinancialyear where (financialyear_id=$id
		OR financialyear_id>0) AND organization_id=$this->defaultorganization_id
		$wherestr
		order by defaultlevel,financialyear_name ;";
	$this->log->showLog(4,"getSelectFinancialYear With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . "<OPTION value='0' SELECTED='SELECTED'>Null </OPTION>";

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$financialyear_id=$row['financialyear_id'];

		$financialyear_name=$row['financialyear_name'];
		if($id==$financialyear_id)
			$selected="SELECTED='SELECTED'";
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$financialyear_id' $selected>$financialyear_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  }



 public function getSelectProductCategory($id,$showNull='N',$onchangefunction="",$ctrlname="category_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr = " and organization_id = $defaultorganization_id ";

	$sql="SELECT category_id,category_name from $this->tableproductcategory where (category_id=$id
		OR category_id>0) and isactive=1 $wherestr
		order by defaultlevel,category_name ;";
	$this->log->showLog(4,"getSelectProductCategory With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$category_id=$row['category_id'];
		$category_name=$row['category_name'];
		if($id==$category_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$category_id' $selected>$category_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

  public function getSelectRaces($id,$showNull='N',$wherestr='') {

	$sql=sprintf("SELECT races_id,races_name from sim_races where (races_id= %d OR races_id > 0) and isactive = 1 $wherestr
		order by races_name desc",$id);

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

   public function getSelectReligion($id,$showNull='N',$wherestr='') {

	$sql=sprintf("SELECT religion_id,religion_name from sim_religion where (religion_id= %d OR religion_id>0) and isactive='1' $wherestr
		order by defaultlevel asc, religion_name desc",$id);

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

	$sql=sprintf("SELECT * from sim_simedu_employeestatus where (employeestatus_id= %d OR employeestatus_id>0) and isactive='1' $wherestr
		order by employeestatus_id asc",$id);

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

   public function getSelectRelationship($id,$showNull='N',$onchangefunction="",$ctrlname="relationship_id",$wherestr='') {

	$sql="SELECT relationship_id,relationship_name from sim_simedu_relationship where (relationship_id='$id'
		OR relationship_id>0) and isactive='1' $wherestr
		order by relationship_name desc ;";

	$selectctl="<SELECT name='$ctrlname' $onchangefunction >";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Nulls</OPTION>';

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
	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

    public function getSelectNamegroup($id,$showNull='N',$onchangefunction="",$ctrlname="namegroup_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT namegroup_id,group_name from $this->tablenamegroup where (namegroup_id=$id
		OR namegroup_id>0) and isactive=1 $wherestr
		order by defaultlevel,group_name ;";
	$this->log->showLog(4,"getSelectNamegroup With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$namegroup_id=$row['namegroup_id'];
		$group_name=$row['group_name'];
		if($id==$namegroup_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$namegroup_id' $selected>$group_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

    public function getSelectProduct($id,$showNull='N',$onchangefunction="",$ctrlname="product_id",$wherestr='',$ctrlid='product_id',$width="",$showsearch="N",$line=0) {
	global $defaultorganization_id;
	$wherestr .= " and a.organization_id = $defaultorganization_id ";

	$sql="SELECT product_id,product_name from $this->tableproduct a, $this->tableproductcategory b
		where a.category_id = b.category_id
		and (product_id=$id OR product_id>0) and a.isactive=1 $wherestr
		order by a.defaultlevel,product_name ;";
	$this->log->showLog(4,"getSelectProduct With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid' $width  onmouseover ='tooltip(this)'>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$product_id=$row['product_id'];
		$product_name=$row['product_name'];
		if($id==$product_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$product_id' $selected>$product_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	if($showsearch=="Y"){//ajax list
	$idinput = $ctrlname."InputLayer".$ctrlid;
	$idlayer = $ctrlname."FormLayer".$ctrlid;

	if($onchangefunction == "")
	$onchangefunction = "0";
	else
	$onchangefunction = "1";

    $wherestr = str_replace(" ","#",$wherestr);
    $wherestr = str_replace("'","*",$wherestr);

	$selectctl=$selectctl . "<input type='button' value='>' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput' style='display:none' autocomplete=off  onkeyup=getListDBWhere('getlistdbproduct',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line','$wherestr')>";
	$selectctl=$selectctl . "<div id='$idlayer'></div>";
	}//ajax list

//	$selectctl .= getZommCtrl($ctrlname,'product.php');

	return $selectctl;
  }




 public function getSelectAccountsExtra($id,$showNull='N',$onchangefunction="",$ctrlname="accounts_id",$wherestr='',$readonly='N',$isparent="N") {
	global $log,$defaultorganization_id,$tableaccounts;
	if($isparent == "N")
	$wherestr .= " and placeholder = 0 ";

	//$orderby = " order by defaultlevel,accounts_code,accounts_name ";
	$orderby = " order by accountcode_full ";

	if($readonly=='Y')
	$sql=	"SELECT accounts_id,accounts_code,accounts_name,accountcode_full from $tableaccounts
		where accounts_id=$id and organization_id=$defaultorganization_id $wherestr
		$orderby ;";
	else
	$sql=	"SELECT accounts_id,accounts_code,accounts_name,accountcode_full from $tableaccounts where (accounts_id=$id
		OR accounts_id>0) and organization_id=$defaultorganization_id $wherestr
		$orderby ;";


	//echo $sql;
	$log->showLog(4,"getSelectAccounts With SQL: $sql");
	$query=$this->xoopsDB->query($sql);

	if(!$query){
	return "<input type='hidden' name='$ctrlname' value='0'>";
	}else{

	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
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
		if($id==$accounts_id)
			$selected="SELECTED='SELECTED'";
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$accounts_id' $selected>$accountcode_full-$accounts_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	}


	if($readonly=='Y')
	return "<input type='hidden' name='$ctrlname' value='$id'><input name='accounts_desc' value='$accountcode_full-$accounts_name' readonly='readonly'>";


	return $selectctl;
  }


  public function getSelectSystemlist($id,$showNull='N',$onchangefunction="",$ctrlname="systemlist_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT systemlist_id,systemlist_name from $this->tablesystemlist where (systemlist_id=$id
		OR systemlist_id>0) and isactive=1 $wherestr
		order by defaultlevel,systemlist_no ;";
	$this->log->showLog(4,"getSelectSystemlist With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$systemlist_id=$row['systemlist_id'];
		$systemlist_name=$row['systemlist_name'];
		if($id==$systemlist_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$systemlist_id' $selected>$systemlist_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

 public function getSelectType($id,$showNull='N',$onchangefunction="",$ctrlname="type_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT type_id,type_name from $this->tabletype where (type_id=$id
		OR type_id>0) and isactive=1 $wherestr
		order by defaultlevel,type_no ;";
	$this->log->showLog(4,"getSelectType With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$type_id=$row['type_id'];
		$type_name=$row['type_name'];
		if($id==$type_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$type_id' $selected>$type_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

 public function getSelectStatus($id,$showNull='N',$onchangefunction="",$ctrlname="status_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT status_id,status_name from $this->tablestatus where (status_id=$id
		OR status_id>0) and isactive=1 $wherestr
		order by defaultlevel,status_no ;";
	$this->log->showLog(4,"getSelectStatus With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$status_id=$row['status_id'];
		$status_name=$row['status_name'];
		if($id==$status_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$status_id' $selected>$status_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

 public function getSelectStafftype($id,$showNull='N',$onchangefunction="",$ctrlname="stafftype_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT stafftype_id,stafftype_description from $this->tablestafftype where (stafftype_id=$id
		OR stafftype_id>0) and isactive='Y' $wherestr
		order by stafftype_code ;";
	$this->log->showLog(4,"getSelectStafftype With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$stafftype_id=$row['stafftype_id'];
		$stafftype_name=$row['stafftype_description'];
		if($id==$stafftype_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$stafftype_id' $selected>$stafftype_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

  public function getSelectCoursetype($id,$showNull='N',$onchangefunction="",$ctrlname="coursetype_id",$wherestr='',$style="") {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT coursetype_id,coursetype_no from $this->tablecoursetype where (coursetype_id=$id
		OR coursetype_id>0) and isactive=1 $wherestr
		order by coursetype_no ;";
	$this->log->showLog(4,"getSelectCoursetype With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction $style>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$coursetype_id=$row['coursetype_id'];
		$coursetype_name=$row['coursetype_no'];
		if($id==$coursetype_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$coursetype_id' $selected>$coursetype_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

   public function getSelectSubject($id,$showNull='N',$onchangefunction="",$ctrlname="subject_id",$wherestr='',
   $ctrlid="subject_id",$width="",$showsearch="N",$line=0) {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT subject_id,subject_name,subject_no from $this->tablesubject where (subject_id=$id
		OR subject_id>0) and isactive=1 $wherestr
		order by subject_name ;";
	$this->log->showLog(4,"getSelectSubject With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction $width id='$ctrlid' onmouseover ='tooltip(this)'>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$subject_id=$row['subject_id'];
		$subject_name=$row['subject_name'];
        $subject_no=$row['subject_no'];
		if($id==$subject_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$subject_id' $selected>$subject_name ($subject_no)</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

    if($showsearch=="Y"){//ajax list
	$idinput = $ctrlname."InputLayer".$ctrlid;
	$idlayer = $ctrlname."FormLayer".$ctrlid;

	if($onchangefunction == "")
	$onchangefunction = "0";
	else
	$onchangefunction = "1";

    $wherestr = str_replace(" ","#",$wherestr);
    $wherestr = str_replace("'","*",$wherestr);

	$selectctl=$selectctl . "<input type='button' value='>' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
	//$selectctl = $selectctl.$this->getZommCtrl('subject_id',$ctrlid,'subject.php','hea');
	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput' style='display:none' autocomplete=off  onkeyup=getListDBWhere('getlistdbsubject',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line','$wherestr')>";
	$selectctl=$selectctl . "<div id='$idlayer'></div>";
	}//ajax list

	return $selectctl;
  }

   public function getSelectSubjecttype($id,$showNull='N',$onchangefunction="",$ctrlname="subjecttype_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT subjecttype_id,subjecttype_name from $this->tablesubjecttype where (subjecttype_id=$id
		OR subjecttype_id>0) and isactive=1 $wherestr
		order by subjecttype_name ;";
	$this->log->showLog(4,"getSelectSubjecttype With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$subjecttype_id=$row['subjecttype_id'];
		$subjecttype_name=$row['subjecttype_name'];
		if($id==$subjecttype_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$subjecttype_id' $selected>$subjecttype_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

  public function getSelectSubjectclass($id,$showNull='N',$onchangefunction="",$ctrlname="subjectclass_id",$wherestr='',
  $ctrlid="subjectclass_id",$width="",$showsearch="N",$line=0) {
	global $defaultorganization_id;

	$wherestr .= " and sc.organization_id = $defaultorganization_id and sc.subject_id = sb.subject_id and sc.course_id = cr.course_id and sc.year_id = cs.year_id and sc.session_id = cs.session_id ";
    $wherestr .= " and cs.isactive = 0";

	$sql="SELECT sc.subjectclass_id,sb.subject_name,sb.subject_no,cr.course_no,sc.group_no
                from $this->tablesubjectclass sc, $this->tablesubject sb, $this->tablecourse cr,
                $this->tableclosesession cs
                where (sc.subjectclass_id=$id
                OR sc.subjectclass_id>0) and sb.isactive=1 $wherestr
                group by sc.subjectclass_id
                order by sb.subject_name,sc.group_no ;";
	$this->log->showLog(4,"getSelectSubjectclass With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid' $width  onmouseover ='tooltip(this)'>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$subjectclass_id=$row['subjectclass_id'];
		$subject_name=$row['subject_name'];
        $subject_no=$row['subject_no'];
        $course_no=$row['course_no'];
        $group_no=$row['group_no'];

		if($id==$subjectclass_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$subjectclass_id' $selected>$subject_name ($subject_no) $course_no - $group_no</OPTION>";

	}

    $selectctl=$selectctl . "</SELECT>";

    if($showsearch=="Y"){//ajax list
	$idinput = $ctrlname."InputLayer".$ctrlid;
	$idlayer = $ctrlname."FormLayer".$ctrlid;

	if($onchangefunction == "")
	$onchangefunction = "0";
	else
	$onchangefunction = "1";

    $wherestr = str_replace(" ","#",$wherestr);
    $wherestr = str_replace("'","*",$wherestr);

	$selectctl=$selectctl . "<input type='button' value='>' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
	//$selectctl = $selectctl.$this->getZommCtrl('subjectclass_id',$ctrlid,'subjectclass.php','hea');
	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput' style='display:none' autocomplete=off  onkeyup=getListDBWhere('getlistdb',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line','$wherestr')>";
	$selectctl=$selectctl . "<div id='$idlayer'></div>";
	}//ajax list


	return $selectctl;
  }

     public function getSelectLoantype($id,$showNull='N',$onchangefunction="",$ctrlname="loantype_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT loantype_id,loantype_no from $this->tableloantype where (loantype_id=$id
		OR loantype_id>0) and isactive=1 $wherestr
		order by loantype_no ;";
	$this->log->showLog(4,"getSelectLoantype With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$loantype_id=$row['loantype_id'];
		$loantype_name=$row['loantype_no'];
		if($id==$loantype_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$loantype_id' $selected>$loantype_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

  public function getSelectSubjectspm($id,$showNull='N',$onchangefunction="",$ctrlname="subjectspm_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT subjectspm_id,subjectspm_name,subjectspm_type from $this->tablesubjectspm where (subjectspm_id=$id
		OR subjectspm_id>0) and isactive=1 $wherestr
		order by subjectspm_type,subjectspm_name ;";
	$this->log->showLog(4,"getSelectSubjectspm With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$subjectspm_id=$row['subjectspm_id'];
		$subjectspm_name=$row['subjectspm_name'];
                $subjectspm_type=$row['subjectspm_type'];

                $levelname = "";
                if($subjectspm_type == "V")
                $levelname = "(SPM/SPMV)";
                else if($subjectspm_type == "T")
                $levelname = "(STPM)";
                else if($subjectspm_type == "D")
                $levelname = "(Diploma)";

                $subjectspm_name .= " $levelname";
		if($id==$subjectspm_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$subjectspm_id' $selected>$subjectspm_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

     public function getSelectCourse($id,$showNull='N',$onchangefunction="",$ctrlname="course_id",$wherestr='',$style="style='width:300px'") {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT course_id,course_name,course_no from $this->tablecourse where (course_id=$id
		OR course_id>0) and isactive=1 $wherestr
		order by course_name ;";
	$this->log->showLog(4,"getSelectCourse With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction  onmouseover ='tooltip(this)' $style>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$course_id=$row['course_id'];
		$course_name=$row['course_name'];
        $course_no=$row['course_no'];

		if($id==$course_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$course_id' $selected>$course_no - $course_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

      public function getSelectDepartment($id,$showNull='N',$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT department_id,department_name from $this->tabledepartment where (department_id=$id
		OR department_id>0) and isactive=1 $wherestr
		order by department_name ;";
	$this->log->showLog(4,"getSelectDepartment With SQL: $sql");

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

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

       public function getSelectEmployeegroup($id,$showNull='N',$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT employeegroup_id,employeegroup_name from sim_simedu_employeegroup where (employeegroup_id=$id
		OR employeegroup_id>0) and isactive=1 $wherestr
		order by employeegroup_name ;";
	$this->log->showLog(4,"getSelectEmployeegroup With SQL: $sql");

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$employeegroup_id=$row['employeegroup_id'];
		$employeegroup_name=$row['employeegroup_name'];
		if($id==$employeegroup_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$employeegroup_id' $selected>$employeegroup_name</OPTION>";

	}

	return $selectctl;
  }

    public function getSelectLecturerroom($id,$showNull='N',$onchangefunction="",$ctrlname="lecturerroom_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT lecturerroom_id,lecturerroom_name,lecturerroom_no,capacity from $this->tablelecturerroom where (lecturerroom_id=$id
		OR lecturerroom_id>0) and isactive=1 $wherestr
		order by lecturerroom_name ;";
	$this->log->showLog(4,"getSelectLecturerroom With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$lecturerroom_id=$row['lecturerroom_id'];
		$lecturerroom_name=$row['lecturerroom_name'];
        $lecturerroom_no=$row['lecturerroom_no'];
        $capacity=$row['capacity'];
		if($id==$lecturerroom_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$lecturerroom_id' $selected>$lecturerroom_no ($capacity)</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }


     public function getSelectStudentletter($id,$showNull='N',$onchangefunction="",$ctrlname="studentletter_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT studentletter_id,studentletter_name from $this->tablestudentletter where (studentletter_id=$id
		OR studentletter_id>0) and isactive=1 $wherestr
		order by studentletter_name ;";
	$this->log->showLog(4,"getSelectStudentletter With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
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

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }
     public function getSelectEmployeeletter($id,$showNull='N',$onchangefunction="",$ctrlname="studentletter_id",$wherestr='') {
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

public function getSelectAward($id,$showNull='N',$onchangefunction="",$ctrlname="award_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT award_id,award_name from $this->tableaward where (award_id=$id
		OR award_id>0) and isactive=1 $wherestr
		order by award_name ;";
	$this->log->showLog(4,"getSelectAward With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$award_id=$row['award_id'];
		$award_name=$row['award_name'];
		if($id==$award_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$award_id' $selected>$award_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

  public function getSelectGradelevel($id,$showNull='N',$onchangefunction="",$ctrlname="gradelevel_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT gradelevel_id,gradelevel_no from $this->tablegradelevel where (gradelevel_id=$id
		OR gradelevel_id>0) and isactive=1 $wherestr
		order by gradelevel_no ;";
	$this->log->showLog(4,"getSelectGradelevel With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$gradelevel_id=$row['gradelevel_id'];
		$gradelevel_name=$row['gradelevel_no'];
		if($id==$gradelevel_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$gradelevel_id' $selected>$gradelevel_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }


     public function getSelectSemester($id,$showNull='N',$onchangefunction="",$ctrlname="semester_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT semester_id,semester_name from $this->tablesemester where (semester_id=$id
		OR semester_id>0) and isactive=1 $wherestr
		order by semester_name ;";
	$this->log->showLog(4,"getSelectSemester With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$semester_id=$row['semester_id'];
		$semester_name=$row['semester_name'];
		if($id==$semester_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$semester_id' $selected>$semester_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

  public function getSelectYear($id,$showNull='N',$onchangefunction="",$ctrlname="year_id",$wherestr='',$defaultyear=0,$isusedefaultsession=true) {
	global $defaultorganization_id;
	//$wherestr .= " and organization_id = $defaultorganization_id ";

    if($isusedefaultsession&&$id==0){
        $year_session = $this->getYearSession($defaultyear);
        $id = $year_session['year_id'];
    }

	$sql="SELECT year_id,year_name from $this->tableyear where (year_id=$id
		OR year_id>0) and isactive='Y' $wherestr
		order by cast(year_name as signed) desc;";
	$this->log->showLog(4,"getSelectYear With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$year_id=$row['year_id'];
		$year_name=$row['year_name'];
		if($id==$year_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$year_id' $selected>$year_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

   public function getSelectSession($id,$showNull='N',$onchangefunction="",$ctrlname="session_id",$wherestr='',$defaultyear=0,$isusedefaultsession=true) {
	global $defaultorganization_id;

        if($isusedefaultsession&&$id==0){
        $year_session = $this->getYearSession($defaultyear);
        $id = $year_session['session_id'];
    }

	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT session_id,session_name from $this->tablesession where (session_id=$id
		OR session_id>0) and isactive=1 $wherestr
		order by session_name desc;";
	$this->log->showLog(4,"getSelectSession With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$session_id=$row['session_id'];
		$session_name=$row['session_name'];
		if($id==$session_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$session_id' $selected>$session_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

 public function getSelectEmployee2($id,$showNull='N',$onchangefunction="",$ctrlname="employee_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT employee_id,employee_name from $this->tableemployee where (employee_id=$id
		OR employee_id>0) and isactive='Y' $wherestr
		order by employee_no ;";
	$this->log->showLog(4,"getSelectEmployee With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$employee_id=$row['employee_id'];
		$employee_name=$row['employee_name'];
		if($id==$employee_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$employee_id' $selected>$employee_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

public function getSelectJobposition($id,$showNull='N',$wherestr='') {

	global $defaultorganization_id;
	//$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT jobposition_id,jobposition_name from sim_simedu_jobposition where (jobposition_id=$id
		OR jobposition_id>0) and isactive=1 $wherestr
		order by jobposition_no ;";

	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$jobposition_id=$row['jobposition_id'];
		$jobposition_name=$row['jobposition_name'];
		if($id==$jobposition_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$jobposition_id' $selected>$jobposition_name</OPTION>";
	}
	return $selectctl;
  }

 public function getSelectEmployee($id,$showNull='N',$onchangefunction="",$ctrlname="employee_id",$wherestr='',
     $ctrlid="employee_id",$width="",$showsearch="N",$line=0) {
     //echo $app."xxx"; die();
	global $defaultorganization_id;
            $wherestr .= " and organization_id = $defaultorganization_id ";

            $sql="SELECT employee_id,employee_name from $this->tableemployee where (employee_id=$id
                    OR employee_id>0) and isactive=1 $wherestr
                    order by employee_name,cast(employee_no as signed);";
	//$this->log->showLog(4,"getSelectEmployee With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid' $width onmouseover ='tooltip(this)'>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$employee_id=$row['employee_id'];
		$employee_name=$row['employee_name'];
		if($id==$employee_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";

                $selectctl=$selectctl  . "<OPTION value='$employee_id' $selected>$employee_name</OPTION>";
	}

    $selectctl=$selectctl . "</SELECT>";

    if($showsearch=="Y"){//ajax list
	$idinput = $ctrlname."InputLayer".$ctrlid;
	$idlayer = $ctrlname."FormLayer".$ctrlid;

	if($onchangefunction == "")
	$onchangefunction = "0";
	else
	$onchangefunction = "1";

    $wherestr = str_replace(" ","#",$wherestr);
    $wherestr = str_replace("'","*",$wherestr);

	$selectctl=$selectctl . "<input type='button' value='>' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
	//$selectctl = $selectctl.$this->getZommCtrl('employee_id',$ctrlid,'employee.php','hr');
	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput' style='display:none' autocomplete=off  onkeyup=getListDBWhere('getlistdbemployee',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line','$wherestr')>";
	$selectctl=$selectctl . "<div id='$idlayer'></div>";
	}//ajax list


	return $selectctl;
  }

   public function getSelectStudent($id,$showNull='N',$onchangefunction="",$ctrlname="student_id",$wherestr='',
     $ctrlid="bpartner_id",$width="",$showsearch="N",$line=0) {

	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

    //echo $wherestr;

	$sql="SELECT student_id,student_name,student_no from $this->tablestudent where (student_id=$id
		OR student_id>0) and isactive=1 $wherestr
		order by student_no ;";
	$this->log->showLog(4,"getSelectStudent With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid' $width onmouseover ='tooltip(this)'>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$student_id=$row['student_id'];
                $student_no=$row['student_no'];
		$student_name=$row['student_name'];
		if($id==$student_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$student_id' $selected>$student_name ($student_no)</OPTION>";

	}

    if($showsearch=="Y"){//ajax list
	$idinput = $ctrlname."InputLayer".$ctrlid;
	$idlayer = $ctrlname."FormLayer".$ctrlid;

	if($onchangefunction == "")
	$onchangefunction = "0";
	else
	$onchangefunction = "1";

    $wherestr = str_replace(" ","#",$wherestr);
    $wherestr = str_replace("'","*",$wherestr);

	$selectctl=$selectctl . "<input type='button' value='>' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
	//$selectctl = $selectctl.$this->getZommCtrl('student_id',$ctrlid,'student.php','hes');
	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput' style='display:none' autocomplete=off  onkeyup=getListDBWhere('getlistdbstudent',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line','$wherestr')>";
	$selectctl=$selectctl . "<div id='$idlayer'></div>";
	}//ajax list

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

  public function getZommCtrl2($ctrlname,$ctrlid,$windows_name,$modules="system"){

	global $url;

	if(strpos($ctrlname,'[') != "")
	$id_name = substr($ctrlname,0,strpos($ctrlname,'['));
	else
	$id_name = $ctrlname;


	$pathimg = $url.'/images/zoom.png';
	$windows_name = $url."/modules/$modules/$windows_name";

	$selectctl = " <img src='$pathimg' style='cursor:pointer' onclick=openViewWindow('$windows_name','$ctrlname',document.getElementById('$ctrlid').value) >";

	//$selectctl = " <img src='images/zoom.png' style='cursor:pointer' onclick=openViewWindow(document.getElementById('id$ctrlname').value,'$windows_name','$id_name') >";

	return $selectctl;
  }

  public function getSelectWindows($table_name,$showNull='N') {

	$sql="SELECT window_id,window_name,table_name from $this->tablewindow where (isactive='Y' or table_name='$table_name') and window_id>0 and functiontype in ('M','T') and table_name <> '' order by window_name ;";
	$selectctl="<SELECT name='table_name' >";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"> Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$school_id=$row['window_id'];
		$school_name=$row['window_name'];
		$table_names=$row['table_name'];

		if($table_names==$table_name)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$table_names' $selected>$school_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getYearSession($type){
        global $defaultorganization_id;

        $sql = "select year_id,session_id from $this->tableclosesession
                    where isactive = $type and organization_id = $defaultorganization_id ";


        $query=$this->xoopsDB->query($sql);

         $year_id = 0;
         $session_id = 0;
         if($row=$this->xoopsDB->fetchArray($query)){
         $year_id = $row['year_id'];
         $session_id = $row['session_id'];
         }

         return array('year_id'=>$year_id,'session_id'=>$session_id);
    }

     public function getSelectHostel($id,$showNull='N',$onchangefunction="",$ctrlname="hostel_id",$wherestr='') {
        global $defaultorganization_id;
        $wherestr .= " and organization_id = $defaultorganization_id ";
        //$wherestr .= " and organization_id = $defaultorganization_id ";

         $sql="SELECT hostel_id,hostel_name from $this->tablehostel where (hostel_id=$id
                OR hostel_id>0) and isactive=1 $wherestr
                order by defaultlevel, hostel_name ;";

        $selectctl="<SELECT name='$ctrlname' $onchangefunction>";
        if ($showNull=='Y')
                $selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

        $query=$this->xoopsDB->query($sql);
        $selected="";
        while($row=$this->xoopsDB->fetchArray($query)){
                $hostel_id=$row['hostel_id'];
                $hostel_name=$row['hostel_name'];
                if($id==$hostel_id)
                        $selected='SELECTED="SELECTED"';
                else
                        $selected="";
                $selectctl=$selectctl  . "<OPTION value='$hostel_id' $selected>$hostel_name</OPTION>";

        }

        $selectctl=$selectctl . "</SELECT>";
        return $selectctl;
  }


       public function getSelectHostelBed($id,$showNull='N',$onchangefunction="",$ctrlname="bed_id",$wherestr='') {
        global $defaultorganization_id;
        //$wherestr .= " and organization_id = $defaultorganization_id ";

        $sql="SELECT bed.bed_id,bed.bed_no from $this->tablehostelbed bed
               where (bed.bed_id=$id OR bed.bed_id>0) and bed.isactive=1
            $wherestr
                order by bed.defaultlevel, bed.bed_no;";

        $selectctl="<SELECT name='$ctrlname' $onchangefunction>";
        if ($showNull=='Y')
                $selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

        $query=$this->xoopsDB->query($sql);
        $selected="";
        while($row=$this->xoopsDB->fetchArray($query)){
                $bed_id=$row['bed_id'];
                $bed_no=$row['bed_no'];
                if($id==$bed_id)
                        $selected='SELECTED="SELECTED"';
                else
                        $selected="";
                $selectctl=$selectctl  . "<OPTION value='$bed_id' $selected>$bed_no</OPTION>";

        }

        $selectctl=$selectctl . "</SELECT>";
        return $selectctl;
  }

  public function getSelectAddress($id,$showNull='N',$onChangeFunction="",$bpartner_id=0) {
    if($bpartner_id=="")
    $wherestr="";
    else
    $wherestr="and bpartner_id=$bpartner_id";
	$sql="SELECT address_id,address_name from $this->tableaddress where (isactive=1 or address_id=$id)
            and address_id>0 $wherestr
             order by address_name and organization_id=$this->defaultorganization_id";
	$this->log->showLog(3,"Generate Address list with id=:$id and shownull=$showNull SQL: $sql");
	$selectctl="<SELECT name='address_id' $onChangeFunction>";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$address_id=$row['address_id'];
		$address_name=$row['address_name'];

		if($id==$address_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$address_id' $selected>$address_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  }

  public function getSelectIndustry($id,$showNull='N') {

	$sql="SELECT industry_id,industry_name from $this->tableindustry where (isactive=1 or industry_id=$id) and industry_id>0 order by industry_name ;";
	$this->log->showLog(3,"Generate Industry list with with SQL($id,$showNull): $sql");
	$selectctl="<SELECT name='industry_id' >";
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

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  }

  public function getSelectUOM($id,$showNull='N',$onchangefunction="",$ctrlname="uom_id",$wherestr='',$ctrlid='uom_id') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT uom_id,uom_code from $this->tableuom where (uom_id=$id
		OR uom_id>0) and isactive=1 $wherestr
		order by defaultlevel,uom_code ;";
	$this->log->showLog(4,"getSelectUOM With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid'>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$uom_id=$row['uom_id'];
		$uom_code=$row['uom_code'];
		if($id==$uom_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$uom_id' $selected>$uom_code</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

  public function getSelectPriceList($id,$showNull='N',$onchangefunction="",$ctrlname="pricelist_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT pricelist_id,pricelist_name from $this->tablepricelist where (pricelist_id=$id
		OR pricelist_id>0) and isactive=1 $wherestr
		order by defaultlevel,pricelist_name ;";
	$this->log->showLog(4,"getSelectUOM With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$pricelist_id=$row['pricelist_id'];
		$pricelist_name=$row['pricelist_name'];
		if($id==$pricelist_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$pricelist_id' $selected>$pricelist_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT><a href='pricelist.php'>Add New</a>";
	return $selectctl;
  }

  public function getSelectUsers($id,$showNull='N',$onchangefunction="",$ctrlname="uid",$wherestr='') {
	global $defaultorganization_id;


	$sql="SELECT uid, uname from $this->tableusers where (uid=$id
		OR uid>0) and uid>0 $wherestr
		order by uname ;";
	$this->log->showLog(4,"getSelectUsername With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
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

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }

  public function getSelectProject($id,$showNull='N',$onchangefunction="",$ctrlname="project_id",$wherestr='') {
	global $defaultorganization_id;


	$sql="SELECT project_id, project_name from $this->tableproject where (project_id=$id
		OR project_id>0) and project_id>0
		order by project_name ;";
	$this->log->showLog(4,"getSelectProject With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$project_id=$row['project_id'];
		$project_name=$row['project_name'];
		if($id==$project_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$project_id' $selected>$project_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }


 public function getSelectWarehouse($id,$showNull='N',$onchangefunction="",$ctrlname="warehouse_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT warehouse_id, warehouse_code from $this->tablewarehouse where (warehouse_id=$id
		OR warehouse_id>0) and isactive=1 $wherestr
		order by defaultlevel,warehouse_code ;"; 
	$this->log->showLog(4,"getSelectWarehouse With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$warehouse_id=$row['warehouse_id'];
		$warehouse_code=$row['warehouse_code'];
		if($id==$warehouse_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$warehouse_id' $selected>$warehouse_code</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT><a href='warehouse.php'>Add New</a>";
	return $selectctl;
  }
 public function getSelectContacts($id,$showNull='N',$onchangefunction="",
                $ctrlname="contacts_id",$wherestr='', $ctrlid='contacts_id',$width="",
                $showsearch="N",$line=0) {

	global $defaultorganization_id;


	$sql="SELECT contacts_id, contacts_name from $this->tablecontacts where (contacts_id=$id
		OR contacts_id>0) and isactive=1 $wherestr
		order by defaultlevel ;";
	$this->log->showLog(4,"getSelectcontacts With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid'>";
	if ($showNull=='Y')
		$selectctl=$selectctl . "<OPTION value='0' SELECTED='SELECTED'>Null </OPTION>";

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$contacts_id=$row['contacts_id'];
		$contacts_name=$row['contacts_name'];
		if($id==$contacts_id)
			$selected="SELECTED='SELECTED'";
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$contacts_id' $selected>$contacts_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  }


 public function getSelectLocation($id,$showNull='N',$onchangefunction="",
                $ctrlname="location_id",$wherestr='', $ctrlid='location_id',$width="",
                $showsearch="N",$line=0) {

	global $defaultorganization_id;


	$sql="SELECT location_id, location_code from $this->tablelocation where (location_id=$id
		OR location_id>0) and isactive=1 $wherestr
		order by defaultlevel,location_code ;";
	$this->log->showLog(4,"getSelectLocation With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid'>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$location_id=$row['location_id'];
		$location_code=$row['location_code'];
		if($id==$location_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$location_id' $selected>$location_code</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	if($showsearch=="Y"){//ajax list

	$idinput = $ctrlname."InputLayer".$ctrlid;
	$idlayer = $ctrlname."FormLayer".$ctrlid;

	if($onchangefunction == "")
	$onchangefunction = "0";
	else
	$onchangefunction = "1";

	$selectctl=$selectctl . "<input type='button' value='>' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput'
         style='display:none' autocomplete=off  onkeyup=getListDB('getlistdblocation',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line',locwherestr$ctrlid.value)>";
	$selectctl=$selectctl . "<div id='$idlayer'></div><input  type='hidden' name='locwherestr$ctrlid' value='$wherestr'>";
	}//ajax list

	return $selectctl;
  }

 public function getSelectAddLine($value=0,$showNull='N'){
               //type=selection(S), text(T)
      //value: NG=Reject,FG=Finish Goods, MT=Material, WP=WIP, RW=Rework
      eval("\$select$value = \"Selected=\'Selected\'\";");
      //echo "\$select$value = 'Selected=\"Selected\"'";
      if($showNull=='Y')
        $shownulltext="<option value='0' $select0>0</option>";
      else
        $shownulltext="";
      return "<SELECT name='addlineqty'>
                        $shownulltext
                        <option value='1' $select1>1</option>
                        <option value='2' $select2>2</option>
                        <option value='3' $select3>3</option>
                        <option value='4' $select4>4</option>
                        <option value='5' $select5>5</option>
                        <option value='6' $select6>6</option>
                        <option value='7' $select7>7</option>
                        <option value='8' $select8>8</option>
                        <option value='9' $select9>9</option>
                        <option value='10' $select10>10</option>
                        <option value='11' $select11>11</option>
                        <option value='12' $select12>12</option>
                        <option value='13' $select13>13</option>
                        <option value='14' $select14>14</option>
                        <option value='15' $select15>15</option>

              </SELECT>";

  }

  public function getSelectRegion($id,$showNull='N') {

	$sql="SELECT region_id,region_name from $this->tableregion where (isactive=1 or region_id=$id)
            and region_id>0 order by region_name and organization_id=$this->defaultorganization_id";
	$this->log->showLog(3,"Generate Region list with id=:$id and shownull=$showNull SQL: $sql");
	$selectctl="<SELECT name='region_id' >";
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

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end



  public function getLocationType($type,$value){
      //type=selection(S), text(T)
      //value: NG=Reject,FG=Finish Goods, MT=Material, WP=WIP, RW=Rework
      $result="";
      $selectNG="";
      $selectFG="";
      $selectMT="";
      $selectWP="";
      $selectRW="";
      $select="Selected='selected'";
      switch($value){
          case "NG":
              $result="Reject";
              $selectNG="$select";
              break;
          case "FG":
              $result="F.Goods";
              $selectFG="$select";
              break;
          case "MT":
              $result="Material";
              $selectMT="$select";
              break;
          case "WP":
              $result="WIP";
              $selectWP="$select";
              break;
          case "RW":
              $result="Rework";
              $selectRW="$select";
              break;


      }

//                        <option value='NG' $selectNG>Reject</option>
//                        <option value='FG' $selectFG>Finish Goods</option>
  //
    //                    <option value='WP' $selectWP>Work In Progress</option>
      //                  <option value='RW' $selectRW>Rework</option>

      if($type=='S'){
      return "<SELECT name='location_type'>
                  <option value='MT' $selectMT>Material</option>
              </SELECT>";
      }else
      {
        return $result;
      }
  }


  public function getSelectReminder($id,$showNull='N',$onchangefunction="",$ctrlname="reminder_id",$wherestr='') {
	global $defaultorganization_id;
	$wherestr .= " and organization_id = $defaultorganization_id ";

	$sql="SELECT reminder_id,reminder_title from $this->tablereminder where (reminder_id=$id
		OR reminder_id>0) and isactive=1 $wherestr
		order by reminder_title ;";
	$this->log->showLog(4,"getSelectReminder With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$reminder_id=$row['reminder_id'];
		$reminder_title=$row['reminder_title'];
		if($id==$reminder_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$reminder_id' $selected>$reminder_title</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";
	return $selectctl;
  }//end of get select reminder

public function getSelectAccountsAjax($id,$showNull='N',$onchangefunction="",$ctrlname="accounts_id",$wherestr='',$readonly='N',$isparent="N",$showlastbalance='N',
		$ctrlid='accounts_id',$width="",$showsearch="N",$line=0) {

	if($isparent == "N")
	$wherestr .= " and placeholder = 0 ";

	//$orderby = " order by defaultlevel,accounts_code,accounts_name ";
	$orderby = " order by accountcode_full ";

	if($readonly=='Y')
	$sql=	"SELECT accounts_id,accounts_code,accounts_name,accountcode_full,lastbalance from $this->tableaccounts
		where accounts_id=$id and organization_id=$this->defaultorganization_id $wherestr
		$orderby ;";
	else
	$sql=	"SELECT accounts_id,accounts_code,accounts_name,accountcode_full,lastbalance from $this->tableaccounts where (accounts_id=$id
		OR accounts_id>0) and organization_id=$this->defaultorganization_id $wherestr
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

	$selectctl=$selectctl . "<input type='button' value='...' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
        //$selectctl = $selectctl.$this->getZommCtrl('accounts_id',$ctrlid,'accounts.php');
	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput' style='display:none' autocomplete=off  onkeyup=getListDB('getlistdbaccount',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line')>";
	$selectctl=$selectctl . "<div id='$idlayer'></div>";
	}//ajax list

	if($readonly=='Y')
	return "<input type='hidden' name='$ctrlname' value='$id'><input name='accounts_desc' value='$accountcode_full-$accounts_name' readonly='readonly'  id='$ctrlid' $onchangefunction>";


	return $selectctl;
  }

  public function getZommCtrl($ctrlname,$ctrlid,$windows_name){

	global $url;

	if(strpos($ctrlname,'[') != "")
	$id_name = substr($ctrlname,0,strpos($ctrlname,'['));
	else
	$id_name = $ctrlname;


	$pathimg = $url.'/images/zoom.png';
        if($windows_name=="accounts.php"){
	$windows_name = $url."/modules/simbiz/$windows_name";
        }else{
            $windows_name = $url."/modules/system/$windows_name";
        }

	$selectctl = " <img src='$pathimg' style='cursor:pointer' onclick=openViewWindow('$windows_name','$ctrlname',document.getElementById('$ctrlid').value) >";

	//$selectctl = " <img src='images/zoom.png' style='cursor:pointer' onclick=openViewWindow(document.getElementById('id$ctrlname').value,'$windows_name','$id_name') >";

	return $selectctl;
  }

  public function getSelectEmployeeLeave($id,$showNull='N',$onchangefunction="",$ctrlname="employee_id",$wherestr='', $ctrlid="employee_id",$width="",$showsearch="N",$line=0) {
     //echo $app."xxx"; die();
	global $defaultorganization_id;

            $wherestr .= " and emp.organization_id = $defaultorganization_id and post.jobposition_id=emp.jobposition_id";

            $sql="SELECT emp.employee_id as employee_id,emp.employee_name as employee_name, post.jobposition_name as jobposition from $this->tableemployee emp, $this->tablejobposition post
                    where (emp.employee_id=$id OR emp.employee_id>0) and emp.isactive=1 $wherestr
                    order by emp.employee_name,cast(emp.employee_no as signed);";



	$this->log->showLog(4,"getSelectEmployeeLeave With SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' $onchangefunction id='$ctrlid' $width onmouseover ='tooltip(this)'>";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$employee_id=$row['employee_id'];
		$employee_name=$row['employee_name'];
                $jobposition=$row['jobposition'];
		if($id==$employee_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";

                    $selectctl=$selectctl  . "<OPTION value='$employee_id' $selected>$employee_name ($jobposition)</OPTION>";


	}

    $selectctl=$selectctl . "</SELECT>";

    if($showsearch=="Y"){//ajax list
	$idinput = $ctrlname."InputLayer".$ctrlid;
	$idlayer = $ctrlname."FormLayer".$ctrlid;

	if($onchangefunction == "")
	$onchangefunction = "0";
	else
	$onchangefunction = "1";

    $wherestr = str_replace(" ","#",$wherestr);
    $wherestr = str_replace("'","*",$wherestr);

	$selectctl=$selectctl . "<input type='button' value='>' style='width:20px' onclick=showSearchLayer('$idinput','$idlayer')>";
	//$selectctl = $selectctl.$this->getZommCtrl('employee_id',$ctrlid,'employee.php','hr');
	$selectctl=$selectctl . "<br><input type='input' value='' size='22' id='$idinput' style='display:none' autocomplete=off  onkeyup=getListDBWhere('getlistdbemployee',this.value,'$idinput','$idlayer','$ctrlid','$onchangefunction','$line','$wherestr')>";
	$selectctl=$selectctl . "<div id='$idlayer'></div>";
	}//ajax list


	return $selectctl;
  }
 /*
  * end of simedu select control class
  */
   /*
   * new for library module
   */

  public function getSelectLiblibrary($id,$showNull='N',$onchangefunction="",$ctrlname="liblibrary_id",$wherestr='') {
        //global $defaultorganization_id;
        //$wherestr = " and organization_id = $defaultorganization_id ";

        $sql="SELECT liblibrary_id,liblibrary_description from sim_simedu_liblibrary where (liblibrary_id=$id
                OR liblibrary_id>0) and isactive='1' $wherestr
                order by liblibrary_name desc;";
        $this->log->showLog(4,"getSelectLiblibrary With SQL: $sql");
        $selectctl="<SELECT name='$ctrlname' id='$ctrlname' $onchangefunction>";
        if ($showNull=='Y')
                $selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

        $query=$this->xoopsDB->query($sql);
        $selected="";
        while($row=$this->xoopsDB->fetchArray($query)){
                $liblibrary_id=$row['liblibrary_id'];
                $liblibrary_name=$row['liblibrary_description'];
                if($id==$liblibrary_id)
                        $selected='SELECTED="SELECTED"';
                else
                        $selected="";
                $selectctl=$selectctl  . "<OPTION value='$liblibrary_id' $selected>$liblibrary_name</OPTION>";

        }

        $selectctl=$selectctl . "</SELECT>";
        return $selectctl;
  }

   public function getSelectLibpublisher($id,$showNull='N',$onchangefunction="",$ctrlname="libpublisher_id",$wherestr='') {
        //global $defaultorganization_id;
        //$wherestr = " and organization_id = $defaultorganization_id ";

        $sql="SELECT libpublisher_id,libpublisher_description from sim_simedu_libpublisher where (libpublisher_id=$id
                OR libpublisher_id>0) and isactive='1' $wherestr
                order by libpublisher_name desc;";
        $this->log->showLog(4,"getSelectLibpublisher With SQL: $sql");
        $selectctl="<SELECT name='$ctrlname' id='$ctrlname' $onchangefunction>";
        if ($showNull=='Y')
                $selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

        $query=$this->xoopsDB->query($sql);
        $selected="";
        while($row=$this->xoopsDB->fetchArray($query)){
                $libpublisher_id=$row['libpublisher_id'];
                $libpublisher_name=$row['libpublisher_description'];
                if($id==$libpublisher_id)
                        $selected='SELECTED="SELECTED"';
                else
                        $selected="";
                $selectctl=$selectctl  . "<OPTION value='$libpublisher_id' $selected>$libpublisher_name</OPTION>";

        }

        $selectctl=$selectctl . "</SELECT>";
        return $selectctl;
  }

public function getSelectLibcategory($id,$showNull='N',$onchangefunction="",$ctrlname="libcategory_id",$wherestr='') {
    //global $defaultorganization_id;
    //$wherestr = " and organization_id = $defaultorganization_id ";

    $sql="SELECT libcategory_id,libcategory_description from sim_simedu_libcategory where (libcategory_id=$id
            OR libcategory_id>0) and isactive='1' $wherestr
            order by libcategory_name desc;";
    $this->log->showLog(4,"getSelectLibcategory With SQL: $sql");
    $selectctl="<SELECT name='$ctrlname' id='$ctrlname' $onchangefunction>";
    if ($showNull=='Y')
            $selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

    $query=$this->xoopsDB->query($sql);
    $selected="";
    while($row=$this->xoopsDB->fetchArray($query)){
            $libcategory_id=$row['libcategory_id'];
            $libcategory_name=$row['libcategory_description'];
            if($id==$libcategory_id)
                    $selected='SELECTED="SELECTED"';
            else
                    $selected="";
            $selectctl=$selectctl  . "<OPTION value='$libcategory_id' $selected>$libcategory_name</OPTION>";

    }

    $selectctl=$selectctl . "</SELECT>";
    return $selectctl;
}

  public function getSelectLibitemtype($id,$showNull='N',$onchangefunction="",$ctrlname="libitemtype_id",$wherestr='') {
        //global $defaultorganization_id;
        //$wherestr = " and organization_id = $defaultorganization_id ";

        $sql="SELECT libitemtype_id,libitemtype_description from sim_simedu_libitemtype where (libitemtype_id=$id
                OR libitemtype_id>0) and isactive='1' $wherestr
                order by libitemtype_name desc;";
        $this->log->showLog(4,"getSelectLibitemtype With SQL: $sql");
        $selectctl="<SELECT name='$ctrlname'  id='$ctrlname' $onchangefunction>";
        if ($showNull=='Y')
                $selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

        $query=$this->xoopsDB->query($sql);
        $selected="";
        while($row=$this->xoopsDB->fetchArray($query)){
                $libitemtype_id=$row['libitemtype_id'];
                $libitemtype_name=$row['libitemtype_description'];
                if($id==$libitemtype_id)
                        $selected='SELECTED="SELECTED"';
                else
                        $selected="";
                $selectctl=$selectctl  . "<OPTION value='$libitemtype_id' $selected>$libitemtype_name</OPTION>";

        }

        $selectctl=$selectctl . "</SELECT>";
        return $selectctl;
  }

       public function getSelectLiblocation($id,$showNull='N',$onchangefunction="",$ctrlname="liblocation_id",$wherestr='') {
        //global $defaultorganization_id;
        //$wherestr = " and organization_id = $defaultorganization_id ";

        $sql="SELECT liblocation_id,liblocation_description from sim_simedu_liblocation where (liblocation_id=$id
                OR liblocation_id>0) and isactive='1' $wherestr
                order by liblocation_name desc;";
        $this->log->showLog(4,"getSelectLiblocation With SQL: $sql");
        $selectctl="<SELECT name='$ctrlname' id='$ctrlname' $onchangefunction>";
        if ($showNull=='Y')
                $selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

        $query=$this->xoopsDB->query($sql);
        $selected="";
        while($row=$this->xoopsDB->fetchArray($query)){
                $liblocation_id=$row['liblocation_id'];
                $liblocation_name=$row['liblocation_description'];
                if($id==$liblocation_id)
                        $selected='SELECTED="SELECTED"';
                else
                        $selected="";
                $selectctl=$selectctl  . "<OPTION value='$liblocation_id' $selected>$liblocation_name</OPTION>";

        }

        $selectctl=$selectctl . "</SELECT>";
        return $selectctl;
   }
   public function getSelectSPMYear($spmyear_id="") {
	 $where="";

        $sql="SELECT * FROM $this->tablespmyear";
        $query=$this->xoopsDB->query($sql);


        //$rowcount=$this->xoopsDB->num_rows($query);
        $spmyearctrl= "<SELECT name='spmyear'>";
        while ($row=$this->xoopsDB->fetchArray($query)){
            if($row['spmyear_id']==$spmyear_id)
                $selected="SELECTED='selected'";
            else
                $selected="";
            $spmyearctrl.="<OPTION value=".$row['spmyear_id']." $selected>".$row['description']."</OPTION>";

        }
        $spmyearctrl.="</SELECT>";
        return $spmyearctrl;
  }

  public function getSelectInstituition($id,$showNull='N',$onchangefunction="",$ctrlname="instituition_id",$wherestr='') {
	 $where="";

        $sql="SELECT * FROM sim_simedu_instituition  where (instituition_id=$id
                OR instituition_id > 0) and isactive='1' $wherestr
                order by instituition_id, instituition_name  desc; ";
        $query=$this->xoopsDB->query($sql);


        //$rowcount=$this->xoopsDB->num_rows($query);
        $instituitionctrl= "<SELECT name='$ctrlname'>";
        //if ($showNull=='Y')
                //$instituitionctrl=$instituitionctrl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
        while ($row=$this->xoopsDB->fetchArray($query)){
            if($row['instituition_id']==$id)
                $selected='SELECTED="SELECTED"';
            else
                $selected="";
            $instituitionctrl.="<OPTION value=".$row['instituition_id']." $selected>".$row['instituition_name']."</OPTION>";

        }
        $instituitionctrl.="</SELECT>";
        return $instituitionctrl;
  }

  public function getSelectFaculty($id,$showNull='N',$onchangefunction="",$ctrlname="faculty_id",$wherestr='') {
	 $where="";
//if($id=="") $id=0;
        $sql="SELECT * FROM sim_simedu_faculty  where (faculty_id=$id
                OR faculty_id > 0) and isactive='1' $wherestr
                order by faculty_id, faculty_name  desc; ";
        $query=$this->xoopsDB->query($sql);

        //$rowcount=$this->xoopsDB->num_rows($query);
        $facultyctrl= "<SELECT name='$ctrlname'>";
        if ($showNull=='Y')
                $facultyctrl=$facultyctrl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
        while ($row=$this->xoopsDB->fetchArray($query)){
            if($row['faculty_id']==$id)
                $selected='SELECTED="SELECTED"';
            else
                $selected="";
            $facultyctrl.="<OPTION value=".$row['faculty_id']." $selected>".$row['faculty_name']."</OPTION>";

        }
        $facultyctrl.="</SELECT>";
        return $facultyctrl;
  }
}

?>
