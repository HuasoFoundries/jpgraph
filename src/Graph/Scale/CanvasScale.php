<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

/**
 * @class CanvasScale
  *  Description: Define a scale for canvas so we
  *  can abstract away with absolute pixels
 */
class CanvasScale
{
    private $g;

    private $w;

    private $h;

    private $ixmin = 0;

    private $ixmax = 10;

    private $iymin = 0;

    private $iymax = 10;

    public function __construct($graph, $xmin = 0, $xmax = 10, $ymin = 0, $ymax = 10)
    {
        $this->g = $graph;
        $this->w = $graph->img->width;
        $this->h = $graph->img->height;
        $this->ixmin = $xmin;
        $this->ixmax = $xmax;
        $this->iymin = $ymin;
        $this->iymax = $ymax;
    }

    /**
     * @param float|int $xmin
     * @param float|int $xmax
     * @param float|int $ymin
     * @param float|int $ymax
     *
     * @return void
     */
    public function Set($xmin = 0, $xmax = 10, $ymin = 0, $ymax = 10)
    {
        $this->ixmin = $xmin;
        $this->ixmax = $xmax;
        $this->iymin = $ymin;
        $this->iymax = $ymax;
    }

    /**
     * @return array
     *
     * @psalm-return array{0: mixed, 1: mixed, 2: mixed, 3: mixed}
     */
    public function Get()
    {
        return [$this->ixmin, $this->ixmax, $this->iymin, $this->iymax];
    }

    /**
     * @return float[]
     *
     * @psalm-return array{0: float, 1: float}
     */
    public function Translate($x, $y)
    {
        $xp = \round(($x - $this->ixmin) / ($this->ixmax - $this->ixmin) * $this->w);
        $yp = \round(($y - $this->iymin) / ($this->iymax - $this->iymin) * $this->h);

        return [$xp, $yp];
    }

    /**
     * @return float
     */
    public function TranslateX($x)
    {
        return \round(($x - $this->ixmin) / ($this->ixmax - $this->ixmin) * $this->w);
    }

    /**
     * @return float
     */
    public function TranslateY($y)
    {
        return \round(($y - $this->iymin) / ($this->iymax - $this->iymin) * $this->h);
    }
}
