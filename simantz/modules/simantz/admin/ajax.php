<?php
include_once ('../../../mainfile.php');
include_once (XOOPS_ROOT_PATH.'/header.php');

$action=$_POST['action'];

if($action == 'ajaxgetWindow')
{    
    echo "<OPTION value='0' SELECTED='SELECTED'>Null</OPTION>\n";
    $mid = $_POST['mid'];

    $sql="SELECT window_id,window_name,table_name from sim_window where isactive='1' and mid='$mid' and parentwindows_id>0 and table_name!='' order by window_name";

    $query=$xoopsDB->query($sql);
    while($row=$xoopsDB->fetchArray($query)){
		$table_name=$row['table_name'];
		$window_name=$row['window_name'];

		echo "<OPTION value=$table_name>$window_name</OPTION>\n";

	}

}
?>
