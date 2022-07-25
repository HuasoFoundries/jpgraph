<?php

/**
 * JPGraph - Community Edition
 */

// Gantt example with sunday week start and only shows a partial graph
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Setup Gantt graph
$__width = 0;
$__height = 0;
$graph = new Graph\GanttGraph($__width, $__height, 'auto');
$graph->SetShadow();
$graph->SetBox();

// Only show part of the Gantt
$graph->SetDateRange('2001-11-22', '2002-1-24');

// Weeks start on Sunday
$graph->scale->SetWeekStart(0);
$example_title = 'General conversion plan';
$graph->title->set($example_title);
$subtitle_text = '(Slice between 2001-11-22 to 2002-01-24)';
$graph->subtitle->Set($subtitle_text);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 20);

$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HYEAR') | Graph\Configs::getConfig('GANTT_HMONTH') | Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HWEEK'));
$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAY'));
$graph->scale->week->SetFont(Graph\Configs::getConfig('FF_FONT1'));

$data = [
    [0, "Group 1\tJohan", '2002-1-23', '2002-01-28', Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 8],
    [1, '  Label 2', '2001-10-26', '2001-11-16'],
    [2, '  Label 3', '2001-11-30', '2001-12-01'],
    [4, 'Group 2', '2001-11-30', '2001-12-22', Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 8],
    [5, '  Label 4', '2001-11-30', '2001-12-1'],
    [6, '  Label 5', '2001-12-6', '2001-12-8'],
    [8, '    Label 8', '2001-11-30', '2002-01-02'],
];

// make up some fictionary activity bars
for ($i = 0; \count($data) > $i; ++$i) {
    $bar = new Plot\GanttBar($data[$i][0], $data[$i][1], $data[$i][2], $data[$i][3], '[5%]', 10);

    if (\count($data[$i]) > 4) {
        $bar->title->SetFont($data[$i][4], $data[$i][5], $data[$i][6]);
    }

    $bar->rightMark->Show();
    $bar->rightMark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
    $bar->rightMark->SetWidth(8);
    $bar->rightMark->SetColor('red');
    $bar->rightMark->SetFillColor('red');
    $bar->rightMark->title->Set($i + 1);
    $bar->rightMark->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
    $bar->rightMark->title->SetColor('white');

    $bar->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
    $bar->SetFillColor('red');
    $bar->progress->Set($i / 10);
    $bar->progress->SetPattern(Graph\Configs::getConfig('GANTT_SOLID'), 'darkgreen');

    $graph->Add($bar);
}

// The line will NOT be shown since it is outside the specified slice
$vline = new Plot\GanttVLine('2002-02-28');
$example_title = '2002-02-28';
$vline->title->set($example_title);
$vline->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 10);
$graph->Add($vline);

// The milestone will NOT be shown since it is outside the specified slice
$ms = new Plot\MileStone(7, 'M5', '2002-01-28', '28/1');
$ms->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->Add($ms);

$graph->Stroke();
