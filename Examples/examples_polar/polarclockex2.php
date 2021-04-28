<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

//$data = array(22,12,27,40,80,48,120,40,142,27,170,12);

$data = [
    0, 0, 10, 2, 30, 25, 40, 60,
    50, 110, 60, 140, 70, 170, 80, 190,
    85, 195, 90, 200, 95, 195, 100, 190,
    110, 170, 120, 140, 130, 110, 140, 60,
    150, 25, 170, 2, 180, 0, ];

//$data2 = array(0,0,50,2,60,30,65,90,60,120,50,150,20,170,0,180);

$data2 = [0, 0, 34, 56, 90, 90, 170, 65, 220, 90, 270, 120, 300, 60, 355, 10];

$__width = 350;
$__height = 350;
$graph = new Graph\PolarGraph($__width, $__height);
$graph->SetScale('lin', 150);

$graph->SetMarginColor('#FFE6C0');
$graph->SetType(Graph\Configs::getConfig('POLAR_360'));
$graph->SetClockwise(true);
$graph->Set90AndMargin(40, 40, 50, 40);

$graph->SetBox(true);
$graph->SetFrame(false);
$graph->axis->ShowGrid(true, false, true);
$graph->axis->SetGridColor('gray', 'gray', 'gray');

$graph->axis->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 8);
$graph->axis->SetTitle('X-Axis', 'center');

$graph->axis->SetColor('black', 'black', 'darkred');
$graph->axis->SetAngleFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 8);

$graph->title->Set('Clockwise polar plot (rotated)');
$graph->title->SetFont(Graph\Configs::getConfig('FF_COMIC'), Graph\Configs::getConfig('FS_NORMAL'), 16);
$graph->title->SetColor('navy');

$p = new Plot\PolarPlot($data);
$p->SetFillColor('lightblue@0.5');
$graph->Add($p);

//$p2 = new Plot\PolarPlot($data2);
//$p2->SetFillColor('red@0.5');
//$graph->Add($p2);

$graph->Stroke();
