<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

require_once 'jpgraph/jpgraph_log.php';

// Matrix size rxr
$r = 10;

// Max Interpolation factor
$f = 5;

for ($i = 1; $i <= $f; ++$i) {
    $xdata[] = $i;
    $ydata[] = pow($r * pow(2, ($i - 1)) - (pow(2, $i) - 1), 2);
}

$__width  = 400;
$__height = 240;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('intint');
$graph->SetMargin(50, 50, 20, 30);
$graph->SetFrame(false);
$graph->SetBox(true, 'black', 2);
$graph->SetMarginColor('white');
$graph->SetColor('lightyellow@0.7');

$graph->title->Set('Interpolation growth for size 10x10');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$graph->xaxis->SetTitle('Interpolation factor', 'center');
$graph->xaxis->SetTitleMargin(10);

$graph->SetAxisStyle(AXSTYLE_YBOXIN);
$graph->xgrid->Show();

$lp1 = new Plot\LinePlot($ydata, $xdata);
$lp1->SetColor('darkred');
$lp1->SetWeight(3);
$graph->Add($lp1);

$graph->Stroke();
