<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [40, 60, 31, 35];

// A new pie graph
$__width  = 250;
$__height = 200;
$graph    = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();

// Title setup
$graph->title->Set('Adjusting the label pos');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

// Setup the pie plot
$p1 = new Plot\PiePlot($data);

// Adjust size and position of plot
$p1->SetSize(0.4);
$p1->SetCenter(0.5, 0.52);

// Setup slice labels and move them into the plot
$p1->value->SetFont(FF_FONT1, FS_BOLD);
$p1->value->SetColor('darkred');
$p1->SetLabelPos(0.6);

// Finally add the plot
$graph->Add($p1);

// ... and stroke it
$graph->Stroke();
