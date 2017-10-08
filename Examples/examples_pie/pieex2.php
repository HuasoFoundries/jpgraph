<?php

// content="text/plain; charset=utf-8"
require_once '../../vendor/autoload.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [40, 21, 17, 14, 23];

// Create the Pie Graph.
$graph = new Graph\PieGraph(300, 200);
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set('Example 2 Pie plot');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

// Create
$p1 = new Plot\PiePlot($data);
$p1->SetLegends(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']);
$graph->Add($p1);
$graph->Stroke();
