<?php


/**
 * class Payment
 * Keep payment information, if product = book, it will minus out the stock of the
 * books.
 */
class Payment
{


  public $payment_id;
  public $payment_datetime;
  public $receivedamt = 0;
  public $amt = 0;
  public $returnamt=0;
  public $outstandingamt = 0;
  public $payment_description;
  public $organization_id;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $iscomplete;
  public $receipt_no;
  public $student_id;
  public $student_name;
  public $ic_no;
  public $student_code;
  public $isAdmin="false";
  public $datefrom;
  public $cur_name;
  public $cur_symbol;
  public $dateto;
  public $showDateFrom;
  public $showDateTo;
  public $deleteAttachment;
  public $classchecked;
  public $totalamt=0;
  public $totaltransportfees=0;
  public $totalpaid=0;
  public $totalbalance=0;
  private $tableprefix;
  private $tablepayment;
  private $tablepaymentline;
  private $tablestudent;
  private $tableusers;
  private $log;
  private $xoopsDB;


/**
   *
   * @param xoopsDB $xoopsDB
   * @param string $tableprefix
   * @param log $log
   * Constructor for class Payment
   * @access public
   */
  public function Payment ($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
	$this->tableprefix=$tableprefix;
	$this->tablepayment=$tableprefix."simtrain_payment";
	$this->tablepaymentline=$tableprefix."simtrain_paymentline";
	$this->tablestudent=$tableprefix."simtrain_student";
	$this->tableusers=$tableprefix."users";
  } //end RegClass
  /**
   * return a SQL string for generate payment table
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllPayment( $wherestring,  $orderbystring,  $startlimitno ) {
	$this->log->showLog(3, "Payment->getSQLStr_AllPayment: with wherestring=$wherestring, $orderbystring=$orderbystring");
	$sql="SELECT p.payment_id, p.receipt_no, p.payment_datetime, p.amt,p.iscomplete,t.student_id, t.student_name,u.uname from $this->tablepayment p ".
		"INNER JOIN $this->tablestudent t on t.student_id=p.student_id inner join $this->tableusers u on p.updatedby=u.uid $wherestring $orderbystring LIMIT $startlimitno,100";
	$this->log->showLog(4, "Return SQL:$sql");
	return $sql;
	
  } // end of member function getSQLStr_AllPayment


  public function openForm($type,$token){
	$header="";
	
	if($type=="new"){
		
		$header="Create Official Receipt";
 		$addnewctrl="";
				
 	 }
	else{
		
		$action="update";
		$header="Edit Official Receipt";
		$addnewctrl="<form name='frmAddNew' onSubmit='confirm(" . '"Confirm? All unsave data will lost."'. ")' action='payment.php?action=choosed&student_id=$this->student_id' method='post'><input type='submit' value='New' value='New'></form>";
		

	}
	echo <<< EOF
		<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">$header</span></big></big></big></div><br>
		<table style="width:140px;"><tbody><td>$addnewctrl</td><td>
		<form method="post" action="payment.php" name="frmpayment" onSubmit="return validatePayment()"  
				 enctype="multipart/form-data">
		<input name="reset" value="Reset" type="reset">
		<input name="paymentline_id" type="hidden"></td></tbody></table>
EOF;

  }//end of openForm

   /**
   * Display a table of payment
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return 
   * @access public
   */
  public function showPaymentTable( $wherestring,  $orderbystring,  $startlimitno) {
	$this->log->showLog(3, "Payment->showPaymentTable: with wherestring=$wherestring, $orderbystring=$orderbystring");
	$sql=$this->getSQLStr_AllPayment( $wherestring,  $orderbystring,  $startlimitno);
	
	$query=$this->xoopsDB->query($sql);
	//<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Payment Summary</span></big></big></big></div><br>
	echo <<< EOF
	
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  		<tbody>
    			<tr>
				<th colspan="9">
					Payment List (1st 100 Payment Only)
					
				</th>
			</tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Receipt No</th>
				<th style="text-align:center;">Date/Time</th>
				<th style="text-align:center;">Student</th>
				<th style="text-align:center;">User</th>
				<th style="text-align:center;">Completed</th>
				<th style="text-align:center;">Amount ($this->cur_symbol)</th>
				<th style="text-align:center;">View/Edit</th>
				<th style="text-align:center;">Activate</th>
   	</tr>
EOF;
	$activatectrl="";
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$receipt_no=$row['receipt_no'];
		$payment_datetime=$row['payment_datetime'];
		$amt=$row['amt'];
		$uname=$row['uname'];
		$iscomplete=$row['iscomplete'];
		$student_id=$row['student_id'];
		$student_name=$row['student_name'];
		$payment_id=$row['payment_id'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		if($iscomplete=='N'){
			$actionperform="<form action='payment.php' method='POST'>".
				"<input type='image' src='images/edit.gif' name='submit' title='Edit this payment'>".
					"<input type='hidden' value='$payment_id' name='payment_id'>".
					"<input type='hidden' name='action' value='edit'></form>";
			$activatectrl="";
			}
		else
			{
			$actionperform="<form action='printreceipt.php' method='POST' target='_blank'>".
				"<input type='image' src='images/list.gif' name='submit' title='Payment completed, you only can view this receipt'>".
					"<input type='hidden' value='$payment_id' name='payment_id'><input type='hidden' value='$student_id' name='student_id'>".
					"<input type='hidden' name='action' value='pdf'></form>";
			 if($this->isAdmin == true)
				$activatectrl="<form action='payment.php' method='POST' onsubmit='return confirm(\"Reactivate this payment?\")'>".
							"<input type='submit' value='enable' name='submit' title='Reactivate this payment.'>".
							"<input type='hidden' value='$payment_id' name='payment_id'>".
							"<input type='hidden' name='action' value='enable'></form>";
				
			}
		
			
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$receipt_no</td>
			<td class="$rowtype" style="text-align:center;">$payment_datetime</td>
			<td class="$rowtype" style="text-align:center;">$student_name</td>
			<td class="$rowtype" style="text-align:center;">$uname</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">$amt</td>
			<td class="$rowtype" style="text-align:center;">$actionperform</td>
			<td class="$rowtype" style="text-align:center;">$activatectrl</td>
		</tr>
EOF;
 }
	
  } // end of member function showPaymentTable

  public function closeForm($type,$token,$showtotal='N'){
	$filectrl="";
	if($type=="new"){
		$action="create";
		$savectrl="<input style='height:40px;' name='submit' value='Next' type='submit'>";
		$deletectrl="";
	}
	else{
		
		if($this->isAdmin == true){
		$deletectrl="<FORM action='payment.php' method='POST' onSubmit='return confirm(".
		'"Confirm to remove this payment?"'.")'><input  style='height:40px;' type='submit' value='Delete' name='submit' tabindex='-1'>".
		"<input type='hidden' value='$this->payment_id' name='payment_id'>".
		"<input type='hidden' value='$this->student_id' name='student_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		}
		$action="update";
		$savectrl="<input name='payment_id' value='$this->payment_id' type='hidden'>".
			 "<input style='height:40px;' name='save' value='Calculate & Save' type='submit' onClick='calculateBalance()'></td><td>" .
			"<input style='height:40px;' name='submit' value='Complete' type='submit' tabindex='-1' >";
		$printctrl="";
		//<FORM action='printreceipt.php' method='POST' target='_blank'>".
		//"<input type='submit' value='Print' name='submit'  style='height:40px;' >".
		//"<input type='hidden' value='$this->payment_id' name='payment_id'>".
		//"<input type='hidden' value='$this->student_id' name='student_id'>".
		//"<input type='hidden' value='print' name='action'></form>";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablepayment' type='hidden'>".
		"<input name='id' value='$this->payment_id' type='hidden'>".
		"<input name='idname' value='payment_id' type='hidden'>".
		"<input name='title' value='Payment' type='hidden'>".
		"<input style='height:40px;' name='submit' value='View Record Info' type='submit'>".
		"</form>";

		$filename="upload/receipt/".$this->payment_id.".pdf";
		
		if(file_exists($filename))
			$fileurl="<a href='$filename' target='_blank'>Download</a>";
		else
			$fileurl="<b style='color:red;'>No Attachment</b>";

		$filectrl="<tr><td class='head'></td><td  class='head'></td>".
				"<td  class='head'>Attachment : $fileurl </td>".
				"<td  class='head' colspan='7'>Remove File <input type='checkbox' name='deleteAttachment'>".
				"<input type='file' name='upload_file' size='60'> </td></tr></tbody></table>";
	
	}
	

	if ($showtotal=='Y'){
	$inputtype=array(
		"<input name='amt' value='$this->amt' size='8' maxlength='10' style='text-align: right;background-color:#c1c1c1;' readonly='readonly'  tabindex='-1'>",
		"<input name='receivedamt' value='$this->receivedamt' size='8' maxlength='10' style='text-align: right;'".
				" onchange='calculateBalance()'>", 
		"<input name='returnamt' value='$this->returnamt' size='8' maxlength='10' style='text-align: right;background-color:#c1c1c1;' readonly='readonly'  tabindex='-1'>","<input value='$this->outstandingamt' name='totaloutstanding'".
		"size='8' maxlength='10' style='text-align: right;background-color:#c1c1c1;' readonly='readonly'  tabindex='-1'>");
		//"<input name='outstandingamt' value='$this->outstandingamt' size='8' maxlength='10' style='text-align: right;background-color:#c1c1c1;'readonly='readonly'>
	$inputname=array("Total Charges","Cash<input type='button' onClick='fullPay()' value='+'>","Change","Outstanding Amount");
		

		$rowtype="";
		for($i=0;$i<4;$i++){
			if($rowtype=="odd")
				$rowtype="even";
			else
				$rowtype="odd";
			$name=$inputname[$i];
			$ctrl=$inputtype[$i];
			echo <<< EOF
			<tr><td class="$rowtype" style="text-align:center;"></td>
			<td class="$rowtype" style="text-align:center;"></td>
			<td class="$rowtype" style="text-align:center;"></td>
			<td class="$rowtype" style="text-align:center;"></td>
			<td class="$rowtype" style="text-align:center;"> </td>
			<td class="$rowtype" style="text-align:center;"></td>
			<td class="$rowtype" style="text-align:center;"> </td>
			<td class="$rowtype" style="text-align:center;"></td>
			<td class="$rowtype" style="text-align:left;">$name	</td>
			<td class="$rowtype" style="text-align:right;">$ctrl</td>
</tr>
EOF;
		}
	}
			if($rowtype=="odd")
				$rowtype="even";
			else
				$rowtype="odd";



	echo <<< EOF
	$filectrl

	<table style="width:150px;"><tbody>
		<tr>
			
			<td>$savectrl </td>
			<td><input name="action" value="$action" type="hidden"></td>
			<td><input name="token" value="$token" type="hidden"></td>
			</form><td>$deletectrl </td>
			<td>$printctrl</td>
			<td>$recordctrl</td>
			</tr></tbody></table>
EOF;
  }

  /**
   *
   * @param string type either 'new' or 'edit'
   * @param int payment_id 
   * @return bool
   * @access public
   */
  public function showInputForm( $type,  $payment_id,$token ) {
	global $defaultorganization_id;
	$mandatorysign="<b style='color:red'>*</b>";
	$header="";
	$timestamp= "";
	$action="";
 	if($type=="new"){
		
		$this->receivedamt = 0;
		$this->amt = 0;
		$this->returnamt=0;
		$this->outstandingamt=0;
		$this->payment_description;
		$this->payment_datetime=date("Y-m-d H:i:s", time()) ;
		$this->receipt_no=$this->getNextReceiptNo();
		
		if($this->organization_id=="")
		$this->organization_id = $defaultorganization_id;
		else
		$this->organization_id=0;
		
 	 }
	
	echo <<< EOF
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  	<tbody>
	<tr><th style="text-align: center;" colspan="4">Payment Header</th></tr>
  	  <tr>
  	    <td class="head">Place Of Payment <input type="hidden" name="student_id" value="$this->student_id"></td>
  	    <td class="odd">$this->orgctrl</td>
  	    <td class="head">Payment Date/Time $mandatorysign</td>
  	    <td class="odd"><input name="payment_datetime" value="$this->payment_datetime"></td>
  	  </tr>
  	  <tr>
  	    <td class="head">Receipt No $mandatorysign</td>
  	    <td class="even"><input name="receipt_no" value="$this->receipt_no"></td>
  	    <td class="head">Description</td>
  	    <td  class="even"><input name="payment_description" size="60"
		 maxlength="60" value="$this->payment_description"></td>
  	  </tr >
  	</tbody>
      </table><br>
	
	
EOF;
  } // end of member function getInputForm

  /**
   *
   * @param int payment_id 
   * @return bool
   * @access public
   */
  public function fetchPaymentInfo( $payment_id ) {
	$this->log->showLog(3,"Retrieve data related to payment id: $payment_id from database");
		
	$sql="SELECT payment_id,payment_datetime,receipt_no,receivedamt,payment_description,organization_id".
		",iscomplete,amt,returnamt,student_id,outstandingamt FROM $this->tablepayment where payment_id=$payment_id";
	
	$this->log->showLog(4,"Payment->fetchPaymentInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->payment_id=$row["payment_id"];
		$this->payment_datetime=$row["payment_datetime"];
		$this->receipt_no=$row["receipt_no"];
		$this->receivedamt =$row["receivedamt"];
		$this->payment_description=$row["payment_description"];
		$this->organization_id=$row["organization_id"];
		$this->iscomplete=$row["iscomplete"];
		$this->amt=$row["amt"];
		$this->outstandingamt=$row["outstandingamt"];
		$this->returnamt=$row["returnamt"];
		$this->student_id=$row["student_id"];
	$this->log->showLog(4,"Payment->fetchPaymentInfo,database fetch into class successfully, payment_id=$this->payment_id");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Payment->fetchPaymentInfo,failed to fetch data into databases.");	
	}

  } // end of member function fetchPaymentInfo

  /**
   *
   * @param int payment_id 
   * @return bool
   * @access public
   */
  public function deletePayment( $payment_id ) {
	$this->log->showLog(2,"Warning, delete payment with id:$payment_id, all child record in paymenline will remove as well");
	$sqlpayment="DELETE FROM $this->tablepayment where payment_id=$payment_id";
	$sqlpaymentline="DELETE FROM $this->tablepaymentline where payment_id=$payment_id";
	$this->log->showLog(4,"Executing SQL:$sqlpayment");
	$rs1=$this->xoopsDB->query($sqlpayment);
	if(!$rs1)
		$this->log->showLog(1,"Error: Cannot remove payment id: $payment_id");
	else
		$this->log->showLog(2,"payment id: $payment_id removed successfully");
	$rs2=$this->xoopsDB->query($sqlpaymentline);
	if(!$rs2)
		$this->log->showLog(1,"Error: Cannot remove payment id: $payment_id");
	else
		$this->log->showLog(2,"payment id: $payment_id removed successfully");
	if ($rs1 && $rs2)
		return true;
	else
		return false;

  } // end of member function deletepayment

  /**
   *
   * @return bool
   * @access public
   */
  public function updatePayment( $nextaction) {
	$completectrl="";
	if($nextaction=="Complete")
	{
	$completectrl=',iscomplete="Y"';
	}
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Updating payment info: with payment_id=$this->payment_id,outstandingamt=$this->outstandingamt");
	$sql="UPDATE $this->tablepayment SET ".
		"payment_datetime='$timestamp',".
		"receipt_no=$this->receipt_no,".
		"receivedamt=$this->receivedamt,".
		"payment_description='$this->payment_description',".
		"organization_id=$this->organization_id,".
		"updated='$timestamp',".
		"updatedby=$this->updatedby,".
		"amt=$this->amt,outstandingamt=$this->outstandingamt,".
		"returnamt=$this->receivedamt - $this->amt $completectrl".
		" WHERE payment_id=$this->payment_id";
	$this->log->showLog(4,"Before running SQL:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update payment failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update payment successfully.");
		return true;
	}

	
  } // end of member function updatePayment

  /**
   *
   * @return bool
   * @access public
   */
  public function completepayment( ) {
    
  } // end of member function completepayment

  /**
   *
   * A search form for user to find a student
   * @access public
   */
  public function showSearchForm(){
   echo <<< EOF
	<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Create Payment Record - Search Student</span></big></big></big></div><br>-->
	<FORM action="payment.php" method="POST" name='frmSearchStudent'>
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
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->studentctrl</td>
	      <td class='head'	>IC Number</td>
	      <td class='odd'><input name='ic_no' value=''></td>
	    </tr>
	  </tbody>
	</table>
	<table style="width:150px;">
	  <tbody>
	    <tr>
	      <td><input style="height: 40px;" type='submit' value='Search' name='submit'><input type='hidden' name='action' value='search'></td>
	      <td><input type='reset' value='Reset' name='reset'></td>
	    </tr>
	  </tbody>
	</table>
	</FORM>
EOF;
  }//showSearchForm

 /**
   *
   * @param int $student_id
   * A simple header to tell end user what is current student
   * @access public
   */
   public function showPaymentHeader(){

	echo <<< EOF
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
		<tbody>
			<tr>
				<th style="text-align: center;" colspan="4">Student Info</th>
			</tr>
			<tr>
				<td class="head">Student Code</td>
				<td class="odd">$this->student_code</td>
				<td class="head">Student Name</td>
				<td class="odd"><a href="student.php?action=edit&student_id=$this->student_id">$this->student_name</a></td>
			</tr>
		</tbody>
	</table><br>
EOF;

   }//showPaymentHeader

 /**
   * Display total payment under a student
   * @param
   * 
   * @access public
   */
 public function showOutstandingClass($student_id){
	$timestamp= date("Y/m/d", time()) ;
	$tabletuitionclass = $this->tableprefix . "simtrain_tuitionclass";
	$tablepayment= $this->tableprefix . "simtrain_payment";
	$tablepaymentline= $this->tableprefix . "simtrain_paymentline";
	$tableproductlist= $this->tableprefix . "simtrain_productlist";
	$tableperiod= $this->tableprefix . "simtrain_period";
	$tablestudentclass=$this->tableprefix . "simtrain_studentclass";


	/* original sql script
	SELECT sc.studentclass_id, tc.tuitionclass_code, pd.product_name, sc.trainingfees,pr.period_name, sc.transportfees,coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline spl inner join sim_simtrain_payment sp on spl.payment_id=sp.payment_id where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as paid, sc.trainingfees+sc.transportfees- coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline spl inner join sim_simtrain_payment sp on spl.payment_id=sp.payment_id where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as balance FROM sim_simtrain_studentclass sc inner join sim_simtrain_tuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id inner join sim_simtrain_productlist pd on tc.product_id=pd.product_id inner join sim_simtrain_period pr on pr.period_id=tc.period_id
 
	where sc.student_id=$student_id 

	group by sc.studentclass_id, tc.tuitionclass_code, pd.product_name, sc.trainingfees,sc.transportfees,pr.period_name order by pr.period_name,tc.tuitionclass_code
	*/

	$sql="SELECT sc.studentclass_id, tc.tuitionclass_code, tc.description, sc.amt,pr.period_name,".
		" sc.transportfees,coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline spl ".
					" inner join sim_simtrain_payment sp on spl.payment_id=sp.payment_id".
					" where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as paid,".
		" sc.amt+sc.transportfees- coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline spl " .
		" inner join sim_simtrain_payment sp on spl.payment_id=sp.payment_id ".
		" where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as balance ".
		" FROM $tablestudentclass sc ".
		" inner join $tabletuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id ".
		" inner join $tableproductlist pd on tc.product_id=pd.product_id ".
		" inner join  $tableperiod pr on pr.period_id=tc.period_id ".
		" where sc.student_id=$student_id and sc.transactiondate <= '$timestamp' AND tc.product_id>0".
		" group by  sc.studentclass_id, tc.tuitionclass_code, tc.description, sc.amt,sc.transportfees,pr.period_name ".
		" HAVING (sc.amt+sc.transportfees- coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline	 spl " .
		" inner join sim_simtrain_payment sp on spl.payment_id=sp.payment_id ".
		" where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0)) <>0 ".
		" order by pr.period_name,tc.tuitionclass_code";
	
	$this->log->showLog(3,"Showing Outstanding Payment Table");
	$this->log->showLog(4,"With SQL:$sql");
	
	$title="Outstanding Class";
	$operationctrl="<input type='checkbox'  name='classchecked[]' checked>";
	
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr><th class="$rowtype" colspan="10" style="text-align:center;">Outstanding Payment</th></tr><tr>
				<th style="text-align:center;">Type</th>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Code</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Fees ($this->cur_symbol)</th>
				<th style="text-align:center;">Transport ($this->cur_symbol)</th>
				<th style="text-align:center;">Paid ($this->cur_symbol)</th>
				<th style="text-align:center;">Balance ($this->cur_symbol)</th>
				<th style="text-align:center;">Action</th>

   	</tr>
EOF;
	
$rowtype="";
	$i=0;
	//$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
//	$totaltrainingfees=0;
//	$totaltransportfees=0;
//	$totalpaid=0;
//	$totalbalance=0;

	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$studentclass_id=$row['studentclass_id'];
		$tuitionclass_code=$row['tuitionclass_code'];
		$description=$row['description'];
		$period_name=$row['period_name'];
		$amt=$row['amt'];
		$transportfees=$row['transportfees'];
		$paid=$row['paid'];
		$balance=$row['balance'];
		
		$this->totalamt=$this->totalamt + $amt;
		$this->totaltransportfees=$this->totaltransportfees + $transportfees;
		$this->totalpaid=$this->totalpaid + $paid;
		$this->totalbalance=$this->totalbalance + $balance;
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		echo <<< EOF

		<tr>
				<td class="$rowtype" style="text-align:center;">Class</td>
				<td class="$rowtype" style="text-align:center;">$i</td>
				<td class="$rowtype" style="text-align:center;">$period_name</td>
				<td class="$rowtype" style="text-align:center;">$tuitionclass_code</td>
				<td class="$rowtype" style="text-align:left;">$description</td>

				<td class="$rowtype" style="text-align:right;">$amt</td>
				<td class="$rowtype" style="text-align:right;">$transportfees</td>
				<td class="$rowtype" style="text-align:right;">$paid</td>
				<td class="$rowtype" style="text-align:right;">$balance <input value="$studentclass_id" type="hidden" name="classchecked[]">
				<input value="C" type="hidden" name="linetype[]"></td>
				<td class="$rowtype" style="text-align:center;">
				<input type="button" name="viewclass" value="zoom" 
					onClick="window.open('regclass.php?action=edit&studentclass_id=$studentclass_id')">
				</td>


		</tr>
EOF;
	}

	/*	$totaltrainingfees=number_format($this->totalamt,2);
		$totaltransportfees=number_format($this->totaltransportfees,2);
		$totalpaid=number_format($this->totalpaid,2);
		$totalbalance=number_format($this->totalbalance,2);

	echo <<< EOF
		<tr>
				<th style="text-align:center;"></th>
				<th style="text-align:center;"></th>
				<th style="text-align:center;"></th>
				<th style="text-align:center;"></th>
				<th style="text-align:center;"></th>
				<th style="text-align:right;">$totaltrainingfees</th>
				<th style="text-align:right;">$totaltransportfees</th>
				<th style="text-align:right;">$totalpaid</th>
				<th style="text-align:right;">$totalbalance</th>
				<th style="text-align:right;"></th>

		</tr>
	</tbody></table>
EOF;*/

  }//showOutstandingClass

public function showOutstandingProduct($student_id){
	$tabletuitionclass = $this->tableprefix . "simtrain_tuitionclass";
	$tablepayment= $this->tableprefix . "simtrain_payment";
	$tablepaymentline= $this->tableprefix . "simtrain_paymentline";
	$tableproductlist= $this->tableprefix . "simtrain_productlist";
	$tableperiod= $this->tableprefix . "simtrain_period";
	$tablestudentclass=$this->tableprefix . "simtrain_studentclass";

/*	$sql="SELECT sc.studentclass_id, pd.product_no, pd.product_name, sc.transactiondate,i.quantity,pd.amt as unitprice, sc.amt as amt,".
	" coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline spl ".
	" inner join sim_simtrain_payment sp on spl.payment_id=sp.payment_id ".
	" where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as paid, ".
	" sc.amt - coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline spl inner join sim_simtrain_payment sp on ".
	" spl.payment_id=sp.payment_id where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as balance ".
	" FROM sim_simtrain_studentclass sc ".
	" inner join sim_simtrain_inventorymovement i on i.movement_id=sc.movement_id ".
	" inner join sim_simtrain_productlist pd on i.product_id=pd.product_id ".
	" where sc.student_id=$student_id and ";
*/
	$sql="SELECT sc.studentclass_id, pd.product_no, pd.product_name, sc.transactiondate,i.quantity,pd.amt as unitprice, sc.amt as amt,".
	" coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline spl ".
	" inner join sim_simtrain_payment sp on spl.payment_id=sp.payment_id ".
	" where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as paid, ".
	" sc.amt - coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline spl inner join sim_simtrain_payment sp on ".
	" spl.payment_id=sp.payment_id where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as balance ".
	" FROM sim_simtrain_studentclass sc ".
	" inner join sim_simtrain_inventorymovement i on i.movement_id=sc.movement_id ".
	" inner join sim_simtrain_productlist pd on i.product_id=pd.product_id ".
	" where sc.student_id=$student_id and i.product_id>0 and ".
	" sc.amt - coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline spl inner join sim_simtrain_payment sp on ".
	" spl.payment_id=sp.payment_id where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) <>0 ";

	
	$this->log->showLog(3,"Showing Outstanding Payment Table");
	$this->log->showLog(4,"With SQL:$sql");
	
	$title="Outstanding Product";
	$operationctrl="<input type='checkbox'  name='classchecked[]' checked>";
/*	
	echo <<< EOF

    			<tr>
				<th style="text-align:center;">Prd</th>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Prd. No</th>
				<th style="text-align:center;">Name</th>
				<th style="text-align:center;">Amt(RM)</th>
				<th style="text-align:center;">Transport (RM)</th>
				<th style="text-align:center;">Paid (RM)</th>
				<th style="text-align:center;">Balance (RM)</th>
				<th style="text-align:center;">Action</th>

   	</tr>
EOF;
*/	
$rowtype="";
	$i=0;
	//$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
	$totalamt=0;
	$totalpaid=0;
	$totalbalance=0;

	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$studentclass_id=$row['studentclass_id'];
		$product_no=$row['product_no'];
		$product_name=$row['product_name'];
		$transactiondate=$row['transactiondate'];
		$quantity=$row['quantity'];
		$unitprice=$row['unitprice'];
		$amt=$row['amt'];
		$paid=$row['paid'];
		$balance=$row['balance'];
		
		$this->totalamt=$this->totalamt + $amt;
		$this->totalpaid=$this->totalpaid + $paid;
		$this->totalbalance=$this->totalbalance + $balance;

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		echo <<< EOF

		<tr>
				<td class="$rowtype" style="text-align:center;">Product</td>
				<td class="$rowtype" style="text-align:center;">$i</td>
				<td class="$rowtype" style="text-align:center;">$transactiondate</td>
				<td class="$rowtype" style="text-align:center;">$product_no</td>
				<td class="$rowtype" style="text-align:left;">$product_name x $quantity</td>

				<td class="$rowtype" style="text-align:right;">$amt</td>
				<td class="$rowtype" style="text-align:right;">0.00</td>
				<td class="$rowtype" style="text-align:right;">$paid</td>
				<td class="$rowtype" style="text-align:right;">$balance 
					<input value="$studentclass_id" type="hidden" name="classchecked[]">
					<input value="P" type="hidden" name="linetype[]"></td>
				<td class="$rowtype" style="text-align:center;">
				<input type="button" name="viewclass" value="zoom" 
					onClick="window.open('regproduct.php?action=edit&studentclass_id=$studentclass_id')">
				</td>


		</tr>
EOF;
	}
		$totalamt=number_format($this->totalamt,2);
		$totalpaid=number_format($this->totalpaid,2);
		$totalbalance=number_format($this->totalbalance,2);
		$totaltransportfees=number_format($this->totaltransportfees,2);

	echo <<< EOF

		<tr>
				<th style="text-align:center;"></th>
				<th style="text-align:center;"></th>
				<th style="text-align:center;"></th>
				<th style="text-align:center;"></th>
				<th style="text-align:center;"></th>

				<th style="text-align:right;">$totalamt</th>
				<th style="text-align:right;">$totaltransportfees</th>
				<th style="text-align:right;">$totalpaid</th>
				<th style="text-align:right;">$totalbalance</th>
				<th style="text-align:center;"></th>


		</tr>
	</tbody></table>
EOF;

  }

/*
  public function getSQLStr_AllPayment($type,$wherestring,$orderbystring){
	$sql="SQL";
	
	$this->log->showLog(3,"returning getSQLStr_AllPayment:$sql");
	return $sql;

  }
*/

  /**
   * Retrieve next payment no
   * @param
   * 
   * @access public
   */
   public function getNextReceiptNo(){
	$this->log->showLog(3,"Retrieving next receipt no from database");
	$sql="SELECT max(receipt_no) as receipt_no from $this->tablepayment";
	$query=$this->xoopsDB->query($sql);
	$nextno=0;
	if ($row=$this->xoopsDB->fetchArray($query))
		$nextno=$row['receipt_no']+1;
	if ($nextno=="")
		$nextno="10001";

	$this->log->showLog(3,"Return next receipt_no: $nextno");
	
	return $nextno;
} //end getNextReceiptNo


  /**
   * Save new paymentline info into database (Payment line info) * At this momment it won't rollback data if something wrong, it keep return true
   * @param int  payment_id
   * return bool
   * @access public
   */
/*   public function insertPaymentLine($payment_id){
	$this->log->showLog(3,"Generate payment line for payment_id: $payment_id");
	$timestamp= date("y/m/d H:i:s", time()) ;
	foreach($this->classchecked as $studentclassid ){
	
		$this->log->showLog(3,"Selected class include: ".$studentclassid);
		$sqlinsertpaymentline="INSERT INTO $this->tablepaymentline (payment_id, product_id,studentclass_id,".
				" organization_id,created,createdby,updated,updatedby) VALUES(".
				"$payment_id,0,$studentclassid,$this->organization_id,'$timestamp',".
				"$this->createdby,'$timestamp',$this->updatedby)";
		$this->log->showLog(3,"Going to Execute SQL Command: $sqlinsertpaymentline");		
		$rs=$this->xoopsDB->query($sqlinsertpaymentline);
		if(!$rs)
			$this->log->showLog(1,"<b style='color: red'>Failed to link studentclass: $studentclass_id to payment_id: $payment_id");
		else
		 	$this->log->showLog(3,"Link studentclass: $studentclass_id to payment: $payment_id successfully");
				
		$i=$i+1;
		}
	return true;


   }*/

  /**
   * Save new payment info into database (Primary table only)
   * @param
   * 
   * @access public
   */
   public function insertPayment(){
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Saving new payment into database");
	$i=0;

	$sql="INSERT INTO $this->tablepayment (payment_datetime,receipt_no,payment_description,".
		"organization_id,created,createdby,updated,updatedby,iscomplete,student_id) VALUES (".
		"'$this->payment_datetime','$this->receipt_no','$this->payment_description',".
		"$this->organization_id,'$timestamp',$this->createdby,'$timestamp',$this->updatedby,".
		"'N',$this->student_id)";
	$this->log->showLog(4,"Before insert Payment SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	return true;
	if (!$rs){
		$this->log->showLog(1,"Failed to insert payment $receip_no");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new payment $receip_no successfully"); 
		return true;

	}//insertPayment
  }
    /**
   * Retrieve new generated payment_id
   * @param
   * 
   * @access public
   */
  public function getLatestPaymentID(){
	$sql="SELECT MAX(payment_id) as payment_id from $this->tablepayment;";
	$newno=0;
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		$newno= $row['payment_id'];
	else
	$newno= -1;
	
	$this->log->showLog(3,"Latest payment_id:$newno");
	return $newno;
  }//getLatestPaymentID

 /**
   * Get child under this payment
   * @param
   * 
   * @access public
   */
   public function showPaymentChild(){
	$this->log-showLog(3,"Showing child record under payment_id:$this->payment_id");
	$sql="SELECT ";


  }

  /**
   * Enable this payment
   * @param int $payment_id
   * 
   * @access public
   */
   public function enablePayment($payment_id){
	$this->log->showLog(2,"Re-enable this payment: $payment_id");
	$sql="update $this->tablepayment set iscomplete='N' where payment_id=$payment_id ";
	$this->log->showLog(4,"With SQL:$sql");
	$result=$this->xoopsDB->query($sql);
	if($result){
		$this->log->showLog(3,"Re-activate successfully");
		return true;
	}
	else{
		$this->log->showLog(1,"Re-failed");
		return false;
	}	


  }



  public function savefile($tmpfile){
	move_uploaded_file($tmpfile, "upload/receipt/$this->payment_id".".pdf");
  }

  public function deletefile(){
	$filename="upload/receipt/$this->payment_id".".pdf";
	unlink("$filename");
  }

  public function checkDraft($student_id){
	$this->log->showLog(2,"Check whether got existing incomplete payment for student_id: $student_id");
	$sql="SELECT payment_id from  $this->tablepayment WHERE iscomplete='N' and student_id=$student_id ";
	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		
		$this->log->showLog(3,"There is existing payment_id,:" . $row['payment_id']);
		return $row['payment_id'];
	}
	$this->log->showLog(3,"There is no existing incomplete payment, allow create new");
	return 0;
  }

public function isCompleted($payment_id){
	$this->log->showLog(3,"Verified whether payment: $payment_id is editable");
	$sql="SELECT iscomplete as iscomplete from $this->tablepayment where payment_id=$payment_id";
	$this->log->showLog(4,"With SQL: $sql");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$iscomplete=$row['iscomplete'];
		$this->log->showLog(3,"Return Result: $iscomplete");
		return  $iscomplete;
	}
	else{
		$this->log->showLog(2,"Can't get any information under this payment, return  total = $N");
		return 'Y';
	}
  }
} // end of Payment
?>