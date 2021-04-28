<?php

/**
 * JPGraph - Community Edition
 */

// Contour plot example

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

// Setup a basic graph context with some generous margins to be able
// to fit the legend
$__width = 500;
$__height = 380;
$graph = new Graph\Graph($__width, $__height);
$graph->SetMargin(40, 140, 60, 40);
$example_title = 'Example of contour plot';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);

// For contour plots it is custom to use a box style ofr the axis
$graph->legend->SetPos(0.05, 0.5, 'right', 'center');
$graph->SetScale('intint');
$graph->SetAxisStyle(Graph\Configs::getConfig('AXSTYLE_BOXOUT'));
$graph->xgrid->Show();
$graph->ygrid->Show();

// A simple contour plot with default arguments (e.g. 10 isobar lines)
$cp = new Plot\ContourPlot($data);

// Display the legend
$cp->ShowLegend();

// Make the isobar lines slightly thicker
$cp->SetLineWeight(2);
$graph->Add($cp);

// ... and send the graph back to the browser
$graph->Stroke();
