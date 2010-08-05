<?php /* Smarty version 2.6.26, created on 2010-08-05 11:52:02
         compiled from /var/www/simantz/modules/system/class/gui/oxygen/xotpl/xo_toolbar.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/var/www/simantz/modules/system/class/gui/oxygen/xotpl/xo_toolbar.html', 7, false),)), $this); ?>
<div id="navOptionsCP">
    <div class="modname">
        <?php echo $this->_tpl_vars['modname']; ?>

    </div>
    <?php $_from = $this->_tpl_vars['mod_options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['op']):
?>
    <a class="tooltip" href="<?php echo $this->_tpl_vars['op']['link']; ?>
" title="<?php echo $this->_tpl_vars['op']['title']; ?>
">
        <img src='<?php echo ((is_array($_tmp=@$this->_tpl_vars['op']['icon'])) ? $this->_run_mod_handler('default', true, $_tmp, ($this->_tpl_vars['theme_icons'])."/icon_options.png") : smarty_modifier_default($_tmp, ($this->_tpl_vars['theme_icons'])."/icon_options.png")); ?>
' alt="<?php echo $this->_tpl_vars['op']['title']; ?>
" />
    </a>
    <?php endforeach; endif; unset($_from); ?>

    <?php if ($this->_tpl_vars['moddir'] != 'system' && $this->_tpl_vars['mod_options']): ?>
    <a class="tooltip" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=<?php echo $this->_tpl_vars['modid']; ?>
" title="<?php echo @_MD_AM_PREF; ?>
">
        <img src="<?php echo $this->_tpl_vars['theme_icons']; ?>
/prefs.png" alt="<?php echo @_MD_AM_PREF; ?>
" />
    </a>
    <?php endif; ?>
</div>