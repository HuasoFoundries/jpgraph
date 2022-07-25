<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [2, 3, 5, 8.5, 11.5, 6, 3];

// Create the graph.
$__width = 460;
$__height = 400;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');
$graph->SetMargin(40, 20, 50, 70);

$graph->legend->SetPos(0.5, 0.97, 'center', 'bottom');
$example_title = 'Plot line legend';
$graph->title->set($example_title);
$graph->title->SetFont(
    Graph\Configs::getConfig('FF_ARIAL'),
    Graph\Configs::getConfig('FS_BOLD'),
    14
);

$graph->SetTitleBackground('lightblue:1.3', Graph\Configs::getConfig('TITLEBKG_STYLE2'), Graph\Configs::getConfig('TITLEBKG_FRAME_BEVEL'));
$graph->SetTitleBackgroundFillStyle(
    Graph\Configs::getConfig('TITLEBKG_FILLSTYLE_HSTRIPED'),
    'lightblue',
    'navy'
);

// Create a bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->value->Show();
$bplot->value->SetFont(
    Graph\Configs::getConfig('FF_VERDANA'),
    Graph\Configs::getConfig('FS_BOLD'),
    8
);
$bplot->SetValuePos('top');
$bplot->SetLegend('Bar Legend');
$graph->Add($bplot);

$pline = new Plot\PlotLine(
    Graph\Configs::getConfig('HORIZONTAL'),
    8,
    'red',
    2
);
$pline->SetLegend('Line Legend');
$graph->legend->SetColumns(10);
$graph->Add($pline);

$graph->Stroke();
