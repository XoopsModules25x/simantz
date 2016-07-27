<?php 

include_once( "admin_header.php" );
xoops_cp_header();

if(PHP_OS!="WINNT")
$backupimagectrl='<tr><td><b>Backup Attachments</b><br>Backup all attachment, include student photo, attendance checklist, receipt, and products.</td><td><A href="backupfile.php">Download Backup Now</A></td></tr>';
echo <<< EOF

<table>
<tbody>
<tr>
<th>Description</th><th>Link</th></tr>
<tr><td><b>Extra Setting</b><br></td><td><A href="changesetting.php">Extra Setting</a></td></tr>

</tbody>
</table>
EOF;

xoops_cp_footer();

?>
