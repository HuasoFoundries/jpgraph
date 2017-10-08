<?php

// content="text/plain; charset=utf-8"
require_once '../../vendor/autoload.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [40, 21, 17, 14, 23];

// Create the Pie Graph.
$graph = new Graph\PieGraph(300, 200, 'auto');
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set('Client side image map');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

// Create
$p1 = new Plot\PiePlot($data);
$p1->SetCenter(0.4, 0.5);

$p1->SetLegends(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']);
$targ = ['pie_csimex1.php#1', 'pie_csimex1.php#2', 'pie_csimex1.php#3',
    'pie_csimex1.php#4', 'pie_csimex1.php#5', 'pie_csimex1.php#6', ];
$alts = ['val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d'];
$p1->SetCSIMTargets($targ, $alts);

$graph->Add($p1);

// Send back the HTML page which will call this script again
// to retrieve the image.
$graph->StrokeCSIM();
