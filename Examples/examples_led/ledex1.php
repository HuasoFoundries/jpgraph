<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Image;

// By default each "LED" circle has a radius of 3 pixels
$led = new Image\DigitalLED74();
$led->StrokeNumber('0123456789.  ABCDEFGHIJKL ', Image\Configs::getConfig('LEDC_GREEN'));
