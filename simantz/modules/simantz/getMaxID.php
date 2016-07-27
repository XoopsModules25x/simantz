<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
	include_once ('../../mainfile.php');
	include_once (XOOPS_ROOT_PATH.'/header.php');
$tablename=$_GET['tablename'];
$idname=$_GET['idname'];

switch($tablename){
case "sim_groups";
  echo getMaxId($idname,$tablename,"");
break;
case "";
break;
case "";
break;
default:
break;
}


function getMaxId($idname,$tablename,$wherestr){
    global $xoopsDB;

 $sql="SELECT max(" . $idname . ") as id FROM " . $tablename . "  " . $wherestr;
$query=$xoopsDB->query($sql);

while($row=$xoopsDB->fetchArray($query)){
 return $row['id'];
}
}
?>