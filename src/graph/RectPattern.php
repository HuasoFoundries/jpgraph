<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Util;

/**
 * @class RectPattern
 *  Base class for pattern hierarchi that is used to display patterned
 *  bands on the graph. Any subclass that doesn't override Stroke()
 *  must at least implement method DoPattern($aImg) which is responsible
 *  for drawing the pattern onto the graph.
 */
class RectPattern
{
    protected $color;

    protected $weight;

    protected $rect;

    protected $doframe = true;

    /**
     * @var float|null
     */
    protected $linespacing; // Line spacing in pixels

    protected $iBackgroundColor = -1; // Default is no background fill

    public function __construct($aColor, $aWeight = 1)
    {
        $this->color = $aColor;
        $this->weight = $aWeight;
    }

    public function SetBackground($aBackgroundColor)
    {
        $this->iBackgroundColor = $aBackgroundColor;
    }

    public function SetPos($aRect)
    {
        $this->rect = $aRect;
    }

    public function ShowFrame($aShow = true)
    {
        $this->doframe = $aShow;
    }
    /**
* 1% corresponds to linespacing=50
 * 100 % corresponds to linespacing 1
 */
    public function SetDensity(float $aDens)
    {
        if (1 > $aDens || 100 < $aDens) {
            Util\JpGraphError::RaiseL(16001, $aDens);
        }

        //(" Desity for pattern must be between 1 and 100. (You tried $aDens)");
        
        $this->linespacing = \floor(((100 - $aDens) / 100.0) * 50) + 1;
    }

    public function Stroke($aImg)
    {
        if (null === $this->rect) {
            Util\JpGraphError::RaiseL(16002);
        }

        //(" No positions specified for pattern.");

        if (!(\is_numeric($this->iBackgroundColor) && -1 === $this->iBackgroundColor)) {
            $aImg->SetColor($this->iBackgroundColor);
            $aImg->FilledRectangle($this->rect->x, $this->rect->y, $this->rect->xe, $this->rect->ye);
        }

        $aImg->SetColor($this->color);
        $aImg->SetLineWeight($this->weight);

        // Virtual function implemented by subclass
        $this->DoPattern($aImg);

        // Frame around the pattern area
        if (!$this->doframe) {
            // Frame around the pattern area
            return;
            // Frame around the pattern area
        }

        $aImg->Rectangle($this->rect->x, $this->rect->y, $this->rect->xe, $this->rect->ye);
    }
}
