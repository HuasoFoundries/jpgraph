<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Image;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Text;
use Amenadiel\JpGraph\Util;
use Amenadiel\JpGraph\Util\TappableTrait;

use function count;

/**
 * @class Graph
 *  Description: Main class to handle graphs
 */
class Graph
{
    use TappableTrait;
    /**
     * @var Util\DateLocale
     */
    public $gDateLocale;

    /**
     * @var Util\DateLocale
     */
    public $gJpgDateLocale;

    /**
     * @var Image\ImgStreamCache
     */
    public $cache; // Cache object (singleton)

    public $img; // Img object (singleton)

    public $plots = []; // Array of all plot object in the graph (for Y 1 axis)

    public $y2plots = []; // Array of all plot object in the graph (for Y 2 axis)

    public $ynplots = [];

    /**
     * @var Scale\DateScale|Scale\LinearScale|Scale\LogScale|null
     */
    public $xscale; // X Scale object (could be instance of LinearScale or LogScale
    public $scale;

    /**
     * @var Scale\LinearScale|Scale\LogScale|null
     */
    public $yscale;

    /**
     * @var Scale\LinearScale|Scale\LogScale|null
     */
    public $y2scale;

    public $ynscale = [];

    public $iIcons = []; // Array of Icons to add to

    public $cache_name; // File name to be used for the current graph in the cache directory

    /**
     * @var Grid|null
     */
    public $xgrid; // X Grid object (linear or logarithmic)

    /**
     * @var Grid|null
     */
    public $ygrid;

    /**
     * @var Grid|null
     */
    public $y2grid; //dito for Y

    public $doframe;

    public $frame_color;

    public $frame_weight; // Frame around graph

    public $boxed = false;

    public $box_color = 'black';

    public $box_weight = 1; // Box around plot area

    public $doshadow = false;

    public $shadow_width = 4;

    public $shadow_color = 'gray@0.5'; // Shadow for graph

    public $xaxis; // X-axis (instane of Axis class)

    /**
     * @var Axis\Axis|null
     */
    public $yaxis;

    /**
     * @var Axis\Axis|null
     */
    public $y2axis;

    public $ynaxis = []; // Y axis (instance of Axis class)

    public $margin_color; // Margin color of graph

    public $plotarea_color = [255, 255, 255]; // Plot area color

    /**
     * @var Text\Text
     */
    public $title;

    /**
     * @var Text\Text
     */
    public $subtitle;

    /**
     * @var Text\Text
     */
    public $subsubtitle; // Title and subtitle(s) text object

    public $axtype = 'linlin'; // Type of axis

    /**
     * @var int
     *
     * @psalm-var 15|30|45|60
     */
    public $xtick_factor;

    /**
     * @var int
     *
     * @psalm-var 12|25|40|100
     */
    public $ytick_factor; // Factor to determine the maximum number of ticks depending on the plot width

    public $texts;

    public $y2texts; // Text object to ge shown in the graph

    public $lines;

    public $y2lines;

    public $bands;

    public $y2bands;

    public $text_scale_off = 0;

    public $text_scale_abscenteroff = -1; // Text scale in fractions and for centering bars

    public $background_image = '';

    public $background_image_type = -1;

    public $background_image_format = 'png';

    /**
     * @var int
     */
    public $background_image_bright = 0;

    /**
     * @var int
     */
    public $background_image_contr = 0;

    /**
     * @var int
     */
    public $background_image_sat = 0;

    public $background_image_xpos = 0;

    public $background_image_ypos = 0;

    /**
     * @var int
     */
    public $image_bright = 0;

    /**
     * @var int
     */
    public $image_contr = 0;

    /**
     * @var int
     */
    public $image_sat = 0;

    public $inline;

    /**
     * @var int
     */
    public $showcsim = 0;

    /**
     * @var string
     */
    public $csimcolor = 'red'; //debug stuff, draw the csim boundaris on the image if <>0

    public $grid_depth = Configs::DEPTH_BACK; // Draw grid under all plots as default

    public $iAxisStyle = Configs::AXSTYLE_SIMPLE;

    /**
     * @var false
     */
    public $iCSIMdisplay = false;

    /**
     * @var bool
     */
    public $iHasStroked = false;

    /**
     * @var Image\Footer
     */
    public $footer;

    /**
     * @var string
     */
    public $csimcachename = '';

    public $csimcachetimeout = 0;

    public $iCSIMImgAlt = '';

    public $iDoClipping = false;

    public $y2orderback = true;

    /**
     * @var Text\GraphTabTitle
     */
    public $tabtitle;

    public $bkg_gradtype = -1;

    public $bkg_gradstyle = Configs::BGRAD_MARGIN;

    public $bkg_gradfrom = 'navy';

    public $bkg_gradto = 'silver';

    public $plot_gradtype = -1;

    public $plot_gradstyle = Configs::BGRAD_MARGIN;

    public $plot_gradfrom = 'silver';

    public $plot_gradto = 'navy';

    public $titlebackground = false;

    public $titlebackground_color = 'lightblue';

    public $titlebackground_style = 1;

    public $titlebackground_framecolor;

    public $titlebackground_framestyle;

    public $titlebackground_frameweight;

    public $titlebackground_bevelheight;

    public $titlebkg_fillstyle = Configs::TITLEBKG_FILLSTYLE_SOLID;

    public $titlebkg_scolor1 = 'black';

    public $titlebkg_scolor2 = 'white';

    public $framebevel;

    public $framebeveldepth;

    public $framebevelborder;

    public $framebevelbordercolor;

    public $framebevelcolor1;

    public $framebevelcolor2;

    public $background_image_mix = 100;

    public $background_cflag = '';

    public $background_cflag_type = Configs::BGIMG_FILLPLOT;

    public $background_cflag_mix = 100;

    /**
     * @var bool
     */
    public $iImgTrans = false;

    public $iImgTransHorizon = 100;

    public $iImgTransSkewDist = 150;

    public $iImgTransDirection = 1;

    public $iImgTransMinSize = true;

    public $iImgTransFillColor = 'white';

    public $iImgTransHighQ = false;

    public $iImgTransBorder = false;

    public $iImgTransHorizonPos = 0.5;

    /**
     * @var Legend
     */
    public $legend;

    public $graph_theme;

    protected $iYAxisDeltaPos = 50;

    protected $iIconDepth = Configs::DEPTH_BACK;

    protected $iAxisLblBgType = 0;

    protected $iXAxisLblBgFillColor = 'lightgray';

    protected $iXAxisLblBgColor = 'black';

    protected $iYAxisLblBgFillColor = 'lightgray';

    protected $iYAxisLblBgColor = 'black';

    protected $iTables;

    /**
     * @var bool
     */
    protected $isRunningClear = false;

    protected $inputValues;

    /**
     * @var bool
     */
    protected $isAfterSetScale = false;

    // aWIdth   Width in pixels of image
    // aHeight   Height in pixels of image
    // aCachedName Name for image file in cache directory
    // aTimeOut  Timeout in minutes for image in cache
    // aInline  If true the image is streamed back in the call to Stroke()
    //   If false the image is just created in the cache
    public function __construct($aWidth = 300, $aHeight = 200, $aCachedName = '', $aTimeout = 0, $aInline = true)
    {
        // Bootstrap configs repository if it hasn't bootstrapped already
        Util\Helper::bootstrapLibrary();

        $this->gDateLocale = new Util\DateLocale();
        $this->gJpgDateLocale = new Util\DateLocale();

        if (!\is_numeric($aWidth) || !\is_numeric($aHeight)) {
            throw      Util\JpGraphError::make(25008); //('Image width/height argument in Graph::Graph() must be numeric');
        }

        // Initialize frame and margin
        $this->InitializeFrameAndMargin();

        // Automatically generate the image file name based on the name of the script that
        // generates the graph
        if ('auto' === $aCachedName) {
            $aCachedName = Util\Helper::GenImgName();
        }

        // Should the image be streamed back to the browser or only to the cache?
        $this->inline = $aInline;

        $this->img = new Image\RotImage($aWidth, $aHeight);
        $this->cache = new Image\ImgStreamCache();

        // Window doesn't like '?' in the file name so replace it with an '_'
        $aCachedName = \str_replace('?', '_', $aCachedName);
        $this->SetupCache($aCachedName, $aTimeout);

        $this->title = new Text\Text();
        $this->title->ParagraphAlign('center');
        $this->title->SetFont(Configs::getConfig('FF_DEFAULT'), Configs::getConfig('FS_NORMAL')); //Configs::getConfig('FF_FONT2'), Configs::getConfig('FS_BOLD')
        $this->title->SetMargin(5);
        $this->title->SetAlign('center');

        $this->subtitle = new Text\Text();
        $this->subtitle->ParagraphAlign('center');
        $this->subtitle->SetMargin(3);
        $this->subtitle->SetAlign('center');

        $this->subsubtitle = new Text\Text();
        $this->subsubtitle->ParagraphAlign('center');
        $this->subsubtitle->SetMargin(3);
        $this->subsubtitle->SetAlign('center');

        $this->legend = new Legend();
        $this->footer = new Image\Footer();

        // If the cached version exist just read it directly from the
        // cache, stream it back to browser and exit
        if ('' !== $aCachedName && Configs::getConfig('READ_CACHE') && $aInline) {
            if ($this->cache->GetAndStream($this->img, $aCachedName)) {
                exit;
            }
        }

        $this->SetTickDensity(); // Normal density

        $this->tabtitle = new Text\GraphTabTitle();

        if (!$this->isRunningClear) {
            $this->inputValues = [];
            $this->inputValues['aWidth'] = $aWidth;
            $this->inputValues['aHeight'] = $aHeight;
            $this->inputValues['aCachedName'] = $aCachedName;
            $this->inputValues['aTimeout'] = $aTimeout;
            $this->inputValues['aInline'] = $aInline;

            $theme_class = '\Amenadiel\JpGraph\Themes\\' . Configs::getConfig('DEFAULT_THEME_CLASS');

            if (\class_exists($theme_class)) {
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
        $this->titlebkg_fillstyle = Configs::getConfig('TITLEBKG_FILLSTYLE_SOLID');
        $this->titlebkg_scolor1 = 'black';
        $this->titlebkg_scolor2 = 'white';
        $this->framebevel = false;
        $this->framebeveldepth = 2;
        $this->framebevelborder = false;
        $this->framebevelbordercolor = 'black';
        $this->framebevelcolor1 = 'white@0.4';
        $this->framebevelcolor2 = 'black@0.4';

        $this->margin_color = [250, 250, 250];
    }

    /**
     * @param string $aFilename
     */
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
    /**
     * @param int $aDepth
     */
    public function SetGridDepth($aDepth)
    {
        $this->grid_depth = $aDepth;
    }

    public function SetIconDepth($aDepth)
    {
        $this->iIconDepth = $aDepth;
    }

    // Specify graph angle 0-360 degrees.
    /**
     * @param int $aAngle
     */
    public function SetAngle($aAngle)
    {
        $this->img->SetAngle($aAngle);
    }

    public function SetAlphaBlending($aFlg = true)
    {
        $this->img->SetAlphaBlending($aFlg);
    }

    // Shortcut to image margin
    /**
     * @param int $lm
     * @param int $rm
     * @param int $tm
     * @param int $bm
     */
    public function SetMargin($lm, $rm, $tm, $bm)
    {
        $this->img->SetMargin($lm, $rm, $tm, $bm);
        return $this;
    }

    public function SetY2OrderBack($aBack = true)
    {
        $this->y2orderback = $aBack;
        return $this;
    }

    // Rotate the graph 90 degrees and set the margin
    // when we have done a 90 degree rotation
    public function Set90AndMargin($lm = 0, $rm = 0, $tm = 0, $bm = 0)
    {
        $lm = 0 === $lm ? \floor(0.2 * $this->img->width) : $lm;
        $rm = 0 === $rm ? \floor(0.1 * $this->img->width) : $rm;
        $tm = 0 === $tm ? \floor(0.2 * $this->img->height) : $tm;
        $bm = 0 === $bm ? \floor(0.1 * $this->img->height) : $bm;

        $adj = ($this->img->height - $this->img->width) / 2;
        $this->img->SetMargin($tm - $adj, $bm - $adj, $rm + $adj, $lm + $adj);
        $this->img->SetCenter(\floor($this->img->width / 2), \floor($this->img->height / 2));
        $this->SetAngle(90);

        if (empty($this->yaxis) || empty($this->xaxis)) {
            throw      Util\JpGraphError::make(25009); //('You must specify what scale to use with a call to Graph::SetScale()');
        }
        $this->xaxis->SetLabelAlign('right', 'center');
        $this->yaxis->SetLabelAlign('center', 'bottom');
        return $this;
    }

    public function SetClipping($aFlg = true)
    {
        $this->iDoClipping = $aFlg;
        return $this;
    }

    // Add a plot object to the graph
    /**
     * @param (Plot\LinePlot|mixed)[]|Text\Text $aPlot
     */
    public function Add($aPlot):self
    {
        if (null === $aPlot) {
            throw      Util\JpGraphError::make(25010); //("Graph::Add() You tried to add a null plot to the graph.");
        }

        if (\is_array($aPlot) && Configs::safe_count($aPlot) > 0) {
            $cl = $aPlot[0];
        } else {
            $cl = $aPlot;
        }

        if ($cl instanceof Text\Text) {
            $this->AddText($aPlot);
        } elseif (($cl instanceof Plot\PlotLine)) {
            $this->AddLine($aPlot);
        } elseif (($cl instanceof Plot\PlotBand)) {
            $this->AddBand($aPlot);
        } elseif (($cl instanceof Plot\IconPlot)) {
            $this->AddIcon($aPlot);
        } elseif (($cl instanceof Text\GTextTable)) {
            $this->AddTable($aPlot);
        } else {
            if (\is_array($aPlot)) {
                $this->plots = \array_merge($this->plots, $aPlot);
            } else {
                $this->plots[] = $aPlot;
            }
        }

        if ($this->graph_theme) {
            $this->graph_theme->SetupPlot($aPlot);
        }


        return $this;
    }

    public function AddTable($aTable)
    {
        if (\is_array($aTable)) {
            for ($i = 0; Configs::safe_count($aTable) > $i; ++$i) {
                $this->iTables[] = $aTable[$i];
            }
        } else {
            $this->iTables[] = $aTable;
        }
        return $this;
    }

    /**
     * @param Plot\IconPlot|array $aIcon
     */
    public function AddIcon($aIcon)
    {
        if (\is_array($aIcon)) {
            for ($i = 0; Configs::safe_count($aIcon) > $i; ++$i) {
                $this->iIcons[] = $aIcon[$i];
            }
        } else {
            $this->iIcons[] = $aIcon;
        }
        return $this;
    }

    // Add plot to second Y-scale
    public function AddY2($aPlot)
    {
        if (null === $aPlot) {
            throw      Util\JpGraphError::make(25011); //("Graph::AddY2() You tried to add a null plot to the graph.");
        }

        if (\is_array($aPlot) && Configs::safe_count($aPlot) > 0) {
            $cl = $aPlot[0];
        } else {
            $cl = $aPlot;
        }

        if ($cl instanceof Text\Text) {
            $this->AddText($aPlot, true);
        } elseif (($cl instanceof Plot\PlotLine)) {
            $this->AddLine($aPlot, true);
        } elseif (($cl instanceof Plot\PlotBand)) {
            $this->AddBand($aPlot, true);
        } else {
            $this->y2plots[] = $aPlot;
        }

        if (!$this->graph_theme) {
            return;
        }

        $this->graph_theme->SetupPlot($aPlot);
    }

    // Add plot to the extra Y-axises
    public function AddY($aN, $aPlot)
    {
        if (null === $aPlot) {
            throw      Util\JpGraphError::make(25012); //("Graph::AddYN() You tried to add a null plot to the graph.");
        }

        if (\is_array($aPlot) && Configs::safe_count($aPlot) > 0) {
            $cl = $aPlot[0];
        } else {
            $cl = $aPlot;
        }

        if (($cl instanceof Text\Text)
            || ($cl instanceof Plot\PlotLine)
            || ($cl instanceof Plot\PlotBand)
        ) {
            throw      Util\JpGraphError::make(25013); //('You can only add standard plots to multiple Y-axis');
        } else {
            $this->ynplots[$aN][] = $aPlot;
        }

        if (!$this->graph_theme) {
            return;
        }

        $this->graph_theme->SetupPlot($aPlot);
    }

    // Add text object to the graph
    /**
     * @param Text\Text|array $aTxt
     * @param bool $aToY2
     */
    public function AddText($aTxt, $aToY2 = false)
    {
        if (null === $aTxt) {
            throw      Util\JpGraphError::make(25014); //("Graph::AddText() You tried to add a null text to the graph.");
        }

        if ($aToY2) {
            if (\is_array($aTxt)) {
                for ($i = 0; Configs::safe_count($aTxt) > $i; ++$i) {
                    $this->y2texts[] = $aTxt[$i];
                }
            } else {
                $this->y2texts[] = $aTxt;
            }
        } else {
            if (\is_array($aTxt)) {
                for ($i = 0; Configs::safe_count($aTxt) > $i; ++$i) {
                    $this->texts[] = $aTxt[$i];
                }
            } else {
                $this->texts[] = $aTxt;
            }
        }
    }

    // Add a line object (class PlotLine) to the graph
    /**
     * @param bool $aToY2
     */
    public function AddLine($aLine, $aToY2 = false)
    {
        if (null === $aLine) {
            throw      Util\JpGraphError::make(25015); //("Graph::AddLine() You tried to add a null line to the graph.");
        }

        if ($aToY2) {
            if (\is_array($aLine)) {
                for ($i = 0; Configs::safe_count($aLine) > $i; ++$i) {
                    //$this->y2lines[]=$aLine[$i];
                    $this->y2plots[] = $aLine[$i];
                }
            } else {
                //$this->y2lines[] = $aLine;
                $this->y2plots[] = $aLine;
            }
        } else {
            if (\is_array($aLine)) {
                for ($i = 0; Configs::safe_count($aLine) > $i; ++$i) {
                    //$this->lines[]=$aLine[$i];
                    $this->plots[] = $aLine[$i];
                }
            } else {
                //$this->lines[] = $aLine;
                $this->plots[] = $aLine;
            }
        }
        return $this;
    }

    // Add vertical or horizontal band
    /**
     * @param bool $aToY2
     */
    public function AddBand($aBand, $aToY2 = false)
    {
        if (null === $aBand) {
            throw      Util\JpGraphError::make(25016); //(" Graph::AddBand() You tried to add a null band to the graph.");
        }

        if ($aToY2) {
            if (\is_array($aBand)) {
                for ($i = 0; Configs::safe_count($aBand) > $i; ++$i) {
                    $this->y2bands[] = $aBand[$i];
                }
            } else {
                $this->y2bands[] = $aBand;
            }
        } else {
            if (\is_array($aBand)) {
                for ($i = 0; Configs::safe_count($aBand) > $i; ++$i) {
                    $this->bands[] = $aBand[$i];
                }
            } else {
                $this->bands[] = $aBand;
            }
        }
        return $this;
    }

    public function SetPlotGradient($aFrom = 'navy', $aTo = 'silver', $aGradType = 2)
    {
        $this->plot_gradtype = $aGradType;
        $this->plot_gradfrom = $aFrom;
        $this->plot_gradto = $aTo;
        return $this;
    }

    public function SetBackgroundGradient($aFrom = 'navy', $aTo = 'silver', $aGradType = 2, $aStyle = Configs::BGRAD_FRAME)
    {
        $this->bkg_gradtype = $aGradType;
        $this->bkg_gradstyle = $aStyle;
        $this->bkg_gradfrom = $aFrom;
        $this->bkg_gradto = $aTo;
        return $this;
    }

    // Set a country flag in the background
    public function SetBackgroundCFlag($aName, $aBgType = Configs::BGIMG_FILLPLOT, $aMix = 100)
    {
        $this->background_cflag = $aName;
        $this->background_cflag_type = $aBgType;
        $this->background_cflag_mix = $aMix;
        return $this;
    }

    // Alias for the above method
    public function SetBackgroundCountryFlag($aName, $aBgType = Configs::BGIMG_FILLPLOT, $aMix = 100)
    {
        $this->background_cflag = $aName;
        $this->background_cflag_type = $aBgType;
        $this->background_cflag_mix = $aMix;
        return $this;
    }

    // Specify a background image
    public function SetBackgroundImage($aFileName, $aBgType = Configs::BGIMG_FILLPLOT, $aImgFormat = 'auto')
    {
        // Get extension to determine image type
        if ('auto' === $aImgFormat) {
            $e = \explode('.', $aFileName);

            if (empty($e)) {
                throw      Util\JpGraphError::make(25018, $aFileName); //('Incorrect file name for Graph::SetBackgroundImage() : '.$aFileName.' Must have a valid image extension (jpg,gif,png) when using autodetection of image type');
            }

            $valid_formats = ['png', 'jpg', 'gif'];
            $aImgFormat = \mb_strtolower($e[\count($e) - 1]);

            if ('jpeg' === $aImgFormat) {
                $aImgFormat = 'jpg';
            } elseif (!\in_array($aImgFormat, $valid_formats, true)) {
                throw      Util\JpGraphError::make(25019, $aImgFormat); //('Unknown file extension ($aImgFormat) in Graph::SetBackgroundImage() for filename: '.$aFileName);
            }
        }

        $this->background_image = $aFileName;
        $this->background_image_type = $aBgType;
        $this->background_image_format = $aImgFormat;
        return $this;
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
        return $this;
    }

    // Specify axis style (boxed or single)
    public function SetAxisStyle($aStyle)
    {
        $this->iAxisStyle = $aStyle;
        return $this;
    }

    // Set a frame around the plot area
    /**
     * @param true $aDrawPlotFrame
     * @param int[]|string $aPlotFrameColor
     */
    public function SetBox($aDrawPlotFrame = true, $aPlotFrameColor = [0, 0, 0], $aPlotFrameWeight = 1)
    {
        $this->boxed = $aDrawPlotFrame;
        $this->box_weight = $aPlotFrameWeight;
        $this->box_color = $aPlotFrameColor;
        return $this;
    }

    // Specify color for the plotarea (not the margins)
    public function SetColor($aColor)
    {
        $this->plotarea_color = $aColor;
        return $this;
    }

    // Specify color for the margins (all areas outside the plotarea)
    /**
     * @param string $aColor
     */
    public function SetMarginColor($aColor)
    {
        $this->margin_color = $aColor;
        return $this;
    }

    // Set a frame around the entire image
    public function SetFrame($aDrawImgFrame = true, $aImgFrameColor = [0, 0, 0], $aImgFrameWeight = 1)
    {
        $this->doframe = $aDrawImgFrame;
        $this->frame_color = $aImgFrameColor;
        $this->frame_weight = $aImgFrameWeight;
        return $this;
    }

    public function SetFrameBevel($aDepth = 3, $aBorder = false, $aBorderColor = 'black', $aColor1 = 'white@0.4', $aColor2 = 'darkgray@0.4', $aFlg = true)
    {
        $this->framebevel = $aFlg;
        $this->framebeveldepth = $aDepth;
        $this->framebevelborder = $aBorder;
        $this->framebevelbordercolor = $aBorderColor;
        $this->framebevelcolor1 = $aColor1;
        $this->framebevelcolor2 = $aColor2;
        return $this;

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
        return $this;
    }

    // Specify x,y scale. Note that if you manually specify the scale
    // you must also specify the tick distance with a call to Ticks::Set()
    /**
     * @param string $aAxisType
     * @param float|int $aYMin
     * @param float|int $aYMax
     * @param float|int $aXMin
     * @param float|int $aXMax
     */
    public function SetScale($aAxisType, $aYMin = 1, $aYMax = 1, $aXMin = 1, $aXMax = 1): self
    {
        $this->axtype = $aAxisType;

        if ($aYMax < $aYMin || $aXMax < $aXMin) {
            throw      Util\JpGraphError::make(25020); //('Graph::SetScale(): Specified Max value must be larger than the specified Min value.');
        }

        $yt = \mb_substr($aAxisType, -3, 3);

        if ('lin' === $yt) {
            $this->yscale = new Scale\LinearScale($aYMin, $aYMax);
        } elseif ('int' === $yt) {
            $this->yscale = new Scale\LinearScale($aYMin, $aYMax);
            $this->yscale->SetIntScale();
        } elseif ('log' === $yt) {
            $this->yscale = new Scale\LogScale($aYMin, $aYMax);
        } else {
            throw      Util\JpGraphError::make(25021, $aAxisType); //("Unknown scale specification for Y-scale. ($aAxisType)");
        }

        $xt = \mb_substr($aAxisType, 0, 3);

        if ('lin' === $xt || 'tex' === $xt) {
            $this->xscale = new Scale\LinearScale($aXMin, $aXMax, 'x');
            $this->xscale->textscale = ('tex' === $xt);
        } elseif ('int' === $xt) {
            $this->xscale = new Scale\LinearScale($aXMin, $aXMax, 'x');
            $this->xscale->SetIntScale();
        } elseif ('dat' === $xt) {
            $this->xscale = new Scale\DateScale($aXMin, $aXMax, 'x');
        } elseif ('log' === $xt) {
            $this->xscale = new Scale\LogScale($aXMin, $aXMax, 'x');
        } else {
            throw      Util\JpGraphError::make(25022, $aAxisType); //(" Unknown scale specification for X-scale. ($aAxisType)");
        }

        $this->xaxis = new Axis\Axis($this->img, $this->xscale);
        $this->yaxis = new Axis\Axis($this->img, $this->yscale);
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
        return $this;
    }

    // Specify secondary Y scale
    public function SetY2Scale($aAxisType = 'lin', $aY2Min = 1, $aY2Max = 1)
    {
        if ('lin' === $aAxisType) {
            $this->y2scale = new Scale\LinearScale($aY2Min, $aY2Max);
        } elseif ('int' === $aAxisType) {
            $this->y2scale = new Scale\LinearScale($aY2Min, $aY2Max);
            $this->y2scale->SetIntScale();
        } elseif ('log' === $aAxisType) {
            $this->y2scale = new Scale\LogScale($aY2Min, $aY2Max);
        } else {
            throw      Util\JpGraphError::make(25023, $aAxisType); //("JpGraph: Unsupported Y2 axis type: $aAxisType\nMust be one of (lin,log,int)");
        }

        $this->y2axis = new Axis\Axis($this->img, $this->y2scale);
        $this->y2axis->scale->ticks->SetDirection(Configs::getConfig('SIDE_LEFT'));
        $this->y2axis->SetLabelSide(Configs::getConfig('SIDE_RIGHT'));
        $this->y2axis->SetPos('max');
        $this->y2axis->SetTitleSide(Configs::getConfig('SIDE_RIGHT'));

        // Deafult position is the max x-value
        $this->y2grid = new Grid($this->y2axis);

        if (!$this->graph_theme) {
            return;
        }

        $this->graph_theme->ApplyGraph($this);
        return $this;
    }

    // Set the delta position (in pixels) between the multiple Y-axis
    public function SetYDeltaDist($aDist)
    {
        $this->iYAxisDeltaPos = $aDist;
        return $this;
    }

    // Specify secondary Y scale
    public function SetYScale($aN, $aAxisType = 'lin', $aYMin = 1, $aYMax = 1): self
    {
        if ('lin' === $aAxisType) {
            $this->ynscale[$aN] = new Scale\LinearScale($aYMin, $aYMax);
        } elseif ('int' === $aAxisType) {
            $this->ynscale[$aN] = new Scale\LinearScale($aYMin, $aYMax);
            $this->ynscale[$aN]->SetIntScale();
        } elseif ('log' === $aAxisType) {
            $this->ynscale[$aN] = new Scale\LogScale($aYMin, $aYMax);
        } else {
            throw      Util\JpGraphError::make(25024, $aAxisType); //("JpGraph: Unsupported Y axis type: $aAxisType\nMust be one of (lin,log,int)");
        }

        $this->ynaxis[$aN] = new Axis\Axis($this->img, $this->ynscale[$aN]);
        $this->ynaxis[$aN]->scale->ticks->SetDirection(Configs::getConfig('SIDE_LEFT'));
        $this->ynaxis[$aN]->SetLabelSide(Configs::getConfig('SIDE_RIGHT'));

        if ($this->graph_theme) {
            $this->graph_theme->ApplyGraph($this);
        }


        return $this;
    }

    // Specify density of ticks when autoscaling 'normal', 'dense', 'sparse', 'verysparse'
    // The dividing factor have been determined heuristically according to my aesthetic
    // sense (or lack off) y.m.m.v !
    /**
     * @param int $aYDensity
     */
    public function SetTickDensity($aYDensity = Configs::TICKD_NORMAL, $aXDensity = Configs::TICKD_NORMAL): self
    {
        $this->xtick_factor = 30;
        $this->ytick_factor = 25;

        switch ($aYDensity) {
            case Configs::getConfig('TICKD_DENSE'):
                $this->ytick_factor = 12;

                break;
            case Configs::getConfig('TICKD_NORMAL'):
                $this->ytick_factor = 25;

                break;
            case Configs::getConfig('TICKD_SPARSE'):
                $this->ytick_factor = 40;

                break;
            case Configs::getConfig('TICKD_VERYSPARSE'):
                $this->ytick_factor = 100;

                break;

            default:
                throw      Util\JpGraphError::make(25025, $aYDensity); //("JpGraph: Unsupported Tick density: $densy");
        }

        switch ($aXDensity) {
            case Configs::getConfig('TICKD_DENSE'):
                $this->xtick_factor = 15;

                break;
            case Configs::getConfig('TICKD_NORMAL'):
                $this->xtick_factor = 30;

                break;
            case Configs::getConfig('TICKD_SPARSE'):
                $this->xtick_factor = 45;

                break;
            case Configs::getConfig('TICKD_VERYSPARSE'):
                $this->xtick_factor = 60;

                break;

            default:
                throw      Util\JpGraphError::make(25025, $aXDensity); //("JpGraph: Unsupported Tick density: $densx");
        }
        return $this;
    }

    // Get a string of all image map areas
    public function GetCSIMareas()
    {
        if (!$this->iHasStroked) {
            $this->Stroke(Configs::getConfig('_CSIM_SPECIALFILE'));
        }

        $csim = $this->title->GetCSIMAreas();
        $csim .= $this->subtitle->GetCSIMAreas();
        $csim .= $this->subsubtitle->GetCSIMAreas();
        $csim .= $this->legend->GetCSIMAreas();

        if (null !== $this->y2axis) {
            $csim .= $this->y2axis->title->GetCSIMAreas();
        }

        if (null !== $this->texts) {
            $n = Configs::safe_count($this->texts);

            for ($i = 0; $i < $n; ++$i) {
                $csim .= $this->texts[$i]->GetCSIMAreas();
            }
        }

        if (null !== $this->y2texts && null !== $this->y2scale) {
            $n = Configs::safe_count($this->y2texts);

            for ($i = 0; $i < $n; ++$i) {
                $csim .= $this->y2texts[$i]->GetCSIMAreas();
            }
        }

        if (null !== $this->yaxis && null !== $this->xaxis) {
            $csim .= $this->yaxis->title->GetCSIMAreas();
            $csim .= $this->xaxis->title->GetCSIMAreas();
        }

        $n = Configs::safe_count($this->plots);

        for ($i = 0; $i < $n; ++$i) {
            $csim .= $this->plots[$i]->GetCSIMareas();
        }

        $n = Configs::safe_count($this->y2plots);

        for ($i = 0; $i < $n; ++$i) {
            $csim .= $this->y2plots[$i]->GetCSIMareas();
        }

        $n = Configs::safe_count($this->ynaxis);

        for ($i = 0; $i < $n; ++$i) {
            $m = Configs::safe_count($this->ynplots[$i]);

            for ($j = 0; $j < $m; ++$j) {
                $csim .= $this->ynplots[$i][$j]->GetCSIMareas();
            }
        }

        $n = Configs::safe_count($this->iTables);

        for ($i = 0; $i < $n; ++$i) {
            $csim .= $this->iTables[$i]->GetCSIMareas();
        }

        return $csim;
    }

    // Get a complete <MAP>..</MAP> tag for the final image map
    public function GetHTMLImageMap($aMapName)
    {
        $im = "<map name=\"{$aMapName}\" id=\"{$aMapName}\" >\n";
        $im .= $this->GetCSIMareas();
        $im .= '</map>';

        return $im;
    }



    // Build the argument string to be used with the csim images
    /**
     * @param bool $aAddRecursiveBlocker
     */
    private function GetURLArguments($aAddRecursiveBlocker = false)
    {
        if ($aAddRecursiveBlocker) {
            // This is a Configs::getConfig('JPGRAPH') internal defined that prevents
            // us from recursively coming here again
            $urlarg = Configs::getConfig('_CSIM_DISPLAY') . '=1';
        }

        // Now reconstruct any user URL argument
        \reset($_GET);

        foreach ($_GET as $key => $value) {
            if (\is_array($value)) {
                foreach ($value as $k => $v) {
                    $urlarg .= '&amp;' . $key . '%5B' . $k . '%5D=' . \urlencode($v);
                }
            } else {
                $urlarg .= '&amp;' . $key . '=' . \urlencode($value);
            }
        }

        // It's not ideal to convert Configs::getConfig('POST') argument to GET arguments
        // but there is little else we can do. One idea for the
        // future might be recreate the Configs::getConfig('POST') header in case.
        \reset($_POST);

        foreach ($_POST as $key => $value) {
            if (\is_array($value)) {
                foreach ($value as $k => $v) {
                    $urlarg .= '&amp;' . $key . '%5B' . $k . '%5D=' . \urlencode($v);
                }
            } else {
                $urlarg .= '&amp;' . $key . '=' . \urlencode($value);
            }
        }

        return $urlarg;
    }


    public function StrokeCSIM($aScriptName = 'auto', $aCSIMName = '', $aBorder = 0)
    {
        $microtime = \microtime(true);
        $random = $microtime * 1000000;

        if ('' === $aCSIMName) {
            // create a random map name
            \mt_srand((int) $random);
            $r = \mt_rand(0, 100000);
            $aCSIMName = '__mapname' . $r . '__';
        }

        if ('auto' === $aScriptName) {
            $aScriptName = \basename($_SERVER['PHP_SELF']);
        }



        if (empty($_GET[Configs::getConfig('_CSIM_DISPLAY')])) {
            // First determine if we need to check for a cached version
            // This differs from the standard cache in the sense that the
            // image and Configs::getConfig('CSIM') map Configs::getConfig('HTML') file is written relative to the directory
            // the script executes in and not the specified cache directory.
            // The reason for this is that the cache directory is not necessarily
            // accessible from the Configs::getConfig('HTTP') server.
            if ('' !== $this->csimcachename) {
                $this->getCSIMImageFromCache($aCSIMName);
            } else {
                if ('' === $aScriptName) {
                    throw      Util\JpGraphError::make(25030); //('Missing script name in call to StrokeCSIM(). You must specify the name of the actual image script as the first parameter to StrokeCSIM().');
                }
                echo $this->GetHTMLImageMap($aCSIMName) . $this->GetCSIMImgHTML($aCSIMName, $aScriptName, $aBorder);
            }
        } else {
            $this->Stroke();
        }
    }
    private function getCSIMImageFromCache(string  $aCSIMName)
    {
        $dir = \dirname($this->csimcachename);
        $base = \basename($this->csimcachename);
        $base = \strtok($base, '.');
        $suffix = \strtok('.');
        $urlarg = $this->GetURLArguments(true);
        $basecsim = $dir . '/' . $base . '?' . $urlarg . '_csim_.html';
        $baseimg = $base . '?' . $urlarg . '.' . $this->img->img_format;

        // Check that apache can write to directory specified

        if (\file_exists($dir) && !\is_writable($dir)) {
            throw      Util\JpGraphError::make(25028, $dir); //('Apache/PHP does not have permission to write to the Configs::getConfig('CSIM') cache directory ('.$dir.'). Check permissions.');
        }

        // Make sure directory exists
        $this->cache->MakeDirs($dir);

        // Write the image file
        $this->Stroke(Configs::getConfig('CSIMCACHE_DIR') . $baseimg);

        // Construct wrapper Configs::getConfig('HTML') and write to file and send it back to browser

        // In the src URL we must replace the '?' with its encoding to prevent the arguments
        // to be converted to real arguments.
        $tmp = \str_replace('?', '%3f', $baseimg);
        $htmlwrap = $this->GetHTMLImageMap($aCSIMName) . "\n" .
            '<img src="' . Configs::getConfig('CSIMCACHE_HTTP_DIR')
            . $tmp . '" ismap="ismap" usemap="#'
            . $aCSIMName . ' width="'
            . $this->img->width . '" height="'
            . $this->img->height . '" alt="'
            . $this->iCSIMImgAlt . "\" />\n";

        if ($fh = \fopen($basecsim, 'wb')) {
            \fwrite($fh, $htmlwrap);
            \fclose($fh);
            echo $htmlwrap;
        } else {
            throw      Util\JpGraphError::make(25029, $basecsim); //(" Can't write Configs::getConfig('CSIM') \"$basecsim\" for writing. Check free space and permissions.");
        }
    }
    public function StrokeCSIMImage()
    {
        if (1 !== $_GET[Configs::getConfig('_CSIM_DISPLAY')]) {
            return;
        }

        $this->Stroke();
    }

    public function GetCSIMImgHTML($aCSIMName, $aScriptName = 'auto', $aBorder = 0)
    {
        if ('auto' === $aScriptName) {
            $aScriptName = \basename($_SERVER['PHP_SELF']);
        }
        $urlarg = $this->GetURLArguments(true);

        return '<img src="' . $aScriptName . '?' . $urlarg . '" ismap="ismap" usemap="#' . $aCSIMName . '" height="' . $this->img->height . '" alt="' . $this->iCSIMImgAlt . "\" />\n";
    }

    /**
     * @param bool $aY2
     */
    public function GetTextsYMinMax($aY2 = false)
    {
        if ($aY2) {
            $txts = $this->y2texts;
        } else {
            $txts = $this->texts;
        }
        $n = Configs::safe_count($txts);
        $min = null;
        $max = null;

        for ($i = 0; $i < $n; ++$i) {
            if (null === $txts[$i]->iScalePosY || null === $txts[$i]->iScalePosX) {
                continue;
            }

            if (null === $min) {
                $min = $max = $txts[$i]->iScalePosY;
            } else {
                $min = \min($min, $txts[$i]->iScalePosY);
                $max = \max($max, $txts[$i]->iScalePosY);
            }
        }

        if (null !== $min) {
            return [$min, $max];
        }

        return null;
    }

    /**
     * @param bool $aY2
     */
    public function GetTextsXMinMax($aY2 = false)
    {
        if ($aY2) {
            $txts = $this->y2texts;
        } else {
            $txts = $this->texts;
        }
        $n = Configs::safe_count($txts);
        $min = null;
        $max = null;

        for ($i = 0; $i < $n; ++$i) {
            if (null === $txts[$i]->iScalePosY || null === $txts[$i]->iScalePosX) {
                continue;
            }

            if (null === $min) {
                $min = $max = $txts[$i]->iScalePosX;
            } else {
                $min = \min($min, $txts[$i]->iScalePosX);
                $max = \max($max, $txts[$i]->iScalePosX);
            }
        }

        if (null !== $min) {
            return [$min, $max];
        }

        return null;
    }

    public function GetXMinMax()
    {
        [$min, $ymin] = $this->plots[0]->Min();
        [$max, $ymax] = $this->plots[0]->Max();

        $i = 0;
        // Some plots, e.g. PlotLine should not affect the scale
        // and will return (null,null). We should ignore those
        // values.
        while ((null === $min || null === $max) && (Configs::safe_count($this->plots) - 1 > $i)) {
            ++$i;
            [$min, $ymin] = $this->plots[$i]->Min();
            [$max, $ymax] = $this->plots[$i]->Max();
        }

        foreach ($this->plots as $p) {
            [$xmin, $ymin] = $p->Min();
            [$xmax, $ymax] = $p->Max();

            if (null === $xmin || null === $xmax) {
                continue;
            }

            $min = \min($xmin, $min);
            $max = \max($xmax, $max);
        }

        if (null !== $this->y2axis) {
            foreach ($this->y2plots as $p) {
                [$xmin, $ymin] = $p->Min();
                [$xmax, $ymax] = $p->Max();
                $min = \min($xmin, $min);
                $max = \max($xmax, $max);
            }
        }

        $n = Configs::safe_count($this->ynaxis);

        for ($i = 0; $i < $n; ++$i) {
            if (null === $this->ynaxis[$i]) {
                continue;
            }

            foreach ($this->ynplots[$i] as $p) {
                [$xmin, $ymin] = $p->Min();
                [$xmax, $ymax] = $p->Max();
                $min = \min($xmin, $min);
                $max = \max($xmax, $max);
            }
        }

        return [$min, $max];
    }

    public function AdjustMarginsForTitles()
    {
        $totrequired =
            ('' !== $this->title->t
                ? $this->title->GetTextHeight($this->img) + $this->title->margin + 5 * Configs::getConfig('SUPERSAMPLING_SCALE')
                : 0) +
            ('' !== $this->subtitle->t
                ? $this->subtitle->GetTextHeight($this->img) + $this->subtitle->margin + 5 * Configs::getConfig('SUPERSAMPLING_SCALE')
                : 0) +
            ('' !== $this->subsubtitle->t
                ? $this->subsubtitle->GetTextHeight($this->img) + $this->subsubtitle->margin + 5 * Configs::getConfig('SUPERSAMPLING_SCALE')
                : 0);

        $btotrequired = 0;

        if (null !== $this->xaxis && !$this->xaxis->hide && !$this->xaxis->hide_labels) {
            // Minimum bottom margin
            if ('' !== $this->xaxis->title->t) {
                if (90 === $this->img->a) {
                    $btotrequired = $this->yaxis->title->GetTextHeight($this->img) + 7;
                } else {
                    $btotrequired = $this->xaxis->title->GetTextHeight($this->img) + 7;
                }
            } else {
                $btotrequired = 0;
            }

            if (90 === $this->img->a) {
                $this->img->SetFont(
                    $this->yaxis->font_family,
                    $this->yaxis->font_style,
                    $this->yaxis->font_size
                );
                $lh = $this->img->GetTextHeight('Mg', $this->yaxis->label_angle);
            } else {
                $this->img->SetFont(
                    $this->xaxis->font_family,
                    $this->xaxis->font_style,
                    $this->xaxis->font_size
                );
                $lh = $this->img->GetTextHeight('Mg', $this->xaxis->label_angle);
            }

            $btotrequired += $lh + 6;
        }

        if (90 === $this->img->a) {
            // DO Nothing. It gets too messy to do this properly for 90 deg...
        } else {
            // need more top margin
            if ($this->img->top_margin < $totrequired) {
                $this->SetMargin(
                    $this->img->raw_left_margin,
                    $this->img->raw_right_margin,
                    $totrequired / Configs::getConfig('SUPERSAMPLING_SCALE'),
                    $this->img->raw_bottom_margin
                );
            }

            // need more bottom margin
            if ($this->img->bottom_margin < $btotrequired) {
                $this->SetMargin(
                    $this->img->raw_left_margin,
                    $this->img->raw_right_margin,
                    $this->img->raw_top_margin,
                    $btotrequired / Configs::getConfig('SUPERSAMPLING_SCALE')
                );
            }
        }
    }
    public function getScale()
    {
        return $this->scale;
    }
    public function StrokeStore($aStrokeFileName)
    {
        // Get the handler to prevent the library from sending the
        // image to the browser
        $ih = $this->Stroke(Configs::getConfig('_IMG_HANDLER'));

        // Stroke it to a file
        $this->img->Stream($aStrokeFileName);

        // Send it back to browser
        $this->img->Headers();
        $this->img->Stream();
    }

    public function doAutoScaleXAxis()
    {
        $aPlots = \array_filter($this->plots, function ($plot) {
            return $plot instanceof Plot\Plot;
        });

        //Check if we should autoscale x-axis
        if (!$this->xscale->IsSpecified()) {
            if (\mb_substr($this->axtype, 0, 4) === 'text') {
                $max = 0;
                $n = Configs::safe_count($aPlots);

                for ($i = 0; $i < $n; ++$i) {
                    $p = $aPlots[$i];

                    // We need some unfortunate sub class knowledge here in order
                    // to increase number of data points in case it is a line plot
                    // which has the barcenter set. If not it could mean that the
                    // last point of the data is outside the scale since the barcenter
                    // settings means that we will shift the entire plot half a tick step
                    // to the right in oder to align with the center of the bars.

                    $cl = \mb_strtolower(\get_class($p));

                    if (empty($p->barcenter)) {
                        $max = \max($max, $p->numpoints - 1);
                    } else {
                        $max = \max($max, $p->numpoints);
                    }
                }
                $min = 0;

                if (null !== $this->y2axis) {
                    foreach ($this->y2plots as $p) {
                        $max = \max($max, $p->numpoints - 1);
                    }
                }
                $n = Configs::safe_count($this->ynaxis);

                for ($i = 0; $i < $n; ++$i) {
                    if (null === $this->ynaxis[$i]) {
                        continue;
                    }

                    foreach ($this->ynplots[$i] as $p) {
                        $max = \max($max, $p->numpoints - 1);
                    }
                }

                $this->xscale->Update($this->img, $min, $max);
                $this->xscale->ticks->Set($this->xaxis->tick_step, 1);
                $this->xscale->ticks->SupressMinorTickMarks();
            } else {
                [$min, $max] = $this->GetXMinMax();

                $lres = $this->GetLinesXMinMax($this->lines);

                if ($lres) {
                    [$linmin, $linmax] = $lres;
                    $min = \min($min, $linmin);
                    $max = \max($max, $linmax);
                }

                $lres = $this->GetLinesXMinMax($this->y2lines);

                if ($lres) {
                    [$linmin, $linmax] = $lres;
                    $min = \min($min, $linmin);
                    $max = \max($max, $linmax);
                }

                $tres = $this->GetTextsXMinMax();

                if ($tres) {
                    [$tmin, $tmax] = $tres;
                    $min = \min($min, $tmin);
                    $max = \max($max, $tmax);
                }

                $tres = $this->GetTextsXMinMax(true);

                if ($tres) {
                    [$tmin, $tmax] = $tres;
                    $min = \min($min, $tmin);
                    $max = \max($max, $tmax);
                }

                $this->xscale->AutoScale($this->img, $min, $max, \round($this->img->plotwidth / $this->xtick_factor));
            }

            //Adjust position of y-axis and y2-axis to minimum/maximum of x-scale
            if (!\is_numeric($this->yaxis->pos) && !\is_string($this->yaxis->pos)) {
                $this->yaxis->SetPos($this->xscale->GetMinVal());
            }
        } elseif (
            $this->xscale->IsSpecified()
            && ($this->xscale->auto_ticks || !$this->xscale->ticks->IsSpecified())
        ) {
            // The tick calculation will use the user suplied min/max values to determine
            // the ticks. If auto_ticks is false the exact user specifed min and max
            // values will be used for the scale.
            // If auto_ticks is true then the scale might be slightly adjusted
            // so that the min and max values falls on an even major step.
            $min = $this->xscale->scale[0];
            $max = $this->xscale->scale[1];
            $this->xscale->AutoScale($this->img, $min, $max, \round($this->img->plotwidth / $this->xtick_factor), false);

            // Now make sure we show enough precision to accurate display the
            // labels. If this is not done then the user might end up with
            // a scale that might actually start with, say 13.5, butdue to rounding
            // the scale label will ony show 14.
            if (\abs(\floor($min) - $min) > 0) {
                // If the user has set a format then we bail out
                if ('' === $this->xscale->ticks->label_formatstr && '' === $this->xscale->ticks->label_dateformatstr) {
                    $this->xscale->ticks->precision = \abs(\floor(\log10(\abs(\floor($min) - $min)))) + 1;
                }
            }
        }

        // Position the optional Y2 and Yn axis to the rightmost position of the x-axis
        if (null !== $this->y2axis) {
            if (!\is_numeric($this->y2axis->pos) && !\is_string($this->y2axis->pos)) {
                $this->y2axis->SetPos($this->xscale->GetMaxVal());
            }
            $this->y2axis->SetTitleSide(Configs::getConfig('SIDE_RIGHT'));
        }

        $n = Configs::safe_count($this->ynaxis);
        $nY2adj = null !== $this->y2axis ? $this->iYAxisDeltaPos : 0;

        for ($i = 0; $i < $n; ++$i) {
            if (null === $this->ynaxis[$i]) {
                continue;
            }

            if (!\is_numeric($this->ynaxis[$i]->pos) && !\is_string($this->ynaxis[$i]->pos)) {
                $this->ynaxis[$i]->SetPos($this->xscale->GetMaxVal());
                $this->ynaxis[$i]->SetPosAbsDelta($i * $this->iYAxisDeltaPos + $nY2adj);
            }
            $this->ynaxis[$i]->SetTitleSide(Configs::getConfig('SIDE_RIGHT'));
        }
    }

    public function doAutoScaleYnAxis()
    {
        if (null !== $this->y2scale) {
            if (!$this->y2scale->IsSpecified() && Configs::safe_count($this->y2plots) > 0) {
                [$min, $max] = $this->GetPlotsYMinMax($this->y2plots);

                $lres = $this->GetLinesYMinMax($this->y2lines);

                if (\is_array($lres)) {
                    [$linmin, $linmax] = $lres;
                    $min = \min($min, $linmin);
                    $max = \max($max, $linmax);
                }
                $tres = $this->GetTextsYMinMax(true);

                if (\is_array($tres)) {
                    [$tmin, $tmax] = $tres;
                    $min = \min($min, $tmin);
                    $max = \max($max, $tmax);
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
                $this->y2scale->AutoScale(
                    $this->img,
                    $min,
                    $max,
                    $this->img->plotheight / $this->ytick_factor,
                    $this->y2scale->auto_ticks
                );

                // Now make sure we show enough precision to accurate display the
                // labels. If this is not done then the user might end up with
                // a scale that might actually start with, say 13.5, butdue to rounding
                // the scale label will ony show 14.
                if (\abs(\floor($min) - $min) > 0) {
                    // If the user has set a format then we bail out
                    if ('' === $this->y2scale->ticks->label_formatstr && '' === $this->y2scale->ticks->label_dateformatstr) {
                        $this->y2scale->ticks->precision = \abs(\floor(\log10(\abs(\floor($min) - $min)))) + 1;
                    }
                }
            }
        }

        // Autoscale the extra Y-axises
        $n = Configs::safe_count($this->ynaxis);

        for ($i = 0; $i < $n; ++$i) {
            if (null === $this->ynscale[$i]) {
                continue;
            }

            if (!$this->ynscale[$i]->IsSpecified() && Configs::safe_count($this->ynplots[$i]) > 0) {
                [$min, $max] = $this->GetPlotsYMinMax($this->ynplots[$i]);
                $this->ynscale[$i]->AutoScale($this->img, $min, $max, $this->img->plotheight / $this->ytick_factor);
            } elseif ($this->ynscale[$i]->IsSpecified() && ($this->ynscale[$i]->auto_ticks || !$this->ynscale[$i]->ticks->IsSpecified())) {
                // The tick calculation will use the user suplied min/max values to determine
                // the ticks. If auto_ticks is false the exact user specifed min and max
                // values will be used for the scale.
                // If auto_ticks is true then the scale might be slightly adjusted
                // so that the min and max values falls on an even major step.
                $min = $this->ynscale[$i]->scale[0];
                $max = $this->ynscale[$i]->scale[1];
                $this->ynscale[$i]->AutoScale(
                    $this->img,
                    $min,
                    $max,
                    $this->img->plotheight / $this->ytick_factor,
                    $this->ynscale[$i]->auto_ticks
                );

                // Now make sure we show enough precision to accurate display the
                // labels. If this is not done then the user might end up with
                // a scale that might actually start with, say 13.5, butdue to rounding
                // the scale label will ony show 14.
                if (\abs(\floor($min) - $min) > 0) {
                    // If the user has set a format then we bail out
                    if ('' === $this->ynscale[$i]->ticks->label_formatstr && '' === $this->ynscale[$i]->ticks->label_dateformatstr) {
                        $this->ynscale[$i]->ticks->precision = \abs(\floor(\log10(\abs(\floor($min) - $min)))) + 1;
                    }
                }
            }
        }
    }

    public function doAutoScaleYAxis()
    {
        //Check if we should autoscale y-axis
        if (!$this->yscale->IsSpecified() && Configs::safe_count($this->plots) > 0) {
            [$min, $max] = $this->GetPlotsYMinMax($this->plots);
            $lres = $this->GetLinesYMinMax($this->lines);

            if (\is_array($lres)) {
                [$linmin, $linmax] = $lres;
                $min = \min($min, $linmin);
                $max = \max($max, $linmax);
            }
            $tres = $this->GetTextsYMinMax();

            if (\is_array($tres)) {
                [$tmin, $tmax] = $tres;
                $min = \min($min, $tmin);
                $max = \max($max, $tmax);
            }
            $this->yscale->AutoScale(
                $this->img,
                $min,
                $max,
                $this->img->plotheight / $this->ytick_factor
            );
        } elseif ($this->yscale->IsSpecified() && ($this->yscale->auto_ticks || !$this->yscale->ticks->IsSpecified())) {
            // The tick calculation will use the user suplied min/max values to determine
            // the ticks. If auto_ticks is false the exact user specifed min and max
            // values will be used for the scale.
            // If auto_ticks is true then the scale might be slightly adjusted
            // so that the min and max values falls on an even major step.
            $min = $this->yscale->scale[0];
            $max = $this->yscale->scale[1];
            $this->yscale->AutoScale(
                $this->img,
                $min,
                $max,
                $this->img->plotheight / $this->ytick_factor,
                $this->yscale->auto_ticks
            );

            // Now make sure we show enough precision to accurate display the
            // labels. If this is not done then the user might end up with
            // a scale that might actually start with, say 13.5, butdue to rounding
            // the scale label will ony show 14.
            if (\abs(\floor($min) - $min) > 0) {
                // If the user has set a format then we bail out
                if ('' === $this->yscale->ticks->label_formatstr && '' === $this->yscale->ticks->label_dateformatstr) {
                    $this->yscale->ticks->precision = \abs(\floor(\log10(\abs(\floor($min) - $min)))) + 1;
                }
            }
        }
    }

    public function InitScaleConfigs()
    {
        // Setup scale constants
        if ($this->yscale) {
            $this->yscale->InitConfigs($this->img);
        }

        if ($this->xscale) {
            $this->xscale->InitConfigs($this->img);
        }

        if ($this->y2scale) {
            $this->y2scale->InitConfigs($this->img);
        }

        $n = Configs::safe_count($this->ynscale);

        for ($i = 0; $i < $n; ++$i) {
            if (!$this->ynscale[$i]) {
                continue;
            }

            $this->ynscale[$i]->InitConfigs($this->img);
        }
    }

    public function doPrestrokeAdjustments()
    {
        // Do any pre-stroke adjustment that is needed by the different plot types
        // (i.e bar plots want's to add an offset to the x-labels etc)
        for ($i = 0; Configs::safe_count($this->plots) > $i; ++$i) {
            if (!($this->plots[$i] instanceof Plot\Plot)) {
                continue;
            }

            $this->plots[$i]->PreStrokeAdjust($this);
            $this->plots[$i]->DoLegend($this);
        }

        // Any plots on the second Y scale?
        if (null !== $this->y2scale) {
            for ($i = 0; Configs::safe_count($this->y2plots) > $i; ++$i) {
                if (!($this->plots[$i] instanceof Plot\Plot)) {
                    continue;
                }

                $this->y2plots[$i]->PreStrokeAdjust($this);
                $this->y2plots[$i]->DoLegend($this);
            }
        }

        // Any plots on the extra Y axises?
        $n = Configs::safe_count($this->ynaxis);

        for ($i = 0; $i < $n; ++$i) {
            if (null === $this->ynplots || null === $this->ynplots[$i]) {
                throw      Util\JpGraphError::make(25032, $i); //("No plots for Y-axis nbr:$i");
            }
            $m = Configs::safe_count($this->ynplots[$i]);

            for ($j = 0; $j < $m; ++$j) {
                $this->ynplots[$i][$j]->PreStrokeAdjust($this);
                $this->ynplots[$i][$j]->DoLegend($this);
            }
        }
    }

    /**
     * @param array $aDepth
     * @param bool $aCSIM
     */
    public function StrokeBands($aDepth, $aCSIM)
    {
        // Stroke bands
        if (null !== $this->bands && !$aCSIM) {
            for ($i = 0; Configs::safe_count($this->bands) > $i; ++$i) {
                // Stroke all bands that asks to be in the background
                if ($this->bands[$i]->depth !== $aDepth) {
                    // Stroke all bands that asks to be in the background
                    continue;
                    // Stroke all bands that asks to be in the background
                }

                $this->bands[$i]->Stroke($this->img, $this->xscale, $this->yscale);
            }
        }

        if (null === $this->y2bands || null === $this->y2scale || $aCSIM) {
            return;
        }

        for ($i = 0; Configs::safe_count($this->y2bands) > $i; ++$i) {
            // Stroke all bands that asks to be in the foreground
            if ($this->y2bands[$i]->depth !== $aDepth) {
                // Stroke all bands that asks to be in the foreground
                continue;
                // Stroke all bands that asks to be in the foreground
            }

            $this->y2bands[$i]->Stroke($this->img, $this->xscale, $this->y2scale);
        }
    }

    // Stroke the graph
    // $aStrokeFileName If != "" the image will be written to this file and NOT
    // streamed back to the browser
    /**
     * @param array|string $aStrokeFileName
     */
    public function Stroke($aStrokeFileName = '')
    {
        // Fist make a sanity check that user has specified a scale
        if (empty($this->yscale)) {
            throw      Util\JpGraphError::make(25031); //('You must specify what scale to use with a call to Graph::SetScale().');
        }

        // Start by adjusting the margin so that potential titles will fit.
        $this->AdjustMarginsForTitles();

        // Give the plot a chance to do any scale adjuments the individual plots
        // wants to do. Right now this is only used by the contour plot to set scale
        // limits
        for ($i = 0; Configs::safe_count($this->plots) > $i; ++$i) {
            if (!($this->plots[$i] instanceof Plot\Plot)) {
                continue;
            }

            $this->plots[$i]->PreScaleSetup($this);
        }

        // Init scale constants that are used to calculate the transformation from
        // world to pixel coordinates
        $this->InitScaleConfigs();

        // If the filename is the predefined value = '_csim_special_'
        // we assume that the call to stroke only needs to do enough
        // to correctly generate the Configs::getConfig('CSIM') maps.
        // We use this variable to skip things we don't strictly need
        // to do to generate the image map to improve performance
        // a best we can. Therefor you will see a lot of tests !$_csim in the
        // code below.
        $_csim = (Configs::getConfig('_CSIM_SPECIALFILE') === $aStrokeFileName);

        // If we are called the second time (perhaps the user has called GetHTMLImageMap()
        // himself then the legends have alsready been populated once in order to get the
        // Configs::getConfig('CSIM') coordinats. Since we do not want the legends to be populated a second time
        // we clear the legends
        $this->legend->Clear();

        // We need to know if we have stroked the plot in the
        // GetCSIMareas. Otherwise the Configs::getConfig('CSIM') hasn't been generated
        // and in the case of GetCSIM called before stroke to generate
        // Configs::getConfig('CSIM') without storing an image to disk GetCSIM must call Stroke.
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
        if ((!$this->yscale->IsSpecified() && Configs::safe_count($this->plots) === 0)
            || (null !== $this->y2scale && !$this->y2scale->IsSpecified() && Configs::safe_count($this->y2plots) === 0)
        ) {
            //$e = "n=". Configs::safe_count($this->y2plots)."\n";
            // $e = "Can't draw unspecified Y-scale.<br>\nYou have either:<br>\n";
            // $e .= "1. Specified an Y axis for autoscaling but have not supplied any plots<br>\n";
            // $e .= "2. Specified a scale manually but have forgot to specify the tick steps";
            throw      Util\JpGraphError::make(25026);
        }

        // Bail out if no plots and no specified X-scale
        if ((!$this->xscale->IsSpecified() && Configs::safe_count($this->plots) === 0 && Configs::safe_count($this->y2plots) === 0)) {
            throw      Util\JpGraphError::make(25034); //("<strong>JpGraph: Can't draw unspecified X-scale.</strong><br>No plots.<br>");
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
        if (($this->xscale->GetMinVal() === $this->yaxis->pos || (\is_string($this->yaxis->pos) && 'min' === $this->yaxis->pos))
            && !\is_numeric($this->xaxis->pos) && $this->yscale->GetMinVal() < 0
            && \mb_substr($this->axtype, 0, 4) !== 'text' && 'min' !== $this->xaxis->pos
        ) {
            //$this->yscale->ticks->SupressZeroLabel(false);
            $this->xscale->ticks->SupressFirst();

            if (null !== $this->y2axis) {
                $this->xscale->ticks->SupressLast();
            }
        } elseif (!\is_numeric($this->yaxis->pos) && 'max' === $this->yaxis->pos) {
            $this->xscale->ticks->SupressLast();
        }

        if (!$_csim) {
            $this->StrokePlotArea();

            if (Configs::getConfig('DEPTH_BACK') === $this->iIconDepth) {
                $this->StrokeIcons();
            }
        }
        $this->StrokeAxis(false);

        // Stroke colored bands
        $this->StrokeBands(Configs::getConfig('DEPTH_BACK'), $_csim);

        if (Configs::getConfig('DEPTH_BACK') === $this->grid_depth && !$_csim) {
            $this->ygrid->Stroke();
            $this->xgrid->Stroke();
        }

        // Stroke Y2-axis
        if (null !== $this->y2axis && !$_csim) {
            $this->y2axis->Stroke($this->xscale);
            $this->y2grid->Stroke();
        }

        // Stroke yn-axis
        $n = Configs::safe_count($this->ynaxis);

        for ($i = 0; $i < $n; ++$i) {
            $this->ynaxis[$i]->Stroke($this->xscale);
        }

        $oldoff = $this->xscale->off;

        if (\mb_substr($this->axtype, 0, 4) === 'text') {
            if (-1 < $this->text_scale_abscenteroff) {
                // For a text scale the scale factor is the number of pixel per step.
                // Hence we can use the scale factor as a substitute for number of pixels
                // per major scale step and use that in order to adjust the offset so that
                // an object of width "abscenteroff" becomes centered.
                $this->xscale->off += \round($this->xscale->scale_factor / 2) - \round($this->text_scale_abscenteroff / 2);
            } else {
                $this->xscale->off += \ceil($this->xscale->scale_factor * $this->text_scale_off * $this->xscale->ticks->minor_step);
            }
        }

        if ($this->iDoClipping) {
            $oldimage = $this->img->CloneCanvasH();
        }

        if (!$this->y2orderback) {
            // Stroke all plots for Y1 axis
            for ($i = 0; Configs::safe_count($this->plots) > $i; ++$i) {
                $this->plots[$i]->Stroke($this->img, $this->xscale, $this->yscale);

                if (!($this->plots[$i] instanceof Plot\Plot)) {
                    continue;
                }

                $this->plots[$i]->StrokeMargin($this->img);
            }
        }

        // Stroke all plots for Y2 axis
        if (null !== $this->y2scale) {
            for ($i = 0; Configs::safe_count($this->y2plots) > $i; ++$i) {
                $this->y2plots[$i]->Stroke($this->img, $this->xscale, $this->y2scale);
            }
        }

        if ($this->y2orderback) {
            // Stroke all plots for Y1 axis
            for ($i = 0; Configs::safe_count($this->plots) > $i; ++$i) {
                $this->plots[$i]->Stroke($this->img, $this->xscale, $this->yscale);

                if (!($this->plots[$i] instanceof Plot\Plot)) {
                    continue;
                }

                $this->plots[$i]->StrokeMargin($this->img);
            }
        }

        $n = Configs::safe_count($this->ynaxis);

        for ($i = 0; $i < $n; ++$i) {
            $m = Configs::safe_count($this->ynplots[$i]);

            for ($j = 0; $j < $m; ++$j) {
                $this->ynplots[$i][$j]->Stroke($this->img, $this->xscale, $this->ynscale[$i]);

                if (!($this->ynplots[$i][$j] instanceof Plot\Plot)) {
                    continue;
                }

                $this->ynplots[$i][$j]->StrokeMargin($this->img);
            }
        }

        if (Configs::getConfig('DEPTH_FRONT') === $this->iIconDepth) {
            $this->StrokeIcons();
        }

        if ($this->iDoClipping) {
            // Clipping only supports graphs at 0 and 90 degrees
            if (0 === $this->img->a) {
                $this->img->CopyCanvasH(
                    $oldimage,
                    $this->img->img,
                    $this->img->left_margin,
                    $this->img->top_margin,
                    $this->img->left_margin,
                    $this->img->top_margin,
                    $this->img->plotwidth + 1,
                    $this->img->plotheight
                );
            } elseif (90 === $this->img->a) {
                $adj = ($this->img->height - $this->img->width) / 2;
                $this->img->CopyCanvasH(
                    $oldimage,
                    $this->img->img,
                    $this->img->bottom_margin - $adj,
                    $this->img->left_margin + $adj,
                    $this->img->bottom_margin - $adj,
                    $this->img->left_margin + $adj,
                    $this->img->plotheight + 1,
                    $this->img->plotwidth
                );
            } else {
                throw      Util\JpGraphError::make(25035, $this->img->a); //('You have enabled clipping. Cliping is only supported for graphs at 0 or 90 degrees rotation. Please adjust you current angle (='.$this->img->a.' degrees) or disable clipping.');
            }
            $this->img->Destroy();
            $this->img->SetCanvasH($oldimage);
        }

        $this->xscale->off = $oldoff;

        if (Configs::getConfig('DEPTH_FRONT') === $this->grid_depth && !$_csim) {
            $this->ygrid->Stroke();
            $this->xgrid->Stroke();
        }

        // Stroke colored bands
        $this->StrokeBands(Configs::getConfig('DEPTH_FRONT'), $_csim);

        // Finally draw the axis again since some plots may have nagged
        // the axis in the edges.
        if (!$_csim) {
            $this->StrokeAxis();
        }

        if (null !== $this->y2scale && !$_csim) {
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

        if ($_csim) {
            return;
        }

        $this->img->SetAngle($aa);

        // Draw an outline around the image map
        if (Configs::_JPG_DEBUG) {
            $this->DisplayClientSideaImageMapAreas();
        }

        // Should we do any final image transformation
        if ($this->iImgTrans) {
            $tform = new Image\ImgTrans($this->img->img);
            $this->img->img = $tform->Skew3D(
                $this->iImgTransHorizon,
                $this->iImgTransSkewDist,
                $this->iImgTransDirection,
                $this->iImgTransHighQ,
                $this->iImgTransMinSize,
                $this->iImgTransFillColor,
                $this->iImgTransBorder
            );
        }

        // If the filename is given as the special "__handle"
        // then the image handler is returned and the image is NOT
        // streamed back
        if (Configs::getConfig('_IMG_HANDLER') === $aStrokeFileName) {
            return $this->img->img;
        }
        // Finally stream the generated picture
        $this->cache->PutAndStream($this->img, $this->cache_name, $this->inline, $aStrokeFileName);
    }

    public function SetAxisLabelBackground($aType, $aXFColor = 'lightgray', $aXColor = 'black', $aYFColor = 'lightgray', $aYColor = 'black'): self
    {
        $this->iAxisLblBgType = $aType;
        $this->iXAxisLblBgFillColor = $aXFColor;
        $this->iXAxisLblBgColor = $aXColor;
        $this->iYAxisLblBgFillColor = $aYFColor;
        $this->iYAxisLblBgColor = $aYColor;
        return $this;
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

        if (1 > $t) {
            return;
        }

        // Stroke optional X-axis label background color
        if (1 === $t || 3 === $t || 5 === $t || 6 === $t) {
            $this->img->PushColor($this->iXAxisLblBgFillColor);

            if (1 === $t || 6 === $t) {
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
            if ('' !== $this->iXAxisLblBgColor) {
                // Hardcode to one pixel wide
                $this->img->SetLineWeight(1);
                $this->img->PushColor($this->iXAxisLblBgColor);

                if (1 === $t || 6 === $t) {
                    $this->img->Line($xl, $yu, $xl, $yl);
                    $this->img->Line($xr, $yu, $xr, $yl);
                } else {
                    $xl = $this->img->width - $this->img->right_margin;
                    $this->img->Line($xl, $yu - 1, $xr, $yu - 1);
                }
                $this->img->PopColor();
            }
        }

        if (2 !== $t && 4 !== $t && 5 !== $t && 6 !== $t) {
            return;
        }

        $this->img->PushColor($this->iYAxisLblBgFillColor);

        if (2 === $t || 6 === $t) {
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
        if ('' === $this->iXAxisLblBgColor) {
            // Check if we should add the vertical lines at left and right edge
            return;
            // Check if we should add the vertical lines at left and right edge
        }

        $this->img->PushColor($this->iXAxisLblBgColor);

        if (2 === $t || 6 === $t) {
            $this->img->Line($xl, $yu - 1, $xr, $yu - 1);
            $this->img->Line($xl, $yl - 1, $xr, $yl - 1);
        } else {
            $this->img->Line($xr + 1, $yu, $xr + 1, $this->img->top_margin);
        }
        $this->img->PopColor();
    }

    /**
     * @param bool $aStrokeLabels
     */
    public function StrokeAxis($aStrokeLabels = true)
    {
        if ($aStrokeLabels) {
            $this->StrokeAxisLabelBackground();
        }

        // Stroke axis
        if (Configs::getConfig('AXSTYLE_SIMPLE') !== $this->iAxisStyle) {
            switch ($this->iAxisStyle) {
                case Configs::getConfig('AXSTYLE_BOXIN'):
                    $toppos = Configs::getConfig('SIDE_DOWN');
                    $bottompos = Configs::getConfig('SIDE_UP');
                    $leftpos = Configs::getConfig('SIDE_RIGHT');
                    $rightpos = Configs::getConfig('SIDE_LEFT');

                    break;
                case Configs::getConfig('AXSTYLE_BOXOUT'):
                    $toppos = Configs::getConfig('SIDE_UP');
                    $bottompos = Configs::getConfig('SIDE_DOWN');
                    $leftpos = Configs::getConfig('SIDE_LEFT');
                    $rightpos = Configs::getConfig('SIDE_RIGHT');

                    break;
                case Configs::getConfig('AXSTYLE_YBOXIN'):
                    $toppos = false;
                    $bottompos = Configs::getConfig('SIDE_UP');
                    $leftpos = Configs::getConfig('SIDE_RIGHT');
                    $rightpos = Configs::getConfig('SIDE_LEFT');

                    break;
                case Configs::getConfig('AXSTYLE_YBOXOUT'):
                    $toppos = false;
                    $bottompos = Configs::getConfig('SIDE_DOWN');
                    $leftpos = Configs::getConfig('SIDE_LEFT');
                    $rightpos = Configs::getConfig('SIDE_RIGHT');

                    break;

                default:
                    throw      Util\JpGraphError::make(25036, $this->iAxisStyle); //('Unknown AxisStyle() : '.$this->iAxisStyle);

                    break;
            }

            // By default we hide the first label so it doesn't cross the
            // Y-axis in case the positon hasn't been set by the user.
            // However, if we use a box we always want the first value
            // displayed so we make sure it will be displayed.
            $this->xscale->ticks->SupressFirst(false);

            // Now draw the bottom X-axis
            $this->xaxis->SetPos('min');
            $this->xaxis->SetLabelSide(Configs::getConfig('SIDE_DOWN'));
            $this->xaxis->scale->ticks->SetSide($bottompos);
            $this->xaxis->Stroke($this->yscale, $aStrokeLabels);

            if (false !== $toppos) {
                // We also want a top X-axis
                $this->xaxis = $this->xaxis;
                $this->xaxis->SetPos('max');
                $this->xaxis->SetLabelSide(Configs::getConfig('SIDE_UP'));
                // No title for the top X-axis
                if ($aStrokeLabels) {
                    $this->xaxis->title->Set('');
                }
                $this->xaxis->scale->ticks->SetSide($toppos);
                $this->xaxis->Stroke($this->yscale, $aStrokeLabels);
            }

            // Stroke the left Y-axis
            $this->yaxis->SetPos('min');
            $this->yaxis->SetLabelSide(Configs::getConfig('SIDE_LEFT'));
            $this->yaxis->scale->ticks->SetSide($leftpos);
            $this->yaxis->Stroke($this->xscale, $aStrokeLabels);

            // Stroke the  right Y-axis
            $this->yaxis->SetPos('max');
            // No title for the right side
            if ($aStrokeLabels) {
                $this->yaxis->title->Set('');
            }
            $this->yaxis->SetLabelSide(Configs::getConfig('SIDE_RIGHT'));
            $this->yaxis->scale->ticks->SetSide($rightpos);
            $this->yaxis->Stroke($this->xscale, $aStrokeLabels);
        } else {
            $this->xaxis->Stroke($this->yscale, $aStrokeLabels);
            $this->yaxis->Stroke($this->xscale, $aStrokeLabels);
        }
    }

    // Private helper function for backgound image
    /**
     * @param string $aImgFormat
     * @param string $aFile
     */
    public static function LoadBkgImage($aImgFormat = '', $aFile = '', $aImgStr = '')
    {
        if ('' !== $aImgStr) {
            return Image\Image::CreateFromString($aImgStr);
        }

        // Remove case sensitivity and setup appropriate function to create image
        // Get file extension. This should be the Configs::getConfig('LAST') '.' separated part of the filename
        $e = \explode('.', $aFile);
        $ext = \mb_strtolower($e[\count($e) - 1]);

        if ('jpeg' === $ext) {
            $ext = 'jpg';
        }

        if (\trim($ext) === '') {
            $ext = 'png'; // Assume PNG if no extension specified
        }

        if ('' === $aImgFormat) {
            $imgtag = $ext;
        } else {
            $imgtag = $aImgFormat;
        }

        $supported = \imagetypes();

        if (('jpg' === $ext && !($supported & \IMG_JPG))
            || ('gif' === $ext && !($supported & \IMG_GIF))
            || ('png' === $ext && !($supported & \IMG_PNG))
            || ('bmp' === $ext && !($supported & \IMG_WBMP))
            || ('xpm' === $ext && !($supported & \IMG_XPM))
        ) {
            throw      Util\JpGraphError::make(25037, $aFile); //('The image format of your background image ('.$aFile.') is not supported in your system configuration. ');
        }

        if ('jpg' === $imgtag || 'jpeg' === $imgtag) {
            $f = 'imagecreatefromjpeg';
            $imgtag = 'jpg';
        } else {
            $f = 'imagecreatefrom' . $imgtag;
        }

        // Compare specified image type and file extension
        if ($imgtag !== $ext) {
            //$t = "Background image seems to be of different type (has different file extension) than specified imagetype. Specified: '".$aImgFormat."'File: '".$aFile."'";
            throw      Util\JpGraphError::make(25038, $aImgFormat, $aFile);
        }

        $img = $f($aFile);

        if (!$img) {
            throw      Util\JpGraphError::make(25039, $aFile); //(" Can't read background image: '".$aFile."'");
        }

        return $img;
    }

    public function StrokePlotGrad()
    {
        if (0 > $this->plot_gradtype) {
            return;
        }

        $grad = new Plot\Gradient($this->img);
        $xl = $this->img->left_margin;
        $yt = $this->img->top_margin;
        $xr = $xl + $this->img->plotwidth + 1;
        $yb = $yt + $this->img->plotheight;
        $grad->FilledRectangle($xl, $yt, $xr, $yb, $this->plot_gradfrom, $this->plot_gradto, $this->plot_gradtype);
    }

    public function StrokeBackgroundGrad()
    {
        if (0 > $this->bkg_gradtype) {
            return;
        }

        $grad = new Plot\Gradient($this->img);

        if (Configs::getConfig('BGRAD_PLOT') === $this->bkg_gradstyle) {
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
        if ('' !== $this->background_image && '' !== $this->background_cflag) {
            throw      Util\JpGraphError::make(25040); //('It is not possible to specify both a background image and a background country flag.');
        }

        if ('' !== $this->background_image) {
            $bkgimg = $this->LoadBkgImage($this->background_image_format, $this->background_image);
        } elseif ('' !== $this->background_cflag) {
            $fobj = new Image\FlagImages(Configs::getConfig('FLAGSIZE4'));
            $dummy = '';
            $bkgimg = $fobj->GetImgByName($this->background_cflag, $dummy);
            $this->background_image_mix = $this->background_cflag_mix;
            $this->background_image_type = $this->background_cflag_type;
        } else {
            return;
        }

        $bw = \imagesx($bkgimg);
        $bh = \imagesy($bkgimg);

        // No matter what the angle is we always stroke the image and frame
        // assuming it is 0 degree
        $aa = $this->img->SetAngle(0);

        switch ($this->background_image_type) {
            case Configs::getConfig('BGIMG_FILLPLOT'): // Resize to just fill the plotarea
                $this->FillMarginArea();
                $this->StrokeFrame();
                // Special case to hande 90 degree rotated graph corectly
                if (90 === $aa) {
                    $this->img->SetAngle(90);
                    $this->FillPlotArea();
                    $aa = $this->img->SetAngle(0);
                    $adj = ($this->img->height - $this->img->width) / 2;
                    $this->img->CopyMerge(
                        $bkgimg,
                        $this->img->bottom_margin - $adj,
                        $this->img->left_margin + $adj,
                        0,
                        0,
                        $this->img->plotheight + 1,
                        $this->img->plotwidth,
                        $bw,
                        $bh,
                        $this->background_image_mix
                    );
                } else {
                    $this->FillPlotArea();
                    $this->img->CopyMerge(
                        $bkgimg,
                        $this->img->left_margin,
                        $this->img->top_margin + 1,
                        0,
                        0,
                        $this->img->plotwidth + 1,
                        $this->img->plotheight,
                        $bw,
                        $bh,
                        $this->background_image_mix
                    );
                }

                break;
            case Configs::getConfig('BGIMG_FILLFRAME'): // Fill the whole area from upper left corner, resize to just fit
                $hadj = 0;
                $vadj = 0;

                if ($this->doshadow) {
                    $hadj = $this->shadow_width;
                    $vadj = $this->shadow_width;
                }
                $this->FillMarginArea();
                $this->FillPlotArea();
                $this->img->CopyMerge(
                    $bkgimg,
                    0,
                    0,
                    0,
                    0,
                    $this->img->width - $hadj,
                    $this->img->height - $vadj,
                    $bw,
                    $bh,
                    $this->background_image_mix
                );
                $this->StrokeFrame();

                break;
            case Configs::getConfig('BGIMG_COPY'): // Just copy the image from left corner, no resizing
                $this->FillMarginArea();
                $this->FillPlotArea();
                $this->img->CopyMerge(
                    $bkgimg,
                    0,
                    0,
                    0,
                    0,
                    $bw,
                    $bh,
                    $bw,
                    $bh,
                    $this->background_image_mix
                );
                $this->StrokeFrame();

                break;
            case Configs::getConfig('BGIMG_CENTER'): // Center original image in the plot area
                $this->FillMarginArea();
                $this->FillPlotArea();
                $centerx = \round($this->img->plotwidth / 2 + $this->img->left_margin - $bw / 2);
                $centery = \round($this->img->plotheight / 2 + $this->img->top_margin - $bh / 2);
                $this->img->CopyMerge(
                    $bkgimg,
                    $centerx,
                    $centery,
                    0,
                    0,
                    $bw,
                    $bh,
                    $bw,
                    $bh,
                    $this->background_image_mix
                );
                $this->StrokeFrame();

                break;
            case Configs::getConfig('BGIMG_FREE'): // Just copy the image to the specified location
                $this->img->CopyMerge(
                    $bkgimg,
                    $this->background_image_xpos,
                    $this->background_image_ypos,
                    0,
                    0,
                    $bw,
                    $bh,
                    $bw,
                    $bh,
                    $this->background_image_mix
                );
                $this->StrokeFrame(); // New

                break;

            default:
                throw      Util\JpGraphError::make(25042); //(" Unknown background image layout");
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

        if (1 >= $this->background_image_type && (0 > $this->bkg_gradtype || (0 < $this->bkg_gradtype && Configs::getConfig('BGRAD_PLOT') === $this->bkg_gradstyle))) {
            $c = $this->margin_color;
        } else {
            $c = false;
        }

        if ($this->doshadow) {
            $this->img->SetColor($this->frame_color);
            $this->img->ShadowRectangle(
                0,
                0,
                $this->img->width,
                $this->img->height,
                $c,
                $this->shadow_width,
                $this->shadow_color
            );
        } elseif ($this->framebevel) {
            if ($c) {
                $this->img->SetColor($this->margin_color);
                $this->img->FilledRectangle(0, 0, $this->img->width - 1, $this->img->height - 1);
            }
            $this->img->Bevel(
                1,
                1,
                $this->img->width - 2,
                $this->img->height - 2,
                $this->framebeveldepth,
                $this->framebevelcolor1,
                $this->framebevelcolor2
            );

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
        $this->img->FilledRectangle(
            $this->img->left_margin + 1,
            $this->img->height - $this->img->bottom_margin,
            $this->img->width - 1 - $hadj,
            $this->img->height - 1 - $hadj
        );
        $this->img->FilledRectangle(
            $this->img->width - $this->img->right_margin,
            $this->img->top_margin + 1,
            $this->img->width - 1 - $hadj,
            $this->img->height - $this->img->bottom_margin - 1
        );
    }

    public function FillPlotArea()
    {
        $this->img->PushColor($this->plotarea_color);
        $this->img->FilledRectangle(
            $this->img->left_margin,
            $this->img->top_margin,
            $this->img->width - $this->img->right_margin,
            $this->img->height - $this->img->bottom_margin
        );
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

        if ('' !== $this->background_image || '' !== $this->background_cflag) {
            $this->StrokeFrameBackground();
        } else {
            $aa = $this->img->SetAngle(0);
            $this->StrokeFrame();
            $aa = $this->img->SetAngle($aa);
            $this->StrokeBackgroundGrad();

            if (0 > $this->bkg_gradtype || (0 < $this->bkg_gradtype && Configs::getConfig('BGRAD_MARGIN') === $this->bkg_gradstyle)) {
                $this->FillPlotArea();
            }
            $this->StrokePlotGrad();
        }
    }

    public function StrokeIcons()
    {
        $n = Configs::safe_count($this->iIcons);

        for ($i = 0; $i < $n; ++$i) {
            $this->iIcons[$i]->StrokeWithScale($this->img, $this->xscale, $this->yscale);
        }
    }

    public function StrokePlotBox()
    {
        // Should we draw a box around the plot area?
        if (!$this->boxed) {
            // Should we draw a box around the plot area?
            return;
            // Should we draw a box around the plot area?
        }

        $this->img->SetLineWeight(1);
        $this->img->SetLineStyle('solid');
        $this->img->SetColor($this->box_color);

        for ($i = 0; $i < $this->box_weight; ++$i) {
            $this->img->Rectangle(
                $this->img->left_margin - $i,
                $this->img->top_margin - $i,
                $this->img->width - $this->img->right_margin + $i,
                $this->img->height - $this->img->bottom_margin + $i
            );
        }
    }

    public function SetTitleBackgroundFillStyle($aStyle, $aColor1 = 'black', $aColor2 = 'white')
    {
        $this->titlebkg_fillstyle = $aStyle;
        $this->titlebkg_scolor1 = $aColor1;
        $this->titlebkg_scolor2 = $aColor2;
    }

    public function SetTitleBackground(
        $aBackColor = 'gray',
        $aStyle = Configs::TITLEBKG_STYLE1,
        $aFrameStyle = Configs::TITLEBKG_FRAME_NONE,
        $aFrameColor = 'black',
        $aFrameWeight = 1,
        $aBevelHeight = 3,
        $aEnable = true
    ) {
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

            if ('' !== $this->subtitle->t && !$this->subtitle->hide) {
                $h += $this->subtitle->GetTextHeight($this->img) + $margin +
                    $this->subtitle->margin;
                $h += 2;
            }

            if ('' !== $this->subsubtitle->t && !$this->subsubtitle->hide) {
                $h += $this->subsubtitle->GetTextHeight($this->img) + $margin +
                    $this->subsubtitle->margin;
                $h += 2;
            }
            $this->img->PushColor($this->titlebackground_color);

            if (Configs::getConfig('TITLEBKG_STYLE1') === $this->titlebackground_style) {
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
            } elseif (Configs::getConfig('TITLEBKG_STYLE2') === $this->titlebackground_style) {
                // Cover the frame as well
                $x1 = $y1 = 0;
                $x2 = $this->img->width - 1;
            } elseif (Configs::getConfig('TITLEBKG_STYLE3') === $this->titlebackground_style) {
                // Cover the frame as well (the difference is that
                // for style==3 a bevel frame border is on top
                // of the title background)
                $x1 = $y1 = 0;
                $x2 = $this->img->width - 1;
                $h += $this->framebeveldepth;
                $this->title->margin += $this->framebeveldepth;
            } else {
                throw      Util\JpGraphError::make(25043); //('Unknown title background style.');
            }

            if (3 === $this->titlebackground_framestyle) {
                $h += $this->titlebackground_bevelheight * 2 + 1;
                $this->title->margin += $this->titlebackground_bevelheight;
            }

            if ($this->doshadow) {
                $x2 -= $this->shadow_width;
            }

            $indent = 0;

            if (Configs::getConfig('TITLEBKG_FRAME_BEVEL') === $this->titlebackground_framestyle) {
                $indent = $this->titlebackground_bevelheight;
            }

            if (Configs::getConfig('TITLEBKG_FILLSTYLE_HSTRIPED') === $this->titlebkg_fillstyle) {
                $this->img->FilledRectangle2(
                    $x1 + $indent,
                    $y1 + $indent,
                    $x2 - $indent,
                    $h - $indent,
                    $this->titlebkg_scolor1,
                    $this->titlebkg_scolor2
                );
            } elseif (Configs::getConfig('TITLEBKG_FILLSTYLE_VSTRIPED') === $this->titlebkg_fillstyle) {
                $this->img->FilledRectangle2(
                    $x1 + $indent,
                    $y1 + $indent,
                    $x2 - $indent,
                    $h - $indent,
                    $this->titlebkg_scolor1,
                    $this->titlebkg_scolor2,
                    2
                );
            } else {
                // Solid fill
                $this->img->FilledRectangle($x1, $y1, $x2, $h);
            }
            $this->img->PopColor();

            $this->img->PushColor($this->titlebackground_framecolor);
            $this->img->SetLineWeight($this->titlebackground_frameweight);

            if (Configs::getConfig('TITLEBKG_FRAME_FULL') === $this->titlebackground_framestyle) {
                // Frame background
                $this->img->Rectangle($x1, $y1, $x2, $h);
            } elseif (Configs::getConfig('TITLEBKG_FRAME_BOTTOM') === $this->titlebackground_framestyle) {
                // Bottom line only
                $this->img->Line($x1, $h, $x2, $h);
            } elseif (Configs::getConfig('TITLEBKG_FRAME_BEVEL') === $this->titlebackground_framestyle) {
                $this->img->Bevel($x1, $y1, $x2, $h, $this->titlebackground_bevelheight);
            }
            $this->img->PopColor();

            // This is clumsy. But we neeed to stroke the whole graph frame if it is
            // set to bevel to get the bevel shading on top of the text background
            if ($this->framebevel && $this->doframe && 3 === $this->titlebackground_style) {
                $this->img->Bevel(
                    1,
                    1,
                    $this->img->width - 2,
                    $this->img->height - 2,
                    $this->framebeveldepth,
                    $this->framebevelcolor1,
                    $this->framebevelcolor2
                );

                if ($this->framebevelborder) {
                    $this->img->SetColor($this->framebevelbordercolor);
                    $this->img->Rectangle(0, 0, $this->img->width - 1, $this->img->height - 1);
                }
            }
        }

        // Stroke title
        $y = $this->title->margin;

        if ('center' === $this->title->halign) {
            $this->title->Center(0, $this->img->width, $y);
        } elseif ('left' === $this->title->halign) {
            $this->title->SetPos($this->title->margin + 2, $y);
        } elseif ('right' === $this->title->halign) {
            $indent = 0;

            if ($this->doshadow) {
                $indent = $this->shadow_width + 2;
            }
            $this->title->SetPos($this->img->width - $this->title->margin - $indent, $y, 'right');
        }
        $this->title->Stroke($this->img);

        // ... and subtitle
        $y += $this->title->GetTextHeight($this->img) + $margin + $this->subtitle->margin;

        if ('center' === $this->subtitle->halign) {
            $this->subtitle->Center(0, $this->img->width, $y);
        } elseif ('left' === $this->subtitle->halign) {
            $this->subtitle->SetPos($this->subtitle->margin + 2, $y);
        } elseif ('right' === $this->subtitle->halign) {
            $indent = 0;

            if ($this->doshadow) {
                $indent = $this->shadow_width + 2;
            }

            $this->subtitle->SetPos($this->img->width - $this->subtitle->margin - $indent, $y, 'right');
        }
        $this->subtitle->Stroke($this->img);

        // ... and subsubtitle
        $y += $this->subtitle->GetTextHeight($this->img) + $margin + $this->subsubtitle->margin;

        if ('center' === $this->subsubtitle->halign) {
            $this->subsubtitle->Center(0, $this->img->width, $y);
        } elseif ('left' === $this->subsubtitle->halign) {
            $this->subsubtitle->SetPos($this->subsubtitle->margin + 2, $y);
        } elseif ('right' === $this->subsubtitle->halign) {
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
        if (null !== $this->texts) {
            for ($i = 0; Configs::safe_count($this->texts) > $i; ++$i) {
                $this->texts[$i]->StrokeWithScale($this->img, $this->xscale, $this->yscale);
            }
        }

        if (null === $this->y2texts || null === $this->y2scale) {
            return;
        }

        for ($i = 0; Configs::safe_count($this->y2texts) > $i; ++$i) {
            $this->y2texts[$i]->StrokeWithScale($this->img, $this->xscale, $this->y2scale);
        }
    }

    public function StrokeTables()
    {
        if (null === $this->iTables) {
            return;
        }

        $n = Configs::safe_count($this->iTables);

        for ($i = 0; $i < $n; ++$i) {
            $this->iTables[$i]->StrokeWithScale($this->img, $this->xscale, $this->yscale);
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

        if (!\preg_match_all('/area shape="(\\w+)" coords="([0-9\\, ]+)"/', $csim, $coords)) {
            return;
        }

        $this->img->SetColor($this->csimcolor);
        $n = Configs::safe_count($coords[0]);

        for ($i = 0; $i < $n; ++$i) {
            if ('poly' === $coords[1][$i]) {
                \preg_match_all('/\s*([0-9]+)\s*,\s*([0-9]+)\s*,*/', $coords[2][$i], $pts);
                $this->img->SetStartPoint($pts[1][\count($pts[0]) - 1], $pts[2][\count($pts[0]) - 1]);
                $m = Configs::safe_count($pts[0]);

                for ($j = 0; $j < $m; ++$j) {
                    $this->img->LineTo($pts[1][$j], $pts[2][$j]);
                }
            } elseif ('rect' === $coords[1][$i]) {
                $pts = \preg_split('/,/', $coords[2][$i]);
                $this->img->SetStartPoint($pts[0], $pts[1]);
                $this->img->LineTo($pts[2], $pts[1]);
                $this->img->LineTo($pts[2], $pts[3]);
                $this->img->LineTo($pts[0], $pts[3]);
                $this->img->LineTo($pts[0], $pts[1]);
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
        if (null === $aLines) {
            return false;
        }

        $n = Configs::safe_count($aLines);

        if (0 === $n) {
            return false;
        }

        $min = $aLines[0]->scaleposition;
        $max = $min;
        $flg = false;

        for ($i = 0; $i < $n; ++$i) {
            if (Configs::getConfig('HORIZONTAL') !== $aLines[$i]->direction) {
                continue;
            }

            $flg = true;
            $v = $aLines[$i]->scaleposition;

            if ($min > $v) {
                $min = $v;
            }

            if ($max >= $v) {
                continue;
            }

            $max = $v;
        }

        return $flg ? [$min, $max] : false;
    }

    // Get X min and max values for added lines
    public function GetLinesXMinMax($aLines)
    {
        $n = Configs::safe_count($aLines);

        if (0 === $n) {
            return false;
        }

        $min = $aLines[0]->scaleposition;
        $max = $min;
        $flg = false;

        for ($i = 0; $i < $n; ++$i) {
            if (Configs::getConfig('VERTICAL') !== $aLines[$i]->direction) {
                continue;
            }

            $flg = true;
            $v = $aLines[$i]->scaleposition;

            if ($min > $v) {
                $min = $v;
            }

            if ($max >= $v) {
                continue;
            }

            $max = $v;
        }

        return $flg ? [$min, $max] : false;
    }

    // Get min and max values for all included plots
    public function GetPlotsYMinMax($bPlots)
    {
        $aPlots = \array_filter($bPlots, function ($plot) {
            return $plot instanceof Plot\Plot;
        });
        \reset($aPlots);
        $n = Configs::safe_count($aPlots);
        $i = 0;

        do {
            [$xmax, $max] = isset($aPlots[$i]) ? $aPlots[$i]->Max() : [null, null];
        } while (++$i < $n && !\is_numeric($max));

        $i = 0;

        do {
            [$xmin, $min] = isset($aPlots[$i]) ? $aPlots[$i]->Min() : [null, null];
        } while (++$i < $n && !\is_numeric($min));

        if (!\is_numeric($min) || !\is_numeric($max)) {
            throw      Util\JpGraphError::make(25044); //('Cannot use autoscaling since it is impossible to determine a valid min/max value  of the Y-axis (only null values).');
        }

        for ($i = 0; $i < $n; ++$i) {
            [$xmax, $ymax] = isset($aPlots[$i]) ? $aPlots[$i]->Max() : [null, null];
            [$xmin, $ymin] = isset($aPlots[$i]) ? $aPlots[$i]->Min() : [null, null];

            if (\is_numeric($ymax)) {
                $max = \max($max, $ymax);
            }

            if (!\is_numeric($ymin)) {
                continue;
            }

            $min = \min($min, $ymin);
        }

        if ('' === $min) {
            $min = 0;
        }

        if ('' === $max) {
            $max = 0;
        }

        if (0 === $min && 0 === $max) {
            // Special case if all values are 0
            $min = 0;
            $max = 1;
        }

        return [$min, $max];
    }

    public function hasLinePlotAndBarPlot()
    {
        $has_line = false;
        $has_bar = false;

        foreach ($this->plots as $plot) {
            if ($plot instanceof Plot\LinePlot) {
                $has_line = true;
            }

            if (!($plot instanceof Plot\BarPlot)) {
                continue;
            }

            $has_bar = true;
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
                throw      Util\JpGraphError::make(25133); //('Use Graph::SetTheme() after Graph::SetScale().');
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

        if ($this->isAfterSetScale) {
            $this->SetScale(
                $this->inputValues['aAxisType'],
                $this->inputValues['aYMin'],
                $this->inputValues['aYMax'],
                $this->inputValues['aXMin'],
                $this->inputValues['aXMax']
            );
        }

        $this->isRunningClear = false;
    }

    public function SetSupersampling($do = false, $scale = 2)
    {
        if ($do) {
            Configs::setConfig('SUPERSAMPLING_SCALE', $scale);
            // $this->img->scale = $scale;
        } else {
            Configs::setConfig('SUPERSAMPLING_SCALE', 1);
            //$this->img->scale = 0;
        }
    }
}

// @class
