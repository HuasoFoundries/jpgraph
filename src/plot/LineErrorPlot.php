<?php

/**
 * JPGraph - Community Edition
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
     * @param mixed $datay
     * @param mixed $datax
     */
    // Data is (val, errdeltamin, errdeltamax)
    public function __construct($datay, $datax = false)
    {
        $ly = [];
        $ey = [];
        $n = Configs::safe_count($datay);

        if ($n % 3 !== 0) {
            throw Util\JpGraphError::make(4002);
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
     * @param mixed $aGraph
     */
    public function Legend($aGraph)
    {
        if ('' !== $this->legend) {
            $aGraph->legend->Add($this->legend, $this->color);
        }

        $this->line->Legend($aGraph);
    }

    public function Stroke($img, $xscale, $yscale)
    {
        parent::Stroke($img, $xscale, $yscale);
        $this->line->Stroke($img, $xscale, $yscale);
    }
} // @class

/* EOF */
