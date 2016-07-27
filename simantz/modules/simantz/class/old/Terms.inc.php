<?php


class Terms
{

  public $terms_id;
  public $terms_name;
  public $description;
  public $isactive;
  public $daycount;
  public $defaultlevel;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $isdeleted;
  private $xoopsDB;


  private $log;


//constructor
   public function Terms(){
	global $xoopsDB,$log;
  	$this->xoopsDB=$xoopsDB;

	$this->tableterms=$tableterms;
	$this->tablebpartner=$tablebpartner;
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
  public function getInputForm( $type,  $terms_id,$token  ) {

  } // end of member function getInputForm

  /**
   * Update existing terms record
   *
   * @return bool
   * @access public
   */
  public function updateTerms( ) {


  } // end of member function updateTerms

  /**
   * Save new terms into database
   *
   * @return bool
   * @access public
   */
  public function insertTerms( ) {


  } // end of member function insertTerms

  /**
   * Pull data from terms table into class
   *
   * @return bool
   * @access public
   */
  public function fetchTerms( $terms_id) {
	$this->log->showLog(3,"Fetching terms detail into class Terms.php.");
        global $defaultorganization_id;
	$sql="SELECT terms_id,terms_name,daycount,description,isactive,defaultlevel,isdeleted,organization_id
                from sim_terms
			where terms_id=$terms_id and organization_id=$defaultorganization_id";
	$this->log->showLog(4,"Terms->fetchTerms, before execute:" . $sql . "<br>");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$this->terms_name=$row["terms_name"];
                $this->daycount=$row['daycount'];
		$this->description=$row["description"];
		$this->defaultlevel= $row['defaultlevel'];
                $this->isdeleted=$row['isdeleted'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Terms->fetchTerms,database fetch into class successfully");
	$this->log->showLog(4,"terms_name:$this->terms_name");
		return true;
	}
	$this->log->showLog(4,"Terms->fetchTerms,failed to fetch data into databases:" . mysql_error());
	
		return false;
	
  } // end of member function fetchTerms

  public function deleteTerms( $terms_id ) {
  } // end of member function deleteTerms
  public function getSQLStr_AllTerms( $wherestring,  $orderbystring) {
  } // end of member function getSQLStr_AllTerms

 public function showTermsTable($wherestring,$orderbystring){
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestTermsID() {
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
    <form name="frmTerms">
    <table>
        <tr><th colspan="4">Search Terms</th></tr>
        <tr>
            <td class="fieldtitle">Terms Name</td>
            <td class="field"><input name="searchterms_name" id="searchterms_name"></td>
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

} // end of ClassTerms
?>
