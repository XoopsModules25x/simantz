<?php
/**
 * TextSanitizer extension
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         class
 * @subpackage      textsanitizer
 * @since           2.3.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: syntaxhighlight.php 4051 2009-12-26 17:01:58Z trabis $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class MytsSyntaxhighlight extends MyTextSanitizerExtension
{
    function load(&$ts, $source, $language)
    {
        $config = parent::loadConfig(dirname(__FILE__));
        if (empty($config['highlight'])) {
            return "<pre>{$source}</pre>";
        }
        if ($config['highlight'] == 'geshi') {
            $language = str_replace('=', '', $language);
            $language = ($language) ? $language : $config['language'];
            $language = strtolower($language);
            if ($source = MytsSyntaxhighlight::geshi($source, $language)) {
                return $source;
            }
        }
        $source = MytsSyntaxhighlight::php($source);
        return $source;
    }

    function php($text)
    {
        $addedtag_open = 0;
        if (!strpos($text, "<?php") and (substr($text, 0, 5) != "<?php")) {
            $text = "<?php " . $text;
            $addedtag_open = 1;
        }
        $addedtag_close = 0;
        if (!strpos($text, "?>")) {
            $text .= "?>";
            $addedtag_close = 1;
        }
        $oldlevel = error_reporting(0);

        //There is a bug in the highlight function(php < 5.3) that it doesn't render
        //backslashes properly like in \s. So here we replace any backslashes
        $text = str_replace("\\", "XxxX", $text);

        $buffer = highlight_string($text, true); // Require PHP 4.20+

        //Placing backspaces back again
        $buffer = str_replace("XxxX", "\\", $buffer);

        error_reporting($oldlevel);
        $pos_open = $pos_close = 0;
        if ($addedtag_open) {
            $pos_open = strpos($buffer, '&lt;?php&nbsp;');
        }
        if ($addedtag_close) {
            $pos_close = strrpos($buffer, '?&gt;');
        }

        $str_open = ($addedtag_open) ? substr($buffer, 0, $pos_open) : "";
        $str_close = ($pos_close) ? substr($buffer, $pos_close + 5) : "";

        $length_open = ($addedtag_open) ? $pos_open + 14 : 0;
        $length_text = ($pos_close) ? $pos_close - $length_open : 0;
        $str_internal = ($length_text) ? substr($buffer, $length_open, $length_text) : substr($buffer, $length_open);

        $buffer = $str_open . $str_internal . $str_close;
        return $buffer;
    }

    function geshi($source, $language)
    {
        if (!xoops_load("geshi", "framework")) {
            if (!@include_once dirname(__FILE__) . '/geshi.php') {
                return false;
            }
        }

        // Create the new GeSHi object, passing relevant stuff
        $geshi_handler = XoopsGeshi::getHandler($source, $language);
        // Enclose the code in a <div>
        $geshi->set_header_type(GESHI_HEADER_NONE);

        // Sets the proper encoding charset other than "ISO-8859-1"
        $geshi->set_encoding(_CHARSET);

        $geshi->set_link_target("_blank");

        // Parse the code
        $code = $geshi->parse_code();

        return $code;
    }
}
?>