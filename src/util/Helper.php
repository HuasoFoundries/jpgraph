<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Util;

require_once __DIR__ . '/../config.inc.php';

/**
 * @class Helper
 * // Misc Helper functions
 */
class Helper
{
    //
    // Setup PHP error handler
    //
    public static function phpErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
    {
        // Respect current error level
        if ($errno & error_reporting()) {
            JpGraphError::RaiseL(25003, basename($filename), $linenum, $errmsg);
        }
    }

    //
    // Utility function to generate an image name based on the filename we
    // are running from and assuming we use auto detection of graphic format
    // (top level), i.e it is safe to call this function
    // from a script that uses JpGraph
    //
    public static function GenImgName()
    {
        // Determine what format we should use when we save the images
        $supported = imagetypes();
        if ($supported & IMG_PNG) {
            $img_format = 'png';
        } elseif ($supported & IMG_GIF) {
            $img_format = 'gif';
        } elseif ($supported & IMG_JPG) {
            $img_format = 'jpeg';
        } elseif ($supported & IMG_WBMP) {
            $img_format = 'wbmp';
        } elseif ($supported & IMG_XPM) {
            $img_format = 'xpm';
        }

        if (!isset($_SERVER['PHP_SELF'])) {
            JpGraphError::RaiseL(25005);
            //(" Can't access PHP_SELF, PHP global variable. You can't run PHP from command line if you want to use the 'auto' naming of cache or image files.");
        }
        $fname = basename($_SERVER['PHP_SELF']);
        if (!empty($_SERVER['QUERY_STRING'])) {
            $q = @$_SERVER['QUERY_STRING'];
            $fname .= '_' . preg_replace('/\\W/', '_', $q) . '.' . $img_format;
        } else {
            $fname = substr($fname, 0, strlen($fname) - 4) . '.' . $img_format;
        }

        return $fname;
    }

    // Useful mathematical function
    public static function sign($a)
    {
        return $a >= 0 ? 1 : -1;
    }

    public static function trace()
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

        $btarray0 = ([
            'class2'    => $backtrace[1]['class'],
            'type2'     => $backtrace[1]['type'],
            'function2' => $backtrace[1]['function'],
            'spacer4'   => ' ',
            'line2'     => $backtrace[0]['line'],
        ]);

        $tag = implode('', $btarray0);

        \PC::debug(func_get_args(), $tag);
    }
}
