<?php

/**
 * JPGraph - Community Edition
 */

// Basic contour plot example

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [
    [0.5, 1.1, 1.5, 1, 2.0, 3, 3, 2, 1, 0.1],
    [1.0, 1.5, 3.0, 5, 6.0, 2, 1, 1.2, 1, 4],
    [0.9, 2.0, 2.1, 3, 6.0, 7, 3, 2, 1, 1.4],
    [1.0, 1.5, 3.0, 4, 6.0, 5, 2, 1.5, 1, 2],
    [0.8, 2.0, 3.0, 3, 4.0, 4, 3, 2.4, 2, 3],
    [0.6, 1.1, 1.5, 1, 4.0, 3.5, 3, 2, 3, 4],
    [1.0, 1.5, 3.0, 5, 6.0, 2, 1, 1.2, 2.7, 4],
    [0.8, 2.0, 3.0, 3, 5.5, 6, 3, 2, 1, 1.4],
    [1.0, 1.5, 3.0, 4, 6.0, 5, 2, 1, 0.5, 0.2], ];

// Basic contour graph
$__width = 350;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('intint');

// Show axis on all sides
$graph->SetAxisStyle(Graph\Configs::getConfig('AXSTYLE_BOXOUT'));

// Adjust the margins to fit the margin
$graph->SetMargin(30, 100, 40, 30);

// Setup$example_title='Basic contour plot with multiple axis'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);

// A simple contour plot with default arguments (e.g. 10 isobar lines)
$cp = new Plot\ContourPlot($data);

// Flip the data around its center line
$cp->SetInvert();

// Display the legend
$cp->ShowLegend();

$graph->Add($cp);

// ... and send the graph back to the browser
$graph->Stroke();
