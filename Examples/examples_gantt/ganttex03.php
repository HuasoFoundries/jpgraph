<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$__width  = 0;
$__height = 0;
$graph    = new Graph\GanttGraph($__width, $__height);
$graph->SetShadow();

// Add title and subtitle$example_title='A nice main title'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$subtitle_text = '(Draft version)';
$graph->subtitle->Set($subtitle_text);

// Show day, week and month scale
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HWEEK') | Graph\Configs::getConfig('GANTT_HMONTH'));

// Instead of week number show the date for the first day in the week
// on the week scale
$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAY'));

// Make the week scale font smaller than the default
$graph->scale->week->SetFont(Graph\Configs::getConfig('FF_FONT0'));

// Use the short name of the month together with a 2 digit year
// on the month scale
$graph->scale->month->SetStyle(Graph\Configs::getConfig('MONTHSTYLE_SHORTNAMEYEAR4'));
$graph->scale->month->SetFontColor('white');
$graph->scale->month->SetBackgroundColor('blue');

// Format the bar for the first activity
// ($row,$title,$startdate,$enddate)
$activity = new Plot\GanttBar(7, 'Project', '2001-12-21', '2002-02-20');

// Yellow diagonal line pattern on a red background
$activity->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
$activity->SetFillColor('red');

// Finally add the bar to the graph
$graph->Add($activity);

// ... and display it
$graph->Stroke();
