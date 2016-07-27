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
    
    // only allow selecting a year
    $dp->selectableYearsRange = array(
        // between 2000 and current year minus 1
        array(2000, date("Y") - 1, 1),
        // and also any year between 1990 and 1998
        array(1990, 1998, 1)
    );
    
    // notice that you now have a select box for years!

?>

<p>
    Another example about restricting selectable dates...
</p>
<pre style="font-size:11px">
&lt;?php

// include the class
require "../class.datepicker.php";

// instantiate the object
$dp=new datepicker();

// only allow selecting a year
$dp->selectableYearsRange = array(
    // between 2000 and current year minus 1
    array(2000, date("Y") - 1, 1),
    // and also any year between 1990 and 1998
    array(1990, 1998, 1)
);

// notice that you now have a select box for years!

?&gt;

&lt;input type="text" id="date">

&lt;--
also note below that we make current year minus 1 the default selected year because the current year not being in
the selectable list, 1990 would've been the year selected by default
--&gt;

&lt;input type="button" value="..." onclick="&lt;?=$dp->show("date", date("m") , date("Y") - 1)?>">
</pre>

<p>Click on the button to see it work</p>

<input type="text" id="date">

<input type="button" value="..." onclick="<?=$dp->show("date", date("m"), date("Y") - 1)?>">

</body>
</html>
