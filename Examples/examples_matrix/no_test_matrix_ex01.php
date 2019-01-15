<?php

/**
 * JPGraph v4.0.0
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

$__width  = 550;
$__height = 500;
$graph    = new MatrixGraph($__width, $__height);
$graph->title->Set('Possible legend positions');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

$mp  = [];
$n   = 4;
$pos = [0.3, 0.33, 0.8, 0.68,
    0.3, 0.68, 0.8, 0.33, ];
for ($i = 0; $i < $n; ++$i) {
    $mp[$i] = new MatrixPlot($data);
    $mp[$i]->colormap->SetMap($i);
    $mp[$i]->SetModuleSize(4, 5);
    $mp[$i]->SetLegendLayout($i);
    $mp[$i]->SetCenterPos($pos[$i * 2], $pos[$i * 2 + 1]);
}

$graph->Add($mp);
$graph->Stroke();
