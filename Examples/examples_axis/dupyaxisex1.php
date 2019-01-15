<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util;

$f                   = new Util\FuncGenerator('cos($i)', '$i*$i*$i');
list($xdata, $ydata) = $f->E(-M_PI, M_PI, 25);

$__width  = 300;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');
$graph->SetMargin(50, 50, 20, 30);
$graph->SetFrame(false);
$graph->SetBox(true, 'black', 2);
$graph->SetMarginColor('white');
$graph->SetColor('lightyellow');

$graph->title->Set('Duplicating Y-axis');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$graph->SetAxisStyle(AXSTYLE_YBOXIN);
$graph->xgrid->Show();

$lp1 = new Plot\LinePlot($ydata, $xdata);
$lp1->SetColor('blue');
$lp1->SetWeight(2);
$graph->Add($lp1);

$graph->Stroke();
