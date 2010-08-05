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
<tr><td><b>Windows</b><br>Add/Edit Windows/Report in this system(You shall not simply change data here unless you know what you are doing).</td><td><A href="window.php">Add/Edit Window</a></td></tr>
<tr><td><b>Permission</b><br>Manage user groups permission from accessing particular function(You shall create group and assign group to access SimTrain Module before proceed to this step).</td><td><A href="permission.php"> Add / Edit Group Permission</a></td></tr>
<tr><td><b>Reset Accounts</b><br>Purge all existing record and chart of accounts under simbiz module.</td><td><A href="resetaccounts.php"> Reset Accounts</a></td></tr>
<tr><td><b>Extra Setting</b><br></td><td><A href="changesetting.php">Extra Setting</a></td></tr>

</tbody>
</table>
EOF;

xoops_cp_footer();

?>
