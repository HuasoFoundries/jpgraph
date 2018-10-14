<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [12, 17, 22, 19, 5, 15];

$__width  = 220;
$__height = 170;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin', 3, 35);
$graph->yscale->ticks->Set(8, 2);

$graph->title->Set('Manual scale, manual ticks');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$line = new Plot\LinePlot($ydata);
$graph->Add($line);

// Output graph
$graph->Stroke();
