<?php

/**
 * class PaymentLine
 * Keep payment line information, in can contain payment for class, books, or enrollment fees
 * books.
 */
  
class PaymentLine
{

  public $paymentline_id;
  public $payment_id;
  public $studentclass_id;
  public $product_id;
  public $payment_description;
  public $organization_id;
  public $createdby;
  public $updatedby;
  public $classcheck; //aray of studentclass_id
  public $paymentlineamt; //aray of total amount in payment line
  public $linetrainingamt; //array of training amt
  public $linetransportamt;//array of transport amt
  public $arraypaymentline_id;
  public $outstandingamt=0;
  public $prdctrl;
  public $qty;
  public $linedescription;
  public $j;
  public $cur_name;
  public $cur_symbol;
  public $lineoutstanding;
  public $lineunitprice;
  public $classctrl;
  public $unitprice;
  private $tableprefix;
  private $log;

  private $xoopsDB;
  private $tablepaymentline;


  public function PaymentLine($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->log=$log;
	$this->tablepaymentline=$tableprefix . "simtrain_paymentline";
  }

/**
   * Save new paymentline info into database (Payment line info) * At this momment it won't rollback data if something wrong, it keep return true
   * @param int  payment_id
   * return bool
   * @access public
   */
   public function genInitPaymentLine($payment_id){
	$this->log->showLog(3,"Generate payment line for payment_id: $payment_id");
	$timestamp= date("y/m/d H:i:s", time()) ;
	foreach($this->classchecked as $studentclassid ){
	
		$this->log->showLog(3,"Selected class include: $studentclassid");
		$sqlinsertpaymentline="INSERT INTO $this->tablepaymentline (payment_id, product_id,studentclass_id,".
				" organization_id,created,createdby,updated,updatedby,qty) VALUES(".
				"$payment_id,0,$studentclassid,$this->organization_id,'$timestamp',".
				"$this->createdby,'$timestamp',$this->updatedby,1)";
		$this->log->showLog(3,"Going to Execute SQL Command: $sqlinsertpaymentline");
		$rs=$this->xoopsDB->query($sqlinsertpaymentline);
		if(!$rs)
			$this->log->showLog(1,"<b style='color: red'>Failed to link studentclass: $studentclass_id to payment_id: $payment_id");
		else
		 	$this->log->showLog(3,"Link studentclass: $studentclass_id to payment: $payment_id successfully");
	
		$i=$i+1;
		}
	return true;


   }

  
 /**
   * Retrieve all existing paymentline for product under payment_id, 
   * @param int  payment_id
   * @param char $isclass
   * return 
   * @access public
   */
  public function getProductPaymentLineTable($payment_id){
	$tabletuitionclass = $this->tableprefix . "simtrain_tuitionclass";
	$tablepayment= $this->tableprefix . "simtrain_payment";
	$tablepaymentline= $this->tableprefix . "simtrain_paymentline";
	$tableproductlist= $this->tableprefix . "simtrain_productlist";
	$tableperiod= $this->tableprefix . "simtrain_period";
	$tablestudentclass=$this->tableprefix . "simtrain_studentclass";

	$sql="SELECT pl.paymentline_id,pl.product_id,pd.product_no,pd.product_name,pl.qty,pl.unitprice, pl.qty*pl.unitprice as total, pl.amt, pl.linedescription ".
		" from $tablepaymentline pl inner join $tableproductlist pd on pd.product_id=pl.product_id".
		" where pl.payment_id=$payment_id and pl.product_id>0";

	$this->log->showLog(3,"Showing Outstanding Payment Table");
	$this->log->showLog(4,"With SQL:$sql");
	
	$title="Payment info(Charges)";
	$operationctrl="";
	echo <<< EOF
	
    			<tr><th style="text-align:center;" colspan="10">$title</th></tr><tr>
				
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Product Code</th>
				<th style="text-align:center;">Product Name</th>
				<th style="text-align:center;">Unit Price($this->cur_symbol)</th>
				<th style="text-align:center;">Qty</th>
				<th style="text-align:center;" colspan="3">Description</th>
				<th style="text-align:center;">Remove</th>
				<th style="text-align:center;">Pay($this->cur_symbol)</th>


   	</tr>
EOF;
	
$rowtype="";
	$i=0;
	//$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$paymentline_id=$row['paymentline_id'];
		$product_id=$row['product_id'];
		$product_no=$row['product_no'];
		$product_name=$row['product_name'];
		$qty=$row['qty'];
		$unitprice=$row['unitprice'];
		$lndescription=$row['linedescription'];
		$total=$row['total'];
		$amt=$row['amt'];
		//$balance=$row['balance'];
		//$paymentlineamt=$row['paymentlineamt'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$product_no</td>
			<td class="$rowtype" style="text-align:center;">$product_name</td>
			<td class="$rowtype" style="text-align:center;">
				<input value="$unitprice" name="lineunitprice[$this->j]" size="7" maxlength="8" 
					style='text-align: right;'  onChange='calculateProductAmt($this->j);'></td>
			<td class="$rowtype" style="text-align:center;">
					<input value="$qty" name="lineqty[$this->j]" size="3" maxlength="3" 
					style='text-align: right;' onChange='calculateProductAmt($this->j);'>
			</td>
			<td class="$rowtype" style="text-align:left;" colspan="3">
				<input name="linedescription[$this->j]" value="$lndescription" size="25" maxlength="25">
			</td>
			<td class="$rowtype" style="text-align:center;"><input type='button' value='Del' name="btnRemove[$this->j]" onClick="submitDelete($paymentline_id);"  tabindex="-1"></td>

			<td class="$rowtype" style="text-align:right;">
				<input value="$amt" name="paymentlineamt[$this->j]" size="7" maxlength="8" 
					style='text-align: right;background-color:#c1c1c1;' readonly='redonly'  tabindex="-1">
				<input value="$paymentline_id" name="arraypaymentline_id[$this->j]" type="hidden" >
			</td>


		</tr>
EOF;

	$this->log->showLog(4,"Table generate successfully");
	$this->j++;
	}	
	echo "<input name='rowcount' value='$this->j' type='hidden'>";

  }


  /**
   * Retrieve all existing paymentline for class under payment_id, 
   * @param int  payment_id
   * @param char $isclass
   * return 
   * @access public
   */
  public function getClassPaymentLineTable($payment_id){
	$tabletuitionclass = $this->tableprefix . "simtrain_tuitionclass";
	$tablepayment= $this->tableprefix . "simtrain_payment";
	$tablepaymentline= $this->tableprefix . "simtrain_paymentline";
	$tableproductlist= $this->tableprefix . "simtrain_productlist";
	$tableperiod= $this->tableprefix . "simtrain_period";
	$tablestudentclass=$this->tableprefix . "simtrain_studentclass";
//		" coalesce(tc.tuitionclass_code,pd.product_no) as code, ".
	
	$this->log->showLog(3,"Showing PaymentLine in Table");
	$sql="SELECT pl.paymentline_id, sc.studentclass_id, sc.movement_id,sc.tuitionclass_id,".
		" sc.transactiondate,".
		" (CASE WHEN tc.tuitionclass_id >0 THEN tc.tuitionclass_code ELSE pd.product_no END ) as code,".
		" (CASE WHEN tc.tuitionclass_id >0 THEN tc.description 
			ELSE concat(pd.product_name,'x',i.quantity) END ) as name,".
		" sc.amt,sc.transportfees, ".
		" sc.amt -coalesce((select sum(spl.trainingamt) as amt from sim_simtrain_paymentline spl  ".
		" inner join sim_simtrain_payment sp on spl.payment_id=sp.payment_id  ".
		" where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as balancefees, ".
		" sc.transportfees -coalesce((select sum(spl.transportamt) as amt from sim_simtrain_paymentline spl  ".
		" inner join sim_simtrain_payment sp on spl.payment_id=sp.payment_id  ".
		" where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as balancetransportfees, ".
		" sc.amt + sc.transportfees- coalesce((select sum(spl.amt) as amt from sim_simtrain_paymentline spl ".
		" inner join sim_simtrain_payment sp on spl.payment_id=sp.payment_id  ".
		" where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as balance, ".
		" pl.trainingamt,pl.transportamt,pl.amt as paymentlineamt ".
		" FROM sim_simtrain_paymentline pl  ".
		" inner join sim_simtrain_studentclass sc on pl.studentclass_id=sc.studentclass_id ".
		" left join sim_simtrain_tuitionclass tc on sc.tuitionclass_id=tc.tuitionclass_id ".
		" left join sim_simtrain_inventorymovement i on sc.movement_id=i.movement_id   ".
		" left join sim_simtrain_productlist pd on i.product_id=pd.product_id  ".
		" where pl.payment_id=$payment_id and pl.product_id=0".
		" order by sc.transactiondate,coalesce(tc.description,concat(pd.product_name,'x',i.quantity))";
	
	$this->log->showLog(4,"With SQL:$sql");
	
	$title="Payment info (Class and Products)";
	$operationctrl="";
	echo <<< EOF
	<table>
  		<tbody>
    			<tr><th style="text-align:center;" colspan="10">$title</th></tr><tr>
				
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Code</th>
				<th style="text-align:center;">Name</th>
				<th style="text-align:center;">Amt/Fees ($this->cur_symbol)</th>
				<th style="text-align:center;">Transport<br> Fees($this->cur_symbol)</th>
				<th style="text-align:center;">Balance<br> Fees ($this->cur_symbol)</th>
				<th style="text-align:center;">Balance<br> Transport ($this->cur_symbol)</th>
				<th style="text-align:center;">Total<br> Balance ($this->cur_symbol)</th>
				<th style="text-align:center;">Total<br> Pay ($this->cur_symbol)</th>
			

   	</tr>
EOF;
	//	<th style="text-align:center;">Removed</th>
$rowtype="";
	$i=0;
	$this->j=0;
	//$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
	$totalbalancetrainingfees=0;
	$totalbalancetransportfees=0;
	$totaloutstanding=0;
	$totalpaid=0;
	$totalbalance=0;

	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;

		$paymentline_id=$row['paymentline_id'];
		$studentclass_id=$row['studentclass_id'];
		$code=$row['code'];
		$name=$row['name'];
		$description=$row['description'];
		$transactiondate=$row['transactiondate'];
		$movement_id=$row['movement_id'];
		$amt=$row['amt'];
		$transportfees=$row['transportfees'];
		$balancefees=$row['balancefees'];
		$balancetransportfees=$row['balancetransportfees'];		
		$paymentlineamt=$row['paymentlineamt'];
		$balance=$row['balance'];
		$trainingamt=$row['trainingamt'];
		$transportamt=$row['transportamt'];
		$lineoutstanding=$balance-$trainingamt-$transportamt;
		$totalbalancetrainingfees=$totalbalancetrainingfees+$balancefees;
		$totalbalancetransportfees=$totalbalancetransportfees+$balancetransportfees;
		$totaloutstanding=$totaloutstanding+$balance;
		$totalpaid=$totalpaid+$paymentlineamt;
		$totalbalance=$balance+$totalbalance;
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		$transportfeesctrl="";
		$datatype="";
		if($movement_id>0){
			$transportfeesctrl="<input type='hidden' value='$balancetransportfees' name='balancetransportfees[$this->j]'>".
						" $balancetransportfees".
						"<input value='$transportamt' name='linetransportamt[$this->j]' size='7' style='text-align: right;'".
						" onChange='onChangeLine($this->j)' type='hidden'>";
			}
		else {
			$transportfeesctrl="<input type='button' name='sum[$this->j]' value='+'  onClick='transportClickPlus($this->j,$balancetransportfees)'>".
						"<input type='hidden' value='$balancetransportfees' name='balancetransportfees[$this->j]'>".
						" $balancetransportfees".
						"<input type='button' name='minus[$this->j]' value='-' onClick='transportClickMinus($this->j)'>".
						"<input value='$transportamt' name='linetransportamt[$this->j]' size='7' style='text-align: right;'".
						" onChange='onChangeLine($this->j)'>";
			}
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$transactiondate</td>
			<td class="$rowtype" style="text-align:center;">$code</td>
			<td class="$rowtype" style="text-align:center;">$name <input name="lineqty[$this->j]" type="hidden"></td>
			<td class="$rowtype" style="text-align:right;">$amt<input value="" name="lineunitprice[$this->j]" type='hidden'></td>
			<td class="$rowtype" style="text-align:right;">$transportfees </td>
			<td class="$rowtype" style="text-align:center;">
					<input type="button" name="sum[$this->j]" value="+" onClick="feesClickPlus($this->j,$balancefees)">
					<input type="hidden" value="$balancefees" name="balancefees[$this->j]">
						$balancefees
					<input type="button" name="minus[$this->j]" value="-" onClick="feesClickMinus($this->j)">
				
				<input value="$trainingamt" name="linetrainingamt[$this->j]"  size="7" style="text-align: right;"
								 onChange="onChangeLine($this->j)">
				
					<input name="linedescription[$this->j]" value="" type="hidden">
			</td>
			<td class="$rowtype" style="text-align:center;">
					$transportfeesctrl
			</td>
			<td class="$rowtype" style="text-align:right;"><input type='button' value='Del' name="btnRemove[$this->j]" onClick="submitDelete($paymentline_id);"  tabindex="-1"> $balance</td>
			<td class="$rowtype" style="text-align:right;">
				<input value="$paymentlineamt" name="paymentlineamt[$this->j]" size="7" readonly="readonly" style='background-color: #c1c1c1; text-align: right;'  tabindex="-1">
				<input value="$paymentline_id" name="arraypaymentline_id[$this->j]" type="hidden">
				<input type="hidden" value="$balance" name="linebalance[$this->j]">
			</td>
			

		</tr>
EOF;
//<td class="$rowtype" style="text-align:center;">
//				<input type='button' value='Del' name='btnRemove[]' onClick="submitDelete($paymentline_id)">
//			</td>
	$this->j++;

	$this->log->showLog(4,"Table generate successfully");
	}

//calculate subtotal for class
$this->outstandingamt=$totaloutstanding-$totalpaid;

echo <<< EOF
				<td  class="head" style="text-align:center;"></td>
				<td class="head" style="text-align:center;"></td>
				<td class="head"  style="text-align:center;">Sub Total:</td>
				<td class="head"  style="text-align:center;"></td>
				<td class="head"  style="text-align:center;"></td>
				<td  class="head" style="text-align:center;"></td>
				<td  class="head" style="text-align:right;">$totalbalancetrainingfees</td>
				<td class="head"  style="text-align:right;">$totalbalancetransportfees</td>
				<td class="head"  style="text-align:right;"><input name="classbalanceamt" value="$totalbalance"
					size="7" readonly="readonly" style='background-color: #c1c1c1; text-align: right;'  tabindex="-1"> </td>
				<td class="head"  style="text-align:right;"><input name="classtotalcharge"
					 value="$totalpaid"  size="7" readonly="readonly" 
					style='background-color: #c1c1c1; text-align: right;'  tabindex="-1"><input name="classrowcount"
					 value="$this->j"  size="7" readonly="readonly" 
					style='background-color: #c1c1c1; text-align: right;'  tabindex="-1" type="hidden"></td>
				

EOF;
	//echo  "</tbody></table>";
  }//getPaymentLineTable

  
  public function updatePaymentLine(){
	$this->log->showLog(3,"Update paymentline amt");
	$this->outstandingamt=0;

	$i=0;
	foreach($this->arraypaymentline_id as $id )
		{	
			$transportamt=$this->linetransportamt[$i];
			$trainingamt=$this->linetrainingamt[$i];
			
			//$amt=$transportamt+$trainingamt;
			$amt=$this->paymentlineamt[$i];
			$qty=$this->lineqty[$i];
			$uprice=$this->lineunitprice[$i];
			$subbalance=$this->linebalance[$i]-$amt;
			$payable=$this->linebalance[$i];
			$lndescription=$this->linedescription[$i];
		//	echo "<br>lndescription=".$this->linedescription[$i]."<br>";
			if($qty!="")
				$sqlupdate="UPDATE $this->tablepaymentline SET qty=$qty,unitprice=$uprice, amt=$amt".
					" ,linedescription='$lndescription' WHERE paymentline_id =$id";
			else {
				$sqlupdate="UPDATE $this->tablepaymentline SET transportamt=$transportamt".
						",trainingamt=$trainingamt, amt=$amt,payable=$payable WHERE paymentline_id =$id";
				$this->outstandingamt=$this->outstandingamt+$subbalance;
			}
			$this->log->showLog(4,"Update paymentline id: $id with amount:$amt: SQL=$sqlupdate total outstanding amt:". 
					": $this->outstandingamt, individual payment line outstanding : " .$this->lineoutstanding[$i]);
			$rs=$this->xoopsDB->query($sqlupdate);
			if(!$rs)
				$this->log->showLog(4,"<br><b style='color: red'>Failed to update paymentline id: $id </b>");
			else
				$this->log->showLog(4,"Update paymentline id: $id successfully");
			$i=$i+1;
		}
	  return true;
  }//updatePaymentLine


/**
   * Display a new form for user to add product/class into payment
   * @param
   * return 
   * @access public
   */
  public function showInsertNewItemForm($payment_id,$token) {
	$this->log->showLog(3,"Display separated form in payment windows for add new product, enrollment fees or class");
	echo <<< EOF
	<table><tbody>
		<tr>
			<th colspan="5">Add New Items</th>
		</tr>
		<tr>
			<th  style="text-align:center;">Description</th>
			<th  style="text-align:center;">Product</th>
			<th  style="text-align:center;">Qty</th>
			<th  style="text-align:center;">Description</th>
			<th  style="text-align:center;">Action</th>
		</tr>
		<tr><form method="post" action="payment.php" onSubmit="return confirm('Confirm to add this items?');">
			<td class="head" style="text-align:left;">Add one time charges or discount in this receipt</td>
			<td class="head" style="text-align:center;">$this->prdctrl</td>
			<td class="head" style="text-align:right;"><input name="qty" value="1" maxlength="3" size="3" style="text-align: right;"></td>
			<td class="head" style="text-align:center;">
			<input name="linedescription"></td><td  class="head" style="text-align:center;">
				<input type="hidden" value="addproduct" name="action">
				<input type="hidden" value="$payment_id" name="payment_id">
				<input type='submit' value='Add Item' name='submit'">
				<input type='hidden' value='$token' name='token'">
			</td>

		</tr></FORM>
		<tr><form method="post" action="payment.php" onSubmit="return confirm('Confirm to add this items?')">
			<td class="head" style="text-align:left;">Add more sales into this receipt</td>
			<td class="head" style="text-align:center;">$this->classctrl</td>
			<td class="head" style="text-align:right;"></td>
			<td class="head" style="text-align:right;"></td>
			<td class="head" style="text-align:center;">
				<input type="hidden" value="addclass" name="action">
				<input type="hidden" value="$payment_id" name="payment_id">
				<input type='submit' value='Add Sales' name='submit'">
				<input type='hidden' value='$token' name='token'">
			</td>
		</tr></FORM>
	</tbody></table>
EOF;
  }//showInsertNewItemForm

/**
   * Insert new product into db 
   * @param int product_id
   * @param int qty
   * return bool
   * @access public
   */
 public function insertNewProduct($product_id,$qty){ 

	$timestamp= date("y/m/d H:i:s", time()) ;
	$amt=$this->unitprice*$qty;
	$sqlInsert="INSERT INTO $this->tablepaymentline ( payment_id, product_id,qty, createdby,created,updatedby,".
		" updated,organization_id,studentclass_id,unitprice,amt,linedescription) VALUES ( '$this->payment_id',$product_id,".
			" $qty,$this->createdby,'$timestamp',$this->updatedby,'$timestamp',$this->organization_id,0,$this->unitprice,$amt,'$this->linedescription');";
	$this->log->showLog(3,"Insert new product into payment: $this->payment_id");
	$this->log->showLog(4,"With SQL:$sqlInsert");
	$rs=$this->xoopsDB->query($sqlInsert);
		if(!$rs){
			$this->log->showLog(1,"<b style='color: red'>Failed to insert new record");
			return false;
		}
		else{
		 	$this->log->showLog(3,"Record create into database successfully");
			return true;
		}


 }//insertNewProduct

/**
   * Insert new product into db 
   * @param int product_id
   * @param int qty
   * return bool
   * @access public
   */
 public function insertNewClass($studentclass_id,$payment_id){ 

	$timestamp= date("y/m/d H:i:s", time()) ;
	
	$sqlInsert="INSERT INTO $this->tablepaymentline ( payment_id, studentclass_id, createdby,created,updatedby,".
		" updated,organization_id,product_id,qty) VALUES ( $payment_id,$studentclass_id,".
			" $this->createdby,'$timestamp',$this->updatedby,'$timestamp',$this->organization_id,0,0);";
	$this->log->showLog(3,"Insert new class into payment: $this->payment_id");
	$this->log->showLog(4,"With SQL:$sqlInsert");
	$rs=$this->xoopsDB->query($sqlInsert);
		if(!$rs){
			$this->log->showLog(1,"<b style='color: red'>Failed to insert new record");
			return false;
		}
		else{
		 	$this->log->showLog(3,"Record create into database successfully");
			return true;
		}


 }//insertNewProduct
  /**
   * Delete payment line from payment
   * @param int paymentline_id
   * return bool
   * @access public
   */
  public function deletepaymentline($paymentline_id){
  	$this->log->showLog(2,"Warning, delete paymentline with id:$paymentline_id");
	$sqldel="DELETE FROM $this->tablepaymentline where paymentline_id=$paymentline_id";

	$this->log->showLog(4,"Executing SQL:$sqldel");
	$rs=$this->xoopsDB->query($sqldel);
	if(!$rs)
		$this->log->showLog(1,"Error: Cannot remove paymentline_id: $paymentline_id");
	else
		$this->log->showLog(2,"paymentline id: $paymentline_id removed successfully");
	
	if ($rs)
		return true;
	else
		return false;

  }//deletepaymentline

  /**
   * Retrieve a selection box for studentclass list, which is not yet included in active payment under a student
   * @param int payment_id
   * @param int student_id
   * return string
   * @access public
   */
  public function getSelectNewClassLine($payment_id,$student_id){

/*
	$sql="SELECT sc.studentclass_id, coalesce(".
		"concat(tc.description,'/',sc.transactiondate,'/',".
			"  $subsqlclass,'/',$subsqltransport), ".
		" concat(pd.product_name,'x',-1*i.quantity,'/',sc.transactiondate,'/',".
			"  $subsqlclass,'/',$subsqltransport)) as name ".
		" FROM  $tablestudentclass sc  ".
		" LEFT JOIN $tabletuitionclass tc ON sc.tuitionclass_id = tc.tuitionclass_id ".
		" LEFT JOIN $tableinventorymovement i on sc.movement_id=i.movement_id ".
		" LEFT JOIN $tableproductlist pd ON i.product_id = pd.product_id ".
		" WHERE sc.studentclass_id NOT IN ( SELECT studentclass_id FROM $this->tablepaymentline ".
		" WHERE payment_id =$payment_id ) and sc.student_id=$student_id;";
*/
	$tabletuitionclass=$this->tableprefix."simtrain_tuitionclass";
	$tableproductlist=$this->tableprefix."simtrain_productlist";
	$tablestudentclass=$this->tableprefix."simtrain_studentclass";
	$tableinventorymovement=$this->tableprefix."simtrain_inventorymovement";
	$tablepayment=$this->tableprefix."simtrain_payment";
	$subsqlclass="sc.amt - ( SELECT coalesce(sum(pl.trainingamt),0) as trainingamt ".
			" from $this->tablepaymentline pl ".
			" inner join $tablepayment py on pl.payment_id=py.payment_id ".
			" where pl.studentclass_id=sc.studentclass_id )";
	$subsqltransport="sc.transportfees - ( SELECT coalesce(sum(pl.transportamt),0) as transportamt ".
			" from $this->tablepaymentline pl ".
			" inner join $tablepayment py on pl.payment_id=py.payment_id ".
			" where pl.studentclass_id=sc.studentclass_id )";

	$selectctl="<SELECT name='studentclass_id' >";
	$this->log->showLog(3,"Generating new selection box for user to add class under this payment: $payment_id");
	$sql="SELECT sc.studentclass_id, (CASE WHEN tc.tuitionclass_id >0 THEN
		concat(tc.description,'/',sc.transactiondate,'/',
			  $subsqlclass,'/',$subsqltransport) ELSE 
		 concat(pd.product_name,'x',-1*i.quantity,'/',sc.transactiondate,'/',
			  $subsqlclass,'/',$subsqltransport) END ) as name 
		 FROM  $tablestudentclass sc  
		 LEFT JOIN $tabletuitionclass tc ON sc.tuitionclass_id = tc.tuitionclass_id 
		 LEFT JOIN $tableinventorymovement i on sc.movement_id=i.movement_id 
		 LEFT JOIN $tableproductlist pd ON i.product_id = pd.product_id 
		 WHERE sc.studentclass_id NOT IN ( SELECT studentclass_id FROM $this->tablepaymentline 
		 WHERE payment_id =$payment_id ) and sc.student_id=$student_id AND (($subsqlclass <>0) OR ($subsqltransport <>0))";

	$this->log->showLog(4,"With SQL : $sql");	
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$studentclass_id=$row['studentclass_id'];
		$product_name=$row['name'];
	
	
		$selectctl=$selectctl  . "<OPTION value='$studentclass_id' $selected>$product_name</OPTION>";

	}
	
	$selectctl=$selectctl . "</SELECT>";
	
	return $selectctl;
  }//getSelectNewClassLine

   /**
   * Retrieve total amt of all paymentline under particular payment payment
   * @param int payment_id
   * return decimal
   * @access public
   */

  public function getPaymentLineTotal($payment_id){
	$this->log->showLog(3,"Retrieve total under: $payment_id");
	$sql="SELECT SUM(amt) as total from $this->tablepaymentline where payment_id=$payment_id";
	$this->log->showLog(4,"With SQL: $sql");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$total=$row['total'];
		$this->log->showLog(3,"Return Total: $total");
		return  $total;
	}
	else{
		$this->log->showLog(2,"Can get any information under this payment, return  total = $total");
		return 0;
	}

  }//getPaymentLineTotal
}//end class PaymentLine

?>