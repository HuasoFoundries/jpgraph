<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

require_once 'jpgraph/jpgraph_bar.php';

function readsunspotdata($aFile, &$aYears, &$aSunspots)
{
    $lines = \file($aFile, Graph\Configs::getConfig('FILE_IGNORE_NEW_LINES') | Graph\Configs::getConfig('FILE_SKIP_EMPTY_LINES'));

    if (false === $lines) {
        throw new JpGraphException('Can not read sunspot data file.');
    }

    foreach ($lines as $line => $datarow) {
        $split = \preg_split('/[\s]+/', $datarow);
        $aYears[] = \mb_substr(\trim($split[0]), 0, 4);
        $aSunspots[] = \trim($split[1]);
    }
}

$year = [];
$ydata = [];
readsunspotdata('yearssn.txt', $year, $ydata);

// Width and height of the graph
$width = 600;
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

// Create the bar plot
$barplot = new Plot\BarPlot($ydata);

// Add the plot to the graph
$graph->Add($barplot);

// Display the graph
$graph->Stroke();
