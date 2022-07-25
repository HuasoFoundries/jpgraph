<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Data can be specified using both ordinal index of the axis
// as well as the direction label
$data[0] = [
    0 => [1, 1, 2.5, 4],
    1 => [3, 4, 1, 4],
    3 => [2, 7, 4, 4, 3],
    5 => [2, 7, 1, 2], ];

$data[1] = [
    'n' => [1, 1, 2.5, 4],
    'ssw' => [3, 4, 1, 4],
    'se' => [2, 7, 4, 4, 3], ];

// Store the position and size data for each plot in an
// array to make it easier to create multiple plots.
// The format choosen for the layout data is
// (type,x-pos,y-pos,size, z-circle size)
$layout = [
    [Plot\Configs::getConfig('WINDROSE_TYPE8'), 0.25, 0.55, 0.4, 0.25],
    [Plot\Configs::getConfig('WINDROSE_TYPE16'), 0.75, 0.55, 0.4, 0.25], ];

$legendtxt = ['(m/s) Station 7', '(m/s) Station 12'];

// First create a new windrose graph with a dropshadow
$__width = 600;
$__height = 350;
$graph = new Graph\WindroseGraph($__width, $__height);
$graph->SetShadow('darkgray');

// Setup titles$example_title='Windrose example 3'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 12);
$graph->title->SetColor('navy');
$subtitle_text = '(Multiple plots in the same graph)';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$graph->subtitle->SetColor('navy');

// Create the two windrose plots.
for ($i = 0; \count($data) > $i; ++$i) {
    $wp[$i] = new Plot\WindrosePlot($data[$i]);

    // Make it have 8 compass direction
    $wp[$i]->SetType($layout[$i][0]);

    // Adjust the font and font color for scale labels
    $wp[$i]->scale->SetFont(Graph\Configs::getConfig('FF_TIMES'), Graph\Configs::getConfig('FS_NORMAL'), 10);
    $wp[$i]->scale->SetFontColor('navy');

    // Set the position of the plot
    $wp[$i]->SetPos($layout[$i][1], $layout[$i][2]);

    // Set the diameter for the plot to 30% of the width of the graph pixels
    $wp[$i]->SetSize($layout[$i][3]);

    // Set the size of the innermost center circle to 30% of the plot size
    $wp[$i]->SetZCircleSize($layout[$i][4]);

    // Adjust the font and font color for compass directions
    $wp[$i]->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 10);
    $wp[$i]->SetFontColor('darkgreen');

    // Add legend text
    $wp[$i]->legend->SetText($legendtxt[$i]);

    $graph->Add($wp[$i]);
}

// Send the graph to the browser
$graph->Stroke();
