<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$errdatay = [11, 9, 2, 4, 19, 26, 13, 19, 7, 12];

// Create the graph. These two calls are always required
$__width  = 300;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

$graph->img->SetMargin(40, 30, 20, 40);
$graph->SetShadow();

// Create the linear plot
$errplot = new Plot\ErrorLinePlot($errdatay);

$errplot->SetColor('red');
$errplot->SetWeight(2);
$errplot->SetCenter();
$errplot->line->SetWeight(2);
$errplot->line->SetColor('blue');

// Add the plot to the graph
$graph->Add($errplot);

$graph->title->Set('Linear error plot');
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);

$datax = $graph->gDateLocale->GetShortMonth();
$graph->xaxis->SetTickLabels($datax);

// Display the graph
$graph->Stroke();
