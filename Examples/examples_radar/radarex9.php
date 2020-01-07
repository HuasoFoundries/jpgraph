<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$titles = ['N', '', 'NW', '', 'W', '', 'SW', '', 'S', '', 'SE', '', 'E', '', 'NE', ''];
$data   = [0, 0, 8, 10, 70, 90, 42, 0, 70, 60, 50, 40, 30, 40, 37.8, 72];

$__width       = 250;
$__height      = 270;
$graph         = new Graph\RadarGraph($__width, $__height);
$example_title = 'Accumulated PPM';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 12);

$subtitle_text = '(according to direction)';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_ITALIC'), 10);

$graph->SetTitles($titles);
$graph->SetCenter(0.5, 0.55);
$graph->HideTickMarks();
$graph->SetColor('lightyellow');
$graph->axis->SetColor('darkgray@0.3');
$graph->grid->SetColor('darkgray@0.3');
$graph->grid->Show();

$graph->SetGridDepth(Graph\Configs::getConfig('DEPTH_BACK'));

$plot = new Plot\RadarPlot($data);
$plot->SetColor('red@0.2');
$plot->SetLineWeight(1);
$plot->SetFillColor('red@0.7');
$graph->Add($plot);
$graph->Stroke();
