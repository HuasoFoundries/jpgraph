<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

require_once 'jpgraph/jpgraph_matrix.php';

$data = [
    [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    [10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0],
    [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    [10, 9, 8, 17, 6, 5, 4, 3, 2, 1, 0],
    [0, 1, 2, 3, 4, 4, 9, 7, 8, 9, 10],
    [8, 1, 2, 3, 4, 8, 3, 7, 8, 9, 10],
    [10, 3, 5, 7, 6, 5, 4, 3, 12, 1, 0],
    [10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0],
];

$width = 400;
$height = 350;
$graph = new MatrixGraph($width, $height);
$example_title = 'Using a circular module type';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);

$mp = new MatrixPlot($data, 2);
$mp->SetSize(0.85);
$mp->SetModuleType(1);
$mp->SetBackgroundColor('teal:1.8');
$mp->SetCenterPos(0.5, 0.45);
$mp->SetLegendLayout(1);

$graph->Add($mp);
$graph->Stroke();
