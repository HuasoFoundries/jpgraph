<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util;

$ydata = [11, 3, 8, 12, 5, 1, 9, 13, 5, 7];
$ydata2 = [1, 19, 15, 7, 22, 14, 5, 9, 21, 13];

$timer = new Util\JpgTimer();
$timer->Push();

// Create the graph. These two calls are always required
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

$graph->SetMargin(40, 20, 20, 60);
$example_title = 'Timing a graph';
$graph->title->set($example_title);
$graph->footer->right->Set('Timer (ms): ');
$graph->footer->right->SetFont(Graph\Configs::getConfig('FF_COURIER'), Graph\Configs::getConfig('FS_ITALIC'));
$graph->footer->SetTimer($timer);

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);

$lineplot2 = new Plot\LinePlot($ydata2);

// Add the plot to the graph
$graph->Add($lineplot);
$graph->Add($lineplot2);

$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$lineplot->SetColor('blue');
$lineplot->SetWeight(2);

$lineplot2->SetColor('orange');
$lineplot2->SetWeight(2);

$graph->yaxis->SetColor('red');
$graph->yaxis->SetWeight(2);
$graph->SetShadow();

// Display the graph
$graph->Stroke();
