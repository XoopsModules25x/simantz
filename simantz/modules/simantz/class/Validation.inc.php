<?php

class Validation
{
    private $validationMsg;

    public function Validation(){}
    public function returnXMLResult($value,$validationtype,$arrpattern){

        switch($validationtype){
            case "numeric":
                if(is_numeric($value))
                    $status=true;
                else{
                    $status=false;
                    $msg="Invalid number!";
                }
                break;
            case "text":
                if(trim($value)==""){
                    $msg="No input found";
                    $status =false;
                }
                else{
                    $msg="";
                    $status= true;
                }
                break;
        }
        
        $xml="<?xml version='1.0' encoding='utf-8'' ?>
            <Result>
            <validation id='id'>
            <status>$status</status>
            <msg>$msg</msg>
            </validation>
            </Result>";
        return $xml;
    }

    public function isValidatedNumber($value,$startlimit,$endlimit){
        if(is_numeric($value)){
            if($startlimit==""){
                return true;
                }
            else{
                if($value>=$startlimit && $value<=$endlimit)
                    return true;
                else{
                    return false;
                }
            }
        }
        else{
      
           return false;
        }
    }

    public function isValidatedText($value,$arrBlockString,$arrAllowString){
        if(trim($value)!="")
        return true;
        else
        return false;
    }
}
?>