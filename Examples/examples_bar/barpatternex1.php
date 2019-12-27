<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [2, 3, 5, 8.5, 11.5, 6, 3];

// Create the graph.
$__width  = 350;
$__height = 300;
$graph    = new Graph\Graph($__width, $__height);

$graph->SetScale('textlin');

$graph->SetMarginColor('navy:1.9');
$graph->SetBox();
$example_title = 'Bar Pattern';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 20);

$graph->SetTitleBackground('lightblue:1.3', Graph\Configs::getConfig('TITLEBKG_STYLE2'), Graph\Configs::getConfig('TITLEBKG_FRAME_BEVEL'));
$graph->SetTitleBackgroundFillStyle(Graph\Configs::getConfig('TITLEBKG_FILLSTYLE_HSTRIPED'), 'lightblue', 'blue');

// Create a bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetFillColor('darkorange');
$bplot->SetWidth(0.6);

$bplot->SetPattern(Graph\Configs::getConfig('PATTERN_CROSS1'), 'navy');

$graph->Add($bplot);

$graph->Stroke();
