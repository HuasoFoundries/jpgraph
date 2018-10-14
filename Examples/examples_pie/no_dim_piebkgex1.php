<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [
    [80, 18, 15, 17],
    [35, 28, 6, 34],
    [10, 28, 10, 5],
    [22, 22, 10, 17], ];

$piepos = [0.2, 0.4, 0.65, 0.28, 0.25, 0.75, 0.8, 0.75];
$titles = ['USA', 'Sweden', 'South America', 'Australia'];

$n = count($piepos) / 2;

defined('DEFAULT_THEME_CLASS') || define('DEFAULT_THEME_CLASS', 'NoTheme');
// A new Graph\Graph
$__width  = 550;
$__height = 400;
$graph    = new Graph\PieGraph($__width, $__height, 'auto');

// Specify margins since we put the image in the plot area
$graph->SetMargin(1, 1, 40, 1);
$graph->SetMarginColor('navy');
$graph->SetShadow(false);

// Setup background
$graph->SetBackgroundImage(__DIR__ . '/../assets/worldmap1.jpg', BGIMG_FILLPLOT);

// Setup title
$graph->title->Set('Pie plots with background image');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 20);
$graph->title->SetColor('white');

$p = [];
// Create the plots
for ($i = 0; $i < $n; ++$i) {
    $d   = "data${i}";
    $p[] = new Plot\PiePlot3D($data[$i]);
}

// Position the four pies
for ($i = 0; $i < $n; ++$i) {
    $p[$i]->SetCenter($piepos[2 * $i], $piepos[2 * $i + 1]);
}

// Set the titles
for ($i = 0; $i < $n; ++$i) {
    $p[$i]->title->Set($titles[$i]);
    $p[$i]->title->SetColor('white');
    $p[$i]->title->SetFont(FF_ARIAL, FS_BOLD, 12);
}

// Label font and color setup
for ($i = 0; $i < $n; ++$i) {
    $p[$i]->value->SetFont(FF_ARIAL, FS_BOLD);
    $p[$i]->value->SetColor('white');
}

// Show the percetages for each slice
for ($i = 0; $i < $n; ++$i) {
    $p[$i]->value->Show();
}

// Label format
for ($i = 0; $i < $n; ++$i) {
    $p[$i]->value->SetFormat('%01.1f%%');
}

// Size of pie in fraction of the width of the graph
for ($i = 0; $i < $n; ++$i) {
    $p[$i]->SetSize(0.15);
}

// Format the border around each slice

for ($i = 0; $i < $n; ++$i) {
    $p[$i]->SetEdge(false);
    $p[$i]->ExplodeSlice(1);
}

// Use one legend for the whole graph
$p[0]->SetLegends(['May', 'June', 'July', 'Aug']);
$graph->legend->Pos(0.05, 0.35);
$graph->legend->SetShadow(false);

for ($i = 0; $i < $n; ++$i) {
    $graph->Add($p[$i]);
}

$graph->Stroke();
