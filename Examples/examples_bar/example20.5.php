<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [12, 8, 19, 3, 10, 5];

// Create the graph. These two calls are always required
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(40, 30, 20, 40);

// Create a bar pot
$bplot = new Plot\BarPlot($datay);

// Adjust fill color
$bplot->SetFillColor('orange');

// Setup values
$bplot->value->Show();
$bplot->value->SetFormat('%d');
$bplot->value->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Center the values in the bar
$bplot->SetValuePos('center');

// Make the bar a little bit wider
$bplot->SetWidth(0.7);

$graph->Add($bplot);

// Setup the titles$example_title='Centered values for bars'; $graph->title->set($example_title);
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Display the graph
$graph->Stroke();
