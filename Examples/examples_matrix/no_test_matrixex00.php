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
$graph->title->Set('Matrix example 00');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

//$graph->SetColor('darkgreen@0.8');

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
}

$hor1 = new LayoutHor([$mp[0], $mp[1]]);
$hor2 = new LayoutHor([$mp[2], $mp[3], $mp[4]]);
$vert = new LayoutVert([$hor1, $hor2]);
$vert->SetCenterPos(0.45, 0.5);

//$mp = new MatrixPlot($data);
//$mp->colormap->SetMap(2);
//$mp->SetCenterPos(0.5, 0.45);
//$mp->SetLegendLayout(0);
//$mp->SetSize(0.6);
//$mp->legend->Show(false);
//$mp->SetModuleSize(5,5);

//$mp->legend->SetModuleSize(20,4);
//$mp->legend->SetSize(20,0.5);

//$t = new Text('A text string',10,10);
//$graph->Add($t);

//$graph->Add($mp);

$graph->Add($vert);
$graph->Stroke();
