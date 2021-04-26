<?php

/**
 * JPGraph - Community Edition
 */

/**
 * // File:        config.inc.php
 * // Description: Configuration constants and settings for JpGraph library
 * // Created:     2004-03-27
 * // Ver:         $Id: jpg-config.inc.php 1871 2009-09-29 05:56:39Z ljp $.
 * //
 * // Copyright (c) Asial Corporation. All rights reserved.
 */

// check if jpgraph is the root folder
if (\file_exists(\dirname(__DIR__) . '/vendor/autoload.php')) {
    \defined('ROOT_PATH') || \define('ROOT_PATH', \dirname(__DIR__));
} elseif (\file_exists(\dirname(__DIR__, 4) . '/vendor/autoload.php')) {
    // otherwise, jpgraph was required as a composer dependency
    \defined('ROOT_PATH') || \define('ROOT_PATH', \dirname(__DIR__, 4));
}

require_once ROOT_PATH . '/vendor/autoload.php';

use Amenadiel\JpGraph\Util\ErrMsgText;

if (\is_readable(ROOT_PATH . '/.env') && \class_exists('\Symfony\Component\Dotenv\Dotenv')) {
    $dotenv = new \Symfony\Component\Dotenv\Dotenv();
    $dotenv->load(ROOT_PATH . '/.env');
}

if (\getenv('JPGRAPH_DEBUGMODE') && !\defined('DEBUGMODE')) {
    \define('DEBUGMODE', \getenv('JPGRAPH_DEBUGMODE'));
}
// Sets DEBUGMODE for the app. Set this to true to enable debugging outputs
\defined('DEBUGMODE') || \define('DEBUGMODE', false);

\ini_set('display_errors', (int) DEBUGMODE);
\ini_set('display_startup_errors', (int) DEBUGMODE);

if (DEBUGMODE) {
    \error_reporting(\E_ALL);
}
require_once __DIR__ . '/includes/polyfills.php';
/*
 * Directories for cache and font directory.
 * Define these constants explicitly or read them from environment vars
 *
 * CACHE_DIR:
 * The full absolute name of the directory to be used to store the
 * cached image files. This directory will not be used if the USE_CACHE
 * define (further down) is false. If you enable the cache please note that
 * this directory MUST be readable and writable for the process running PHP.
 * Must end with '/'
 *
 * TTF_DIR:
 * Directory where TTF fonts can be found. Must end with '/'
 *
 * The default values used if these defines are left commented out are:
 *
 * UNIX:
 *   CACHE_DIR /tmp/jpgraph_cache/
 *   TTF_DIR   /usr/share/fonts/truetype/
 *   MBTTF_DIR /usr/share/fonts/truetype/
 *
 * WINDOWS:
 *   CACHE_DIR $SERVER_TEMP/jpgraph_cache/
 *   TTF_DIR   $SERVER_SYSTEMROOT/fonts/
 *   MBTTF_DIR $SERVER_SYSTEMROOT/fonts/
 *
 */

// Define these constants explicitly
// define('CACHE_DIR','/tmp/jpgraph_cache/');
// define('TTF_DIR','/usr/share/fonts/TrueType/');
// define('MBTTF_DIR','/usr/share/fonts/TrueType/');
//
// Or read them from environment variables
if (\getenv('JPGRAPH_CACHE_DIR')) {
    \define('CACHE_DIR', \getenv('JPGRAPH_CACHE_DIR'));
}

if (\getenv('JPGRAPH_TTF_DIR')) {
    \define('TTF_DIR', \getenv('JPGRAPH_TTF_DIR'));
}

if (\getenv('JPGRAPH_MBTTF_DIR')) {
    \define('MBTTF_DIR', \getenv('JPGRAPH_MBTTF_DIR'));
}

/*
 * Cache directory specification for use with CSIM graphs that are
 * // using the cache.
 * // The directory must be the filesysystem name as seen by PHP
 * // and the 'http' version must be the same directory but as
 * // seen by the HTTP server relative to the 'htdocs' ddirectory.
 * // If a relative path is specified it is taken to be relative from where
 * // the image script is executed.
 * // Note: The default setting is to create a subdirectory in the
 * // directory from where the image script is executed and store all files
 * // there. As ususal this directory must be writeable by the PHP process.
 */
\define('CSIMCACHE_DIR', 'csimcache/');
\define('CSIMCACHE_HTTP_DIR', 'csimcache/');

/*
 * Various JpGraph Settings. Adjust accordingly to your
 * // preferences. Note that cache functionality is turned off by
 * // default (Enable by setting USE_CACHE to true)
 */
// Deafult locale for error messages.
// This defaults to English = 'en'
\define('DEFAULT_ERR_LOCALE', 'en');

// Deafult graphic format set to 'auto' which will automatically
// choose the best available format in the order png,gif,jpeg
// (The supported format depends on what your PHP installation supports)
\define('DEFAULT_GFORMAT', 'auto');

// Should the cache be used at all? By setting this to false no
// files will be generated in the cache directory.
// The difference from READ_CACHE being that setting READ_CACHE to
// false will still create the image in the cache directory
// just not use it. By setting USE_CACHE=false no files will even
// be generated in the cache directory.
if (!\defined('USE_CACHE')) {
    \define('USE_CACHE', \getenv('JPGRAPH_USE_CACHE') ?: false);
}

// Should we try to find an image in the cache before generating it?
// Set this define to false to bypass the reading of the cache and always
// regenerate the image. Note that even if reading the cache is
// disabled the cached will still be updated with the newly generated
// image. Set also 'USE_CACHE' below.
if (!\defined('READ_CACHE')) {
    \define('READ_CACHE', true);
}

// Determine if the error handler should be image based or purely
// text based. Image based makes it easier since the script will
// always return an image even in case of errors.
\define('USE_IMAGE_ERROR_HANDLER', true);

// Should the library examine the global php_errmsg string and convert
// any error in it to a graphical representation. This is handy for the
// occasions when, for example, header files cannot be found and this results
// in the graph not being created and just a 'red-cross' image would be seen.
// This should be turned off for a production site.
\define('CATCH_PHPERRMSG', true);

// Determine if the library should also setup the default PHP
// error handler to generate a graphic error mesage. This is useful
// during development to be able to see the error message as an image
// instead as a 'red-cross' in a page where an image is expected.
\define('INSTALL_PHP_ERR_HANDLER', false);

// Should usage of deprecated functions and parameters give a fatal error?
// (Useful to check if code is future proof.)
\define('ERR_DEPRECATED', true);

// The builtin GD function imagettfbbox() fuction which calculates the bounding box for
// text using TTF fonts is buggy. By setting this define to true the library
// uses its own compensation for this bug. However this will give a
// slightly different visual apparance than not using this compensation.
// Enabling this compensation will in general give text a bit more space to more
// truly reflect the actual bounding box which is a bit larger than what the
// GD function thinks.
\define('USE_LIBRARY_IMAGETTFBBOX', true);

/*
 * The following constants should rarely have to be changed !
 */
// What group should the cached file belong to
// (Set to '' will give the default group for the 'PHP-user')
// Please note that the Apache user must be a member of the
// specified group since otherwise it is impossible for Apache
// to set the specified group.
\define('CACHE_FILE_GROUP', 'www');

// What permissions should the cached file have
// (Set to '' will give the default persmissions for the 'PHP-user')
\define('CACHE_FILE_MOD', 0664);

// Default theme class name
\defined('DEFAULT_THEME_CLASS') || \define('DEFAULT_THEME_CLASS', 'UniversalTheme');

\define('SUPERSAMPLING', true);
\define('SUPERSAMPLING_SCALE', 1);

// TTF Font families
\define('FF_COURIER', 10);
\define('FF_VERDANA', 11);
\define('FF_TIMES', 12);
\define('FF_COMIC', 14);
\define('FF_ARIAL', 15);
\define('FF_GEORGIA', 16);
\define('FF_TREBUCHE', 17);

// Gnome Vera font
// Available from http://www.gnome.org/fonts/
\define('FF_VERA', 18);
\define('FF_VERAMONO', 19);
\define('FF_VERASERIF', 20);

// Chinese font
\define('FF_SIMSUN', 30);
\define('FF_CHINESE', 31);
\define('FF_BIG5', 32);

// Japanese font
\define('FF_MINCHO', 40);
\define('FF_PMINCHO', 41);
\define('FF_GOTHIC', 42);
\define('FF_PGOTHIC', 43);

// Hebrew fonts
\define('FF_DAVID', 44);
\define('FF_MIRIAM', 45);
\define('FF_AHRON', 46);

// Dejavu-fonts http://sourceforge.net/projects/dejavu
\define('FF_DV_SANSSERIF', 47);
\define('FF_DV_SERIF', 48);
\define('FF_DV_SANSSERIFMONO', 49);
\define('FF_DV_SERIFCOND', 50);
\define('FF_DV_SANSSERIFCOND', 51);

// Extra fonts
// Download fonts from
// http://www.webfontlist.com
// http://www.webpagepublicity.com/free-fonts.html
// http://www.fontonic.com/fonts.asp?width=d&offset=120
// http://www.fontspace.com/category/famous

// define("FF_SPEEDO",71);  // This font is also known as Bauer (Used for development gauge fascia)
\define('FF_DIGITAL', 72); // Digital readout font
\define('FF_COMPUTER', 73); // The classic computer font
\define('FF_CALCULATOR', 74); // Triad font

\define('FF_USERFONT', 90);
\define('FF_USERFONT1', 90);
\define('FF_USERFONT2', 91);
\define('FF_USERFONT3', 92);

// Limits for fonts
\define('_FIRST_FONT', 10);
\define('_LAST_FONT', 99);

// TTF Font styles
\define('FS_NORMAL', 9001);
\define('FS_BOLD', 9002);
\define('FS_ITALIC', 9003);
\define('FS_BOLDIT', 9004);
\define('FS_BOLDITALIC', 9004);

//Definitions for internal font
\define('FF_FONT0', 1);
\define('FF_FONT1', 2);
\define('FF_FONT2', 4);

/*
 * Defines for font setup
 */
// Actual name of the TTF file used together with FF_CHINESE aka FF_BIG5
// This is the TTF file being used when the font family is specified as
// either FF_CHINESE or FF_BIG5
\define('CHINESE_TTF_FONT', 'bkai00mp.ttf');

// Special unicode greek language support
\define('LANGUAGE_GREEK', false);

// If you are setting this config to true the conversion of greek characters
// will assume that the input text is windows 1251
\define('GREEK_FROM_WINDOWS', false);

// Special unicode cyrillic language support
\define('LANGUAGE_CYRILLIC', false);

// If you are setting this config to true the conversion
// will assume that the input text is windows 1251, if
// false it will assume koi8-r
\define('CYRILLIC_FROM_WINDOWS', false);

// The following constant is used to auto-detect
// whether cyrillic conversion is really necessary
// if enabled. Just replace 'windows-1251' with a variable
// containing the input character encoding string
// of your application calling jpgraph.
// A typical such string would be 'UTF-8' or 'utf-8'.
// The comparison is case-insensitive.
// If this charset is not a 'koi8-r' or 'windows-1251'
// derivate then no conversion is done.
//
// This constant can be very important in multi-user
// multi-language environments where a cyrillic conversion
// could be needed for some cyrillic people
// and resulting in just erraneous conversions
// for not-cyrillic language based people.
//
// Example: In the free project management
// software dotproject.net $locale_char_set is dynamically
// set by the language environment the user has chosen.
//
// Usage: define('LANGUAGE_CHARSET', $locale_char_set);
//
// where $locale_char_set is a GLOBAL (string) variable
// from the application including JpGraph.
//
\define('LANGUAGE_CHARSET', null);

// Japanese TrueType font used with FF_MINCHO, FF_PMINCHO, FF_GOTHIC, FF_PGOTHIC
// Standard fonts from Infomation-technology Promotion Agency (IPA)
// See http://mix-mplus-ipa.sourceforge.jp/
\define('MINCHO_TTF_FONT', 'ipam.ttf');
\define('PMINCHO_TTF_FONT', 'ipamp.ttf');
\define('GOTHIC_TTF_FONT', 'ipag.ttf');
\define('PGOTHIC_TTF_FONT', 'ipagp.ttf');

// Assume that Japanese text have been entered in EUC-JP encoding.
// If this define is true then conversion from EUC-JP to UTF8 is done
// automatically in the library using the mbstring module in PHP.
\define('ASSUME_EUCJP_ENCODING', false);

// Default font family
\define('FF_DEFAULT', FF_DV_SANSSERIF);

// Line styles
\define('LINESTYLE_SOLID', 1);
\define('LINESTYLE_DOTTED', 2);
\define('LINESTYLE_DASHED', 3);
\define('LINESTYLE_LONGDASH', 4);

// The DEFAULT_GFORMAT sets the default graphic encoding format, i.e.
// PNG, JPG or GIF depending on what is installed on the target system
// in that order.
if (!\defined('DEFAULT_GFORMAT')) {
    \define('DEFAULT_GFORMAT', 'auto');
}

// Styles for gradient color fill
\define('GRAD_VER', 1);
\define('GRAD_VERT', 1);
\define('GRAD_HOR', 2);
\define('GRAD_MIDHOR', 3);
\define('GRAD_MIDVER', 4);
\define('GRAD_CENTER', 5);
\define('GRAD_WIDE_MIDVER', 6);
\define('GRAD_WIDE_MIDHOR', 7);
\define('GRAD_LEFT_REFLECTION', 8);
\define('GRAD_RIGHT_REFLECTION', 9);
\define('GRAD_RAISED_PANEL', 10);
\define('GRAD_DIAGONAL', 11);
\define('_DEFAULT_LPM_SIZE', 8); // Default Legend Plot Mark size

// Version info
\define('JPG_VERSION', '4.1.0');

// Minimum required PHP version
\define('MIN_PHPVERSION', '7.2.0');

// Special file name to indicate that we only want to calc
// the image map in the call to Graph::Stroke() used
// internally from the GetHTMLCSIM() method.
\define('_CSIM_SPECIALFILE', '_csim_special_');

// HTTP GET argument that is used with image map
// to indicate to the script to just generate the image
// and not the full CSIM HTML page.
\define('_CSIM_DISPLAY', '_jpg_csimd');

// Special filename for Graph::Stroke(). If this filename is given
// then the image will NOT be streamed to browser of file. Instead the
// Stroke call will return the handler for the created GD image.
\define('_IMG_HANDLER', '__handle');

// Special filename for Graph::Stroke(). If this filename is given
// the image will be stroked to a file with a name based on the script name.
\define('_IMG_AUTO', 'auto');

// Tick density
\define('TICKD_DENSE', 1);
\define('TICKD_NORMAL', 2);
\define('TICKD_SPARSE', 3);
\define('TICKD_VERYSPARSE', 4);

// Side for ticks and labels.
\define('SIDE_LEFT', -1);
\define('SIDE_RIGHT', 1);
\define('SIDE_DOWN', -1);
\define('SIDE_BOTTOM', -1);
\define('SIDE_UP', 1);
\define('SIDE_TOP', 1);

// Legend type stacked vertical or horizontal
\define('LEGEND_VERT', 0);
\define('LEGEND_HOR', 1);

// Mark types for plot marks
\define('MARK_SQUARE', 1);
\define('MARK_UTRIANGLE', 2);
\define('MARK_DTRIANGLE', 3);
\define('MARK_DIAMOND', 4);
\define('MARK_CIRCLE', 5);
\define('MARK_FILLEDCIRCLE', 6);
\define('MARK_CROSS', 7);
\define('MARK_STAR', 8);
\define('MARK_X', 9);
\define('MARK_LEFTTRIANGLE', 10);
\define('MARK_RIGHTTRIANGLE', 11);
\define('MARK_FLASH', 12);
\define('MARK_IMG', 13);
\define('MARK_FLAG1', 14);
\define('MARK_FLAG2', 15);
\define('MARK_FLAG3', 16);
\define('MARK_FLAG4', 17);

// Builtin images
\define('MARK_IMG_PUSHPIN', 50);
\define('MARK_IMG_SPUSHPIN', 50);
\define('MARK_IMG_LPUSHPIN', 51);
\define('MARK_IMG_DIAMOND', 52);
\define('MARK_IMG_SQUARE', 53);
\define('MARK_IMG_STAR', 54);
\define('MARK_IMG_BALL', 55);
\define('MARK_IMG_SBALL', 55);
\define('MARK_IMG_MBALL', 56);
\define('MARK_IMG_LBALL', 57);
\define('MARK_IMG_BEVEL', 58);

// Inline defines
\define('INLINE_YES', 1);
\define('INLINE_NO', 0);

// Format for background images
\define('BGIMG_FILLPLOT', 1);
\define('BGIMG_FILLFRAME', 2);
\define('BGIMG_COPY', 3);
\define('BGIMG_CENTER', 4);
\define('BGIMG_FREE', 5);

// Depth of objects
\define('DEPTH_BACK', 0);
\define('DEPTH_FRONT', 1);

// Direction
\define('VERTICAL', 1);
\define('HORIZONTAL', 0);

// Axis styles for scientific style axis
\define('AXSTYLE_SIMPLE', 1);
\define('AXSTYLE_BOXIN', 2);
\define('AXSTYLE_BOXOUT', 3);
\define('AXSTYLE_YBOXIN', 4);
\define('AXSTYLE_YBOXOUT', 5);

// Style for title backgrounds
\define('TITLEBKG_STYLE1', 1);
\define('TITLEBKG_STYLE2', 2);
\define('TITLEBKG_STYLE3', 3);
\define('TITLEBKG_FRAME_NONE', 0);
\define('TITLEBKG_FRAME_FULL', 1);
\define('TITLEBKG_FRAME_BOTTOM', 2);
\define('TITLEBKG_FRAME_BEVEL', 3);
\define('TITLEBKG_FILLSTYLE_HSTRIPED', 1);
\define('TITLEBKG_FILLSTYLE_VSTRIPED', 2);
\define('TITLEBKG_FILLSTYLE_SOLID', 3);

// Styles for axis labels background
\define('LABELBKG_NONE', 0);
\define('LABELBKG_XAXIS', 1);
\define('LABELBKG_YAXIS', 2);
\define('LABELBKG_XAXISFULL', 3);
\define('LABELBKG_YAXISFULL', 4);
\define('LABELBKG_XYFULL', 5);
\define('LABELBKG_XY', 6);

// Style for background gradient fills
\define('BGRAD_FRAME', 1);
\define('BGRAD_MARGIN', 2);
\define('BGRAD_PLOT', 3);

// Width of tab titles
\define('TABTITLE_WIDTHFIT', 0);
\define('TABTITLE_WIDTHFULL', -1);

// Defines for 3D skew directions
\define('SKEW3D_UP', 0);
\define('SKEW3D_DOWN', 1);
\define('SKEW3D_LEFT', 2);
\define('SKEW3D_RIGHT', 3);

// For internal use only
\define('_JPG_DEBUG', false);
\define('_FORCE_IMGTOFILE', false);
\define('_FORCE_IMGDIR', '/tmp/jpgimg/');

//
// Automatic settings of path for cache and font directory
// if they have not been previously specified
//
if (\mb_strstr(\PHP_OS, 'WIN')) {
    \define('SYSTEMROOT', \getenv('SystemRoot'));
}

if (USE_CACHE) {
    if (!\defined('CACHE_DIR')) {
        if (\mb_strstr(\PHP_OS, 'WIN')) {
            if (empty($_SERVER['TEMP'])) {
                $t = new ErrMsgText();
                $msg = $t->Get(11, $file, $lineno);

                exit($msg);
            }
            \define('CACHE_DIR', $_SERVER['TEMP'] . '/');
        } else {
            \define('CACHE_DIR', '/tmp/jpgraph_cache/');
        }
    }
} elseif (!\defined('CACHE_DIR')) {
    \define('CACHE_DIR', '');
}

//
// Setup path for western/latin TTF fonts
//
if (!\defined('TTF_DIR')) {
    if (\mb_strstr(\PHP_OS, 'WIN')) {
        if (empty(SYSTEMROOT)) {
            $t = new ErrMsgText();
            $msg = $t->Get(12, $file, $lineno);

            exit($msg);
        }
        \define('TTF_DIR', SYSTEMROOT . '/fonts/');
    } else {
        \define('TTF_DIR', '/usr/share/fonts/truetype/');
    }
}

//
// Setup path for MultiByte TTF fonts (japanese, chinese etc.)
//
if (!\defined('MBTTF_DIR')) {
    if (\mb_strstr(\PHP_OS, 'WIN')) {
        if (empty(SYSTEMROOT)) {
            $t = new ErrMsgText();
            $msg = $t->Get(12, $file, $lineno);

            exit($msg);
        }
        \define('MBTTF_DIR', SYSTEMROOT . '/fonts/');
    } else {
        \define('MBTTF_DIR', '/usr/share/fonts/truetype/');
    }
}

//
// Make sure PHP version is high enough
//
if (\version_compare(\PHP_VERSION, MIN_PHPVERSION) < 0) {
    Amenadiel\JpGraph\Util\JpGraphError::RaiseL(13, \PHP_VERSION, MIN_PHPVERSION);

    exit();
}

//
// Make GD sanity check
//
if (!\function_exists('imagetypes') || !\function_exists('imagecreatefromstring')) {
    Amenadiel\JpGraph\Util\JpGraphError::RaiseL(25001);
    //("This PHP installation is not configured with the GD library. Please recompile PHP with GD support to run JpGraph. (Neither function imagetypes() nor imagecreatefromstring() does exist)");
}

if (INSTALL_PHP_ERR_HANDLER) {
    \set_error_handler('\Amenadiel\JpGraph\Util\Helper::phpErrorHandler');
}

//
// Check if there were any warnings, perhaps some wrong includes by the user. In this
// case we raise it immediately since otherwise the image will not show and makes
// debugging difficult. This is controlled by the user setting CATCH_PHPERRMSG
//
if (isset($GLOBALS['php_errormsg']) && CATCH_PHPERRMSG && !\preg_match('/|Deprecated|/i', $GLOBALS['php_errormsg'])) {
    Amenadiel\JpGraph\Util\JpGraphError::RaiseL(25004, $GLOBALS['php_errormsg']);
}

// Constants for types of static bands in plot area
\define('BAND_RDIAG', 1); // Right diagonal lines
\define('BAND_LDIAG', 2); // Left diagonal lines
\define('BAND_SOLID', 3); // Solid one color
\define('BAND_VLINE', 4); // Vertical lines
\define('BAND_HLINE', 5); // Horizontal lines
\define('BAND_3DPLANE', 6); // "3D" Plane
\define('BAND_HVCROSS', 7); // Vertical/Hor crosses
\define('BAND_DIAGCROSS', 8); // Diagonal crosses

// Maximum size for Automatic Gantt chart
\define('MAX_GANTTIMG_SIZE_W', 8000);
\define('MAX_GANTTIMG_SIZE_H', 5000);

// Scale Header types
\define('GANTT_HDAY', 1);
\define('GANTT_HWEEK', 2);
\define('GANTT_HMONTH', 4);
\define('GANTT_HYEAR', 8);
\define('GANTT_HHOUR', 16);
\define('GANTT_HMIN', 32);

// Bar patterns
\define('GANTT_RDIAG', BAND_RDIAG); // Right diagonal lines
\define('GANTT_LDIAG', BAND_LDIAG); // Left diagonal lines
\define('GANTT_SOLID', BAND_SOLID); // Solid one color
\define('GANTT_VLINE', BAND_VLINE); // Vertical lines
\define('GANTT_HLINE', BAND_HLINE); // Horizontal lines
\define('GANTT_3DPLANE', BAND_3DPLANE); // "3D" Plane
\define('GANTT_HVCROSS', BAND_HVCROSS); // Vertical/Hor crosses
\define('GANTT_DIAGCROSS', BAND_DIAGCROSS); // Diagonal crosses

// Conversion constant
\define('HOURADJ_1', 0 + 30);
\define('HOURADJ_2', 1 + 30);
\define('HOURADJ_3', 2 + 30);
\define('HOURADJ_4', 3 + 30);
\define('HOURADJ_6', 4 + 30);
\define('HOURADJ_12', 5 + 30);

\define('MINADJ_1', 0 + 20);
\define('MINADJ_5', 1 + 20);
\define('MINADJ_10', 2 + 20);
\define('MINADJ_15', 3 + 20);
\define('MINADJ_30', 4 + 20);

\define('SECADJ_1', 0);
\define('SECADJ_5', 1);
\define('SECADJ_10', 2);
\define('SECADJ_15', 3);
\define('SECADJ_30', 4);

\define('YEARADJ_1', 0 + 30);
\define('YEARADJ_2', 1 + 30);
\define('YEARADJ_5', 2 + 30);

\define('MONTHADJ_1', 0 + 20);
\define('MONTHADJ_6', 1 + 20);

\define('DAYADJ_1', 0);
\define('DAYADJ_WEEK', 1);
\define('DAYADJ_7', 1);

\define('SECPERYEAR', 31536000);
\define('SECPERDAY', 86400);
\define('SECPERHOUR', 3600);
\define('SECPERMIN', 60);

// Locales. ONLY KEPT FOR BACKWARDS COMPATIBILITY
// You should use the proper locale strings directly
// from now on.
\define('LOCALE_EN', 'en_UK');
\define('LOCALE_SV', 'sv_SE');

// Layout of bars
\define('GANTT_EVEN', 1);
\define('GANTT_FROMTOP', 2);

// Style for minute header
\define('MINUTESTYLE_MM', 0); // 15
\define('MINUTESTYLE_CUSTOM', 2); // Custom format

// Style for hour header
\define('HOURSTYLE_HM24', 0); // 13:10
\define('HOURSTYLE_HMAMPM', 1); // 1:10pm
\define('HOURSTYLE_H24', 2); // 13
\define('HOURSTYLE_HAMPM', 3); // 1pm
\define('HOURSTYLE_CUSTOM', 4); // User defined

// Style for day header
\define('DAYSTYLE_ONELETTER', 0); // "M"
\define('DAYSTYLE_LONG', 1); // "Monday"
\define('DAYSTYLE_LONGDAYDATE1', 2); // "Monday 23 Jun"
\define('DAYSTYLE_LONGDAYDATE2', 3); // "Monday 23 Jun 2003"
\define('DAYSTYLE_SHORT', 4); // "Mon"
\define('DAYSTYLE_SHORTDAYDATE1', 5); // "Mon 23/6"
\define('DAYSTYLE_SHORTDAYDATE2', 6); // "Mon 23 Jun"
\define('DAYSTYLE_SHORTDAYDATE3', 7); // "Mon 23"
\define('DAYSTYLE_SHORTDATE1', 8); // "23/6"
\define('DAYSTYLE_SHORTDATE2', 9); // "23 Jun"
\define('DAYSTYLE_SHORTDATE3', 10); // "Mon 23"
\define('DAYSTYLE_SHORTDATE4', 11); // "23"
\define('DAYSTYLE_CUSTOM', 12); // "M"

// Styles for week header
\define('WEEKSTYLE_WNBR', 0);
\define('WEEKSTYLE_FIRSTDAY', 1);
\define('WEEKSTYLE_FIRSTDAY2', 2);
\define('WEEKSTYLE_FIRSTDAYWNBR', 3);
\define('WEEKSTYLE_FIRSTDAY2WNBR', 4);

// Styles for month header
\define('MONTHSTYLE_SHORTNAME', 0);
\define('MONTHSTYLE_LONGNAME', 1);
\define('MONTHSTYLE_LONGNAMEYEAR2', 2);
\define('MONTHSTYLE_SHORTNAMEYEAR2', 3);
\define('MONTHSTYLE_LONGNAMEYEAR4', 4);
\define('MONTHSTYLE_SHORTNAMEYEAR4', 5);
\define('MONTHSTYLE_FIRSTLETTER', 6);

// Types of constrain links
\define('CONSTRAIN_STARTSTART', 0);
\define('CONSTRAIN_STARTEND', 1);
\define('CONSTRAIN_ENDSTART', 2);
\define('CONSTRAIN_ENDEND', 3);

// Arrow direction for constrain links
\define('ARROW_DOWN', 0);
\define('ARROW_UP', 1);
\define('ARROW_LEFT', 2);
\define('ARROW_RIGHT', 3);

// Arrow type for constrain type
\define('ARROWT_SOLID', 0);
\define('ARROWT_OPEN', 1);

// Arrow size for constrain lines
\define('ARROW_S1', 0);
\define('ARROW_S2', 1);
\define('ARROW_S3', 2);
\define('ARROW_S4', 3);
\define('ARROW_S5', 4);

// Activity types for use with utility method CreateSimple()
\define('ACTYPE_NORMAL', 0);
\define('ACTYPE_GROUP', 1);
\define('ACTYPE_MILESTONE', 2);

\define('ACTINFO_3D', 1);
\define('ACTINFO_2D', 0);

\define('GICON_WARNINGRED', 0);
\define('GICON_TEXT', 1);
\define('GICON_ENDCONS', 2);
\define('GICON_MAIL', 3);
\define('GICON_STARTCONS', 4);
\define('GICON_CALC', 5);
\define('GICON_MAGNIFIER', 6);
\define('GICON_LOCK', 7);
\define('GICON_STOP', 8);
\define('GICON_WARNINGYELLOW', 9);
\define('GICON_FOLDEROPEN', 10);
\define('GICON_FOLDER', 11);
\define('GICON_TEXTIMPORTANT', 12);


if (!\function_exists('is_countable')) {
    function is_countable($c)
    {
        return \is_array($c) || $c instanceof Countable;
    }
}

/**
 * Returns the item count of the variable, or zero if it's non countable.
 *
 * @param mixed $var The variable whose items we want to count
 */
function safe_count($var)
{
    if (\is_countable($var)) {
        return \count($var);
    }

    return 0;
}
