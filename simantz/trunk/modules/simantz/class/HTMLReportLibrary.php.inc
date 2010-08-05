<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportLibraryphp
 *
 * @author kstan
 */
class HTMLReportLibrary {
    //put your code here
    private $pageLayout='P';  //P or L
    private $pagewidth=0;
    private $pageheight=0;
    private $ypos=0;
    private $allowline=0;

    private $lineheight=15;
    private $currentpage=0;
    private $pageqty=0;
    private $stdcharacterwidth=15;

    public $headerlinecount=0;
    public $titlelinecount=0;
    public $footerlinecount=0;
    public $summarylinecount=0;
    public $footertext="Unknown";
    public $lastfootertext="Unknown";
    public $reportsummarytext="Unknown";
    public $lastreportsummarytext="Unknown";
    public $reportTitle="Unknown";
    private $qtylineforbody;
    public $titlearray;
    public $headercolumnwidth;
    public $letterheadline1;
    public $letterheadline2;
    public $letterheadline3;
    
    private $tablestyle = "border='0' cellpading='0' cellspacing='0'";

    private $alignc="style='text-align:center'";
    public $variablestring;
    public function HTMLReportLibrary($pageLayout){
        global $xoopsDB,$defaultorganization_id,$log,$tableorganization,
            $tableorganization;
            //300 dpi
        if($pageLayout=='P'){
            
            $this->pagewidth=2250;
            $this->pageheight=3508;
            $this->allowline=43;
            //max character per line = 150
            
        }
        else{
            $this->pagewidth=3508;
            $this->pageheight=2250;
                        $this->allowline=32;
        }
         // echo "allowline:".  $this->allowline=(integer)($this->pageheight / $this->lineheight);
            $this->tableorganization=$tableorganization;
    }

    public function reportLetterHead(){

        
       
        
        echo <<< EOF
        <table $this->tablestyle >
            <tr><td  $this->alignc width='$this->pagewidth'><TT><B>$this->letterheadline1</B></TT></td></tr>
            <tr><td  $this->alignc width='$this->pagewidth'><TT> $this->letterheadline2</TT></td></tr>
            <tr><td  $this->alignc width='$this->pagewidth'><TT>$this->letterheadline3</TT></td></tr>
        </table>
        <hr>
EOF;
        
    }


    public function reportTitle(){
         
        $this->ypos=0;
       // $variablestring=$this->variablestring;
        $titlearray=$this->titlearray;
        $w=$this->headercolumnwidth;

        
        echo "<DIV style='text-align:center'><TT><B><U>$this->reportTitle</U></b></TT><br></DIV>";
        echo "<TT>$this->variablestring</TT><br>";
        echo "<table  $tablestyle width='100%'><tr>";
        $i=0;
        $maxheight=0;
        foreach($titlearray as $title){
            $width=$w[$i]*$this->stdcharacterwidth;
           // $rowheight=$this->checkRecordHeight($title,$w[$i]);
           // $allowchar =$w[$i];
            echo "<TD $this->alignc><TT><B><U>$title</U><B></TT></td>";
            $i++;
        }
        echo "</tr>";

    }
    
    public function reportFooter(){


        echo "<TT><hr></TT>";
         
       
        echo "<div style='text-align: center;page-break-after: always'>
                <TT>$this->footertext</TT><br>
                <TT>Page Number $this->currentpage/
                <font id='page$this->currentpage'>$this->pageqty</font>
                </TT></div>";
 
                          
    }
public function latReportFooter(){


        echo "<TT><hr></TT>";


        echo "<div style='text-align: center'>
            <TT>$this->lastfootertext</TT><br>
                <TT>Page Number $this->currentpage/
                <font id='page$this->currentpage'>$this->pageqty</font>
                </TT></a><div>";


    }
    public function reportSummary(){

        echo "</table>";
          echo "<TT>$this->reportsummarytext</TT><br>";


    }

    public function lastReportSummary(){
        
        echo "</table>";
          echo "<TT>$this->lastreportsummarytext</TT><br>";
          $this->latReportFooter();

    }
        public function reportBody($dataarray,$w,$alignarray){
        $bodyheight=2;
        $tableheight=$this->lineheight*$bodyheight;
        $cellno=0;
        $rowno=0;
       
        foreach($dataarray as $row){
            //if balanceline =0 then call reportheader and title, update ypos
            //else
                //loop all cell verified this row using how many line
                //if balanceline can fill in by this record, display it and update ypos
                //display this record if fit into page, modified ypos
            //if this record more than 1 line

             $maxrowheight=0;
            echo "<tr>";
            foreach($row as $cell){
                $width=$w[$cellno]*$this->stdcharacterwidth;
                if($alignarray[$cellno]=='L'){$align="left";}
                elseif($alignarray[$cellno]=='R'){$align="right";}
                else $align="center";

                $aligntext="style='text-align:$align'";
                $allowchar =$w[$i];
                $rowheight=1; //we share detect row height here
                //$allowchar=$this->checkAllowCharInWidth($width);
                //$rowheight=$this->checkRecordHeight($cell,$allowchar );
                //
                //if($maxrowheight<$rowheight)
                 // $maxrowheight=$rowheight;
                  
               if($this->qtylineforbody<$this->ypos+$rowheight){
                   $this->reportSummary();
                   $this->reportFooter();
                   $this->currentpage++;
                   $this->reportLetterHead();
                   $this->reportTitle();
               }
                //$title=$maxrowheight;
                //  if($cellno==9)
                    
                    echo "<TD $aligntext ><TT>$cell</TT></td>
                    ";
                $cellno++;
            }
            $cellno=0;
            if($rowheight==1)
                $this->ypos++;
            elseif($rowheight==2)
                $this->ypos+=1.77;
            else
                $this->ypos+=(1+2*0.77);

            echo "</tr>";
            $rowno++;
        }
       

       
        //$this->ypos= $this->ypos+$titleheight;
        $balancerow=$this->allowline-$this->ypos-$this->footerlinecount-$this->summarylinecount-$this->headerlinecount;
        if($balancerow>0){
            for($j=1;$j<$balancerow;$j++){
                $rowno++;
                echo "<tr>";
                foreach($w as $width){
                       $width=$w[$cellno]*$this->stdcharacterwidth;
                           echo "<TD $aligntext title='$title'> <TT>&nbsp;</TT></td>
                        ";
                    $cellno++;
                }
                echo "</tr>";

            }
           // $this->reportFooter();
        }

    }

    public function checkAllowCharInWidth($width){
         $result= (integer)($width / $this->stdcharacterwidth);
         //echo $result;
         return $result;
    }

    public function checkRecordHeight($text,$allowcharqty){
     $rowcount=0;
     
    // echo "$text , $allowcharqty<br>";
     $wordarray=split(" ",$text);
   //  print_r($wordarray);
     $currentusedcharqty=0;
     $currentlinestring="";
     foreach($wordarray as $word){
         //check length
         $currentwordtotalchar=strlen($word ." ");

         //if cannot fit into currentline, consider new line
         if($allowcharqty<$currentusedcharqty+$currentwordtotalchar){
          //  echo " $currentlinestring" . strlen($currentlinestring) ."<br>";

             $rowcount++;
             $currentusedcharqty=$currentwordtotalchar;
             $currentlinestring=$word." ";
            
         }
         else{
            $currentusedcharqty+=$currentwordtotalchar;
            $currentlinestring.=$word . " ";
          
            
            }
             

     } 
       //echo " $currentlinestring" . strlen($currentlinestring) ."<br>";
     //echo "<br>".$rowcount;
           return $rowcount;
    }

    public function addPage(){

        $this->currentpage=1;
        $this->qtylineforbody=$this->allowline- $this->titlelinecount-
                    $this->headerlinecount-$this->footerlinecount-$this->summarylinecount;
        $this->reportLetterHead();
        $this->reportTitle();
    }
    public function updatePageCount(){
        
        echo <<< EOF
        <script type='text/javascript'>
  
           var i=1;
         
            while(i<=$this->currentpage){
            
            document.getElementById("page"+i).innerHTML=$this->currentpage;
            i++;
            }
  
        </script>
  
EOF;
    }
}
?>
