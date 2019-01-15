<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay1 = [15, 21, 24, 10, 37, 29, 47];
$datay2 = [8, 6, 11, 26, 10, 4, 2];

// Setup the graph
$__width  = 300;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);

$graph->SetScale('textlin', 0, 50);

//$theme_class=new DefaultTheme;
//$graph->SetTheme($theme_class);

$graph->title->Set('Filled Area');

$graph->SetBox(false);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);
$graph->yaxis->HideZeroLabel();

$graph->xaxis->SetTickLabels(['A', 'B', 'C', 'D', 'E', 'F', 'G']);

// Create the plot
$p1 = new Plot\LinePlot($datay1);
$graph->Add($p1);

$p2 = new Plot\LinePlot($datay2);
$graph->Add($p2);

// Use an image of favourite car as marker
$p1->mark->SetType(MARK_IMG, __DIR__ . '/../assets/rose.gif', 1.0);
$p1->SetLegend('rose');
$p1->SetColor('#CD5C5C');

$p2->mark->SetType(MARK_IMG, __DIR__ . '/../assets/sunflower.gif', 1.0);
$p2->SetLegend('sunflower');
$p2->SetColor('#CD5C5C');

$graph->Stroke();
