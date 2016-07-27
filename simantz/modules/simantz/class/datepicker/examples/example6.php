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
    
    $dp->enableTimePicker = true;
    
    $dp->selectableTimesRange = array(
        array(12, 20, 2, 0, 60, 15)
    );

?>

<p>
    An example about restricting selectable times...
</p>
<pre style="font-size:11px">
&lt;?php

// include the class
require "../class.datepicker.php";

// instantiate the object
$dp=new datepicker();

// allow selection of time also
$dp->enableTimePicker = true;

// restrict the selectable hours range to every second hour between 12 and 20
// and minutes to every 15 minute
$dp->selectableTimesRange = array(
    array(12, 20, 2, 0, 60, 15)
);
?&gt;

&lt;input type="text" id="date">

&lt;input type="button" value="..." onclick="&lt;?=$dp->show("date")?>">
</pre>

<p>Click on the button to see it work</p>

<input type="text" id="date">

<input type="button" value="..." onclick="<?=$dp->show("date")?>">

</body>
</html>
