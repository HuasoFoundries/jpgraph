<?php
//=======================================================================
// File:        JPGRAPH.PHP
// Description: PHP Graph Plotting library. Base module.
// Created:     2001-01-08
// Ver:         $Id: jpgraph.php 1924 2010-01-11 14:03:26Z ljp $
//
// Copyright (c) Asial Corporation. All rights reserved.
//========================================================================

require_once 'includes/jpg-config.inc.php';
require_once 'jpgraph_gradient.php';
require_once 'jpgraph_errhandler.inc.php';
require_once 'jpgraph_ttf.inc.php';
require_once 'jpgraph_rgb.inc.php';
require_once 'jpgraph_text.inc.php';
require_once 'jpgraph_legend.inc.php';
require_once 'jpgraph_theme.inc.php';
require_once 'gd_image.inc.php';

// Version info
define('JPG_VERSION', '3.5.0b1');

// Minimum required PHP version
define('MIN_PHPVERSION', '5.1.0');

// Special file name to indicate that we only want to calc
// the image map in the call to Graph::Stroke() used
// internally from the GetHTMLCSIM() method.
define('_CSIM_SPECIALFILE', '_csim_special_');

// HTTP GET argument that is used with image map
// to indicate to the script to just generate the image
// and not the full CSIM HTML page.
define('_CSIM_DISPLAY', '_jpg_csimd');

// Special filename for Graph::Stroke(). If this filename is given
// then the image will NOT be streamed to browser of file. Instead the
// Stroke call will return the handler for the created GD image.
define('_IMG_HANDLER', '__handle');

// Special filename for Graph::Stroke(). If this filename is given
// the image will be stroked to a file with a name based on the script name.
define('_IMG_AUTO', 'auto');

// Tick density
define("TICKD_DENSE", 1);
define("TICKD_NORMAL", 2);
define("TICKD_SPARSE", 3);
define("TICKD_VERYSPARSE", 4);

// Side for ticks and labels.
define("SIDE_LEFT", -1);
define("SIDE_RIGHT", 1);
define("SIDE_DOWN", -1);
define("SIDE_BOTTOM", -1);
define("SIDE_UP", 1);
define("SIDE_TOP", 1);

// Legend type stacked vertical or horizontal
define("LEGEND_VERT", 0);
define("LEGEND_HOR", 1);

// Mark types for plot marks
define("MARK_SQUARE", 1);
define("MARK_UTRIANGLE", 2);
define("MARK_DTRIANGLE", 3);
define("MARK_DIAMOND", 4);
define("MARK_CIRCLE", 5);
define("MARK_FILLEDCIRCLE", 6);
define("MARK_CROSS", 7);
define("MARK_STAR", 8);
define("MARK_X", 9);
define("MARK_LEFTTRIANGLE", 10);
define("MARK_RIGHTTRIANGLE", 11);
define("MARK_FLASH", 12);
define("MARK_IMG", 13);
define("MARK_FLAG1", 14);
define("MARK_FLAG2", 15);
define("MARK_FLAG3", 16);
define("MARK_FLAG4", 17);

// Builtin images
define("MARK_IMG_PUSHPIN", 50);
define("MARK_IMG_SPUSHPIN", 50);
define("MARK_IMG_LPUSHPIN", 51);
define("MARK_IMG_DIAMOND", 52);
define("MARK_IMG_SQUARE", 53);
define("MARK_IMG_STAR", 54);
define("MARK_IMG_BALL", 55);
define("MARK_IMG_SBALL", 55);
define("MARK_IMG_MBALL", 56);
define("MARK_IMG_LBALL", 57);
define("MARK_IMG_BEVEL", 58);

// Inline defines
define("INLINE_YES", 1);
define("INLINE_NO", 0);

// Format for background images
define("BGIMG_FILLPLOT", 1);
define("BGIMG_FILLFRAME", 2);
define("BGIMG_COPY", 3);
define("BGIMG_CENTER", 4);
define("BGIMG_FREE", 5);

// Depth of objects
define("DEPTH_BACK", 0);
define("DEPTH_FRONT", 1);

// Direction
define("VERTICAL", 1);
define("HORIZONTAL", 0);

// Axis styles for scientific style axis
define('AXSTYLE_SIMPLE', 1);
define('AXSTYLE_BOXIN', 2);
define('AXSTYLE_BOXOUT', 3);
define('AXSTYLE_YBOXIN', 4);
define('AXSTYLE_YBOXOUT', 5);

// Style for title backgrounds
define('TITLEBKG_STYLE1', 1);
define('TITLEBKG_STYLE2', 2);
define('TITLEBKG_STYLE3', 3);
define('TITLEBKG_FRAME_NONE', 0);
define('TITLEBKG_FRAME_FULL', 1);
define('TITLEBKG_FRAME_BOTTOM', 2);
define('TITLEBKG_FRAME_BEVEL', 3);
define('TITLEBKG_FILLSTYLE_HSTRIPED', 1);
define('TITLEBKG_FILLSTYLE_VSTRIPED', 2);
define('TITLEBKG_FILLSTYLE_SOLID', 3);

// Styles for axis labels background
define('LABELBKG_NONE', 0);
define('LABELBKG_XAXIS', 1);
define('LABELBKG_YAXIS', 2);
define('LABELBKG_XAXISFULL', 3);
define('LABELBKG_YAXISFULL', 4);
define('LABELBKG_XYFULL', 5);
define('LABELBKG_XY', 6);

// Style for background gradient fills
define('BGRAD_FRAME', 1);
define('BGRAD_MARGIN', 2);
define('BGRAD_PLOT', 3);

// Width of tab titles
define('TABTITLE_WIDTHFIT', 0);
define('TABTITLE_WIDTHFULL', -1);

// Defines for 3D skew directions
define('SKEW3D_UP', 0);
define('SKEW3D_DOWN', 1);
define('SKEW3D_LEFT', 2);
define('SKEW3D_RIGHT', 3);

// For internal use only
define("_JPG_DEBUG", false);
define("_FORCE_IMGTOFILE", false);
define("_FORCE_IMGDIR", '/tmp/jpgimg/');

//
// Automatic settings of path for cache and font directory
// if they have not been previously specified
//
if (USE_CACHE) {
    if (!defined('CACHE_DIR')) {
        if (strstr(PHP_OS, 'WIN')) {
            if (empty($_SERVER['TEMP'])) {
                $t = new ErrMsgText();
                $msg = $t->Get(11, $file, $lineno);
                die($msg);
            } else {
                define('CACHE_DIR', $_SERVER['TEMP'] . '/');
            }
        } else {
            define('CACHE_DIR', '/tmp/jpgraph_cache/');
        }
    }
} elseif (!defined('CACHE_DIR')) {
    define('CACHE_DIR', '');
}

//
// Setup path for western/latin TTF fonts
//
if (!defined('TTF_DIR')) {
    if (strstr(PHP_OS, 'WIN')) {
        $sroot = getenv('SystemRoot');
        if (empty($sroot)) {
            $t = new ErrMsgText();
            $msg = $t->Get(12, $file, $lineno);
            die($msg);
        } else {
            define('TTF_DIR', $sroot . '/fonts/');
        }
    } else {
        define('TTF_DIR', '/usr/share/fonts/truetype/');
    }
}

//
// Setup path for MultiByte TTF fonts (japanese, chinese etc.)
//
if (!defined('MBTTF_DIR')) {
    if (strstr(PHP_OS, 'WIN')) {
        $sroot = getenv('SystemRoot');
        if (empty($sroot)) {
            $t = new ErrMsgText();
            $msg = $t->Get(12, $file, $lineno);
            die($msg);
        } else {
            define('MBTTF_DIR', $sroot . '/fonts/');
        }
    } else {
        define('MBTTF_DIR', '/usr/share/fonts/truetype/');
    }
}

//
// Check minimum PHP version
//
function CheckPHPVersion($aMinVersion)
{
    list($majorC, $minorC, $editC) = preg_split('/[\/.-]/', PHP_VERSION);
    list($majorR, $minorR, $editR) = preg_split('/[\/.-]/', $aMinVersion);

    if ($majorC != $majorR) {
        return false;
    }

    if ($majorC < $majorR) {
        return false;
    }

    // same major - check minor
    if ($minorC > $minorR) {
        return true;
    }

    if ($minorC < $minorR) {
        return false;
    }

    // and same minor
    if ($editC >= $editR) {
        return true;
    }

    return true;
}

//
// Make sure PHP version is high enough
//
if (!CheckPHPVersion(MIN_PHPVERSION)) {
    JpGraphError::RaiseL(13, PHP_VERSION, MIN_PHPVERSION);
    die();
}

//
// Make GD sanity check
//
if (!function_exists("imagetypes") || !function_exists('imagecreatefromstring')) {
    JpGraphError::RaiseL(25001);
    //("This PHP installation is not configured with the GD library. Please recompile PHP with GD support to run JpGraph. (Neither function imagetypes() nor imagecreatefromstring() does exist)");
}

//
// Setup PHP error handler
//
function _phpErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
    // Respect current error level
    if ($errno & error_reporting()) {
        JpGraphError::RaiseL(25003, basename($filename), $linenum, $errmsg);
    }
}

if (INSTALL_PHP_ERR_HANDLER) {
    set_error_handler("_phpErrorHandler");
}

//
// Check if there were any warnings, perhaps some wrong includes by the user. In this
// case we raise it immediately since otherwise the image will not show and makes
// debugging difficult. This is controlled by the user setting CATCH_PHPERRMSG
//
if (isset($GLOBALS['php_errormsg']) && CATCH_PHPERRMSG && !preg_match('/|Deprecated|/i', $GLOBALS['php_errormsg'])) {
    JpGraphError::RaiseL(25004, $GLOBALS['php_errormsg']);
}

// Useful mathematical function
function sign($a)
{return $a >= 0 ? 1 : -1;}

//
// Utility function to generate an image name based on the filename we
// are running from and assuming we use auto detection of graphic format
// (top level), i.e it is safe to call this function
// from a script that uses JpGraph
//
function GenImgName()
{
    // Determine what format we should use when we save the images
    $supported = imagetypes();
    if ($supported & IMG_PNG) {
        $img_format = "png";
    } elseif ($supported & IMG_GIF) {
        $img_format = "gif";
    } elseif ($supported & IMG_JPG) {
        $img_format = "jpeg";
    } elseif ($supported & IMG_WBMP) {
        $img_format = "wbmp";
    } elseif ($supported & IMG_XPM) {
        $img_format = "xpm";
    }

    if (!isset($_SERVER['PHP_SELF'])) {
        JpGraphError::RaiseL(25005);
        //(" Can't access PHP_SELF, PHP global variable. You can't run PHP from command line if you want to use the 'auto' naming of cache or image files.");
    }
    $fname = basename($_SERVER['PHP_SELF']);
    if (!empty($_SERVER['QUERY_STRING'])) {
        $q = @$_SERVER['QUERY_STRING'];
        $fname .= '_' . preg_replace("/\W/", "_", $q) . '.' . $img_format;
    } else {
        $fname = substr($fname, 0, strlen($fname) - 4) . '.' . $img_format;
    }
    return $fname;
}

//===================================================
// CLASS JpgTimer
// Description: General timing utility class to handle
// time measurement of generating graphs. Multiple
// timers can be started.
//===================================================
class JpgTimer
{
    private $start, $idx;

    public function __construct()
    {
        $this->idx = 0;
    }

    // Push a new timer start on stack
    public function Push()
    {
        list($ms, $s) = explode(" ", microtime());
        $this->start[$this->idx++] = floor($ms * 1000) + 1000 * $s;
    }

    // Pop the latest timer start and return the diff with the
    // current time
    public function Pop()
    {
        assert($this->idx > 0);
        list($ms, $s) = explode(" ", microtime());
        $etime = floor($ms * 1000) + (1000 * $s);
        $this->idx--;
        return $etime - $this->start[$this->idx];
    }
} // Class

//===================================================
// CLASS DateLocale
// Description: Hold localized text used in dates
//===================================================
class DateLocale
{

    public $iLocale = 'C'; // environmental locale be used by default
    private $iDayAbb = null, $iShortDay = null, $iShortMonth = null, $iMonthName = null;

    public function __construct()
    {
        settype($this->iDayAbb, 'array');
        settype($this->iShortDay, 'array');
        settype($this->iShortMonth, 'array');
        settype($this->iMonthName, 'array');
        $this->Set('C');
    }

    public function Set($aLocale)
    {
        if (in_array($aLocale, array_keys($this->iDayAbb))) {
            $this->iLocale = $aLocale;
            return true; // already cached nothing else to do!
        }

        $pLocale = setlocale(LC_TIME, 0); // get current locale for LC_TIME

        if (is_array($aLocale)) {
            foreach ($aLocale as $loc) {
                $res = @setlocale(LC_TIME, $loc);
                if ($res) {
                    $aLocale = $loc;
                    break;
                }
            }
        } else {
            $res = @setlocale(LC_TIME, $aLocale);
        }

        if (!$res) {
            JpGraphError::RaiseL(25007, $aLocale);
            //("You are trying to use the locale ($aLocale) which your PHP installation does not support. Hint: Use '' to indicate the default locale for this geographic region.");
            return false;
        }

        $this->iLocale = $aLocale;
        for ($i = 0, $ofs = 0 - strftime('%w'); $i < 7; $i++, $ofs++) {
            $day = strftime('%a', strtotime("$ofs day"));
            $day[0] = strtoupper($day[0]);
            $this->iDayAbb[$aLocale][] = $day[0];
            $this->iShortDay[$aLocale][] = $day;
        }

        for ($i = 1; $i <= 12; ++$i) {
            list($short, $full) = explode('|', strftime("%b|%B", strtotime("2001-$i-01")));
            $this->iShortMonth[$aLocale][] = ucfirst($short);
            $this->iMonthName[$aLocale][] = ucfirst($full);
        }

        setlocale(LC_TIME, $pLocale);

        return true;
    }

    public function GetDayAbb()
    {
        return $this->iDayAbb[$this->iLocale];
    }

    public function GetShortDay()
    {
        return $this->iShortDay[$this->iLocale];
    }

    public function GetShortMonth()
    {
        return $this->iShortMonth[$this->iLocale];
    }

    public function GetShortMonthName($aNbr)
    {
        return $this->iShortMonth[$this->iLocale][$aNbr];
    }

    public function GetLongMonthName($aNbr)
    {
        return $this->iMonthName[$this->iLocale][$aNbr];
    }

    public function GetMonth()
    {
        return $this->iMonthName[$this->iLocale];
    }
}

// Global object handlers
$gDateLocale = new DateLocale();
$gJpgDateLocale = new DateLocale();

//=======================================================
// CLASS Footer
// Description: Encapsulates the footer line in the Graph
//=======================================================
class Footer
{
    public $iLeftMargin = 3, $iRightMargin = 3, $iBottomMargin = 3;
    public $left, $center, $right;
    private $iTimer = null, $itimerpoststring = '';

    public function __construct()
    {
        $this->left = new Text();
        $this->left->ParagraphAlign('left');
        $this->center = new Text();
        $this->center->ParagraphAlign('center');
        $this->right = new Text();
        $this->right->ParagraphAlign('right');
    }

    public function SetTimer($aTimer, $aTimerPostString = '')
    {
        $this->iTimer = $aTimer;
        $this->itimerpoststring = $aTimerPostString;
    }

    public function SetMargin($aLeft = 3, $aRight = 3, $aBottom = 3)
    {
        $this->iLeftMargin = $aLeft;
        $this->iRightMargin = $aRight;
        $this->iBottomMargin = $aBottom;
    }

    public function Stroke($aImg)
    {
        $y = $aImg->height - $this->iBottomMargin;
        $x = $this->iLeftMargin;
        $this->left->Align('left', 'bottom');
        $this->left->Stroke($aImg, $x, $y);

        $x = ($aImg->width - $this->iLeftMargin - $this->iRightMargin) / 2;
        $this->center->Align('center', 'bottom');
        $this->center->Stroke($aImg, $x, $y);

        $x = $aImg->width - $this->iRightMargin;
        $this->right->Align('right', 'bottom');
        if ($this->iTimer != null) {
            $this->right->Set($this->right->t . sprintf('%.3f', $this->iTimer->Pop() / 1000.0) . $this->itimerpoststring);
        }
        $this->right->Stroke($aImg, $x, $y);
    }
}

//===================================================
// CLASS Graph
// Description: Main class to handle graphs
//===================================================
class Graph
{
    public $cache = null; // Cache object (singleton)
    public $img = null; // Img object (singleton)
    public $plots = array(); // Array of all plot object in the graph (for Y 1 axis)
    public $y2plots = array(); // Array of all plot object in the graph (for Y 2 axis)
    public $ynplots = array();
    public $xscale = null; // X Scale object (could be instance of LinearScale or LogScale
    public $yscale = null, $y2scale = null, $ynscale = array();
    public $iIcons = array(); // Array of Icons to add to
    public $cache_name; // File name to be used for the current graph in the cache directory
    public $xgrid = null; // X Grid object (linear or logarithmic)
    public $ygrid = null, $y2grid = null; //dito for Y
    public $doframe, $frame_color, $frame_weight; // Frame around graph
    public $boxed = false, $box_color = 'black', $box_weight = 1; // Box around plot area
    public $doshadow = false, $shadow_width = 4, $shadow_color = 'gray@0.5'; // Shadow for graph
    public $xaxis = null; // X-axis (instane of Axis class)
    public $yaxis = null, $y2axis = null, $ynaxis = array(); // Y axis (instance of Axis class)
    public $margin_color; // Margin color of graph
    public $plotarea_color = array(255, 255, 255); // Plot area color
    public $title, $subtitle, $subsubtitle; // Title and subtitle(s) text object
    public $axtype = "linlin"; // Type of axis
    public $xtick_factor, $ytick_factor; // Factor to determine the maximum number of ticks depending on the plot width
    public $texts = null, $y2texts = null; // Text object to ge shown in the graph
    public $lines = null, $y2lines = null;
    public $bands = null, $y2bands = null;
    public $text_scale_off = 0, $text_scale_abscenteroff = -1; // Text scale in fractions and for centering bars
    public $background_image = '', $background_image_type = -1, $background_image_format = "png";
    public $background_image_bright = 0, $background_image_contr = 0, $background_image_sat = 0;
    public $background_image_xpos = 0, $background_image_ypos = 0;
    public $image_bright = 0, $image_contr = 0, $image_sat = 0;
    public $inline;
    public $showcsim = 0, $csimcolor = "red"; //debug stuff, draw the csim boundaris on the image if <>0
    public $grid_depth = DEPTH_BACK; // Draw grid under all plots as default
    public $iAxisStyle = AXSTYLE_SIMPLE;
    public $iCSIMdisplay = false, $iHasStroked = false;
    public $footer;
    public $csimcachename = '', $csimcachetimeout = 0, $iCSIMImgAlt = '';
    public $iDoClipping = false;
    public $y2orderback = true;
    public $tabtitle;
    public $bkg_gradtype = -1, $bkg_gradstyle = BGRAD_MARGIN;
    public $bkg_gradfrom = 'navy', $bkg_gradto = 'silver';
    public $plot_gradtype = -1, $plot_gradstyle = BGRAD_MARGIN;
    public $plot_gradfrom = 'silver', $plot_gradto = 'navy';

    public $titlebackground = false;
    public $titlebackground_color = 'lightblue',
    $titlebackground_style = 1,
    $titlebackground_framecolor,
    $titlebackground_framestyle,
    $titlebackground_frameweight,
    $titlebackground_bevelheight;
    public $titlebkg_fillstyle = TITLEBKG_FILLSTYLE_SOLID;
    public $titlebkg_scolor1 = 'black', $titlebkg_scolor2 = 'white';
    public $framebevel, $framebeveldepth;
    public $framebevelborder, $framebevelbordercolor;
    public $framebevelcolor1, $framebevelcolor2;
    public $background_image_mix = 100;
    public $background_cflag = '';
    public $background_cflag_type = BGIMG_FILLPLOT;
    public $background_cflag_mix = 100;
    public $iImgTrans = false,
    $iImgTransHorizon = 100, $iImgTransSkewDist = 150,
    $iImgTransDirection = 1, $iImgTransMinSize = true,
    $iImgTransFillColor = 'white', $iImgTransHighQ = false,
    $iImgTransBorder = false, $iImgTransHorizonPos = 0.5;
    public $legend;
    public $graph_theme;
    protected $iYAxisDeltaPos = 50;
    protected $iIconDepth = DEPTH_BACK;
    protected $iAxisLblBgType = 0,
    $iXAxisLblBgFillColor = 'lightgray', $iXAxisLblBgColor = 'black',
    $iYAxisLblBgFillColor = 'lightgray', $iYAxisLblBgColor = 'black';
    protected $iTables = null;

    protected $isRunningClear = false;
    protected $inputValues;
    protected $isAfterSetScale = false;

    // aWIdth   Width in pixels of image
    // aHeight   Height in pixels of image
    // aCachedName Name for image file in cache directory
    // aTimeOut  Timeout in minutes for image in cache
    // aInline  If true the image is streamed back in the call to Stroke()
    //   If false the image is just created in the cache
    public function __construct($aWidth = 300, $aHeight = 200, $aCachedName = '', $aTimeout = 0, $aInline = true)
    {

        if (!is_numeric($aWidth) || !is_numeric($aHeight)) {
            JpGraphError::RaiseL(25008); //('Image width/height argument in Graph::Graph() must be numeric');
        }

        // Initialize frame and margin
        $this->InitializeFrameAndMargin();

        // Automatically generate the image file name based on the name of the script that
        // generates the graph
        if ($aCachedName == 'auto') {
            $aCachedName = GenImgName();
        }

        // Should the image be streamed back to the browser or only to the cache?
        $this->inline = $aInline;

        $this->img = new RotImage($aWidth, $aHeight);
        $this->cache = new ImgStreamCache();

        // Window doesn't like '?' in the file name so replace it with an '_'
        $aCachedName = str_replace("?", "_", $aCachedName);
        $this->SetupCache($aCachedName, $aTimeout);

        $this->title = new Text();
        $this->title->ParagraphAlign('center');
        $this->title->SetFont(FF_DEFAULT, FS_NORMAL); //FF_FONT2, FS_BOLD
        $this->title->SetMargin(5);
        $this->title->SetAlign('center');

        $this->subtitle = new Text();
        $this->subtitle->ParagraphAlign('center');
        $this->subtitle->SetMargin(3);
        $this->subtitle->SetAlign('center');

        $this->subsubtitle = new Text();
        $this->subsubtitle->ParagraphAlign('center');
        $this->subsubtitle->SetMargin(3);
        $this->subsubtitle->SetAlign('center');

        $this->legend = new Legend();
        $this->footer = new Footer();

        // If the cached version exist just read it directly from the
        // cache, stream it back to browser and exit
        if ($aCachedName != '' && READ_CACHE && $aInline) {
            if ($this->cache->GetAndStream($this->img, $aCachedName)) {
                exit();
            }
        }

        $this->SetTickDensity(); // Normal density

        $this->tabtitle = new GraphTabTitle();

        if (!$this->isRunningClear) {
            $this->inputValues = array();
            $this->inputValues['aWidth'] = $aWidth;
            $this->inputValues['aHeight'] = $aHeight;
            $this->inputValues['aCachedName'] = $aCachedName;
            $this->inputValues['aTimeout'] = $aTimeout;
            $this->inputValues['aInline'] = $aInline;

            $theme_class = DEFAULT_THEME_CLASS;
            if (class_exists($theme_class)) {
                $this->graph_theme = new $theme_class();
            }
        }
    }

    public function InitializeFrameAndMargin()
    {
        $this->doframe = true;
        $this->frame_color = 'black';
        $this->frame_weight = 1;

        $this->titlebackground_framecolor = 'blue';
        $this->titlebackground_framestyle = 2;
        $this->titlebackground_frameweight = 1;
        $this->titlebackground_bevelheight = 3;
        $this->titlebkg_fillstyle = TITLEBKG_FILLSTYLE_SOLID;
        $this->titlebkg_scolor1 = 'black';
        $this->titlebkg_scolor2 = 'white';
        $this->framebevel = false;
        $this->framebeveldepth = 2;
        $this->framebevelborder = false;
        $this->framebevelbordercolor = 'black';
        $this->framebevelcolor1 = 'white@0.4';
        $this->framebevelcolor2 = 'black@0.4';

        $this->margin_color = array(250, 250, 250);
    }

    public function SetupCache($aFilename, $aTimeout = 60)
    {
        $this->cache_name = $aFilename;
        $this->cache->SetTimeOut($aTimeout);
    }

    // Enable final image perspective transformation
    public function Set3DPerspective($aDir = 1, $aHorizon = 100, $aSkewDist = 120, $aQuality = false, $aFillColor = '#FFFFFF', $aBorder = false, $aMinSize = true, $aHorizonPos = 0.5)
    {
        $this->iImgTrans = true;
        $this->iImgTransHorizon = $aHorizon;
        $this->iImgTransSkewDist = $aSkewDist;
        $this->iImgTransDirection = $aDir;
        $this->iImgTransMinSize = $aMinSize;
        $this->iImgTransFillColor = $aFillColor;
        $this->iImgTransHighQ = $aQuality;
        $this->iImgTransBorder = $aBorder;
        $this->iImgTransHorizonPos = $aHorizonPos;
    }

    public function SetUserFont($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->img->ttf->SetUserFont($aNormal, $aBold, $aItalic, $aBoldIt);
    }

    public function SetUserFont1($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->img->ttf->SetUserFont1($aNormal, $aBold, $aItalic, $aBoldIt);
    }

    public function SetUserFont2($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->img->ttf->SetUserFont2($aNormal, $aBold, $aItalic, $aBoldIt);
    }

    public function SetUserFont3($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->img->ttf->SetUserFont3($aNormal, $aBold, $aItalic, $aBoldIt);
    }

    // Set Image format and optional quality
    public function SetImgFormat($aFormat, $aQuality = 75)
    {
        $this->img->SetImgFormat($aFormat, $aQuality);
    }

    // Should the grid be in front or back of the plot?
    public function SetGridDepth($aDepth)
    {
        $this->grid_depth = $aDepth;
    }

    public function SetIconDepth($aDepth)
    {
        $this->iIconDepth = $aDepth;
    }

    // Specify graph angle 0-360 degrees.
    public function SetAngle($aAngle)
    {
        $this->img->SetAngle($aAngle);
    }

    public function SetAlphaBlending($aFlg = true)
    {
        $this->img->SetAlphaBlending($aFlg);
    }

    // Shortcut to image margin
    public function SetMargin($lm, $rm, $tm, $bm)
    {
        $this->img->SetMargin($lm, $rm, $tm, $bm);
    }

    public function SetY2OrderBack($aBack = true)
    {
        $this->y2orderback = $aBack;
    }

    // Rotate the graph 90 degrees and set the margin
    // when we have done a 90 degree rotation
    public function Set90AndMargin($lm = 0, $rm = 0, $tm = 0, $bm = 0)
    {
        $lm = $lm == 0 ? floor(0.2 * $this->img->width) : $lm;
        $rm = $rm == 0 ? floor(0.1 * $this->img->width) : $rm;
        $tm = $tm == 0 ? floor(0.2 * $this->img->height) : $tm;
        $bm = $bm == 0 ? floor(0.1 * $this->img->height) : $bm;

        $adj = ($this->img->height - $this->img->width) / 2;
        $this->img->SetMargin($tm - $adj, $bm - $adj, $rm + $adj, $lm + $adj);
        $this->img->SetCenter(floor($this->img->width / 2), floor($this->img->height / 2));
        $this->SetAngle(90);
        if (empty($this->yaxis) || empty($this->xaxis)) {
            JpgraphError::RaiseL(25009); //('You must specify what scale to use with a call to Graph::SetScale()');
        }
        $this->xaxis->SetLabelAlign('right', 'center');
        $this->yaxis->SetLabelAlign('center', 'bottom');
    }

    public function SetClipping($aFlg = true)
    {
        $this->iDoClipping = $aFlg;
    }

    // Add a plot object to the graph
    public function Add($aPlot)
    {
        if ($aPlot == null) {
            JpGraphError::RaiseL(25010); //("Graph::Add() You tried to add a null plot to the graph.");
        }
        if (is_array($aPlot) && count($aPlot) > 0) {
            $cl = $aPlot[0];
        } else {
            $cl = $aPlot;
        }

        if ($cl instanceof Text) {
            $this->AddText($aPlot);
        } elseif (class_exists('PlotLine', false) && ($cl instanceof PlotLine)) {
            $this->AddLine($aPlot);
        } elseif (class_exists('PlotBand', false) && ($cl instanceof PlotBand)) {
            $this->AddBand($aPlot);
        } elseif (class_exists('IconPlot', false) && ($cl instanceof IconPlot)) {
            $this->AddIcon($aPlot);
        } elseif (class_exists('GTextTable', false) && ($cl instanceof GTextTable)) {
            $this->AddTable($aPlot);
        } else {
            if (is_array($aPlot)) {
                $this->plots = array_merge($this->plots, $aPlot);
            } else {
                $this->plots[] = $aPlot;
            }
        }

        if ($this->graph_theme) {
            $this->graph_theme->SetupPlot($aPlot);
        }
    }

    public function AddTable($aTable)
    {
        if (is_array($aTable)) {
            for ($i = 0; $i < count($aTable); ++$i) {
                $this->iTables[] = $aTable[$i];
            }
        } else {
            $this->iTables[] = $aTable;
        }
    }

    public function AddIcon($aIcon)
    {
        if (is_array($aIcon)) {
            for ($i = 0; $i < count($aIcon); ++$i) {
                $this->iIcons[] = $aIcon[$i];
            }
        } else {
            $this->iIcons[] = $aIcon;
        }
    }

    // Add plot to second Y-scale
    public function AddY2($aPlot)
    {
        if ($aPlot == null) {
            JpGraphError::RaiseL(25011); //("Graph::AddY2() You tried to add a null plot to the graph.");
        }

        if (is_array($aPlot) && count($aPlot) > 0) {
            $cl = $aPlot[0];
        } else {
            $cl = $aPlot;
        }

        if ($cl instanceof Text) {
            $this->AddText($aPlot, true);
        } elseif (class_exists('PlotLine', false) && ($cl instanceof PlotLine)) {
            $this->AddLine($aPlot, true);
        } elseif (class_exists('PlotBand', false) && ($cl instanceof PlotBand)) {
            $this->AddBand($aPlot, true);
        } else {
            $this->y2plots[] = $aPlot;
        }

        if ($this->graph_theme) {
            $this->graph_theme->SetupPlot($aPlot);
        }
    }

    // Add plot to the extra Y-axises
    public function AddY($aN, $aPlot)
    {

        if ($aPlot == null) {
            JpGraphError::RaiseL(25012); //("Graph::AddYN() You tried to add a null plot to the graph.");
        }

        if (is_array($aPlot) && count($aPlot) > 0) {
            $cl = $aPlot[0];
        } else {
            $cl = $aPlot;
        }

        if (($cl instanceof Text) ||
            (class_exists('PlotLine', false) && ($cl instanceof PlotLine)) ||
            (class_exists('PlotBand', false) && ($cl instanceof PlotBand))) {
            JpGraph::RaiseL(25013); //('You can only add standard plots to multiple Y-axis');
        } else {
            $this->ynplots[$aN][] = $aPlot;
        }

        if ($this->graph_theme) {
            $this->graph_theme->SetupPlot($aPlot);
        }
    }

    // Add text object to the graph
    public function AddText($aTxt, $aToY2 = false)
    {
        if ($aTxt == null) {
            JpGraphError::RaiseL(25014); //("Graph::AddText() You tried to add a null text to the graph.");
        }
        if ($aToY2) {
            if (is_array($aTxt)) {
                for ($i = 0; $i < count($aTxt); ++$i) {
                    $this->y2texts[] = $aTxt[$i];
                }
            } else {
                $this->y2texts[] = $aTxt;
            }
        } else {
            if (is_array($aTxt)) {
                for ($i = 0; $i < count($aTxt); ++$i) {
                    $this->texts[] = $aTxt[$i];
                }
            } else {
                $this->texts[] = $aTxt;
            }
        }
    }

    // Add a line object (class PlotLine) to the graph
    public function AddLine($aLine, $aToY2 = false)
    {
        if ($aLine == null) {
            JpGraphError::RaiseL(25015); //("Graph::AddLine() You tried to add a null line to the graph.");
        }

        if ($aToY2) {
            if (is_array($aLine)) {
                for ($i = 0; $i < count($aLine); ++$i) {
                    //$this->y2lines[]=$aLine[$i];
                    $this->y2plots[] = $aLine[$i];
                }
            } else {
                //$this->y2lines[] = $aLine;
                $this->y2plots[] = $aLine;
            }
        } else {
            if (is_array($aLine)) {
                for ($i = 0; $i < count($aLine); ++$i) {
                    //$this->lines[]=$aLine[$i];
                    $this->plots[] = $aLine[$i];
                }
            } else {
                //$this->lines[] = $aLine;
                $this->plots[] = $aLine;
            }
        }
    }

    // Add vertical or horizontal band
    public function AddBand($aBand, $aToY2 = false)
    {
        if ($aBand == null) {
            JpGraphError::RaiseL(25016); //(" Graph::AddBand() You tried to add a null band to the graph.");
        }

        if ($aToY2) {
            if (is_array($aBand)) {
                for ($i = 0; $i < count($aBand); ++$i) {
                    $this->y2bands[] = $aBand[$i];
                }
            } else {
                $this->y2bands[] = $aBand;
            }
        } else {
            if (is_array($aBand)) {
                for ($i = 0; $i < count($aBand); ++$i) {
                    $this->bands[] = $aBand[$i];
                }
            } else {
                $this->bands[] = $aBand;
            }
        }
    }

    public function SetPlotGradient($aFrom = 'navy', $aTo = 'silver', $aGradType = 2)
    {
        $this->plot_gradtype = $aGradType;
        $this->plot_gradfrom = $aFrom;
        $this->plot_gradto = $aTo;
    }

    public function SetBackgroundGradient($aFrom = 'navy', $aTo = 'silver', $aGradType = 2, $aStyle = BGRAD_FRAME)
    {
        $this->bkg_gradtype = $aGradType;
        $this->bkg_gradstyle = $aStyle;
        $this->bkg_gradfrom = $aFrom;
        $this->bkg_gradto = $aTo;
    }

    // Set a country flag in the background
    public function SetBackgroundCFlag($aName, $aBgType = BGIMG_FILLPLOT, $aMix = 100)
    {
        $this->background_cflag = $aName;
        $this->background_cflag_type = $aBgType;
        $this->background_cflag_mix = $aMix;
    }

    // Alias for the above method
    public function SetBackgroundCountryFlag($aName, $aBgType = BGIMG_FILLPLOT, $aMix = 100)
    {
        $this->background_cflag = $aName;
        $this->background_cflag_type = $aBgType;
        $this->background_cflag_mix = $aMix;
    }

    // Specify a background image
    public function SetBackgroundImage($aFileName, $aBgType = BGIMG_FILLPLOT, $aImgFormat = 'auto')
    {

        // Get extension to determine image type
        if ($aImgFormat == 'auto') {
            $e = explode('.', $aFileName);
            if (!$e) {
                JpGraphError::RaiseL(25018, $aFileName); //('Incorrect file name for Graph::SetBackgroundImage() : '.$aFileName.' Must have a valid image extension (jpg,gif,png) when using autodetection of image type');
            }

            $valid_formats = array('png', 'jpg', 'gif');
            $aImgFormat = strtolower($e[count($e) - 1]);
            if ($aImgFormat == 'jpeg') {
                $aImgFormat = 'jpg';
            } elseif (!in_array($aImgFormat, $valid_formats)) {
                JpGraphError::RaiseL(25019, $aImgFormat); //('Unknown file extension ($aImgFormat) in Graph::SetBackgroundImage() for filename: '.$aFileName);
            }
        }

        $this->background_image = $aFileName;
        $this->background_image_type = $aBgType;
        $this->background_image_format = $aImgFormat;
    }

    public function SetBackgroundImageMix($aMix)
    {
        $this->background_image_mix = $aMix;
    }

    // Adjust background image position
    public function SetBackgroundImagePos($aXpos, $aYpos)
    {
        $this->background_image_xpos = $aXpos;
        $this->background_image_ypos = $aYpos;
    }

    // Specify axis style (boxed or single)
    public function SetAxisStyle($aStyle)
    {
        $this->iAxisStyle = $aStyle;
    }

    // Set a frame around the plot area
    public function SetBox($aDrawPlotFrame = true, $aPlotFrameColor = array(0, 0, 0), $aPlotFrameWeight = 1)
    {
        $this->boxed = $aDrawPlotFrame;
        $this->box_weight = $aPlotFrameWeight;
        $this->box_color = $aPlotFrameColor;
    }

    // Specify color for the plotarea (not the margins)
    public function SetColor($aColor)
    {
        $this->plotarea_color = $aColor;
    }

    // Specify color for the margins (all areas outside the plotarea)
    public function SetMarginColor($aColor)
    {
        $this->margin_color = $aColor;
    }

    // Set a frame around the entire image
    public function SetFrame($aDrawImgFrame = true, $aImgFrameColor = array(0, 0, 0), $aImgFrameWeight = 1)
    {
        $this->doframe = $aDrawImgFrame;
        $this->frame_color = $aImgFrameColor;
        $this->frame_weight = $aImgFrameWeight;
    }

    public function SetFrameBevel($aDepth = 3, $aBorder = false, $aBorderColor = 'black', $aColor1 = 'white@0.4', $aColor2 = 'darkgray@0.4', $aFlg = true)
    {
        $this->framebevel = $aFlg;
        $this->framebeveldepth = $aDepth;
        $this->framebevelborder = $aBorder;
        $this->framebevelbordercolor = $aBorderColor;
        $this->framebevelcolor1 = $aColor1;
        $this->framebevelcolor2 = $aColor2;

        $this->doshadow = false;
    }

    // Set the shadow around the whole image
    public function SetShadow($aShowShadow = true, $aShadowWidth = 5, $aShadowColor = 'darkgray')
    {
        $this->doshadow = $aShowShadow;
        $this->shadow_color = $aShadowColor;
        $this->shadow_width = $aShadowWidth;
        $this->footer->iBottomMargin += $aShadowWidth;
        $this->footer->iRightMargin += $aShadowWidth;
    }

    // Specify x,y scale. Note that if you manually specify the scale
    // you must also specify the tick distance with a call to Ticks::Set()
    public function SetScale($aAxisType, $aYMin = 1, $aYMax = 1, $aXMin = 1, $aXMax = 1)
    {
        $this->axtype = $aAxisType;

        if ($aYMax < $aYMin || $aXMax < $aXMin) {
            JpGraphError::RaiseL(25020); //('Graph::SetScale(): Specified Max value must be larger than the specified Min value.');
        }

        $yt = substr($aAxisType, -3, 3);
        if ($yt == 'lin') {
            $this->yscale = new LinearScale($aYMin, $aYMax);
        } elseif ($yt == 'int') {
            $this->yscale = new LinearScale($aYMin, $aYMax);
            $this->yscale->SetIntScale();
        } elseif ($yt == 'log') {
            $this->yscale = new LogScale($aYMin, $aYMax);
        } else {
            JpGraphError::RaiseL(25021, $aAxisType); //("Unknown scale specification for Y-scale. ($aAxisType)");
        }

        $xt = substr($aAxisType, 0, 3);
        if ($xt == 'lin' || $xt == 'tex') {
            $this->xscale = new LinearScale($aXMin, $aXMax, 'x');
            $this->xscale->textscale = ($xt == 'tex');
        } elseif ($xt == 'int') {
            $this->xscale = new LinearScale($aXMin, $aXMax, 'x');
            $this->xscale->SetIntScale();
        } elseif ($xt == 'dat') {
            $this->xscale = new DateScale($aXMin, $aXMax, 'x');
        } elseif ($xt == 'log') {
            $this->xscale = new LogScale($aXMin, $aXMax, 'x');
        } else {
            JpGraphError::RaiseL(25022, $aAxisType); //(" Unknown scale specification for X-scale. ($aAxisType)");
        }

        $this->xaxis = new Axis($this->img, $this->xscale);
        $this->yaxis = new Axis($this->img, $this->yscale);
        $this->xgrid = new Grid($this->xaxis);
        $this->ygrid = new Grid($this->yaxis);
        $this->ygrid->Show();

        if (!$this->isRunningClear) {
            $this->inputValues['aAxisType'] = $aAxisType;
            $this->inputValues['aYMin'] = $aYMin;
            $this->inputValues['aYMax'] = $aYMax;
            $this->inputValues['aXMin'] = $aXMin;
            $this->inputValues['aXMax'] = $aXMax;

            if ($this->graph_theme) {
                $this->graph_theme->ApplyGraph($this);
            }
        }

        $this->isAfterSetScale = true;
    }

    // Specify secondary Y scale
    public function SetY2Scale($aAxisType = 'lin', $aY2Min = 1, $aY2Max = 1)
    {
        if ($aAxisType == 'lin') {
            $this->y2scale = new LinearScale($aY2Min, $aY2Max);
        } elseif ($aAxisType == 'int') {
            $this->y2scale = new LinearScale($aY2Min, $aY2Max);
            $this->y2scale->SetIntScale();
        } elseif ($aAxisType == 'log') {
            $this->y2scale = new LogScale($aY2Min, $aY2Max);
        } else {
            JpGraphError::RaiseL(25023, $aAxisType); //("JpGraph: Unsupported Y2 axis type: $aAxisType\nMust be one of (lin,log,int)");
        }

        $this->y2axis = new Axis($this->img, $this->y2scale);
        $this->y2axis->scale->ticks->SetDirection(SIDE_LEFT);
        $this->y2axis->SetLabelSide(SIDE_RIGHT);
        $this->y2axis->SetPos('max');
        $this->y2axis->SetTitleSide(SIDE_RIGHT);

        // Deafult position is the max x-value
        $this->y2grid = new Grid($this->y2axis);

        if ($this->graph_theme) {
            $this->graph_theme->ApplyGraph($this);
        }
    }

    // Set the delta position (in pixels) between the multiple Y-axis
    public function SetYDeltaDist($aDist)
    {
        $this->iYAxisDeltaPos = $aDist;
    }

    // Specify secondary Y scale
    public function SetYScale($aN, $aAxisType = "lin", $aYMin = 1, $aYMax = 1)
    {

        if ($aAxisType == 'lin') {
            $this->ynscale[$aN] = new LinearScale($aYMin, $aYMax);
        } elseif ($aAxisType == 'int') {
            $this->ynscale[$aN] = new LinearScale($aYMin, $aYMax);
            $this->ynscale[$aN]->SetIntScale();
        } elseif ($aAxisType == 'log') {
            $this->ynscale[$aN] = new LogScale($aYMin, $aYMax);
        } else {
            JpGraphError::RaiseL(25024, $aAxisType); //("JpGraph: Unsupported Y axis type: $aAxisType\nMust be one of (lin,log,int)");
        }

        $this->ynaxis[$aN] = new Axis($this->img, $this->ynscale[$aN]);
        $this->ynaxis[$aN]->scale->ticks->SetDirection(SIDE_LEFT);
        $this->ynaxis[$aN]->SetLabelSide(SIDE_RIGHT);

        if ($this->graph_theme) {
            $this->graph_theme->ApplyGraph($this);
        }
    }

    // Specify density of ticks when autoscaling 'normal', 'dense', 'sparse', 'verysparse'
    // The dividing factor have been determined heuristically according to my aesthetic
    // sense (or lack off) y.m.m.v !
    public function SetTickDensity($aYDensity = TICKD_NORMAL, $aXDensity = TICKD_NORMAL)
    {
        $this->xtick_factor = 30;
        $this->ytick_factor = 25;
        switch ($aYDensity) {
            case TICKD_DENSE:
                $this->ytick_factor = 12;
                break;
            case TICKD_NORMAL:
                $this->ytick_factor = 25;
                break;
            case TICKD_SPARSE:
                $this->ytick_factor = 40;
                break;
            case TICKD_VERYSPARSE:
                $this->ytick_factor = 100;
                break;
            default:
                JpGraphError::RaiseL(25025, $densy); //("JpGraph: Unsupported Tick density: $densy");
        }
        switch ($aXDensity) {
            case TICKD_DENSE:
                $this->xtick_factor = 15;
                break;
            case TICKD_NORMAL:
                $this->xtick_factor = 30;
                break;
            case TICKD_SPARSE:
                $this->xtick_factor = 45;
                break;
            case TICKD_VERYSPARSE:
                $this->xtick_factor = 60;
                break;
            default:
                JpGraphError::RaiseL(25025, $densx); //("JpGraph: Unsupported Tick density: $densx");
        }
    }

    // Get a string of all image map areas
    public function GetCSIMareas()
    {
        if (!$this->iHasStroked) {
            $this->Stroke(_CSIM_SPECIALFILE);
        }

        $csim = $this->title->GetCSIMAreas();
        $csim .= $this->subtitle->GetCSIMAreas();
        $csim .= $this->subsubtitle->GetCSIMAreas();
        $csim .= $this->legend->GetCSIMAreas();

        if ($this->y2axis != null) {
            $csim .= $this->y2axis->title->GetCSIMAreas();
        }

        if ($this->texts != null) {
            $n = count($this->texts);
            for ($i = 0; $i < $n; ++$i) {
                $csim .= $this->texts[$i]->GetCSIMAreas();
            }
        }

        if ($this->y2texts != null && $this->y2scale != null) {
            $n = count($this->y2texts);
            for ($i = 0; $i < $n; ++$i) {
                $csim .= $this->y2texts[$i]->GetCSIMAreas();
            }
        }

        if ($this->yaxis != null && $this->xaxis != null) {
            $csim .= $this->yaxis->title->GetCSIMAreas();
            $csim .= $this->xaxis->title->GetCSIMAreas();
        }

        $n = count($this->plots);
        for ($i = 0; $i < $n; ++$i) {
            $csim .= $this->plots[$i]->GetCSIMareas();
        }

        $n = count($this->y2plots);
        for ($i = 0; $i < $n; ++$i) {
            $csim .= $this->y2plots[$i]->GetCSIMareas();
        }

        $n = count($this->ynaxis);
        for ($i = 0; $i < $n; ++$i) {
            $m = count($this->ynplots[$i]);
            for ($j = 0; $j < $m; ++$j) {
                $csim .= $this->ynplots[$i][$j]->GetCSIMareas();
            }
        }

        $n = count($this->iTables);
        for ($i = 0; $i < $n; ++$i) {
            $csim .= $this->iTables[$i]->GetCSIMareas();
        }

        return $csim;
    }

    // Get a complete <MAP>..</MAP> tag for the final image map
    public function GetHTMLImageMap($aMapName)
    {
        $im = "<map name=\"$aMapName\" id=\"$aMapName\" >\n";
        $im .= $this->GetCSIMareas();
        $im .= "</map>";
        return $im;
    }

    public function CheckCSIMCache($aCacheName, $aTimeOut = 60)
    {
        global $_SERVER;

        if ($aCacheName == 'auto') {
            $aCacheName = basename($_SERVER['PHP_SELF']);
        }

        $urlarg = $this->GetURLArguments();
        $this->csimcachename = CSIMCACHE_DIR . $aCacheName . $urlarg;
        $this->csimcachetimeout = $aTimeOut;

        // First determine if we need to check for a cached version
        // This differs from the standard cache in the sense that the
        // image and CSIM map HTML file is written relative to the directory
        // the script executes in and not the specified cache directory.
        // The reason for this is that the cache directory is not necessarily
        // accessible from the HTTP server.
        if ($this->csimcachename != '') {
            $dir = dirname($this->csimcachename);
            $base = basename($this->csimcachename);
            $base = strtok($base, '.');
            $suffix = strtok('.');
            $basecsim = $dir . '/' . $base . '?' . $urlarg . '_csim_.html';
            $baseimg = $dir . '/' . $base . '?' . $urlarg . '.' . $this->img->img_format;

            $timedout = false;
            // Does it exist at all ?

            if (file_exists($basecsim) && file_exists($baseimg)) {
                // Check that it hasn't timed out
                $diff = time() - filemtime($basecsim);
                if ($this->csimcachetimeout > 0 && ($diff > $this->csimcachetimeout * 60)) {
                    $timedout = true;
                    @unlink($basecsim);
                    @unlink($baseimg);
                } else {
                    if ($fh = @fopen($basecsim, "r")) {
                        fpassthru($fh);
                        return true;
                    } else {
                        JpGraphError::RaiseL(25027, $basecsim); //(" Can't open cached CSIM \"$basecsim\" for reading.");
                    }
                }
            }
        }
        return false;
    }

    // Build the argument string to be used with the csim images
    public static function GetURLArguments($aAddRecursiveBlocker = false)
    {

        if ($aAddRecursiveBlocker) {
            // This is a JPGRAPH internal defined that prevents
            // us from recursively coming here again
            $urlarg = _CSIM_DISPLAY . '=1';
        }

        // Now reconstruct any user URL argument
        reset($_GET);
        while (list($key, $value) = each($_GET)) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $urlarg .= '&amp;' . $key . '%5B' . $k . '%5D=' . urlencode($v);
                }
            } else {
                $urlarg .= '&amp;' . $key . '=' . urlencode($value);
            }
        }

        // It's not ideal to convert POST argument to GET arguments
        // but there is little else we can do. One idea for the
        // future might be recreate the POST header in case.
        reset($_POST);
        while (list($key, $value) = each($_POST)) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $urlarg .= '&amp;' . $key . '%5B' . $k . '%5D=' . urlencode($v);
                }
            } else {
                $urlarg .= '&amp;' . $key . '=' . urlencode($value);
            }
        }

        return $urlarg;
    }

    public function SetCSIMImgAlt($aAlt)
    {
        $this->iCSIMImgAlt = $aAlt;
    }

    public function StrokeCSIM($aScriptName = 'auto', $aCSIMName = '', $aBorder = 0)
    {
        if ($aCSIMName == '') {
            // create a random map name
            srand((double) microtime() * 1000000);
            $r = rand(0, 100000);
            $aCSIMName = '__mapname' . $r . '__';
        }

        if ($aScriptName == 'auto') {
            $aScriptName = basename($_SERVER['PHP_SELF']);
        }

        $urlarg = $this->GetURLArguments(true);

        if (empty($_GET[_CSIM_DISPLAY])) {
            // First determine if we need to check for a cached version
            // This differs from the standard cache in the sense that the
            // image and CSIM map HTML file is written relative to the directory
            // the script executes in and not the specified cache directory.
            // The reason for this is that the cache directory is not necessarily
            // accessible from the HTTP server.
            if ($this->csimcachename != '') {
                $dir = dirname($this->csimcachename);
                $base = basename($this->csimcachename);
                $base = strtok($base, '.');
                $suffix = strtok('.');
                $basecsim = $dir . '/' . $base . '?' . $urlarg . '_csim_.html';
                $baseimg = $base . '?' . $urlarg . '.' . $this->img->img_format;

                // Check that apache can write to directory specified

                if (file_exists($dir) && !is_writeable($dir)) {
                    JpgraphError::RaiseL(25028, $dir); //('Apache/PHP does not have permission to write to the CSIM cache directory ('.$dir.'). Check permissions.');
                }

                // Make sure directory exists
                $this->cache->MakeDirs($dir);

                // Write the image file
                $this->Stroke(CSIMCACHE_DIR . $baseimg);

                // Construct wrapper HTML and write to file and send it back to browser

                // In the src URL we must replace the '?' with its encoding to prevent the arguments
                // to be converted to real arguments.
                $tmp = str_replace('?', '%3f', $baseimg);
                $htmlwrap = $this->GetHTMLImageMap($aCSIMName) . "\n" .
                '<img src="' . CSIMCACHE_HTTP_DIR . $tmp . '" ismap="ismap" usemap="#' . $aCSIMName . ' width="' . $this->img->width . '" height="' . $this->img->height . "\" alt=\"" . $this->iCSIMImgAlt . "\" />\n";

                if ($fh = @fopen($basecsim, 'w')) {
                    fwrite($fh, $htmlwrap);
                    fclose($fh);
                    echo $htmlwrap;
                } else {
                    JpGraphError::RaiseL(25029, $basecsim); //(" Can't write CSIM \"$basecsim\" for writing. Check free space and permissions.");
                }
            } else {

                if ($aScriptName == '') {
                    JpGraphError::RaiseL(25030); //('Missing script name in call to StrokeCSIM(). You must specify the name of the actual image script as the first parameter to StrokeCSIM().');
                }
                echo $this->GetHTMLImageMap($aCSIMName) . $this->GetCSIMImgHTML($aCSIMName, $aScriptName, $aBorder);
            }
        } else {
            $this->Stroke();
        }
    }

    public function StrokeCSIMImage()
    {
        if (@$_GET[_CSIM_DISPLAY] == 1) {
            $this->Stroke();
        }
    }

    public function GetCSIMImgHTML($aCSIMName, $aScriptName = 'auto', $aBorder = 0)
    {
        if ($aScriptName == 'auto') {
            $aScriptName = basename($_SERVER['PHP_SELF']);
        }
        $urlarg = $this->GetURLArguments(true);
        return "<img src=\"" . $aScriptName . '?' . $urlarg . "\" ismap=\"ismap\" usemap=\"#" . $aCSIMName . '" height="' . $this->img->height . "\" alt=\"" . $this->iCSIMImgAlt . "\" />\n";
    }

    public function GetTextsYMinMax($aY2 = false)
    {
        if ($aY2) {
            $txts = $this->y2texts;
        } else {
            $txts = $this->texts;
        }
        $n = count($txts);
        $min = null;
        $max = null;
        for ($i = 0; $i < $n; ++$i) {
            if ($txts[$i]->iScalePosY !== null && $txts[$i]->iScalePosX !== null) {
                if ($min === null) {
                    $min = $max = $txts[$i]->iScalePosY;
                } else {
                    $min = min($min, $txts[$i]->iScalePosY);
                    $max = max($max, $txts[$i]->iScalePosY);
                }
            }
        }
        if ($min !== null) {
            return array($min, $max);
        } else {
            return null;
        }
    }

    public function GetTextsXMinMax($aY2 = false)
    {
        if ($aY2) {
            $txts = $this->y2texts;
        } else {
            $txts = $this->texts;
        }
        $n = count($txts);
        $min = null;
        $max = null;
        for ($i = 0; $i < $n; ++$i) {
            if ($txts[$i]->iScalePosY !== null && $txts[$i]->iScalePosX !== null) {
                if ($min === null) {
                    $min = $max = $txts[$i]->iScalePosX;
                } else {
                    $min = min($min, $txts[$i]->iScalePosX);
                    $max = max($max, $txts[$i]->iScalePosX);
                }
            }
        }
        if ($min !== null) {
            return array($min, $max);
        } else {
            return null;
        }
    }

    public function GetXMinMax()
    {

        list($min, $ymin) = $this->plots[0]->Min();
        list($max, $ymax) = $this->plots[0]->Max();

        $i = 0;
        // Some plots, e.g. PlotLine should not affect the scale
        // and will return (null,null). We should ignore those
        // values.
        while (($min === null || $max === null) && ($i < count($this->plots) - 1)) {
            ++$i;
            list($min, $ymin) = $this->plots[$i]->Min();
            list($max, $ymax) = $this->plots[$i]->Max();
        }

        foreach ($this->plots as $p) {
            list($xmin, $ymin) = $p->Min();
            list($xmax, $ymax) = $p->Max();

            if ($xmin !== null && $xmax !== null) {
                $min = Min($xmin, $min);
                $max = Max($xmax, $max);
            }
        }

        if ($this->y2axis != null) {
            foreach ($this->y2plots as $p) {
                list($xmin, $ymin) = $p->Min();
                list($xmax, $ymax) = $p->Max();
                $min = Min($xmin, $min);
                $max = Max($xmax, $max);
            }
        }

        $n = count($this->ynaxis);
        for ($i = 0; $i < $n; ++$i) {
            if ($this->ynaxis[$i] != null) {
                foreach ($this->ynplots[$i] as $p) {
                    list($xmin, $ymin) = $p->Min();
                    list($xmax, $ymax) = $p->Max();
                    $min = Min($xmin, $min);
                    $max = Max($xmax, $max);
                }
            }
        }
        return array($min, $max);
    }

    public function AdjustMarginsForTitles()
    {
        $totrequired =
        ($this->title->t != ''
            ? $this->title->GetTextHeight($this->img) + $this->title->margin + 5 * SUPERSAMPLING_SCALE
            : 0) +
        ($this->subtitle->t != ''
            ? $this->subtitle->GetTextHeight($this->img) + $this->subtitle->margin + 5 * SUPERSAMPLING_SCALE
            : 0) +
        ($this->subsubtitle->t != ''
            ? $this->subsubtitle->GetTextHeight($this->img) + $this->subsubtitle->margin + 5 * SUPERSAMPLING_SCALE
            : 0);

        $btotrequired = 0;
        if ($this->xaxis != null && !$this->xaxis->hide && !$this->xaxis->hide_labels) {
            // Minimum bottom margin
            if ($this->xaxis->title->t != '') {
                if ($this->img->a == 90) {
                    $btotrequired = $this->yaxis->title->GetTextHeight($this->img) + 7;
                } else {
                    $btotrequired = $this->xaxis->title->GetTextHeight($this->img) + 7;
                }
            } else {
                $btotrequired = 0;
            }

            if ($this->img->a == 90) {
                $this->img->SetFont($this->yaxis->font_family, $this->yaxis->font_style,
                    $this->yaxis->font_size);
                $lh = $this->img->GetTextHeight('Mg', $this->yaxis->label_angle);
            } else {
                $this->img->SetFont($this->xaxis->font_family, $this->xaxis->font_style,
                    $this->xaxis->font_size);
                $lh = $this->img->GetTextHeight('Mg', $this->xaxis->label_angle);
            }

            $btotrequired += $lh + 6;
        }

        if ($this->img->a == 90) {
            // DO Nothing. It gets too messy to do this properly for 90 deg...
        } else {
            // need more top margin
            if ($this->img->top_margin < $totrequired) {
                $this->SetMargin(
                    $this->img->raw_left_margin,
                    $this->img->raw_right_margin,
                    $totrequired / SUPERSAMPLING_SCALE,
                    $this->img->raw_bottom_margin
                );
            }

            // need more bottom margin
            if ($this->img->bottom_margin < $btotrequired) {
                $this->SetMargin(
                    $this->img->raw_left_margin,
                    $this->img->raw_right_margin,
                    $this->img->raw_top_margin,
                    $btotrequired / SUPERSAMPLING_SCALE
                );
            }
        }
    }

    public function StrokeStore($aStrokeFileName)
    {
        // Get the handler to prevent the library from sending the
        // image to the browser
        $ih = $this->Stroke(_IMG_HANDLER);

        // Stroke it to a file
        $this->img->Stream($aStrokeFileName);

        // Send it back to browser
        $this->img->Headers();
        $this->img->Stream();
    }

    public function doAutoscaleXAxis()
    {
        //Check if we should autoscale x-axis
        if (!$this->xscale->IsSpecified()) {
            if (substr($this->axtype, 0, 4) == "text") {
                $max = 0;
                $n = count($this->plots);
                for ($i = 0; $i < $n; ++$i) {
                    $p = $this->plots[$i];
                    // We need some unfortunate sub class knowledge here in order
                    // to increase number of data points in case it is a line plot
                    // which has the barcenter set. If not it could mean that the
                    // last point of the data is outside the scale since the barcenter
                    // settings means that we will shift the entire plot half a tick step
                    // to the right in oder to align with the center of the bars.
                    if (class_exists('BarPlot', false)) {
                        $cl = strtolower(get_class($p));
                        if ((class_exists('BarPlot', false) && ($p instanceof BarPlot)) || empty($p->barcenter)) {
                            $max = max($max, $p->numpoints - 1);
                        } else {
                            $max = max($max, $p->numpoints);
                        }
                    } else {
                        if (empty($p->barcenter)) {
                            $max = max($max, $p->numpoints - 1);
                        } else {
                            $max = max($max, $p->numpoints);
                        }
                    }
                }
                $min = 0;
                if ($this->y2axis != null) {
                    foreach ($this->y2plots as $p) {
                        $max = max($max, $p->numpoints - 1);
                    }
                }
                $n = count($this->ynaxis);
                for ($i = 0; $i < $n; ++$i) {
                    if ($this->ynaxis[$i] != null) {
                        foreach ($this->ynplots[$i] as $p) {
                            $max = max($max, $p->numpoints - 1);
                        }
                    }
                }

                $this->xscale->Update($this->img, $min, $max);
                $this->xscale->ticks->Set($this->xaxis->tick_step, 1);
                $this->xscale->ticks->SupressMinorTickMarks();
            } else {
                list($min, $max) = $this->GetXMinMax();

                $lres = $this->GetLinesXMinMax($this->lines);
                if ($lres) {
                    list($linmin, $linmax) = $lres;
                    $min = min($min, $linmin);
                    $max = max($max, $linmax);
                }

                $lres = $this->GetLinesXMinMax($this->y2lines);
                if ($lres) {
                    list($linmin, $linmax) = $lres;
                    $min = min($min, $linmin);
                    $max = max($max, $linmax);
                }

                $tres = $this->GetTextsXMinMax();
                if ($tres) {
                    list($tmin, $tmax) = $tres;
                    $min = min($min, $tmin);
                    $max = max($max, $tmax);
                }

                $tres = $this->GetTextsXMinMax(true);
                if ($tres) {
                    list($tmin, $tmax) = $tres;
                    $min = min($min, $tmin);
                    $max = max($max, $tmax);
                }

                $this->xscale->AutoScale($this->img, $min, $max, round($this->img->plotwidth / $this->xtick_factor));
            }

            //Adjust position of y-axis and y2-axis to minimum/maximum of x-scale
            if (!is_numeric($this->yaxis->pos) && !is_string($this->yaxis->pos)) {
                $this->yaxis->SetPos($this->xscale->GetMinVal());
            }
        } elseif ($this->xscale->IsSpecified() &&
            ($this->xscale->auto_ticks || !$this->xscale->ticks->IsSpecified())) {
            // The tick calculation will use the user suplied min/max values to determine
            // the ticks. If auto_ticks is false the exact user specifed min and max
            // values will be used for the scale.
            // If auto_ticks is true then the scale might be slightly adjusted
            // so that the min and max values falls on an even major step.
            $min = $this->xscale->scale[0];
            $max = $this->xscale->scale[1];
            $this->xscale->AutoScale($this->img, $min, $max, round($this->img->plotwidth / $this->xtick_factor), false);

            // Now make sure we show enough precision to accurate display the
            // labels. If this is not done then the user might end up with
            // a scale that might actually start with, say 13.5, butdue to rounding
            // the scale label will ony show 14.
            if (abs(floor($min) - $min) > 0) {

                // If the user has set a format then we bail out
                if ($this->xscale->ticks->label_formatstr == '' && $this->xscale->ticks->label_dateformatstr == '') {
                    $this->xscale->ticks->precision = abs(floor(log10(abs(floor($min) - $min)))) + 1;
                }
            }
        }

        // Position the optional Y2 and Yn axis to the rightmost position of the x-axis
        if ($this->y2axis != null) {
            if (!is_numeric($this->y2axis->pos) && !is_string($this->y2axis->pos)) {
                $this->y2axis->SetPos($this->xscale->GetMaxVal());
            }
            $this->y2axis->SetTitleSide(SIDE_RIGHT);
        }

        $n = count($this->ynaxis);
        $nY2adj = $this->y2axis != null ? $this->iYAxisDeltaPos : 0;
        for ($i = 0; $i < $n; ++$i) {
            if ($this->ynaxis[$i] != null) {
                if (!is_numeric($this->ynaxis[$i]->pos) && !is_string($this->ynaxis[$i]->pos)) {
                    $this->ynaxis[$i]->SetPos($this->xscale->GetMaxVal());
                    $this->ynaxis[$i]->SetPosAbsDelta($i * $this->iYAxisDeltaPos + $nY2adj);
                }
                $this->ynaxis[$i]->SetTitleSide(SIDE_RIGHT);
            }
        }
    }

    public function doAutoScaleYnAxis()
    {

        if ($this->y2scale != null) {
            if (!$this->y2scale->IsSpecified() && count($this->y2plots) > 0) {
                list($min, $max) = $this->GetPlotsYMinMax($this->y2plots);

                $lres = $this->GetLinesYMinMax($this->y2lines);
                if (is_array($lres)) {
                    list($linmin, $linmax) = $lres;
                    $min = min($min, $linmin);
                    $max = max($max, $linmax);
                }
                $tres = $this->GetTextsYMinMax(true);
                if (is_array($tres)) {
                    list($tmin, $tmax) = $tres;
                    $min = min($min, $tmin);
                    $max = max($max, $tmax);
                }
                $this->y2scale->AutoScale($this->img, $min, $max, $this->img->plotheight / $this->ytick_factor);
            } elseif ($this->y2scale->IsSpecified() && ($this->y2scale->auto_ticks || !$this->y2scale->ticks->IsSpecified())) {
                // The tick calculation will use the user suplied min/max values to determine
                // the ticks. If auto_ticks is false the exact user specifed min and max
                // values will be used for the scale.
                // If auto_ticks is true then the scale might be slightly adjusted
                // so that the min and max values falls on an even major step.
                $min = $this->y2scale->scale[0];
                $max = $this->y2scale->scale[1];
                $this->y2scale->AutoScale($this->img, $min, $max,
                    $this->img->plotheight / $this->ytick_factor,
                    $this->y2scale->auto_ticks);

                // Now make sure we show enough precision to accurate display the
                // labels. If this is not done then the user might end up with
                // a scale that might actually start with, say 13.5, butdue to rounding
                // the scale label will ony show 14.
                if (abs(floor($min) - $min) > 0) {
                    // If the user has set a format then we bail out
                    if ($this->y2scale->ticks->label_formatstr == '' && $this->y2scale->ticks->label_dateformatstr == '') {
                        $this->y2scale->ticks->precision = abs(floor(log10(abs(floor($min) - $min)))) + 1;
                    }
                }

            }
        }

        //
        // Autoscale the extra Y-axises
        //
        $n = count($this->ynaxis);
        for ($i = 0; $i < $n; ++$i) {
            if ($this->ynscale[$i] != null) {
                if (!$this->ynscale[$i]->IsSpecified() && count($this->ynplots[$i]) > 0) {
                    list($min, $max) = $this->GetPlotsYMinMax($this->ynplots[$i]);
                    $this->ynscale[$i]->AutoScale($this->img, $min, $max, $this->img->plotheight / $this->ytick_factor);
                } elseif ($this->ynscale[$i]->IsSpecified() && ($this->ynscale[$i]->auto_ticks || !$this->ynscale[$i]->ticks->IsSpecified())) {
                    // The tick calculation will use the user suplied min/max values to determine
                    // the ticks. If auto_ticks is false the exact user specifed min and max
                    // values will be used for the scale.
                    // If auto_ticks is true then the scale might be slightly adjusted
                    // so that the min and max values falls on an even major step.
                    $min = $this->ynscale[$i]->scale[0];
                    $max = $this->ynscale[$i]->scale[1];
                    $this->ynscale[$i]->AutoScale($this->img, $min, $max,
                        $this->img->plotheight / $this->ytick_factor,
                        $this->ynscale[$i]->auto_ticks);

                    // Now make sure we show enough precision to accurate display the
                    // labels. If this is not done then the user might end up with
                    // a scale that might actually start with, say 13.5, butdue to rounding
                    // the scale label will ony show 14.
                    if (abs(floor($min) - $min) > 0) {
                        // If the user has set a format then we bail out
                        if ($this->ynscale[$i]->ticks->label_formatstr == '' && $this->ynscale[$i]->ticks->label_dateformatstr == '') {
                            $this->ynscale[$i]->ticks->precision = abs(floor(log10(abs(floor($min) - $min)))) + 1;
                        }
                    }
                }
            }
        }
    }

    public function doAutoScaleYAxis()
    {

        //Check if we should autoscale y-axis
        if (!$this->yscale->IsSpecified() && count($this->plots) > 0) {
            list($min, $max) = $this->GetPlotsYMinMax($this->plots);
            $lres = $this->GetLinesYMinMax($this->lines);
            if (is_array($lres)) {
                list($linmin, $linmax) = $lres;
                $min = min($min, $linmin);
                $max = max($max, $linmax);
            }
            $tres = $this->GetTextsYMinMax();
            if (is_array($tres)) {
                list($tmin, $tmax) = $tres;
                $min = min($min, $tmin);
                $max = max($max, $tmax);
            }
            $this->yscale->AutoScale($this->img, $min, $max,
                $this->img->plotheight / $this->ytick_factor);
        } elseif ($this->yscale->IsSpecified() && ($this->yscale->auto_ticks || !$this->yscale->ticks->IsSpecified())) {
            // The tick calculation will use the user suplied min/max values to determine
            // the ticks. If auto_ticks is false the exact user specifed min and max
            // values will be used for the scale.
            // If auto_ticks is true then the scale might be slightly adjusted
            // so that the min and max values falls on an even major step.
            $min = $this->yscale->scale[0];
            $max = $this->yscale->scale[1];
            $this->yscale->AutoScale($this->img, $min, $max,
                $this->img->plotheight / $this->ytick_factor,
                $this->yscale->auto_ticks);

            // Now make sure we show enough precision to accurate display the
            // labels. If this is not done then the user might end up with
            // a scale that might actually start with, say 13.5, butdue to rounding
            // the scale label will ony show 14.
            if (abs(floor($min) - $min) > 0) {

                // If the user has set a format then we bail out
                if ($this->yscale->ticks->label_formatstr == '' && $this->yscale->ticks->label_dateformatstr == '') {
                    $this->yscale->ticks->precision = abs(floor(log10(abs(floor($min) - $min)))) + 1;
                }
            }
        }

    }

    public function InitScaleConstants()
    {
        // Setup scale constants
        if ($this->yscale) {
            $this->yscale->InitConstants($this->img);
        }

        if ($this->xscale) {
            $this->xscale->InitConstants($this->img);
        }

        if ($this->y2scale) {
            $this->y2scale->InitConstants($this->img);
        }

        $n = count($this->ynscale);
        for ($i = 0; $i < $n; ++$i) {
            if ($this->ynscale[$i]) {
                $this->ynscale[$i]->InitConstants($this->img);
            }
        }
    }

    public function doPrestrokeAdjustments()
    {

        // Do any pre-stroke adjustment that is needed by the different plot types
        // (i.e bar plots want's to add an offset to the x-labels etc)
        for ($i = 0; $i < count($this->plots); ++$i) {
            $this->plots[$i]->PreStrokeAdjust($this);
            $this->plots[$i]->DoLegend($this);
        }

        // Any plots on the second Y scale?
        if ($this->y2scale != null) {
            for ($i = 0; $i < count($this->y2plots); ++$i) {
                $this->y2plots[$i]->PreStrokeAdjust($this);
                $this->y2plots[$i]->DoLegend($this);
            }
        }

        // Any plots on the extra Y axises?
        $n = count($this->ynaxis);
        for ($i = 0; $i < $n; ++$i) {
            if ($this->ynplots == null || $this->ynplots[$i] == null) {
                JpGraphError::RaiseL(25032, $i); //("No plots for Y-axis nbr:$i");
            }
            $m = count($this->ynplots[$i]);
            for ($j = 0; $j < $m; ++$j) {
                $this->ynplots[$i][$j]->PreStrokeAdjust($this);
                $this->ynplots[$i][$j]->DoLegend($this);
            }
        }
    }

    public function StrokeBands($aDepth, $aCSIM)
    {
        // Stroke bands
        if ($this->bands != null && !$aCSIM) {
            for ($i = 0; $i < count($this->bands); ++$i) {
                // Stroke all bands that asks to be in the background
                if ($this->bands[$i]->depth == $aDepth) {
                    $this->bands[$i]->Stroke($this->img, $this->xscale, $this->yscale);
                }
            }
        }

        if ($this->y2bands != null && $this->y2scale != null && !$aCSIM) {
            for ($i = 0; $i < count($this->y2bands); ++$i) {
                // Stroke all bands that asks to be in the foreground
                if ($this->y2bands[$i]->depth == $aDepth) {
                    $this->y2bands[$i]->Stroke($this->img, $this->xscale, $this->y2scale);
                }
            }
        }
    }

    // Stroke the graph
    // $aStrokeFileName If != "" the image will be written to this file and NOT
    // streamed back to the browser
    public function Stroke($aStrokeFileName = '')
    {
        // Fist make a sanity check that user has specified a scale
        if (empty($this->yscale)) {
            JpGraphError::RaiseL(25031); //('You must specify what scale to use with a call to Graph::SetScale().');
        }

        // Start by adjusting the margin so that potential titles will fit.
        $this->AdjustMarginsForTitles();

        // Give the plot a chance to do any scale adjuments the individual plots
        // wants to do. Right now this is only used by the contour plot to set scale
        // limits
        for ($i = 0; $i < count($this->plots); ++$i) {
            $this->plots[$i]->PreScaleSetup($this);
        }

        // Init scale constants that are used to calculate the transformation from
        // world to pixel coordinates
        $this->InitScaleConstants();

        // If the filename is the predefined value = '_csim_special_'
        // we assume that the call to stroke only needs to do enough
        // to correctly generate the CSIM maps.
        // We use this variable to skip things we don't strictly need
        // to do to generate the image map to improve performance
        // a best we can. Therefor you will see a lot of tests !$_csim in the
        // code below.
        $_csim = ($aStrokeFileName === _CSIM_SPECIALFILE);

        // If we are called the second time (perhaps the user has called GetHTMLImageMap()
        // himself then the legends have alsready been populated once in order to get the
        // CSIM coordinats. Since we do not want the legends to be populated a second time
        // we clear the legends
        $this->legend->Clear();

        // We need to know if we have stroked the plot in the
        // GetCSIMareas. Otherwise the CSIM hasn't been generated
        // and in the case of GetCSIM called before stroke to generate
        // CSIM without storing an image to disk GetCSIM must call Stroke.
        $this->iHasStroked = true;

        // Setup pre-stroked adjustments and Legends
        $this->doPrestrokeAdjustments();

        if ($this->graph_theme) {
            $this->graph_theme->PreStrokeApply($this);
        }

        // Bail out if any of the Y-axis not been specified and
        // has no plots. (This means it is impossible to do autoscaling and
        // no other scale was given so we can't possible draw anything). If you use manual
        // scaling you also have to supply the tick steps as well.
        if ((!$this->yscale->IsSpecified() && count($this->plots) == 0) ||
            ($this->y2scale != null && !$this->y2scale->IsSpecified() && count($this->y2plots) == 0)) {
            //$e = "n=".count($this->y2plots)."\n";
            // $e = "Can't draw unspecified Y-scale.<br>\nYou have either:<br>\n";
            // $e .= "1. Specified an Y axis for autoscaling but have not supplied any plots<br>\n";
            // $e .= "2. Specified a scale manually but have forgot to specify the tick steps";
            JpGraphError::RaiseL(25026);
        }

        // Bail out if no plots and no specified X-scale
        if ((!$this->xscale->IsSpecified() && count($this->plots) == 0 && count($this->y2plots) == 0)) {
            JpGraphError::RaiseL(25034); //("<strong>JpGraph: Can't draw unspecified X-scale.</strong><br>No plots.<br>");
        }

        // Autoscale the normal Y-axis
        $this->doAutoScaleYAxis();

        // Autoscale all additiopnal y-axis
        $this->doAutoScaleYnAxis();

        // Autoscale the regular x-axis and position the y-axis properly
        $this->doAutoScaleXAxis();

        // If we have a negative values and x-axis position is at 0
        // we need to supress the first and possible the last tick since
        // they will be drawn on top of the y-axis (and possible y2 axis)
        // The test below might seem strange the reasone being that if
        // the user hasn't specified a value for position this will not
        // be set until we do the stroke for the axis so as of now it
        // is undefined.
        // For X-text scale we ignore all this since the tick are usually
        // much further in and not close to the Y-axis. Hence the test
        // for 'text'
        if (($this->yaxis->pos == $this->xscale->GetMinVal() || (is_string($this->yaxis->pos) && $this->yaxis->pos == 'min')) &&
            !is_numeric($this->xaxis->pos) && $this->yscale->GetMinVal() < 0 &&
            substr($this->axtype, 0, 4) != 'text' && $this->xaxis->pos != 'min') {

            //$this->yscale->ticks->SupressZeroLabel(false);
            $this->xscale->ticks->SupressFirst();
            if ($this->y2axis != null) {
                $this->xscale->ticks->SupressLast();
            }
        } elseif (!is_numeric($this->yaxis->pos) && $this->yaxis->pos == 'max') {
            $this->xscale->ticks->SupressLast();
        }

        if (!$_csim) {
            $this->StrokePlotArea();
            if ($this->iIconDepth == DEPTH_BACK) {
                $this->StrokeIcons();
            }
        }
        $this->StrokeAxis(false);

        // Stroke colored bands
        $this->StrokeBands(DEPTH_BACK, $_csim);

        if ($this->grid_depth == DEPTH_BACK && !$_csim) {
            $this->ygrid->Stroke();
            $this->xgrid->Stroke();
        }

        // Stroke Y2-axis
        if ($this->y2axis != null && !$_csim) {
            $this->y2axis->Stroke($this->xscale);
            $this->y2grid->Stroke();
        }

        // Stroke yn-axis
        $n = count($this->ynaxis);
        for ($i = 0; $i < $n; ++$i) {
            $this->ynaxis[$i]->Stroke($this->xscale);
        }

        $oldoff = $this->xscale->off;
        if (substr($this->axtype, 0, 4) == 'text') {
            if ($this->text_scale_abscenteroff > -1) {
                // For a text scale the scale factor is the number of pixel per step.
                // Hence we can use the scale factor as a substitute for number of pixels
                // per major scale step and use that in order to adjust the offset so that
                // an object of width "abscenteroff" becomes centered.
                $this->xscale->off += round($this->xscale->scale_factor / 2) - round($this->text_scale_abscenteroff / 2);
            } else {
                $this->xscale->off += ceil($this->xscale->scale_factor * $this->text_scale_off * $this->xscale->ticks->minor_step);
            }
        }

        if ($this->iDoClipping) {
            $oldimage = $this->img->CloneCanvasH();
        }

        if (!$this->y2orderback) {
            // Stroke all plots for Y1 axis
            for ($i = 0; $i < count($this->plots); ++$i) {
                $this->plots[$i]->Stroke($this->img, $this->xscale, $this->yscale);
                $this->plots[$i]->StrokeMargin($this->img);
            }
        }

        // Stroke all plots for Y2 axis
        if ($this->y2scale != null) {
            for ($i = 0; $i < count($this->y2plots); ++$i) {
                $this->y2plots[$i]->Stroke($this->img, $this->xscale, $this->y2scale);
            }
        }

        if ($this->y2orderback) {
            // Stroke all plots for Y1 axis
            for ($i = 0; $i < count($this->plots); ++$i) {
                $this->plots[$i]->Stroke($this->img, $this->xscale, $this->yscale);
                $this->plots[$i]->StrokeMargin($this->img);
            }
        }

        $n = count($this->ynaxis);
        for ($i = 0; $i < $n; ++$i) {
            $m = count($this->ynplots[$i]);
            for ($j = 0; $j < $m; ++$j) {
                $this->ynplots[$i][$j]->Stroke($this->img, $this->xscale, $this->ynscale[$i]);
                $this->ynplots[$i][$j]->StrokeMargin($this->img);
            }
        }

        if ($this->iIconDepth == DEPTH_FRONT) {
            $this->StrokeIcons();
        }

        if ($this->iDoClipping) {
            // Clipping only supports graphs at 0 and 90 degrees
            if ($this->img->a == 0) {
                $this->img->CopyCanvasH($oldimage, $this->img->img,
                    $this->img->left_margin, $this->img->top_margin,
                    $this->img->left_margin, $this->img->top_margin,
                    $this->img->plotwidth + 1, $this->img->plotheight);
            } elseif ($this->img->a == 90) {
                $adj = ($this->img->height - $this->img->width) / 2;
                $this->img->CopyCanvasH($oldimage, $this->img->img,
                    $this->img->bottom_margin - $adj, $this->img->left_margin + $adj,
                    $this->img->bottom_margin - $adj, $this->img->left_margin + $adj,
                    $this->img->plotheight + 1, $this->img->plotwidth);
            } else {
                JpGraphError::RaiseL(25035, $this->img->a); //('You have enabled clipping. Cliping is only supported for graphs at 0 or 90 degrees rotation. Please adjust you current angle (='.$this->img->a.' degrees) or disable clipping.');
            }
            $this->img->Destroy();
            $this->img->SetCanvasH($oldimage);
        }

        $this->xscale->off = $oldoff;

        if ($this->grid_depth == DEPTH_FRONT && !$_csim) {
            $this->ygrid->Stroke();
            $this->xgrid->Stroke();
        }

        // Stroke colored bands
        $this->StrokeBands(DEPTH_FRONT, $_csim);

        // Finally draw the axis again since some plots may have nagged
        // the axis in the edges.
        if (!$_csim) {
            $this->StrokeAxis();
        }

        if ($this->y2scale != null && !$_csim) {
            $this->y2axis->Stroke($this->xscale, false);
        }

        if (!$_csim) {
            $this->StrokePlotBox();
        }

        // The titles and legends never gets rotated so make sure
        // that the angle is 0 before stroking them
        $aa = $this->img->SetAngle(0);
        $this->StrokeTitles();
        $this->footer->Stroke($this->img);
        $this->legend->Stroke($this->img);
        $this->img->SetAngle($aa);
        $this->StrokeTexts();
        $this->StrokeTables();

        if (!$_csim) {

            $this->img->SetAngle($aa);

            // Draw an outline around the image map
            if (_JPG_DEBUG) {
                $this->DisplayClientSideaImageMapAreas();
            }

            // Should we do any final image transformation
            if ($this->iImgTrans) {
                if (!class_exists('ImgTrans', false)) {
                    require_once 'jpgraph_imgtrans.php';
                    //JpGraphError::Raise('In order to use image transformation you must include the file jpgraph_imgtrans.php in your script.');
                }

                $tform = new ImgTrans($this->img->img);
                $this->img->img = $tform->Skew3D($this->iImgTransHorizon, $this->iImgTransSkewDist,
                    $this->iImgTransDirection, $this->iImgTransHighQ,
                    $this->iImgTransMinSize, $this->iImgTransFillColor,
                    $this->iImgTransBorder);
            }

            // If the filename is given as the special "__handle"
            // then the image handler is returned and the image is NOT
            // streamed back
            if ($aStrokeFileName == _IMG_HANDLER) {
                return $this->img->img;
            } else {
                // Finally stream the generated picture
                $this->cache->PutAndStream($this->img, $this->cache_name, $this->inline, $aStrokeFileName);
            }
        }
    }

    public function SetAxisLabelBackground($aType, $aXFColor = 'lightgray', $aXColor = 'black', $aYFColor = 'lightgray', $aYColor = 'black')
    {
        $this->iAxisLblBgType = $aType;
        $this->iXAxisLblBgFillColor = $aXFColor;
        $this->iXAxisLblBgColor = $aXColor;
        $this->iYAxisLblBgFillColor = $aYFColor;
        $this->iYAxisLblBgColor = $aYColor;
    }

    public function StrokeAxisLabelBackground()
    {
        // Types
        // 0 = No background
        // 1 = Only X-labels, length of axis
        // 2 = Only Y-labels, length of axis
        // 3 = As 1 but extends to width of graph
        // 4 = As 2 but extends to height of graph
        // 5 = Combination of 3 & 4
        // 6 = Combination of 1 & 2

        $t = $this->iAxisLblBgType;
        if ($t < 1) {
            return;
        }

        // Stroke optional X-axis label background color
        if ($t == 1 || $t == 3 || $t == 5 || $t == 6) {
            $this->img->PushColor($this->iXAxisLblBgFillColor);
            if ($t == 1 || $t == 6) {
                $xl = $this->img->left_margin;
                $yu = $this->img->height - $this->img->bottom_margin + 1;
                $xr = $this->img->width - $this->img->right_margin;
                $yl = $this->img->height - 1 - $this->frame_weight;
            } else {
                // t==3 || t==5
                $xl = $this->frame_weight;
                $yu = $this->img->height - $this->img->bottom_margin + 1;
                $xr = $this->img->width - 1 - $this->frame_weight;
                $yl = $this->img->height - 1 - $this->frame_weight;
            }

            $this->img->FilledRectangle($xl, $yu, $xr, $yl);
            $this->img->PopColor();

            // Check if we should add the vertical lines at left and right edge
            if ($this->iXAxisLblBgColor !== '') {
                // Hardcode to one pixel wide
                $this->img->SetLineWeight(1);
                $this->img->PushColor($this->iXAxisLblBgColor);
                if ($t == 1 || $t == 6) {
                    $this->img->Line($xl, $yu, $xl, $yl);
                    $this->img->Line($xr, $yu, $xr, $yl);
                } else {
                    $xl = $this->img->width - $this->img->right_margin;
                    $this->img->Line($xl, $yu - 1, $xr, $yu - 1);
                }
                $this->img->PopColor();
            }
        }

        if ($t == 2 || $t == 4 || $t == 5 || $t == 6) {
            $this->img->PushColor($this->iYAxisLblBgFillColor);
            if ($t == 2 || $t == 6) {
                $xl = $this->frame_weight;
                $yu = $this->frame_weight + $this->img->top_margin;
                $xr = $this->img->left_margin - 1;
                $yl = $this->img->height - $this->img->bottom_margin + 1;
            } else {
                $xl = $this->frame_weight;
                $yu = $this->frame_weight;
                $xr = $this->img->left_margin - 1;
                $yl = $this->img->height - 1 - $this->frame_weight;
            }

            $this->img->FilledRectangle($xl, $yu, $xr, $yl);
            $this->img->PopColor();

            // Check if we should add the vertical lines at left and right edge
            if ($this->iXAxisLblBgColor !== '') {
                $this->img->PushColor($this->iXAxisLblBgColor);
                if ($t == 2 || $t == 6) {
                    $this->img->Line($xl, $yu - 1, $xr, $yu - 1);
                    $this->img->Line($xl, $yl - 1, $xr, $yl - 1);
                } else {
                    $this->img->Line($xr + 1, $yu, $xr + 1, $this->img->top_margin);
                }
                $this->img->PopColor();
            }

        }
    }

    public function StrokeAxis($aStrokeLabels = true)
    {

        if ($aStrokeLabels) {
            $this->StrokeAxisLabelBackground();
        }

        // Stroke axis
        if ($this->iAxisStyle != AXSTYLE_SIMPLE) {
            switch ($this->iAxisStyle) {
                case AXSTYLE_BOXIN:
                    $toppos = SIDE_DOWN;
                    $bottompos = SIDE_UP;
                    $leftpos = SIDE_RIGHT;
                    $rightpos = SIDE_LEFT;
                    break;
                case AXSTYLE_BOXOUT:
                    $toppos = SIDE_UP;
                    $bottompos = SIDE_DOWN;
                    $leftpos = SIDE_LEFT;
                    $rightpos = SIDE_RIGHT;
                    break;
                case AXSTYLE_YBOXIN:
                    $toppos = false;
                    $bottompos = SIDE_UP;
                    $leftpos = SIDE_RIGHT;
                    $rightpos = SIDE_LEFT;
                    break;
                case AXSTYLE_YBOXOUT:
                    $toppos = false;
                    $bottompos = SIDE_DOWN;
                    $leftpos = SIDE_LEFT;
                    $rightpos = SIDE_RIGHT;
                    break;
                default:
                    JpGRaphError::RaiseL(25036, $this->iAxisStyle); //('Unknown AxisStyle() : '.$this->iAxisStyle);
                    break;
            }

            // By default we hide the first label so it doesn't cross the
            // Y-axis in case the positon hasn't been set by the user.
            // However, if we use a box we always want the first value
            // displayed so we make sure it will be displayed.
            $this->xscale->ticks->SupressFirst(false);

            // Now draw the bottom X-axis
            $this->xaxis->SetPos('min');
            $this->xaxis->SetLabelSide(SIDE_DOWN);
            $this->xaxis->scale->ticks->SetSide($bottompos);
            $this->xaxis->Stroke($this->yscale, $aStrokeLabels);

            if ($toppos !== false) {
                // We also want a top X-axis
                $this->xaxis = $this->xaxis;
                $this->xaxis->SetPos('max');
                $this->xaxis->SetLabelSide(SIDE_UP);
                // No title for the top X-axis
                if ($aStrokeLabels) {
                    $this->xaxis->title->Set('');
                }
                $this->xaxis->scale->ticks->SetSide($toppos);
                $this->xaxis->Stroke($this->yscale, $aStrokeLabels);
            }

            // Stroke the left Y-axis
            $this->yaxis->SetPos('min');
            $this->yaxis->SetLabelSide(SIDE_LEFT);
            $this->yaxis->scale->ticks->SetSide($leftpos);
            $this->yaxis->Stroke($this->xscale, $aStrokeLabels);

            // Stroke the  right Y-axis
            $this->yaxis->SetPos('max');
            // No title for the right side
            if ($aStrokeLabels) {
                $this->yaxis->title->Set('');
            }
            $this->yaxis->SetLabelSide(SIDE_RIGHT);
            $this->yaxis->scale->ticks->SetSide($rightpos);
            $this->yaxis->Stroke($this->xscale, $aStrokeLabels);
        } else {
            $this->xaxis->Stroke($this->yscale, $aStrokeLabels);
            $this->yaxis->Stroke($this->xscale, $aStrokeLabels);
        }
    }

    // Private helper function for backgound image
    public static function LoadBkgImage($aImgFormat = '', $aFile = '', $aImgStr = '')
    {
        if ($aImgStr != '') {
            return Image::CreateFromString($aImgStr);
        }

        // Remove case sensitivity and setup appropriate function to create image
        // Get file extension. This should be the LAST '.' separated part of the filename
        $e = explode('.', $aFile);
        $ext = strtolower($e[count($e) - 1]);
        if ($ext == "jpeg") {
            $ext = "jpg";
        }

        if (trim($ext) == '') {
            $ext = 'png'; // Assume PNG if no extension specified
        }

        if ($aImgFormat == '') {
            $imgtag = $ext;
        } else {
            $imgtag = $aImgFormat;
        }

        $supported = imagetypes();
        if (($ext == 'jpg' && !($supported & IMG_JPG)) ||
            ($ext == 'gif' && !($supported & IMG_GIF)) ||
            ($ext == 'png' && !($supported & IMG_PNG)) ||
            ($ext == 'bmp' && !($supported & IMG_WBMP)) ||
            ($ext == 'xpm' && !($supported & IMG_XPM))) {

            JpGraphError::RaiseL(25037, $aFile); //('The image format of your background image ('.$aFile.') is not supported in your system configuration. ');
        }

        if ($imgtag == "jpg" || $imgtag == "jpeg") {
            $f = "imagecreatefromjpeg";
            $imgtag = "jpg";
        } else {
            $f = "imagecreatefrom" . $imgtag;
        }

        // Compare specified image type and file extension
        if ($imgtag != $ext) {
            //$t = "Background image seems to be of different type (has different file extension) than specified imagetype. Specified: '".$aImgFormat."'File: '".$aFile."'";
            JpGraphError::RaiseL(25038, $aImgFormat, $aFile);
        }

        $img = @$f($aFile);
        if (!$img) {
            JpGraphError::RaiseL(25039, $aFile); //(" Can't read background image: '".$aFile."'");
        }
        return $img;
    }

    public function StrokePlotGrad()
    {
        if ($this->plot_gradtype < 0) {
            return;
        }

        $grad = new Gradient($this->img);
        $xl = $this->img->left_margin;
        $yt = $this->img->top_margin;
        $xr = $xl + $this->img->plotwidth + 1;
        $yb = $yt + $this->img->plotheight;
        $grad->FilledRectangle($xl, $yt, $xr, $yb, $this->plot_gradfrom, $this->plot_gradto, $this->plot_gradtype);

    }

    public function StrokeBackgroundGrad()
    {
        if ($this->bkg_gradtype < 0) {
            return;
        }

        $grad = new Gradient($this->img);
        if ($this->bkg_gradstyle == BGRAD_PLOT) {
            $xl = $this->img->left_margin;
            $yt = $this->img->top_margin;
            $xr = $xl + $this->img->plotwidth + 1;
            $yb = $yt + $this->img->plotheight;
            $grad->FilledRectangle($xl, $yt, $xr, $yb, $this->bkg_gradfrom, $this->bkg_gradto, $this->bkg_gradtype);
        } else {
            $xl = 0;
            $yt = 0;
            $xr = $xl + $this->img->width - 1;
            $yb = $yt + $this->img->height - 1;
            if ($this->doshadow) {
                $xr -= $this->shadow_width;
                $yb -= $this->shadow_width;
            }
            if ($this->doframe) {
                $yt += $this->frame_weight;
                $yb -= $this->frame_weight;
                $xl += $this->frame_weight;
                $xr -= $this->frame_weight;
            }
            $aa = $this->img->SetAngle(0);
            $grad->FilledRectangle($xl, $yt, $xr, $yb, $this->bkg_gradfrom, $this->bkg_gradto, $this->bkg_gradtype);
            $aa = $this->img->SetAngle($aa);
        }
    }

    public function StrokeFrameBackground()
    {
        if ($this->background_image != '' && $this->background_cflag != '') {
            JpGraphError::RaiseL(25040); //('It is not possible to specify both a background image and a background country flag.');
        }
        if ($this->background_image != '') {
            $bkgimg = $this->LoadBkgImage($this->background_image_format, $this->background_image);
        } elseif ($this->background_cflag != '') {
            if (!class_exists('FlagImages', false)) {
                JpGraphError::RaiseL(25041); //('In order to use Country flags as backgrounds you must include the "jpgraph_flags.php" file.');
            }
            $fobj = new FlagImages(FLAGSIZE4);
            $dummy = '';
            $bkgimg = $fobj->GetImgByName($this->background_cflag, $dummy);
            $this->background_image_mix = $this->background_cflag_mix;
            $this->background_image_type = $this->background_cflag_type;
        } else {
            return;
        }

        $bw = ImageSX($bkgimg);
        $bh = ImageSY($bkgimg);

        // No matter what the angle is we always stroke the image and frame
        // assuming it is 0 degree
        $aa = $this->img->SetAngle(0);

        switch ($this->background_image_type) {
            case BGIMG_FILLPLOT: // Resize to just fill the plotarea
                $this->FillMarginArea();
                $this->StrokeFrame();
                // Special case to hande 90 degree rotated graph corectly
                if ($aa == 90) {
                    $this->img->SetAngle(90);
                    $this->FillPlotArea();
                    $aa = $this->img->SetAngle(0);
                    $adj = ($this->img->height - $this->img->width) / 2;
                    $this->img->CopyMerge($bkgimg,
                        $this->img->bottom_margin - $adj, $this->img->left_margin + $adj,
                        0, 0,
                        $this->img->plotheight + 1, $this->img->plotwidth,
                        $bw, $bh, $this->background_image_mix);
                } else {
                    $this->FillPlotArea();
                    $this->img->CopyMerge($bkgimg,
                        $this->img->left_margin, $this->img->top_margin + 1,
                        0, 0, $this->img->plotwidth + 1, $this->img->plotheight,
                        $bw, $bh, $this->background_image_mix);
                }
                break;
            case BGIMG_FILLFRAME: // Fill the whole area from upper left corner, resize to just fit
                $hadj = 0;
                $vadj = 0;
                if ($this->doshadow) {
                    $hadj = $this->shadow_width;
                    $vadj = $this->shadow_width;
                }
                $this->FillMarginArea();
                $this->FillPlotArea();
                $this->img->CopyMerge($bkgimg, 0, 0, 0, 0, $this->img->width - $hadj, $this->img->height - $vadj,
                    $bw, $bh, $this->background_image_mix);
                $this->StrokeFrame();
                break;
            case BGIMG_COPY: // Just copy the image from left corner, no resizing
                $this->FillMarginArea();
                $this->FillPlotArea();
                $this->img->CopyMerge($bkgimg, 0, 0, 0, 0, $bw, $bh,
                    $bw, $bh, $this->background_image_mix);
                $this->StrokeFrame();
                break;
            case BGIMG_CENTER: // Center original image in the plot area
                $this->FillMarginArea();
                $this->FillPlotArea();
                $centerx = round($this->img->plotwidth / 2 + $this->img->left_margin - $bw / 2);
                $centery = round($this->img->plotheight / 2 + $this->img->top_margin - $bh / 2);
                $this->img->CopyMerge($bkgimg, $centerx, $centery, 0, 0, $bw, $bh,
                    $bw, $bh, $this->background_image_mix);
                $this->StrokeFrame();
                break;
            case BGIMG_FREE: // Just copy the image to the specified location
                $this->img->CopyMerge($bkgimg,
                    $this->background_image_xpos, $this->background_image_ypos,
                    0, 0, $bw, $bh, $bw, $bh, $this->background_image_mix);
                $this->StrokeFrame(); // New
                break;
            default:
                JpGraphError::RaiseL(25042); //(" Unknown background image layout");
        }
        $this->img->SetAngle($aa);
    }

    // Private
    // Draw a frame around the image
    public function StrokeFrame()
    {
        if (!$this->doframe) {
            return;
        }

        if ($this->background_image_type <= 1 && ($this->bkg_gradtype < 0 || ($this->bkg_gradtype > 0 && $this->bkg_gradstyle == BGRAD_PLOT))) {
            $c = $this->margin_color;
        } else {
            $c = false;
        }

        if ($this->doshadow) {
            $this->img->SetColor($this->frame_color);
            $this->img->ShadowRectangle(0, 0, $this->img->width, $this->img->height,
                $c, $this->shadow_width, $this->shadow_color);
        } elseif ($this->framebevel) {
            if ($c) {
                $this->img->SetColor($this->margin_color);
                $this->img->FilledRectangle(0, 0, $this->img->width - 1, $this->img->height - 1);
            }
            $this->img->Bevel(1, 1, $this->img->width - 2, $this->img->height - 2,
                $this->framebeveldepth,
                $this->framebevelcolor1, $this->framebevelcolor2);
            if ($this->framebevelborder) {
                $this->img->SetColor($this->framebevelbordercolor);
                $this->img->Rectangle(0, 0, $this->img->width - 1, $this->img->height - 1);
            }
        } else {
            $this->img->SetLineWeight($this->frame_weight);
            if ($c) {
                $this->img->SetColor($this->margin_color);
                $this->img->FilledRectangle(0, 0, $this->img->width - 1, $this->img->height - 1);
            }
            $this->img->SetColor($this->frame_color);
            $this->img->Rectangle(0, 0, $this->img->width - 1, $this->img->height - 1);
        }
    }

    public function FillMarginArea()
    {
        $hadj = 0;
        $vadj = 0;
        if ($this->doshadow) {
            $hadj = $this->shadow_width;
            $vadj = $this->shadow_width;
        }

        $this->img->SetColor($this->margin_color);
        $this->img->FilledRectangle(0, 0, $this->img->width - 1 - $hadj, $this->img->height - 1 - $vadj);

        $this->img->FilledRectangle(0, 0, $this->img->width - 1 - $hadj, $this->img->top_margin);
        $this->img->FilledRectangle(0, $this->img->top_margin, $this->img->left_margin, $this->img->height - 1 - $hadj);
        $this->img->FilledRectangle($this->img->left_margin + 1,
            $this->img->height - $this->img->bottom_margin,
            $this->img->width - 1 - $hadj,
            $this->img->height - 1 - $hadj);
        $this->img->FilledRectangle($this->img->width - $this->img->right_margin,
            $this->img->top_margin + 1,
            $this->img->width - 1 - $hadj,
            $this->img->height - $this->img->bottom_margin - 1);
    }

    public function FillPlotArea()
    {
        $this->img->PushColor($this->plotarea_color);
        $this->img->FilledRectangle($this->img->left_margin,
            $this->img->top_margin,
            $this->img->width - $this->img->right_margin,
            $this->img->height - $this->img->bottom_margin);
        $this->img->PopColor();
    }

    // Stroke the plot area with either a solid color or a background image
    public function StrokePlotArea()
    {
        // Note: To be consistent we really should take a possible shadow
        // into account. However, that causes some problem for the LinearScale class
        // since in the current design it does not have any links to class Graph which
        // means it has no way of compensating for the adjusted plotarea in case of a
        // shadow. So, until I redesign LinearScale we can't compensate for this.
        // So just set the two adjustment parameters to zero for now.
        $boxadj = 0; //$this->doframe ? $this->frame_weight : 0 ;
        $adj = 0; //$this->doshadow ? $this->shadow_width : 0 ;

        if ($this->background_image != '' || $this->background_cflag != '') {
            $this->StrokeFrameBackground();
        } else {
            $aa = $this->img->SetAngle(0);
            $this->StrokeFrame();
            $aa = $this->img->SetAngle($aa);
            $this->StrokeBackgroundGrad();
            if ($this->bkg_gradtype < 0 || ($this->bkg_gradtype > 0 && $this->bkg_gradstyle == BGRAD_MARGIN)) {
                $this->FillPlotArea();
            }
            $this->StrokePlotGrad();
        }
    }

    public function StrokeIcons()
    {
        $n = count($this->iIcons);
        for ($i = 0; $i < $n; ++$i) {
            $this->iIcons[$i]->StrokeWithScale($this->img, $this->xscale, $this->yscale);
        }
    }

    public function StrokePlotBox()
    {
        // Should we draw a box around the plot area?
        if ($this->boxed) {
            $this->img->SetLineWeight(1);
            $this->img->SetLineStyle('solid');
            $this->img->SetColor($this->box_color);
            for ($i = 0; $i < $this->box_weight; ++$i) {
                $this->img->Rectangle(
                    $this->img->left_margin - $i, $this->img->top_margin - $i,
                    $this->img->width - $this->img->right_margin + $i,
                    $this->img->height - $this->img->bottom_margin + $i);
            }
        }
    }

    public function SetTitleBackgroundFillStyle($aStyle, $aColor1 = 'black', $aColor2 = 'white')
    {
        $this->titlebkg_fillstyle = $aStyle;
        $this->titlebkg_scolor1 = $aColor1;
        $this->titlebkg_scolor2 = $aColor2;
    }

    public function SetTitleBackground($aBackColor = 'gray', $aStyle = TITLEBKG_STYLE1, $aFrameStyle = TITLEBKG_FRAME_NONE, $aFrameColor = 'black', $aFrameWeight = 1, $aBevelHeight = 3, $aEnable = true)
    {
        $this->titlebackground = $aEnable;
        $this->titlebackground_color = $aBackColor;
        $this->titlebackground_style = $aStyle;
        $this->titlebackground_framecolor = $aFrameColor;
        $this->titlebackground_framestyle = $aFrameStyle;
        $this->titlebackground_frameweight = $aFrameWeight;
        $this->titlebackground_bevelheight = $aBevelHeight;
    }

    public function StrokeTitles()
    {

        $margin = 3;

        if ($this->titlebackground) {
            // Find out height
            $this->title->margin += 2;
            $h = $this->title->GetTextHeight($this->img) + $this->title->margin + $margin;
            if ($this->subtitle->t != '' && !$this->subtitle->hide) {
                $h += $this->subtitle->GetTextHeight($this->img) + $margin +
                $this->subtitle->margin;
                $h += 2;
            }
            if ($this->subsubtitle->t != '' && !$this->subsubtitle->hide) {
                $h += $this->subsubtitle->GetTextHeight($this->img) + $margin +
                $this->subsubtitle->margin;
                $h += 2;
            }
            $this->img->PushColor($this->titlebackground_color);
            if ($this->titlebackground_style === TITLEBKG_STYLE1) {
                // Inside the frame
                if ($this->framebevel) {
                    $x1 = $y1 = $this->framebeveldepth + 1;
                    $x2 = $this->img->width - $this->framebeveldepth - 2;
                    $this->title->margin += $this->framebeveldepth + 1;
                    $h += $y1;
                    $h += 2;
                } else {
                    $x1 = $y1 = $this->frame_weight;
                    $x2 = $this->img->width - $this->frame_weight - 1;
                }
            } elseif ($this->titlebackground_style === TITLEBKG_STYLE2) {
                // Cover the frame as well
                $x1 = $y1 = 0;
                $x2 = $this->img->width - 1;
            } elseif ($this->titlebackground_style === TITLEBKG_STYLE3) {
                // Cover the frame as well (the difference is that
                // for style==3 a bevel frame border is on top
                // of the title background)
                $x1 = $y1 = 0;
                $x2 = $this->img->width - 1;
                $h += $this->framebeveldepth;
                $this->title->margin += $this->framebeveldepth;
            } else {
                JpGraphError::RaiseL(25043); //('Unknown title background style.');
            }

            if ($this->titlebackground_framestyle === 3) {
                $h += $this->titlebackground_bevelheight * 2 + 1;
                $this->title->margin += $this->titlebackground_bevelheight;
            }

            if ($this->doshadow) {
                $x2 -= $this->shadow_width;
            }

            $indent = 0;
            if ($this->titlebackground_framestyle == TITLEBKG_FRAME_BEVEL) {
                $indent = $this->titlebackground_bevelheight;
            }

            if ($this->titlebkg_fillstyle == TITLEBKG_FILLSTYLE_HSTRIPED) {
                $this->img->FilledRectangle2($x1 + $indent, $y1 + $indent, $x2 - $indent, $h - $indent,
                    $this->titlebkg_scolor1,
                    $this->titlebkg_scolor2);
            } elseif ($this->titlebkg_fillstyle == TITLEBKG_FILLSTYLE_VSTRIPED) {
                $this->img->FilledRectangle2($x1 + $indent, $y1 + $indent, $x2 - $indent, $h - $indent,
                    $this->titlebkg_scolor1,
                    $this->titlebkg_scolor2, 2);
            } else {
                // Solid fill
                $this->img->FilledRectangle($x1, $y1, $x2, $h);
            }
            $this->img->PopColor();

            $this->img->PushColor($this->titlebackground_framecolor);
            $this->img->SetLineWeight($this->titlebackground_frameweight);
            if ($this->titlebackground_framestyle == TITLEBKG_FRAME_FULL) {
                // Frame background
                $this->img->Rectangle($x1, $y1, $x2, $h);
            } elseif ($this->titlebackground_framestyle == TITLEBKG_FRAME_BOTTOM) {
                // Bottom line only
                $this->img->Line($x1, $h, $x2, $h);
            } elseif ($this->titlebackground_framestyle == TITLEBKG_FRAME_BEVEL) {
                $this->img->Bevel($x1, $y1, $x2, $h, $this->titlebackground_bevelheight);
            }
            $this->img->PopColor();

            // This is clumsy. But we neeed to stroke the whole graph frame if it is
            // set to bevel to get the bevel shading on top of the text background
            if ($this->framebevel && $this->doframe && $this->titlebackground_style === 3) {
                $this->img->Bevel(1, 1, $this->img->width - 2, $this->img->height - 2,
                    $this->framebeveldepth,
                    $this->framebevelcolor1, $this->framebevelcolor2);
                if ($this->framebevelborder) {
                    $this->img->SetColor($this->framebevelbordercolor);
                    $this->img->Rectangle(0, 0, $this->img->width - 1, $this->img->height - 1);
                }
            }
        }

        // Stroke title
        $y = $this->title->margin;
        if ($this->title->halign == 'center') {
            $this->title->Center(0, $this->img->width, $y);
        } elseif ($this->title->halign == 'left') {
            $this->title->SetPos($this->title->margin + 2, $y);
        } elseif ($this->title->halign == 'right') {
            $indent = 0;
            if ($this->doshadow) {
                $indent = $this->shadow_width + 2;
            }
            $this->title->SetPos($this->img->width - $this->title->margin - $indent, $y, 'right');
        }
        $this->title->Stroke($this->img);

        // ... and subtitle
        $y += $this->title->GetTextHeight($this->img) + $margin + $this->subtitle->margin;
        if ($this->subtitle->halign == 'center') {
            $this->subtitle->Center(0, $this->img->width, $y);
        } elseif ($this->subtitle->halign == 'left') {
            $this->subtitle->SetPos($this->subtitle->margin + 2, $y);
        } elseif ($this->subtitle->halign == 'right') {
            $indent = 0;
            if ($this->doshadow) {
                $indent = $this->shadow_width + 2;
            }

            $this->subtitle->SetPos($this->img->width - $this->subtitle->margin - $indent, $y, 'right');
        }
        $this->subtitle->Stroke($this->img);

        // ... and subsubtitle
        $y += $this->subtitle->GetTextHeight($this->img) + $margin + $this->subsubtitle->margin;
        if ($this->subsubtitle->halign == 'center') {
            $this->subsubtitle->Center(0, $this->img->width, $y);
        } elseif ($this->subsubtitle->halign == 'left') {
            $this->subsubtitle->SetPos($this->subsubtitle->margin + 2, $y);
        } elseif ($this->subsubtitle->halign == 'right') {
            $indent = 0;
            if ($this->doshadow) {
                $indent = $this->shadow_width + 2;
            }

            $this->subsubtitle->SetPos($this->img->width - $this->subsubtitle->margin - $indent, $y, 'right');
        }
        $this->subsubtitle->Stroke($this->img);

        // ... and fancy title
        $this->tabtitle->Stroke($this->img);

    }

    public function StrokeTexts()
    {
        // Stroke any user added text objects
        if ($this->texts != null) {
            for ($i = 0; $i < count($this->texts); ++$i) {
                $this->texts[$i]->StrokeWithScale($this->img, $this->xscale, $this->yscale);
            }
        }

        if ($this->y2texts != null && $this->y2scale != null) {
            for ($i = 0; $i < count($this->y2texts); ++$i) {
                $this->y2texts[$i]->StrokeWithScale($this->img, $this->xscale, $this->y2scale);
            }
        }

    }

    public function StrokeTables()
    {
        if ($this->iTables != null) {
            $n = count($this->iTables);
            for ($i = 0; $i < $n; ++$i) {
                $this->iTables[$i]->StrokeWithScale($this->img, $this->xscale, $this->yscale);
            }
        }
    }

    public function DisplayClientSideaImageMapAreas()
    {
        // Debug stuff - display the outline of the image map areas
        $csim = '';
        foreach ($this->plots as $p) {
            $csim .= $p->GetCSIMareas();
        }
        $csim .= $this->legend->GetCSIMareas();
        if (preg_match_all("/area shape=\"(\w+)\" coords=\"([0-9\, ]+)\"/", $csim, $coords)) {
            $this->img->SetColor($this->csimcolor);
            $n = count($coords[0]);
            for ($i = 0; $i < $n; $i++) {
                if ($coords[1][$i] == 'poly') {
                    preg_match_all('/\s*([0-9]+)\s*,\s*([0-9]+)\s*,*/', $coords[2][$i], $pts);
                    $this->img->SetStartPoint($pts[1][count($pts[0]) - 1], $pts[2][count($pts[0]) - 1]);
                    $m = count($pts[0]);
                    for ($j = 0; $j < $m; $j++) {
                        $this->img->LineTo($pts[1][$j], $pts[2][$j]);
                    }
                } elseif ($coords[1][$i] == 'rect') {
                    $pts = preg_split('/,/', $coords[2][$i]);
                    $this->img->SetStartPoint($pts[0], $pts[1]);
                    $this->img->LineTo($pts[2], $pts[1]);
                    $this->img->LineTo($pts[2], $pts[3]);
                    $this->img->LineTo($pts[0], $pts[3]);
                    $this->img->LineTo($pts[0], $pts[1]);
                }
            }
        }
    }

    // Text scale offset in world coordinates
    public function SetTextScaleOff($aOff)
    {
        $this->text_scale_off = $aOff;
        $this->xscale->text_scale_off = $aOff;
    }

    // Text width of bar to be centered in absolute pixels
    public function SetTextScaleAbsCenterOff($aOff)
    {
        $this->text_scale_abscenteroff = $aOff;
    }

    // Get Y min and max values for added lines
    public function GetLinesYMinMax($aLines)
    {
        $n = count($aLines);
        if ($n == 0) {
            return false;
        }

        $min = $aLines[0]->scaleposition;
        $max = $min;
        $flg = false;
        for ($i = 0; $i < $n; ++$i) {
            if ($aLines[$i]->direction == HORIZONTAL) {
                $flg = true;
                $v = $aLines[$i]->scaleposition;
                if ($min > $v) {
                    $min = $v;
                }

                if ($max < $v) {
                    $max = $v;
                }

            }
        }
        return $flg ? array($min, $max) : false;
    }

    // Get X min and max values for added lines
    public function GetLinesXMinMax($aLines)
    {
        $n = count($aLines);
        if ($n == 0) {
            return false;
        }

        $min = $aLines[0]->scaleposition;
        $max = $min;
        $flg = false;
        for ($i = 0; $i < $n; ++$i) {
            if ($aLines[$i]->direction == VERTICAL) {
                $flg = true;
                $v = $aLines[$i]->scaleposition;
                if ($min > $v) {
                    $min = $v;
                }

                if ($max < $v) {
                    $max = $v;
                }

            }
        }
        return $flg ? array($min, $max) : false;
    }

    // Get min and max values for all included plots
    public function GetPlotsYMinMax($aPlots)
    {
        $n = count($aPlots);
        $i = 0;
        do {
            list($xmax, $max) = $aPlots[$i]->Max();
        } while (++$i < $n && !is_numeric($max));

        $i = 0;
        do {
            list($xmin, $min) = $aPlots[$i]->Min();
        } while (++$i < $n && !is_numeric($min));

        if (!is_numeric($min) || !is_numeric($max)) {
            JpGraphError::RaiseL(25044); //('Cannot use autoscaling since it is impossible to determine a valid min/max value  of the Y-axis (only null values).');
        }

        for ($i = 0; $i < $n; ++$i) {
            list($xmax, $ymax) = $aPlots[$i]->Max();
            list($xmin, $ymin) = $aPlots[$i]->Min();
            if (is_numeric($ymax)) {
                $max = max($max, $ymax);
            }

            if (is_numeric($ymin)) {
                $min = min($min, $ymin);
            }

        }
        if ($min == '') {
            $min = 0;
        }

        if ($max == '') {
            $max = 0;
        }

        if ($min == 0 && $max == 0) {
            // Special case if all values are 0
            $min = 0;
            $max = 1;
        }
        return array($min, $max);
    }

    public function hasLinePlotAndBarPlot()
    {
        $has_line = false;
        $has_bar = false;

        foreach ($this->plots as $plot) {
            if ($plot instanceof LinePlot) {
                $has_line = true;
            }
            if ($plot instanceof BarPlot) {
                $has_bar = true;
            }
        }

        if ($has_line && $has_bar) {
            return true;
        }

        return false;
    }

    public function SetTheme($graph_theme)
    {

        if (!($this instanceof PieGraph)) {
            if (!$this->isAfterSetScale) {
                JpGraphError::RaiseL(25133); //('Use Graph::SetTheme() after Graph::SetScale().');
            }
        }

        if ($this->graph_theme) {
            $this->ClearTheme();
        }
        $this->graph_theme = $graph_theme;
        $this->graph_theme->ApplyGraph($this);
    }

    public function ClearTheme()
    {
        $this->graph_theme = null;

        $this->isRunningClear = true;

        $this->__construct(
            $this->inputValues['aWidth'],
            $this->inputValues['aHeight'],
            $this->inputValues['aCachedName'],
            $this->inputValues['aTimeout'],
            $this->inputValues['aInline']
        );

        if (!($this instanceof PieGraph)) {
            if ($this->isAfterSetScale) {
                $this->SetScale(
                    $this->inputValues['aAxisType'],
                    $this->inputValues['aYMin'],
                    $this->inputValues['aYMax'],
                    $this->inputValues['aXMin'],
                    $this->inputValues['aXMax']
                );
            }
        }

        $this->isRunningClear = false;
    }

    public function SetSupersampling($do = false, $scale = 2)
    {
        if ($do) {
            define('SUPERSAMPLING_SCALE', $scale);
            // $this->img->scale = $scale;
        } else {
            define('SUPERSAMPLING_SCALE', 1);
            //$this->img->scale = 0;
        }
    }

} // Class

//===================================================
// CLASS LineProperty
// Description: Holds properties for a line
//===================================================
class LineProperty
{
    public $iWeight = 1, $iColor = 'black', $iStyle = 'solid', $iShow = false;

    public function __construct($aWeight = 1, $aColor = 'black', $aStyle = 'solid')
    {
        $this->iWeight = $aWeight;
        $this->iColor = $aColor;
        $this->iStyle = $aStyle;
    }

    public function SetColor($aColor)
    {
        $this->iColor = $aColor;
    }

    public function SetWeight($aWeight)
    {
        $this->iWeight = $aWeight;
    }

    public function SetStyle($aStyle)
    {
        $this->iStyle = $aStyle;
    }

    public function Show($aShow = true)
    {
        $this->iShow = $aShow;
    }

    public function Stroke($aImg, $aX1, $aY1, $aX2, $aY2)
    {
        if ($this->iShow) {
            $aImg->PushColor($this->iColor);
            $oldls = $aImg->line_style;
            $oldlw = $aImg->line_weight;
            $aImg->SetLineWeight($this->iWeight);
            $aImg->SetLineStyle($this->iStyle);
            $aImg->StyleLine($aX1, $aY1, $aX2, $aY2);
            $aImg->PopColor($this->iColor);
            $aImg->line_style = $oldls;
            $aImg->line_weight = $oldlw;

        }
    }
}

//===================================================
// CLASS GraphTabTitle
// Description: Draw "tab" titles on top of graphs
//===================================================
class GraphTabTitle extends Text
{
    private $corner = 6, $posx = 7, $posy = 4;
    private $fillcolor = 'lightyellow', $bordercolor = 'black';
    private $align = 'left', $width = TABTITLE_WIDTHFIT;
    public function __construct()
    {
        $this->t = '';
        $this->font_style = FS_BOLD;
        $this->hide = true;
        $this->color = 'darkred';
    }

    public function SetColor($aTxtColor, $aFillColor = 'lightyellow', $aBorderColor = 'black')
    {
        $this->color = $aTxtColor;
        $this->fillcolor = $aFillColor;
        $this->bordercolor = $aBorderColor;
    }

    public function SetFillColor($aFillColor)
    {
        $this->fillcolor = $aFillColor;
    }

    public function SetTabAlign($aAlign)
    {
        $this->align = $aAlign;
    }

    public function SetWidth($aWidth)
    {
        $this->width = $aWidth;
    }

    public function Set($t)
    {
        $this->t = $t;
        $this->hide = false;
    }

    public function SetCorner($aD)
    {
        $this->corner = $aD;
    }

    public function Stroke($aImg, $aDummy1 = null, $aDummy2 = null)
    {
        if ($this->hide) {
            return;
        }

        $this->boxed = false;
        $w = $this->GetWidth($aImg) + 2 * $this->posx;
        $h = $this->GetTextHeight($aImg) + 2 * $this->posy;

        $x = $aImg->left_margin;
        $y = $aImg->top_margin;

        if ($this->width === TABTITLE_WIDTHFIT) {
            if ($this->align == 'left') {
                $p = array($x, $y,
                    $x, $y - $h + $this->corner,
                    $x + $this->corner, $y - $h,
                    $x + $w - $this->corner, $y - $h,
                    $x + $w, $y - $h + $this->corner,
                    $x + $w, $y);
            } elseif ($this->align == 'center') {
                $x += round($aImg->plotwidth / 2) - round($w / 2);
                $p = array($x, $y,
                    $x, $y - $h + $this->corner,
                    $x + $this->corner, $y - $h,
                    $x + $w - $this->corner, $y - $h,
                    $x + $w, $y - $h + $this->corner,
                    $x + $w, $y);
            } else {
                $x += $aImg->plotwidth - $w;
                $p = array($x, $y,
                    $x, $y - $h + $this->corner,
                    $x + $this->corner, $y - $h,
                    $x + $w - $this->corner, $y - $h,
                    $x + $w, $y - $h + $this->corner,
                    $x + $w, $y);
            }
        } else {
            if ($this->width === TABTITLE_WIDTHFULL) {
                $w = $aImg->plotwidth;
            } else {
                $w = $this->width;
            }

            // Make the tab fit the width of the plot area
            $p = array($x, $y,
                $x, $y - $h + $this->corner,
                $x + $this->corner, $y - $h,
                $x + $w - $this->corner, $y - $h,
                $x + $w, $y - $h + $this->corner,
                $x + $w, $y);

        }
        if ($this->halign == 'left') {
            $aImg->SetTextAlign('left', 'bottom');
            $x += $this->posx;
            $y -= $this->posy;
        } elseif ($this->halign == 'center') {
            $aImg->SetTextAlign('center', 'bottom');
            $x += $w / 2;
            $y -= $this->posy;
        } else {
            $aImg->SetTextAlign('right', 'bottom');
            $x += $w - $this->posx;
            $y -= $this->posy;
        }

        $aImg->SetColor($this->fillcolor);
        $aImg->FilledPolygon($p);

        $aImg->SetColor($this->bordercolor);
        $aImg->Polygon($p, true);

        $aImg->SetColor($this->color);
        $aImg->SetFont($this->font_family, $this->font_style, $this->font_size);
        $aImg->StrokeText($x, $y, $this->t, 0, 'center');
    }

}

//===================================================
// CLASS SuperScriptText
// Description: Format a superscript text
//===================================================
class SuperScriptText extends Text
{
    private $iSuper = '';
    private $sfont_family = '', $sfont_style = '', $sfont_size = 8;
    private $iSuperMargin = 2, $iVertOverlap = 4, $iSuperScale = 0.65;
    private $iSDir = 0;
    private $iSimple = false;

    public function __construct($aTxt = '', $aSuper = '', $aXAbsPos = 0, $aYAbsPos = 0)
    {
        parent::__construct($aTxt, $aXAbsPos, $aYAbsPos);
        $this->iSuper = $aSuper;
    }

    public function FromReal($aVal, $aPrecision = 2)
    {
        // Convert a floating point number to scientific notation
        $neg = 1.0;
        if ($aVal < 0) {
            $neg = -1.0;
            $aVal = -$aVal;
        }

        $l = floor(log10($aVal));
        $a = sprintf("%0." . $aPrecision . "f", round($aVal / pow(10, $l), $aPrecision));
        $a *= $neg;
        if ($this->iSimple && ($a == 1 || $a == -1)) {
            $a = '';
        }

        if ($a != '') {
            $this->t = $a . ' * 10';
        } else {
            if ($neg == 1) {
                $this->t = '10';
            } else {
                $this->t = '-10';
            }
        }
        $this->iSuper = $l;
    }

    public function Set($aTxt, $aSuper = '')
    {
        $this->t = $aTxt;
        $this->iSuper = $aSuper;
    }

    public function SetSuperFont($aFontFam, $aFontStyle = FS_NORMAL, $aFontSize = 8)
    {
        $this->sfont_family = $aFontFam;
        $this->sfont_style = $aFontStyle;
        $this->sfont_size = $aFontSize;
    }

    // Total width of text
    public function GetWidth($aImg)
    {
        $aImg->SetFont($this->font_family, $this->font_style, $this->font_size);
        $w = $aImg->GetTextWidth($this->t);
        $aImg->SetFont($this->sfont_family, $this->sfont_style, $this->sfont_size);
        $w += $aImg->GetTextWidth($this->iSuper);
        $w += $this->iSuperMargin;
        return $w;
    }

    // Hight of font (approximate the height of the text)
    public function GetFontHeight($aImg)
    {
        $aImg->SetFont($this->font_family, $this->font_style, $this->font_size);
        $h = $aImg->GetFontHeight();
        $aImg->SetFont($this->sfont_family, $this->sfont_style, $this->sfont_size);
        $h += $aImg->GetFontHeight();
        return $h;
    }

    // Hight of text
    public function GetTextHeight($aImg)
    {
        $aImg->SetFont($this->font_family, $this->font_style, $this->font_size);
        $h = $aImg->GetTextHeight($this->t);
        $aImg->SetFont($this->sfont_family, $this->sfont_style, $this->sfont_size);
        $h += $aImg->GetTextHeight($this->iSuper);
        return $h;
    }

    public function Stroke($aImg, $ax = -1, $ay = -1)
    {

        // To position the super script correctly we need different
        // cases to handle the alignmewnt specified since that will
        // determine how we can interpret the x,y coordinates

        $w = parent::GetWidth($aImg);
        $h = parent::GetTextHeight($aImg);
        switch ($this->valign) {
            case 'top':
                $sy = $this->y;
                break;
            case 'center':
                $sy = $this->y - $h / 2;
                break;
            case 'bottom':
                $sy = $this->y - $h;
                break;
            default:
                JpGraphError::RaiseL(25052); //('PANIC: Internal error in SuperScript::Stroke(). Unknown vertical alignment for text');
                break;
        }

        switch ($this->halign) {
            case 'left':
                $sx = $this->x + $w;
                break;
            case 'center':
                $sx = $this->x + $w / 2;
                break;
            case 'right':
                $sx = $this->x;
                break;
            default:
                JpGraphError::RaiseL(25053); //('PANIC: Internal error in SuperScript::Stroke(). Unknown horizontal alignment for text');
                break;
        }

        $sx += $this->iSuperMargin;
        $sy += $this->iVertOverlap;

        // Should we automatically determine the font or
        // has the user specified it explicetly?
        if ($this->sfont_family == '') {
            if ($this->font_family <= FF_FONT2) {
                if ($this->font_family == FF_FONT0) {
                    $sff = FF_FONT0;
                } elseif ($this->font_family == FF_FONT1) {
                    if ($this->font_style == FS_NORMAL) {
                        $sff = FF_FONT0;
                    } else {
                        $sff = FF_FONT1;
                    }
                } else {
                    $sff = FF_FONT1;
                }
                $sfs = $this->font_style;
                $sfz = $this->font_size;
            } else {
                // TTF fonts
                $sff = $this->font_family;
                $sfs = $this->font_style;
                $sfz = floor($this->font_size * $this->iSuperScale);
                if ($sfz < 8) {
                    $sfz = 8;
                }

            }
            $this->sfont_family = $sff;
            $this->sfont_style = $sfs;
            $this->sfont_size = $sfz;
        } else {
            $sff = $this->sfont_family;
            $sfs = $this->sfont_style;
            $sfz = $this->sfont_size;
        }

        parent::Stroke($aImg, $ax, $ay);

        // For the builtin fonts we need to reduce the margins
        // since the bounding bx reported for the builtin fonts
        // are much larger than for the TTF fonts.
        if ($sff <= FF_FONT2) {
            $sx -= 2;
            $sy += 3;
        }

        $aImg->SetTextAlign('left', 'bottom');
        $aImg->SetFont($sff, $sfs, $sfz);
        $aImg->PushColor($this->color);
        $aImg->StrokeText($sx, $sy, $this->iSuper, $this->iSDir, 'left');
        $aImg->PopColor();
    }
}

//===================================================
// CLASS Grid
// Description: responsible for drawing grid lines in graph
//===================================================
class Grid
{
    protected $img;
    protected $scale;
    protected $majorcolor = '#CCCCCC', $minorcolor = '#DDDDDD';
    protected $majortype = 'solid', $minortype = 'solid';
    protected $show = false, $showMinor = false, $majorweight = 1, $minorweight = 1;
    protected $fill = false, $fillcolor = array('#EFEFEF', '#BBCCFF');

    public function __construct($aAxis)
    {
        $this->scale = $aAxis->scale;
        $this->img = $aAxis->img;
    }

    public function SetColor($aMajColor, $aMinColor = false)
    {
        $this->majorcolor = $aMajColor;
        if ($aMinColor === false) {
            $aMinColor = $aMajColor;
        }
        $this->minorcolor = $aMinColor;
    }

    public function SetWeight($aMajorWeight, $aMinorWeight = 1)
    {
        $this->majorweight = $aMajorWeight;
        $this->minorweight = $aMinorWeight;
    }

    // Specify if grid should be dashed, dotted or solid
    public function SetLineStyle($aMajorType, $aMinorType = 'solid')
    {
        $this->majortype = $aMajorType;
        $this->minortype = $aMinorType;
    }

    public function SetStyle($aMajorType, $aMinorType = 'solid')
    {
        $this->SetLineStyle($aMajorType, $aMinorType);
    }

    // Decide if both major and minor grid should be displayed
    public function Show($aShowMajor = true, $aShowMinor = false)
    {
        $this->show = $aShowMajor;
        $this->showMinor = $aShowMinor;
    }

    public function SetFill($aFlg = true, $aColor1 = 'lightgray', $aColor2 = 'lightblue')
    {
        $this->fill = $aFlg;
        $this->fillcolor = array($aColor1, $aColor2);
    }

    // Display the grid
    public function Stroke()
    {
        if ($this->showMinor && !$this->scale->textscale) {
            $this->DoStroke($this->scale->ticks->ticks_pos, $this->minortype, $this->minorcolor, $this->minorweight);
            $this->DoStroke($this->scale->ticks->maj_ticks_pos, $this->majortype, $this->majorcolor, $this->majorweight);
        } else {
            $this->DoStroke($this->scale->ticks->maj_ticks_pos, $this->majortype, $this->majorcolor, $this->majorweight);
        }
    }

    //--------------
    // Private methods
    // Draw the grid
    public function DoStroke($aTicksPos, $aType, $aColor, $aWeight)
    {
        if (!$this->show) {
            return;
        }

        $nbrgrids = count($aTicksPos);

        if ($this->scale->type == 'y') {
            $xl = $this->img->left_margin;
            $xr = $this->img->width - $this->img->right_margin;

            if ($this->fill) {
                // Draw filled areas
                $y2 = $aTicksPos[0];
                $i = 1;
                while ($i < $nbrgrids) {
                    $y1 = $y2;
                    $y2 = $aTicksPos[$i++];
                    $this->img->SetColor($this->fillcolor[$i & 1]);
                    $this->img->FilledRectangle($xl, $y1, $xr, $y2);
                }
            }

            $this->img->SetColor($aColor);
            $this->img->SetLineWeight($aWeight);

            // Draw grid lines
            switch ($aType) {
                case 'solid':$style = LINESTYLE_SOLID;
                    break;
                case 'dotted':$style = LINESTYLE_DOTTED;
                    break;
                case 'dashed':$style = LINESTYLE_DASHED;
                    break;
                case 'longdashed':$style = LINESTYLE_LONGDASH;
                    break;
                default:
                    $style = LINESTYLE_SOLID;
                    break;
            }

            for ($i = 0; $i < $nbrgrids; ++$i) {
                $y = $aTicksPos[$i];
                $this->img->StyleLine($xl, $y, $xr, $y, $style, true);
            }
        } elseif ($this->scale->type == 'x') {
            $yu = $this->img->top_margin;
            $yl = $this->img->height - $this->img->bottom_margin;
            $limit = $this->img->width - $this->img->right_margin;

            if ($this->fill) {
                // Draw filled areas
                $x2 = $aTicksPos[0];
                $i = 1;
                while ($i < $nbrgrids) {
                    $x1 = $x2;
                    $x2 = min($aTicksPos[$i++], $limit);
                    $this->img->SetColor($this->fillcolor[$i & 1]);
                    $this->img->FilledRectangle($x1, $yu, $x2, $yl);
                }
            }

            $this->img->SetColor($aColor);
            $this->img->SetLineWeight($aWeight);

            // We must also test for limit since we might have
            // an offset and the number of ticks is calculated with
            // assumption offset==0 so we might end up drawing one
            // to many gridlines
            $i = 0;
            $x = $aTicksPos[$i];
            while ($i < count($aTicksPos) && ($x = $aTicksPos[$i]) <= $limit) {
                if ($aType == 'solid') {
                    $this->img->Line($x, $yl, $x, $yu);
                } elseif ($aType == 'dotted') {
                    $this->img->DashedLineForGrid($x, $yl, $x, $yu, 1, 6);
                } elseif ($aType == 'dashed') {
                    $this->img->DashedLineForGrid($x, $yl, $x, $yu, 2, 4);
                } elseif ($aType == 'longdashed') {
                    $this->img->DashedLineForGrid($x, $yl, $x, $yu, 8, 6);
                }

                ++$i;
            }
        } else {
            JpGraphError::RaiseL(25054, $this->scale->type); //('Internal error: Unknown grid axis ['.$this->scale->type.']');
        }
        return true;
    }
} // Class

//===================================================
// CLASS Axis
// Description: Defines X and Y axis. Notes that at the
// moment the code is not really good since the axis on
// several occasion must know wheter it's an X or Y axis.
// This was a design decision to make the code easier to
// follow.
//===================================================
class AxisPrototype
{
    public $scale = null;
    public $img = null;
    public $hide = false, $hide_labels = false;
    public $title = null;
    public $font_family = FF_DEFAULT, $font_style = FS_NORMAL, $font_size = 8, $label_angle = 0;
    public $tick_step = 1;
    public $pos = false;
    public $ticks_label = array();

    protected $weight = 1;
    protected $color = array(0, 0, 0), $label_color = array(0, 0, 0);
    protected $ticks_label_colors = null;
    protected $show_first_label = true, $show_last_label = true;
    protected $label_step = 1; // Used by a text axis to specify what multiple of major steps
    // should be labeled.
    protected $labelPos = 0; // Which side of the axis should the labels be?
    protected $title_adjust, $title_margin, $title_side = SIDE_LEFT;
    protected $tick_label_margin = 5;
    protected $label_halign = '', $label_valign = '', $label_para_align = 'left';
    protected $hide_line = false;
    protected $iDeltaAbsPos = 0;

    public function __construct($img, $aScale, $color = array(0, 0, 0))
    {
        $this->img = $img;
        $this->scale = $aScale;
        $this->color = $color;
        $this->title = new Text('');

        if ($aScale->type == 'y') {
            $this->title_margin = 25;
            $this->title_adjust = 'middle';
            $this->title->SetOrientation(90);
            $this->tick_label_margin = 7;
            $this->labelPos = SIDE_LEFT;
        } else {
            $this->title_margin = 5;
            $this->title_adjust = 'high';
            $this->title->SetOrientation(0);
            $this->tick_label_margin = 5;
            $this->labelPos = SIDE_DOWN;
            $this->title_side = SIDE_DOWN;
        }
    }

    public function SetLabelFormat($aFormStr)
    {
        $this->scale->ticks->SetLabelFormat($aFormStr);
    }

    public function SetLabelFormatString($aFormStr, $aDate = false)
    {
        $this->scale->ticks->SetLabelFormat($aFormStr, $aDate);
    }

    public function SetLabelFormatCallback($aFuncName)
    {
        $this->scale->ticks->SetFormatCallback($aFuncName);
    }

    public function SetLabelAlign($aHAlign, $aVAlign = 'top', $aParagraphAlign = 'left')
    {
        $this->label_halign = $aHAlign;
        $this->label_valign = $aVAlign;
        $this->label_para_align = $aParagraphAlign;
    }

    // Don't display the first label
    public function HideFirstTickLabel($aShow = false)
    {
        $this->show_first_label = $aShow;
    }

    public function HideLastTickLabel($aShow = false)
    {
        $this->show_last_label = $aShow;
    }

    // Manually specify the major and (optional) minor tick position and labels
    public function SetTickPositions($aMajPos, $aMinPos = null, $aLabels = null)
    {
        $this->scale->ticks->SetTickPositions($aMajPos, $aMinPos, $aLabels);
    }

    // Manually specify major tick positions and optional labels
    public function SetMajTickPositions($aMajPos, $aLabels = null)
    {
        $this->scale->ticks->SetTickPositions($aMajPos, null, $aLabels);
    }

    // Hide minor or major tick marks
    public function HideTicks($aHideMinor = true, $aHideMajor = true)
    {
        $this->scale->ticks->SupressMinorTickMarks($aHideMinor);
        $this->scale->ticks->SupressTickMarks($aHideMajor);
    }

    // Hide zero label
    public function HideZeroLabel($aFlag = true)
    {
        $this->scale->ticks->SupressZeroLabel();
    }

    public function HideFirstLastLabel()
    {
        // The two first calls to ticks method will supress
        // automatically generated scale values. However, that
        // will not affect manually specified value, e.g text-scales.
        // therefor we also make a kludge here to supress manually
        // specified scale labels.
        $this->scale->ticks->SupressLast();
        $this->scale->ticks->SupressFirst();
        $this->show_first_label = false;
        $this->show_last_label = false;
    }

    // Hide the axis
    public function Hide($aHide = true)
    {
        $this->hide = $aHide;
    }

    // Hide the actual axis-line, but still print the labels
    public function HideLine($aHide = true)
    {
        $this->hide_line = $aHide;
    }

    public function HideLabels($aHide = true)
    {
        $this->hide_labels = $aHide;
    }

    // Weight of axis
    public function SetWeight($aWeight)
    {
        $this->weight = $aWeight;
    }

    // Axis color
    public function SetColor($aColor, $aLabelColor = false)
    {
        $this->color = $aColor;
        if (!$aLabelColor) {
            $this->label_color = $aColor;
        } else {
            $this->label_color = $aLabelColor;
        }

    }

    // Title on axis
    public function SetTitle($aTitle, $aAdjustAlign = 'high')
    {
        $this->title->Set($aTitle);
        $this->title_adjust = $aAdjustAlign;
    }

    // Specify distance from the axis
    public function SetTitleMargin($aMargin)
    {
        $this->title_margin = $aMargin;
    }

    // Which side of the axis should the axis title be?
    public function SetTitleSide($aSideOfAxis)
    {
        $this->title_side = $aSideOfAxis;
    }

    public function SetTickSide($aDir)
    {
        $this->scale->ticks->SetSide($aDir);
    }

    public function SetTickSize($aMajSize, $aMinSize = 3)
    {
        $this->scale->ticks->SetSize($aMajSize, $aMinSize = 3);
    }

    // Specify text labels for the ticks. One label for each data point
    public function SetTickLabels($aLabelArray, $aLabelColorArray = null)
    {
        $this->ticks_label = $aLabelArray;
        $this->ticks_label_colors = $aLabelColorArray;
    }

    public function SetLabelMargin($aMargin)
    {
        $this->tick_label_margin = $aMargin;
    }

    // Specify that every $step of the ticks should be displayed starting
    // at $start
    public function SetTextTickInterval($aStep, $aStart = 0)
    {
        $this->scale->ticks->SetTextLabelStart($aStart);
        $this->tick_step = $aStep;
    }

    // Specify that every $step tick mark should have a label
    // should be displayed starting
    public function SetTextLabelInterval($aStep)
    {
        if ($aStep < 1) {
            JpGraphError::RaiseL(25058); //(" Text label interval must be specified >= 1.");
        }
        $this->label_step = $aStep;
    }

    public function SetLabelSide($aSidePos)
    {
        $this->labelPos = $aSidePos;
    }

    // Set the font
    public function SetFont($aFamily, $aStyle = FS_NORMAL, $aSize = 10)
    {
        $this->font_family = $aFamily;
        $this->font_style = $aStyle;
        $this->font_size = $aSize;
    }

    // Position for axis line on the "other" scale
    public function SetPos($aPosOnOtherScale)
    {
        $this->pos = $aPosOnOtherScale;
    }

    // Set the position of the axis to be X-pixels delta to the right
    // of the max X-position (used to position the multiple Y-axis)
    public function SetPosAbsDelta($aDelta)
    {
        $this->iDeltaAbsPos = $aDelta;
    }

    // Specify the angle for the tick labels
    public function SetLabelAngle($aAngle)
    {
        $this->label_angle = $aAngle;
    }

} // Class

//===================================================
// CLASS Axis
// Description: Defines X and Y axis. Notes that at the
// moment the code is not really good since the axis on
// several occasion must know wheter it's an X or Y axis.
// This was a design decision to make the code easier to
// follow.
//===================================================
class Axis extends AxisPrototype
{

    public function __construct($img, $aScale, $color = 'black')
    {
        parent::__construct($img, $aScale, $color);
    }

    // Stroke the axis.
    public function Stroke($aOtherAxisScale, $aStrokeLabels = true)
    {
        if ($this->hide) {
            return;
        }

        if (is_numeric($this->pos)) {
            $pos = $aOtherAxisScale->Translate($this->pos);
        } else {
            // Default to minimum of other scale if pos not set
            if (($aOtherAxisScale->GetMinVal() >= 0 && $this->pos == false) || $this->pos == 'min') {
                $pos = $aOtherAxisScale->scale_abs[0];
            } elseif ($this->pos == "max") {
                $pos = $aOtherAxisScale->scale_abs[1];
            } else {
                // If negative set x-axis at 0
                $this->pos = 0;
                $pos = $aOtherAxisScale->Translate(0);
            }
        }

        $pos += $this->iDeltaAbsPos;
        $this->img->SetLineWeight($this->weight);
        $this->img->SetColor($this->color);
        $this->img->SetFont($this->font_family, $this->font_style, $this->font_size);

        if ($this->scale->type == "x") {
            if (!$this->hide_line) {
                // Stroke X-axis
                $this->img->FilledRectangle(
                    $this->img->left_margin,
                    $pos,
                    $this->img->width - $this->img->right_margin,
                    $pos + $this->weight - 1
                );
            }
            if ($this->title_side == SIDE_DOWN) {
                $y = $pos + $this->img->GetFontHeight() + $this->title_margin + $this->title->margin;
                $yalign = 'top';
            } else {
                $y = $pos - $this->img->GetFontHeight() - $this->title_margin - $this->title->margin;
                $yalign = 'bottom';
            }

            if ($this->title_adjust == 'high') {
                $this->title->SetPos($this->img->width - $this->img->right_margin, $y, 'right', $yalign);
            } elseif ($this->title_adjust == 'middle' || $this->title_adjust == 'center') {
                $this->title->SetPos(($this->img->width - $this->img->left_margin - $this->img->right_margin) / 2 + $this->img->left_margin, $y, 'center', $yalign);
            } elseif ($this->title_adjust == 'low') {
                $this->title->SetPos($this->img->left_margin, $y, 'left', $yalign);
            } else {
                JpGraphError::RaiseL(25060, $this->title_adjust); //('Unknown alignment specified for X-axis title. ('.$this->title_adjust.')');
            }
        } elseif ($this->scale->type == "y") {
            // Add line weight to the height of the axis since
            // the x-axis could have a width>1 and we want the axis to fit nicely together.
            if (!$this->hide_line) {
                // Stroke Y-axis
                $this->img->FilledRectangle(
                    $pos - $this->weight + 1,
                    $this->img->top_margin,
                    $pos,
                    $this->img->height - $this->img->bottom_margin + $this->weight - 1
                );
            }

            $x = $pos;
            if ($this->title_side == SIDE_LEFT) {
                $x -= $this->title_margin;
                $x -= $this->title->margin;
                $halign = 'right';
            } else {
                $x += $this->title_margin;
                $x += $this->title->margin;
                $halign = 'left';
            }
            // If the user has manually specified an hor. align
            // then we override the automatic settings with this
            // specifed setting. Since default is 'left' we compare
            // with that. (This means a manually set 'left' align
            // will have no effect.)
            if ($this->title->halign != 'left') {
                $halign = $this->title->halign;
            }
            if ($this->title_adjust == 'high') {
                $this->title->SetPos($x, $this->img->top_margin, $halign, 'top');
            } elseif ($this->title_adjust == 'middle' || $this->title_adjust == 'center') {
                $this->title->SetPos($x, ($this->img->height - $this->img->top_margin - $this->img->bottom_margin) / 2 + $this->img->top_margin, $halign, "center");
            } elseif ($this->title_adjust == 'low') {
                $this->title->SetPos($x, $this->img->height - $this->img->bottom_margin, $halign, 'bottom');
            } else {
                JpGraphError::RaiseL(25061, $this->title_adjust); //('Unknown alignment specified for Y-axis title. ('.$this->title_adjust.')');
            }
        }
        $this->scale->ticks->Stroke($this->img, $this->scale, $pos);
        if ($aStrokeLabels) {
            if (!$this->hide_labels) {
                $this->StrokeLabels($pos);
            }
            $this->title->Stroke($this->img);
        }
    }

    //---------------
    // PRIVATE METHODS
    // Draw all the tick labels on major tick marks
    public function StrokeLabels($aPos, $aMinor = false, $aAbsLabel = false)
    {

        if (is_array($this->label_color) && count($this->label_color) > 3) {
            $this->ticks_label_colors = $this->label_color;
            $this->img->SetColor($this->label_color[0]);
        } else {
            $this->img->SetColor($this->label_color);
        }
        $this->img->SetFont($this->font_family, $this->font_style, $this->font_size);
        $yoff = $this->img->GetFontHeight() / 2;

        // Only draw labels at major tick marks
        $nbr = count($this->scale->ticks->maj_ticks_label);

        // We have the option to not-display the very first mark
        // (Usefull when the first label might interfere with another
        // axis.)
        $i = $this->show_first_label ? 0 : 1;
        if (!$this->show_last_label) {
            --$nbr;
        }
        // Now run through all labels making sure we don't overshoot the end
        // of the scale.
        $ncolor = 0;
        if (isset($this->ticks_label_colors)) {
            $ncolor = count($this->ticks_label_colors);
        }
        while ($i < $nbr) {
            // $tpos holds the absolute text position for the label
            $tpos = $this->scale->ticks->maj_ticklabels_pos[$i];

            // Note. the $limit is only used for the x axis since we
            // might otherwise overshoot if the scale has been centered
            // This is due to us "loosing" the last tick mark if we center.
            if ($this->scale->type == 'x' && $tpos > $this->img->width - $this->img->right_margin + 1) {
                return;
            }
            // we only draw every $label_step label
            if (($i % $this->label_step) == 0) {

                // Set specific label color if specified
                if ($ncolor > 0) {
                    $this->img->SetColor($this->ticks_label_colors[$i % $ncolor]);
                }

                // If the label has been specified use that and in other case
                // just label the mark with the actual scale value
                $m = $this->scale->ticks->GetMajor();

                // ticks_label has an entry for each data point and is the array
                // that holds the labels set by the user. If the user hasn't
                // specified any values we use whats in the automatically asigned
                // labels in the maj_ticks_label
                if (isset($this->ticks_label[$i * $m])) {
                    $label = $this->ticks_label[$i * $m];
                } else {
                    if ($aAbsLabel) {
                        $label = abs($this->scale->ticks->maj_ticks_label[$i]);
                    } else {
                        $label = $this->scale->ticks->maj_ticks_label[$i];
                    }

                    // We number the scale from 1 and not from 0 so increase by one
                    if ($this->scale->textscale &&
                        $this->scale->ticks->label_formfunc == '' &&
                        !$this->scale->ticks->HaveManualLabels()) {

                        ++$label;

                    }
                }

                if ($this->scale->type == "x") {
                    if ($this->labelPos == SIDE_DOWN) {
                        if ($this->label_angle == 0 || $this->label_angle == 90) {
                            if ($this->label_halign == '' && $this->label_valign == '') {
                                $this->img->SetTextAlign('center', 'top');
                            } else {
                                $this->img->SetTextAlign($this->label_halign, $this->label_valign);
                            }

                        } else {
                            if ($this->label_halign == '' && $this->label_valign == '') {
                                $this->img->SetTextAlign("right", "top");
                            } else {
                                $this->img->SetTextAlign($this->label_halign, $this->label_valign);
                            }
                        }
                        $this->img->StrokeText($tpos, $aPos + $this->tick_label_margin, $label,
                            $this->label_angle, $this->label_para_align);
                    } else {
                        if ($this->label_angle == 0 || $this->label_angle == 90) {
                            if ($this->label_halign == '' && $this->label_valign == '') {
                                $this->img->SetTextAlign("center", "bottom");
                            } else {
                                $this->img->SetTextAlign($this->label_halign, $this->label_valign);
                            }
                        } else {
                            if ($this->label_halign == '' && $this->label_valign == '') {
                                $this->img->SetTextAlign("right", "bottom");
                            } else {
                                $this->img->SetTextAlign($this->label_halign, $this->label_valign);
                            }
                        }
                        $this->img->StrokeText($tpos, $aPos - $this->tick_label_margin - 1, $label,
                            $this->label_angle, $this->label_para_align);
                    }
                } else {
                    // scale->type == "y"
                    //if( $this->label_angle!=0 )
                    //JpGraphError::Raise(" Labels at an angle are not supported on Y-axis");
                    if ($this->labelPos == SIDE_LEFT) {
                        // To the left of y-axis
                        if ($this->label_halign == '' && $this->label_valign == '') {
                            $this->img->SetTextAlign("right", "center");
                        } else {
                            $this->img->SetTextAlign($this->label_halign, $this->label_valign);
                        }
                        $this->img->StrokeText($aPos - $this->tick_label_margin, $tpos, $label, $this->label_angle, $this->label_para_align);
                    } else {
                        // To the right of the y-axis
                        if ($this->label_halign == '' && $this->label_valign == '') {
                            $this->img->SetTextAlign("left", "center");
                        } else {
                            $this->img->SetTextAlign($this->label_halign, $this->label_valign);
                        }
                        $this->img->StrokeText($aPos + $this->tick_label_margin, $tpos, $label, $this->label_angle, $this->label_para_align);
                    }
                }
            }
            ++$i;
        }
    }

}

//===================================================
// CLASS DisplayValue
// Description: Used to print data values at data points
//===================================================
class DisplayValue
{
    public $margin = 5;
    public $show = false;
    public $valign = '', $halign = 'center';
    public $format = '%.1f', $negformat = '';
    private $ff = FF_DEFAULT, $fs = FS_NORMAL, $fsize = 8;
    private $iFormCallback = '';
    private $angle = 0;
    private $color = 'navy', $negcolor = '';
    private $iHideZero = false;
    public $txt = null;

    public function __construct()
    {
        $this->txt = new Text();
    }

    public function Show($aFlag = true)
    {
        $this->show = $aFlag;
    }

    public function SetColor($aColor, $aNegcolor = '')
    {
        $this->color = $aColor;
        $this->negcolor = $aNegcolor;
    }

    public function SetFont($aFontFamily, $aFontStyle = FS_NORMAL, $aFontSize = 8)
    {
        $this->ff = $aFontFamily;
        $this->fs = $aFontStyle;
        $this->fsize = $aFontSize;
    }

    public function ApplyFont($aImg)
    {
        $aImg->SetFont($this->ff, $this->fs, $this->fsize);
    }

    public function SetMargin($aMargin)
    {
        $this->margin = $aMargin;
    }

    public function SetAngle($aAngle)
    {
        $this->angle = $aAngle;
    }

    public function SetAlign($aHAlign, $aVAlign = '')
    {
        $this->halign = $aHAlign;
        $this->valign = $aVAlign;
    }

    public function SetFormat($aFormat, $aNegFormat = '')
    {
        $this->format = $aFormat;
        $this->negformat = $aNegFormat;
    }

    public function SetFormatCallback($aFunc)
    {
        $this->iFormCallback = $aFunc;
    }

    public function HideZero($aFlag = true)
    {
        $this->iHideZero = $aFlag;
    }

    public function Stroke($img, $aVal, $x, $y)
    {

        if ($this->show) {
            if ($this->negformat == '') {
                $this->negformat = $this->format;
            }
            if ($this->negcolor == '') {
                $this->negcolor = $this->color;
            }

            if ($aVal === null || (is_string($aVal) && ($aVal == '' || $aVal == '-' || $aVal == 'x'))) {
                return;
            }

            if (is_numeric($aVal) && $aVal == 0 && $this->iHideZero) {
                return;
            }

            // Since the value is used in different cirumstances we need to check what
            // kind of formatting we shall use. For example, to display values in a line
            // graph we simply display the formatted value, but in the case where the user
            // has already specified a text string we don't fo anything.
            if ($this->iFormCallback != '') {
                $f = $this->iFormCallback;
                $sval = call_user_func($f, $aVal);
            } elseif (is_numeric($aVal)) {
                if ($aVal >= 0) {
                    $sval = sprintf($this->format, $aVal);
                } else {
                    $sval = sprintf($this->negformat, $aVal);
                }
            } else {
                $sval = $aVal;
            }

            $y = $y - sign($aVal) * $this->margin;

            $this->txt->Set($sval);
            $this->txt->SetPos($x, $y);
            $this->txt->SetFont($this->ff, $this->fs, $this->fsize);
            if ($this->valign == '') {
                if ($aVal >= 0) {
                    $valign = "bottom";
                } else {
                    $valign = "top";
                }
            } else {
                $valign = $this->valign;
            }
            $this->txt->Align($this->halign, $valign);

            $this->txt->SetOrientation($this->angle);
            if ($aVal > 0) {
                $this->txt->SetColor($this->color);
            } else {
                $this->txt->SetColor($this->negcolor);
            }
            $this->txt->Stroke($img);
        }
    }
}

// Provide a deterministic list of new colors whenever the getColor() method
// is called. Used to automatically set colors of plots.
class ColorFactory
{

    private static $iIdx = 0;
    private static $iColorList = array(
        'black',
        'blue',
        'orange',
        'darkgreen',
        'red',
        'AntiqueWhite3',
        'aquamarine3',
        'azure4',
        'brown',
        'cadetblue3',
        'chartreuse4',
        'chocolate',
        'darkblue',
        'darkgoldenrod3',
        'darkorchid3',
        'darksalmon',
        'darkseagreen4',
        'deepskyblue2',
        'dodgerblue4',
        'gold3',
        'hotpink',
        'lawngreen',
        'lightcoral',
        'lightpink3',
        'lightseagreen',
        'lightslateblue',
        'mediumpurple',
        'olivedrab',
        'orangered1',
        'peru',
        'slategray',
        'yellow4',
        'springgreen2');
    private static $iNum = 33;

    public static function getColor()
    {
        if (ColorFactory::$iIdx >= ColorFactory::$iNum) {
            ColorFactory::$iIdx = 0;
        }

        return ColorFactory::$iColorList[ColorFactory::$iIdx++];
    }

}

// <EOF>
