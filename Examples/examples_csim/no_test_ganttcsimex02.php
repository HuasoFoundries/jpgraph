<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
require_once 'jpgraph/jpgraph_gantt.php';

$data = [
    [0, ACTYPE_GROUP, 'Phase 1', '2001-10-26', '2001-11-23', '',
        '#1', 'Go home', ],
    [1, ACTYPE_NORMAL, '  Label 2', '2001-10-26', '2001-11-16', 'ab,cd',
        '#2', 'Go home', ],
    [2, ACTYPE_NORMAL, '  Label 3', '2001-11-20', '2001-11-22', 'ek',
        '#3', 'Go home', ],
    [3, ACTYPE_MILESTONE, '  Phase 1 Done', '2001-11-23', 'M2',
        '#4', 'Go home', ], ];

// The constrains between the activities
$constrains = [[1, 2, CONSTRAIN_ENDSTART],
    [2, 3, CONSTRAIN_STARTSTART], ];

$progress = [[1, 0.4]];

$graph = new GanttGraph(500);
$graph->title->Set('Example with image map');
$graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH | GANTT_HDAY | GANTT_HWEEK);
$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY);
$graph->scale->week->SetFont(FF_FONT1);

$graph->CreateSimple($data, $constrains, $progress);

// Add the specified activities
//SetupSimpleGantt($graph,$data,$constrains,$progress);

// And stroke
$graph->StrokeCSIM();
