<?php

/**
 * JPGraph - Community Edition
 */

// A simple Polar graph, example 0

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [0, 1, 10, 2, 30, 25, 40, 60,
    50, 110, 60, 160, 70, 210, 75, 230, 80, 260,
    85, 270, 90, 280,
    95, 270, 100, 260, 105, 230,
    110, 210, 120, 160, 130, 110, 140, 60,
    150, 25, 170, 2, 180, 1, ];

$__width = 250;
$__height = 250;
$graph = new Graph\PolarGraph($__width, $__height);
$graph->SetScale('lin');
$graph->SetMargin(35, 35, 25, 25);
$graph->SetType(Graph\Configs::getConfig('POLAR_180'));

$p = new Plot\PolarPlot($data);
$p->SetFillColor('lightblue@0.5');
$graph->Add($p);

$graph->Stroke();
