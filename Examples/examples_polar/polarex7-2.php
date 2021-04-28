<?php

/**
 * JPGraph - Community Edition
 */

// A simple Polar graph,

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [0, 1, 30, 2, 30, 25, 40, 60,
    50, 110, 60, 160, 70, 210, 75, 230, 80, 260, 85, 370,
    90, 480,
    95, 370, 100, 260, 105, 230,
    110, 210, 120, 160, 130, 110, 140, 60,
    150, 25, 150, 2, 180, 1, ];

$n = \count($data);

for ($i = 0; $i < $n; $i += 2) {
    $data[$n + $i] = 360 - $data[$i];
    $data[$n + $i + 1] = $data[$i + 1];
}

$__width = 300;
$__height = 400;
$graph = new Graph\PolarGraph($__width, $__height);
$graph->SetScale('log', 100);
$graph->SetType(Graph\Configs::getConfig('POLAR_360'));
$graph->SetPlotSize(220, 300);

// Hide frame around graph (by setting width=0)
$graph->SetFrame(true, 'white', 1);

$graph->SetBackgroundGradient('blue:1.3', 'brown:1.4', Graph\Configs::getConfig('GRAD_MIDHOR'), Graph\Configs::getConfig('BGRAD_PLOT'));

// Set color for gradient lines
$graph->axis->SetGridColor('gray', 'gray', 'gray');
$example_title = 'Polar plot #7-2';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 16);
$graph->title->SetColor('navy');

// Adjust legen box position and color
$graph->legend->SetColor('navy', 'darkgray');
$graph->legend->SetFillColor('white');
$graph->legend->SetShadow('darkgray@0.5', 5);

$p = new Plot\PolarPlot($data);
$p->SetFillColor('yellow@0.6');
$p->mark->SetType(Graph\Configs::getConfig('MARK_SQUARE'));
$p->SetLegend("Mirophone #1\n(No amps)");

$graph->Add($p);

$graph->Stroke();
