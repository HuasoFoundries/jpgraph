<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util;

$f = new Util\FuncGenerator('cos($i)', '$i*$i*$i');
[$xdata, $ydata] = $f->E(-\M_PI, \M_PI, 25);

$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');
$graph->SetMargin(50, 50, 20, 30);
$graph->SetFrame(false);
$graph->SetBox(true, 'black', 2);
$graph->SetMarginColor('white');
$graph->SetColor('lightyellow');
$example_title = 'Duplicating Y-axis';
$example_title = $example_title;
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$graph->SetAxisStyle(Graph\Configs::getConfig('AXSTYLE_YBOXIN'));
$graph->xgrid->Show();

$lp1 = new Plot\LinePlot($ydata, $xdata);
$lp1->SetColor('blue');
$lp1->SetWeight(2);
$graph->Add($lp1);

$graph->Stroke();
