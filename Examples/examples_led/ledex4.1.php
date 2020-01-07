<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
// By default each "LED" circle has a radius of 3 pixels. Change to 5 and slghtly smaller margin
use Amenadiel\JpGraph\Image;

$led = new Image\DigitalLED74(6);
$led->SetSupersampling(2);
$led->StrokeNumber('123.', Image\Configs::getConfig('LEDC_RED'));
