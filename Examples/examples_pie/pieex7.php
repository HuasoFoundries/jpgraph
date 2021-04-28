<?php

/**
 * JPGraph - Community Edition
 */

//$Id: pieex7.php,v 1.1 2002/06/17 13:53:43 aditus Exp $
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [27, 23, 0, 17];

// A new Graph\Graph
$__width = 350;
$__height = 200;
$graph = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();

// Setup title
$example_title = 'Pie plot with absolute labels';
$graph->title->set($example_title);
$subtitle_text = '(With hidden 0 labels)';
$graph->subtitle->Set($subtitle_text);
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
$p1->value->HideZero();
$p1->value->Show();

// Size of pie in fraction of the width of the graph
$p1->SetSize(0.3);

// Legends
$p1->SetLegends(['May ($%d)', 'June ($%d)', 'July ($%d)', 'Aug ($%d)']);
$graph->legend->Pos(0.05, 0.2);

$graph->Add($p1);
$graph->Stroke();
