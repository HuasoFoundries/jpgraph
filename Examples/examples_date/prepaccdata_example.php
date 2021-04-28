<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

//Create some test data
$xdata = [];
$ydata = [];

// Timestamps - 2h (=7200s) apart starting
$sampling = 7200;
$n = 50; // data points

for ($i = 0; $i < $n; ++$i) {
    $xdata[$i] = \time() + $i * $sampling;
    $ydata[0][$i] = \mt_rand(12, 15);
    $ydata[1][$i] = \mt_rand(100, 155);
    $ydata[2][$i] = \mt_rand(20, 30);
}

$formatDate = function (&$aVal) {
    $aVal = \date('Y-m-d H:i', $aVal);
};

// Apply this format to all time values in the data to prepare it to be display
\array_walk($xdata, $formatDate);

// Create the graph.
$__width = 600;
$__height = 350;
$graph = new Graph\Graph($__width, $__height);
$example_title = 'Accumulated values with specified X-axis scale';
$graph->title->set($example_title);
$graph->SetScale('textlin');

// Setup margin color
$graph->SetMarginColor('green@0.95');

// Adjust the margin to make room for the X-labels
$graph->SetMargin(40, 30, 40, 120);

// Turn the tick marks out from the plot area
$graph->xaxis->SetTickSide(Graph\Configs::getConfig('SIDE_BOTTOM'));
$graph->yaxis->SetTickSide(Graph\Configs::getConfig('SIDE_LEFT'));

$p0 = new Plot\LinePlot($ydata[0]);
$p0->SetFillColor('sandybrown');
$p1 = new Plot\LinePlot($ydata[1]);
$p1->SetFillColor('lightblue');
$p2 = new Plot\LinePlot($ydata[2]);
$p2->SetFillColor('red');
$ap = new Plot\AccLinePlot([$p0, $p1, $p2]);

$graph->xaxis->SetTickLabels($xdata);
$graph->xaxis->SetTextLabelInterval(4);

// Add the plot to the graph
$graph->Add($ap);

// Set the angle for the labels to 90 degrees
$graph->xaxis->SetLabelAngle(90);

// Display the graph
$graph->Stroke();
