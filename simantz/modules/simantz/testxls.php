<?php
################################################################################
#  Project : ABG Framework
#  File    : TstXls.php
#  V1.0.0   27/03/2011
#  © G. BENABOU / ABG Soft PARIS FRANCE
#
#  Test bed for ABG_PhpToXls.cls.php class
#
################################################################################

include('class/ABG_PhpToXls.cls.php');
  $TstArray=array( array(1.222,'B1',  'C1',  'D1', 'E1'),
                   array(2237, 'B2',  'C2',  'D2', 'E2', 'F2'),
                   array('A3', 'B3',   true, 'D3', 3456),
                   array(44475, false, 'C4', 52.643e1),
                   array(5689, 'B5',  'C5',  'D5', 'E5', 'F5', null, 'H5')
                );
  try{
    $PhpToXls = new ABG_PhpToXls($TstArray, 'upload', 'Sample.xls', true);
//    $PhpToXls->SendFile();
    $PhpToXls->SaveFile();
  }
  catch(Exception $Except){
    ABG_PhpToXls::ExceptPrint($Except);
  }
?>

