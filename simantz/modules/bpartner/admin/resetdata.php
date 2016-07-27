<?php
include_once( "system.php" );
xoops_cp_header();

if(isset($_POST['submit'])){

		$sql1="TRUNCATE TABLE sim_bpartner;";
		$sql2="TRUNCATE TABLE sim_address;";
		$sql3="TRUNCATE TABLE sim_bpartnergroup;";

		$sql4="DELETE FROM sim_followuptype where followuptype_id>0;";
		$sql5="ALTER TABLE sim_followuptype AUTO_INCREMENT =1;";

		$sql6="DELETE FROM sim_bpartnergroup where bpartnergroup_id>0;";
		$sql7="ALTER TABLE sim_bpartnergroup AUTO_INCREMENT =1;";

		$sql8="DELETE FROM sim_industry where industry_id>0;";
		$sql9="ALTER TABLE sim_industry AUTO_INCREMENT =1;";

		$sql10="DELETE FROM sim_terms where terms_id>0;";
		$sql11="ALTER TABLE sim_terms AUTO_INCREMENT =1;";


		$qry=$xoopsDB->query($sql1);
		$qry=$xoopsDB->query($sql2);
		$qry=$xoopsDB->query($sql3);
		$qry=$xoopsDB->query($sql4);
		$qry=$xoopsDB->query($sql5);
		$qry=$xoopsDB->query($sql6);
		$qry=$xoopsDB->query($sql7);
		$qry=$xoopsDB->query($sql8);
		$qry=$xoopsDB->query($sql81);
		$qry=$xoopsDB->query($sql82);

		$qry=$xoopsDB->query($sql9);
		$qry=$xoopsDB->query($sql10);
		$qry=$xoopsDB->query($sql11);


		echo <<< EOF
		<A href='index.php'>Back To This Module Administration Menu</A><br>
		everything in this organization is purge!<br>

		$sql1<br>
		$sql2<br>
		$sql3<br>
		$sql4<br>
		$sql5<br>
		$sql6<br>
		$sql7<br>
		$sql8<br>
		$sql81<br>
		$sql82<br>
		$sql9<br>
		$sql10<br>
		$sql11<br>
		$sql12<br>

	
EOF;

	
}
else{

echo <<< EOF
	<A href='index.php'>Back To This Module Administration Menu</A><br>
Confirm to remove all data? Please backup your data before proceed further.<br>

<FORM action="resetdata.php" method="POST" onsubmit="return confirm('Confirm to clear data?')">

  <INPUT type="submit" name="submit" value="Reset Data">
</FORM>

EOF;
}

xoops_cp_footer();
?>

