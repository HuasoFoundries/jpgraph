<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$__width = 300;
$__height = 300;
$graph = new Graph\RadarGraph($__width, $__height);
$graph->SetScale('lin', 0, 50);
$graph->yscale->ticks->Set(25, 5);
$graph->SetColor('white');
$graph->SetShadow();

$graph->SetCenter(0.5, 0.55);

$graph->axis->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->axis->SetWeight(2);

// Uncomment the following lines to also show grid lines.
$graph->grid->SetLineStyle('dashed');
$graph->grid->SetColor('navy@0.5');
$graph->grid->Show();

$graph->ShowMinorTickMarks();
$example_title = 'Quality result';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->SetTitles(['One', 'Two', 'Three', 'Four', 'Five', 'Sex', 'Seven', 'Eight', 'Nine', 'Ten']);

$plot = new Plot\RadarPlot([12, 35, 20, 30, 33, 15, 37]);
$plot->SetLegend('Goal');
$plot->SetColor('red', 'lightred');
$plot->SetFillColor('lightblue');
$plot->SetLineWeight(2);

$graph->Add($plot);
$graph->Stroke();
