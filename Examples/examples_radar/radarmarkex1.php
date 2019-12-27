<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$titles = ['Planning', 'Quality', 'Time', 'RR', 'CR', 'DR'];
$data   = [18, 40, 70, 90, 42, 66];

$__width       = 300;
$__height      = 280;
$graph         = new Graph\RadarGraph($__width, $__height);
$example_title = 'Radar with marks';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 12);

$graph->SetTitles($titles);
$graph->SetCenter(0.5, 0.55);
$graph->HideTickMarks();
$graph->SetColor('lightgreen@0.7');
$graph->axis->SetColor('darkgray');
$graph->grid->SetColor('darkgray');
$graph->grid->Show();

$graph->axis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 12);
$graph->axis->title->SetMargin(5);
$graph->SetGridDepth(Graph\Configs::getConfig('DEPTH_BACK'));
$graph->SetSize(0.6);

$plot = new Plot\RadarPlot($data);
$plot->SetColor('red@0.2');
$plot->SetLineWeight(1);
$plot->SetFillColor('red@0.7');

$plot->mark->SetType(Graph\Configs::getConfig('MARK_IMG_SBALL'), 'red');

$graph->Add($plot);
$graph->Stroke();
