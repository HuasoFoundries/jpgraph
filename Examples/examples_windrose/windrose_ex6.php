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
    '10' => [1, 1, 2.5, 4],
    '32.0' => [3, 4, 1, 4],
    '120.5' => [2, 3, 4, 4, 3, 2, 1],
    '223.2' => [2, 4, 1, 2, 2],
    '285.7' => [2, 2, 1, 2, 4, 2, 1, 1],
];

// Specify text for direction labels
$labels = ['120.5' => "Plant\n#1275",
    '285.7' => "Reference\n#13 Ver:2", ];

// Range colors to be used
$rangeColors = ['khaki', 'yellow', 'orange', 'orange:0.7', 'brown', 'darkred', 'black'];

// First create a new windrose graph with a title
$__width = 400;
$__height = 450;
$graph = new Graph\WindroseGraph($__width, $__height);

// Setup titles$example_title='Windrose example 6'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 12);
$graph->title->SetColor('navy');

$subtitle_text = '(Free type plot)';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_ITALIC'), 10);
$graph->subtitle->SetColor('navy');

// Create the windrose plot.
$wp = new Plot\WindrosePlot($data);

// Setup a free plot
$wp->SetType(Plot\Configs::getConfig('WINDROSE_TYPEFREE'));

// Setup labels
$wp->SetLabels($labels);
$wp->SetLabelPosition(Plot\Configs::getConfig('LBLPOSITION_CENTER'));
$wp->SetLabelMargin(30);

// Setup the colors for the ranges
$wp->SetRangeColors($rangeColors);

// Adjust the font and font color for scale labels
$wp->scale->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);

// Set the diameter and position for plot
$wp->SetSize(230);
$wp->SetZCircleSize(30);

// Adjust the font and font color for compass directions
$wp->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 10);
$wp->SetFontColor('darkgreen');

// Adjust grid colors
$wp->SetGridColor('darkgreen@0.7', 'blue');

// Add (m/s) text to legend
$wp->legend->SetText('(m/s)');

// Display legend values with no decimals
$wp->legend->SetFormat('%d');

// Add plot to graph and send back to the client
$graph->Add($wp);
$graph->Stroke();
