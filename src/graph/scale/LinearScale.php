<?php

/**
 * JPGraph v4.0.0
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Tick;
use Amenadiel\JpGraph\Util;

/**
 * @class LinearScale
 * // Description: Handle linear scaling between screen and world
 */
class LinearScale extends Scale
{
    public $textscale = false; // Just a flag to let the Plot class find out if
    // we are a textscale or not. This is a cludge since
    // this information is available in Graph::axtype but
    // we don't have access to the graph object in the Plots
    // stroke method. So we let graph store the status here
    // when the linear scale is created. A real cludge...
    public $type; // is this x or y scale ?
    public $ticks; // Store ticks
    public $text_scale_off = 0;
    public $scale_abs      = [0, 0];
    public $scale_factor; // Scale factor between world and screen
    public $off; // Offset between image edge and plot area
    public $scale      = [0, 0];
    public $name       = 'lin';
    public $auto_ticks = false; // When using manual scale should the ticks be automatically set?
    public $world_abs_size; // Plot area size in pixels (Needed public in jpgraph_radar.php)
    public $intscale         = false; // Restrict autoscale to integers
    protected $autoscale_min = false; // Forced minimum value, auto determine max
    protected $autoscale_max = false; // Forced maximum value, auto determine min
    private $gracetop        = 0;
    private $gracebottom     = 0;

    private $_world_size; // Plot area size in world coordinates

    public function __construct($aMin = 0, $aMax = 0, $aType = 'y', $subType = null)
    {
        assert($aType == 'x' || $aType == 'y');
        assert($aMin <= $aMax);

        $this->type       = $aType;
        $this->scale      = [$aMin, $aMax];
        $this->world_size = $aMax - $aMin;
        if ($subType === 'radar') {
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
        if ($this->GetMinVal() == $this->GetMaxVal()) {
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
        if ($aGraceTop < 0 || $aGraceBottom < 0) {
            Util\JpGraphError::RaiseL(25069); //(" Grace must be larger then 0");
        }
        $this->gracetop    = $aGraceTop;
        $this->gracebottom = $aGraceBottom;
    }

    // Get the minimum value in the scale
    public function GetMinVal()
    {
        return $this->scale[0];
    }

    // get maximum value for scale
    public function GetMaxVal()
    {
        return $this->scale[1];
    }

    // Specify a new min/max value for sclae
    public function Update($aImg, $aMin, $aMax)
    {
        $this->scale      = [$aMin, $aMax];
        $this->world_size = $aMax - $aMin;
        $this->InitConfigs($aImg);
    }

    // Translate between world and screen
    public function Translate($aCoord)
    {
        if (!is_numeric($aCoord)) {
            if ($aCoord != '' && $aCoord != '-' && $aCoord != 'x') {
                Util\JpGraphError::RaiseL(25070); //('Your data contains non-numeric values.');
            }

            return 0;
        }

        return round($this->off + ($aCoord - $this->scale[0]) * $this->scale_factor);
    }

    // Relative translate (don't include offset) usefull when we just want
    // to know the relative position (in pixels) on the axis
    public function RelTranslate($aCoord)
    {
        if (!is_numeric($aCoord)) {
            if ($aCoord != '' && $aCoord != '-' && $aCoord != 'x') {
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
