<?php
include "system.php";
include "menu.php";
include_once 'class/Log.php';
include_once 'class/FinancialYear.php';
include_once 'class/FinancialYearLine.php';
include_once 'class/SelectCtrl.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$o = new FinancialYear();
$l = new FinancialYearLine();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$orgctrl="";

//marhan add here --> ajax
echo "<iframe src='financialyear.php' name='nameValidate' id='idValidate' style='display:none' width='100%' height='260px'></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////
$action="";

echo <<< EOF
<script type="text/javascript">
function autofocus(){
document.forms['frmFinancialYear'].financialyear_name.focus();
}

	function validateFinancialYear(){
		
		var name=document.forms['frmFinancialYear'].financialyear_name.value;
		var description=document.forms['frmFinancialYear'].description.value;

		var defaultlevel=document.forms['frmFinancialYear'].defaultlevel.value;
	
		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" || description == ""){
			alert('Please make sure name & description is filled in, Default Level is filled with numeric value');
			return false;
		}
		else
			return true;
		}
		else
			return false;
	}

	function closePeriod(period_id,value,financialyearline_id){

	//alert(value);
	var arr_fld=new Array("action","period_id","isclose","financialyearline_id");//name for POST
	var arr_val=new Array("closeperiod",period_id,value,financialyearline_id);//value for POST
	
	getRequest(arr_fld,arr_val);


	}

        function postRetainEarning(period_id,amt,financialyearline_id,period_name,ctrl){
        if(confirm("Post retain earning?")){
        var arr_fld= new Array("action","period_id","amt","financialyearline_id","period_name");
        var arr_val=new Array("postretainearning",period_id,amt,financialyearline_id,period_name);
        getRequest(arr_fld,arr_val);
        }
        ctrl.style.display="";
        }

  function rePostRetainEarning(batch_id,newamt,financialyearline_id,batchno){
        if(confirm("Re-Post retain earning?")){
        var arr_fld= new Array("action","batch_id","newamt","financialyearline_id","batchno");
        var arr_val=new Array("repost",batch_id,newamt,financialyearline_id,batchno);
        getRequest(arr_fld,arr_val);
        }
        }


</script>

EOF;

$o->financialyear_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->financialyear_id=$_POST["financialyear_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->financialyear_id=$_GET["financialyear_id"];

}
else
$action="";

$token=$_POST['token'];

$o->financialyear_name=$_POST["financialyear_name"];

$o->periodqty=$_POST['periodqty'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->isclosed=$_POST['isclosed'];
$l->linedel=$_POST['linedel'];
$l->lineisclosed=$_POST['lineisclosed'];
$l->linefinancialyearline_id=$_POST['linefinancialyearline_id'];
$o->periodfrom_id=$_POST['periodfrom_id'];
$o->periodto_id=$_POST['periodto_id'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->isAdmin=$xoopsUser->isAdmin();
//$o->periodqty=$row['periodqty'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with financialyear name=$o->financialyear_name");

	if ($s->check(true,$token,"CREATE_ACG")){
		

	if($o->isValid($o->periodfrom_id,$o->periodto_id)){
	  if($o->insertFinancialYear()){
		 $latest_id=$o->getLatestFinancialYearID();
		$l->createFinancialYearLine($latest_id,$o->periodfrom_id,$o->periodto_id);
		$o->periodqty=$l->createdline+$o->periodqty;
		$o->updateFinancialYear();
			 redirect_header("financialyear.php?action=edit&financialyear_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	  else {
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->periodfromctrl=$ctrl->getSelectPeriod($o->periodfrom_id,'N',"","periodfrom_id");
		$o->periodtoctrl=$ctrl->getSelectPeriod($o->periodto_id,'N',"","periodto_id");

		$o->getInputForm("new",-1,$token);
		$o->showFinancialYearTable("WHERE financialyear_id>0 and organization_id=$defaultorganization_id","ORDER BY f.financialyear_name"); 
		}
	 }
	else {
		$log->showLog(1,"Error: Record cannot create, please verified your input!");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->periodfromctrl=$ctrl->getSelectPeriod($o->periodfrom_id,'N',"","periodfrom_id");
		$o->periodtoctrl=$ctrl->getSelectPeriod($o->periodto_id,'N',"","periodto_id");
		$o->getInputForm("new",-1,$token);
		$o->showFinancialYearTable("WHERE financialyear_id>0 and organization_id=$defaultorganization_id","ORDER BY f.financialyear_name"); 
		}

	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data

		$log->showLog(1,"Error: Record cannot create, due to token expired!");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->periodfromctrl=$ctrl->getSelectPeriod($o->periodfrom_id,'N',"","periodfrom_id");
		$o->periodtoctrl=$ctrl->getSelectPeriod($o->periodto_id,'N',"","periodto_id");

		$o->getInputForm("new",-1,$token);
		$o->showFinancialYearTable("WHERE financialyear_id>0 and organization_id=$defaultorganization_id","ORDER BY f.financialyear_name"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchFinancialYear($o->financialyear_id)){
		//create a new token for editing a form
		$o->periodtable=$l->showFinancialYearLine($o->financialyear_id);
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->periodfromctrl=$simbizctrl->getSelectPeriod(0,'Y',"","periodfrom_id");
		$o->periodtoctrl=$simbizctrl->getSelectPeriod(0,'Y',"","periodto_id");

		$o->getInputForm("edit",$o->financialyear,$token);
		$o->showFinancialYearTable("WHERE f.financialyear_id>0 and f.organization_id=$defaultorganization_id","ORDER BY f.financialyear_name,f.defaultlevel"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("financialyear.php",3,"Some error on viewing your financialyear data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(true,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$l->createFinancialYearLine($o->financialyear_id,$o->periodfrom_id,$o->periodto_id);
		$o->periodqty=$l->createdline+$o->periodqty;
	//	if($o->isclosed==1)
	//	$l->closeFinancialYearLine($o->financialyear_id);
	//	else
		$l->updateFinancialYearLine();
		if($o->updateFinancialYear()) {//if data save successfully

			redirect_header("financialyear.php?action=edit&financialyear_id=$o->financialyear_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("financialyear.php?action=edit&financialyear_id=$o->financialyear_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	

	}
	else{
		redirect_header("financialyear.php?action=edit&financialyear_id=$o->financialyear_id",$pausetime,"Warning! Can't save the data, due to token expired.");			}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteFinancialYear($o->financialyear_id))
			redirect_header("financialyear.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("financialyear.php?action=edit&financialyear_id=$o->financialyear_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("financialyear.php?action=edit&financialyear_id=$o->financialyear_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "postretainearning":
      $period_id=$_POST['period_id'];
      $amt=$_POST['amt']*-1;
      $financialyearline_id=$_POST['financialyearline_id'];
      $period_name=$_POST['period_name'];
      include "class/Accounts.php";
      include "class/AccountsAPI.php";
      $newbatchno=$l->getNewBatchNo();
      $acc = new Accounts();
      $api = new AccountsAPI();
      $account=$acc->getRetainEarningAccount();
        
      $retainearningacc=$account[0];
      $reverseretainearningacc=$account[1];
      $batchdate=getLastDayByMonth($period_name);
      //$amtarray

      //$uid,$date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
//		$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
//		$chequenoarray,$linedesc="",isreadonly=0
         $api->PostBatch($o->createdby,$batchdate,"simbiz","Retain Earning For $period_name","", $amt,
                array("***","***"), array($retainearningacc,$reverseretainearningacc),array($amt,$amt*-1),
                    array($defaultcurrency_id,$defaultcurrency_id),array(1,1),
                   array($amt,$amt*-1),array(0,0),array("RE","RE"),array(0,1),
                    array("",""),"",1,$newbatchno);
   	$sql="update $tablefinancialline set batch_id=$api->resultbatch_id where financialyearline_id=$financialyearline_id";
        $xoopsDB->query($sql);
    $amt=$amt*-1;
    if($amt==0)
    $amt=0;
      echo <<< EOF

      <script type="text/javascript">

	alert("Retain earning posted! batch no:$newbatchno");
        self.parent.document.getElementById("divperiod$financialyearline_id").innerHTML="<A href='batch.php?action=view&batch_id=$api->resultbatch_id'> Amount: $amt (Posted as Batch No: $newbatchno)</A>";

	
	</script>
EOF;
      break;
case "repost":
   $batch_id=$_POST['batch_id'];
     $batchno=$_POST['batchno'];
      $newamt=$_POST['newamt']*-1;
      $financialyearline_id=$_POST['financialyearline_id'];
      $reactivateresult="failed";
      include "class/AccountsAPI.php";
      $api = new AccountsAPI();
      if($batch_id>0)
       if($api->reActivateBatch($batch_id)){
          $arraytrans_id= $l->getRetainEarningTransaction($batch_id);
          $trans1=$arraytrans_id[0];
          $trans2=$arraytrans_id[1];
   
        if($api->updateTransactionAmount($batch_id,$newamt,$arraytrans_id,array($newamt,$newamt*-1)))
           $reactivateresult="success";
       }
       $newamt=$newamt*-1;
       if($newamt==0)
       $newamt=0;
  echo <<< EOF

      <script type="text/javascript">

	//alert("reactivate $reactivateresult, then repost $newamt, $batch_id,$financialyearline_id, t:$trans1, $trans2 ");
        self.parent.document.getElementById("divperiod$financialyearline_id").innerHTML="<A href='batch.php?action=view&batch_id=$batch_id'>$batchno: $newamt (Posted)</A>";

	</script>
EOF;
    break;
  case "closeperiod":
	include_once "class/Accounts.php";
	$acc = new Accounts();
	$isclose=$_POST['isclose'];
	$period_id=$_POST['period_id'];
	$financialyearline_id=$_POST['financialyearline_id'];


	$result=$acc->replicateLastMonthBpartnerTransSummary($period_id,$defaultorganization_id);
	$needreset="1";
	if($result){

		if($isclose=="true")
			$value="on";
		else
			$value="off";
		$log->showLog(4,"Update financial line: $financialyearline_id to  $value");
		$l->lineisclosed=array($value);
		$l->linedel=array("");
		$l->linefinancialyearline_id=array($financialyearline_id);

		if($l->updateFinancialYearLine())
			$needreset=0;

	}		
	echo <<< EOF

	<script type="text/javascript">

		if($needreset==1)
			alert("Cannot close/open this period, please contact developer for further explaination");
	
	//self.parent.document.getElementById("ctrlBP$line").innerHTML = "$newbpartner" ;
	//	self.parent.document.getElementById("ctrlBP$line").style.display = "$styledisplay";
	</script>
EOF;
  break;

  default :
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	//$o->accounclassctrl=$ctrl->getAccClass(0,'N');
	$o->periodfromctrl=$simbizctrl->getSelectPeriod(0,'Y',"","periodfrom_id");
	$o->periodtoctrl=$simbizctrl->getSelectPeriod(0,'Y',"","periodto_id");

	$o->getInputForm("new",0,$token);
	$o->showFinancialYearTable("WHERE f.financialyear_id>0 and f.organization_id=$defaultorganization_id","ORDER BY f.financialyear_name");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>
