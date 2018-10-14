<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$l1datay = [11, 9, 2, 4, 3, 13, 17];
$l2datay = [23, 12, 5, 19, 17, 10, 15];
$datax   = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];

// Create the graph.
$__width  = 400;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

$graph->img->SetMargin(40, 130, 20, 40);
$graph->SetShadow();

// Create the linear error plot
$l1plot = new Plot\LinePlot($l1datay);
$l1plot->SetColor('red');
$l1plot->SetWeight(2);
$l1plot->SetLegend('Prediction');

// Create the bar plot
$bplot = new Plot\BarPlot($l2datay);
$bplot->SetFillColor('orange');
$bplot->SetLegend('Result');

// Add the plots to t'he graph
$graph->Add($bplot);
$graph->Add($l1plot);

$graph->title->Set('Adding a line plot to a bar graph v1');
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);

$graph->xaxis->SetTickLabels($datax);
//$graph->xaxis->SetTextTickInterval(2);

// Display the graph
$graph->Stroke();
