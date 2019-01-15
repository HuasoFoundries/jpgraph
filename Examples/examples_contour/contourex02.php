<?php

/**
 * JPGraph v4.0.0
 */

// Contour plot example 02

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [
    [12, 12, 10, 10, 8, 4],
    [10, 10, 8, 14, 10, 3],
    [7, 7, 13, 17, 12, 8],
    [4, 5, 8, 12, 7, 6],
    [10, 8, 7, 8, 10, 4], ];

// Setup a basic graph context with some generous margins to be able
// to fit the legend
$__width  = 500;
$__height = 380;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetMargin(40, 140, 60, 40);

$graph->title->Set('Example of contour plot');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

// For contour plots it is custom to use a box style ofr the axis
$graph->legend->SetPos(0.05, 0.5, 'right', 'center');
$graph->SetScale('intint');
$graph->SetAxisStyle(AXSTYLE_BOXOUT);
$graph->xgrid->Show();
$graph->ygrid->Show();

// A simple contour plot with 12 isobar lines and flipped Y-coordinates
$cp = new Plot\ContourPlot($data, 12, true);

// Display the legend
$cp->ShowLegend();

// Make the isobar lines slightly thicker
$graph->Add($cp);

// ... and send the graph back to the browser
$graph->Stroke();
