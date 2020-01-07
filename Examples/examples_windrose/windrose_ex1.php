<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [
    0     => [1, 1, 2.5, 4],
    1     => [3, 4, 1, 4],
    'wsw' => [1, 5, 5, 3],
    'N'   => [2, 7, 5, 4, 2],
    15    => [2, 7, 12], ];

// First create a new windrose graph with a title
$__width  = 400;
$__height = 400;
$graph    = new Graph\WindroseGraph($__width, $__height);

// Setup title
$example_title = 'Windrose basic example';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 12);
$graph->title->SetColor('navy');

// Create the windrose plot.
$wp = new Plot\WindrosePlot($data);
$wp->SetRadialGridStyle('solid');
$graph->Add($wp);

// Send the graph to the browser
$graph->Stroke();
