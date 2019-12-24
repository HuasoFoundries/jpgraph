<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

require_once 'jpgraph/jpgraph_bar.php';

function readsunspotdata($aFile, &$aYears, &$aSunspots)
{
    $lines = @file($aFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        throw new JpGraphException('Can not read sunspot data file.');
    }
    foreach ($lines as $line => $datarow) {
        $split       = preg_split('/[\s]+/', $datarow);
        $aYears[]    = substr(trim($split[0]), 0, 4);
        $aSunspots[] = trim($split[1]);
    }
}

$year  = [];
$ydata = [];
readsunspotdata('yearssn.txt', $year, $ydata);

// Width and height of the graph
$width  = 600;
$height = 200;

// Create a graph instance
$graph = new Graph\Graph($width, $height);

// Specify what scale we want to use,
// int = integer scale for the X-axis
// int = integer scale for the Y-axis
$graph->SetScale('intint');

// Setup a title for the graph$example_title='Sunspot example'; $graph->title->set($example_title);

// Setup titles and X-axis labels
$graph->xaxis->title->Set('(year from 1701)');

// Setup Y-axis title
$graph->yaxis->title->Set('(# sunspots)');

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
