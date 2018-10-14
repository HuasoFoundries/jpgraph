<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data for the five windrose plots
$data = [
    [
        1 => [10, 10, 13, 7],
        2 => [2, 8, 10],
        4 => [1, 12, 22], ],
    [
        4 => [12, 8, 2, 3],
        2 => [5, 4, 4, 5, 2], ],
    [
        1 => [12, 8, 2, 3],
        3 => [5, 4, 4, 5, 2], ],
    [
        2 => [12, 8, 2, 3],
        3 => [5, 4, 4, 5, 2], ],
    [
        4 => [12, 8, 2, 3],
        6 => [5, 4, 4, 5, 2], ],
];

// Legend range colors
$rangecolors = ['green', 'yellow', 'red', 'brown'];

// Create a windrose graph with titles
$__width  = 750;
$__height = 700;
$graph    = new Graph\WindroseGraph($__width, $__height);

$graph->title->Set('Multiple plots with automatic layout');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

// Setup the individual windrose plots
$wp = [];
for ($i = 0; $i < 5; ++$i) {
    $wp[$i] = new Plot\WindrosePlot($data[$i]);
    $wp[$i]->SetType(WINDROSE_TYPE8);
    if ($i < 2) {
        $wp[$i]->SetSize(0.28);
    } else {
        $wp[$i]->legend->Hide();
        $wp[$i]->SetSize(0.16);
        $wp[$i]->SetCenterSize(0.25);
    }
    $wp[$i]->SetRangeColors($rangecolors);
}

// Position with two rows. Two plots in top row and three plots in
// bottom row.
$hl1 = new LayoutHor([$wp[0], $wp[1]]);
$hl2 = new LayoutHor([$wp[2], $wp[3], $wp[4]]);
$vl  = new LayoutVert([$hl1, $hl2]);

$graph->Add($vl);
$graph->Stroke();
