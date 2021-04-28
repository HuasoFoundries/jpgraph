<?php

/**
 * JPGraph - Community Edition
 */

// Gantt example 30
// $Id: ganttex30.php,v 1.4 2003/05/30 20:12:43 aditus Exp $
require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Standard calls to create a new Graph\Graph
$graph = new Graph\GanttGraph();
$graph->SetShadow();
$graph->SetBox();

// Titles for chart$example_title='General conversion plan'; $graph->title->set($example_title);
$subtitle_text = '(Revision: 2001-11-18)';
$graph->subtitle->Set($subtitle_text);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);

// For illustration we enable all headers.
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HYEAR') | Graph\Configs::getConfig('GANTT_HMONTH') | Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HWEEK'));

// For the week we choose to show the start date of the week
// the default is to show week number (according to ISO 8601)
$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAY'));

// Change the scale font
$graph->scale->week->SetFont(Graph\Configs::getConfig('FF_FONT0'));
$graph->scale->year->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);

// Setup some data for the gantt bars
$data = [
    [0, 'Group 1', '2001-10-29', '2001-11-27', Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 8],
    [1, '  Label 2', '2001-11-8', '2001-12-14'],
    [2, '  Label 3', '2001-11-01', '2001-11-8'],
    [4, 'Group 2', '2001-11-07', '2001-12-19', Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 8],
    [5, '  Label 4', '2001-11-8', '2001-12-19'],
    [6, '  Label 5', '2001-11-01', '2001-11-8'],
];

for ($i = 0; \count($data) > $i; ++$i) {
    $bar = new Plot\GanttBar($data[$i][0], $data[$i][1], $data[$i][2], $data[$i][3], '[50%]', 0.5);

    if (\count($data[$i]) > 4) {
        $bar->title->SetFont($data[$i][4], $data[$i][5], $data[$i][6]);
    }

    // If you like each bar can have a shadow
    // $bar->SetShadow(true,"darkgray");

    // For illustration lets make each bar be red with yellow diagonal stripes
    $bar->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
    $bar->SetFillColor('red');

    // To indicate progress each bar can have a smaller bar within
    // For illustrative purpose just set the progress to 50% for each bar
    $bar->progress->Set(0.5);

    // Each bar may also have optional left and right plot marks
    // As illustration lets put a filled circle with a number at the end
    // of each bar
    $bar->rightMark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
    $bar->rightMark->SetFillColor('red');
    $bar->rightMark->SetColor('red');
    $bar->rightMark->SetWidth(10);

    // Title for the mark
    $bar->rightMark->title->Set((string) ($i + 1));
    $bar->rightMark->title->SetColor('white');
    $bar->rightMark->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 10);
    $bar->rightMark->Show();

    // ... and add the bar to the gantt chart
    $graph->Add($bar);
}

// Create a milestone mark
$ms = new Plot\MileStone(7, 'M5', '2001-12-10', '10/12');
$ms->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->Add($ms);

// Create a vertical line to emphasize the milestone
$vl = new Plot\GanttVLine('2001-12-10 13:00', 'Phase 1', 'darkred');
$vl->SetDayOffset(0.5); // Center the line in the day
$graph->Add($vl);

// Output the graph
$graph->Stroke();

// EOF
