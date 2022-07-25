<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Image;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Text;
use Amenadiel\JpGraph\Util;
use const M_PI;
use function max;
use function min;

/**
 * @class RadarGraph
 *  Description: Main container for a radar graph
 */
class RadarGraph extends Graph
{
    public RadarGrid $grid;

    public Axis\RadarAxis $axis;

    private $posx;

    private $posy;

    private $len;

    private $axis_title;

    public function __construct($width = 300, $height = 200, $cachedName = '', $timeout = 0, $inline = 1)
    {
        parent::__construct($width, $height, $cachedName, $timeout, $inline);
        $this->posx = $width / 2;
        $this->posy = $height / 2;
        $this->len = \min($width, $height) * 0.35;
        $this->SetColor([255, 255, 255]);
        $this->SetTickDensity(
            Configs::TICKD_NORMAL
        );
        $this->SetScale('lin');
        $this->SetGridDepth(
            Configs::DEPTH_FRONT
        );
    }

    public function HideTickMarks($aFlag = true)
    {
        $this->axis->scale->ticks->SupressTickMarks($aFlag);
    }

    public function ShowMinorTickmarks($aFlag = true)
    {
        $this->yscale->ticks->SupressMinorTickMarks(!$aFlag);
    }

    /**
     * @param string $axtype
     */
    public function SetScale($axtype, $ymin = 1, $ymax = 1, $dummy1 = null, $dumy2 = null): self
    {
        if ('lin' !== $axtype && 'log' !== $axtype) {
            throw      Util\JpGraphError::make(18003, $axtype);
            //("Illegal scale for radarplot ($axtype). Must be \"lin\" or \"log\"");
        }

        if ('lin' === $axtype) {
            $this->yscale = new Scale\LinearScale($ymin, $ymax, 'y', 'radar');
        } elseif ('log' === $axtype) {
            $this->yscale = new Scale\LogScale($ymin, $ymax, 'y', 'radar');
        }

        $this->axis = new Axis\RadarAxis($this->img, $this->yscale);
        $this->grid = new RadarGrid();
        return $this;
    }

    public function SetSize($aSize)
    {
        if (0.1 > $aSize || 1 < $aSize) {
            throw      Util\JpGraphError::make(18004, $aSize);
            //("Radar Plot size must be between 0.1 and 1. (Your value=$s)");
        }
        $this->len = \min($this->img->width, $this->img->height) * $aSize / 2;
    }

    public function SetPlotSize($aSize)
    {
        $this->SetSize($aSize);
    }

    /**
     * @param int $densy
     */
    public function SetTickDensity($densy = Configs::TICKD_NORMAL, $dummy1 = null): self
    {
        $this->ytick_factor = 25;

        switch ($densy) {
            case Configs::TICKD_DENSE:
                $this->ytick_factor = 12;

                break;
            case Configs::TICKD_NORMAL:
                $this->ytick_factor = 25;

                break;
            case Configs::TICKD_SPARSE:
                $this->ytick_factor = 40;

                break;
            case Configs::TICKD_VERYSPARSE:
                $this->ytick_factor = 70;

                break;

            default:
                throw      Util\JpGraphError::make(18005, $densy);
                //("RadarPlot Unsupported Tick density: $densy");
        }
        return $this;
    }

    public function SetPos($px, $py = 0.5)
    {
        $this->SetCenter($px, $py);
    }

    public function SetCenter($px, $py = 0.5)
    {
        if (0 <= $px && 1 >= $px) {
            $this->posx = $this->img->width * $px;
        } else {
            $this->posx = $px;
        }

        if (0 <= $py && 1 >= $py) {
            $this->posy = $this->img->height * $py;
        } else {
            $this->posy = $py;
        }
    }

    /**
     * @param int[] $aColor
     */
    public function SetColor($aColor)
    {
        $this->SetMarginColor($aColor);
    }

    public function SetTitles($aTitleArray)
    {
        $this->axis_title = $aTitleArray;
    }

    public function Add($aPlot): self
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
        } elseif (($cl instanceof Plot\IconPlot)) {
            $this->AddIcon($aPlot);
        } else {
            $this->plots[] = $aPlot;
        }
        return $this;
    }

    public function GetPlotsYMinMax($aPlots)
    {
        $min = $aPlots[0]->Min();
        $max = $aPlots[0]->Max();

        foreach ($this->plots as $p) {
            $max = \max($max, $p->Max());
            $min = \min($min, $p->Min());
        }

        if (0 > $min) {
            throw      Util\JpGraphError::make(18006, $min);
            //("Minimum data $min (Radar plots should only be used when all data points > 0)");
        }

        return [$min, $max];
    }

    public function StrokeIcons()
    {
        if (null === $this->iIcons) {
            return;
        }

        $n = Configs::safe_count($this->iIcons);

        for ($i = 0; $i < $n; ++$i) {
            $this->iIcons[$i]->Stroke($this->img);
        }
    }

    public function StrokeTexts()
    {
        if (null === $this->texts) {
            return;
        }

        $n = Configs::safe_count($this->texts);

        for ($i = 0; $i < $n; ++$i) {
            $this->texts[$i]->Stroke($this->img);
        }
    }

    // Stroke the Radar graph
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

        // We need to know if we have stroked the plot in the
        // GetCSIMareas. Otherwise the CSIM hasn't been generated
        // and in the case of GetCSIM called before stroke to generate
        // CSIM without storing an image to disk GetCSIM must call Stroke.
        $this->iHasStroked = true;

        $n = Configs::safe_count($this->plots);
        // Set Y-scale

        if (!$this->yscale->IsSpecified() && Configs::safe_count($this->plots) > 0) {
            [$min, $max] = $this->GetPlotsYMinMax($this->plots);
            $this->yscale->AutoScale($this->img, 0, $max, $this->len / $this->ytick_factor);
        } elseif ($this->yscale->IsSpecified()
            && ($this->yscale->auto_ticks || !$this->yscale->ticks->IsSpecified())
        ) {
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
                $this->len / $this->ytick_factor,
                $this->yscale->auto_ticks
            );
        }

        // Set start position end length of scale (in absolute pixels)
        $this->yscale->SetConstants($this->posx, $this->len);

        // We need as many axis as there are data points
        $nbrpnts = $this->plots[0]->GetCount();

        // If we have no titles just number the axis 1,2,3,...
        if (null === $this->axis_title) {
            for ($i = 0; $i < $nbrpnts; ++$i) {
                $this->axis_title[$i] = $i + 1;
            }
        } elseif (Configs::safe_count($this->axis_title) < $nbrpnts
        ) {
            throw      Util\JpGraphError::make(18007);
            // ("Number of titles does not match number of points in plot.");
        }

        for ($i = 0; $i < $n; ++$i) {
            if ($this->plots[$i]->GetCount() === $nbrpnts) {
                continue;
            }

            throw      Util\JpGraphError::make(18008);
            //("Each radar plot must have the same number of data points.");
        }

        if (!$_csim) {
            if ('' !== $this->background_image) {
                $this->StrokeFrameBackground();
            } else {
                $this->StrokeFrame();
                $this->StrokeBackgroundGrad();
            }
        }
        $astep = 2 * M_PI / $nbrpnts;

        if (!$_csim) {
            if (Configs::getConfig('DEPTH_BACK') === $this->iIconDepth
            ) {
                $this->StrokeIcons();
            }

            // Prepare legends
            for ($i = 0; $i < $n; ++$i) {
                $this->plots[$i]->Legend($this);
            }
            $this->legend->Stroke($this->img);
            $this->footer->Stroke($this->img);
        }
        $grid = [];

        if (!$_csim) {
            if (Configs::getConfig('DEPTH_BACK') === $this->grid_depth
            ) {
                // Draw axis and grid
                for ($i = 0, $a = M_PI / 2; $i < $nbrpnts; ++$i, $a += $astep) {
                    $this->axis->Stroke($this->posy, $a, $grid[$i], $this->axis_title[$i], 0 === $i);
                }
                $this->grid->Stroke($this->img, $grid);
            }

            if (Configs::getConfig('DEPTH_BACK') === $this->iIconDepth
            ) {
                $this->StrokeIcons();
            }
        }

        // Plot points
        $a = M_PI / 2;

        for ($i = 0; $i < $n; ++$i) {
            $this->plots[$i]->Stroke($this->img, $this->posy, $this->yscale, $a);
        }

        if (!$_csim) {
            if (Configs::getConfig('DEPTH_BACK') !== $this->grid_depth
            ) {
                // Draw axis and grid
                for ($i = 0, $a = M_PI / 2; $i < $nbrpnts; ++$i, $a += $astep) {
                    $this->axis->Stroke($this->posy, $a, $grid[$i], $this->axis_title[$i], 0 === $i);
                }
                $this->grid->Stroke($this->img, $grid);
            }

            $this->StrokeTitles();
            $this->StrokeTexts();

            if (Configs::DEPTH_FRONT === $this->iIconDepth
            ) {
                $this->StrokeIcons();
            }
        }

        // Should we do any final image transformation
        if ($this->iImgTrans && !$_csim) {
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

        if ($_csim) {
            return;
        }

        // If the filename is given as the special "__handle"
        // then the image handler is returned and the image is NOT
        // streamed back
        if (Configs::getConfig('_IMG_HANDLER') === $aStrokeFileName
        ) {
            return $this->img->img;
        }
        // Finally stream the generated picture
        $this->cache->PutAndStream($this->img, $this->cache_name, $this->inline, $aStrokeFileName);
    }
}

// @class
