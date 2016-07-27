<?php

class BPartnerFormElement extends FormElement{
			public function getBPartnerBox($bpartner_id,$text,$ctrlid,$ctrlname,$width,$onchange, $type=""){
			if($width!='')
			$boxwidth="style='width:$width'";
			else
			$boxwidth="style='width:100px'";
			
		return	$box="<input type='1hidden' value='$bpartner_id' id='$ctrlid' name='$ctrlname'>".
				 "<input type='text' class='autocomplete' value='$text' id='{$ctrlname}_text' 
							name='{$ctrlid}_text'   linkcolumn='$ctrlid' $boxwidth $onchange
							autocompleteurl='../bpartner/searchlayer.php?action=bpautocomp&usetext=1&type=$type'>";
			



			}
	}
