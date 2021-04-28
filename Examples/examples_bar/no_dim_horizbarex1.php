<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [2, 3, 5, 8, 12, 6, 3];
$datax = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'];

// Size of graph
$__width = 400;
$__height = 500;

// Set the basic parameters of the graph
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');

// Rotate graph 90 degrees and set margin
$graph->Set90AndMargin(50, 20, 50, 30);

// Nice shadow
$graph->SetShadow();

// Setup title
$example_title = 'Horizontal bar graph ex 1';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 14);

// Setup X-axis
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 12);

// Some extra margin looks nicer
$graph->xaxis->SetLabelMargin(10);

// Label align for X-axis
$graph->xaxis->SetLabelAlign('right', 'center');

// Add some grace to y-axis so the bars doesn't go
// all the way to the end of the plot area
$graph->yaxis->scale->SetGrace(20);

// We don't want to display Y-axis
$graph->yaxis->Hide();

// Now create a bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetFillColor('orange');
$bplot->SetShadow();

//You can change the width of the bars if you like
//$bplot->SetWidth(0.5);

// We want to display the value of each bar at the top
$bplot->value->Show();
$bplot->value->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$bplot->value->SetAlign('left', 'center');
$bplot->value->SetColor('black', 'darkred');
$bplot->value->SetFormat('%.1f mkr');

// Add the bar to the graph
$graph->Add($bplot);

// .. and stroke the graph
$graph->Stroke();
