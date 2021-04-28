<?php

/**
 * JPGraph - Community Edition
 */

// Example for use of JpGraph,
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// We need some data
$datay = [0.13, 0.25, 0.21, 0.35, 0.31, 0.06];
$datax = ['January', 'February', 'March', 'April', 'May', 'June'];

// Setup the graph.
$__width = 400;
$__height = 240;
$graph = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(60, 20, 35, 75);
$graph->SetScale('textlin');
$graph->SetMarginColor('lightblue:1.1');
$graph->SetShadow();

// Set up the title for the graph$example_title='Bar gradient with left reflection'; $graph->title->set($example_title);
$graph->title->SetMargin(8);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 12);
$graph->title->SetColor('darkred');

// Setup font for axis
$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 10);
$graph->yaxis->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 10);

// Show 0 label on Y-axis (default is not to show)
$graph->yscale->ticks->SupressZeroLabel(false);

// Setup X-axis labels
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(50);

// Create the bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetWidth(0.6);

// Setup color for gradient fill style
$bplot->SetFillGradient('navy:0.9', 'navy:1.85', Graph\Configs::getConfig('GRAD_LEFT_REFLECTION'));

// Set color for the frame of each bar
$bplot->SetColor('white');
$graph->Add($bplot);

// Finally send the graph to the browser
$graph->Stroke();
