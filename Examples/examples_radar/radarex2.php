<?php

/**
 * JPGraph v3.6.15
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use Amenadiel\JpGraph\Graph;
require_once 'jpgraph/jpgraph_radar.php';

// Some data to plot
$data = [55, 80, 46, 71, 95];

// Create the graph and the plot
$graph = new RadarGraph(300, 200);

$graph->title->Set('Weekly goals');
$graph->subtitle->Set('Year 2003');

$plot = new RadarPlot($data);
$plot->SetFillColor('lightred');
$graph->SetSize(0.6);
$graph->SetPos(0.5, 0.6);
// Add the plot and display the graph
$graph->Add($plot);
$graph->Stroke();
