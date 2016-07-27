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
    
    // restrict selectable dates to weekdays in december 2007
    $dp->selectableDatesRange = array(
        // this is for all the Mondays (December 3rd is a Monday and therefore every 7th day will be a monday)
        array(mktime(0, 0, 0, 12, 3, 2007), mktime(0, 0, 0, 12, 31, 2007), 7),
        // this is for the Tuesdays
        array(mktime(0, 0, 0, 12, 4, 2007), mktime(0, 0, 0, 12, 31, 2007), 7),
        // this is for the Wednesdays
        array(mktime(0, 0, 0, 12, 5, 2007), mktime(0, 0, 0, 12, 31, 2007), 7),
        // this is for the Thursdays
        array(mktime(0, 0, 0, 12, 6, 2007), mktime(0, 0, 0, 12, 31, 2007), 7),
        // and this is for the Fridays
        array(mktime(0, 0, 0, 12, 7, 2007), mktime(0, 0, 0, 12, 31, 2007), 7),
    )

?>

<p>
    Another example about restricting selectable dates...
</p>
<pre style="font-size:11px">
// include the class
require "../class.datepicker.php";

// instantiate the object
$dp=new datepicker();

// restrict selectable dates to weekdays in december 2007
$dp->selectableDatesRange = array(
    // this is for all the Mondays (December 3rd is a Monday and therefore every 7th day will be a monday)
    array(mktime(0, 0, 0, 12, 3, 2007), mktime(0, 0, 0, 12, 31, 2007), 7),
    // this is for the Tuesdays
    array(mktime(0, 0, 0, 12, 4, 2007), mktime(0, 0, 0, 12, 31, 2007), 7),
    // this is for the Wednesdays
    array(mktime(0, 0, 0, 12, 5, 2007), mktime(0, 0, 0, 12, 31, 2007), 7),
    // this is for the Thursdays
    array(mktime(0, 0, 0, 12, 6, 2007), mktime(0, 0, 0, 12, 31, 2007), 7),
    // and this is for the Fridays
    array(mktime(0, 0, 0, 12, 7, 2007), mktime(0, 0, 0, 12, 31, 2007), 7),
)

&lt;input type="text" id="date">

&lt;input type="button" value="..." onclick="&lt;?=$dp->show("date")?>">
</pre>

<p>Click on the button to see it work</p>

<input type="text" id="date">

<input type="button" value="..." onclick="<?=$dp->show("date")?>">

</body>
</html>
