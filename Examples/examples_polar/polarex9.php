<?php

/**
 * JPGraph v4.0.0
 */

// A simple Polar graph,

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [0, 1, 10, 2, 30, 25, 40, 60,
    50, 110, 60, 160, 70, 210, 75, 230, 80, 260, 85, 370,
    90, 480,
    95, 370, 100, 260, 105, 230,
    110, 210, 120, 160, 130, 110, 140, 60,
    150, 25, 170, 2, 180, 1];

$__width  = 350;
$__height = 320;
$graph    = new Graph\PolarGraph($__width, $__height);
$graph->SetScale('log', 100);
$graph->SetType(Graph\Configs::getConfig('POLAR_180'));

// Hide frame around graph (by setting width=0)
$graph->SetFrame(true, 'white', 1);

// Show both major and minor grid lines
$graph->axis->ShowGrid(true, true);

// Set color for gradient lines
$graph->axis->SetGridColor('lightblue:0.9', 'lightblue:0.9', 'lightblue:0.9');

// Set label and axis colors
$graph->axis->SetColor('black', 'navy', 'darkred');

// Draw the ticks on the bottom side of the radius axis
$graph->axis->SetTickSide(Graph\Configs::getConfig('SIDE_DOWN'));

// Increase the margin for the labels since we changed the
// side of the ticks.
$graph->axis->SetLabelMargin(6);

// Change fonts
$graph->axis->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 8);
$graph->axis->SetAngleFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 8);

// Setup axis title
$graph->axis->SetTitle('Coverage (in meter)', 'middle');
$graph->axis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Setup graph title$example_title='Polar plot #9'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 16);
$graph->title->SetColor('navy');

// Setup tab title
$graph->tabtitle->Set('Microphone #1');
$graph->tabtitle->SetColor('brown:0.5', 'lightyellow');

$p = new Plot\PolarPlot($data);
$p->SetFillColor('lightblue@0.5');
$p->mark->SetType(Graph\Configs::getConfig('MARK_SQUARE'));

$graph->Add($p);

$graph->Stroke();
