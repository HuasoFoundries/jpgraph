<?php

/**
 * JPGraph - Community Edition
 */

//=======================================================================
// File:        MKGRAD.PHP
// Description:    Simple tool to create a gradient background
// Ver:         $Id$
//=======================================================================

// Basic library classes
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Image;
use Amenadiel\JpGraph\Plot;

// Must have a global comparison method for usort()
function _cmp($a, $b)
{
    return \strcmp($a, $b);
}

$example_title = 'Generate gradient background';
// Generate the input form
class Form
{
    public $iColors;

    public $iGradstyles;

    public function __construct()
    {
        $rgb = new Image\RGB();
        $this->iColors = \array_keys($rgb->rgb_table);
        \usort($this->iColors, '_cmp');

        $this->iGradstyles = [
            'Vertical', 2,
            'Horizontal', 1,
            'Vertical from middle', 3,
            'Horizontal from middle', 4,
            'Horizontal wider middle', 6,
            'Vertical wider middle', 7,
            'Rectangle', 5, ];
    }

    public function Run($example_title)
    {
        echo "<h3>{$example_title}</h3>";
        echo '<form METHOD=POST action=""><table style="border:blue solid 1;">';
        echo '<tr><td>Width:<br>' . $this->GenHTMLInput('w', 8, 4, 300) . '</td>';
        echo "\n";
        echo '<td>Height:<br>' . $this->GenHTMLInput('h', 8, 4, 300) . '</td></tr>';
        echo "\n";
        echo '<tr><td>From Color:<br>';
        echo $this->GenHTMLSelect('fc', $this->iColors);
        echo '</td><td>To Color:<br>';
        echo $this->GenHTMLSelect('tc', $this->iColors);
        echo '</td></tr>';
        echo '<tr><td colspan=2>Gradient style:<br>';
        echo $this->GenHTMLSelectCode('s', $this->iGradstyles);
        echo '</td></tr>';
        echo '<tr><td colspan=2>Filename: (empty to stream)<br>';
        echo $this->GenHTMLInput('fn', 55, 100);
        echo '</td></tr>';
        echo '<tr><td colspan=2 align=right>' . $this->GenHTMLSubmit('submit') . '</td></tr>';
        echo '</table>';
        echo '</form>';
    }

    public function GenHTMLSubmit($name)
    {
        return '<INPUT TYPE=submit name="ok"  value=" Ok " >';
    }

    public function GenHTMLInput($name, $len, $maxlen = 100, $val = '')
    {
        return '<INPUT TYPE=TEXT NAME=' . $name . ' VALUE="' . $val . '" SIZE=' . $len . ' MAXLENGTH=' . $maxlen . '>';
    }

    public function GenHTMLSelect($name, $option, $selected = '', $size = 0)
    {
        $txt = "<select name={$name}";

        if (0 < $size) {
            $txt .= " size={$size} >";
        } else {
            $txt .= '>';
        }

        for ($i = 0; \count($option) > $i; ++$i) {
            if ($selected === $option[$i]) {
                $txt = $txt . "<option selected value=\"{$option[$i]}\">{$option[$i]}</option>\n";
            } else {
                $txt = $txt . '<option value="' . $option[$i] . "\">{$option[$i]}</option>\n";
            }
        }

        return $txt . "</select>\n";
    }

    public function GenHTMLSelectCode($name, $option, $selected = '', $size = 0)
    {
        $txt = "<select name={$name}";

        if (0 < $size) {
            $txt .= " size={$size} >";
        } else {
            $txt .= '>';
        }

        for ($i = 0; \count($option) > $i; $i += 2) {
            if ($option[($i + 1)] === $selected) {
                $txt = $txt . '<option selected value=' . $option[($i + 1)] . ">{$option[$i]}</option>\n";
            } else {
                $txt = $txt . '<option value="' . $option[($i + 1)] . "\">{$option[$i]}</option>\n";
            }
        }

        return $txt . "</select>\n";
    }
}

// Basic application driver

class Driver
{
    public $iGraph;

    public $iGrad;

    public $iWidth;

    public $iHeight;

    public $iFromColor;

    public $iToColor;

    public $iStyle;

    public $iForm;

    public function __construct()
    {
        $this->iForm = new Form();
    }

    public function GenGradImage($aWidth = null, $aHeight = null)
    {
        $aWidth = $aWidth ?: (int) $_POST['w'];
        $aHeight = $aHeight ?: (int) $_POST['h'];
        $aFrom = $_POST['fc'] ?? $this->iForm->iColors[0];
        $aTo = $_POST['tc'] ?? $this->iForm->iColors[0];
        $aStyle = $_POST['s'] ?? '2';
        $aFileName = $_POST['fn'] ?? '';

        $this->iWidth = $aWidth;
        $this->iHeight = $aHeight;
        $this->iFromColor = $aFrom;
        $this->iToColor = $aTo;
        $this->iStyle = $aStyle;

        $this->graph = new Graph\CanvasGraph($aWidth, $aHeight);
        $this->grad = new Plot\Gradient($this->graph->img);
        $this->grad->FilledRectangle(
            0,
            0,
            $this->iWidth,
            $this->iHeight,
            $this->iFromColor,
            $this->iToColor,
            $this->iStyle
        );

        if ('' !== $aFileName) {
            $this->graph->Stroke($aFileName);
            echo "Image file '{$aFileName}' created.";
        } else {
            $this->graph->Stroke();
        }
    }

    public function Run($example_title, $inmediate, $aWidth, $aHeight)
    {
        global $HTTP_POST_VARS;

        // Two modes:
        // 1) If the script is called with no posted arguments
        // we show the input form.
        // 2) If we have posted arguments we naivly assume that
        // we are called to do the image.
        if ($inmediate) {
            $this->GenGradImage($aWidth, $aHeight);
        } elseif (' Ok ' === $_POST['ok']) {
            $this->GenGradImage($aWidth, $aHeight);
        } else {
            $this->iForm->Run($example_title);
        }
    }
}
\defined('TEST_INMEDIATE') || \define('TEST_INMEDIATE', true);
$driver = new Driver();
$__width = 300;
$__height = 300;
$driver->Run($example_title, TEST_INMEDIATE, $__width, $__height);
