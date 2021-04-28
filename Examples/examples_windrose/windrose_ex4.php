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
    0 => [1, 1, 2.5, 4],
    1 => [3, 4, 1, 4],
    3 => [2, 7, 4, 4, 3],
    5 => [2, 7, 1, 2], ];

// First create a new windrose graph with a title
$__width = 400;
$__height = 400;
$graph = new Graph\WindroseGraph($__width, $__height);

// Setup title
$example_title = 'Windrose example 4';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 12);
$graph->title->SetColor('navy');

// Create the windrose plot.
$wp = new Plot\WindrosePlot($data);

// Adjust the font and font color for scale labels
$wp->scale->SetFont(Graph\Configs::getConfig('FF_TIMES'), Graph\Configs::getConfig('FS_NORMAL'), 11);
$wp->scale->SetFontColor('navy');

// Set the diameter and position for plot
$wp->SetSize(190);

// Set the size of the innermost center circle to 40% of the plot size
// Note that we can have the automatic "Zero" sum appear in our custom text
$wp->SetZCircleSize(0.38);
$wp->scale->SetZeroLabel("Station 12\n(Calm %d%%)");

// Adjust color and font for center circle text
$wp->scale->SetZFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$wp->scale->SetZFontColor('darkgreen');

// Adjust the font and font color for compass directions
$wp->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 10);
$wp->SetFontColor('darkgreen');

// Adjust the margin to the compass directions
$wp->SetLabelMargin(50);

// Adjust grid colors
$wp->SetGridColor('silver', 'blue');

// Add (m/s) text to legend
$wp->legend->SetText('(m/s)');
$wp->legend->SetMargin(20, 5);

// Add and send back to client
$graph->Add($wp);
$graph->Stroke();
