<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data to plot
$data = [55, 80, 46, 71, 95];

// Create the graph and the plot
$__width       = 300;
$__height      = 200;
$graph         = new Graph\RadarGraph($__width, $__height);
$example_title = 'Weekly goals';
$graph->title->set($example_title);
$subtitle_text = 'Year 2003';
$graph->subtitle->Set($subtitle_text);

$plot = new Plot\RadarPlot($data);
$plot->SetFillColor('lightred');
$graph->SetSize(0.6);
$graph->SetPos(0.5, 0.6);
// Add the plot and display the graph
$graph->Add($plot);
$graph->Stroke();
