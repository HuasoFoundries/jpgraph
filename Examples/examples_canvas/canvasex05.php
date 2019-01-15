<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;

// Define work space
$xmax = 40;
$ymax = 40;

// Setup a basic canvas we can work
$__width  = 400;
$__height = 200;
$g        = new Graph\CanvasGraph($__width, $__height, 'auto');
$g->SetMargin(5, 11, 6, 11);
$g->SetShadow();
$g->SetMarginColor('teal');

// We need to stroke the plotarea and margin before we add the
// text since we otherwise would overwrite the text.
$g->InitFrame();

// Create a new Graph\scale
$scale = new Graph\CanvasScale($g);
$scale->Set(0, $xmax, 0, $ymax);

// The shape class is wrapper around the Imgae class which translates
// the coordinates for us
$shape = new Graph\Shape($g, $scale);
$shape->SetColor('black');

// Add a black line
$shape->SetColor('black');
$shape->Line(0, 0, 20, 20);

// .. and a circle (x,y,diameter)
$shape->Circle(5, 14, 2);

// .. and a filled circle (x,y,diameter)
$shape->SetColor('red');
$shape->FilledCircle(11, 8, 3);

// .. add a rectangle
$shape->SetColor('green');
$shape->FilledRectangle(15, 8, 19, 14);

// .. add a filled rounded rectangle
$shape->SetColor('green');
$shape->FilledRoundedRectangle(2, 3, 8, 6);
// .. with a darker border
$shape->SetColor('darkgreen');
$shape->RoundedRectangle(2, 3, 8, 6);

// Stroke the graph
$g->Stroke();
