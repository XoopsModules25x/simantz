<?php

include_once "system.php" ;
  include_once "menu.php";

$isselect = $_POST['isselect'];
$arr_studentid = $_POST['studentid_address'];
$i=1;
$studentlist_id="";
//echo "input=$isselect,$arr_studentid<br>";

foreach ($arr_studentid as $id){
	if($isselect[$i]=="on")
		$studentlist_id=$studentlist_id."$id,";

$i++;
}
$studentlist_id=substr_replace($studentlist_id,"",-1);

	$tablestudent=$tableprefix . "simtrain_student";
	$tableaddress=$tableprefix . "simtrain_address";
	$tablearea=$tableprefix . "simtrain_area";
	$tableparents=$tableprefix . "simtrain_parents";
	$tablestudentclass=$tableprefix."simtrain_studentclass";
	$tablestandard=$tableprefix."simtrain_standard";
	$tableorganization=$tableprefix."simtrain_organization";
	$tableraces=$tableprefix."simtrain_races";
	$tablereligion=$tableprefix."simtrain_religion";
	$tableschool=$tableprefix."simtrain_school";
    $sql= "SELECT s.student_id, s.student_code,s.alternate_name, s.student_name, s.isactive, s.dateofbirth,std.standard_name, s.gender, s.ic_no, 
	 sch.school_name, s.hp_no, s.tel_1, s.tel_2, s.parents_id,p.parents_name, p.parents_contact, s.organization_id, s.joindate, 
	 p.parents_email,ad.no,ad.street1,ad.street2,ad.postcode,ad.city,ad.state,ad.country,area.area_name,
	 r.races_name,s.description,s.email,s.web,s.levela,s.levelb,s.levelc,s.religion_id, re.religion_name,o.organization_code
	 FROM $tablestudent s 
	 inner join $tableraces r on r.races_id=s.races_id 
	 inner join $tableaddress ad on ad.student_id=s.student_id
	 inner join $tablestandard std on std.standard_id=s.standard_id 
	 inner join $tableschool sch on sch.school_id=s.school_id 
	 inner join $tablearea area on area.area_id=ad.area_id 
	 inner join $tableorganization o on o.organization_id=s.organization_id 
	 inner join $tableparents p on p.parents_id=s.parents_id 
	 inner join $tablereligion re on s.religion_id=re.religion_id
	 where s.student_id in ($studentlist_id) order by s.student_code";

	
	$query=$xoopsDB->query($sql);
	echo <<< EOF

	<table style="text-align:left width: 100%" border="1" cellpadding="0" cellspacing="3">
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Index No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Join Date</th>
				<th style="text-align:center;">Student Name</th>
				<th style="text-align:center;">Alternate Name</th>
				<th style="text-align:center;">IC No</th>
				<th style="text-align:center;">Gender</th>
				<th style="text-align:center;">Races</th>
				<th style="text-align:center;">Religion</th>
				<th style="text-align:center;">DOB</th>
				<th style="text-align:center;">School</th>
				<th style="text-align:center;">Standard</th>
				<th style="text-align:center;">L.A</th>
				<th style="text-align:center;">L.B</th>
				<th style="text-align:center;">L.C</th>
				<th style="text-align:center;">H/P No.</th>
				<th style="text-align:center;">Tel</th>
				<th style="text-align:center;">Others Contact</th>
				<th style="text-align:center;">Parents Name</th>
				<th style="text-align:center;">Parents HP</th>
				<th style="text-align:center;">Parents Email</th>
				<th style="text-align:center;">Web</th>
				<th style="text-align:center;">Email</th>
				<th style="text-align:center;">Area</th>
				<th style="text-align:center;">Home Address</th>
				<th style="text-align:center;">Active</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$xoopsDB->fetchArray($query)){
		$i++;
		$student_code=$row['student_code'];
		$student_name=$row['student_name'];
		$alternate_name=$row['alternate_name'];
		$school_name=$row['school_name'];
		$organization_code=$row['organization_code'];
		$joindate=$row['joindate'];
		$dateofbirth=$row['dateofbirth'];
		$hp_no=$row['hp_no'];
		$standard_name=$row['standard_name'];
		$levela=$row['levela'];
		$levelb=$row['levelb'];
		$levelc=$row['levelc'];
		$religion_name=$row['religion_name'];
		$student_id=$row['student_id'];
		$isactive=$row['isactive'];
		$ic_no=$row['ic_no'];
		$parents_id=$row['parents_id'];
		$parents_name=$row['parents_name'];
		$parents_contact=$row['parents_contact'];
		$parents_email=$row['parents_email'];
		$races_name=$row['races_name'];
		$tel_1=$row['tel_1'];
		$tel_2=$row['tel_2'];
		$email=$row["email"];
		$area_name=$row['area_name'];
		$homeaddress=$row['no'].", ".$row['street1'].", ".$row['street2'].", ". $row['postcode']." ".$row['state'].", ".$row['country'];
		$web=$row["web"];
		$description=$row["description"];
		$gender=$row['gender'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		echo <<< EOF

		<tr>

		<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$student_code</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">$joindate</td>
			<td class="$rowtype" style="text-align:center;">$student_name</td>
			<td class="$rowtype" style="text-align:center;">$alternate_name</td>
			<td class="$rowtype" style="text-align:center;">$ic_no</td>
			<td class="$rowtype" style="text-align:center;">$gender</td>
			<td class="$rowtype" style="text-align:center;">$races_name</td>
			<td class="$rowtype" style="text-align:center;">$religion_name</td>
			<td class="$rowtype" style="text-align:center;">$dateofbirth</td>
			<td class="$rowtype" style="text-align:center;">$school_name</td>
			<td class="$rowtype" style="text-align:center;">$standard_name</td>
			<td class="$rowtype" style="text-align:center;">$levela</td>
			<td class="$rowtype" style="text-align:center;">$levelb</td>
			<td class="$rowtype" style="text-align:center;">$levelc</td>
			<td class="$rowtype" style="text-align:center;">$hp_no</td>
			<td class="$rowtype" style="text-align:center;">$tel_1</td>
			<td class="$rowtype" style="text-align:center;">$tel_2</td>
			<td class="$rowtype" style="text-align:center;">$parents_name</td>
			<td class="$rowtype" style="text-align:center;">$parents_contact</td>
			<td class="$rowtype" style="text-align:center;">$parents_email</td>
			<td class="$rowtype" style="text-align:center;">$web</td>
			<td class="$rowtype" style="text-align:center;">$email</td>
			<td class="$rowtype" style="text-align:center;">$area_name</td>
			<td class="$rowtype" style="text-align:center;">$homeaddress</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>

		</tr>
EOF;
	}//end of while

echo  "</tr></tbody></table>";

require(XOOPS_ROOT_PATH.'/footer.php');
?>
