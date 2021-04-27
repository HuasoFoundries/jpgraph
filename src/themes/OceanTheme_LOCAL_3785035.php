<?php

/**
 * JPGraph v4.1.0-beta.01
 */

namespace Amenadiel\JpGraph\Themes;

/**
 * Ocean Theme class.
 */
class OceanTheme extends Theme
{
    protected $font_color       = '#0066FF';
    protected $background_color = '#DDEEFF';
    protected $axis_color       = '#0000CC';
    protected $grid_color       = '#3333CC';

    public function GetColorList()
    {
        return [
            '#0066FF',
            '#CCCCFF',
            '#0000FF',
            '#3366FF',
            '#33CCFF',
            '#660088',
            '#3300FF',
            '#0099FF',
            '#6633FF',
            '#0055EE',
            '#2277EE',
            '#3300FF',
            '#AA00EE',
            '#778899',
            '#114499',
            '#7744EE',
            '#002288',
            '#6666FF',
        ];
    }
}
