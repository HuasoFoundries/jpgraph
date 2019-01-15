<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Data can be specified using both ordinal index of the axis
// as well as the direction label.
$data = [
    'E'  => [3, 2, 1, 2, 2],
    'N'  => [1, 1, 1.5, 2],
    'nw' => [1, 1, 1.5, 2],
    'S'  => [2, 3, 5, 1],
];

// Define the color,weight and style of some individual radial
// grid lines. Axis can be specified either by their (localized)
// label or by their index.
// Note; Depending on how many axis you have in the plot the
// index will vary between 0..n where n is the number of
// compass directions.
$axiscolors  = ['nw' => 'brown'];
$axisweights = ['nw' => 8]; // Could also be specified as 6 => 8
$axisstyles  = ['nw' => 'solid'];

// First create a new windrose graph with a title
$__width  = 400;
$__height = 500;
$graph    = new Graph\WindroseGraph($__width, $__height);
$graph->title->Set('Windrose example 9');
$graph->title->SetFont(FF_VERDANA, FS_BOLD, 14);
$graph->title->SetColor('navy');

// Create the free windrose plot.
$wp = new Plot\WindrosePlot($data);
$wp->SetType(WINDROSE_TYPE16);

// Specify colors weights and style for the radial gridlines
$wp->SetRadialColors($axiscolors);
$wp->SetRadialWeights($axisweights);
$wp->SetRadialStyles($axisstyles);

// Add some "arbitrary" text to the center
$wp->scale->SetZeroLabel("SOx\n8%%");

// Finally add it to the graph and send back to the client
$graph->Add($wp);
$graph->Stroke();
