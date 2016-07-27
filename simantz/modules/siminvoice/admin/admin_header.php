<?php
//  ------------------------------------------------------------------------ 	//
//                XOOPS - PHP Content Management System    				//
//                    Copyright (c) 2004 XOOPS.org                       	//
//                       <http://www.xoops.org/>                              //
//                   										//
//                  Authors :									//
//						- solo (www.wolfpackclan.com)         	//
//						- christian (www.edom.org)		 	//
//						- herve (www.herve-thouzard.com)   		//
//                  edito v2.2								//
//  ------------------------------------------------------------------------ 	//
function quoteHandling($text){
return $text;
//return str_replace("'","\'",$text);
}

include_once("../../../mainfile.php");
include_once XOOPS_ROOT_PATH . "/include/cp_header.php";
include_once XOOPS_ROOT_PATH."/class/xoopsmodule.php";
include_once XOOPS_ROOT_PATH."/class/xoopstree.php";
include_once XOOPS_ROOT_PATH."/class/xoopslists.php";
include_once XOOPS_ROOT_PATH."/include/xoopscodes.php";
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH."/class/module.errorhandler.php";
$tableprefix= XOOPS_DB_PREFIX . "_";
$tableuser= $tableprefix . "users";
$rowperpage=50;
$thstyle="style='text-align: center;' " ;
$tdstyle[0]="class='even' style='text-align:center;' ";
$tdstyle[1]="class='odd' style='text-align:center;'";
$eh = new ErrorHandler;

if ( is_object($xoopsUser))
	{
	$xoopsModule = XoopsModule::getByDirname("simtrain");
	if ( !$xoopsUser->isAdmin($xoopsModule->mid()) )
		{
		redirect_header(XOOPS_URL."/",1,_NOPERM);
		exit();
		}
	}
else
	{
	redirect_header(XOOPS_URL."/",1,_NOPERM);
	exit();
	}
$myts =& MyTextSanitizer::getInstance();




?>
