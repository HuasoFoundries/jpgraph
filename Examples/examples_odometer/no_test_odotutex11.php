<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_odo.php';

// Create a new odometer graph (width=250, height=200 pixels)
$__width  = 250;
$__height = 150;
$graph    = new OdoGraph($__width, $__height);

$graph->title->Set('Example with scale indicators');

// Add drop shadow for graph
$graph->SetShadow();

// Now we need to create an odometer to add to the graph.
// By default the scale will be 0 to 100
$odo = new Odometer(ODO_HALF);

// Add color indications
$odo->AddIndication(0, 20, 'green:0.7');
$odo->AddIndication(20, 30, 'green:0.9');
$odo->AddIndication(30, 60, 'yellow');
$odo->AddIndication(60, 80, 'orange');
$odo->AddIndication(80, 100, 'red');

// Set display value for the odometer
$odo->needle->Set(90);

// Set the size of the non-colored base area to 40% of the radius
$odo->SetCenterAreaWidth(0.45);

// Add drop shadow for needle
$odo->needle->SetShadow();

// Add the odometer to the graph
$graph->Add($odo);

// ... and finally stroke and stream the image back to the browser
$graph->Stroke();

// EOF
