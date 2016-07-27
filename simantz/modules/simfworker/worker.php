<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Worker.php';
include_once 'class/WorkerCompany.php';
include_once 'class/Nationality.php';
include_once 'class/Races.php';
include_once "menu.php";
include_once "class/LoanPayment.php";
require "datepicker/class.datepicker.php";
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();

$o = new Worker($xoopsDB,$tableprefix,$log);
$wc = new WorkerCompany($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$r = new Races($xoopsDB,$tableprefix,$log);
$n = new Nationality($xoopsDB,$tableprefix,$log);
$l = new LoanPayment($xoopsDB,$tableprefix,$log);

$o->showddateofbirthctrl=$dp->show("dateofbirth");
$o->showarrivaldatectrl=$dp->show("arrivaldate");
$o->showdeparturedatectrl=$dp->show("departuredate");

$action="";

echo <<< EOF
<script type="text/javascript">
	function validateWorker(){
		var name=document.forms['frmWorker'].worker_name.value;
		if(confirm("Confirm to save the data?")==true){
		if(name =="" ){
			alert('Please make sure worker name is filled in.');
			return false;
		}
		else
			return true;
		}
		else
			return false;
	}
</script>

EOF;

$o->worker_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->worker_id=$_POST["worker_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->worker_id=$_GET["worker_id"];

}
else
$action="";

$token=$_POST['token'];

//================
$o->worker_no=$_POST['worker_no'];
$o->worker_code=$_POST['worker_code'];
$o->worker_name=$_POST['worker_name'];
$o->dateofbirth=$_POST['dateofbirth'];
$o->ic_no=$_POST['ic_no'];
$o->gender=$_POST['gender'];
$o->races_id=$_POST['races_id'];
$o->nationality_id=$_POST['nationality_id'];
$o->workerstatus=$_POST['workerstatus'];
$o->passport_no=$_POST['passport_no'];
$o->home_street1=$_POST['home_street1'];
$o->home_street2=$_POST['home_street2'];
$o->home_postcode=$_POST['home_postcode'];
$o->home_city=$_POST['home_city'];
$o->home_state=$_POST['home_state'];
$o->home_country=$_POST['home_country'];
$o->email=$_POST['email'];
$o->home_tel1=$_POST['home_tel1'];
$o->home_tel2=$_POST['home_tel2'];
$o->handphone=$_POST['handphone'];
$o->maritalstatus=$_POST['maritalstatus'];
$o->family_contactname=$_POST['family_contactname'];
$o->family_contactno=$_POST['family_contactno'];
$o->relationship=$_POST['relationship'];
$o->skill=$_POST['skill'];
$o->educationlevel=$_POST['educationlevel'];
$o->bank_name=$_POST['bank_name'];
$o->bank_acc=$_POST['bank_acc'];
$o->bankacc_type=$_POST['bankacc_type'];
$o->description=$_POST['description'];
$o->arrivaldate=$_POST['arrivaldate'];
$o->departuredate=$_POST['departuredate'];
$o->workerstatus=$_POST['workerstatus'];
$o->isactive=$_POST['isactive'];
$filterstring=$_GET['filterstring'];
//$o->racesctrl=$r->getSelectRaces($o->races_id);
//$o->nationalityctrl=$n->getSelectNationality($o->nationality_id);
$phototmpfile= $_FILES["workerphoto"]["tmp_name"];
$photofilesize=$_FILES["workerphoto"]["size"] / 1024;
$photofiletype=$_FILES["workerphoto"]["type"];
$o->removepic=$_POST['removepic'];
$passporttmpfile= $_FILES["passportphoto"]["tmp_name"];
$passportfilesize=$_FILES["passportphoto"]["size"] / 1024;
$passportfiletype=$_FILES["passportphoto"]["type"];
$o->removepassport=$_POST['removepassport'];
//==================


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


if ( $o->isactive=="on")
	$o->isactive=1;
elseif($o->isactive=='' || $o->isactive=='off')
	$o->isactive=0;

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Worker Master Data</span></big></big></big></div><br>
EOF;
$filterstring=$o->searchAToZ();
if($_GET['filterstring']!="")
$filterstring=$_GET['filterstring'];

 switch ($action){

	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with Worker name=$o->Worker_name");

	if ($s->check(false,$token,"CREATE_WKR")){
		
	if($o->insertWorker()){
		 $latest_id=$o->getLatestWorkerID();
			 redirect_header("worker.php?action=edit&worker_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create Worker!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_WKR");
		$o->getInputForm("new",-1,$token);
		$o->showWorkerTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchWorker($o->worker_id)){
		$o->racesctrl=$r->getSelectRaces($o->races_id);
		$o->nationalityctrl=$n->getSelectNationality($o->nationality_id);
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_WKR"); 
		$o->getInputForm("edit",$o->worker_id,$token);
		$wc->worker_id=$o->worker_id;
		$wc->showWorkerEmploymentTable("WHERE w.worker_id=$o->worker_id",
				'ORDER BY wc.joindate',0,99999);
		$l->worker_id=$o->worker_id;
		$l->showLoanPaymentTable("WHERE m.worker_id=$o->worker_id","ORDER BY m.loanpayment_date asc",0,9999);
		/*echo <<< EOF
	EOF;*/
		//$o->showWorkerTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("worker.php",3,"Some error on viewing your Worker data, probably database corrupted");
  
break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_WKR")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$log->showLog(4,"$photofilesize,$photofiletype");
		if($o->updateWorker()) {//if data save successfully

			if($o->removepic=='on')
				$o->deletephoto($o->worker_id);
			if($o->removepassport=='on')
				$o->deletepassport($o->worker_id);

			if(($photofilesize>0 && $photofilesize<100) && $photofiletype=='image/jpeg')
				$o->savephoto($phototmpfile);
			else
				$uploaderror="<b style='color: red'>Failed to upload photo, propbably you didn't upload any photo or photo size bigger than 100kb.<br></b>";

			if(($passportfilesize>0 && $passportfilesize<100) && $passportfiletype=='image/jpeg')
				$o->savepassport($passporttmpfile);
			else
				$uploaderror=$uploaderror."<b style='color: red'>Failed to upload passport file, probably you didn't upload any file or file size bigger than 100kb.</b>";


			redirect_header("worker.php?action=edit&worker_id=$o->worker_id",$pausetime,"Your form is saved.<br> $uploaderror");

		}
		else
			redirect_header("worker.php?action=edit&worker_id=$o->worker_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.$uploaderror");
		}
	else{
		redirect_header("worker.php?action=edit&worker_id=$o->Worker_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  case "delete" :
	if ($s->check(false,$token,"CREATE_WKR")){
		if($o->deleteWorker($o->worker_id))
			redirect_header("worker.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("worker.php?action=edit&worker_id=$o->worker_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("worker.php?action=edit&worker_id=$o->worker_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "showSerchForm":
	$o->racesctrl=$r->getSelectRaces(-1);
	$o->nationalityctrl=$n->getSelectNationality(-1);
	$o->workerctrl=$o->getSelectWorker(-1);
	$o->showSearchForm();
	$o->showWorkerTable(" WHERE w.isactive='1' ", "ORDER BY w.worker_name",0,50);
  break;
  case "search":
	//if ($o->races_id==0)
	$o->racesctrl=$r->getSelectRaces(-1);
	//else
//	$o->racesctrl=$r->getSelectRaces($o->races_id);
//	if($o->nationality_id==0)
	$o->nationalityctrl=$n->getSelectNationality(-1);
//	else
//	$o->nationalityctrl=$n->getSelectNationality($o->nationality_id);
//	if($o->worker_id==0)
	$o->workerctrl=$o->getSelectWorker(-1);

//	else
//	$o->workerctrl=$o->getSelectWorker($o->worker_id);
	$log->showLog(4,"Filterstring=$o->worker_id,$o->worker_code,$o->worker_name,$o->ic_no,$o->passport_no,$o->workerstatus,
				$o->races_id,$o->nationality_id,$o->dateofbirth,$o->isactive");
	$wherestring=$o->convertSearchString($o->worker_id,$o->worker_code,$o->worker_name,$o->ic_no,$o->passport_no,
			$o->workerstatus,$o->races_id,$o->nationality_id,$o->dateofbirth,$o->isactive);
	
	$o->showSearchForm();
	$o->showWorkerTable("$wherestring", "ORDER BY w.worker_name",0,99999);
  break;
  case "new":
	$token=$s->createToken($tokenlife,"CREATE_WKR");
	$o->racesctrl=$r->getSelectRaces(0);
	$o->nationalityctrl=$n->getSelectNationality(0);
	$o->workerctrl=$o->getSelectWorker(0);
	

	$o->getInputForm("new",0,$token);

	//if ($filterstring=="")
	//	$filterstring="A";
	//$o->showWorkerTable(" WHERE w.worker_name LIKE '$filterstring%' AND w.isactive='1' ", "ORDER BY w.worker_name",0,99999);

  break;
  default :
	//$token=$s->createToken(120,"CREATE_WKR");
//	$o->racesctrl=$r->getSelectRaces(0);
//	$o->nationalityctrl=$n->getSelectNationality(0);
//	$o->workerctrl=$o->getSelectWorker(0);
//	$o->getInputForm("new",0,$token);

	if ($filterstring=="")
		$filterstring="A";
	$o->showWorkerTable(" WHERE w.worker_name LIKE '$filterstring%' AND w.isactive='1' ", "ORDER BY w.worker_name",0,99999);

  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');


?>
