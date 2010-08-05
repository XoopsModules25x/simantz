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

?>

<p>
    Time picker
</p>
<pre style="font-size:11px">
&lt;?php

// include the class
require "../class.datepicker.php";

// instantiate the object
$dp=new datepicker();

// allow selection of time also
$dp->enableTimePicker = true;

?&gt;

&lt;input type="text" id="date">

&lt;--
we're showing the current month of the current year and also have the current time preselected
--&gt;

&lt;input type="button" value="..." onclick="&lt;?=$dp->show("date", date("m") , date("Y"), date("H"), date("i"))?>">
</pre>

<p>Click on the button to see it work</p>

<input type="text" id="date">

<input type="button" value="..." onclick="<?=$dp->show("date", date("m"), date("Y"), date("H"), date("i"))?>">

</body>
</html>
