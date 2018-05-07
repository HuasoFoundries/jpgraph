<?php
// $Id: canvasex06.php,v 1.1 2002/08/27 20:08:57 aditus Exp $

require_once '../../vendor/autoload.php';

use Amenadiel\JpGraph\Graph;

// Define work space
$xmax = 40;
$ymax = 40;

// Setup a basic canvas we can work
$g = new Graph\CanvasGraph(400, 200, 'auto');
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
