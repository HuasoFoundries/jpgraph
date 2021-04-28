<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

require_once __DIR__.'/read_sunspot_data.php'; 

$year = [];
$ydata = [];
readsunspotdata(__DIR__.'/yearssn.txt', $year, $ydata);

// Just keep the last 20 values in the arrays
$year = \array_slice($year, -20);
$ydata = \array_slice($ydata, -20);

// Width and height of the graph
$width = 600;
$height = 200;

// Create a graph instance
$graph = new Graph\Graph($width, $height);

// Specify what scale we want to use,
// text = txt scale for the X-axis
// int = integer scale for the Y-axis
$graph->SetScale('textint');

// Setup a title for the graph$example_title='Sunspot example'; $graph->title->set($example_title);

// Setup titles and X-axis labels
$graph->xaxis->title->Set('(year)');
$graph->xaxis->SetTickLabels($year);

// Setup Y-axis title
$graph->yaxis->title->Set('(# sunspots)');

// Create the bar plot
$barplot = new Plot\BarPlot($ydata);

// Add the plot to the graph
$graph->Add($barplot);

// Display the graph
$graph->Stroke();
