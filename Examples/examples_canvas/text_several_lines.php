<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Text;

// Create the graph.
$__width = 350;
$__height = 200;
$graph = new Graph\CanvasGraph($__width, $__height);
$example_title = 'text with several lines';
$t1 = new Text\Text("good!\nas you can see right now per see\nThis is a \n {$example_title} \n");
$t1->SetPos(0.05, 100);
$t1->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_NORMAL'));
$t1->SetBox('white', 'black', true);
$t1->ParagraphAlign('right');
$t1->SetColor('black');
$graph->AddText($t1);

$graph->Stroke();
