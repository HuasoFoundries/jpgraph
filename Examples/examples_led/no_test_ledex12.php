<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

require_once 'jpgraph/jpgraph_led.php';

// By default each "LED" circle has a radius of 3 pixels
$led = new DigitalLED74();
$led->StrokeNumber('0123456789. ABCDEFGHIJKL', LEDC_LIMEGREEN);
