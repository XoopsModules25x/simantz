<?php 
include_once "../../../mainfile.php";
include_once XOOPS_ROOT_PATH . "/include/cp_header.php";
xoops_cp_header();
echo <<< EOF
<table>
<tbody>
<tr>
<th>Description</th><th>Link</th></tr>

<tr><td><b>Empty System</b><br>Empty all existing data.</td><td><A href="resetdata.php">Empty Data</a></td></tr>
</tbody>
</table>
EOF;
xoops_cp_footer();
?>
