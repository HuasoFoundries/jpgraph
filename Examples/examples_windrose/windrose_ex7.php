<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [
    2 => [1, 15, 7.5, 2],
    5 => [1, 1, 1.5, 2],
    7 => [1, 2, 10, 3, 2],
    9 => [2, 3, 1, 3, 1, 2],
];

// First create a new windrose graph with a title
$__width  = 400;
$__height = 450;
$graph    = new Graph\WindroseGraph($__width, $__height);
$graph->title->Set('Windrose example 7');
$graph->title->SetFont(FF_VERDANA, FS_BOLD, 14);
$graph->title->SetColor('navy');

// Create the free windrose plot.
$wp = new Plot\WindrosePlot($data);
$wp->SetType(WINDROSE_TYPE16);

// Add some "arbitrary" text to the center
$wp->scale->SetZeroLabel("SOx\n8%%");

// Localize the compass direction labels into Swedish
// Note: The labels for data must now also match the exact
// string for the compass directions.
$se_CompassLbl = ['O', 'ONO', 'NO', 'NNO', 'N', 'NNV', 'NV', 'VNV',
    'V', 'VSV', 'SV', 'SSV', 'S', 'SSO', 'SO', 'OSO', ];
$wp->SetCompassLabels($se_CompassLbl);

// Localize the "Calm" text into Swedish and make the circle
// slightly bigger than default
$se_calmtext = 'Lugnt';
$wp->legend->SetCircleText($se_calmtext);
$wp->legend->SetCircleRadius(20);

// Adjust the displayed ranges
$ranges = [1, 3, 5, 8, 12, 19, 29];
$wp->SetRanges($ranges);
//$wp->SetAntiAlias(true);

// Set the scale to always have max value of 30 with a step
// size of 12.
$wp->scale->Set(30, 12);

// Finally add it to the graph and send back to client
$graph->Add($wp);
$graph->Stroke();
