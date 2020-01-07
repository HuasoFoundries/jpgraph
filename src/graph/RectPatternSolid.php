<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Graph;

/**
 * @class RectPatternSolid
 * // Implements a solid band
 */
class RectPatternSolid extends RectPattern
{
    public function __construct($aColor = 'black', $aWeight = 1)
    {
        parent::__construct($aColor, $aWeight);
    }

    public function DoPattern($aImg)
    {
        $aImg->SetColor($this->color);
        $aImg->FilledRectangle(
            $this->rect->x,
            $this->rect->y,
            $this->rect->xe,
            $this->rect->ye
        );
    }
}
