<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [20, 10, 35, 5, 17, 35, 22];

// Setup the graph
$__width = 400;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('intlin', 0, $aYMax = 50);
$theme_class = new UniversalTheme();
$graph->SetTheme($theme_class);

$graph->SetBox(false);
$example_title = 'Step Line';
$graph->title->set($example_title);
$graph->ygrid->Show(true);
$graph->xgrid->Show(false);
$graph->yaxis->HideZeroLabel();
$graph->ygrid->SetFill(true, '#FFFFFF@0.5', '#FFFFFF@0.5');
$graph->SetBackgroundGradient('blue', '#55eeff', Graph\Configs::getConfig('GRAD_HOR'), Graph\Configs::getConfig('BGRAD_PLOT'));
$graph->xaxis->SetTickLabels(['A', 'B', 'C', 'D', 'E', 'F', 'G']);

// Create the line
$p1 = new Plot\LinePlot($datay);
$graph->Add($p1);

$p1->SetFillGradient('yellow', 'red');
$p1->SetStepStyle();
$p1->SetColor('#808000');

// Output line
$graph->Stroke();
