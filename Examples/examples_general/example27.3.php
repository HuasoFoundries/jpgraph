<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [40, 60, 21, 33];

$__width  = 330;
$__height = 200;
$graph    = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();
$example_title = 'A simple 3D Pie plot';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$p1 = new Plot\PiePlot3D($data);
$p1->ExplodeSlice(1);
$p1->SetCenter(0.45);
$p1->SetLegends($graph->gDateLocale->GetShortMonth());

$graph->Add($p1);
$graph->Stroke();
