<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [40, 60, 21, 33];

$__width = 300;
$__height = 200;
$graph = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();
$example_title = 'Example 4 of pie plot';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$p1 = new Plot\PiePlot($data);
$p1->value->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$p1->value->SetColor('darkred');
$p1->SetSize(0.3);
$p1->SetCenter(0.4);
$p1->SetLegends(['Jan', 'Feb', 'Mar', 'Apr', 'May']);
$graph->Add($p1);

$graph->Stroke();
