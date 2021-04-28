<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Text;

$__width = 0;
$__height = 0;
$graph = new Graph\GanttGraph($__width, $__height);
$graph->SetBox();
$graph->SetShadow();

// Add title and subtitle
$example_title = 'Example with added texts';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);

// Show day, week and month scale
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HWEEK') | Graph\Configs::getConfig('GANTT_HMONTH'));

// Set table title
$graph->scale->tableTitle->Set('(Rev: 1.22)');
$graph->scale->tableTitle->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->scale->SetTableTitleBackground('silver');

// Modify the appearance of the dividing lines
$graph->scale->divider->SetWeight(3);
$graph->scale->divider->SetColor('navy');
$graph->scale->dividerh->SetWeight(3);
$graph->scale->dividerh->SetColor('navy');

// Use the short name of the month together with a 2 digit year
// on the month scale
$graph->scale->month->SetStyle(Graph\Configs::getConfig('MONTHSTYLE_SHORTNAMEYEAR2'));
$graph->scale->month->SetFontColor('white');
$graph->scale->month->SetBackgroundColor('blue');

// 0 % vertical label margin
$graph->SetLabelVMarginFactor(1);

// Format the bar for the first activity
// ($row,$title,$startdate,$enddate)
$activity = new Plot\GanttBar(0, 'Project', '2001-12-21', '2002-01-07', '[50%]');

// Yellow diagonal line pattern on a red background
$activity->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
$activity->SetFillColor('red');

// Set absolute height
$activity->SetHeight(10);

// Specify progress to 60%
$activity->progress->Set(0.6);
$activity->progress->SetPattern(Graph\Configs::getConfig('BAND_HVCROSS'), 'blue');

// Format the bar for the second activity
// ($row,$title,$startdate,$enddate)
$activity2 = new Plot\GanttBar(1, 'Project', '2001-12-21', '2001-12-27', '[30%]');

// Yellow diagonal line pattern on a red background
$activity2->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
$activity2->SetFillColor('red');

// Set absolute height
$activity2->SetHeight(10);

// Specify progress to 30%
$activity2->progress->Set(0.3);
$activity2->progress->SetPattern(Graph\Configs::getConfig('BAND_HVCROSS'), 'blue');

// Finally add the bar to the graph
$graph->Add($activity);
$graph->Add($activity2);

// Add text to top left corner of graph
$txt1 = new Text\Text();
$txt1->SetPos(5, 2);
$txt1->Set("Note:\nEstimate done w148");
$txt1->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$txt1->SetColor('darkred');
$graph->Add($txt1);

// Add text to the top bar
$txt2 = new Text\Text();
$txt2->SetScalePos('2002-01-01', 1);
$txt2->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$txt2->SetAlign('left', 'center');
$txt2->Set('Remember this!');
$txt2->SetBox('yellow');
$graph->Add($txt2);

// Add a vertical line
$vline = new Plot\GanttVLine('2001-12-24', 'Phase 1');
$vline->SetDayOffset(0.5);
//$graph->Add($vline);

// ... and display it
$graph->Stroke();
