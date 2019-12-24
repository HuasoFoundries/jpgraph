<?php

/**
 * JPGraph v4.0.0
 */

namespace Amenadiel\JpGraph\Util;

require_once __DIR__ . '/../config.inc.php';

/**
 * NOTE THAT CACHE FUNCTIONALITY IS TURNED OFF BY  DEFAULT ENABLE BY SETTING USE_CACHE TO TRUE)
 * Should the cache be used at all? By setting this to false no
 * files will be generated in the cache directory.
 * The difference from READ_CACHE being that setting READ_CACHE to
 * false will still create the image in the cache directory
 * just not use it. By setting USE_CACHE=false no files will even
 * be generated in the cache directory.
 */
defined('USE_CACHE') || define('USE_CACHE', getenv('JPGRAPH_USE_CACHE') || false);

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
if (strstr(PHP_OS, 'WIN') && getenv('SystemRoot')) {
    define('SYSTEMROOT', getenv('SystemRoot'));
}

// Define these constants explicitly
// define('CACHE_DIR','/tmp/jpgraph_cache/');
// define('TTF_DIR','/usr/share/fonts/TrueType/');
// define('MBTTF_DIR','/usr/share/fonts/TrueType/');
//
// Or read them from environment variables
if (getenv('JPGRAPH_CACHE_DIR')) {
    define('CACHE_DIR', getenv('JPGRAPH_CACHE_DIR'));
}
if (getenv('JPGRAPH_TTF_DIR')) {
    define('TTF_DIR', getenv('JPGRAPH_TTF_DIR'));
}
if (getenv('JPGRAPH_MBTTF_DIR')) {
    define('MBTTF_DIR', getenv('JPGRAPH_MBTTF_DIR'));
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
define('CSIMCACHE_DIR', 'csimcache/');
define('CSIMCACHE_HTTP_DIR', 'csimcache/');

// Should we try to find an image in the cache before generating it?
// Set this define to false to bypass the reading of the cache and always
// regenerate the image. Note that even if reading the cache is
// disabled the cached will still be updated with the newly generated
// image. Set also 'USE_CACHE' below.
defined('READ_CACHE') || define('READ_CACHE', true);

/*
 * The following constants should rarely have to be changed !
 */
// What group should the cached file belong to
// (Set to '' will give the default group for the 'PHP-user')
// Please note that the Apache user must be a member of the
// specified group since otherwise it is impossible for Apache
// to set the specified group.
defined('CACHE_FILE_GROUP') || define('CACHE_FILE_GROUP', getenv('JPGRAPH_CACHE_FILE_GROUP') || 'www');

// What permissions should the cached file have
// (Set to '' will give the default persmissions for the 'PHP-user')
defined('CACHE_FILE_MOD') || define('CACHE_FILE_MOD', getenv('JPGRAPH_CACHE_FILE_MOD') || 0664);

/**
 * @class Constants
 *
 * Basic constants getter and setter.
 * self::f(he user beforehand,
 * self::t(efaults defined here.
 */
class Constants
{
    const FF_DEFAULT = 47;
    // Constants for types of static bands in plot area
    const BAND_RDIAG     = 1; // Right diagonal lines
    const BAND_LDIAG     = 2; // Left diagonal lines
    const BAND_SOLID     = 3; // Solid one color
    const BAND_VLINE     = 4; // Vertical lines
    const BAND_HLINE     = 5; // Horizontal lines
    const BAND_3DPLANE   = 6; // "3D" Plane
    const BAND_HVCROSS   = 7; // Vertical/Hor crosses
    const BAND_DIAGCROSS = 8; // Diagonal crosses

    // Bar patterns
    const GANTT_RDIAG     = self::BAND_RDIAG; // Right diagonal lines
    const GANTT_LDIAG     = self::BAND_LDIAG; // Left diagonal lines
    const GANTT_SOLID     = self::BAND_SOLID; // Solid one color
    const GANTT_VLINE     = self::BAND_VLINE; // Vertical lines
    const GANTT_HLINE     = self::BAND_HLINE; // Horizontal lines
    const GANTT_3DPLANE   = self::BAND_3DPLANE; // "3D" Plane
    const GANTT_HVCROSS   = self::BAND_HVCROSS; // Vertical/Hor crosses
    const GANTT_DIAGCROSS = self::BAND_DIAGCROSS; // Diagonal crosses
    // Scale Header types
    const GANTT_HDAY   = 1;
    const GANTT_HWEEK  = 2;
    const GANTT_HMONTH = 4;
    const GANTT_HYEAR  = 8;
    const GANTT_HHOUR  = 16;
    const GANTT_HMIN   = 32;

    // Conversion constant
    const HOURADJ_1  = 0 + 30;
    const HOURADJ_2  = 1 + 30;
    const HOURADJ_3  = 2 + 30;
    const HOURADJ_4  = 3 + 30;
    const HOURADJ_6  = 4 + 30;
    const HOURADJ_12 = 5 + 30;

    const MINADJ_1  = 0 + 20;
    const MINADJ_5  = 1 + 20;
    const MINADJ_10 = 2 + 20;
    const MINADJ_15 = 3 + 20;
    const MINADJ_30 = 4 + 20;

    const SECADJ_1  = 0;
    const SECADJ_5  = 1;
    const SECADJ_10 = 2;
    const SECADJ_15 = 3;
    const SECADJ_30 = 4;

    const YEARADJ_1 = 0 + 30;
    const YEARADJ_2 = 1 + 30;
    const YEARADJ_5 = 2 + 30;

    const MONTHADJ_1 = 0 + 20;
    const MONTHADJ_6 = 1 + 20;

    const DAYADJ_1    = 0;
    const DAYADJ_WEEK = 1;
    const DAYADJ_7    = 1;

    const SECPERYEAR = 31536000;
    const SECPERDAY  = 86400;
    const SECPERHOUR = 3600;
    const SECPERMIN  = 60;

    // Layout of bars
    const GANTT_EVEN    = 1;
    const GANTT_FROMTOP = 2;

    // Style for minute header
    const MINUTESTYLE_MM     = 0; // 15
    const MINUTESTYLE_CUSTOM = 2; // Custom format

    // Style for hour header
    const HOURSTYLE_HM24   = 0; // 13:10
    const HOURSTYLE_HMAMPM = 1; // 1:10pm
    const HOURSTYLE_H24    = 2; // 13
    const HOURSTYLE_HAMPM  = 3; // 1pm
    const HOURSTYLE_CUSTOM = 4; // User defined

    // Style for day header
    const DAYSTYLE_ONELETTER     = 0; // "M"
    const DAYSTYLE_LONG          = 1; // "Monday"
    const DAYSTYLE_LONGDAYDATE1  = 2; // "Monday 23 Jun"
    const DAYSTYLE_LONGDAYDATE2  = 3; // "Monday 23 Jun 2003"
    const DAYSTYLE_SHORT         = 4; // "Mon"
    const DAYSTYLE_SHORTDAYDATE1 = 5; // "Mon 23/6"
    const DAYSTYLE_SHORTDAYDATE2 = 6; // "Mon 23 Jun"
    const DAYSTYLE_SHORTDAYDATE3 = 7; // "Mon 23"
    const DAYSTYLE_SHORTDATE1    = 8; // "23/6"
    const DAYSTYLE_SHORTDATE2    = 9; // "23 Jun"
    const DAYSTYLE_SHORTDATE3    = 10; // "Mon 23"
    const DAYSTYLE_SHORTDATE4    = 11; // "23"
    const DAYSTYLE_CUSTOM        = 12; // "M"

    // Styles for week header
    const WEEKSTYLE_WNBR          = 0;
    const WEEKSTYLE_FIRSTDAY      = 1;
    const WEEKSTYLE_FIRSTDAY2     = 2;
    const WEEKSTYLE_FIRSTDAYWNBR  = 3;
    const WEEKSTYLE_FIRSTDAY2WNBR = 4;

    // Styles for month header
    const MONTHSTYLE_SHORTNAME      = 0;
    const MONTHSTYLE_LONGNAME       = 1;
    const MONTHSTYLE_LONGNAMEYEAR2  = 2;
    const MONTHSTYLE_SHORTNAMEYEAR2 = 3;
    const MONTHSTYLE_LONGNAMEYEAR4  = 4;
    const MONTHSTYLE_SHORTNAMEYEAR4 = 5;
    const MONTHSTYLE_FIRSTLETTER    = 6;

    // Types of constrain links
    const CONSTRAIN_STARTSTART = 0;
    const CONSTRAIN_STARTEND   = 1;
    const CONSTRAIN_ENDSTART   = 2;
    const CONSTRAIN_ENDEND     = 3;

    // Arrow direction for constrain links
    const ARROW_DOWN  = 0;
    const ARROW_UP    = 1;
    const ARROW_LEFT  = 2;
    const ARROW_RIGHT = 3;

    // Arrow type for constrain type
    const ARROWT_SOLID = 0;
    const ARROWT_OPEN  = 1;

    // Arrow size for constrain lines
    const ARROW_S1 = 0;
    const ARROW_S2 = 1;
    const ARROW_S3 = 2;
    const ARROW_S4 = 3;
    const ARROW_S5 = 4;

    // Activity types for use with utility method CreateSimple()
    const ACTYPE_NORMAL    = 0;
    const ACTYPE_GROUP     = 1;
    const ACTYPE_MILESTONE = 2;

    const ACTINFO_3D = 1;
    const ACTINFO_2D = 0;

    const GICON_WARNINGRED              = 0;
    const GICON_TEXT                    = 1;
    const GICON_ENDCONS                 = 2;
    const GICON_MAIL                    = 3;
    const GICON_STARTCONS               = 4;
    const GICON_CALC                    = 5;
    const GICON_MAGNIFIER               = 6;
    const GICON_LOCK                    = 7;
    const GICON_STOP                    = 8;
    const GICON_WARNINGYELLOW           = 9;
    const GICON_FOLDEROPEN              = 10;
    const GICON_FOLDER                  = 11;
    const GICON_TEXTIMPORTANT           = 12;
    private static $active_lazy_statics = [];
    private static $lazy_statics        = [
        'LOCALE_EN'                   => 'en_UK',
        'LOCALE_SV'                   => 'sv_SE',
        'MBTTF_DIR'                   => '/usr/share/fonts/truetype/',
        'TTF_DIR'                     => '/usr/share/fonts/truetype/',
        'CACHE_DIR'                   => '/tmp/jpgraph_cache/',
        'DEFAULT_GFORMAT'             => 'auto',
        'USE_LIBRARY_IMAGETTFBBOX'    => true,
        'MAX_GANTTIMG_SIZE_W'         => 8000,
        'MAX_GANTTIMG_SIZE_H'         => 5000,
        'GANTT_HDAY'                  => 1,
        'GANTT_HWEEK'                 => 2,
        'GANTT_HMONTH'                => 4,
        'GANTT_HYEAR'                 => 8,
        'GANTT_HHOUR'                 => 16,
        'GANTT_HMIN'                  => 32,
        'HOURADJ_1'                   => 0 + 30,
        'HOURADJ_2'                   => 1 + 30,
        'HOURADJ_3'                   => 2 + 30,
        'HOURADJ_4'                   => 3 + 30,
        'HOURADJ_6'                   => 4 + 30,
        'HOURADJ_12'                  => 5 + 30,
        'MINADJ_1'                    => 0 + 20,
        'MINADJ_5'                    => 1 + 20,
        'MINADJ_10'                   => 2 + 20,
        'MINADJ_15'                   => 3 + 20,
        'MINADJ_30'                   => 4 + 20,
        'SECADJ_1'                    => 0,
        'SECADJ_5'                    => 1,
        'SECADJ_10'                   => 2,
        'SECADJ_15'                   => 3,
        'SECADJ_30'                   => 4,
        'YEARADJ_1'                   => 0 + 30,
        'YEARADJ_2'                   => 1 + 30,
        'YEARADJ_5'                   => 2 + 30,
        'MONTHADJ_1'                  => 0 + 20,
        'MONTHADJ_6'                  => 1 + 20,
        'DAYADJ_1'                    => 0,
        'DAYADJ_WEEK'                 => 1,
        'DAYADJ_7'                    => 1,
        'SECPERYEAR'                  => 31536000,
        'SECPERDAY'                   => 86400,
        'SECPERHOUR'                  => 3600,
        'SECPERMIN'                   => 60,
        'GANTT_EVEN'                  => 1,
        'GANTT_FROMTOP'               => 2,
        'MINUTESTYLE_MM'              => 0,
        'MINUTESTYLE_CUSTOM'          => 2,
        'HOURSTYLE_HM24'              => 0,
        'HOURSTYLE_HMAMPM'            => 1,
        'HOURSTYLE_H24'               => 2,
        'HOURSTYLE_HAMPM'             => 3,
        'HOURSTYLE_CUSTOM'            => 4,
        'DAYSTYLE_ONELETTER'          => 0,
        'DAYSTYLE_LONG'               => 1,
        'DAYSTYLE_LONGDAYDATE1'       => 2,
        'DAYSTYLE_LONGDAYDATE2'       => 3,
        'DAYSTYLE_SHORT'              => 4,
        'DAYSTYLE_SHORTDAYDATE1'      => 5,
        'DAYSTYLE_SHORTDAYDATE2'      => 6,
        'DAYSTYLE_SHORTDAYDATE3'      => 7,
        'DAYSTYLE_SHORTDATE1'         => 8,
        'DAYSTYLE_SHORTDATE2'         => 9,
        'DAYSTYLE_SHORTDATE3'         => 10,
        'DAYSTYLE_SHORTDATE4'         => 11,
        'DAYSTYLE_CUSTOM'             => 12,
        'WEEKSTYLE_WNBR'              => 0,
        'WEEKSTYLE_FIRSTDAY'          => 1,
        'WEEKSTYLE_FIRSTDAY2'         => 2,
        'WEEKSTYLE_FIRSTDAYWNBR'      => 3,
        'WEEKSTYLE_FIRSTDAY2WNBR'     => 4,
        'MONTHSTYLE_SHORTNAME'        => 0,
        'MONTHSTYLE_LONGNAME'         => 1,
        'MONTHSTYLE_LONGNAMEYEAR2'    => 2,
        'MONTHSTYLE_SHORTNAMEYEAR2'   => 3,
        'MONTHSTYLE_LONGNAMEYEAR4'    => 4,
        'MONTHSTYLE_SHORTNAMEYEAR4'   => 5,
        'MONTHSTYLE_FIRSTLETTER'      => 6,
        'CONSTRAIN_STARTSTART'        => 0,
        'CONSTRAIN_STARTEND'          => 1,
        'CONSTRAIN_ENDSTART'          => 2,
        'CONSTRAIN_ENDEND'            => 3,
        'ARROW_DOWN'                  => 0,
        'ARROW_UP'                    => 1,
        'ARROW_LEFT'                  => 2,
        'ARROW_RIGHT'                 => 3,
        'ARROWT_SOLID'                => 0,
        'ARROWT_OPEN'                 => 1,
        'ARROW_S1'                    => 0,
        'ARROW_S2'                    => 1,
        'ARROW_S3'                    => 2,
        'ARROW_S4'                    => 3,
        'ARROW_S5'                    => 4,
        'ACTYPE_NORMAL'               => 0,
        'ACTYPE_GROUP'                => 1,
        'ACTYPE_MILESTONE'            => 2,
        'ACTINFO_3D'                  => 1,
        'ACTINFO_2D'                  => 0,
        'GICON_WARNINGRED'            => 0,
        'GICON_TEXT'                  => 1,
        'GICON_ENDCONS'               => 2,
        'GICON_MAIL'                  => 3,
        'GICON_STARTCONS'             => 4,
        'GICON_CALC'                  => 5,
        'GICON_MAGNIFIER'             => 6,
        'GICON_LOCK'                  => 7,
        'GICON_STOP'                  => 8,
        'GICON_WARNINGYELLOW'         => 9,
        'GICON_FOLDEROPEN'            => 10,
        'GICON_FOLDER'                => 11,
        'GICON_TEXTIMPORTANT'         => 12,
        'FF_COURIER'                  => 10,
        'FF_VERDANA'                  => 11,
        'FF_TIMES'                    => 12,
        'FF_COMIC'                    => 14,
        'FF_ARIAL'                    => 15,
        'FF_GEORGIA'                  => 16,
        'FF_TREBUCHE'                 => 17,
        'FF_VERA'                     => 18,
        'FF_VERAMONO'                 => 19,
        'FF_VERASERIF'                => 20,
        'FF_SIMSUN'                   => 30,
        'FF_CHINESE'                  => 31,
        'FF_BIG5'                     => 32,
        'FF_MINCHO'                   => 40,
        'FF_PMINCHO'                  => 41,
        'FF_GOTHIC'                   => 42,
        'FF_PGOTHIC'                  => 43,
        'FF_DAVID'                    => 44,
        'FF_MIRIAM'                   => 45,
        'FF_AHRON'                    => 46,
        'FF_DV_SANSSERIF'             => self::FF_DEFAULT,
        'FF_DV_SERIF'                 => 48,
        'FF_DV_SANSSERIFMONO'         => 49,
        'FF_DV_SERIFCOND'             => 50,
        'FF_DV_SANSSERIFCOND'         => 51,

        'FF_DIGITAL'                  => 72,
        'FF_COMPUTER'                 => 73,
        'FF_CALCULATOR'               => 74,
        'FF_USERFONT'                 => 90,
        'FF_USERFONT1'                => 90,
        'FF_USERFONT2'                => 91,
        'FF_USERFONT3'                => 92,
        'FS_NORMAL'                   => 9001,
        'FS_BOLD'                     => 9002,
        'FS_ITALIC'                   => 9003,
        'FS_BOLDIT'                   => 9004,
        'FS_BOLDITALIC'               => 9004,
        'FF_FONT0'                    => 1,
        'FF_FONT1'                    => 2,
        'FF_FONT2'                    => 4,
        'CHINESE_TTF_FONT'            => 'bkai00mp.ttf',
        'LANGUAGE_GREEK'              => false,
        'GREEK_FROM_WINDOWS'          => false,
        'LANGUAGE_CYRILLIC'           => false,
        'CYRILLIC_FROM_WINDOWS'       => false,
        'LANGUAGE_CHARSET'            => null,
        'MINCHO_TTF_FONT'             => 'ipam.ttf',
        'PMINCHO_TTF_FONT'            => 'ipamp.ttf',
        'GOTHIC_TTF_FONT'             => 'ipag.ttf',
        'PGOTHIC_TTF_FONT'            => 'ipagp.ttf',
        'ASSUME_EUCJP_ENCODING'       => false,
        'LINESTYLE_SOLID'             => 1,
        'LINESTYLE_DOTTED'            => 2,
        'LINESTYLE_DASHED'            => 3,
        'LINESTYLE_LONGDASH'          => 4,
        'GRAD_VER'                    => 1,
        'GRAD_VERT'                   => 1,
        'GRAD_HOR'                    => 2,
        'GRAD_MIDHOR'                 => 3,
        'GRAD_MIDVER'                 => 4,
        'GRAD_CENTER'                 => 5,
        'GRAD_WIDE_MIDVER'            => 6,
        'GRAD_WIDE_MIDHOR'            => 7,
        'GRAD_LEFT_REFLECTION'        => 8,
        'GRAD_RIGHT_REFLECTION'       => 9,
        'GRAD_RAISED_PANEL'           => 10,
        'GRAD_DIAGONAL'               => 11,
        'TICKD_DENSE'                 => 1,
        'TICKD_NORMAL'                => 2,
        'TICKD_SPARSE'                => 3,
        'TICKD_VERYSPARSE'            => 4,
        'SIDE_LEFT'                   => -1,
        'SIDE_RIGHT'                  => 1,
        'SIDE_DOWN'                   => -1,
        'SIDE_BOTTOM'                 => -1,
        'SIDE_UP'                     => 1,
        'SIDE_TOP'                    => 1,
        'LEGEND_VERT'                 => 0,
        'LEGEND_HOR'                  => 1,
        'MARK_SQUARE'                 => 1,
        'MARK_UTRIANGLE'              => 2,
        'MARK_DTRIANGLE'              => 3,
        'MARK_DIAMOND'                => 4,
        'MARK_CIRCLE'                 => 5,
        'MARK_FILLEDCIRCLE'           => 6,
        'MARK_CROSS'                  => 7,
        'MARK_STAR'                   => 8,
        'MARK_X'                      => 9,
        'MARK_LEFTTRIANGLE'           => 10,
        'MARK_RIGHTTRIANGLE'          => 11,
        'MARK_FLASH'                  => 12,
        'MARK_IMG'                    => 13,
        'MARK_FLAG1'                  => 14,
        'MARK_FLAG2'                  => 15,
        'MARK_FLAG3'                  => 16,
        'MARK_FLAG4'                  => 17,
        'MARK_IMG_PUSHPIN'            => 50,
        'MARK_IMG_SPUSHPIN'           => 50,
        'MARK_IMG_LPUSHPIN'           => 51,
        'MARK_IMG_DIAMOND'            => 52,
        'MARK_IMG_SQUARE'             => 53,
        'MARK_IMG_STAR'               => 54,
        'MARK_IMG_BALL'               => 55,
        'MARK_IMG_SBALL'              => 55,
        'MARK_IMG_MBALL'              => 56,
        'MARK_IMG_LBALL'              => 57,
        'MARK_IMG_BEVEL'              => 58,
        'INLINE_YES'                  => 1,
        'INLINE_NO'                   => 0,
        'BGIMG_FILLPLOT'              => 1,
        'BGIMG_FILLFRAME'             => 2,
        'BGIMG_COPY'                  => 3,
        'BGIMG_CENTER'                => 4,
        'BGIMG_FREE'                  => 5,
        'DEPTH_BACK'                  => 0,
        'DEPTH_FRONT'                 => 1,
        'VERTICAL'                    => 1,
        'HORIZONTAL'                  => 0,
        'AXSTYLE_SIMPLE'              => 1,
        'AXSTYLE_BOXIN'               => 2,
        'AXSTYLE_BOXOUT'              => 3,
        'AXSTYLE_YBOXIN'              => 4,
        'AXSTYLE_YBOXOUT'             => 5,
        'TITLEBKG_STYLE1'             => 1,
        'TITLEBKG_STYLE2'             => 2,
        'TITLEBKG_STYLE3'             => 3,
        'TITLEBKG_FRAME_NONE'         => 0,
        'TITLEBKG_FRAME_FULL'         => 1,
        'TITLEBKG_FRAME_BOTTOM'       => 2,
        'TITLEBKG_FRAME_BEVEL'        => 3,
        'TITLEBKG_FILLSTYLE_HSTRIPED' => 1,
        'TITLEBKG_FILLSTYLE_VSTRIPED' => 2,
        'TITLEBKG_FILLSTYLE_SOLID'    => 3,
        'LABELBKG_NONE'               => 0,
        'LABELBKG_XAXIS'              => 1,
        'LABELBKG_YAXIS'              => 2,
        'LABELBKG_XAXISFULL'          => 3,
        'LABELBKG_YAXISFULL'          => 4,
        'LABELBKG_XYFULL'             => 5,
        'LABELBKG_XY'                 => 6,
        'BGRAD_FRAME'                 => 1,
        'BGRAD_MARGIN'                => 2,
        'BGRAD_PLOT'                  => 3,
        'TABTITLE_WIDTHFIT'           => 0,
        'TABTITLE_WIDTHFULL'          => -1,
        'SKEW3D_UP'                   => 0,
        'SKEW3D_DOWN'                 => 1,
        'SKEW3D_LEFT'                 => 2,
        'SKEW3D_RIGHT'                => 3,
        'CATCH_PHPERRMSG'             => true,
        'INSTALL_PHP_ERR_HANDLER'     => true,
        'ERR_DEPRECATED'              => true,
        'DEFAULT_THEME_CLASS'         => 'UniversalTheme',
        'SUPERSAMPLING'               => true,
        'SUPERSAMPLING_SCALE'         => 1,

        'DEFAULT_GFORMAT'             => 'auto',
        '_DEFAULT_LPM_SIZE'           => 8, // Default Legend Plot Mark size,
        '_JPG_DEBUG'                  => false,
        '_FORCE_IMGTOFILE'            => false,
        '_FORCE_IMGDIR'               => '/tmp/jpgimg/',
        'JPG_VERSION'                 => '3.5.0b1',
        'MIN_PHPVERSION'              => '7.0.0',
        '_CSIM_SPECIALFILE'           => '_csim_special_',
        '_CSIM_DISPLAY'               => '_jpg_csimd',
        '_IMG_HANDLER'                => '__handle',
        '_IMG_AUTO'                   => 'auto',
    ];

    /**
     * @see https://www.php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.methods
     * This workaround allows to access JPGraph constants
     * as if they were static properties of this class in the form
     *
     * ```
     *  $ttf_folder = \Constants::TTF_FOLDER
     * ```
     *
     * Same goes for setting the default value;
     *
     * ```
     * \Constants::TTF_FOLDER('/var/www')
     * ```
     *
     * It will only handle constant names from an internal whitelist,
     * and accept setters only for scalars.
     *
     * and wreak havoc otherwise. { (╯°□°)╯︵ ┻━┻   }
     *
     * @param string  $const_name  The constant's name
     * @param scalar $value    The value to set, if passed and admissible.
     */
    public static function __callStatic(string $const_name, array $args)
    {
        if (defined(sprintf('self::%s', $const_name))) {
            return constant(sprintf('self::%s', $const_name));
        }
        if (defined($const_name)) {
            return constant($const_name);
        }

        /**
         * Not a constant/static that we know of
         */
        if (
            !array_key_exists($const_name, self::$lazy_statics)
        ) {
            throw new \Exception(sprintf('Unknown constant %s', $const_name));
        }
        /**
         * It's a static that we know of, we'll check if the calling class is trying
         * to set or get its value
         */
        if (array_key_exists($const_name, self::$lazy_statics)) {
            return $args && is_scalar($args) ? self::setConstant($const_name, $args) : self::getConstant($const_name);
        }
    }

    /**
     * If they're trying to set the value, only allow it
     * if it isn't previously set
     *
     * @param string  $const_name   The constant name
     * @param scalar  $const_value  The constant value
     *
     * @return <type>  ( description_of_the_return_value )
     */
    protected static function setConstant(string $const_name, scalar $const_value)
    {
        if (!array_key_exists($const_name, $active_lazy_statics)) {
            static::$active_lazy_statics[$const_name] = $const_value;
        }
        return static::$active_lazy_statics[$const_name];
    }

    /**
     * If trying to get the constant value, return the current one
     * or set it as the default declared in $lazy_statics
     *
     * @param string  $const_name  The constant name
     *
     * @throws Exception  (description)
     *
     * @return array  The constant.
     */
    protected static function getConstant(string $const_name)
    {
        if (!array_key_exists($const_name, static::$active_lazy_statics)) {
            static::$active_lazy_statics[$const_name] = static::$lazy_statics[$const_name];
        }
        return static::$active_lazy_statics[$const_name];
    }

    public static function setGeneralConstants()
    {
        self::DEFAULT_ERR_LOCALE('en');
        // Automatic settings of path for cache and font directory
        // if they have not been previously specified
        //

        // Locales. ONLY KEPT FOR BACKWARDS COMPATIBILITY
        // You should use the proper locale strings directly
        // from now on.
        self::LOCALE_EN('en_UK');
        self::LOCALE_SV('sv_SE');

        // Determine if the error handler should be image based or purely
        // text based. Image based makes it easier since the script will
        // always return an image even in case of errors.
        self::USE_IMAGE_ERROR_HANDLER(true);

        // Should the library examine the global php_errmsg string and convert
        // any error in it to a graphical representation. This is handy for the
        // occasions when, for example, header files cannot be found and this results
        // in the graph not being created and just a 'red-cross' image would be seen.
        // This should be turned off for a production site.
        self::CATCH_PHPERRMSG(true);

        // Determine if the library should also setup the default PHP
        // error handler to generate a graphic error mesage. This is useful
        // during development to be able to see the error message as an image
        // instead as a 'red-cross' in a page where an image is expected.
        self::INSTALL_PHP_ERR_HANDLER(false);

        // Should usage of deprecated functions and parameters give a fatal error?
        // (Useful to check if code is future proof.)
        self::ERR_DEPRECATED(true);

        // Default theme class name
        self::DEFAULT_THEME_CLASS('UniversalTheme');

        self::SUPERSAMPLING(true);
        self::SUPERSAMPLING_SCALE(1);

        // Default font family
        self::FF_DV_SANSSERIF(self::FF_DEFAULT);

        // The DEFAULT_GFORMAT sets the default graphic encoding format, i.e.
        // PNG, JPG or GIF depending on what is installed on the target system
        // in that order.
        self::DEFAULT_GFORMAT('auto');

        self::_DEFAULT_LPM_SIZE(8); // Default Legend Plot Mark size
        // For internal use only
        self::_JPG_DEBUG(false);
        self::_FORCE_IMGTOFILE(false);
        self::_FORCE_IMGDIR('/tmp/jpgimg/');

        // Version info
        self::JPG_VERSION('3.5.0b1');

        // Minimum required PHP version
        self::MIN_PHPVERSION('7.0.0');

        // Special file name to indicate that we only want to calc
        // the image map in the call to Graph::Stroke() used
        // internally from the GetHTMLCSIM() method.
        self::_CSIM_SPECIALFILE('_csim_special_');

        // HTTP GET argument that is used with image map
        // to indicate to the script to just generate the image
        // and not the full CSIM HTML page.
        self::_CSIM_DISPLAY('_jpg_csimd');

        // Special filename for Graph::Stroke(). If this filename is given
        // then the image will NOT be streamed to browser of file. Instead the
        // Stroke call will return the handler for the created GD image.
        self::_IMG_HANDLER('__handle');

        // Special filename for Graph::Stroke(). If this filename is given
        // the image will be stroked to a file with a name based on the script name.
        self::_IMG_AUTO('auto');
    }

    public static function verifyFontConstants()
    {

        // A huge lot of font constants
        // TTF Font families
        self::FF_COURIER(10);
        self::FF_VERDANA(11);
        self::FF_TIMES(12);
        self::FF_COMIC(14);
        self::FF_ARIAL(15);
        self::FF_GEORGIA(16);
        self::FF_TREBUCHE(17);

        // Gnome Vera font
        // Available from http://www.gnome.org/fonts/
        self::FF_VERA(18);
        self::FF_VERAMONO(19);
        self::FF_VERASERIF(20);

        // Chinese font
        self::FF_SIMSUN(30);
        self::FF_CHINESE(31);
        self::FF_BIG5(32);

        // Japanese font
        self::FF_MINCHO(40);
        self::FF_PMINCHO(41);
        self::FF_GOTHIC(42);
        self::FF_PGOTHIC(43);

        // Hebrew fonts
        self::FF_DAVID(44);
        self::FF_MIRIAM(45);
        self::FF_AHRON(46);

        // Dejavu-fonts http://sourceforge.net/projects/dejavu
        self::FF_DV_SANSSERIF(47);
        self::FF_DV_SERIF(48);
        self::FF_DV_SANSSERIFMONO(49);
        self::FF_DV_SERIFCOND(50);
        self::FF_DV_SANSSERIFCOND(51);

        // Extra fonts
        // Download fonts from
        // http://www.webfontlist.com
        // http://www.webpagepublicity.com/free-fonts.html
        // http://www.fontonic.com/fonts.asp?width=d&offset=120
        // http://www.fontspace.com/category/famous

        // define("FF_SPEEDO",71);  // This font is also known as Bauer (Used for development gauge fascia)
        self::FF_DIGITAL(72); // Digital readout font
        self::FF_COMPUTER(73); // The classic computer font
        self::FF_CALCULATOR(74); // Triad font

        self::FF_USERFONT(90);
        self::FF_USERFONT1(90);
        self::FF_USERFONT2(91);
        self::FF_USERFONT3(92);

        // Limits for fonts

        // TTF Font styles
        self::FS_NORMAL(9001);
        self::FS_BOLD(9002);
        self::FS_ITALIC(9003);
        self::FS_BOLDIT(9004);
        self::FS_BOLDITALIC(9004);

        //Definitions for internal font
        self::FF_FONT0(1);
        self::FF_FONT1(2);
        self::FF_FONT2(4);

        /*
         * Defines for font setup
         */
        // Actual name of the TTF file used together with FF_CHINESE aka FF_BIG5
        // This is the TTF file being used when the font family is specified as
        // either FF_CHINESE or FF_BIG5
        self::CHINESE_TTF_FONT('bkai00mp.ttf');

        // Special unicode greek language support
        self::LANGUAGE_GREEK(false);

        // If you are setting this config to true the conversion of greek characters
        // will assume that the input text is windows 1251
        self::GREEK_FROM_WINDOWS(false);

        // Special unicode cyrillic language support
        self::LANGUAGE_CYRILLIC(false);

        // If you are setting this config to true the conversion
        // will assume that the input text is windows 1251, if
        // false it will assume koi8-r
        self::CYRILLIC_FROM_WINDOWS(false);

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
        self::LANGUAGE_CHARSET(null);

        // Japanese TrueType font used with FF_MINCHO, FF_PMINCHO, FF_GOTHIC, FF_PGOTHIC
        // Standard fonts from Infomation-technology Promotion Agency (IPA)
        // See http://mix-mplus-ipa.sourceforge.jp/
        self::MINCHO_TTF_FONT('ipam.ttf');
        self::PMINCHO_TTF_FONT('ipamp.ttf');
        self::GOTHIC_TTF_FONT('ipag.ttf');
        self::PGOTHIC_TTF_FONT('ipagp.ttf');

        // Assume that Japanese text have been entered in EUC-JP encoding.
        // If this define is true then conversion from EUC-JP to UTF8 is done
        // automatically in the library using the mbstring module in PHP.
        self::ASSUME_EUCJP_ENCODING(false);

        // Line styles
        self::LINESTYLE_SOLID(1);
        self::LINESTYLE_DOTTED(2);
        self::LINESTYLE_DASHED(3);
        self::LINESTYLE_LONGDASH(4);

        // Styles for gradient color fill
        self::GRAD_VER(1);
        self::GRAD_VERT(1);
        self::GRAD_HOR(2);
        self::GRAD_MIDHOR(3);
        self::GRAD_MIDVER(4);
        self::GRAD_CENTER(5);
        self::GRAD_WIDE_MIDVER(6);
        self::GRAD_WIDE_MIDHOR(7);
        self::GRAD_LEFT_REFLECTION(8);
        self::GRAD_RIGHT_REFLECTION(9);
        self::GRAD_RAISED_PANEL(10);
        self::GRAD_DIAGONAL(11);

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
        self::TICKD_DENSE(1);
        self::TICKD_NORMAL(2);
        self::TICKD_SPARSE(3);
        self::TICKD_VERYSPARSE(4);

        // Side for ticks and labels.
        self::SIDE_LEFT(-1);
        self::SIDE_RIGHT(1);
        self::SIDE_DOWN(-1);
        self::SIDE_BOTTOM(-1);
        self::SIDE_UP(1);
        self::SIDE_TOP(1);

        // Legend type stacked vertical or horizontal
        self::LEGEND_VERT(0);
        self::LEGEND_HOR(1);

        // Mark types for plot marks
        self::MARK_SQUARE(1);
        self::MARK_UTRIANGLE(2);
        self::MARK_DTRIANGLE(3);
        self::MARK_DIAMOND(4);
        self::MARK_CIRCLE(5);
        self::MARK_FILLEDCIRCLE(6);
        self::MARK_CROSS(7);
        self::MARK_STAR(8);
        self::MARK_X(9);
        self::MARK_LEFTTRIANGLE(10);
        self::MARK_RIGHTTRIANGLE(11);
        self::MARK_FLASH(12);
        self::MARK_IMG(13);
        self::MARK_FLAG1(14);
        self::MARK_FLAG2(15);
        self::MARK_FLAG3(16);
        self::MARK_FLAG4(17);

        // Builtin images
        self::MARK_IMG_PUSHPIN(50);
        self::MARK_IMG_SPUSHPIN(50);
        self::MARK_IMG_LPUSHPIN(51);
        self::MARK_IMG_DIAMOND(52);
        self::MARK_IMG_SQUARE(53);
        self::MARK_IMG_STAR(54);
        self::MARK_IMG_BALL(55);
        self::MARK_IMG_SBALL(55);
        self::MARK_IMG_MBALL(56);
        self::MARK_IMG_LBALL(57);
        self::MARK_IMG_BEVEL(58);

        // Inline defines
        self::INLINE_YES(1);
        self::INLINE_NO(0);

        // Format for background images
        self::BGIMG_FILLPLOT(1);
        self::BGIMG_FILLFRAME(2);
        self::BGIMG_COPY(3);
        self::BGIMG_CENTER(4);
        self::BGIMG_FREE(5);

        // Depth of objects
        self::DEPTH_BACK(0);
        self::DEPTH_FRONT(1);

        // Direction
        self::VERTICAL(1);
        self::HORIZONTAL(0);

        // Axis styles for scientific style axis
        self::AXSTYLE_SIMPLE(1);
        self::AXSTYLE_BOXIN(2);
        self::AXSTYLE_BOXOUT(3);
        self::AXSTYLE_YBOXIN(4);
        self::AXSTYLE_YBOXOUT(5);

        // Style for title backgrounds
        self::TITLEBKG_STYLE1(1);
        self::TITLEBKG_STYLE2(2);
        self::TITLEBKG_STYLE3(3);
        self::TITLEBKG_FRAME_NONE(0);
        self::TITLEBKG_FRAME_FULL(1);
        self::TITLEBKG_FRAME_BOTTOM(2);
        self::TITLEBKG_FRAME_BEVEL(3);
        self::TITLEBKG_FILLSTYLE_HSTRIPED(1);
        self::TITLEBKG_FILLSTYLE_VSTRIPED(2);
        self::TITLEBKG_FILLSTYLE_SOLID(3);

        // Styles for axis labels background
        self::LABELBKG_NONE(0);
        self::LABELBKG_XAXIS(1);
        self::LABELBKG_YAXIS(2);
        self::LABELBKG_XAXISFULL(3);
        self::LABELBKG_YAXISFULL(4);
        self::LABELBKG_XYFULL(5);
        self::LABELBKG_XY(6);

        // Style for background gradient fills
        self::BGRAD_FRAME(1);
        self::BGRAD_MARGIN(2);
        self::BGRAD_PLOT(3);

        // Width of tab titles
        self::TABTITLE_WIDTHFIT(0);
        self::TABTITLE_WIDTHFULL(-1);

        // Defines for 3D skew directions
        self::SKEW3D_UP(0);
        self::SKEW3D_DOWN(1);
        self::SKEW3D_LEFT(2);
        self::SKEW3D_RIGHT(3);

        // For internal use only
    }

    public static function verifyCacheSettings()
    {

        /**
         * NOTE THAT CACHE FUNCTIONALITY IS TURNED OFF BY  DEFAULT ENABLE BY SETTING USE_CACHE TO TRUE)
         * Should the cache be used at all? By setting this to false no
         * files will be generated in the cache directory.
         * The difference from READ_CACHE being that setting READ_CACHE to
         * false will still create the image in the cache directory
         * just not use it. By setting USE_CACHE=false no files will even
         * be generated in the cache directory.
         */
        self::USE_CACHE(getenv('JPGRAPH_USE_CACHE') || false);

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
        if (getenv('JPGRAPH_CACHE_DIR')) {
            self::CACHE_DIR(getenv('JPGRAPH_CACHE_DIR'));
        }
        if (getenv('JPGRAPH_TTF_DIR')) {
            self::TTF_DIR(getenv('JPGRAPH_TTF_DIR'));
        }
        if (getenv('JPGRAPH_MBTTF_DIR')) {
            self::MBTTF_DIR(getenv('JPGRAPH_MBTTF_DIR'));
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
        self::CSIMCACHE_DIR('csimcache/');
        self::CSIMCACHE_HTTP_DIR('csimcache/');

        // Should we try to find an image in the cache before generating it?
        // Set this define to false to bypass the reading of the cache and always
        // regenerate the image. Note that even if reading the cache is
        // disabled the cached will still be updated with the newly generated
        // image. Set also 'USE_CACHE' below.
        self::READ_CACHE(true);

        /*
         * The following constants should rarely have to be changed !
         */
        // What group should the cached file belong to
        // (Set to '' will give the default group for the 'PHP-user')
        // Please note that the Apache user must be a member of the
        // specified group since otherwise it is impossible for Apache
        // to set the specified group.
        self::CACHE_FILE_GROUP(getenv('JPGRAPH_CACHE_FILE_GROUP') || 'www');

        // What permissions should the cached file have
        // (Set to '' will give the default persmissions for the 'PHP-user')
        self::CACHE_FILE_MOD(getenv('JPGRAPH_CACHE_FILE_MOD') || 0664);

        if (USE_CACHE) {
            if (!defined('CACHE_DIR')) {
                if (strstr(PHP_OS, 'WIN')) {
                    if (empty($_SERVER['TEMP'])) {
                        $t   = new ErrMsgText();
                        $msg = $t->Get(11, $file, $lineno);
                        die($msg);
                    }
                    self::CACHE_DIR($_SERVER['TEMP'] . '/');
                } else {
                    self::CACHE_DIR('/tmp/jpgraph_cache/');
                }
            }
        } else {
            self::CACHE_DIR('');
        }
    }

    public static function verifyTTFSettings()
    {

        //self::CSIMCACHE_DIR('csimcache/');
        //self::CSIMCACHE_HTTP_DIR('csimcache/');
        /**
         * Setup path for TTF fonts
         */
        if (!defined('TTF_DIR')) {
            if (strstr(PHP_OS, 'WIN')) {
                if (!defined('SYSTEMROOT')) {
                    $t   = new ErrMsgText();
                    $msg = $t->Get(12, $file, $lineno);
                    die($msg);
                }
                self::TTF_DIR(SYSTEMROOT . '/fonts/');
            } else {
                self::TTF_DIR('/usr/share/fonts/truetype/');
            }
        }
    }

    public static function verifyMBTTFSettings()
    {
        /**
         * Setup path for MultiByte TTF fonts (japanese, chinese etc.)
         */
        if (!defined('MBTTF_DIR')) {
            if (strstr(PHP_OS, 'WIN')) {
                if (!defined('SYSTEMROOT')) {
                    $t   = new ErrMsgText();
                    $msg = $t->Get(12, $file, $lineno);
                    die($msg);
                }
                self::MBTTF_DIR(SYSTEMROOT . '/fonts/');
            } else {
                self::MBTTF_DIR('/usr/share/fonts/truetype/');
            }
        }
    }

    /**
     * Traverse format related constants.
     * self::heck(et them to defaults otherwise
     */
    public static function verifyFormatSettings()
    {
        // Deafult graphic format set to 'auto' which will automatically
        // choose the best available format in the order png,gif,jpeg
        // (The supported format depends on what your PHP installation supports)
        self::DEFAULT_GFORMAT('auto');
        // The builtin GD function imagettfbbox() fuction which calculates the bounding box for
        // text using TTF fonts is buggy. By setting this define to true the library
        // uses its own compensation for this bug. However this will give a
        // slightly different visual apparance than not using this compensation.
        // Enabling this compensation will in general give text a bit more space to more
        // truly reflect the actual bounding box which is a bit larger than what the
        // GD function thinks.
        self::USE_LIBRARY_IMAGETTFBBOX(true);

        // Maximum size for Automatic Gantt chart
        self::MAX_GANTTIMG_SIZE_W(8000);
        self::MAX_GANTTIMG_SIZE_H(5000);
    }
}

Constants::setGeneralConstants();
