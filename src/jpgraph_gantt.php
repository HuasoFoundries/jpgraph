<?php
/*=======================================================================
// File:        JPGRAPH_GANTT.PHP
// Description: JpGraph Gantt plot extension
// Created:     2001-11-12
// Ver:         $Id: jpgraph_gantt.php 1809 2009-09-09 13:07:33Z ljp $
//
// Copyright (c) Asial Corporation. All rights reserved.
//========================================================================
 */

require_once 'jpgraph_plotband.php';
require_once 'jpgraph_iconplot.php';
require_once 'jpgraph_plotmark.inc.php';

// Maximum size for Automatic Gantt chart
define('MAX_GANTTIMG_SIZE_W', 8000);
define('MAX_GANTTIMG_SIZE_H', 5000);

// Scale Header types
define("GANTT_HDAY", 1);
define("GANTT_HWEEK", 2);
define("GANTT_HMONTH", 4);
define("GANTT_HYEAR", 8);
define("GANTT_HHOUR", 16);
define("GANTT_HMIN", 32);

// Bar patterns
define("GANTT_RDIAG", BAND_RDIAG); // Right diagonal lines
define("GANTT_LDIAG", BAND_LDIAG); // Left diagonal lines
define("GANTT_SOLID", BAND_SOLID); // Solid one color
define("GANTT_VLINE", BAND_VLINE); // Vertical lines
define("GANTT_HLINE", BAND_HLINE); // Horizontal lines
define("GANTT_3DPLANE", BAND_3DPLANE); // "3D" Plane
define("GANTT_HVCROSS", BAND_HVCROSS); // Vertical/Hor crosses
define("GANTT_DIAGCROSS", BAND_DIAGCROSS); // Diagonal crosses

// Conversion constant
define("SECPERDAY", 3600 * 24);

// Locales. ONLY KEPT FOR BACKWARDS COMPATIBILITY
// You should use the proper locale strings directly
// from now on.
define("LOCALE_EN", "en_UK");
define("LOCALE_SV", "sv_SE");

// Layout of bars
define("GANTT_EVEN", 1);
define("GANTT_FROMTOP", 2);

// Style for minute header
define("MINUTESTYLE_MM", 0); // 15
define("MINUTESTYLE_CUSTOM", 2); // Custom format

// Style for hour header
define("HOURSTYLE_HM24", 0); // 13:10
define("HOURSTYLE_HMAMPM", 1); // 1:10pm
define("HOURSTYLE_H24", 2); // 13
define("HOURSTYLE_HAMPM", 3); // 1pm
define("HOURSTYLE_CUSTOM", 4); // User defined

// Style for day header
define("DAYSTYLE_ONELETTER", 0); // "M"
define("DAYSTYLE_LONG", 1); // "Monday"
define("DAYSTYLE_LONGDAYDATE1", 2); // "Monday 23 Jun"
define("DAYSTYLE_LONGDAYDATE2", 3); // "Monday 23 Jun 2003"
define("DAYSTYLE_SHORT", 4); // "Mon"
define("DAYSTYLE_SHORTDAYDATE1", 5); // "Mon 23/6"
define("DAYSTYLE_SHORTDAYDATE2", 6); // "Mon 23 Jun"
define("DAYSTYLE_SHORTDAYDATE3", 7); // "Mon 23"
define("DAYSTYLE_SHORTDATE1", 8); // "23/6"
define("DAYSTYLE_SHORTDATE2", 9); // "23 Jun"
define("DAYSTYLE_SHORTDATE3", 10); // "Mon 23"
define("DAYSTYLE_SHORTDATE4", 11); // "23"
define("DAYSTYLE_CUSTOM", 12); // "M"

// Styles for week header
define("WEEKSTYLE_WNBR", 0);
define("WEEKSTYLE_FIRSTDAY", 1);
define("WEEKSTYLE_FIRSTDAY2", 2);
define("WEEKSTYLE_FIRSTDAYWNBR", 3);
define("WEEKSTYLE_FIRSTDAY2WNBR", 4);

// Styles for month header
define("MONTHSTYLE_SHORTNAME", 0);
define("MONTHSTYLE_LONGNAME", 1);
define("MONTHSTYLE_LONGNAMEYEAR2", 2);
define("MONTHSTYLE_SHORTNAMEYEAR2", 3);
define("MONTHSTYLE_LONGNAMEYEAR4", 4);
define("MONTHSTYLE_SHORTNAMEYEAR4", 5);
define("MONTHSTYLE_FIRSTLETTER", 6);

// Types of constrain links
define('CONSTRAIN_STARTSTART', 0);
define('CONSTRAIN_STARTEND', 1);
define('CONSTRAIN_ENDSTART', 2);
define('CONSTRAIN_ENDEND', 3);

// Arrow direction for constrain links
define('ARROW_DOWN', 0);
define('ARROW_UP', 1);
define('ARROW_LEFT', 2);
define('ARROW_RIGHT', 3);

// Arrow type for constrain type
define('ARROWT_SOLID', 0);
define('ARROWT_OPEN', 1);

// Arrow size for constrain lines
define('ARROW_S1', 0);
define('ARROW_S2', 1);
define('ARROW_S3', 2);
define('ARROW_S4', 3);
define('ARROW_S5', 4);

// Activity types for use with utility method CreateSimple()
define('ACTYPE_NORMAL', 0);
define('ACTYPE_GROUP', 1);
define('ACTYPE_MILESTONE', 2);

define('ACTINFO_3D', 1);
define('ACTINFO_2D', 0);

// Check if array_fill() exists
if (!function_exists('array_fill')) {
    function array_fill($iStart, $iLen, $vValue)
    {
        $aResult = array();
        for ($iCount = $iStart; $iCount < $iLen + $iStart; $iCount++) {
            $aResult[$iCount] = $vValue;
        }
        return $aResult;
    }
}

//===================================================
// CLASS GanttActivityInfo
// Description:
//===================================================
class GanttActivityInfo
{
    public $iShow = true;
    public $iLeftColMargin = 4, $iRightColMargin = 1, $iTopColMargin = 1, $iBottomColMargin = 3;
    public $vgrid = null;
    private $iColor = 'black';
    private $iBackgroundColor = 'lightgray';
    private $iFFamily = FF_FONT1, $iFStyle = FS_NORMAL, $iFSize = 10, $iFontColor = 'black';
    private $iTitles = array();
    private $iWidth = array(), $iHeight = -1;
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
    public function SetFont($aFFamily, $aFStyle = FS_NORMAL, $aFSize = 10)
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
        $n = min(count($this->iTitles), count($aWidths));
        for ($i = 0; $i < $n; ++$i) {
            if (!empty($aWidths[$i])) {
                if (empty($this->iWidth[$i])) {
                    $this->iWidth[$i] = $aWidths[$i];
                } else {
                    $this->iWidth[$i] = max($this->iWidth[$i], $aWidths[$i]);
                }
            }
        }
    }

    public function GetWidth($aImg)
    {
        $txt = new TextProperty();
        $txt->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        $n = count($this->iTitles);
        $rm = $this->iRightColMargin;
        $w = 0;
        for ($h = 0, $i = 0; $i < $n; ++$i) {
            $w += $this->iLeftColMargin;
            $txt->Set($this->iTitles[$i]);
            if (!empty($this->iWidth[$i])) {
                $w1 = max($txt->GetWidth($aImg) + $rm, $this->iWidth[$i]);
            } else {
                $w1 = $txt->GetWidth($aImg) + $rm;
            }
            $this->iWidth[$i] = $w1;
            $w += $w1;
            $h = max($h, $txt->GetHeight($aImg));
        }
        $this->iHeight = $h + $this->iTopHeaderMargin;
        $txt = '';
        return $w;
    }

    public function GetColStart($aImg, &$aStart, $aAddLeftMargin = false)
    {
        $n = count($this->iTitles);
        $adj = $aAddLeftMargin ? $this->iLeftColMargin : 0;
        $aStart = array($aImg->left_margin + $adj);
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

        $txt = new TextProperty();
        $txt->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        $txt->SetColor($this->iFontColor);
        $txt->SetAlign($this->iHeaderAlign, 'top');
        $n = count($this->iTitles);

        if ($n == 0) {
            return;
        }

        $x = $aXLeft;
        $h = $this->iHeight;
        $yTop = $aUseTextHeight ? $aYBottom - $h - $this->iTopColMargin - $this->iBottomColMargin : $aYTop;

        if ($h < 0) {
            JpGraphError::RaiseL(6001);
            //('Internal error. Height for ActivityTitles is < 0');
        }

        $aImg->SetLineWeight(1);
        // Set background color
        $aImg->SetColor($this->iBackgroundColor);
        $aImg->FilledRectangle($aXLeft, $yTop, $aXRight, $aYBottom - 1);

        if ($this->iStyle == 1) {
            // Make a 3D effect
            $aImg->SetColor('white');
            $aImg->Line($aXLeft, $yTop + 1, $aXRight, $yTop + 1);
        }

        for ($i = 0; $i < $n; ++$i) {
            if ($this->iStyle == 1) {
                // Make a 3D effect
                $aImg->SetColor('white');
                $aImg->Line($x + 1, $yTop, $x + 1, $aYBottom);
            }
            $x += $this->iLeftColMargin;
            $txt->Set($this->iTitles[$i]);

            // Adjust the text anchor position according to the choosen alignment
            $xp = $x;
            if ($this->iHeaderAlign == 'center') {
                $xp = (($x - $this->iLeftColMargin) + ($x + $this->iWidth[$i])) / 2;
            } elseif ($this->iHeaderAlign == 'right') {
                $xp = $x + $this->iWidth[$i] - $this->iRightColMargin;
            }

            $txt->Stroke($aImg, $xp, $yTop + $this->iTopHeaderMargin);
            $x += $this->iWidth[$i];
            if ($i < $n - 1) {
                $aImg->SetColor($this->iColor);
                $aImg->Line($x, $yTop, $x, $aYBottom);
            }
        }

        $aImg->SetColor($this->iColor);
        $aImg->Line($aXLeft, $yTop, $aXRight, $yTop);

        // Stroke vertical column dividers
        $cols = array();
        $this->GetColStart($aImg, $cols);
        $n = count($cols);
        for ($i = 1; $i < $n; ++$i) {
            $this->vgrid->Stroke($aImg, $cols[$i], $aYBottom, $cols[$i],
                $aImg->height - $aImg->bottom_margin);
        }
    }
}

//===================================================
// CLASS PredefIcons
// Description: Predefined icons for use with Gantt charts
//===================================================
define('GICON_WARNINGRED', 0);
define('GICON_TEXT', 1);
define('GICON_ENDCONS', 2);
define('GICON_MAIL', 3);
define('GICON_STARTCONS', 4);
define('GICON_CALC', 5);
define('GICON_MAGNIFIER', 6);
define('GICON_LOCK', 7);
define('GICON_STOP', 8);
define('GICON_WARNINGYELLOW', 9);
define('GICON_FOLDEROPEN', 10);
define('GICON_FOLDER', 11);
define('GICON_TEXTIMPORTANT', 12);

class PredefIcons
{
    private $iBuiltinIcon = null, $iLen = -1;

    public function GetLen()
    {
        return $this->iLen;
    }

    public function GetImg($aIdx)
    {
        if ($aIdx < 0 || $aIdx >= $this->iLen) {
            JpGraphError::RaiseL(6010, $aIdx);
            //('Illegal icon index for Gantt builtin icon ['.$aIdx.']');
        }
        return Image::CreateFromString(base64_decode($this->iBuiltinIcon[$aIdx][1]));
    }

    public function __construct()
    {
        //==========================================================
        // warning.png
        //==========================================================
        $this->iBuiltinIcon[0][0] = 1043;
        $this->iBuiltinIcon[0][1] =
        'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsSAAALEgHS3X78AAAA' .
        'B3RJTUUH0wgKFSgilWPhUQAAA6BJREFUeNrtl91rHFUYh5/3zMx+Z5JNUoOamCZNaqTZ6IWIkqRiQWmi1IDetHfeiCiltgXBP8AL' .
        '0SIUxf/AvfRSBS9EKILFFqyIH9CEmFZtPqrBJLs7c+b1YneT3WTTbNsUFPLCcAbmzPt73o9zzgzs2Z793231UOdv3w9k9Z2uzOdA' .
        '5+2+79yNeL7Hl7hw7oeixRMZ6PJM26W18DNAm/Vh7lR8fqh97NmMF11es1iFpMATqdirwMNA/J4DpIzkr5YsAF1PO6gIMYHRdPwl' .
        'oO2elmB+qH3sm7XozbkgYvy8SzYnZPtcblyM6I+5z3jQ+0vJfgpEu56BfI9vUkbyi2HZd1QJoeWRiAjBd4SDCW8SSAOy6wBHMzF7' .
        'YdV2A+ROuvRPLfHoiSU0EMY/cDAIhxJeGngKaN1VgHyPL7NBxI1K9P4QxBzw3K1zJ/zkG8B9uwaQ7/HNsRZv9kohBGD0o7JqMYS/' .
        '/ynPidQw/LrBiPBcS/yFCT95DvB2BWAy4575PaQbQKW+tPd3GCItu2odKI++YxiKu0d26oWmAD7paZU/rLz37VqIijD2YbnzNBBE' .
        'IBHf8K8qjL7vYhCGErEU8CTg3xXAeMp96GrJEqkyXkm9Bhui1xfsunjdGhcYLq+IzjsGmBt5YH/cmJkFq6gIqlon3u4LxdKGuCIo' .
        'Qu41g0E41po+2R33Xt5uz9kRIB2UTle7PnfKrROP1HD4sRjZlq0lzhwoZ6rDNeTi3nEg1si/7FT7kYQbXS6E5E65tA5uRF9tutq0' .
        'K/VwAF+/FbIYWt6+tjQM/AqUms7A4Wy6d7YSfSNxgMmzi0ycWWworio4QJvj4LpuL5BqugTnXzzqJsJwurrlNhJXFaavW67NRw3F' .
        'q+aJcCQVe9fzvJGmAY7/dPH0gi0f64OveGxa+usCuQMeZ0+kt8BVrX+qPO9Bzx0MgqBvs+a2PfDdYIf+WAjXU1ub4tqNaPPzRs8A' .
        'blrli+WVn79cXn0cWKl+tGx7HLc7pu3CSmnfitL+l1UihAhwjFkPQev4K/fSABjBM8JCaFuurJU+rgW41SroA8aNMVNAFtgHJCsn' .
        'XGy/58QVxAC9MccJtZ5kIzNlW440WrJ2ea4YPA9cAooA7i0A/gS+iqLoOpB1HOegqrYB3UBmJrAtQAJwpwPr1Ry92wVlgZsiYlW1' .
        'uX1gU36dymgqYxJIJJNJT1W9QqHgNwFQBGYqo94OwHZQUuPD7ACglSvc+5n5T9m/wfJJX4U9qzEAAAAASUVORK5CYII=';

        //==========================================================
        // edit.png
        //==========================================================
        $this->iBuiltinIcon[1][0] = 959;
        $this->iBuiltinIcon[1][1] =
        'iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAFgAWABY9j+ZuwAAAAlwSFlz' .
        'AAALEAAACxABrSO9dQAAAAd0SU1FB9AKDAwbIEXOA6AAAAM8SURBVHicpdRPaBxlHMbx76ZvsmOTmm1dsEqQSIIsEmGVBAQjivEQ' .
        'PAUJngpWsAWlBw8egpQepKwplN4ULEG9CjkEyUFKlSJrWTG0IU51pCsdYW2ncUPjdtp9Z+f3vuNhu8nKbmhaf5cZeGc+PO8zf1Lc' .
        'm0KhkACICCKCMeaBjiLC0tLSnjNvPmuOHRpH0TZTU1M8zBi9wakzn7OFTs5sw8YYACYmJrre7HkeuVyu69qPF77hlT1XmZ0eQ03O' .
        'wOLJTvhBx1rLz18VmJ0eY+jVd2FxDkKXnvYLHgb97OgLzE4ON9Hzc1B1QaQzsed5O0Lta3Ec89OnR5h5McfQ+Mw2qgQUnfBOPbZ3' .
        'bK3l+xOvMT0+3ERLp5FNF6UEjcL32+DdVmGt5WLhDYYPZrbRqreFumXwql0S3w9tnDvLWD5PZigPpdOwuYpSCo3C8wU3UHxQdHbf' .
        'cZIkNM6dxcnlUM4k1eUFMlUPpUADbpkttFarHe6oYqeOr6yt4RzMQHYUcUsQVtGicHDwKprViuLDkkOtVnsHCHZVRVy/zcj1i5Af' .
        'h8AjdIts+hUcGcYPK3iBtKM3gD/uAzf/AdY2mmmVgy6X8YNNKmGIvyloPcB8SUin07RQ4EZHFdsdG0wkJEnEaHAJxvKEpSLeaokV' .
        'r4zWmhUZYLlY4b1D03y5eIEWCtS7vsciAgiIxkQRabWOrlQor66y4pUphoJb1jiO4uO5o0S3q6RSqVbiOmC7VCEgAhLSaDQ48dH7' .
        'vD46REY0iysegSjKQciRt99ib7qXwX0O+pG4teM6YKHLB9JMq4mTmF9/+AKA4wvLZByH7OgYL7+UY2qvw/7Bfg5kHiXjJFyv3CGO' .
        'Y1rof+BW4t/XLiPG0DCGr79d4XzRxRnIMn98huXSTYyJ6et1UNYQhRvcinpJq86H3wGPPPM0iBDd+QffD1g4eZjLvuG7S1Wef26E' .
        'J7L7eSx7gAHVg7V3MSbi6m/r93baBd6qQjerAJg/9Ql/XrvG0ON1+vv7GH3qSfY5fahUnSTpwZgIEQesaVXRPbHRG/xyJSAxMYlp' .
        'EOm71HUINiY7mGb95l/8jZCyQmJjMDGJjUmsdCROtZ0n/P/Z8v4Fs2MTUUf7vYoAAAAASUVORK5CYII=';

        //==========================================================
        // endconstrain.png
        //==========================================================
        $this->iBuiltinIcon[2][0] = 666;
        $this->iBuiltinIcon[2][1] =
        'iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlz' .
        'AAALDwAACw8BkvkDpQAAAAd0SU1FB9ALEREILkh0+eQAAAIXSURBVHictZU9aFNRFMd/N81HX77aptJUWmp1LHRpIcWhg5sIDlUQ' .
        'LAXB4t7RRUpwEhy7iQ46CCIoSHcl0CFaoVARU2MFMYktadLXJNok7x2HtCExvuYFmnO4w/3gx+Gc/z1HKRTdMEdXqHbB/sgc/sic' .
        'nDoYAI8XwDa8o1RMLT+2hAsigtTvbIGVqhX46szUifBGswUeCPgAGB7QeLk0X4Ork+HOxo1VgSqGASjMqkn8W4r4vVtEgI/RRQEL' .
        'vaoGD85cl5V3nySR/S1mxWxab7f35PnntNyMJeRr9kCMqiHTy09EoeToLwggx6ymiMOD/VwcD7Oa/MHkcIiQx026WGYto5P/U+ZZ' .
        '7gD0QwDuT5z9N3LrVPi0Xs543eQPKkRzaS54eviJIp4tMFQFMllAWN2qcRZHBnixNM8NYD162xq8u7ePSQ+GX2Pjwxc2dB2cLtB8' .
        '7GgamCb0anBYBeChMtl8855CarclxU1gvViiUK4w2OMkNDnGeJ8bt9fH90yOnOkCwLFTwhzykhvtYzOWoBBbY//R3dbaNTYhf2RO' .
        'QpeuUMzv188MlwuHy0H13HnE48UzMcL0WAtUHX8OxZHoG1URiFw7rnLLCswuSPD1ulze/iWjT2PSf+dBXRFtVVGIvzqph0pQL7VE' .
        'avXYaXXxPwsnt0imdttCocMmZBdK7YU9D8wuNOW0nXc6QWzPsSa5naZ1beb9BbGB6dxGtMnXAAAAAElFTkSuQmCC';

        //==========================================================
        // mail.png
        //==========================================================
        $this->iBuiltinIcon[3][0] = 1122;
        $this->iBuiltinIcon[3][1] =
        'iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlz' .
        'AAALEAAACxABrSO9dQAAAAd0SU1FB9AJHAMfFvL9OU8AAAPfSURBVHictZRdaBRXFMd/987H7tbNx8aYtGCrEexDsOBDaKHFxirb' .
        'h0qhsiY0ykppKq1osI99C4H2WSiFFMHWUhXBrjRi0uCmtSEUGgP1QWqhWjGkoW7M1kTX3WRn5p4+TJJNGolQ6IXDnDtz+N0z/3PP' .
        'UWBIpdpYa23b9g09PZ2kUrOrvmUyGVKp1Ao/mUyi56YnVgWfO/P1CihAd/dJMpmaNROIRq8BkM1m0bH6TasC3j6QXgFdXI+DR6PR' .
        'JX/Pno8B+KLnMKqlpUU8z8MYs2RBEDzWf9J+0RcRbMdxGBsbw/fmCXwPMUEYID4iAVp8wIRmDIHMo4yHSIBSASKC+CWE0C/PF9jU' .
        '3B6Cp+4M07C5FUtKGNvGwQJctPgIsgD2wRhEIqAMGB+UQYkHJgYYZD7P1HwVlmWhHcfhyk83KeRGUW4t6CgoG5SNUS4KBWgQDUov' .
        '7AGlwYASBVqH0Bk49dXpCviVV3dw/tI1Bvr7kMIIlh0NYUpjlF0BAYvcxSXmEVLKceHSCJm+PnbueBHbtkNwTXUNBzo6aGpq4sSZ' .
        'GwT5H7BsF6Wdf1GWHQAoM0upeI9PT1yioS7B7tdaSdSuw7KsUGMAy7HYsmUztTW1nMwM0txssX1rlHjjS5jy/Uq2YkK/eJuLl6/z' .
        'x+1xkslW6mrixGIODx8EFSlEBC0+tmXT0NhA2763iEUjnLv4C8XpUbSbAB1mKkGJ3J83Od77HW5EszvZSqK2iljMIeJaRGNuJePF' .
        '6mspY7BJ1DXwQnCd2fxGRq5OUCz8xt72dyhMZcn++Cu3xu9SKhdp2b4ZHWnAtTSxmIWlhcIjlksR3lNBYzlxZsb7+f7ne+xtSzOd' .
        'u83szH1OnThOPp/n+a0beeP1l4mvq+PU2Qyd+5PY1RuwlAqLYFaBfbTbyPSdfgaH77A//QF4f1O/vpr6RJyq+C5Kc/M8FbFxXItY' .
        'xOHDrvfo/fxLDnbsJBp5BowBReVWYAzabeTh5ABDw7cWoNNL3YYYNtSv57lnn6Z+Qx01VeuIuBa2DV1HD3H63BAPZu4u1WGpeLHq' .
        'Rh7+NcjA0O+0p4+CNwXigwnbWlQQdpuEpli+n+PIkcOc//YKuckJJFh2K2anrjFw+QZt6S6kPImIF/b+cqAJD1LihWAxC61twBTo' .
        'fPcQF/oGsVW5ovHQlavs2/8+uYnRVSOUgHAmmAClBIOBwKC0gPjhIRgEIX2wg7NnwpZW3d3d4vs+vu8TBMGK51rvPM9b8hdteZxd' .
        'LBbVR8feJDs0Rlv6GFKeXJ21rNRXESxMPR+CBUl0nN7PjtO+dye7Up/8v1I88bf/ixT/AO1/hZsqW+C6AAAAAElFTkSuQmCC';

        //==========================================================
        // startconstrain.png
        //==========================================================
        $this->iBuiltinIcon[4][0] = 725;
        $this->iBuiltinIcon[4][1] =
        'iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlz' .
        'AAALDgAACw4BQL7hQQAAAAd0SU1FB9ALEREICJp5fBkAAAJSSURBVHic3dS9a1NRGMfx77kxtS+xqS9FG6p1ER3qVJpBQUUc3CRU' .
        'BwURVLB1EAuKIP0THJQiiNRJBK3iJl18AyeltRZa0bbaJMbUNmlNSm5e7s25j0NqpSSmyag/OMM9POdzDuflwn8djz8gClVRrVEV' .
        'ur4Bl1FTNSzLrSS6vbml0jUUwSXj8Qfk3PkLtLW2AeBIybmrgz3+gFzpucjlE4f4btuFTuWuCF5XDr3a3UPf6cM8GQvxzbsRAJdh' .
        'ScfxSywml5j7mVypN0eGEJ0tebIre+zxB6Tv7jPReS2hREpOvpmUXU+H5eC913JnNCSRVE60pUVbWoZjprR39Yq70bdqj4pW7PEH' .
        '5FpvL9e79jOTTHM7ssDL6CJZ08LbvAGnrpZg2mI2Z/MlZfN8IkxuSwu4V9+WIrj7zFlOHfXzKrLIi2SGh5ECKjnNVNxkQEc55vOw' .
        'rb6O8JLFdHyJ+ayFElUeHvjwkfteL/V7fKTSkFvIQE4DoLI2Mz/muTkTApcBKIwaN8pwIUrKw+ajWwDknAO0d/r4zFaMuRS63sWm' .
        'RoOdm+vRIriUYjKexrQV+t1o0YEVwfZSVJmD/dIABJuO0LG3lRFx0GOfiAELE9OgCrfU0XnIp5FwGLEy5WEAOxlR5uN+ARhP7GN3' .
        '5w7Gv4bQI2+xpt4jjv2nWBmIlcExE2vDAHYioszBZXw6CPE4ADoWVHmd/tuwlZR9eXYyoszBfpiNQqaAOU5+TXRN+DeeenADPT9b' .
        'EVgKVsutKPl0TGWGhwofoquaoKK4apsq/tH/e/kFwBMXLgAEKK4AAAAASUVORK5CYII=';

        //==========================================================
        // calc.png
        //==========================================================
        $this->iBuiltinIcon[5][0] = 589;
        $this->iBuiltinIcon[5][1] =
        'iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAA4AIwBbgMF12wAAAAlwSFlz' .
        'AAALEQAACxEBf2RfkQAAAAd0SU1FB9AHBxQeFsqn0wQAAAHKSURBVHicnZWff+RAGIef3U/gcOEgUAgUCgcLhYXCwsHBQeGgUDgs' .
        'FgMHB4VA/4Bg4XChWFgIFIqBwkJhsRAYeOGF+TQHmWSTTbKd9pU37/x45jvfTDITXEynAbdWKVQB0NazcVm0alcL4rJaRVzm+w/e' .
        '3iwAkzbYRcnnYgI04GCvsxxSPabYaEdt2Ra6D0atcvvvDmyrMWBX1zPq2ircP/Tk98DiJtjV/fim6ziOCL6dDHZNhxQ3arIMsox4' .
        'vejleL2Ay9+jaw6A+4OSICG2cacGKhsGxg+CxeqAQS0Y7BYJvowq7iGMOhXHEfzpvpQkA9bLKgOgWKt+4Lo1mM9hs9m17QNsJ70P' .
        'Fjc/O52joogoX8MZKiBiAFxd9Z1vcj9wfSpUlDRNMcYQxzFpmnJ0FPH8nDe1MQaWSz9woQpWSZKEojDkeaWoKAyr1tlu+s48wfVx' .
        'u7n5i7jthmGIiEGcT+36PP+gFeJrxWLhb0UA/lb4ggGs1T0rZs0zwM/ZjNfilcIY5tutPxgOW3F6dUX464LrKILLiw+A7WErrl+2' .
        'rABG1EL/BilZP8DjU2uR4U+2E49P1Z8QJmNXUzl24A9GBT0IruCfi86d9x+D12RGzt+pNAAAAABJRU5ErkJggg==';

        //==========================================================
        // mag.png
        //==========================================================
        $this->iBuiltinIcon[6][0] = 1415;
        $this->iBuiltinIcon[6][1] =
        'iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlz' .
        'AAALDAAACwwBP0AiyAAAAAd0SU1FB9ALDxEWDY6Ul+UAAAUESURBVHicdZVrbFRFGIafsyyF0nalV1R6WiggaAptlzsr1OgEogmC' .
        '0IgoBAsBgkIrBAPEhBj/AP6xRTCUFEwRI4jcgsitXMrFCJptJWvBNpXYbbXtbtttt6e7e86ec/yxadlCfZPJZDIz73zzzjfvR2VL' .
        'F7U+hf0HD2JduIzTFy6SlJRkPtkcDgdCCE65OxFC8NPV6wghyM7OptankJ2dzbSC5QghEEIgCSHog9PpNAF27dlN6miZuPgElB4/' .
        'nmY3O7ZtByA1NVUCkGWZweD1eklJScESTbqxuIjrd+/x6uIl5M19hSy7nfGOeUxf+g7VjU1sKi7C4/GYsiyz7tAJAD4/cRaA1tZW' .
        'AHIPnECUVGD1+/3U19ebG4uLeHf1akamjsIwoVnVCOvQEdLoVILYYmMo3PIxSBJflpSaDX5FAmju1QAYv/8k/s8+wLVxOU0jR2LZ' .
        '8sMFAApWrCApbRRDrRZirBYSLBKaoRPQw3SFernf2sav7T0Ubt4KwL4FMwF4Vu8FoHBCKgCzDhwHwLIhZ7y5a89u4m2JhA0wTdDC' .
        'OrphEjJMNElCHxKDEjaobmvlfo/Krj27CQQCJsCGJW8C0KXqAMxMiosQA8hZWcTFx9OsaniDKh1qmG7VoFsL0x0K06kbeAMhWpRe' .
        '/KpG+gwHAKUnz7Dz3BUMw6DK18nuw99wt0Nh6VdHI8RJicmETQgFg7SFwjSrGv+oKp6ghldV6dZ0ugJBlF6FmCESQ2w2AIqXLsan' .
        'BrFYLJTnTCBrdBqveeopWZiPFaBHUegJhegMqGgxEkHDwB/UaQ9rdIV06v0+TD2EEQjQFtAY0dsNgNvt5sialQAIIXh7wQKuVf6J' .
        'gTsSccPDWlQstClBGjr9eHpVWvUQncEwdYEedF8noQ4vmYmpZMTH0nTvDn25vLbrNmu7bvfnsYEbAMnhcPDgwQPzUo2LJusw/mhp' .
        'QwlHNO0KBAnoIfxtrcQMT2De1Mm891wyUzNlUlJSpIyMDBobGzlzr5rFM/Koq6vrP8ASGxsLwPmKcvIShjPGZiPOakE3VFB8hHwd' .
        'vJAxhrk5L7Ly+RQuH/sWgPdXrwFg/6HDFBUsIj09nehfbAWwPWOT9n5RYhqGwarNWxkRM5TRCfF4U1PQsDDJFk9uYhwXvzvKjm3b' .
        'KSsro3DJInNW5RXp7u2bAKSlpeH1esnPz6eqqgqLpmmcr3Fht9ulfaV7mZk1Bs+lM6T1djM9fhg5egDPpTNMy5TZsW07kydPYdWM' .
        'aXx96ixOp9O8cfUa80srmDpjOgAulytiQqZpMnvObLbt/JTtHxXj9/tRVdU0DGOAufRpevPDTeac0hJyc3NxOOawfv161lVWS6eX' .
        'z+9/UOCxu1VWVvaTRGv16NFfjB2bNeAQp9NpTpmSM4DcbrdL0WsGDKLRR+52uwe1yP8jb2lpYfikyY9t80n03UCWZeaXVjw1f+zs' .
        'Oen+/d+pqanhzp2fKSsrw+l0mi6XiyPl5ZGITdN8fAVJwjRNJEmi1qfw1kw7siyTnJxMe3s71dXV3GpoZO64DG41NPJylvxU5D/e' .
        'qJKsfWQD9IkaZ2RmUvr9aV4aGYcQgjfO3aWoYBF5eXm4ewIsu/CbdPz1aWb0/p1bNoOrQxlUiuiaFo3c3FyEEOx9+C9CCD6paaTW' .
        'p/TXyYkTJ0Xe59jf7QOyAKDWp/QXxcFQ61P4pT3ShBBcvnUHIQTjxmX19/8BCeVg+/GPpskAAAAASUVORK5CYII=';

        //==========================================================
        // lock.png
        //==========================================================
        $this->iBuiltinIcon[7][0] = 963;
        $this->iBuiltinIcon[7][1] =
        'iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAAAAAAAA+UO7fwAAAAlwSFlz' .
        'AAALCwAACwsBbQSEtwAAAAd0SU1FB9AKAw0XDmwMOwIAAANASURBVHic7ZXfS1t3GMY/3+PprI7aisvo2YU6h6ATA8JW4rrlsF4U' .
        'qiAsF9mhl0N2cYTRy9G/wptAYWPD9iJtRy5asDe7cYFmyjaXOLaMImOrmkRrjL9yTmIS3120JybWQgfb3R74wuc8Lzw858vLOUpE' .
        'OK6pqSm2trbY39+nu7tbPHYch7m5OcLhMIA67kWj0aMQEWk6tm17rNm2LSIie3t7ksvlJJ1OSyqVkls3Z8SyLMnlcqTTaVKpFLdu' .
        'zmBZVj1HeY2VUti2TSQSQSml2bZdi0QirK2tMT09zerqKtlslqGhISYnJ4nHv2N+foFsNquOe9FotLlxOBwmk8lgWRbhcFgymYxY' .
        'liUi0mqaJoAuIi2macrdO7fFsizx3to0Te7euV1vrXtXEgqFmJmZYWVlhXK5LB4/U9kwDL784kYV0A3DYHd3m4sXRymXywKoRi8U' .
        'Ch01DgQCJBIJLMsiEAhIIpHw2uLz+eqtYrEYIqKZpimxWEyCwaCMjY01zYPBIJpXqVQqsby8TLVabWKA/v5+RkZGMAyDrq4ulFKH' .
        'HsfjcWZnZ+ns7KTRqwcnk0mKxSKFQqGJlVKtruuSTCYB6O3trW9UI/v9/iZPB/j8s2HOnX0FgHfeXpeffnzK+fWf+fijvhLs0PtG' .
        'D/n1OJ9+MsrlSwb3733DwMCAt1EyPj6uACYmJp56168NU6nUqFSE9nZdPE7+WqC/r4NKTagcCJVqDaUUB5VDAA4Pa9x7sMLlSwan' .
        'WjRmv13D7/erpaWlo604qOp88OF7LC48rPNosMq5Th+Dgxd4/XyA1rbzADi7j8jnf2P++wdcvSr8MJ/i8eomAKlUqn41OsDAQDeD' .
        'g++yuPCwzm/2vU8+n2a7sMFfj79mp7BBuVzioFSiXHJx3SKuW2Rzy0Up9dxnQVvODALQerqNRn4ZKe0Mvtc6TpzpmqbxalcY9Ato' .
        '2v06t515C73YQftZB9GLnDrt4LoujuPgOA4Ui+C6yOpXJwZrJ7r/gv4P/u+D9W7fLxTz+1ScQxrZ3atRLaVxdjbY2d184R6/sLHe' .
        'opHP7/Do90Ua+WWUyezzZHObP/7cfX54/dowE1d66s8TV3oE+Mfn+L/zb4XmHPjRG9YjAAAAAElFTkSuQmCC';

        //==========================================================
        // stop.png
        //==========================================================
        $this->iBuiltinIcon[8][0] = 889;
        $this->iBuiltinIcon[8][1] =
        'iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAAAAAAAA+UO7fwAAAAlwSFlz' .
        'AAALDwAACw8BkvkDpQAAAAd0SU1FB9AJDwEvNyD6M/0AAAL2SURBVHic1ZTLaxVnGIefb2bO5OScHJN4oWrFNqcUJYoUEgU3/Qf6' .
        'F7gwCkIrvdBLUtqqiLhSg9bgBduFSHZdiG5ctkJ3xRDbUFwUmghNzBDanPGMkzOX79LFJGPMOSd204U/+Bbzvd/78F4H/ieJdoad' .
        'pZKxRFszAI/DcP0HazXY22v+HB01kee1PA/v3zfnjx4xgGnHcNZe7OvuNj+cOEF1ZATv5nUA4jhBSgmADCVWo8Ge2Of9wb18P/G7' .
        'oUXmYi30zqlTVEdGWLh1g2D6MYlKkXGE0Vl8aa2GEB149+4xXSzyoOIw/mimiZV/DPb25pFOj13A9gOMEChhUEqhVYqWKUk9QAUp' .
        'sT/P4s8PmKlUmNhQaIJbkDVqBbpw6wZ2zUc4Nm+ePku5p4eOrgpueQOFUoVCVxcD4+N07dpF9+5tVJeWGPBjhvr7WF1zC8ASgtcP' .
        'H8a7eZ1odh4sh50nzwCw9ZNh3M4Stutiu0X2nB/LyjZ6lcIbVTpdQU/jWVPzLADM8+ZGBRdtC7wrF/O7bR99iu26VL86iU4SAH4b' .
        'Po5d6AQhstMSvGyI4wS5FJBKSRwnzF8byx/u+PjzzMF1mfryQ1K/jnCahqp1xEopjFLoNEFJSRJHzF799gWHqa+/QKcSUXBI609f' .
        'Al5W4teQSiHDOipNUKnMI13RvnOXAIEKQixvGWya98SC560MFwPiqEG86JM8q79Q06lvhnOndy5/B6GPCUOMUu3BQgg8z0M3GmBZ' .
        'iGJn3v2VmsqnfzNx7FDueODuj8ROCFpjtG5TCmOYv32bJ09msP0ISydMfnAUgF8/O45RAA6WTPjlvXcB+Gn7FuRf/zAnNX6x3ARe' .
        'PSdmqL+P/YHkwMGDOGWDZTlQcNBRhPEComgB/YeHfq2InF1kLlXUOkpMbio1bd7aATRD/X0M1lPeSlM2vt2X1XBZjZnpLG2tmZO6' .
        'LbQVOIcP+HG2UauH3xgwBqOz9Cc3l1tC24Fz+MvUDroeGNb5if9H/1dM/wLPCYMw9fryKgAAAABJRU5ErkJggg==';

        //==========================================================
        // error.png
        //==========================================================
        $this->iBuiltinIcon[9][0] = 541;
        $this->iBuiltinIcon[9][1] =
        'iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAC7IEhfAAAAaVBMVEX//////2Xy8mLl5V/Z2VvMzFi/v1WyslKlpU+ZmUyMjEh/' .
        'f0VyckJlZT9YWDxMTDjAwMDy8sLl5bnY2K/MzKW/v5yyspKlpYiYmH+MjHY/PzV/f2xycmJlZVlZWU9MTEXY2Ms/PzwyMjLFTjea' .
        'AAAAAXRSTlMAQObYZgAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxIAAAsSAdLdfvwAAAAHdElNRQfTCAkUMSj9wWSOAAABLUlEQVR4' .
        '2s2U3ZKCMAxGjfzJanFAXFkUle/9H9JUKA1gKTN7Yy6YMjl+kNPK5rlZVSuxf1ZRnlZxFYAm93NnIKvR+MEHUgqBXx93wZGIUrSe' .
        'h+ctEgbpiMo3iQ4kioHCGxir/ZYUbr7AgPXs9bX0BCYM8vN/cPe8oQYzom3tVsSBMVHEoOJ5dm5F1RsIe9CtqGgRacCAkUvRtevT' .
        'e2pd6vOWF+gCuc/brcuhyARakBU9FgK5bUBWdHEH8tHpDsZnRTZQGzdLVvQ3CzyYZiTAmSIODEwzFCAdJopuvbpeZDisJ4pKEcjD' .
        'ijWPJhU1MjCo9dkYfiUVjQNTDKY6CVbR6A0niUSZjRwFanR0l9i/TyvGnFdqwStq5axMfDbyBksld/FUumvxS/Bd9VyJvQDWiiMx' .
        'iOsCHgAAAABJRU5ErkJggg==';

        //==========================================================
        // openfolder.png
        //==========================================================
        $this->iBuiltinIcon[10][0] = 2040;
        $this->iBuiltinIcon[10][1] =
        'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEANAAtwClFht71AAAAAlwSFlz' .
        'AAALEAAACxABrSO9dQAAAAd0SU1FB9AKDQ4RIXMeaLcAAAd1SURBVHicxZd7jBXVHcc/58zcvTNzH8vusqw8FsTsKiCUUh5WBZXG' .
        'GkOptmqwNWsWLKXFGlEpzZI0AWNKSy0WhDS22gJKtWlTsSRqzYIuLGB2WVvDIwQMZQMsy2OFfdzde+/OnHP6x907vJaFpjb9JZM5' .
        'c85Mfp/f9/s7Jxn4P4e41gtSyp78WGvtfdEAcqDFYUOH9HS0NhGk9tPb/ilSyp789UUB2AMuqhQy3Uzm7HGkE6W3dTNZMRI3EcWO' .
        'jf9ClLmWBT3dzW8jUsevWHCG3UpWl+IkHSxnbDh/Mcz12NevBcuWXTmf6TjnXvJ88gDmVB3pw3+nt3UzHa1NqMzBS2zqPLGFjtMN' .
        'ZNr3XdW+qyqwZcFk76HX/tHWfuQvyO4W7qhaHwL8efkMRlRUpPv7rqD0RrJ+FgAjLy1a20OIxZJEEuNCRfIApj+om4bGM3u2/sYU' .
        '9J41d8973f3Dhg1pISTV1dXXBRNJxPGFCzhou+DCQrScZOkktNaeDZjamgeZ9MgiYmVDccvHhjAzJw0NTh8/alyZMaVJicp0iTHj' .
        'JpgNv38tjWUhhGROdbUL9W5/MH5XCkjlcibi+KIop5LVHLKEu8A/f4r286doa9pGrGwYAAsfqbbH3b8MgO/Nqgy6WvdbbXHMkEFJ' .
        '4xUOMVEvaTZu3BgmvF4Yk4hz9rO/Ulr5cE9owae/rcGxohSOuiWkC2IjcIqKyPZm+OmCH7GhoZEF077EEzVVweAbJ+riEeO0Ey8y' .
        'UubqOHn0AOgMwvf59txnBrSp9dgxKmf/+kIP1NY8SFk0jh5ajmNHAWg5b2E5EexojGHjbiVRMoRMNs0LC+Yz46vTuH3enN7BI8fr' .
        'qFdo0BoVZNC9aVSQ4fNjBzEmQJiARxb+/AqYPMAVB5FsPU5v37g9OxgLhe14ZM5/ju052E6MNZvf5pmHHuLmmWOkEysxUtpGAtme' .
        'dtHTflJkezqQto3jFRnLssyf1jydxiiM7zNnye/c3ZsqLu2BN5fcMfzrv/hby1tPzmRUoihcTJ87CwQI2yLtDcIqsIjYUf51qBlf' .
        'OnScOSrdQUOMURkiXsLUzJnvbGhoBGDHH5cGyZLhOpYoNl5hqYnYEXOu5fDl9eYAHntx98n8hFHZcPHUuTSxSASAeK/CGIOxJJ0f' .
        'bOGNPU280dgkq6Y2yu8vfjCIlwwzr+/ZQ/PHO0gOLuO5qsftDQ2NbN+4OCgqG6WTxWVaq6zpF+DiSHWnicdylp3r6aZTWthIOrNp' .
        'ktHcvBu0sHX1Sm6ozB3B42d90zZA9bQp7PvgPSzXZfnqX/HS4DKKK2+x69Y/HURs26iBAN5ccsfw7774UcumF37C6f07KSt2OHji' .
        'DEUJD0tISjyPrrSPlAKvN0JP/U4O1NfjuhG2rvklN1SOpfXwftpbTqAyKRrff5fb7rs9V1R7m4wlz2ihA3HpmXflUWyOH2umpLiY' .
        'ui3v8M+6bWzfsRNbSgqkxaCkiy0simMuEWEhpcRzIhQWOIAh6tiAwS4owInFiTou5dOnMnl2NR++ujBwXEc9terD6M43nrj6LgAB' .
        'QnDPA9/irtkP8JRS7Hr/3T6YekDQ1pEiEXOwpUVJzCVlZZFS4mZtkpEo9ChAkDp/jtLMBACy6S4RiQghLyv5cgBRPnKUOX6smUGF' .
        'hSil0MYw9d77mPy1e5mnFE3batm3czvb6nYgEJztSFGU9LCRlMRdUjIH0+lnEMIwPNXD3NumoVJnrMCJaiciMUZfvQnz4QcBSvV1' .
        'vjE5GK358t0zmXDnDB79saLpo20c+aSRD+t25JTp7GZQwsEWFiVxl6hlUf/WO9z32CxmL1rOe6u/I2KuwGhzLQCB7/sYY9Bah3el' .
        'FKbvrrVm4vS7GH/7ncx+chEHGz7myCeNbPtoO0JI2jq78WIRLGkzsqs7V5SfFV5EovXACoiqqsfNpk2vo5VCWtYFBfoU0VoTBAFa' .
        'a7TRaK2p+MoURk+cxMzq+Rzbv49DDbuo27UTW9h0dedssPxuK+kIfN8XxhgDYPVXf2Fh4XKtFIl4AiklAlBKAYRKKK36wHIweTCt' .
        'NfHiEkaOn8j0+7/BmDFjaT30GbHywSxcuZkpFfFg+m1jjZ/NmnVvNfRvwd69e8WBA/uNFAIh4JVXXmHsmDHE4vEQQgjQ2lxQIm9N' .
        'nz35q3BEOZOHzaG2thaA4mRU+L29It+IV21CpbRQfeMFC35gRB/M2rVrubnyZmLxWJhECBEmz/eHyo/7lMlH3LFFujsthNFCCGOu' .
        '+WNyeUgpjSVzMKtWraKyshLPdcPEeYWCIEBdpIxSivr6eta8vI7d6+cGnhdV06pe1QP+F/QXWmuRL+jZZ58LlVmxYgUVFRV4rhtu' .
        '4TzMxXAA6XRaRAtsYUkx8I/JtSJQOlSwpmZpCLN8+fPcdNNoHMfB9/0QJgRoP295TlR7UVv8xxZcHMuWIZ9/Hn35vG3JEGZpzVJG' .
        'jx5N1IlitKahsZE1L69j69qHgx+urFX/lQL9JYdLlfnZihUhzOLFi8N3Ml1dthOxVH/f/8/CtqSJ2JaJ2JZ59J7RPsC/AViJsQS/' .
        'dBntAAAAAElFTkSuQmCC';

        //==========================================================
        // folder.png
        //==========================================================
        $this->iBuiltinIcon[11][0] = 1824;
        $this->iBuiltinIcon[11][1] =
        'iVBORw0KGgoAAAANSUhEUgAAACIAAAAiCAYAAAA6RwvCAAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAAAAAAAA+UO7fwAAAAlwSFlz' .
        'AAALEAAACxABrSO9dQAAAAd0SU1FB9ECAQgFFyd9cRUAAAadSURBVHiczdhvbBP3Hcfx9/2xfefEOA5JoCNNnIT8AdtZmYBETJsI' .
        '6+jQOlQihT1AYgytqzZpD1atfyYqlT1h0lRpT7aRJ4NQpRvZGELVuo5Ua9jEJDIETQsNQyPBsUJMWGPnj//e+e72wNg4xElMR6ed' .
        'ZNln3933dZ/f93f6yfB/sgmrHdDV1WXlPg8NDZUDScD8LFFFEZZlWYZhWMFg0Orq6sq/gDJAfFy1iiZy9OjrVnj4JzQ1rMWqfxm/' .
        '309jYyNtbW0kEgnu3bvH4cOH88c/jqSKQl4/XGkd+eVtAN46up1LH92ktqYS++ZX8Pv9NDQ0sGnTJlKpFOFwmO7u7vy5IyMjeVRd' .
        'XV1+WEOh0IrY4pDnq6wXX/sTiCJaMkFZdRNqxefoe7VtCSqXVDqdZnZ2ltraWkzTpKqqijt3JpFlG7dvj7NzZ1f++qFQyA3EClHL' .
        'Ql743nFkhxPDtJAd5eTaYSVUfX09lZWVlJWVIUnSg7sVQMBCUcu4ceMGe/bsIRQK1QAzOcyykIM9P0KyudAyCWyqG8nhwqa4SkLt' .
        '3r0bVVVxu924XC40TUOWZUQxe97CwgIdHR2LMHIxSCaVInVvFElxE0vMY1Pd2NUKJMWNTXHlUfF//4vETJCelwbpFm3MjP2dt37x' .
        'AlN+PzU1NViWRSwW4+7du3g8HjweD4qi5EFAJzAExIpCANbooxhplfB0FJvTg6xWIqsVRVF6MopkU3FXPcnkJxGU0VEAdF2noqKC' .
        'W3/8DpnqLjzep2lubsblcjE8PExHR8fboVDID9xYFpLBDpJF0jDQIncQpWlkm31FlFLtp9PfyuW/vYQj1kPSuRW/38+lj27S2Q7v' .
        '/aWXUBVUffVNtm3blivVCEwsC5Eyc5iiApEpDEAXMqQdldhSiWVQHjJagud+8Fuexck/zv+K82dfoSbSCsDe75/km+4GVPd6+l5t' .
        '4zJHcqVUYN2yEEtZQDCSJCueRAYsPY49HsFIZVG6p25JUumFafT4DKJN4amtT7Nz38sk5+5A70HMtEYyMkFiZhxzjQ/poXrLQrRU' .
        'DFGEeFpAlkQkm4pRiCpIKodKzk0T/2QMh+piPjxKZPwiSkUtu/b9mNnJEWS7E8nhAmvpM60oJDkXJxqNozxRRUxPIesispBBlsXV' .
        'UaKEFo8gzoaJhz8s2lOmrpUG+WBhJ9/60g+Z+fDXTAXfxllRjl1VkO0OFATsYhYliiK21ZKKhhHnFveUqSdKgwAEOp7F2v51vvw8' .
        'XH7/N1wd/BlTweuUV65BdtgfoLTSkipsdD3tRi0VYpommUwGwzDwdT5HYEc3giAwcvH3jLz3BlPB67jWeZBEKYsSBWwpHZtNKo4q' .
        'aHTDsJeeiGEYWJaFZVmYpommaRiGQdPnv0bb1m8gSRL/vPIOV979aR4lmAJ2p4qCgCxksNuKJ6VNpx4NYhgGpmkuQhmGQTqdxjAM' .
        'qr2d7HtxEEEQuH1tkKvvvkF44tqDnrIcKJKAPf1g+LAUElq8dIiu60sApmnm93Pfzc7OYhgGrie+wFe++ztcLhcT1wf54PzPCU9c' .
        'w7XWjWS3IdsdOAUBWZAxrRJnTQ6SG5bce2FCpmkughmGQSqVYm5uDtnj44sH38TtdhP6+Dwf//V4ttHXrkGURZJaic8RgHQ6jWma' .
        'SJKUL5RLKNfIOczDKF3XSSaTRCIRhLJWntp3nGfWrSMxc5OLf3iNP4+68T9Ub9nF76lTpxgfHycajZJKpdA0LZ9GbjYV7hcDWZaF' .
        'pmnMz88Ti8UYunSLmu1HFi2aVkxkaGjINTY2ttDb24vX6+XQoUNs3ryZ8vJyIDu1BUFYkkxhgxeiWlpaOHPmDE1NTdTX1xe98eWG' .
        'JnF/9dQZCoXUYDA4AOD1ejlw4ACtra2Ul5fniwmCkEcUJiUIAoFAgL6+Pnw+H21tbfT39z8SxCS7hHsfWH9/8dL4MKqnp4eWlhac' .
        'TmcekEvMNE2am5s5ceIEgUCA9vZ2Tp48ic/nY3j4UsmQHCYOjJHtpeBKqL1799Lc3IzT6UTXdRobGxkYGKC9vZ3W1tZ8Ko86NJ8a' .
        'tXHjRo4dO8bp06fZsmULGzZsoL+/n0AggNfr5ezZs/8VpGTU5OSkc//+/acBfD4f1dXV7Nq1i4aGBs6dO4fP5+Pq1SuPBbIiyjTN' .
        'RUnV1dUNXLhwAa/Xy44dO4jFYgBEo9FFF1r134BPuYlk16LrAYXsAlmtq6sbKDwoFAp9m+ykuP5ZQVZF3f8tCdwCov8LyHIoAANI' .
        'AXf/A1TI0XCDh7OWAAAAAElFTkSuQmCC';

        //==========================================================
        // file_important.png
        //==========================================================
        $this->iBuiltinIcon[12][0] = 1785;
        $this->iBuiltinIcon[12][1] =
        'iVBORw0KGgoAAAANSUhEUgAAACIAAAAiCAYAAAA6RwvCAAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAAAAAAAA+UO7fwAAAAlwSFlz' .
        'AAALDwAACw8BkvkDpQAAAAd0SU1FB9ECDAcjDeD3lKsAAAZ2SURBVHicrZhPaFzHHcc/897s7lutJCsr2VHsOHWMk0MPbsBUrcnF' .
        'OFRdSo6FNhdB6SGHlpDmYtJCDyoxyKe6EBxKQkt7KKL0T6ABo0NbciqigtC6PhWKI2NFqqxdSd7V2/dmftPDvPd212t55dCBYfbN' .
        'zpvfZ77z+/1mdhUjytWrV93Hf/24eD5z9gwiMlDjOKbb7dLtdhER2u02u7u73Lp1CxEZBw4AeZwdNQqkMd9wbziFGINJUt6rRbz5' .
        '1ptUq1XK5TJBEAAUMHt7e+zu7gKwvLzMysoKwAng/uNg9CgQgFKlgg1DUJ67Vqtx6tQpZmdniaIIpRTOOZRSdDoddnZ2aLfbLC8v' .
        's7S0xJUrV7ZGwQSj1PhhfRodVdDlMrpc5vup5Z2fvMPdu3fZ29vDWjvwztjYGPV6nVqtRqVS4dKlSywtLQFsAdOH2XwsCEApg3jl' .
        'w98Rak2gvYjNZpNms0mSJDjnHgkDMDc3dySYQ0Ea8w139YUX0OUKulzyg7UmCEO+l1huvHuDra0t9vf3h1TJYSqVypFhHquIrlQI' .
        'S5qv/uIDAC7/4bcEQYAKvK+0Wq1DVQGIoog7d+4cCeaRII35hrt+8SsEOkRlUaEyR0UpFIrXHxyMVKVUKnHv3r0jwRwaNelBjBjL' .
        'Sz/7KYuLiwAsLi7y4z/9kY9e+TpkCuSqjI+Po7XuAWeKXLt2DWNMUZMkwRjDhQsXWFtbK6JpCCT3jfQgxomPtPX19YHWicM5x3c2' .
        '73Pj3Ru8/aO3mZqaolKpoHVvyuvXr/Ppnf/Q7uzz380NPtu4y/qnG+ztd1hfX2dtbQ3gIvDnRyqSxl1UoPjyz98D4PTp0wPtq39Z' .
        '4fdzLxegrVaLVqvF5OQkYRgWqpRKJZ77wvNsbW1RG5tgfKLOTH2G7Z1twqBQrgrMDvhInjfSOCY5iIv+hYWFgRZArEWsZWF941Bf' .
        'SdMUgMnJCWpjVU4cn+HUyePM1Gc4+fRUPkzBI5w1jbukcczLv/5l0XfmzJmBFuCba38r/CRXpT+CrDUoZ0jjB4RYonJAOYRobJKT' .
        'z5zgqfqxAbsFSH6mpHFM2qdGXh4VnoViD6mSJF2cTQeqDqBaKVHWmonJCWpZjhkC6anR5WsffTgwaHV1FaUUq6urA/2v3f5k4LnV' .
        'arG9tUn3oI2YBCcWHYAxMVYs1qZEZY2SFB2aYZDGfMN9d7uJiWPSeFiNo5Rclc3NTXZbO6RpF7EJVixYA9agwwDnUiqlEPdQ3imi' .
        'Jo27BGHIt/7x9yEjc3Nzh27Na7c/4TdffKl4bja3ae5MUIu0T/HOEIaOpJt4gwoSsVTK4SBIY77hFtY3ABBjBiZ90rKwvsH77/+K' .
        't37wOhO1iPpTk4SBw1mLsz6CnKQ4l3qV+kE+t9XHlNZOk+bUJLVIE1VCcIJWQmJ6qjj30NbcXLkZMt8YPig+Z3n1G5fZ39/j/vY2' .
        '9ckqZT2Ochbn0p4qNkU/dDfUADdXbh4HXgRO4zNdEU0XL1784PLly5w9e7Z4SazFOfGrEotDcOKrcoJPmrYIXf/Zop3QNd1skuGt' .
        'cUAb2MgAxvHZTgFUq1Wmp6eZnZ0F8JlTjDduDThBnDeECEoJtbGIp6enqEblzCcEZ1PECU4yVRiOGgd0gc+AB0CZvkv1sWPHOHfu' .
        'HOfPn8da41cpkkltEBEPJhYnBkTQJcdYVKGkgRxCfBsq5xXNgAa2Bn+hjTOgHEKBP8pzRUxykIH4ifLJRTJAl+UMBJzPHQ6bfe/f' .
        'cWIzPxlUpD+zugzIZtVk1d8znBAqRxgoQuVQgSJQ3h9C5QhDRYgjUILCAzlnEdsHYTKfMTEBcP7F54YUGVmc2GLlIn6ve6v0ahSt' .
        '8X25TzjJ+rIx1grKpQPWR4LkGVVsMgghvS0qjPdvm5OeceOTWA5Evo2mFzkjQfL7hZPUy5yvvF/uPFQL3+nbDmsLCEmT3sTmCTNr' .
        'rogT6yFsOix3ftw7OwQhkvSU6CuinhCk0+kAkFoBazEEICHaHHiPVmU0gnUp4EAc1mYrF0EBVpwPi34VrBkwPxKk3W5ju/e5/c+d' .
        'bGUHIAIuydTIE5zfc5Wr4lJcahHnHTP3CVGm78DrgY38N+DEibp7dmYKdAQmBh1hjEFjis+9CTWYGK21H6PxPyOI0DobYwzZF/z7' .
        '7jadTvJtYG0kCD7lfwl49ijgT1gc0AH+dZSJA/xB+Mz/GSIvFoj/B7H1mAd8CO/zAAAAAElFTkSuQmCC';

        $this->iLen = count($this->iBuiltinIcon);
    }
}

//===================================================
// Global cache for builtin images
//===================================================
$_gPredefIcons = new PredefIcons();

//===================================================
// CLASS IconImage
// Description: Holds properties for an icon image
//===================================================
class IconImage
{
    private $iGDImage = null;
    private $iWidth, $iHeight;
    private $ixalign = 'left', $iyalign = 'center';
    private $iScale = 1.0;

    public function __construct($aIcon, $aScale = 1)
    {
        global $_gPredefIcons;
        if (is_string($aIcon)) {
            $this->iGDImage = Graph::LoadBkgImage('', $aIcon);
        } elseif (is_integer($aIcon)) {
            // Builtin image
            $this->iGDImage = $_gPredefIcons->GetImg($aIcon);
        } else {
            JpGraphError::RaiseL(6011);
            //('Argument to IconImage must be string or integer');
        }
        $this->iScale = $aScale;
        $this->iWidth = Image::GetWidth($this->iGDImage);
        $this->iHeight = Image::GetHeight($this->iGDImage);
    }

    public function GetWidth()
    {
        return round($this->iScale * $this->iWidth);
    }

    public function GetHeight()
    {
        return round($this->iScale * $this->iHeight);
    }

    public function SetAlign($aX = 'left', $aY = 'center')
    {
        $this->ixalign = $aX;
        $this->iyalign = $aY;
    }

    public function Stroke($aImg, $x, $y)
    {

        if ($this->ixalign == 'right') {
            $x -= $this->iWidth;
        } elseif ($this->ixalign == 'center') {
            $x -= round($this->iWidth / 2 * $this->iScale);
        }

        if ($this->iyalign == 'bottom') {
            $y -= $this->iHeight;
        } elseif ($this->iyalign == 'center') {
            $y -= round($this->iHeight / 2 * $this->iScale);
        }

        $aImg->Copy($this->iGDImage,
            $x, $y, 0, 0,
            round($this->iWidth * $this->iScale), round($this->iHeight * $this->iScale),
            $this->iWidth, $this->iHeight);
    }
}

//===================================================
// CLASS HeaderProperty
// Description: Data encapsulating class to hold property
// for each type of the scale headers
//===================================================
class HeaderProperty
{
    public $grid;
    public $iShowLabels = true, $iShowGrid = true;
    public $iTitleVertMargin = 3, $iFFamily = FF_FONT0, $iFStyle = FS_NORMAL, $iFSize = 8;
    public $iStyle = 0;
    public $iFrameColor = "black", $iFrameWeight = 1;
    public $iBackgroundColor = "white";
    public $iWeekendBackgroundColor = "lightgray", $iSundayTextColor = "red"; // these are only used with day scale
    public $iTextColor = "black";
    public $iLabelFormStr = "%d";
    public $iIntervall = 1;

    //---------------
    // CONSTRUCTOR
    public function __construct()
    {
        $this->grid = new LineProperty();
    }

    //---------------
    // PUBLIC METHODS
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

    public function SetFont($aFFamily, $aFStyle = FS_NORMAL, $aFSize = 10)
    {
        $this->iFFamily = $aFFamily;
        $this->iFStyle = $aFStyle;
        $this->iFSize = $aFSize;
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

//===================================================
// CLASS GanttConstraint
// Just a structure to store all the values for a constraint
//===================================================
class GanttConstraint
{
    public $iConstrainRow;
    public $iConstrainType;
    public $iConstrainColor;
    public $iConstrainArrowSize;
    public $iConstrainArrowType;

    //---------------
    // CONSTRUCTOR
    public function __construct($aRow, $aType, $aColor, $aArrowSize, $aArrowType)
    {
        $this->iConstrainType = $aType;
        $this->iConstrainRow = $aRow;
        $this->iConstrainColor = $aColor;
        $this->iConstrainArrowSize = $aArrowSize;
        $this->iConstrainArrowType = $aArrowType;
    }
}

//===================================================
// CLASS Progress
// Holds parameters for the progress indicator
// displyed within a bar
//===================================================
class Progress
{
    public $iProgress = -1;
    public $iPattern = GANTT_SOLID;
    public $iColor = "black", $iFillColor = 'black';
    public $iDensity = 98, $iHeight = 0.65;

    public function Set($aProg)
    {
        if ($aProg < 0.0 || $aProg > 1.0) {
            JpGraphError::RaiseL(6027);
            //("Progress value must in range [0, 1]");
        }
        $this->iProgress = $aProg;
    }

    public function SetPattern($aPattern, $aColor = "blue", $aDensity = 98)
    {
        $this->iPattern = $aPattern;
        $this->iColor = $aColor;
        $this->iDensity = $aDensity;
    }

    public function SetFillColor($aColor)
    {
        $this->iFillColor = $aColor;
    }

    public function SetHeight($aHeight)
    {
        $this->iHeight = $aHeight;
    }
}

define('GANTT_HGRID1', 0);
define('GANTT_HGRID2', 1);

//===================================================
// CLASS HorizontalGridLine
// Responsible for drawinf horizontal gridlines and filled alternatibg rows
//===================================================
class HorizontalGridLine
{
    private $iGraph = null;
    private $iRowColor1 = '', $iRowColor2 = '';
    private $iShow = false;
    private $line = null;
    private $iStart = 0; // 0=from left margin, 1=just along header

    public function __construct()
    {
        $this->line = new LineProperty();
        $this->line->SetColor('gray@0.4');
        $this->line->SetStyle('dashed');
    }

    public function Show($aShow = true)
    {
        $this->iShow = $aShow;
    }

    public function SetRowFillColor($aColor1, $aColor2 = '')
    {
        $this->iRowColor1 = $aColor1;
        $this->iRowColor2 = $aColor2;
    }

    public function SetStart($aStart)
    {
        $this->iStart = $aStart;
    }

    public function Stroke($aImg, $aScale)
    {

        if (!$this->iShow) {
            return;
        }

        // Get horizontal width of line
        /*
        $limst = $aScale->iStartDate;
        $limen = $aScale->iEndDate;
        $xt = round($aScale->TranslateDate($aScale->iStartDate));
        $xb = round($aScale->TranslateDate($limen));
         */

        if ($this->iStart === 0) {
            $xt = $aImg->left_margin - 1;
        } else {
            $xt = round($aScale->TranslateDate($aScale->iStartDate)) + 1;
        }

        $xb = $aImg->width - $aImg->right_margin;

        $yt = round($aScale->TranslateVertPos(0));
        $yb = round($aScale->TranslateVertPos(1));
        $height = $yb - $yt;

        // Loop around for all lines in the chart
        for ($i = 0; $i < $aScale->iVertLines; ++$i) {
            $yb = $yt - $height;
            $this->line->Stroke($aImg, $xt, $yb, $xb, $yb);
            if ($this->iRowColor1 !== '') {
                if ($i % 2 == 0) {
                    $aImg->PushColor($this->iRowColor1);
                    $aImg->FilledRectangle($xt, $yt, $xb, $yb);
                    $aImg->PopColor();
                } elseif ($this->iRowColor2 !== '') {
                    $aImg->PushColor($this->iRowColor2);
                    $aImg->FilledRectangle($xt, $yt, $xb, $yb);
                    $aImg->PopColor();
                }
            }
            $yt = round($aScale->TranslateVertPos($i + 1));
        }
        $yb = $yt - $height;
        $this->line->Stroke($aImg, $xt, $yb, $xb, $yb);
    }
}

//===================================================
// CLASS LinkArrow
// Handles the drawing of a an arrow
//===================================================
class LinkArrow
{
    private $ix, $iy;
    private $isizespec = array(
        array(2, 3), array(3, 5), array(3, 8), array(6, 15), array(8, 22));
    private $iDirection = ARROW_DOWN, $iType = ARROWT_SOLID, $iSize = ARROW_S2;
    private $iColor = 'black';

    public function __construct($x, $y, $aDirection, $aType = ARROWT_SOLID, $aSize = ARROW_S2)
    {
        $this->iDirection = $aDirection;
        $this->iType = $aType;
        $this->iSize = $aSize;
        $this->ix = $x;
        $this->iy = $y;
    }

    public function SetColor($aColor)
    {
        $this->iColor = $aColor;
    }

    public function SetSize($aSize)
    {
        $this->iSize = $aSize;
    }

    public function SetType($aType)
    {
        $this->iType = $aType;
    }

    public function Stroke($aImg)
    {
        list($dx, $dy) = $this->isizespec[$this->iSize];
        $x = $this->ix;
        $y = $this->iy;
        switch ($this->iDirection) {
            case ARROW_DOWN:
                $c = array($x, $y, $x - $dx, $y - $dy, $x + $dx, $y - $dy, $x, $y);
                break;
            case ARROW_UP:
                $c = array($x, $y, $x - $dx, $y + $dy, $x + $dx, $y + $dy, $x, $y);
                break;
            case ARROW_LEFT:
                $c = array($x, $y, $x + $dy, $y - $dx, $x + $dy, $y + $dx, $x, $y);
                break;
            case ARROW_RIGHT:
                $c = array($x, $y, $x - $dy, $y - $dx, $x - $dy, $y + $dx, $x, $y);
                break;
            default:
                JpGraphError::RaiseL(6030);
                //('Unknown arrow direction for link.');
                die();
                break;
        }
        $aImg->SetColor($this->iColor);
        switch ($this->iType) {
            case ARROWT_SOLID:
                $aImg->FilledPolygon($c);
                break;
            case ARROWT_OPEN:
                $aImg->Polygon($c);
                break;
            default:
                JpGraphError::RaiseL(6031);
                //('Unknown arrow type for link.');
                die();
                break;
        }
    }
}

//===================================================
// CLASS GanttLink
// Handles the drawing of a link line between 2 points
//===================================================

class GanttLink
{
    private $ix1, $ix2, $iy1, $iy2;
    private $iPathType = 2, $iPathExtend = 15;
    private $iColor = 'black', $iWeight = 1;
    private $iArrowSize = ARROW_S2, $iArrowType = ARROWT_SOLID;

    public function __construct($x1 = 0, $y1 = 0, $x2 = 0, $y2 = 0)
    {
        $this->ix1 = $x1;
        $this->ix2 = $x2;
        $this->iy1 = $y1;
        $this->iy2 = $y2;
    }

    public function SetPos($x1, $y1, $x2, $y2)
    {
        $this->ix1 = $x1;
        $this->ix2 = $x2;
        $this->iy1 = $y1;
        $this->iy2 = $y2;
    }

    public function SetPath($aPath)
    {
        $this->iPathType = $aPath;
    }

    public function SetColor($aColor)
    {
        $this->iColor = $aColor;
    }

    public function SetArrow($aSize, $aType = ARROWT_SOLID)
    {
        $this->iArrowSize = $aSize;
        $this->iArrowType = $aType;
    }

    public function SetWeight($aWeight)
    {
        $this->iWeight = $aWeight;
    }

    public function Stroke($aImg)
    {
        // The way the path for the arrow is constructed is partly based
        // on some heuristics. This is not an exact science but draws the
        // path in a way that, for me, makes esthetic sence. For example
        // if the start and end activities are very close we make a small
        // detour to endter the target horixontally. If there are more
        // space between axctivities then no suh detour is made and the
        // target is "hit" directly vertical. I have tried to keep this
        // simple. no doubt this could become almost infinitive complex
        // and have some real AI. Feel free to modify this.
        // This will no-doubt be tweaked as times go by. One design aim
        // is to avoid having the user choose what types of arrow
        // he wants.

        // The arrow is drawn between (x1,y1) to (x2,y2)
        $x1 = $this->ix1;
        $x2 = $this->ix2;
        $y1 = $this->iy1;
        $y2 = $this->iy2;

        // Depending on if the target is below or above we have to
        // handle thi different.
        if ($y2 > $y1) {
            $arrowtype = ARROW_DOWN;
            $midy = round(($y2 - $y1) / 2 + $y1);
            if ($x2 > $x1) {
                switch ($this->iPathType) {
                    case 0:
                        $c = array($x1, $y1, $x1, $midy, $x2, $midy, $x2, $y2);
                        break;
                    case 1:
                    case 2:
                    case 3:
                        $c = array($x1, $y1, $x2, $y1, $x2, $y2);
                        break;
                    default:
                        JpGraphError::RaiseL(6032, $this->iPathType);
                        //('Internal error: Unknown path type (='.$this->iPathType .') specified for link.');
                        exit(1);
                        break;
                }
            } else {
                switch ($this->iPathType) {
                    case 0:
                    case 1:
                        $c = array($x1, $y1, $x1, $midy, $x2, $midy, $x2, $y2);
                        break;
                    case 2:
                        // Always extend out horizontally a bit from the first point
                        // If we draw a link back in time (end to start) and the bars
                        // are very close we also change the path so it comes in from
                        // the left on the activity
                        $c = array($x1, $y1, $x1 + $this->iPathExtend, $y1,
                            $x1 + $this->iPathExtend, $midy,
                            $x2, $midy, $x2, $y2);
                        break;
                    case 3:
                        if ($y2 - $midy < 6) {
                            $c = array($x1, $y1, $x1, $midy,
                                $x2 - $this->iPathExtend, $midy,
                                $x2 - $this->iPathExtend, $y2,
                                $x2, $y2);
                            $arrowtype = ARROW_RIGHT;
                        } else {
                            $c = array($x1, $y1, $x1, $midy, $x2, $midy, $x2, $y2);
                        }
                        break;
                    default:
                        JpGraphError::RaiseL(6032, $this->iPathType);
                        //('Internal error: Unknown path type specified for link.');
                        exit(1);
                        break;
                }
            }
            $arrow = new LinkArrow($x2, $y2, $arrowtype);
        } else {
            // Y2 < Y1
            $arrowtype = ARROW_UP;
            $midy = round(($y1 - $y2) / 2 + $y2);
            if ($x2 > $x1) {
                switch ($this->iPathType) {
                    case 0:
                    case 1:
                        $c = array($x1, $y1, $x1, $midy, $x2, $midy, $x2, $y2);
                        break;
                    case 3:
                        if ($midy - $y2 < 8) {
                            $arrowtype = ARROW_RIGHT;
                            $c = array($x1, $y1, $x1, $y2, $x2, $y2);
                        } else {
                            $c = array($x1, $y1, $x1, $midy, $x2, $midy, $x2, $y2);
                        }
                        break;
                    default:
                        JpGraphError::RaiseL(6032, $this->iPathType);
                        //('Internal error: Unknown path type specified for link.');
                        break;
                }
            } else {
                switch ($this->iPathType) {
                    case 0:
                    case 1:
                        $c = array($x1, $y1, $x1, $midy, $x2, $midy, $x2, $y2);
                        break;
                    case 2:
                        // Always extend out horizontally a bit from the first point
                        $c = array($x1, $y1, $x1 + $this->iPathExtend, $y1,
                            $x1 + $this->iPathExtend, $midy,
                            $x2, $midy, $x2, $y2);
                        break;
                    case 3:
                        if ($midy - $y2 < 16) {
                            $arrowtype = ARROW_RIGHT;
                            $c = array($x1, $y1, $x1, $midy, $x2 - $this->iPathExtend, $midy,
                                $x2 - $this->iPathExtend, $y2,
                                $x2, $y2);
                        } else {
                            $c = array($x1, $y1, $x1, $midy, $x2, $midy, $x2, $y2);
                        }
                        break;
                    default:
                        JpGraphError::RaiseL(6032, $this->iPathType);
                        //('Internal error: Unknown path type specified for link.');
                        break;
                }
            }
            $arrow = new LinkArrow($x2, $y2, $arrowtype);
        }
        $aImg->SetColor($this->iColor);
        $aImg->SetLineWeight($this->iWeight);
        $aImg->Polygon($c);
        $aImg->SetLineWeight(1);
        $arrow->SetColor($this->iColor);
        $arrow->SetSize($this->iArrowSize);
        $arrow->SetType($this->iArrowType);
        $arrow->Stroke($aImg);
    }
}

// <EOF>
