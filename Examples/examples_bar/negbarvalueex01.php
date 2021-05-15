<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [12, 0, -19, -7, 17, -6];

// Create the graph.
$__width  = 400;
$__height = 300;
$graph    = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(60, 30, 40, 40);
$graph->SetScale('textlin');
$graph->SetShadow();

// Create a bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetFillColor('orange');

// DIsplay value at top of each bar
$bplot->value->Show();
$bplot->SetShadow();

$graph->Add($bplot);

// Position the scale at the min of the other axis
$graph->xaxis->SetPos('min');

// Add 10% more space at top and bottom of graph
$graph->yscale->SetGrace(10, 10);

$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 12);
$example_title = 'Example of bar plot with absolute labels';
$graph->title->set($example_title);

$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 16);

$graph->Stroke();
