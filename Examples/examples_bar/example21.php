<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data1y = [12, 8, 19, 3, 10, 5];
$data2y = [8, 2, 11, 7, 14, 4];

// Create the graph. These two calls are always required
$__width = 310;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

$graph->SetShadow();
$graph->img->SetMargin(40, 30, 20, 40);

// Create the bar plots
$b1plot = new Plot\BarPlot($data1y);
$b1plot->SetFillColor('orange');
$b2plot = new Plot\BarPlot($data2y);
$b2plot->SetFillColor('blue');

// Create the grouped bar plot
$gbplot = new Plot\GroupBarPlot([$b1plot, $b2plot]);

// ...and add it to the graPH
$graph->Add($gbplot);
$example_title = 'Example 21';
$graph->title->set($example_title);
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Display the graph
$graph->Stroke();
