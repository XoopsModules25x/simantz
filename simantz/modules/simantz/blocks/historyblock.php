<?php
function showHistory($options){
//
global $xoopsTpl;

$block=array();
$block['historycount']=$options[0];

//echo "<br/><br/><br/><br/><br/><br/><br/>?";
for($i=0;$i<=$options[0];$i++){
    $protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
    if($_SESSION['urlhistory_'.$i]==""){
    $_SESSION['urlhistory_'.$i]=$protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $_SESSION['urlhistoryname_'.$i]=$xoopsTpl->get_template_vars('xoops_pagetitle');

    break;
    }

}


if($_SESSION['urlhistory_'.$options[0]]!=""){
    for($i=0;$i<$options[0];$i++){
        $_SESSION['urlhistory_'.$i]=$_SESSION['urlhistory_'.($i+1)];
        $_SESSION['urlhistoryname_'.$i]=$_SESSION['urlhistoryname_'.($i+1)];
        $block["history"][$i]=$_SESSION['urlhistory_'.$i];
         $block["historyname"][$i]=$_SESSION['urlhistoryname_'.$i];
         $block['index'][$i]=$i;
    }

}
$_SESSION['urlhistory_'.$options[0]]="";    
$_SESSION['urlhistoryname_'.$options[0]]="";

return $block;

}

function editHistoryCount($options){
    $form = "Max History Count: <input type='text' size='9' name='options[0]' value='$options[0]' />";
$form .= "<br />";
return $form;
}

?>
