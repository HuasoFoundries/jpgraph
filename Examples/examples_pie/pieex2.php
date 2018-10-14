<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [40, 21, 17, 14, 23];

// Create the Pie Graph.
$__width  = 300;
$__height = 200;
$graph    = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set('Example 2 Pie plot');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

// Create
$p1 = new Plot\PiePlot($data);
$p1->SetLegends(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']);
$graph->Add($p1);
$graph->Stroke();
