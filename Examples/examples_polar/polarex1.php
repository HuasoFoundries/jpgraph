<?php

/**
 * JPGraph - Community Edition
 */

// A simple Polar graph, example 1

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [0, 1, 10, 2, 30, 25, 40, 60,
    50, 110, 60, 160, 70, 210, 75, 230, 80, 260,
    85, 270, 90, 280,
    95, 270, 100, 260, 105, 230,
    110, 210, 120, 160, 130, 110, 140, 60,
    150, 25, 170, 2, 180, 1, ];

$__width = 600;
$__height = 500;
$graph = new Graph\PolarGraph($__width, $__height);
$graph->SetScale('lin');
$graph->SetType(Graph\Configs::getConfig('POLAR_180'));
//$graph->SetAngle(90);
//$graph->SetMargin(30-150,30-150,30+150,30+150);
$graph->Set90AndMargin(40, 40, 40, 40);
//$graph->axis->SetLabelAlign('right','center');

$p = new Plot\PolarPlot($data);
$p->SetLegend('Test');
$graph->Add($p);

$graph->Stroke();
