<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_odo.php';

// Create a new odometer graph (width=250, height=200 pixels)
$__width = 250;
$__height = 200;
$graph = new OdoGraph($__width, $__height);

// Setup titles$example_title='Result for 2002'; $graph->title->set($example_title);
$graph->title->SetColor('white');
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);
$subtitle_text = 'New York Office';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetColor('white');
$graph->caption->Set("Figure 1.This is a very, very\nlong text with multiples lines\nthat are added as a caption.");
$graph->caption->SetColor('white');

// Setup colors
// Make the border 40% darker than normal "khaki"
$graph->SetMarginColor('khaki:0.6');
$graph->SetColor('khaki');

// Now we need to create an odometer to add to the graph.
// By default the scale will be 0 to 100
$odo = new Odometer();

// Setup colors for odometyer plot
$odo->SetColor('white');
$odo->scale->label->SetColor('darkred');
$odo->needle->SetFillColor('yellow');

// Set display value for the odometer
$odo->needle->Set(30);

// Add the odometer to the graph
$graph->Add($odo);

// ... and finally stroke and stream the image back to the client
$graph->Stroke();
