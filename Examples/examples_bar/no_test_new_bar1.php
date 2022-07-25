<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data1y = [47, 80, 40, 116];
$data2y = [61, 30, 82, 105];
$data3y = [115, 50, 70, 93];

// Create the graph. These two calls are always required
$__width = 350;
$__height = 200;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');

$theme_class = new UniversalTheme();
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions([0, 30, 60, 90, 120, 150], [15, 45, 75, 105, 135]);
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(['A', 'B', 'C', 'D']);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

// Create the bar plots
$b1plot = new Plot\BarPlot($data1y);
$b2plot = new Plot\BarPlot($data2y);
$b3plot = new Plot\BarPlot($data3y);

// Create the grouped bar plot
$gbplot = new Plot\GroupBarPlot([$b1plot, $b2plot, $b3plot]);
// ...and add it to the graPH
$graph->Add($gbplot);

$b1plot->SetColor('white');
$b1plot->SetFillColor('#cc1111');

$b2plot->SetColor('white');
$b2plot->SetFillColor('#11cccc');

$b3plot->SetColor('white');
$b3plot->SetFillColor('#1111cc');
$example_title = 'Bar Plots';
$graph->title->set($example_title);

// Display the graph
$graph->Stroke();
