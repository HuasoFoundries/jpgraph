<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$__width  = 600;
$__height = 400;
$graph    = new Graph\CCBPGraph($__width, $__height);
$graph->SetTitle('Buffer penetration', '(history added)');
$graph->SetColorMap(0);

// Two "fake tasks with hostory
$datax  = [75, 83];
$datay  = [110, 64];
$datax1 = [33, 50, 67, 83];
$datay1 = [86, 76, 80, 64];
$datax2 = [18, 47, 58, 75];
$datay2 = [80, 97, 105, 110];

$sp = new Plot\ScatterPlot($datay, $datax);
$sp->mark->SetType(MARK_DIAMOND);
$sp->mark->SetFillColor('white');
$sp->mark->SetSize(12);

$sp_hist    = [];
$sp_hist[0] = new Plot\LinePlot($datay1, $datax1);
$sp_hist[0]->SetWeight(1);
$sp_hist[0]->SetColor('white');

$sp_hist[1] = new Plot\LinePlot($datay2, $datax2);
$sp_hist[1]->SetWeight(1);
$sp_hist[1]->SetColor('white');

$graph->Add($sp_hist);
$graph->Add($sp);

$graph->Stroke();
