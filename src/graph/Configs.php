<?php

/**
 * JPGraph v4.0.0
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Util;

class Configs extends Util\Configs
{
    const DSUTILS_MONTH  = 1; // Major and minor ticks on a monthly basis
    const DSUTILS_MONTH1 = 1; // Major and minor ticks on a monthly basis
    const DSUTILS_MONTH2 = 2; // Major ticks on a bi-monthly basis
    const DSUTILS_MONTH3 = 3; // Major icks on a tri-monthly basis
    const DSUTILS_MONTH6 = 4; // Major on a six-monthly basis
    const DSUTILS_WEEK1  = 5; // Major ticks on a weekly basis
    const DSUTILS_WEEK2  = 6; // Major ticks on a bi-weekly basis
    const DSUTILS_WEEK4  = 7; // Major ticks on a quod-weekly basis
    const DSUTILS_DAY1   = 8; // Major ticks on a daily basis
    const DSUTILS_DAY2   = 9; // Major ticks on a bi-daily basis
    const DSUTILS_DAY4   = 10; // Major ticks on a qoud-daily basis
    const DSUTILS_YEAR1  = 11; // Major ticks on a yearly basis
    const DSUTILS_YEAR2  = 12; // Major ticks on a bi-yearly basis
    const DSUTILS_YEAR5  = 13; // Major ticks on a five-yearly basis
    // Configs for types of static bands in plot area
    const _JPG_DEBUG     = false;
    const BAND_RDIAG     = 1; // Right diagonal lines
    const BAND_LDIAG     = 2; // Left diagonal lines
    const BAND_SOLID     = 3; // Solid one color
    const BAND_VLINE     = 4; // Vertical lines
    const BAND_HLINE     = 5; // Horizontal lines
    const BAND_3DPLANE   = 6; // "3D" Plane
    const BAND_HVCROSS   = 7; // Vertical/Hor crosses
    const BAND_DIAGCROSS = 8; // Diagonal crosses

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

    public function __construct()
    {
        parent::__construct();
    }
}
