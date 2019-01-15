<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [0, 25, 12, 47, 27, 27, 0];

// Setup the graph
$__width  = 350;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('intlin', 0, $aYMax = 50);

$theme_class = new UniversalTheme();
$graph->SetTheme($theme_class);

$graph->SetMargin(40, 40, 50, 40);

$graph->title->Set('Inverted Y-axis');
$graph->SetBox(false);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

// For background to be gradient, setfill is needed first.
$graph->ygrid->SetFill(true, '#FFFFFF@0.5', '#FFFFFF@0.5');
$graph->SetBackgroundGradient('#FFFFFF', '#00FF7F', GRAD_HOR, BGRAD_PLOT);

$graph->xaxis->SetTickLabels(['G', 'F', 'E', 'D', 'C', 'B', 'A']);
$graph->xaxis->SetLabelMargin(20);
$graph->yaxis->SetLabelMargin(20);

$graph->SetAxisStyle(AXSTYLE_BOXOUT);
$graph->img->SetAngle(180);

// Create the line
$p1 = new Plot\LinePlot($datay);
$graph->Add($p1);

$p1->SetFillGradient('#FFFFFF', '#F0F8FF');
$p1->SetColor('#aadddd');

// Output line
$graph->Stroke();
