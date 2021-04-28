<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [12, 17, 22, 19, 5, 15];

$__width = 270;
$__height = 170;
$graph = new Graph\Graph($__width, $__height);
$graph->SetMargin(30, 90, 30, 30);
$graph->SetScale('textlin');

$graph->img->SetAngle(45);
$graph->img->SetCenter(\floor(270 / 2), \floor(170 / 2));

$line = new Plot\LinePlot($ydata);
$line->SetLegend('2002');
$line->SetColor('darkred');
$line->SetWeight(2);
$graph->Add($line);

// Output graph
$graph->Stroke();
