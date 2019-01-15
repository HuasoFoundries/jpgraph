<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

require_once 'jpgraph/jpgraph_radar.php';

$__width  = 300;
$__height = 300;
$graph    = new RadarGraph($__width, $__height);
$graph->SetScale('lin', 0, 50);
$graph->yscale->ticks->Set(25, 5);
$graph->SetColor('white');
$graph->SetShadow();

$graph->SetCenter(0.5, 0.55);

$graph->axis->SetFont(FF_FONT1, FS_BOLD);
$graph->axis->SetWeight(2);

// Uncomment the following lines to also show grid lines.
$graph->grid->SetLineStyle('dashed');
$graph->grid->SetColor('navy@0.5');
$graph->grid->Show();

$graph->ShowMinorTickMarks();

$graph->title->Set('Quality result');
$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->SetTitles(['One', 'Two', 'Three', 'Four', 'Five', 'Sex', 'Seven', 'Eight', 'Nine', 'Ten']);

$plot = new RadarPlot([12, 35, 20, 30, 33, 15, 37]);
$plot->SetLegend('Goal');
$plot->SetColor('red', 'lightred');
$plot->SetFillColor('lightblue');
$plot->SetLineWeight(2);

$graph->Add($plot);
$graph->Stroke();
