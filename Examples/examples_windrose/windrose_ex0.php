<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Data can be specified using both ordinal index of the axis
// as well as the direction label
$data = [
    0     => [5, 5, 5, 8],
    1     => [3, 4, 1, 4],
    'WSW' => [1, 5, 5, 3],
    'N'   => [2, 3, 8, 1, 1],
    15    => [2, 3, 5], ];

// First create a new windrose graph with a title
$__width  = 400;
$__height = 400;
$graph    = new Graph\WindroseGraph($__width, $__height);
$graph->title->Set('A basic Windrose graph');

// Create the windrose plot.
$wp = new Plot\WindrosePlot($data);

// Add and send back to browser
$graph->Add($wp);
$graph->Stroke();
