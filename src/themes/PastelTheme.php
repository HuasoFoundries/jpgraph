<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Themes;

/**
 * Pastel Theme class.
 */
class PastelTheme extends Theme
{
    protected $font_color = '#0044CC';

    protected $background_color = '#DDFFFF';

    protected $axis_color = '#0066CC';

    protected $grid_color = '#3366CC';

    public function GetColorList()
    {
        return [
            '#FFAACC',
            '#AAEECC',
            '#AACCFF',
            '#CCAAFF',
            '#EEDDFF',
            '#FFCCAA',
            '#CCBBDD',
            '#CCFFAA',
            '#C7D7C2',
            '#FFEEDD',
            '#FFCCEE',
            '#BFECFA',
        ];
    }
}
