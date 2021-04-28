<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

require_once 'jpgraph/jpgraph_gantt.php';

$data = [
    [0, Graph\Configs::getConfig('ACTYPE_GROUP'), 'Phase 1', '2001-10-26', '2001-11-23', '',
        '#1', 'Go home', ],
    [1, Graph\Configs::getConfig('ACTYPE_NORMAL'), '  Label 2', '2001-10-26', '2001-11-16', 'ab,cd',
        '#2', 'Go home', ],
    [2, Graph\Configs::getConfig('ACTYPE_NORMAL'), '  Label 3', '2001-11-20', '2001-11-22', 'ek',
        '#3', 'Go home', ],
    [3, Graph\Configs::getConfig('ACTYPE_MILESTONE'), '  Phase 1 Done', '2001-11-23', 'M2',
        '#4', 'Go home', ], ];

// The constrains between the activities
$constrains = [[1, 2, Graph\Configs::getConfig('CONSTRAIN_ENDSTART')],
    [2, 3, Graph\Configs::getConfig('CONSTRAIN_STARTSTART')], ];

$progress = [[1, 0.4]];

$graph = new GanttGraph(500);
$example_title = 'Example with image map';
$graph->title->set($example_title);
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HYEAR') | Graph\Configs::getConfig('GANTT_HMONTH') | Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HWEEK'));
$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAY'));
$graph->scale->week->SetFont(Graph\Configs::getConfig('FF_FONT1'));

$graph->CreateSimple($data, $constrains, $progress);

// Add the specified activities
//SetupSimpleGantt($graph,$data,$constrains,$progress);

// And stroke
$graph->StrokeCSIM();
