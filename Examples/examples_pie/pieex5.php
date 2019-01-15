<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [40, 60, 21, 33];

// Setup graph
$__width  = 300;
$__height = 200;
$graph    = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();

// Setup graph title
$graph->title->Set('Example 5 of pie plot');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

// Create pie plot
$p1 = new Plot\PiePlot($data);
$p1->value->SetFont(FF_VERDANA, FS_BOLD);
$p1->value->SetColor('darkred');
$p1->SetSize(0.3);
$p1->SetCenter(0.4);
$p1->SetLegends(['Jan', 'Feb', 'Mar', 'Apr', 'May']);
//$p1->SetStartAngle(M_PI/8);
$p1->ExplodeSlice(3);

$graph->Add($p1);

$graph->Stroke();
