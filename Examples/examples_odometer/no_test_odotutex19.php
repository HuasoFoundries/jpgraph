<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_odo.php';

require_once 'jpgraph/jpgraph_iconplot.php';

// Create a new odometer graph
$__width = 500;
$__height = 180;
$graph = new OdoGraph($__width, $__height);

$odo = [];

// Now we need to create an odometer to add to the graph.
for ($i = 0; 5 > $i; ++$i) {
    $odo[$i] = new Odometer();
    $odo[$i]->SetColor('lightgray:1.9');
    $odo[$i]->needle->Set(10 + $i * 17);
    $odo[$i]->needle->SetShadow();

    if (2 > $i) {
        $fsize = 10;
    } else {
        $fsize = 8;
    }
    $odo[$i]->scale->label->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), $fsize);
    $odo[$i]->AddIndication(92, 100, 'red');
    $odo[$i]->AddIndication(80, 92, 'orange');
    $odo[$i]->AddIndication(60, 80, 'yellow');
}

// Create the layout
$row1 = new LayoutHor([$odo[0], $odo[1]]);
$row2 = new LayoutHor([$odo[2], $odo[3], $odo[4]]);
$col1 = new LayoutVert([$row1, $row2]);

// Add the odometer to the graph
$graph->Add($col1);

// Add an icon and text
$icon = new IconPlot('jpglogo.jpg', 250, 10, 0.85, 30);
$icon->SetAnchor('center', 'top');
$graph->Add($icon);

$t = new Text('JpGraph', 250, 70);
$t->SetAlign('center', 'top');
//$t->SetFont(Graph\Configs::getConfig('FF_VERA'),FS_BOLD,11);
$t->SetColor('darkgray');
$graph->Add($t);

// ... and finally stroke and stream the image back to the browser
$graph->Stroke();
