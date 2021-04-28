<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Data can be specified using both ordinal index of the axis
// as well as the direction label
$data = [
    0 => [1, 1, 6, 4],
    1 => [3, 8, 1, 4],
    2 => [2, 7, 4, 4, 3],
    3 => [2, 7, 1, 2], ];

// First create a new windrose graph with a title
$__width = 400;
$__height = 400;
$graph = new Graph\WindroseGraph($__width, $__height);

// Setup title
$example_title = 'Windrose example 2';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 12);
$graph->title->SetColor('navy');

// Create the windrose plot.
$wp = new Plot\WindrosePlot($data);

// Make it have 8 compass direction
$wp->SetType(Plot\Configs::getConfig('WINDROSE_TYPE4'));

// Setup the weight of the laegs for the different ranges
$weights = \array_fill(0, 8, 10);
$wp->SetRangeWeights($weights);

// Adjust the font and font color for scale labels
$wp->scale->SetFont(Graph\Configs::getConfig('FF_TIMES'), Graph\Configs::getConfig('FS_NORMAL'), 11);
$wp->scale->SetFontColor('navy');

// Set the diametr for the plot to 160 pixels
$wp->SetSize(160);

// Set the size of the innermost center circle to 30% of the plot size
$wp->SetZCircleSize(0.2);

// Adjust the font and font color for compass directions
$wp->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 12);
$wp->SetFontColor('darkgreen');

// Add and send back to browser
$graph->Add($wp);
$graph->Stroke();
