<?php
/**
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Extension to mimetype lookup table
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         kernel
 * @subpackage      core
 * @since           2.4.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: mimetypes.inc.php 4170 2010-01-18 19:37:40Z trabis $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

$GLOBALS['xoopsLogger']->addDeprecated("'/class/mimetypes.inc.php' is deprecated, use '/include/mimetypes.inc.php' directly.");

return include XOOPS_ROOT_PATH . '/include/mimetypes.inc.php';
?>