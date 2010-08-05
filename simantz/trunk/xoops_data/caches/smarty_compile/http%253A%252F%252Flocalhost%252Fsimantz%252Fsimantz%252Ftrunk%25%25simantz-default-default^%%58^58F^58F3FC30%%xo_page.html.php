<?php /* Smarty version 2.6.26, created on 2010-08-05 13:26:02
         compiled from /var/www/simantz/simantz/trunk/modules/system/class/gui/oxygen/xotpl/xo_page.html */ ?>
<div id="containBodyCP"><br />
	<div id="bodyCP">
		<?php if ($this->_tpl_vars['modules']): ?>
			<?php $this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_tpl'])."/xo_icons.html", 'smarty_include_vars' => array()));
 ?>
				<table id="xo-index ">
					<tr>
						<td id="xo-modules" class="CPindexOptions"><?php $this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_tpl'])."/xo_modules.html", 'smarty_include_vars' => array()));
 ?></td>
						<td id="xo-accordion" class="CPindexOptions"><?php $this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['theme_tpl'])."/xo_accordion.html", 'smarty_include_vars' => array()));
 ?></td>
					</tr>
				</table>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['xoops_contents']): ?><div id="xo-content"><?php echo $this->_tpl_vars['xoops_contents']; ?>
</div><?php endif; ?>
	</div>
	<br />
</div>