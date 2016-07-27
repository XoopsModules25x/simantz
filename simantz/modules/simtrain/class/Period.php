<?php 
class Period {

public $period_id;
public $period_name;
public $datefrom;
public $dateto;
public $organization_id;
public $cur_name;
public $cur_symbol;
public $createdby;
public $updatedby;
public $year;
public $month;

private $xoopsDB;
private $log;
private $tableprefix;
private $tableperiod;

public function Period($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->log=$log;
	$this->tableperiod=$tableprefix ."simtrain_period";

}

public function insertPeriod(){
 	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new period $this->period_name");
 	$sql="INSERT INTO $this->tableperiod (period_name,year,month,isactive,createdby,created,updatedby,updated) values(".
	"'$this->period_name','$this->year','$this->month','$this->isactive',$this->createdby,'$timestamp',$this->updatedby,'$timestamp')";
	$this->log->showLog(4,"Before insert period SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert period $this->period_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new period $this->period_name successfully"); 
		return true;
	}
}

public function updatePeriod( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableperiod SET ".
	"period_name='$this->period_name',updatedby=$this->updatedby,updated='$timestamp',isactive='$this->isactive', ".
			"year=$this->year,month=$this->month WHERE period_id='$this->period_id'";
	
	$this->log->showLog(3, "Update period_id: $this->period_id, $this->period_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update period failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update period successfully.");
		return true;
	}
  } // end of member function updateCategory



public function getInputForm( $type,  $period_id,$token  ) {
	
	$mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$checked='';
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Period";
		$action="create";
	 	
		if($period_id==0){
			$this->period_name="";
			$this->isactive="";

		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$deletectrl="";
		$addnewctrl="";
		$checked='checked';

	}
	else
	{
		$action="update";
		$savectrl="<input name='period_id' value='$this->period_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";
		$header="Update Period";
		if($this->isactive=='Y')
			$checked='checked';

		
		/*if($this->allowDelete($this->category_id))
		$deletectrl="<FORM action='category.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this category?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->category_id' name='category_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
	*/
		$addnewctrl="<Form action='period.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Period</span></big></big></big></div><br>-->

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validatePeriod();" method="post"
 action="period.php" name="frmPeriod"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="6" rowspan="1">$header</th>
      </tr>
        <tr>
        <td class="head">Period Name (YYYY-MM) $mandatorysign</td>
        <td class="odd" colspan="2"><input name="period_name" value="$this->period_name"></td>

      	<td class="head">Active</td>
        <td class="odd" colspan="2"><input type="checkbox" name="isactive" $checked></td>
      </tr>
      <tr>

        <td class="head">Year $mandatorysign</td>
        <td class="odd" colspan="2"><input name="year" value="$this->year"></td>

      	<td class="head">Month $mandatorysign</td>
        <td class="odd" colspan="2"><input name="month" value="$this->month"></td>
      </tr>
    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table>
  <br>



EOF;
  } 
public function showPeriodTable(){
	
	$this->log->showLog(3,"Showing Period Table");
	$sql="SELECT period_id,period_name,year,month,isactive from $this->tableperiod where period_id>0 order by period_name desc";
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Name</th>
				<th style="text-align:center;">Year</th>
				<th style="text-align:center;">Month</th>
				<th style="text-align:center;">Active</th>

				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$period_id=$row['period_id'];
		$period_name=$row['period_name'];
		$isactive=$row['isactive'];
		$month=$row['month'];
		$year=$row['year'];
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$period_name</td>
			<td class="$rowtype" style="text-align:center;">$year</td>
			<td class="$rowtype" style="text-align:center;">$month</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="period.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title="Edit this period, avoid changing the period name, unless you know this period never use before.">
				<input type="hidden" value="$period_id" name="period_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }


public function getPeriodList($id,$ctrlname='period_id',$showNull='N'){
	$this->log->showLog(3,"Retrieve available period from database");

	$sql="SELECT period_id,period_name from $this->tableperiod where (isactive='Y' or period_id=$id) and period_id>0 order by period_name desc";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='$ctrlname' >";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
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

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

 public function fetchPeriod( $period_id) {
    
	$this->log->showLog(3,"Fetching period detail into class Period.php.<br>");
		
	$sql="SELECT period_id,period_name,isactive,year,month from $this->tableperiod ". 
			"where period_id=$period_id";
	
	$this->log->showLog(4,"Period->fetchperiod, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->period_id=$row["period_id"];
		$this->year=$row["year"];
		$this->month=$row["month"];
		$this->period_name=$row["period_name"];
		$this->isactive=$row['isactive'];

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Category->fetchCategory,failed to fetch data into databases.");	
	}
  }
}
?>