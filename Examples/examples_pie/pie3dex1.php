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
$graph->title->Set('Example 1 3D Pie plot');
$graph->title->SetFont(FF_VERDANA, FS_BOLD, 18);
$graph->title->SetColor('darkblue');
$graph->legend->Pos(0.1, 0.2);

// Create pie plot
$p1 = new Plot\PiePlot3D($data);
$p1->SetTheme('sand');
$p1->SetCenter(0.4);
$p1->SetAngle(30);
$p1->value->SetFont(FF_ARIAL, FS_NORMAL, 12);
$p1->SetLegends(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct']);

$graph->Add($p1);
$graph->Stroke();
