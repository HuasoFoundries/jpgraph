<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

require_once 'jpgraph/jpgraph_radar.php';

$titles = ['N', '', 'NW', '', 'W', '', 'SW', '', 'S', '', 'SE', '', 'E', '', 'NE', ''];
$data   = [0, 0, 8, 10, 70, 90, 42, 0, 70, 60, 50, 40, 30, 40, 37.8, 72];

$__width  = 250;
$__height = 270;
$graph    = new RadarGraph($__width, $__height);

$graph->title->Set('Accumulated PPM');
$graph->title->SetFont(FF_VERDANA, FS_NORMAL, 12);

$graph->subtitle->Set('(according to direction)');
$graph->subtitle->SetFont(FF_VERDANA, FS_ITALIC, 10);

$graph->SetTitles($titles);
$graph->SetCenter(0.5, 0.55);
$graph->HideTickMarks();
$graph->SetColor('lightyellow');
$graph->axis->SetColor('darkgray@0.3');
$graph->grid->SetColor('darkgray@0.3');
$graph->grid->Show();

$graph->SetGridDepth(DEPTH_BACK);

$plot = new RadarPlot($data);
$plot->SetColor('red@0.2');
$plot->SetLineWeight(1);
$plot->SetFillColor('red@0.7');
$graph->Add($plot);
$graph->Stroke();
