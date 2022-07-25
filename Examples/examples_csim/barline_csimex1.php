<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
$ydata2 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$targ = ['#1', '#2', '#3', '#4', '#5', '#6', '#7', '#8', '#9', '#10'];
$alt = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

// Create the graph.
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->img->SetMargin(40, 20, 30, 40);
$example_title = 'CSIM example with bar and line';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Setup axis titles
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$lineplot->mark->SetWidth(5);
$lineplot->mark->SetColor('black');
$lineplot->mark->SetFillColor('red');
$lineplot->SetCSIMTargets($targ, $alt);

// Create line plot
$barplot = new Plot\BarPlot($ydata2);
$barplot->SetCSIMTargets($targ, $alt);

// Add the plots to the graph
$graph->Add($lineplot);
$graph->Add($barplot);

$graph->StrokeCSIM();
