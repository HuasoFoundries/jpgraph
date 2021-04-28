<?php

/**
 * JPGraph - Community Edition
 */

// Example for use of JpGraph,
// ljp, 01/03/01 20:32
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// We need some data
$datay = [-0.13, 0.25, -0.21, 0.35, 0.31, 0.04];
$datax = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June'];

// Setup the graph.
$__width = 400;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(60, 20, 30, 50);
$graph->SetScale('textlin');
$graph->SetMarginColor('silver');
$graph->SetShadow();

// Set up the title for the graph$example_title='Example negative bars'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 16);
$graph->title->SetColor('darkred');

// Setup font for axis
$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 10);
$graph->yaxis->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 10);

// Show 0 label on Y-axis (default is not to show)
$graph->yscale->ticks->SupressZeroLabel(false);

// Setup X-axis labels
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(50);

// Set X-axis at the minimum value of Y-axis (default will be at 0)
$graph->xaxis->SetPos('min'); // min will position the x-axis at the minimum value of the Y-axis

// Create the bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetWidth(0.6);

// Setup color for gradient fill style
$bplot->SetFillGradient('navy', 'steelblue', Graph\Configs::getConfig('GRAD_MIDVER'));

// Set color for the frame of each bar
$bplot->SetColor('navy');
$graph->Add($bplot);

// Finally send the graph to the browser
$graph->Stroke();
