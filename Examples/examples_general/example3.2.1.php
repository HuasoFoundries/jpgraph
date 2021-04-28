<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [11, 3, 8, 12, 5, 1, 9, 15, 5, 7];

// Create the graph. These two calls are always required
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->yaxis->scale->SetGrace(10, 10);

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->mark->SetType(Graph\Configs::getConfig('MARK_CIRCLE'));

// Add the plot to the graph
$graph->Add($lineplot);

$graph->img->SetMargin(40, 20, 20, 40);
$example_title = 'Grace value, version 1';
$graph->title->set($example_title);
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$lineplot->SetColor('blue');
$lineplot->SetWeight(2);
$graph->yaxis->SetWeight(2);
$graph->SetShadow();

// Display the graph
$graph->Stroke();
