<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Themes;

/**
 * Green Theme class.
 */
class GreenTheme extends Theme
{
    protected $font_color = '#009900';

    protected $background_color = '#EEFFDD';

    protected $axis_color = '#00CC00';

    protected $grid_color = '#33CC33';

    public function GetColorList()
    {
        return [
            '#66CC00',
            '#009900',
            '#AAFF77',
            '#559922',
            '#00CC33',
            '#99FF00',
            '#009966',
            '#00FF99',
            '#99BB66',
            '#33FF00',
            '#DDFFBB',
            '#669933',
            '#BBDDCC',
            '#77CCBB',
            '#668833',
            '#BBEE66',
        ];
    }
}
