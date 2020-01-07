<?php

/**
 * JPgraph3 v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\Jpgraph\Graph;
use Amenadiel\Jpgraph\Plot;

$datay = [20, 22, 12, 13, 17, 20, 16, 19, 30, 31, 40, 43];

$__width  = 300;
$__height = 200;
$graph3   = new Graph\Graph($__width, $__height);
$graph3->SetScale('textlin');

$graph3->SetShadow();
$graph3->img->SetMargin(40, 40, 40, 40);
$example_title = 'Simple impulse plot';
$graph3->title->set($example_title);
$graph3->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$sp1 = new Plot\ScatterPlot($datay);
$sp1->mark->SetType(Graph\Configs::getConfig('MARK_SQUARE'));
$sp1->SetImpuls();

$graph3->Add($sp1);
$graph3->Stroke();
