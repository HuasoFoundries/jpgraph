<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

require_once 'jpgraph/jpgraph_matrix.php';

require_once 'jpgraph/jpgraph_iconplot.php';

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

$nrow = \count($data);
$ncol = \count($data[0]);

$width = 350;
$height = 300;
$graph = new MatrixGraph($width, $height);
$example_title = 'Add ine row/col labels';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);

$mp = new MatrixPlot($data, 1);
$mp->SetSize(0.55);
$mp->SetCenterPos(0.45, 0.45);

$rowtitles = [];

for ($i = 0; $i < $nrow; ++$i) {
    $rowtitles[$i] = \sprintf('Row: %02d', $i);
}
$coltitles = [];

for ($i = 0; $i < $ncol; ++$i) {
    $coltitles[$i] = \sprintf('Col: %02d', $i);
}

$mp->rowlabel->Set($rowtitles);
$mp->rowlabel->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 10);
$mp->rowlabel->SetFontColor('blue');
$mp->rowlabel->SetSide('left');

$mp->collabel->Set($coltitles);
$mp->collabel->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 10);
$mp->collabel->SetFontColor('darkred');
$mp->collabel->SetAngle(70); // 90 is default for col titles
$mp->collabel->SetSide('bottom');

$graph->Add($mp);
$graph->Stroke();
