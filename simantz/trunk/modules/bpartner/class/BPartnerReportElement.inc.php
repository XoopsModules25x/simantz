<?php

class BPartnerReportElement extends ReportElement{
	
	public function BPartnerReportElement(){
		
		}
		
	public function rptctrl_bpartner($caption,$name,$value,$onchange,$reporttype){
			global $sl;
		$arrctrl=array($name."_id",$name."_no",$name."_name");
			 $bpfrom=$sl->ctrlBPartner($arrctrl,$arrctrl,array(0,$value,''),1,"$onchange",$reporttype);
			 return "<tr><td>$caption</td><td>$bpfrom</td></tr>";	
		}
		
	public function rptctrl_bpartnerrange($caption,$name1,$value1,$onchange1,$name2,$value2,$onchange2,$reporttype){
			global $sl;
		$arrctrl1=array($name1."_id",$name1."_no",$name1."_name");
			$arrctrl2=array($name2."_id",$name2."_no",$name2."_name");

			 $bpfrom=$sl->ctrlBPartner($arrctrl1,$arrctrl1,array(0,$value1,''),1,"$onchange1",$reporttype);
			 $bpto=$sl->ctrlBPartner($arrctrl2,$arrctrl2,array(0,$value2,''),1,"$onchange2",$reporttype);
			 return "<tr><td>$caption</td><td>$bpfrom To $bpto</td></tr>";	

		}
			public function rptctrl_industry($caption,$name,$industry_id,$onchange,$showNull){
			global $bpctrl;
			$result = 
			"<select name='$name' id='$name' onchange='$onchange()'>".$bpctrl->getSelectIndustry($industry_id ,$showNull)."</select>";
			return "<tr><td>$caption</td><td>$result</td></tr>";
			}	
		
			public function rptctrl_bpartnergroup($caption,$name,$id,$onchange,$showNull){
			global $bpctrl;
			$result = 
			"<select name='$name' id='$name' onchange='$onchange()'>".$bpctrl->getSelectBPartnerGroup($id ,$showNull)."</select>";
			return "<tr><td>$caption</td><td>$result</td></tr>";
			}

}
