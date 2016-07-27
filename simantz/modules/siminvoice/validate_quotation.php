<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Quotation.php';
include_once 'class/Customer.php';
include_once 'class/Item.php';
include_once 'class/Terms.php';
include_once "menu.php";
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Quotation($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$c = new Customer($xoopsDB,$tableprefix,$log);
$i = new Item($xoopsDB,$tableprefix,$log);
$t = new Terms($xoopsDB,$tableprefix,$log);

$xf_value = $_GET['xf_value'];

if($xf_value!=""){
?>
<script language="javascript">
<?php


$quotation_attn = $o->getAttnDesc($xf_value,"customer_contactperson");
$quotation_attntel = $o->getAttnDesc($xf_value,"customer_contactno");
$quotation_attntelhp = $o->getAttnDesc($xf_value,"customer_contactnohp");
$quotation_attnfax = $o->getAttnDesc($xf_value,"customer_contactfax");
$terms_id = $o->getAttnDesc($xf_value,"terms_id");
$terms_desc = $o->getTermsDesc($terms_id,"terms_desc");


echo "self.parent.document.forms['frmQuotation'].quotation_attn.value = '$quotation_attn' ;";
echo "self.parent.document.forms['frmQuotation'].quotation_attntel.value = '$quotation_attntel' ;";
echo "self.parent.document.forms['frmQuotation'].quotation_attntelhp.value = '$quotation_attntelhp' ;";
echo "self.parent.document.forms['frmQuotation'].quotation_attnfax.value = '$quotation_attnfax' ;";
echo "self.parent.document.forms['frmQuotation'].terms_id.value = '$terms_id' ;";
echo "self.parent.document.forms['frmQuotation'].quotation_terms.value = '$terms_desc' ;";

//if($quotation_attn!="")
//echo "self.parent.document.getElementById('idItemLine').innerHTML = '<table border=1><tr><td>$xf_value</td></tr></table>';";


?>
</script>

<?php
}
?>
