<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$numpoints = 50;
$k         = 0.05;

// Create some data points
for ($i = 0; $i < $numpoints; ++$i) {
    $datay[$i] = exp(-$k * $i) * cos(2 * M_PI / 10 * $i);
}

// A format callbakc function
function mycallback($l)
{
    return sprintf('%02.2f', $l);
}

// Setup the basic parameters for the graph
$__width  = 400;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('intlin');
$graph->SetShadow();
$graph->SetBox();
$example_title = 'Impuls Example 3';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Set format callback for labels
$graph->yaxis->SetLabelFormatCallback('mycallback');

// Set X-axis at the minimum value of Y-axis (default will be at 0)
$graph->xaxis->SetPos('min'); // "min" will position the x-axis at the minimum value of the Y-axis

// Extend the margin for the labels on the Y-axis and reverse the direction
// of the ticks on the Y-axis
$graph->yaxis->SetLabelMargin(12);
$graph->xaxis->SetLabelMargin(6);
$graph->yaxis->SetTickSide(Graph\Configs::getConfig('SIDE_LEFT'));
$graph->xaxis->SetTickSide(Graph\Configs::getConfig('SIDE_DOWN'));

// Create a new impulse type scatter plot
$sp1 = new Plot\ScatterPlot($datay);
$sp1->mark->SetType(Graph\Configs::getConfig('MARK_SQUARE'));
$sp1->mark->SetFillColor('red');
$sp1->SetImpuls();
$sp1->SetColor('blue');
$sp1->SetWeight(1);
$sp1->mark->SetWidth(3);

$graph->Add($sp1);

$graph->Stroke();
