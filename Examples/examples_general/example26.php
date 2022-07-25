<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [40, 60, 21, 33];

$__width = 300;
$__height = 200;
$graph = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();
$example_title = 'A simple Pie plot';
$graph->title->set($example_title);

$p1 = new Plot\PiePlot($data);
$graph->Add($p1);
$graph->Stroke();
