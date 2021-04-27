<?php

/**
 * JPGraph v4.0.3
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// We need some data
$datay = [4, 8, 6];

// Setup the graph.
$__width  = 200;
$__height = 150;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->img->SetMargin(25, 15, 25, 25);

$graph->title->Set('"GRAD_MIDVER"');
$graph->title->SetColor('darkred');

// Setup font for axis
$graph->xaxis->SetFont(FF_FONT1);
$graph->yaxis->SetFont(FF_FONT1);

// Create the bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetWidth(0.6);

// Setup color for gradient fill style
$bplot->SetFillGradient('navy', 'lightsteelblue', GRAD_MIDVER);

// Set color for the frame of each bar
$bplot->SetColor('navy');
$graph->Add($bplot);

// Finally send the graph to the browser
$graph->Stroke();
