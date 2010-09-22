<?php


class Address
{

  public $address_id;
  public $address_name;
  public $description;
  public $organization_id;
  public $isactive;
  public $isshipment;
  public $isinvoice;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $address_street;
  public $address_postcode;
  public $address_city;
  public $region_id;
  public $country_id;
  public $bpartner_id;
  public $tel_1;
  public $tel_2;
  public $fax;

  public $orgctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablejobposition;
  private $tablebpartner;

  private $log;


//constructor
   public function Address(){
	global $xoopsDB,$log,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
        $this->tableaddress="sim_address";
	$this->log=$log;
   }

  public function fetchAddress($address_id) {


	$this->log->showLog(3,"Fetching address detail into class Address.php.<br>");

	$sql="SELECT * from $this->tableaddress where address_id=$address_id";

	$this->log->showLog(4,"ProductAddress->fetchAddress, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->jobposition_name=$row["address_name"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];
		$this->isshipment=$row['isshipment'];
		$this->isinvoice=$row['isinvoice'];
		$this->address_street=$row['address_street'];
		$this->description=$row['description'];

		$this->address_postcode=$row['address_postcode'];
		$this->address_city=$row['address_city'];
		$this->region_id=$row['region_id'];
		$this->country_id=$row['country_id'];
		$this->bpartner_id=$row['bpartner_id'];
		$this->tel_1=$row['tel_1'];
		$this->tel_2=$row['tel_2'];
		$this->fax=$row['fax'];
   	$this->log->showLog(4,"Address->fetchAddress,database fetch into class successfully");
	$this->log->showLog(4,"Address Name:$this->address_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Address->fetchAddress,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchJobposition

 

} // end of ClassJobposition
?>
