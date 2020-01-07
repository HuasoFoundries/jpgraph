<?php

/**
 * JPGraph v4.1.0-beta.01
 */

namespace Amenadiel\JpGraph\Image;

use Amenadiel\JpGraph\Util;
use function define;
use function defined;
use function getenv;

// Require ../Util/Config.php
require_once sprintf(
    '%s%s..%sutil%sConfigs.php',
    __DIR__,
    DIRECTORY_SEPARATOR,
    DIRECTORY_SEPARATOR,
    DIRECTORY_SEPARATOR
);

/*
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

class Configs extends Util\Configs
{
    // Configs for types of static bands in plot area
    const LEDC_RED         = 0;
    const LEDC_GREEN       = 1;
    const LEDC_BLUE        = 2;
    const LEDC_YELLOW      = 3;
    const LEDC_GRAY        = 4;
    const LEDC_CHOCOLATE   = 5;
    const LEDC_PERU        = 6;
    const LEDC_GOLDENROD   = 7;
    const LEDC_KHAKI       = 8;
    const LEDC_OLIVE       = 9;
    const LEDC_LIMEGREEN   = 10;
    const LEDC_FORESTGREEN = 11;
    const LEDC_TEAL        = 12;
    const LEDC_STEELBLUE   = 13;
    const LEDC_NAVY        = 14;
    const LEDC_INVERTGRAY  = 15;
    const BAND_RDIAG       = 1; // Right diagonal lines
    const BAND_LDIAG       = 2; // Left diagonal lines
    const BAND_SOLID       = 3; // Solid one color
    const BAND_VLINE       = 4; // Vertical lines
    const BAND_HLINE       = 5; // Horizontal lines
    const BAND_3DPLANE     = 6; // "3D" Plane
    const BAND_HVCROSS     = 7; // Vertical/Hor crosses
    const BAND_DIAGCROSS   = 8; // Diagonal crosses

// Style for background gradient fills
    const BGRAD_FRAME  = 1;
    const BGRAD_MARGIN = 2;
    const BGRAD_PLOT   = 3;

    // Format for background images
    const BGIMG_FILLPLOT  = 1;
    const BGIMG_FILLFRAME = 2;
    const BGIMG_COPY      = 3;
    const BGIMG_CENTER    = 4;
    const BGIMG_FREE      = 5;
    // Activity types for use with utility method CreateSimple()
    const ACTYPE_NORMAL    = 0;
    const ACTYPE_GROUP     = 1;
    const ACTYPE_MILESTONE = 2;

    const ACTINFO_3D = 1;
    const ACTINFO_2D = 0;
    // Axis styles for scientific style axis
    const AXSTYLE_SIMPLE  = 1;
    const AXSTYLE_BOXIN   = 2;
    const AXSTYLE_BOXOUT  = 3;
    const AXSTYLE_YBOXIN  = 4;
    const AXSTYLE_YBOXOUT = 5;
    // Depth of objects
    const DEPTH_BACK  = 0;
    const DEPTH_FRONT = 1;

    // TTF Font styles
    const FS_NORMAL     = 9001;
    const FS_BOLD       = 9002;
    const FS_ITALIC     = 9003;
    const FS_BOLDIT     = 9004;
    const FS_BOLDITALIC = 9004;

    // Tick density
    const TICKD_DENSE      = 1;
    const TICKD_NORMAL     = 2;
    const TICKD_SPARSE     = 3;
    const TICKD_VERYSPARSE = 4;

    // Side for ticks and labels.
    const SIDE_LEFT  = -1;
    const SIDE_RIGHT = 1;
    // Style for title backgrounds
    const TITLEBKG_STYLE1             = 1;
    const TITLEBKG_STYLE2             = 2;
    const TITLEBKG_STYLE3             = 3;
    const TITLEBKG_FRAME_NONE         = 0;
    const TITLEBKG_FRAME_FULL         = 1;
    const TITLEBKG_FRAME_BOTTOM       = 2;
    const TITLEBKG_FRAME_BEVEL        = 3;
    const TITLEBKG_FILLSTYLE_HSTRIPED = 1;
    const TITLEBKG_FILLSTYLE_VSTRIPED = 2;
    const TITLEBKG_FILLSTYLE_SOLID    = 3;
    const _FIRST_FONT                 = 10;
    const _LAST_FONT                  = 99;

    public function __construct()
    {
        parent::__construct();
    }
}
