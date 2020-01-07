<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Plot;

require_once __DIR__ . '/../config.inc.php';

use Amenadiel\JpGraph\Util;

/**
 * @class Plot
 * // Description: Abstract base class for all concrete plot classes
 */
class Plot
{
    public $numpoints = 0;
    public $value;
    public $legend         = '';
    public $coords         = [];
    public $color          = 'black';
    public $hidelegend     = false;
    public $line_weight    = 1;
    public $csimtargets    = [];
    public $csimwintargets = []; // Array of targets for CSIM
    public $csimareas      = ''; // Resultant CSIM area tags
    public $csimalts; // ALT:s for corresponding target
    public $legendcsimtarget    = '';
    public $legendcsimwintarget = '';
    public $legendcsimalt       = '';
    protected $weight           = 1;
    protected $center           = false;

    protected $inputValues;
    protected $isRunningClear = false;

    public function __construct($aDatay, $aDatax = false)
    {
        $this->numpoints = safe_count($aDatay);
        if ($this->numpoints == 0) {
            Util\JpGraphError::RaiseL(25121); //("Empty input data array specified for plot. Must have at least one data point.");
        }

        if (!$this->isRunningClear) {
            $this->inputValues           = [];
            $this->inputValues['aDatay'] = $aDatay;
            $this->inputValues['aDatax'] = $aDatax;
        }

        $this->coords[0] = $aDatay;
        if (is_array($aDatax)) {
            $this->coords[1] = $aDatax;
            $n               = safe_count($aDatax);
            for ($i = 0; $i < $n; ++$i) {
                if (!is_numeric($aDatax[$i])) {
                    Util\JpGraphError::RaiseL(25070);
                }
            }
        }
        $this->value = new DisplayValue();
    }

    // Stroke the plot
    // "virtual" function which must be implemented by
    // the subclasses
    public function Stroke($aImg, $aXScale, $aYScale)
    {
        Util\JpGraphError::RaiseL(25122); //("JpGraph: Stroke() must be implemented by concrete subclass to class Plot");
    }

    public function HideLegend($f = true)
    {
        $this->hidelegend = $f;
    }

    public function DoLegend($graph)
    {
        if (!$this->hidelegend) {
            $this->Legend($graph);
        }
    }

    public function StrokeDataValue($img, $aVal, $x, $y)
    {
        $this->value->Stroke($img, $aVal, $x, $y);
    }

    // Set href targets for CSIM
    public function SetCSIMTargets($aTargets, $aAlts = '', $aWinTargets = '')
    {
        $this->csimtargets    = $aTargets;
        $this->csimwintargets = $aWinTargets;
        $this->csimalts       = $aAlts;
    }

    // Get all created areas
    public function GetCSIMareas()
    {
        return $this->csimareas;
    }

    // "Virtual" function which gets called before any scale
    // or axis are stroked used to do any plot specific adjustment
    public function PreStrokeAdjust($aGraph)
    {
        if (substr($aGraph->axtype, 0, 4) == 'text' && (isset($this->coords[1]))) {
            Util\JpGraphError::RaiseL(25123); //("JpGraph: You can't use a text X-scale with specified X-coords. Use a \"int\" or \"lin\" scale instead.");
        }

        return true;
    }

    // Virtual function to the the concrete plot class to make any changes to the graph
    // and scale before the stroke process begins
    public function PreScaleSetup($aGraph)
    {
        // Empty
    }

    // Get minimum values in plot
    public function Min()
    {
        if (isset($this->coords[1])) {
            $x = $this->coords[1];
        } else {
            $x = '';
        }
        if ($x != '' && safe_count($x) > 0) {
            $xm = min($x);
        } else {
            $xm = 0;
        }
        $y   = $this->coords[0];
        $cnt = safe_count($y);
        if ($cnt > 0) {
            $i = 0;
            while ($i < $cnt && !is_numeric($ym = $y[$i])) {
                ++$i;
            }
            while ($i < $cnt) {
                if (is_numeric($y[$i])) {
                    $ym = min($ym, $y[$i]);
                }
                ++$i;
            }
        } else {
            $ym = '';
        }

        return [$xm, $ym];
    }

    // Get maximum value in plot
    public function Max()
    {
        if (isset($this->coords[1])) {
            $x = $this->coords[1];
        } else {
            $x = '';
        }

        if ($x != '' && safe_count($x) > 0) {
            $xm = max($x);
        } else {
            $xm = $this->numpoints - 1;
        }
        $y = $this->coords[0];
        if (safe_count($y) > 0) {
            $cnt = safe_count($y);
            $i   = 0;
            while ($i < $cnt && !is_numeric($ym = $y[$i])) {
                ++$i;
            }
            while ($i < $cnt) {
                if (is_numeric($y[$i])) {
                    $ym = max($ym, $y[$i]);
                }
                ++$i;
            }
        } else {
            $ym = '';
        }

        return [$xm, $ym];
    }

    public function SetColor($aColor)
    {
        $this->color = $aColor;
    }

    public function SetLegend($aLegend, $aCSIM = '', $aCSIMAlt = '', $aCSIMWinTarget = '')
    {
        $this->legend              = $aLegend;
        $this->legendcsimtarget    = $aCSIM;
        $this->legendcsimwintarget = $aCSIMWinTarget;
        $this->legendcsimalt       = $aCSIMAlt;
    }

    public function SetWeight($aWeight)
    {
        $this->weight = $aWeight;
    }

    public function SetLineWeight($aWeight = 1)
    {
        $this->line_weight = $aWeight;
    }

    public function SetCenter($aCenter = true)
    {
        $this->center = $aCenter;
    }

    // This method gets called by Graph class to plot anything that should go
    // into the margin after the margin color has been set.
    public function StrokeMargin($aImg)
    {
        return true;
    }

    // Framework function the chance for each plot class to set a legend
    public function Legend($aGraph)
    {
        if ($this->legend != '') {
            $aGraph->legend->Add($this->legend, $this->color, '', 0, $this->legendcsimtarget, $this->legendcsimalt, $this->legendcsimwintarget);
        }
    }

    public function Clear()
    {
        $this->isRunningClear = true;
        $this->__construct($this->inputValues['aDatay'], $this->inputValues['aDatax']);
        $this->isRunningClear = false;
    }
} // @class
