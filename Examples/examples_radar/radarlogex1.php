<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data to plot
$data  = [242, 58, 1500, 12, 1397, 810, 373];
$data2 = [447, 176, 1472, 191, 1616, 42, 46];

// Create the graph
$__width  = 300;
$__height = 350;
$graph    = new Graph\RadarGraph($__width, $__height);

// Use logarithmic scale (If you don't use any SetScale()
// the radar graph will default to linear scale
$graph->SetScale('log');

$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 16);
$example_title = 'Logarithmic scale';
$graph->title->set($example_title);
$graph->title->SetMargin(10);

// Make the radar graph fill out it's bounding box
$graph->SetPlotSize(0.8);
$graph->SetCenter(0.5, 0.55);

// Uncomment the following line if you want to supress
// minor tick marks
//$graph->yscale->ticks->SupressMinorTickMarks();

// We want the major tick marks to be black and minor
// slightly less noticable
$graph->yscale->ticks->SetMarkColor('black', 'darkgray');

// Set the axis title font
$graph->axis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);
$graph->axis->title->SetColor('darkred:0.8');

// Use blue axis
$graph->axis->SetColor('blue');

$plot = new Plot\RadarPlot($data);
$plot->SetLineWeight(1);
$plot->SetColor('forestgreen');
$plot->SetFillColor('forestgreen@0.9');

$plot2 = new Plot\RadarPlot($data2);
$plot2->SetLineWeight(2);
$plot2->SetColor('red');
$plot2->SetFillColor('red@0.9');

// Add the plot and display the graph
$graph->Add($plot);
$graph->Add($plot2);
$graph->Stroke();
