<?php


class BPartnerGroup
{

  public $bpartnergroup_id;
  public $bpartnergroup_name;
  public $description;
  public $debtoraccounts_id;
  public $creditoraccounts_id;
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
   public function BPartnerGroup(){
	global $xoopsDB,$log;
  	$this->xoopsDB=$xoopsDB;

	$this->tablebpartnergroup=$tablebpartnergroup;
	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int bpartnergroup_id
   * @return
   * @access public
   */
  public function getInputForm( $type,  $bpartnergroup_id,$token  ) {

  } // end of member function getInputForm

  /**
   * Update existing bpartnergroup record
   *
   * @return bool
   * @access public
   */
  public function updateBPartnerGroup( ) {


  } // end of member function updateBPartnerGroup

  /**
   * Save new bpartnergroup into database
   *
   * @return bool
   * @access public
   */
  public function insertBPartnerGroup( ) {


  } // end of member function insertBPartnerGroup

  /**
   * Pull data from bpartnergroup table into class
   *
   * @return bool
   * @access public
   */
  public function fetchBPartnerGroup( $bpartnergroup_id) {
	$this->log->showLog(3,"Fetching bpartnergroup detail into class BPartnerGroup.php.");
        global $defaultorganization_id;
	$sql="SELECT bpartnergroup_id,bpartnergroup_name,description,isactive,defaultlevel,isdeleted,
            organization_id,debtoraccounts_id,creditoraccounts_id
                from sim_bpartnergroup
			where bpartnergroup_id=$bpartnergroup_id and organization_id=$defaultorganization_id";
	$this->log->showLog(4,"BPartnerGroup->fetchBPartnerGroup, before execute:" . $sql . "<br>");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$this->bpartnergroup_name=$row["bpartnergroup_name"];
                $this->debtoraccounts_id=$row['debtoraccounts_id'];
                $this->creditoraccounts_id=$row['creditoraccounts_id'];
		$this->description=$row["description"];
		$this->defaultlevel= $row['defaultlevel'];
                $this->isdeleted=$row['isdeleted'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"BPartnerGroup->fetchBPartnerGroup,database fetch into class successfully");
	$this->log->showLog(4,"bpartnergroup_name:$this->bpartnergroup_name");
		return true;
	}
	$this->log->showLog(4,"BPartnerGroup->fetchBPartnerGroup,failed to fetch data into databases:" . mysql_error());
	
		return false;
	
  } // end of member function fetchBPartnerGroup

  public function deleteBPartnerGroup( $bpartnergroup_id ) {
  } // end of member function deleteBPartnerGroup
  public function getSQLStr_AllBPartnerGroup( $wherestring,  $orderbystring) {
  } // end of member function getSQLStr_AllBPartnerGroup

 public function showBPartnerGroupTable($wherestring,$orderbystring){
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestBPartnerGroupID() {
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
    <form name="frmBPartnerGroup">
    <table>
        <tr><th colspan="4">Search BPartnerGroup</th></tr>
        <tr>
            <td class="fieldtitle">BPartnerGroup Name</td>
            <td class="field"><input name="searchbpartnergroup_name" id="searchbpartnergroup_name"></td>
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

} // end of ClassBPartnerGroup
?>
