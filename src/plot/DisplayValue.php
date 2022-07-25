<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Plot;

use Amenadiel\JpGraph\Text;
use Amenadiel\JpGraph\Util;

/**
 * @class DisplayValue
 * // Description: Used to print data values at data points
 */
class DisplayValue extends Configs
{
    public $margin = 5;

    public $show = false;

    public $valign = '';

    public $halign = 'center';

    public $format = '%.1f';

    public $negformat = '';

    public $txt;

    private $ff = self::FF_DEFAULT;

    private $fs = self::FS_NORMAL;

    private $fsize = 8;

    private $iFormCallback = '';

    private $angle = 0;

    private $color = 'navy';

    private $negcolor = '';

    private $iHideZero = false;

    public function __construct()
    {
        $this->txt = new Text\Text();
    }

    public function Show($aFlag = true)
    {
        $this->show = $aFlag;
    }

    public function SetColor($aColor, $aNegcolor = '')
    {
        $this->color = $aColor;
        $this->negcolor = $aNegcolor;
    }

    public function SetFont($aFontFamily, $aFontStyle = self::FS_NORMAL, $aFontSize = 8)
    {
        $this->ff = $aFontFamily;
        $this->fs = $aFontStyle;
        $this->fsize = $aFontSize;
    }

    public function ApplyFont($aImg)
    {
        $aImg->SetFont($this->ff, $this->fs, $this->fsize);
    }

    public function SetMargin($aMargin)
    {
        $this->margin = $aMargin;
    }

    public function SetAngle($aAngle)
    {
        $this->angle = $aAngle;
    }

    public function SetAlign($aHAlign, $aVAlign = '')
    {
        $this->halign = $aHAlign;
        $this->valign = $aVAlign;
    }

    public function SetFormat($aFormat, $aNegFormat = '')
    {
        $this->format = $aFormat;
        $this->negformat = $aNegFormat;
    }

    public function SetFormatCallback($aFunc)
    {
        $this->iFormCallback = $aFunc;
    }

    public function HideZero($aFlag = true)
    {
        $this->iHideZero = $aFlag;
    }

    public function Stroke($img, $aVal, $x, $y)
    {
        if (!$this->show) {
            return;
        }

        if ('' === $this->negformat) {
            $this->negformat = $this->format;
        }

        if ('' === $this->negcolor) {
            $this->negcolor = $this->color;
        }

        if (null === $aVal || (\is_string($aVal) && ('' === $aVal || '-' === $aVal || 'x' === $aVal))) {
            return;
        }

        if (\is_numeric($aVal) && 0 === $aVal && $this->iHideZero) {
            return;
        }

        // Since the value is used in different cirumstances we need to check what
        // kind of formatting we shall use. For example, to display values in a line
        // graph we simply display the formatted value, but in the case where the user
        // has already specified a text string we don't fo anything.
        if ('' !== $this->iFormCallback) {
            $f = $this->iFormCallback;
            $sval = $f($aVal);
        } elseif (\is_numeric($aVal)) {
            if (0 <= $aVal) {
                $sval = \sprintf($this->format, $aVal);
            } else {
                $sval = \sprintf($this->negformat, $aVal);
            }
        } else {
            $sval = $aVal;
        }

        $y = $y - Util\Helper::sign($aVal) * $this->margin;

        $this->txt->Set($sval);
        $this->txt->SetPos($x, $y);
        $this->txt->SetFont($this->ff, $this->fs, $this->fsize);

        if ('' === $this->valign) {
            if (0 <= $aVal) {
                $valign = 'bottom';
            } else {
                $valign = 'top';
            }
        } else {
            $valign = $this->valign;
        }
        $this->txt->Align($this->halign, $valign);

        $this->txt->SetOrientation($this->angle);

        if (0 < $aVal) {
            $this->txt->SetColor($this->color);
        } else {
            $this->txt->SetColor($this->negcolor);
        }
        $this->txt->Stroke($img);
    }
}
