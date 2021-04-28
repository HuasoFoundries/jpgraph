<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Tick;
use Amenadiel\JpGraph\Util;

/**
 * @class LinearScale
  *  Description: Handle linear scaling between screen and world
 */
class LinearScale extends Scale
{
    public $textscale = false;

    // Just a flag to let the Plot class find out if
    // we are a textscale or not. This is a cludge since
    // this information is available in Graph::axtype but
    // we don't have access to the graph object in the Plots
    // stroke method. So we let graph store the status here
    // when the linear scale is created. A real cludge...
    public $type; // is this x or y scale ?

    public $ticks; // Store ticks

    public $text_scale_off = 0;

    public $scale_abs = [0, 0];

    public $scale_factor; // Scale factor between world and screen

    public $off; // Offset between image edge and plot area

    public $scale = [0, 0];

    public $name = 'lin';

    public $auto_ticks = false; // When using manual scale should the ticks be automatically set?

    public $world_abs_size; // Plot area size in pixels (Needed public in jpgraph_radar.php)

    public $intscale = false; // Restrict autoscale to integers

    protected $autoscale_min = false; // Forced minimum value, auto determine max

    protected $autoscale_max = false; // Forced maximum value, auto determine min

    private $gracetop = 0;

    private $gracebottom = 0;

    private $_world_size; // Plot area size in world coordinates

    public function __construct($aMin = 0, $aMax = 0, $aType = 'y', $subType = null)
    {
        \assert('x' === $aType || 'y' === $aType);
        \assert($aMin <= $aMax);

        $this->type = $aType;
        $this->scale = [$aMin, $aMax];
        $this->world_size = $aMax - $aMin;

        if ('radar' === $subType) {
            $this->ticks = new Tick\RadarLinearTicks();
            $this->ticks->SupressMinorTickMarks();
        } else {
            $this->ticks = new Tick\LinearTicks();
        }
    }

    // Check if scale is set or if we should autoscale
    // We should do this is either scale or ticks has not been set
    public function IsSpecified()
    {
        if ($this->GetMinVal() === $this->GetMaxVal()) {
            // Scale not set
            return false;
        }

        return true;
    }

    // Set the minimum data value when the autoscaling is used.
    // Usefull if you want a fix minimum (like 0) but have an
    // automatic maximum
    public function SetAutoMin($aMin)
    {
        $this->autoscale_min = $aMin;
    }

    // Set the minimum data value when the autoscaling is used.
    // Usefull if you want a fix minimum (like 0) but have an
    // automatic maximum
    public function SetAutoMax($aMax)
    {
        $this->autoscale_max = $aMax;
    }

    // If the user manually specifies a scale should the ticks
    // still be set automatically?
    public function SetAutoTicks($aFlag = true)
    {
        $this->auto_ticks = $aFlag;
    }

    // Specify scale "grace" value (top and bottom)
    public function SetGrace($aGraceTop, $aGraceBottom = 0)
    {
        if (0 > $aGraceTop || 0 > $aGraceBottom) {
            Util\JpGraphError::RaiseL(25069); //(" Grace must be larger then 0");
        }
        $this->gracetop = $aGraceTop;
        $this->gracebottom = $aGraceBottom;
    }

    // Calculate autoscale. Used if user hasn't given a scale and ticks
    // $maxsteps is the maximum number of major tickmarks allowed.
    public function AutoScale($img, $min, $max, $maxsteps, $majend = true)
    {
        if (!\is_numeric($min) || !\is_numeric($max)) {
            Util\JpGraphError::Raise(25044);
        }

        if ($this->intscale) {
            $this->IntAutoScale($img, $min, $max, $maxsteps, $majend);

            return;
        }

        if (\abs($min - $max) < 0.00001) {
            // We need some difference to be able to autoscale
            // make it 5% above and 5% below value
            if (0 === $min && 0 === $max) {
                // Special case
                $min = -1;
                $max = 1;
            } else {
                $delta = (\abs($max) + \abs($min)) * 0.005;
                $min -= $delta;
                $max += $delta;
            }
        }

        $gracetop = ($this->gracetop / 100.0) * \abs($max - $min);
        $gracebottom = ($this->gracebottom / 100.0) * \abs($max - $min);

        if (\is_numeric($this->autoscale_min)) {
            $min = $this->autoscale_min;

            if ($min >= $max) {
                Util\JpGraphError::RaiseL(25071); //('You have specified a min value with SetAutoMin() which is larger than the maximum value used for the scale. This is not possible.');
            }

            if (\abs($min - $max) < 0.001) {
                $max *= 1.2;
            }
        }

        if (\is_numeric($this->autoscale_max)) {
            $max = $this->autoscale_max;

            if ($min >= $max) {
                Util\JpGraphError::RaiseL(25072); //('You have specified a max value with SetAutoMax() which is smaller than the miminum value used for the scale. This is not possible.');
            }

            if (\abs($min - $max) < 0.001) {
                $min *= 0.8;
            }
        }

        $min -= $gracebottom;
        $max += $gracetop;

        // First get tickmarks as multiples of 0.1, 1, 10, ...
        if ($majend) {
            [$num1steps, $adj1min, $adj1max, $min1step, $maj1step] = $this->CalcTicks($maxsteps, $min, $max, 1, 2);
        } else {
            $adj1min = $min;
            $adj1max = $max;
            [$num1steps, $min1step, $maj1step] = $this->CalcTicksFreeze($maxsteps, $min, $max, 1, 2, false);
        }

        // Then get tick marks as 2:s 0.2, 2, 20, ...
        if ($majend) {
            [$num2steps, $adj2min, $adj2max, $min2step, $maj2step] = $this->CalcTicks($maxsteps, $min, $max, 5, 2);
        } else {
            $adj2min = $min;
            $adj2max = $max;
            [$num2steps, $min2step, $maj2step] = $this->CalcTicksFreeze($maxsteps, $min, $max, 5, 2, false);
        }

        // Then get tickmarks as 5:s 0.05, 0.5, 5, 50, ...
        if ($majend) {
            [$num5steps, $adj5min, $adj5max, $min5step, $maj5step] = $this->CalcTicks($maxsteps, $min, $max, 2, 5);
        } else {
            $adj5min = $min;
            $adj5max = $max;
            [$num5steps, $min5step, $maj5step] = $this->CalcTicksFreeze($maxsteps, $min, $max, 2, 5, false);
        }

        // Check to see whichof 1:s, 2:s or 5:s fit better with
        // the requested number of major ticks
        $match1 = \abs($num1steps - $maxsteps);
        $match2 = \abs($num2steps - $maxsteps);
        $match5 = \abs($num5steps - $maxsteps);

        // Compare these three values and see which is the closest match
        // We use a 0.8 weight to gravitate towards multiple of 5:s
        $r = $this->MatchMin3($match1, $match2, $match5, 0.8);

        switch ($r) {
            case 1:
                $this->Update($img, $adj1min, $adj1max);
                $this->ticks->Set($maj1step, $min1step);

                break;
            case 2:
                $this->Update($img, $adj2min, $adj2max);
                $this->ticks->Set($maj2step, $min2step);

                break;
            case 3:
                $this->Update($img, $adj5min, $adj5max);
                $this->ticks->Set($maj5step, $min5step);

                break;
        }
    }

    // Translate between world and screen
    public function Translate($aCoord)
    {
        if (!\is_numeric($aCoord)) {
            if ('' !== $aCoord && '-' !== $aCoord && 'x' !== $aCoord) {
                Util\JpGraphError::RaiseL(25070); //('Your data contains non-numeric values.');
            }

            return 0;
        }

        return \round($this->off + ($aCoord - $this->scale[0]) * $this->scale_factor);
    }

    // Relative translate (don't include offset) usefull when we just want
    // to know the relative position (in pixels) on the axis
    public function RelTranslate($aCoord)
    {
        if (!\is_numeric($aCoord)) {
            if ('' !== $aCoord && '-' !== $aCoord && 'x' !== $aCoord) {
                Util\JpGraphError::RaiseL(25070); //('Your data contains non-numeric values.');
            }

            return 0;
        }

        return ($aCoord - $this->scale[0]) * $this->scale_factor;
    }

    // Restrict autoscaling to only use integers
    public function SetIntScale($aIntScale = true)
    {
        $this->intscale = $aIntScale;
    }

    // Determine the minimum of three values witha  weight for last value
    public function MatchMin3($a, $b, $c, $weight)
    {
        if ($a < $b) {
            if ($a < ($c * $weight)) {
                return 1; // $a smallest
            }

            return 3; // $c smallest
        }

        if ($b < ($c * $weight)) {
            return 2; // $b smallest
        }

        return 3; // $c smallest
    }
} // @class
