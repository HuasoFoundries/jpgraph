<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_odo.php';

// Create a new odometer graph (width=250, height=200 pixels)
$__width  = 250;
$__height = 140;
$graph    = new OdoGraph($__width, $__height);

// Setup a title
$graph->title->Set('An example with drop shadows');

// Add drop shadow for graph
$graph->SetShadow();

// Set some nonstandard colors
$color = [205, 220, 205];
$graph->SetMarginColor($color);
$graph->SetColor($color);

// Now we need to create an odometer to add to the graph.
// By default the scale will be 0 to 100
$odo = new Odometer();
$odo->SetColor('white');

// Set display value for the odometer
$odo->needle->Set(70);

// Add drop shadow for needle
$odo->needle->SetShadow();

// Add the odometer to the graph
$graph->Add($odo);

// ... and finally stroke and stream the image back to the browser
$graph->Stroke();
