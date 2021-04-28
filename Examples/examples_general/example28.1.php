<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [40, 60, 21, 33, 12, 33];

$__width = 150;
$__height = 150;
$graph = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();
$example_title = "'earth' Theme";
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$p1 = new Plot\PiePlot($data);
$p1->SetTheme('earth');
$p1->SetCenter(0.5, 0.55);
$p1->value->Show(false);
$graph->Add($p1);
$graph->Stroke();
