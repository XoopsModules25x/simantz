<?php

    function getNewCode($xoopsDB,$fldname,$table,$where="") {
		global $defaultorganization_id;
		$wherestr = " WHERE CAST($fldname AS SIGNED) > 0 and organization_id = $defaultorganization_id ";
		$wherestr .= $where;

	$sql =	"SELECT CAST($fldname AS SIGNED) as new_no, $fldname as ori_data
			from $table $wherestr order by CAST($fldname AS SIGNED) DESC limit 1 ";

		$query=$xoopsDB->query($sql);

		if($row=$xoopsDB->fetchArray($query)){

			$new_no=$row['new_no']+1;

			$length_new = strlen($new_no);
			$length_ori = strlen($row['ori_data']);

			if($length_new < $length_ori){
			$add0 = "";
			while($i < ($length_ori - $length_new)){
			$i++;
			$add0 .= "0";
			}
			return $add0.$new_no;
			}else
			return $new_no;


		}
		else
		return 1;

  	}


?>
