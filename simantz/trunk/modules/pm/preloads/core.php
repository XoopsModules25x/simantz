<?php
/**
 * Private Messages
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         pm
 * @since           2.4.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: core.php 3333 2009-08-27 10:46:15Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * PM core preloads
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author          trabis <lusopoemas@gmail.com>
 */
class PmCorePreload extends XoopsPreloadItem
{

    function eventCorePmliteStart($args)
    {
        header("location: ./modules/pm/pmlite.php" . (empty($_SERVER['QUERY_STRING']) ? "" : "?" . $_SERVER['QUERY_STRING']));
        exit();
    }

    function eventCoreReadpmsgStart($args)
    {
        header("location: ./modules/pm/readpmsg.php" . (empty($_SERVER['QUERY_STRING']) ? "" : "?" . $_SERVER['QUERY_STRING']));
        exit();
    }

    function eventCoreViewpmsgStart($args)
    {
        header("location: ./modules/pm/viewpmsg.php" . (empty($_SERVER['QUERY_STRING']) ? "" : "?" . $_SERVER['QUERY_STRING']));
        exit();
    }

    function eventCoreClassSmartyXoops_pluginsXoinboxcount($args)
    {
        $args[0] =& xoops_getModuleHandler('message', 'pm');
    }

}
?>