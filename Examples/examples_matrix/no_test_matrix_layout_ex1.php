<?php

/**
 * JPGraph v3.6.21
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

doMeshInterpolate($data, 4);

$__width  = 850;
$__height = 580;
$graph    = new MatrixGraph($__width, $__height);
$graph->title->Set('Matrix layout example');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

$mp = [];
$n  = 5;
for ($i = 0; $i < $n; ++$i) {
    $mp[$i] = new MatrixPlot($data);
    $mp[$i]->colormap->SetMap($i);
    if ($i < 2) {
        $mp[$i]->SetSize(0.35);
    } else {
        $mp[$i]->SetSize(0.21);
    }
    // We need to make the legend a bit smaller since by
    // defalt has a  ~45% height
    $mp[$i]->legend->SetModuleSize(15, 2);
}

$hor1 = new LayoutHor([$mp[0], $mp[1]]);
$hor2 = new LayoutHor([$mp[2], $mp[3], $mp[4]]);
$vert = new LayoutVert([$hor1, $hor2]);
$vert->SetCenterPos(0.45, 0.5);

$graph->Add($vert);
$graph->Stroke();
