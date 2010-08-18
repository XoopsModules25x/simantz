<?php
include_once( "system.php" );
xoops_cp_header();

if(isset($_POST['submit'])){

		$sql1="TRUNCATE TABLE sim_hr_travellingclaim;";
		$sql2="TRUNCATE TABLE sim_hr_leaveadjustment;";
		$sql3="TRUNCATE TABLE sim_hr_medicalclaim;";
		$sql4="TRUNCATE TABLE sim_hr_overtimeclaim;";
		$sql5="TRUNCATE TABLE sim_hr_panelclinics;";
  		$sql6="TRUNCATE TABLE sim_hr_generalclaim;";
		$sql7="TRUNCATE TABLE sim_hr_leave;";
                $sql8="TRUNCATE TABLE sim_workflowtransaction;";
                $sql9="TRUNCATE TABLE sim_hr_supervisorline;";
		$sql10="UPDATE sim_hr_department set department_head=0 where department_id>0;";
		$sql11="DELETE FROM sim_followup where employee_id>0;";
		$sql12="DELETE FROM sim_hr_employee where employee_id>0;";

		$sql13="ALTER TABLE sim_hr_employee AUTO_INCREMENT =1;";

		$sql14="DELETE FROM sim_hr_trainingtype where trainingtype_id>0;";
		$sql15="ALTER TABLE sim_hr_trainingtype AUTO_INCREMENT =1;";

		$sql16="DELETE FROM sim_hr_disciplinetype where disciplinetype_id>0;";
		$sql17="ALTER TABLE sim_hr_disciplinetype AUTO_INCREMENT =1;";

		$sql18="DELETE FROM sim_hr_leavetype where leavetype_id>0;";
		$sql19="ALTER TABLE sim_hr_leavetype AUTO_INCREMENT =1;";

                $sql20="TRUNCATE TABLE sim_hr_qualificationline;";

                $sql21="TRUNCATE TABLE sim_hr_employeespouse;";
                $sql22="TRUNCATE TABLE sim_hr_employeefamily;";

                $sql23="TRUNCATE TABLE sim_hr_defaultpayroll;";
                $sql24="TRUNCATE TABLE sim_hr_attachmentline;";
                $sql25="TRUNCATE TABLE sim_hr_attachmentline;";
                $sql26="TRUNCATE TABLE sim_hr_skillline;";

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
		$qry=$xoopsDB->query($sql12);
		$qry=$xoopsDB->query($sql13);
		$qry=$xoopsDB->query($sql14);
		$qry=$xoopsDB->query($sql15);
		$qry=$xoopsDB->query($sql16);
		$qry=$xoopsDB->query($sql17);
		$qry=$xoopsDB->query($sql18);
		$qry=$xoopsDB->query($sql19);
		$qry=$xoopsDB->query($sql20);
		$qry=$xoopsDB->query($sql21);
		$qry=$xoopsDB->query($sql22);
		$qry=$xoopsDB->query($sql23);
		$qry=$xoopsDB->query($sql24);
		$qry=$xoopsDB->query($sql25);
		$qry=$xoopsDB->query($sql26);
		$qry=$xoopsDB->query($sql27);
		$qry=$xoopsDB->query($sql28);
		$qry=$xoopsDB->query($sql29);
		$qry=$xoopsDB->query($sql30);
		$qry=$xoopsDB->query($sql31);
		$qry=$xoopsDB->query($sql32);
		$qry=$xoopsDB->query($sql33);


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
		$sql23<br>
		$sql24<br>
		$sql25<br>
		$sql26<br>
		$sql27<br>
		$sql28<br>
		$sql29<br>
		$sql30<br>
		$sql31<br>
		$sql32<br>
		$sql33<br>
		$sql34<br>
		$sql35<br>
		$sql36<br>
		$sql37<br>
		$sql38<br>
	
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

