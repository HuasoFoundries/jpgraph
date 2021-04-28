<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Configs;
use const M_PI;

class PolarScale extends LinearScale
{
    public $clockwise = false;

    private $graph;

    public function __construct($aMax, $graph, $aClockwise)
    {
        parent::__construct(0, $aMax, 'x');
        $this->graph = $graph;
        $this->clockwise = $aClockwise;
    }

    public function SetClockwise($aFlg)
    {
        $this->clockwise = $aFlg;
    }

    public function _Translate($v)
    {
        return parent::Translate($v);
    }

    public function PTranslate($aAngle, $aRad)
    {
        $m = $this->scale[1];
        $w = $this->graph->img->plotwidth / 2;
        $aRad = $aRad / $m * $w;

        $a = $aAngle / 180 * M_PI;

        if ($this->clockwise) {
            $a = 2 * M_PI - $a;
        }

        $x = \cos($a) * $aRad;
        $y = \sin($a) * $aRad;

        $x += $this->_Translate(0);

        if (Configs::POLAR_360 === $this->graph->iType) {
            $y = ($this->graph->img->top_margin + $this->graph->img->plotheight / 2) - $y;
        } else {
            $y = ($this->graph->img->top_margin + $this->graph->img->plotheight) - $y;
        }

        return [$x, $y];
    }
}
