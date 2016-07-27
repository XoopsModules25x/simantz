<?php

/**
 * class ProductTest
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Test
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $test_id;
  public $test_name;
  public $test_description;
  public $classctrl;
  public $employeectrl;
  public $studentctrl;
  public $created;
  public $createdby;
  public $updated;
  public $highestmark=0;
  public $lowestmark=0;
  public $averagemark=0;
  public $student_id;
  public $showDate;
  public $orgctrl;
  public $cur_name;
  public $cur_symbol;
  public $updatedby;
  public $linetestline_id;
  public $lineresult;
  public $linedescription;
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tabletuitionclass;
  private $tableemployee;
  private $tabletest;
  private $tabletestline;
  private $tablestudent;
  private $tablestudentclasss;
  private $log;

 
//constructor
   public function Test($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tabletest=$tableprefix."simtrain_test";
	$this->tabletestline=$tableprefix."simtrain_testline";
  	$this->tabletuitionclass=$tableprefix."simtrain_tuitionclass";
  	$this->tableemployee=$tableprefix."simtrain_employee";
	$this->tablestudentclass=$tableprefix."simtrain_studentclass";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int test_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $test_id,$token  ) {
	
	$mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Test";
		$action="create";
	 	
		if($test_id==0){
			$this->test_name="";
			$this->test_description="";
			
			$this->averagemark=0;
			$this->lowestmark=0;
			$this->highestmark=0;
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";


	}
	else
	{
		
		$action="update";
		$savectrl="<input name='test_id' value='$this->test_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tabletest' type='hidden'>".
		"<input name='id' value='$this->test_id' type='hidden'>".
		"<input name='idname' value='test_id' type='hidden'>".
		"<input name='title' value='Test' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		



	
		$header="Edit Test";
		
		
		$deletectrl="<FORM action='test.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this test?"'.")'>
		<input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->test_id' name='test_id'>".
		"<input type='hidden' value='$this->tuitionclass_id' name='tuitionclass_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";

		$printctrl="<FORM action='viewtest.php' method='POST' target='_blank'>
		<input type='submit' value='Print Preview' name='submit'>".
		"<input type='hidden' value='$this->test_id' name='test_id'>".
		"<input type='hidden' value='edit' name='action'></form>";

		$backtoclassctrl="<FORM action='tuitionclass.php' method='POST'>
		<input type='submit' value='Back To Class' name='submit'>".
		"<input type='hidden' value='$this->tuitionclass_id' name='tuitionclass_id'>".
		"<input type='hidden' value='edit' name='action'>
		<input name='token' value='$token' type='hidden'></form>";

		$addnewctrl="<Form action='test.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<br>
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Test Info</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateTest()" method="post"
 action="test.php" name="frmTest"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
       <tr>
        <td class="head">Test Name $mandatorysign</td>
        <td class="even" >
		<input maxlength="40" size="40"
			 name="test_name" value="$this->test_name">
	</td>
       <td class="head">Tuition Class $mandatorysign</td>
        <td class="even">
		 $this->classctrl
	</td>
      </tr>
      <tr>
        <td class="head">Date (YYYY-MM-DD) $mandatorysign</td>
        <td class="odd"><input maxlength="10" size="10"
 name="testdate" id='testdate' value="$this->testdate">
		<input type='button' name='btnDate' value='Date' onClick="$this->showDate"></td>
<td class="head">Tutor</td>
        <td class="odd">
$this->employeectrl</td>
 </tr>
<tr>
  <tr>
        <td class="head">Highest / Lowest / Average Mark</td>
        <td class="even" >
	<input name='deleteline' value=0 type='hidden'>
	<input maxlength="5" size="5" name="highestmark" value="$this->highestmark" readonly>
	<input maxlength="5" size="5" name="lowestmark" value="$this->lowestmark" readonly>
	<input maxlength="5" size="5" name="averagemark" value="$this->averagemark" readonly></td>
   <td class="head">Test Description</td>
        <td class="even"><input maxlength="40" size="40"
 name="test_description" value="$this->test_description"></td>
</tr>
    </tbody>
  </table><br><br>
EOF;
$this->showChild();
echo <<< EOF
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$printctrl</td><td>$deletectrl</td><td>$backtoclassctrl</td></tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  /**
   * Update existing test record
   *
   * @return bool
   * @access public
   */
  public function updateTest( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tabletest SET 
	test_description='$this->test_description',test_name='$this->test_name',
	updated='$timestamp',updatedby=$this->updatedby,
	testdate='$this->testdate',employee_id=$this->employee_id,tuitionclass_id=$this->tuitionclass_id,
	highestmark=$this->highestmark,lowestmark=$this->lowestmark,averagemark=$this->averagemark
	WHERE test_id='$this->test_id'";
	
	$this->log->showLog(3, "Update test_id: $this->test_id, $this->test_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update test failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update test successfully.");
		return true;
	}
  } // end of member function updateTest

  /**
   * Save new test into database
   *
   * @return bool
   * @access public
   */
  public function insertTest( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new test $this->test_name");
 	$sql="INSERT INTO $this->tabletest (test_description,test_name,testdate,employee_id,tuitionclass_id
	,created,createdby,updated,updatedby) values(
	'$this->test_description','$this->test_name','$this->testdate',$this->employee_id, 
	$this->tuitionclass_id, '$timestamp',$this->createdby,'$timestamp',
	$this->updatedby)";
	$this->log->showLog(4,"Before insert test SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert test code $test_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new test $test_name successfully"); 
		return true;
	}
  } // end of member function insertTest

  /**
   * Pull data from test table into class
   *
   * @return bool
   * @access public
   */
  public function fetchTest( $test_id) {
    
	$this->log->showLog(3,"Fetching test detail into class Test.php.<br>");
		
	$sql="SELECT test_id,test_name,test_description,employee_id,tuitionclass_id,
		averagemark,highestmark,lowestmark,testdate from $this->tabletest ". 
			"where test_id=$test_id";
	
	$this->log->showLog(4,"ProductTest->fetchTest, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->test_name=$row["test_name"];
		$this->test_description= $row['test_description'];

		$this->employee_id=$row['employee_id'];
		$this->tuitionclass_id=$row['tuitionclass_id'];
		$this->lowestmark=$row['lowestmark'];
		$this->highestmark=$row['highestmark'];
		$this->averagemark=$row['averagemark'];
		$this->testdate=$row['testdate'];
   	$this->log->showLog(4,"Test->fetchTest,database fetch into class successfully");
	$this->log->showLog(4,"test_name:$this->test_name");
	$this->log->showLog(4,"test_description:$this->test_description");

	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Test->fetchTest,failed to fetch data into databases.");	
	}
  } // end of member function fetchTest

  /**
   * Delete particular test id
   *
   * @param int test_id 
   * @return bool
   * @access public
   */
  public function deleteTest( $test_id ) {
    	$this->log->showLog(2,"Warning: Performing delete test id : $test_id !");
	$sql="DELETE FROM $this->tabletest where test_id=$test_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: test ($test_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"test ($test_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteTest

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllTest( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductTest->getSQLStr_AllTest: $sql");
    $sql="SELECT test_name,test_description,test_id FROM $this->tabletest " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showtesttable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllTest

 public function showTestTable(){
	
	$this->log->showLog(3,"Showing Test Table");
	$sql=$this->getSQLStr_AllTest("WHERE test_id>0","ORDER BY test_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Test Name</th>
				<th style="text-align:center;">Test Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$test_id=$row['test_id'];
		$test_name=$row['test_name'];
		$test_description=$row['test_description'];


		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$test_name</td>
			<td class="$rowtype" style="text-align:center;">$test_description</td>

			<td class="$rowtype" style="text-align:center;">
				<form action="test.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this test'>
				<input type="hidden" value="$test_id" name="test_id">
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
  public function getLatestTestID() {
	$sql="SELECT MAX(test_id) as test_id from $this->tabletest;";
	$this->log->showLog(3,'Checking latest created test_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created test_id:' . $row['test_id']);
		return $row['test_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectTest($id,$showNull='N') {
	
	$sql="SELECT test_id,test_name from $this->tabletest where test_id=$id and test_id>0 order by test_name ;";
	$this->log->showLog(3,"Generate Test list with id=:$id and shownull=$showNull");
	$selectctl="<SELECT name='test_id' >";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$test_id=$row['test_id'];
		$test_name=$row['test_name'];
	
		if($id==$test_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$test_id' $selected>$test_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function showHeader($test_id){
$sql="SELECT t.test_id,t.test_name,t.tuitionclass_id,tc.tuitionclass_code,tc.description,
		e.employee_name,e.employee_id 
		from $this->tabletest t
		INNER JOIN $this->tabletuitionclass tc on t.tuitionclass_id=tc.tuitionclass_id
		INNER JOIN $this->tableemployee e on e.employee_id=tc.employee_id 
		where t.test_id=$test_id and t.test_id>0 order by t.test_name ;";
	$this->log->showLog(3,"Generate Test table header with sql =$sql ");

$query=$this->xoopsDB->query($sql);
$i=0;
if($row=$this->xoopsDB->fetchArray($query)){
$employee_name=$row['employee_name'];
$tuitionclass_code=$row['tuitionclass_code'];
$tuitionclass_id=$row['tuitionclass_id'];
$description=$row['description'];
$test_name=$row['test_name'];

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Class Info</span></big></big></big></div><br>

<table border='1'>
<tbody>
<tr>
<TD class='head'>Class Code</TD>
     <TD class='odd'>
		<A href='tuitionclass.php?action=edit&tuitionclass_id=$this->tuitionclass_id'>
		$tuitionclass_code</A>
    </TD>
    <TD class='head'>Description</TD><TD class='odd'>$description</TD></tr>
</tbody>
</table>

EOF;
 }
}

public function showChild(){
$sql="SELECT s.student_id,s.student_name,s.student_code, tl.description, tl.result, tl.testline_id
	FROM $this->tabletestline tl
	INNER JOIN $this->tablestudent s on tl.student_id=s.student_id
	WHERE tl.test_id=$this->test_id";
	$this->log->showLog(3,"Show Child testline table: $sql ");

$query=$this->xoopsDB->query($sql);
$i=0;

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Student Info</span></big></big></big></div><br>

<table border='1'>
<tbody>
<tr>
<Th style="text-align: center">No</TH>
<Th style="text-align: center">Index</TH>
<TH style="text-align: center">Student Name</TH>
<TH style="text-align: center">Result</TH>
<Th style="text-align: center">Description</TH>
<TH style="text-align: center">Remove</TH>

EOF;
$rowtype="odd";
$i=0;
while($row=$this->xoopsDB->fetchArray($query)){
$student_code=$row['student_code'];
$student_id=$row['student_id'];
$student_name=$row['student_name'];
$description=$row['description'];
$result=$row['result'];
$testline_id=$row['testline_id'];
$no=$i+1;
echo <<< EOF
	<tr>
     <TD class="$rowtype">$no<input type='hidden' name='linetestline_id[$i]' 
			id="linetestline_id$testline_id" value="$testline_id"></TD>
     <TD class="$rowtype">$student_code</TD>
     <TD class="$rowtype"><A href="student.php?action=edit&student_id=$student_id">$student_name</A></TD>
     <TD class="$rowtype"><input size='5' maxlength='5' name='lineresult[$i]' value="$result"></TD>
	     <TD class="$rowtype">
		<input size='30' maxlength='30' name='linedescription[$i]' value="$description"></TD>
     <TD class="$rowtype"><input type='button' value="Del" name='btnDelLine' 
			onclick="changeDeleteID($testline_id)">
</TD>
	</tr>
EOF;
$i++;
 }
echo "</tbody></table>";
}


public function generateTestLine(){
$sql1="SELECT student_id FROM $this->tablestudentclass WHERE tuitionclass_id=$this->tuitionclass_id";
$this->log->showLog(3,"Show Child testline table: $sql1");

$query=$this->xoopsDB->query($sql1);
$i=0;

$rowtype="odd";
while($row=$this->xoopsDB->fetchArray($query)){

  $student_id=$row['student_id'];
  $sql2="INSERT INTO $this->tabletestline (student_id,test_id) VALUES ($student_id,$this->test_id)";
  $this->log->showLog(3,"Insert testline with sql: $sql2");
  $rsinsert=$this->xoopsDB->query($sql2);

	if($rsinsert){
 	 $this->log->showLog(4,"Insert successfully");
	}
	else{
 	 $this->log->showLog(1,"Insert failed");
	return false;
	}

}
return true;

}

  public function updateTestLine($deleteline){
	$this->log->showLog(3,"Update testline");
	$this->outstandingamt=0;

	$i=0;
	
	foreach($this->linetestline_id as $id )
		{	
			if($deleteline==$id)
				continue;
			$result=$this->lineresult[$i];
			$description=$this->linedescription[$i];

			if($i==0)
			$this->lowestmark=$result;

			if($result > $this->highestmark)
				$this->highestmark=$result;
			elseif($result < $this->lowestmark )
				$this->lowestmark=$result;

			$this->averagemark=($this->averagemark * $i + $result ) / ($i +1);


	
			$sqlupdate="UPDATE $this->tabletestline 
						SET result=$result,description='$description' WHERE testline_id =$id";

			$this->log->showLog(4,"Update testline_id: $id with sql: $sqlupdate");
			$rs=$this->xoopsDB->query($sqlupdate);
			if(!$rs){
				$this->log->showLog(4,"<br><b style='color: red'>Failed to update testline id: $id </b>");
				}
			else
				$this->log->showLog(4,"Update testline id: $id successfully");
			$i=$i+1;
		}
	  return true;
  }

  public function deleteTestLine($deleteline){
	if($deleteline==0)
		return true;
	else{
		$sqldelete="DELETE FROM $this->tabletestline where testline_id=$deleteline";
		$this->log->showLog(3,"Delete testline with SQl:$sql");
		$query=$this->xoopsDB->query($sqldelete);
		if($query){
		$this->log->showLog(4,"Delete testline with successfully");

			return true;
		}
		else{
		$this->log->showLog(3,"Delete testline failed.");

			return false;
		}

	}


	}

  public function addTestLine(){
		$sql="INSERT INTO $this->tabletestline (student_id,test_id) VALUES ($this->student_id,$this->test_id)";
		$this->log->showLog(3,"insert testline with SQl:$sql");
		$query=$this->xoopsDB->query($sql);
		if($query){
		$this->log->showLog(4,"insert testline successfully");

			return true;
		}
		else{
		$this->log->showLog(3,"insert testline failed.");

			return false;
		}


	}

  public function showAddTestLine($token){
echo <<< EOF
	
<table border='1'>
  <tbody>
    <tr>
      <th style='text-align:center;' colspan='4'>Add Student</th>
    </tr>
<form action='test.php' method="POST" name='frmAddTestLine' onsubmit="return confirm('Confirm add this student?')">
    <tr>
      <td>Student</td>
      <td>$this->studentctrl</td>
      <td>

	<input type='hidden' value="$token" name='token'>
	<input type='hidden' value='addline' name='action'>
	<input type='hidden' value="$this->test_id" name='test_id'>
	<input type='submit' value='Add' name='submit'>
	</form></td>
    </tr>
  </tbody>
</table>
EOF;

	}
} // end of ClassTest
?>
