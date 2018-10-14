<?php

/**
 * JPGraph v3.6.21
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

$shape->IndentedRectangle(1, 2, 15, 15, 8, 8, CORNER_TOPLEFT, 'khaki');

$shape->IndentedRectangle(1, 20, 15, 15, 8, 8, CORNER_BOTTOMLEFT, 'khaki');

$shape->IndentedRectangle(20, 2, 15, 15, 8, 8, CORNER_TOPRIGHT, 'khaki');

$shape->IndentedRectangle(20, 20, 15, 15, 8, 8, CORNER_BOTTOMRIGHT, 'khaki');

// Stroke the graph
$g->Stroke();
