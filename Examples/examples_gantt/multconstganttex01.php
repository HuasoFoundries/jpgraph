<?php

/**
 * JPGraph v4.0.0
 */

// Gantt example
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Create the basic graph
$graph         = new Graph\GanttGraph();
$example_title = 'Example with multiple constrains';
$graph->title->set($example_title);

$bar1 = new Plot\GanttBar(0, 'Label 1', '2003-06-08', '2003-06-12');
$bar2 = new Plot\GanttBar(1, 'Label 2', '2003-06-16', '2003-06-19');
$bar3 = new Plot\GanttBar(2, 'Label 3', '2003-06-15', '2003-06-21');

//create constraints
$bar1->SetConstrain(1, Graph\Configs::getConfig('CONSTRAIN_ENDSTART'));
$bar1->SetConstrain(2, Graph\Configs::getConfig('CONSTRAIN_ENDSTART'));

// Setup scale
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HYEAR') | Graph\Configs::getConfig('GANTT_HMONTH') | Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HWEEK'));
$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAYWNBR'));

// Add the specified activities
$graph->Add($bar1);
$graph->Add($bar2);
$graph->Add($bar3);

// .. and stroke the graph
$graph->Stroke();
