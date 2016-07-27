<?php
include_once( "system.php" );
xoops_cp_header();

if(isset($_POST['submit'])){



		$sql1="TRUNCATE TABLE sim_simtrain_payment;";
		$sql2="TRUNCATE TABLE sim_simtrain_paymentline;";
		$sql3="TRUNCATE TABLE sim_simtrain_payslip;";
		$sql4="TRUNCATE TABLE sim_simtrain_payslipline;";

		$sql6="TRUNCATE TABLE sim_simtrain_cashtransfer;";
		$sql7="DELETE FROM sim_simtrain_studentclass where studentclass_id>0;";
		$sql8="ALTER TABLE sim_simtrain_studentclass ENGINE = InnoDB;";
		$sql9="DELETE FROM sim_simtrain_tuitionclass where tuitionclass_id>0;";
		$sql10="ALTER TABLE sim_simtrain_tuitionclass ENGINE = InnoDB;";
		$sql11="TRUNCATE TABLE sim_simtrain_test;";
		$sql12="TRUNCATE TABLE sim_simtrain_regattendance;";
		$sql13="TRUNCATE TABLE sim_simtrain_attendance;";
		$sql14="DELETE FROM sim_simtrain_inventorymovement where movement_id>0;";
		$sql15="ALTER TABLE sim_simtrain_inventorymovement ENGINE = InnoDB;";
		$sql16="DELETE FROM sim_simtrain_cloneprocess where clone_id>0;";
		$sql17="ALTER TABLE sim_simtrain_cloneprocess ENGINE = InnoDB;";
		$sql18="TRUNCATE TABLE sim_simtrain_emppayslipitem;";
		$sql19="DELETE FROM sim_simtrain_student where student_id>0;";
		$sql20="ALTER TABLE sim_simtrain_student ENGINE = InnoDB;";
		$sql21="DELETE FROM sim_simtrain_employee where employee_id>0;";
		$sql22="ALTER TABLE sim_simtrain_employee ENGINE = InnoDB;";
		$sql23="DELETE FROM sim_simtrain_area where area_id>0;";
		$sql24="ALTER TABLE sim_simtrain_area ENGINE = InnoDB;";
		$sql25="DELETE FROM sim_simtrain_parents where parents_id>0;";
		$sql26="ALTER TABLE sim_simtrain_parents ENGINE = InnoDB;";
		$sql27="DELETE FROM sim_simtrain_period where period_id>0;";
		$sql28="ALTER TABLE sim_simtrain_period ENGINE = InnoDB;";
		$sql29="DELETE FROM sim_simtrain_productlist where product_id>0;";
		$sql30="ALTER TABLE sim_simtrain_productlist ENGINE = InnoDB;";
		$sql31="DELETE FROM sim_simtrain_productcategory where category_id>0;";
		$sql32="ALTER TABLE sim_simtrain_productcategory ENGINE = InnoDB;";
		$sql33="DELETE FROM sim_simtrain_races where races_id>0;";
		$sql34="ALTER TABLE sim_simtrain_races ENGINE = InnoDB;";
		$sql35="DELETE FROM sim_simtrain_standard where standard_id>0;";
		$sql36="ALTER TABLE sim_simtrain_standard ENGINE = InnoDB;";
		$sql37="DELETE FROM sim_simtrain_religion where religion_id>0;";
		$sql38="ALTER TABLE sim_simtrain_religion ENGINE = InnoDB;";
		$sql39="DELETE FROM sim_simtrain_room where room_id>0;";
		$sql40="ALTER TABLE sim_simtrain_room ENGINE = InnoDB;";
		$sql41="DELETE FROM sim_simtrain_school where school_id>0;";
		$sql42="ALTER TABLE sim_simtrain_school ENGINE = InnoDB;";
		$sql43="DELETE FROM sim_simtrain_transport where transport_id>0;";
		$sql44="ALTER TABLE sim_simtrain_transport ENGINE = InnoDB;";
		$sql45="DELETE FROM sim_simtrain_organization where organization_id>0;";
		$sql46="ALTER TABLE sim_simtrain_organization ENGINE = InnoDB;";
		$sql47="DELETE FROM sim_simtrain_address where address_id>0;";
		$sql48="ALTER TABLE sim_simtrain_address ENGINE = InnoDB;";
		$qry=$xoopsDB->query($sql1);
		$qry=$xoopsDB->query($sql2);
		$qry=$xoopsDB->query($sql3);
		$qry=$xoopsDB->query($sql4);
//		$qry=$xoopsDB->query($sql5);
		$qry=$xoopsDB->query($sql6);
		$qry=$xoopsDB->query($sql7);
		$qry=$xoopsDB->query($sql8);
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
		$qry=$xoopsDB->query($sql34);
		$qry=$xoopsDB->query($sql35);
		$qry=$xoopsDB->query($sql36);
		$qry=$xoopsDB->query($sql37);
		$qry=$xoopsDB->query($sql38);
		$qry=$xoopsDB->query($sql39);
		$qry=$xoopsDB->query($sql40);
		$qry=$xoopsDB->query($sql41);
		$qry=$xoopsDB->query($sql42);
		$qry=$xoopsDB->query($sql43);
		$qry=$xoopsDB->query($sql44);
		$qry=$xoopsDB->query($sql45);
		$qry=$xoopsDB->query($sql46);
		$qry=$xoopsDB->query($sql47);
		$qry=$xoopsDB->query($sql48);

		echo <<< EOF
		<A href='index.php'>Back To This Module Administration Menu</A><br>
		everything in this organization is purge!<br>

		$sql1<br>
		$sql2<br>
		$sql3<br>
		$sql4<br>

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
		$sql39<br>
		$sql40<br>
		$sql41<br>
		$sql42<br>
		$sql43<br>
		$sql44<br>
		$sql45<br>
		$sql46<br>
		$sql47<br>
		$sql48<br>
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

