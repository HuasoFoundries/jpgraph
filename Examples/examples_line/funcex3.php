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

$__width = 350;
$__height = 430;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');
$graph->SetShadow();
$graph->img->SetMargin(50, 50, 60, 40);
$graph->SetBox(true, 'black', 2);
$graph->SetMarginColor('white');
$graph->SetColor('lightyellow');
$graph->SetAxisStyle(Graph\Configs::getConfig('AXSTYLE_BOXIN'));
$graph->xgrid->Show();

//$graph->xaxis->SetLabelFormat('%.0f');

$graph->img->SetMargin(50, 50, 60, 40);
$example_title = 'Function plot';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$subtitle_text = ' BOXIN  Axis style)';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_NORMAL'));

$lp1 = new Plot\LinePlot($ydata, $xdata);
$lp1->SetColor('blue');
$lp1->SetWeight(2);

$graph->Add($lp1);
$graph->Stroke();
