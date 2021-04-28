<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data to plot
$data = [55, 80, 46, 71, 95];

// Create the graph and the plot
$__width = 250;
$__height = 200;
$graph = new Graph\RadarGraph($__width, $__height);

// Create the titles for the axis
$titles = $graph->gDateLocale->GetShortMonth();
$graph->SetTitles($titles);

$plot = new Plot\RadarPlot($data);
$plot->SetFillColor('lightblue');

// Add the plot and display the graph
$graph->Add($plot);
$graph->Stroke();
