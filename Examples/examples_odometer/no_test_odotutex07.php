<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_odo.php';

// Create a new odometer graph (width=250, height=200 pixels)
$__width  = 570;
$__height = 250;
$graph    = new OdoGraph($__width, $__height);

$odo     = [];
$astyles = [
    Graph\Configs::getConfig('NEEDLE_ARROW_SS'), Graph\Configs::getConfig('NEEDLE_ARROW_SM'), Graph\Configs::getConfig('NEEDLE_ARROW_SL'),
    Graph\Configs::getConfig('NEEDLE_ARROW_MS'), Graph\Configs::getConfig('NEEDLE_ARROW_MM'), Graph\Configs::getConfig('NEEDLE_ARROW_ML'),
    Graph\Configs::getConfig('NEEDLE_ARROW_LS'), Graph\Configs::getConfig('NEEDLE_ARROW_LM'), Graph\Configs::getConfig('NEEDLE_ARROW_LL'),
];
$acaptions = [
    'SS', 'SM', 'SL', 'MS', 'MM', 'ML', 'LS', 'LM', 'LL',
];

for ($i = 0; $i < 9; ++$i) {
    $odo[$i] = new Odometer();
    $odo[$i]->SetColor('lightyellow');
    $odo[$i]->needle->Set(75);
    $odo[$i]->needle->SetStyle(Graph\Configs::getConfig('NEEDLE_STYLE_ENDARROW'), $astyles[$i]);
    $odo[$i]->caption->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
    $odo[$i]->caption->Set('Arrow: ' . $acaptions[$i]);
}

$row1 = new LayoutHor([$odo[0], $odo[1], $odo[2]]);
$row2 = new LayoutHor([$odo[3], $odo[4], $odo[5]]);
$row3 = new LayoutHor([$odo[6], $odo[7], $odo[8]]);
$col1 = new LayoutVert([$row1, $row2, $row3]);

// Add the odometer to the graph
$graph->Add($col1);

// ... and finally stroke and stream the image back to the browser
$graph->Stroke();
