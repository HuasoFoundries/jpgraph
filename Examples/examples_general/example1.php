<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [11, 3, 8, 12, 5, 1, 9, 13, 5, 7];

// Create the graph. These two calls are always required
$__width  = 300;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->img->SetMargin(50, 90, 40, 50);
$graph->xaxis->SetFont(FF_FONT1, FS_BOLD);
$graph->title->Set('Examples for graph');

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetLegend('Test 1');
$lineplot->SetColor('blue');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
