<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data1y = [12, 8, 19, 3, 10, 5];
$data2y = [8, 2, 11, 7, 14, 4];
$data3y = [3, 9, 2, 7, 5, 8];
$data4y = [1, 5, 11, 2, 14, 4];

// Create the graph. These two calls are always required
$__width  = 310;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

$graph->SetShadow();
$graph->img->SetMargin(40, 30, 20, 40);

$b1plot = new Plot\BarPlot($data1y);
$b1plot->SetFillColor('orange');
$b2plot = new Plot\BarPlot($data2y);
$b2plot->SetFillColor('blue');
$b3plot = new Plot\BarPlot($data3y);
$b3plot->SetFillColor('green');
$b4plot = new Plot\BarPlot($data4y);
$b4plot->SetFillColor('brown');

// Create the accumulated bar plots
$ab1plot = new Plot\AccBarPlot([$b1plot, $b2plot]);
$ab2plot = new Plot\AccBarPlot([$b3plot, $b4plot]);

// Create the grouped bar plot
$gbplot = new Plot\GroupBarPlot([$ab1plot, $ab2plot]);

// ...and add it to the graph
$graph->Add($gbplot);

$graph->title->Set('Grouped Accumulated bar plots');
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);

// Display the graph
$graph->Stroke();
