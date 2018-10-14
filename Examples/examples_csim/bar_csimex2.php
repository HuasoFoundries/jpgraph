<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data1y = [12, 8, 19, 3, 10, 5];
$data2y = [8, 2, 12, 7, 14, 4];

// Create the graph. These two calls are always required
$__width  = 310;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');
$graph->img->SetMargin(40, 30, 20, 40);
$graph->SetShadow();

// Create the bar plots
$b1plot = new Plot\BarPlot($data1y);
$b1plot->SetFillColor('orange');
$targ = ['bar_csimex2.php#1', 'bar_csimex2.php#2', 'bar_csimex2.php#3',
    'bar_csimex2.php#4', 'bar_csimex2.php#5', 'bar_csimex2.php#6', ];
$alts = ['val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d'];
$b1plot->SetCSIMTargets($targ, $alts);

$b2plot = new Plot\BarPlot($data2y);
$b2plot->SetFillColor('blue');
$targ = ['bar_csimex2.php#7', 'bar_csimex2.php#8', 'bar_csimex2.php#9',
    'bar_csimex2.php#10', 'bar_csimex2.php#11', 'bar_csimex2.php#12', ];
$alts = ['val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d'];
$b2plot->SetCSIMTargets($targ, $alts);

// Create the grouped bar plot
$abplot = new Plot\AccBarPlot([$b1plot, $b2plot]);

$abplot->SetShadow();
$abplot->value->Show();

// ...and add it to the graPH
$graph->Add($abplot);

$graph->title->Set('Image map barex2');
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);

// Send back the HTML page which will call this script again
// to retrieve the image.
$graph->StrokeCSIM();
