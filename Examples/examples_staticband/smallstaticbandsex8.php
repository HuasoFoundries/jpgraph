<?php

/**
 * JPGraph - Community Edition
 */

// Illustration of the different patterns for bands
// $Id: smallstaticbandsex8.php,v 1.1 2002/09/01 21:51:08 aditus Exp $
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [10, 29, 3, 6];

// Create the graph.
$__width = 200;
$__height = 150;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->SetMargin(25, 10, 20, 20);

// Add 10% grace ("space") at top and botton of Y-scale.
$graph->yscale->SetGrace(10);

// Create a bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetFillColor('lightblue');

// Position the X-axis at the bottom of the plotare
$graph->xaxis->SetPos('min');

$graph->ygrid->Show(false);

// .. and add the plot to the graph
$graph->Add($bplot);

// Add band
$band = new Plot\PlotBand(Graph\Configs::getConfig('HORIZONTAL'), Graph\Configs::getConfig('BAND_3DPLANE'), 15, 35, 'khaki4');
$band->ShowFrame(false);
$graph->Add($band);

// Set title
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 10);
$graph->title->SetColor('darkred');
$example_title = 'BAND_3DPLANE';
$graph->title->set($example_title);

$graph->Stroke();
