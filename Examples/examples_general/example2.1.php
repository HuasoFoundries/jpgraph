<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [11, -3, -8, 7, 5, -1, 9, 13, 5, -7];

// Create the graph. These two calls are always required
$__width  = 300;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);

$lineplot->value->Show();
$lineplot->value->SetColor('red');
$lineplot->value->SetFont(FF_FONT1, FS_BOLD);

// Add the plot to the graph
$graph->Add($lineplot);

$graph->img->SetMargin(40, 20, 20, 40);
$graph->title->Set('Example 2.1');
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

// Display the graph
$graph->Stroke();
