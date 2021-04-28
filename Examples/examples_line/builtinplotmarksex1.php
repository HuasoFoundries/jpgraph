<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay1 = [2, 6, 7, 12, 13, 18];
$datay2 = [5, 12, 12, 19, 25, 20];

// Setup the graph
$__width = 350;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetMargin(30, 20, 60, 20);
$graph->SetMarginColor('white');
$graph->SetScale('linlin');

// Hide the frame around the graph
$graph->SetFrame(false);

// Setup title
$example_title = 'Using Builtin PlotMarks';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 14);

// Note: requires jpgraph 1.12p or higher
// $graph->SetBackgroundGradient('blue','navy:0.5',GRAD_HOR,BGRAD_PLOT);
$graph->tabtitle->Set('Region 1');
$graph->tabtitle->SetWidth(Graph\Configs::getConfig('TABTITLE_WIDTHFULL'));

// Enable X and Y Grid
$graph->xgrid->Show();
$graph->xgrid->SetColor('gray@0.5');
$graph->ygrid->SetColor('gray@0.5');

// Format the legend box
$graph->legend->SetColor('navy');
$graph->legend->SetFillColor('lightgreen');
$graph->legend->SetLineWeight(1);
$graph->legend->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 8);
$graph->legend->SetShadow('gray@0.4', 3);
$graph->legend->SetAbsPos(15, 120, 'right', 'bottom');

// Create the line plots

$p1 = new Plot\LinePlot($datay1);
$p1->SetColor('red');
$p1->SetFillColor('yellow@0.5');
$p1->SetWeight(2);
$p1->mark->SetType(Graph\Configs::getConfig('MARK_IMG_DIAMOND'), 5, 0.6);
$p1->SetLegend('2006');
$graph->Add($p1);

$p2 = new Plot\LinePlot($datay2);
$p2->SetColor('darkgreen');
$p2->SetWeight(2);
$p2->SetLegend('2001');
$p2->mark->SetType(Graph\Configs::getConfig('MARK_IMG_MBALL'), 'red');
$graph->Add($p2);

// Add a vertical line at the end scale position '7'
$l1 = new Plot\PlotLine(Graph\Configs::getConfig('VERTICAL'), 7);
$graph->Add($l1);

// Output the graph
$graph->Stroke();
