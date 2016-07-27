<?php 
// $Id: index.php,v 1.1 2004/01/29 14:45:49 buennagel Exp $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//
// ------------------------------------------------------------------------ //
include_once( "system.php" );
	xoops_cp_header();

if(PHP_OS!="WINNT")
$backupimagectrl='<tr><td><b>Backup Attachments</b><br>Backup all attachment, include student photo, attendance checklist, receipt, and products.</td><td><A href="backupfile.php">Download Backup Now</A></td></tr>';
echo <<< EOF

<table>
<tbody>
<tr>
<th>Description</th><th>Link</th></tr><tr>
<td><b>Organization</b><br>Add/Edit Organization/branch in your company.</td><td><A href="organization.php">Organization</td></tr>
<tr><td><b>Backup Database</b><br>Backup current database.</td><td><A href="backup.php">Download Backup Now</A></td></tr>
$backupimagectrl
<tr><td><b>Restore Database</b><br>Upload wrong file can corrupt the database.</td><td><A href="restore.php">Upload Restore file(.sql)</A></td></tr>
<tr><td><b>Windows</b><br>Add/Edit Windows/Report in this system(You shall not simply change data here unless you know what you are doing).</td><td><A href="window.php">Add/Edit Window</a></td></tr>
<tr><td><b>Permission</b><br>Manage user groups permission from accessing particular function(You shall create group and assign group to access SimTrain Module before proceed to this step).</td><td><A href="permission.php"> Add / Edit Group Permission</a></td></tr>
<tr><td><b>Change report logo</b><br>Change logo in reports.</td><td><A href="uploadimage.php">Upload Image</a></td></tr>
<tr><td><b>Setup</b><br>Setup system configuration.</td><td><A href="changesetting.php">Setup</a></td></tr>
<tr><td><b>Empty System</b><br>Empty all existing data.</td><td><A href="resetdata.php">Empty Data</a></td></tr>
</tbody>
</table>
EOF;

xoops_cp_footer();

?>
