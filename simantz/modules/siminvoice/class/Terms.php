<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Terms
{

public	$terms_id;
public	$terms_code;
public	$terms_desc;
public	$terms_days;
public	$termsctrl;


public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public	$isactive;

public  $xoopsDB;
public  $tableprefix;
public  $tableterms;
public  $tableitem;
public  $tablecustomer;
public  $tableinvoice;
public  $tablequotation;
public  $log;



//constructor
   public function Terms($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableterms=$tableprefix."tblterms";
	$this->tableitem=$tableprefix."tblitem";
	$this->tableincustomer=$tableprefix."tblcustomer";
	$this->tableinvoice=$tableprefix."tblinvoice";
	$this->tablequotation=$tableprefix."tblquotation";
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
		$header="New Terms";
		$action="create";
	 	
		if($terms_code==0){
			$this->terms_code=$this->getNewTerms();
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
	
		$header="Edit Terms";
		
		if($this->allowDelete($this->terms_id))
		$deletectrl="<FORM action='terms.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this terms?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->terms_id' name='terms_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else

		$deletectrl="";
	
	}


	if($this->terms_days=="")
		$this->terms_days = 0;
	
    echo <<< EOF


<table style="width:140px;"><tbody><td><form onsubmit="return validateTerms()" method="post"
 action="terms.php" name="frmTerms"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        	<td class="head">Terms Code *</td>
        	<td class="odd" ><input name='terms_code' value="$this->terms_code" maxlength='10' size='15'> </td>
        	<td class="head">Terms Description *</td>
        	<td class="odd"><input maxlength="40" size="50" name="terms_desc" value="$this->terms_desc"></td>
      </tr>
      
		<tr>
			<td class="head">Active</td>
			<td  class="odd"> <input type='checkbox' $checked name='isactive'></td>
			<td class="head">Terms Days</td>
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

 
  public function updateTerms( ) {
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
  } // end of member function updateTerms


  public function insertTerms( ) {
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
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert terms code $terms_desc");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new terms $terms_desc successfully"); 
		return true;
	}
  } // end of member function insertTerms


  public function fetchTerms( $terms_id) {
    
    //echo $terms_id;
	$this->log->showLog(3,"Fetching terms detail into class Terms.php.<br>");
		
	$sql="SELECT terms_id,terms_code,terms_desc,terms_days,created,createdby,updated, updatedby, isactive 
			from $this->tableterms 
			where terms_id=$terms_id";
	
	$this->log->showLog(4,"ProductTerms->fetchTerms, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->terms_code=$row['terms_code'];
	$this->terms_desc=$row['terms_desc'];
	$this->terms_days=$row['terms_days'];
	$this->isactive=$row['isactive'];
	
   $this->log->showLog(4,"Terms->fetchTerms,database fetch into class successfully");	
	$this->log->showLog(4,"terms_desc:$this->terms_desc");
	$this->log->showLog(4,"description:$this->description");
	$this->log->showLog(4,"isactive:$this->isactive");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Terms->fetchTerms,failed to fetch data into databases.");	
	}
  } // end of member function fetchTerms

  public function deleteTerms( $terms_id ) {
    	$this->log->showLog(2,"Warning: Performing delete terms id : $terms_id !");
	$sql="DELETE FROM $this->tableterms where terms_id=$terms_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: terms ($terms_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"terms ($terms_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteTerms

  
  public function getSQLStr_AllTerms( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {

/*
    $sql="SELECT c.terms_id,c.terms_code,c.terms_desc,c.street1,c.street2,".
		"c.postcode,c.city,c.state1,c.country,".
		"c.contactperson,c.contactperson_no,c.tel1,c.tel2,c.fax,c.description,".
		"c.created,c.createdby,c.updated, c.updatedby, c.isactive, c.isdefault,c.currency_id, ".
		"cr.currency_symbol FROM $this->tableterms c " .
		"left join $this->tablecurrency cr on c.currency_id = cr.currency_id ".
	" $wherestring $orderbystring LIMIT $startlimitno,$recordcount";
	*/
	
	$sql = "SELECT c.terms_id,c.terms_code,c.terms_desc,c.terms_days,c.created,c.createdby,c.updated, c.updatedby, c.isactive
				FROM $this->tableterms c 
				$wherestring $orderbystring LIMIT $startlimitno,$recordcount ";
				
  $this->log->showLog(4,"Running ProductTerms->getSQLStr_AllTerms: $sql"); 
 return $sql;
  } // end of member function getSQLStr_AllTerms

 public function showTermsTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0){
	$this->log->showLog(3,"Showing Terms Table");
	$sql=$this->getSQLStr_AllTerms($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Terms No</th>
				<th style="text-align:center;">Terms Description</th>
				<th style="text-align:center;">Payment Terms</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$terms_id=$row['terms_id'];
		$terms_code=$row['terms_code'];
		$terms_desc=$row['terms_desc'];
		$terms_days=$row['terms_days'];
		$isactive=$row['isactive'];
		
		// terms 
		if($terms_days=="S")
			$terms_days = "Stock";
		else
			$terms_days = $terms_days." Days";
	
	
		// isactive 
		if($isactive=="1")
			$isactive = "Yes";
		else
			$isactive = "No";
	
		// row style
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$terms_code</td>
			<td class="$rowtype" style="text-align:center;">$terms_desc</td>
			<td class="$rowtype" style="text-align:center;">$terms_days</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="terms.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this terms'>
				<input type="hidden" value="$terms_id" name="terms_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

  
  
  // start serach table
  
  public function showSearchTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0, $orderctrl="", $fldSort =""){
	$this->log->showLog(3,"Showing Terms Table");
	
	$sql=$this->getSQLStr_AllTerms($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	
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


	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Terms Code <br><input type='image' src="$sortimage1" name='submit'  title='Sort this record' onclick = " headerSort('terms_code');"></th>
				<th style="text-align:center;">Terms Description <br><input type='image' src="$sortimage2" name='submit'  title='Sort this record' onclick = " headerSort('terms_desc');"></th>
				<th style="text-align:center;">Terms Days <br><input type='image' src="$sortimage3" name='submit'  title='Sort this record' onclick = " headerSort('terms_days');"></th>
				<th style="text-align:center;">Active <br><input type='image' src="$sortimage4" name='submit'  title='Sort this record' onclick = " headerSort('isactive');"></th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$terms_id=$row['terms_id'];
		$terms_code=$row['terms_code'];
		$terms_desc=$row['terms_desc'];
		$terms_days=$row['terms_days'];

		$isactive=$row['isactive'];
		
	
	
		// isactive 
		if($isactive=="1")
			$isactive = "Yes";
		else
			$isactive = "No";
		
		// row style
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$terms_code</td>
			<td class="$rowtype" style="text-align:center;">$terms_desc</td>
			<td class="$rowtype" style="text-align:center;">$terms_days</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="terms.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this terms'>
				<input type="hidden" value="$terms_id" name="terms_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	
		$printctrl="<tr><td colspan='11' align=right><form action='viewterms.php' method='POST' target='_blank' name='frmPdf'>
					<input type='image' src='images/reportbutton.jpg'>
					<input type='hidden' name='wherestr' value=\"$wherestring\">
					<input type='hidden' name='orderstr' value='$orderbystring'>
					</form></td></tr>";
					
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
	/*
	echo "<b>Terms Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if terms never do filter yet, if will choose 1st terms listing
		
		echo "<A style='font-size:12;' href='terms.php?filterstring=$shortname'>  $shortname  </A> ";
	}*/
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>
<A href='terms.php?action=new' style='color: GRAY'><img src="images/addnew.jpg"</A>
<A href='terms.php?action=showSearchForm' style='color: gray'><img src="images/search.jpg"</A>

EOF;
return $filterstring;
  }
  
  
  
  


  public function getLatestTermsID() {
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
  
  
  public function getNewTerms() {
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
  
  

  public function getSelectTerms($id) {
	
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
	$sql="SELECT SUM(r.rowcount) as rowcount FROM (
		SELECT count(terms_id) as rowcount from $this->tableinvoice where terms_id=$id
		UNION ALL
		SELECT count(terms_id) as rowcount from $this->tablequotation where terms_id=$id) as r";
	
	$this->log->showLog(3,"Accessing ProductTerms->allowDelete to verified id:$id is deletable.");
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


 public function showTermsHeader($terms_id){
	if($this->fetchTerms($terms_id)){
		$this->log->showLog(4,"Showing terms header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Terms Info</th>
			</tr>
			<tr>
				<td class="head">Terms No</td>
				<td class="odd">$this->terms_code</td>
				<td class="head">Terms Description</td>
				<td class="odd"><A href="terms.php?action=edit&terms_id=$terms_id" 
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

   echo <<< EOF

	<FORM action="terms.php" method="POST" name="frmActionSearch" id="frmActionSearch">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head'>Terms No</td>
	      <td class='even'><input name='terms_code' value='$this->terms_code'> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Terms Description</td>
	      <td class='even'><input name='terms_desc' value='$this->terms_desc'>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->termsctrl</td>
	      <td class='head'>Is Active</td>
	      <td class='odd'>
		<select name="isactive">
			<option value="-1">Null</option>
			<option value="1" >Y</option>
			<option value="0" >N</option>
		</select>
		</td>
	    </tr>
	    
	
	    
	  </tbody>
	</table>
	<table style="width:150px;">
	  <tbody>
	    <tr>
	      <td><input style="height:40px;" type='submit' value='Search' name='btnSubmit'>
	      <input type='hidden' name='action' value='search'>
			<input type='hidden' name='fldSort' value=''>
			<input type='hidden' name='wherestr' value="$wherestring">
			<input type='hidden' name='orderctrl' value='$orderctrl'>  
	      </td>
	      <td><input type='reset' value='Reset' name='reset'></td>
	    </tr>
	  </tbody>
	</table>
	</FORM>
EOF;
  }

  public function convertSearchString($terms_id,$terms_code,$terms_desc,$isactive){
$filterstring="";

if($terms_id > 0 ){
	$filterstring=$filterstring . " c.terms_id=$terms_id AND";
}

if($terms_code!=""){
	$filterstring=$filterstring . " c.terms_code LIKE '$terms_code' AND";
}

if($terms_desc!=""){
	$filterstring=$filterstring . "  c.terms_desc LIKE '$terms_desc' AND";
}

if ($isactive!="-1")
$filterstring=$filterstring . " c.isactive =$isactive AND";

if ($filterstring=="")
	return "";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return "WHERE $filterstring";
	}
	
}
  	
  

} // end of ClassTerms
?>


