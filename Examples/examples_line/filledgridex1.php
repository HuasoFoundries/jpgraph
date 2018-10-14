<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay1 = [20, 15, 23, 15];
$datay2 = [12, 9, 42, 8];
$datay3 = [5, 17, 32, 24];

// Setup the graph
$__width  = 300;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetMarginColor('white');
$graph->SetScale('textlin');
$graph->SetFrame(false);
$graph->SetMargin(30, 50, 30, 30);

$graph->title->Set('Filled Y-grid');

$graph->yaxis->HideZeroLabel();
$graph->ygrid->SetFill(true, '#EFEFEF@0.5', '#BBCCFF@0.5');
$graph->xgrid->Show();

$graph->xaxis->SetTickLabels($graph->gDateLocale->GetShortMonth());

// Create the first line
$p1 = new Plot\LinePlot($datay1);
$p1->SetColor('navy');
$p1->SetLegend('Line 1');
$graph->Add($p1);

// Create the second line
$p2 = new Plot\LinePlot($datay2);
$p2->SetColor('red');
$p2->SetLegend('Line 2');
$graph->Add($p2);

// Create the third line
$p3 = new Plot\LinePlot($datay3);
$p3->SetColor('orange');
$p3->SetLegend('Line 3');
$graph->Add($p3);

$graph->legend->SetShadow('gray@0.4', 5);
$graph->legend->SetPos(0.1, 0.1, 'right', 'top');
// Output line
$graph->Stroke();
