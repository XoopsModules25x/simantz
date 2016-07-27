<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>datepicker test</title>
    </head>
<body>
<?php

    // include the class
    require "../class.datepicker.php";

    // instantiate the object
    $dp=new datepicker();
    
    // restrict selectable dates to every second day from today on and for a week
    $dp->selectableDatesRange = array(
        array(mktime(), strtotime("+1 week"), 2)
    )

?>

<p>
    Restrict selectable dates...
</p>
<pre style="font-size:11px">
// include the class
require "../class.datepicker.php";

// instantiate the object
$dp=new datepicker();

// restrict selectable dates to every second day between today and a week from today
$dp->selectableDatesRange = array(
    array(mktime(), strtotime("+1 week"), 2)
)

&lt;input type="text" id="date">

&lt;input type="button" value="..." onclick="&lt;?=$dp->show("date")?>">
</pre>

<p>Click on the button to see it work</p>

<input type="text" id="date">

<input type="button" value="..." onclick="<?=$dp->show("date")?>">

</body>
</html>
