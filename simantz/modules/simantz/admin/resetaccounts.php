<?php
include_once( "system.php" );
xoops_cp_header();

if(isset($_POST['submit'])){

$organization_id=$_POST['organization_id'];
	if($organization_id>0)
	{
		$sql1="DELETE FROM $tableaccountgroup where organization_id=$organization_id and accountgroup_id>0;";
		$sql2="DELETE FROM $tablebatch where organization_id=$organization_id and batch_id>0;";
		$sql3="DELETE FROM $tablebankreconcilation where organization_id=$organization_id and bankreconcilation_id>0;";
		$sql4="DELETE FROM $tablereceipt where organization_id=$organization_id and receipt_id>0;";
		$sql5="DELETE FROM $tablepaymentvoucher where organization_id=$organization_id and paymentvoucher_id>0;";
		$sql6="DELETE FROM $tablefinancialyear where organization_id=$organization_id and financialyear_id>0;";
		$sql7="DELETE FROM $tabletax where organization_id=$organization_id and tax_id>0;";
		$sql8="DELETE FROM $tabledebitcreditnote where organization_id=$organization_id and debitcreditnote_id>0;";
		$sql9="DELETE FROM $tableinvoice where organization_id=$organization_id and invoice_id>0;";

		$sql10=" ALTER TABLE $tableaccountgroup ENGINE = InnoDB;";
		$sql11=" ALTER TABLE $tablebatch ENGINE = InnoDB;";
		$sql12=" ALTER TABLE $tablebankreconcilation ENGINE = InnoDB;";
		$sql13=" ALTER TABLE $tablereceipt ENGINE = InnoDB;";
		$sql14=" ALTER TABLE $tablepaymentvoucher ENGINE = InnoDB;";
		$sql15=" ALTER TABLE $tablefinancialyear ENGINE = InnoDB;";
		$sql16=" ALTER TABLE $tabletax ENGINE = InnoDB;";
		$sql17=" ALTER TABLE $tabledebitcreditnote ENGINE = InnoDB;";
		$sql18=" ALTER TABLE $tabledebitcreditnoteline ENGINE = InnoDB;";
		$sql19=" ALTER TABLE $tablefinancialyearline ENGINE = InnoDB;";
		$sql20=" ALTER TABLE $tableinvoice ENGINE = InnoDB;";
		$sql21=" ALTER TABLE $tableinvoiceline ENGINE = InnoDB;";
		$sql22=" ALTER TABLE $tablereceiptline ENGINE = InnoDB;";
		$sql23=" ALTER TABLE $tablepaymentvoucherline ENGINE = InnoDB;";
		$sql24=" UPDATE $tablebpartner SET currentbalance=0,debtoraccounts_id=0,creditoraccounts_id where organization_id=$organization_id;";

		$rs1=$xoopsDB->query($sql1);
		$rs2=$xoopsDB->query($sql2);
		$rs3=$xoopsDB->query($sql3);
		$rs4=$xoopsDB->query($sql4);
		$rs5=$xoopsDB->query($sql5);
		$rs6=$xoopsDB->query($sql6);
		$rs7=$xoopsDB->query($sql7);
		$rs8=$xoopsDB->query($sql8);
		$rs9=$xoopsDB->query($sql9);
		$rs10=$xoopsDB->query($sql10);
		$rs11=$xoopsDB->query($sql11);
		$rs12=$xoopsDB->query($sql12);
		$rs13=$xoopsDB->query($sql13);
		$rs14=$xoopsDB->query($sql14);
		$rs15=$xoopsDB->query($sql15);
		$rs16=$xoopsDB->query($sql16);
		$rs17=$xoopsDB->query($sql17);
		$rs18=$xoopsDB->query($sql18);
		$rs19=$xoopsDB->query($sql19);
		$rs20=$xoopsDB->query($sql20);
		$rs21=$xoopsDB->query($sql21);
		$rs22=$xoopsDB->query($sql22);
		$rs23=$xoopsDB->query($sql23);
		$rs24=$xoopsDB->query($sql24);

		echo <<< EOF
		<A href='index.php'>Back To This Module Administration Menu</A><br>
		everything in this organization is purge!
EOF;
		$log->showLog(3,"
		$sql1<br>
		$sql2<br>
		$sql3<br>
		$sql4<br>
		$sql5<br>
		$sql6<br>
		$sql7<br>
		$sql8<br>
		$sql9<br>
		$sql10<br>
		$sql11<br>
		$sql12<br>
		$sql13<br>
		$sql14<br>
		$sql15<br>
		$sql16<br>
		$sql17<br>
		$sql18<br>
		$sql19<br>
		$sql20<br>
		$sql21<br>
		$sql22<br>
		");
	}
	else{
		echo <<< EOF
		<A href='index.php'>Back To This Module Administration Menu</A><br>
		No organization is selected, click <a href="resetaccounts.php">[here]</a> to go back previous page.
EOF;
	}
}
else{

include_once "../class/SelectCtrl.inc.php";
include_once "../class/Log.inc.php";
$log= new Log();
$ctrl= new SelectCtrl();

$orgctrl=$ctrl->selectionOrg(0,0,'Y','');
echo <<< EOF
	<A href='index.php'>Back To This Module Administration Menu</A><br>
Confirm to reset accounts in this organization? Please backup your data before proceed further.<br>

<FORM action="resetaccounts.php" method="POST" onsubmit="return confirm('Confirm to clear data?')">
Organization: $orgctrl<br>

  <INPUT type="submit" name="submit" value="Reset Account">
</FORM>

EOF;
}
xoops_cp_footer();
?>

