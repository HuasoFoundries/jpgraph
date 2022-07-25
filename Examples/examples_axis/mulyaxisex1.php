<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$n = 8;

for ($i = 0; $i < $n; ++$i) {
    $datay[$i] = \mt_rand(1, 10);
    $datay2[$i] = \mt_rand(10, 55);
    $datay3[$i] = \mt_rand(200, 600);
    $datay4[$i] = \mt_rand(500, 800);
}

// Setup the graph
$__width = 450;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetMargin(40, 150, 40, 30);
$graph->SetMarginColor('white');

$graph->SetScale('intlin');
$example_title = 'Using multiple Y-axis';
$example_title = $example_title;
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 14);

$graph->SetYScale(0, 'lin');
$graph->SetYScale(1, 'lin');
$graph->SetYScale(2, 'lin');

$p1 = new Plot\LinePlot($datay);
$graph->Add($p1);

$p2 = new Plot\LinePlot($datay2);
$p2->SetColor('teal');
$graph->AddY(0, $p2);
$graph->ynaxis[0]->SetColor('teal');

$p3 = new Plot\LinePlot($datay3);
$p3->SetColor('red');
$graph->AddY(1, $p3);
$graph->ynaxis[1]->SetColor('red');

$p4 = new Plot\LinePlot($datay4);
$p4->SetColor('blue');
$graph->AddY(2, $p4);
$graph->ynaxis[2]->SetColor('blue');

// Output line
$graph->Stroke();
