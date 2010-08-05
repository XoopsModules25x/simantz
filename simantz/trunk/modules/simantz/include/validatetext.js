function IsNumeric(sText)
{
   var ValidChars = "0123456789.-";
   var IsNumber=true;
   var Char;


   for (i = 0; i < sText.length && IsNumber == true; i++)
      {
      Char = sText.charAt(i);
      if (ValidChars.indexOf(Char) == -1)
         {
         IsNumber = false;
         }
      }
   return IsNumber;

   }


function isDate(dateStr) {

	var datePat = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;
	var matchArray = dateStr.match(datePat); // is the format ok?

	if (matchArray == null) {
		//alert("Please enter date as YYYY-MM-DD.");
		return false;
		}

	month = matchArray[4]; // p@rse date into variables
	day = matchArray[7];
	year = matchArray[1];

	if (month < 1 || month > 12) { // check month range
		//alert("Month must be between 1 and 12.");
		return false;
	}

	if (day < 1 || day > 31) {
		//alert("Day must be between 1 and 31.");
		return false;
	}

	if ((month==4 || month==6 || month==9 || month==11) && day==31) {
		//alert("Month "+month+" doesn`t have 31 days!")
		return false;
	}

	if (month == 2) { // check for february 29th
		var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
		if (day > 29 || (day==29 && !isleap)) {
			//alert("February " + year + " doesn`t have " + day + " days!");
			return false;
		}
	}
	return true; // date is valid
}

function nextNode(nid,frmName,fldAction,txtStatus){

    /*
    if(confirm("Confirm to "+txtStatus+" record?")){

            if(nid > 0){
                document.getElementById(fldAction).value = 'next_node';
                document.getElementById('status_node').value = nid;

                var data = $("#"+frmName).serialize();

                $.ajax({
                 url: "leave.php",type: "POST",data: data,cache: false,
                     success: function (xml) {

                        jsonObj = eval( '(' + xml + ')');

                        var status = jsonObj.status;
                        var msg = jsonObj.msg;


                        if(status == 1){

                        self.location = "leave.php?action=edit&leave_id="+leave_id;

                        }else{
                        document.getElementById("action").value = "edit";
                        }

                        document.getElementById("statusDiv").innerHTML=msg;
                }});
                return false;
            }
        }
        */
       if(confirm("Confirm to "+txtStatus+" record?")){

            if(nid > 0){
            document.getElementById(fldAction).value = 'next_node';
            //document.getElementById('status_node').value = nid;
            document.forms[frmName].status_node.value = nid;
            document.getElementById(frmName).submit();
            }
       }
    //document.forms[frmName].submit();
    //alert(frmName);
}

function nextNodeAjax(nid,frmName,fldAction,txtStatus){

    
    if(confirm("Confirm to "+txtStatus+" record?")){

            if(nid > 0){
                document.getElementById(fldAction).value = 'next_node';
                document.getElementById('status_node').value = nid;

                var data = $("#"+frmName).serialize();

                $.ajax({
                 url: "approvallist.php",type: "POST",data: data,cache: false,
                     success: function (xml) {

                        jsonObj = eval( '(' + xml + ')');

                        var status = jsonObj.status;
                        var msg = jsonObj.msg;

                        document.getElementById("statusDiv").innerHTML=msg;
                        search();
                        document.getElementById('idApprovalWindows').style.display = "none";
                }});
                return false;
            }
        }
        

}

function validateField(value,validationtype,pattern,controlobject){

              var data="action="+"validation"+
                        "&value="+value+
                        "&validationtype="+validationtype+
                        "&pattern="+pattern;
              $.ajax({
                     url: "../simantz/validation.php",type: "GET",data: data,cache: false,
                         success: function (xml) {

                        $(xml).find("validation").each(function()
                                {
                                var currentaid = $(this).attr("id");
                                    var status = $(this).find("status").text();
                                    var msg1=$(this).find("msg").text();

                                    if(status=="1"){
                                    $("#"+controlobject.id).removeClass('validatefail');
                                    //allowSave(true);
                                    }
                                    else{
                                    $("#"+controlobject.id).addClass('validatefail');
                                    //allowSave(false);
                                 //   controlobject.focus();
                                    }

                                });
                    }});
       }