<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$titles = ['N', '', 'NW', '', 'W', '', 'SW', '', 'S', '', 'SE', '', 'E', '', 'NE', ''];
$data = [
    0, 0,
    0.8,
    0.10,
    0.70,
    0.90,
    0.42,
    0.0,
    0.70,
    0.60,
    0.50,
    0.40,
    0.30,
    0.40,
    0.378,
    0.72,
];

$graph = new Graph\RadarGraph(1140, 850);
$graph->SetCenter(0.52, 0.5);
$graph->SetScale('lin', 0, 8);
$graph->SetFrame(false);
$graph->legend->SetPos(0.77, 0.02, 'left', 'top');

$graph->legend->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 16);

$graph->SetTitles($titles);

$graph->axis->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 11);
$graph->axis->SetWeight(2);

$graph->axis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 16);
$graph->axis->SetColor('black', [225, 100, 150, 0.8]);
$graph->axis->scale->ticks->Set(1, 2, 3);
$graph->grid->Show();
$teamPlot = new Plot\RadarPlot($data);
$teamPlot->SetColor('blue', 'lightblue');
$teamPlot->SetLegend('Initial Assessment');
$graph->Add($teamPlot);
$img = $graph->Stroke();
