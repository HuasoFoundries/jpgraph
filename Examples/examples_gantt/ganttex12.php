<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$graph = new Graph\GanttGraph();
$graph->SetBox();
$graph->SetShadow();

// Add title and subtitle
$example_title = 'A nice main title';
$graph->title->set($example_title);
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

// 0 % vertical label margin
$graph->SetLabelVMarginFactor(0);

// Format the bar for the first activity
// ($row,$title,$startdate,$enddate)
$activity = new Plot\GanttBar(0, 'Project', '2001-12-21', '2002-02-20');

// Yellow diagonal line pattern on a red background
$activity->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
$activity->SetFillColor('red');

// Add a right marker
$activity->rightMark->Show();
$activity->rightMark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$activity->rightMark->SetWidth(13);
$activity->rightMark->SetColor('red');
$activity->rightMark->SetFillColor('red');
$activity->rightMark->title->Set('M5');
$activity->rightMark->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$activity->rightMark->title->SetColor('white');

// Set absolute height
$activity->SetHeight(10);

// Format the bar for the second activity
// ($row,$title,$startdate,$enddate)
$activity2 = new Plot\GanttBar(1, 'Project', '2001-12-21', '2002-02-20');

// Yellow diagonal line pattern on a red background
$activity2->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
$activity2->SetFillColor('red');

// Add a right marker
$activity2->rightMark->Show();
$activity2->rightMark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$activity2->rightMark->SetWidth(13);
$activity2->rightMark->SetColor('red');
$activity2->rightMark->SetFillColor('red');
$activity2->rightMark->title->Set('M5');
$activity2->rightMark->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$activity2->rightMark->title->SetColor('white');

// Set absolute height
$activity2->SetHeight(10);

// Finally add the bar to the graph
$graph->Add($activity);
$graph->Add($activity2);

// Create a miletone
$milestone = new Plot\MileStone(2, 'Milestone', '2002-01-15', '2002-01-15');
$milestone->title->SetColor('black');
$milestone->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->Add($milestone);

// Add a vertical line
$vline = new Plot\GanttVLine('2001-12-24', 'Phase 1');
$vline->SetDayOffset(0.5);
//$graph->Add($vline);

// ... and display it
$graph->Stroke();
