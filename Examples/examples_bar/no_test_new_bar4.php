<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [17, 22, 33, 48, 24, 20];

// Create the graph. These two calls are always required
$__width  = 220;
$__height = 300;
$graph    = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');

$theme_class = new UniversalTheme();
$graph->SetTheme($theme_class);

$graph->Set90AndMargin(50, 40, 40, 40);
$graph->img->SetAngle(90);

// set major and minor tick positions manually
$graph->SetBox(false);

//$graph->ygrid->SetColor('gray');
$graph->ygrid->Show(false);
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(['A', 'B', 'C', 'D', 'E', 'F']);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

// For background to be gradient, setfill is needed first.
$graph->SetBackgroundGradient('#00CED1', '#FFFFFF', GRAD_HOR, BGRAD_PLOT);

// Create the bar plots
$b1plot = new Plot\BarPlot($datay);

// ...and add it to the graPH
$graph->Add($b1plot);

$b1plot->SetWeight(0);
$b1plot->SetFillGradient('#808000', '#90EE90', GRAD_HOR);
$b1plot->SetWidth(17);

// Display the graph
$graph->Stroke();
