<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some (random) data
$ydata = [17, 3, '-', 10, 7, '-', 3, 19, 9, 7];

// Size of the overall graph
$__width = 350;
$__height = 250;

// Create the graph and set a scale.
// These two calls are always required
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('intlin');
$graph->SetShadow();

// Setup margin and titles
$graph->SetMargin(40, 20, 20, 40);
$example_title = 'Interpolated values';
$graph->title->set($example_title);
$graph->xaxis->title->Set('x-title');
$graph->yaxis->title->Set('y-title');

$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 9);
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 9);

$graph->yaxis->SetColor('blue');

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetColor('blue');
$lineplot->SetWeight(2); // Two pixel wide

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
