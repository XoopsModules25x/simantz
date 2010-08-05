<?php /* Smarty version 2.6.26, created on 2010-08-05 13:20:40
         compiled from db:system_redirect.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['xoops_charset']; ?>
" />
<meta http-equiv="Refresh" content="<?php echo $this->_tpl_vars['time']; ?>
; url=<?php echo $this->_tpl_vars['url']; ?>
" />
<meta name="generator" content="XOOPS" />
<link rel="shortcut icon" type="image/ico" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/favicon.ico" />
<title><?php echo $this->_tpl_vars['xoops_sitename']; ?>
</title>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $this->_tpl_vars['xoops_themecss']; ?>
" />
</head>
<body>
<div style="text-align:center; background-color: #EBEBEB; border-top: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight : bold;">
  <h4><?php echo $this->_tpl_vars['message']; ?>
</h4>
  <p><?php echo $this->_tpl_vars['lang_ifnotreload']; ?>
</p>
</div>
<?php if ($this->_tpl_vars['xoops_logdump'] != ''): ?><div><?php echo $this->_tpl_vars['xoops_logdump']; ?>
</div><?php endif; ?>
</body>
</html>