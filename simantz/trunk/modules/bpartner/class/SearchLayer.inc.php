<?php

class SearchLayer{
	private $xoopsDB;
	private $log;

  
	public function SearchLayer(){
		global $xoopsDB,$log,$ctrl;
		$this->xoopsDB=$xoopsDB;
		$this->ctrl=$ctrl;
		$this->log=$log;
		}
		
		
		public function ctrlBPartner($arrfieldid,$arrfieldname,$arrvalue,$col=1,$changefunction,$bpartneraccounttype){
			if($arrfieldid[0]!='')
				$field1_id=$arrfieldid[0];
			else
				$field1_id='bpartner_id';
			if($arrfieldid[1]!='')
				$field2_id=$arrfieldid[1];
			else
				$field2_id='bpartner_no';
			if($arrfieldid[2]!='')
				$field3_id=$arrfieldid[2];
			else
				$field2_id='bpartner_name';
			
			if($arrfieldname[0]!='')				
				$field1_name=$arrfieldname[0];
			else
				$field1_name='bpartner_id';
			if($arrfieldname[1]!='')				
				$field2_name=$arrfieldname[1];
			else
				$field2_name='bpartner_no';
			if($arrfieldname[2]!='')				
				$field3_name=$arrfieldname[2];				
			else
				$field3_name='bpartner_name';
				
			if($arrvalue[0]!='')
				$value1=$arrvalue[0];
			else
				$value1=0;
				
			if($arrvalue[1]!='')
				$value2=$arrvalue[1];
			else
				$value2='';
			if($arrvalue[2]!='')
				$value3=$arrvalue[2];
			else
				$value3='';
				
				switch($col){
					case 0:
						$field1readonly='input type="hidden"';
						$field2readonly='readonly="readonly"';
						$field3readonly='readonly="readonly"  class="graybg" ';
						$function="openbpartnerwindow(document.getElementById('$field1_id').value,$col,'$field1_id','$field2_id','$field3_id','$bpartneraccounttype')";
					break;
					case 1:
						$field1readonly='input type="hidden"';
						$field2readonly=" onchange=$changefunction " ;
						$field3readonly='readonly="readonly" class="graybg" DISABLED';
						$function="openbpartnerwindow(document.getElementById('$field2_id').value,$col,'$field1_id','$field2_id','$field3_id','$bpartneraccounttype')";
					break;
					case 2:
						$field1readonly='input type="hidden"';
						$field2readonly='readonly="readonly"  class="graybg" DISABLED';
						$field3readonly="  onchange=$changefunction ";
						$function="openbpartnerwindow(document.getElementById('$field3_id').value,$col,'$field1_id','$field2_id','$field3_id','$bpartneraccounttype')";
					break;
				}
				return "<input id='$field1_id' name='$field1_name'  value='$value1' $field1readonly>
			<input id='$field2_id' name='$field2_name'  value='$value2' size='8' $field2readonly>
			<input id='$field3_id' name='$field3_name'  value='$value3' size='25' $field3readonly>
			<img onclick=$function src='../simantz/images/zoom.png' style='cursor:pointer'>";
			}
			
		public function showBPartnerJS(){
			
echo <<< EOF

<script>
var col1='';
var col2='';
var col3='';
var c=0;
function choose(value1,value2,value3,event){
	
	if(event=='' || event.keyCode==13){
	document.getElementById(col1).value=value1;
	document.getElementById(col2).value=value2;
	document.getElementById(col3).value=value3;
	$("#"+col1).change();
	$("#"+col2).change();
	$("#"+col3).change();
	$("#idApprovalWindows").fadeOut("fast").html(null);
    }
	}


function openbpartnerwindow(searchtxt,col,c1,c2,c3,bpartneraccounttype){
col1=c1;
col2=c2;
col3=c3;
c=col;
 var data="action=showBPartnerSearchForm&col="+col+"&bpartneraccounttype="+bpartneraccounttype+"&searchtxt="+searchtxt;
     $.ajax({url: "../bpartner/searchlayer.php",type: "POST",data: data,cache: false,
             success: function (xml) {
                            document.getElementById('idApprovalWindows').innerHTML = xml;
                            document.getElementById('idApprovalWindows').style.display = "";
                            self.parent.scrollTo(0,0);
                            //append dynamic javascript
                            
                            if(searchtxt!='')
								searchbpartner();
					//	$.getScript('searchlayer.php?action=jsbpartner', function(data, textStatus){});

             }});

}



 function searchbpartner(){

            var data=$("#frmsearchbpartner").serialize();
            $.ajax({
                 url: "../bpartner/searchlayer.php",type: "POST",data: data,cache: false,
                     success: function (xml) {
                      $("#frmsearchbpartner").slideDown("slow",function(){
                           document.getElementById('searchbpartnerresult').innerHTML = xml;
                           
                           if(document.getElementById('layerrowcount'))
							if(document.getElementById('layerrowcount').value>0)
										document.getElementById('chooseline_1').focus();
										
										$(window).keydown(function(event){
										if(event.keyCode == 13){
												$("#idApprovalWindows").fadeOut("fast").html("");

										}});

                       })


					

                }});
    }
    
    
     $(document).ready(function(){
		var c='';
	if(ccol==1)
	c=col2;
	else
	c=col3;
	   if(document.getElementById(c).value!='')
		searchbpartner();
 });
 
 </script>
 
EOF;


	 
}

	 public function GetBpartnerWindow($searchtxt,$col,$bpartneraccounttype){
	global $ctrl;
    include "../bpartner/class/BPSelectCtrl.inc.php";
    

    $cur_ctrl = $this->ctrl->getSelectCurrency(0,'Y');
    $bpctrl = new BPSelectCtrl();

    $this->bpartnergroupctrl=$bpctrl->getSelectBPartnerGroup(0,'Y');
    $this->industryctrl=$bpctrl->getSelectIndustry(0,'Y');
    if($col==1)
    $searchbpartner_no=$searchtxt;
    else
    $searchbpartner_name=$searchtxt;
    
echo <<< EOF

<div class="dimBackground"></div>
<div align="center" >
<form id="frmsearchbpartner" name="frmsearchbpartner" onsubmit='return false'>

<table>
 <tr>
  <td astyle="vertical-align:middle;" align="center">

    <table class="floatWindow" style="width:900px">
       <tr class="tdListRightTitle" >
          <td colspan="4">
                <table><tr>
                <td id="idHeaderText" align="center">Business Partner Search Form</td>
                <td align="right" width="30px"><img src="../simantz/images/close.png" onclick="closeWindow();" style="cursor:pointer" title="Close"></td>
                </tr></table>
          </td>
       </tr>

   <tr>
      <td class="head">Business Partner No
</td>
      <td class="even"><input type="text" $colstyle name="searchbpartner_no" id="searchbpartner_no" value="$searchbpartner_no"/></td>
      <td class="head">Business Partner Name</td>
      <td class="even"><input type="text" $colstyle name="searchbpartner_name" id="searchbpartner_name" value="$searchbpartner_name"/></td>
   </tr>

   <tr>
      <td class="head">Business Partner Group</td>
      <td class="even">
         <select name="searchbpartnergroup_id" id="searchbpartnergroup_id" $colstyle>
           $this->bpartnergroupctrl
         </select>
      </td>
      <td class="head">Industry</td>
      <td class="even">
         <select name="searchindustry_id" id="searchindustry_id" $colstyle>
           $this->industryctrl
         </select>
      </td>

   </tr>

   <tr>
      <td class="head">In Charge Person</td>
      <td class="even"><input type="text" $colstyle name="searchpic" id="searchpic" value="$this->searchpic"/></td>
      <td class="head">Is Active</td>
      <td class="even">
           <select $colstyle name="searchisactive" id="searchisactive">
             <option value="0" >Null</option>
             <option value="Y" >Yes</option>
             <option value="N" >No</option>
          </select>
      </td>
   </tr>

   <tr>
        <td class="head">Currency</td>
        <td class="even" colspan="2"><select $colstyle name="currency_id">$cur_ctrl</select></td>
   </tr>

   <tr>
      <td $style colspan="4">
      <input type="hidden" name="issearch" id="issearch" value="Y"/>
      <input type="hidden" name="bpartneraccounttype"  value="$bpartneraccounttype"/>
      <input type="hidden" name="action" value="showBPartnerSearchResult"/>
      <input type="button" value="Search" onclick="searchbpartner()"/>
      <input type="button" value="Reset" onclick="reset();"/></td>
   </tr>

   <tr>
      <td align="left" colspan="4">
        <div id="searchbpartnerresult"></div>
      </td>
   </tr>
   
 </table>

    </td>
  </tr>
</table>
</form>
</div>
EOF;

  }
  
  public function showBPartnerResult(){
	   global $defaultorganization_id;

        $warr = array();
         array_push($warr, "bp.bpartner_id > 0");
        if($this->searchbpartner_no!="")
               array_push($warr, "bp.bpartner_no LIKE '%$this->searchbpartner_no%'");

        if($this->searchbpartner_name!="")
               array_push($warr, "bp.bpartner_name LIKE '%$this->searchbpartner_name%'");

        if($this->searchbpartnergroup_id!="0" and $this->searchbpartnergroup_id != "")
                 array_push($warr, "bp.groupid = '$this->searchbpartnergroup_id'");

        if($this->searchindustry_id!="0" and $this->searchindustry_id!="")
                 array_push($warr, "bp.industry_id = '$this->searchindustry_id'");

        if($this->searchpic != "")
                array_push($warr, "bp.inchargeperson LIKE '%$this->searchpic%'");

        if(isset($this->searchisactive) && $this->searchisactive != "0" && $this->searchisactive != "")
           {
                 $this->searchisactive = $this->searchisactive== 'Y' ? 1 : 0;
                array_push($warr, "bp.isactive = '$this->searchisactive'");
           }
 
        if($this->currency_id != "0" && $this->currency_id != "null")
           array_push($warr,  "bp.currency_id = $this->currency_id");

	
        //   array_push($warr, "bp.organization_id = $defaultorganization_id");
         $whrstr = implode(" AND ",$warr);
        
	 $sql="SELECT bp.bpartner_id,
                      bp.bpartner_name,
                      bp.bpartner_no,
                      bg.bpartnergroup_name,
                      cur.currency_code,
                      bp.inchargeperson
	      FROM sim_bpartner as bp
              INNER JOIN sim_bpartnergroup bg ON bp.bpartnergroup_id  = bg.bpartnergroup_id 
              INNER JOIN sim_currency as cur ON cur.currency_id = bp.currency_id
        
              
			WHERE $whrstr
              ORDER BY bp.seqno, bp.bpartner_name ASC";
        
	$this->log->showLog(3,"Showing GetSearchBpartnerResult Table");
	$this->log->showLog(4," $this->searchmember_no With SQL:$sql");
        $this->j=1;
	$operationctrl="";
	echo <<< EOF
<div style="height:450px;overflow:auto;">


<table id="searchitemtable" style="text-align: left;" border="0" cellpadding="0" >
 <tbody>
 
   <tr>
        <td class="tdListRightTitle" >$this->bpartneraccounttype</td>
     <td class="tdListRightTitle" >B.Partner No.</td>
     <td class="tdListRightTitle" >Business Partner Name</td>
     <td class="tdListRightTitle" >Business Partner Group</td>
     <td class="tdListRightTitle" >Currency</td>



   </tr>

EOF;
$rowtype="";
	$i=0;
	$query=$this->xoopsDB->query($sql);
        //echo $sql;
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		if($i==1)
			$checked='checked';
		else
			$checked='';
		$bpartner_id=$row['bpartner_id'];
		$bpartner_no=$row['bpartner_no'];
		$bpartner_name=htmlspecialchars($row['bpartner_name']);
        $cur = $row['currency_code'];
        $group = $row['bpartnergroup_name'];
        $incharge = $row['inchargeperson'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

	$choose="<input type='radio' $checked name='chooseline' id='chooseline_$i' value='$bpartner_no' onKeyDown=\"choose('$bpartner_id','$bpartner_no','$bpartner_name',event)\" ondblclick=\"choose('$bpartner_id','$bpartner_no','$bpartner_name','')\">";
		echo <<< EOF

		<tr class="bpartner_row">
		<td class="$rowtype" style="text-align:center;">$choose</td>
			<td class="$rowtype" style="text-align:left;">$bpartner_no</td>
			<td class="$rowtype bpartner_name" style="text-align:left;"><a href='../bpartner/bpartner.php?action=viewsummary&bpartner_id=$bpartner_id' target='_blank'>$bpartner_name</a></td>
			<td class="$rowtype" style="text-align:center;">$group</td>
            <td class="$rowtype" style="text-align:center;">$cur</td>

			
		</tr>
EOF;
        }
echo "
    </tbody>
  </table>
  <input id='layerrowcount' value=$i type='hidden'>

</div>";

	  }
	
	
		
		
	
}
