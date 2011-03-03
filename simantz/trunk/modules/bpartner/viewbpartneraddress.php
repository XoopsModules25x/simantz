<?php

include_once "system.php";
include_once '../bpartner/class/BPartner.php';
include_once "../simantz/class/PHPJasperXML.inc";
include_once "../simantz/class/fpdf/fpdf.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$s = new XoopsSecurity();
$b = new BPartner();
//var_dump($_POST);

$industry_id=$_POST['industry_id'];
$bpartnergroup_id=$_POST['bpartnergroup_id'];
$isactive=$_POST['isactive'];
$isSearch=$_POST['isSearch'];

if(isset($_GET['filterchar'])){
$filterchar=$_GET['filterchar'];
$industry_id=$_GET['industry_id'];
$bpartnergroup_id=$_GET['bpartnergroup_id'];
$isactive=$_GET['isactive'];
$isSearch=$_GET['isSearch'];
}
if(isset($_POST['printreport'])){
//var_dump($_POST);

$org=new Organization();
$org->fetchOrganization($defaultorganization_id);
$organization_name=$org->organization_name;
$company_no=$org->companyno;

$addresslist="";
foreach($_POST['print'] as $c){
if($c>0)
$addresslist.=$c.",";
}
$addresslist=substr_replace($addresslist,"",-1);


//$wherestring ="WHERE a.address_id in ($addresslist)";

$xml = simplexml_load_file('viewbpartneraddress.jrxml'); //file name
$PHPJasperXML = new PHPJasperXML();
//echo $addresslist;

$wherestring ="WHERE a.address_id in ($addresslist)";
//$PHPJasperXML->debugsql=true;

$PHPJasperXML->arrayParameter=array("companyname"=>$organization_name, "companyno"=>$company_no, "wherestring"=>$wherestring);
$PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->transferDBtoArray(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS,XOOPS_DB_NAME);//$PHPJasperXML->transferDBtoArray(url,dbuser,dbpassword,db);
$PHPJasperXML->outpage("I");
}

else{
include_once "menu.php";
 include_once "../simantz/class/SelectCtrl.inc.php";

 $ctrl= new SelectCtrl();
 if($bpartnergroup_id=="")
     $bpartnergroup_id=0;

 $industryctrl=$ctrl->getSelectIndustry($industry_id, 'Y');
 $bpartnergroupctrl=$ctrl->getSelectBPartnerGroup($bpartnergroup_id, 'Y');

 $search=$b->searchAToZ();

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

function searchchar(char)
   {
    window.location="viewbpartneraddress.php?filterchar="+char+"&isSearch=Y";
    }

  function searchall()
    {
     window.location="viewbpartneraddress.php?filterchar=-1"+"&isSearch=Y";
    }
    



</script>$search
<table border='0' class="searchformblock">
	<tbody>
                <tr><td></td></tr>
		<tr><td class="searchformheader" style="text-align:center;" colspan='4'>Search Business Partner</td></tr>
		<form name='frmBpartner' method='POST' action='viewbpartneraddress.php' >

		<tr>
               <td class="head">Industry</td><td><select name="industry_id" $width id="industry_id">$industryctrl</select></td>
               <td class="head">Is Active</td><td><select name="isactive" $width id="isactive">
                <OPTION value="-1">Null</OPTION>
                <OPTION value="1">Yes</OPTION>
                <OPTION value="0">No</OPTION>
                </select></td>

            </tr>

             <tr>
               <td class="head">Business Partner Group</td><td><select name="bpartnergroup_id" $width id="bpartnergroup_id">$bpartnergroupctrl</select></td>

            </tr>

            <tr>
               <td class="head"><br></td>
               <td colspan="3"></td>
            </tr>

            <tr class="searchformheader"><td colspan="6" align="left"><input type="submit" name="submit" value="Search" id="button"></td></tr>
`            <input name="isSearch" id="Y" value="Y" type="hidden">

		</tr>
		</blank>
	</tbody>
</table>
</form>
EOF;


if($isSearch=='Y'){
echo <<< EOF
           <script type="text/javascript" src="../simantz/include/sorttable.js"></script>

<form action='../bpartner/viewbpartneraddress.php' method='POST' target="_blank">

<table class="searchformblock sortable" >

    <tr>
               <td class="searchformheader">No</select></td>
               <td class="searchformheader">Business Partner</td>
               <td class="searchformheader">Address Name</td>
               <td class="searchformheader">Address Street</td>
               
               <td class="searchformheader">Address(City/State)</td>
               <td class="searchformheader">Contact No. 1</td>
               <td class="searchformheader">Contact No. 2</td>
               <td class="searchformheader">Company Fax No</td>
               <td class="searchformheader">Company Website</td>
               
        <td class="searchformheader sorttable_nosort" align='center'>Print <input type='checkbox' onclick='printAll(this.checked)'></td>
    </tr>
EOF;
 $wherestring ="WHERE  a.address_id>0 ";


if($filterchar !="-1" && $filterchar !="")
    $wherestring.= " AND bp.bpartner_name LIKE '".$filterchar."%'";

else{
if($industry_id !=0 && $industry_id !="")
    $wherestring .=" AND bp.industry_id=$industry_id";

if($bpartnergroup_id !=0 && $bpartnergroup_id !="")
    $wherestring .=" AND bp.bpartnergroup_id=$bpartnergroup_id";

if($isactive !=-1 && $isactive !='')
    $wherestring .=" AND bp.isactive=$isactive";

}
    
   $sql=" SELECT bp.bpartner_id, bp.bpartner_name, bp.bpartner_url, bp.bpartnergroup_id, bpg.bpartnergroup_name, a.address_id, a.address_city, a.address_name,
                a.tel_1, a.tel_2, a.fax, a.address_street, a.address_postcode,i.industry_name
                FROM sim_address a
                INNER JOIN sim_bpartner bp ON bp.bpartner_id = a.bpartner_id
                INNER JOIN sim_bpartnergroup bpg ON bp.bpartnergroup_id = bpg.bpartnergroup_id
                INNER JOIN sim_industry i ON i.industry_id = bp.industry_id
        $wherestring";

$i=0;
$j=0;
$query=$xoopsDB->query($sql);
$rowtype='odd';

while($row=$xoopsDB->fetchArray($query)){

    $bpartnergroup_id=$row['bpartnergroup_id'];
    $bpartnergroup_name=$row['bpartnergroup_name'];
    $bpartner_id=$row['bpartner_id'];
    $bpartner_name=$row['bpartner_name'];
    $bpartner_url=$row['bpartner_url'];
    $address_name=$row['address_name'];
    $address_street=$row['address_street'];
    $address_postcode=$row['address_postcode'];
    $address_city=$row['address_city'];
    $address_id=$row['address_id'];
    $tel_1=$row['tel_1'];
    $tel_2=$row['tel_2'];
    $fax=$row['fax'];

        
          if($fax!="")
          $fax= $fax;
$j++;
if($rowtype=='odd')
        $rowtype='even';
    else
        $rowtype='odd';

echo <<< EOF
    <tr>
        <td class='$rowtype'>$j</td>

        <td class='$rowtype'>$bpartner_name</td>
        <td class='$rowtype'>$address_name</td>
        <td class='$rowtype'>$address_street</td>
        
        <td class='$rowtype'>$address_city</td>
        <td class='$rowtype'>$tel_1</td>
        <td class='$rowtype'>$tel_2</td>

        <td class='$rowtype'>$fax</td>
        <td class='$rowtype'>$bpartner_url</td>
        <td class='$rowtype'><input type='hidden' name='address[$i]' value='$address_id' id='address_$i'><input type='checkbox' name='print[$i]' value='$address_id' id='print_$i'></td>
       
EOF;

$i++;

}

    echo "<input name='rowcount' id='rowcount' value='$j' type='hidden'>";
           if($i > 0){
echo <<< EOF
  </tr></tbody></table>
               
               <input type="submit" name="printreport" value="Print" id="print" >
               <input type='hidden' id='rowcount' name='rowcount' value='$i'></form>
EOF;
    }


echo '</td>';}
require(XOOPS_ROOT_PATH.'/footer.php');
}



