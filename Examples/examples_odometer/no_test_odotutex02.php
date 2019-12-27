<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_odo.php';

// Create a new odometer graph (width=250, height=200 pixels)
$__width  = 250;
$__height = 180;
$graph    = new OdoGraph($__width, $__height);

// Setup titles$example_title='Result for 2002'; $graph->title->set($example_title);
$graph->title->SetColor('white');
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);
$subtitle_text = 'New York Office';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetColor('white');
$graph->caption->Set('Figure 1. Branch results.');
$graph->caption->SetColor('white');

// Now we need to create an odometer to add to the graph.
// By default the scale will be 0 to 100
$odo = new Odometer();

// Set display value for the odometer
$odo->needle->Set(30);

// Add the odometer to the graph
$graph->Add($odo);

// ... and finally stroke and stream the image back to the client
$graph->Stroke();
