<?php


if($_REQUEST['type']=="followup")
    followup();
elseif ($_REQUEST['type']=="address")
    address();
elseif ($_REQUEST['type']=="contacts")
    contacts();


function contacts(){
echo <<< EOF

    nitobi.loadComponent('gridcontacts');

     function search(){
        var grid = nitobi.getGrid("gridcontacts");
        //reload grid data
	grid.dataBind();

    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        return 0;
    }

    //after grid html render properly, set focus on it. It is important when use choose particular cell but
    // immediately press search again. From screen we won't detect cell is selected infact from javascript
    // detect selected
   function dataready(){

       var  g = nitobi.getGrid('gridcontacts');
        g.move(0,0);//need to trigger relative position 0,0 in for next code able to highlight at screen
        var selRow = g.getSelectedRow();

    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('gridcontacts');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();



        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Record saved successfully</a>";
                         //document.getElementById('popupmessage').innerHTML="Please Wait.....";
                         search();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	search();

                popup('popUpDiv');

        	return false;
        	}
    }

    //if save_data have error, trigger this function
    function showError(){

        var grid= nitobi.getGrid('gridcontacts');
        var dataSource =grid.getDataSource();

        var errorMessage = dataSource.getHandlerError();



        if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">"+errorMessage+"</a><br/>";
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var  myGrid = nitobi.getGrid('gridcontacts');
                    var myCell = myGrid.getCellObject(row, col);
                    myCell.edit();
    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('gridcontacts');
        g.insertAfterCurrentRow();
    }

    //trigger save activity from javascript
   function save()
     {
    if(validateEmpty()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('gridcontacts');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
     	  var g= nitobi.getGrid('gridcontacts');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
	    search();
    	   }
	}
      }
      else{
      document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Contact name.</b><br/>";

      }
    }

    function beforesave(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
    }

   function onclickdeletebutton(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('gridcontacts');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
    }

    function checkAllowEdit(eventArgs){
	var g= nitobi.getGrid('gridcontacts');
        col=eventArgs.getCell().getColumn();
        return true;
  
        }


    //after insert a new line will automatically fill in some value here
      function setDefaultValue(eventArgs)
       {
       var myGrid = eventArgs.getSource();
       var r = eventArgs.getRow();
       var rowNo = r.Row;
         
       myGrid.selectCellByCoords(rowNo, 0);
    }

    function beforeDelete(){
            if(confirm('Delete this record? Data will save into database immediately.')){
                    document.getElementById("afterconfirm").value=1;
  //popup('popUpDiv');
                    return true;
            }
                    else{
                    document.getElementById("afterconfirm").value=0;
                    return false;
                    }
     }
    function viewlog(){
   	var g= nitobi.getGrid('gridcontacts');
        var selRow = g.getSelectedRow();
        var cellObj = g.getCellValue(selRow, 4);
      window.open(cellObj,"");
    }
   function validateEmpty(){

        var grid= nitobi.getGrid('gridcontacts');
        var isallow = true;
        var total_row = grid.getRowCount();
        var name ="";

        for( var i = 0; i < total_row; i++ ) {

        var celly = grid.getCellObject( i, 1);//1st para : row , 2nd para : column seq

           name = celly.getValue();
           if(name=="")
           {
            isallow = false;
           }
        }

        if(isallow)
          return true;
        else
          return false;
    }

        function valiedatetelno(){
       var grid= nitobi.getGrid('gridcontacts');
       var selRow = grid.getSelectedRow();
       var selCol = grid.getSelectedColumn();
       var celly = grid.getCellObject( selRow, selCol);
       var no = celly.getValue();

       if(no!="") {
           if((no.replace(/[0-9]/g,'')).replace(/-/g,'') !=""){
             celly.setValue("");alert("Contact number format error.");
           }

        }
     }

EOF;
die;
}

function address(){
echo <<< EOF

nitobi.loadComponent('gridaddress');

     function search(){
        var grid = nitobi.getGrid("gridaddress");
        //reload grid data
	grid.dataBind();

    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        return 0;
    }

    //after grid html render properly, set focus on it. It is important when use choose particular cell but
    // immediately press search again. From screen we won't detect cell is selected infact from javascript
    // detect selected
   function dataready(){

       var  g = nitobi.getGrid('gridaddress');
        g.move(0,0);//need to trigger relative position 0,0 in for next code able to highlight at screen
        var selRow = g.getSelectedRow();

    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('gridaddress');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();



        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Record saved successfully</a>";
                         //document.getElementById('popupmessage').innerHTML="Please Wait.....";
                         search();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	search();

                popup('popUpDiv');

        	return false;
        	}
    }

    //if save_data have error, trigger this function
    function showError(){

        var grid= nitobi.getGrid('gridaddress');
        var dataSource =grid.getDataSource();

        var errorMessage = dataSource.getHandlerError();



        if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">"+errorMessage+"</a><br/>";
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var  myGrid = nitobi.getGrid('gridaddress');
                    var myCell = myGrid.getCellObject(row, col);
                    myCell.edit();
    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('gridaddress');
        g.insertAfterCurrentRow();
    }

    //trigger save activity from javascript
   function save()
     {
    if(validateEmpty()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('gridaddress');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
     	  var g= nitobi.getGrid('gridaddress');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
	    search();
    	   }
	}
      }
      else{
      document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Address name.</b><br/>";

      }
    }

    function beforesave(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
    }

   function onclickdeletebutton(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('gridaddress');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
    }

    function checkAllowEdit(eventArgs){
	var g= nitobi.getGrid('gridaddress');
        col=eventArgs.getCell().getColumn();
        return true;
    
        }


    //after insert a new line will automatically fill in some value here
      function setDefaultValue(eventArgs)
       {
       var myGrid = eventArgs.getSource();
       var r = eventArgs.getRow();
       var rowNo = r.Row;
       
       myGrid.selectCellByCoords(rowNo, 0);
    }

    function beforeDelete(){
            if(confirm('Delete this record? Data will save into database immediately.')){
                    document.getElementById("afterconfirm").value=1;
  //popup('popUpDiv');
                    return true;
            }
                    else{
                    document.getElementById("afterconfirm").value=0;
                    return false;
                    }
     }
    function viewlog(){
   	var g= nitobi.getGrid('gridaddress');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, selCol);
      window.open(cellObj,"");
    }
   function validateEmpty(){

        var grid= nitobi.getGrid('gridaddress');
        var isallow = true;
        var total_row = grid.getRowCount();
        var name ="";

        for( var i = 0; i < total_row; i++ ) {

        var celly = grid.getCellObject( i, 0);//1st para : row , 2nd para : column seq

           name = celly.getValue();
           if(name=="")
           {
            isallow = false;
           }
        }

        if(isallow)
          return true;
        else
          return false;
    }

    function valiedatetelno(){
       var grid= nitobi.getGrid('gridaddress');
       var selRow = grid.getSelectedRow();
       var selCol = grid.getSelectedColumn();
       var celly = grid.getCellObject( selRow, selCol);
       var no = celly.getValue();

       if(no!="") {
           if((no.replace(/[0-9]/g,'')).replace(/-/g,'') !=""){
             celly.setValue("");alert("Contact number format error.");
           }

        }
     }
EOF;
die;
}
function followup(){
echo <<< EOF

nitobi.loadComponent('followupgrid');

   function dataready(){

       var  g = nitobi.getGrid('followupgrid');
        g.move(0,0);//need to trigger relative position 0,0 in for next code able to highlight at screen
        var selRow = g.getSelectedRow();

    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('followupgrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();



        if (!errorMessage) {//save successfully
        	         $('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Record saved successfully</a>";
                         //document.getElementById('popupmessage').innerHTML="Please Wait.....";
                        	grid.dataBind();

                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        		grid.dataBind();


                popup('popUpDiv');

        	return false;
        	}
    }

    //if save_data have error, trigger this function
    function showError(){

        var grid= nitobi.getGrid('followupgrid');
        var dataSource =grid.getDataSource();

        var errorMessage = dataSource.getHandlerError();



        if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">"+errorMessage+"</a><br/>";
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var  myGrid = nitobi.getGrid('followupgrid');
                    var myCell = myGrid.getCellObject(row, col);
                    myCell.edit();
    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('followupgrid');
        g.insertAfterCurrentRow();
    }

    //trigger save activity from javascript
   function save()
     {
    if(validateEmpty()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('followupgrid');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
     	  var g= nitobi.getGrid('followupgrid');
	    document.getElementById("afterconfirm").value=0;
	    g.save();

    	   }
	}
      }

    }

    function beforesave(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
    }

   function onclickdeletebutton(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('followupgrid');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
    }

    function checkAllowEdit(eventArgs){
    return true;
        }



    function beforeDelete(){
            if(confirm('Delete this record? Data will save into database immediately.')){
                    document.getElementById("afterconfirm").value=1;
  //popup('popUpDiv');
                    return true;
            }
                    else{
                    document.getElementById("afterconfirm").value=0;
                    return false;
                    }
     }
    function viewlog(){
   	var g= nitobi.getGrid('followupgrid');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, selCol);
      window.open(cellObj,"");
    }
   function validateEmpty(){

        var grid= nitobi.getGrid('followupgrid');
        var isallow = true;
        var total_row = grid.getRowCount();
        var title ="";
        var type ="";
        var pic ="";
        var cname ="";

        for( var i = 0; i < total_row; i++ ) {

        var titlecelly = grid.getCellObject( i, 1);//1st para : row , 2nd para : column seq
        var typecelly = grid.getCellObject( i, 2);//1st para : row , 2nd para : column seq
        var piccelly = grid.getCellObject( i, 3);//1st para : row , 2nd para : column seq
        var cnamecelly = grid.getCellObject( i, 5);//1st para : row , 2nd para : column seq

        title = titlecelly.getValue();
        type = typecelly.getValue();
        pic = piccelly.getValue();
        cname = cnamecelly.getValue();

           if(cname=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Contact name.</b><br/>";
           }
           if(pic=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please select a P.I.C.</b><br/>";
           }

           if(type=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please select a Type.</b><br/>";
           }
           if(title=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Title.</b><br/>";
           }

        }

        if(isallow)
          return true;
        else
          return false;
    }
EOF;
die;
}