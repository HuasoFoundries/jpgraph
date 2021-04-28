<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datax = [3.5, 3.7, 3, 4, 6.2, 6, 3.5, 8, 14, 8, 11.1, 13.7];
$datay = [20, 22, 12, 13, 17, 20, 16, 19, 30, 31, 40, 43];
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(40, 40, 40, 40);
$graph->img->SetAntiAliasing();
$graph->SetScale('linlin');
$graph->SetShadow();
$example_title = 'Linked Scatter plot ex1';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$sp1 = new Plot\ScatterPlot($datay, $datax);
$sp1->SetLinkPoints(true, 'red', 2);
$sp1->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$sp1->mark->SetFillColor('navy');
$sp1->mark->SetWidth(3);

$graph->Add($sp1);
$graph->Stroke();
