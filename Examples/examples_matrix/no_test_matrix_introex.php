<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

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
// Interpolate the data a factor of 4 to get some mroe
// data points
doMeshInterpolate($data, 4);

// Setup a timer
$timer = new Util\JpgTimer();
$timer->Push();

//--------------------------------------------------------------
// Setup a basic matrix graph
//--------------------------------------------------------------
$width = 740;
$height = 500;
$graph = new MatrixGraph($width, $height);
$graph->SetMargin(1, 2, 70, 1);
$graph->SetColor('white');
$graph->SetMarginColor('#fafafa');
$example_title = 'Intro matrix graph';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);

// Setup the background image
$graph->SetBackgroundImage(__DIR__ . '/../assets/fireplace.jpg', Graph\Configs::getConfig('BGIMG_FILLPLOT'));
$graph->SetBackgroundImageMix(50);

// Setup the timer in the right footer
$graph->footer->SetTimer($timer);
$graph->footer->right->SetColor('white');

//--------------------------------------------------------------
// Create the 2 matrix plots
//--------------------------------------------------------------
$mp = [];
$n = 2;

for ($i = 0; $i < $n; ++$i) {
    $mp[$i] = new MatrixPlot($data);
    $mp[$i]->colormap->SetMap($i);
    $mp[$i]->SetSize(300, 250);
    $mp[$i]->SetLegendLayout(1);
    $mp[$i]->SetAlpha(0.2);

    // Make the legend slightly longer than default
    $mp[$i]->legend->SetSize(20, 280);
}
$mp[1]->colormap->SetMap(3);

$hor1 = new LayoutHor([$mp[0], $mp[1]]);
$hor1->SetCenterPos(0.5, 0.5);

$graph->Add($hor1);

//--------------------------------------------------------------
// Add texts to the graph
//--------------------------------------------------------------
$txts = [
    ['Temperature gradient', $width / 2, 80],
    ['Heat color map', 200, 110],
    ['High contrast map', 560, 110], ];

$n = \count($txts);
$t = [];

for ($i = 0; $i < $n; ++$i) {
    $t[$i] = new Text($txts[$i][0], $txts[$i][1], $txts[$i][2]);
    $t[$i]->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);
    $t[$i]->SetColor('white');
    $t[$i]->SetAlign('center', 'top');
}
$graph->Add($t);

//--------------------------------------------------------------
// Add Jpgraph logo to top left corner
//--------------------------------------------------------------
$icon = new IconPlot('jpglogo.jpg', 2, 2, 0.9, 50);
$graph->Add($icon);

$graph->Stroke();
