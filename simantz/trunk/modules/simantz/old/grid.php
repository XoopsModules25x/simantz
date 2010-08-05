<?php


require('../../mainfile.php');
include "class/nitobi.xml.php";
require(XOOPS_ROOT_PATH.'/header.php');
include "menu.php";
echo "This is grid<br/>";
echo <<< EOF
<link rel="stylesheet" href="http://localhost/simitxoops/modules/simantz/include/nitobi.grid/nitobi.grid.css" type="text/css" />
<script type="text/javascript" src="http://localhost/simitxoops/modules/simantz/include/nitobi.grid/nitobi.toolkit.js"></script>

<script type="text/javascript" src="http://localhost/simitxoops/modules/simantz/include/nitobi.grid/nitobi.grid.js"></script>
  <script language="javascript" type="text/javascript">
    function GetNewRecordID()
    {
      // Use the native cross-browser nitobi Ajax object
      var myAjaxRequest = new nitobi.ajax.HttpRequest();

      // Define the url for your generatekey script
      myAjaxRequest.handler = 'getMaxID.php?idname=groupid&tablename=sim_groups';
      myAjaxRequest.async = false;
      myAjaxRequest.get();

      myResultKey = myAjaxRequest.httpObj.responseText;
      myResultKey.replace(/s/g, '');
      myResultKey = parseInt(myResultKey) + 1;

      // return the result to the grid
      return myResultKey.toString(); 
    }
  </script> 
<ntb:grid id="DataboundGrid"       
   
     mode="livescrolling"      
     keygenerator="GetNewRecordID();"  
     autosaveenabled="false"
     gethandler="load_data.php"  
     savehandler="save_data.php"  
     toolbarenabled="true"
     theme="nitobi"
    >
   <ntb:columns>
       <ntb:textcolumn   label="Group Name"    xdatafld="name" ></ntb:textcolumn>
       <ntb:textcolumn    label="Description"   xdatafld="description"     ></ntb:textcolumn>
   <ntb:textcolumn      label="Lookup"      xdatafld="group_type" >
             <ntb:lookupeditor  delay="1000" gethandler="lookup.php" displayfields="group_type" valuefield="group_type" ></ntb:lookupeditor>
    </ntb:textcolumn>
      
 </ntb:grid> 
EOF;
require(XOOPS_ROOT_PATH.'/footer.php');

?>
