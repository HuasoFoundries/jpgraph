<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once 'jpgraph/jpgraph_pie.php';

$data = [40, 60, 21, 33];

$graph = new PieGraph(300, 200);
$graph->SetShadow();

$graph->title->Set('A simple Pie plot');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$p1 = new PiePlot($data);
$p1->SetLegends($gDateLocale->GetShortMonth());
$p1->SetCenter(0.4);

$graph->Add($p1);
$graph->Stroke();
