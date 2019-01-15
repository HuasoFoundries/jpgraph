<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$ydata = [11, 3, 8, 12, 5, 1, 9, 13, 5, 7];

// Create the graph. These two calls are always required
$__width  = 350;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetColor('blue');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
