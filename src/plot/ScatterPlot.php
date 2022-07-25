<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Plot;

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Util;

/**
 * @class ScatterPlot
 * // Description: Render X and Y plots
 */
class ScatterPlot extends Plot
{
    public $mark;

    public $link;

    private $impuls = false;

    /**
     * @param mixed $datay
     * @param mixed $datax
     */
    public function __construct($datay, $datax = false)
    {
        if ((Configs::safe_count($datax) !== Configs::safe_count($datay)) && \is_array($datax)) {
            throw Util\JpGraphError::make(20003); //("Scatterplot must have equal number of X and Y points.");
        }
        parent::__construct($datay, $datax);
        $this->mark = new PlotMark();
        $this->mark->SetType(
            Configs::MARK_SQUARE
        );
        $this->mark->SetColor($this->color);
        $this->value->SetAlign('center', 'center');
        $this->value->SetMargin(0);
        $this->link = new Graph\Scale\LineProperty(1, 'black', 'solid');
        $this->link->iShow = false;
    }

    /**
     * PUBLIC METHODS.
     *
     * @param mixed $f
     */
    public function SetImpuls($f = true)
    {
        $this->impuls = $f;
    }

    public function SetStem($f = true)
    {
        $this->impuls = $f;
    }

    // Combine the scatter plot points with a line
    public function SetLinkPoints($aFlag = true, $aColor = 'black', $aWeight = 1, $aStyle = 'solid')
    {
        $this->link->iShow = $aFlag;
        $this->link->iColor = $aColor;
        $this->link->iWeight = $aWeight;
        $this->link->iStyle = $aStyle;
    }

    public function Stroke($aImg, $aXScale, $aYScale)
    {
        $ymin = $aYScale->scale_abs[0];

        if (0 > $aYScale->scale[0]) {
            $yzero = $aYScale->Translate(0);
        } else {
            $yzero = $aYScale->scale_abs[0];
        }

        $this->csimareas = '';

        for ($i = 0; $i < $this->numpoints; ++$i) {
            // Skip null values
            if ('' === $this->coords[0][$i] || '-' === $this->coords[0][$i] || 'x' === $this->coords[0][$i]) {
                continue;
            }

            if (isset($this->coords[1])) {
                $xt = $aXScale->Translate($this->coords[1][$i]);
            } else {
                $xt = $aXScale->Translate($i);
            }

            $yt = $aYScale->Translate($this->coords[0][$i]);

            if ($this->link->iShow && isset($yt_old)) {
                $aImg->SetColor($this->link->iColor);
                $aImg->SetLineWeight($this->link->iWeight);
                $old = $aImg->SetLineStyle($this->link->iStyle);
                $aImg->StyleLine($xt_old, $yt_old, $xt, $yt);
                $aImg->SetLineStyle($old);
            }

            if ($this->impuls) {
                $aImg->SetColor($this->color);
                $aImg->SetLineWeight($this->weight);
                $aImg->Line($xt, $yzero, $xt, $yt);
            }

            if (!empty($this->csimtargets[$i])) {
                if (!empty($this->csimwintargets[$i])) {
                    $this->mark->SetCSIMTarget($this->csimtargets[$i], $this->csimwintargets[$i]);
                } else {
                    $this->mark->SetCSIMTarget($this->csimtargets[$i]);
                }
                $this->mark->SetCSIMAlt($this->csimalts[$i]);
            }

            if (isset($this->coords[1])) {
                $this->mark->SetCSIMAltVal($this->coords[0][$i], $this->coords[1][$i]);
            } else {
                $this->mark->SetCSIMAltVal($this->coords[0][$i], $i);
            }

            $this->mark->Stroke($aImg, $xt, $yt);

            $this->csimareas .= $this->mark->GetCSIMAreas();
            $this->value->Stroke($aImg, $this->coords[0][$i], $xt, $yt);

            $xt_old = $xt;
            $yt_old = $yt;
        }
    }

    // Framework function
    public function Legend($aGraph)
    {
        if ('' === $this->legend) {
            return;
        }

        $aGraph->legend->Add(
            $this->legend,
            $this->mark->fill_color,
            $this->mark,
            0,
            $this->legendcsimtarget,
            $this->legendcsimalt,
            $this->legendcsimwintarget
        );
    }
}

// @class
/* EOF */
