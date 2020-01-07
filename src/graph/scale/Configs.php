<?php

/**
 * JPGraph v4.1.0-beta.01
 */

namespace Amenadiel\JpGraph\Scale;

use Amenadiel\JpGraph\Util;

class Configs extends Util\Configs
{
    // Configs for types of static bands in plot area
    public const _JPG_DEBUG     = false;
    public const BAND_RDIAG     = 1; // Right diagonal lines
    public const BAND_LDIAG     = 2; // Left diagonal lines
    public const BAND_SOLID     = 3; // Solid one color
    public const BAND_VLINE     = 4; // Vertical lines
    public const BAND_HLINE     = 5; // Horizontal lines
    public const BAND_3DPLANE   = 6; // "3D" Plane
    public const BAND_HVCROSS   = 7; // Vertical/Hor crosses
    public const BAND_DIAGCROSS = 8; // Diagonal crosses

// Style for background gradient fills
    public const BGRAD_FRAME  = 1;
    public const BGRAD_MARGIN = 2;
    public const BGRAD_PLOT   = 3;

    // Format for background images
    public const BGIMG_FILLPLOT  = 1;
    public const BGIMG_FILLFRAME = 2;
    public const BGIMG_COPY      = 3;
    public const BGIMG_CENTER    = 4;
    public const BGIMG_FREE      = 5;
    // Activity types for use with utility method CreateSimple()
    public const ACTYPE_NORMAL    = 0;
    public const ACTYPE_GROUP     = 1;
    public const ACTYPE_MILESTONE = 2;

    public const ACTINFO_3D = 1;
    public const ACTINFO_2D = 0;
    // Axis styles for scientific style axis
    public const AXSTYLE_SIMPLE  = 1;
    public const AXSTYLE_BOXIN   = 2;
    public const AXSTYLE_BOXOUT  = 3;
    public const AXSTYLE_YBOXIN  = 4;
    public const AXSTYLE_YBOXOUT = 5;
    // Depth of objects
    public const DEPTH_BACK  = 0;
    public const DEPTH_FRONT = 1;

    // TTF Font styles
    public const FS_NORMAL     = 9001;
    public const FS_BOLD       = 9002;
    public const FS_ITALIC     = 9003;
    public const FS_BOLDIT     = 9004;
    public const FS_BOLDITALIC = 9004;

    // Tick density
    public const TICKD_DENSE      = 1;
    public const TICKD_NORMAL     = 2;
    public const TICKD_SPARSE     = 3;
    public const TICKD_VERYSPARSE = 4;

    // Side for ticks and labels.
    public const SIDE_LEFT  = -1;
    public const SIDE_RIGHT = 1;
    // Style for title backgrounds
    public const TITLEBKG_STYLE1             = 1;
    public const TITLEBKG_STYLE2             = 2;
    public const TITLEBKG_STYLE3             = 3;
    public const TITLEBKG_FRAME_NONE         = 0;
    public const TITLEBKG_FRAME_FULL         = 1;
    public const TITLEBKG_FRAME_BOTTOM       = 2;
    public const TITLEBKG_FRAME_BEVEL        = 3;
    public const TITLEBKG_FILLSTYLE_HSTRIPED = 1;
    public const TITLEBKG_FILLSTYLE_VSTRIPED = 2;
    public const TITLEBKG_FILLSTYLE_SOLID    = 3;

    public function __construct()
    {
        parent::__construct();
    }
}
