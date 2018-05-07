<?php

/**
 * JPGraph v3.6.15
 */
require_once 'jpgraph/jpgraph.php';
require_once 'jpgraph/jpgraph_led.php';

// By default each "LED" circle has a radius of 3 pixels
$led = new DigitalLED74();
$led->StrokeNumber('0123456789. ABCDEFGHIJKL', LEDC_BLUE);
