<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Data can be specified using both ordinal index of the axis
// as well as the direction label
$data = [
    0 => [1, 1, 2.5, 4],
    1 => [3, 4, 1, 4],
    3 => [2, 7, 4, 4, 3],
    5 => [2, 7, 1, 2], ];

// First create a new windrose graph with a title
$__width  = 400;
$__height = 400;
$graph    = new Graph\WindroseGraph($__width, $__height);

// Setup title
$graph->title->Set('Windrose example 2');
$graph->title->SetFont(FF_VERDANA, FS_BOLD, 12);
$graph->title->SetColor('navy');

// Create the windrose plot.
$wp = new Plot\WindrosePlot($data);

// Make it have 8 compass direction
$wp->SetType(WINDROSE_TYPE8);

// Setup the weight of the laegs for the different ranges
$weights = array_fill(0, 8, 10);
$wp->SetRangeWeights($weights);

// Adjust the font and font color for scale labels
$wp->scale->SetFont(FF_TIMES, FS_NORMAL, 11);
$wp->scale->SetFontColor('navy');

// Set the diametr for the plot to 160 pixels
$wp->SetSize(200);

// Set the size of the innermost center circle to 30% of the plot size
$wp->SetZCircleSize(0.2);

// Adjust the font and font color for compass directions
$wp->SetFont(FF_ARIAL, FS_NORMAL, 12);
$wp->SetFontColor('darkgreen');

// Add and send back the graph to the client
$graph->Add($wp);
$graph->Stroke();
