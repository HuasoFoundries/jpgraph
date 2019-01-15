<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay1 = [20, 15, 23, 15];
$datay2 = [12, 9, 42, 8];
$datay3 = [5, 17, 32, 24];

// Setup the graph
$__width  = 300;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

$theme_class = new UniversalTheme();

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Filled Y-grid');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle('solid');
$graph->xaxis->SetTickLabels(['A', 'B', 'C', 'D']);
$graph->xgrid->SetColor('#E3E3E3');
/* $graph->SetBackgroundImage("tiger_bkg.png",BGIMG_FILLPLOT); */

// Create the first line
$p1 = new Plot\LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor('#6495ED');
$p1->SetLegend('Line 1');

// Create the second line
$p2 = new Plot\LinePlot($datay2);
$graph->Add($p2);
$p2->SetColor('#B22222');
$p2->SetLegend('Line 2');

// Create the third line
$p3 = new Plot\LinePlot($datay3);
$graph->Add($p3);
$p3->SetColor('#FF1493');
$p3->SetLegend('Line 3');

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();
