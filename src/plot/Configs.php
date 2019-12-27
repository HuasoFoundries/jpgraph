<?php

/**
 * JPGraph v4.0.0
 */

namespace Amenadiel\JpGraph\Plot;

use Amenadiel\JpGraph\Util;

class Configs extends Util\Configs
{
    const WINDROSE_TYPE4    = 1;
    const WINDROSE_TYPE8    = 2;
    const WINDROSE_TYPE16   = 3;
    const WINDROSE_TYPEFREE = 4;

    /*
     * How should the labels for the circular grids be aligned
     */
    const POLAR_360 = 1;
    const POLAR_180 = 2;
    /*
     * How should the labels around the plot be align
     */
    const LBLPOSITION_CENTER = 1;
    const LBLPOSITION_EDGE   = 2;

    /*
     * Interpretation of ordinal values in the data
     */
    const KEYENCODING_CLOCKWISE     = 1;
    const KEYENCODING_ANTICLOCKWISE = 2;

    // Internal debug flag
    const __DEBUG           = false;
    const RANGE_OVERLAPPING = 0;
    const RANGE_DISCRETE    = 1;
    // Configs for types of static bands in plot area

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
    const GRAD_CENTER                 = 5;
    const GRAD_DIAGONAL               = 11;
    const GRAD_HOR                    = 2;
    const GRAD_LEFT_REFLECTION        = 8;
    const GRAD_MIDHOR                 = 3;
    const GRAD_MIDVER                 = 4;
    const GRAD_RAISED_PANEL           = 10;
    const GRAD_RIGHT_REFLECTION       = 9;
    const GRAD_VER                    = 1;
    const GRAD_VERT                   = 1;
    const GRAD_WIDE_MIDHOR            = 7;
    const GRAD_WIDE_MIDVER            = 6;
    public function __construct()
    {
        parent::__construct();
    }
}
