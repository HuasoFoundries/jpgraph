<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
//require_once 'jpgraph/jpgraph_scatter.php';
use Amenadiel\JpGraph\Plot;

$numpoints = 50;
$k = 0.05;

// Create some data points
for ($i = -$numpoints + 1; 0 > $i; ++$i) {
    $datay[$i + $numpoints - 1] = \exp($k * $i) * \cos(2 * \M_PI / 10 * $i) * 14;
    $datayenv[$i + $numpoints - 1] = \exp($k * $i) * 14;
    $datax[$i + $numpoints - 1] = $i;
}

for ($i = 0; $i < $numpoints; ++$i) {
    $datay[$i + $numpoints - 1] = \exp(-$k * $i) * \cos(2 * \M_PI / 10 * $i) * 14;
    $datayenv[$i + $numpoints - 1] = \exp(-$k * $i) * 14;
    $datax[$i + $numpoints - 1] = $i;
}

// Setup the basic parameters for the graph
$__width = 500;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('intlin');

$graph->SetShadow();
$graph->SetBox();
$example_title = 'Impuls Example 4';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Set some other color then the boring default
$graph->SetColor('lightyellow');
$graph->SetMarginColor('khaki');

// Set legend box specification
$graph->legend->SetFillColor('white');
$graph->legend->SetLineWeight(2);

// Set X-axis at the minimum value of Y-axis (default will be at 0)
$graph->xaxis->SetPos('min'); // "min" will position the x-axis at the minimum value of the Y-axis

// Extend the margin for the labels on the Y-axis and reverse the direction
// of the ticks on the Y-axis
$graph->yaxis->SetLabelMargin(12);
$graph->xaxis->SetLabelMargin(6);
$graph->yaxis->SetTickSide(Graph\Configs::getConfig('SIDE_LEFT'));
$graph->xaxis->SetTickSide(Graph\Configs::getConfig('SIDE_DOWN'));

// Add mark graph with static lines
$line = new Plot\PlotLine(Graph\Configs::getConfig('HORIZONTAL'), 0, 'black', 2);
$graph->AddLine($line);

// Create a new impulse type scatter plot
$sp1 = new Plot\ScatterPlot($datay, $datax);
$sp1->mark->SetType(Graph\Configs::getConfig('MARK_SQUARE'));
$sp1->mark->SetFillColor('red');
$sp1->mark->SetWidth(3);

$sp1->SetImpuls();
$sp1->SetColor('blue');
$sp1->SetWeight(1);
$sp1->SetLegend('Non-causal signal');

$graph->Add($sp1);

// Create the envelope plot
$ep1 = new Plot\LinePlot($datayenv, $datax);
$ep1->SetStyle('dotted');
$ep1->SetLegend('Positive envelope');

$graph->Add($ep1);

$graph->Stroke();
