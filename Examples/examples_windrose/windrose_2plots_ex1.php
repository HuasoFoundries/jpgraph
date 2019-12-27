<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Data can be specified using both ordinal idex of axis as well
// as the direction label
$data = [
    1 => [10, 10, 13, 7],
    2 => [2, 8, 10],
    4 => [1, 12, 22],
];

$data2 = [
    4 => [12, 8, 2, 3],
    2 => [5, 4, 4, 5, 2],
];

// Create a new small windrose graph
$__width  = 660;
$__height = 400;
$graph    = new Graph\WindroseGraph($__width, $__height);
$graph->SetShadow();
$example_title = 'Two windrose plots in one graph';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);
$subtitle_text = '(Using Box() for each plot)';
$graph->subtitle->Set($subtitle_text);

$wp = new Plot\WindrosePlot($data);
$wp->SetType(Plot\Configs::getConfig('WINDROSE_TYPE8'));
$wp->SetSize(0.42);
$wp->SetPos(0.25, 0.55);
$wp->SetBox();

$wp2 = new Plot\WindrosePlot($data2);
$wp2->SetType(Plot\Configs::getConfig('WINDROSE_TYPE16'));
$wp2->SetSize(0.42);
$wp2->SetPos(0.74, 0.55);
$wp2->SetBox();
$wp2->SetRangeColors(['green', 'yellow', 'red', 'brown']);

$graph->Add($wp);
$graph->Add($wp2);

$graph->Stroke();
