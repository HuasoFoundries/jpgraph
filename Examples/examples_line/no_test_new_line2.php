<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay1 = [20, 7, 16, 46];
$datay2 = [6, 20, 10, 22];

// Setup the graph
$__width = 350;
$__height = 230;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

$theme_class = new UniversalTheme();
$graph->SetTheme($theme_class);
$example_title = 'Background Image';
$graph->title->set($example_title);
$graph->SetBox(false);

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

$graph->xaxis->SetTickLabels(['A', 'B', 'C', 'D']);
$graph->ygrid->SetFill(false);
$graph->SetBackgroundImage(__DIR__ . '/../assets/tiger_bkg.png', Graph\Configs::getConfig('BGIMG_FILLFRAME'));

$p1 = new Plot\LinePlot($datay1);
$graph->Add($p1);

$p2 = new Plot\LinePlot($datay2);
$graph->Add($p2);

$p1->SetColor('#55bbdd');
$p1->SetLegend('Line 1');
$p1->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'), '', 1.0);
$p1->mark->SetColor('#55bbdd');
$p1->mark->SetFillColor('#55bbdd');
$p1->SetCenter();

$p2->SetColor('#aaaaaa');
$p2->SetLegend('Line 2');
$p2->mark->SetType(Graph\Configs::getConfig('MARK_UTRIANGLE'), '', 1.0);
$p2->mark->SetColor('#aaaaaa');
$p2->mark->SetFillColor('#aaaaaa');
$p2->value->SetMargin(14);
$p2->SetCenter();

$graph->legend->SetFrameWeight(1);
$graph->legend->SetColor('#4E4E4E', '#00A78A');
$graph->legend->SetMarkAbsSize(8);

// Output line
$graph->Stroke();
