<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Configs;
use Amenadiel\JpGraph\Text;
use Amenadiel\JpGraph\Util;

/**
 * File:        JPGRAPH_GANTT.PHP
  *  Description: JpGraph Gantt plot extension
  *  Created:     2001-11-12
  *  Ver:         $Id: jpgraph_gantt.php 1809 2009-09-09 13:07:33Z ljp $.
  * 
  *  Copyright (c) Asial Corporation. All rights reserved.
 */

/**
 * @class GanttActivityInfo
  *  Description:
 */
class GanttActivityInfo
{
    public $iShow = true;

    public $iLeftColMargin = 4;

    public $iRightColMargin = 1;

    public $iTopColMargin = 1;

    public $iBottomColMargin = 3;

    public $vgrid;

    private $iColor = 'black';

    private $iBackgroundColor = 'lightgray';

    private $iFFamily = Configs::FF_FONT1;

    private $iFStyle = Configs::FS_NORMAL;

    private $iFSize = 10;

    private $iFontColor = 'black';

    private $iTitles = [];

    private $iWidth = [];

    private $iHeight = -1;

    private $iTopHeaderMargin = 4;

    private $iStyle = 1;

    private $iHeaderAlign = 'center';

    public function __construct()
    {
        $this->vgrid = new LineProperty();
    }

    public function Hide($aF = true)
    {
        $this->iShow = !$aF;
    }

    public function Show($aF = true)
    {
        $this->iShow = $aF;
    }

    // Specify font
    public function SetFont($aFFamily, $aFStyle = Configs::FS_NORMAL, $aFSize = 10)
    {
        $this->iFFamily = $aFFamily;
        $this->iFStyle = $aFStyle;
        $this->iFSize = $aFSize;
    }

    public function SetStyle($aStyle)
    {
        $this->iStyle = $aStyle;
    }

    public function SetColumnMargin($aLeft, $aRight)
    {
        $this->iLeftColMargin = $aLeft;
        $this->iRightColMargin = $aRight;
    }

    public function SetFontColor($aFontColor)
    {
        $this->iFontColor = $aFontColor;
    }

    public function SetColor($aColor)
    {
        $this->iColor = $aColor;
    }

    public function SetBackgroundColor($aColor)
    {
        $this->iBackgroundColor = $aColor;
    }

    public function SetColTitles($aTitles, $aWidth = null)
    {
        $this->iTitles = $aTitles;
        $this->iWidth = $aWidth;
    }

    public function SetMinColWidth($aWidths)
    {
        $n = \min(Configs::safe_count($this->iTitles), Configs::safe_count($aWidths));

        for ($i = 0; $i < $n; ++$i) {
            if (empty($aWidths[$i])) {
                continue;
            }

            if (empty($this->iWidth[$i])) {
                $this->iWidth[$i] = $aWidths[$i];
            } else {
                $this->iWidth[$i] = \max($this->iWidth[$i], $aWidths[$i]);
            }
        }
    }

    public function GetWidth($aImg)
    {
        $txt = new Text\TextProperty();
        $txt->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        $n = Configs::safe_count($this->iTitles);
        $rm = $this->iRightColMargin;
        $w = 0;

        for ($h = 0, $i = 0; $i < $n; ++$i) {
            $w += $this->iLeftColMargin;
            $txt->Set($this->iTitles[$i]);

            if (!empty($this->iWidth[$i])) {
                $w1 = \max($txt->GetWidth($aImg) + $rm, $this->iWidth[$i]);
            } else {
                $w1 = $txt->GetWidth($aImg) + $rm;
            }
            $this->iWidth[$i] = $w1;
            $w += $w1;
            $h = \max($h, $txt->GetHeight($aImg));
        }
        $this->iHeight = $h + $this->iTopHeaderMargin;
        $txt = '';

        return $w;
    }

    public function GetColStart($aImg, &$aStart, $aAddLeftMargin = false)
    {
        $n = Configs::safe_count($this->iTitles);
        $adj = $aAddLeftMargin ? $this->iLeftColMargin : 0;
        $aStart = [$aImg->left_margin + $adj];

        for ($i = 1; $i < $n; ++$i) {
            $aStart[$i] = $aStart[$i - 1] + $this->iLeftColMargin + $this->iWidth[$i - 1];
        }
    }

    // Adjust headers left, right or centered
    public function SetHeaderAlign($aAlign)
    {
        $this->iHeaderAlign = $aAlign;
    }

    public function Stroke($aImg, $aXLeft, $aYTop, $aXRight, $aYBottom, $aUseTextHeight = false)
    {
        if (!$this->iShow) {
            return;
        }

        $txt = new Text\TextProperty();
        $txt->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        $txt->SetColor($this->iFontColor);
        $txt->SetAlign($this->iHeaderAlign, 'top');
        $n = Configs::safe_count($this->iTitles);

        if (0 === $n) {
            return;
        }

        $x = $aXLeft;
        $h = $this->iHeight;
        $yTop = $aUseTextHeight ? $aYBottom - $h - $this->iTopColMargin - $this->iBottomColMargin : $aYTop;

        if (0 > $h) {
            Util\JpGraphError::RaiseL(6001);
            //('Internal error. Height for ActivityTitles is < 0');
        }

        $aImg->SetLineWeight(1);
        // Set background color
        $aImg->SetColor($this->iBackgroundColor);
        $aImg->FilledRectangle($aXLeft, $yTop, $aXRight, $aYBottom - 1);

        if (1 === $this->iStyle) {
            // Make a 3D effect
            $aImg->SetColor('white');
            $aImg->Line($aXLeft, $yTop + 1, $aXRight, $yTop + 1);
        }

        for ($i = 0; $i < $n; ++$i) {
            if (1 === $this->iStyle) {
                // Make a 3D effect
                $aImg->SetColor('white');
                $aImg->Line($x + 1, $yTop, $x + 1, $aYBottom);
            }
            $x += $this->iLeftColMargin;
            $txt->Set($this->iTitles[$i]);

            // Adjust the text anchor position according to the choosen alignment
            $xp = $x;

            if ('center' === $this->iHeaderAlign) {
                $xp = (($x - $this->iLeftColMargin) + ($x + $this->iWidth[$i])) / 2;
            } elseif ('right' === $this->iHeaderAlign) {
                $xp = $x + $this->iWidth[$i] - $this->iRightColMargin;
            }

            $txt->Stroke($aImg, $xp, $yTop + $this->iTopHeaderMargin);
            $x += $this->iWidth[$i];

            if ($n - 1 <= $i) {
                continue;
            }

            $aImg->SetColor($this->iColor);
            $aImg->Line($x, $yTop, $x, $aYBottom);
        }

        $aImg->SetColor($this->iColor);
        $aImg->Line($aXLeft, $yTop, $aXRight, $yTop);

        // Stroke vertical column dividers
        $cols = [];
        $this->GetColStart($aImg, $cols);
        $n = Configs::safe_count($cols);

        for ($i = 1; $i < $n; ++$i) {
            $this->vgrid->Stroke(
                $aImg,
                $cols[$i],
                $aYBottom,
                $cols[$i],
                $aImg->height - $aImg->bottom_margin
            );
        }
    }
}
