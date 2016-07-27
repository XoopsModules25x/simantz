<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
class RegProduct{

  public $studentclass_id=0;
  public $orgctrl;
  public $studentctrl;
  public $classctrl;
  public $areacf_ctrl;
  public $areact_ctrl;
  public $areabf_ctrl;
  public $areabt_ctrl;
  public $period;
  public $student_id;
  public $student_name;
  public $ic_no;
  public $description;
  public $cur_name;
  public $cur_symbol;
  public $student_code;
  public $createdby;
  public $updatedby;
  public $tuitionclass_id;
  public $isactive;
  public $comeactive;
  public $backactive;
  public $updatestandard;
  public $trainingfees;
  public $paidamt;
  public $transportfees;
  public $comeareafrom_id;
  public $comeareato_id;
  public $productctrl;
  public $showcalendar;
  public $includeall;
  public $ispaid;
  public $transactiondate; //it will keep the date of registration, if this record is generated via 'Clone', the date will keep as 0000-00-00
  public $backareafrom_id;
  public $backareato_id;
  public $transportationmethod;
  public $organization_id;
  public $clone_id;
  public $datefrom;
   public $isAdmin;
  public $movement_id;
  public $movementctrl;
  public $dateto;
  public $datefromctrl;
  public $datetoctrl;
  public $futuretrainingfees;
  public $futuretransportfees;

  public $xoopsDB;
  private $log;
  public $tableprefix;
  public $tablestudentclass;
  public $tabletransport;
  public $tablestudent;
  public $tableaddress;
  public $tableproductlist;
  public $tabletuitionclass;
  public $tablepaymentline;
  public $tableemployee;
  public $tableperiod;
   /**
   *
   * @param xoopsDB $xoopsDB
   * @param string $tableprefix
   * @param log $log
   * Constructor for class RegClass
   * @access public
   */
  public function RegProduct ($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
	$this->tableprefix=$tableprefix;
	$this->tablestudentclass=$tableprefix."simtrain_studentclass";
	$this->tablestudent=$tableprefix."simtrain_student";
	$this->tableproductlist=$tableprefix."simtrain_productlist";
	$this->tabletuitionclass=$tableprefix."simtrain_tuitionclass";
	$this->tablepaymentline=$tableprefix."simtrain_paymentline";
	$this->tableemployee=$tableprefix."simtrain_employee";
	$this->tabletransport=$tableprefix."simtrain_transport";
	$this->tablearea=$tableprefix."simtrain_area";
	$this->tableaddress=$tableprefix."simtrain_address";
	$this->tableperiod=$tableprefix."simtrain_period";
  } //end RegClass

   /**
   *
   * @param int $student_id
   * A simple header to tell end user what is current student
   * @access public
   */
   public function showRegistrationHeader(){
	echo <<< EOF
	<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">$this->student_name Purchased Item</span></big></big></big></div><br>
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Student Info</th>
			</tr>
			<tr>
				<td class="head">Student Code</td>
				<td class="odd">$this->student_code</td>
				<td class="head">Student Name</td>
				<td class="odd"><A href="student.php?action=edit&student_id=$this->student_id" 
						target="_blank">$this->student_name</A></td>
			</tr>
		</tbody>
	</table>
EOF;

   }//showRegistrationHeader

   /**
   *
   * A search form for user to find a student
   * @access public
   */
  public function showSearchForm(){
   echo <<< EOF
	<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Product Collection - Search Student</span></big></big></big></div><br>-->
	<FORM action="regproduct.php" method="POST" name='frmSearchStudent'>
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criterial</th>
	    </tr>
	    <tr>
	      <td class='head'>Student Code</td>
	      <td class='even'><input name='student_code' value=''> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Student Name</td>
	      <td class='even'><input name='student_name' value=''>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quck Search</td>
	      <td class='odd'>$this->studentctrl</td>
	      <td class='head'	>IC Number</td>
	      <td class='odd'><input name='ic_no' value=''></td>
	    </tr>
	  </tbody>
	</table>
	<table style="width:150px;">
	  <tbody>
	    <tr>
	      <td><input style="height:40px;" type='submit' value='Search' name='submit'><input type='hidden' name='action' value='search'></td>
	      <td><input type='reset' value='Reset' name='reset'></td>
	    </tr>
	  </tbody>
	</table>
	</FORM>
EOF;
  }//showSearchForm

/**
   *Retrieve class registration info from database into class
   * @param int $studentclass_id 
   * 
   * @access public
   */
  public function fetchRegProductInfo($studentclass_id){
	$this->log->showLog(3,"Fetch Class Registration info for record: $studentclass_id.");
		
	$sql="SELECT studentclass_id, student_id,movement_id, isactive, amt,transactiondate,organization_id,createdby,created,updatedby, updated,description ".
		" FROM $this->tablestudentclass where studentclass_id=$studentclass_id";
	
	$this->log->showLog(4,"RegProduct->fetchRegProductInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->studentclass_id=$row['studentclass_id'];
		$this->student_id	=$row['student_id'];
		$this->movement_id=$row['movement_id'];
		$this->isactive=$row['isactive'];

		$this->amt=$row['amt'];		
		$this->transactiondate=$row['transactiondate'];
		$this->organization_id=$row['organization_id'];
		$this->description =$row['description'];
		$this->createdby=$row['createdby'];
		$this->created=$row['created'];
		$this->updatedby=$row['updatedby'];
		$this->updated=$row['updated'];

	$this->log->showLog(4,"RegProduct->fetchRegProductInfo, database fetch into class successfully, with studentclass_id=$this->studentclass_id");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"RegProduct->fetchRegProductInfo,failed to fetch data into databases.");	
	}
  }//fetchRegClassInfo

 /**
   *
   * @param int $student_id oor $class_id
   * @param string $type can be 'student' or 'class'
   * @param string $wherestring filter string
   * @param string $orderbystring used for sort record purpose
   * Display registered class in this student or class, depends on $type
   * @access public
   */
  public function showRegisteredTable($type,$wherestring,$orderbystring,$callfrom="regproduct"){
	
	//$wherestring="";
	$this->log->showLog(3,"Showing Product Table");
	$sql="";
	$operationctrl="";
	
	
	$title="";
	switch ($callfrom){
	case "regproduct":
			$title="Registered Product";
			$sql=$this->getSQLStr_RegisteredProduct($type,$wherestring,$orderbystring);
		
	break;
	case "payment":
			$title="Outstanding Payment";
			$sql=$this->getSQLStr_RegisteredProduct($type,$wherestring,$orderbystring);
		
	break;
	case "default":
			$title="Registered Course (Active Course)";
			$sql=$this->getSQLStr_RegisteredProduct($type,$wherestring,$orderbystring);
			
	break;
	}
	
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr><th style="text-align:center;" colspan="9">
				$title 
				<FORM name="filterProductDate" method="POST" action="regproduct.php">
					Date From : <input id='datefrom' name="datefrom">
						<input type="button" onclick="$this->showdatefrom" value="date">
					Date To : <input name="dateto" id='dateto'>
						<input type="button" onclick="$this->showdateto" value="date">
					<input type="hidden" name="action" value="filter">
					<input type="hidden" name="student_id" value="$this->student_id">
					<input type="submit" value="search" name="submit">
				</FORM></th></tr><tr>
				
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Product Code</th>
				<th style="text-align:center;">Product Name</th>
				<th style="text-align:center;">Unit Price ($this->cur_symbol)</th>
				<th style="text-align:center;">Qty</th>
				<th style="text-align:center;">Amount ($this->cur_symbol)</th>
				<th style="text-align:center;">Zoom</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
//	$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$studentclass_id=$row['studentclass_id'];
		$transactiondate=$row['transactiondate'];
		$product_name=$row['product_name'];
		$product_code=$row['product_no'];
		$qty=$row['qty']*-1;
		$amt=number_format($row['amt']*-1,2);
		$unitprice=$row['unitprice'];
//		$transportationmethod=$row['transportationmethod'];
		$employee_name=$row['employee_name'];
		$isactive=$row['isactive'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		switch ($callfrom){
		case "regproduct":
			$operationctrl="<form action='regproduct.php' method='POST'>".
					"<input type='image' src='images/edit.gif' name='submit' title='Edit this record'>".
					"<input type='hidden' value='$studentclass_id' name='studentclass_id'>".
					"<input type='hidden' name='action' value='edit'>".
					"</form>";
		break;
		case "payment":
			$operationctrl="<input type='checkbox'  value='$studentclass_id' name='classchecked[]' >" ;
		break;
		case "default":
			$operationctrl="<form action='regproduct.php' method='POST'><input type='submit' value='Edit' name='submit'>".
					"<input type='hidden' value='$studentclass_id' name='studentclass_id'>".
					"<input type='hidden' name='action' value='edit'>".
					"</form>";
		break;
		}


		echo <<< EOF

			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$transactiondate</td>
			<td class="$rowtype" style="text-align:center;">$product_code</td>
			<td class="$rowtype" style="text-align:center;">$product_name</td>
			<td class="$rowtype" style="text-align:center;">$unitprice</td>
			<td class="$rowtype" style="text-align:center;">$qty</td>
			<td class="$rowtype" style="text-align:center;">$amt</td>
			<td class="$rowtype" style="text-align:center;">$operationctrl</td>

		</tr>
EOF;
	}
	echo  "</tbody></table><br>";
  }

/**
   *
   * @param string $type can be 'student' or 'class'
   * @param string $wherestring filter string
   * @param string $orderbystring used for sort record purpose
   * return sql statement to caller
   * @access public
   */
  public function getSQLStr_RegisteredProduct($type,$wherestring,$orderbystring){
	$sql=""; 
	$this->log->showLog(3,"RegClass-getSQLStr_RegisteredProduct($type,$wherestring,$orderbystring");
	if($type=='student'){
		$sql="SELECT sc.studentclass_id, sc.movement_id,  sc.amt,sc.transactiondate, sc.organization_id, ".
			" p.product_no,p.product_name,p.amt as unitprice,-1*i.quantity as qty from sim_simtrain_studentclass sc ".
			" inner join sim_simtrain_inventorymovement i on sc.movement_id=i.movement_id ".
			" inner join sim_simtrain_productlist p on p.product_id=i.product_id ".
			" $wherestring $orderbystring ";
	$this->log->showLog(3,"Retrieve register product $wherestring");
	}
	elseif($type=='class'){
		$sql="SELECT sc.studentclass_id, t.student_id, t.student_code, t.student_name, t.gender, t.ic_no, t.tel_1,t.hp_no, sc.isactive, sc.comeactive, sc.backactive, sc.trainingfees, sc.paidamt, sc.transportfees, sc.comeareafrom_id,sc.ispaid, sc.transactiondate , sc.backareato_id, sc.organization_id FROM $this->tablestudent t inner join $this->tablestudentclass sc on sc.student_id=t.student_id $wherestring $orderbystring";
	$this->log->showLog(3,'Retrieve register student $wherestring');
	}
	$this->log->showLog(4,"return sql: $sql");
	return $sql;
  }//end showRegisteredClass

/**
   *
   * @param string $type can be 'edit' or 'new'
   * @param int $studentclass_id
   * @param string $token for security purpose
   * Display forms for user to create/edit existing student-class registration
   * @access public
   */
  public function showInputForm($type,$studentclass_id,$token){
	$mandatorysign="<b style='color:red'>*</b>";
	$this->log->showLog(3,"Accessing RegProduct->showInputForm($type,$studentclass_id,$token)");
	$checked="";
	$paidchecked="";
	$transportType="";
	$jumptotopayment="";
	$feesctrl="";
	$includeAllCtrl='<input type="checkbox" name="includeall" title="When you enable this option, once submit all items on the '.
			'right will be generated base on this transaction date and default price.">Include All';
	//$movementctrl="";
     if($type=="new"){
		$this->transactiondate=date("Y-m-d", time()) ;;
		$header="New Product Collection";
		$action="create";
		if($studentclass_id==0){
		$this->tuitionclass_id=0;
		}

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
//	$transportType=$this->transportType("BOTH");
		$freesctrl="<td class='head'></td><td class='even'></td>";
		
	//echo $movementctrl;
	}
     else{
		$action="update";
		$savectrl="<input name='studentclass_id' value='$this->studentclass_id' type='hidden'>".
			 "<input style='height:40px;' name='submit' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";
		if ($this->comeactive=='Y')
			$comechecked="CHECKED";
		else
			$comechecked="";
		if ($this->backactive=='Y')
			$backchecked="CHECKED";
		else
			$backchecked="";
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestudentclass' type='hidden'>".
		"<input name='id' value='$this->studentclass_id' type='hidden'>".
		"<input name='idname' value='studentclass_id' type='hidden'>".
		"<input name='title' value='Class Registration' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'  style='height: 40px;' >".
		"</form>";

		$header="Edit Product Collection Detail";
		if($this->allowDelete($this->studentclass_id))
		$deletectrl="<FORM action='regproduct.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this registration?"'.")'><input type='submit' value='Delete' name='submit' 
			 style='height: 40px;' >".
		"<input type='hidden' value='$this->studentclass_id' name='studentclass_id'>".
		"<input type='hidden' value='$this->student_id' name='student_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		//"<Form action='regproduct.php' method='POST'><input name='submit' value='New' type='submit'></form>";

		$addnewctrl="<form action='regproduct.php?action=choosed&student_id=$this->student_id' method='post'><input type='submit' value='New' name='new'></form>";
		$freesctrl="<td class='head'>Amount($this->cur_symbol) $mandatorysign</td><td class='even'><input name='amt' value='$this->amt'></td>";

		$jumptotopayment="<Form action='payment.php' method='POST'>".
				"<input name='submit' value='Go To Payment' style='height: 40px;' type='submit'>".
				"<input name='action' value='choosed' type='hidden'>".
				"<input name='student_id' value='$this->student_id' type='hidden'>".
				"</form>";
		$includeAllCtrl='';
//	$transportType=$this->transportType($this->transportationmethod);
//	$this->transportfees=$this->transportFees($this->transportationmethod,$this->orgctrl,$this->comeareafrom_id);
	}
	echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">$header</span></big></big></big></div><br>
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onSubmit="return validateRegProduct()" method="post"
 action="regproduct.php" name="frmRegProduct"><input name="reset" value="Reset" type="reset"></td></tbody></table>
	<table border='1' cellspacing='3'>
	<tbody>
	<tr><th colspan='4'>Registration Information<input type='hidden' name="student_id" value="$this->student_id"></th></tr>
	<tr>
	
	<td class="head">Product $includeAllCtrl</td>
	<td class="odd">$this->movementctrl <a onClick="zoomProduct()">zoom</a></td>
	<td class="head">Transaction Date (YYYY-MM-DD) $mandatorysign<input type='hidden' value='1' name='organization_id'></td>
	<td class="odd"><input name="transactiondate" id="transactiondate" value="$this->transactiondate">
		<input type='button' value='Date' onClick="$this->showcalendar"></td>
	
	</tr>
	<tr>
	<td class="head">Description</td>
	<td class="even" ><input name='description' value="$this->description"  maxlength='40' size='40'></td>$freesctrl
	</tr>
	</tbody>
	</table>
	<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td><td>$jumptotopayment</td><td>$recordctrl</td></tbody></table>

EOF;
  } //showInputForm

/**
   * display a selection box, if value assign it will autoselect the particular transport type
   * @param string transport method, can be come/back/both
   * return string selection box
   * @access public
   */
  public function transportType($transporttype){
	$selectedboth="";
	$selectedcome="";
	$selectedback="";

	switch ($transporttype){
		case "BOTH":
			$selectedboth="selected='selected'";	
		break;
		case "COME":
			$selectedcome="selected='selected'";
		break;
		case "BACK":
			$selectedback="selected='selected'";
		break;

	}
	$selectctrl="<SELECT name='transportationmethod'>".
			 "<OPTION value='BOTH' $selectedboth>BOTH</option>".
			 "<OPTION value='BACK' $selectedback>BACK</option>".
			 "<OPTION value='COME' $selectedcome>COME</option>".
			 "</SELECT>";
	
	return $selectctrl;
  }

/**
   * get default tuition fees from database
   * @param int tuitionclass
   * return decimal tuition price
   * @access public
   */
  public function defaultAmt($movement_id){
	$this->log->showLog(3,"Retrieve default product amt from movement_id: $mvoement_id");
	$sql="select -1*p.amt * i.quantity as amt from sim_simtrain_inventorymovement i inner join sim_simtrain_productlist p on i.product_id=p.product_id ".
		" where i.movement_id=$movement_id";
	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	if ($row=$this->xoopsDB->fetchArray($query)){
		$result=$row['amt'];
		$this->log->showLog(3,"return result: $result");
		return $result;
	}
	else{
		$this->log->showLog(2,"Can't find the default amt, return:0"); 
		return 0;
	}
  } // end defaultTrainingFees()



/**
   * Insert new registration info into database.
   * @param 
   * return bool true or false for successing create the record
   * @access public
   */
  public function insertRegProduct() {
	//	sleep (10);
     	$timestamp= date("y/m/d H:i:s", time()) ;
	//calculate transport price
	$this->log->showLog(4,"Creating record, with option includeall:$this->includeall");

	if($this->includeall=="on" || $this->includeall=='Y'){
		if($this->insertAllRegProduct())
			return true;
		else
			return false;
	}
	else{
	  $this->amt=$this->defaultAmt($this->movement_id);
	

	  $sql="INSERT INTO $this->tablestudentclass (student_id,movement_id,amt,transactiondate, isactive, ".
		" created,createdby,updated,updatedby,organization_id) values ".
		" ($this->student_id, $this->movement_id, $this->amt, '$this->transactiondate', 'N' ,'$timestamp', $this->createdby,".
		" '$timestamp',$this->updatedby,$this->organization_id)";
	
	  $this->log->showLog(4,"Before insert product SQL:$sql");
	  $rs=$this->xoopsDB->query($sql);

	  if (!$rs){
		$this->log->showLog(1,"Failed to save registration");
		return false;
	  }
	  else{
		$this->log->showLog(3,"Inserting new registration successfully"); 
		return true;
	  }
	}

  }//insertRegClass

  public function insertAllRegProduct() {
	//	sleep (10);
     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Start insert all regproduct in 1 times.");
	$sql="select i.movement_id, p.product_name,i.movementdate,i.quantity from sim_simtrain_inventorymovement i ".
		" inner join sim_simtrain_productlist p on p.product_id=i.product_id ".
		" where i.student_id=$this->student_id and ".
		" i.movement_id not in (select movement_id from sim_simtrain_studentclass where student_id=$this->student_id)".
		" and i.requirepayment='Y';";
	$this->log->showLog(4,"Select all items on the with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
	$movement_id=$row['movement_id'];
	$amt=$this->defaultAmt($movement_id);
	$this->log->showLog(3,"Start movement_id $movement_id with amt: $amt.");
	$sqlinsert="INSERT INTO $this->tablestudentclass (student_id,movement_id,amt,transactiondate, isactive, ".
		" created,createdby,updated,updatedby,organization_id) values ".
		" ($this->student_id, $movement_id, $amt, '$this->transactiondate', 'N' ,'$timestamp', $this->createdby,".
		" '$timestamp',$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"With SQL: $sqlinsert");
//	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sqlinsert);
	if($rs)
		$this->log->showLog(3,"This data generated successfully(movement_id:$movement_id)");
	else
		$this->log->showLog(1,"<b style='color:red;'>Error! Can't generate this data into database(movement_id: $movement_id).</b>");
	}
	return true;
  }//insertAllRegProduct

/**
   * Get latest studentclass_id
   * @param 
   * return int student_id
   * @access public
   */
  public function getLatestStudentProductID(){
	$sql="SELECT MAX(studentclass_id) as studentclass_id from $this->tablestudentclass;";
	$this->log->showLog(4,"Get latest studentclass_id with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['studentclass_id'];
	else
	return -1;
  }//getLatestStudentClassID



 /**
   * Update student class registration information
   *
   * @return bool
   * @access public
   */
  public function updateStudentClass( ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestudentclass SET ".
		"amt=$this->amt,".
		"movement_id=$this->movement_id,".
		"transactiondate	='$this->transactiondate',".
		"organization_id=$this->organization_id,".
		"updatedby='$this->updatedby',".
		"updated	='$timestamp', ".
		"description ='$this->description'".
		"WHERE studentclass_id=$this->studentclass_id";
	
	$this->log->showLog(3, "Update studentclass_id: $this->studentclass_id");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update studentclass failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update studentclass successfully.");
		return true;
	}
  } // end of member function updateStudentClass

 /**
   * Delte student class registration information
   * @param int $studentclass_id 
   * @return bool
   * @access public
   */
   public function deleteStudentClass($studentclass_id){
	$this->log->showLog(2,"Warning: Performing delete StudentClass id : $studentclass_id !");
	$sql="DELETE FROM $this->tablestudentclass where studentclass_id=$studentclass_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: StudentClass ($studentclass_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"StudentClass ($studentclass_id) removed from database successfully!");
		return true;
		
	}
   }

  public function getUnpaidProduct($id,$student_id){
	$this->log->showLog(3,"Retrieve unpaid product list");
	$sql="";
	if($id==0)
	$sql="select i.movement_id, p.product_name,i.movementdate,i.quantity from sim_simtrain_inventorymovement i ".
		" inner join sim_simtrain_productlist p on p.product_id=i.product_id ".
		" where i.student_id=$student_id and ".
		" i.movement_id not in (select movement_id from sim_simtrain_studentclass where student_id=$student_id)".
		" and i.requirepayment='Y';";	
	else
	$sql="select i.movement_id, p.product_name,i.movementdate,i.quantity from sim_simtrain_inventorymovement i ".
		" inner join sim_simtrain_productlist p on p.product_id=i.product_id ".
		" where ((i.student_id=$student_id and ".
		" i.movement_id not in (select movement_id from sim_simtrain_studentclass where student_id=$student_id)) OR (i.movement_id=$id))".
		" and i.requirepayment='Y';";

	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	$movementctrl="<SELECT name='movement_id'>";
	
	//echo $selectctl;
	$i=0;
	$movement_id=0;
	$product_name="";
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
		$movement_id=$row['movement_id'];
		$product_name=$row['product_name'];
		$quantity=$row['quantity'];
		$movementdate=$row['movementdate'];
	
		if($id==$movement_id)
			$selected="SELECTED='SELECTED'";
		else
			$selected="";
		
		$movementctrl=$movementctrl  . "<OPTION value=$movement_id $selected>$product_name x $quantity ($movementdate)</OPTION>";
//		$movementctrl=$movementctrl  . "<OPTION value='$i' $i/OPTION";
//		echo $selectctl;
	}
	$movementctrl=$movementctrl."</SELECT>";
	$this->log->showLog(4,"Return qty: $i items in movement list.");
	//echo $selectctl;
	return $movementctrl;

	
  }


public function allowDelete($studentclass_id){
	$this->log->showLog(3,"Verified whether studentclass_id: $studentclass_id is deletable");
	$sql="SELECT count(studentclass_id) as countid from $this->tablepaymentline where studentclass_id=$studentclass_id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$recordcount=0;
	if($row=$this->xoopsDB->fetchArray($query))
		$recordcount=$row['countid'];
	
	if($recordcount=="" || $recordcount==0){
		return true;
		$this->log->showLog(4,"Record deletable, count: $recordcount");
	
	}
	else{
		$this->log->showLog(4,"Record not deletable, count: $recordcount");
		return false;
	}
  }
}
?>