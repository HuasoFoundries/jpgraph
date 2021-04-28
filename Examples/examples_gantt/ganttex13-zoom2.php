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
$example_title = 'Zooming a graph';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$subtitle_text = '(zoom=1.5)';
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

// 0 % vertical label margin
$graph->SetLabelVMarginFactor(1.0); // 1=default value

// Set zoom factor
$graph->SetZoomFactor(1.5);

// Format the bar for the first activity
// ($row,$title,$startdate,$enddate)
$activity1 = new Plot\GanttBar(0, 'Activity 1', '2001-12-21', '2002-01-07', '[ER,TR]');

// Yellow diagonal line pattern on a red background
$activity1->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
$activity1->SetFillColor('red');

// Set absolute height of activity
$activity1->SetHeight(16);

// Format the bar for the second activity
// ($row,$title,$startdate,$enddate)
$activity2 = new Plot\GanttBar(1, 'Activity 2', '2001-12-21', '2002-01-01', '[BO,SW,JC]');

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
