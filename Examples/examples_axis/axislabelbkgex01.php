<?php

/**
 *  Graph\Configs::getConfig('JPG')raph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [12, 19, 3, 9, 15, 10];

// The code to setup a very basic graph
$__width  = 200;
$__height = 150;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('intlin');
$graph->SetMargin(30, 15, 40, 30);
$graph->SetMarginColor('white');
$graph->SetFrame(true, 'blue', 3);
$example_title = 'Label background';
$example_title = $example_title;
$example_title = $example_title;
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);

$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 10);
$graph->subtitle->SetColor('darkred');
$subtitle_text = 'Label without background';
$graph->subtitle->Set($subtitle_text);

$graph->SetAxisLabelBackground(Graph\Configs::getConfig('LABELBKG_NONE'), 'orange', 'red', 'lightblue', 'red');

// Use Ariel font
$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$graph->yaxis->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$graph->xgrid->Show();

// Create the plot line
$p1 = new Plot\LinePlot($ydata);
$graph->Add($p1);

// Output graph
$graph->Stroke();
