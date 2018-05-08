<?php

/**
 * JPGraph v3.6.15
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use Amenadiel\JpGraph\Graph;
require_once 'jpgraph/jpgraph_radar.php';
require_once 'jpgraph/jpgraph_iconplot.php';

// Some data to plot
$data = [55, 80, 46, 71, 95];

// Create the graph and the plot
$graph = new RadarGraph(250, 200);
$plot  = new RadarPlot($data);

// Add the plot and display the graph
$graph->Add($plot);
$graph->Stroke();
