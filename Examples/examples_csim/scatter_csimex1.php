<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data for the points
$datax = [3.5, 13.7, 3, 4, 6.2, 6, 3.5, 8, 14, 8, 11.1, 13.7];
$datay = [10, 22, 12, 13, 17, 20, 16, 19, 30, 31, 40, 43];

// A new scatter graph
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetShadow();
$graph->SetScale('linlin');

//$graph->img->SetMargin(40,40,40,40);
$example_title = 'Scatter plot with Image Map';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Client side image map targets
$targ = ['pie_csimex1.php#1', 'pie_csimex1.php#2', 'pie_csimex1.php#3',
    'pie_csimex1.php#4', 'pie_csimex1.php#5', 'pie_csimex1.php#6',
    'pie_csimex1.php#7', 'pie_csimex1.php#8', 'pie_csimex1.php#9', ];

// Strings to put as "alts" (and "title" value)
$alts = ['val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d'];

// Create a new scatter plot
$sp1 = new Plot\ScatterPlot($datay, $datax);

// Use diamonds as markerss
$sp1->mark->SetType(Graph\Configs::getConfig('MARK_DIAMOND'));
$sp1->mark->SetWidth(10);

// Set the scatter plot image map targets
$sp1->SetCSIMTargets($targ, $alts);

// Add the plot
$graph->Add($sp1);

// Send back the Graph\Configs::getConfig('HTML') page which will call this script again
// to retrieve the image.
$graph->StrokeCSIM();
