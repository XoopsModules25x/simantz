<?php

include_once "mainfile.php";

$field_name = $_REQUEST['field_name'];
$tablename = $_REQUEST['tablename'];
$field_value = $_REQUEST['field_value'];
$primarykey_name = $_REQUEST['primarykey_name'];
$primarykey_value = $_REQUEST['primarykey_value'];

if($field_value != ""){

        $sql= sprintf("SELECT %s as version_fld FROM %s where %s='%d' ",$field_name,$tablename,$primarykey_name,$primarykey_value);

        $version_fld = "";
        
	$query=$xoopsDB->query($sql);

        if($row=$xoopsDB->fetchArray($query)){
        $version_fld = $row['version_fld'];
        }

        $status = "ko";
        if($version_fld == $field_value)
        $status = "ok";

        $arr = array("version_fld"=>$version_fld,"status"=>$status);
        echo json_encode($arr);
}
?>