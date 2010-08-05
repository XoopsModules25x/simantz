<?php 
include_once "../../../mainfile.php";
include_once XOOPS_ROOT_PATH . "/include/cp_header.php";
xoops_cp_header();
echo <<< EOF
<table>
<tbody>
<tr>
<th>Description</th><th>Link</th></tr>
<tr><td><b>Backup</b><br>Backup Database</td>
        <td><A href="backup.php">Backup</A></td></tr>
<tr><td><b>Restore</b><br>Restore Database</td>
        <td><A href="restore.php">Restore</a></td></tr>
<tr><td><b>Organization</b><br>Add/Edit Organization</td>
        <td><A href="organization.php">Add/Edit Organization</a></td></tr>
<tr><td><b>Windows</b><br>Add/Edit Windows/Report in this system(You shall not simply change data here unless you know what you are doing).</td>
        <td><A href="window.php">Add/Edit Window</a></td></tr>
<tr><td><b>Permission</b><br>Manage user groups permission from accessing particular function(You shall create group and assign group to access SimTrain Module before proceed to this step).</td>
        <td><A href="permission.php"> Add / Edit Group Permission</a></td></tr>
<tr><td><b>Extra Setting</b><br/>Change Others configuration</td><td><A href="changesetting.php">Extra Setting</a></td></tr>
<tr><td><b>Activity Summary Report</b><br>Summary For Save,Update and Delete</td><td><A href="activitysummary.php">Activity Summary Report</a></td></tr>
<tr><td><b>Login History Report</b><br>Summary For User Login/Logout system</td><td><A href="loginhistory.php">Login History Report</a></td></tr>
<tr><td><b>Workflow</b><br>Workflow for various approval windows</td><td><A href="workflow.php">Workflow</a></td></tr>
</tbody>
</table>
EOF;
xoops_cp_footer();
?>
