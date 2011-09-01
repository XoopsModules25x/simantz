<?php


class ReportElement{
	
	public function ReportElement(){
		
		}
	
	public function rptctrl_date($caption='Date',$name='date',$value='',$onchange){
		return "<tr><td>$caption</td><td><input id='$name' name='$name' value='$value' size='10' $onchange></td></tr>";
		}
		
		public function rptctrl_daterage($caption='Date',$name1='datefrom',$name2='dateto',$value1='',$value2,$onchange1,$onchange2){
		return "<tr><td>$caption</td><td><input name='$name1' id='$name1' value='$value1' size='10' $onchange1> To <input id='$name2' name='$name2' value='$value2' size='10' $onchange2></td></tr>";
		}
		
		public function rptctrl_checkbox($caption='Active',$name,$value,$checked,$onchange){
			return "<tr><td>$caption</td><td><input type='checkbox' name='$name' id='$name' value='$value' $checked  $onchange></td></tr>";
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
 
		
		
	}

