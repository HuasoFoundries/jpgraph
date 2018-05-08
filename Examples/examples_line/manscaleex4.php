<?php

/**
 * JPGraph v3.6.15
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [12, 17, 22, 19, 5, 15];

$graph = new Graph\Graph(220, 200);
$graph->SetScale('textlin', 3, 35);
$graph->yscale->SetAutoTicks();

$graph->title->Set('Manual scale, allow adjustment');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$line = new Plot\LinePlot($ydata);
$graph->Add($line);

// Output graph
$graph->Stroke();
