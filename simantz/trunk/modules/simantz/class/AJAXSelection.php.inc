<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AJAXSelection
 *
 * @author kstan
 */
class AJAXSelection {
    private $xoopsDB;
    private $defaultorganization_id;
    private $log;
    public function AJAXSelection(){
        global $defaultorganization_id,$xoopsDB,$log;
        $this->xoopsDB=$xoopsDB;
        $this->defaultorganization_id=$defaultorganization_id;
        $this->log=$log;
    }
    public function getSelectDBAjax($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name from $table a
		where $primary_name like '%$strchar%' and $primary_key > 0 $wherestr
		$limit";

	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	$rowtypes="";
	$i=0;
	$retval .= "<table><tr><th>List</th></tr>";
	while ($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$fld_name = $row['fld_name'];
	$fld_id = $row['fld_id'];

	if($rowtypes=="even")
	$rowtypes = "odd";
	else
	$rowtypes = "even";

	$idtr = $idinput.$i;

	$onchangefunction = "";
	if($ocf==1){
		if($primary_key == "bpartner_id"){
		$onchangefunction = "getBPInfo($fld_id)";
                $jumpctrl="<A href='../system/bpartner.php?$primary_key=$fld_id&action=view' target='_blank'>(?)</a>";
                 }
		else if($primary_key == "product_id"){
		$onchangefunction = "getProductInfo($fld_id,$line)";
                 $jumpctrl="<A href='product.php?$primary_key=$fld_id&action=view' target='_blank'>(?)</a>";
                }
                else if($primary_key == "location_id"){
		$onchangefunction = "getLocationInfo($fld_id,$line)";
                 $jumpctrl='';

                }
                else if($primary_key == "accounts_id"){

                echo $ctrlid;
		$onchangefunction = "onChangeAccount($fld_id,$line,".'\\"'.$ctrlid.'\\")';
                 $jumpctrl="<A href='../simbiz/accounts.php?$primary_key=$fld_id&action=edit' target='_blank'>(?)</a>";

                }
	}

	$retval .= "<tr  class='$rowtypes' onmouseover=onmover('idTRLine$idtr') onmouseout=onmout('idTRLine$idtr','$rowtypes') id='idTRLine$idtr' onclick=selectList('$fld_id','$idinput','$idlayer','$ctrlid','$onchangefunction');  style='cursor:pointer'>";
	$retval .= "<td>$fld_name $jumpctrl</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
 	}
    //put your code here
}
?>
