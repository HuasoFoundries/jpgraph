<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [11, 30, 20, 13, 10, 'x', 16, 12, 'x', 15, 4, 9];

// Setup the graph
$__width = 400;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('intlin');
$example_title = 'Filled line with NULL values';
$graph->title->set($example_title);
//Make sure data starts from Zero whatever data we have
$graph->yscale->SetAutoMin(0);

$p1 = new Plot\LinePlot($datay);
$p1->SetFillColor('lightblue');
$graph->Add($p1);

// Output line
$graph->Stroke();
