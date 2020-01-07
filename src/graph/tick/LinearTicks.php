<?php

/**
 * JPGraph v4.1.0-beta.01
 */

namespace Amenadiel\JpGraph\Graph\Tick;

use Amenadiel\JpGraph\Graph\Configs;
use Amenadiel\JpGraph\Util;

/**
 * @class LinearTicks
 * // Description: Draw linear ticks on axis
 */
class LinearTicks extends Ticks
{
    public $minor_step    = 1;
    public $major_step    = 2;
    public $xlabel_offset = 0;
    public $xtick_offset  = 0;
    public $label_offset  = 0; // What offset should the displayed label have
    // i.e should we display 0,1,2 or 1,2,3,4 or 2,3,4 etc
    protected $text_label_start = 0;
    protected $iManualTickPos;
    protected $iManualMinTickPos;
    protected $iManualTickLabels;
    protected $iAdjustForDST = false; // If a date falls within the DST period add one hour to the diaplyed time

    public function __construct()
    {
        $this->precision = -1;
    }

    // Return major step size in world coordinates
    public function GetMajor()
    {
        return $this->major_step;
    }

    // Return minor step size in world coordinates
    public function GetMinor()
    {
        return $this->minor_step;
    }

    // Set Minor and Major ticks (in world coordinates)
    public function Set($aMajStep, $aMinStep = false)
    {
        if ($aMinStep == false) {
            $aMinStep = $aMajStep;
        }

        if ($aMajStep <= 0 || $aMinStep <= 0) {
            Util\JpGraphError::RaiseL(25064);
            //(" Minor or major step size is 0. Check that you haven't got an accidental SetTextTicks(0) in your code. If this is not the case you might have stumbled upon a bug in JpGraph. Please report this and if possible include the data that caused the problem.");
        }

        $this->major_step = $aMajStep;
        $this->minor_step = $aMinStep;
        $this->is_set     = true;
    }

    public function SetMajTickPositions($aMajPos, $aLabels = null)
    {
        $this->SetTickPositions($aMajPos, null, $aLabels);
    }

    public function SetTickPositions($aMajPos, $aMinPos = null, $aLabels = null)
    {
        if (!is_array($aMajPos) || ($aMinPos !== null && !is_array($aMinPos))) {
            Util\JpGraphError::RaiseL(25065); //('Tick positions must be specifued as an array()');
            return;
        }
        $n = Configs::safe_count($aMajPos);
        if (is_array($aLabels) && (Configs::safe_count($aLabels) != $n)) {
            Util\JpGraphError::RaiseL(25066); //('When manually specifying tick positions and labels the number of labels must be the same as the number of specified ticks.');
        }
        $this->iManualTickPos    = $aMajPos;
        $this->iManualMinTickPos = $aMinPos;
        $this->iManualTickLabels = $aLabels;
    }

    public function HaveManualLabels()
    {
        return Configs::safe_count($this->iManualTickLabels) > 0;
    }

    public function AdjustForDST($aFlg = true)
    {
        $this->iAdjustForDST = $aFlg;
    }

    // Draw linear ticks
    public function Stroke($aImg, $aScale, $aPos)
    {
        if ($this->iManualTickPos != null) {
            $this->_doManualTickPos($aScale);
        } else {
            $this->_doAutoTickPos($aScale);
        }
        $this->_StrokeTicks($aImg, $aScale, $aPos, $aScale->type == 'x');
    }

    /**
     * PRIVATE METHODS.
     *
     * @param mixed $aLabelOff
     * @param mixed $aTickOff
     */
    // Spoecify the offset of the displayed tick mark with the tick "space"
    // Legal values for $o is [0,1] used to adjust where the tick marks and label
    // should be positioned within the major tick-size
    // $lo specifies the label offset and $to specifies the tick offset
    // this comes in handy for example in bar graphs where we wont no offset for the
    // tick but have the labels displayed halfway under the bars.
    public function SetXLabelOffset($aLabelOff, $aTickOff = -1)
    {
        $this->xlabel_offset = $aLabelOff;
        if ($aTickOff == -1) {
            // Same as label offset
            $this->xtick_offset = $aLabelOff;
        } else {
            $this->xtick_offset = $aTickOff;
        }
        if ($aLabelOff <= 0) {
            return;
        }

        $this->SupressLast(); // The last tick wont fit
    }

    // Which tick label should we start with?
    public function SetTextLabelStart($aTextLabelOff)
    {
        $this->text_label_start = $aTextLabelOff;
    }
}
// @class
