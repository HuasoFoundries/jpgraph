<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_radar.php';

// Some data to plot
$data = [55, 80, 26, 31, 95];

// Create the graph and the plot
$__width  = 250;
$__height = 200;
$graph    = new RadarGraph($__width, $__height);

// Add a drop shadow to the graph
$graph->SetShadow();

// Create the titles for the axis
$titles = $graph->gDateLocale->GetShortMonth();
$graph->SetTitles($titles);
$graph->SetColor('lightyellow');

// ADjust the position to make more room
// for the legend
$graph->SetCenter(0.45, 0.5);

// Add grid lines
$graph->grid->Show();
$graph->grid->SetColor('darkred');
$graph->grid->SetLineStyle('dashed');

$plot = new RadarPlot($data);
$plot->SetFillColor('lightblue');
$plot->SetLegend('QA results');

// Add the plot and display the graph
$graph->Add($plot);
$graph->Stroke();
