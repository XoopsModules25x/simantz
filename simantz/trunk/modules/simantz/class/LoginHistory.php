<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginHistory
 *
 * @author kstan
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class LoginHistory {
    private $xoopsDB;
    public $showcalendarfrom;
    public $showcalendarto;
    function LoginHistory (){
        global $xoopsDB;
        $this->xoopsDB=$xoopsDB;

    }
    function showTable($wherestring,$orderbystring){
            $logineventtable=XOOPS_DB_PREFIX . "_loginevent";
            $usertable=XOOPS_DB_PREFIX . "_users";
        $sql="SELECT e.uid,u.uname,u.name,e.eventdatetime,e.event_id,e.activity,e.ip
            FROM $logineventtable e
            INNER JOIN $usertable u on e.uid=u.uid $wherestring $orderbystring";
        $query=$this->xoopsDB->query($sql);
        echo <<< EOF
        <br>
        <table border='1'><tbody>
        <tr>
            <th>User</th>
            <th>Full Name</th>
            <th>Date/Time</th>
            <th>Activity</th>
            <th>IP</th>
        </tr>

EOF;
        while($row=$this->xoopsDB->fetchArray($query)){
            $uid=$row['uid'];
            $uname=$row['uname'];
            $name=$row['name'];
            $eventdatetime=$row['eventdatetime'];
            $activity=$row['activity'];
            $ip=$row['ip'];
            if($activity=='I')
             $activity="Login";
            elseif($activity=='O')
             $activity="Logout";
            else
             $activity="Unknown";

            if($rowtype=='odd')
             $rowtype='event';
            else
             $rowtype='odd';
            echo <<< EOF
            <tr>
                <td class="$rowtype">$uname</td>
                <td class="$rowtype">$name</td>
                <td class="$rowtype">$eventdatetime</td>
                <td class="$rowtype">$activity</td>
                <td class="$rowtype">$ip</td>
           </tr>
EOF;

        }
        echo "</tbody></table>";
    }
    function showSearchForm(){
        $userctrl=$this->getSelectUser($this->user_id);
        $activityctrl=$this->getSelectActivity($this->activity);
        echo <<<EOF
        <script type='text/javascript'>
            function validate(){
                var actionvalue=document.frm1.action.value;
                if(actionvalue=='delete'){
                    if(confirm("Confirm to remove the record?"))
                        return true;
                    else
                        return false;
                }
                 return true;
            }
        </script>
        <form name='frm1' method='POST' onsubmit='return validate()'>
        <table border="1">
        <thead>
        <tr><th colspan='4'>Search Form</th></tr>
        </thead>
        <tbody>
        <tr>
        <td>User</td>
        <td>$userctrl</td>
        <td>Activity</td>
        <td>$activityctrl</td>
        </tr>
        <tr>
        <td>Date From(YYYY-MM-DD)</td>
        <td><input name='datefrom' value="$this->datefrom" id="datefrom">
            <input type='button' value='Date' onclick="$this->showcalendarfrom"></td>
        <td>Date To(YYYY-MM-DD)</td>
        <td><input name='dateto' value="$this->dateto" id="dateto">
            <input type='button' value='Date' onclick="$this->showcalendarto"></td>
        </tr>
        <tr>
        <td><input name='submit' value="Search" type='submit' onclick='action.value="search"'></td>
        <td><input name='submit' value="Delete" type='submit' onclick='action.value="delete"'></td>
        <td><input name='action' value="search" type='hidden'></td>
        <td><input name='reset' value="Reset" type='reset'></td>
        </tr>

        </tbody>
        </table></form>

EOF;
    }

    function insertEventRecord($uid,$activity,$loginactivity="R"){
        global $_SERVER;
        
        //$loginactivity: R= keep, k = kill previous session
        $datetime=date("Y-m-d h:m:d",time());
        $logineventtable=XOOPS_DB_PREFIX . "_loginevent";
       $ip=$_SERVER["REMOTE_ADDR"];
        //$ip=$REMOTE_ADDR;
       $sql="INSERT INTO $logineventtable (uid,eventdatetime,activity,ip)
         VALUES ($uid,'$datetime','$activity','$ip')";
        $rs=$this->xoopsDB->queryf($sql);
        if(!$rs){
            echo "<b style='color:red'>Can't insert login event in database at function insertEventRecord</b>";
            return false;
            
            }
       else{
        if($loginactivity=="k")
           $this->killOthersSession($uid);
        return true;
       }
    }

    function killOthersSession($uid){
        $sessiontable=XOOPS_DB_PREFIX."_session";
        $sql="DELETE FROM $sessiontable where sess_data LIKE 'xoopsUserId|s:1:\"$uid\";%' AND sess_id <>'".session_id()."'";
        $rs=$this->xoopsDB->query($sql);
    }


      function deleteEventRecord($wherestring){
        $logineventtable=XOOPS_DB_PREFIX . "_loginhistory_loginevent";

       $sql="DELETE FROM $logineventtable $wherestring";
        $rs=$this->xoopsDB->query($sql);
        if(!$rs){
            echo "<b style='color:red'>Can't delete login event in database at function deleteEventRecord</b>";
            return false;

            }
        return true;
    }
    function getSelectActivity($act){
    switch ($act){
        case "I":
            $valuen="";
            $valuei="selected='selected'";
            $valueo="";
            break;
        case "O":
            $valuen="";
            $valuei="";
            $valueo="selected='selected'";
            break;
        default:
            $valuen="selected='selected'";
            $valuei="";
            $valueo="";
            break;
    }
        $selection="<select name='activity'>
            <option value='-' $valuen>Null</option>
            <option value='I' $valuei>Login</option>
            <option value='O' $valueo>Logout</option>
            </select>";
        return $selection;
    }
    function getSelectUser($id){
        $usertable=XOOPS_DB_PREFIX . "_users";
      $sql="SELECT uid,uname FROM $usertable";
        $query=$this->xoopsDB->query($sql);
        $selection="<SELECT name='user_id'>";
        while($row=$this->xoopsDB->fetchArray($query)){
            $uid=$row['uid'];
            $uname=$row['uname'];

           	if($id==$uid)
            	$selected='SELECTED="SELECTED"';
            else
                $selected="";
            $selection.="<option value='$uid' $selected>$uname</option>
                        ";
        }
        $selection.="</selection>";
        return $selection;
    }
    function genWhereString($uid,$act,$datefrom,$dateto,$action){
        $wherestr="";
        if($datefrom=="")
        $datefrom="0000-00-00";
        if($dateto=="")
        $dateto="9999-12-31";

        $wherestr.="WHERE eventdatetime BETWEEN '$datefrom 00:00:00' and '$dateto 23:59:59' AND";

        if($uid>0){
            if($action=='search')
             $wherestr.=" e.uid=$uid AND";
            else
            $wherestr.=" uid=$uid AND";
        }
        if($act!='-'){
            if($action=='search')
             $wherestr.=" e.activity='$act' AND";
             else
             $wherestr.=" activity='$act' AND";
        }
        $wherestr=substr_replace($wherestr,"",-3);
        return $wherestr;
    }
    //put your code here
}
?>
