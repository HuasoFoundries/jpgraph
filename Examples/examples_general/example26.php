<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once 'jpgraph/jpgraph_pie.php';

$data = [40, 60, 21, 33];

$graph = new PieGraph(300, 200);
$graph->SetShadow();

$graph->title->Set('A simple Pie plot');

$p1 = new PiePlot($data);
$graph->Add($p1);
$graph->Stroke();
