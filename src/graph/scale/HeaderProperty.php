<?php

/**
 * JPGraph v4.1.0-beta.01
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Configs;

/**
 * @class HeaderProperty
 * // Description: Data encapsulating class to hold property
 * // for each type of the scale headers
 */
class HeaderProperty extends Configs
{
    public $grid;
    public $iShowLabels             = true;
    public $iShowGrid               = true;
    public $iTitleVertMargin        = 3;
    public $iFFamily                = Configs::FF_FONT0;
    public $iFStyle                 = Configs::FS_NORMAL;
    public $iFSize                  = 8;
    public $iStyle                  = 0;
    public $iFrameColor             = 'black';
    public $iFrameWeight            = 1;
    public $iBackgroundColor        = 'white';
    public $iWeekendBackgroundColor = 'lightgray';
    public $iSundayTextColor        = 'red'; // these are only used with day scale
    public $iTextColor              = 'black';
    public $iLabelFormStr           = '%d';
    public $iIntervall              = 1;

    public function __construct()
    {
        $this->grid = new LineProperty();
    }

    /**
     * PUBLIC METHODS.
     *
     * @param mixed $aShow
     */
    public function Show($aShow = true)
    {
        $this->iShowLabels = $aShow;
    }

    public function SetIntervall($aInt)
    {
        $this->iIntervall = $aInt;
    }

    public function SetInterval($aInt)
    {
        $this->iIntervall = $aInt;
    }

    public function GetIntervall()
    {
        return $this->iIntervall;
    }

    public function SetFont($aFFamily, $aFStyle = Configs::FS_NORMAL, $aFSize = 10)
    {
        $this->iFFamily = $aFFamily;
        $this->iFStyle  = $aFStyle;
        $this->iFSize   = $aFSize;
    }

    public function SetFontColor($aColor)
    {
        $this->iTextColor = $aColor;
    }

    public function GetFontHeight($aImg)
    {
        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);

        return $aImg->GetFontHeight();
    }

    public function GetFontWidth($aImg)
    {
        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);

        return $aImg->GetFontWidth();
    }

    public function GetStrWidth($aImg, $aStr)
    {
        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);

        return $aImg->GetTextWidth($aStr);
    }

    public function SetStyle($aStyle)
    {
        $this->iStyle = $aStyle;
    }

    public function SetBackgroundColor($aColor)
    {
        $this->iBackgroundColor = $aColor;
    }

    public function SetFrameWeight($aWeight)
    {
        $this->iFrameWeight = $aWeight;
    }

    public function SetFrameColor($aColor)
    {
        $this->iFrameColor = $aColor;
    }

    // Only used by day scale
    public function SetWeekendColor($aColor)
    {
        $this->iWeekendBackgroundColor = $aColor;
    }

    // Only used by day scale
    public function SetSundayFontColor($aColor)
    {
        $this->iSundayTextColor = $aColor;
    }

    public function SetTitleVertMargin($aMargin)
    {
        $this->iTitleVertMargin = $aMargin;
    }

    public function SetLabelFormatString($aStr)
    {
        $this->iLabelFormStr = $aStr;
    }

    public function SetFormatString($aStr)
    {
        $this->SetLabelFormatString($aStr);
    }
}
