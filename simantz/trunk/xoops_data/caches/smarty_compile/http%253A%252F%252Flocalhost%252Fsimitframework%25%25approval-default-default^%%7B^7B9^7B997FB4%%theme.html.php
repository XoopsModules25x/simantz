<?php /* Smarty version 2.6.26, created on 2010-08-05 12:10:38
         compiled from /var/www/simantz/themes/default/theme.html */ ?>
<?php 

	if( ! empty( $_SESSION['redirect_message'] ) ) {
		$this->_tpl_vars['xoops_msg'] = $_SESSION['redirect_message']; 
		$this->_tpl_vars['wait_time'] = $_SESSION['redirect_time']; 
		unset( $_SESSION['redirect_message'] ) ;
	}
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:ntb="http://www.nitobi.com" xml:lang="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
" lang="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
">



<head>
	<!-- Assign Theme name -->
	<?php $this->assign('theme_name', $this->_tpl_vars['xoTheme']->folderName); ?>

	<!-- Title and meta -->
    <meta http-equiv="content-language" content="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
" />
    <meta http-equiv="content-type" content="text/html; charset=<?php echo $this->_tpl_vars['xoops_charset']; ?>
" />
	<title><?php if ($this->_tpl_vars['xoops_pagetitle'] != ''): ?><?php echo $this->_tpl_vars['xoops_pagetitle']; ?>
 - <?php endif; ?><?php echo $this->_tpl_vars['xoops_sitename']; ?>
</title>
	<meta name="robots" content="<?php echo $this->_tpl_vars['xoops_meta_robots']; ?>
" />
	<meta name="keywords" content="<?php echo $this->_tpl_vars['xoops_meta_keywords']; ?>
" />
	<meta name="description" content="<?php echo $this->_tpl_vars['xoops_meta_description']; ?>
" />
	<meta name="rating" content="<?php echo $this->_tpl_vars['xoops_meta_rating']; ?>
" />
	<meta name="author" content="<?php echo $this->_tpl_vars['xoops_meta_author']; ?>
" />
	<meta name="copyright" content="<?php echo $this->_tpl_vars['xoops_meta_copyright']; ?>
" />
	<meta name="generator" content="XOOPS" />

	<!-- Rss -->
	<link rel="alternate" type="application/rss+xml" title="" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/backend.php" />

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/ico" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/favicon.ico" />
	
    <!-- Sheet Css -->
	<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/xoops.css" />
	<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/themes/default/style.css" />


    <!-- customized header contents -->
	<?php echo $this->_tpl_vars['xoops_module_header']; ?>




</head>

<body onload="if(document.init)init();">

<?php if ($this->_tpl_vars['xoops_msg']): ?>
<div id="divLoading">
  <p><img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/images/loadingAnimation.gif" /><br /><?php echo $this->_tpl_vars['xoops_msg']; ?>
</p>
</div>
<?php endif; ?>

<div id='blanket' style='display:none;'></div>
<div id='popUpDiv' style='display:none;verticle-align:center'>

     <div id='popupmessage' style='text-align:center'></div>
     <div id='progressimage' style='text-align:center'><img src='<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/simantz/images/ajax_indicator_01.gif'></div>
</div>
    
<!-- Start Header -->
<div id="productlogo"><img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/themes/default/hiumen.png"></div>
<div id="headerdiv">
        <ul>
            
             <?php 
             global $xoopsDB,$xoopsUser;
             $xoops_url=XOOPS_URL;
             if($xoopsUser)
             $uid=$xoopsUser->getVar('uid');
             else
             $uid=0;
             $sql="SELECT m.mid,m.name,m.dirname
                    FROM sim_modules m
                    inner join sim_group_permission p on m.mid=p.gperm_itemid 
                    where m.hasmain=1 and m.isactive=1 and p.gperm_name='module_read'
                    and p.gperm_groupid in (select groupid from sim_groups_users_link where uid=$uid)
                    group by m.mid,m.name,m.dirname
                    order by m.weight";
             
             $query=$xoopsDB->query($sql);                            
			
             $currentfolder=basename(getcwd());
			 if(XOOPS_ROOT_PATH==getcwd())
			 echo "<li class='activemodulepattern'>&nbsp;&nbsp;<a href='$xoops_url/modules/system/admin.php' title='Admin'> Admin</a></li><li class='modulepattern'>|</li>";
			 else
			 echo "<li class='modulepattern'>&nbsp;&nbsp;<a href='$xoops_url/modules/system/admin.php' title='Admin'> Admin</a></li><li class='modulepattern'>|</li>";

             while($row=$xoopsDB->fetchArray($query)){
             $mid=$row['mid'];
             $name=$row['name'];
	     $class="modulepattern";
             $dirname=$row['dirname'];
             if($dirname != "system" && $dirname != "protector" && $dirname != "profile" && $dirname!="pm"){             

             if($dirname == "approval")
             {$name = $name."&nbsp;<span id='idApprovalTotal'></span>";
		$class="approvalmodule";}

             if($dirname!=$currentfolder)
             echo "<li class='$class'><a href='$xoops_url/modules/$dirname'>$name</a></li><li class='modulepattern'>|</li>";
             else
             echo "<li class='activemodulepattern'><a href='$xoops_url/modules/$dirname'>$name</a></li><li class='modulepattern'>|</li>";


             }

             
             }
             if($uid>0)
           		echo "<li class='modulepattern'><A href='$xoops_url/user.php?op=logout'>Logout</a></li>";
           	else
           		echo "<li class='modulepattern'><A href='$xoops_url/user.php'>Login</a></li>";
           
             ?>
            <li class="stopofmodule"></li>
        </ul>
</div>
<table cellspacing="0">
    <tr>
      <td id="xo-globalnav" style='Text-align: right'></td>
    </tr>
  </table>

  <table cellspacing="0">
    <tr>
	<!-- Start left blocks loop -->
	<?php if ($this->_tpl_vars['xoops_showlblock']): ?>
		<td id="leftcolumn">
		<?php $_from = $this->_tpl_vars['xoBlocks']['canvas_left']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
			<?php $this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_name'])."/theme_blockleft.html", 'smarty_include_vars' => array()));
 ?>
		<?php endforeach; endif; unset($_from); ?>
		</td>
	<?php endif; ?>
	<!-- End left blocks loop -->

	<td id="centercolumn">
		<!-- Display center blocks if any -->
		<?php if ($this->_tpl_vars['xoBlocks']['page_topleft'] || $this->_tpl_vars['xoBlocks']['page_topcenter'] || $this->_tpl_vars['xoBlocks']['page_topright']): ?>
			<table cellspacing="0">
			<tr>
				<td id="centerCcolumn" colspan="2">
				<!-- Start center-center blocks loop -->
				<?php $_from = $this->_tpl_vars['xoBlocks']['page_topcenter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
					<?php $this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_name'])."/theme_blockcenter_c.html", 'smarty_include_vars' => array()));
 ?>
				<?php endforeach; endif; unset($_from); ?>
				<!-- End center-center blocks loop -->
				</td>
			</tr>
			<tr>
				<td id="centerLcolumn">
				<!-- Start center-left blocks loop -->
				<?php $_from = $this->_tpl_vars['xoBlocks']['page_topleft']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
					<?php $this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_name'])."/theme_blockcenter_l.html", 'smarty_include_vars' => array()));
 ?>
				<?php endforeach; endif; unset($_from); ?>
				<!-- End center-left blocks loop -->
				</td>
				<td id="centerRcolumn">
				<!-- Start center-right blocks loop -->
				<?php $_from = $this->_tpl_vars['xoBlocks']['page_topright']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
					<?php $this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_name'])."/theme_blockcenter_r.html", 'smarty_include_vars' => array()));
 ?>
				<?php endforeach; endif; unset($_from); ?>
				<!-- End center-right blocks loop -->
				</td>
			</tr>
			</table>
		<?php endif; ?>
		<!-- End center top blocks loop -->

		<!-- Start content module page -->
		<div id="content"><?php echo $this->_tpl_vars['xoops_contents']; ?>
</div>
		<!-- End content module -->

		<!-- Start center bottom blocks loop -->
		<?php if ($this->_tpl_vars['xoBlocks']['page_bottomleft'] || $this->_tpl_vars['xoBlocks']['page_bottomright'] || $this->_tpl_vars['xoBlocks']['page_bottomcenter']): ?>
			<table cellspacing="0">
			<?php if ($this->_tpl_vars['xoBlocks']['page_bottomcenter']): ?>
				<tr>
					<td id="bottomCcolumn" colspan="2">
					<?php $_from = $this->_tpl_vars['xoBlocks']['page_bottomcenter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_name'])."/theme_blockcenter_c.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php endforeach; endif; unset($_from); ?>
					</td>
				</tr>
			<?php endif; ?>

			<?php if ($this->_tpl_vars['xoBlocks']['page_bottomleft'] || $this->_tpl_vars['xoBlocks']['page_bottomright']): ?>
				<tr>
					<td id="bottomLcolumn">
					<?php $_from = $this->_tpl_vars['xoBlocks']['page_bottomleft']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_name'])."/theme_blockcenter_l.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php endforeach; endif; unset($_from); ?>
					</td>

					<td id="bottomRcolumn">
					<?php $_from = $this->_tpl_vars['xoBlocks']['page_bottomright']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_name'])."/theme_blockcenter_r.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php endforeach; endif; unset($_from); ?>
					</td>
				</tr>
			<?php endif; ?>
			</table>
		<?php endif; ?>
		<!-- End center bottom blocks loop -->

	</td>

	<?php if ($this->_tpl_vars['xoops_showrblock']): ?>
		<td id="rightcolumn">
		<!-- Start right blocks loop -->
		<?php $_from = $this->_tpl_vars['xoBlocks']['canvas_right']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
			<?php $this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_name'])."/theme_blockright.html", 'smarty_include_vars' => array()));
 ?>
		<?php endforeach; endif; unset($_from); ?>
		<!-- End right blocks loop -->
		</td>
	<?php endif; ?>
</tr>
</table>

<!-- Start footer -->
<table cellspacing="0">
<tr>
	<td id="footerbar"><?php echo $this->_tpl_vars['xoops_footer']; ?>
</td>
</tr>
</table>
<!-- End footer -->

<!--{xo-logger-output}-->

 <?php 
        $wherestring = "";
        $wherestring .= " AND (wt.target_uid = $uid OR $uid IN (wt.targetparameter_name)
                            OR $uid IN (SELECT uid FROM sim_groups_users_link WHERE groupid = wt.target_groupid)
                            ) ";


            $wherestring .= " AND wt.iscomplete = 0 ";

            $sqlapproval = "SELECT
                    COUNT(*) as total_approval
                    FROM sim_workflowtransaction wt
                    INNER JOIN sim_hr_employee emp ON wt.person_id = emp.employee_id
                    INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id
                    $wherestring
                    AND wt.issubmit = 1
                    ORDER BY wt.created DESC";


            $queryapproval=$xoopsDB->query($sqlapproval);

            $total_approval = 0;
            if($rowapproval=$xoopsDB->fetchArray($queryapproval)){
            $total_approval = $rowapproval['total_approval'];
            }

            $approval_status = "";
            if($total_approval > 0)
            $approval_status = "<li id='pendingno'>$total_approval</li>";

echo <<< EOF
   <script type="text/javascript">
	try {
	document.getElementById('idApprovalTotal').innerHTML = "$approval_status";
	}catch (error) {
	}
    </script>
EOF;

 ?>

</body>
</html>

