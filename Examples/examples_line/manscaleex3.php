<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [12, 17, 22, 19, 5, 15];

$__width  = 250;
$__height = 170;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin', 3, 35);
$graph->SetTickDensity(TICKD_DENSE);
$graph->yscale->SetAutoTicks();
$example_title = 'Manual scale, auto ticks';
$graph->title->set($example_title);
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$line = new Plot\LinePlot($ydata);
$graph->Add($line);

// Output graph
$graph->Stroke();
