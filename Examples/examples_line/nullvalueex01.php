<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$datax  = ['2001-04-01', '2001-04-02', '2001-04-03', '2001-04-04', '2001-04-05', '2001-04-06'];
$datay  = [28, 13, 24, '', 90, 11];
$data2y = [11, 41, '-', 33, '-', 63];

// Setup graph
$__width  = 400;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(40, 150, 40, 80);
$graph->SetScale('textlin');
$graph->SetShadow();

//Setup title
$graph->title->Set('Line plot with null values');

// Use built in font
$graph->title->SetFont(FF_ARIAL, FS_NORMAL, 14);

// Slightly adjust the legend from it's default position
$graph->legend->Pos(0.03, 0.5, 'right', 'center');
$graph->legend->SetFont(FF_FONT1, FS_BOLD);

// Setup X-scale
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 8);
$graph->xaxis->SetLabelAngle(45);

// Create the first line
$p1 = new Plot\LinePlot($datay);
$p1->mark->SetType(MARK_FILLEDCIRCLE);
$p1->mark->SetFillColor('red');
$p1->mark->SetWidth(4);
$p1->SetColor('blue');
$p1->SetCenter();
$p1->SetLegend("Undefined\nvariant 1");
$graph->Add($p1);

// ... and the second
$p2 = new Plot\LinePlot($data2y);
$p2->mark->SetType(MARK_STAR);
$p2->mark->SetFillColor('red');
$p2->mark->SetWidth(4);
$p2->SetColor('red');
$p2->SetCenter();
$p2->SetLegend("Undefined\nvariant 2");
$graph->Add($p2);

// Output line
$graph->Stroke();
