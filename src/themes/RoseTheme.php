<?php

/**
 * JPGraph v4.1.0-beta.01
 */

namespace Amenadiel\JpGraph\Themes;

/**
 * Rose Theme class.
 */
class RoseTheme extends Theme
{
    protected $font_color       = '#CC0044';
    protected $background_color = '#FFDDDD';
    protected $axis_color       = '#CC0000';
    protected $grid_color       = '#CC3333';

    public function GetColorList()
    {
        return [
            '#FF0000',
            '#FF99FF',
            '#AA0099',
            '#FF00FF',
            '#FF6666',
            '#FF0099',
            '#FFBB88',
            '#AA2211',
            '#FF6699',
            '#BBAA88',
            '#FF2200',
            '#883333',
            '#EE7777',
            '#EE7711',
            '#FF0066',
            '#DD7711',
            '#AA6600',
            '#EE5500',
        ];
    }
}
