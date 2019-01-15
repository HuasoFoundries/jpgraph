<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [20, 27, 45, 75, 90];

// Create the Pie Graph.
$__width  = 350;
$__height = 200;
$graph    = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set('Example 3 3D Pie plot');
$graph->title->SetFont(FF_VERDANA, FS_BOLD, 18);
$graph->title->SetColor('darkblue');
$graph->legend->Pos(0.1, 0.2);

// Create 3D pie plot
$p1 = new Plot\PiePlot3D($data);
$p1->SetTheme('sand');
$p1->SetCenter(0.4);
$p1->SetSize(80);

// Adjust projection angle
$p1->SetAngle(45);

// As a shortcut you can easily explode one numbered slice with
$p1->ExplodeSlice(3);

// Setup the slice values
$p1->value->SetFont(FF_ARIAL, FS_BOLD, 11);
$p1->value->SetColor('navy');

$p1->SetLegends(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct']);

$graph->Add($p1);
$graph->Stroke();
