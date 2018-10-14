<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [11, 3, 8, 12, 5, 1, 9, 13, 5, 7];

// Create the graph. These two calls are always required
$__width  = 300;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('intlin', 0, 10);
$graph->SetMargin(30, 20, 70, 40);
$graph->SetMarginColor([177, 191, 174]);

$graph->SetClipping(true);

$graph->xaxis->SetFont(FF_FONT1, FS_BOLD);

$graph->ygrid->SetLineStyle('dashed');

$graph->title->Set('Manual scale');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
$graph->title->SetColor('white');
$graph->subtitle->Set('(With clipping)');
$graph->subtitle->SetColor('white');
$graph->subtitle->SetFont(FF_ARIAL, FS_BOLD, 10);

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetColor('red');
$lineplot->SetWeight(2);

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
