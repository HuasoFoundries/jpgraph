<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datax = [3.5, 3.7, 3, 4, 6.2, 6, 3.5, 8, 14, 8, 11.1, 13.7];
$datay = [20, 22, 12, 13, 17, 20, 16, 19, 30, 31, 40, 43];

$__width  = 300;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');

$graph->img->SetMargin(40, 40, 40, 40);
$graph->SetShadow();

$graph->title->Set('A simple scatter plot');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$sp1 = new Plot\ScatterPlot($datay, $datax);

$graph->Add($sp1);
$graph->Stroke();
