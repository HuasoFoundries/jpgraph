<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

//
// The data for the graphs
//
$data = [
    [0, Graph\Configs::getConfig('ACTYPE_GROUP'), 'Phase 1', '2001-10-26', '2001-11-23', ''],
    [1, Graph\Configs::getConfig('ACTYPE_NORMAL'), '  Label 2', '2001-11-01', '2001-11-20', ''],
    [2, Graph\Configs::getConfig('ACTYPE_NORMAL'), '  Label 3', '2001-10-26', '2001-11-03', ''],
    [3, Graph\Configs::getConfig('ACTYPE_MILESTONE'), '  Phase 1 Done', '2001-11-23', 'M2'], ];

// The constrains between the activities
$constrains = [[2, 1, Graph\Configs::getConfig('CONSTRAIN_ENDSTART')],
    [1, 3, Graph\Configs::getConfig('CONSTRAIN_STARTSTART')], ];

$progress = [[1, 0.4]];

// Create the basic graph
$graph = new Graph\GanttGraph();
$example_title = 'Example with grouping and constrains';
$graph->title->set($example_title);
//$graph->SetFrame(false);

// Setup scale
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HYEAR') | Graph\Configs::getConfig('GANTT_HMONTH') | Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HWEEK'));
$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAYWNBR'));

// Add the specified activities
$graph->CreateSimple($data, $constrains, $progress);

// .. and stroke the graph
$graph->Stroke();
