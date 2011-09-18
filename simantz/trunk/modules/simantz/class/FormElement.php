<?php

class FormElement{
	
	public function FormElement(){
		
		}
		
	public function activateAutoComplete(){
		echo <<< EOF
  <script type="text/javascript" src="../include/jqueryui/ui/jquery.ui.position.js"></script>
  <link rel="stylesheet" type="text/css" href="../include/jqueryui/themes/ui-lightness/jquery.ui.autocomplete.css">
  <script type="text/javascript" src="../include/jqueryui/ui/jquery.ui.autocomplete.js"></script>

	<script>
	function activateAutoComplete(){
	
		$(".autocomplete").each(function(index){
			link=$(this).attr('autocompleteurl');
			
			$(this).autocomplete({
			source:link,
			minLength: 0,
			autoFocus:true,		
			select: function( event, ui ) {
//			alert(ui.item.id+','+ui.item.value+','+ui.item.label);
			}
			});
			
			$(this).click(function(){
				$(this).autocomplete("search","");
				$(this).select();
				});


		});
	}
	</script>
EOF;
		}
	}
