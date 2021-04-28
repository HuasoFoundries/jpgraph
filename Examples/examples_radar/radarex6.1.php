<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data to plot
$data = [55, 80, 26, 31, 95];
$data2 = [15, 50, 46, 39, 25];

// Create the graph and the plot
$__width = 250;
$__height = 200;
$graph = new Graph\RadarGraph($__width, $__height);

// Add a drop shadow to the graph
$graph->SetShadow();

// Create the titles for the axis
$titles = $graph->gDateLocale->GetShortMonth();
$graph->SetTitles($titles);
$graph->SetColor('lightyellow');

// ADjust the position to make more room
// for the legend
$graph->SetCenter(0.4, 0.55);
$graph->SetSize(0.6);

// Add grid lines
$graph->grid->Show();
$graph->grid->SetColor('darkred');
$graph->grid->SetLineStyle('dotted');

$plot = new Plot\RadarPlot($data);
$plot->SetFillColor('lightblue');
$plot->SetLegend('QA results');

$plot2 = new Plot\RadarPlot($data2);
$plot2->SetLegend('Target');
$plot2->SetColor('red');
$plot2->SetFill(false);
$plot2->SetLineWeight(2);

// Add the plot and display the graph
$graph->Add($plot);
$graph->Add($plot2);
$graph->Stroke();
