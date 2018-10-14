<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

require_once 'jpgraph/jpgraph_iconplot.php';

//$datay = array(20,15,23,15,17,35,22);
$datay  = [30, 25, 33, 25, 27, 45, 32];
$datay2 = [3, 25, 10, 15, 50, 5, 18];
$datay3 = [10, 5, 10, 15, 5, 2, 1];

// Setup the graph
$__width  = 400;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetMargin(40, 40, 20, 30);
$graph->SetScale('textlin');

$graph->title->Set('Adding an icon ("tux") in the background');
$graph->title->SetFont(FF_ARIAL, FS_NORMAL, 12);

//$graph->SetBackgroundGradient('red','blue');

$graph->xaxis->SetPos('min');

$p1 = new Plot\LinePlot($datay);
$p1->SetColor('blue');
$p1->SetFillGradient('yellow@0.4', 'red@0.4');

$p2 = new Plot\LinePlot($datay2);
$p2->SetColor('black');
$p2->SetFillGradient('green@0.4', 'white');

$p3 = new Plot\LinePlot($datay3);
$p3->SetColor('blue');
$p3->SetFillGradient('navy@0.4', 'white@0.4');

$graph->Add($p1);
$graph->Add($p2);
$graph->Add($p3);

$icon = new IconPlot('penguin.png', 0.2, 0.3, 1, 30);
$icon->SetAnchor('center', 'center');
$graph->Add($icon);

// Output line
$graph->Stroke();
