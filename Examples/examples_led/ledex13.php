<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
// By default each "LED" circle has a radius of 3 pixels
use Amenadiel\JpGraph\Image;

$led = new Image\DigitalLED74();
$led->StrokeNumber('0123456789. ABCDEFGHIJKL', Image\Configs::getConfig('LEDC_FORESTGREEN'));
