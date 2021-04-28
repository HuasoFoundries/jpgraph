<?php

/**
 * JPGraph - Community Edition
 */

// Example of a stock chart
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_stock.php';

// Data must be in the format : open,close,min,max,median
$datay = [
    34, 42, 27, 45, 36,
    55, 25, 14, 59, 40,
    15, 40, 12, 47, 23,
    62, 38, 25, 65, 57,
    38, 49, 32, 64, 45, ];

// Setup a simple graph
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->SetMarginColor('lightblue');
$example_title = 'Box Stock chart example';
$graph->title->set($example_title);

// Create a new stock plot
$p1 = new BoxPlot($datay);

// Setup URL target for image map
$p1->SetCSIMTargets(['#1', '#2', '#3', '#4', '#5']);

// Width of the bars (in pixels)
$p1->SetWidth(9);

//$p1->SetCenter();
// Uncomment the following line to hide the horizontal end lines
//$p1->HideEndLines();

// Add the plot to the graph and send it back to the browser
$graph->Add($p1);
$graph->StrokeCSIM();
