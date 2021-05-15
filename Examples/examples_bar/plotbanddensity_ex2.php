<?php

/**
 * JPGraph v4.1.0-beta.01
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

// Add 10% grace (space) at top and botton of Y-scale.
$graph->yscale->SetGrace(10);
$graph->ygrid->Show(false);

// Create a bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetFillColor('lightblue');

// .. and add the plot to the graph
$graph->Add($bplot);

// Add band
$band = new Plot\PlotBand(Graph\Configs::getConfig('HORIZONTAL'), Graph\Configs::getConfig('BAND_3DPLANE'), 15, 35, 'khaki4');
$band->SetDensity(80);
$band->ShowFrame(true);
$graph->AddBand($band);

// Set title
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 10);
$graph->title->SetColor('darkred');
$example_title = 'BAND_3DPLANE, Density=80';
$graph->title->set($example_title);

$graph->Stroke();
