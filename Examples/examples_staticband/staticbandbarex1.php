<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [12, 0, -19, -7, 17, -6];

// Create the graph.
$__width = 400;
$__height = 300;
$graph = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(60, 30, 50, 40);
$graph->SetScale('textlin');
$graph->SetShadow();

$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 15);
$example_title = 'Cash flow ';
$graph->title->set($example_title);
$subtitle_text = '(Department X)';
$graph->subtitle->Set($subtitle_text);

// Show both X and Y grid
$graph->xgrid->Show(true, false);

// Add 10% grace ("space") at top and botton of Y-scale.
$graph->yscale->SetGrace(10, 10);

// Turn the tick mark out from the plot area
$graph->xaxis->SetTickSide(Graph\Configs::getConfig('SIDE_DOWN'));
$graph->yaxis->SetTickSide(Graph\Configs::getConfig('SIDE_LEFT'));

// Create a bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetFillColor('orange');

// Show the actual value for each bar on top/bottom
$bplot->value->Show(true);
$bplot->value->SetFormat('%02d kr');

// Position the X-axis at the bottom of the plotare
$graph->xaxis->SetPos('min');

// .. and add the plot to the graph
$graph->Add($bplot);

// Add band
$graph->Add(new Plot\PlotBand(Graph\Configs::getConfig('HORIZONTAL'), Graph\Configs::getConfig('BAND_HLINE'), 0, 10));

//$graph->title->Set("Test of bar gradient fill");
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 11);
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 11);

$graph->Stroke();
