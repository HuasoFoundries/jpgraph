<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

require_once 'jpgraph/jpgraph_flags.php';
require_once 'jpgraph/jpgraph_iconplot.php';

$datay = [30, 25, 33, 25, 27, 45, 32];

// Setup the graph
$__width  = 400;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetMargin(40, 40, 20, 30);
$graph->SetScale('textlin');

$graph->title->Set('Adding a country flag as a an icon');

$p1 = new Plot\LinePlot($datay);
$p1->SetColor('blue');
$p1->SetFillGradient('yellow@0.4', 'red@0.4');

$graph->Add($p1);

$icon = new IconPlot();
$icon->SetCountryFlag('iceland', 50, 30, 1.5, 40, 3);
$icon->SetAnchor('left', 'top');
$graph->Add($icon);

// Output line
$graph->Stroke();
