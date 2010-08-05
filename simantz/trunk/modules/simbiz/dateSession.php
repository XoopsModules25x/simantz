<?php

$action = $_POST['action'];
$name = $_POST['name'];
$_POST['str_fld'] = str_replace("\'","'",$_POST['str_fld']);
$_POST['str_val'] = str_replace("\'","'",$_POST['str_val']);

$str_fld = '$str_fld='.$_POST['str_fld'];
eval("$str_fld;");//$str_fld = array(..........

$str_val = '$str_val='.$_POST['str_val'];
eval("$str_val;");//$str_val = array(..........

$count_fld = count($str_val);

/*

$i=0;
while($i<$count_fld){
$i=0;
$_SESSION['defaultorganization_id']=$str_val[$i];
$i++;
}*/


echo <<< EOF

<form name='frmValidateDate' target='nameValidateDate' method='POST' action='system.php'>
EOF;
$i=0;
while($i<$count_fld){

echo <<< EOF
<input type='hidden' value="$str_val[$i]" name="$str_fld[$i]">
EOF;
$i++;
}


echo <<< EOF
</form>
EOF;

?>
