<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Util;

/**
 * @class RectPatternFactory
 * // Factory class for rectangular pattern
 */
class RectPatternFactory
{
    public function __construct()
    {
        // Empty
    }

    public function Create($aPattern, $aColor, $aWeight = 1)
    {
        switch ($aPattern) {
            case BAND_RDIAG:
                $obj = new RectPatternRDiag($aColor, $aWeight);

                break;
            case BAND_LDIAG:
                $obj = new RectPatternLDiag($aColor, $aWeight);

                break;
            case BAND_SOLID:
                $obj = new RectPatternSolid($aColor, $aWeight);

                break;
            case BAND_VLINE:
                $obj = new RectPatternVert($aColor, $aWeight);

                break;
            case BAND_HLINE:
                $obj = new RectPatternHor($aColor, $aWeight);

                break;
            case BAND_3DPLANE:
                $obj = new RectPattern3DPlane($aColor, $aWeight);

                break;
            case BAND_HVCROSS:
                $obj = new RectPatternCross($aColor, $aWeight);

                break;
            case BAND_DIAGCROSS:
                $obj = new RectPatternDiagCross($aColor, $aWeight);

                break;
            default:
                Util\JpGraphError::RaiseL(16003, $aPattern);
                //(" Unknown pattern specification ($aPattern)");
        }

        return $obj;
    }
}
