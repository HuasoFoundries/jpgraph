<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Make a circle with a scatterplot
$steps = 16;
for ($i = 0; $i < $steps; ++$i) {
    $a         = 2 * M_PI / $steps * $i;
    $datax[$i] = cos($a);
    $datay[$i] = sin($a);
}

$__width  = 300;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');

$graph->img->SetMargin(40, 40, 40, 40);

$graph->SetShadow();
$graph->title->Set('Linked scatter plot');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

// 10% top and bottom grace
$graph->yscale->SetGrace(5, 5);
$graph->xscale->SetGrace(1, 1);

$sp1 = new Plot\ScatterPlot($datay, $datax);
$sp1->mark->SetType(MARK_FILLEDCIRCLE);
$sp1->mark->SetFillColor('red');
$sp1->SetColor('blue');

//$sp1->SetWeight(3);
$sp1->mark->SetWidth(4);
$sp1->SetLinkPoints();

$graph->Add($sp1);

$graph->Stroke();
