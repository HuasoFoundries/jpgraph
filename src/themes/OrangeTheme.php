<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Themes;

/**
 * Orange Theme class.
 */
class OrangeTheme extends Theme
{
    protected $font_color = '#CC4400';

    protected $background_color = '#FFEEDD';

    protected $axis_color = '#CC6600';

    protected $grid_color = '#CC6633';

    public function GetColorList()
    {
        return [
            '#FF9900',
            '#FFCC00',
            '#AA6600',
            '#CCCC00',
            '#CC6600',
            '#FFFF66',
            '#CCFF00',
            '#CC3300',
            '#669933',
            '#EE7700',
            '#AAEE33',
            '#77AA00',
            '#CCFF99',
            '#FF6633',
            '#885500',
            '#AADD00',
            '#99CC44',
            '#887711',
        ];
    }
}
