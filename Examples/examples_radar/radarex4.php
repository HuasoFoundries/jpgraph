<?php

/**
 * JPGraph v3.6.15
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use Amenadiel\JpGraph\Graph;
require_once 'jpgraph/jpgraph_radar.php';

// Some data to plot
$data = [55, 80, 26, 31, 95];

// Create the graph and the plot
$graph = new RadarGraph(250, 200);

// Add a drop shadow to the graph
$graph->SetShadow();

// Create the titles for the axis
$titles = $gDateLocale->GetShortMonth();
$graph->SetTitles($titles);

// Add grid lines
$graph->grid->Show();
$graph->grid->SetLineStyle('dashed');

$plot = new RadarPlot($data);
$plot->SetFillColor('lightblue');

// Add the plot and display the graph
$graph->Add($plot);
$graph->Stroke();
