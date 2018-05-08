<?php

/**
 * JPGraph v3.6.15
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use Amenadiel\JpGraph\Graph;
require_once 'jpgraph/jpgraph_bar.php';
use Amenadiel\JpGraph\Plot;

$ydata = [12, 15, 22, 19, 5];

$graph = new Graph\Graph(400, 200);
$graph->img->SetMargin(40, 80, 40, 40);
$graph->SetScale('textlin');
$graph->SetShadow();

$graph->title->Set('Center the line points in bars');

$line = new Plot\LinePlot($ydata);
$line->SetBarCenter();
$line->SetWeight(2);

$bar  = new Plot\BarPlot($ydata);
$bar2 = new Plot\BarPlot($ydata);
$bar2->SetFillColor('red');

$gbar = new Plot\GroupBarPlot([$bar, $bar2]);

$graph->Add($gbar);
$graph->Add($line);

// Output line
$graph->Stroke();
