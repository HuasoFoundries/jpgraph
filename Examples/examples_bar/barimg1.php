<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [5, 3, 11, 6, 3];

$__width  = 400;
$__height = 300;
$graph    = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');
$example_title = 'Images on top of bars';
$graph->title->set($example_title);
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 13);

$graph->SetTitleBackground('lightblue:1.1', TITLEBKG_STYLE1, TITLEBKG_FRAME_BEVEL);

$bplot = new Plot\BarPlot($datay);
$bplot->SetFillColor('orange');
$bplot->SetWidth(0.5);

$lplot = new Plot\LinePlot($datay);
$lplot->SetColor('white@1');
$lplot->SetBarCenter();
$lplot->mark->SetType(MARK_IMG_LBALL, 'red');

$graph->Add($bplot);
$graph->Add($lplot);

$graph->Stroke();
