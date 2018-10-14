<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util;

$f                   = new Util\FuncGenerator('cos($i)', '$i*$i*$i');
list($xdata, $ydata) = $f->E(-M_PI, M_PI, 25);

$__width  = 380;
$__height = 450;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');
$graph->SetShadow();
$graph->img->SetMargin(50, 50, 60, 40);
$graph->SetBox(true, 'black', 2);
$graph->SetMarginColor('white');
$graph->SetColor('lightyellow');
$graph->SetAxisStyle(AXSTYLE_SIMPLE);

//$graph->xaxis->SetLabelFormat('%.1f');

$graph->title->Set('Function plot with marker');
$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->subtitle->Set('(BOXOUT Axis style)');
$graph->subtitle->SetFont(FF_FONT1, FS_NORMAL);

$lp1 = new Plot\LinePlot($ydata, $xdata);
$lp1->mark->SetType(MARK_FILLEDCIRCLE);
$lp1->mark->SetFillColor('red');
$lp1->SetColor('blue');

$graph->Add($lp1);
$graph->Stroke();
