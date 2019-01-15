<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [12, 17, 22, 19, 5, 15];

$__width  = 270;
$__height = 170;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetMargin(30, 90, 30, 30);
$graph->SetScale('textlin');

$line = new Plot\LinePlot($ydata);
$line->SetLegend('2002');
$line->SetColor('darkred');
$line->SetWeight(2);
$graph->Add($line);

// Output graph
$graph->Stroke();
