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

$graph->title->Set('Impuls plot, variant 2');
$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->Set('Impuls respons');
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);

$sp1 = new Plot\ScatterPlot($datay); //,$datax);
$sp1->mark->SetType(MARK_FILLEDCIRCLE);
$sp1->mark->SetFillColor('red');
$sp1->mark->SetWidth(4);
$sp1->SetImpuls();
$sp1->SetColor('blue');
$sp1->SetWeight(3);

$graph->Add($sp1);
$graph->Stroke();
