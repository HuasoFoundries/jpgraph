<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_odo.php';

// Create a new odometer graph (width=250, height=200 pixels)
$__width  = 570;
$__height = 220;
$graph    = new OdoGraph($__width, $__height);

$nstyle = [
    NEEDLE_STYLE_SIMPLE, NEEDLE_STYLE_STRAIGHT, NEEDLE_STYLE_ENDARROW,
    NEEDLE_STYLE_SMALL_TRIANGLE, NEEDLE_STYLE_MEDIUM_TRIANGLE,
    NEEDLE_STYLE_LARGE_TRIANGLE,
];

$captions = [
    'NEEDLE_STYLE_SIMPLE', 'NEEDLE_STYLE_STRAIGHT', 'NEEDLE_STYLE_ENDARROW',
    'NEEDLE_STYLE_SMALL_TRIANGLE', 'NEEDLE_STYLE_MEDIUM_TRIANGLE',
    'NEEDLE_STYLE_LARGE_TRIANGLE',
];

$odo = [];

for ($i = 0; $i < 6; ++$i) {
    $odo[$i] = new Odometer();
    $odo[$i]->SetColor('lightyellow');
    $odo[$i]->needle->Set(80);
    $odo[$i]->needle->SetStyle($nstyle[$i]);
    $odo[$i]->caption->Set($captions[$i]);
    $odo[$i]->caption->SetFont(FF_FONT1);
    $odo[$i]->caption->SetMargin(3);
}

// Use the automatic layout engine to positon the plots on the graph
$row1 = new LayoutHor([$odo[0], $odo[1], $odo[2]]);
$row2 = new LayoutHor([$odo[3], $odo[4], $odo[5]]);
$col1 = new LayoutVert([$row1, $row2]);

// Add the odometer to the graph
$graph->Add($col1);

// ... and finally stroke and stream the image back to the browser
$graph->Stroke();
