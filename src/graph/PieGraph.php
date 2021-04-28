<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Image;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Text;

/**
 * @class PieGraph
  *  Description:
 */
class PieGraph extends Graph
{
    public $plots = [];

    public $pieaa = false;

    private $posx;

    private $posy;

    private $radius;

    /**
     * @var array
     */
    private $legends = [];

    /**
     * @param mixed $width
     * @param mixed $height
     * @param mixed $cachedName
     * @param mixed $timeout
     * @param mixed $inline
     */
    public function __construct($width = 300, $height = 200, $cachedName = '', $timeout = 0, $inline = 1)
    {
        parent::__construct($width, $height, $cachedName, $timeout, $inline);
        $this->posx = $width / 2;
        $this->posy = $height / 2;
        $this->SetColor([255, 255, 255]);

        if (!$this->graph_theme) {
            return;
        }

        $this->graph_theme->ApplyGraph($this);
    }

    /**
     * PUBLIC METHODS.
     *
     * @param mixed $aObj
     */
    public function Add($aObj)
    {
        if (\is_array($aObj) && Configs::safe_count($aObj) > 0) {
            $cl = $aObj[0];
        } else {
            $cl = $aObj;
        }

        if ($cl instanceof Text\Text) {
            $this->AddText($aObj);
        } elseif (($cl instanceof Plot\IconPlot)) {
            $this->AddIcon($aObj);
        } else {
            if (\is_array($aObj)) {
                $n = Configs::safe_count($aObj);

                for ($i = 0; $i < $n; ++$i) {
                    //if ($aObj[$i]->theme) {
                    //    $this->ClearTheme();
                    //}
                    $this->plots[] = $aObj[$i];
                }
            } else {
                //if ($aObj->theme) {
                //    $this->ClearTheme();
                //}
                $this->plots[] = $aObj;
            }
        }

        if (!$this->graph_theme) {
            return;
        }

        $this->graph_theme->SetupPlot($aObj);

        if (!$aObj->is_using_plot_theme) {
            return;
        }

        $aObj->UsePlotThemeColors();
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

        $this->isRunningClear = false;
    }

    public function SetAntiAliasing($aFlg = true)
    {
        $this->pieaa = $aFlg;
    }

    /**
     * @param int[] $c
     */
    public function SetColor($c)
    {
        $this->SetMarginColor($c);
    }

    public function DisplayCSIMAreas()
    {
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

    // Method description
    public function Stroke($aStrokeFileName = '')
    {
        // If the filename is the predefined value = '_csim_special_'
        // we assume that the call to stroke only needs to do enough
        // to correctly generate the CSIM maps.
        // We use this variable to skip things we don't strictly need
        // to do to generate the image map to improve performance
        // a best we can. Therefor you will see a lot of tests !$_csim in the
        // code below.
        $_csim = (Configs::getConfig('_CSIM_SPECIALFILE') === $aStrokeFileName);

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

        $n = Configs::safe_count($this->plots);

        if ($this->pieaa) {
            if (!$_csim) {
                if ('' !== $this->background_image) {
                    $this->StrokeFrameBackground();
                } else {
                    $this->StrokeFrame();
                    $this->StrokeBackgroundGrad();
                }
            }

            $w = $this->img->width;
            $h = $this->img->height;
            $oldimg = $this->img->img;

            $this->img->CreateImgCanvas(2 * $w, 2 * $h);

            $this->img->SetColor($this->margin_color);
            $this->img->FilledRectangle(0, 0, 2 * $w - 1, 2 * $h - 1);

            // Make all icons *2 i size since we will be scaling down the
            // imahe to do the anti aliasing
            $ni = Configs::safe_count($this->iIcons);

            for ($i = 0; $i < $ni; ++$i) {
                $this->iIcons[$i]->iScale *= 2;

                if (1 < $this->iIcons[$i]->iX) {
                    $this->iIcons[$i]->iX *= 2;
                }

                if (1 >= $this->iIcons[$i]->iY) {
                    continue;
                }

                $this->iIcons[$i]->iY *= 2;
            }

            $this->StrokeIcons();

            for ($i = 0; $i < $n; ++$i) {
                if (1 < $this->plots[$i]->posx) {
                    $this->plots[$i]->posx *= 2;
                }

                if (1 < $this->plots[$i]->posy) {
                    $this->plots[$i]->posy *= 2;
                }

                $this->plots[$i]->Stroke($this->img, 1);

                if (1 < $this->plots[$i]->posx) {
                    $this->plots[$i]->posx /= 2;
                }

                if (1 >= $this->plots[$i]->posy) {
                    continue;
                }

                $this->plots[$i]->posy /= 2;
            }

            $indent = $this->doframe ? ($this->frame_weight + ($this->doshadow ? $this->shadow_width : 0)) : 0;
            $indent += $this->framebevel ? $this->framebeveldepth + 1 : 0;
            $this->img->CopyCanvasH(
                $oldimg,
                $this->img->img,
                $indent,
                $indent,
                $indent,
                $indent,
                $w - 2 * $indent,
                $h - 2 * $indent,
                2 * ($w - $indent),
                2 * ($h - $indent)
            );

            $this->img->img = $oldimg;
            $this->img->width = $w;
            $this->img->height = $h;

            for ($i = 0; $i < $n; ++$i) {
                $this->plots[$i]->Stroke($this->img, 2); // Stroke labels
                $this->plots[$i]->Legend($this);
            }
        } else {
            if (!$_csim) {
                if ('' !== $this->background_image) {
                    $this->StrokeFrameBackground();
                } else {
                    $this->StrokeFrame();
                    $this->StrokeBackgroundGrad();
                }
            }

            $this->StrokeIcons();

            for ($i = 0; $i < $n; ++$i) {
                $this->plots[$i]->Stroke($this->img);
                $this->plots[$i]->Legend($this);
            }
        }

        $this->legend->Stroke($this->img);
        $this->footer->Stroke($this->img);
        $this->StrokeTitles();

        if ($_csim) {
            return;
        }

        // Stroke texts
        if (null !== $this->texts) {
            $n = Configs::safe_count($this->texts);

            for ($i = 0; $i < $n; ++$i) {
                $this->texts[$i]->Stroke($this->img);
            }
        }

        if (Configs::_JPG_DEBUG) {
            $this->DisplayCSIMAreas();
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
        $this->cache->PutAndStream(
            $this->img,
            $this->cache_name,
            $this->inline,
            $aStrokeFileName
        );
    }
}

// @class
