<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [10, 29, 3, 6];

// Create the graph.
$__width  = 200;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->SetMargin(25, 10, 20, 25);
$graph->SetBox(true);

// Add 10% grace ("space") at top and botton of Y-scale.
$graph->yscale->SetGrace(10);

// Create a bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetFillColor('lightblue');

$graph->ygrid->Show(false);

// .. and add the plot to the graph
$graph->Add($bplot);

// Add band
$band = new Plot\PlotBand(HORIZONTAL, BAND_3DPLANE, 15, 35, 'khaki4');
$band->SetDensity(40);
$band->ShowFrame(true);
$graph->AddBand($band);

// Set title
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 10);
$graph->title->SetColor('darkred');
$graph->title->Set('BAND_3DPLANE, Density=40');

$graph->Stroke();
