<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

function toFahrenheit($aVal)
{
    return \round(($aVal * 9 / 5) + 32, 2);
}

function toCelcius($aVal)
{
    return \round(($aVal - 32) * 5 / 9, 2);
}

$datay = [2, 3, 8, 19, 7, 17, 6, 22];

// Create the graph.
$__width = 400;
$__height = 280;
$graph = new Graph\Graph($__width, $__height);

// Slightly bigger margins than default to make room for titles
$graph->SetMargin(50, 60, 40, 45);
$graph->SetMarginColor('white');

// Setup the scales for X,Y and Y2 axis
$graph->SetScale('intlin'); // X and Y axis
$graph->SetY2Scale('lin'); // Y2 axis

// Overall graph title
$example_title = 'Synchronized Y & Y2 scales';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);

// Title for X-axis
$graph->xaxis->title->Set('Measurement');
$graph->xaxis->title->SetMargin(5);
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 11);

// Create Y data set
$lplot = new Plot\LinePlot($datay);
$graph->yaxis->title->Set('Celcius (C)');
$graph->yaxis->title->SetMargin(5);
$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 11);
// ... and add the plot to the Y-axis
$graph->Add($lplot);

// Create Y2 scale data set
$l2plot = new Plot\LinePlot($datay);
$l2plot->SetWeight(0);
$graph->y2axis->title->Set('Fahrenheit (F)');
$graph->y2axis->title->SetMargin(5); // Some extra margin to clear labels
$graph->y2axis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 11);
$graph->y2axis->SetLabelFormatCallback('toFahrenheit');
$graph->y2axis->SetColor('navy');

// ... and add the plot to the Y2-axis
$graph->AddY2($l2plot);

$graph->Stroke();
