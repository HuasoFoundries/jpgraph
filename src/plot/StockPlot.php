<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Plot;

use Amenadiel\JpGraph\Util;

/**
 * File:        JPGRAPH_STOCK.PHP
 * // Description: Stock plot extension for JpGraph
 * // Created:     2003-01-27
 * // Ver:         $Id: jpgraph_stock.php 1364 2009-06-24 07:07:44Z ljp $.
 * //
 * // Copyright (c) Asial Corporation. All rights reserved.
 */

/**
 * @class StockPlot
 */
class StockPlot extends Plot
{
    protected $iTupleSize = 4;

    private $iWidth = 9;

    private $iEndLines = 1;

    private $iStockColor1 = 'white';

    private $iStockColor2 = 'darkred';

    private $iStockColor3 = 'darkred';

    /**
     * @param mixed $datay
     * @param mixed $datax
     */
    public function __construct($datay, $datax = false)
    {
        if (Configs::safe_count($datay) % $this->iTupleSize
        ) {
            throw Util\JpGraphError::make(21001, $this->iTupleSize);
            //('Data values for Stock charts must contain an even multiple of '.$this->iTupleSize.' data points.');
        }
        parent::__construct($datay, $datax);
        $this->numpoints /= $this->iTupleSize;
    }

    /**
     * PUBLIC METHODS.
     *
     * @param mixed $aColor
     * @param mixed $aColor1
     * @param mixed $aColor2
     * @param mixed $aColor3
     */
    public function SetColor($aColor, $aColor1 = 'white', $aColor2 = 'darkred', $aColor3 = 'darkred')
    {
        $this->color = $aColor;
        $this->iStockColor1 = $aColor1;
        $this->iStockColor2 = $aColor2;
        $this->iStockColor3 = $aColor3;
    }

    public function SetWidth($aWidth)
    {
        // Make sure it's odd
        $this->iWidth = 2 * \floor($aWidth / 2) + 1;
    }

    public function HideEndLines($aHide = true)
    {
        $this->iEndLines = !$aHide;
    }

    // Gets called before any axis are stroked
    public function PreStrokeAdjust($aGraph)
    {
        if ($this->center) {
            $a = 0.5;
            $b = 0.5;
            ++$this->numpoints;
        } else {
            $a = 0;
            $b = 0;
        }
        $aGraph->xaxis->scale->ticks->SetXLabelOffset($a);
        $aGraph->SetTextScaleOff($b);
    }

    // Method description
    public function Stroke($aImg, $aXScale, $aYScale)
    {
        $n = $this->numpoints;

        if ($this->center) {
            --$n;
        }

        if (isset($this->coords[1])) {
            if (Configs::safe_count($this->coords[1]) !== $n
            ) {
                throw Util\JpGraphError::make(2003, Configs::safe_count($this->coords[1]), $n);
                // ("Number of X and Y points are not equal. Number of X-points:". Configs::safe_count($this->coords[1])." Number of Y-points:$numpoints");
            }
            $exist_x = true;
        } else {
            $exist_x = false;
        }

        if ($exist_x) {
            $xs = $this->coords[1][0];
        } else {
            $xs = 0;
        }

        $ts = $this->iTupleSize;
        $this->csimareas = '';

        for ($i = 0; $i < $n; ++$i) {
            //If value is NULL, then don't draw a bar at all
            if ($this->coords[0][$i * $ts] === null) {
                continue;
            }

            if ($exist_x) {
                $x = $this->coords[1][$i];

                if (null === $x) {
                    continue;
                }
            } else {
                $x = $i;
            }
            $xt = $aXScale->Translate($x);

            $neg = $this->coords[0][$i * $ts] > $this->coords[0][$i * $ts + 1];
            $yopen = $aYScale->Translate($this->coords[0][$i * $ts]);
            $yclose = $aYScale->Translate($this->coords[0][$i * $ts + 1]);
            $ymin = $aYScale->Translate($this->coords[0][$i * $ts + 2]);
            $ymax = $aYScale->Translate($this->coords[0][$i * $ts + 3]);

            $dx = \floor($this->iWidth / 2);
            $xl = $xt - $dx;
            $xr = $xt + $dx;

            if ($neg) {
                $aImg->SetColor($this->iStockColor3);
            } else {
                $aImg->SetColor($this->iStockColor1);
            }
            $aImg->FilledRectangle($xl, $yopen, $xr, $yclose);
            $aImg->SetLineWeight($this->weight);

            if ($neg) {
                $aImg->SetColor($this->iStockColor2);
            } else {
                $aImg->SetColor($this->color);
            }

            $aImg->Rectangle($xl, $yopen, $xr, $yclose);

            if ($yopen < $yclose) {
                $ytop = $yopen;
                $ybottom = $yclose;
            } else {
                $ytop = $yclose;
                $ybottom = $yopen;
            }
            $aImg->SetColor($this->color);
            $aImg->Line($xt, $ytop, $xt, $ymax);
            $aImg->Line($xt, $ybottom, $xt, $ymin);

            if ($this->iEndLines) {
                $aImg->Line($xl, $ymax, $xr, $ymax);
                $aImg->Line($xl, $ymin, $xr, $ymin);
            }

            // A chance for subclasses to add things to the bar
            // for data point i
            $this->ModBox($aImg, $aXScale, $aYScale, $i, $xl, $xr, $neg);

            // Setup image maps
            if (empty($this->csimtargets[$i])) {
                // Setup image maps
                continue;
                // Setup image maps
            }

            $this->csimareas .= '<area shape="rect" coords="' .
                \round($xl) . ',' . \round($ytop) . ',' .
                \round($xr) . ',' . \round($ybottom) . '" ';
            $this->csimareas .= ' href="' . $this->csimtargets[$i] . '"';

            if (!empty($this->csimalts[$i])) {
                $sval = $this->csimalts[$i];
                $this->csimareas .= " title=\"{$sval}\" alt=\"{$sval}\" ";
            }
            $this->csimareas .= "  />\n";
        }

        return true;
    }

    // A hook for subclasses to modify the plot
    public function ModBox($img, $xscale, $yscale, $i, $xl, $xr, $neg)
    {
    }
}

// @class
