<?php
	include_once "system.php";
	include_once ('../../mainfile.php');
	include_once (XOOPS_ROOT_PATH.'/header.php');
	include_once 'class/Log.php';
	//include_once 'class/Permission.php';
	//include_once 'class/Organization.php';
	
	//include_once $_SERVER['DOCUMENT_ROOT']."simbiz/modules/simbiz/system.php";
	//include_once $_SERVER['DOCUMENT_ROOT']."simbiz/mainfile.php";
	//include_once $_SERVER['DOCUMENT_ROOT']."simbiz/header.php";
	//include_once $_SERVER['DOCUMENT_ROOT']."simbiz/modules/simbiz/exporttransaction.php";

	
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	$log = new Log();


	function createTransaction($account_id_arr,$amount_arr,$date_arr,$document_no1_arr,$document_no2_arr,
					$bacth_no_arr,$batch_name_arr,$type_arr,$systemname_arr){
	global $tablecountry;
	
	$tableprefix = "sim_";
	$tablebatch = $tableprefix."simbiz_batch";
	$tabletransaction = $tableprefix."simbiz_transaction";

	$i = 0;
	$batch_group = "";
	foreach($account_id_arr as $id){
	$i++;

	$account_id = $account_id_arr[$i];
	$amount = $amount_arr[$i];
	$date = $date_arr[$i];
	$document_no1 = $document_no1_arr[$i];
	$document_no2 = $document_no2_arr[$i];
	$bacth_no = $bacth_no_arr[$i];
	$batch_name = $batch_name_arr[$i];
	$type = $type_arr[$i];
	$systemname = $systemname_arr[$i];

	if($batch_group != $bacth_no){//insert batch 
	$batch_group = $bacth_no;
	
	$sqlinsert = "insert into $tablebatch () values () ";
	$sqltrans = "insert into $tabletransaction () values () ";

	}else{

	$sqltrans = "insert into $tabletransaction () values () ";

	}
	

	}

	}

?>