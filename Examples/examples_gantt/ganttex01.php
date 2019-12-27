<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$graph = new Graph\GanttGraph();
$graph->SetShadow();

// Add title and subtitle$example_title='A main title'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$graph->subtitle->Set('(Draft version)');

// Show day, week and month scale
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HWEEK') | Graph\Configs::getConfig('GANTT_HMONTH'));

// Instead of week number show the date for the first day in the week
// on the week scale
$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAY'));

// Make the week scale font smaller than the default
$graph->scale->week->SetFont(Graph\Configs::getConfig('FF_FONT0'));

// Use the short name of the month together with a 2 digit year
// on the month scale
$graph->scale->month->SetStyle(Graph\Configs::getConfig('MONTHSTYLE_SHORTNAMEYEAR2'));

// Format the bar for the first activity
// ($row,$title,$startdate,$enddate)
$activity = new Plot\GanttBar(0, 'Activity 1', '2001-12-21', '2002-01-18');

// Yellow diagonal line pattern on a red background
$activity->SetPattern(Graph\Configs::getConfig('BAND_LDIAG'), 'yellow');
$activity->SetFillColor('red');

// Finally add the bar to the graph
$graph->Add($activity);

// ... and display it
$graph->Stroke();
