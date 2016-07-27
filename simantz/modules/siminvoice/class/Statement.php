<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Statement
{


public	$customer_id;
public	$invoice_id;
public	$start_date;
public	$end_date;

public	$termsctrl;


public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public	$isactive;

public 	$customerctrl;
public 	$invoicectrl;
public 	$showcalendar1;
public 	$showcalendar2;

public  $xoopsDB;
public  $tableprefix;
public  $tableterms;
public  $tableitem;
public  $tablecustomer;
public  $tableinvoice;
public  $tablequotation;
public  $tableinvoiceline;
public  $tablequotationline;
public  $tablepayment;
public  $tablepaymentline;
public  $log;



//constructor
   public function Statement($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableterms=$tableprefix."tblterms";
	$this->tableitem=$tableprefix."tblitem";
	$this->tableincustomer=$tableprefix."tblcustomer";
	$this->tableinvoice=$tableprefix."tblinvoice";
	$this->tableinvoiceline=$tableprefix."tblinvoiceline";
	$this->tablepayment=$tableprefix."tablepayment";
	$this->tablepaymentline=$tableprefix."tablepaymentline";
	$this->tablepayment=$tableprefix."tblpayment";
	$this->tablepaymentline=$tableprefix."tblpaymentline";
	$this->tablequotation=$tableprefix."tblquotation";
	$this->tableterms=$tableprefix."tblterms";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int terms_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $terms_id, $token  ) {

   $header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	

		$selected_n = ''; 
		$selected_s = '';
		$selected_t = '';
 

 		
		if($this->terms_days == '')
		$selected_n = "selected='selected'";
		if($this->terms_days == 'S')
		$selected_s = "selected='selected'";
		if($this->terms_days == 'T')
		$selected_t = "selected='selected'";
		
	$this->created=0;
	if ($type=="new"){
		$header="New Statement";
		$action="create";
	 	
		if($terms_code==0){
			$this->terms_code=$this->getNewStatement();
			$this->terms_desc="";
			$this->isactive=0;
			

		}
		
		

	

		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$defaultchecked="";
		$deletectrl="";


	}
	else
	{
		
		$action="update";
		$savectrl="<input name='terms_id' value='$this->terms_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='1')
			$checked="CHECKED";
		else
			$checked="";
		if ($this->isdefault=='1')
			$defaultchecked="CHECKED";
		else
			$defaultchecked="";
	
		$header="Edit Statement";
		
		if($this->allowDelete($this->terms_id))
		$deletectrl="<FORM action='statement.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this terms?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->terms_id' name='terms_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else

		$deletectrl="";
	
	}


	if($this->terms_days=="")
		$this->terms_days = 0;
	
    echo <<< EOF


<table style="width:140px;"><tbody><td><form onsubmit="return validateStatement()" method="post"
 action="statement.php" name="frmStatement"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        	<td class="head">Statement Code *</td>
        	<td class="odd" ><input name='terms_code' value="$this->terms_code" maxlength='10' size='15'> </td>
        	<td class="head">Statement Description *</td>
        	<td class="odd"><input maxlength="40" size="50" name="terms_desc" value="$this->terms_desc"></td>
      </tr>
      
		<tr>
			<td class="head">Active</td>
			<td  class="odd"> <input type='checkbox' $checked name='isactive'></td>
			<td class="head">Statement Days</td>
			<td  class="odd"><input maxlength="5" size="5" name="terms_days" value="$this->terms_days"></td>
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

 
  public function updateStatement( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableterms SET
	terms_code='$this->terms_code',
	terms_desc='$this->terms_desc',
	terms_days=$this->terms_days,
	updated='$timestamp',
	updatedby=$this->updatedby,
	isactive=$this->isactive
	WHERE terms_id=$this->terms_id";
	
	$this->log->showLog(3, "Update terms_id: $this->terms_id, $this->terms_desc");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update terms failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update terms successfully.");
		return true;
	}
  } // end of member function updateStatement


  public function insertStatement( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new terms $this->terms_desc");
 	$sql="INSERT INTO $this->tableterms 
 			(terms_code,terms_desc,terms_days,createdby,created,updatedby,updated,isactive) 
 			values 	('$this->terms_code',
						'$this->terms_desc',
						$this->terms_days,
						 $this->createdby,
						'$timestamp',
						 $this->updatedby,
						'$timestamp',
						 $this->isactive)";
	$this->log->showLog(4,"Before insert terms SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert terms code $terms_desc");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new terms $terms_desc successfully"); 
		return true;
	}
  } // end of member function insertStatement


  public function fetchStatement( $terms_id) {
    
    //echo $terms_id;
	$this->log->showLog(3,"Fetching terms detail into class Statement.php.<br>");
		
	$sql="SELECT terms_id,terms_code,terms_desc,terms_days,created,createdby,updated, updatedby, isactive 
			from $this->tableterms 
			where terms_id=$terms_id";
	
	$this->log->showLog(4,"ProductStatement->fetchStatement, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->terms_code=$row['terms_code'];
	$this->terms_desc=$row['terms_desc'];
	$this->terms_days=$row['terms_days'];
	$this->isactive=$row['isactive'];
	
   $this->log->showLog(4,"Statement->fetchStatement,database fetch into class successfully");	
	$this->log->showLog(4,"terms_desc:$this->terms_desc");
	$this->log->showLog(4,"description:$this->description");
	$this->log->showLog(4,"isactive:$this->isactive");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Statement->fetchStatement,failed to fetch data into databases.");	
	}
  } // end of member function fetchStatement

  public function deleteStatement( $terms_id ) {
    	$this->log->showLog(2,"Warning: Performing delete terms id : $terms_id !");
	$sql="DELETE FROM $this->tableterms where terms_id=$terms_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: terms ($terms_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"terms ($terms_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteStatement

  
  public function getSQLStr_AllStatement($customer_id="",$invoice_id="",$start_date="",$end_date="") {

	$wherestr = $this->convertSearchString($customer_id,$invoice_id,$start_date,$end_date);
	$sql="SELECT SUM(t.AMOUNT) as balance FROM (
		SELECT SUM(invoice_totalamount) as amount FROM $this->tableinvoice 
			WHERE customer_id=$customer_id AND invoice_date< '$start_date' AND iscomplete='1'
		UNION ALL
		SELECT -1*sum(paymentline_amount) as amount FROM $this->tablepaymentline a 
			inner join $this->tablepayment b on a.payment_id = b.payment_id
			WHERE customer_id=$customer_id AND payment_date< '$start_date' 
		) as t";
	$this->log->showLog(4,"1st sql statement for get b/f :$sql");
	$bfamount=0;
	$querybf=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($querybf))
		$bfamount=$row['balance'];

	if($bfamount=="")
	$bfamount=0;


	$sql2 = "SELECT 0 as customer_id,0 invoice_id,0 as terms_id,'' as invoice_no,''  as date,'' as due_date,'Balance B/F' as type,$bfamount as amount,'' as iscomplete Union ALL

		SELECT * FROM
		(
			
			SELECT
			a.customer_id as customer_id,
			a.invoice_id as invoice_id,
			a.terms_id as terms_id,
			a.invoice_no as invoice_no,
			a.invoice_date as date,
			ADDDATE(a.invoice_date, INTERVAL b.terms_days DAY) as due_date,
			'Sales' as type,
			invoice_totalamount as amount,
			a.iscomplete as complete
			FROM $this->tableinvoice a, $this->tableterms b 
			WHERE a.iscomplete = 1
			AND a.terms_id = b.terms_id

			UNION ALL


			SELECT 
			b.customer_id as customer_id,
			a.invoice_id as invoice_id,
			'' as terms_id,
			c.invoice_no as invoice_no,
			b.payment_date as date,
			'' as due_date,
			'Payment' as type, -1 *
			paymentline_amount as amountcredit ,
			'' as complete
			FROM $this->tablepaymentline a, $this->tablepayment b, $this->tableinvoice c
			WHERE a.payment_id = b.payment_id
			AND a.invoice_id = c.invoice_id
			

			) a 
			$wherestr 
			ORDER BY date ASC ";
	/*$sql = "SELECT * FROM
		(
			SELECT
			a.customer_id as customer_id,
			a.invoice_id as invoice_id,
			a.terms_id as term_id,
			a.invoice_no as invoice_no,
			a.invoice_date as date,
			ADDDATE(a.invoice_date, INTERVAL b.terms_days DAY) as due_date,
			'invoice' as type,
			invoice_totalamount as amount ,
			a.iscomplete as complete
			FROM $this->tableinvoice a
			inner join $this->tableterms b on  a.terms_id = b.terms_id 
			WHERE a.iscomplete = 1
			UNION ALL


			SELECT 
			b.customer_id as customer_id,
			b.payment_id as invoice_id,
			'' as term_id,
			b.payment_no as invoice_no,
			b.payment_date as date,
			'' as due_date,
			'payment' as type, 
			sum(paymentline_amount) as amount ,
			'' as complete
			FROM $this->tablepaymentline a inner join $this->tablepayment b on a.payment_id = b.payment_id
			GROUP BY b.payment_id,b.payment_date
			) a 
			$wherestr 
			ORDER BY date ASC,type desc ";
							
							
							
*/
	$this->log->showLog(4,"Running ProductStatement->getSQLStr_AllStatement: $sql2"); 
	return $sql2;

  } // end of member function getSQLStr_AllStatement

 public function showStatementTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0){
	$this->log->showLog(3,"Showing Statement Table");
	//$sql=$this->getSQLStr_AllStatement($wherestring,$orderbystring,$startlimitno,$recordcount);
	$sql=$this->getSQLStr_AllStatement();
	
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Due Date</th>
				<th style="text-align:center;">Reference </th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Amount (RM)</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$invoice_id=$row['invoice_id'];
		$invoice_no=$row['invoice_no'];
		$date=$row['date'];
		$due_date=$row['due_date'];
		$description_days=$row['type'];
		$amount=$row['amount'];
		
		
		// row style
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$date</td>
			<td class="$rowtype" style="text-align:center;">$due_date</td>
			<td class="$rowtype" style="text-align:center;">$invoice_no</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">$amount</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

  
  
  // start serach table
  
  public function showSearchTable($customer_id,$invoice_id,$start_date,$end_date){
	$this->log->showLog(3,"Showing Statement Table");
	
	if($_POST)
	$sql=$this->getSQLStr_AllStatement($customer_id,$invoice_id,$start_date,$end_date);
	else
	$sql = "";
	
	$wherestr = $this->convertSearchString($customer_id,$invoice_id,$start_date,$end_date);
	
	if($orderctrl=='asc'){
	
	if($fldSort=='terms_code')
	$sortimage1 = 'images/sortdown.gif';
	else
	$sortimage1 = 'images/sortup.gif';
	if($fldSort=='terms_desc')
	$sortimage2 = 'images/sortdown.gif';
	else
	$sortimage2 = 'images/sortup.gif';
	if($fldSort=='terms_days')
	$sortimage3 = 'images/sortdown.gif';
	else
	$sortimage3 = 'images/sortup.gif';
	if($fldSort=='isactive')
	$sortimage4 = 'images/sortdown.gif';
	else
	$sortimage4 = 'images/sortup.gif';
	
	}else{
	$sortimage1 = 'images/sortup.gif';
	$sortimage2 = 'images/sortup.gif';
	$sortimage3 = 'images/sortup.gif';
	$sortimage4 = 'images/sortup.gif';
	}

//echo $sql;
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Due Date</th>
				<th style="text-align:center;">Reference </th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Amount (RM)</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	$tot_amount = 0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$invoice_id=$row['invoice_id'];
		$invoice_no=$row['invoice_no'];
		$date=$row['date'];
		$due_date=$row['due_date'];
		$description=$row['type'];
		$amount=$row['amount'];
		
		if($description=="payment")
		$amount = "-".$amount;
		
		$tot_amount += $amount;		
		
		
		// row style
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$date</td>
			<td class="$rowtype" style="text-align:center;">$due_date</td>
			<td class="$rowtype" style="text-align:center;">$invoice_no</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">$amount</td>

		</tr>
EOF;
	}
	
	if($i>0){
	$tot_amount = number_format($tot_amount, 2, '.','');
	echo "<tr><td colspan='4'></td>
			<td class='head' align='center'>Total Due (RM)</td>
			<td class='head' align='center'>$tot_amount</td>
			</tr>";
	}
	
	
		
	$printctrl="<tr><td colspan='11' align=right><form action='viewstatement.php' method='POST' target='_blank' name='frmPdf'><br>
					<input type='submit' value='Print Statement' name='btnPrint'>
					<input type='hidden' name='wherestr' value=\"$wherestr\">
					<input type='hidden' name='orderstr' value=''>
					<input type='hidden' name='start_date' value='$start_date'>
					<input type='hidden' name='end_date' value='$end_date'>
					<input type='hidden' name='customer_id' value='$customer_id'>
					</form></td></tr>";
	
					
	if($customer_id!="-1")			
	echo $printctrl;

	echo  "</tr></tbody></table>";
 }



   
   
 public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search terms easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(terms_desc,1)) as shortname FROM $this->tableterms where isactive='1' order by terms_desc";
	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
	echo "<b>Statement Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if terms never do filter yet, if will choose 1st terms listing
		
		echo "<A style='font-size:12;' href='statement.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>
<A href='statement.php?action=new' style='color: GRAY'> [ADD NEW TERMS]</A>
<A href='statement.php?action=showSearchForm' style='color: gray'> [SEARCH TERMS]</A>

EOF;
return $filterstring;
  }
  
  
  
  


  public function getLatestStatementID() {
	$sql="SELECT MAX(terms_id) as terms_id from $this->tableterms;";
	$this->log->showLog(3,'Checking latest created terms_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created terms_id:' . $row['terms_id']);
		return $row['terms_id'];
	}
	else
	return -1;
	
  } // end
  
  
  public function getNewStatement() {
	$sql="SELECT MAX(terms_code) as terms_code from $this->tableterms;";
	$this->log->showLog(3,'Checking latest created terms_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created terms_code:' . $row['terms_code']);
		$terms_code=$row['terms_code']+1;
		return $terms_code;
	}
	else
	return 0;
	
  } // end
  
  

  public function getSelectStatement($id) {
	
	if($id=="")
	$id = 0;	
	
	$sql="SELECT terms_id,terms_desc from $this->tableterms where isactive=1 or terms_id=$id " .
		" order by terms_desc";
	$selectctl="<SELECT name='terms_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$terms_id=$row['terms_id'];
		$terms_desc=$row['terms_desc'];
	
		if($id==$terms_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$terms_id' $selected>$terms_desc</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end


  public function allowDelete($id){
	$sql="SELECT count(terms_id) as rowcount from $this->tableterms where terms_id=$id";
	
	$this->log->showLog(3,"Accessing ProductStatement->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this terms, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this terms, record deletable");
		return true;
		}
	}


 public function showStatementHeader($terms_id){
	if($this->fetchStatement($terms_id)){
		$this->log->showLog(4,"Showing terms header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Statement Info</th>
			</tr>
			<tr>
				<td class="head">Statement No</td>
				<td class="odd">$this->terms_code</td>
				<td class="head">Statement Description</td>
				<td class="odd"><A href="statement.php?action=edit&terms_id=$terms_id" 
						target="_blank">$this->terms_desc</A></td>
			</tr>
		</tbody>
	</table>
EOF;
	}
	else{
		$this->log->showLog(1,"<b style='color:red;'>Showing terms header failed.</b>");
	}

   }//showRegistrationHeader
   
   
  
  
 public function showSearchForm($wherestring="",$orderctrl=""){
	
   
	if($this->start_date=="")
	$this->start_date = $this->getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = $this->getMonth(date("Ymd", time()),1) ;
   
   echo <<< EOF

	<FORM action="statement.php" method="POST" name="frmActionSearch" id="frmActionSearch">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head'>Customer</td>
	      <td class='even'>$this->customerctrl</td>
	      <td class='head'></td>
	      <td class='even'></td>
	    </tr>
	    <tr>
	      <td class='head'>Start Date</td>
	      <td class='odd'>
	      <input name="start_date" id="start_date" value="$this->start_date"  size='10' maxlength='10'>
	      <input type='button' value='Date' onClick="$this->showcalendar1"></td>
	      <td class='head'>End Date</td>
	      <td class='odd'>
	      <input name="end_date" id="end_date" value="$this->end_date"  size='10' maxlength='10'>
	      <input type='button' value='Date' onClick="$this->showcalendar2"></td>
	    </tr>
	    
	
	    
	  </tbody>
	</table>
	<table style="width:150px;">
	  <tbody>
	    <tr>
	      <td><input style="height:40px;" type='button' value='Search' name='btnSubmit' onclick="return searchForms(); ">
	      <input type='hidden' name='action' value='search'>
			<input type='hidden' name='fldSort' value=''>
			<input type='hidden' name='wherestr' value="$wherestring">
			<input type='hidden' name='orderctrl' value='$orderctrl'>  
	      </td>
	      
	    </tr>
	  </tbody>
	</table>
	</FORM>
EOF;
  }

  public function convertSearchString($customer_id,$invoice_id,$start_date,$end_date){
  
  
	$filterstring="";

	if($customer_id > 0 ){
		$filterstring=$filterstring . " a.customer_id=$customer_id AND";
	}

	if($invoice_id > 0 ){
		$filterstring=$filterstring . " a.invoice_id=$invoice_id AND";
	}

	if($start_date!="" && $end_date!=""){
		$filterstring=$filterstring . "  a.date between '$start_date' AND '$end_date' AND";
	}

	if ($filterstring=="")
		return "";
	else {
		$filterstring =substr_replace($filterstring,"",-3);  

		return "WHERE $filterstring";
		}
	
	}
	
	public function getMonth($date,$type){
	
	$month = substr($date,4,2);
	$year = substr($date,0,4);
	$first_of_month = mktime(0, 0, 0, (int)$month, 1, 2008);
	$days_in_month = date('t', $first_of_month);
	$last_of_month = mktime(0, 0, 0, (int)$month, $days_in_month, $year);
	
	if($type==0)
	$date_val = date("Y",$first_of_month).date("m",$first_of_month).date("d",$first_of_month);
	else
	$date_val = date("Y",$last_of_month).date("m",$last_of_month).date("d",$last_of_month);
	
	
	$date_val = strtotime($date_val.' UTC');
	
	return gmdate('Y-m-d',$date_val);
	
	}
	
	
  	
  

} // end of ClassStatement
?>


