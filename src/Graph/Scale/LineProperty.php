<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

/**
 * @class LineProperty
  *  Description: Holds properties for a line
 */
class LineProperty
{
    public $iWeight = 1;

    public $iColor = 'black';

    public $iStyle = 'solid';

    public $iShow = false;

    public function __construct($aWeight = 1, $aColor = 'black', $aStyle = 'solid')
    {
        $this->iWeight = $aWeight;
        $this->iColor = $aColor;
        $this->iStyle = $aStyle;
    }

    /**
     * @param string $aColor
     *
     * @return void
     */
    public function SetColor($aColor)
    {
        $this->iColor = $aColor;
    }

    /**
     * @param int $aWeight
     *
     * @return void
     */
    public function SetWeight($aWeight)
    {
        $this->iWeight = $aWeight;
    }

    /**
     * @param string $aStyle
     *
     * @return void
     */
    public function SetStyle($aStyle)
    {
        $this->iStyle = $aStyle;
    }

    /**
     * @param bool $aShow
     *
     * @return void
     */
    public function Show($aShow = true)
    {
        $this->iShow = $aShow;
    }

    /**
     * @param float $aY1
     * @param float $aY2
     *
     * @return void
     */
    public function Stroke($aImg, $aX1, $aY1, $aX2, $aY2)
    {
        if (!$this->iShow) {
            return;
        }

        $aImg->PushColor($this->iColor);
        $oldls = $aImg->line_style;
        $oldlw = $aImg->line_weight;
        $aImg->SetLineWeight($this->iWeight);
        $aImg->SetLineStyle($this->iStyle);
        $aImg->StyleLine($aX1, $aY1, $aX2, $aY2);
        $aImg->PopColor($this->iColor);
        $aImg->line_style = $oldls;
        $aImg->line_weight = $oldlw;
    }
}
