<?php


class ConversionRate
{
  public $conversion_id;
  public $currencyfrom_id;
  public $currencyto_id;
  public $organization_id;
  public $multiplyvalue;
  public $effectivedate;
  public $description;
  public $isactive;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $isdeleted;
  private $xoopsDB;


  private $log;


//constructor
   public function ConversionRate(){
	global $xoopsDB,$log;
  	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
   }
  
  public function fetchConversionRate( $conversion_id) {
	$this->log->showLog(3,"Fetching fetchConversionRate($conversion_id)");
	$sql="SELECT conversion_id,currencyfrom_id,currencyto_id,isactive,organization_id,isdeleted,
                multiplyvalue,effectivedate,description
            from sim_conversionrate
			where conversion_id=$conversion_id";
	$this->log->showLog(4,"Country->fetchCountry, before execute:" . $sql . "<br>");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
                $this->currencyfrom_id=$row['currencyfrom_id'];
                $this->currencyto_id=$row['currencyto_id'];
                $this->organization_id=$row['organization_id'];
                $this->multiplyvalue=$row['multiplyvalue'];
                $this->effectivedate=$row['effectivedate'];
                $this->description=$row['description'];
                $this->isdeleted=$row['isdeleted'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"ConversionRate->fetchConversionRate,database fetch into class successfully");
	$this->log->showLog(4,"conversionrate:$this->multiplyvalue");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Country->fetchConversionRate,failed to fetch data into databases:" . mysql_error());
	}
  } // end of member function fetchCountry

   public function allowDelete($id){
       $this->log->showLog(2,"Call function allowDelete($id)");
       $this->log->showLog(3,"return true");

       return true;
   }

} // end of ClassCountry
?>
