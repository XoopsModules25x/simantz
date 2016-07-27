<?php

require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
include_once "class/nitobi.xml.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$id=$_GET['id'];
$xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
$url=XOOPS_URL;
echo <<< EOF
<link rel="stylesheet" href="$url/modules/simantz/include/nitobi/nitobi.tree/nitobi.tree.css" type="text/css" />
<script type="text/javascript" src="$url/modules/simantz/include/nitobi/nitobi.toolkit.js"></script>
<script type="text/javascript" src="$url/modules/simantz/include/nitobi/nitobi.tree/nitobi.tree.js"></script>
<ntb:tree id="tree1" theme="folders" gethandler="tree_handle.php?treeId=tree1&id=$id"></ntb:tree>


  <script language="javascript" type="text/javascript">
 function init(){
      nitobi.loadComponent("tree1");
 }

</script>
EOF;

//0197760680 kstan http://www.simit.com.my

require(XOOPS_ROOT_PATH.'/footer.php');
?>