<?php /* Smarty version 2.6.26, created on 2010-08-05 13:18:53
         compiled from db:sideblockshortcut.html */ ?>
<small>
<?php $_from = $this->_tpl_vars['block']['index']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
<a href="<?php echo $this->_tpl_vars['block']['history'][$this->_tpl_vars['i']]; ?>
"><?php echo $this->_tpl_vars['block']['historyname'][$this->_tpl_vars['i']]; ?>
<a><br/>

<?php endforeach; endif; unset($_from); ?>
</small>