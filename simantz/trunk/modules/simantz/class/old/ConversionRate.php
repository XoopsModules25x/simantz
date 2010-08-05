<?php

class ConversionRate{

public $currencyfrom_id;
public $currencyto_id;
public $organization_id;
public $multiplyvalue;
public $devidevalue;
public $isactive;
public $description;
public $createdby;
public $created;
public $updatedby;
public $updated;

public $new_effectivedate;
public $new_multiplyvalue;
public $new_isactive;
public $new_description;

private $xoopsDB;
private $log;
private $tablecurrency;
private $tablecountry;
private $tableconversionrate;
private $ctrl;
public function ConversionRate(){
	global $xoopsDB,$log,$tablecurrency,$tablecountry,$tableconversionrate,$defaultorganization_id,$ctrl;
  	$this->xoopsDB=$xoopsDB;
	$this->tablecurrency=$tablecurrency;
	$this->ctrl=$ctrl;
	$this->tablecountry=$tablecountry;
	$this->tableconversionrate=$tableconversionrate;
	$this->log=$log;
	}

public function showConversionTable($currencyfrom_id){
global $defaultorganization_id;
$this->currencyfrom_id=$currencyfrom_id;
$sql="SELECT cvr.conversion_id,cvr.currencyto_id,cur.currency_name, cvr.multiplyvalue, cvr.effectivedate, cvr.isactive,cvr.description 
	FROM $this->tableconversionrate cvr 
	INNER JOIN $this->tablecurrency cur on cvr.currencyto_id=cur.currency_id
	 where cvr.currencyfrom_id=$currencyfrom_id and cvr.organization_id=$defaultorganization_id";
$this->log->showLog(4,"showConversionTable with SQL: $sql");
$table="<TABLE><TBODT><TR>
			<TH>Convert To Currency</TH>
			<TH>Effective Date</TH>
			<TH>Multiply Value</TH>
			<TH>Active</TH>
			<TH>Description</TH>
			<TR>
";
$newcurrencytoctrl=$this->ctrl->getSelectCurrency(0,'Y','new_currencyto_id',"AND currency_id<>$currencyfrom_id");
$query=$this->xoopsDB->query($sql);
$date=date('Y-m-d',time());
$i=0;
while($row=$this->xoopsDB->fetchArray($query)){
$currencyto_id=$row['currencyto_id'];
$multiplyvalue=$row['multiplyvalue'];
$effectivedate=$row['effectivedate'];
$isactive=$row['isactive'];
if($isactive==1)
$checked='checked';
else
$checked='';

$conversion_id=$row['conversion_id'];
$description=$row['decription'];
$currencytoctrl=$this->ctrl->getSelectCurrency($currencyto_id,'Y',"linecurrencyto_id[$i]","AND currency_id<>$currencyfrom_id");
$table=$table."
		<tr>
			<td>$currencytoctrl <input value='$conversion_id' name='lineconversion_id[$i]' type='hidden'>
			Choose 'Null' To Delete</td>
			<td><input value='$effectivedate' name='lineeffectivedate[$i]'></td>
			<td><input value='$multiplyvalue' name='linemultiplyvalue[$i]'></td>
			<td><input type='checkbox' name='lineisactive[$i]'$checked></td>
			<td><input name='linedescription[$i]' value='$description'></td>
		</tr>";
$i++;
}
$table=$table."		<tr>
			<td>* New $newcurrencytoctrl</td>
			<td><input value='$date' name='new_effectivedate'></td>
			<td><input value='0' name='new_multiplyvalue'></td>
			<td><input type='checkbox' name='new_isactive' checked></td>
			<td><input name='new_description' ></td>
		</tr>
</TBODY></TABLE>";
return $table;

}

 public function save(){
	global $defaultorganization_id;
	if($this->new_currencyto_id!=0 && $this->new_isactive=='on'){
		if($this->new_isactive=='on')
			$this->new_isactive=1;
		else
			$this->new_isactive=0;
		$sql1="INSERT INTO $this->tableconversionrate (currencyfrom_id,currencyto_id,organization_id,multiplyvalue,
			isactive,description,effectivedate) VALUES ($this->currencyfrom_id,$this->new_currencyto_id,$defaultorganization_id,
			$this->new_multiplyvalue,$this->new_isactive,'$this->new_description','$this->new_effectivedate')";
	
	
		$rs1=$this->xoopsDB->query($sql1);
		if($rs1)
			$this->log->showLog(4,"Insert new conversion at save() with SQL: $sql1");
		else
			$this->log->showLog(1,"Failed to insert new conversion at save() with SQL: $sql1");
	}
	$i=0;	
	foreach($this->lineconversion_id as $id){
		$currencyto_id=$this->linecurrencyto_id[$i];
		$multiplyvalue=$this->linemultiplyvalue[$i];
		$effectivedate=$this->lineeffectivedate[$i];
		$description=$this->linedescription[$i];
		$isactive=$this->lineisactive[$i];
		if($isactive=='on')
			$isactive=1;
		else
			$isactive=0;
		if($currencyto_id>0)
		$sql2="UPDATE $this->tableconversionrate set currencyto_id=$currencyto_id, multiplyvalue=$multiplyvalue, 
			effectivedate='$effectivedate', description='$description',isactive=$isactive where conversion_id=$id";	
		else
		$sql2="DELETE FROM $this->tableconversionrate where conversion_id=$id";	
		
		$rs2=$this->xoopsDB->query($sql2);
		if($rs2)
			$this->log->showLog(4,"Update conversionrate successfully at save() with SQL2: $sql2");
		else
			$this->log->showLog(1,"Update conversionrate failed at save() with SQL2: $sql2");
		$i++;
	}
  }
}
?>
