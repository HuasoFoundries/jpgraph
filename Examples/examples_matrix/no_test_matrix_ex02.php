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

// Do the meshinterpolation once for the data
doMeshInterpolate($data, 3);
$r = \count($data);
$c = \count($data[0]);

$__width = 250;
$__height = 220;
$graph = new MatrixGraph($__width, $__height);
$example_title = 'Meshinterpolation=3';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);

$mp = new MatrixPlot($data, 1);
$mp->colormap->SetMap(0);
$mp->SetSize(200, 160);
$mp->SetCenterPos(0.5, 0.55);
$mp->legend->Show(false);
$graph->Add($mp);
$graph->Stroke();
