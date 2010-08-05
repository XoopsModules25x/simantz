<?php

class Selection{
private $log;
private $xoopsDB;

public function Selection(){
    global $log,$xoopsDB;
    $this->log=$log;
    $this->xoopsDB=$xoopsDB;
}

public function showModule(){
       
    }

public function showCountry(){
       
    }

public function showCurrency($wherestring){
   $this->log->showLog(2,"Access Selection.inc.php showCurrency($wherestring)");

    global $defaultorganization_id,$getHandler;
    $sql = "SELECT currency_id,currency_name,isactive
            FROM sim_currency where isactive=1 and isdeleted=0 ";
       $this->log->showLog(4,"with sql: $sql");

$query = $this->xoopsDB->query($sql);
while ($row=$this->xoopsDB->fetchArray($query))
{
 $record = New EBARecord($row['currency_id']);
  $record->add("currency_id", $row['currency_id']);
  $record->add("currency_name", $row['currency_name']);
  $record->add("isactive", $row['isactive']);

 $getHandler->add($record);

}
   $this->log->showLog(2,"Exit Selection.inc.php showCurrency()");

    }

public function showWindow($wherestring=""){
      
    }

public function showBPartnerGroup($wherestring){
     $this->log->showLog(2,"Access Selection.inc.php showBPartnerGroup($wherestring)");

    global $defaultorganization_id,$getHandler;
    $sql = "SELECT bpartnergroup_id,bpartnergroup_name,description,isactive
            FROM sim_bpartnergroup where isactive=1 and isdeleted=0 and
             organization_id=$defaultorganization_id";
       $this->log->showLog(4,"with sql: $sql");

$query = $this->xoopsDB->query($sql);
while ($row=$this->xoopsDB->fetchArray($query))
{
 $record = New EBARecord($row['bpartnergroup_id']);
  $record->add("bpartnergroup_id", $row['bpartnergroup_id']);
  $record->add("bpartnergroup_name", $row['bpartnergroup_name']);
  $record->add("isactive", $row['isactive']);

 $getHandler->add($record);

}
   $this->log->showLog(2,"Exit Selection.inc.php showBPartnerGroup()");

    }

public function showIndustry($wherestring){
     $this->log->showLog(2,"Access Selection.inc.php showIndustry($wherestring)");

  global $defaultorganization_id,$getHandler;
        $sql = "SELECT industry_id,industry_name,isactive
            FROM sim_industry where isactive=1 and isdeleted=0 and
             organization_id=$defaultorganization_id";
$query = $this->xoopsDB->query($sql);
   $this->log->showLog(4,"with sql: $sql");

while ($row=$this->xoopsDB->fetchArray($query))
{
 $record = New EBARecord($row['industry_id']);
  $record->add("industry_id", $row['industry_id']);
  $record->add("industry_name", $row['industry_name']);
  $record->add("isactive", $row['isactive']);

 $getHandler->add($record);

}
   $this->log->showLog(2,"Exit Selection.inc.php showIndustry()");


    }

public function showEmployee($wherestring){
   $this->log->showLog(2,"Access Selection.inc.php showEmployee($wherestring)");
  global $defaultorganization_id,$getHandler;
        $sql = "SELECT employee_id,employee_name,isactive
            FROM sim_simiterp_employee where isactive=1 and isdeleted=0 and
             organization_id=$defaultorganization_id";
$query = $this->xoopsDB->query($sql);
   $this->log->showLog(4,"With sql: $sql");

while ($row=$this->xoopsDB->fetchArray($query))
{
 $record = New EBARecord($row['employee_id']);
  $record->add("employee_id", $row['employee_id']);
  $record->add("employee_name", $row['employee_name']);
  $record->add("isactive", $row['isactive']);

 $getHandler->add($record);

}

   $this->log->showLog(2,"exit Selection.inc.php showEmployee()");

    }

    public function showTerms($wherestring){
   $this->log->showLog(2,"Access Selection.inc.php showTerms($wherestring)");

global $defaultorganization_id,$getHandler;
        $sql = "SELECT terms_id,terms_name,isactive
            FROM sim_terms where isactive=1 and isdeleted=0 and
             organization_id=$defaultorganization_id";
$query = $this->xoopsDB->query($sql);
   $this->log->showLog(4,"with sql: $sql");

while ($row=$this->xoopsDB->fetchArray($query))
{
 $record = New EBARecord($row['terms_id']);
  $record->add("terms_id", $row['terms_id']);
  $record->add("terms_name", $row['terms_name']);
  $record->add("isactive", $row['isactive']);

 $getHandler->add($record);

}

   $this->log->showLog(2,"Exit Selection.inc.php showTerms()");

    }

       public function showTax($wherestring){
   $this->log->showLog(2,"Access Selection.inc.php showTax($wherestring)");

global $defaultorganization_id,$getHandler;
        $sql = "SELECT tax_id,tax_name,isactive
            FROM sim_tax where isactive=1 and isdeleted=0 and
             organization_id=$defaultorganization_id";
$query = $this->xoopsDB->query($sql);
   $this->log->showLog(4,"with sql: $sql");

while ($row=$this->xoopsDB->fetchArray($query))
{
 $record = New EBARecord($row['tax_id']);
  $record->add("tax_id", $row['tax_id']);
  $record->add("tax_name", $row['tax_name']);
  $record->add("isactive", $row['isactive']);

 $getHandler->add($record);

}

   $this->log->showLog(2,"Exit Selection.inc.php showTax()");

    }

       public function showAccounts($wherestring){
   $this->log->showLog(2,"Access Selection.inc.php showAccounts($wherestring)");

global $defaultorganization_id,$getHandler;
        $sql = "SELECT accounts_id,concat(accountcode_full,accounts_name) as accounts_name,isactive
            FROM sim_simbiz_accounts  where isactive=1 and isdeleted=0 and
             organization_id=$defaultorganization_id";
$query = $this->xoopsDB->query($sql);
   $this->log->showLog(4,"with sql: $sql");

while ($row=$this->xoopsDB->fetchArray($query))
{
 $record = New EBARecord($row['accounts_id']);
  $record->add("accounts_id", $row['accounts_id']);
  $record->add("accounts_name", $row['accounts_name']);
  $record->add("isactive", $row['isactive']);

 $getHandler->add($record);

}

   $this->log->showLog(2,"Exit Selection.inc.php showAccounts()");

    }


        public function showPriceList($wherestring){
   $this->log->showLog(2,"Access Selection.inc.php showPriceList($wherestring)");

global $defaultorganization_id,$getHandler;
        $sql = "SELECT pricelist_id,pricelist_name,isactive
            FROM sim_simiterp_pricelist where isactive=1 and isdeleted=0 and
             organization_id=$defaultorganization_id";
$query = $this->xoopsDB->query($sql);
   $this->log->showLog(4,"with sql: $sql");

while ($row=$this->xoopsDB->fetchArray($query))
{
 $record = New EBARecord($row['pricelist_id']);
  $record->add("pricelist_id", $row['pricelist_id']);
  $record->add("pricelist_name", $row['pricelist_name']);
  $record->add("isactive", $row['isactive']);

 $getHandler->add($record);

}

   $this->log->showLog(2,"Exit Selection.inc.php showAccounts()");

    }

}
?>