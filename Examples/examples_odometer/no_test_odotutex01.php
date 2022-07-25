<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_odo.php';

// Create a new odometer graph (width=250, height=200 pixels)
$__width = 250;
$__height = 140;
$graph = new OdoGraph($__width, $__height);

// Now we need to create an odometer to add to the graph.
// By default the scale will be 0 to 100
$odo = new Odometer(Graph\Configs::getConfig('ODO_FULL'));

// Set display value for the odometer
$odo->needle->Set(30);

// Add the odometer to the graph
$graph->Add($odo);

// ... and finally stroke and stream the image back to the client
$graph->Stroke();
