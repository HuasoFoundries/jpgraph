<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Create the Pie Graph.
$__width  = 350;
$__height = 250;
$graph    = new Graph\PieGraph($__width, $__height);
$graph->title->Set('A Simple Pie Plot');
$graph->SetBox(true);

$data = [40, 21, 17, 14, 23];
$p1   = new Plot\PiePlot($data);
$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(['#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3']);

$graph->Add($p1);
$graph->Stroke();
