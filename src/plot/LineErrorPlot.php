<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Plot;

use Amenadiel\JpGraph\Util;

/**
 * @class LineErrorPlot
 * // Description: Combine a line and error plot
 */
class LineErrorPlot extends ErrorPlot
{
    public $line;

    /**
     * CONSTRUCTOR.
     *
     * @param mixed $datay
     * @param mixed $datax
     */
    // Data is (val, errdeltamin, errdeltamax)
    public function __construct($datay, $datax = false)
    {
        $ly = [];
        $ey = [];
        $n  = safe_count($datay);
        if ($n % 3 != 0) {
            Util\JpGraphError::RaiseL(4002);
            //('Error in input data to LineErrorPlot. Number of data points must be a multiple of 3');
        }
        for ($i = 0; $i < $n; $i += 3) {
            $ly[] = $datay[$i];
            $ey[] = $datay[$i] + $datay[$i + 1];
            $ey[] = $datay[$i] + $datay[$i + 2];
        }
        parent::__construct($ey, $datax);
        $this->line = new LinePlot($ly, $datax);
    }

    /**
     * PUBLIC METHODS.
     *
     * @param mixed $graph
     */
    public function Legend($graph)
    {
        if ($this->legend != '') {
            $graph->legend->Add($this->legend, $this->color);
        }

        $this->line->Legend($graph);
    }

    public function Stroke($img, $xscale, $yscale)
    {
        parent::Stroke($img, $xscale, $yscale);
        $this->line->Stroke($img, $xscale, $yscale);
    }
} // @class

/* EOF */
