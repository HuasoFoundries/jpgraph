<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
require_once 'jpgraph/jpgraph_gantt.php';

$bar1 = new GanttBar(0, 'Activity 1', '2001-12-21', '2002-01-20');
$bar1->SetCSIMTarget('#', 'Go back 1');
$bar1->title->SetCSIMTarget('#', 'Go back 1 (title)');
$bar2 = new GanttBar(1, 'Activity 2', '2002-01-03', '2002-01-25');
$bar2->SetCSIMTarget('#', 'Go back 2');
$bar2->title->SetCSIMTarget('#', 'Go back 2 (title)');

$graph         = new GanttGraph(500);
$example_title = 'Example with image map';
$graph->title->set($example_title);
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HYEAR') | Graph\Configs::getConfig('GANTT_HMONTH') | Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HWEEK'));
$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAY'));
$graph->scale->week->SetFont(Graph\Configs::getConfig('FF_FONT1'));

$graph->Add([$bar1, $bar2]);

// And stroke
$graph->StrokeCSIM();
