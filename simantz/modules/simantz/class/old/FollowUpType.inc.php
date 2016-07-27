<?php


class FollowUpType
{

  public $followuptype_id;
  public $followuptype_name;
  public $description;
  public $isactive;
  public $defaultlevel;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $isdeleted;
  private $xoopsDB;


  private $log;


//constructor
   public function FollowUpType(){
	global $xoopsDB,$log;
  	$this->xoopsDB=$xoopsDB;

	$this->tablefollowuptype=$tablefollowuptype;
	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int followuptype_id
   * @return
   * @access public
   */
  public function getInputForm( $type,  $followuptype_id,$token  ) {

  } // end of member function getInputForm

  /**
   * Update existing followuptype record
   *
   * @return bool
   * @access public
   */
  public function updateFollowUpType( ) {


  } // end of member function updateFollowUpType

  /**
   * Save new followuptype into database
   *
   * @return bool
   * @access public
   */
  public function insertFollowUpType( ) {


  } // end of member function insertFollowUpType

  /**
   * Pull data from followuptype table into class
   *
   * @return bool
   * @access public
   */
  public function fetchFollowUpType( $followuptype_id) {
	$this->log->showLog(3,"Fetching followuptype detail into class FollowUpType.php.");
        global $defaultorganization_id;
	$sql="SELECT followuptype_id,followuptype_name,description,isactive,defaultlevel,isdeleted,
            organization_id
                from sim_followuptype
			where followuptype_id=$followuptype_id and organization_id=$defaultorganization_id";
	$this->log->showLog(4,"FollowUpType->fetchFollowUpType, before execute:" . $sql . "<br>");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$this->followuptype_name=$row["followuptype_name"];
		$this->description=$row["description"];
		$this->defaultlevel= $row['defaultlevel'];
                $this->isdeleted=$row['isdeleted'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"FollowUpType->fetchFollowUpType,database fetch into class successfully");
	$this->log->showLog(4,"followuptype_name:$this->followuptype_name");
		return true;
	}
	$this->log->showLog(4,"FollowUpType->fetchFollowUpType,failed to fetch data into databases:" . mysql_error());
	
		return false;
	
  } // end of member function fetchFollowUpType

  public function deleteFollowUpType( $followuptype_id ) {
  } // end of member function deleteFollowUpType
  public function getSQLStr_AllFollowUpType( $wherestring,  $orderbystring) {
  } // end of member function getSQLStr_AllFollowUpType

 public function showFollowUpTypeTable($wherestring,$orderbystring){
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestFollowUpTypeID() {
  } // end



    public function allowDelete($id){
       $this->log->showLog(2,"Call function allowDelete($id)");
        $this->log->showLog(3,"return true");
       return true;
   }


  public function showSearchForm(){

  global $isadmin;

  if($isadmin==1)
  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\">".
        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";

  echo <<< EOF
    <form name="frmFollowUpType">
    <table>
        <tr><th colspan="4">Search FollowUpType</th></tr>
        <tr>
            <td class="fieldtitle">FollowUpType Name</td>
            <td class="field"><input name="searchfollowuptype_name" id="searchfollowuptype_name"></td>
            <td class="fieldtitle">Active</td>
            <td class="field">
                <select name="searchisactive" id="searchisactive">
                    <option value="-">Null</option>
                    <option value="1" SELECTED="SELECTED">Yes</option>
                    <option value="0">No</option>
                </select>
                </td>
        </tr>
        <tr><td><input name="submit" value="Search" type="button" onclick="search()">$showdeleted </td></tr>
    </table>
EOF;
}

} // end of ClassFollowUpType
?>
