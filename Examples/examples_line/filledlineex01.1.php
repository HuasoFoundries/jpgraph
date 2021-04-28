<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [1.23, 1.9, 1.6, 3.1, 3.4, 2.8, 2.1, 1.9];
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

$graph->img->SetMargin(40, 40, 40, 40);
$graph->SetShadow();
$graph->SetGridDepth(Graph\Configs::getConfig('DEPTH_FRONT'));
$example_title = 'Example of filled line plot';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$p1 = new Plot\LinePlot($datay);
$p1->SetFillColor('orange');
$p1->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$p1->mark->SetFillColor('red');
$p1->mark->SetWidth(4);
$graph->Add($p1);

$graph->Stroke();
