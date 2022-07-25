<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Configs;

/**
 * @class HeaderProperty
 *  Description: Data encapsulating class to hold property
 *  for each type of the scale headers
 */
class HeaderProperty extends Configs
{
    /**
     * @var LineProperty
     */
    public $grid;

    public $iShowLabels = true;

    /**
     * @var true
     */
    public $iShowGrid = true;

    public $iTitleVertMargin = 3;

    /**
     * @var int
     */
    public $iFFamily = Configs::FF_FONT0;

    /**
     * @var int
     */
    public $iFStyle = Configs::FS_NORMAL;

    public $iFSize = 8;

    /**
     * @var int
     */
    public $iStyle = 0;

    public $iFrameColor = 'black';

    public $iFrameWeight = 1;

    public $iBackgroundColor = 'white';

    public $iWeekendBackgroundColor = 'lightgray';

    public $iSundayTextColor = 'red'; // these are only used with day scale

    public $iTextColor = 'black';

    /**
     * @var string
     */
    public $iLabelFormStr = '%d';

    public $iIntervall = 1;

    public function __construct()
    {
        $this->grid = new LineProperty();
    }

    /**
     * PUBLIC METHODS.
     *
     * @param mixed $aShow
     *
     * @return void
     */
    public function Show($aShow = true)
    {
        $this->iShowLabels = $aShow;
    }

    /**
     * @param int $aInt
     *
     * @return void
     */
    public function SetIntervall($aInt)
    {
        $this->iIntervall = $aInt;
    }

    /**
     * @return void
     */
    public function SetInterval($aInt)
    {
        $this->iIntervall = $aInt;
    }

    public function GetInterval()
    {
        return $this->iIntervall;
    }

    /**
     * @param int $aFFamily
     * @param int $aFStyle
     *
     * @return void
     */
    public function SetFont($aFFamily, $aFStyle = Configs::FS_NORMAL, $aFSize = 10)
    {
        $this->iFFamily = $aFFamily;
        $this->iFStyle = $aFStyle;
        $this->iFSize = $aFSize;
    }

    /**
     * @return void
     */
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

    /**
     * @param string $aStr
     */
    public function GetStrWidth($aImg, $aStr)
    {
        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);

        return $aImg->GetTextWidth($aStr);
    }

    /**
     * @param int $aStyle
     *
     * @return void
     */
    public function SetStyle($aStyle)
    {
        $this->iStyle = $aStyle;
    }

    /**
     * @return void
     */
    public function SetBackgroundColor($aColor)
    {
        $this->iBackgroundColor = $aColor;
    }

    /**
     * @return void
     */
    public function SetFrameWeight($aWeight)
    {
        $this->iFrameWeight = $aWeight;
    }

    /**
     * @return void
     */
    public function SetFrameColor($aColor)
    {
        $this->iFrameColor = $aColor;
    }

    // Only used by day scale
    /**
     * @return void
     */
    public function SetWeekendColor($aColor)
    {
        $this->iWeekendBackgroundColor = $aColor;
    }

    // Only used by day scale
    /**
     * @return void
     */
    public function SetSundayFontColor($aColor)
    {
        $this->iSundayTextColor = $aColor;
    }

    /**
     * @return void
     */
    public function SetTitleVertMargin($aMargin)
    {
        $this->iTitleVertMargin = $aMargin;
    }

    /**
     * @param string $aStr
     *
     * @return void
     */
    public function SetLabelFormatString($aStr)
    {
        $this->iLabelFormStr = $aStr;
    }

    /**
     * @return void
     */
    public function SetFormatString($aStr)
    {
        $this->SetLabelFormatString($aStr);
    }
}
