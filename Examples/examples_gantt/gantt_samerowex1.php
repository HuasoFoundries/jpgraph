<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$graph = new Graph\GanttGraph();
$graph->SetShadow();

// Add title and subtitle
$example_title = 'Activities on same row';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);

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

// 0 % vertical label margin
$graph->SetLabelVMarginFactor(1); // 1=default value

// Format the bar for the first activity
// ($row,$title,$startdate,$enddate)
$activity1 = new Plot\GanttBar(0, 'Activity 1', '2001-12-21', '2001-12-26', '');

// Yellow diagonal line pattern on a red background
$activity1->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
$activity1->SetFillColor('red');

// Set absolute height of activity
$activity1->SetHeight(16);

// Format the bar for the second activity
// ($row,$title,$startdate,$enddate)
$activity2 = new Plot\GanttBar(0, '', '2001-12-31', '2002-01-2', '[BO]');

// ADjust font for caption
$activity2->caption->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'));
$activity2->caption->SetColor('darkred');

// Yellow diagonal line pattern on a red background
$activity2->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
$activity2->SetFillColor('red');

// Set absolute height of activity
$activity2->SetHeight(16);

// Finally add the bar to the graph
$graph->Add($activity1);
$graph->Add($activity2);

// ... and display it
$graph->Stroke();
