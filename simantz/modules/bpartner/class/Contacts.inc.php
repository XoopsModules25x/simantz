<?php


class Contacts
{

  public $address_id;
  public $contacts_name;
  public $description;
  public $organization_id;
  public $isactive;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $greeting;
  public $alternatename;
  public $hpno;
  public $religion_id;
  public $email;
  public $bpartner_id;
  public $position;
  public $races_id;
  public $department;

  public $orgctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablejobposition;
  private $tablebpartner;

  private $log;

//constructor
   public function Contacts(){
	global $xoopsDB,$log,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
        $this->tablecontacts="sim_contacts";
	$this->log=$log;
   }

  public function fetchContacts($contacts_id) {


	$this->log->showLog(3,"Fetching contact detail into class Contact.php.<br>");

	$sql="SELECT * from $this->tablecontacts                   
                    where contacts_id=$contacts_id";

	$this->log->showLog(4,"fetchContacts, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->address_id=$row["address_id"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];
		$this->position=$row['position'];
		$this->contacts_name=$row['contacts_name'];
		$this->description=$row['description'];
		$this->department=$row['department'];
		$this->email=$row['email'];
		$this->religion_id=$row['religion_id'];
		$this->races_id=$row['races_id'];
                $this->alternatename=$row['alternatename'];
                $this->hpno=$row['hpno'];
		$this->bpartner_id=$row['bpartner_id'];
		$this->greeting=$row['greeting'];
	

   	$this->log->showLog(4,"contacts->fetchContacts,database fetch into class successfully");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"fetchContacts->fetchContacts,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchJobposition

} // end of ClassJobposition
?>
