<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [62, 105, 85, 50];

// Create the graph. These two calls are always required
$__width = 350;
$__height = 220;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');

//$theme_class=DefaultTheme;
//$graph->SetTheme(new $theme_class());

// set major and minor tick positions manually
$graph->yaxis->SetTickPositions([0, 30, 60, 90, 120, 150], [15, 45, 75, 105, 135]);
$graph->SetBox(false);

//$graph->ygrid->SetColor('gray');
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(['A', 'B', 'C', 'D']);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

// Create the bar plots
$b1plot = new Plot\BarPlot($datay);

// ...and add it to the graPH
$graph->Add($b1plot);

$b1plot->SetColor('white');
$b1plot->SetFillGradient('#4B0082', 'white', Graph\Configs::getConfig('GRAD_LEFT_REFLECTION'));
$b1plot->SetWidth(45);
$graph->title->Set('Bar Gradient(Left reflection)');

// Display the graph
$graph->Stroke();
