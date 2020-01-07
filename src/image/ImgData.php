<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Image;

use Amenadiel\JpGraph\Util;

/**
 * @class ImgData
 * // Description: Base class for all image data classes that contains the
 * // real image data.
 */
class ImgData
{
    protected $name     = ''; // Each subclass gives a name
    protected $an       = []; // Data array names
    protected $colors   = []; // Available colors
    protected $index    = []; // Index for colors
    protected $maxidx   = 0; // Max color index
    protected $anchor_x = 0.5;
    protected $anchor_y = 0.5; // Where is the center of the image

    public function __construct()
    {
        // Empty
    }

    // Create a GD image from the data and return a GD handle
    public function GetImg($aMark, $aIdx)
    {
        $n = $this->an[$aMark];
        if (is_string($aIdx)) {
            if (!in_array($aIdx, $this->colors, true)) {
                Util\JpGraphError::RaiseL(23001, $this->name, $aIdx); //('This marker "'.($this->name).'" does not exist in color: '.$aIdx);
            }
            $idx = $this->index[$aIdx];
        } elseif (!is_integer($aIdx) ||
            (is_integer($aIdx) && $aIdx > $this->maxidx)) {
            Util\JpGraphError::RaiseL(23002, $this->name); //('Mark color index too large for marker "'.($this->name).'"');
        } else {
            $idx = $aIdx;
        }

        return Image::CreateFromString(base64_decode($this->{$n}[$idx][1], true));
    }

    public function GetAnchor()
    {
        return [$this->anchor_x, $this->anchor_y];
    }
}
