<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_canvas.php';

// Create the graph.
$__width  = 350;
$__height = 200;
$graph    = new CanvasGraph($__width, $__height);

$t1 = new Text('This is a text with more text');
$t1->SetPos(0.05, 0.5);
$t1->SetOrientation('h');
$t1->SetFont(FF_FONT1, FS_NORMAL);
$t1->SetBox('white', 'black', 'gray');
$t1->SetColor('black');
$graph->AddText($t1);

$graph->Stroke();
