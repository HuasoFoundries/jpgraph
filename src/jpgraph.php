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
