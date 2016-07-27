<?php
/************************************************************************
  			ClassCurrency.php - Copyright kstan

Here you can write a license for your code, some comments or any other
information you want to have in your generated code. To to this simply
configure the "headings" directory in uml to point to a directory
where you have your heading files.

or you can just replace the contents of this file with your own.
If you want to do this, this file is located at

/usr/share/apps/umbrello/headings/heading.php

-->Code Generators searches for heading files based on the file extension
   i.e. it will look for a file name ending in ".h" to include in C++ header
   files, and for a file name ending in ".java" to include in all generated
   java code.
   If you name the file "heading.<extension>", Code Generator will always
   choose this file even if there are other files with the same extension in the
   directory. If you name the file something else, it must be the only one with that
   extension in the directory to guarantee that Code Generator will choose it.

you can use variables in your heading files which are replaced at generation
time. possible variables are : author, date, time, filename and filepath.
just write %variable_name%

This file was generated on Tue Mar 25 2008 at 01:10:25
The original location of this file is /home/kstan/Desktop/ClassCurrency.php
**************************************************************************/

/**
 * class ProductCurrency
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Currency
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $currency_id;
  public $currency_symbol;
  public $currency_description;
  public $isactive=0;
  public $isdefault=0;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  private $xoopsDB;
  private $tableprefix;
  private $tablecurrency;
  private $tableworker;
  private $log;


//constructor
   public function Currency($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableworker=$tableprefix . "simfworker_worker";
	$this->tablecurrency=$tableprefix."simfworker_currency";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int currency_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $currency_id,$token  ) {
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";


	$this->created=0;
	if ($type=="new"){
		$header="New Currency";
		$action="create";
	 	
		if($currency_id==0){
			$this->currency_symbol="";
			$this->currency_description="";
			$this->isactive="1";
			$this->isdefault="0";
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$defaultchecked="";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

	}
	else
	{
		
		$action="update";
		$savectrl="<input name='currency_id' value='$this->currency_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablecurrency' type='hidden'>".
		"<input name='id' value='$this->currency_id' type='hidden'>".
		"<input name='idname' value='currency_id' type='hidden'>".
		"<input name='title' value='Currency' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='1')
			$checked="CHECKED";
		else
			$checked="";

		if ($this->isdefault=='1')
			$defaultchecked="CHECKED";
		else
			$defaultchecked="";

		$header="Edit Currency";
		
		if($this->allowDelete($this->currency_id))
		$deletectrl="<FORM action='currency.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this currency?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->currency_id' name='currency_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='currency.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Currency Master Data</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateCurrency()" method="post"
 action="currency.php" name="frmCurrency"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
    
      <tr>
        <td class="head">Currency Symbol</td>
        <td class="even" ><input maxlength="3" size="3"
 name="currency_symbol" value="$this->currency_symbol">
	<td class="head">Active </td><td class="even"><input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Currency Description</td>
        <td class="odd"><input maxlength="30" size="30"
 name="currency_description" value="$this->currency_description">
	<td class="head"> Default	</td>
	<td class="odd"><input type="checkbox" $defaultchecked name="isdefault"></td>
      </tr>
    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  /**
   * Update existing currency record
   *
   * @return bool
   * @access public
   */
  public function updateCurrency( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablecurrency SET ".
	"currency_description='$this->currency_description',currency_symbol='$this->currency_symbol',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',isdefault=$this->isdefault ".
	"WHERE currency_id='$this->currency_id'";
	
	$this->log->showLog(3, "Update currency_id: $this->currency_id, $this->currency_symbol");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update currency failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update currency successfully.");
		return true;
	}
  } // end of member function updateCurrency

  /**
   * Save new currency into database
   *
   * @return bool
   * @access public
   */
  public function insertCurrency( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new currency $this->currency_symbol");
 	$sql="INSERT INTO $this->tablecurrency (currency_description,currency_symbol".
	",isactive, created,createdby,updated,updatedby,isdefault) values(".
	"'$this->currency_description','$this->currency_symbol','$this->isactive','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,$this->isdefault)";
	$this->log->showLog(4,"Before insert currency SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert currency code $currency_symbol");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new currency $currency_symbol successfully"); 
		return true;
	}
  } // end of member function insertCurrency

  /**
   * Pull data from currency table into class
   *
   * @return bool
   * @access public
   */
  public function fetchCurrency( $currency_id) {
    
	$this->log->showLog(3,"Fetching currency detail into class Currency.php.<br>");
		
	$sql="SELECT currency_id,currency_symbol,currency_description,isactive,isdefault from $this->tablecurrency ". 
			"where currency_id=$currency_id";
	
	$this->log->showLog(4,"ProductCurrency->fetchCurrency, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->currency_symbol=$row["currency_symbol"];
		$this->currency_description= $row['currency_description'];
		$this->isactive=$row['isactive'];
		$this->isdefault=$row['isdefault'];

	$this->log->showLog(4,"Currency->fetchCurrency,database fetch into class successfully");
	$this->log->showLog(4,"currency_symbol:$this->currency_symbol");
	$this->log->showLog(4,"currency_description:$this->currency_description");
	$this->log->showLog(4,"isactive:$this->isactive");


		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Currency->fetchCurrency,failed to fetch data into databases.");	
	}
  } // end of member function fetchCurrency

  /**
   * Delete particular currency id
   *
   * @param int currency_id 
   * @return bool
   * @access public
   */
  public function deleteCurrency( $currency_id ) {
    	$this->log->showLog(2,"Warning: Performing delete currency id : $currency_id !");
	$sql="DELETE FROM $this->tablecurrency where currency_id=$currency_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: currency ($currency_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"currency ($currency_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteCurrency

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllCurrency( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductCurrency->getSQLStr_AllCurrency: $sql");
    $sql="SELECT currency_symbol,currency_description,currency_id,isactive,isdefault FROM $this->tablecurrency " .
	" $wherestring $orderbystring";
  return $sql;
  } // end of member function getSQLStr_AllCurrency

 public function showCurrencyTable(){
	
	$this->log->showLog(3,"Showing Currency Table");
	$sql=$this->getSQLStr_AllCurrency($wherestring,"ORDER BY currency_symbol",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Currency Name</th>
				<th style="text-align:center;">Currency Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Default</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$currency_id=$row['currency_id'];
		$currency_symbol=$row['currency_symbol'];
		$currency_description=$row['currency_description'];
		$isdefault=$row['isdefault'];
		$isactive=$row['isactive'];

		if($isactive=='1')
			$isactive='Y';
		else
			$isactive='N';
		if($isdefault=='1')
			$isdefault='Y';
		else
			$isdefault='N';

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$currency_symbol</td>
			<td class="$rowtype" style="text-align:center;">$currency_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$isdefault</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="currency.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this currency'>
				<input type="hidden" value="$currency_id" name="currency_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestCurrencyID() {
	$sql="SELECT MAX(currency_id) as currency_id from $this->tablecurrency;";
	$this->log->showLog(3,'Checking latest created currency_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created currency_id:' . $row['currency_id']);
		return $row['currency_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectCurrency($id) {

	$sql="SELECT currency_id,currency_symbol from $this->tablecurrency where isactive='1' or  currency_id=$id order by isdefault desc,currency_symbol ;";
	$this->log->showLog(4,"Showing currency selection: $sql");
	$selectctl="<SELECT name='currency_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$currency_id=$row['currency_id'];
		$currency_symbol=$row['currency_symbol'];
	
		if($id==$currency_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$currency_id' $selected>$currency_symbol</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(currency_id) as rowcount from $this->tableworker where currency_id=$id";
	$this->log->showLog(3,"Accessing ProductCurrency->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this currency, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this currency, record deletable");
		return true;
		}
	}
} // end of ClassCurrency
?>
