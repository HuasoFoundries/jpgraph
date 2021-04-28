<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Themes;

/**
 * Vivid Theme class.
 */
class VividTheme extends Theme
{
    protected $font_color = '#0044CC';

    protected $background_color = '#DDFFFF';

    protected $axis_color = '#0066CC';

    protected $grid_color = '#3366CC';

    public function GetColorList()
    {
        return [
            '#FFFB11',
            '#005EBC',
            '#9AEB67',
            '#FF4A26',
            '#FDFF98',
            '#6B7EFF',
            '#BCE02E',
            '#E0642E',
            '#E0D62E',
            '#2E97E0',
            '#02927F',
            '#FF005A',
        ];
    }
}
