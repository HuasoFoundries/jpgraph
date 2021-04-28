<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [19, 12, 4, 3, 3, 12, 3, 3, 5, 6, 7, 8, 8, 1, 7, 2, 2, 4, 6, 8, 21, 23, 2, 2, 12];

// Create the Pie Graph.
$__width = 300;
$__height = 350;
$graph = new Graph\PieGraph($__width, $__height);

// Set A title for the plot
$example_title = 'Label guide lines';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 12);
$graph->title->SetColor('darkblue');
$graph->legend->Pos(0.1, 0.2);

// Create pie plot
$p1 = new Plot\PiePlot($data);
$p1->SetCenter(0.5, 0.55);
$p1->SetSize(0.3);

// Enable and set policy for guide-lines. Make labels line up vertically
// and force guide lines to always beeing used
$p1->SetGuideLines(true, false, true);
$p1->SetGuideLinesAdjust(1.5);

// Setup the labels
$p1->SetLabelType(Graph\Configs::getConfig('PIE_VALUE_PER'));
$p1->value->Show();
$p1->value->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$p1->value->SetFormat('%2.1f%%');

// Add and stroke
$graph->Add($p1);
$graph->Stroke();
