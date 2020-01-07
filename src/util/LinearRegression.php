<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Util;

define('__LR_EPSILON', 1.0e-8);
/**
 * @class LinearRegression
 */
class LinearRegression
{
    private $ix          = [];
    private $iy          = [];
    private $ib          = 0;
    private $ia          = 0;
    private $icalculated = false;
    public $iDet         = 0;
    public $iCorr        = 0;
    public $iStdErr      = 0;

    public function __construct($aDataX, $aDataY)
    {
        if (safe_count($aDataX) !== safe_count($aDataY)) {
            JpGraph::Raise('LinearRegression: X and Y data array must be of equal length.');
        }
        $this->ix = $aDataX;
        $this->iy = $aDataY;
    }

    public function Calc()
    {
        $this->icalculated = true;

        $n   = safe_count($this->ix);
        $sx2 = 0;
        $sy2 = 0;
        $sxy = 0;
        $sx  = 0;
        $sy  = 0;

        for ($i = 0; $i < $n; ++$i) {
            $sx2 += $this->ix[$i] * $this->ix[$i];
            $sy2 += $this->iy[$i] * $this->iy[$i];
            $sxy += $this->ix[$i] * $this->iy[$i];
            $sx += $this->ix[$i];
            $sy += $this->iy[$i];
        }

        if ($n * $sx2 - $sx * $sx > __LR_EPSILON) {
            $this->ib = ($n * $sxy - $sx * $sy) / ($n * $sx2 - $sx * $sx);
            $this->ia = ($sy - $this->ib * $sx) / $n;

            $sx  = $this->ib * ($sxy - $sx * $sy / $n);
            $sy2 = $sy2 - $sy * $sy / $n;
            $sy  = $sy2 - $sx;

            $this->iDet  = $sx / $sy2;
            $this->iCorr = sqrt($this->iDet);
            if ($n > 2) {
                $this->iStdErr = sqrt($sy / ($n - 2));
            } else {
                $this->iStdErr = NAN;
            }
        } else {
            $this->ib = 0;
            $this->ia = 0;
        }
    }

    public function GetAB()
    {
        if ($this->icalculated == false) {
            $this->Calc();
        }

        return [$this->ia, $this->ib];
    }

    public function GetStat()
    {
        if ($this->icalculated == false) {
            $this->Calc();
        }

        return [$this->iStdErr, $this->iCorr, $this->iDet];
    }

    public function GetY($aMinX, $aMaxX, $aStep = 1)
    {
        if ($this->icalculated == false) {
            $this->Calc();
        }

        $yy = [];
        $i  = 0;
        for ($x = $aMinX; $x <= $aMaxX; $x += $aStep) {
            $xx[$i]   = $x;
            $yy[$i++] = $this->ia + $this->ib * $x;
        }

        return [$xx, $yy];
    }
}
