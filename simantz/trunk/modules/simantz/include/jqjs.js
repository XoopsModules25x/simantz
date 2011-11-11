	$(document).ready(function(){
    		 $("button").button();

		$(".datepick").datepicker({
					dateFormat: 'yy-mm-dd',
	                  numberOfMonths: 2
					});
				});

function holdscreen(){
	
$("#popUpDiv").dialog({modal:true,
	 position: 'center',
    closeOnEscape: false,
    open: function(event, ui) {
        // Hide close button
        $(this).parent().children().children(".ui-dialog-titlebar-close").hide();
    }
    });
}


function releasescreen(){
	
	$("#popUpDiv").dialog('close')

	}
