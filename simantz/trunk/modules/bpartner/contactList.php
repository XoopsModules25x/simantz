<?php


include_once "system.php";


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$s = new XoopsSecurity();

//$acc= new Accounts();
$contacts_name=$_GET['contacts_name'];
$hpno=$_GET['hpno'];
$bpartner_id=$_GET['bpartner_id'];
$races_id=$_GET['races_id'];
$religion_id=$_GET['religion_id'];
$region_id=$_GET['region_id'];

if($bpartner_id=="")
$bpartner_id=0;

if($races_id=="")
$races_id=0;

if($religion_id=="")
$religion_id=0;

if($region_id=="")
$region_id=0;


//$bpartnerfrom
//$accounts_id=$_POST['accounts_id'];
//$period_id=$_POST['periodfrom_id'];
//	$acc->fetchAccounts($accounts_id);
//	$balanceamt=$acc->accBalanceBFAmount($period_id,$accounts_id);

if($_POST['action']=="SMS"){
    include_once "menu.php";
$bpartnerctrl=$bpctrl->getSelectBPartner($bpartner_id,'Y');
$racesctrl=$ctrl->getSelectRaces($races_id,'Y');
$religionctrl=$ctrl->getSelectReligion($religion_id,'Y');
$regionctrl=$ctrl->getSelectRegion($region_id,'Y');

        $removestring=array("(", ")", "-", " ","\n","\0","\t","\r");
$subscriber_number="";
foreach($_POST['chk'] as $hp){
    $hp=str_replace($removestring,"",$hp);
        if(strlen($hp)==10 && substr($hp,0,1 )=="0")
                $hp="6".$hp ;
                elseif(strlen($hp)==9 && substr($hp,0,1)=="1")
                $hp="60".$hp;
                elseif(strlen($hp)!=11)
                $hp="";



                if($hp!=""){
                $subscriber_number.=$hp."@";
                   $j++;
                }
}
global $smsurl,$smsid,$smspassword,$smssender_name,$urlchecksmsbalance;
    $url=$smsurl;
 $owner_id=$smsid;
    $password=$smspassword;
    $sender_name=$smssender_name;
    $lang_type = $_POST['selectLang'];
    $msg=htmlspecialchars($_POST['smstext']);
    $subscriber_number=substr_replace($subscriber_number,"",-1);
    //echo "owner_id=$owner_id&password=$password&sender_name=$sender_name&lang_type=$lang_type&subscriber_num=$subscriber_number&msg=$msg";
$curl_connection = curl_init($url);
	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_connection, CURLOPT_USERAGENT,
		"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, false);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_connection, CURLOPT_POST ,1);
	curl_setopt ($curl_connection, CURLOPT_POSTFIELDS,
		"owner_id=$owner_id&password=$password&sender_name=$sender_name&lang_type=$lang_type&subscriber_num=$subscriber_number&msg=$msg");
	curl_setopt ($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	$result= curl_exec ($curl_connection);
 	curl_close ($curl_connection);
        sleep(4);
        echo "<br>SMS Balance ";
        $curl_connection = curl_init($urlchecksmsbalance);
	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_connection, CURLOPT_USERAGENT,
		"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, false);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	$result= curl_exec ($curl_connection);
 	curl_close ($curl_connection);
        echo "SMS";

    echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');
die;
}
elseif($_POST['action']=="Print Address"){
    $addresslist="";
   foreach($_POST['print'] as $c){
    if($c>0)
        $addresslist.=$c.",";
    }

      $addresslist=substr_replace($addresslist,"",-1);
      $sql="SELECT c.greeting,c.contacts_id, c.contacts_name, c.bpartner_id,bp.bpartner_name, c.position,
        c.tel_1,c.hpno,c.fax,c.email,a.address_city ,a.address_name,c.address_id,
        a.address_street,a.address_postcode,country.country_name,r.region_name
        FROM $tablecontacts c
        INNER JOIN $tablebpartner bp on bp.bpartner_id=c.bpartner_id
        INNER JOIN $tableaddress a on c.address_id=a.address_id
        INNER JOIN $tablecountry country on country.country_id=a.country_id
        INNER JOIN $tableregion r on r.region_id=a.region_id
        where c.contacts_id in ($addresslist) order by bp.bpartner_name ASC,a.address_city ASC";
      $table=" <table border='1' width='100%'>";


      $query=$xoopsDB->query($sql);
      $col=0;
      while($row=$xoopsDB->fetchArray($query)){
          $greeting=$row['greeting'];

          $contacts_name=$row['contacts_name'];
          $address_name=$row['address_name'];
          $address_street=$row['address_street'];
                    $address_street=str_replace(array("\n","\r"), "<br/>", $address_street);

          $address_city=$row['address_city'];
          $address_postcode=$row['address_postcode'];
          $country_name=$row['country_name'];
          $region_name=$row['region_name'];
          $tel_1=$row['tel_1'];
          $tel_2=$row['tel_2'];
          $fax=$row['fax'];
        if($col==0){
          $table.="<tr><td><b>$greeting $contacts_name</b><br/>$address_street<br/>$address_postcode $address_city <br/>$region_name $country_name<br/></td><td>&nbsp;</td>";
          $col=1;
        }
        else{
            $table.="<td><b>$greeting $contacts_name</b><br/>$address_street<br/>$address_postcode $address_city <br/>$region_name $country_name</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
          $col=0;
        }
          
      }
      $table.="</table>";
      echo $table;
    die;
}
include_once "menu.php";
$bpartnerctrl=$bpctrl->getSelectBPartner($bpartner_id,'Y');
$racesctrl=$ctrl->getSelectRaces($races_id,'Y');
$religionctrl=$ctrl->getSelectReligion($religion_id,'Y');
$regionctrl=$ctrl->getSelectRegion($region_id,'Y');

echo <<< EOF
<script type='text/javascript'>

function printAll(value){
var rowcount=document.getElementById("rowcount").value;

for(i=0;i<rowcount;i++)
if(document.getElementById("address_"+i).value !=0)
    document.getElementById("print_"+i).checked=value;
else
    document.getElementById("print_"+i).checked=false;
}


function selectAll(value){
var rowcount=document.getElementById("rowcount").value;

for(i=0;i<rowcount;i++)
if(document.getElementById("chk_"+i).value !="")
    document.getElementById("chk_"+i).checked=value;
else
    document.getElementById("chk_"+i).checked=false;
}



function checktextlength(){
	var smstext=document.getElementById("smstext");
	var lang=document.getElementById("selectLang");
	var textlength=document.getElementById("textlength");
	if(lang.value=='C')
		textlength.value=smstext.value.length*2 +$senderlen * 2;
	else
		textlength.value=smstext.value.length+$senderlen;
}

</script>
<table border='1' class="searchformblock">
	<tbody>
		<tr><td class="searchformheader" style="text-align:center;" colspan='4'>Search Contact List</td></tr>
		<form name='frmContactList' method='GET' action='contactList.php' >
		
		<tr><td class='head'>Name</td><td class='odd'><input name='contacts_name' value='$contacts_name'></td>
			<td class='head'>Business Partner</td><td class='odd'>$bpartnerctrl</td>
		</tr>
	<tr><td class='head'>Races</td><td class='odd'><select id="races_id" name="races_id">$racesctrl</select></td>
			<td class='head'>Religion</td><td class='odd'><select id="religion_id" name="religion_id">$religionctrl</select></td>
		</tr>
	<tr><td class='head'>HP</td><td class='odd'><input name='hpno'  value='$hpno'></td>
		<td class='head'>Region</td><td class='odd'><select id="region_id" name="region_id">$regionctrl</select></td>
		</tr>
		<tr><td>
		<tr><td>
			<input type='submit' value='Search' name='submit'>
		</tr>
		</blank>
	</tbody>
</table>
</form>
EOF;


if(isset($_GET['submit'])){
echo <<< EOF
           <script type="text/javascript" src="../simantz/include/sorttable.js"></script>

<form action='contactList.php' method='POST' onsubmit="return confirm('Confirmed?')" target="_blank">

<h1> Contact List</h1>

<table class="searchformblock sortable" >
   
    <tr>
        <td class="searchformheader" align='center'>No</td>
        <td class="searchformheader" align='center'>Name</td>
        <td class="searchformheader" align='center'>B.Partner</td>
        <td class="searchformheader" align='center'>Address</td>
        <td class="searchformheader" align='center'>City</td>
        <td class="searchformheader" align='center'>Position</td>
        <td class="searchformheader" align='center'>Races</td>
        <td class="searchformheader" align='center'>Religion</td>
        <td class="searchformheader" align='center'>Tel</td>
        <td class="searchformheader" align='center'>HP No</td>
        <td class="searchformheader" align='center'>Fax</td>
        <td class="searchformheader" align='center'>Email</td>
        <td class="searchformheader sorttable_nosort" align='center'>SMS <input type='checkbox' onclick='selectAll(this.checked)'></td>
        <td class="searchformheader sorttable_nosort" align='center'>Print <input type='checkbox' onclick='printAll(this.checked)'></td>
    </tr>
EOF;

    $wherestring = "WHERE c.contacts_id>0 AND";
    if($contacts_name != "")
    $wherestring .= " c.contacts_name LIKE '$contacts_name' AND";
    if($hpno != "")
    $wherestring .= " c.hpno LIKE '$hpno' AND";
    if($races_id >0)
    $wherestring .= " c.races_id = '$races_id' AND";
    if($religion_id >0)
    $wherestring .= " c.religion_id = '$religion_id' AND";
    if($races_id >0)
    $wherestring .= " c.races_id = '$races_id' AND";
$wherestring =substr_replace($wherestring,"",-3 );

    $sql="SELECT c.greeting, c.contacts_id, c.contacts_name, c.bpartner_id,bp.bpartner_name, c.position,
        rc.races_name,rlg.religion_name, c.tel_1,c.hpno,c.fax,c.email,a.address_city ,a.address_name,c.address_id
        FROM $tablecontacts c
        INNER JOIN $tablebpartner bp on bp.bpartner_id=c.bpartner_id
        INNER JOIN $tableaddress a on c.address_id=a.address_id
        INNER JOIN $tableraces rc on rc.races_id=c.races_id
        INNER JOIN $tablereligion rlg on rlg.religion_id=c.religion_id
        $wherestring  order by c.contacts_name ASC";
$i=0;
$j=0;
$query=$xoopsDB->query($sql);

while($row=$xoopsDB->fetchArray($query)){

$j++;
$greeting=$row['greeting'];
$contacts_id=$row['contacts_id'];
$bpartner_id=$row['bpartner_id'];
$address_id=$row['address_id'];
$address_name=$row['address_name'];
$address_city =$row['address_city'];
$contacts_name=$row['contacts_name'];
$bpartner_name=$row['bpartner_name'];
$position=$row['position'];
$races_name=$row['races_name'];
$religion_name=$row['religion_name'];
$tel_1=$row['tel_1'];
$hpno=$row['hpno'];
$fax=$row['fax'];
$email=$row['email'];
echo <<< EOF
    <tr>
        <td align='center'>$j</td>
        <td align='center'>$greeting $contacts_name</td>
        <td align='center'><a href='bpartner.php?action=viewsummary&bpartner_id=$bpartner_id'>$bpartner_name</a></td>
        <td align='center'>$address_name</td>
        <td align='center'>$address_city</td>
        <td align='center'>$position</td>
        <td align='center'>$races_name</td>
        <td align='center'>$religion_name</td>
        <td align='center'>$tel_1</td>
        <td align='center'>$hpno</td>
        <td align='center'>$fax</td>
        <td align='center'>$email</td>
        <td align='center'><input type='checkbox' name='chk[$i]' value='$hpno' id='chk_$i'></td>
        <td align='center'><input type='hidden' name='address[$i]' value='$address_id' id='address_$i'><input type='checkbox' name='print[$i]' value='$contacts_id' id='print_$i'></td>
    </tr>
EOF;

$i++;

}
    echo "<input name='rowcount' id='rowcount' value='$j' type='hidden'>";
           if($i > 0){
echo <<< EOF
  </tr></tbody></table>
               <input value='Print Address' name='action' type='submit'>
               <input type='hidden' id='rowcount' name='rowcount' value='$i'>
	<br/><br/>SMS Text:<SELECT name='selectLang' id='selectLang' onchange='checktextlength()'>
					<OPTION value='E'>Malay/English</option>
					<OPTION value='C'>Chinese</option>
				</SELECT> (Chinese character use 2x space in SMS, if text more than 160 will split into 2 sms)<br>
	<textarea name='smstext' id='smstext' cols='50' rows='5' onkeyup='checktextlength()'></textarea>
	<input name='textlength' value='0' id='textlength' size='3' readonly='readonly'> characters, $senderlen (English) characters has been used by system<br>
	<input value='SMS' name='action' type='submit'>
	<input name='Reset' value='Reset' type='Reset'></form>

EOF;
    }
    
}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

