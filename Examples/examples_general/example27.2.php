<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [40, 60, 21, 33];

$__width  = 300;
$__height = 200;
$graph    = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();

$graph->title->Set('A simple Pie plot');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$p1 = new Plot\PiePlot($data);
$p1->ExplodeSlice(1);
$p1->SetCenter(0.45);
$p1->SetLegends($graph->gDateLocale->GetShortMonth());

$graph->Add($p1);
$graph->Stroke();
