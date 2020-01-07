<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Util;

use Amenadiel\JpGraph\Image;

// Keep a global flag cache to reduce memory usage

// Only supposed to b called as statics
class FlagCache
{
    private static $_gFlagCache = [
        1 => null,
        2 => null,
        3 => null,
        4 => null,
    ];

    public static function GetFlagImgByName($aSize, $aName)
    {
        if (self::$_gFlagCache[$aSize] === null) {
            self::$_gFlagCache[$aSize] = new Image\FlagImages($aSize);
        }
        $f   = self::$_gFlagCache[$aSize];
        $idx = $f->GetIdxByName($aName, $aFullName);

        return $f->GetImgByIdx($idx);
    }
}
