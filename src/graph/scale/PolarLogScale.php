<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Configs;
use const M_PI;

class PolarLogScale extends LogScale
{
    public $clockwise = false;

    private $graph;

    public function __construct($aMax, $graph, $aClockwise = false)
    {
        parent::__construct(0, $aMax, 'x');
        $this->graph = $graph;

        if ($this->ticks instanceof LogTicks) {
            $this->ticks->SetLabelLogType(Configs::LOGLABELS_MAGNITUDE);
        }
        $this->clockwise = $aClockwise;
    }

    public function SetClockwise($aFlg)
    {
        $this->clockwise = $aFlg;
    }

    public function PTranslate($aAngle, $aRad)
    {
        if (0 === $aRad) {
            $aRad = 1;
        }

        $aRad = \log10($aRad);
        $m = $this->scale[1];
        $w = $this->graph->img->plotwidth / 2;
        $aRad = $aRad / $m * $w;

        $a = $aAngle / 180 * M_PI;

        if ($this->clockwise) {
            $a = 2 * M_PI - $a;
        }

        $x = \cos($a) * $aRad;
        $y = \sin($a) * $aRad;

        $x += $w + $this->graph->img->left_margin; //$this->_Translate(0);

        if (Configs::POLAR_360 === $this->graph->iType) {
            $y = ($this->graph->img->top_margin + $this->graph->img->plotheight / 2) - $y;
        } else {
            $y = ($this->graph->img->top_margin + $this->graph->img->plotheight) - $y;
        }

        return [$x, $y];
    }
}
