<?php

/**
 * JPGraph v3.6.21
 */

// Contour plot example 04

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

$graph->title->Set('Example of interpolated contour plot');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
$graph->title->SetMargin(10);

// For contour plots it is custom to use a box style ofr the axis
$graph->legend->SetPos(0.05, 0.5, 'right', 'center');
$graph->SetScale('intint');

// Setup axis and grids
$graph->SetAxisStyle(AXSTYLE_BOXOUT);
$graph->xgrid->SetLineStyle('dashed');
$graph->xgrid->Show(true);
$graph->ygrid->SetLineStyle('dashed');
$graph->ygrid->Show(true);

// A simple contour plot with 10 isobar lines and flipped Y-coordinates
// Make the data smoother by interpolate the original matrice by a factor of two
// which will make each grid cell half the original size
$cp = new Plot\ContourPlot($data, 10, 2);

$cp->UseHighContrastColor(true);

// Display the legend
$cp->ShowLegend();

// Make the isobar lines slightly thicker
$graph->Add($cp);

// ... and send the graph back to the browser
$graph->Stroke();
