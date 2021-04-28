<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

//$datax = array(3.5,3.7,3,4,6.2,6,3.5,8,14,8,11.1,13.7);
$datay = [1.23, 1.9, 1.6, 3.1, 3.4, 2.8, 2.1, 1.9];
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(40, 40, 40, 40);
$graph->img->SetAntiAliasing();
$graph->SetScale('textlin');
$graph->SetShadow();
$example_title = 'Example of line centered plot';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Use 20% "grace" to get slightly larger scale then min/max of
// data
$graph->yscale->SetGrace(20);

$p1 = new Plot\LinePlot($datay);
$p1->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$p1->mark->SetFillColor('red');
$p1->mark->SetWidth(4);
$p1->SetColor('blue');
$p1->SetCenter();
$graph->Add($p1);

$graph->Stroke();
