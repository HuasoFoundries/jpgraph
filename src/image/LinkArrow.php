<?php

/**
 * JPGraph v4.1.0-beta.01
 */

namespace Amenadiel\JpGraph\Image;

use Amenadiel\JpGraph\Util;

/**
 * @class LinkArrow
 * // Handles the drawing of a an arrow
 */
class LinkArrow
{
    private $ix;
    private $iy;
    private $isizespec  = [
        [2, 3],
        [3, 5],
        [3, 8],
        [6, 15],
        [8, 22],
    ];
    private $iDirection = Configs::ARROW_DOWN;
    private $iType      = Configs::ARROWT_SOLID;
    private $iSize      = Configs::ARROW_S2;
    private $iColor     = 'black';

    public function __construct($x, $y, $aDirection, $aType = Configs::ARROWT_SOLID, $aSize = Configs::ARROW_S2)
    {
        $this->iDirection = $aDirection;
        $this->iType      = $aType;
        $this->iSize      = $aSize;
        $this->ix         = $x;
        $this->iy         = $y;
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
        $x             = $this->ix;
        $y             = $this->iy;
        switch ($this->iDirection) {
            case Configs::ARROW_DOWN:
                $c = [$x, $y, $x - $dx, $y - $dy, $x + $dx, $y - $dy, $x, $y];

                break;
            case Configs::ARROW_UP:
                $c = [$x, $y, $x - $dx, $y + $dy, $x + $dx, $y + $dy, $x, $y];

                break;
            case Configs::ARROW_LEFT:
                $c = [$x, $y, $x + $dy, $y - $dx, $x + $dy, $y + $dx, $x, $y];

                break;
            case Configs::ARROW_RIGHT:
                $c = [$x, $y, $x - $dy, $y - $dx, $x - $dy, $y + $dx, $x, $y];

                break;
            default:
                Util\JpGraphError::RaiseL(6030);
                //('Unknown arrow direction for link.');
                die;

                break;
        }
        $aImg->SetColor($this->iColor);
        switch ($this->iType) {
            case Configs::ARROWT_SOLID:
                $aImg->FilledPolygon($c);

                break;
            case Configs::ARROWT_OPEN:
                $aImg->Polygon($c);

                break;
            default:
                Util\JpGraphError::RaiseL(6031);
                //('Unknown arrow type for link.');
                die;

                break;
        }
    }
}
