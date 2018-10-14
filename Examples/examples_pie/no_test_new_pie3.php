<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [40, 60, 21, 33];

// Create the Pie Graph.
$__width  = 350;
$__height = 250;
$graph    = new Graph\PieGraph($__width, $__height);

$theme_class = new UniversalTheme();
$graph->SetTheme($theme_class);

// Set A title for the plot
$graph->title->Set('A Simple 3D Pie Plot');

// Create
$p1 = new Plot\PiePlot3D($data);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(['#1E90FF', '#2E8B57', '#ADFF2F', '#BA55D3']);
$p1->ExplodeSlice(1);
$graph->Stroke();
