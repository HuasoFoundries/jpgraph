<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ab2 = [1.5, 2.0, 2.5, 3.0, 4.0, 5.0, 6.0, 8.0, 10.0,
    12.0, 15.0, 20.0, 25.0, 30.0, 40.0, 50.0, 60.0, 75.0,
    100., 125., 150., ];
$mn2 = [0.5, 0.5, 0.5, 0.5, 0.8, 0.8, 0.8, 0.8, 1.0,
    1.0, 1.0, 1.0, 1.0, 2.0, 2.0, 2.0, 2.0, 2.0,
    5.0, 5.0, 5.0, ];
$rhos = [30.0, 31.0, 32.0, 34.0, 35.5, 37.5, 38.0, 39.5, 41.5,
    43.0, 41.0, 42.0, 42.5, 45.0, 49.0, 53.5, 58.0, 66.5,
    75.0, 81.0, 89.0, ];

// Create the graph.
$__width = 500;
$__height = 300;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('loglog');
$graph->SetY2Scale('lin');
$graph->y2axis->SetColor('blue', 'blue');

$graph->img->SetMargin(50, 70, 40, 50);
$example_title = 'Geoelektrik';
$graph->title->set($example_title);
$graph->xaxis->title->Set('Auslage ab/2 [m]');
$graph->yaxis->title->Set('rho_s [Ohm m]');
$graph->y2axis->title->Set('mn/2 [m]');
$graph->y2axis->title->SetColor('blue');
$graph->y2axis->SetTitleMargin(35);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xgrid->Show(true, true);
$graph->ygrid->Show(true, true);

// Create the linear plot

$lineplot = new Plot\LinePlot($rhos, $ab2);
$lineplot->SetWeight(1);
$lineplot->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$lineplot->mark->SetWidth(2);

// Create scatter plot

$scplot = new Plot\ScatterPlot($mn2, $ab2);
$scplot->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$scplot->mark->SetColor('blue');
$scplot->mark->SetWidth(2);

// Add plots to the graph

$graph->AddY2($scplot);
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
