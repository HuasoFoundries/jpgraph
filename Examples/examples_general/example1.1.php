<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [11, 11, 11];

// Create the graph.
$__width  = 350;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->img->SetMargin(30, 90, 40, 50);
$graph->xaxis->SetFont(FF_FONT1, FS_BOLD);
$graph->title->Set('Example 1.1 same y-values');

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetLegend('Test 1');
$lineplot->SetColor('blue');
$lineplot->SetWeight(5);

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
