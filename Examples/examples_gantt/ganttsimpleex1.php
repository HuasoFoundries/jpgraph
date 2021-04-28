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
    [1, Graph\Configs::getConfig('ACTYPE_NORMAL'), '  Label 2', '2001-10-26', '2001-11-13', '[KJ]'],
    [2, Graph\Configs::getConfig('ACTYPE_NORMAL'), '  Label 3', '2001-11-20', '2001-11-22', '[EP]'],
    [3, Graph\Configs::getConfig('ACTYPE_MILESTONE'), '  Phase 1 Done', '2001-11-23', 'M2'], ];

// Create the basic graph
$graph = new Graph\GanttGraph();
$graph->title->Set('Gantt Graph using CreateSimple()');

// Setup scale
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HYEAR') | Graph\Configs::getConfig('GANTT_HMONTH') | Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HWEEK'));
$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAY'));

// Add the specified activities
$graph->CreateSimple($data);

// .. and stroke the graph
$graph->Stroke();
