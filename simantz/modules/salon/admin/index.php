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
// ------------------------------------------------------------------------ //
include_once( "admin_header.php" );
xoops_cp_header();

echo <<< EOF

<table>
<tbody>
<tr>
<th colspan='2'>SimSalon Management System</th></tr>
<tr><th>Description</th><th>Link</th></tr><tr>
<td><b>Organization</b><br>Add/Edit Organization/branch in your company.</td><td><A href="organization.php">Organization</td></tr>
<td><b>User Access Control</b><br>Add/Edit User Access Control</td><td><A href="access.php">User Access Control</td></tr>
<tr><td><b>Backup Database</b><br>Backup current database.</td><td><A href="backup.php">Download Backup Now</A></td></tr>
<tr><td><b>Backup Folder</b><br>Backup entire folder, include source code and pictures.</td><td><A href="backupfile.php">Download Backup Now</A></td></tr>
<tr><td><b>Restore Database</b><br>Upload wrong file can corrupt the database.</td><td><A href="restore.php">Upload Restore file(.sql)</A></td></tr>
</tbody>
</table>
EOF;

xoops_cp_footer();

?>
