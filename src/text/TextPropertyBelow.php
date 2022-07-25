<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Text;

/**
 * @class TextPropertyBelow
 */
class TextPropertyBelow extends TextProperty
{
    public function __construct($aTxt = '')
    {
        parent::__construct($aTxt);
    }

    public function GetColWidth($aImg, $aMargin = 0)
    {
        // Since we are not stroking the title in the columns
        // but rather under the graph we want this to return 0.
        return [0];
    }
}
