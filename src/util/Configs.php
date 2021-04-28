<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Util;

use Exception;

\defined('DEFAULT_ERR_LOCALE') || \define('DEFAULT_ERR_LOCALE', 'en');

if (!\function_exists('\is_countable')) {
    function is_countable($c)
    {
        return \is_array($c) || $c instanceof \Countable;
    }
}

/*
 * NOTE THAT CACHE FUNCTIONALITY IS TURNED OFF BY  DEFAULT ENABLE BY SETTING USE_CACHE TO TRUE)
 * Should the cache be used at all? By setting this to false no
 * files will be generated in the cache directory.
 * The difference from READ_CACHE being that setting READ_CACHE to
 * false will still create the image in the cache directory
 * just not use it. By setting USE_CACHE=false no files will even
 * be generated in the cache directory.
 */
\defined('USE_CACHE') || \define('USE_CACHE', \getenv('JPGRAPH_USE_CACHE') || false);

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
if (\mb_strstr(\PHP_OS, 'WIN') && \getenv('SystemRoot')) {
    \define('SYSTEMROOT', \getenv('SystemRoot'));
}

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
\define('CSIMCACHE_DIR', \getenv('JPGRAPH_CSIMCACHE_DIR') || 'csimcache/');
\define('CSIMCACHE_HTTP_DIR', \getenv('JPGRAPH_CSIMCACHE_HTTP_DIR') || 'csimcache/');

// Should we try to find an image in the cache before generating it?
// Set this define to false to bypass the reading of the cache and always
// regenerate the image. Note that even if reading the cache is
// disabled the cached will still be updated with the newly generated
// image. Set also 'USE_CACHE' below.
\defined('READ_CACHE') || \define('READ_CACHE', true);

/*
 * The following constants should rarely have to be changed !
 */
// What group should the cached file belong to
// (Set to '' will give the default group for the 'PHP-user')
// Please note that the Apache user must be a member of the
// specified group since otherwise it is impossible for Apache
// to set the specified group.
\defined('CACHE_FILE_GROUP') || \define('CACHE_FILE_GROUP', \getenv('JPGRAPH_CACHE_FILE_GROUP') || 'www');

// What permissions should the cached file have
// (Set to '' will give the default persmissions for the 'PHP-user')
\defined('CACHE_FILE_MOD') || \define('CACHE_FILE_MOD', \getenv('JPGRAPH_CACHE_FILE_MOD') || 0664);
\defined('DEFAULT_THEME_CLASS') || \define('DEFAULT_THEME_CLASS', 'UniversalTheme');

/*
 * NOTE THAT CACHE FUNCTIONALITY IS TURNED OFF BY  DEFAULT ENABLE BY SETTING USE_CACHE TO TRUE)
 * Should the cache be used at all? By setting this to false no
 * files will be generated in the cache directory.
 * The difference from READ_CACHE being that setting READ_CACHE to
 * false will still create the image in the cache directory
 * just not use it. By setting USE_CACHE=false no files will even
 * be generated in the cache directory.
 */
\defined('USE_CACHE') || \define('USE_CACHE', \getenv('JPGRAPH_USE_CACHE') || false);
/**
 * @class Configs
 *
 * Basic constants getter and setter.
 * self::f(he user beforehand,
 * self::t(efaults defined here.
 */
class Configs
{
    const GICON_WARNINGRED = 0;
    const GICON_TEXT = 1;
    const GICON_ENDCONS = 2;
    const GICON_MAIL = 3;
    const GICON_STARTCONS = 4;
    const GICON_CALC = 5;
    const GICON_MAGNIFIER = 6;
    const GICON_LOCK = 7;
    const GICON_STOP = 8;
    const GICON_WARNINGYELLOW = 9;
    const GICON_FOLDEROPEN = 10;
    const GICON_FOLDER = 11;
    const GICON_TEXTIMPORTANT = 12;
    const LBLALIGN_CENTER = 1;
    const LBLALIGN_TOP = 2;
    const FF_DEFAULT = 47;
    // Configs for types of static bands in plot area
    const BAND_RDIAG = 1; // Right diagonal lines
    const BAND_LDIAG = 2; // Left diagonal lines
    const BAND_SOLID = 3; // Solid one color
    const BAND_VLINE = 4; // Vertical lines
    const BAND_HLINE = 5; // Horizontal lines
    const BAND_3DPLANE = 6; // "3D" Plane
    const BAND_HVCROSS = 7; // Vertical/Hor crosses
    const BAND_DIAGCROSS = 8; // Diagonal crosses

    //const CACHE_DIR=CACHE_DIR;
    //const TTF_DIR=TTF_DIR;
    //const MBTTF_DIR=MBTTF_DIR;
    const CSIMCACHE_DIR = CSIMCACHE_DIR;
    const CSIMCACHE_HTTP_DIR = CSIMCACHE_HTTP_DIR;
    const READ_CACHE = READ_CACHE;
    const CACHE_FILE_GROUP = CACHE_FILE_GROUP;
    const CACHE_FILE_MOD = CACHE_FILE_MOD;
    //const DEFAULT_THEME_CLASS=DEFAULT_THEME_CLASS;
    // Bar patterns
    const GANTT_RDIAG = self::BAND_RDIAG; // Right diagonal lines
    const GANTT_LDIAG = self::BAND_LDIAG; // Left diagonal lines
    const GANTT_SOLID = self::BAND_SOLID; // Solid one color
    const GANTT_VLINE = self::BAND_VLINE; // Vertical lines
    const GANTT_HLINE = self::BAND_HLINE; // Horizontal lines
    const GANTT_3DPLANE = self::BAND_3DPLANE; // "3D" Plane
    const GANTT_HVCROSS = self::BAND_HVCROSS; // Vertical/Hor crosses
    const GANTT_DIAGCROSS = self::BAND_DIAGCROSS; // Diagonal crosses
    // Scale Header types
    const GANTT_HDAY = 1;
    const GANTT_HWEEK = 2;
    const GANTT_HMONTH = 4;
    const GANTT_HYEAR = 8;
    const GANTT_HHOUR = 16;
    const GANTT_HMIN = 32;

    // Conversion constant
    const HOURADJ_1 = 0 + 30;
    const HOURADJ_2 = 1 + 30;
    const HOURADJ_3 = 2 + 30;
    const HOURADJ_4 = 3 + 30;
    const HOURADJ_6 = 4 + 30;
    const HOURADJ_12 = 5 + 30;
    const MINADJ_1 = 0 + 20;
    const MINADJ_5 = 1 + 20;
    const MINADJ_10 = 2 + 20;
    const MINADJ_15 = 3 + 20;
    const MINADJ_30 = 4 + 20;
    const SECADJ_1 = 0;
    const SECADJ_5 = 1;
    const SECADJ_10 = 2;
    const SECADJ_15 = 3;
    const SECADJ_30 = 4;
    const YEARADJ_1 = 0 + 30;
    const YEARADJ_2 = 1 + 30;
    const YEARADJ_5 = 2 + 30;
    const MONTHADJ_1 = 0 + 20;
    const MONTHADJ_6 = 1 + 20;
    const DAYADJ_1 = 0;
    const DAYADJ_WEEK = 1;
    const DAYADJ_7 = 1;
    const SECPERYEAR = 31536000;
    const SECPERDAY = 86400;
    const SECPERHOUR = 3600;
    const SECPERMIN = 60;
    // Layout of bars
    const GANTT_EVEN = 1;
    const GANTT_FROMTOP = 2;
    // Style for minute header
    const MINUTESTYLE_MM = 0; // 15
    const MINUTESTYLE_CUSTOM = 2; // Custom format
    // Style for hour header
    const HOURSTYLE_HM24 = 0; // 13:10
    const HOURSTYLE_HMAMPM = 1; // 1:10pm
    const HOURSTYLE_H24 = 2; // 13
    const HOURSTYLE_HAMPM = 3; // 1pm
    const HOURSTYLE_CUSTOM = 4; // User defined
    // Style for day header
    const DAYSTYLE_ONELETTER = 0; // "M"
    const DAYSTYLE_LONG = 1; // "Monday"
    const DAYSTYLE_LONGDAYDATE1 = 2; // "Monday 23 Jun"
    const DAYSTYLE_LONGDAYDATE2 = 3; // "Monday 23 Jun 2003"
    const DAYSTYLE_SHORT = 4; // "Mon"
    const DAYSTYLE_SHORTDAYDATE1 = 5; // "Mon 23/6"
    const DAYSTYLE_SHORTDAYDATE2 = 6; // "Mon 23 Jun"
    const DAYSTYLE_SHORTDAYDATE3 = 7; // "Mon 23"
    const DAYSTYLE_SHORTDATE1 = 8; // "23/6"
    const DAYSTYLE_SHORTDATE2 = 9; // "23 Jun"
    const DAYSTYLE_SHORTDATE3 = 10; // "Mon 23"
    const DAYSTYLE_SHORTDATE4 = 11; // "23"
    const DAYSTYLE_CUSTOM = 12; // "M"
    // Styles for week header
    const WEEKSTYLE_WNBR = 0;
    const WEEKSTYLE_FIRSTDAY = 1;
    const WEEKSTYLE_FIRSTDAY2 = 2;
    const WEEKSTYLE_FIRSTDAYWNBR = 3;
    const WEEKSTYLE_FIRSTDAY2WNBR = 4;
    // Styles for month header
    const MONTHSTYLE_SHORTNAME = 0;
    const MONTHSTYLE_LONGNAME = 1;
    const MONTHSTYLE_LONGNAMEYEAR2 = 2;
    const MONTHSTYLE_SHORTNAMEYEAR2 = 3;
    const MONTHSTYLE_LONGNAMEYEAR4 = 4;
    const MONTHSTYLE_SHORTNAMEYEAR4 = 5;
    const MONTHSTYLE_FIRSTLETTER = 6;
    // Types of constrain links
    const CONSTRAIN_STARTSTART = 0;
    const CONSTRAIN_STARTEND = 1;
    const CONSTRAIN_ENDSTART = 2;
    const CONSTRAIN_ENDEND = 3;
    // Arrow direction for constrain links
    const ARROW_DOWN = 0;
    const ARROW_UP = 1;
    const ARROW_LEFT = 2;
    const ARROW_RIGHT = 3;
    // Arrow type for constrain type
    const ARROWT_SOLID = 0;
    const ARROWT_OPEN = 1;
    // Arrow size for constrain lines
    const ARROW_S1 = 0;
    const ARROW_S2 = 1;
    const ARROW_S3 = 2;
    const ARROW_S4 = 3;
    const ARROW_S5 = 4;
    // Activity types for use with utility method CreateSimple()
    const ACTYPE_NORMAL = 0;
    const ACTYPE_GROUP = 1;
    const ACTYPE_MILESTONE = 2;
    const ACTINFO_3D = 1;
    const ACTINFO_2D = 0;

    const _CSIM_DISPLAY = '_jpg_csimd';
    const _CSIM_SPECIALFILE = '_csim_special_';
    const _DEFAULT_LPM_SIZE = 8; // Default Legend Plot Mark size;
    const _FORCE_IMGDIR = '/tmp/jpgimg/';
    const _FORCE_IMGTOFILE = false;
    const _IMG_AUTO = 'auto';
    const _IMG_HANDLER = '__handle';
    const _JPG_DEBUG = false;

    /*const ACTINFO_2D                  = 0;
    const ACTINFO_3D                  = 1;
    const ACTYPE_GROUP                = 1;
    const ACTYPE_MILESTONE            = 2;
    const ACTYPE_NORMAL               = 0;
    const ARROW_DOWN                  = 0;
    const ARROW_LEFT                  = 2;
    const ARROW_RIGHT                 = 3;
    const ARROW_S1                    = 0;
    const ARROW_S2                    = 1;
    const ARROW_S3                    = 2;
    const ARROW_S4                    = 3;
    const ARROW_S5                    = 4;
    const ARROW_UP                    = 1;
    const ARROWT_OPEN                 = 1;
    const ARROWT_SOLID                = 0;*/

    const AXSTYLE_BOXIN = 2;
    const AXSTYLE_BOXOUT = 3;
    const AXSTYLE_SIMPLE = 1;
    const AXSTYLE_YBOXIN = 4;
    const AXSTYLE_YBOXOUT = 5;
    const BGIMG_CENTER = 4;
    const BGIMG_COPY = 3;
    const BGIMG_FILLFRAME = 2;
    const BGIMG_FILLPLOT = 1;
    const BGIMG_FREE = 5;
    const BGRAD_FRAME = 1;
    const BGRAD_MARGIN = 2;
    const BGRAD_PLOT = 3;
    const CACHE_DIR = '/tmp/jpgraph_cache/';
    const CATCH_PHPERRMSG = true;
    const CHINESE_TTF_FONT = 'bkai00mp.ttf';
    /*
    const CONSTRAIN_ENDEND            = 3;
    const CONSTRAIN_ENDSTART          = 2;
    const CONSTRAIN_STARTEND          = 1;
    const CONSTRAIN_STARTSTART        = 0;
     */

    const CYRILLIC_FROM_WINDOWS = false;
    /*
    const DAYADJ_1                    = 0;
    const DAYADJ_7                    = 1;
    const DAYADJ_WEEK                 = 1;
    const DAYSTYLE_CUSTOM             = 12;
    const DAYSTYLE_LONG               = 1;
    const DAYSTYLE_LONGDAYDATE1       = 2;
    const DAYSTYLE_LONGDAYDATE2       = 3;
    const DAYSTYLE_ONELETTER          = 0;
    const DAYSTYLE_SHORT              = 4;
    const DAYSTYLE_SHORTDATE1         = 8;
    const DAYSTYLE_SHORTDATE2         = 9;
    const DAYSTYLE_SHORTDATE3         = 10;
    const DAYSTYLE_SHORTDATE4         = 11;
    const DAYSTYLE_SHORTDAYDATE1      = 5;
    const DAYSTYLE_SHORTDAYDATE2      = 6;
    const DAYSTYLE_SHORTDAYDATE3      = 7;
     */
    const DEFAULT_GFORMAT = 'auto';
    const DEFAULT_THEME_CLASS = 'UniversalTheme';
    const DEPTH_BACK = 0;
    const DEPTH_FRONT = 1;
    const ERR_DEPRECATED = true;
    const FF_AHRON = 46;
    const FF_ARIAL = 15;
    const FF_BIG5 = 32;
    const FF_CALCULATOR = 74;
    const FF_CHINESE = 31;
    const FF_COMIC = 14;
    const FF_COMPUTER = 73;
    const FF_COURIER = 10;
    const FF_DAVID = 44;
    const FF_DIGITAL = 72;
    const FF_DV_SANSSERIF = self::FF_DEFAULT;
    const FF_DV_SANSSERIFCOND = 51;
    const FF_DV_SANSSERIFMONO = 49;
    const FF_DV_SERIF = 48;
    const FF_DV_SERIFCOND = 50;
    const FF_FONT0 = 1;
    const FF_FONT1 = 2;
    const FF_FONT2 = 4;
    const FF_GEORGIA = 16;
    const FF_GOTHIC = 42;
    const FF_MINCHO = 40;
    const FF_MIRIAM = 45;
    const FF_PGOTHIC = 43;
    const FF_PMINCHO = 41;
    const FF_SIMSUN = 30;
    const FF_TIMES = 12;
    const FF_TREBUCHE = 17;
    const FF_USERFONT = 90;
    const FF_USERFONT1 = 90;
    const FF_USERFONT2 = 91;
    const FF_USERFONT3 = 92;
    const FF_VERA = 18;
    const FF_VERAMONO = 19;
    const FF_VERASERIF = 20;
    const FF_VERDANA = 11;
    const FS_BOLD = 9002;
    const FS_BOLDIT = 9004;
    const FS_BOLDITALIC = 9004;
    const FS_ITALIC = 9003;
    const FS_NORMAL = 9001;
    /*
    const GANTT_EVEN                  = 1;
    const GANTT_FROMTOP               = 2;
    const GANTT_HDAY                  = 1;
    const GANTT_HHOUR                 = 16;
    const GANTT_HMIN                  = 32;
    const GANTT_HMONTH                = 4;
    const GANTT_HWEEK                 = 2;
    const GANTT_HYEAR                 = 8;

     */
    const GOTHIC_TTF_FONT = 'ipag.ttf';
    const GRAD_CENTER = 5;
    const GRAD_DIAGONAL = 11;
    const GRAD_HOR = 2;
    const GRAD_LEFT_REFLECTION = 8;
    const GRAD_MIDHOR = 3;
    const GRAD_MIDVER = 4;
    const GRAD_RAISED_PANEL = 10;
    const GRAD_RIGHT_REFLECTION = 9;
    const GRAD_VER = 1;
    const GRAD_VERT = 1;
    const GRAD_WIDE_MIDHOR = 7;
    const GRAD_WIDE_MIDVER = 6;
    const GREEK_FROM_WINDOWS = false;
    const HORIZONTAL = 0;
    /*
    const HOURADJ_1                   = 0 + 30;
    const HOURADJ_12                  = 5 + 30;
    const HOURADJ_2                   = 1 + 30;
    const HOURADJ_3                   = 2 + 30;
    const HOURADJ_4                   = 3 + 30;
    const HOURADJ_6                   = 4 + 30;
    const HOURSTYLE_CUSTOM            = 4;
    const HOURSTYLE_H24               = 2;
    const HOURSTYLE_HAMPM             = 3;
    const HOURSTYLE_HM24              = 0;
    const HOURSTYLE_HMAMPM            = 1;*/
    const INLINE_NO = 0;
    const INLINE_YES = 1;
    const INSTALL_PHP_ERR_HANDLER = true;
    const JPG_VERSION = '3.5.0b1';
    const LABELBKG_NONE = 0;
    const LABELBKG_XAXIS = 1;
    const LABELBKG_XAXISFULL = 3;
    const LABELBKG_XY = 6;
    const LABELBKG_XYFULL = 5;
    const LABELBKG_YAXIS = 2;
    const LABELBKG_YAXISFULL = 4;

    const LEGEND_HOR = 1;
    const LEGEND_VERT = 0;
    const LINESTYLE_DASHED = 3;
    const LINESTYLE_DOTTED = 2;
    const LINESTYLE_LONGDASH = 4;
    const LINESTYLE_SOLID = 1;
    const LOCALE_EN = 'en_UK';
    const LOCALE_SV = 'sv_SE';
    const MARK_CIRCLE = 5;
    const MARK_CROSS = 7;
    const MARK_DIAMOND = 4;
    const MARK_DTRIANGLE = 3;
    const MARK_FILLEDCIRCLE = 6;
    const MARK_FLAG1 = 14;
    const MARK_FLAG2 = 15;
    const MARK_FLAG3 = 16;
    const MARK_FLAG4 = 17;
    const MARK_FLASH = 12;
    const MARK_IMG = 13;
    const MARK_IMG_BALL = 55;
    const MARK_IMG_BEVEL = 58;
    const MARK_IMG_DIAMOND = 52;
    const MARK_IMG_LBALL = 57;
    const MARK_IMG_LPUSHPIN = 51;
    const MARK_IMG_MBALL = 56;
    const MARK_IMG_PUSHPIN = 50;
    const MARK_IMG_SBALL = 55;
    const MARK_IMG_SPUSHPIN = 50;
    const MARK_IMG_SQUARE = 53;
    const MARK_IMG_STAR = 54;
    const MARK_LEFTTRIANGLE = 10;
    const MARK_RIGHTTRIANGLE = 11;
    const MARK_SQUARE = 1;
    const MARK_STAR = 8;
    const MARK_UTRIANGLE = 2;
    const MARK_X = 9;
    const MAX_GANTTIMG_SIZE_H = 5000;
    const MAX_GANTTIMG_SIZE_W = 8000;
    const MBTTF_DIR = '/usr/share/fonts/truetype/';
    const MIN_PHPVERSION = '7.0.0';
    /*const MINADJ_1                    = 0 + 20;
    const MINADJ_10                   = 2 + 20;
    const MINADJ_15                   = 3 + 20;
    const MINADJ_30                   = 4 + 20;
    const MINADJ_5                    = 1 + 20;
    const MINUTESTYLE_CUSTOM          = 2;
    const MINUTESTYLE_MM              = 0;
    const MONTHADJ_1                  = 0 + 20;
    const MONTHADJ_6                  = 1 + 20;
    const MONTHSTYLE_FIRSTLETTER      = 6;
    const MONTHSTYLE_LONGNAME         = 1;
    const MONTHSTYLE_LONGNAMEYEAR2    = 2;
    const MONTHSTYLE_LONGNAMEYEAR4    = 4;
    const MONTHSTYLE_SHORTNAME        = 0;
    const MONTHSTYLE_SHORTNAMEYEAR2   = 3;
    const MONTHSTYLE_SHORTNAMEYEAR4   = 5;*/

    /*const SECADJ_1                    = 0;
    const SECADJ_10                   = 2;
    const SECADJ_15                   = 3;
    const SECADJ_30                   = 4;
    const SECADJ_5                    = 1;
    const SECPERDAY                   = 86400;
    const SECPERHOUR                  = 3600;
    const SECPERMIN                   = 60;
    const SECPERYEAR                  = 31536000;*/
    const SIDE_BOTTOM = -1;
    const SIDE_DOWN = -1;
    const SIDE_LEFT = -1;
    const SIDE_RIGHT = 1;
    const SIDE_TOP = 1;
    const SIDE_UP = 1;
    const SKEW3D_DOWN = 1;
    const SKEW3D_LEFT = 2;
    const SKEW3D_RIGHT = 3;
    const SKEW3D_UP = 0;
    const SUPERSAMPLING = true;
    const SUPERSAMPLING_SCALE = 1;
    const TABTITLE_WIDTHFIT = 0;
    const TABTITLE_WIDTHFULL = -1;
    const TICKD_DENSE = 1;
    const TICKD_NORMAL = 2;
    const TICKD_SPARSE = 3;
    const TICKD_VERYSPARSE = 4;
    const TITLEBKG_FILLSTYLE_HSTRIPED = 1;
    const TITLEBKG_FILLSTYLE_SOLID = 3;
    const TITLEBKG_FILLSTYLE_VSTRIPED = 2;
    const TITLEBKG_FRAME_BEVEL = 3;
    const TITLEBKG_FRAME_BOTTOM = 2;
    const TITLEBKG_FRAME_FULL = 1;
    const TITLEBKG_FRAME_NONE = 0;
    const TITLEBKG_STYLE1 = 1;
    const TITLEBKG_STYLE2 = 2;
    const TITLEBKG_STYLE3 = 3;
    const TTF_DIR = '/usr/share/fonts/truetype/';
    const USE_LIBRARY_IMAGETTFBBOX = true;
    const VERTICAL = 1;

    /*const Configs::WEEKSTYLE_FIRSTDAY          = 1;
    const WEEKSTYLE_FIRSTDAY2         = 2;
    const WEEKSTYLE_FIRSTDAY2WNBR     = 4;
    const WEEKSTYLE_FIRSTDAYWNBR      = 3;
    const WEEKSTYLE_WNBR              = 0;*/
    /*const Configs::YEARADJ_1                   = 0 + 30;
    const YEARADJ_2                   = 1 + 30;
    const YEARADJ_5                   = 2 + 30;*/
    public static $FOUND_FONTS = [];

    protected static $lazy_statics = [
        'AXSTYLE_BOXIN' => self::AXSTYLE_BOXIN,
        'AXSTYLE_BOXOUT' => self::AXSTYLE_BOXOUT,
        'AXSTYLE_SIMPLE' => self::AXSTYLE_SIMPLE,
        'AXSTYLE_YBOXIN' => self::AXSTYLE_YBOXIN,
        'AXSTYLE_YBOXOUT' => self::AXSTYLE_YBOXOUT,
        'BGIMG_CENTER' => self::BGIMG_CENTER,
        'BGIMG_COPY' => self::BGIMG_COPY,
        'BGIMG_FILLFRAME' => self::BGIMG_FILLFRAME,
        'BGIMG_FILLPLOT' => self::BGIMG_FILLPLOT,
        'BGIMG_FREE' => self::BGIMG_FREE,
        'BGRAD_FRAME' => self::BGRAD_FRAME,
        'BGRAD_MARGIN' => self::BGRAD_MARGIN,
        'BGRAD_PLOT' => self::BGRAD_PLOT,
        'CATCH_PHPERRMSG' => self::CATCH_PHPERRMSG,
        'CHINESE_TTF_FONT' => self::CHINESE_TTF_FONT,
        'CSIMCACHE_DIR' => self::CSIMCACHE_DIR,
        'CSIMCACHE_HTTP_DIR' => self::CSIMCACHE_HTTP_DIR,
        'DEFAULT_ERR_LOCALE' => 'en',
        'DEFAULT_GFORMAT' => self::DEFAULT_GFORMAT,
        'DEFAULT_THEME_CLASS' => self::DEFAULT_THEME_CLASS,
        'DEPTH_BACK' => self::DEPTH_BACK,
        'DEPTH_FRONT' => self::DEPTH_FRONT,
        'ERR_DEPRECATED' => self::ERR_DEPRECATED,
        'FF_AHRON' => self::FF_AHRON,
        'FF_ARIAL' => self::FF_ARIAL,
        'FF_BIG5' => self::FF_BIG5,
        'FF_CALCULATOR' => self::FF_CALCULATOR,
        'FF_CHINESE' => self::FF_CHINESE,
        'FF_COMIC' => self::FF_COMIC,
        'FF_COMPUTER' => self::FF_COMPUTER,
        'FF_COURIER' => self::FF_COURIER,
        'FF_DAVID' => self::FF_DAVID,
        'FF_DIGITAL' => self::FF_DIGITAL,
        'FF_DV_SANSSERIF' => self::FF_DV_SANSSERIF,
        'FF_DV_SANSSERIFCOND' => self::FF_DV_SANSSERIFCOND,
        'FF_DV_SANSSERIFMONO' => self::FF_DV_SANSSERIFMONO,
        'FF_DV_SERIF' => self::FF_DV_SERIF,
        'FF_DV_SERIFCOND' => self::FF_DV_SERIFCOND,
        'FF_FONT0' => self::FF_FONT0,
        'FF_FONT1' => self::FF_FONT1,
        'FF_FONT2' => self::FF_FONT2,
        'FF_GEORGIA' => self::FF_GEORGIA,
        'FF_GOTHIC' => self::FF_GOTHIC,
        'FF_MINCHO' => self::FF_MINCHO,
        'FF_MIRIAM' => self::FF_MIRIAM,
        'FF_PGOTHIC' => self::FF_PGOTHIC,
        'FF_PMINCHO' => self::FF_PMINCHO,
        'FF_SIMSUN' => self::FF_SIMSUN,
        'FF_TIMES' => self::FF_TIMES,
        'FF_TREBUCHE' => self::FF_TREBUCHE,
        'FF_USERFONT' => self::FF_USERFONT,
        'FF_USERFONT1' => self::FF_USERFONT1,
        'FF_USERFONT2' => self::FF_USERFONT2,
        'FF_USERFONT3' => self::FF_USERFONT3,
        'FF_VERA' => self::FF_VERA,
        'FF_VERAMONO' => self::FF_VERAMONO,
        'FF_VERASERIF' => self::FF_VERASERIF,
        'FF_VERDANA' => self::FF_VERDANA,
        'FS_BOLD' => self::FS_BOLD,
        'FS_BOLDIT' => self::FS_BOLDIT,
        'FS_BOLDITALIC' => self::FS_BOLDITALIC,
        'FS_ITALIC' => self::FS_ITALIC,
        'FS_NORMAL' => self::FS_NORMAL,
        'GOTHIC_TTF_FONT' => self::GOTHIC_TTF_FONT,
        'GRAD_CENTER' => self::GRAD_CENTER,
        'GRAD_DIAGONAL' => self::GRAD_DIAGONAL,
        'GRAD_HOR' => self::GRAD_HOR,
        'GRAD_LEFT_REFLECTION' => self::GRAD_LEFT_REFLECTION,
        'GRAD_MIDHOR' => self::GRAD_MIDHOR,
        'GRAD_MIDVER' => self::GRAD_MIDVER,
        'GRAD_RAISED_PANEL' => self::GRAD_RAISED_PANEL,
        'GRAD_RIGHT_REFLECTION' => self::GRAD_RIGHT_REFLECTION,
        'GRAD_VER' => self::GRAD_VER,
        'GRAD_VERT' => self::GRAD_VERT,
        'GRAD_WIDE_MIDHOR' => self::GRAD_WIDE_MIDHOR,
        'GRAD_WIDE_MIDVER' => self::GRAD_WIDE_MIDVER,
        'HORIZONTAL' => self::HORIZONTAL,
        'INLINE_NO' => self::INLINE_NO,
        'INLINE_YES' => self::INLINE_YES,
        'INSTALL_PHP_ERR_HANDLER' => self::INSTALL_PHP_ERR_HANDLER,
        'JPG_VERSION' => self::JPG_VERSION,
        'LABELBKG_NONE' => self::LABELBKG_NONE,
        'LABELBKG_XAXIS' => self::LABELBKG_XAXIS,
        'LABELBKG_XAXISFULL' => self::LABELBKG_XAXISFULL,
        'LABELBKG_XY' => self::LABELBKG_XY,
        'LABELBKG_XYFULL' => self::LABELBKG_XYFULL,
        'LABELBKG_YAXIS' => self::LABELBKG_YAXIS,
        'LABELBKG_YAXISFULL' => self::LABELBKG_YAXISFULL,

        'LEGEND_HOR' => self::LEGEND_HOR,
        'LEGEND_VERT' => self::LEGEND_VERT,
        'LINESTYLE_DASHED' => self::LINESTYLE_DASHED,
        'LINESTYLE_DOTTED' => self::LINESTYLE_DOTTED,
        'LINESTYLE_LONGDASH' => self::LINESTYLE_LONGDASH,
        'LINESTYLE_SOLID' => self::LINESTYLE_SOLID,
        'LOCALE_EN' => self::LOCALE_EN,
        'LOCALE_SV' => self::LOCALE_SV,
        'MARK_CIRCLE' => self::MARK_CIRCLE,
        'MARK_CROSS' => self::MARK_CROSS,
        'MARK_DIAMOND' => self::MARK_DIAMOND,
        'MARK_DTRIANGLE' => self::MARK_DTRIANGLE,
        'MARK_FILLEDCIRCLE' => self::MARK_FILLEDCIRCLE,
        'MARK_FLAG1' => self::MARK_FLAG1,
        'MARK_FLAG2' => self::MARK_FLAG2,
        'MARK_FLAG3' => self::MARK_FLAG3,
        'MARK_FLAG4' => self::MARK_FLAG4,
        'MARK_FLASH' => self::MARK_FLASH,
        'MARK_IMG' => self::MARK_IMG,
        'MARK_IMG_BALL' => self::MARK_IMG_BALL,
        'MARK_IMG_BEVEL' => self::MARK_IMG_BEVEL,
        'MARK_IMG_DIAMOND' => self::MARK_IMG_DIAMOND,

        'MARK_IMG_LPUSHPIN' => self::MARK_IMG_LPUSHPIN,
        'MARK_IMG_MBALL' => self::MARK_IMG_MBALL,
        'MARK_IMG_PUSHPIN' => self::MARK_IMG_PUSHPIN,
        'MARK_IMG_SBALL' => self::MARK_IMG_SBALL,
        'MARK_IMG_SPUSHPIN' => self::MARK_IMG_SPUSHPIN,
        'MARK_IMG_SQUARE' => self::MARK_IMG_SQUARE,
        'MARK_IMG_STAR' => self::MARK_IMG_STAR,
        'MARK_LEFTTRIANGLE' => self::MARK_LEFTTRIANGLE,
        'MARK_RIGHTTRIANGLE' => self::MARK_RIGHTTRIANGLE,
        'MARK_SQUARE' => self::MARK_SQUARE,
        'MARK_STAR' => self::MARK_STAR,
        'MARK_UTRIANGLE' => self::MARK_UTRIANGLE,
        'MARK_X' => self::MARK_X,
        'MAX_GANTTIMG_SIZE_H' => self::MAX_GANTTIMG_SIZE_H,
        'MAX_GANTTIMG_SIZE_W' => self::MAX_GANTTIMG_SIZE_W,
        'MBTTF_DIR' => self::MBTTF_DIR,

        'MIN_PHPVERSION' => self::MIN_PHPVERSION,
        'READ_CACHE' => self::READ_CACHE,
        'SIDE_BOTTOM' => self::SIDE_BOTTOM,
        'SIDE_DOWN' => self::SIDE_DOWN,
        'SIDE_LEFT' => self::SIDE_LEFT,
        'SIDE_RIGHT' => self::SIDE_RIGHT,
        'SIDE_TOP' => self::SIDE_TOP,
        'SIDE_UP' => self::SIDE_UP,
        'SKEW3D_DOWN' => self::SKEW3D_DOWN,
        'SKEW3D_LEFT' => self::SKEW3D_LEFT,
        'SKEW3D_RIGHT' => self::SKEW3D_RIGHT,
        'SKEW3D_UP' => self::SKEW3D_UP,
        'SUPERSAMPLING' => self::SUPERSAMPLING,
        'SUPERSAMPLING_SCALE' => self::SUPERSAMPLING_SCALE,
        'TABTITLE_WIDTHFIT' => self::TABTITLE_WIDTHFIT,
        'TABTITLE_WIDTHFULL' => self::TABTITLE_WIDTHFULL,
        'TICKD_DENSE' => self::TICKD_DENSE,
        'TICKD_NORMAL' => self::TICKD_NORMAL,
        'TICKD_SPARSE' => self::TICKD_SPARSE,
        'TICKD_VERYSPARSE' => self::TICKD_VERYSPARSE,
        'TITLEBKG_FILLSTYLE_HSTRIPED' => self::TITLEBKG_FILLSTYLE_HSTRIPED,
        'TITLEBKG_FILLSTYLE_SOLID' => self::TITLEBKG_FILLSTYLE_SOLID,
        'TITLEBKG_FILLSTYLE_VSTRIPED' => self::TITLEBKG_FILLSTYLE_VSTRIPED,
        'TITLEBKG_FRAME_BEVEL' => self::TITLEBKG_FRAME_BEVEL,
        'TITLEBKG_FRAME_BOTTOM' => self::TITLEBKG_FRAME_BOTTOM,
        'TITLEBKG_FRAME_FULL' => self::TITLEBKG_FRAME_FULL,
        'TITLEBKG_FRAME_NONE' => self::TITLEBKG_FRAME_NONE,
        'TITLEBKG_STYLE1' => self::TITLEBKG_STYLE1,
        'TITLEBKG_STYLE2' => self::TITLEBKG_STYLE2,
        'TITLEBKG_STYLE3' => self::TITLEBKG_STYLE3,
        'USE_IMAGE_ERROR_HANDLER' => null, //self::USE_IMAGE_ERROR_HANDLER,
        'USE_LIBRARY_IMAGETTFBBOX' => self::USE_LIBRARY_IMAGETTFBBOX,
        'VERTICAL' => self::VERTICAL,
        '_DEFAULT_LPM_SIZE' => (8), // Default Legend Plot Mark size,
        // For internal use only
        '_JPG_DEBUG' => (false),
        '_FORCE_IMGTOFILE' => (false),
        '_FORCE_IMGDIR' => ('/tmp/jpgimg/'),
        'CACHE_DIR' => null,
        'TTF_DIR' => null,
        'MBTTF_DIR' => null,
        'CSIMCACHE_DIR' => null,
        'CSIMCACHE_HTTP_DIR' => null,
        // Special file name to indicate that we only want to calc
        // the image map in the call to Graph::Stroke() used
        // internally from the GetHTMLCSIM() method.
        '_CSIM_SPECIALFILE' => ('_csim_special_'),

        // HTTP GET argument that is used with image map
        // to indicate to the script to just generate the image
        // and not the full CSIM HTML page.
        '_CSIM_DISPLAY' => ('_jpg_csimd'),

        // Special filename for Graph::Stroke(). If this filename is given
        // then the image will NOT be streamed to browser of file. Instead the
        // Stroke call will return the handler for the created GD image.
        '_IMG_HANDLER' => ('__handle'),

        // Special filename for Graph::Stroke(). If this filename is given
        // the image will be stroked to a file with a name based on the script name.
        '_IMG_AUTO' => ('auto'),
    ];

    private static $active_lazy_statics = [];

    private static $Instance;

    /**
     * @see https://www.php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.methods
     * This workaround allows to access JPGraph constants
     * as if they were static properties of this class in the form
     *
     * ```
     *  $ttf_folder = \Configs::TTF_FOLDER
     * ```
     *
     * Same goes for setting the default value;
     *
     * ```
     * \Configs::TTF_FOLDER('/var/www')
     * ```
     *
     * It will only handle constant names from an internal whitelist,
     * and accept setters only for scalars.
     *
     * and wreak havoc otherwise. { (╯°□°)╯︵ ┻━┻   }
     *
     * @param string $const_name The constant's name
     */
    public static function __callStatic(string $const_name, array $args)
    {
        /*
         * Not a constant/static that we know of
         */
        if (!\array_key_exists($const_name, self::$lazy_statics)) {
            throw new Exception(\sprintf('You requested an unknown constant "%s"', $const_name));
        }
        /*
         * It's a static that we know of, we'll check if the calling class is trying
         * to set or get its value
         */
        return $args && \is_scalar($args) ? self::setConfig($const_name, $args) : self::getConfig($const_name);
    }

    public function __get($config_key)
    {
    }

    public static function getInstance()
    {
        if (self::$Instance) {
            return;
        }

        self::$Instance = new self();
    }

    /**
     * If trying to get the constant value, return the current one
     * or set it as the default declared in $lazy_statics.
     *
     * @param string $config_key The config_key name
     *
     * @throws Exception (description)
     *
     * @return array the constant
     */
    public static function getConfig(string $config_key)
    {
        // Environment variable takes precedence
        if (\getenv(\sprintf('JPGRAPH_%s', $config_key))) {
            return \getenv(\sprintf('JPGRAPH_%s', $config_key));
        }
        // Local or inherited class constants come next
        if (\defined(\sprintf('static::%s', $config_key))) {
            return \constant(\sprintf('static::%s', $config_key));
        }
        // Global constants in third place
        if (\defined($config_key)) {
            return \constant($config_key);
        }
        // Only chance left is to look for a static member of $lazy_statics
        // It not found, it's an error
        if (!\array_key_exists($config_key, static::$lazy_statics)) {
            throw new Exception(\sprintf('You requested an unknown config_key "%s"', $config_key));
        }
        // If found, and not set, use the default value
        if (!\array_key_exists($config_key, static::$active_lazy_statics)) {
            static::$active_lazy_statics[$config_key] = static::$lazy_statics[$config_key];
        }
        // Finally, return said static
        return static::$active_lazy_statics[$config_key];
    }

    /**
     * Returns the item count of the variable, or zero if it's non countable.
     *
     * @param mixed $var The variable whose items we want to count
     */
    public static function safe_count($var)
    {
        if (is_countable($var)) {
            return \count($var);
        }

        return 0;
    }

    public static function setGeneralConfigs()
    {
        self::setConfig('DEFAULT_ERR_LOCALE', 'en');
        // Automatic settings of path for cache and font directory
        // if they have not been previously specified
        // Locales. ONLY KEPT FOR BACKWARDS COMPATIBILITY
        // You should use the proper locale strings directly
        // from now on.
        self::setConfig('LOCALE_EN', 'en_UK');
        self::setConfig('LOCALE_SV', 'sv_SE');

        // Determine if the error handler should be image based or purely
        // text based. Image based makes it easier since the script will
        // always return an image even in case of errors.
        self::setConfig('USE_IMAGE_ERROR_HANDLER', true);

        // Should the library examine the global php_errmsg string and convert
        // any error in it to a graphical representation. This is handy for the
        // occasions when, for example, header files cannot be found and this results
        // in the graph not being created and just a 'red-cross' image would be seen.
        // This should be turned off for a production site.
        self::setConfig('CATCH_PHPERRMSG', true);

        // Determine if the library should also setup the default PHP
        // error handler to generate a graphic error mesage. This is useful
        // during development to be able to see the error message as an image
        // instead as a 'red-cross' in a page where an image is expected.
        self::setConfig('INSTALL_PHP_ERR_HANDLER', false);

        // Should usage of deprecated functions and parameters give a fatal error?
        // (Useful to check if code is future proof.)
        self::setConfig('ERR_DEPRECATED', true);

        // Default theme class name
        self::setConfig('DEFAULT_THEME_CLASS', 'UniversalTheme');

        self::setConfig('SUPERSAMPLING', true);
        self::setConfig('SUPERSAMPLING_SCALE', 1);

        // Default font family
        self::setConfig('FF_DV_SANSSERIF', self::FF_DEFAULT);

        // The DEFAULT_GFORMAT sets the default graphic encoding format, i.e.
        // PNG, JPG or GIF depending on what is installed on the target system
        // in that order.
        self::setConfig('DEFAULT_GFORMAT', 'auto');

        // Version info
        self::setConfig('JPG_VERSION', '3.5.0b1');

        // Minimum required PHP version
        self::setConfig('MIN_PHPVERSION', '7.0.0');
    }

    public static function verifyFontConfigs()
    {
        // A huge lot of font constants
        // TTF Font families
        self::setConfig('FF_COURIER', 10);
        self::setConfig('FF_VERDANA', 11);
        self::setConfig('FF_TIMES', 12);
        self::setConfig('FF_COMIC', 14);
        self::setConfig('FF_ARIAL', 15);
        self::setConfig('FF_GEORGIA', 16);
        self::setConfig('FF_TREBUCHE', 17);

        // Gnome Vera font
        // Available from http://www.gnome.org/fonts/
        self::setConfig('FF_VERA', 18);
        self::setConfig('FF_VERAMONO', 19);
        self::setConfig('FF_VERASERIF', 20);

        // Chinese font
        self::setConfig('FF_SIMSUN', 30);
        self::setConfig('FF_CHINESE', 31);
        self::setConfig('FF_BIG5', 32);

        // Japanese font
        self::setConfig('FF_MINCHO', 40);
        self::setConfig('FF_PMINCHO', 41);
        self::setConfig('FF_GOTHIC', 42);
        self::setConfig('FF_PGOTHIC', 43);

        // Hebrew fonts
        self::setConfig('FF_DAVID', 44);
        self::setConfig('FF_MIRIAM', 45);
        self::setConfig('FF_AHRON', 46);

        // Dejavu-fonts http://sourceforge.net/projects/dejavu
        self::setConfig('FF_DV_SANSSERIF', 47);
        self::setConfig('FF_DV_SERIF', 48);
        self::setConfig('FF_DV_SANSSERIFMONO', 49);
        self::setConfig('FF_DV_SERIFCOND', 50);
        self::setConfig('FF_DV_SANSSERIFCOND', 51);

        // Extra fonts
        // Download fonts from
        // http://www.webfontlist.com
        // http://www.webpagepublicity.com/free-fonts.html
        // http://www.fontonic.com/fonts.asp?width=d&offset=120
        // http://www.fontspace.com/category/famous

        // define("FF_SPEEDO",71);  // This font is also known as Bauer (Used for development gauge fascia)
        self::setConfig('FF_DIGITAL', 72); // Digital readout font
        self::setConfig('FF_COMPUTER', 73); // The classic computer font
        self::setConfig('FF_CALCULATOR', 74); // Triad font

        self::setConfig('FF_USERFONT', 90);
        self::setConfig('FF_USERFONT1', 90);
        self::setConfig('FF_USERFONT2', 91);
        self::setConfig('FF_USERFONT3', 92);

        // Limits for fonts

        // TTF Font styles
        self::setConfig('FS_NORMAL', 9001);
        self::setConfig('FS_BOLD', 9002);
        self::setConfig('FS_ITALIC', 9003);
        self::setConfig('FS_BOLDIT', 9004);
        self::setConfig('FS_BOLDITALIC', 9004);

        //Definitions for internal font
        self::setConfig('FF_FONT0', 1);
        self::setConfig('FF_FONT1', 2);
        self::setConfig('FF_FONT2', 4);

        // Line styles
        self::setConfig('LINESTYLE_SOLID', 1);
        self::setConfig('LINESTYLE_DOTTED', 2);
        self::setConfig('LINESTYLE_DASHED', 3);
        self::setConfig('LINESTYLE_LONGDASH', 4);

        // Styles for gradient color fill
        self::setConfig('GRAD_VER', 1);
        self::setConfig('GRAD_VERT', 1);
        self::setConfig('GRAD_HOR', 2);
        self::setConfig('GRAD_MIDHOR', 3);
        self::setConfig('GRAD_MIDVER', 4);
        self::setConfig('GRAD_CENTER', 5);
        self::setConfig('GRAD_WIDE_MIDVER', 6);
        self::setConfig('GRAD_WIDE_MIDHOR', 7);
        self::setConfig('GRAD_LEFT_REFLECTION', 8);
        self::setConfig('GRAD_RIGHT_REFLECTION', 9);
        self::setConfig('GRAD_RAISED_PANEL', 10);
        self::setConfig('GRAD_DIAGONAL', 11);

        // Special file name to indicate that we only want to calc
        // the image map in the call to Graph::Stroke() used
        // internally from the GetHTMLCSIM() method.

        // HTTP GET argument that is used with image map
        // to indicate to the script to just generate the image
        // and not the full CSIM HTML page.

        // Special filename for Graph::Stroke(). If this filename is given
        // then the image will NOT be streamed to browser of file. Instead the
        // Stroke call will return the handler for the created GD image.

        // Special filename for Graph::Stroke(). If this filename is given
        // the image will be stroked to a file with a name based on the script name.

        // Tick density
        self::setConfig('TICKD_DENSE', 1);
        self::setConfig('TICKD_NORMAL', 2);
        self::setConfig('TICKD_SPARSE', 3);
        self::setConfig('TICKD_VERYSPARSE', 4);

        // Side for ticks and labels.
        self::setConfig('SIDE_LEFT', -1);
        self::setConfig('SIDE_RIGHT', 1);
        self::setConfig('SIDE_DOWN', -1);
        self::setConfig('SIDE_BOTTOM', -1);
        self::setConfig('SIDE_UP', 1);
        self::setConfig('SIDE_TOP', 1);

        // Legend type stacked vertical or horizontal
        self::setConfig('LEGEND_VERT', 0);
        self::setConfig('LEGEND_HOR', 1);

        // Mark types for plot marks
        self::setConfig('MARK_SQUARE', 1);
        self::setConfig('MARK_UTRIANGLE', 2);
        self::setConfig('MARK_DTRIANGLE', 3);
        self::setConfig('MARK_DIAMOND', 4);
        self::setConfig('MARK_CIRCLE', 5);
        self::setConfig('MARK_FILLEDCIRCLE', 6);
        self::setConfig('MARK_CROSS', 7);
        self::setConfig('MARK_STAR', 8);
        self::setConfig('MARK_X', 9);
        self::setConfig('MARK_LEFTTRIANGLE', 10);
        self::setConfig('MARK_RIGHTTRIANGLE', 11);
        self::setConfig('MARK_FLASH', 12);
        self::setConfig('MARK_IMG', 13);
        self::setConfig('MARK_FLAG1', 14);
        self::setConfig('MARK_FLAG2', 15);
        self::setConfig('MARK_FLAG3', 16);
        self::setConfig('MARK_FLAG4', 17);

        // Builtin images

        // Inline defines
        self::setConfig('INLINE_YES', 1);
        self::setConfig('INLINE_NO', 0);

        // Format for background images
        self::setConfig('BGIMG_FILLPLOT', 1);
        self::setConfig('BGIMG_FILLFRAME', 2);
        self::setConfig('BGIMG_COPY', 3);
        self::setConfig('BGIMG_CENTER', 4);
        self::setConfig('BGIMG_FREE', 5);

        // Depth of objects
        self::setConfig('DEPTH_BACK', 0);
        self::setConfig('DEPTH_FRONT', 1);

        // Direction
        self::setConfig('VERTICAL', 1);
        self::setConfig('HORIZONTAL', 0);

        // Axis styles for scientific style axis
        self::setConfig('AXSTYLE_SIMPLE', 1);
        self::setConfig('AXSTYLE_BOXIN', 2);
        self::setConfig('AXSTYLE_BOXOUT', 3);
        self::setConfig('AXSTYLE_YBOXIN', 4);
        self::setConfig('AXSTYLE_YBOXOUT', 5);

        // Style for title backgrounds
        self::setConfig('TITLEBKG_STYLE1', 1);
        self::setConfig('TITLEBKG_STYLE2', 2);
        self::setConfig('TITLEBKG_STYLE3', 3);
        self::setConfig('TITLEBKG_FRAME_NONE', 0);
        self::setConfig('TITLEBKG_FRAME_FULL', 1);
        self::setConfig('TITLEBKG_FRAME_BOTTOM', 2);
        self::setConfig('TITLEBKG_FRAME_BEVEL', 3);
        self::setConfig('TITLEBKG_FILLSTYLE_HSTRIPED', 1);
        self::setConfig('TITLEBKG_FILLSTYLE_VSTRIPED', 2);
        self::setConfig('TITLEBKG_FILLSTYLE_SOLID', 3);

        // Styles for axis labels background
        self::setConfig('LABELBKG_NONE', 0);
        self::setConfig('LABELBKG_XAXIS', 1);
        self::setConfig('LABELBKG_YAXIS', 2);
        self::setConfig('LABELBKG_XAXISFULL', 3);
        self::setConfig('LABELBKG_YAXISFULL', 4);
        self::setConfig('LABELBKG_XYFULL', 5);
        self::setConfig('LABELBKG_XY', 6);

        // Style for background gradient fills
        self::setConfig('BGRAD_FRAME', 1);
        self::setConfig('BGRAD_MARGIN', 2);
        self::setConfig('BGRAD_PLOT', 3);

        // Width of tab titles
        self::setConfig('TABTITLE_WIDTHFIT', 0);
        self::setConfig('TABTITLE_WIDTHFULL', -1);

        // Defines for 3D skew directions
        self::setConfig('SKEW3D_UP', 0);
        self::setConfig('SKEW3D_DOWN', 1);
        self::setConfig('SKEW3D_LEFT', 2);
        self::setConfig('SKEW3D_RIGHT', 3);

        // For internal use only
    }

    public static function verifyCacheSettings()
    {
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
            self::setConfig('CACHE_DIR', \getenv('JPGRAPH_CACHE_DIR'));
        }

        if (\getenv('JPGRAPH_TTF_DIR')) {
            self::setConfig('TTF_DIR', \getenv('JPGRAPH_TTF_DIR'));
        }

        if (\getenv('JPGRAPH_MBTTF_DIR')) {
            self::setConfig('MBTTF_DIR', \getenv('JPGRAPH_MBTTF_DIR'));
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
        //self::setConfig('CSIMCACHE_DIR', 'csimcache/');
        //self::setConfig('CSIMCACHE_HTTP_DIR', 'csimcache/');

        if (self::getConfig('USE_CACHE')) {
            if (!\defined('CACHE_DIR')) {
                if (\mb_strstr(\PHP_OS, 'WIN')) {
                    if (empty($_SERVER['TEMP'])) {
                        $t = new ErrMsgText();
                        $msg = $t->Get(11, $file, $lineno);

                        exit($msg);
                    }
                    self::setConfig('CACHE_DIR', $_SERVER['TEMP'] . '/');
                } else {
                    self::setConfig('CACHE_DIR', '/tmp/jpgraph_cache/');
                }
            }
        } else {
            self::setConfig('CACHE_DIR', '');
        }
    }

    public static function verifyTTFSettings()
    {
        //self::setConfig('CSIMCACHE_DIR','csimcache/');
        //self::setConfig('CSIMCACHE_HTTP_DIR','csimcache/');
        /*
         * Setup path for TTF fonts
         */
        if (\defined('TTF_DIR')) {
            return;
        }

        if (\mb_strstr(\PHP_OS, 'WIN')) {
            if (!\defined('SYSTEMROOT')) {
                $t = new ErrMsgText();
                $msg = $t->Get(12, $file, $lineno);

                exit($msg);
            }
            self::setConfig('TTF_DIR', SYSTEMROOT . '/fonts/');
        } else {
            self::setConfig('TTF_DIR', '/usr/share/fonts/truetype/');
        }
    }

    public static function verifyMBTTFSettings()
    {
        /*
         * Setup path for MultiByte TTF fonts (japanese, chinese etc.)
         */
        if (\defined('MBTTF_DIR')) {
            return;
        }

        if (\mb_strstr(\PHP_OS, 'WIN')) {
            if (!\defined('SYSTEMROOT')) {
                $t = new ErrMsgText();
                $msg = $t->Get(12, $file, $lineno);

                exit($msg);
            }
            self::setConfig('MBTTF_DIR', SYSTEMROOT . '/fonts/');
        } else {
            self::setConfig('MBTTF_DIR', '/usr/share/fonts/truetype/');
        }
    }

    /**
     * Traverse format related constants.
     * self::heck(et them to defaults otherwise.
     */
    public static function verifyFormatSettings()
    {
        // Deafult graphic format set to 'auto' which will automatically
        // choose the best available format in the order png,gif,jpeg
        // (The supported format depends on what your PHP installation supports)
        self::setConfig('DEFAULT_GFORMAT', 'auto');
        // The builtin GD function imagettfbbox() fuction which calculates the bounding box for
        // text using TTF fonts is buggy. By setting this define to true the library
        // uses its own compensation for this bug. However this will give a
        // slightly different visual apparance than not using this compensation.
        // Enabling this compensation will in general give text a bit more space to more
        // truly reflect the actual bounding box which is a bit larger than what the
        // GD function thinks.
        self::setConfig('USE_LIBRARY_IMAGETTFBBOX', true);

        // Maximum size for Automatic Gantt chart
        self::setConfig('MAX_GANTTIMG_SIZE_W', 8000);
        self::setConfig('MAX_GANTTIMG_SIZE_H', 5000);
    }

    /**
     * If they're trying to set the value, only allow it
     * if it isn't previously set.
     *
     * @param string $config_key   The config_key name
     * @param mixed  $config_value The config_value value
     *
     * @return <type> ( description_of_the_return_value )
     */
    protected static function setConfig(string $config_key, $config_value)
    {
        // Environment variable takes precedence
        if (\getenv(\sprintf('JPGRAPH_%s', $config_key))) {
            return \getenv(\sprintf('JPGRAPH_%s', $config_key));
        }
        // Local or inherited class constants come next
        if (\defined(\sprintf('static::%s', $config_key))) {
            return \constant(\sprintf('static::%s', $config_key));
        }
        // Global constants in third place
        if (\defined($config_key)) {
            return \constant($config_key);
        }
        //   look for a static member of $lazy_statics
        // It not found, it's an error
        if (!\array_key_exists($config_key, static::$lazy_statics)) {
            throw new Exception(\sprintf('You tried to set an unknown config_key "%s"', $config_key));
        }

        static::$active_lazy_statics[$config_key] = \is_scalar($config_value) ? $config_value : self::$lazy_statics[$config_key];

        return static::$active_lazy_statics[$config_key];
    }
}

Configs::setGeneralConfigs();
