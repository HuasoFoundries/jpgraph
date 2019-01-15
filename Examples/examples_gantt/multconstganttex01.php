<?php

/**
 * JPGraph v4.0.0
 */

// Gantt example
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Create the basic graph
$graph = new Graph\GanttGraph();
$graph->title->Set('Example with multiple constrains');

$bar1 = new Plot\GanttBar(0, 'Label 1', '2003-06-08', '2003-06-12');
$bar2 = new Plot\GanttBar(1, 'Label 2', '2003-06-16', '2003-06-19');
$bar3 = new Plot\GanttBar(2, 'Label 3', '2003-06-15', '2003-06-21');

//create constraints
$bar1->SetConstrain(1, CONSTRAIN_ENDSTART);
$bar1->SetConstrain(2, CONSTRAIN_ENDSTART);

// Setup scale
$graph->ShowHeaders( /*GANTT_HYEAR | GANTT_HMONTH |*/GANTT_HDAY | GANTT_HWEEK);
$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAYWNBR);

// Add the specified activities
$graph->Add($bar1);
$graph->Add($bar2);
$graph->Add($bar3);

// .. and stroke the graph
$graph->Stroke();
