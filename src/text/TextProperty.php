<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Text;

use Amenadiel\JpGraph\Util;

/**
 * @class TextProperty
 * // Description: Holds properties for a text
 */
class TextProperty
{
    public $iShow         = true;
    public $csimtarget    = '';
    public $csimwintarget = '';
    public $csimalt       = '';
    private $iFFamily     = FF_FONT1;
    private $iFStyle      = FS_NORMAL;
    private $iFSize       = 10;
    private $iFontArray   = [];
    private $iColor       = 'black';
    private $iText        = '';
    private $iHAlign      = 'left';
    private $iVAlign      = 'bottom';

    /**
     * CONSTRUCTOR.
     *
     * @param mixed $aTxt
     */
    public function __construct($aTxt = '')
    {
        $this->iText = $aTxt;
    }

    /**
     * PUBLIC METHODS.
     *
     * @param mixed $aTxt
     */
    public function Set($aTxt)
    {
        $this->iText = $aTxt;
    }

    public function SetCSIMTarget($aTarget, $aAltText = '', $aWinTarget = '')
    {
        if (is_string($aTarget)) {
            $aTarget = [$aTarget];
        }

        $this->csimtarget = $aTarget;

        if (is_string($aWinTarget)) {
            $aWinTarget = [$aWinTarget];
        }

        $this->csimwintarget = $aWinTarget;

        if (is_string($aAltText)) {
            $aAltText = [$aAltText];
        }

        $this->csimalt = $aAltText;
    }

    public function SetCSIMAlt($aAltText)
    {
        if (is_string($aAltText)) {
            $aAltText = [$aAltText];
        }

        $this->csimalt = $aAltText;
    }

    // Set text color
    public function SetColor($aColor)
    {
        $this->iColor = $aColor;
    }

    public function HasTabs()
    {
        if (is_string($this->iText)) {
            return substr_count($this->iText, "\t") > 0;
        }
        if (is_array($this->iText)) {
            return false;
        }
    }

    // Get number of tabs in string
    public function GetNbrTabs()
    {
        if (is_string($this->iText)) {
            return substr_count($this->iText, "\t");
        }

        return 0;
    }

    // Set alignment
    public function Align($aHAlign, $aVAlign = 'bottom')
    {
        $this->iHAlign = $aHAlign;
        $this->iVAlign = $aVAlign;
    }

    // Synonym
    public function SetAlign($aHAlign, $aVAlign = 'bottom')
    {
        $this->iHAlign = $aHAlign;
        $this->iVAlign = $aVAlign;
    }

    // Specify font
    public function SetFont($aFFamily, $aFStyle = FS_NORMAL, $aFSize = 10)
    {
        $this->iFFamily = $aFFamily;
        $this->iFStyle  = $aFStyle;
        $this->iFSize   = $aFSize;
    }

    public function SetColumnFonts($aFontArray)
    {
        if (!is_array($aFontArray) || safe_count($aFontArray[0]) != 3) {
            Util\JpGraphError::RaiseL(6033);
            // 'Array of fonts must contain arrays with 3 elements, i.e. (Family, Style, Size)'
        }
        $this->iFontArray = $aFontArray;
    }

    public function IsColumns()
    {
        return is_array($this->iText);
    }

    // Get width of text. If text contains several columns separated by
    // tabs then return both the total width as well as an array with a
    // width for each column.
    public function GetWidth($aImg, $aUseTabs = false, $aTabExtraMargin = 1.1)
    {
        $extra_margin = 4;
        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        if (is_string($this->iText)) {
            if (strlen($this->iText) == 0) {
                return 0;
            }

            $tmp = preg_split('/\t/', $this->iText);
            if (safe_count($tmp) <= 1 || !$aUseTabs) {
                $w = $aImg->GetTextWidth($this->iText);

                return $w + 2 * $extra_margin;
            }
            $tot = 0;
            $n   = safe_count($tmp);
            for ($i = 0; $i < $n; ++$i) {
                $res[$i] = $aImg->GetTextWidth($tmp[$i]);
                $tot += $res[$i] * $aTabExtraMargin;
            }

            return [round($tot), $res];
        }
        if (is_object($this->iText)) {
            // A single icon
            return $this->iText->GetWidth() + 2 * $extra_margin;
        }
        if (is_array($this->iText)) {
            // Must be an array of texts. In this case we return the sum of the
            // length + a fixed margin of 4 pixels on each text string
            $n  = safe_count($this->iText);
            $nf = safe_count($this->iFontArray);
            for ($i = 0, $w = 0; $i < $n; ++$i) {
                if ($i < $nf) {
                    $aImg->SetFont($this->iFontArray[$i][0], $this->iFontArray[$i][1], $this->iFontArray[$i][2]);
                } else {
                    $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
                }
                $tmp = $this->iText[$i];
                if (is_string($tmp)) {
                    $w += $aImg->GetTextWidth($tmp) + $extra_margin;
                } else {
                    if (is_object($tmp) === false) {
                        Util\JpGraphError::RaiseL(6012);
                    }
                    $w += $tmp->GetWidth() + $extra_margin;
                }
            }

            return $w;
        }
        Util\JpGraphError::RaiseL(6012);
    }

    // for the case where we have multiple columns this function returns the width of each
    // column individually. If there is no columns just return the width of the single
    // column as an array of one
    public function GetColWidth($aImg, $aMargin = 0)
    {
        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        if (is_array($this->iText)) {
            $n  = safe_count($this->iText);
            $nf = safe_count($this->iFontArray);
            for ($i = 0, $w = []; $i < $n; ++$i) {
                $tmp = $this->iText[$i];
                if (is_string($tmp)) {
                    if ($i < $nf) {
                        $aImg->SetFont($this->iFontArray[$i][0], $this->iFontArray[$i][1], $this->iFontArray[$i][2]);
                    } else {
                        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
                    }
                    $w[$i] = $aImg->GetTextWidth($tmp) + $aMargin;
                } else {
                    if (is_object($tmp) === false) {
                        Util\JpGraphError::RaiseL(6012);
                    }
                    $w[$i] = $tmp->GetWidth() + $aMargin;
                }
            }

            return $w;
        }

        return [$this->GetWidth($aImg)];
    }

    // Get total height of text
    public function GetHeight($aImg)
    {
        $nf        = safe_count($this->iFontArray);
        $maxheight = -1;

        if ($nf > 0) {
            // We have to find out the largest font and take that one as the
            // height of the row
            for ($i = 0; $i < $nf; ++$i) {
                $aImg->SetFont($this->iFontArray[$i][0], $this->iFontArray[$i][1], $this->iFontArray[$i][2]);
                $height    = $aImg->GetFontHeight();
                $maxheight = max($height, $maxheight);
            }
        }

        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        $height    = $aImg->GetFontHeight();
        $maxheight = max($height, $maxheight);

        return $maxheight;
    }

    // Unhide/hide the text
    public function Show($aShow = true)
    {
        $this->iShow = $aShow;
    }

    // Stroke text at (x,y) coordinates. If the text contains tabs then the
    // x parameter should be an array of positions to be used for each successive
    // tab mark. If no array is supplied then the tabs will be ignored.
    public function Stroke($aImg, $aX, $aY)
    {
        if ($this->iShow) {
            $aImg->SetColor($this->iColor);
            $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
            $aImg->SetTextAlign($this->iHAlign, $this->iVAlign);
            if ($this->GetNbrTabs() < 1) {
                if (is_string($this->iText)) {
                    if (is_array($aX)) {
                        $aX = $aX[0];
                    }

                    if (is_array($aY)) {
                        $aY = $aY[0];
                    }

                    $aImg->StrokeText($aX, $aY, $this->iText);
                } elseif (is_array($this->iText) && ($n = safe_count($this->iText)) > 0) {
                    $ax = is_array($aX);
                    $ay = is_array($aY);
                    if ($ax && $ay) {
                        // Nothing; both are already arrays
                    } elseif ($ax) {
                        $aY = array_fill(0, $n, $aY);
                    } elseif ($ay) {
                        $aX = array_fill(0, $n, $aX);
                    } else {
                        $aX = array_fill(0, $n, $aX);
                        $aY = array_fill(0, $n, $aY);
                    }
                    $n = min($n, safe_count($aX));
                    $n = min($n, safe_count($aY));
                    for ($i = 0; $i < $n; ++$i) {
                        $tmp = $this->iText[$i];
                        if (is_object($tmp)) {
                            $tmp->Stroke($aImg, $aX[$i], $aY[$i]);
                        } else {
                            if ($i < safe_count($this->iFontArray)) {
                                $font = $this->iFontArray[$i];
                                $aImg->SetFont($font[0], $font[1], $font[2]);
                            } else {
                                $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
                            }
                            $aImg->StrokeText($aX[$i], $aY[$i], str_replace("\t", ' ', $tmp));
                        }
                    }
                }
            } else {
                $tmp = preg_split('/\t/', $this->iText);
                $n   = min(safe_count($tmp), safe_count($aX));
                for ($i = 0; $i < $n; ++$i) {
                    if ($i < safe_count($this->iFontArray)) {
                        $font = $this->iFontArray[$i];
                        $aImg->SetFont($font[0], $font[1], $font[2]);
                    } else {
                        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
                    }
                    $aImg->StrokeText($aX[$i], $aY, $tmp[$i]);
                }
            }
        }
    }
}
