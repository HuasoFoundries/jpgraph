<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Text;

//use Amenadiel\JpGraph\Graph\Graph;

use Amenadiel\JpGraph\Image\RotImage;
use Amenadiel\JpGraph\Util;

/**
 * File:        JPGRAPH_TEXT.INC.PHP
 * // Description: Class to handle text as object in the graph.
 * //              The low level text layout engine is handled by the GD class
 * // Created:     2001-01-08 (Refactored to separate file 2008-08-01)
 * // Ver:         $Id: jpgraph_text.inc.php 1844 2009-09-26 17:05:31Z ljp $.
 * //
 * // Copyright (c) Asial Corporation. All rights reserved.
 */

/**
 * @class Text
 * // Description: Arbitrary text object that can be added to the graph
 */
class Text extends Configs
{
    public $t;

    public $x = 0;

    public $y = 0;

    public $halign = 'left';

    public $valign = 'top';

    public $color = [0, 0, 0];

    public $hide = false;

    public $dir = 0;

    public $iScalePosY;

    public $iScalePosX;

    public $iWordwrap = 0;

    public $font_family = self::FF_DEFAULT;

    public $font_style = self::FS_NORMAL; // old. self::FF_FONT1

    public $boxed = false; // Should the text be boxed

    protected $paragraph_align = 'left';

    protected $icornerradius = 0;

    protected $ishadowwidth = 3;

    protected $fcolor = 'white';

    protected $bcolor = 'black';

    protected $shadow = false;

    protected $iCSIMarea = '';

    protected $iCSIMalt = '';

    protected $iCSIMtarget = '';

    protected $iCSIMWinTarget = '';

    private $iBoxType = 1; // Which variant of filled box around text we want

    // for __get, __set
    private $_margin;

    private $_font_size = 8; // old. 12

    /**
     * @param mixed $aTxt
     * @param mixed $aXAbsPos
     * @param mixed $aYAbsPos
     */
    // Create new text at absolute pixel coordinates
    public function __construct($aTxt = '', $aXAbsPos = 0, $aYAbsPos = 0)
    {
        if (!\is_string($aTxt)) {
            throw      Util\JpGraphError::make(25050); //('First argument to Text::Text() must be s atring.');
        }
        $this->t = $aTxt;
        $this->x = \round($aXAbsPos);
        $this->y = \round($aYAbsPos);
        $this->margin = 0;
    }

    public function __get($name)
    {
        if (\mb_strpos($name, 'raw_') !== false) {
            // if $name == 'raw_left_margin' , return $this->_left_margin;
            $variable_name = '_' . \str_replace('raw_', '', $name);

            return $this->{$variable_name};
        }

        $variable_name = '_' . $name;

        if (isset($this->{$variable_name})) {
            return $this->{$variable_name} * self::SUPERSAMPLING_SCALE;
        }
        throw      Util\JpGraphError::make('25132', $name);
    }

    public function __set($name, $value)
    {
        $this->{'_' . $name} = $value;
        return $this;
    }

    /**
     * PUBLIC METHODS.
     *
     * @param mixed $aTxt
     */
    // Set the string in the text object
    public function Set($aTxt)
    {
        $this->t = $aTxt;
        return $this;
    }

    // Alias for Pos()
    public function SetPos($aXAbsPos = 0, $aYAbsPos = 0, $aHAlign = 'left', $aVAlign = 'top')
    {
        //$this->Pos($aXAbsPos,$aYAbsPos,$aHAlign,$aVAlign);
        $this->x = $aXAbsPos;
        $this->y = $aYAbsPos;
        $this->halign = $aHAlign;
        $this->valign = $aVAlign;
        return $this;
    }

    public function SetScalePos($aX, $aY)
    {
        $this->iScalePosX = $aX;
        $this->iScalePosY = $aY;
        return $this;
    }

    // Specify alignment for the text
    public function Align($aHAlign, $aVAlign = 'top', $aParagraphAlign = '')
    {
        $this->halign = $aHAlign;
        $this->valign = $aVAlign;

        if ('' === $aParagraphAlign) {
            return;
        }

        $this->paragraph_align = $aParagraphAlign;
        return $this;
    }

    // Alias
    public function SetAlign($aHAlign, $aVAlign = 'top', $aParagraphAlign = '')
    {
        $this->Align($aHAlign, $aVAlign, $aParagraphAlign);
        return $this;
    }

    // Specifies the alignment for a multi line text
    public function ParagraphAlign($aAlign)
    {
        $this->paragraph_align = $aAlign;
        return $this;
    }

    // Specifies the alignment for a multi line text
    public function SetParagraphAlign($aAlign)
    {
        $this->paragraph_align = $aAlign;
        return $this;
    }

    public function SetShadow($aShadowColor = 'gray', $aShadowWidth = 3)
    {
        $this->ishadowwidth = $aShadowWidth;
        $this->shadow = $aShadowColor;
        $this->boxed = true;
        return $this;
    }


    public function SetWordWrap($aCol)
    {
        $this->iWordwrap = $aCol;
        return $this;
    }

    // Specify that the text should be boxed. fcolor=frame color, bcolor=border color,
    // $shadow=drop shadow should be added around the text.
    public function SetBox($aFrameColor = [255, 255, 255], $aBorderColor = [0, 0, 0], $aShadowColor = false, $aCornerRadius = 4, $aShadowWidth = 3)
    {
        if (false === $aFrameColor) {
            $this->boxed = false;
        } else {
            $this->boxed = true;
        }
        $this->fcolor = $aFrameColor;
        $this->bcolor = $aBorderColor;
        // For backwards compatibility when shadow was just true or false
        if (true === $aShadowColor) {
            $aShadowColor = 'gray';
        }
        $this->shadow = $aShadowColor;
        $this->icornerradius = $aCornerRadius;
        $this->ishadowwidth = $aShadowWidth;
        return $this;
    }

    public function SetBox2($aFrameColor = [255, 255, 255], $aBorderColor = [0, 0, 0], $aShadowColor = false, $aCornerRadius = 4, $aShadowWidth = 3)
    {
        $this->iBoxType = 2;
        $this->SetBox($aFrameColor, $aBorderColor, $aShadowColor, $aCornerRadius, $aShadowWidth);
        return $this;
    }

    // Hide the text
    public function Hide($aHide = true)
    {
        $this->hide = $aHide;
        return $this;
    }

    // This looks ugly since it's not a very orthogonal design
    // but I added this "inverse" of Hide() to harmonize
    // with some classes which I designed more recently (especially)
    // jpgraph_gantt
    public function Show($aShow = true)
    {
        $this->hide = !$aShow;
        return $this;
    }

    // Specify font
    public function SetFont($aFamily, $aStyle = self::FS_NORMAL, $aSize = 10)
    {
        $this->font_family = $aFamily;
        $this->font_style = $aStyle;
        $this->font_size = $aSize;
        return $this;
    }

    // Center the text between $left and $right coordinates
    public function Center($aLeft, $aRight, $aYAbsPos = false)
    {
        $this->x = $aLeft + ($aRight - $aLeft) / 2;
        $this->halign = 'center';

        if (!\is_numeric($aYAbsPos)) {
            return;
        }

        $this->y = $aYAbsPos;
        return $this;
    }

    // Set text color
    public function SetColor($aColor)
    {
        $this->color = $aColor;
        return $this;
    }

    public function SetAngle($aAngle)
    {
        $this->SetOrientation($aAngle);
        return $this;
    }

    // Orientation of text. Note only TTF fonts can have an arbitrary angle
    public function SetOrientation($aDirection = 0)
    {
        if (\is_numeric($aDirection)) {
            $this->dir = $aDirection;
        } elseif ('h' === $aDirection) {
            $this->dir = 0;
        } elseif ('v' === $aDirection) {
            $this->dir = 90;
        } else {
            throw      Util\JpGraphError::make(25051);
        }
        return $this;
        //(" Invalid direction specified for text.");
    }

    // Total width of text
    public function GetWidth($aImg)
    {
        $aImg->SetFont($this->font_family, $this->font_style, $this->raw_font_size);

        return $aImg->GetTextWidth($this->t, $this->dir);
    }

    // Hight of font
    public function GetFontHeight($aImg)
    {
        $aImg->SetFont($this->font_family, $this->font_style, $this->raw_font_size);

        return $aImg->GetFontHeight();
    }

    public function GetTextHeight($aImg)
    {
        $aImg->SetFont($this->font_family, $this->font_style, $this->raw_font_size);

        return $aImg->GetTextHeight($this->t, $this->dir);
    }

    public function GetHeight($aImg)
    {
        // Synonym for GetTextHeight()
        $aImg->SetFont($this->font_family, $this->font_style, $this->raw_font_size);

        return $aImg->GetTextHeight($this->t, $this->dir);
    }

    // Set the margin which will be interpretated differently depending
    // on the context.
    public function SetMargin($aMarg)
    {
        $this->margin = $aMarg;
        return $this;
    }

    public function StrokeWithScale($aImg, $axscale, $ayscale)
    {
        if (null === $this->iScalePosX || null === $this->iScalePosY) {
            $this->Stroke($aImg);
        } else {
            $this->Stroke(
                $aImg,
                \round($axscale->Translate($this->iScalePosX)),
                \round($ayscale->Translate($this->iScalePosY))
            );
        }
        return $this;
    }

    public function SetCSIMTarget($aURITarget, $aAlt = '', $aWinTarget = '')
    {
        $this->iCSIMtarget = $aURITarget;
        $this->iCSIMalt = $aAlt;
        $this->iCSIMWinTarget = $aWinTarget;
        return $this;
    }

    public function GetCSIMareas()
    {
        if ('' !== $this->iCSIMtarget) {
            return $this->iCSIMarea;
        }

        return '';
    }

    // Display text in image
    public function Stroke($aImg, $x = null, $y = null)
    {
        if (\is_numeric($x)) {
            $this->x = \round($x);
        }

        if (\is_numeric($y)) {
            $this->y = \round($y);
        }

        // Insert newlines
        if (0 < $this->iWordwrap) {
            $this->t = \wordwrap($this->t, $this->iWordwrap, "\n");
        }

        // If position been given as a fraction of the image size
        // calculate the absolute position
        if (1 > $this->x && 0 < $this->x) {
            $this->x *= $aImg->width;
        }

        if (1 > $this->y && 0 < $this->y) {
            $this->y *= $aImg->height;
        }

        $aImg->PushColor($this->color);
        $aImg->SetFont($this->font_family, $this->font_style, $this->raw_font_size);
        $aImg->SetTextAlign($this->halign, $this->valign);

        if ($this->boxed && $aImg instanceof RotImage) {
            if ('nofill' === $this->fcolor) {
                $this->fcolor = false;
            }

            $oldweight = $aImg->SetLineWeight(1);

            if (2 === $this->iBoxType && self::FF_FONT2 + 2 < $this->font_family) {
                $bbox = $aImg->StrokeBoxedText2(
                    $this->x,
                    $this->y,
                    $this->t,
                    $this->dir,
                    $this->fcolor,
                    $this->bcolor,
                    $this->shadow,
                    $this->paragraph_align,
                    2,
                    4,
                    $this->icornerradius,
                    $this->ishadowwidth
                );
            } else {
                $bbox = $aImg->StrokeBoxedText(
                    $this->x,
                    $this->y,
                    $this->t,
                    $this->dir,
                    $this->fcolor,
                    $this->bcolor,
                    $this->shadow,
                    $this->paragraph_align,
                    3,
                    3,
                    $this->icornerradius,
                    $this->ishadowwidth
                );
            }

            $aImg->SetLineWeight($oldweight);
        } else {
            $debug = false;
            $bbox = $aImg->StrokeText($this->x, $this->y, $this->t, $this->dir, $this->paragraph_align, $debug);
        }

        // Create CSIM targets
        $coords = \implode(',', [
            $bbox[0],
            $bbox[1],
            $bbox[2],
            $bbox[3],
            $bbox[4],
            $bbox[5],
            $bbox[6],
            $bbox[7],
        ]);
        $this->iCSIMarea = "<area shape=\"poly\" coords=\"{$coords}\" href=\"";
        $this->iCSIMarea .= \htmlentities($this->iCSIMtarget) . '" ';

        if (\trim($this->iCSIMalt) !== '') {
            $this->iCSIMarea .= ' alt="' . $this->iCSIMalt . '" ';
            $this->iCSIMarea .= ' title="' . $this->iCSIMalt . '" ';
        }

        if (\trim($this->iCSIMWinTarget) !== '') {
            $this->iCSIMarea .= ' target="' . $this->iCSIMWinTarget . '" ';
        }
        $this->iCSIMarea .= " />\n";

        $aImg->PopColor($this->color);
        return $this;
    }
}
// @class
