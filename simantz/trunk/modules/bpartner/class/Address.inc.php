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

	$sql="SELECT a.*,c.country_name,r.region_name from $this->tableaddress a
                    inner join sim_region r on a.region_id=r.region_id
                    inner join sim_country c on c.country_id=a.country_id
                    where address_id=$address_id";

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
                $this->country_name=$row['country_name'];
                $this->region_name=$row['region_name'];
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

 public function getAddress($bpartner_id,$type){
//i =invoice,s=shipment

if($type=="i")
    $wherestr=" and a.isinvoice=1 ";
else
    $wherestr=" and a.isshipment=1";


  $sql="SELECT a.*,c.country_name,r.region_name from $this->tableaddress a
        left join sim_region r on a.region_id=r.region_id
        left join sim_country c on c.country_id=a.country_id
        where a.bpartner_id=$bpartner_id and a.isactive=1 $wherestr order by seqno ASC";
$query=$this->xoopsDB->query($sql);

while($row=$this->xoopsDB->fetchArray($query)){
        $country_name=$row['country_name'];
        $region_name=$row['region_name'];
        $address_street =$row['address_street'];
        $address_postcode=$row['address_postcode'];
        $address_city=$row['address_city'];
        $tel_1=$row['tel_1'];
        $tel_2=$row['tel_2'];
        $fax=$row['fax'];
         $name= "$address_street\n".
        "Tel:$tel_1 $tel_2 Fax:$fax";
        return $name;
 }
return "";
 }


 public function getAddressTxt($address_id){
//i =invoice,s=shipment


$sql="SELECT a.*,c.country_name,r.region_name from $this->tableaddress a
        left join sim_region r on a.region_id=r.region_id
        left join sim_country c on c.country_id=a.country_id
        where a.address_id=$address_id ";
$query=$this->xoopsDB->query($sql);

while($row=$this->xoopsDB->fetchArray($query)){
        $country_name=$row['country_name'];
        $region_name=$row['region_name'];
        $address_street =$row['address_street'];
        $address_postcode=$row['address_postcode'];
        $address_city=$row['address_city'];
        $tel_1=$row['tel_1'];
        $tel_2=$row['tel_2'];
        $fax=$row['fax'];
         $name= "$address_street\n".
        "$address_postcode $address_city\n".
        "$region_name $country_name";
        return $name;
 }
 
return "";
 }

} // end of ClassJobposition
?>
