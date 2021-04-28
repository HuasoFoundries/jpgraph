<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay1 = [11, 7, 5, 8, 3, 5, 5, 4, 8, 6, 5, 5, 3, 2, 5, 1, 2, 0];
$datay2 = [4, 5, 4, 5, 6, 5, 7, 4, 7, 4, 4, 3, 2, 4, 1, 2, 2, 1];
$datay3 = [4, 5, 7, 10, 13, 15, 15, 22, 26, 26, 30, 34, 40, 43, 47, 55, 60, 62];

// Create the graph. These two calls are always required
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->SetShadow();
$graph->img->SetMargin(40, 30, 20, 40);

// Create the linear plots for each category
$dplot[] = new Plot\LinePlot($datay1);
$dplot[] = new Plot\LinePlot($datay2);
$dplot[] = new Plot\LinePlot($datay3);

$dplot[0]->SetFillColor('red');
$dplot[1]->SetFillColor('blue');
$dplot[2]->SetFillColor('green');

// Create the accumulated graph
$accplot = new Plot\AccLinePlot($dplot);

// Add the plot to the graph
$graph->Add($accplot);

$graph->xaxis->SetTextTickInterval(2);
$example_title = 'Example 17';
$graph->title->set($example_title);
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Display the graph
$graph->Stroke();
