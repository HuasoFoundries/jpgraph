<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [20, 15, 33, 5, 17, 35, 22];

// Setup the graph
$__width = 400;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetMargin(40, 40, 20, 30);
$graph->SetScale('intlin');
$graph->SetMarginColor('darkgreen@0.8');
$example_title = 'Gradient filled line plot';
$graph->title->set($example_title);
$graph->yscale->SetAutoMin(0);

// Create the line
$p1 = new Plot\LinePlot($datay);
$p1->SetColor('blue');
$p1->SetWeight(0);
$p1->SetFillGradient('red', 'yellow');

$graph->Add($p1);

// Output line
$graph->Stroke();
