<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Tick;

use Amenadiel\JpGraph\Graph\Configs;
use Amenadiel\JpGraph\Util;

/**
 * @class Ticks
  *  Description: Abstract base class for drawing linear and logarithmic
  *  tick marks on axis
 */
class Ticks
{
    public $label_formatstr = ''; // C-style format string to use for labels

    public $label_formfunc = '';

    public $label_dateformatstr = '';

    public $direction = 1; // Should ticks be in(=1) the plot area or outside (=-1)

    public $supress_last = false;

    public $supress_tickmarks = false;

    public $supress_minor_tickmarks = false;

    public $maj_ticks_pos = [];

    public $maj_ticklabels_pos = [];

    public $ticks_pos = [];

    public $maj_ticks_label = [];

    public $precision;

    protected $minor_abs_size = 3;

    protected $major_abs_size = 5;

    protected $scale;

    protected $is_set = false;

    protected $supress_zerolabel = false;

    protected $supress_first = false;

    protected $mincolor = '';

    protected $majcolor = '';

    protected $weight = 1;

    protected $label_usedateformat = false;

    protected $text_label_start = 0;

    protected $iManualTickPos;

    protected $iManualMinTickPos;

    protected $iManualTickLabels;

    protected $iAdjustForDST = false;

    public function __construct($aScale)
    {
        $this->scale = $aScale;
        $this->precision = -1;
    }

    // Set format string for automatic labels
    public function SetLabelFormat($aFormatString, $aDate = false)
    {
        $this->label_formatstr = $aFormatString;
        $this->label_usedateformat = $aDate;
    }

    public function SetLabelDateFormat($aFormatString)
    {
        $this->label_dateformatstr = $aFormatString;
    }

    public function SetFormatCallback($aCallbackFuncName)
    {
        $this->label_formfunc = $aCallbackFuncName;
    }

    // Don't display the first zero label
    public function SupressZeroLabel($aFlag = true)
    {
        $this->supress_zerolabel = $aFlag;
    }

    // Don't display minor tick marks
    public function SupressMinorTickMarks($aHide = true)
    {
        $this->supress_minor_tickmarks = $aHide;
    }

    // Don't display major tick marks
    public function SupressTickMarks($aHide = true)
    {
        $this->supress_tickmarks = $aHide;
    }

    // Hide the first tick mark
    public function SupressFirst($aHide = true)
    {
        $this->supress_first = $aHide;
    }

    // Hide the last tick mark
    public function SupressLast($aHide = true)
    {
        $this->supress_last = $aHide;
    }

    // Size (in pixels) of minor tick marks
    public function GetMinTickAbsSize()
    {
        return $this->minor_abs_size;
    }

    // Size (in pixels) of major tick marks
    public function GetMajTickAbsSize()
    {
        return $this->major_abs_size;
    }

    public function SetSize($aMajSize, $aMinSize = 3)
    {
        $this->major_abs_size = $aMajSize;
        $this->minor_abs_size = $aMinSize;
    }

    // Have the ticks been specified
    public function IsSpecified()
    {
        return $this->is_set;
    }

    public function SetSide($aSide)
    {
        $this->direction = $aSide;
    }

    // Which side of the axis should the ticks be on
    public function SetDirection($aSide = SIDE_RIGHT)
    {
        $this->direction = $aSide;
    }

    // Set colors for major and minor tick marks
    public function SetMarkColor($aMajorColor, $aMinorColor = '')
    {
        $this->SetColor($aMajorColor, $aMinorColor);
    }

    public function SetColor($aMajorColor, $aMinorColor = '')
    {
        $this->majcolor = $aMajorColor;

        // If not specified use same as major
        if ('' === $aMinorColor) {
            $this->mincolor = $aMajorColor;
        } else {
            $this->mincolor = $aMinorColor;
        }
    }

    public function SetWeight($aWeight)
    {
        $this->weight = $aWeight;
    }

    // Specify all the tick positions manually and possible also the exact labels
    protected function _doManualTickPos($aScale)
    {
        $n = Configs::safe_count($this->iManualTickPos);
        $m = Configs::safe_count($this->iManualMinTickPos);
        $doLbl = Configs::safe_count($this->iManualTickLabels) > 0;

        $this->maj_ticks_pos = [];
        $this->maj_ticklabels_pos = [];
        $this->ticks_pos = [];

        // Now loop through the supplied positions and translate them to screen coordinates
        // and store them in the maj_label_positions
        $minScale = $aScale->scale[0];
        $maxScale = $aScale->scale[1];
        $j = 0;

        for ($i = 0; $i < $n; ++$i) {
            // First make sure that the first tick is not lower than the lower scale value
            if (!isset($this->iManualTickPos[$i]) || $this->iManualTickPos[$i] < $minScale || $this->iManualTickPos[$i] > $maxScale) {
                continue;
            }

            $this->maj_ticks_pos[$j] = $aScale->Translate($this->iManualTickPos[$i]);
            $this->maj_ticklabels_pos[$j] = $this->maj_ticks_pos[$j];

            // Set the minor tick marks the same as major if not specified
            if (0 >= $m) {
                $this->ticks_pos[$j] = $this->maj_ticks_pos[$j];
            }

            if ($doLbl) {
                $this->maj_ticks_label[$j] = $this->iManualTickLabels[$i];
            } else {
                $this->maj_ticks_label[$j] = $this->_doLabelFormat($this->iManualTickPos[$i], $i, $n);
            }
            ++$j;
        }

        // Some sanity check
        if (Configs::safe_count($this->maj_ticks_pos) < 2) {
            Util\JpGraphError::RaiseL(25067); //('Your manually specified scale and ticks is not correct. The scale seems to be too small to hold any of the specified tickl marks.');
        }

        // Setup the minor tick marks
        $j = 0;

        for ($i = 0; $i < $m; ++$i) {
            if (empty($this->iManualMinTickPos[$i]) || $this->iManualMinTickPos[$i] < $minScale || $this->iManualMinTickPos[$i] > $maxScale) {
                continue;
            }
            $this->ticks_pos[$j] = $aScale->Translate($this->iManualMinTickPos[$i]);
            ++$j;
        }
    }

    protected function _doAutoTickPos($aScale)
    {
        $maj_step_abs = $aScale->scale_factor * $this->major_step;
        $min_step_abs = $aScale->scale_factor * $this->minor_step;

        if (0 === $min_step_abs || 0 === $maj_step_abs) {
            Util\JpGraphError::RaiseL(25068); //("A plot has an illegal scale. This could for example be that you are trying to use text autoscaling to draw a line plot with only one point or that the plot area is too small. It could also be that no input data value is numeric (perhaps only '-' or 'x')");
        }
        // We need to make this an int since comparing it below
        // with the result from round() can give wrong result, such that
        // (40 < 40) == TRUE !!!
        $limit = (int) $aScale->scale_abs[1];

        if ($aScale->textscale) {
            // This can only be true for a X-scale (horizontal)
            // Define ticks for a text scale. This is slightly different from a
            // normal linear type of scale since the position might be adjusted
            // and the labels start at on
            $label = (float) $aScale->GetMinVal() + $this->text_label_start + $this->label_offset;
            $start_abs = $aScale->scale_factor * $this->text_label_start;
            $nbrmajticks = \round(($aScale->GetMaxVal() - $aScale->GetMinVal() - $this->text_label_start) / $this->major_step) + 1;

            $x = $aScale->scale_abs[0] + $start_abs + $this->xlabel_offset * $min_step_abs;

            for ($i = 0; $aScale->GetMaxVal() + $this->label_offset >= $label; ++$i) {
                // Apply format to label
                $this->maj_ticks_label[$i] = $this->_doLabelFormat($label, $i, $nbrmajticks);
                $label += $this->major_step;

                // The x-position of the tick marks can be different from the labels.
                // Note that we record the tick position (not the label) so that the grid
                // happen upon tick marks and not labels.
                $xtick = $aScale->scale_abs[0] + $start_abs + $this->xtick_offset * $min_step_abs + $i * $maj_step_abs;
                $this->maj_ticks_pos[$i] = $xtick;
                $this->maj_ticklabels_pos[$i] = \round($x);
                $x += $maj_step_abs;
            }
        } else {
            $label = $aScale->GetMinVal();
            $abs_pos = $aScale->scale_abs[0];
            $j = 0;
            $i = 0;
            $step = \round($maj_step_abs / $min_step_abs);

            if ('x' === $aScale->type) {
                // For a normal linear type of scale the major ticks will always be multiples
                // of the minor ticks. In order to avoid any rounding issues the major ticks are
                // defined as every "step" minor ticks and not calculated separately
                $nbrmajticks = \round(($aScale->GetMaxVal() - $aScale->GetMinVal() - $this->text_label_start) / $this->major_step) + 1;

                while (\round($abs_pos) <= $limit) {
                    $this->ticks_pos[] = \round($abs_pos);
                    $this->ticks_label[] = $label;

                    if (0 === $step || $i % $step === 0 && $j < $nbrmajticks) {
                        $this->maj_ticks_pos[$j] = \round($abs_pos);
                        $this->maj_ticklabels_pos[$j] = \round($abs_pos);
                        $this->maj_ticks_label[$j] = $this->_doLabelFormat($label, $j, $nbrmajticks);
                        ++$j;
                    }
                    ++$i;
                    $abs_pos += $min_step_abs;
                    $label += $this->minor_step;
                }
            } elseif ('y' === $aScale->type) {
                /**
                 *@todo  s=2:20,12  s=1:50,6  $this->major_step:$nbr
                 * abs_point,limit s=1:270,80 s=2:540,160
                 * $this->major_step = 50;
                 */
                $nbrmajticks = \round(($aScale->GetMaxVal() - $aScale->GetMinVal()) / $this->major_step) + 1;
                //                $step = 5;
                while (\round($abs_pos) >= $limit) {
                    $this->ticks_pos[$i] = \round($abs_pos);
                    $this->ticks_label[$i] = $label;

                    if (0 === $step || $i % $step === 0 && $j < $nbrmajticks) {
                        $this->maj_ticks_pos[$j] = \round($abs_pos);
                        $this->maj_ticklabels_pos[$j] = \round($abs_pos);
                        $this->maj_ticks_label[$j] = $this->_doLabelFormat($label, $j, $nbrmajticks);
                        ++$j;
                    }
                    ++$i;
                    $abs_pos += $min_step_abs;
                    $label += $this->minor_step;
                }
            }
        }
    }

    protected function _doLabelFormat($aVal, $aIdx, $aNbrTicks)
    {
        // If precision hasn't been specified set it to a sensible value
        if (-1 === $this->precision) {
            $t = \log10($this->minor_step);

            if (0 < $t) {
                $precision = 0;
            } else {
                $precision = -\floor($t);
            }
        } else {
            $precision = $this->precision;
        }

        if ('' !== $this->label_formfunc) {
            $f = $this->label_formfunc;

            if ('' === $this->label_formatstr) {
                $l = $f($aVal);
            } else {
                $l = \sprintf($this->label_formatstr, $f($aVal));
            }
        } elseif ('' !== $this->label_formatstr || '' !== $this->label_dateformatstr) {
            if ($this->label_usedateformat) {
                // Adjust the value to take daylight savings into account
                if (\date('I', $aVal) === 1 && $this->iAdjustForDST) {
                    // DST
                    $aVal += 3600;
                }

                $l = \date($this->label_formatstr, $aVal);

                if ('W' === $this->label_formatstr) {
                    // If we use week formatting then add a single 'w' in front of the
                    // week number to differentiate it from dates
                    $l = 'w' . $l;
                }
            } else {
                if ('' !== $this->label_dateformatstr) {
                    // Adjust the value to take daylight savings into account
                    if (\date('I', $aVal) === 1 && $this->iAdjustForDST) {
                        // DST
                        $aVal += 3600;
                    }

                    $l = \date($this->label_dateformatstr, $aVal);

                    if ('W' === $this->label_formatstr) {
                        // If we use week formatting then add a single 'w' in front of the
                        // week number to differentiate it from dates
                        $l = 'w' . $l;
                    }
                } else {
                    $l = \sprintf($this->label_formatstr, $aVal);
                }
            }
        } else {
            //FIX: if negative precision  is returned "0f" , instead of formatted values
            $format = 0 < $precision ? '%01.' . $precision . 'f' : '%01.0f';
            $l = \sprintf($format, \round($aVal, $precision));
        }

        if (($this->supress_zerolabel && 0 === $l) || ($this->supress_first && 0 === $aIdx) || ($this->supress_last && $aNbrTicks - 1 === $aIdx)) {
            $l = '';
        }

        return $l;
    }

    // Stroke ticks on either X or Y axis
    protected function _StrokeTicks($aImg, $aScale, $aPos)
    {
        $hor = 'x' === $aScale->type;
        $aImg->SetLineWeight($this->weight);

        // We need to make this an int since comparing it below
        // with the result from round() can give wrong result, such that
        // (40 < 40) == TRUE !!!
        $limit = (int) $aScale->scale_abs[1];

        // A text scale doesn't have any minor ticks
        if (!$aScale->textscale) {
            // Stroke minor ticks
            $yu = $aPos - $this->direction * $this->GetMinTickAbsSize();
            $xr = $aPos + $this->direction * $this->GetMinTickAbsSize();
            $n = Configs::safe_count($this->ticks_pos);

            for ($i = 0; $i < $n; ++$i) {
                if ($this->supress_tickmarks || $this->supress_minor_tickmarks) {
                    continue;
                }

                if ('' !== $this->mincolor) {
                    $aImg->PushColor($this->mincolor);
                }

                if ($hor) {
                    //if( $this->ticks_pos[$i] <= $limit )
                    $aImg->Line($this->ticks_pos[$i], $aPos, $this->ticks_pos[$i], $yu);
                } else {
                    //if( $this->ticks_pos[$i] >= $limit )
                    $aImg->Line($aPos, $this->ticks_pos[$i], $xr, $this->ticks_pos[$i]);
                }

                if ('' === $this->mincolor) {
                    continue;
                }

                $aImg->PopColor();
            }
        }

        // Stroke major ticks
        $yu = $aPos - $this->direction * $this->GetMajTickAbsSize();
        $xr = $aPos + $this->direction * $this->GetMajTickAbsSize();
        $nbrmajticks = \round(($aScale->GetMaxVal() - $aScale->GetMinVal() - $this->text_label_start) / $this->major_step) + 1;
        $n = Configs::safe_count($this->maj_ticks_pos);

        for ($i = 0; $i < $n; ++$i) {
            if ((0 < $this->xtick_offset && $nbrmajticks - 1 === $i) || $this->supress_tickmarks) {
                continue;
            }

            if ('' !== $this->majcolor) {
                $aImg->PushColor($this->majcolor);
            }

            if ($hor) {
                //if( $this->maj_ticks_pos[$i] <= $limit )
                $aImg->Line($this->maj_ticks_pos[$i], $aPos, $this->maj_ticks_pos[$i], $yu);
            } else {
                //if( $this->maj_ticks_pos[$i] >= $limit )
                $aImg->Line($aPos, $this->maj_ticks_pos[$i], $xr, $this->maj_ticks_pos[$i]);
            }

            if ('' === $this->majcolor) {
                continue;
            }

            $aImg->PopColor();
        }
    }
}
// @class
