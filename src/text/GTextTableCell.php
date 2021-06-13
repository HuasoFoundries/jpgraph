<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Text;

use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util;
use function round;

/*
 * File:        JPGRAPH_TABLE.PHP
 * // Description: Classes to create basic tables of data
 * // Created:     2006-01-25
 * // Ver:         $Id: jpgraph_table.php 1514 2009-07-07 11:15:58Z ljp $
 * //
 * // Copyright (c) Asial Corporation. All rights reserved.
 */
// Style of grid lines in table

/**
 * @class GTextTableCell
 * // Description:
 * // Internal class that represents each cell in the table
 */
class GTextTableCell
{
    public $iColSpan = 1;

    public $iRowSpan = 1;

    public $iMarginLeft = 5;

    public $iMarginRight = 5;

    public $iMarginTop = 5;

    public $iMarginBottom = 5;

    public $iVal;

    private $iBGColor = '';

    private $iFontColor = 'black';

    private $iFF = Configs::FF_FONT1;

    private $iFS = Configs::FS_NORMAL;

    private $iFSize = 10;

    private $iRow = 0;

    private $iCol = 0;

    private $iVertAlign = 'bottom';

    private $iHorAlign = 'left';

    private $iMerged = false;

    private $iPRow;

    private $iPCol;

    private $iTable;

    private $iGridColor = ['darkgray', 'darkgray', 'darkgray', 'darkgray'];

    private $iGridWeight = [1, 1, 0, 0]; // left,top,bottom,right;

    private $iGridStyle = [Configs::TGRID_SINGLE, Configs::TGRID_SINGLE, Configs::TGRID_SINGLE, Configs::TGRID_SINGLE]; // left,top,bottom,right;

    private $iNumberFormat;

    private $iIcon;

    private $iIconConstrain = [];

    private $iCSIMtarget = '';

    private $iCSIMwintarget = '';

    private $iCSIMalt = '';

    private $iCSIMArea = '';

    public function __construct($aVal = '', $aRow = 0, $aCol = 0)
    {
        $this->iVal = new Text($aVal);
        $this->iRow = $aRow;
        $this->iCol = $aCol;
        $this->iPRow = $aRow; // Initialiy each cell is its own parent
        $this->iPCol = $aCol;
        $this->iIconConstrain = [-1, -1];
    }

    public function Init($aTable)
    {
        $this->iTable = $aTable;
    }

    public function SetCSIMTarget($aTarget, $aAlt = '', $aWinTarget = '')
    {
        $this->iCSIMtarget = $aTarget;
        $this->iCSIMwintarget = $aWinTarget;
        $this->iCSIMalt = $aAlt;
    }

    public function GetCSIMArea()
    {
        if ('' !== $this->iCSIMtarget) {
            return $this->iCSIMArea;
        }

        return '';
    }

    public function SetImageConstrain($aType, $aVal)
    {
        if (!\in_array($aType, [Configs::TIMG_WIDTH, Configs::TIMG_HEIGHT], true)) {
            throw      Util\JpGraphError::make(27015);
        }
        $this->iIconConstrain = [$aType, $aVal];
    }

    public function SetCountryFlag($aFlag, $aScale = 1.0, $aMix = 100, $aStdSize = 3)
    {
        $this->iIcon = new Plot\IconPlot();
        $this->iIcon->SetCountryFlag($aFlag, 0, 0, $aScale, $aMix, $aStdSize);
    }

    public function SetImage($aFile, $aScale = 1.0, $aMix = 100)
    {
        $this->iIcon = new Plot\IconPlot($aFile, 0, 0, $aScale, $aMix);
    }

    public function SetImageFromString($aStr, $aScale = 1.0, $aMix = 100)
    {
        $this->iIcon = new Plot\IconPlot('', 0, 0, $aScale, $aMix);
        $this->iIcon->CreateFromString($aStr);
    }

    public function SetRowColSpan($aRowSpan, $aColSpan)
    {
        $this->iRowSpan = $aRowSpan;
        $this->iColSpan = $aColSpan;
        $this->iMerged = true;
    }

    public function SetMerged($aPRow, $aPCol, $aFlg = true)
    {
        $this->iMerged = $aFlg;
        $this->iPRow = $aPRow;
        $this->iPCol = $aPCol;
    }

    public function IsMerged()
    {
        return $this->iMerged;
    }

    public function SetNumberFormat($aF)
    {
        $this->iNumberFormat = $aF;
    }

    public function Set($aTxt)
    {
        $this->iVal->Set($aTxt);
    }

    public function SetFont($aFF, $aFS, $aFSize)
    {
        $this->iFF = $aFF;
        $this->iFS = $aFS;
        $this->iFSize = $aFSize;
        $this->iVal->SetFont($aFF, $aFS, $aFSize);
    }

    public function SetFillColor($aColor)
    {
        $this->iBGColor = $aColor;
    }

    public function SetFontColor($aColor)
    {
        $this->iFontColor = $aColor;
    }

    public function SetGridColor($aLeft, $aTop = null, $aBottom = null, $aRight = null)
    {
        if (null !== $aLeft) {
            $this->iGridColor[0] = $aLeft;
        }

        if (null !== $aTop) {
            $this->iGridColor[1] = $aTop;
        }

        if (null !== $aBottom) {
            $this->iGridColor[2] = $aBottom;
        }

        if (null === $aRight) {
            return;
        }

        $this->iGridColor[3] = $aRight;
    }

    public function SetGridStyle($aLeft, $aTop = null, $aBottom = null, $aRight = null)
    {
        if (null !== $aLeft) {
            $this->iGridStyle[0] = $aLeft;
        }

        if (null !== $aTop) {
            $this->iGridStyle[1] = $aTop;
        }

        if (null !== $aBottom) {
            $this->iGridStyle[2] = $aBottom;
        }

        if (null === $aRight) {
            return;
        }

        $this->iGridStyle[3] = $aRight;
    }

    public function SetGridWeight($aLeft = null, $aTop = null, $aBottom = null, $aRight = null)
    {
        if (null !== $aLeft) {
            $this->iGridWeight[0] = $aLeft;
        }

        if (null !== $aTop) {
            $this->iGridWeight[1] = $aTop;
        }

        if (null !== $aBottom) {
            $this->iGridWeight[2] = $aBottom;
        }

        if (null === $aRight) {
            return;
        }

        $this->iGridWeight[3] = $aRight;
    }

    public function SetMargin($aLeft, $aRight, $aTop, $aBottom)
    {
        $this->iMarginLeft = $aLeft;
        $this->iMarginRight = $aRight;
        $this->iMarginTop = $aTop;
        $this->iMarginBottom = $aBottom;
    }

    public function GetWidth($aImg)
    {
        if (null !== $this->iIcon) {
            if (
                Configs::TIMG_WIDTH === $this->iIconConstrain[0]
            ) {
                $this->iIcon->SetScale(1);
                $tmp = $this->iIcon->GetWidthHeight();
                $this->iIcon->SetScale($this->iIconConstrain[1] / $tmp[0]);
            } elseif (
                Configs::TIMG_HEIGHT === $this->iIconConstrain[0]
            ) {
                $this->iIcon->SetScale(1);
                $tmp = $this->iIcon->GetWidthHeight();
                $this->iIcon->SetScale($this->iIconConstrain[1] / $tmp[1]);
            }
            $tmp = $this->iIcon->GetWidthHeight();
            $iwidth = $tmp[0];
        } else {
            $iwidth = 0;
        }

        if (0 === $this->iTable->iCells[$this->iPRow][$this->iPCol]->iVal->dir) {
            $pwidth = $this->iTable->iCells[$this->iPRow][$this->iPCol]->iVal->GetWidth($aImg);
        } elseif (90 === $this->iTable->iCells[$this->iPRow][$this->iPCol]->iVal->dir) {
            $pwidth = $this->iTable->iCells[$this->iPRow][$this->iPCol]->iVal->GetFontHeight($aImg) + 2;
        } else {
            $pwidth = $this->iTable->iCells[$this->iPRow][$this->iPCol]->iVal->GetWidth($aImg) + 2;
        }

        $pcolspan = $this->iTable->iCells[$this->iPRow][$this->iPCol]->iColSpan;

        return \round(\max($iwidth, $pwidth) / $pcolspan) + $this->iMarginLeft + $this->iMarginRight;
    }

    public function GetHeight($aImg)
    {
        if (null !== $this->iIcon) {
            if (
                Configs::TIMG_WIDTH === $this->iIconConstrain[0]
            ) {
                $this->iIcon->SetScale(1);
                $tmp = $this->iIcon->GetWidthHeight();
                $this->iIcon->SetScale($this->iIconConstrain[1] / $tmp[0]);
            } elseif (
                Configs::TIMG_HEIGHT === $this->iIconConstrain[0]
            ) {
                $this->iIcon->SetScale(1);
                $tmp = $this->iIcon->GetWidthHeight();
                $this->iIcon->SetScale($this->iIconConstrain[1] / $tmp[1]);
            }
            $tmp = $this->iIcon->GetWidthHeight();
            $iheight = $tmp[1];
        } else {
            $iheight = 0;
        }

        if (0 === $this->iTable->iCells[$this->iPRow][$this->iPCol]->iVal->dir) {
            $pheight = $this->iTable->iCells[$this->iPRow][$this->iPCol]->iVal->GetHeight($aImg);
        } else {
            $pheight = $this->iTable->iCells[$this->iPRow][$this->iPCol]->iVal->GetHeight($aImg) + 1;
        }
        $prowspan = $this->iTable->iCells[$this->iPRow][$this->iPCol]->iRowSpan;

        return \round(\max($iheight, $pheight) / $prowspan) + $this->iMarginTop + $this->iMarginBottom;
    }

    public function SetAlign($aHorAlign = 'left', $aVertAlign = 'bottom')
    {
        $aHorAlign = \mb_strtolower($aHorAlign);
        $aVertAlign = \mb_strtolower($aVertAlign);
        $chk = ['left', 'right', 'center', 'bottom', 'top', 'middle'];

        if (!\in_array($aHorAlign, $chk, true) || !\in_array($aVertAlign, $chk, true)) {
            throw      Util\JpGraphError::make(27011, $aHorAlign, $aVertAlign);
        }
        $this->iVertAlign = $aVertAlign;
        $this->iHorAlign = $aHorAlign;
    }

    public function AdjustMarginsForGrid()
    {
        if (0 < $this->iCol) {
            switch ($this->iGridStyle[0]) {
                case Configs::TGRID_SINGLE:
                    $wf = 1;

                    break;
                case Configs::TGRID_DOUBLE:
                    $wf = 3;

                    break;
                case Configs::TGRID_DOUBLE2:
                    $wf = 4;

                    break;
            }
            $this->iMarginLeft += $this->iGridWeight[0] * $wf;
        }

        if (0 < $this->iRow) {
            switch ($this->iGridStyle[1]) {
                case Configs::TGRID_SINGLE:
                    $wf = 1;

                    break;
                case Configs::TGRID_DOUBLE:
                    $wf = 3;

                    break;
                case Configs::TGRID_DOUBLE2:
                    $wf = 4;

                    break;
            }
            $this->iMarginTop += $this->iGridWeight[1] * $wf;
        }

        if ($this->iRow + $this->iRowSpan - 1 < $this->iTable->iSize[0] - 1) {
            switch ($this->iGridStyle[2]) {
                case Configs::TGRID_SINGLE:
                    $wf = 1;

                    break;
                case Configs::TGRID_DOUBLE:
                    $wf = 3;

                    break;
                case Configs::TGRID_DOUBLE2:
                    $wf = 4;

                    break;
            }
            $this->iMarginBottom += $this->iGridWeight[2] * $wf;
        }

        if ($this->iCol + $this->iColSpan - 1 >= $this->iTable->iSize[1] - 1) {
            return;
        }

        switch ($this->iGridStyle[3]) {
            case Configs::TGRID_SINGLE:
                $wf = 1;

                break;
            case Configs::TGRID_DOUBLE:
                $wf = 3;

                break;
            case Configs::TGRID_DOUBLE2:
                $wf = 4;

                break;
        }
        $this->iMarginRight += $this->iGridWeight[3] * $wf;
    }

    public function StrokeVGrid($aImg, $aX, $aY, $aWidth, $aHeight, $aDir = 1)
    {
        // Left or right grid line
        // For the right we increase the X-pos and for the right we decrease it. This is
        // determined by the direction argument.
        $idx = 1 === $aDir ? 0 : 3;

        // We don't stroke the grid lines that are on the edge of the table since this is
        // the place of the border.
        if (((0 >= $this->iCol || 0 !== $idx) && ($this->iCol + $this->iColSpan - 1 >= $this->iTable->iSize[1] - 1 || 3 !== $idx))
            || 0 >= $this->iGridWeight[$idx]
        ) {
            // We don't stroke the grid lines that are on the edge of the table since this is
            // the place of the border.
            return;
            // We don't stroke the grid lines that are on the edge of the table since this is
            // the place of the border.
        }

        $x = 1 === $aDir ? $aX : $aX + $aWidth - 1;
        $y = $aY + $aHeight - 1;
        $aImg->SetColor($this->iGridColor[$idx]);

        switch ($this->iGridStyle[$idx]) {
            case Configs::TGRID_SINGLE:
                for ($i = 0; $i < $this->iGridWeight[$idx]; ++$i) {
                    $aImg->Line($x + $i * $aDir, $aY, $x + $i * $aDir, $y);
                }

                break;
            case Configs::TGRID_DOUBLE:
                for ($i = 0; $i < $this->iGridWeight[$idx]; ++$i) {
                    $aImg->Line($x + $i * $aDir, $aY, $x + $i * $aDir, $y);
                }

                $x += $this->iGridWeight[$idx] * 2;

                for ($i = 0; $i < $this->iGridWeight[$idx]; ++$i) {
                    $aImg->Line($x + $i * $aDir, $aY, $x + $i * $aDir, $y);
                }

                break;
            case Configs::TGRID_DOUBLE2:
                for ($i = 0; $this->iGridWeight[$idx] * 2 > $i; ++$i) {
                    $aImg->Line($x + $i * $aDir, $aY, $x + $i * $aDir, $y);
                }

                $x += $this->iGridWeight[$idx] * 3;

                for ($i = 0; $i < $this->iGridWeight[$idx]; ++$i) {
                    $aImg->Line($x + $i * $aDir, $aY, $x + $i * $aDir, $y);
                }

                break;
        }
    }

    public function StrokeHGrid($aImg, $aX, $aY, $aWidth, $aHeight, $aDir = 1)
    {
        // Top or bottom grid line
        // For the left we increase the X-pos and for the right we decrease it. This is
        // determined by the direction argument.
        $idx = 1 === $aDir ? 1 : 2;

        // We don't stroke the grid lines that are on the edge of the table since this is
        // the place of the border.
        if (((0 >= $this->iRow || 1 !== $idx) && ($this->iRow + $this->iRowSpan - 1 >= $this->iTable->iSize[0] - 1 || 2 !== $idx))
            || 0 >= $this->iGridWeight[$idx]
        ) {
            // We don't stroke the grid lines that are on the edge of the table since this is
            // the place of the border.
            return;
            // We don't stroke the grid lines that are on the edge of the table since this is
            // the place of the border.
        }

        $y = 1 === $aDir ? $aY : $aY + $aHeight - 1;
        $x = $aX + $aWidth - 1;
        $aImg->SetColor($this->iGridColor[$idx]);

        switch ($this->iGridStyle[$idx]) {
            case Configs::TGRID_SINGLE:
                for ($i = 0; $i < $this->iGridWeight[$idx]; ++$i) {
                    $aImg->Line($aX, $y + $i, $x, $y + $i);
                }

                break;
            case Configs::TGRID_DOUBLE:
                for ($i = 0; $i < $this->iGridWeight[$idx]; ++$i) {
                    $aImg->Line($aX, $y + $i, $x, $y + $i);
                }

                $y += $this->iGridWeight[$idx] * 2;

                for ($i = 0; $i < $this->iGridWeight[$idx]; ++$i) {
                    $aImg->Line($aX, $y + $i, $x, $y + $i);
                }

                break;
            case Configs::TGRID_DOUBLE2:
                for ($i = 0; $this->iGridWeight[$idx] * 2 > $i; ++$i) {
                    $aImg->Line($aX, $y + $i, $x, $y + $i);
                }

                $y += $this->iGridWeight[$idx] * 3;

                for ($i = 0; $i < $this->iGridWeight[$idx]; ++$i) {
                    $aImg->Line($aX, $y + $i, $x, $y + $i);
                }

                break;
        }
    }

    public function Stroke($aImg, $aX, $aY, $aWidth, $aHeight)
    {
        // If this is a merged cell we only stroke if it is the parent cell.
        // The parent cell holds the merged cell block
        if ($this->iMerged && ($this->iRow !== $this->iPRow || $this->iCol !== $this->iPCol)) {
            return;
        }

        if ('' !== $this->iBGColor) {
            $aImg->SetColor($this->iBGColor);
            $aImg->FilledRectangle($aX, $aY, $aX + $aWidth - 1, $aY + $aHeight - 1);
        }

        $coords = $aX . ',' . $aY . ',' . ($aX + $aWidth - 1) . ',' . $aY . ',' . ($aX + $aWidth - 1) . ',' . ($aY + $aHeight - 1) . ',' . $aX . ',' . ($aY + $aHeight - 1);

        if (!empty($this->iCSIMtarget)) {
            $this->iCSIMArea = '<area shape="poly" coords="' . $coords . '" href="' . $this->iCSIMtarget . '"';

            if (!empty($this->iCSIMwintarget)) {
                $this->iCSIMArea .= ' target="' . $this->iCSIMwintarget . '"';
            }

            if (!empty($this->iCSIMalt)) {
                $this->iCSIMArea .= ' alt="' . $this->iCSIMalt . '" title="' . $this->iCSIMalt . '" ';
            }
            $this->iCSIMArea .= " />\n";
        }

        $this->StrokeVGrid($aImg, $aX, $aY, $aWidth, $aHeight);
        $this->StrokeVGrid($aImg, $aX, $aY, $aWidth, $aHeight, -1);
        $this->StrokeHGrid($aImg, $aX, $aY, $aWidth, $aHeight);
        $this->StrokeHGrid($aImg, $aX, $aY, $aWidth, $aHeight, -1);

        if (null !== $this->iIcon) {
            switch ($this->iHorAlign) {
                case 'left':
                    $x = $aX + $this->iMarginLeft;
                    $hanchor = 'left';

                    break;
                case 'center':
                case 'middle':
                    $x = $aX + $this->iMarginLeft + \round(($aWidth - $this->iMarginLeft - $this->iMarginRight) / 2);
                    $hanchor = 'center';

                    break;
                case 'right':
                    $x = $aX + $aWidth - $this->iMarginRight - 1;
                    $hanchor = 'right';

                    break;

                default:
                    throw      Util\JpGraphError::make(27012, $this->iHorAlign);
            }

            switch ($this->iVertAlign) {
                case 'top':
                    $y = $aY + $this->iMarginTop;
                    $vanchor = 'top';

                    break;
                case 'center':
                case 'middle':
                    $y = $aY + $this->iMarginTop + \round(($aHeight - $this->iMarginTop - $this->iMarginBottom) / 2);
                    $vanchor = 'center';

                    break;
                case 'bottom':
                    $y = $aY + $aHeight - 1 - $this->iMarginBottom;
                    $vanchor = 'bottom';

                    break;

                default:
                    throw      Util\JpGraphError::make(27012, $this->iVertAlign);
            }
            $this->iIcon->SetAnchor($hanchor, $vanchor);
            $this->iIcon->_Stroke($aImg, $x, $y);
        }
        $this->iVal->SetColor($this->iFontColor);
        $this->iVal->SetFont($this->iFF, $this->iFS, $this->iFSize);

        switch ($this->iHorAlign) {
            case 'left':
                $x = $aX + $this->iMarginLeft;

                break;
            case 'center':
            case 'middle':
                $x = $aX + $this->iMarginLeft + \round(($aWidth - $this->iMarginLeft - $this->iMarginRight) / 2);

                break;
            case 'right':
                $x = $aX + $aWidth - $this->iMarginRight - 1;

                break;

            default:
                throw      Util\JpGraphError::make(27012, $this->iHorAlign);
        }
        // A workaround for the shortcomings in the TTF font handling in GD
        // The anchor position for rotated text (=90) is to "short" so we add
        // an offset based on the actual font size
        if (0 !== $this->iVal->dir && 10 <= $this->iVal->font_family) {
            $aY += 4 + \round($this->iVal->font_size * 0.8);
        }

        switch ($this->iVertAlign) {
            case 'top':
                $y = $aY + $this->iMarginTop;

                break;
            case 'center':
            case 'middle':
                $y = $aY + $this->iMarginTop + \round(($aHeight - $this->iMarginTop - $this->iMarginBottom) / 2);
                //$y -= round($this->iVal->GetFontHeight($aImg)/2);
                $y -= \round($this->iVal->GetHeight($aImg) / 2);

                break;
            case 'bottom':
                //$y = $aY+$aHeight-1-$this->iMarginBottom-$this->iVal->GetFontHeight($aImg);
                $y = $aY + $aHeight - $this->iMarginBottom - $this->iVal->GetHeight($aImg);

                break;

            default:
                throw      Util\JpGraphError::make(27012, $this->iVertAlign);
        }
        $this->iVal->SetAlign($this->iHorAlign, 'top');

        if (null !== $this->iNumberFormat && \is_numeric($this->iVal->t)) {
            $this->iVal->t = \sprintf($this->iNumberFormat, $this->iVal->t);
        }
        $this->iVal->Stroke($aImg, $x, $y);
    }
}

/*
EOF
 */
