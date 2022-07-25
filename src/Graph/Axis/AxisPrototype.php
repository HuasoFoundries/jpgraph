<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Axis;

use Amenadiel\JpGraph\Graph\Configs;
use Amenadiel\JpGraph\Text;
use Amenadiel\JpGraph\Util;

/**
 * @class Axis
  *  Description: Defines X and Y axis. Notes that at the
  *  moment the code is not really good since the axis on
  *  several occasion must know wheter it's an X or Y axis.
  *  This was a design decision to make the code easier to
  *  follow.
 */
class AxisPrototype extends Configs
{
    public $scale;

    public $img;

    public $hide = false;

    public $hide_labels = false;

    /**
     * @var Text\Text
     */
    public $title;

    public $font_family = Configs::FF_DEFAULT;

    public $font_style = Configs::FS_NORMAL;

    public $font_size = 8;

    public $label_angle = 0;

    public $tick_step = 1;

    /**
     * @var false|string
     */
    public $pos = false;

    public $ticks_label = [];

    protected $weight = 1;

    protected $color = [0, 0, 0];

    protected $label_color = [0, 0, 0];

    protected $ticks_label_colors;

    protected $show_first_label = true;

    protected $show_last_label = true;

    protected $label_step = 1;

    // Used by a text axis to specify what multiple of major steps
    // should be labeled.
    /**
     * @var array|int
     */
    protected $labelPos = 0; // Which side of the axis should the labels be?

    protected $title_adjust;

    protected $title_margin;

    /**
     * @var array
     */
    protected $title_side = Configs::SIDE_LEFT;

    protected $tick_label_margin = 5;

    protected $label_halign = '';

    protected $label_valign = '';

    protected $label_para_align = 'left';

    protected $hide_line = false;

    protected $iDeltaAbsPos = 0;
   

    public function __construct($img, $aScale, $color = [0, 0, 0])
    {
        $this->img = $img;
        $this->scale = $aScale;
        $this->color = $color;
        $this->title = new Text\Text('');

        if ('y' === $aScale->type) {
            $this->title_margin = 25;
            $this->title_adjust = 'middle';
            $this->title->SetOrientation(90);
            $this->tick_label_margin = 7;
            $this->labelPos = Configs::getConfig('SIDE_LEFT');
        } else {
            $this->title_margin = 5;
            $this->title_adjust = 'high';
            $this->title->SetOrientation(0);
            $this->tick_label_margin = 5;
            $this->labelPos = Configs::getConfig('SIDE_DOWN');
            $this->title_side = Configs::getConfig('SIDE_DOWN');
        }
    }
    public function getScale() {
        return $this->scale;
    }
    /**
     * @return void
     */
    public function SetLabelFormat($aFormStr)
    {
        $this->scale->ticks->SetLabelFormat($aFormStr);
    }

    /**
     * @param string $aFormStr
     *
     * @return void
     */
    public function SetLabelFormatString($aFormStr, $aDate = false)
    {
        $this->scale->ticks->SetLabelFormat($aFormStr, $aDate);
    }

    /**
     * @return void
     */
    public function SetLabelFormatCallback($aFuncName)
    {
        $this->scale->ticks->SetFormatCallback($aFuncName);
    }

    /**
     * @param string $aHAlign
     * @param string $aVAlign
     *
     * @return void
     */
    public function SetLabelAlign($aHAlign, $aVAlign = 'top', $aParagraphAlign = 'left')
    {
        $this->label_halign = $aHAlign;
        $this->label_valign = $aVAlign;
        $this->label_para_align = $aParagraphAlign;
    }

    // Don't display the first label
    /**
     * @return void
     */
    public function HideFirstTickLabel($aShow = false)
    {
        $this->show_first_label = $aShow;
    }

    /**
     * @return void
     */
    public function HideLastTickLabel($aShow = false)
    {
        $this->show_last_label = $aShow;
    }

    // Manually specify the major and (optional) minor tick position and labels
    /**
     * @return void
     */
    public function SetTickPositions($aMajPos, $aMinPos = null, $aLabels = null)
    {
        $this->scale->ticks->SetTickPositions($aMajPos, $aMinPos, $aLabels);
    }

    // Manually specify major tick positions and optional labels
    /**
     * @return void
     */
    public function SetMajTickPositions($aMajPos, $aLabels = null)
    {
        $this->scale->ticks->SetTickPositions($aMajPos, null, $aLabels);
    }

    // Hide minor or major tick marks
    /**
     * @return void
     */
    public function HideTicks($aHideMinor = true, $aHideMajor = true)
    {
        $this->scale->ticks->SupressMinorTickMarks($aHideMinor);
        $this->scale->ticks->SupressTickMarks($aHideMajor);
    }

    // Hide zero label
    /**
     * @return void
     */
    public function HideZeroLabel($aFlag = true)
    {
        $this->scale->ticks->SupressZeroLabel();
    }

    /**
     * @return void
     */
    public function HideFirstLastLabel()
    {
        // The two first calls to ticks method will supress
        // automatically generated scale values. However, that
        // will not affect manually specified value, e.g text-scales.
        // therefor we also make a kludge here to supress manually
        // specified scale labels.
        $this->scale->ticks->SupressLast();
        $this->scale->ticks->SupressFirst();
        $this->show_first_label = false;
        $this->show_last_label = false;
    }

    // Hide the axis
    /**
     * @return void
     */
    public function Hide($aHide = true)
    {
        $this->hide = $aHide;
    }

    // Hide the actual axis-line, but still print the labels
    /**
     * @return void
     */
    public function HideLine($aHide = true)
    {
        $this->hide_line = $aHide;
    }

    /**
     * @return void
     */
    public function HideLabels($aHide = true)
    {
        $this->hide_labels = $aHide;
    }

    // Weight of axis
    /**
     * @param int $aWeight
     *
     * @return void
     */
    public function SetWeight($aWeight)
    {
        $this->weight = $aWeight;
    }

    // Axis color
    /**
     * @param string $aColor
     * @param false|string $aLabelColor
     *
     * @return void
     */
    public function SetColor($aColor, $aLabelColor = false)
    {
        $this->color = $aColor;

        if (!$aLabelColor) {
            $this->label_color = $aColor;
        } else {
            $this->label_color = $aLabelColor;
        }
    }

    // Title on axis
    /**
     * @return void
     */
    public function SetTitle($aTitle, $aAdjustAlign = 'high')
    {
        $this->title->Set($aTitle);
        $this->title_adjust = $aAdjustAlign;
    }

    // Specify distance from the axis
    /**
     * @return void
     */
    public function SetTitleMargin($aMargin)
    {
        $this->title_margin = $aMargin;
    }

    // Which side of the axis should the axis title be?
    /**
     * @param array $aSideOfAxis
     *
     * @return void
     */
    public function SetTitleSide($aSideOfAxis)
    {
        $this->title_side = $aSideOfAxis;
    }

    /**
     * @return void
     */
    public function SetTickSide($aDir)
    {
        $this->scale->ticks->SetSide($aDir);
    }

    /**
     * @return void
     */
    public function SetTickSize($aMajSize, $aMinSize = 3)
    {
        $this->scale->ticks->SetSize($aMajSize, $aMinSize = 3);
    }

    // Specify text labels for the ticks. One label for each data point
    /**
     * @return void
     */
    public function SetTickLabels($aLabelArray, $aLabelColorArray = null)
    {
        $this->ticks_label = $aLabelArray;
        $this->ticks_label_colors = $aLabelColorArray;
    }

    /**
     * @return void
     */
    public function SetLabelMargin($aMargin)
    {
        $this->tick_label_margin = $aMargin;
    }

    // Specify that every $step of the ticks should be displayed starting
    // at $start
    /**
     * @return void
     */
    public function SetTextTickInterval($aStep, $aStart = 0)
    {
        $this->scale->ticks->SetTextLabelStart($aStart);
        $this->tick_step = $aStep;
    }

    // Specify that every $step tick mark should have a label
    // should be displayed starting
    /**
     * @return void
     */
    public function SetTextLabelInterval($aStep)
    {
        if (1 > $aStep) {
     throw      Util\JpGraphError::make(25058); //(" Text label interval must be specified >= 1.");
        }
        $this->label_step = $aStep;
    }

    /**
     * @param array $aSidePos
     *
     * @return void
     */
    public function SetLabelSide($aSidePos)
    {
        $this->labelPos = $aSidePos;
    }

    // Set the font
    /**
     * @param int $aFamily
     * @param int $aStyle
     * @param int $aSize
     *
     * @return void
     */
    public function SetFont($aFamily, $aStyle = Configs::FS_NORMAL, $aSize = 10)
    {
        $this->font_family = $aFamily;
        $this->font_style = $aStyle;
        $this->font_size = $aSize;
    }

    // Position for axis line on the "other" scale
    /**
     * @param string $aPosOnOtherScale
     *
     * @return void
     */
    public function SetPos($aPosOnOtherScale)
    {
        $this->pos = $aPosOnOtherScale;
    }

    // Set the position of the axis to be X-pixels delta to the right
    // of the max X-position (used to position the multiple Y-axis)
    /**
     * @return void
     */
    public function SetPosAbsDelta($aDelta)
    {
        $this->iDeltaAbsPos = $aDelta;
    }

    // Specify the angle for the tick labels
    /**
     * @return void
     */
    public function SetLabelAngle($aAngle)
    {
        $this->label_angle = $aAngle;
    }
} // @class
