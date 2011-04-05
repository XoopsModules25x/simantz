<?php
################################################################################
#  Project : ABG Framework
#  File    : ABG_PhpToXls.cls.php
#  V1.0.0   27/03/2011
#  © G. BENABOU / ABG Soft PARIS FRANCE
#
#  PHP class to export PHP array to Excel file
#
#*******************************************************************************
#
#--- PROPERTIES-----------------------------------------------------------------
#  FileName     Xls file name
#  PhpArray     Input array to build Xls data
#  XlsDir       Output directory for Xls file
#
#--- METHODS -------------------------------------------------------------------
#  public __construct(PhpArray, XlsDir, FileName, PrtMsg)
#    Initialize class & set properties
#...............................................................................
#   public BuildXls(PhpArrayl)
#    Main loop on PhpArray to build xls cells
#...............................................................................
#  public SaveFile()
#    Utility to write xls file to disk
#...............................................................................
#  public SendFile()
#    Utility to HTTP-send xls data to caller
#
#--- EXCEPTIONS ----------------------------------------------------------------
#  . Unknown GET attribute      : Specified attribute is not a property
#  . Unknown SET attribute      :             -id-
#  . Unable to create directory : Failure while buiding XlsDir directory
#  . Null  PHP input array      : Source array is null
#  . Unable to open Xls file    : Failure while opening Xls file for writing
#  . Invalid Xls file name      : ill formatted name
#  . Xls data not available     : Assignement of PhpArray property never made
################################################################################

/*** Required stuff ***********************************************************/
  // None

### Class  ABG_PhpToXls ########################################################
class ABG_PhpToXls	{
  /*** Loacal constants *******************************************************/
  const C_DefName = 'ABG';      // Default for xls file name
  /*** Private Properties *****************************************************/
  private $PrtMsg;              // Allow/deny printing end message after saving file
  private $XlsData;             // Xls representaion of input PHP array
  //... Get'able ......
  private $_PhpArray = array();
  private $_XlsDir;
  private $_FileName;

  ### C O N S T R U C T O R  ###################################################
  /*** obj __construct(array PhpArray, str XlsDir, FileName, bool PrtMsg) ********
   Initialize class & set properties
   - PhpArray : PHP array to convert to Xls
   - XlsDir   : Directory for xls file; default to current
   - FileName : Name for xls file; default to 'ABG'
   - PrtMsg   : Validate printing exit message in SaveFile; default to false
   - RETURN   : ABG_PhpToXls object
  *****************************************************************************/
  public function __construct($_PhpArray=null, $_XlsDir=null, $_FileName=null, $_PrtMsg=false) {
    $this->XlsDir   = $_XlsDir;
    $this->FileName = $_FileName;
    if(isset($_PrtMsg))
      $this->PrtMsg = $_PrtMsg;
    if(isset($_PhpArray))
      $this->PhpArray = $_PhpArray;
  } // ABG_PhpToXls::__construct

  /*** mixed __Get(str Attr) **************************************************/
  protected function __Get($_Attr){
    switch($_Attr){
      case 'PhpArray'  : //flow
      case 'XlsDir'   : // flow
      case 'FileName' : $Attr_ = "_$_Attr"; return($this->$Attr_);
      default         : throw new exception("Unknown GET attribute <u><b>$_Attr</b></u>");
    }
  } // ABG_PhpToXls::__Get

  /*** void __Set(str Attr, Mixed Value) **************************************/
  protected function __Set($_Attr, $_Value){
    switch($_Attr){
      case 'PhpArray'  : $this->BuildXls($_Value); break;
      case 'XlsDir'   :
        if(isset($_Value)) {
          $_Value = rtrim($_Value, "/\\");
          if(!is_dir($_Value))
            if(!@mkdir($_Value, 0777, true))
              throw new exception("Unable to create directory <u><b>$_Value</b></u>");
          $this->_XlsDir = $_Value;
        } else
          $this->_XlsDir = getcwd();
        break;
      case 'FileName' :
        if(isset($_Value)){
          $P_ = pathinfo($_Value, PATHINFO_FILENAME);
          $N_ = preg_match ("/[\"%,\'\/:;<>?]/", $_Value);
          if(empty($P_) || (bool)$N_)
            throw new exception("Invalid Xls file name <u><b>\"$_Value\"</b></u>");
          if(strtolower(pathinfo($_Value, PATHINFO_EXTENSION)) <> 'xls')
            $_Value = "$_Value.xls";
          $this->_FileName = $_Value;
        } else
        $this->_FileName = self::C_DefName;
        break;
      default         : throw new exception("Unknown SET attribute <u><b>$_Attr</b></u>");
    }
  } // ABG_PhpToXls::__Set

  ### P U B L I C  M E T H O D S  ##############################################
  /**** str BuildXls(array PhpArray) ********************************************
  Main loop on PhpArray to build xls cells
  - PhpArray : Optional; array to parse
  - RETURN  : Xls data (also in XlsData)
  *****************************************************************************/
  public function BuildXls($_PhpArray=null) {
    $this->XlsData = "";
    if(isset($_PhpArray))
      $this->_PhpArray = $_PhpArray;
    $_PhpArray = $this->_PhpArray;
    if(!isset($_PhpArray))
      throw new exception('Null PHP input array');
    $Res_ = pack("S*", 0x809, 8, 0,0x10, 0, 0);
    foreach($_PhpArray as $RowNo_=>$RowS_)
      foreach($RowS_ as $ColNo_=>$Cell_)
        $Res_ .= $this->BuildCell($RowNo_, $ColNo_, $Cell_);
    $Res_ .= pack('S*', 0x0A, 0);
    $this->XlsData = $Res_;
    return($Res_);
  } // ABG_PhpToXls::BuildXls

  /*** void SaveFile() *********************************************************
  Utility to write xls file to disk
  *****************************************************************************/
  public function SaveFile() {
    if(empty($this->XlsData))
      throw new exception('Xls data not available');
    $Path_ = $this->_XlsDir.DIRECTORY_SEPARATOR.$this->_FileName;
    $Hnd_      = @fopen($Path_, "wb");
    if($Hnd_===false)
      throw new exception("Unable to open Xls file <u><b>$Path_</b></u>");
    fwrite($Hnd_, $this->XlsData);
    fclose($Hnd_);
$Msg_ = <<< ABGHereDoc
  <div style="color: ActiveCaption; font: bold 18px sans-serif; padding-top:48px; text-align: center;">
     File <span style="color: red;">$Path_ </span> now saved to disk
  </div>
ABGHereDoc;
    if($this->PrtMsg)
      print($Msg_) ;
  } // ABG_PhpToXls::SaveFile

  /*** void SendFile()**********************************************************
  Utility to send (HTTP) xls data to caller
  *****************************************************************************/
  public function SendFile(){
    if(empty($this->XlsData))
      throw new exception('Xls data not available');
    header("Cache-Control: no-cache, must-revalidate");
    header("Content-Description: ABG_PhpToXls Generated XLS Data");
    header("Content-Disposition: attachment; filename=\"$this->_FileName\"");
    header('Content-Transfer-Encoding: binary');
    header('Content-Type: application/force-download');
    header('Content-Type: application/octet-stream');
    header("Content-type: application/x-msexcel");
    header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
    header("Last-Modified: ".gmdate("D,d M YH:i:s")." GMT");
    header("Pragma: no-cache");
    print($this->XlsData);
  } // ABG_PhpToXls::SendFile

  /*** void ExceptPrint(Except) ************************************************
  Utility to print error message from exceptions
  *****************************************************************************/
  static public function ExceptPrint($_Except){
    $Msg_  = "<b>Fatal ".get_class($_Except)." : </b>";
    $Msg_ .= $_Except->GetMessage()." in <b>".$_Except->GetFile();
    $Msg_ .= "</b> on line <b>".$_Except->GetLine()."</b><br />\n";
    print($Msg_);
  } // ABG_PhpToXls::ExceptPrint

  ### P R I V A T E   M E T H O D S  ###########################################
  /*** str BuildCell(RowNo, ColNo, Cell) ***************************************
  Utility to build cell data according to type(int, float, string, boolean)
  - RowNo   : Row number in spread sheet
  - ColNo   : Column
  - Cell    : Data to convert to xls format
  - RETURN  : Piece of formatted data for the cell
  *****************************************************************************/
  private function BuildCell($_RowNo, $_ColNo, $_Cell)  {
    if(is_string($_Cell)) {
      $Len_ = strlen($_Cell);
      return(pack("S*", 0x0204, $Len_ + 8, $_RowNo, $_ColNo, 0x00, $Len_).$_Cell);
    }
    if(is_int($_Cell))
      return(pack("S*", 0x027E, 10, $_RowNo, $_ColNo, 0x00).pack("I", ($_Cell<<2) | 2));
    if(is_float($_Cell))
      return(pack("S*", 0x0203, 14, $_RowNo, $_ColNo, 0x00).pack("d", $_Cell));
    if(is_bool($_Cell))
      return($this->BuildCell($_RowNo, $_ColNo, (int)($_Cell ? 1 : 0)));
    // Returns a null cell
    return(pack("S*", 0x0201, 6, $_RowNo, $_ColNo, 0x17));
  } // ABG_PhpToXls::BuildCell

} ### End class  ABG_PhpToXls #################################################
?>