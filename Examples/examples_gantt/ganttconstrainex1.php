<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

//
// The data for the graphs
//
$data = [
    [0, ACTYPE_GROUP, 'Phase 1', '2001-10-26', '2001-11-23', ''],
    [1, ACTYPE_NORMAL, '  Label 2', '2001-10-26', '2001-11-16', ''],
    [2, ACTYPE_NORMAL, '  Label 3', '2001-11-20', '2001-11-22', ''],
    [3, ACTYPE_NORMAL, '  Label 4', '2001-11-20', '2001-11-22', ''],
    [4, ACTYPE_MILESTONE, '  Phase 1 Done', '2001-11-23', 'M2'], ];

// The constrains between the activities
$constrains = [[1, 2, CONSTRAIN_ENDEND],
    [2, 3, CONSTRAIN_STARTEND],
    [3, 4, CONSTRAIN_ENDSTART],
];

$progress = [[1, 0.4]];

// Create the basic graph
$graph = new Graph\GanttGraph();
$graph->title->Set('Example with grouping and constrains');

// Setup scale
$graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH | GANTT_HDAY | GANTT_HWEEK);
$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAYWNBR);

// Add the specified activities
$graph->CreateSimple($data, $constrains, $progress);

// .. and stroke the graph
$graph->Stroke();
