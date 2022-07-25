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

// Width and height of the graph
$width = 600;
$height = 200;

// Create a graph instance
$graph = new Graph\Graph($width, $height);

// Specify what scale we want to use,
// int = integer scale for the X-axis
// int = integer scale for the Y-axis
$graph->SetScale('intint', 0, 0, 0, \max($year) - \min($year) + 1);

// Setup a title for the graph$example_title='Sunspot example'; $graph->title->set($example_title);

// Setup titles and X-axis labels
$graph->xaxis->title->Set('(year from 1701)');
$graph->xaxis->SetTickLabels($year);

// Setup Y-axis title
$graph->yaxis->title->Set('(# sunspots)');

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetFillColor('orange@0.5');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
