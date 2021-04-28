<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_pie.php';

// Some data
$data = [40, 60, 21, 33];

$piepos = [0.2, 0.35, 0.5, 0.25, 0.3, 0.7, 0.85, 0.7];
$titles = ['USA', 'Sweden', 'South America', 'Australia'];

$n = \count($piepos) / 2;

// A new Graph\Graph
$__width = 450;
$__height = 300;
$graph = new Graph\PieGraph($__width, $__height, 'auto');

$theme_class = 'PastelTheme';
$graph->SetTheme(new $theme_class());

// Setup background
$graph->SetBackgroundImage(__DIR__ . '/../assets/worldmap1.jpg', Graph\Configs::getConfig('BGIMG_FILLFRAME'));

// Setup title
$example_title = 'Pie plots with background image';
$graph->title->set($example_title);
$graph->title->SetColor('white');
$graph->SetTitleBackground('#4169E1', Graph\Configs::getConfig('TITLEBKG_STYLE2'), Graph\Configs::getConfig('TITLEBKG_FRAME_FULL'), '#4169E1', 10, 10, true);

$p = [];
// Create the plots
for ($i = 0; $i < $n; ++$i) {
    $p[] = new Plot\PiePlot3D($data);
}

for ($i = 0; $i < $n; ++$i) {
    $graph->Add($p[$i]);
}

// Position the four pies and change color
for ($i = 0; $i < $n; ++$i) {
    $p[$i]->SetCenter($piepos[2 * $i], $piepos[2 * $i + 1]);
    $p[$i]->SetSliceColors(['#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3']);
}

// Set the titles
for ($i = 0; $i < $n; ++$i) {
    $p[$i]->title->Set($titles[$i]);
    $p[$i]->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 8);
}

for ($i = 0; $i < $n; ++$i) {
    $p[$i]->value->Show(false);
}

// Size of pie in fraction of the width of the graph
for ($i = 0; $i < $n; ++$i) {
    $p[$i]->SetSize(0.13);
}

for ($i = 0; $i < $n; ++$i) {
    $p[$i]->SetEdge(false);
    $p[$i]->ExplodeSlice(1, 7);
}

$graph->Stroke();
