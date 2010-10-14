<?php


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


class Organization
{

  /** Aggregations: */

  /** Compositions: */

   
  public $organization_id;
  public $organization_code;
  public $organization_name;
  public $companyname;
  public $companyno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $isactive;
  public $street1;
  public $street2;
  public $street3;
  public $city;
  public $state;
  public $country_id;
  public $tel_1;
  public $tel_2;
  public $fax;
  public $seqno;
  public $currency_id;
  public $email;
  public $url;
  public $groupid;

  public $groupctrl;
  public $currencyctrl;
  /**
   * @access public
   */

  
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $log;


  /**
   *
   * @param xoopsDB 
   * @param tableprefix 
   * @access public, constructor
   */
  public function Organization(){
	global $xoopsDB,$log,$tablecurrency,$tablecountry,$tableorganization,$tablegroups_users_link;
  	$this->xoopsDB=$xoopsDB;
	$this->tablecurrency=$tablecurrency;
	$this->tablecountry=$tablecountry;
	$this->tableorganization=$tableorganization;
	$this->tablegroups_users_link=$tablegroups_users_link;
	$this->log=$log;
   }

  /**
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllOrganization( $wherestring,  $orderbystring,  $startlimitno ) {
     $sql= "SELECT organization_id,organization_code,organization_name,tel_1,tel_2,fax," .
	"email,url,isactive,country_id,companyno
      FROM $this->tableorganization $wherestring $orderbystring";
	$this->log->showLog(4,"Calling getSQLStr_AllOrganization:" .$sql);
   return $sql;
   } // end of member function getSQLStr_AllOrganization

  /**
   *
   * @param string type 'new' or 'edit'

   * @param int organization_id 
   * @return bool
   * @access public
   */
  public function getInputForm( $type,  $organization_id,$token ) {

	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	if ($type=="new"){
		$header="New Organization";
		$action="create";
		if($organization_id==0){
		$this->organization_name="";
		$this->organization_code="";
                $this->company_name="";
		$this->tel_1="";
		$this->tel_2="";
		$this->fax="";
		$this->email="";
		$this->street1="";
		$this->street2="";
		$this->street3="";
		$this->seqno=10;
		$this->url="";
		$this->groupid=0;
		}
		$savectrl="<input name='btnsave' value='save' type='submit' onclick='save()'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		/*
		*
		* creating address for organization not yet complete.
		*/
		$action="update";
		
		$savectrl="".
			 "<input name='btnsave' value='save' type='submit' onclick='save()'>";

		//force isactive checkbox been checked if the value in db is '1'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";
		$header="Edit Organization";
		$deletectrl="<input type='submit' value='Delete' name='btndelete' onclick='deleterecord();'>";
		$addnewctrl="<input name='btnadd' value='New' type='submit' onclick='add()'>";
	}
//<A href='index.php'>Back To This Module Administration Menu</A>
    echo <<< EOF
 <script language="javascript" type="text/javascript">
        
  function deleterecord(){
    if(confirm("Delete record?")){
    document.frmOrganzation.action.value="delete";
    document.frmOrganzation.submit();
    }
  }
  function add(){
    document.frmOrganzation.action.value="";
    document.frmOrganzation.submit();
  }
  function save(){

      var name=document.forms['frmOrganzation'].organization_name.value;
      var code=document.forms['frmOrganzation'].organization_code.value;


            var isallow = true;
            var errorMsg = "";

            if(name == ""){
                isallow = false;
                errorMsg += "<br/><b>Organization name Name</b>";
            }
            if(code == ""){
                isallow = false;
                errorMsg += "<br/><b>Organization code</b>";
            }

      if(confirm("Save record?")){
             if(isallow){
             document.frmOrganzation.submit();
              }else{
                 document.getElementById("statusDiv").innerHTML="Failed to save record...Please Check :<br/>"+errorMsg;
                 return false;
               }
        }

  }

  function resetdata(){

     document.forms['frmOrganzation'].organization_code.value="";
     document.forms['frmOrganzation'].organization_name.value="";
     document.forms['frmOrganzation'].companyname.value="";
     document.forms['frmOrganzation'].companyno.value="";
     document.forms['frmOrganzation'].tel_1.value="";
     document.forms['frmOrganzation'].tel_2.value="";

     document.forms['frmOrganzation'].fax.value="";
     document.forms['frmOrganzation'].url.value="";
     document.forms['frmOrganzation'].email.value="";
     document.forms['frmOrganzation'].street1.value="";
     document.forms['frmOrganzation'].street2.value="";

    document.forms['frmOrganzation'].street3.value="";
     document.forms['frmOrganzation'].city.value="";
     document.forms['frmOrganzation'].state.value="";
     document.forms['frmOrganzation'].postcode.value="";
     document.forms['frmOrganzation'].country_id.value="0";
     document.forms['frmOrganzation'].currency_id.value="0";
   }

</script>
<br>
<div style="width: 970px;" id="statusDiv" align="center" class="ErrorstatusDiv"></div>
<form onsubmit="return false" method="post" action="organization.php" name="frmOrganzation">
<input name='organization_id' value='$this->organization_id' type='hidden'>
    <table>
      <tr>
        <td align="left">$addnewctrl</td>
      </tr>
   </table>
   <table style="text-align: left; width: 100%;" border="1" class="searchformblock" cellpadding="2" >
    <tbody>
        
      <tr>
        <td colspan="4" rowspan="1" class="searchformheader">$header</td>
      </tr>

      <tr>
        <td class='head'>Organization Code $selectorg</td>

        <td class='even'><input maxlength="10" size="10"  name="organization_code" value="$this->organization_code">&nbsp;
	Active <input type="checkbox" $checked name="isactive">  $this->groupctrl</td>

      </tr>

      <tr>
        <td class='head'>Organization Name</td>
        <td class='odd'>
            <input maxlength="40" size="40" name="organization_name"  id="organization_name" value="$this->organization_name"></td>
        <td class='head'>Company Name/No</td>
        <td class='odd'>
            <input maxlength="40" size="40" name="companyname"  id="companyname" value="$this->companyname">
	    <input maxlength="15" size="15" name="companyno" id="companyno" value="$this->companyno"></td>
      </tr>

      <tr>
        <td  class='head'>Tel 1 / Tel 2</td>
        <td class='even'>
            <input maxlength="16" size="16" name="tel_1" value="$this->tel_1"> /
            <input maxlength="16" size="16" name="tel_2" value="$this->tel_2"></td>
        <td class='head'>Fax</td>
        <td class='even'><input maxlength="16" size="16" name="fax" value="$this->fax"></td>
      </tr>

      <tr>
        <td class='head'>Website</td>
        <td class='odd'><input maxlength="100" size="60" name="url" value="$this->url"></td>
	<td class='head'>Email</td>
        <td  class='odd'><input maxlength="100" size="60" name="email" value="$this->email"></td>
      </tr>
     
     <tr>
        <td class='head'>Street 1</td>
        <td class='even'><input maxlength="60" size="60" name="street1" value="$this->street1"></td>
        <td class='head'>Street 2</td>
        <td class='even'><input maxlength="60" size="60" name="street2" value="$this->street2"></td>
     </tr>

     <tr>
        <td class='head'>Street 3</td>
        <td class='odd'><input maxlength="60" size="60" name="street3" value="$this->street3"></td>
        <td class='head'>City / Postcode</td>
        <td class='odd'><input maxlength="30" size="30" name="city" value="$this->city">
	<input maxlength="6" size="6" name="postcode" value="$this->postcode"></td>
     </tr>
            
     <tr>
        <td class='head'>State</td>
        <td class='even'><input maxlength="30" size="30" name="state" value="$this->state"></td>
        <td class='head'>Country</td>
        <td class='even'><select name="country_id" id="country_id">$this->countryctrl</select></td>
     </tr>

     <tr>
        <td class='head'>Currency</td>
        <td class='odd'><select name="currency_id" id="currency_id">$this->currencyctrl</select></td>
        <td class='head'>Seq No</td>
        <td class='odd'><input maxlength="3" size="3" name="seqno" value="$this->seqno"></td>
     </tr>
            
     <tr>
        <td></td>
        <td>$savectrl  <input name="reset" value="Reset" type="button" onclick="resetdata()">
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden">
        </td> </form><td>
        <td> $deletectrl</td>
      </tr>

    </tbody>
  </table>

  <br>



EOF;
  } // end of member function getInputForm

  /**
   *
   * @return bool
   * @access public
   */
  public function updateOrganization( ) {

      $this->log->showLog(3,"Access updateOrganization");
     	$timestamp= date("y/m/d H:i:s", time()) ;
	
        include_once XOOPS_ROOT_PATH."/modules/simantz/class/Save_Data.inc.php";
          $save = new Save_Data();

      $arrfield=array("organization_name","organization_code","tel_1","tel_2","fax","url","email",
	"updated","updatedby","isactive","groupid","currency_id","street1", "street2","street3","postcode","country_id",
	"city","state","seqno","companyno","companyname");
       $arrfieldtype=array("%s","%s","%s","%s","%s","%s","%s",
	"%s","%d","%d","%d","%d","%s", "%s","%s","%s","%d",
	"%s","%s","%d","%s","%s");

    $arrvalue=array($this->organization_name,$this->organization_code,$this->tel_1,$this->tel_2,$this->fax,$this->url,$this->email,
	$timestamp,$this->updatedby,$this->isactive,$this->groupid,$this->currency_id,$this->street1, $this->street2,$this->street3,
            $this->postcode,$this->country_id,$this->city,$this->state,$this->seqno,$this->companyno,$this->companyname);
   

 $controlvalue=$this->organization_code;

 
	if($save->UpdateRecord($this->tableorganization, "organization_id", $this->organization_id,
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue)){
		$this->log->showLog(3, "Update organization successfully.");
		return true;
	}
	else{
		$this->log->showLog(2, "Warning! Update organization failed");
		return false;
	}

  } // end of member function updateOrganization


/**
   *
   * @return int
   * @access public
   */
  public function getLatestOrganizationID() {
	$sql="SELECT MAX(organization_id) as organization_id from $this->tableorganization;";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['organization_id'];
	else
	return -1;
	
  } // end of member function getLatestOrganizationID


  /**
   *
   * @return bool
   * @access public
   */
  public function insertOrganization( ) {

        $this->log->showLog(2,"Access insertOrganization");
     	$timestamp= date("y/m/d H:i:s", time()) ;

        include_once XOOPS_ROOT_PATH."/modules/simantz/class/Save_Data.inc.php";
          $save = new Save_Data();
   $arrfield=array("organization_name","organization_code","street1","street2",
		"street3","postcode","city","state","country_id","tel_1","tel_2","fax",
                 "url","email","isactive", "created","createdby","updated","updatedby",
		"seqno","groupid","currency_id","companyno","companyname");
    $arrfieldtype=array("%s","%s","%s","%s",
		"%s","%s","%s","%s","%d","%s","%s","%s",
                "%s","%s","%d", "%s","%d","%s","%d",
		"%d","%d","%d","%s","%s");
     $arrvalue=array($this->organization_name,$this->organization_code,$this->street1,$this->street2,
		$this->street3,$this->postcode,$this->city,$this->state,$this->country_id,$this->tel_1,$this->tel_2,$this->fax,
                $this->url,$this->email,$this->isactive,$timestamp,$this->createdby,$timestamp,$this->updatedby,
		$this->seqno,$this->groupid,$this->currency_id,$this->companyno,$this->companyname);

 $controlvalue=$this->organization_code;
   if($save->InsertRecord($this->tableorganization, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"organization_id"))
           return true;
   else
        return false;
  
} // end of member function insertOrganization


  public function deleteOrganization( $organization_id ) {
    	$this->log->showLog(2,"Warning: Performing delete organization id : $organization_id !");
         include_once XOOPS_ROOT_PATH."/modules/simantz/class/Save_Data.inc.php";
          $save = new Save_Data();
          $this->fetchOrganization($organization_id);
	if (!$save->DeleteRecord($this->tableorganization,"organization_id",$organization_id,$this->organization_code,1)){
		$this->log->showLog(1,"Error: organization ($organization_id) cannot remove from database:".mysql_error());
		return false;
	}
	else{
		$this->log->showLog(3,"Organization ($organization_id) removed from database successfully!");
		return true;
		
	}
	
  } // end of member function deleteOrganization

  public function getDefaultOrganization( $uid ) {
    	$this->log->showLog(2,"Get Default organization id : $organization_id !");
	 $sql="SELECT organization_id from sim_organization o
		INNER JOIN sim_groups_users_link ug on o.groupid=ug.groupid
		where ug.uid=$uid and o.isactive=1 order by seqno";
	$this->log->showLog(4,"getDefaultOrganization SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	while ($row=$this->xoopsDB->fetchArray($rs)){
		
		return $row['organization_id'];
	}
	//return 1;	
  } // end of member function deleteOrganization

  public function fetchOrganization( $organization_id ) {
	
	$this->log->showLog(3,"Fetching organization detail into class Organization.php.<br>");
		
	 $sql="SELECT o.organization_code,o.organization_name,o.tel_1,o.tel_2,o.fax,o.url,o.email,o.currency_id,
		o.country_id,o.isactive,o.groupid,o.street1,o.street2,o.street3,o.postcode,o.state,o.city,o.seqno,
		o.companyno,o.companyname,ct.country_name,ct.country_code,cr.currency_name,cr.currency_code,ct.telcode
		from $this->tableorganization o
		LEFT JOIN $this->tablecountry ct on o.country_id=ct.country_id
		LEFT JOIN $this->tablecurrency cr on o.currency_id=cr.currency_id
		where o.organization_id=$organization_id";
	
	$this->log->showLog(4,"Organization->fetchOrganization, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_name=$row["organization_name"];
		$this->organization_code=$row["organization_code"];
		$this->tel_1= $row['tel_1'];
		$this->tel_2=$row['tel_2'];
		$this->street2=$row['street2'];
		$this->street3=$row['street3'];
		$this->postcode=$row['postcode'];
		$this->city=$row['city'];
		$this->state=$row['state'];
		$this->street1=$row['street1'];
		$this->fax=$row['fax'];
                $this->accrued_acc=$row['accrued_acc'];
		$this->socso_acc=$row['socso_acc'];
		$this->epf_acc=$row['epf_acc'];
		$this->salary_acc=$row['salary_acc'];

		$this->groupid=$row['groupid'];
		$this->seqno=$row['seqno'];
		$this->url=$row['url'];
		$this->email=$row['email'];
		$this->isactive=$row['isactive'];
		$this->country_id=$row['country_id'];
		$this->country_name=$row['country_name'];
                $this->telcode=$row['telcode'];
                $this->country_code=$row['country_code'];
                $this->companyname=$row['companyname'];
		$this->currency_name=$row['currency_name'];
		$this->companyno=$row['companyno'];
		$this->currency_id=$row['currency_id'];
		$this->currency_code=$row['currency_code'];
	$this->log->showLog(4,"Organization->fetchOrganization,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Organization->fetchOrganization,failed to fetch data into databases:".mysql_error());	
	}
  } // end of member function fetchOrganization

 public function showOrganizationTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing Organization Table");
	$sql=$this->getSQLStr_AllOrganization($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table>
  		<tbody>
    			<tr>
				<td class="searchformheader">No</td>
				<td class="searchformheader">Organization Code</td>
				<td class="searchformheader">Organization Name</td>
				<td class="searchformheader">Company No</td>
				<td class="searchformheader">Website</td>
				<td class="searchformheader">Email</td>
				<td class="searchformheader">Active</td>
				<td class="searchformheader">Operation</td>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$organization_code=$row['organization_code'];
		$organization_name=$row['organization_name'];
		$url=$row['url'];
		$email=$row['email'];
		$companyno=$row['companyno'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		if ($isactive==0)
			$isactive="<b style='color:red'>N</b>";
		else
			$isactive='Y';
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">$organization_name</td>
			<td class="$rowtype" style="text-align:center;">$companyno</td>
			<td class="$rowtype" style="text-align:center;">$url</td>
			<td class="$rowtype" style="text-align:center;">$email</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="organization.php" method="POST">
				<input type="submit" value="Edit" name="submit">
				<input type="hidden" value="$organization_id" name="organization_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }


} // end of Organization
?>
