<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [20, 22, 12, 13, 17, 20, 16, 19, 30, 31, 40, 43];

$__width  = 300;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

$graph->SetShadow();
$graph->img->SetMargin(40, 40, 40, 40);

$graph->title->Set('Simple mpuls plot');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$sp1 = new Plot\ScatterPlot($datay);
$sp1->mark->SetType(MARK_SQUARE);
$sp1->SetImpuls();

$graph->Add($sp1);
$graph->Stroke();
