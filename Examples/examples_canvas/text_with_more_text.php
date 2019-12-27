<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Text;

// Create the graph.
$__width       = 350;
$__height      = 200;
$graph         = new Graph\CanvasGraph($__width, $__height);
$example_title = 'This is a text with more text';
$t1            = new Text\Text($example_title);
$t1->SetPos(0.05, 0.5);
$t1->SetOrientation('h');
$t1->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_NORMAL'));
$t1->SetBox('white', 'black', 'gray');
$t1->SetColor('black');
$graph->AddText($t1);

$graph->Stroke();
