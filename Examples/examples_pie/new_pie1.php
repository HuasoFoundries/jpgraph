<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Create the Pie Graph.
$__width = 350;
$__height = 250;
$graph = new Graph\PieGraph($__width, $__height);
$example_title = 'A Simple Pie Plot';
$graph->title->set($example_title);
$graph->SetBox(true);

$data = [40, 21, 17, 14, 23];
$p1 = new Plot\PiePlot($data);
$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(['#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3']);

$graph->Add($p1);
$graph->Stroke();
