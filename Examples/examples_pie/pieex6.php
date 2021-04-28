<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [27, 23, 47, 17];

// A new Graph\Graph
$__width = 350;
$__height = 200;
$graph = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();

// Setup title
$example_title = 'Example of pie plot with absolute labels';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// The pie plot
$p1 = new Plot\PiePlot($data);

// Move center of pie to the left to make better room
// for the legend
$p1->SetCenter(0.35, 0.5);

// No border
$p1->ShowBorder(false);

// Label font and color setup
$p1->value->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$p1->value->SetColor('darkred');

// Use absolute values (type==1)
$p1->SetLabelType(Graph\Configs::getConfig('PIE_VALUE_ABS'));

// Label format
$p1->value->SetFormat('$%d');
$p1->value->Show();

// Size of pie in fraction of the width of the graph
$p1->SetSize(0.3);

// Legends
$p1->SetLegends(['May ($%d)', 'June ($%d)', 'July ($%d)', 'Aug ($%d)']);
$graph->legend->Pos(0.05, 0.15);

$graph->Add($p1);
$graph->Stroke();
