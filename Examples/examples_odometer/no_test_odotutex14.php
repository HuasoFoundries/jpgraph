<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_odo.php';

// Create a new odometer graph (width=250, height=200 pixels)
$__width = 250;
$__height = 160;
$graph = new OdoGraph($__width, $__height);
$example_title = 'Custom scale';
$graph->title->set($example_title);
$graph->title->SetColor('white');
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'));

// Add drop shadow for graph
$graph->SetShadow();

// Now we need to create an odometer to add to the graph.
// By default the scale will be 0 to 100
$odo = new Odometer();
$odo->SetColor('lightyellow');

// Setup the scale
$odo->scale->Set(100, 600);
$odo->scale->SetTicks(50, 2);

// Set display value for the odometer
$odo->needle->Set(280);

// Add drop shadow for needle
$odo->needle->SetShadow();

// Add the odometer to the graph
$graph->Add($odo);

// ... and finally stroke and stream the image back to the browser
$graph->Stroke();
