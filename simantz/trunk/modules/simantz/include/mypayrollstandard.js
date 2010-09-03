function iscompleteblock(){
     
          disableEditGrid('Income','7','7');
          disableEditGrid('Deduction','7','7');
          disableEditGrid('Other','5','5');
          document.getElementById('addincomectrl').innerHTML="";
          document.getElementById('adddeductionctrl').innerHTML="";
          document.getElementById('addotherctrl').innerHTML="";
          document.getElementById('reprocess').innerHTML="";
 }
 
function disableEditGrid(gridname,totalcol,delcol){

     var grid = nitobi.getGrid(gridname+'DataboundGrid');
     grid.getColumnObject(delcol).setWidth(0);

         for (var i=0;i<=totalcol;i++){
         grid.getColumnObject(i).setEditable(false);
         }
    grid.render();
      //setWidth
    }
function enableEditGrid(gridname,totalcol,delcol){

     var grid = nitobi.getGrid(gridname+'DataboundGrid');
     grid.getColumnObject(delcol).setWidth(25);

         for (var i=0;i<=totalcol;i++){
         grid.getColumnObject(i).setEditable(true);
         }
    grid.render();
      //setWidth
    }

function blockepfsocso(eepf,esocso,epcb,iscomplete){
	   var g= nitobi.getGrid('DeductionDataboundGrid');
           var selRow = g.getSelectedRow();
           var cellObj = g.getCellValue(selRow, 1);
           var iscomplete = iscomplete;
           if(cellObj==eepf || cellObj==esocso || cellObj==epcb){
             g.getColumnObject(2).setEditable(false);
             g.getColumnObject(3).setEditable(false);
           }else{
             if(iscomplete!="Y"){
             g.getColumnObject(2).setEditable(true);
             g.getColumnObject(3).setEditable(true);}
           }
}

function getepfbase(employee_epftype,epfbasecol,erepfcol,eepfcol){
  var type =employee_epftype;
  if(type!="0"){
       var Incomegrid= nitobi.getGrid('IncomeDataboundGrid');
       var Deductiongrid= nitobi.getGrid('DeductionDataboundGrid');
       var Othergrid= nitobi.getGrid('OtherDataboundGrid');
       var epfbase =0;
       var Incomeepfbase =0;
       var Deductionepfbase =0;

       var Incometotal_row = Incomegrid.getRowCount();
       for( var i = 0; i < Incometotal_row; i++ ) {
         var celly = Incomegrid.getCellObject( i, 2);//1st para : row , 2nd para : column seq
         if(celly.getValue() == 1){
         Incomeepfbase = Incomeepfbase+Incomegrid.getCellObject( i, 4).getValue();
         }
       }

       var Deductiontotal_row = Deductiongrid.getRowCount();
       for( i = 0; i < Deductiontotal_row; i++ ) {
         celly = Deductiongrid.getCellObject( i, 2);//1st para : row , 2nd para : column seq
         if(celly.getValue() == 1){
         Deductionepfbase = Deductionepfbase+Deductiongrid.getCellObject( i, 4).getValue();
         }
       }

       epfbase = Incomeepfbase - Deductionepfbase; 
       var Othertotal_row = Othergrid.getRowCount();
       for( i = 0; i < Othertotal_row; i++ ) {
         celly = Othergrid.getCellObject( i, 0);//1st para : row , 2nd para : column seq
         if(celly.getValue() == epfbasecol){
         Othergrid.getCellObject(i, 2).setValue(epfbase);
         }
       }
        var data = "action=calculateEPF&epfbase="+epfbase+"&employee_epftype="+employee_epftype;
        $.ajax({
           url: "payslip.php",type: "POST",data: data,cache: false,
                 success: function (xml) {
                      jsonObj = eval( '(' + xml + ')');
                      var status = jsonObj.status;
                      var msg = jsonObj.msg;
                      var eepf = jsonObj.eepf;
                      var erepf = jsonObj.erepf;
                       for( var i = 0; i < Othertotal_row; i++ ) {
                         var celly = Othergrid.getCellObject( i, 0);//1st para : row , 2nd para : column seq
                         if(celly.getValue() == erepfcol){
                         Othergrid.getCellObject(i, 2).setValue(erepf);
                         }
                       }
                       for( i = 0; i < Deductiontotal_row; i++ ) {
                         celly = Deductiongrid.getCellObject( i, 1);//1st para : row , 2nd para : column seq
                         if(celly.getValue() == eepfcol){
                         Deductiongrid.getCellObject(i, 4).setValue(eepf);
                         }
                       }
                       gettotalamount();
                 }});
      }
   }


function getsocsobase(employee_socsotype,socsobasecol,ersocsocol,esocsocol){
    var type =employee_socsotype;

    if(type!="0"){
       var Incomegrid= nitobi.getGrid('IncomeDataboundGrid');
       var Deductiongrid= nitobi.getGrid('DeductionDataboundGrid');
       var Othergrid= nitobi.getGrid('OtherDataboundGrid');
       var socsobase =0;
       var Incomesocsobase =0;
       var Deductionsocsobase =0;

       var Incometotal_row = Incomegrid.getRowCount();
       for( var i = 0; i < Incometotal_row; i++ ) {
         var celly = Incomegrid.getCellObject( i, 3);//1st para : row , 2nd para : column seq
         if(celly.getValue() == 1){
         Incomesocsobase = Incomesocsobase+Incomegrid.getCellObject( i, 4).getValue();
         }
       }

       var Deductiontotal_row = Deductiongrid.getRowCount();
       for(i = 0; i < Deductiontotal_row; i++ ) {
         celly = Deductiongrid.getCellObject( i, 3);//1st para : row , 2nd para : column seq
         if(celly.getValue() == 1){
         Deductionsocsobase = Deductionsocsobase+Deductiongrid.getCellObject( i, 4).getValue();
         }
       }

       socsobase = Incomesocsobase - Deductionsocsobase;

       var Othertotal_row = Othergrid.getRowCount();
       for(i = 0; i < Othertotal_row; i++ ) {
         celly = Othergrid.getCellObject( i, 0);//1st para : row , 2nd para : column seq
         if(celly.getValue() == socsobasecol){
         Othergrid.getCellObject(i, 2).setValue(socsobase);
         }
       }
       var data = "action=calculateSOC&socsobase="+socsobase+"&employee_socsotype="+employee_socsotype;
        $.ajax({
           url: "payslip.php",type: "POST",data: data,cache: false,
                 success: function (xml) {
                      jsonObj = eval( '(' + xml + ')');
                      var status = jsonObj.status;
                      var msg = jsonObj.msg;
                      var esocso = jsonObj.esocso;
                      var ersocso = jsonObj.ersocso; 
                       for( var i = 0; i < Othertotal_row; i++ ) {
                         var celly = Othergrid.getCellObject( i, 0);//1st para : row , 2nd para : column seq
                         if(celly.getValue() == ersocsocol){
                         Othergrid.getCellObject(i, 2).setValue(ersocso);
                         }
                       }
                       for(i = 0; i < Deductiontotal_row; i++ ) {
                         celly = Deductiongrid.getCellObject( i, 1);//1st para : row , 2nd para : column seq
                         if(celly.getValue() == esocsocol){
                         Deductiongrid.getCellObject(i, 4).setValue(esocso);
                         }
                       }
                       gettotalamount();
                 }});
     }
   }