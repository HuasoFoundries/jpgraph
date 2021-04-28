<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay1 = [4, 26, 12, 18, 8, 22];
$datay2 = [12, 9, 42, 8, 20, 19];

// Setup the graph
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetMarginColor('white');
$graph->SetScale('textlin', 0, 50);
$graph->SetMargin(30, 50, 30, 30);

// We must have the frame enabled to get the gradient
// However, we don't want the frame line so we set it to
// white color which makes it invisible.
$graph->SetFrame(true, 'white');

// Setup a background gradient image
$graph->SetBackgroundGradient('blue', 'navy:0.5', Graph\Configs::getConfig('GRAD_HOR'), Graph\Configs::getConfig('BGRAD_PLOT'));

// Setup the tab title
$graph->tabtitle->Set(' 3rd Division ');
$graph->tabtitle->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 13);

// Setup x,Y grid
$graph->xgrid->Show();
$graph->xgrid->SetColor('gray@0.5');
$graph->xaxis->SetTickLabels($graph->gDateLocale->GetShortMonth());
$graph->ygrid->SetColor('gray@0.5');

// Setup color for axis and labels on axis
$graph->xaxis->SetColor('orange', 'black');
$graph->yaxis->SetColor('orange', 'black');

// Ticks on the outsid
$graph->xaxis->SetTickSide(Graph\Configs::getConfig('SIDE_DOWN'));
$graph->yaxis->SetTickSide(Graph\Configs::getConfig('SIDE_LEFT'));

// Setup the legend box colors and font
$graph->legend->SetColor('white', 'navy');
$graph->legend->SetFillColor('navy@0.25');
$graph->legend->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 8);
$graph->legend->SetShadow('darkgray@0.4', 3);
$graph->legend->SetPos(0.05, 0.05, 'right', 'top');

// Create the first line
$p1 = new Plot\LinePlot($datay1);
$p1->SetColor('red');
$p1->SetWeight(2);
$p1->SetLegend('2002');
$graph->Add($p1);

// Create the second line
$p2 = new Plot\LinePlot($datay2);
$p2->SetColor('lightyellow');
$p2->SetLegend('2001');
$p2->SetWeight(2);
$graph->Add($p2);

// Output line
$graph->Stroke();
