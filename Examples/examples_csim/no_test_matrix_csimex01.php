<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_matrix.php';

$data = [
    [0, null, 2, 3, 4, 5, 6, 7, 8, 9, 10, 8, 6, 4, 2],
    [10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0, 8, 5, 9, 2],
    [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 2, 4, 5, 7],
    [10, 9, 8, 17, 6, 5, 4, 3, 2, 1, 0, 8, 6, 4, 2],
    [0, 1, 2, 3, 4, 4, 9, 7, 8, 9, 10, 3, 2, 7, 2],
    [8, 1, 2, 3, 4, 8, 3, 7, 8, 9, 10, 5, 3, 9, 1],
    [10, 3, 5, 7, 6, 5, 4, 3, 12, 1, 0, 6, 5, 10, 2],
    [10, 9, 8, 7, 6, 5, 4, 3, 2, 1, null, 8, 6, 4, 2],
];

$nx = \count($data[0]);
$ny = \count($data);

for ($i = 0; $i < $ny; ++$i) {
    for ($j = 0; $j < $nx; ++$j) {
        $csimtargets[$i][$j] = '#' . \sprintf('%02sd', $i) . '-' . \sprintf('%02sd', $j);
    }
}

for ($i = 0; $i < $nx; ++$i) {
    $collabels[$i] = \sprintf('column label: %02d', $i);
    $collabeltargets[$i] = '#' . \sprintf('collabel: %02d', $i);
}

for ($i = 0; $i < $ny; ++$i) {
    $rowlabels[$i] = \sprintf('row label: %02d', $i);
    $rowlabeltargets[$i] = '#' . \sprintf('rowlabel: %02d', $i);
}

// Setup a nasic matrix graph
$__width = 400;
$__height = 350;
$graph = new MatrixGraph($__width, $__height);

$graph->SetBackgroundGradient('lightsteelblue:0.8', 'lightsteelblue:0.3');
$example_title = 'CSIM with matrix';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 16);
$graph->title->SetColor('white');

// Create one matrix plot
$mp = new MatrixPlot($data, 1);
$mp->SetModuleSize(13, 15);
$mp->SetCenterPos(0.35, 0.6);
$mp->colormap->SetNullColor('gray');

// Setup column lablels
$mp->collabel->Set($collabels);
$mp->collabel->SetSide('top');
$mp->collabel->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 8);
$mp->collabel->SetFontColor('lightgray');

// Setup row lablels
$mp->rowlabel->Set($rowlabels);
$mp->rowlabel->SetSide('right');
$mp->rowlabel->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 8);
$mp->rowlabel->SetFontColor('lightgray');

$mp->rowlabel->SetCSIMTargets($rowlabeltargets);
$mp->collabel->SetCSIMTargets($collabeltargets);

// Move the legend more to the right
$mp->legend->SetMargin(90);
$mp->legend->SetColor('white');
$mp->legend->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 10);

$mp->SetCSIMTargets($csimtargets);

$graph->Add($mp);
$graph->StrokeCSIM();
