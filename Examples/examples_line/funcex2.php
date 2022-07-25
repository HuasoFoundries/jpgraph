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

$__width = 380;
$__height = 450;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');
$graph->SetShadow();
$graph->img->SetMargin(50, 50, 60, 40);
$graph->SetBox(true, 'black', 2);
$graph->SetMarginColor('white');
$graph->SetColor('lightyellow');
$graph->SetAxisStyle(
    Graph\Configs::getConfig('AXSTYLE_SIMPLE')
);

//$graph->xaxis->SetLabelFormat('%.1f');
$example_title = 'Function plot with marker';
$graph->title->set($example_title);
$graph->title->SetFont(
    Graph\Configs::getConfig('FF_FONT1'),
    Graph\Configs::getConfig('FS_BOLD')
);
$subtitle_text = 'BOXOUT Axis style)';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetFont(
    Graph\Configs::getConfig('FF_FONT1'),
    Graph\Configs::getConfig('FS_NORMAL')
);

$lp1 = new Plot\LinePlot($ydata, $xdata);
$lp1->mark->SetType(
    Graph\Configs::getConfig('MARK_FILLEDCIRCLE')
);
$lp1->mark->SetFillColor('red');
$lp1->SetColor('blue');

$graph->Add($lp1);
$graph->Stroke();
