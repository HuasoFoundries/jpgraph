<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Configs;
use Amenadiel\JpGraph\Text;
use Amenadiel\JpGraph\Util;
use const M_PI;
use function max;

/**
 * @class WindrosePlotScale
 */
class WindrosePlotScale
{
    public $iMaxNum = 0;

    public $iFontFamily = Configs::FF_VERDANA;

    public $iFontStyle = Configs::FS_NORMAL;

    public $iFontSize = 10;

    public $iZFontFamily = Configs::FF_ARIAL;

    public $iZFontStyle = Configs::FS_NORMAL;

    public $iZFontSize = 10;

    public $iFontColor = 'black';

    public $iZFontColor = 'black';

    public $iAngle = 'auto';

    private $iMax;

    private $iDelta = 5;

    private $iNumCirc = 3;

    private $iLblFmt = '%.0f%%';

    private $iFontFrameColor = false;

    private $iFontBkgColor = false;

    private $iLblZeroTxt;

    private $iLblAlign = Configs::LBLALIGN_CENTER;

    /**
     * @var bool
     */
    private $iManualScale = false;

    private $iHideLabels = false;

    public function __construct($aData)
    {
        $max = 0;
        $totlegsum = 0;
        $maxnum = 0;
        $this->iZeroSum = 0;

        foreach ($aData as $idx => $legdata) {
            $legsum = \array_sum($legdata);
            $maxnum = \max($maxnum, Configs::safe_count($legdata) - 1);
            $max = \max($legsum - $legdata[0], $max);
            $totlegsum += $legsum;
            $this->iZeroSum += $legdata[0];
        }

        if (\round($totlegsum) > 100) {
            Util\JpGraphError::RaiseL(22001, $legsum);
            //("Total percentage for all windrose legs in a windrose plot can not exceed  100% !\n(Current max is: ".$legsum.')');
        }
        $this->iMax = $max;
        $this->iMaxNum = $maxnum;
        $this->iNumCirc = $this->GetNumCirc();
        $this->iMaxVal = $this->iNumCirc * $this->iDelta;
    }

    // Return number of grid circles
    /**
     * @return float|int
     */
    public function GetNumCirc()
    {
        // Never return less than 1 circles
        $num = \ceil($this->iMax / $this->iDelta);

        return \max(1, $num);
    }

    /**
     * @return void
     */
    public function SetMaxValue($aMax)
    {
        $this->iMax = $aMax;
        $this->iNumCirc = $this->GetNumCirc();
        $this->iMaxVal = $this->iNumCirc * $this->iDelta;
    }

    // Set step size for circular grid
    /**
     * @return void
     */
    public function Set($aMax, $aDelta = null)
    {
        if (null === $aDelta) {
            $this->SetMaxValue($aMax);

            return;
        }
        $this->iDelta = $aDelta;
        $this->iNumCirc = \ceil($aMax / $aDelta); //$this->GetNumCirc();
        $this->iMaxVal = $this->iNumCirc * $this->iDelta;
        $this->iMax = $aMax;
        // Remember that user has specified interval so don't
        // do autoscaling
        $this->iManualScale = true;
    }

    /**
     * @param float|int $aMinDist
     *
     * @return void
     */
    public function AutoScale($aRadius, $aMinDist = 30)
    {
        if ($this->iManualScale) {
            return;
        }

        // Make sure distance (in pixels) between two circles
        // is never less than $aMinDist pixels
        $tst = \ceil($aRadius / $this->iNumCirc);

        while ($tst <= $aMinDist && 100 > $this->iDelta) {
            $this->iDelta += 5;
            $tst = \ceil($aRadius / $this->GetNumCirc());
        }

        if (100 <= $this->iDelta) {
            Util\JpGraphError::RaiseL(22002); //('Graph is too small to have a scale. Please make the graph larger.');
        }

        // If the distance is to large try with multiples of 2 instead
        if ($aMinDist * 3 < $tst) {
            $this->iDelta = 2;
            $tst = \ceil($aRadius / $this->iNumCirc);

            while ($tst <= $aMinDist && 100 > $this->iDelta) {
                $this->iDelta += 2;
                $tst = \ceil($aRadius / $this->GetNumCirc());
            }

            if (100 <= $this->iDelta) {
                Util\JpGraphError::RaiseL(22002); //('Graph is too small to have a scale. Please make the graph larger.');
            }
        }

        $this->iNumCirc = $this->GetNumCirc();
        $this->iMaxVal = $this->iNumCirc * $this->iDelta;
    }

    // Return max of all leg values
    public function GetMax()
    {
        return $this->iMax;
    }

    /**
     * @return void
     */
    public function Hide($aFlg = true)
    {
        $this->iHideLabels = $aFlg;
    }

    /**
     * @return void
     */
    public function SetAngle($aAngle)
    {
        $this->iAngle = $aAngle;
    }

    // Translate a Leg value to radius distance
    /**
     * @return float
     */
    public function RelTranslate($aVal, $r, $ri)
    {
        return \round($aVal / $this->iMaxVal * ($r - $ri));
    }

    /**
     * @return void
     */
    public function SetLabelAlign($aAlign)
    {
        $this->iLblAlign = $aAlign;
    }

    /**
     * @return void
     */
    public function SetLabelFormat($aFmt)
    {
        $this->iLblFmt = $aFmt;
    }

    /**
     * @return void
     */
    public function SetLabelFillColor($aBkgColor, $aBorderColor = false)
    {
        $this->iFontBkgColor = $aBkgColor;

        if (false === $aBorderColor) {
            $this->iFontFrameColor = $aBkgColor;
        } else {
            $this->iFontFrameColor = $aBorderColor;
        }
    }

    /**
     * @return void
     */
    public function SetFontColor($aColor)
    {
        $this->iFontColor = $aColor;
        $this->iZFontColor = $aColor;
    }

    /**
     * @return void
     */
    public function SetFont($aFontFamily, $aFontStyle = Configs::FS_NORMAL, $aFontSize = 10)
    {
        $this->iFontFamily = $aFontFamily;
        $this->iFontStyle = $aFontStyle;
        $this->iFontSize = $aFontSize;
        $this->SetZFont($aFontFamily, $aFontStyle, $aFontSize);
    }

    /**
     * @return void
     */
    public function SetZFont($aFontFamily, $aFontStyle = Configs::FS_NORMAL, $aFontSize = 10)
    {
        $this->iZFontFamily = $aFontFamily;
        $this->iZFontStyle = $aFontStyle;
        $this->iZFontSize = $aFontSize;
    }

    /**
     * @return void
     */
    public function SetZeroLabel($aTxt)
    {
        $this->iLblZeroTxt = $aTxt;
    }

    /**
     * @return void
     */
    public function SetZFontColor($aColor)
    {
        $this->iZFontColor = $aColor;
    }

    /**
     * @param float $xc
     * @param float $yc
     * @param float $rr
     *
     * @return void
     */
    public function StrokeLabels($aImg, $xc, $yc, $ri, $rr)
    {
        if ($this->iHideLabels) {
            return;
        }

        // Setup some convinient vairables
        $a = $this->iAngle * M_PI / 180.0;
        $n = $this->iNumCirc;
        $d = $this->iDelta;

        // Setup the font and font color
        $val = new Text\Text();
        $val->SetFont($this->iFontFamily, $this->iFontStyle, $this->iFontSize);
        $val->SetColor($this->iFontColor);

        if (false !== $this->iFontBkgColor) {
            $val->SetBox($this->iFontBkgColor, $this->iFontFrameColor);
        }

        // Position the labels relative to the radiant circles
        if (Configs::LBLALIGN_TOP === $this->iLblAlign) {
            if (0 < $a && M_PI / 2 >= $a) {
                $val->SetAlign('left', 'bottom');
            } elseif (M_PI / 2 < $a && M_PI >= $a) {
                $val->SetAlign('right', 'bottom');
            }
        } elseif (Configs::LBLALIGN_CENTER === $this->iLblAlign) {
            $val->SetAlign('center', 'center');
        }

        // Stroke the labels close to each circle
        $v = $d;
        $si = \sin($a);
        $co = \cos($a);

        for ($i = 0; $i < $n; ++$i, $v += $d) {
            $r = $ri + ($i + 1) * $rr;
            $x = $xc + $co * $r;
            $y = $yc - $si * $r;
            $val->Set(\sprintf($this->iLblFmt, $v));
            $val->Stroke($aImg, $x, $y);
        }

        // Print the text in the zero circle
        if (null === $this->iLblZeroTxt) {
            $this->iLblZeroTxt = \sprintf($this->iLblFmt, $this->iZeroSum);
        } else {
            $this->iLblZeroTxt = \sprintf($this->iLblZeroTxt, $this->iZeroSum);
        }

        $val->Set($this->iLblZeroTxt);
        $val->SetAlign('center', 'center');
        $val->SetParagraphAlign('center');
        $val->SetColor($this->iZFontColor);
        $val->SetFont($this->iZFontFamily, $this->iZFontStyle, $this->iZFontSize);
        $val->Stroke($aImg, $xc, $yc);
    }
}
