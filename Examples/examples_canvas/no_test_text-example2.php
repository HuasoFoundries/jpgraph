<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_canvas.php';

// Create the graph.
$__width  = 350;
$__height = 200;
$graph    = new CanvasGraph($__width, $__height);

$t1 = new Text("a good\nas you can see right now per see\nThis is a text with\nseveral lines\n");
$t1->SetPos(0.05, 100);
$t1->SetFont(FF_FONT1, FS_NORMAL);
$t1->SetBox('white', 'black', true);
$t1->ParagraphAlign('right');
$t1->SetColor('black');
$graph->AddText($t1);

$graph->Stroke();
