<?php

/**
 * class ProductWindow
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Window
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $window_id;
  public $window_name;
  public $table_name;
  public $parentwindows_id;
  public $filename;
  public $isactive;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $helpurl;
  public $updatedby;
  public $windowsetting;
  public $description;
  public $modulectrl;
  public $mid;
  private $xoopsDB;
  private $log;
  private $arrUpdateField;
  private $arrInsertField;
  private $tablename;
//constructor
   public function Window(){
	global $path,$tableprefix,$tablewindow,$tablemodules,$log,$xoopsDB;
        $this->arrUpdateField=array("mid","windowsetting","seqno","description","parentwindows_id","filename","isactive",
                    "window_name","updated","updatedby","table_name","helpurl");
        $this->arrInsertField=array("mid","windowsetting","seqno","description","parentwindows_id","filename","isactive",
                    "window_name","created","createdby","updated","updatedby","table_name","helpurl");
        $this->arrInsertFieldType=array("%d","%s","%d","%s","%d","%s","%d",
                    "%s","%s","%d","%s","%d","%s","%s");
        $this->arrUpdateFieldType=array("%d","%s","%d","%s","%d","%s","%d",
                    "%s","%s","%d","%s","%s");
        $this->tablename="sim_window";
	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
   }

  public function fetchWindow( $window_id) {

	$this->log->showLog(3,"Fetching window detail into class Window.php.<br>");

	$sql="SELECT * from $this->tablename where window_id=$window_id ";

	$this->log->showLog(4,"ProductWindow->fetchWindow, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
                $this->window_id=$row['window_id'];
		$this->filename=$row["filename"];
		$this->window_name=$row["window_name"];
		$this->table_name=$row["table_name"];
		$this->description= $row['description'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];
		$this->helpurl=$row['helpurl'];
                $this->mid=$row['mid'];
                $this->parentwindows_id=$row['parentwindows_id'];
               $this->windowsetting=$row['windowsetting'];
   	$this->log->showLog(4,"Window->fetchWindow,database fetch into class successfully");
	$this->log->showLog(4,"window_name:$this->window_name");
	$this->log->showLog(4,"functiontype:$this->functiontype");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Window->fetchWindow,failed to fetch data into databases.");
	}
  } // end of member function fetchWindow


   public function allowDelete($id){
       $this->log->showLog(2,"Call function allowDelete($id)");
       $this->log->showLog(3,"return true");

       return true;
   }


   public function showParentWindowsTree($module_id){

       return $this->showChildWindowsTree($module_id,0,0);

   }
   public function showChildWindowsTree($module_id,$parent_id,$level){

       $result="";
       if($module_id==0)
           return $result;
       $sql = sprintf("SELECT window_id,filename, isactive,window_name,parentwindows_id,
                        windowsetting,description,isdeleted,seqno,table_name
                        FROM sim_window WHERE mid = %d and parentwindows_id=%d
                        order by seqno
                        ", $module_id,$parent_id);

   $query = $this->xoopsDB->query($sql);
    while ($row =$this->xoopsDB->fetchArray($query)) {

   		$children++;
                $window_id=$row['window_id'];

                $table_name=$row['table_name'];
                $filename=$row['filename'];
                $window_name=$row['window_name'];
                if($row['isactive']==1)
                     $inactivetext="";
                else
                     $inactivetext="[Hidden]";
    $hyperlink="&nbsp;&nbsp;&nbsp;".
                "<a href='javascript:showWindowsForm($window_id)' title='View Window' >$window_name &nbsp;</a>&nbsp;<b style='color:red'>$inactivetext</b>&nbsp;&nbsp;
	<a style='color:black' href=javascript:addChildren($window_id,$module_id)>[+]</a>";
    $result.= "<li id='$list_id' style='list-style: none;'>";
	for($j=0;$j<$level;$j++)
            $result.= "&nbsp;&nbsp;&nbsp;&nbsp;";

    $result.=$hyperlink;
       // call this function again to display this child's children
       $result.=$this->showChildWindowsTree($module_id,$window_id, $level+1,$result);
   }
   return $result;

   }

   public function showSearchForm(){



  echo <<< EOF
    <form name="frmWindow">
    <table>
        <tr><th colspan="4">Search Window</th></tr>
        <tr>
            <td class="fieldtitle">Module</td>
            <td class="field"><select name="findmodule_id" id="findmodule_id" onchange=submit.click()>$this->modulectrl</select><input name="submit" value="Search" type="submit" onclick="search()"></td>
        </tr>

</table>
</form>
EOF;
}

public function getInputForm($module_id){

    $optionlist=$this->getSelectWindows(0,$module_id,"Y");
    return "
        <A href=javascript:addNew()>[Add New]</a><br/>
    <form id='frmwindow' onsubmit='return false'>
        <table>

            <tr><td class='head'>Windows Name</td>
                    <td class='even'><input id='window_name' name='window_name'></td></tr>
            <tr><td class='head'>File Name</td>
                    <td class='even'><input id='filename'  name='filename'></td></tr>
            <tr><td class='head'>Table Name</td>
                    <td class='even'><input id='table_name' name='table_name'></td></tr>
            <tr><td class='head'>Seq No</td>
                    <td class='even'><input id='seqno' value='10'></td></tr>
            <tr><td class='head'>Setting</td>
                    <td class='even'><textarea id='windowsetting'  name='windowsetting' rows='5' cols='50'></textarea></td></tr>
            <tr><td class='head'>Description</td>
                            <td class='even'><textarea name='description' id='description' rows='5' cols='50'></textarea></td></tr>
            <tr><td class='head'>Parent Window</td>
                            <td class='even'>
                                <select id='parentwindows_id' name='parentwindows_id' onfocus=refreshparentwindowslist($module_id,this.value)>
                                        $optionlist
                                </select>
                            </td></tr>

            <tr><td class='head'>Display</td>
                            <td class='even'><input type='checkbox' id='isactive' name='isactive'  checked></td></tr>
            <tr><td class='head'>Help URL</td>
                            <td class='even'><input name='helpurl' size='70' id='helpurl'></td></tr>
             <tr><td><input id='window_id' name='window_id' title='window_id'  type='hidden'>
                    <input id='mid' name='mid'  title='mid' value='$module_id' type='hidden'>
                        </td>
             </tr>
        </table>

        <input name='action'  type='hidden' id='action' value='ajaxsave'>
        <input name='save' onclick='saverecord()' type='submit' value='Save'>
        <input name='save' onclick='deleterecord()' type='button' value='Delete'>
        </form>
";
}

public function returnWindowXML(){
header("Content-Type: text/xml");
$this->helpurl=str_replace("&", "&#38;",$this->helpurl);
    echo <<< EOF
<?xml version="1.0" encoding="utf-8" ?>
<Result>
<Window id="w_$this->window_id">
    <window_id >$this->window_id</window_id>
    <filename>$this->filename</filename>
    <table_name>$this->table_name</table_name>
    <isactive>$this->isactive</isactive>
    <window_name>$this->window_name</window_name>
    <parentwindow_id>$this->parentwindows_id</parentwindow_id>
    <seqno>$this->seqno</seqno>
    <description>$this->description</description>
    <windowsetting>$this->windowsetting</windowsetting>
    <helpurl>$this->helpurl</helpurl>
    <mid>$this->mid</mid>
</Window>
</Result>
EOF;
}

public function insertWindow(){
        include "../class/Save_Data.inc.php";
    $save = new Save_Data();
    $arrvalue=array($this->mid,$this->windowsetting,$this->seqno,$this->description,
                    $this->parentwindows_id,$this->filename,$this->isactive,
                    $this->window_name,$this->updated,$this->updatedby,
                    $this->updated,$this->updatedby,$this->table_name,$this->helpurl);
    $save->InsertRecord($this->tablename,   $this->arrInsertField,
            $arrvalue,$this->arrInsertFieldType,$this->window_name,"window_id");

  }

  public function updateWindow(){
    include "../class/Save_Data.inc.php";
    $save = new Save_Data();
    $arrvalue=array($this->mid,$this->windowsetting,$this->seqno,$this->description,
                    $this->parentwindows_id,$this->filename,$this->isactive,
                    $this->window_name,$this->updated,$this->updatedby,$this->table_name,$this->helpurl);
    return $save->UpdateRecord($this->tablename, "window_id",
                $this->window_id,
                    $this->arrUpdateField, $arrvalue,  $this->arrUpdateFieldType,$this->window_name);


}

public function deleteWindow($window_id){
    include "../class/Save_Data.inc.php";
    $save = new Save_Data();
    $this->fetchWindow($window_id);
    return $save->DeleteRecord($this->tablename,"window_id",$window_id,$this->window_name,1);

}

public function getSelectWindows($id,$mid,$showNull="N"){
    $sql="SELECT * FROM $this->tablename w where mid=$mid and (isactive=1 or window_id=$id or window_id=0) order by seqno";
    $query=$this->xoopsDB->query($sql);
    $result="";
     if($showNull=="Y")
    $result.="<option value='0' >Null</option>";

    while($row=$this->xoopsDB->fetchArray($query)){

    $window_id=$row['window_id'];
    $window_name=$row['window_name'];
    $selected="";

    if($id==$window_id)
        $selected="SELECTED='SELECTED'";
    $result.="<option value='$window_id' $selected>$window_name</option>";

    }
    return $result;
}
} // end of ClassWindow
