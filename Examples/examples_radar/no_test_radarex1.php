<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_radar.php';
require_once 'jpgraph/jpgraph_iconplot.php';

// Some data to plot
$data = [55, 80, 46, 71, 95];

// Create the graph and the plot
$__width  = 250;
$__height = 200;
$graph    = new RadarGraph($__width, $__height);
$plot     = new RadarPlot($data);

// Add the plot and display the graph
$graph->Add($plot);
$graph->Stroke();
