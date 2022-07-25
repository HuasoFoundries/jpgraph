<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [12, 26, 9, 17, 31];

// Create the graph.
// One minute timeout for the cached image
// Graph\Configs::getConfig('INLINE_NO') means don't stream it back to the browser.
$__width = 310;
$__height = 250;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');
$graph->img->SetMargin(60, 30, 20, 40);
$graph->yaxis->SetTitleMargin(45);
$graph->yaxis->scale->SetGrace(30);
$graph->SetShadow();

// Turn the tickmarks
$graph->xaxis->SetTickSide(Graph\Configs::getConfig('SIDE_DOWN'));
$graph->yaxis->SetTickSide(Graph\Configs::getConfig('SIDE_LEFT'));

// Create a bar pot
$bplot = new Plot\BarPlot($datay);

// Create targets for the image maps. One for each column
$targ = ['bar_csimex1.php#1', 'bar_csimex1.php#2', 'bar_csimex1.php#3', 'bar_csimex1.php#4', 'bar_csimex1.php#5', 'bar_csimex1.php#6'];
$alts = ['val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d'];
$bplot->SetCSIMTargets($targ, $alts);
$bplot->SetFillColor('orange');

// Use a shadow on the bar graphs (just use the default settings)
$bplot->SetShadow();
$bplot->value->SetFormat(' $ %2.1f', 70);
$bplot->value->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$bplot->value->SetColor('blue');
$bplot->value->Show();

$graph->Add($bplot);
$example_title = 'Image maps barex1';
$graph->title->set($example_title);
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Send back the HTML page which will call this script again
// to retrieve the image.
$graph->StrokeCSIM();
