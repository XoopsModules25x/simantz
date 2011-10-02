<?php


class ReportElement{

	public function ReportElement(){
		
		}
	

	public function rptctrl_date($caption='Date',$name='date',$value='',$onchange){
		return "<tr><td>$caption</td><td><input id='$name' name='$name' class='datepick'  value='$value' size='11' $onchange></td></tr>";
		}
		
  	public function rptctrl_text($caption='Text',$name='txt',$value='',$onchange){
		return "<tr><td>$caption</td><td><input id='$name' name='$name'   value='$value' size='20' $onchange></td></tr>";
		}
		
		public function rptctrl_daterage($caption='Date',$name1='datefrom',$name2='dateto',$value1='',$value2,$onchange1,$onchange2){
		return "<tr><td>$caption</td><td><input name='$name1' id='$name1' value='$value1' size='11' class='datepick' $onchange1> To <input id='$name2' name='$name2' class='datepick' value='$value2' size='11' $onchange2></td></tr>";
		}
		
		public function rptctrl_norage($caption='No',$name1='nofrom',$name2='noto',$value1='',$value2,$onchange1,$onchange2){
		return "<tr><td>$caption</td><td><input name='$name1' id='$name1' value='$value1' size='15' $onchange1> To <input id='$name2' name='$name2' value='$value2' size='15' $onchange2></td></tr>";
		}
		public function rptctrl_checkbox($caption='Active',$name,$value,$checked,$onchange){
			return "<tr><td>$caption</td><td><input type='checkbox' name='$name' id='$name' value='$value' $checked  $onchange></td></tr>";
		}
		public function rptctrl_radio($caption='Type',$name,$arrvalue,$arrtext,$arrchecked,$onchange){
			$i=0;
			$c="";
			foreach($arrvalue as $value){
				$value=$arrvalue[$i];
				$text=$arrtext[$i];
				$checked=$arrchecked[$i];
				$c.="<label name='lbl$name'><input type='radio' id='$name' value='$value' name='$name' $checked $onchange/>$text</label>";
        
				
			$i++;
			}
			
			return "<tr><td>$caption</td><td>$c</td></tr>";
		}
	
		public function rptctrl_blankline($caption='',$value){
			return "<tr><td>$caption</td><td>$value&nbsp;</td></tr>";
		}

		//type=p,pr,prx
		public function rptctrl_submit($caption='',$type='p'){
			switch($type){
			case 'p':
				return "<tr><td>$caption</td><td>
					<input type='submit' name='submit' value='Preview'></td></tr>";
			break;

			case 'pr':
				return "<tr><td>$caption</td><td>
					<input type='submit' name='submit' value='Preview'>&nbsp;&nbsp;<input type='reset' name='reset' value='Reset'></td></tr>";
			break;
			default:
				return "<tr><td>$caption</td><td>
					<input type='submit' name='submit' value='Preview'></td></tr>";
			break;
			}
		}
		
		public function rptctrl_staticselect($caption,$name,$arraytext,$arrayvalue,$selectedrow,$onchange){
			$s="";
			$i=0;
			foreach($arraytext as $text){
				$txt=$arraytext[$i];
				$value=$arrayvalue[$i];
				if($selectedrow==$i+i)
				$selected="SELECTED='selected'";
				else
				$selected='';
				
				$s.="<option value='$value' $selected>$txt</option>";
				$i++;
				}
			
			return "<tr><td>$caption</td><td><select name='$name' id='$name' onchange='$onchange'>$s</select></td></tr>";

			}
 
		public function rptctrl_period($caption,$name,$period_id,$onchange,$showNull,$wherestr){
			global $ctrl;
			$result = 
			"<select name='$name' id='$name' onchange='$onchange()'>".$ctrl->getSelectPeriod($period_id,$showNull,$wherestr)."</select>";
			return "<tr><td>$caption</td><td>$result</td></tr>";
			
			}


			
		public function rptctrl_periodrange($caption,$name1,$name2,$period_id1,$period_id2,$onchange1,$onchange2,$showNull1,$showNull2,$wherestr1,$wherestr2){
			global $ctrl;
			$result1 = 
			"<select name='$name1' id='$name1' onchange='$onchange1'>".$ctrl->getSelectPeriod($period_id1,$showNull1,$wherestr1)."</select>";
			$result2 = 
			"<select name='$name2' id='$name2' onchange='$onchange2'>".$ctrl->getSelectPeriod($period_id2,$showNull2,$wherestr2)."</select>";
			return "<tr><td>$caption</td><td>$result1 To $result2</td></tr>";
			
			}
					
		public function rptctrl_organization($caption,$name,$organization_id,$onchange,$showNull,$wherestr){
			global $ctrl,$xoopsUser;
			$result = $ctrl->selectionOrg($xoopsUser->getVar('uid') ,$organization_id,$showNull);
			return "<tr><td>$caption</td><td>$result</td></tr>";
			
			}

		public function rptctrl_country($caption,$name,$country_id,$onchange,$showNull){
			global $ctrl;
			$result = 
			"<select name='$name' id='$name' onchange='$onchange()'>".$ctrl->getSelectCountry($country_id ,$showNull)."</select>";
			return "<tr><td>$caption</td><td>$result</td></tr>";
			}		
			
		public function rptctrl_currency($caption,$name,$currency_id,$onchange,$showNull){
			global $ctrl;
			$result = 
			"<select name='$name' id='$name' onchange='$onchange()'>".$ctrl->getSelectCurrency($currency_id ,$showNull)."</select>";
			return "<tr><td>$caption</td><td>$result</td></tr>";
			}
			
		public function rptctrl_religion($caption,$name,$id,$onchange,$showNull){
			global $ctrl;
			$result = 
			"<select name='$name' id='$name' onchange='$onchange()'>".$ctrl->getSelectReligion($id ,$showNull)."</select>";
			return "<tr><td>$caption</td><td>$result</td></tr>";
			}
		public function rptctrl_region($caption,$name,$id,$onchange,$showNull){
			global $ctrl;
			$result = 
			"<select name='$name' id='$name' onchange='$onchange()'>".$ctrl->getSelectRegion($id ,$showNull)."</select>";
			return "<tr><td>$caption</td><td>$result</td></tr>";
			}


		public function rptctrl_races($caption,$name,$id,$onchange,$showNull){
			global $ctrl;
			$result = 
			"<select name='$name' id='$name' onchange='$onchange()'>".$ctrl->getSelectRaces($id ,$showNull)."</select>";
			return "<tr><td>$caption</td><td>$result</td></tr>";
			}

		public function rptctrl_user($caption,$name,$uid,$onchange,$showNull){
			global $ctrl;
			$result = 
			"<select name='$name' id='$name' onchange='$onchange()'>".$ctrl->getSelectUser($uid ,$showNull)."</select>";
			return "<tr><td>$caption</td><td>$result</td></tr>";
			}
			
			
			
				
	}

